<?php

namespace App\Http\Controllers;

use App\Models\Consultas;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Citas;
use App\Models\Persona;
use App\Models\ConsultaReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Concepto;

class ConsultaController extends Controller
{
    public function createWithoutCita($pacienteId)
    {
        $paciente = Paciente::findOrFail($pacienteId);
        $medicoId = Auth::id(); // Obtener el ID del usuario autenticado
        $medico = Auth::user(); // Obtener el usuario autenticado

        // Realizar la búsqueda de conceptos
        $conceptoConsulta = Concepto::where('medico_id', $medicoId)
            ->where(function($query) {
                $query->whereRaw('LOWER(concepto) LIKE ?', ['%consulta%'])
                    ->orWhereRaw('LOWER(concepto) LIKE ?', ['%consultas%']);
            })
            ->first();

        // Verificar si no se encontró ningún concepto de consulta
        $showAlert = !$conceptoConsulta; // Si no hay concepto, mostrar alerta
        $precioConsulta = $conceptoConsulta ? $conceptoConsulta->precio_unitario : 0;

        return view('medico.consultas.agregarConsultaSinCita', compact('paciente', 'medico', 'precioConsulta', 'showAlert'));
    }

    public function storeWithoutCita(Request $request)
    {
        $request->validate([
            'pacienteid' => 'required|exists:pacientes,id',
            'hidden_talla' => 'nullable|string',
            'hidden_temperatura' => 'nullable|string',
            'hidden_saturacion_oxigeno' => 'nullable|string',
            'hidden_frecuencia_cardiaca' => 'nullable|string',
            'hidden_peso' => 'nullable|string',
            'hidden_tension_arterial' => 'nullable|string',
            'motivoConsulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'interrogatorio_por_aparatos' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'required|string',
            'plan' => 'nullable|string',
            'status' => 'required|string|in:en curso,Finalizada',
            'totalPagar' => 'required|numeric|min:1', // Aseguramos que el totalPagar no sea 0
            'usuariomedicoid' => 'required|exists:users,id',
            'circunferencia_cabeza' => 'nullable|string',
            'recetas' => 'array',
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string'
        ]);

        // Obtener el concepto de la consulta
        $conceptoConsulta = Concepto::where('medico_id', Auth::id())
            ->where(function($query) {
                $query->whereRaw('LOWER(concepto) LIKE ?', ['%consulta%'])
                    ->orWhereRaw('LOWER(concepto) LIKE ?', ['%consultas%']);
            })
            ->first();

        // Si no hay un concepto de consulta definido, devolver un error
        if (!$conceptoConsulta) {
            return back()->withErrors(['message' => 'No hay un concepto de consulta definido. Por favor, configure uno antes de continuar.']);
        }

        // Verificar si el precio personalizado es válido, si no, usar el precio predeterminado
        $precioConsulta = $request->input('totalPagar', $conceptoConsulta->precio_unitario);
        $impuesto = $conceptoConsulta->impuesto;
        $totalPagar = $precioConsulta + ($precioConsulta * ($impuesto / 100));

        // Verificar si el precio es 0 antes de proceder
        if ($totalPagar == 0) {
            return back()->withErrors(['totalPagar' => 'El precio de la consulta no puede ser 0.']);
        }

        // Creación de la consulta
        $consultaData = $request->except('recetas'); 
        $consultaData['talla'] = $request->hidden_talla;
        $consultaData['temperatura'] = $request->hidden_temperatura;
        $consultaData['saturacion_oxigeno'] = $request->hidden_saturacion_oxigeno;
        $consultaData['frecuencia_cardiaca'] = $request->hidden_frecuencia_cardiaca;
        $consultaData['peso'] = $request->hidden_peso;
        $consultaData['tension_arterial'] = $request->hidden_tension_arterial;
        $consultaData['circunferencia_cabeza'] = $request->circunferencia_cabeza;
        $consultaData['status'] = 'Finalizada'; 
        $consulta = Consultas::create($consultaData);

        // Obtener el correo y la CURP del paciente
        $paciente = Paciente::find($request->pacienteid);
        $email = $paciente->email;
        $curp = $paciente->curp;

        // Buscar persona que coincida con el paciente usando email y curp
        $persona = Persona::where('correo', $email)
                        ->orWhere('curp', $curp) // Ajustar si 'curp' existe en la tabla Pacientes
                        ->first();

        // Actualizar el estado de la cita si la persona coincide
        if ($persona) {
            $cita = Citas::where('persona_id', $persona->id)
                        ->where('status', '!=', 'Finalizada') // Asegurarse de que no esté ya finalizada
                        ->first();

            if ($cita) {
                $cita->status = 'Finalizada';
                $cita->save();
            }
        }

        // Guardar recetas
        if ($request->has('recetas')) {
            foreach ($request->recetas as $recetaData) {
                ConsultaReceta::create([
                    'consulta_id' => $consulta->id,
                    'tipo_de_receta' => $recetaData['tipo_de_receta'],
                    'receta' => $recetaData['receta']
                ]);
            }
        }

        $venta = Venta::create([
            'consulta_id' => $consulta->id,
            'precio_consulta' => $precioConsulta,
            'iva' => $impuesto,
            'total' => $totalPagar,
            'paciente_id' => $paciente->id,
            'status' => 'Por pagar',  // Cambiar el estado aquí
        ]);

        // Redirigir a la vista de detalles de la consulta
        return redirect()->route('vistaInicio')->with('success', 'Consulta guardada exitosamente.');
    }


    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;
        $today = Carbon::today();

        // Obtener las fechas de inicio y fin del filtro
        $startDate = $request->input('start_date', $today->format('Y-m-d'));
        $endDate = $request->input('end_date', $today->format('Y-m-d'));

        // Consultas con cita que no están finalizadas
        $consultasConCita = Citas::where('medicoid', $medicoId)
            ->where('activo', 'si')
            ->where('status', '!=', 'Finalizada') // Excluir las citas finalizadas
            ->whereBetween('fecha', [$startDate, $endDate])
            ->with('persona') // Incluir relación con la persona
            ->get()
            ->map(function($cita) {
                $cita->isCita = true; // Marcar como consulta con cita
                return $cita;
            });

        // Consultas sin cita
        $consultasSinCita = Consultas::where('usuariomedicoid', $medicoId)
            ->whereNull('citai_id') // Filtrar las consultas sin cita asociada
            ->where('status', 'Finalizada') // Solo mostrar las consultas que ya están finalizadas
            ->whereBetween('fechaHora', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']) // Asegurarse de que la fecha y hora estén dentro del rango
            ->get()
            ->map(function($consulta) {
                $consulta->isCita = false; // Marcar como consulta sin cita
                return $consulta;
            });

        // Concatenar ambas colecciones
        $consultas = $consultasConCita->concat($consultasSinCita);

        // Ordenar por fecha y hora (opcional)
        $consultas = $consultas->sortBy(function($consulta) {
            return $consulta->isCita ? $consulta->fecha . ' ' . $consulta->hora : $consulta->fechaHora;
        });

        // Paginación manual
        $perPage = 10;
        $page = $request->input('page', 1);
        $paginatedConsultas = $consultas->slice(($page - 1) * $perPage, $perPage)->values();

        return view('medico.consultas.consultas', [
            'consultas' => new \Illuminate\Pagination\LengthAwarePaginator($paginatedConsultas, $consultas->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query()
            ])
        ]);
    }

    public function verificarPaciente(Request $request, $citaId)
    {
        $cita = Citas::with('persona')->findOrFail($citaId);
        $correo = $cita->persona->correo;
        $curp = $cita->persona->curp;

        $paciente = Paciente::where('correo', $correo)->orWhere('curp', $curp)->first();

        if ($paciente) {
            // Si el paciente existe, redirige a la vista de agregarConsultaSinCita
            return redirect()->route('consultas.createWithoutCita', $paciente->id);
        } else {
            // Mostrar SweetAlert y redirigir
            session()->flash('alerta', true);

            return view('medico.pacientes.editarPaciente', [
                'paciente' => new Paciente([
                    'nombres' => $cita->persona->nombres,
                    'apepat' => $cita->persona->apepat,
                    'apemat' => $cita->persona->apemat,
                    'fechanac' => $cita->persona->fechanac->format('Y-m-d'),
                    'correo' => $correo,
                    'curp' => $curp,
                    'sexo' => $cita->persona->sexo,
                    'telefono' => $cita->persona->telefono,
                    'no_exp' => Paciente::max('no_exp') ? Paciente::max('no_exp') + 1 : 1,
                ])
            ]);

        }
    }

    public function edit($id)
    {
        $consulta = Consultas::findOrFail($id);

        if ($consulta->cita) {
            return view('medico.consultas.editarConsulta', compact('consulta'));
        } else {
            return view('medico.consultas.editarConsultaSinCita', compact('consulta'));
        }
    }

    public function show($id)
    {
        $consulta = Consultas::with(['recetas', 'usuarioMedico', 'cita.paciente'])
            ->findOrFail($id);

        if ($consulta->cita) {
            $paciente = $consulta->cita->paciente;
        } else {
            $paciente = Paciente::findOrFail($consulta->pacienteid);
        }

        // Formatear la fecha de la consulta
        $fechaConsulta = \Carbon\Carbon::parse($consulta->fechaHora)->format('d-m-Y');

        return view('medico.consultas.verConsulta', compact('consulta', 'paciente', 'fechaConsulta'));
    }


    public function print($id)
    {
        $consulta = Consultas::with(['recetas', 'usuarioMedico', 'cita.paciente'])
            ->findOrFail($id);

        if ($consulta->cita) {
            $paciente = $consulta->cita->paciente;
        } else {
            $paciente = Paciente::findOrFail($consulta->pacienteid);
        }

        return view('medico.consultas.print', compact('consulta', 'paciente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'talla' => 'nullable|string',
            'temperatura' => 'nullable|string',
            'saturacion_oxigeno' => 'nullable|string',
            'frecuencia_cardiaca' => 'nullable|string',
            'peso' => 'nullable|string',
            'tension_arterial' => 'nullable|string',
            'motivoConsulta' => 'required|string',
            'notas_padecimiento' => 'nullable|string',
            'interrogatorio_por_aparatos' => 'nullable|string',
            'examen_fisico' => 'nullable|string',
            'diagnostico' => 'required|string',
            'plan' => 'nullable|string',
            'status' => 'required|string|in:en curso,Finalizada',
            'totalPagar' => 'required|numeric|min:0',
            'recetas' => 'array',
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string'
        ]);

        $consulta = Consultas::findOrFail($id);
        $consulta->update($request->all());

        $consulta->recetas()->delete();
        if ($request->has('recetas')) {
            foreach ($request->recetas as $recetaData) {
                ConsultaReceta::create([
                    'consulta_id' => $consulta->id,
                    'tipo_de_receta' => $recetaData['tipo_de_receta'],
                    'receta' => $recetaData['receta']
                ]);
            }
        }

        return redirect()->route('consultas.index')->with('status', 'Consulta actualizada correctamente');
    }

    public function terminate($id)
    {
        $consulta = Consultas::findOrFail($id);
        $consulta->status = 'Finalizada';
        $consulta->save();

        return response()->json(['success' => true]);
    }


    public function navigate(Request $request)
    {
        $direction = $request->input('direction');
        $currentConsultationId = $request->input('currentConsultationId');
        $medicoId = Auth::id(); // ID del médico logueado

        // Obtener el paciente actual desde la consulta actual
        $currentConsultation = Consultas::findOrFail($currentConsultationId);
        $pacienteId = $currentConsultation->pacienteid;

        if ($direction == 'first') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)
                ->where('pacienteid', $pacienteId) // Asegurarse de que sea el mismo paciente
                ->orderBy('id', 'asc')
                ->first();
        } elseif ($direction == 'prev') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)
                ->where('pacienteid', $pacienteId) // Asegurarse de que sea el mismo paciente
                ->where('id', '<', $currentConsultationId)
                ->orderBy('id', 'desc')
                ->first();
        } elseif ($direction == 'next') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)
                ->where('pacienteid', $pacienteId) // Asegurarse de que sea el mismo paciente
                ->where('id', '>', $currentConsultationId)
                ->orderBy('id', 'asc')
                ->first();
        } elseif ($direction == 'last') {
            $consulta = Consultas::where('usuariomedicoid', $medicoId)
                ->where('pacienteid', $pacienteId) // Asegurarse de que sea el mismo paciente
                ->orderBy('id', 'desc')
                ->first();
        }

        if ($consulta) {
            $consulta->load('recetas'); // Cargar recetas relacionadas
            $paciente = $consulta->cita ? $consulta->cita->paciente : Paciente::findOrFail($consulta->pacienteid);

            return response()->json([
                'success' => true,
                'redirectUrl' => route('consultas.show', $consulta->id)
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    
    public function iniciarConsulta($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->status = 'En proceso';
        $cita->save();

        return response()->json(['success' => true]);
    }

    public function generateVenta($consultaId)
    {
        $consulta = Consultas::findOrFail($consultaId);
        $pacienteId = $consulta->pacienteid;

        // Obtener el concepto de la consulta
        $conceptoConsulta = Concepto::where('medico_id', Auth::id())
            ->where(function($query) {
                $query->whereRaw('LOWER(concepto) LIKE ?', ['%consulta%'])
                    ->orWhereRaw('LOWER(concepto) LIKE ?', ['%consultas%']);
            })
            ->first();

        // Si no hay un concepto de consulta definido, devolver un error
        if (!$conceptoConsulta) {
            return back()->withErrors(['message' => 'No hay un concepto de consulta definido. Por favor, configure uno antes de continuar.']);
        }

        // Obtener el precio de la consulta y el impuesto desde el concepto
        $precioConsulta = $conceptoConsulta->precio_unitario;
        $impuesto = $conceptoConsulta->impuesto; // Porcentaje de impuesto

        // Calcular el total basado en el impuesto
        $total = $precioConsulta + ($precioConsulta * ($impuesto / 100));

        // Crear la venta con los datos calculados
        $venta = Venta::create([
            'consulta_id' => $consulta->id,
            'precio_consulta' => $precioConsulta,
            'iva' => $impuesto, // Guardar el porcentaje de impuesto
            'total' => $total,
            'paciente_id' => $pacienteId,
            'status' => 'Por pagar',
        ]);

        // Redirigir a la vista de la venta generada
        return view('medico.ventas.show', compact('venta'));
    }


    public function consultasPendientesHoy()
    {
        $medicoId = Auth::user()->id; // ID del médico autenticado
        $hoy = Carbon::today(); // Obtener la fecha de hoy

        // Contar las consultas pendientes del día de hoy
        $consultasPendientes = Citas::where('medicoid', $medicoId)
            ->whereDate('fecha', $hoy)
            ->where('status', '!=', 'Finalizada')
            ->count();

        return $consultasPendientes;
    }


}

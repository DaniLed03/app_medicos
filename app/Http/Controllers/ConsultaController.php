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
use Illuminate\Support\Facades\Log;
use App\Models\Consulta;
use App\Models\Venta;
use App\Models\Concepto;
use App\Models\TipoDeReceta;

class ConsultaController extends Controller
{
    public function createWithoutCita($pacienteId)
    {
        $paciente = Paciente::where('no_exp', $pacienteId)->firstOrFail();
        $medicoId = Auth::id(); 
        $medico = Auth::user(); 

        $tiposDeReceta = TipoDeReceta::all();

        $recetas = ConsultaReceta::join('tipo_de_receta', 'consulta_recetas.id_tiporeceta', '=', 'tipo_de_receta.id')
                                ->where('no_exp', $paciente->no_exp)
                                ->select('consulta_recetas.*', 'tipo_de_receta.nombre as tipo_receta_nombre')
                                ->get();

        $conceptoConsulta = Concepto::where('medico_id', $medicoId)
            ->where(function($query) {
                $query->whereRaw('LOWER(concepto) LIKE ?', ['%consulta%'])
                    ->orWhereRaw('LOWER(concepto) LIKE ?', ['%consultas%']);
            })
            ->first();

        $showAlert = !$conceptoConsulta;
        $precioConsulta = $conceptoConsulta ? $conceptoConsulta->precio_unitario : 0;

        return view('medico.consultas.agregarConsultaSinCita', compact('paciente', 'medico', 'precioConsulta', 'showAlert', 'tiposDeReceta', 'recetas'));
    }

    public function storeWithoutCita(Request $request)
    {
        $request->validate([
            'pacienteid' => 'required|exists:pacientes,no_exp',
            'hidden_talla' => 'nullable|string',
            'hidden_temperatura' => 'nullable|string',
            'hidden_saturacion_oxigeno' => 'nullable|string',
            'hidden_frecuencia_cardiaca' => 'nullable|string',
            'hidden_peso' => 'nullable|string',
            'hidden_tension_arterial' => 'nullable|string',
            'motivoConsulta' => 'required|string',
            'diagnostico' => 'required|string',
            'status' => 'required|string|in:en curso,Finalizada',
            'totalPagar' => 'nullable|numeric|min:1',
            'usuariomedicoid' => 'required|exists:users,id',
            'circunferencia_cabeza' => 'nullable|string',
            'años' => 'nullable|integer',  // Nuevo campo
            'meses' => 'nullable|integer', // Nuevo campo
            'dias' => 'nullable|integer',  // Nuevo campo
            'recetas' => 'array',
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string'
        ]);

        $medicoId = $request->input('usuariomedicoid');
        $pacienteId = $request->input('pacienteid');

        // Obtener el concepto de la consulta
        $conceptoConsulta = Concepto::where('medico_id', $medicoId)
            ->where(function($query) {
                $query->whereRaw('LOWER(concepto) LIKE ?', ['%consulta%'])
                    ->orWhereRaw('LOWER(concepto) LIKE ?', ['%consultas%']);
            })
            ->first();

        if (!$conceptoConsulta) {
            return back()->withErrors(['message' => 'No hay un concepto de consulta definido. Por favor, configure uno antes de continuar.']);
        }

        // Verificar si el precio personalizado es válido, si no, usar el precio predeterminado
        $precioConsulta = $request->input('totalPagar', $conceptoConsulta->precio_unitario);
        $impuesto = $conceptoConsulta->impuesto;
        $totalPagar = round($precioConsulta + ($precioConsulta * ($impuesto / 100)), 2);

        if ($totalPagar == 0) {
            return back()->withErrors(['totalPagar' => 'El precio de la consulta no puede ser 0.']);
        }

        // Generar el 'id' de la consulta manualmente basado en las consultas previas del médico y paciente
        $ultimoId = Consultas::where('usuariomedicoid', $medicoId)
                             ->where('pacienteid', $pacienteId)
                             ->max('id');

        $nuevoId = $ultimoId ? $ultimoId + 1 : 1;

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
        $consultaData['id'] = $nuevoId; 
        $consultaData['años'] = $request->años;
        $consultaData['meses'] = $request->meses;
        $consultaData['dias'] = $request->dias;
        $consulta = Consultas::create($consultaData);

        // Obtener el correo y la CURP del paciente
        $paciente = Paciente::find($pacienteId);
        $email = $paciente->email;
        $curp = $paciente->curp;

        $paciente = Paciente::where('no_exp', $pacienteId)
                            ->where('medico_id', $medicoId)
                            ->first();

        // Actualizar el estado de la cita
        $cita = Citas::where('no_exp', $pacienteId)
                     ->where('medicoid', $medicoId)
                     ->where('status', '!=', 'Finalizada')
                     ->first();

        if ($cita) {
            $cita->status = 'Finalizada';
            $cita->save();
        }

        if ($request->has('recetas')) {
            foreach ($request->recetas as $recetaData) {
                // Obtener el siguiente valor de 'id' basado en la cantidad de recetas previas
                $recetaId = ConsultaReceta::where('id_medico', $request->input('usuariomedicoid'))
                    ->where('no_exp', $request->input('pacienteid'))
                    ->where('consulta_id', $consulta->id)
                    ->max('id');

                // Si no hay resultados, empieza con 1, si hay, incrementa en 1.
                $recetaId = $recetaId ? $recetaId + 1 : 1;

        
                ConsultaReceta::create([
                    'consulta_id' => $consulta->id,
                    'id_medico' => $request->input('usuariomedicoid'),
                    'no_exp' => $request->input('pacienteid'),
                    'id_tiporeceta' => $recetaData['tipo_de_receta'],
                    'receta' => $recetaData['receta'],
                    'id' => $recetaId, // Asignar el nuevo ID único
                ]);
            }
        }
        

        Venta::create([
            'consulta_id' => $consulta->id,
            'precio_consulta' => $precioConsulta,
            'iva' => $impuesto,
            'total' => $totalPagar,
            'no_exp' => $paciente->no_exp,
            'medico_id' => $paciente->medico_id,
            'status' => 'Por pagar',
        ]);
        
    
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
            ->with('paciente') // Incluir relación con el paciente
            ->get()
            ->map(function($cita) {
                $cita->isCita = true; // Marcar como consulta con cita
                return $cita;
            });


        // Consultas sin cita
        $consultasSinCita = Consultas::where('usuariomedicoid', $medicoId)
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

        // Cantidad de ventas "Por pagar"
        $ventasPorPagar = Venta::where('status', 'Por pagar')->count();

        return view('medico.consultas.consultas', [
            'consultas' => new \Illuminate\Pagination\LengthAwarePaginator($paginatedConsultas, $consultas->count(), $perPage, $page, [
                'path' => $request->url(),
                'query' => $request->query()
            ]),
            'ventasPorPagar' => $ventasPorPagar, // Enviamos el conteo de ventas por pagar
        ]);
    }


    public function verificarPaciente(Request $request, $citaId)
    {
        $cita = Citas::with('paciente')->findOrFail($citaId);
        $paciente = Paciente::where('no_exp', $cita->no_exp)
                            ->where('medico_id', $cita->medicoid)
                            ->first();

        if ($paciente) {
            // Si el paciente existe, redirige a la vista de agregarConsultaSinCita
            return redirect()->route('consultas.createWithoutCita', $paciente->no_exp);
        } else {
            // Mostrar SweetAlert y redirigir
            session()->flash('alerta', true);

            return view('medico.pacientes.editarPaciente', [
                'paciente' => new Paciente([
                    'nombres' => $cita->paciente->nombres,
                    'apepat' => $cita->paciente->apepat,
                    'apemat' => $cita->paciente->apemat,
                    'fechanac' => $cita->paciente->fechanac->format('Y-m-d'),
                    'correo' => $cita->paciente->correo,
                    'curp' => $cita->paciente->curp,
                    'sexo' => $cita->paciente->sexo,
                    'telefono' => $cita->paciente->telefono,
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

    public function show($id, $no_exp, $medico_id)
    {
        // Encuentra la consulta y las recetas asociadas, filtrando por consulta, paciente y médico
        $consulta = Consultas::with(['recetas' => function ($query) use ($id, $no_exp) {
            $query->where('consulta_recetas.consulta_id', $id) // Filtrar por la consulta específica
                ->where('consulta_recetas.no_exp', $no_exp); // Filtrar por paciente
        }])
        ->where('id', $id)  // Filtrar por el ID de la consulta
        ->where('pacienteid', $no_exp)  // Filtrar por el paciente
        ->where('usuariomedicoid', $medico_id)  // Filtrar por el médico
        ->firstOrFail();

        // Obtener la información del paciente
        $paciente = Paciente::where('no_exp', $no_exp)->firstOrFail();

        // Calcular la edad del paciente
        $fechaNacimiento = \Carbon\Carbon::parse($paciente->fechanac);
        $edad = $fechaNacimiento->diff(\Carbon\Carbon::now());

        // Formatear la fecha de la consulta
        $fechaConsulta = \Carbon\Carbon::parse($consulta->fechaHora)->format('d-m-Y');

        // Retornar la vista con los datos de la consulta y paciente
        return view('medico.consultas.verConsulta', compact('consulta', 'paciente', 'fechaConsulta', 'edad'));
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
            'diagnostico' => 'required|string',
            'años' => 'nullable|integer',  // Nuevo campo
            'meses' => 'nullable|integer', // Nuevo campo
            'dias' => 'nullable|integer',  // Nuevo campo
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
    $pacienteId = $request->input('pacienteId'); // ID del paciente actual

    // Obtener la consulta actual
    $currentConsultation = Consultas::where('id', $currentConsultationId)
                                    ->where('pacienteid', $pacienteId)
                                    ->where('usuariomedicoid', $medicoId)
                                    ->firstOrFail();

    if ($direction == 'first') {
        $consulta = Consultas::where('usuariomedicoid', $medicoId)
            ->where('pacienteid', $pacienteId)
            ->orderBy('id', 'asc')
            ->first();
    } elseif ($direction == 'prev') {
        $consulta = Consultas::where('usuariomedicoid', $medicoId)
            ->where('pacienteid', $pacienteId)
            ->where('id', '<', $currentConsultationId)
            ->orderBy('id', 'desc')
            ->first();
    } elseif ($direction == 'next') {
        $consulta = Consultas::where('usuariomedicoid', $medicoId)
            ->where('pacienteid', $pacienteId)
            ->where('id', '>', $currentConsultationId)
            ->orderBy('id', 'asc')
            ->first();
    } elseif ($direction == 'last') {
        $consulta = Consultas::where('usuariomedicoid', $medicoId)
            ->where('pacienteid', $pacienteId)
            ->orderBy('id', 'desc')
            ->first();
    }

    // Verificar si no se encontró más consultas
    if (!$consulta) {
        return response()->json([
            'success' => false,
            'message' => 'No hay más consultas en esta dirección.'
        ]);
    }

    // Si se encontró una consulta, devolverla
    $consulta->load('recetas');
    return response()->json([
        'success' => true,
        'consulta' => $consulta,
        'redirectUrl' => route('consultas.show', ['id' => $consulta->id, 'no_exp' => $consulta->pacienteid, 'medico_id' => $medicoId])
    ]);
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

        if (!$conceptoConsulta) {
            return ['success' => false, 'message' => 'No hay un concepto de consulta definido.'];
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
            'iva' => $impuesto,
            'total' => $total,
            'no_exp' => $pacienteId, // Asegúrate de que esto sea correcto
            'medico_id' => $consulta->usuariomedicoid, // Usar el ID del médico de la consulta
            'status' => 'Por pagar',
        ]);

        // Verifica que la venta se haya creado correctamente
        if (!$venta) {
            return ['success' => false, 'message' => 'No se pudo crear la venta.'];
        }

        return ['success' => true, 'venta' => $venta];
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

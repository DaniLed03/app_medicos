<?php

namespace App\Http\Controllers;

use App\Models\Consultas;
use App\Models\Paciente;
use App\Models\Citas;
use App\Models\ConsultaReceta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Concepto;
use App\Models\TipoDeReceta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class ConsultaController extends Controller
{
    public function createWithoutCita($pacienteId)
    {
        $medicoId = Auth::id(); 

        // Obtener datos del paciente y filtrar también por médico, incluyendo los antecedentes
        $paciente = DB::select("
            SELECT no_exp, nombres, apepat, apemat, fechanac, antecedentes 
            FROM pacientes 
            WHERE no_exp = ? 
            AND medico_id = ? 
            LIMIT 1
        ", [$pacienteId, $medicoId]);

        if (empty($paciente)) {
            abort(404, 'Paciente no encontrado para este médico');
        }

        $paciente = $paciente[0];

        $medico = Auth::user();

        // Obtener tipos de receta
        $tiposDeReceta = DB::select("SELECT * FROM tipo_de_receta");

        // Obtener recetas del paciente con JOIN
        $recetas = DB::select("
            SELECT cr.*, tdr.nombre as tipo_receta_nombre 
            FROM consulta_recetas cr
            JOIN tipo_de_receta tdr ON cr.id_tiporeceta = tdr.id
            WHERE cr.no_exp = ? 
            AND cr.id_medico = ?
        ", [$paciente->no_exp, $medicoId]);

        // Obtener consultas pasadas del paciente
        $consultasPasadas = DB::select("
            SELECT c.*, 
                (SELECT COUNT(*) 
                    FROM consulta_recetas cr 
                    WHERE cr.consulta_id = c.id 
                    AND cr.no_exp = ? 
                    AND cr.id_medico = c.usuariomedicoid
                ) as total_recetas
            FROM consultas c
            WHERE c.pacienteid = ? 
            AND c.usuariomedicoid = ? 
            AND c.status = 'Finalizada'
            ORDER BY c.fechaHora DESC
        ", [$paciente->no_exp, $paciente->no_exp, $medicoId]);

        // Verificar si existe el concepto de consulta
        $conceptoConsulta = DB::select("
            SELECT * 
            FROM conceptos 
            WHERE medico_id = ? 
            AND (LOWER(concepto) LIKE '%consulta%' OR LOWER(concepto) LIKE '%consultas%')
            LIMIT 1
        ", [$medicoId]);

        $conceptoConsulta = !empty($conceptoConsulta) ? $conceptoConsulta[0] : null;

        $showAlert = !$conceptoConsulta;
        $precioConsulta = $conceptoConsulta ? $conceptoConsulta->precio_unitario : 0;

        return view('medico.consultas.agregarConsultaSinCita', compact(
            'paciente', 
            'medico', 
            'precioConsulta', 
            'showAlert', 
            'tiposDeReceta', 
            'recetas', 
            'consultasPasadas'
        ));
    }



    public function getConsultaDetails($id, $pacienteId, $medicoId, Request $request)
    {
        // Obtener la consulta específica usando los tres parámetros
        $consulta = Consultas::where('id', $id)
                            ->where('pacienteid', $pacienteId)
                            ->where('usuariomedicoid', $medicoId)
                            ->firstOrFail();

        // Obtener las recetas de la consulta para el paciente usando la relación recetasPorPaciente
        $recetas = $consulta->recetasPorPaciente($pacienteId)
                            ->join('tipo_de_receta', 'consulta_recetas.id_tiporeceta', '=', 'tipo_de_receta.id') // Une la tabla de tipos de recetas
                            ->select('consulta_recetas.*', 'tipo_de_receta.nombre as tipo_receta_nombre') // Selecciona el nombre del tipo de receta
                            ->get();

        // Formatear los datos que quieres devolver
        $responseData = [
            'fechaHora' => $consulta->fechaHora,
            'motivoConsulta' => $consulta->motivoConsulta,
            'diagnostico' => $consulta->diagnostico,
            'talla' => $consulta->talla,
            'peso' => $consulta->peso,
            'frecuencia_cardiaca' => $consulta->frecuencia_cardiaca,
            'temperatura' => $consulta->temperatura,
            'saturacion_oxigeno' => $consulta->saturacion_oxigeno,
            'tension_arterial' => $consulta->tension_arterial,
            'circunferencia_cabeza' => $consulta->circunferencia_cabeza,
            'recetas' => $recetas,  // Aquí añadimos las recetas obtenidas
        ];

        // Verificar si la solicitud es una petición AJAX (normalmente usada para JSON)
        if ($request->ajax()) {
            return response()->json($responseData);
        }

        // Si no es una solicitud AJAX, retornar la vista como en la función show
        $paciente = Paciente::where('no_exp', $pacienteId)->firstOrFail();
        $fechaNacimiento = \Carbon\Carbon::parse($paciente->fechanac);
        $edad = $fechaNacimiento->diff(\Carbon\Carbon::now());
        $fechaConsulta = \Carbon\Carbon::parse($consulta->fechaHora)->format('d-m-Y');

        // Retornar la vista con los datos de la consulta y paciente
        return view('medico.consultas.verConsulta', compact('consulta', 'paciente', 'fechaConsulta', 'edad'));
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
            'años' => 'nullable|integer',
            'meses' => 'nullable|integer',
            'dias' => 'nullable|integer',
            'recetas' => 'array',
            'recetas.*.tipo_de_receta' => 'required|string',
            'recetas.*.receta' => 'required|string',
            'antecedentes' => 'nullable|string'
        ]);

        $medicoId = $request->input('usuariomedicoid');
        $pacienteId = $request->input('pacienteid');

        // Obtener el concepto de la consulta
        $conceptos = DB::select(
            'SELECT * FROM conceptos WHERE medico_id = ? AND (LOWER(concepto) LIKE ? OR LOWER(concepto) LIKE ?) LIMIT 1',
            [$medicoId, '%consulta%', '%consultas%']
        );

        $conceptoConsulta = count($conceptos) > 0 ? $conceptos[0] : null;

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
        $result = DB::select(
            'SELECT MAX(id) as max_id FROM consultas WHERE usuariomedicoid = ? AND pacienteid = ?',
            [$medicoId, $pacienteId]
        );

        $ultimoId = $result[0]->max_id ?? null;
        $nuevoId = $ultimoId ? $ultimoId + 1 : 1;

        // Preparar los datos de la consulta
        $consultaData = [
            'id' => $nuevoId,
            'pacienteid' => $pacienteId,
            'usuariomedicoid' => $medicoId,
            'status' => 'Finalizada',
            'motivoConsulta' => $request->input('motivoConsulta'),
            'diagnostico' => $request->input('diagnostico'),
            'talla' => $request->input('hidden_talla'),
            'temperatura' => $request->input('hidden_temperatura'),
            'saturacion_oxigeno' => $request->input('hidden_saturacion_oxigeno'),
            'frecuencia_cardiaca' => $request->input('hidden_frecuencia_cardiaca'),
            'peso' => $request->input('hidden_peso'),
            'tension_arterial' => $request->input('hidden_tension_arterial'),
            'circunferencia_cabeza' => $request->input('circunferencia_cabeza'),
            'años' => $request->input('años'),
            'meses' => $request->input('meses'),
            'dias' => $request->input('dias'),
            'created_at' => now(), // Agregar el campo created_at
            'updated_at' => now(), // Agregar el campo updated_at
        ];

        // Insertar la consulta en la base de datos
        DB::table('consultas')->insert($consultaData);

        // Obtener el paciente filtrado por medico_id y no_exp
        $pacientes = DB::select(
            'SELECT * FROM pacientes WHERE no_exp = ? AND medico_id = ?',
            [$pacienteId, $medicoId]
        );

        $paciente = count($pacientes) > 0 ? $pacientes[0] : null;

        if (!$paciente) {
            return back()->withErrors(['message' => 'Paciente no encontrado.']);
        }

        $email = $paciente->correo;
        $curp = $paciente->curp;

        // Actualizar los antecedentes en la tabla pacientes
        DB::table('pacientes')
            ->where('no_exp', $pacienteId)
            ->where('medico_id', $medicoId)
            ->update(['antecedentes' => $request->input('antecedentes')]);

        // Actualizar el estado de la cita
        $citas = DB::select(
            'SELECT * FROM citas WHERE no_exp = ? AND medicoid = ? AND status != ?',
            [$pacienteId, $medicoId, 'Finalizada']
        );

        if (count($citas) > 0) {
            $cita = $citas[0];
            DB::table('citas')
                ->where('id', $cita->id)
                ->update(['status' => 'Finalizada']);
        }

        // Manejar las recetas
        if ($request->has('recetas')) {
            foreach ($request->recetas as $recetaData) {
                // Obtener el siguiente valor de 'id' basado en las recetas previas
                $result = DB::select(
                    'SELECT MAX(id) as max_id FROM consulta_recetas WHERE id_medico = ? AND no_exp = ? AND consulta_id = ?',
                    [$medicoId, $pacienteId, $nuevoId]
                );

                $recetaId = $result[0]->max_id ?? null;
                $recetaId = $recetaId ? $recetaId + 1 : 1;

                // Insertar la receta en la base de datos
                DB::table('consulta_recetas')->insert([
                    'consulta_id' => $nuevoId,
                    'id_medico' => $medicoId,
                    'no_exp' => $pacienteId,
                    'id_tiporeceta' => $recetaData['tipo_de_receta'],
                    'receta' => $recetaData['receta'],
                    'id' => $recetaId,
                    'created_at' => now(), // Agregar el campo created_at si existe en la tabla
                    'updated_at' => now(), // Agregar el campo updated_at si existe en la tabla
                ]);
            }
        }

        // Verificar si la opción de 'mostrar_caja' está activada para el usuario autenticado
        $userSetting = Auth::user()->userSetting;
        if ($userSetting && $userSetting->mostrar_caja) {
            DB::table('ventas')->insert([
                'consulta_id' => $nuevoId,
                'precio_consulta' => $precioConsulta,
                'iva' => $impuesto,
                'total' => $totalPagar,
                'no_exp' => $paciente->no_exp,
                'medico_id' => $paciente->medico_id,
                'status' => 'Por pagar',
                'created_at' => now(), 
                'updated_at' => now(), 
            ]);
        }

        return redirect()->route('vistaInicio')->with('success', 'Consulta guardada exitosamente.');
    }

    
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        // Obtener la fecha de hoy
        $today = Carbon::today();

        // Obtener las fechas de inicio y fin del request, por defecto la fecha de hoy
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : $today;
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : $today;

        // Asegurarse de que las fechas estén en el formato correcto
        $startDateFormatted = $startDate->format('Y-m-d');
        $endDateFormatted = $endDate->format('Y-m-d');

        // Consultas con cita
        $consultasConCita = collect(DB::select(
            'SELECT citas.*, citas.created_at AS created_at, pacientes.nombres, pacientes.apepat, pacientes.apemat
            FROM citas
            JOIN pacientes ON pacientes.no_exp = citas.no_exp AND pacientes.medico_id = citas.medicoid
            WHERE citas.medicoid = ?
            AND citas.activo = ?
            AND citas.status != ?
            AND citas.fecha BETWEEN ? AND ?',
            [$medicoId, 'si', 'Finalizada', $startDateFormatted, $endDateFormatted]
        ))->map(function($cita) {
            $cita->isCita = true; // Marcar como consulta con cita
            $cita->paciente = (object)[
                'nombres' => $cita->nombres,
                'apepat' => $cita->apepat,
                'apemat' => $cita->apemat,
            ];
            return $cita;
        });

        // Consultas sin cita
        $consultasSinCita = collect(DB::select(
            'SELECT consultas.*, consultas.created_at AS created_at, pacientes.nombres, pacientes.apepat, pacientes.apemat
            FROM consultas
            JOIN pacientes ON pacientes.no_exp = consultas.pacienteid AND pacientes.medico_id = consultas.usuariomedicoid
            WHERE consultas.usuariomedicoid = ?
            AND DATE(consultas.created_at) BETWEEN ? AND ?',
            [$medicoId, $startDateFormatted, $endDateFormatted]
        ))->map(function($consulta) {
            $consulta->isCita = false; // Marcar como consulta sin cita
            $consulta->paciente = (object)[
                'nombres' => $consulta->nombres,
                'apepat' => $consulta->apepat,
                'apemat' => $consulta->apemat,
            ];
            return $consulta;
        });

        // Combinar ambas consultas
        $consultas = $consultasConCita->concat($consultasSinCita);

        // Cantidad de ventas "Por pagar"
        $ventasPorPagar = DB::table('ventas')->where('status', 'Por pagar')->count();

        return view('medico.consultas.consultas', [
            'consultas' => $consultas,
            'ventasPorPagar' => $ventasPorPagar,
            'startDate' => $startDateFormatted,
            'endDate' => $endDateFormatted,
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
        $medicoId = Auth::id();

        // Obtener el concepto de la consulta
        $conceptoConsulta = Concepto::where('medico_id', $medicoId)
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

        // Verificar si la opción de 'mostrar_caja' está activada para el usuario autenticado
        $userSetting = Auth::user()->userSetting;
        if ($userSetting && $userSetting->mostrar_caja) {
            $venta = Venta::create([
                'consulta_id' => $consulta->id,
                'precio_consulta' => $precioConsulta,
                'iva' => $impuesto,
                'total' => $total,
                'no_exp' => $pacienteId,
                'medico_id' => $consulta->usuariomedicoid,
                'status' => 'Por pagar',
            ]);

            // Verifica que la venta se haya creado correctamente
            if (!$venta) {
                return ['success' => false, 'message' => 'No se pudo crear la venta.'];
            }

            return ['success' => true, 'venta' => $venta];
        } else {
            // Si la opción de 'mostrar_caja' no está activada, no se crea la venta
            return ['success' => false, 'message' => 'La opción de Caja está desactivada. No se generó la venta.'];
        }
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

    public function obtenerConsultasPasadas($pacienteId)
    {
        $medicoId = Auth::id();
        $consultas = Consultas::where('pacienteid', $pacienteId)
                            ->where('usuariomedicoid', $medicoId)
                            ->where('status', 'Finalizada')
                            ->orderBy('fechaHora', 'desc')
                            ->get();

        return response()->json($consultas);
    }

}

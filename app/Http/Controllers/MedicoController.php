<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use App\Models\Citas;
use App\Models\Consultas;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HorariosMedicos;
use Carbon\Carbon;

class MedicoController extends Controller
{
    // Muestra la vista principal del usuario medico
    public function index()
    {
        return view('UsuarioMedico');
    }

    //////////////////////////////////    PACIENTES    /////////////////////////////////////////
    public function completarRegistroPaciente($citaId)
    {
        $datosPersona = session('datosPersona');
        return view('medico.pacientes.completarRegistroPaciente', compact('citaId', 'datosPersona'));
    }

    // Guarda un nuevo paciente
    public function storePacientes(Request $request)
    {
        // Obtener el ID del usuario autenticado
        $currentUserId = Auth::id();

        // Obtener el ID del médico que creó al usuario autenticado (si existe)
        $medicoId = Auth::user()->medico_id ? Auth::user()->medico_id : $currentUserId;

        // Obtener el último número de expediente del médico correspondiente y generar el siguiente
        $lastPaciente = Paciente::where('medico_id', $medicoId)->orderBy('no_exp', 'desc')->first();
        $nextNoExp = $lastPaciente ? $lastPaciente->no_exp + 1 : 1;

        // Validación de los datos del paciente
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'sexo' => 'required|in:masculino,femenino',
        ]);

        // Crear el nuevo paciente con el medico_id correcto
        Paciente::create([
            'no_exp' => $nextNoExp,
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'sexo' => $request->sexo,
            'activo' => 'si',
            'medico_id' => $medicoId, // Usar el ID del médico original
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('medico.dashboard')->with('status', 'Paciente creado con éxito');
    }

    public function showPaciente($id)
    {
        $medicoId = Auth::id();
        $paciente = Paciente::where('id', $id)->where('medico_id', $medicoId)->firstOrFail();
        
        // Obtener las consultas del paciente con el mismo doctor
        $consultas = Consultas::where('pacienteid', $id)->where('usuariomedicoid', $medicoId)->get();

        return view('medico.pacientes.verPaciente', compact('paciente', 'consultas'));
    }

    public function storePacientesDesdeModal(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'correo' => 'required|string|email|max:255|unique:pacientes',
            'curp' => 'required|string|max:18|unique:pacientes',
            'telefono' => 'required|string|max:18',
        ]);

        // Obtener el último número de expediente y sumarle uno
        $ultimoExpediente = Paciente::orderBy('no_exp', 'desc')->first();
        $nuevoExpediente = $ultimoExpediente ? $ultimoExpediente->no_exp + 1 : 1;

        $paciente = new Paciente();
        $paciente->nombres = $request->nombres;
        $paciente->apepat = $request->apepat;
        $paciente->apemat = $request->apemat;
        $paciente->fechanac = $request->fechanac;
        $paciente->correo = $request->correo;
        $paciente->curp = $request->curp;
        $paciente->telefono = $request->telefono;
        $paciente->no_exp = $nuevoExpediente;
        $paciente->medico_id = Auth::id(); // Asigna el ID del médico autenticado
        $paciente->save();

        return redirect()->route('medico.dashboard')->with('success', 'Paciente registrado exitosamente');
    }

    public function mostrarPacientes(Request $request)
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        $pacientes = Paciente::where('activo', 'si')
                    ->where(function($q) use ($medicoId, $currentUser) {
                        $q->where('medico_id', $medicoId)
                        ->orWhere('medico_id', $currentUser->id);
                    });

        if ($request->has('name') && $request->name != '') {
            $pacientes->where('nombres', 'like', '%' . $request->name . '%');
        }

        $pacientes = $pacientes->get();
        $totalPacientes = $pacientes->count();
        $totalMujeres = $pacientes->where('sexo', 'femenino')->count();
        $totalHombres = $pacientes->where('sexo', 'masculino')->count();

        $porcentajeMujeres = $totalPacientes > 0 ? ($totalMujeres / $totalPacientes) * 100 : 0;
        $porcentajeHombres = $totalPacientes > 0 ? ($totalHombres / $totalPacientes) * 100 : 0;

        return view('medico.dashboard', compact('pacientes', 'totalPacientes', 'porcentajeMujeres', 'porcentajeHombres'));
    }



    // Muestra el formulario de edición de un paciente específico
    public function editarPaciente($id)
    {
        $medicoId = Auth::id();
        $paciente = Paciente::where('id', $id)->where('medico_id', $medicoId)->firstOrFail();
        
        // Obtener las consultas del paciente con el mismo doctor
        $consultas = Consultas::where('pacienteid', $id)->where('usuariomedicoid', $medicoId)->get();

        return view('medico.pacientes.editarPaciente', compact('paciente', 'consultas'));
    }
 

    public function updatePaciente(Request $request, $id = null)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'nullable|string|max:255',
            'apepat' => 'nullable|string|max:255',
            'apemat' => 'nullable|string|max:255',
            'fechanac' => 'nullable|date',
            'hora' => 'nullable|date_format:H:i:s',
            'peso' => 'nullable|numeric',
            'talla' => 'nullable|numeric',
            'lugar_naci' => 'nullable|string|max:255',
            'hospital' => 'nullable|string|max:255',
            'tipoparto' => 'nullable|string|max:255',
            'tiposangre' => 'nullable|string|max:255',
            'antecedentes' => 'nullable|string',
            'padre' => 'nullable|string|max:255',
            'madre' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'correo' => 'nullable|string|email|max:255|unique:pacientes,correo,' . $id,
            'telefono' => 'nullable|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'sexo' => 'nullable|in:masculino,femenino',
            'curp' => 'nullable|string|max:18|unique:pacientes,curp,' . $id,
            'Nombre_fact' => 'nullable|string|max:255',
            'Direccion_fact' => 'nullable|string|max:255',
            'RFC' => 'nullable|string|max:255',
            'Regimen_fiscal' => 'nullable|string|max:255',
            'CFDI' => 'nullable|string|max:255',
        ]);

        // Verifica si el paciente existe
        $paciente = Paciente::find($id);

        if ($paciente) {
            // Si el paciente existe, actualiza sus datos
            $paciente->update($request->all());
            $mensaje = 'Paciente actualizado correctamente';
        } else {
            // Si el paciente es nuevo, genera el siguiente número de expediente
            $medicoId = Auth::id();
            $lastPaciente = Paciente::where('medico_id', $medicoId)->orderBy('no_exp', 'desc')->first();
            $nextNoExp = $lastPaciente ? $lastPaciente->no_exp + 1 : 1;

            // Crear el nuevo paciente manualmente
            $paciente = new Paciente();
            $paciente->nombres = $request->nombres;
            $paciente->apepat = $request->apepat;
            $paciente->apemat = $request->apemat ?? '';
            $paciente->fechanac = $request->fechanac ?? null;
            $paciente->curp = $request->curp ?? '';
            $paciente->correo = $request->correo ?? '';
            $paciente->sexo = $request->sexo ?? '';
            $paciente->direccion = $request->direccion ?? '';
            $paciente->telefono = $request->telefono ?? '';
            $paciente->no_exp = $nextNoExp;
            $paciente->medico_id = $medicoId;
            $paciente->activo = 'si';
            // Asignar otros campos si es necesario
            $paciente->save();

            $mensaje = 'Paciente creado correctamente';
        }

        // Verifica si el campo antecedentes está presente en la solicitud
        $tab = $request->has('antecedentes') ? 'antecedentes' : $request->input('tab', 'datos');
        
        // Redirecciona a la vista de edición de paciente con un mensaje de éxito
        return redirect()->route('pacientes.editar', ['id' => $paciente->id, 'tab' => $tab])->with('status', $mensaje);
    }



    // Marca a un paciente como inactivo (eliminado)
    public function eliminarPaciente($id)
    {
        $medicoId = Auth::id();
        $paciente = Paciente::where('id', $id)->where('medico_id', $medicoId)->firstOrFail();
        $paciente->update(['activo' => 'no']);

        return redirect()->route('medico.dashboard')->with('status', 'Paciente eliminado correctamente');
    }

    //////////////////////////////////    CITAS    /////////////////////////////////////////

    // Muestra todas las citas activas
    public function mostrarCitas()
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        $citas = Citas::select('citas.*', 'personas.nombres', 'personas.apepat', 'personas.apemat')
                        ->join('personas', 'citas.persona_id', '=', 'personas.id')
                        ->where('citas.activo', 'si')
                        ->where('citas.status', '!=', 'Finalizada') // Excluir las citas finalizadas
                        ->where(function($q) use ($medicoId, $currentUser) {
                            $q->where('citas.medicoid', $medicoId)
                            ->orWhere('citas.medicoid', $currentUser->id);
                        })
                        ->get();
        
        // Obtener las personas asociadas al médico
        $personas = Persona::where(function($q) use ($medicoId, $currentUser) {
                            $q->where('medico_id', $medicoId)
                            ->orWhere('medico_id', $currentUser->id);
                        })->get();
        
        return view('medico.citas.citas', compact('citas', 'personas'));
    }
    
    // Guarda una nueva cita
    public function storeCitas(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'persona_id' => 'required|exists:personas,id',
            'motivo_consulta' => 'nullable|string|max:255'
        ]);

        // Obtener el ID del médico que creó al usuario autenticado
        $medicoId = Auth::user()->medico_id ? Auth::user()->medico_id : Auth::id();

        // Verificar si ya existe una cita a la misma hora y fecha para el mismo médico
        $exists = Citas::where('fecha', $request->fecha)
                    ->where('hora', $request->hora)
                    ->where('medicoid', $medicoId)
                    ->exists();

        if ($exists) {
            return back()->withErrors(['hora' => 'La hora seleccionada ya está ocupada. Por favor, elija otra hora.'])->withInput();
        }

        // Creación de la cita
        Citas::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'persona_id' => $request->persona_id,
            'medicoid' => $medicoId, // Guardar el ID del médico
            'motivo_consulta' => $request->motivo_consulta
        ]);

        // Redirecciona a la vista de citas con un mensaje de éxito
        return redirect()->route('citas')->with('status', 'Cita registrada correctamente');
    }


    // Muestra el formulario para agregar una nueva cita
    public function crearCita()
    {
        $medicoId = Auth::id();
        $personas = Persona::where('activo', 'si')->where('medico_id', $medicoId)->get();
        return view('medico.citas.agregarCita', compact('personas'));
    }

    // Muestra el formulario de edición de una cita específica
    public function editarCita(Request $request, $id)
    {
        $medicoId = Auth::id();
        $cita = Citas::where('id', $id)->where('medicoid', $medicoId)->firstOrFail();
        
        // Capturar la nueva fecha y hora si existen
        $fecha = $request->input('newDate', $cita->fecha);
        $hora = $request->input('newTime', $cita->hora);

        $diaSemana = Carbon::parse($fecha)->locale('es')->dayName;
        
        // Filtrar las horas disponibles según la nueva fecha
        $horario = HorariosMedicos::where('medico_id', $medicoId)
                                    ->where('dia_semana', $diaSemana)
                                    ->first();

        $horasDisponibles = [];
        if ($horario && $horario->disponible) {
            $horasOcupadas = Citas::where('fecha', $fecha)
                                ->where('medicoid', $medicoId)
                                ->pluck('hora')
                                ->toArray();

            $horaActual = Carbon::parse($horario->hora_inicio);
            while ($horaActual->format('H:i') < $horario->hora_fin) {
                if (!in_array($horaActual->format('H:i'), $horasOcupadas)) {
                    $horasDisponibles[] = $horaActual->format('H:i');
                }
                $horaActual->addMinutes($horario->duracion_sesion);
            }
        }

        return view('medico.citas.editarCita', compact('cita', 'horasDisponibles', 'fecha', 'hora'));
    }

    // Actualiza la información de una cita específica
    public function updateCita(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'persona_id' => 'required|exists:personas,id',
            'usuariomedicoid' => 'required|exists:users,id',
            'motivo_consulta' => 'nullable|string|max:255'
        ]);

        // Verificar si ya existe una cita a la misma hora y fecha para el mismo médico
        $exists = Citas::where('fecha', $request->fecha)
                    ->where('hora', $request->hora)
                    ->where('medicoid', $request->usuariomedicoid)
                    ->where('id', '!=', $id) // Excluir la cita actual
                    ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'La hora seleccionada ya está ocupada. Por favor, elija otra hora.')->withInput();
        }

        $cita = Citas::findOrFail($id);
        $cita->update([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'persona_id' => $request->persona_id,
            'medicoid' => $request->usuariomedicoid,
            'motivo_consulta' => $request->motivo_consulta
        ]);

        return redirect()->route('citas')->with('status', 'Cita actualizada correctamente');
    }


    // Marca una cita como inactiva (eliminada)
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->update(['activo' => 'no']);

        return redirect()->route('citas')->with('status', 'Cita eliminada correctamente');
    }

    // Elimina una cita de la base de datos
    public function borrarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->delete();

        return redirect()->route('citas')->with('status', 'Cita borrada correctamente');
    }

    public function obtenerHorasDisponibles(Request $request)
    {
        $fecha = $request->fecha;
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        // Determinar el día de la semana para la fecha dada
        $diaSemana = Carbon::parse($fecha)->locale('es')->dayName;

        // Buscar primero si hay un horario específico para la fecha
        $horario = HorariosMedicos::where('medico_id', $medicoId)
                                    ->where('fecha', $fecha)
                                    ->first();

        // Si no hay horario específico para la fecha, buscar por el día de la semana
        if (!$horario) {
            $horario = HorariosMedicos::where('medico_id', $medicoId)
                                        ->where('dia_semana', $diaSemana)
                                        ->first();
        }

        if ($horario && $horario->disponible) {
            $horasOcupadas = Citas::where('fecha', $fecha)
                                ->where('medicoid', $medicoId)
                                ->pluck('hora')
                                ->toArray();

            $horasDisponibles = [];
            $horaActual = Carbon::parse($horario->hora_inicio);

            while ($horaActual->format('H:i') < $horario->hora_fin) {
                if (!in_array($horaActual->format('H:i'), $horasOcupadas)) {
                    $horasDisponibles[] = $horaActual->format('H:i');
                }
                $horaActual->addMinutes($horario->duracion_sesion);
            }

            return response()->json($horasDisponibles);
        } else {
            return response()->json([]);
        }
    }


    public function storeHorario(Request $request)
    {
        $request->validate([
            'fecha' => 'nullable|date',
            'dia_semana' => 'nullable|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'duracion_sesion' => 'required|integer|min:1',
            'disponible' => 'required|boolean',
        ]);

        if ($request->dia_semana) {
            // Si se seleccionó un día de la semana, crea un horario recurrente para ese día
            HorariosMedicos::updateOrCreate(
                [
                    'medico_id' => Auth::id(),
                    'dia_semana' => $request->dia_semana
                ],
                [
                    'hora_inicio' => $request->hora_inicio,
                    'hora_fin' => $request->hora_fin,
                    'duracion_sesion' => $request->duracion_sesion,
                    'disponible' => $request->disponible
                ]
            );
        } else if ($request->fecha) {
            // Si se seleccionó una fecha específica, crea un horario para esa fecha
            HorariosMedicos::create([
                'medico_id' => Auth::id(),
                'fecha' => $request->fecha,
                'hora_inicio' => $request->hora_inicio,
                'hora_fin' => $request->hora_fin,
                'duracion_sesion' => $request->duracion_sesion,
                'disponible' => $request->disponible
            ]);
        }

        return redirect()->route('citas.configurarHorario')->with('status', 'Horario guardado exitosamente.');
    }


    public function configurarHorario()
    {
        $medicoId = Auth::id();

        // Obtener horarios configurados para los días de la semana
        $horariosSemana = HorariosMedicos::where('medico_id', $medicoId)
                                        ->whereNotNull('dia_semana')
                                        ->get();

        // Obtener horarios configurados para fechas específicas
        $horariosFechas = HorariosMedicos::where('medico_id', $medicoId)
                                        ->whereNotNull('fecha')
                                        ->get();

        return view('medico.citas.configurarHorario', compact('horariosSemana', 'horariosFechas'));
    }

    public function updateHorario(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'nullable|date',
            'dia_semana' => 'nullable|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'duracion_sesion' => 'required|integer|min:1',
            'disponible' => 'required|boolean',
        ]);

        $horario = HorariosMedicos::findOrFail($id);
        $horario->update([
            'fecha' => $request->fecha,
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'duracion_sesion' => $request->duracion_sesion,
            'disponible' => $request->disponible,
        ]);

        return redirect()->route('citas.configurarHorario')->with('status', 'Horario actualizado exitosamente.');
    }

    public function destroyHorario($id)
    {
        $horario = HorariosMedicos::findOrFail($id);
        $horario->delete();

        return redirect()->route('citas.configurarHorario')->with('status', 'Horario eliminado exitosamente.');
    }

}

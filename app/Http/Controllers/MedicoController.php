<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use App\Models\Citas;
use App\Models\Consultas;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $medicoId = Auth::id();

        // Obtener el último número de expediente del médico autenticado y generar el siguiente
        $lastPaciente = Paciente::where('medico_id', $medicoId)->orderBy('no_exp', 'desc')->first();
        $nextNoExp = $lastPaciente ? $lastPaciente->no_exp + 1 : 1;

        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'sexo' => 'required|in:masculino,femenino',
        ]);

        Paciente::create([
            'no_exp' => $nextNoExp,
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'sexo' => $request->sexo,
            'activo' => 'si',
            'medico_id' => $medicoId,
        ]);

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

    // Muestra todos los pacientes activos
    public function mostrarPacientes(Request $request)
    {
        $medicoId = Auth::id();
        
        $query = Paciente::where('activo', 'si')->where('medico_id', $medicoId);

        if ($request->has('name') && $request->name != '') {
            $query->where('nombres', 'like', '%' . $request->name . '%');
        }
        
        $pacientes = Paciente::all();
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
        $medicoId = Auth::id();
        $citas = Citas::select('citas.*', 'personas.nombres', 'personas.apepat', 'personas.apemat')
                        ->join('personas', 'citas.persona_id', '=', 'personas.id')
                        ->where('citas.activo', 'si')
                        ->where('citas.medicoid', $medicoId)
                        ->get();
        
        // Mostrar todas las personas sin filtrar por activo
        $personas = Persona::where('medico_id', $medicoId)->get();
        
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
            'usuariomedicoid' => 'required|exists:users,id',
            'motivo_consulta' => 'nullable|string|max:255'
        ]);

        // Verificar si ya existe una cita a la misma hora y fecha para el mismo médico
        $exists = Citas::where('fecha', $request->fecha)
                    ->where('hora', $request->hora)
                    ->where('medicoid', $request->usuariomedicoid)
                    ->exists();

        if ($exists) {
            return back()->withErrors(['hora' => 'La hora seleccionada ya está ocupada. Por favor, elija otra hora.'])->withInput();
        }

        // Creación de la cita
        Citas::create([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'persona_id' => $request->persona_id,
            'medicoid' => $request->usuariomedicoid,
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
        $personas = Persona::where('medico_id', $medicoId)->get();

        // Verificar si se recibieron newDate y newTime, y utilizarlos
        $newDate = $request->input('newDate', $cita->fecha); // Usar la nueva fecha si está presente
        $newTime = $request->input('newTime', $cita->hora);  // Usar la nueva hora si está presente

        return view('medico.citas.editarCita', compact('cita', 'personas', 'newDate', 'newTime'));
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

        $cita = Citas::findOrFail($id);
        $cita->update([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'persona_id' => $request->persona_id,
            'medicoid' => $request->usuariomedicoid,
            'motivo_consulta' => $request->motivo_consulta
        ]);

        return redirect()->route('citas');
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
        $horasOcupadas = Citas::where('fecha', $fecha)->pluck('hora')->toArray();
        $horasDisponibles = [];

        // Generar horas enteras disponibles
        for ($i = 0; $i < 24; $i++) {
            $hora = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00:00';
            if (!in_array($hora, $horasOcupadas)) {
                $horasDisponibles[] = $hora;
            }
        }

        return response()->json($horasDisponibles);
    }

    public function horasDisponibles(Request $request)
    {
        $fecha = $request->input('fecha');
        $medicoid = $request->input('medicoid');
        $citas = Citas::where('fecha', $fecha)
                    ->where('medicoid', $medicoid)
                    ->pluck('hora')
                    ->toArray();
        return response()->json($citas);
    }
    
}

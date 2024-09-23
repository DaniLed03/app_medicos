<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use App\Models\Citas;
use App\Models\Consultas;
use App\Models\Persona;
use App\Models\EntidadFederativa;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\Calle;
use App\Models\Colonia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HorariosMedicos;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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

    public function generatePatientListPdf()
    {
        $pacientes = Paciente::all();
        $pdf = PDF::loadView('medico.pacientes.pdf', compact('pacientes'));
        $fileName = 'Lista_de_Pacientes.pdf';
        return $pdf->download($fileName);
    }
    

    // Guarda un nuevo paciente
    public function storePacientes(Request $request)
    {
        // Obtener el ID del usuario autenticado
        $currentUserId = Auth::id();

        // Obtener el ID del médico que creó al usuario autenticado (si existe)
        $medicoId = Auth::user()->medico_id ? Auth::user()->medico_id : $currentUserId;

        // Obtener el número máximo de expediente y sumar 1
        $nextNoExp = Paciente::where('medico_id', $medicoId)->max('no_exp') + 1;

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
            'nombres' => strtoupper($request->nombres),
            'apepat' => strtoupper($request->apepat),
            'apemat' => strtoupper($request->apemat),
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'sexo' => $request->sexo,
            'activo' => 'si',
            'medico_id' => $medicoId,
        ]);

        // Redirigir a la vista de edición del paciente recién creado
        return redirect()->route('pacientes.editar', ['no_exp' => $nextNoExp, 'medico_id' => $medicoId])->with('status', 'Paciente creado con éxito');
    }

    public function showPaciente($id)
    {
        $medicoId = Auth::id();
        $paciente = paciente::where('no_exp', $id)->where('medico_id', $medicoId)->firstOrFail();
        
        // Obtener las consultas del paciente con el mismo doctor
        $consultas = Consultas::where('pacienteid', $id)->where('usuariomedicoid', $medicoId)->get();

        return view('medico.pacientes.verPaciente', compact('paciente', 'consultas'));
    }

    public function storeDesdeModal(Request $request)
    {
        $medicoId = Auth::id();

        // Validar los datos del paciente
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:100',
            'apepat' => 'required|string|max:100',
            'apemat' => 'required|string|max:100',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'sexo' => 'required|in:masculino,femenino',
        ]);

        // Asignar el ID del médico
        $validatedData['medico_id'] = $medicoId;

        // Generar el número de expediente (no_exp) único
        $validatedData['no_exp'] = Paciente::where('medico_id', $medicoId)->max('no_exp') + 1;

        // Crear paciente y guardar el resultado en una variable
        $paciente = Paciente::create($validatedData);

        // Redireccionar con un mensaje y el id del paciente recién creado
        return redirect()->route('citas')
            ->with('status', 'Paciente agregado')
            ->with('paciente_id', $paciente->no_exp);
    }

    public function mostrarPacientes(Request $request)
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        // Obtén todos los pacientes para los cálculos de totales
        $totalPacientes = Paciente::where('activo', 'si')
                        ->where(function($q) use ($medicoId, $currentUser) {
                            $q->where('medico_id', $medicoId)
                            ->orWhere('medico_id', $currentUser->id);
                        })->count();

        $totalMujeres = Paciente::where('activo', 'si')
                        ->where('sexo', 'femenino')
                        ->where(function($q) use ($medicoId, $currentUser) {
                            $q->where('medico_id', $medicoId)
                            ->orWhere('medico_id', $currentUser->id);
                        })->count();

        $totalHombres = Paciente::where('activo', 'si')
                        ->where('sexo', 'masculino')
                        ->where(function($q) use ($medicoId, $currentUser) {
                            $q->where('medico_id', $medicoId)
                            ->orWhere('medico_id', $currentUser->id);
                        })->count();

        $porcentajeMujeres = $totalPacientes > 0 ? ($totalMujeres / $totalPacientes) * 100 : 0;
        $porcentajeHombres = $totalPacientes > 0 ? ($totalHombres / $totalPacientes) * 100 : 0;

        // Pacientes filtrados solo cuando hay búsqueda
        $pacientes = collect(); // Inicia vacío
        if ($request->has('name') && $request->name != '') {
            $searchTerm = $request->name;
            $pacientes = Paciente::where('activo', 'si')
                        ->where(function ($query) use ($searchTerm, $medicoId, $currentUser) {
                            $query->where(DB::raw("CONCAT(nombres, ' ', apepat, ' ', apemat)"), 'like', '%' . $searchTerm . '%')
                                ->where(function($q) use ($medicoId, $currentUser) {
                                    $q->where('medico_id', $medicoId)
                                    ->orWhere('medico_id', $currentUser->id);
                                });
                        })->get();
        }

        return view('medico.dashboard', compact('pacientes', 'totalPacientes', 'porcentajeMujeres', 'porcentajeHombres'));
    }


    // Muestra el formulario de edición de un paciente específico
    public function editarPaciente($noExp)
    {
        $medicoId = Auth::id();
        $paciente = Paciente::where('no_exp', $noExp)
                    ->where('medico_id', $medicoId)
                    ->firstOrFail();
        // Cargar los datos de las consultas del paciente con el mismo médico
        $consultas = Consultas::where('pacienteid', $noExp)->where('usuariomedicoid', $medicoId)->get();

        // Cargar datos de las tablas de catálogo
        $entidadesFederativas = EntidadFederativa::all();
        $municipios = Municipio::where('entidad_federativa_id', $paciente->entidad_federativa_id)->get();
        $localidades = Localidad::where('id_municipio', $paciente->municipio_id)
                                ->where('id_entidad_federativa', $paciente->entidad_federativa_id)
                                ->get();
        $colonias = Colonia::where('id_municipio', $paciente->municipio_id)
                        ->where('id_entidad', $paciente->entidad_federativa_id)
                        ->get();

        return view('medico.pacientes.editarPaciente', compact(
            'paciente', 
            'consultas', 
            'entidadesFederativas', 
            'municipios', 
            'localidades', 
            'colonias'
        ));
    }


    public function getMunicipios($entidadId)
    {
        $municipios = Municipio::where('entidad_federativa_id', $entidadId)->get(['id_municipio', 'nombre']);
        return response()->json($municipios);
    }    

    public function getLocalidades($municipioId)
    {
        $entidadId = request()->get('entidad_id');

        // Filtrar localidades por entidad y municipio
        $localidades = Localidad::where('id_municipio', $municipioId)
                                ->where('id_entidad_federativa', $entidadId)
                                ->get(['id_localidad', 'nombre']);

        // Mapear las localidades para concatenar los campos si es necesario
        $localidades = $localidades->map(function($localidad) {
            return [
                'id_localidad' => $localidad->id_localidad,
                'nombre' => $localidad->nombre // Puedes personalizar el nombre si deseas concatenar otros campos
            ];
        });

        return response()->json($localidades);
    }
    
    public function getColonias($municipioId)
    {
        $entidadId = request()->get('entidad_id');

        // Filtrar colonias por entidad y municipio
        $colonias = Colonia::where('id_municipio', $municipioId)
                            ->where('id_entidad', $entidadId)
                            ->get(['id_asentamiento', 'cp', 'tipo_asentamiento', 'asentamiento']);

        // Mapear las colonias para concatenar los campos
        $colonias = $colonias->map(function($colonia) {
            return [
                'id_asentamiento' => $colonia->id_asentamiento,
                'nombre' => $colonia->cp . ' - ' . $colonia->tipo_asentamiento . ' ' . $colonia->asentamiento
            ];
        });

        return response()->json($colonias);
    }


    public function updatePaciente(Request $request, $noExp = null)
    {
        $medicoId = Auth::id();

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
            'entidad_federativa_id' => 'nullable|exists:entidades_federativas,id',
            'municipio_id' => 'nullable|exists:municipios,id_municipio',
            'localidad_id' => 'nullable|exists:localidades,id_localidad',
            'colonia_id' => 'nullable|exists:colonias,id_asentamiento',
            'correo' => 'nullable|string|email|max:255|unique:pacientes,correo,' . $noExp . ',no_exp,medico_id,' . $medicoId,
            'telefono' => 'nullable|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'sexo' => 'nullable|in:masculino,femenino',
            'curp' => 'nullable|string|max:18|unique:pacientes,curp,' . $noExp . ',no_exp,medico_id,' . $medicoId,
            'Nombre_fact' => 'nullable|string|max:255',
            'Direccion_fact' => 'nullable|string|max:255',
            'RFC' => 'nullable|string|max:255',
            'Regimen_fiscal' => 'nullable|string|max:255',
            'CFDI' => 'nullable|string|max:255',
        ]);

        // Obtener el ID del médico autenticado
        $medicoId = Auth::id();

        // Verifica si el paciente existe
        $paciente = Paciente::where('no_exp', $noExp)
                            ->where('medico_id', $medicoId)
                            ->first();


        if ($paciente) {
            $data = array_filter($request->all(), function($value) {
                return !is_null($value);
            });
                        
            $paciente->fill($data);
            if (!is_null($request->localidad_id)) {
                $paciente->localidad_id = $request->localidad_id;
            }

            $paciente->save();
            
        } else {
            // Si el paciente es nuevo, genera el siguiente número de expediente
            $medicoId = Auth::id();
            $lastPaciente = Paciente::where('medico_id', $medicoId)->orderBy('no_exp', 'desc')->first();
            $nextNoExp = $lastPaciente ? $lastPaciente->no_exp + 1 : 1;

            // Crear el nuevo paciente manualmente
            $paciente = new Paciente();
            $paciente->no_exp = $nextNoExp;
            $paciente->nombres = $request->nombres;
            $paciente->apepat = $request->apepat;
            $paciente->apemat = $request->apemat ?? '';
            $paciente->fechanac = $request->fechanac ?? null;
            $paciente->curp = $request->curp ?? '';
            $paciente->correo = $request->correo ?? '';
            $paciente->sexo = $request->sexo ?? '';
            $paciente->entidad_federativa_id = $request->entidad_federativa_id ?? null;
            $paciente->municipio_id = $request->municipio_id ?? null;
            $paciente->localidad_id = $request->localidad_id ?? null;
            $paciente->calle = $request->calle ?? '';
            $paciente->colonia_id = $request->colonia_id ?? null;
            $paciente->telefono = $request->telefono ?? '';
            $paciente->telefono2 = $request->telefono2 ?? null;
            $paciente->Nombre_fact = $request->Nombre_fact ?? '';
            $paciente->Direccion_fact = $request->Direccion_fact ?? '';
            $paciente->RFC = $request->RFC ?? '';
            $paciente->Regimen_fiscal = $request->Regimen_fiscal ?? '';
            $paciente->CFDI = $request->CFDI ?? '';
            $paciente->hospital = $request->hospital ?? '';
            $paciente->tipoparto = $request->tipoparto ?? '';
            $paciente->tiposangre = $request->tiposangre ?? '';
            $paciente->lugar_naci = $request->lugar_naci ?? '';
            $paciente->hora = $request->hora ?? null;
            $paciente->peso = $request->peso ?? null;
            $paciente->talla = $request->talla ?? null;
            $paciente->padre = $request->padre ?? '';
            $paciente->madre = $request->madre ?? '';
            $paciente->antecedentes = $request->antecedentes ?? '';
            $paciente->medico_id = $medicoId;
            $paciente->activo = 'si';
            $paciente->save();

            $mensaje = 'Paciente creado correctamente';
        }

        // Redirecciona a la vista de edición de paciente con un mensaje de éxito
        $tab = $request->has('antecedentes') ? 'antecedentes' : $request->input('tab', 'datos');
        return redirect()->route('pacientes.editar', ['no_exp' => $paciente->no_exp, 'tab' => $tab])->with('status');

    }

    public function eliminarPaciente($no_exp)
    {
        $medicoId = Auth::id(); // Obtener el ID del médico autenticado

        // Buscar al paciente con las claves compuestas
        $paciente = Paciente::where('no_exp', $no_exp)
                            ->where('medico_id', $medicoId)
                            ->firstOrFail();

        if ($paciente) {
            // Marcar al paciente como inactivo
            $paciente->update(['activo' => 'no']);
            return redirect()->route('medico.dashboard')->with('status', 'Paciente eliminado correctamente.');
        } else {
            return redirect()->route('medico.dashboard')->with('error', 'Paciente no encontrado o no tienes permisos para eliminarlo.');
        }
    }

    //////////////////////////////////    CITAS    /////////////////////////////////////////

    public function searchPacientes(Request $request)
    {
        $searchTerm = $request->input('q');
        $medicoId = Auth::id();

        $pacientes = Paciente::where('activo', 'si')
            ->where('medico_id', $medicoId)
            ->where(function($query) use ($searchTerm) {
                $query->where('nombres', 'like', "%{$searchTerm}%")
                    ->orWhere('apepat', 'like', "%{$searchTerm}%")
                    ->orWhere('apemat', 'like', "%{$searchTerm}%");
            })
            ->select('no_exp', DB::raw("CONCAT(nombres, ' ', apepat, ' ', apemat) AS full_name"))
            ->limit(10)
            ->get();

        return response()->json($pacientes);
    }

    // Muestra todas las citas activas
    public function mostrarCitas()
    {
        $currentUser = Auth::user();
        $medicoId = $currentUser->medico_id ? $currentUser->medico_id : $currentUser->id;

        $citas = Citas::select('citas.*', 'pacientes.nombres', 'pacientes.apepat', 'pacientes.apemat')
                    ->join('pacientes', function($join) use ($medicoId) {
                        // Cambiar a la columna correcta de la tabla citas
                        $join->on('citas.no_exp', '=', 'pacientes.no_exp') // Reemplaza persona_id por no_exp
                            ->where('pacientes.medico_id', '=', $medicoId);
                    })
                    ->where('citas.activo', 'si')
                    ->where('citas.status', '!=', 'Finalizada') // Excluir las citas finalizadas
                    ->where(function($q) use ($medicoId, $currentUser) {
                        $q->where('citas.medicoid', $medicoId)
                            ->orWhere('citas.medicoid', $currentUser->id);
                    })
                    ->get();

        
        // Obtener los pacientes asociados al médico
        $pacientes = Paciente::where(function($q) use ($medicoId, $currentUser) {
                            $q->where('medico_id', $medicoId)
                            ->orWhere('medico_id', $currentUser->id);
                        })
                        ->get();
        
        return view('medico.citas.citas', compact('citas', 'pacientes'));
    }

    // Guarda una nueva cita
    public function storeCitas(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'paciente_no_exp' => 'required|exists:pacientes,no_exp', // Cambiado de persona_id a paciente_no_exp
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
            'no_exp' => $request->paciente_no_exp, // Cambiado de persona_id a no_exp
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
        $pacientes = Paciente::where('activo', 'si')
                            ->where('medico_id', $medicoId)
                            ->get();
        return view('medico.citas.agregarCita', compact('pacientes'));
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
        // Validación de los datos
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'motivo_consulta' => 'nullable|string|max:255',
            'usuariomedicoid' => 'required|exists:users,id',
            'paciente_no_exp' => 'required|exists:pacientes,no_exp', // Validamos el no_exp
        ]);

        // Verifica si ya existe una cita en esa fecha y hora para evitar conflictos
        $exists = Citas::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('medicoid', $request->usuariomedicoid)
            ->where('id', '!=', $id) // Excluir la cita actual
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'La hora seleccionada ya está ocupada. Por favor, elija otra hora.')->withInput();
        }

        // Encontrar la cita y actualizarla
        $cita = Citas::findOrFail($id);
        $cita->update([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'motivo_consulta' => $request->motivo_consulta,
            'usuariomedicoid' => $request->usuariomedicoid,
            'no_exp' => $request->paciente_no_exp, // Usamos el no_exp en lugar de persona_id
        ]);

        // Redirigir a la lista de citas con un mensaje de éxito
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

    public function storeHorario(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'duracion_sesion' => 'required|integer|min:1',
            'turno' => 'required|in:Matutino,Vespertino,Nocturno',
        ], [
            'dia_semana.required' => 'Debe seleccionar un día de la semana.',
            'dia_semana.in' => 'Debe seleccionar un día válido.',
            'turno.required' => 'Debe seleccionar un turno.',
            'turno.in' => 'Debe seleccionar un turno válido.',
            'hora_fin.after' => 'La hora de fin debe ser mayor que la hora de inicio.', // Mensaje personalizado
        ]);

        $medicoId = Auth::id();
        $diaSemana = $request->dia_semana;
        $turno = $request->turno;

        // Verificar si el médico ya tiene un turno asignado para este día
        $horariosDelDia = HorariosMedicos::where('medico_id', $medicoId)
                                            ->where('dia_semana', $diaSemana)
                                            ->where('turno', $turno)
                                            ->first();

        // Si ya existe el turno, redirigir con error
        if ($horariosDelDia) {
            return redirect()->back()->withErrors(['turno_repetido' => 'Ya tienes un horario configurado para el turno ' . $turno . ' en el día ' . $diaSemana . '.']);
        }

        // Creación del horario si no hay errores
        HorariosMedicos::create([
            'medico_id' => $medicoId,
            'dia_semana' => $diaSemana,
            'turno' => $turno,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'duracion_sesion' => $request->duracion_sesion,
            'disponible' => 1,
        ]);

        return redirect()->route('citas.configurarHorario')->with('status', 'Horario guardado exitosamente.');
    }

    public function obtenerHorariosPorDia(Request $request)
    {
        $fecha = $request->input('fecha');
        $medicoId = Auth::id();

        // Determinar el día de la semana a partir de la fecha seleccionada
        $diaSemana = Carbon::parse($fecha)->locale('es')->dayName;

        // Buscar horarios para el día de la semana
        $horarios = HorariosMedicos::where('medico_id', $medicoId)
                                    ->where('dia_semana', $diaSemana)
                                    ->get();

        if ($horarios->isEmpty()) {
            return response()->json(['mensaje' => 'No hay horarios configurados para este día.'], 404);
        }

        // Ordenar los turnos en el siguiente orden: Matutino, Vespertino, Nocturno
        $horariosOrdenados = $horarios->sortBy(function($horario) {
            return ['Matutino' => 1, 'Vespertino' => 2, 'Nocturno' => 3][$horario->turno];
        });

        // Crear los intervalos basados en la duración de la sesión
        $horariosDivididos = [];

        foreach ($horariosOrdenados as $horario) {
            // Añadir el encabezado para el turno
            $horariosDivididos[] = [
                'inicio' => null, 
                'fin' => null, 
                'turno' => 'Horario ' . $horario->turno
            ];

            $horaInicio = Carbon::parse($horario->hora_inicio);
            $horaFin = Carbon::parse($horario->hora_fin);
            $duracionSesion = $horario->duracion_sesion;

            while ($horaInicio->lessThan($horaFin)) {
                $finIntervalo = $horaInicio->copy()->addMinutes($duracionSesion);
                if ($finIntervalo->greaterThan($horaFin)) {
                    $finIntervalo = $horaFin;
                }

                $horariosDivididos[] = [
                    'inicio' => $horaInicio->format('H:i'),
                    'fin' => $finIntervalo->format('H:i'),
                    'turno' => null
                ];

                $horaInicio->addMinutes($duracionSesion);
            }
        }

        return response()->json($horariosDivididos);
    }

    public function obtenerHorasOcupadas(Request $request)
    {
        $fecha = $request->input('fecha');
        $medicoId = Auth::id(); // Obtener el ID del médico actual

        // Obtener las horas ocupadas para la fecha seleccionada
        $horasOcupadas = Citas::where('fecha', $fecha)
                            ->where('medicoid', $medicoId)
                            ->pluck('hora') // Obtenemos las horas ocupadas
                            ->toArray(); // Convertimos la colección en un array

        return response()->json($horasOcupadas);
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
            'turno' => $request->turno, // Asegúrate de incluir el turno aquí también
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

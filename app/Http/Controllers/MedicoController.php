<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Productos;
use App\Models\User;
use App\Models\Citas;
use App\Models\Servicio;
use App\Models\Consultas;
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
        $medicoId = Auth::id();

        // Obtener el último número de expediente del médico autenticado y generar el siguiente
        $lastPaciente = Paciente::where('medico_id', $medicoId)->orderBy('no_exp', 'desc')->first();
        $nextNoExp = $lastPaciente ? $lastPaciente->no_exp + 1 : 1;

        $validatedData = $request->validate([
            'nombres' => 'required|string|max:100',
            'apepat' => 'required|string|max:100',
            'apemat' => 'required|string|max:100',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'sexo' => 'required|in:masculino,femenino',
            'correo' => 'required|string|email|max:255|unique:pacientes',
        ]);

        $optionalFields = [
            'hora', 'peso', 'talla', 'lugar_naci', 'hospital',
            'tipoparto', 'tiposangre', 'antecedentes', 'padre',
            'madre', 'direccion', 'telefono2'
        ];

        foreach ($optionalFields as $field) {
            if ($request->filled($field)) {
                $validatedData[$field] = $request->input($field);
            }
        }

        $validatedData['no_exp'] = $nextNoExp;
        $validatedData['medico_id'] = $medicoId;

        $paciente = Paciente::create($validatedData);

        return redirect()->route('citas')->with('status', 'Paciente agregado exitosamente')->with('paciente_id', $paciente->id);
    }

    // Muestra todos los pacientes activos
    public function mostrarPacientes(Request $request)
    {
        $medicoId = Auth::id();
        
        $query = Paciente::where('activo', 'si')->where('medico_id', $medicoId);

        if ($request->has('name') && $request->name != '') {
            $query->where('nombres', 'like', '%' . $request->name . '%');
        }
        
        $pacientes = $query->get();
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
 

    public function updatePaciente(Request $request, $id)
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
            'correo' => 'nullable|string|email|max:255|unique:pacientes,correo,'.$id,
            'telefono' => 'nullable|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'sexo' => 'nullable|in:masculino,femenino',
            'curp' => 'nullable|string|max:18|unique:pacientes,curp,'.$id,
            'Nombre_fact' => 'nullable|string|max:255',
            'Direccion_fact' => 'nullable|string|max:255',
            'RFC' => 'nullable|string|max:255',
            'Regimen_fiscal' => 'nullable|string|max:255',
            'CFDI' => 'nullable|string|max:255',
        ]);

        // Encuentra el paciente y actualiza sus datos
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        // Redirecciona a la vista de edición de paciente con un mensaje de éxito
        // Redirect to the correct tab based on the form that was submitted
        $tab = $request->input('tab', 'datos'); // Get the tab from the request or default to 'datos'
        return redirect()->route('pacientes.editar', ['id' => $id, 'tab' => $tab])->with('status', 'Paciente actualizado correctamente');    }


    // Marca a un paciente como inactivo (eliminado)
    public function eliminarPaciente($id)
    {
        $medicoId = Auth::id();
        $paciente = Paciente::where('id', $id)->where('medico_id', $medicoId)->firstOrFail();
        $paciente->update(['activo' => 'no']);

        return redirect()->route('medico.dashboard')->with('status', 'Paciente eliminado correctamente');
    }

    //////////////////////////////////    PRODUCTOS    /////////////////////////////////////////

    // Muestra todos los productos activos
    public function mostrarProductos()
    {
        $productos = Productos::where('activo', 'si')->get();
        return view('medico.productos.productos', compact('productos'));
    }

    // Guarda un nuevo producto
    public function storeProductos(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'cantidad' => 'required|integer|min:0'
        ]);

        // Creación del producto
        Productos::create($request->all());

        // Redirecciona a la vista de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo producto
    public function crearProducto()
    {
        return view('medico.productos.agregarProducto');
    }

    // Muestra el formulario de edición de un producto específico
    public function editarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        return view('medico.productos.editarProducto', compact('producto'));
    }

    // Actualiza la información de un producto específico
    public function updateProducto(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'cantidad' => 'required|integer|min:0'
        ]);

        // Encuentra el producto y actualiza sus datos
        $producto = Productos::findOrFail($id);
        $producto->update($request->all());

        // Redirecciona a la vista de productos con un mensaje de éxito
        return redirect()->route('productos')->with('status', 'Producto actualizado correctamente');
    }

    // Marca a un producto como inactivo (eliminado)
    public function eliminarProducto($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => 'no']);

        return redirect()->route('productos')->with('status', 'Producto eliminado correctamente');
    }

    //////////////////////////////////    CITAS    /////////////////////////////////////////

    // Muestra todas las citas activas
    public function mostrarCitas()
    {
        $medicoId = Auth::id();
        $citas = Citas::select('citas.*', 'pacientes.nombres', 'pacientes.apepat', 'pacientes.apemat')
                        ->join('pacientes', 'citas.pacienteid', '=', 'pacientes.id')
                        ->where('citas.activo', 'si')
                        ->where('citas.medicoid', $medicoId)
                        ->get();
    
        $pacientes = Paciente::where('activo', 'si')->where('medico_id', $medicoId)->get();
    
        return view('medico.citas.citas', compact('citas', 'pacientes'));
    }
    
    // Guarda una nueva cita
    public function storeCitas(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id',
            'motivo_consulta' => 'nullable|string|max:255' // Asegúrate de que el campo esté aquí
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
            'pacienteid' => $request->pacienteid,
            'medicoid' => $request->usuariomedicoid,
            'motivo_consulta' => $request->motivo_consulta // Asegúrate de que el campo esté aquí
        ]);

        // Redirecciona a la vista de citas con un mensaje de éxito
        return redirect()->route('citas')->with('status', 'Cita registrada correctamente');
    }

    // Muestra el formulario para agregar una nueva cita
    public function crearCita()
    {
        $medicoId = Auth::id();
        $pacientes = Paciente::where('activo', 'si')->where('medico_id', $medicoId)->get();
        return view('medico.citas.agregarCita', compact('pacientes'));
    }

    // Muestra el formulario de edición de una cita específica
    public function editarCita($id)
    {
        $medicoId = Auth::id();
        $cita = Citas::where('id', $id)->where('medicoid', $medicoId)->firstOrFail();
        $pacientes = Paciente::where('activo', 'si')->where('medico_id', $medicoId)->get();
        return view('medico.citas.editarCita', compact('cita', 'pacientes'));
    }

    // Actualiza la información de una cita específica
    public function updateCita(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id',
            'motivo_consulta' => 'nullable|string|max:255'
        ]);

        $cita = Citas::findOrFail($id);
        $cita->update([
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'pacienteid' => $request->pacienteid,
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
    

    //////////////////////////////////    MEDICOS    /////////////////////////////////////////

    // Muestra todos los médicos activos
    public function mostrarMedicos()
    {
        $medicos = User::where('rol', 'medico')->where('activo', 'si')->get();
        $totalMedicos = $medicos->count();
        $totalMujeres = $medicos->where('sexo', 'femenino')->count();
        $totalHombres = $medicos->where('sexo', 'masculino')->count();

        $porcentajeMujeres = $totalMedicos > 0 ? ($totalMujeres / $totalMedicos) * 100 : 0;
        $porcentajeHombres = $totalMedicos > 0 ? ($totalHombres / $totalMedicos) * 100 : 0;

        return view('medico.medicos.medicos', compact('medicos', 'totalMedicos', 'porcentajeMujeres', 'porcentajeHombres'));
    }

    // Guarda un nuevo médico
    public function storeMedicos(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'sexo' => 'required|in:masculino,femenino', // Nueva validación
        ]);

        // Creación del médico con cifrado de la contraseña
        User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'medico',
            'sexo' => $request->sexo, // Nuevo campo
        ]);

        // Redirecciona a la vista de médicos con un mensaje de éxito
        return redirect()->route('medicos')->with('status', 'Médico registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo médico
    public function crearMedico()
    {
        return view('medico.medicos.agregarMedico');
    }

    // Muestra el formulario de edición de un médico específico
    public function editarMedico($id)
    {
        $medico = User::findOrFail($id);
        return view('medico.medicos.editarMedico', compact('medico'));
    }

    // Actualiza la información de un médico específico
    public function updateMedico(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'sexo' => 'required|in:masculino,femenino', // Nueva validación
        ]);

        // Encuentra el médico y actualiza sus datos
        $medico = User::findOrFail($id);
        $medico->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $medico->password,
            'sexo' => $request->sexo, // Nuevo campo
        ]);

        // Redirecciona a la vista de médicos con un mensaje de éxito
        return redirect()->route('medicos')->with('status', 'Médico actualizado correctamente');
    }

    // Marca a un médico como inactivo (eliminado)
    public function eliminarMedico($id)
    {
        $medico = User::findOrFail($id);
        $medico->update(['activo' => 'no']);

        return redirect()->route('medicos')->with('status', 'Médico eliminado correctamente');
    }

    //////////////////////////////////    SERVICIOS    /////////////////////////////////////////

    // Muestra todos los servicios activos
    public function mostrarServicios()
    {
        $servicios = Servicio::where('activo', 'si')->get();
        return view('medico.servicios.servicios', compact('servicios'));
    }

    // Guarda un nuevo servicio
    public function storeServicios(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'cantidad' => 'required|integer|min:0'
        ]);

        // Creación del servicio
        Servicio::create($request->all());

        // Redirecciona a la vista de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio registrado correctamente');
    }

    // Muestra el formulario para agregar un nuevo servicio
    public function crearServicio()
    {
        return view('medico.servicios.agregarServicio');
    }

    // Muestra el formulario de edición de un servicio específico
    public function editarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('medico.servicios.editarServicio', compact('servicio'));
    }

    // Actualiza la información de un servicio específico
    public function updateServicio(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:1000',
            'cantidad' => 'required|integer|min:0'
        ]);

        // Encuentra el servicio y actualiza sus datos
        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->all());

        // Redirecciona a la vista de servicios con un mensaje de éxito
        return redirect()->route('servicios')->with('status', 'Servicio actualizado correctamente');
    }

    // Marca a un servicio como inactivo (eliminado)
    public function eliminarServicio($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => 'no']);

        // Redirecciona a la vista de servicios
        return redirect()->route('servicios')->with('status', 'Servicio eliminado correctamente');
    }

    ////////////////////////////////    ENFERMERAS    /////////////////////////////////////////

    // Muestra todas las enfermeras activas
    public function mostrarEnfermeras()
    {
        $enfermeras = User::where('rol', 'enfermera')->where('activo', 'si')->get();
        $totalEnfermeras = $enfermeras->count();
        $totalMujeres = $enfermeras->where('sexo', 'femenino')->count();
        $totalHombres = $enfermeras->where('sexo', 'masculino')->count();

        $porcentajeMujeres = $totalEnfermeras > 0 ? ($totalMujeres / $totalEnfermeras) * 100 : 0;
        $porcentajeHombres = $totalEnfermeras > 0 ? ($totalHombres / $totalEnfermeras) * 100 : 0;

        return view('medico.enfermeras.enfermeras', compact('enfermeras', 'totalEnfermeras', 'porcentajeMujeres', 'porcentajeHombres'));
    }

    // Guarda una nueva enfermera
    public function storeEnfermeras(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'sexo' => 'required|in:masculino,femenino', // Nueva validación
        ]);

        // Creación de la enfermera con cifrado de la contraseña
        User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'enfermera',
            'sexo' => $request->sexo, // Nuevo campo
        ]);

        // Redirecciona a la vista de enfermeras con un mensaje de éxito
        return redirect()->route('enfermeras')->with('status', 'Enfermera registrada correctamente');
    }

    // Muestra el formulario para agregar una nueva enfermera
    public function crearEnfermera()
    {
        return view('medico.enfermeras.agregarEnfermera');
    }

    // Muestra el formulario de edición de una enfermera específica
    public function editarEnfermera($id)
    {
        $enfermera = User::findOrFail($id);
        return view('medico.enfermeras.editarEnfermera', compact('enfermera'));
    }

    // Actualiza la información de una enfermera específica
    public function updateEnfermera(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'sexo' => 'required|in:masculino,femenino', // Nueva validación
        ]);
    
        // Encuentra la enfermera y actualiza sus datos
        $enfermera = User::findOrFail($id);
        $enfermera->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $enfermera->password,
            'sexo' => $request->sexo, // Nuevo campo
        ]);
    
        // Redirecciona a la vista de enfermeras con un mensaje de éxito
        return redirect()->route('enfermeras')->with('status', 'Enfermera actualizada correctamente');
    }
    

    // Marca a una enfermera como inactiva (eliminada)
    public function eliminarEnfermera($id)
    {
        $enfermera = User::findOrFail($id);
        $enfermera->update(['activo' => 'no']);

        return redirect()->route('enfermeras')->with('status', 'Enfermera eliminada correctamente');
    }

    //////////////////////////////////    SECRETARIAS    /////////////////////////////////////////

    // Muestra todas las secretarias activas
    public function mostrarSecretarias()
    {
        $secretarias = User::where('rol', 'secretaria')->where('activo', 'si')->get();
        $totalSecretarias = $secretarias->count();
        $totalMujeres = $secretarias->where('sexo', 'femenino')->count();
        $totalHombres = $secretarias->where('sexo', 'masculino')->count();

        $porcentajeMujeres = $totalSecretarias > 0 ? ($totalMujeres / $totalSecretarias) * 100 : 0;
        $porcentajeHombres = $totalSecretarias > 0 ? ($totalHombres / $totalSecretarias) * 100 : 0;

        return view('medico.Secretaria.secretarias', compact('secretarias', 'totalSecretarias', 'porcentajeMujeres', 'porcentajeHombres'));
    }

    // Guarda una nueva secretaria
    public function storeSecretarias(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'sexo' => 'required|in:masculino,femenino',
        ]);

        // Creación de la secretaria con cifrado de la contraseña
        User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => 'secretaria',
            'sexo' => $request->sexo,
        ]);

        // Redirecciona a la vista de secretarias con un mensaje de éxito
        return redirect()->route('secretarias')->with('status', 'Secretaria registrada correctamente');
    }

    // Muestra el formulario para agregar una nueva secretaria
    public function crearSecretaria()
    {
        return view('medico.Secretaria.agregarSecretaria');
    }

    // Muestra el formulario de edición de una secretaria específica
    public function editarSecretaria($id)
    {
        $secretaria = User::findOrFail($id);
        return view('medico.Secretaria.editarSecretaria', compact('secretaria'));
    }

    // Actualiza la información de una secretaria específica
    public function updateSecretaria(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'sexo' => 'required|in:masculino,femenino',
        ]);

        // Encuentra la secretaria y actualiza sus datos
        $secretaria = User::findOrFail($id);
        $secretaria->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $secretaria->password,
            'sexo' => $request->sexo,
        ]);

        // Redirecciona a la vista de secretarias con un mensaje de éxito
        return redirect()->route('secretarias')->with('status', 'Secretaria actualizada correctamente');
    }

    // Marca a una secretaria como inactiva (eliminada)
    public function eliminarSecretaria($id)
    {
        $secretaria = User::findOrFail($id);
        $secretaria->update(['activo' => 'no']);

        return redirect()->route('secretarias')->with('status', 'Secretaria eliminada correctamente');
    }
}

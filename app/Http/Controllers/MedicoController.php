<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Productos;
use App\Models\User;
use App\Models\Citas;
use App\Models\Servicio;
use Illuminate\Http\Request;

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
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'correo' => 'required|string|email|max:255|unique:pacientes',
            'contraseña' => 'required|string|min:8',
            'telefono' => 'required|string|max:20',
            'sexo' => 'required|in:masculino,femenino',
        ]);

        Paciente::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'correo' => $request->correo,
            'contraseña' => bcrypt($request->contraseña),
            'telefono' => $request->telefono,
            'sexo' => $request->sexo,
            'activo' => 'si',
        ]);

        return redirect()->route('medico.dashboard')->with('status', 'Paciente registrado correctamente');
    }


    // Muestra todos los pacientes activos
    public function mostrarPacientes(Request $request)
    {
        $query = Paciente::where('activo', 'si');
        
        // Filtrar por nombre si se proporciona
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
        $paciente = Paciente::findOrFail($id);
        return view('medico.pacientes.editarPaciente', compact('paciente'));
    }


    public function updatePaciente(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'correo' => 'required|string|email|max:255|unique:pacientes,correo,'.$id,
            'contraseña' => 'nullable|string|min:8',
            'telefono' => 'required|string|max:20', // nuevo campo
            'sexo' => 'required|in:masculino,femenino', // nuevo campo
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'correo' => $request->correo,
            'contraseña' => $request->contraseña ? bcrypt($request->contraseña) : $paciente->contraseña,
            'telefono' => $request->telefono, // nuevo campo
            'sexo' => $request->sexo, // nuevo campo
            'activo' => 'si',
        ]);

        return redirect()->route('medico.dashboard')->with('status', 'Paciente actualizado correctamente');
    }


    // Marca a un paciente como inactivo (eliminado)
    public function eliminarPaciente($id)
    {
        $paciente = Paciente::findOrFail($id);
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
        $citas = Citas::select('citas.*', 'pacientes.nombres', 'pacientes.apepat', 'pacientes.apemat')
                        ->join('pacientes', 'citas.pacienteid', '=', 'pacientes.id')
                        ->where('citas.activo', 'si')
                        ->get();

        $pacientes = Paciente::where('activo', 'si')->get();
        $usuarios = User::where('activo', 'si')->get();

        return view('medico.citas.citas', compact('citas', 'pacientes', 'usuarios'));
    }

    // Guarda una nueva cita
    public function storeCitas(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i', // Validar formato HH:mm
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
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
            'medicoid' => $request->usuariomedicoid
        ]);

        // Redirecciona a la vista de citas con un mensaje de éxito
        return redirect()->route('citas')->with('status', 'Cita registrada correctamente');
    }

    // Muestra el formulario para agregar una nueva cita
    public function crearCita()
    {
        $pacientes = Paciente::where('activo', 'si')->get();
        $usuarios = User::where('activo', 'si')->get();
        return view('medico.citas.agregarCita', compact('pacientes', 'usuarios'));
    }

    // Muestra el formulario de edición de una cita específica
    public function editarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $pacientes = Paciente::where('activo', 'si')->get();
        $usuarios = User::where('activo', 'si')->get();
        return view('medico.citas.editarCita', compact('cita', 'pacientes', 'usuarios'));
    }

    // Actualiza la información de una cita específica
    public function updateCita(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i', // Validar formato HH:mm
            'pacienteid' => 'required|exists:pacientes,id',
            'usuariomedicoid' => 'required|exists:users,id'
        ]);

        // Encuentra la cita y actualiza sus datos
        $cita = Citas::findOrFail($id);
        $cita->update($request->all());

        // Redirecciona a la vista de citas con un mensaje de éxito
        return redirect()->route('citas')->with('status', 'Cita actualizada correctamente');
    }

    // Marca una cita como inactiva (eliminada)
    public function eliminarCita($id)
    {
        $cita = Citas::findOrFail($id);
        $cita->update(['activo' => 'no']);

        return redirect()->route('citas')->with('status', 'Cita eliminada correctamente');
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
        return view('medico.medicos.medicos', compact('medicos'));
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
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
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
        return view('medico.enfermeras.enfermeras', compact('enfermeras'));
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
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
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

}


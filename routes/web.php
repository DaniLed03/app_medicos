<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\MedicoController;
use Illuminate\Support\Facades\Route;

// Ruta de la página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Incluir las rutas de autenticación generadas por Laravel Breeze
require __DIR__.'/auth.php';

// Agrupación de rutas que requieren autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
    // Ruta del dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Rutas del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Pacientes
    Route::post('/pacientes', [MedicoController::class, 'storePacientes'])->name('pacientes.store');
    Route::get('/agregarPaciente', function () {
        return view('medico.pacientes.agregarPaciente');
    })->name('agregarPaciente');
    Route::get('/medico/dashboard', [MedicoController::class, 'mostrarPacientes'])->name('medico.dashboard');
    Route::get('/medico/pacientes/editar/{id}', [MedicoController::class, 'editarPaciente'])->name('pacientes.editar');
    Route::match(['put', 'patch'], '/medico/pacientes/editar/{id}', [MedicoController::class, 'updatePaciente'])->name('pacientes.update');
    Route::delete('/medico/pacientes/eliminar/{id}', [MedicoController::class, 'eliminarPaciente'])->name('pacientes.eliminar');
    Route::get('/medico/pacientes', [MedicoController::class, 'mostrarPacientes'])->name('pacientes.index');
    Route::post('/pacientes/storeDesdeModal', [MedicoController::class, 'storePacientesDesdeModal'])->name('pacientes.storeDesdeModal');
    Route::get('/pacientes/create', [MedicoController::class, 'create'])->name('pacientes.create');
    Route::get('/pacientes/{id}', [MedicoController::class, 'showPaciente'])->name('pacientes.show');

    // Rutas de Productos
    Route::get('/medico/productos/agregar', [MedicoController::class, 'crearProducto'])->name('productos.agregar');
    Route::post('/medico/productos/agregarProducto', [MedicoController::class, 'storeProductos'])->name('productos.store');
    Route::patch('/medico/productos/editar/{id}', [MedicoController::class, 'updateProducto'])->name('productos.update');
    Route::delete('/medico/productos/eliminar/{id}', [MedicoController::class, 'eliminarProducto'])->name('productos.eliminar');
    Route::get('/medico/productos', [MedicoController::class, 'mostrarProductos'])->name('productos');
    Route::get('/productos/{id}/editar', [MedicoController::class, 'editarProducto'])->name('productos.editar');

    // Rutas de Citas
    Route::get('/medico/citas', [MedicoController::class, 'mostrarCitas'])->name('citas');
    Route::get('/medico/citas/editar/{id}', [MedicoController::class, 'editarCita'])->name('citas.editar');
    Route::delete('/medico/citas/eliminar/{id}', [MedicoController::class, 'eliminarCita'])->name('citas.eliminar');
    Route::get('/horas-disponibles', [MedicoController::class, 'horasDisponibles'])->name('horas.disponibles');
    Route::delete('/medico/citas/borrar/{id}', [MedicoController::class, 'borrarCita'])->name('citas.borrar');
    Route::patch('/medico/citas/editar/{id}', [MedicoController::class, 'updateCita'])->name('citas.update');
    Route::get('/medico/citas/agregar', [MedicoController::class, 'crearCita'])->name('citas.agregar');
    Route::post('/medico/citas/agregarCita', [MedicoController::class, 'storeCitas'])->name('citas.store');

    // Rutas de Médicos
    Route::get('/medico/medicos', [MedicoController::class, 'mostrarMedicos'])->name('medicos');
    Route::post('/medico/medicos/agregarMedico', [MedicoController::class, 'storeMedicos'])->name('medicos.store');
    Route::get('/medico/medicos/agregar', [MedicoController::class, 'crearMedico'])->name('medicos.agregar');
    Route::get('/medico/medicos/editar/{id}', [MedicoController::class, 'editarMedico'])->name('medicos.editar');
    Route::patch('/medico/medicos/editar/{id}', [MedicoController::class, 'updateMedico'])->name('medicos.update');
    Route::delete('/medico/medicos/eliminar/{id}', [MedicoController::class, 'eliminarMedico'])->name('medicos.eliminar');

    // Rutas de Servicios
    Route::get('/medico/servicios', [MedicoController::class, 'mostrarServicios'])->name('servicios');
    Route::post('/medico/servicios/agregarServicio', [MedicoController::class, 'storeServicios'])->name('servicios.store');
    Route::get('/medico/servicios/agregar', [MedicoController::class, 'crearServicio'])->name('servicios.agregar');
    Route::patch('/medico/servicios/editar/{id}', [MedicoController::class, 'updateServicio'])->name('servicios.update');
    Route::delete('/medico/servicios/eliminar/{id}', [MedicoController::class, 'eliminarServicio'])->name('servicios.eliminar');
    Route::get('/servicios/{id}/editar', [MedicoController::class, 'editarServicio'])->name('servicios.editar');

    // Rutas de Consultas
    Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::post('/consultas/agregar', [ConsultaController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/editar/{id}', [ConsultaController::class, 'edit'])->name('consultas.edit');
    Route::put('/consultas/editar/{id}', [ConsultaController::class, 'update'])->name('consultas.update');
    Route::get('/consultas/agregar/{citaId}', [ConsultaController::class, 'create'])->name('consultas.create');
    Route::get('consultas/{id}', [ConsultaController::class, 'show'])->name('consultas.show');
    Route::put('consultas/{id}/terminate', [ConsultaController::class, 'terminate'])->name('consultas.terminate');
    Route::get('/consultas/crear-sin-cita/{pacienteId}', [ConsultaController::class, 'createWithoutCita'])->name('consultas.createWithoutCita');
    Route::post('/consultas/crear-sin-cita', [ConsultaController::class, 'storeWithoutCita'])->name('consultas.storeWithoutCita');
    Route::get('consultas/{consulta}/print', [ConsultaController::class, 'print'])->name('consultas.print');
    Route::get('/consultas/{id}', [ConsultaController::class, 'show'])->name('consultas.show');

    // Rutas de enfermeras
    Route::get('/enfermeras', [MedicoController::class, 'mostrarEnfermeras'])->name('enfermeras');
    Route::get('/enfermeras/create', [MedicoController::class, 'crearEnfermera'])->name('enfermeras.create');
    Route::post('/enfermeras', [MedicoController::class, 'storeEnfermeras'])->name('enfermeras.store');
    Route::get('/enfermeras/{id}/edit', [MedicoController::class, 'editarEnfermera'])->name('enfermeras.edit');
    Route::put('/enfermeras/{id}', [MedicoController::class, 'updateEnfermera'])->name('enfermeras.update');
    Route::delete('/enfermeras/{id}', [MedicoController::class, 'eliminarEnfermera'])->name('enfermeras.destroy');

    // Rutas de Secretarias
    Route::get('/secretarias', [MedicoController::class, 'mostrarSecretarias'])->name('secretarias');
    Route::get('/secretarias/create', [MedicoController::class, 'crearSecretaria'])->name('secretarias.create');
    Route::post('/secretarias', [MedicoController::class, 'storeSecretarias'])->name('secretarias.store');
    Route::get('/secretarias/{id}/edit', [MedicoController::class, 'editarSecretaria'])->name('secretarias.edit');
    Route::put('/secretarias/{id}', [MedicoController::class, 'updateSecretaria'])->name('secretarias.update');
    Route::delete('/secretarias/{id}', [MedicoController::class, 'eliminarSecretaria'])->name('secretarias.destroy');


});

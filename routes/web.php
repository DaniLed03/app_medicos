<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PersonaAuthController;
use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;

// Ruta de la página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Incluir las rutas de autenticación generadas por Laravel Breeze
require __DIR__.'/auth.php';

Route::get('persona/login', [PersonaAuthController::class, 'showLoginForm'])->name('persona.login');
Route::post('persona/login', [PersonaAuthController::class, 'login']);
Route::post('persona/logout', [PersonaAuthController::class, 'logout'])->name('persona.logout');

Route::get('/personas/citas', [PersonaController::class, 'showCitas'])->name('personas.citas');

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

    Route::get('/usuarios', [AsignarController::class, 'index'])->name('users.index');
    Route::get('/usuarios/{id}/edit', [AsignarController::class, 'edit'])->name('users.edit');
    Route::patch('/usuarios/{id}', [AsignarController::class, 'update'])->name('users.update');
    Route::post('/usuarios', [AsignarController::class, 'store'])->name('users.store');
    Route::delete('/{id}', [AsignarController::class, 'destroy'])->name('users.destroy');

    // Rutas para gestionar roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Rutas para gestionar permisos
    Route::get('/permisos', [PermissionController::class, 'index'])->name('permisos.index');
    Route::post('/permisos', [PermissionController::class, 'store'])->name('permisos.store');
    Route::delete('/permisos/{permission}', [PermissionController::class, 'destroy'])->name('permisos.destroy');

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
    Route::get('/medico/pacientes/{id}/editarPaciente', [MedicoController::class, 'editarPaciente'])->name('medico.pacientes.editarPaciente');

    // Rutas de Citas
    Route::get('/medico/citas', [MedicoController::class, 'mostrarCitas'])->name('citas');
    Route::get('/medico/citas/editar/{id}', [MedicoController::class, 'editarCita'])->name('citas.editar');
    Route::delete('/medico/citas/eliminar/{id}', [MedicoController::class, 'eliminarCita'])->name('citas.eliminar');
    Route::get('/horas-disponibles', [MedicoController::class, 'horasDisponibles'])->name('horas.disponibles');
    Route::delete('/medico/citas/borrar/{id}', [MedicoController::class, 'borrarCita'])->name('citas.borrar');
    Route::patch('/medico/citas/editar/{id}', [MedicoController::class, 'updateCita'])->name('citas.update');
    Route::get('/medico/citas/agregar', [MedicoController::class, 'crearCita'])->name('citas.agregar');
    Route::post('/medico/citas/agregarCita', [MedicoController::class, 'storeCitas'])->name('citas.store');
    Route::patch('/citas/{id}/update', [MedicoController::class, 'updateCita'])->name('citas.update');
    Route::get('/configurar-horario', [MedicoController::class, 'configurarHorario'])->name('citas.configurarHorario');
    Route::post('/guardar-horario', [MedicoController::class, 'storeHorario'])->name('horarios.store');
    Route::get('/horas-disponibles', [MedicoController::class, 'obtenerHorasDisponibles']);
    Route::post('/horarios/store', [MedicoController::class, 'storeHorario'])->name('horarios.store');
    Route::delete('/horarios/destroy/{id}', [MedicoController::class, 'destroyHorario'])->name('horarios.destroy');
    Route::patch('/horarios/update/{id}', [MedicoController::class, 'updateHorario'])->name('horarios.update');
    
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
    Route::get('/consultations/navigate', [ConsultaController::class, 'navigate'])->name('consultations.navigate');
    Route::post('/consultas/{id}/iniciar', [ConsultaController::class, 'iniciarConsulta'])->name('consultas.iniciar');

    // Rutas de Usuarios
    Route::post('/personas/storeDesdeModal', [PersonaController::class, 'storeDesdeModal'])->name('personas.storeDesdeModal');
    Route::get('/personas/create', [PersonaController::class, 'create'])->name('personas.create');
    Route::get('/consultas/verificarPaciente/{citaId}', [ConsultaController::class, 'verificarPaciente'])->name('consultas.verificarPaciente');
    Route::get('/pacientes/completar-registro/{citaId}', [MedicoController::class, 'completarRegistroPaciente'])->name('pacientes.completarRegistro');
    Route::post('/users/{id}/reset-password', [AsignarController::class, 'resetPassword'])->name('users.resetPassword');

});

<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecretariaController;
use Illuminate\Support\Facades\Route;

// Ruta de la página de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Incluir las rutas de autenticación generadas por Laravel Breeze
require __DIR__.'/auth.php';

// Agrupación de rutas que requieren autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
    // Rutas del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Pacientes
    Route::post('/pacientes/agregarPaciente', [SecretariaController::class, 'storePacientes'])->name('registrarPaciente.store');
    Route::get('/agregarPaciente', function () {
        return view('secretaria.pacientes.agregarPaciente');
    })->name('agregarPaciente');
    Route::get('/secretaria/dashboardSecretaria', [SecretariaController::class, 'mostrarPacientes'])->name('dashboardSecretaria');
    Route::get('/secretaria/pacientes/editar/{id}', [SecretariaController::class, 'editarPaciente'])->name('pacientes.editar');
    Route::patch('/secretaria/pacientes/editar/{id}', [SecretariaController::class, 'updatePaciente'])->name('pacientes.update');
    Route::delete('/secretaria/pacientes/eliminar/{id}', [SecretariaController::class, 'eliminarPaciente'])->name('pacientes.eliminar');

    // Rutas de Productos
    Route::get('/secretaria/productos/agregar', [SecretariaController::class, 'crearProducto'])->name('productos.agregar');
    Route::post('/secretaria/productos/agregarProducto', [SecretariaController::class, 'storeProductos'])->name('productos.store');
    Route::get('/secretaria/productos/editar/{id}', [SecretariaController::class, 'editarProducto'])->name('productos.editar');
    Route::patch('/secretaria/productos/editar/{id}', [SecretariaController::class, 'updateProducto'])->name('productos.update');
    Route::delete('/secretaria/productos/eliminar/{id}', [SecretariaController::class, 'eliminarProducto'])->name('productos.eliminar');
    Route::get('/secretaria/productos', [SecretariaController::class, 'mostrarProductos'])->name('productos');

    // Rutas de Citas
    Route::get('/secretaria/citas', [SecretariaController::class, 'mostrarCitas'])->name('citas');
    Route::post('/secretaria/citas/agregarCita', [SecretariaController::class, 'storeCitas'])->name('citas.store');
    Route::get('/secretaria/citas/agregar', [SecretariaController::class, 'crearCita'])->name('citas.agregar');
    Route::get('/secretaria/citas/editar/{id}', [SecretariaController::class, 'editarCita'])->name('citas.editar');
    Route::patch('/secretaria/citas/editar/{id}', [SecretariaController::class, 'updateCita'])->name('citas.update');
    Route::delete('/secretaria/citas/eliminar/{id}', [SecretariaController::class, 'eliminarCita'])->name('citas.eliminar');
    Route::post('/horas-disponibles', [SecretariaController::class, 'horasDisponibles'])->name('horas.disponibles');

    // Rutas de Médicos
    Route::get('/secretaria/medicos', [SecretariaController::class, 'mostrarMedicos'])->name('medicos');
    Route::post('/secretaria/medicos/agregarMedico', [SecretariaController::class, 'storeMedicos'])->name('medicos.store');
    Route::get('/secretaria/medicos/agregar', [SecretariaController::class, 'crearMedico'])->name('medicos.agregar');
    Route::get('/secretaria/medicos/editar/{id}', [SecretariaController::class, 'editarMedico'])->name('medicos.editar');
    Route::patch('/secretaria/medicos/editar/{id}', [SecretariaController::class, 'updateMedico'])->name('medicos.update');
    Route::delete('/secretaria/medicos/eliminar/{id}', [SecretariaController::class, 'eliminarMedico'])->name('medicos.eliminar');

    // Rutas de Servicios
    Route::get('/secretaria/servicios', [SecretariaController::class, 'mostrarServicios'])->name('servicios');
    Route::post('/secretaria/servicios/agregarServicio', [SecretariaController::class, 'storeServicios'])->name('servicios.store');
    Route::get('/secretaria/servicios/agregar', [SecretariaController::class, 'crearServicio'])->name('servicios.agregar');
    Route::get('/secretaria/servicios/editar/{id}', [SecretariaController::class, 'editarServicio'])->name('servicios.editar');
    Route::patch('/secretaria/servicios/editar/{id}', [SecretariaController::class, 'updateServicio'])->name('servicios.update');
    Route::delete('/secretaria/servicios/eliminar/{id}', [SecretariaController::class, 'eliminarServicio'])->name('servicios.eliminar');
});

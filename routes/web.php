<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\ActualizarConsultaSinCitaController;
use App\Http\Controllers\DocumentoController;

// Ruta de la página de bienvenida
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/error-database', [ErrorController::class, 'databaseError'])->name('error.database');

// Incluir las rutas de autenticación generadas por Laravel Breeze
require __DIR__.'/auth.php';

// Agrupación de rutas que requieren autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
    // Ruta del dashboard
    Route::get('/dashboard', function () {
        return view('medico.dashboard'); // Apunta a la vista en resources/views/medico/dashboard.blade.php
    })->name('dashboard');

    // Ruta para la vista de inicio
    Route::get('/inicio', function () {
        return view('vistaInicio');
    })->name('vistaInicio');

    // Rutas del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::patch('/profile/consultorio', [ProfileController::class, 'updateConsultorio'])->name('profile.updateConsultorio');

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
    Route::get('/medico/pacientes/editar/{no_exp}', [MedicoController::class, 'editarPaciente'])->name('pacientes.editar');
    Route::patch('/pacientes/{no_exp}', [MedicoController::class, 'updatePaciente'])->name('pacientes.update');
    Route::delete('/pacientes/{no_exp}/eliminar', [MedicoController::class, 'eliminarPaciente'])->name('pacientes.eliminar');
    Route::get('/medico/pacientes', [MedicoController::class, 'mostrarPacientes'])->name('pacientes.index');
    Route::post('/pacientes/storeDesdeModal', [MedicoController::class, 'storePacientesDesdeModal'])->name('pacientes.storeDesdeModal');
    Route::get('/pacientes/create', [MedicoController::class, 'create'])->name('pacientes.create');
    Route::get('/pacientes/{id}', [MedicoController::class, 'showPaciente'])->name('pacientes.show');
    Route::get('/medico/pacientes/{id}/editarPaciente', [MedicoController::class, 'editarPaciente'])->name('medico.pacientes.editarPaciente');
    Route::get('/medico/pacientes/pdf', [MedicoController::class, 'generatePatientListPdf'])->name('pacientes.pdf');
    Route::get('/dashboard', [MedicoController::class, 'mostrarPacientes'])->name('dashboard');
    Route::delete('/horarios/{id}', [MedicoController::class, 'destroyHorario'])->name('horarios.destroy');

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
    Route::post('/horarios/store', [MedicoController::class, 'storeHorario'])->name('horarios.store');
    Route::delete('/horarios/destroy/{id}', [MedicoController::class, 'destroyHorario'])->name('horarios.destroy');
    Route::patch('/horarios/update/{id}', [MedicoController::class, 'updateHorario'])->name('horarios.update');
    route::get('/obtener-horarios-por-dia', [MedicoController::class, 'obtenerHorariosPorDia']);
    route::get('/obtener-horas-ocupadas', [MedicoController::class, 'obtenerHorasOcupadas']);
    route::patch('/citas/{id}', [MedicoController::class, 'updateCita'])->name('citas.update');

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
    Route::post('/recetas/store', [ConsultaController::class, 'storeReceta'])->name('recetas.store');
    Route::post('/medico/storeDesdeModal', [MedicoController::class, 'storeDesdeModal'])->name('medico.storeDesdeModal');
    Route::get('/search-pacientes', [MedicoController::class, 'searchPacientes'])->name('pacientes.search');
    route::post('/consultas/navigate', [ConsultaController::class, 'navigate'])->name('consultas.navigate');    

    Route::get(
        '/consultas/{id}/detalles/{pacienteId}/{medicoId}',
        [ConsultaController::class, 'getConsultaDetails']
    )->name('consultas.getConsultaDetails');
    
    Route::get(
        '/consultas/{id}/{no_exp}/{medico_id}',
        [ConsultaController::class, 'show']
    )->name('consultas.show');
    

    Route::get('/consultas/{id}/{pacienteId}/{medicoId}', [ConsultaController::class, 'getConsultaDetails']);
    Route::get('/consultas/{pacienteId}/{medicoId}/{consultaId}/editar', [ActualizarConsultaSinCitaController::class, 'editWithoutCita'])
    ->name('consultas.editWithoutCita');
    Route::put('consultas/{pacienteId}/{medicoId}/{consultaId}/actualizar', [ActualizarConsultaSinCitaController::class, 'updateWithoutCita'])->name('consultas.updateWithoutCita');

    // Rutas de Usuarios
    Route::get('/consultas/verificarPaciente/{citaId}', [ConsultaController::class, 'verificarPaciente'])->name('consultas.verificarPaciente');
    Route::get('/pacientes/completar-registro/{citaId}', [MedicoController::class, 'completarRegistroPaciente'])->name('pacientes.completarRegistro');
    Route::post('/users/{id}/reset-password', [AsignarController::class, 'resetPassword'])->name('users.resetPassword');
    route::get('/consultas/{id}/{no_exp}/{medico_id}', [ConsultaController::class, 'show'])->name('consultas.show');

    // Rutas para ventas (ya existente)
    Route::get('ventas/generate/{consulta}', [ConsultaController::class, 'generateVenta'])->name('ventas.generate');
    Route::post('ventas/store/{venta}', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::resource('ventas', VentaController::class);
    Route::post('/ventas/agregar/{producto}', [VentaController::class, 'agregar'])->name('ventas.agregar');
    Route::get('ventas/{id}/generate-invoice', [VentaController::class, 'generateInvoice'])->name('ventas.generateInvoice');
    Route::post('/ventas/{id}/pagar', [VentaController::class, 'pagar'])->name('ventas.pagar');
    route::get('ventas/pagar/{id}', [VentaController::class, 'marcarComoPagado'])->name('ventas.marcarComoPagado');
    Route::post('ventas/actualizar/{id}', [VentaController::class, 'actualizarVenta'])->name('ventas.actualizarVenta');  
    route::put('/ventas/{id}/actualizar', [VentaController::class, 'actualizarVenta'])->name('ventas.actualizar');
    
    Route::resource('conceptos', ConceptoController::class);
    Route::get('/medico/catalogos/conceptos/pdf', [ConceptoController::class, 'generateReport'])->name('conceptos.pdf');
    Route::resource('conceptos', ConceptoController::class);

    Route::resource('colonias', ColoniaController::class);
    route::get('/colonias/create', [ColoniaController::class, 'create'])->name('colonias.create');
    route::get('/api/municipios/{id_entidad}', [ColoniaController::class, 'getMunicipiosByEntidad']);
    route::get('/api/colonias/{id}', [ColoniaController::class, 'getColoniasByMunicipio']);
    route::get('/api/municipios/{entidad}', [ColoniaController::class, 'getMunicipiosByEntidad']);
    route::delete('/colonias/{id_asentamiento}/{id_entidad}/{id_municipio}', [ColoniaController::class, 'destroy'])->name('colonias.destroy');
    route::get('/colonias/{id_asentamiento}/{id_entidad}/{id_municipio}/edit', [ColoniaController::class, 'edit'])->name('colonias.edit');   
    route::put('/colonias/{id_asentamiento}/{id_entidad}/{id_municipio}', [ColoniaController::class, 'update'])->name('colonias.update');
        /// nuevo vv
    Route::get('/medico/ventas/pdf', [VentaController::class, 'generateVentasPdf'])->name('ventas.pdf');

    route::get('/get-municipios/{id}', [MedicoController::class, 'getMunicipios']);
    Route::get('/get-localidades/{id}', [MedicoController::class, 'getLocalidades']);
    route::get('/get-colonias/{id}', [MedicoController::class, 'getColonias']);

    // Rutas de ProfileController para manejo de entidades, municipios, localidades y colonias
    Route::get('/get-municipios/{entidad_id}', [ProfileController::class, 'getMunicipios']);
    Route::get('/get-localidades/{municipio_id}', [ProfileController::class, 'getLocalidades']);
    Route::get('/get-colonias/{municipio_id}', [ProfileController::class, 'getColonias']);

    Route::get('/medico/catalogos/configuracion/configSistema', [MedicoController::class, 'mostrarConfiguracion'])->name('configuracion.mostrar');
    Route::post('/medico/catalogos/configuracion/guardar', [MedicoController::class, 'guardarConfiguracion'])->name('configuracion.guardar');

    // Rutas de DocumentoController
    Route::get('/pacientes/{pacienteId}/pdf-pasaporte', [DocumentoController::class, 'generarPasaportePDF'])
     ->name('documentos.pasaporte');
     // routes/web.php
    Route::post('/documentos/pasaporte-preview/{pacienteId}', [DocumentoController::class, 'generarPasaportePreview'])
    ->name('documentos.pasaporte.preview');

    Route::post('/documento/generar-pasaporte', [DocumentoController::class, 'generarPasaporteDesdeFormulario'])
        ->name('documento.generarPasaporteDesdeFormulario');

    Route::post('/documento/generar-factura', [DocumentoController::class, 'generarFacturaDesdeFormulario'])
    ->name('ruta.generarFacturaDesdeFormulario');


});

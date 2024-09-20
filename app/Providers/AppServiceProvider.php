<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ConsultaController;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Establecer el idioma de Carbon a español
        Carbon::setLocale('es');

        // View Composer para incluir consultasPendientes en navigationAdmin
        View::composer('layouts.navigationAdmin', function ($view) {
            $consultasPendientes = (new ConsultaController)->consultasPendientesHoy();
            $view->with('consultasPendientes', $consultasPendientes);
        });     
        
        View::composer('*', function ($view) {
            // Verificar si el usuario está autenticado
            if (Auth::check()) {
                // Obtener el ID del usuario autenticado
                $currentUser = Auth::user();
        
                // Filtrar las ventas pendientes basadas en el ID del médico desde la tabla de consultas
                $ventasPorPagar = Venta::whereHas('consulta', function($query) use ($currentUser) {
                    $query->where('usuariomedicoid', $currentUser->id);
                })->where('status', 'Por pagar')->count();
                
                // Compartir las ventas pendientes con la vista
                $view->with('ventasPorPagar', $ventasPorPagar);
            } else {
                // Si no está autenticado, compartir 0 ventas pendientes
                $view->with('ventasPorPagar', 0);
            }
        });
        
    }
}

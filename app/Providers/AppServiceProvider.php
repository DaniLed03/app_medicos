<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ConsultaController;
use App\Models\Venta;
use Carbon\Carbon;

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
        
        // Compartir el número de ventas "Por pagar" con todas las vistas
        View::composer('*', function ($view) {
            $ventasPorPagar = Venta::where('status', 'Por pagar')->count();
            $view->with('ventasPorPagar', $ventasPorPagar);
        });
    }
}

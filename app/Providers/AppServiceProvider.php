<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\ConsultaController;

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
        // View Composer para incluir consultasPendientes en navigationAdmin
        View::composer('layouts.navigationAdmin', function ($view) {
            $consultasPendientes = (new ConsultaController)->consultasPendientesHoy();
            $view->with('consultasPendientes', $consultasPendientes);
        });        
    }
}

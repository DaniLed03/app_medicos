<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Muestra la vista de error de base de datos.
     *
     * @return \Illuminate\View\View
     */
    public function databaseError()
    {
        return view('errors.database-error');
    }
}

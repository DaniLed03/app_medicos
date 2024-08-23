<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index()
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Redirige al Dashboard si la sesión está activa
            return redirect()->route('dashboard');
        }

        // Si no hay sesión activa, muestra la vista de bienvenida
        return view('welcome');
    }
}

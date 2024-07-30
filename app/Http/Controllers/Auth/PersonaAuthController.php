<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;

class PersonaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.loginPersona');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar la persona por el correo
        $persona = Persona::where('correo', $request->correo)->first();

        // Verificar que la persona exista y que la contraseña coincida
        if ($persona) {
            logger()->info('Persona encontrada:', ['correo' => $request->correo]);
            if (Hash::check($request->password, $persona->password)) {
                logger()->info('Contraseña correcta para:', ['correo' => $request->correo]);
                // Autenticar la persona
                Auth::guard('personas')->login($persona, $request->remember);
                return redirect()->intended(route('personas.citas'));
            } else {
                logger()->warning('Contraseña incorrecta para:', ['correo' => $request->correo]);
            }
        } else {
            logger()->warning('Persona no encontrada para el correo:', ['correo' => $request->correo]);
        }

        // Autenticación fallida
        return back()->withErrors([
            'correo' => 'Estas credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('personas')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

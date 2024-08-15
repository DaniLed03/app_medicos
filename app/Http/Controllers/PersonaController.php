<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class PersonaController extends Controller
{
    public function showCitas()
    {
        return view('medico.Personas.citas');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        $persona = Persona::where('correo', $credentials['correo'])->first();

        if ($persona && Hash::check($credentials['password'], $persona->password)) {
            $request->session()->put('logged_in', true);
            $request->session()->put('persona_id', $persona->id);
            $request->session()->put('persona_name', $persona->nombres);

            return redirect()->route('personas.citas')->with('status', 'Inicio de sesión exitoso');
        }

        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('correo');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('persona.login')->with('status', 'Sesión cerrada exitosamente');
    }
}

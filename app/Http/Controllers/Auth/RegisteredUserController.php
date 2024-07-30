<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $medicos = User::role('medico')->get(); // Obtener los usuarios con el rol de médico
        return view('auth.register', compact('medicos'));
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:100'],
            'apepat' => ['required', 'string', 'max:100'],
            'apemat' => ['required', 'string', 'max:100'],
            'fechanac' => ['required', 'date'],
            'telefono' => ['required', 'string', 'max:20'],
            'sexo' => ['required', 'in:masculino,femenino'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:personas'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'curp' => ['required', 'string', 'max:18', 'unique:personas'],
            'medico_id' => ['required', 'exists:users,id'],
        ]);

        $persona = Persona::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'sexo' => $request->sexo,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'curp' => $request->curp,
            'medico_id' => $request->medico_id,
        ]);

        event(new Registered($persona));

        Auth::login($persona);

        return redirect(route('login'));
    }
}

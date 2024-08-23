<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

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

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }        

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->roles->isEmpty()) {
            Auth::logout();
            Alert::warning('¡Atención!', 'Esta cuenta aún no está activa. Habla con el administrador para activar tu cuenta.');
            return redirect()->route('login');
        }
        
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
        switch ($user->rol) {
            case 'medico':
                return redirect()->route('medico.dashboard');
            case 'secretaria':
                return redirect()->route('medico.dashboard');
            case 'enfermera':
                return redirect()->route('medico.dashboard');
            default:
                return redirect()->route('medico.dashboard');
        }
    }
}

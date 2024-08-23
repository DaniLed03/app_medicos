<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        try {
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                // Intenta almacenar el archivo con un nombre único
                $foto = $file->store('profiles', 'public');
                
                // Verifica si el archivo se almacenó correctamente
                if (!$foto) {
                    dd('Error al almacenar la imagen');
                }
                
                // Asigna la ruta del archivo al campo 'foto' del usuario
                $user->foto = $foto;
            }
        } catch (\Exception $e) {
            dd('Error: ' . $e->getMessage());
        }
        
        

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('La contraseña actual no es correcta.'),
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

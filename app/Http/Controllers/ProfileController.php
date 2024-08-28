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
use App\Models\EntidadFederativa;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\Colonia;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Obtener el consultorio con todas las relaciones necesarias
        $consultorio = $user->consultorio()->with(['entidadFederativa', 'municipio', 'localidad', 'colonia'])->first();

        // Cargar todas las entidades federativas
        $entidadesFederativas = EntidadFederativa::all();

        // Obtener el municipio, localidad y colonia asociados al consultorio si existen
        $municipios = $user->consultorio && $user->consultorio->entidad_federativa_id
            ? Municipio::where('entidad_federativa_id', $user->consultorio->entidad_federativa_id)->get()
            : collect([]);

        $localidades = $user->consultorio && $user->consultorio->municipio_id
            ? Localidad::where('id_municipio', $user->consultorio->municipio_id)
                    ->where('id_entidad_federativa', $user->consultorio->entidad_federativa_id)
                    ->get()
            : collect([]);

        $colonias = $user->consultorio && $user->consultorio->municipio_id
            ? Colonia::where('id_municipio', $user->consultorio->municipio_id)
                    ->where('id_entidad', $user->consultorio->entidad_federativa_id)
                    ->get()
            : collect([]);
            
        return view('profile.edit', [
            'user' => $user,
            'consultorio' => $consultorio, // Pasa el consultorio con las relaciones a la vista
            'entidadesFederativas' => $entidadesFederativas,
            'municipios' => $municipios,
            'localidades' => $localidades,
            'colonias' => $colonias,
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

    /**
     * Update the consultorio information.
     */
    public function updateConsultorio(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Actualización o creación de la información del consultorio
        $consultorioData = $request->only([
            'nombre', 
            'entidad_federativa_id', 
            'municipio_id', 
            'localidad_id', 
            'calle', 
            'colonia_id', 
            'telefono', 
            'cedula_profesional', 
            'especialidad', 
            'facultad_medicina'
        ]);

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $consultorioData['logo'] = $file->store('logos', 'public');
        }

        // Aquí se actualiza o crea el registro del consultorio
        $user->consultorio()->updateOrCreate(['user_id' => $user->id], $consultorioData);

        return Redirect::route('profile.edit')->with('status', 'consultorio-updated');
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

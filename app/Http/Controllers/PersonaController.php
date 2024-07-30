<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;

class PersonaController extends Controller
{
    public function showCitas()
    {
        return view('Personas.citas');
    }

    // Método para guardar una nueva persona desde el modal
    public function storeDesdeModal(Request $request)
    {
        $medicoId = Auth::id();

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombres' => 'required|string|max:100',
            'apepat' => 'required|string|max:100',
            'apemat' => 'required|string|max:100',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'sexo' => 'required|in:masculino,femenino',
            'correo' => 'required|string|email|max:255|unique:personas',
            'curp' => 'required|string|max:18|unique:personas',
            'password' => 'nullable|string|min:8', // Hacer opcional
        ]);

        // Agregar el campo 'medico_id'
        $validatedData['medico_id'] = $medicoId;

        // Si no se proporciona una contraseña, no se debe hash el valor
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        }

        // Crear la nueva persona
        $persona = Persona::create($validatedData);

        return redirect()->route('citas')->with('status', 'Persona agregada exitosamente')->with('persona_id', $persona->id);
    }


}

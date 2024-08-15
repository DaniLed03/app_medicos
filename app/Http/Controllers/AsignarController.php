<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AsignarController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');
        $currentUserId = Auth::id(); // Obtén el ID del usuario autenticado

        if ($userRoles->contains('Medico')) {
            $users = User::where('medico_id', $currentUserId)->with('roles')->get();
        } else {
            $users = User::with('roles')->get();
        }

        $totalUsers = $users->count();

        // Calcular porcentajes
        $maleUsers = $users->where('sexo', 'masculino')->count();
        $femaleUsers = $users->where('sexo', 'femenino')->count();
        $porcentajeMujeres = $totalUsers > 0 ? ($femaleUsers / $totalUsers) * 100 : 0;
        $porcentajeHombres = $totalUsers > 0 ? ($maleUsers / $totalUsers) * 100 : 0;

        return view('medico.Usuarios.ListadoUser', compact('users', 'totalUsers', 'porcentajeMujeres', 'porcentajeHombres'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apepat' => 'required|string|max:255',
            'apemat' => 'required|string|max:255',
            'fechanac' => 'required|date',
            'telefono' => 'required|string|max:20',
            'sexo' => 'required|in:masculino,femenino',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $defaultPassword = 'ContraseñaPrueba'; // Define aquí la contraseña por defecto
        $currentUser = Auth::user(); // Obtener el usuario autenticado
        $userRoles = $currentUser->roles->pluck('name'); // Obtener los roles del usuario autenticado

        // Asignar el `medico_id` solo si el usuario autenticado no es administrador
        $medicoId = $userRoles->contains('Administrador') ? null : $currentUser->id;

        $user = User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'password' => Hash::make($defaultPassword),
            'activo' => 'si', // Establecer el estado como activo
            'medico_id' => $medicoId, // Asigna el ID del médico si no es administrador
        ]);

        // Asignar el rol por defecto o roles al usuario
        $role = Role::where('name', 'default_role_name')->first();
        if ($role) {
            $user->assignRole($role);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        if ($userRoles->contains('Medico')) {
            // Excluir los roles 'Administrador' y 'Medico' si el usuario autenticado es 'Medico'
            $roles = Role::whereNotIn('name', ['Administrador', 'Medico'])->get();
        } else {
            // Mostrar todos los roles para otros usuarios
            $roles = Role::all();
        }

        return view('medico.Usuarios.userRol', compact('user', 'roles'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->sync($request->roles);
        return redirect()->route('users.index')->with('success', 'Roles asignados con éxito.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        $defaultPassword = 'ContraseñaPrueba'; // Define aquí la contraseña por defecto que quieres asignar
        $user->password = Hash::make($defaultPassword);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Contraseña restablecida con éxito.');
    }

}

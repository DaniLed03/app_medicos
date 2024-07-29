<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AsignarController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $totalUsers = $users->count();

        // Calculate the percentages of male and female users
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
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nombres' => $request->nombres,
            'apepat' => $request->apepat,
            'apemat' => $request->apemat,
            'fechanac' => $request->fechanac,
            'telefono' => $request->telefono,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activo' => 'si', // Set status to active
        ]);

        // Assign default role or roles to the user
        $role = Role::where('name', 'default_role_name')->first();
        if ($role) {
            $user->assignRole($role);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
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

}

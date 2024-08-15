<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        // Verificar si el usuario tiene el rol de Administrador
        if (!$userRoles->contains('Administrador')) {
            return redirect()->route('dashboard')->with('error', 'No cuentas con los permisos para acceder a esta sección.');
        }

        $permissions = Permission::all();
        return view('medico.Usuarios.permisos', compact('permissions'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        // Verificar si el usuario tiene el rol de Administrador
        if (!$userRoles->contains('Administrador')) {
            return redirect()->route('dashboard')->with('error', 'No cuentas con los permisos para realizar esta acción.');
        }

        $request->validate(['name' => 'required']);
        Permission::create($request->only('name'));
        return redirect()->route('permisos.index')->with('success', 'Permiso creado con éxito.');
    }

    public function destroy(Permission $permission)
    {
        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        // Verificar si el usuario tiene el rol de Administrador
        if (!$userRoles->contains('Administrador')) {
            return redirect()->route('dashboard')->with('error', 'No cuentas con los permisos para realizar esta acción.');
        }

        $permission->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado con éxito.');
    }
}

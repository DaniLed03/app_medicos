<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('medico.Usuarios.permisos', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Permission::create($request->only('name'));
        return redirect()->route('permisos.index')->with('success', 'Permiso creado con éxito.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado con éxito.');
    }
}

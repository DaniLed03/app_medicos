<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Vista Roles')->only('index');
        $this->middleware('can:Vista Roles')->only('store');
        $this->middleware('can:Vista Roles')->only(['edit', 'update']);
        $this->middleware('can:Vista Roles')->only('destroy');
    }

    public function index()
    {
        $roles = Role::all();
        return view('medico.Usuarios.roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Role::create($request->only('name'));
        return redirect()->route('roles.index')->with('success', 'Rol creado con éxito.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado con éxito.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('medico.Usuarios.rolePermission', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'array'
        ]);

        $role->update($request->only('name'));

        // Sync permissions
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.edit', $role)->with('success', 'Rol actualizado con éxito.');
    }
}

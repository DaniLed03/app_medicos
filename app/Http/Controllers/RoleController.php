<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

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
        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        if (!$userRoles->contains('Administrador')) {
            // Si no es Administrador, excluir los roles 'Administrador' y 'Medico'
            $roles = Role::whereNotIn('name', ['Administrador', 'Medico'])->get();
        } else {
            $roles = Role::all();
        }

        return view('medico.Usuarios.roles', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);

        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        if (!$userRoles->contains('Administrador') && in_array($request->name, ['Administrador', 'Medico'])) {
            return redirect()->route('roles.index')->with('error', 'No tienes permiso para crear este rol.');
        }

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
        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        if ($userRoles->contains('Administrador')) {
            // Si es Administrador, mostrar todos los permisos
            $permissions = Permission::all();
        } else {
            // Si no es Administrador, excluir el permiso 'Vista Permisos'
            $permissions = Permission::where('name', '!=', 'Vista Permisos')->get();
        }

        return view('medico.Usuarios.rolePermission', compact('role', 'permissions'));
    }



    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'array'
        ]);

        $currentUser = Auth::user();
        $userRoles = $currentUser->roles->pluck('name');

        if (!$userRoles->contains('Administrador') && in_array($role->name, ['Administrador', 'Medico'])) {
            return redirect()->route('roles.index')->with('error', 'No tienes permiso para actualizar este rol.');
        }

        $role->update($request->only('name'));

        // Sync permissions
        $role->permissions()->sync($request->permissions);

        return redirect()->route('roles.edit', $role)->with('success', 'Rol actualizado con éxito.');
    }

}

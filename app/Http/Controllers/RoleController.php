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

        // Verificar si el usuario tiene permiso para actualizar este rol
        if (!$userRoles->contains('Administrador') && in_array($role->name, ['Administrador', 'Medico'])) {
            return redirect()->route('roles.index')->with('error', 'No tienes permiso para actualizar este rol.');
        }

        // Actualizar el nombre del rol
        $role->update($request->only('name'));

        // Recuperar los permisos seleccionados en la página actual
        $selectedPermissions = $request->permissions ?? [];

        // Obtener todos los permisos actuales del rol
        $existingPermissions = $role->permissions->pluck('id')->toArray();

        // Diferenciar entre los permisos seleccionados (visibles) y los no visibles
        $toDetach = array_diff($existingPermissions, $selectedPermissions);

        // Desactivar solo los permisos visibles que fueron deseleccionados
        if (!empty($toDetach)) {
            $role->permissions()->detach($toDetach);
        }

        // Sincronizar los permisos seleccionados sin eliminar los ya asignados
        $role->permissions()->syncWithoutDetaching($selectedPermissions);

        return redirect()->route('roles.edit', $role)->with('success', 'Rol actualizado con éxito.');
    }
}

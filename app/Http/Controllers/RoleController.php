<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Muestra la lista de roles.
     */
    public function index()
    {
        $roles = Role::all();
        return Inertia::render('Roles/Index', [
            'roles' => $roles
        ]);
    }

    /**
     * Almacena un nuevo rol.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
        ]);

        Role::create($request->all());

        return redirect()->back()->with('message', 'Rol creado con éxito');
    }

    /**
     * Actualiza un rol existente.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'guard_name' => 'required|string|max:255',
        ]);

        $role->update($request->all());

        return redirect()->back()->with('message', 'Rol actualizado');
    }

    /**
     * Elimina un rol.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('message', 'Rol eliminado');
    }
}
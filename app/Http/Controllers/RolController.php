<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RolController extends Controller
{
    public function index()
    {
        return Inertia::render('Roles/Index', [
            'roles' => Rol::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50|unique:ROL,nombre'
        ]);

        Rol::create($data);

        return Redirect::route('roles.index');
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        
        $data = $request->validate([
            'nombre' => 'required|string|max:50|unique:ROL,nombre,' . $id . ',id_rol'
        ]);

        $rol->update($data);

        return Redirect::route('roles.index');
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        
        // Evitar eliminar roles básicos del sistema si existen
        $rol->delete();
        return Redirect::route('roles.index');
    }
}
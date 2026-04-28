<?php

namespace App\Http\Controllers;

use App\Models\TipoMantenimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TipoMantenimientoController extends Controller
{
    public function index()
    {
        return Inertia::render('TiposMantenimiento/Index', [
            'tipos' => TipoMantenimiento::orderBy('id_tipo_mant', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100|unique:TIPO_MANTENIMIENTO,nombre',
            'descripcion' => 'nullable|string|max:200',
        ]);

        TipoMantenimiento::create($data);

        return Redirect::route('tipos-mantenimiento.index');
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoMantenimiento::findOrFail($id);
        
        $data = $request->validate([
            'nombre'      => 'required|string|max:100|unique:TIPO_MANTENIMIENTO,nombre,' . $id . ',id_tipo_mant',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $tipo->update($data);

        return Redirect::route('tipos-mantenimiento.index');
    }

    public function destroy($id)
    {
        $tipo = TipoMantenimiento::findOrFail($id);

        // Validar si existen mantenimientos registrados con este tipo
        if ($tipo->mantenimientos()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar el tipo porque existen registros vinculados a buses.']);
        }

        $tipo->delete();
        return Redirect::route('tipos-mantenimiento.index');
    }
}
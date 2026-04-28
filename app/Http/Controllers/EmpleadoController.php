<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EmpleadoController extends Controller
{
    public function index()
    {
        return Inertia::render('Empleados/Index', [
            'empleados' => Empleado::latest('id_empleado')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'licencia' => 'nullable|string|max:50',
            'rol'      => 'required|in:EMPLEADO,CONDUCTOR',
            'estado'   => 'required|string'
        ]);

        Empleado::create($data);

        return Redirect::route('empleados.index');
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $data = $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'licencia' => 'nullable|string|max:50',
            'rol'      => 'required|in:EMPLEADO,CONDUCTOR',
            'estado'   => 'required|string'
        ]);

        $empleado->update($data);

        return Redirect::route('empleados.index');
    }

    public function destroy($id)
    {
        // Nota: En un sistema real, podrías verificar si tiene viajes pendientes antes de eliminar
        Empleado::findOrFail($id)->delete();
        return Redirect::route('empleados.index');
    }
}

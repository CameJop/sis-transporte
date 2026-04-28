<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Viaje;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AsignacionController extends Controller
{
    public function index()
    {
        return Inertia::render('Asignaciones/Index', [
            'asignaciones' => Asignacion::with(['viaje.ruta.origen', 'viaje.ruta.destino', 'empleado'])
                ->orderBy('id_asignacion', 'desc')
                ->get(),
            'viajes' => Viaje::with(['ruta.origen', 'ruta.destino'])->get(),
            'empleados' => Empleado::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_viaje' => 'required|exists:VIAJE,id_viaje',
            'id_empleado' => 'required|exists:EMPLEADO,id_empleado',
            'fecha_asignacion' => 'required|date'
        ]);

        $existe = Asignacion::where('id_viaje', $request->id_viaje)
                            ->where('id_empleado', $request->id_empleado)
                            ->exists();

        if ($existe) {
            return back()->withErrors(['error' => 'Este empleado ya está asignado a este viaje.']);
        }

        Asignacion::create($request->all());

        return Redirect::route('asignaciones.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_viaje' => 'required|exists:VIAJE,id_viaje',
            'id_empleado' => 'required|exists:EMPLEADO,id_empleado',
            'fecha_asignacion' => 'required|date'
        ]);

        $asignacion = Asignacion::findOrFail($id);
        $asignacion->update($request->all());

        return Redirect::route('asignaciones.index');
    }

    public function destroy($id)
    {
        $asignacion = Asignacion::findOrFail($id);

        if ($asignacion->viaje->fecha_salida < now()->toDateString()) {
            return back()->withErrors(['error' => 'No se puede eliminar una asignación de un viaje que ya ha concluido.']);
        }

        $asignacion->delete();
        return Redirect::route('asignaciones.index');
    }
}
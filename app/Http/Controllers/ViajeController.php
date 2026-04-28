<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Ruta;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ViajeController extends Controller
{
    /**
     * Listado de viajes programados
     */
    public function index()
    {
        return inertia('Viajes/Index', [
            // Cargamos relaciones anidadas: viaje -> ruta -> terminales
            'viajes' => Viaje::with(['ruta.origen', 'ruta.destino', 'bus'])
                        ->latest('id_viaje')
                        ->get(),
            'rutas'  => Ruta::with(['origen', 'destino'])->get(),
            'buses'  => Bus::where('estado', 'ACTIVO')->get()
        ]);
    }

    /**
     * Crear un nuevo viaje
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_ruta'      => 'required|exists:RUTA,id_ruta',
            'id_bus'        => 'required|exists:BUS,id_bus',
            'fecha_salida'  => 'required|date|after_or_equal:today',
            'hora_salida'   => 'required',
            'estado'        => 'required|string|in:PROGRAMADO,EN_CURSO,FINALIZADO',
        ]);

        Viaje::create($data);

        return Redirect::route('viajes.index');
    }

    /**
     * Actualizar estado o datos del viaje
     */
    public function update(Request $request, $id)
    {
        $viaje = Viaje::findOrFail($id);

        $data = $request->validate([
            'id_ruta'      => 'required',
            'id_bus'        => 'required',
            'fecha_salida'  => 'required|date',
            'hora_salida'   => 'required',
            'estado'        => 'required',
        ]);

        $viaje->update($data);

        return Redirect::route('viajes.index');
    }

    /**
     * Eliminar un viaje (si no tiene boletos vendidos)
     */
    public function destroy($id)
    {
        $viaje = Viaje::findOrFail($id);
        
        // Opcional: Validar que no tenga boletos antes de borrar
        // if($viaje->boletos()->exists()) { ... error ... }

        $viaje->delete();

        return Redirect::route('viajes.index');
    }
}
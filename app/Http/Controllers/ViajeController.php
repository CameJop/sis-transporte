<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use App\Models\Viaje;
use App\Models\Itinerario; // <-- Agregamos el nuevo modelo de Itinerarios
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ViajeController extends Controller
{
    public function index()
    {
        // 1. Cargamos los viajes con la nueva estructura relacional anidada
        $viajesMapped = Viaje::with(['itinerario.ruta.origen', 'itinerario.ruta.destino', 'bus'])
            ->orderBy('id_viaje', 'desc')
            ->get()
            ->map(function ($viaje) {
                // Inyectamos de manera dinámica 'ruta' y 'hora_salida' en la raíz de cada viaje
                // para mantener la compatibilidad perfecta con las columnas de tu DataTable en Vue
                $viaje->ruta = $viaje->itinerario->ruta ?? null;
                $viaje->hora_salida = $viaje->itinerario->hora_salida ?? null;
                return $viaje;
            });

        return Inertia::render('Viajes/Index', [
            'viajes' => $viajesMapped,

            // CAMBIO: Ahora enviamos los Itinerarios Fijos con sus respectivas rutas para armar el Dropdown
            'itinerarios' => Itinerario::with(['ruta.origen', 'ruta.destino'])
                ->where('estado', 'ACTIVO') // Solo mostramos itinerarios vigentes
                ->get(),

            'buses' => Bus::where('estado', 'ACTIVO')->get(), // Solo buses listos para viajar
        ]);
    }

   

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_itinerario' => 'required|exists:ITINERARIO,id_itinerario',
            'fecha_salida'  => 'required|date',
            'estado'        => 'required|in:PROGRAMADO,EN_CURSO,FINALIZADO',

            // El bus se valida asegurando que no tenga otra salida programada 
            // para el mismo itinerario en esa misma fecha exacta.
            'id_bus' => [
                'required',
                'exists:BUS,id_bus',
                Rule::unique('VIAJE')->where(function ($query) use ($request) {
                    return $query->where('id_itinerario', $request->id_itinerario)
                        ->where('fecha_salida', $request->fecha_salida);
                })
            ],
        ], [
            'id_bus.unique' => 'Este bus ya se encuentra asignado a este itinerario para la fecha seleccionada.'
        ]);

        Viaje::create($data);

        return Redirect::route('viajes.index');
    }

    public function update(Request $request, $id)
    {
        $viaje = Viaje::findOrFail($id);

        $data = $request->validate([
            'id_itinerario' => 'required|exists:ITINERARIO,id_itinerario', // <-- Nueva llave foránea
            'id_bus'        => 'required|exists:BUS,id_bus',
            'fecha_salida'  => 'required|date',
            'estado'        => 'required|in:PROGRAMADO,EN_CURSO,FINALIZADO'
        ]);

        $viaje->update($data);

        return Redirect::route('viajes.index')->with('success', 'Salida actualizada correctamente.');
    }

    public function destroy($id)
    {
        Viaje::findOrFail($id)->delete();
        return Redirect::route('viajes.index')->with('success', 'Salida eliminada correctamente.');
    }
}

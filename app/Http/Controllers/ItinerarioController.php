<?php

namespace App\Http\Controllers;

use App\Models\Itinerario;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ItinerarioController extends Controller
{
    /**
     * Muestra la lista de itinerarios configurados.
     */
    public function index()
    {
        return Inertia::render('Itinerarios/Index', [
            // Cargamos los itinerarios con su ruta y terminales origen/destino
            'itinerarios' => Itinerario::with(['ruta.origen', 'ruta.destino'])
                ->orderBy('id_ruta')
                ->orderBy('hora_salida')
                ->get(),

            // Enviamos las rutas para poder enlazarlas en el formulario de creación/edición
            'rutas' => Ruta::with(['origen', 'destino'])->get(),
        ]);
    }

    /**
     * Registra un nuevo horario fijo en el sistema.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_ruta'     => 'required|exists:RUTA,id_ruta',
            'hora_salida' => 'required', // Valida formato HH:MM o HH:MM:SS
            'dia_semana'  => 'required|string|max:20',
            'estado'      => 'required|in:ACTIVO,INACTIVO'
        ]);

        Itinerario::create($data);

        return Redirect::route('itinerarios.index')->with('success', 'Horario permanente registrado con éxito.');
    }

    /**
     * Actualiza un itinerario existente.
     */
    public function update(Request $request, $id)
    {
        $itinerario = Itinerario::findOrFail($id);

        $data = $request->validate([
            'id_ruta'     => 'required|exists:RUTA,id_ruta',
            'hora_salida' => 'required',
            'dia_semana'  => 'required|string|max:20',
            'estado'      => 'required|in:ACTIVO,INACTIVO'
        ]);

        $itinerario->update($data);

        return Redirect::route('itinerarios.index')->with('success', 'Horario permanente actualizado con éxito.');
    }

    /**
     * Elimina un itinerario (o lo desactiva según tu lógica de negocio).
     */
    public function destroy($id)
    {
        $itinerario = Itinerario::findOrFail($id);

        try {
            $itinerario->delete();
            return Redirect::route('itinerarios.index')->with('success', 'Horario permanente eliminado.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Protección por si el itinerario ya está siendo usado por algún viaje programado
            return Redirect::route('itinerarios.index')->withErrors([
                'error' => 'No se puede eliminar este itinerario porque ya existen viajes asociados a este horario. Recomendamos cambiar su estado a INACTIVO.'
            ]);
        }
    }
}
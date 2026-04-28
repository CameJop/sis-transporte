<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RutaController extends Controller
{
    /**
     * Listado de rutas con sus terminales
     */
    public function index()
    {
        return inertia('Rutas/Index', [
            'rutas' => Ruta::with(['origen', 'destino'])->get(),
            'terminales' => Terminal::all(['id_terminal', 'nombre', 'ciudad'])
        ]);
    }

    /**
     * Registrar una nueva ruta
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_origen'         => 'required|exists:TERMINAL,id_terminal',
            'id_destino'        => 'required|exists:TERMINAL,id_terminal|different:id_origen',
            'distancia'         => 'nullable|numeric|min:0',
            'duracion_estimada' => 'nullable|numeric|min:0',
        ], [
            'id_destino.different' => 'El destino no puede ser igual al origen.'
        ]);

        Ruta::create($data);

        return Redirect::route('rutas.index');
    }

    /**
     * Actualizar datos de la ruta
     */
    public function update(Request $request, $id)
    {
        $ruta = Ruta::findOrFail($id);

        $data = $request->validate([
            'id_origen'         => 'required',
            'id_destino'        => 'required|different:id_origen',
            'distancia'         => 'required|numeric',
            'duracion_estimada' => 'required|numeric',
        ]);

        $ruta->update($data);

        return Redirect::route('rutas.index');
    }

    /**
     * Eliminar una ruta
     */
    public function destroy($id)
    {
        $ruta = Ruta::findOrFail($id);
        
        // Verifica si la ruta ya está siendo usada en viajes antes de borrar
        if($ruta->viajes()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar una ruta que tiene viajes programados.']);
        }

        $ruta->delete();

        return Redirect::route('rutas.index');
    }
}
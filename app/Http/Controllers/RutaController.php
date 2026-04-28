<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RutaController extends Controller
{
    public function index()
    {
        return Inertia::render('Rutas/Index', [
            // Ordenamos por id_ruta de forma descendente para que los nuevos (o el 10) salgan primero
            'rutas' => Ruta::with(['origen', 'destino'])
                ->orderBy('id_ruta', 'desc')
                ->get(),
            'terminales' => Terminal::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_origen'         => 'required|exists:TERMINAL,id_terminal|different:id_destino',
            'id_destino'        => 'required|exists:TERMINAL,id_terminal',
            'distancia'         => 'nullable|numeric|min:0',
            'duracion_estimada' => 'nullable|numeric|min:0'
        ], [
            'id_origen.different' => 'El origen y el destino no pueden ser el mismo.'
        ]);

        Ruta::create($data);

        return Redirect::route('rutas.index');
    }

    public function update(Request $request, $id)
    {
        $ruta = Ruta::findOrFail($id);
        
        $data = $request->validate([
            'id_origen'         => 'required|exists:TERMINAL,id_terminal|different:id_destino',
            'id_destino'        => 'required|exists:TERMINAL,id_terminal',
            'distancia'         => 'nullable|numeric|min:0',
            'duracion_estimada' => 'nullable|numeric|min:0'
        ]);

        $ruta->update($data);

        return Redirect::route('rutas.index');
    }

    public function destroy($id)
    {
        Ruta::findOrFail($id)->delete();
        return Redirect::route('rutas.index');
    }
}
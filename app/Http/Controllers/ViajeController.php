<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Ruta;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ViajeController extends Controller
{
    public function index()
    {
        return Inertia::render('Viajes/Index', [
            // Cargamos ruta Y sus terminales anidadas (origen y destino)
            'viajes' => Viaje::with(['ruta.origen', 'ruta.destino', 'bus'])
                ->orderBy('id_viaje', 'desc')
                ->get(),

            // Cargamos también los nombres para los Dropdowns del formulario
            'rutas' => Ruta::with(['origen', 'destino'])->get(),

            'buses' => Bus::all(),
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_ruta'      => 'required|exists:RUTA,id_ruta',
            'id_bus'       => 'required|exists:BUS,id_bus',
            'fecha_salida' => 'required|date',
            'hora_salida'  => 'required',
            'estado'       => 'required|in:PROGRAMADO,EN_CURSO,FINALIZADO'
        ]);

        Viaje::create($data);

        return Redirect::route('viajes.index');
    }

    public function update(Request $request, $id)
    {
        $viaje = Viaje::findOrFail($id);

        $data = $request->validate([
            'id_ruta'      => 'required|exists:RUTA,id_ruta',
            'id_bus'       => 'required|exists:BUS,id_bus',
            'fecha_salida' => 'required|date',
            'hora_salida'  => 'required',
            'estado'       => 'required|in:PROGRAMADO,EN_CURSO,FINALIZADO'
        ]);

        $viaje->update($data);

        return Redirect::route('viajes.index');
    }

    public function destroy($id)
    {
        Viaje::findOrFail($id)->delete();
        return Redirect::route('viajes.index');
    }
}

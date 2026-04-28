<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BusController extends Controller
{
    public function index()
    {
        return Inertia::render('Buses/Index', [
            // Ordenamos por id_bus descendente para que coincida con tu requerimiento
            'buses' => Bus::orderBy('id_bus', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'placa'     => 'required|string|max:20|unique:BUS,placa',
            'capacidad' => 'required|integer|min:1',
            'estado'    => 'required|string|max:50'
        ]);

        Bus::create($data);

        return Redirect::route('buses.index');
    }

    public function update(Request $request, $id)
    {
        $bus = Bus::findOrFail($id);
        
        $data = $request->validate([
            'placa'     => 'required|string|max:20|unique:BUS,placa,'.$id.',id_bus',
            'capacidad' => 'required|integer|min:1',
            'estado'    => 'required|string|max:50'
        ]);

        $bus->update($data);

        return Redirect::route('buses.index');
    }

    public function destroy($id)
    {
        Bus::findOrFail($id)->delete();
        return Redirect::route('buses.index');
    }
}
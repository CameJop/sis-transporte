<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Viaje;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BoletoController extends Controller
{
    public function index()
    {
        return Inertia::render('Boletos/Index', [
            'boletos' => Boleto::with(['viaje.ruta.origen', 'viaje.ruta.destino', 'cliente'])
                ->orderBy('id_boleto', 'desc') // Ordenar de 10 a 1
                ->get(),
            'viajes' => Viaje::with(['ruta.origen', 'ruta.destino', 'bus'])
                ->where('estado', '!=', 'FINALIZADO')
                ->get(),
            'clientes' => Cliente::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_viaje'   => 'required|exists:VIAJE,id_viaje',
            'id_cliente' => 'required|exists:CLIENTE,id_cliente',
            'asiento'    => 'required|string|max:10',
            'precio'     => 'required|numeric|min:0',
        ]);

        // Validación manual de asiento único por viaje (además del constraint de DB)
        $existe = Boleto::where('id_viaje', $data['id_viaje'])
                        ->where('asiento', $data['asiento'])
                        ->exists();

        if ($existe) {
            return back()->withErrors(['asiento' => 'El asiento ya está ocupado para este viaje.']);
        }

        Boleto::create($data);

        return Redirect::route('boletos.index');
    }

    public function update(Request $request, $id)
    {
        $boleto = Boleto::findOrFail($id);
        
        $data = $request->validate([
            'id_viaje'   => 'required|exists:VIAJE,id_viaje',
            'id_cliente' => 'required|exists:CLIENTE,id_cliente',
            'asiento'    => 'required|string|max:10',
            'precio'     => 'required|numeric|min:0',
        ]);

        $boleto->update($data);

        return Redirect::route('boletos.index');
    }

    public function destroy($id)
    {
        Boleto::findOrFail($id)->delete();
        return Redirect::route('boletos.index');
    }
}
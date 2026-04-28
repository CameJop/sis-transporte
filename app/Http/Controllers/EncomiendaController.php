<?php

namespace App\Http\Controllers;

use App\Models\Encomienda;
use App\Models\Viaje;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EncomiendaController extends Controller
{
    public function index()
    {
        return Inertia::render('Encomiendas/Index', [
            'encomiendas' => Encomienda::with([
                'viaje.ruta.origen', 
                'viaje.ruta.destino', 
                'remitente', 
                'destinatario'
            ])->latest('id_encomienda')->get(),
            'viajes' => Viaje::with(['ruta.origen', 'ruta.destino'])->get(),
            'clientes' => Cliente::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_viaje'                => 'required|exists:VIAJE,id_viaje',
            'id_cliente_remitente'    => 'required|exists:CLIENTE,id_cliente',
            'id_cliente_destinatario' => 'required|exists:CLIENTE,id_cliente',
            'peso'                    => 'nullable|numeric|min:0.1',
            'estado'                  => 'required|string',
            'fecha_envio'             => 'required|date'
        ]);

        Encomienda::create($data);

        return Redirect::route('encomiendas.index');
    }

    public function update(Request $request, $id)
    {
        $encomienda = Encomienda::findOrFail($id);
        
        $data = $request->validate([
            'id_viaje'                => 'required|exists:VIAJE,id_viaje',
            'id_cliente_remitente'    => 'required|exists:CLIENTE,id_cliente',
            'id_cliente_destinatario' => 'required|exists:CLIENTE,id_cliente',
            'peso'                    => 'nullable|numeric|min:0.1',
            'estado'                  => 'required|string',
            'fecha_envio'             => 'required|date'
        ]);

        $encomienda->update($data);

        return Redirect::route('encomiendas.index');
    }

    public function destroy($id)
    {
        Encomienda::findOrFail($id)->delete();
        return Redirect::route('encomiendas.index');
    }
}
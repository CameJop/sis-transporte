<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Viaje;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BoletoController extends Controller
{
    /**
     * Listado de boletos con relaciones
     */
    public function index()
    {
        return inertia('Boletos/Index', [
            'boletos' => Boleto::with(['viaje.ruta', 'cliente'])->latest('id_boleto')->get(),
            'viajes' => Viaje::with('ruta')->where('estado', 'PROGRAMADO')->get(),
            'clientes' => Cliente::all(['id_cliente', 'nombre', 'documento_identidad'])
        ]);
    }

    /**
     * Registrar un nuevo boleto
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_viaje'   => 'required|exists:VIAJE,id_viaje',
            'id_cliente' => 'required|exists:CLIENTE,id_cliente',
            'asiento'    => 'required|string|max:10',
            'precio'     => 'required|numeric|min:0',
            // Si no envías fecha, el SQL usará el CURRENT_TIMESTAMP
            'fecha_compra' => 'nullable|date',
        ]);

        // Validación extra: Verificar si el asiento ya está ocupado en ese viaje
        $ocupado = Boleto::where('id_viaje', $data['id_viaje'])
                         ->where('asiento', $data['asiento'])
                         ->exists();

        if ($ocupado) {
            return back()->withErrors(['asiento' => 'El asiento ya está ocupado para este viaje.']);
        }

        Boleto::create($data);

        return Redirect::route('boletos.index');
    }

    /**
     * Actualizar información de un boleto
     */
    public function update(Request $request, $id)
    {
        $boleto = Boleto::findOrFail($id);

        $data = $request->validate([
            'id_viaje'   => 'required',
            'id_cliente' => 'required',
            'asiento'    => 'required|string',
            'precio'     => 'required|numeric',
        ]);

        $boleto->update($data);

        return Redirect::route('boletos.index');
    }

    /**
     * Eliminar (Anular) un boleto
     */
    public function destroy($id)
    {
        $boleto = Boleto::findOrFail($id);
        $boleto->delete();

        return Redirect::route('boletos.index');
    }
}
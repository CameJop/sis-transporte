<?php

namespace App\Http\Controllers;

use App\Models\DetalleFactura;
use App\Models\Factura;
use App\Models\Boleto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DetalleFacturaController extends Controller
{
    public function index()
    {
        return Inertia::render('DetallesFactura/Index', [
            'detalles' => DetalleFactura::with(['factura.cliente']) ->orderBy('id_detalle', 'desc')->get(),
            'facturas' => Factura::with('cliente')->latest('id_factura')->take(20)->get(),
            // Cargamos boletos que no tengan factura aún (lógica de ejemplo)
            'boletos' => Boleto::latest('id_boleto')->take(50)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_factura'    => 'required|exists:FACTURA,id_factura',
            'tipo'          => 'required|in:BOLETO,ENCOMIENDA',
            'id_referencia' => 'required|integer',
            'monto'         => 'required|numeric|min:0'
        ]);

        DetalleFactura::create($data);

        return Redirect::route('detalles-factura.index');
    }

    public function destroy($id)
    {
        DetalleFactura::findOrFail($id)->delete();
        return Redirect::route('detalles-factura.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FacturaController extends Controller
{
    // FacturaController.php

    public function index()
    {
        return Inertia::render('Facturas/Index', [
            'facturas' => Factura::with(['cliente', 'empleado', 'metodo_pago'])
                ->orderBy('id_factura', 'desc') // <-- Cambio aquí: de asc a desc
                ->get(),
            'clientes' => Cliente::orderBy('nombre')->get(),
            'empleados' => Empleado::orderBy('nombre')->get(),
            'metodos_pago' => MetodoPago::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_metodo_pago' => 'required|exists:metodos_pago,id_metodo_pago',
            'fecha' => 'required|date',
        ]);

        try {
            Factura::create($validated);
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'No se pudo generar la factura.']);
        }
    }

    public function destroy($id)
    {
        try {
            $factura = Factura::findOrFail($id);
            $factura->delete();
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'La factura tiene detalles vinculados y no puede eliminarse.']);
        }
    }
}
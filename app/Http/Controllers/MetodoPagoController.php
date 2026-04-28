<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MetodoPagoController extends Controller
{
    public function index()
    {
        return Inertia::render('MetodosPago/Index', [
            // Ordenamos por ID descendente para que coincida con tu requerimiento
            'metodos' => MetodoPago::orderBy('id_metodo_pago', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:50|unique:METODO_PAGO,descripcion'
        ]);

        MetodoPago::create($data);

        return Redirect::route('metodos-pago.index');
    }

    public function update(Request $request, $id)
    {
        $metodo = MetodoPago::findOrFail($id);

        $data = $request->validate([
            'descripcion' => 'required|string|max:50|unique:METODO_PAGO,descripcion,' . $id . ',id_metodo_pago'
        ]);

        $metodo->update($data);

        return Redirect::route('metodos-pago.index');
    }

    public function destroy($id)
    {
        $metodo = MetodoPago::findOrFail($id);

        // Validar si el método ya ha sido usado en facturas
        if ($metodo->facturas()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar un método de pago que ya tiene transacciones registradas.']);
        }

        $metodo->delete();
        return Redirect::route('metodos-pago.index');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ClienteController extends Controller
{
    public function index()
    {
        return Inertia::render('Clientes/Index', [
            // Ordenamos por id_cliente descendente para ver los registros nuevos primero
            'clientes' => Cliente::orderBy('id_cliente', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'              => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:50|unique:CLIENTE,documento_identidad',
            'telefono'            => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:100'
        ]);

        Cliente::create($data);

        return Redirect::route('clientes.index');
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $data = $request->validate([
            'nombre'              => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:50|unique:CLIENTE,documento_identidad,' . $id . ',id_cliente',
            'telefono'            => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:100'
        ]);

        $cliente->update($data);

        return Redirect::route('clientes.index');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Validación de integridad referencial
        if ($cliente->boletos()->exists() || $cliente->facturas()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar un cliente con historial de compras.']);
        }

        $cliente->delete();
        return Redirect::route('clientes.index');
    }
}
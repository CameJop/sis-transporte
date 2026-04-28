<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ClienteController extends Controller
{
    /**
     * Listado de clientes
     */
    public function index()
    {
        return inertia('Clientes/Index', [
            'clientes' => Cliente::latest('id_cliente')->get()
        ]);
    }

    /**
     * Registrar un nuevo cliente
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'              => 'required|string|max:100',
            'documento_identidad' => 'required|string|max:50|unique:CLIENTE,documento_identidad',
            'telefono'            => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:100',
        ]);

        Cliente::create($data);

        return Redirect::route('clientes.index');
    }

    /**
     * Actualizar datos del cliente
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $data = $request->validate([
            'nombre'              => 'required|string|max:100',
            // Validamos único pero ignoramos el ID actual para permitir la edición
            'documento_identidad' => 'required|string|max:50|unique:CLIENTE,documento_identidad,' . $id . ',id_cliente',
            'telefono'            => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:100',
        ]);

        $cliente->update($data);

        return Redirect::route('clientes.index');
    }

    /**
     * Eliminar un cliente
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        
        // Nota: Si el cliente ya tiene boletos, la DB lanzará error por integridad referencial.
        $cliente->delete();

        return Redirect::route('clientes.index');
    }
}
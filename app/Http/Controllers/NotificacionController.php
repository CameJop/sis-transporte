<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class NotificacionController extends Controller
{
    public function index()
    {
        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => Notificacion::with('cliente')->latest('id_notificacion')->get(),
            'clientes' => Cliente::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_cliente' => 'required|exists:CLIENTE,id_cliente',
            'mensaje'    => 'required|string|max:255',
            'fecha'      => 'nullable|date',
        ]);

        $data['leido'] = false;
        $data['fecha'] = $data['fecha'] ?? now();

        Notificacion::create($data);

        return Redirect::route('notificaciones.index');
    }

    public function update(Request $request, $id)
    {
        $notificacion = Notificacion::findOrFail($id);
        
        $data = $request->validate([
            'leido' => 'required|boolean'
        ]);

        $notificacion->update($data);

        return Redirect::route('notificaciones.index');
    }

    public function destroy($id)
    {
        Notificacion::findOrFail($id)->delete();
        return Redirect::route('notificaciones.index');
    }
}
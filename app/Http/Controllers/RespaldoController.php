<?php

namespace App\Http\Controllers;

use App\Models\Respaldo;
use App\Models\RespaldoActionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;

class RespaldoController extends Controller
{
    public function index()
    {
        $last = RespaldoActionHistory::orderByDesc('id')->first();

        return Inertia::render('Respaldos/Index', [
            'respaldos'  => Respaldo::orderBy('id_respaldo', 'desc')->get(),
            'canUndo'    => RespaldoActionHistory::exists(),
            'lastAction' => $last?->action,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:200',
        ]);

        $respaldo = Respaldo::create([
            'fecha'       => Carbon::now(),
            'descripcion' => $request->descripcion,
        ]);

        // 📌 Push a la pila
        RespaldoActionHistory::create([
            'action'       => 'created',
            'respaldo_id'  => $respaldo->id_respaldo,
            'snapshot'     => [],
            'performed_by' => auth()->id(),
        ]);

        return Redirect::route('respaldos.index');
    }

    public function destroy($id)
    {
        $respaldo = Respaldo::findOrFail($id);

        // 📌 Push a la pila: guardar estado completo antes de borrar
        RespaldoActionHistory::create([
            'action'       => 'deleted',
            'respaldo_id'  => null,
            'snapshot'     => [
                'original_id' => $respaldo->id_respaldo,
                'fecha'       => $respaldo->fecha,
                'descripcion' => $respaldo->descripcion,
            ],
            'performed_by' => auth()->id(),
        ]);

        $respaldo->delete();

        return Redirect::route('respaldos.index');
    }

    public function undo()
    {
        $last = RespaldoActionHistory::orderByDesc('id')->firstOrFail();

        switch ($last->action) {

            case 'created':
                // Revertir creación = eliminar el respaldo creado
                Respaldo::find($last->respaldo_id)?->delete();
                break;

            case 'deleted':
                // Revertir eliminación = recrear el respaldo con sus datos originales
                Respaldo::create([
                    'fecha'       => $last->snapshot['fecha'],
                    'descripcion' => $last->snapshot['descripcion'],
                ]);
                break;
        }

        // Pop de la pila
        $last->delete();

        return Redirect::route('respaldos.index');
    }
}
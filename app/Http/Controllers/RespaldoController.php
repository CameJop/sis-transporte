<?php

namespace App\Http\Controllers;

use App\Models\Respaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;

class RespaldoController extends Controller
{
    public function index()
    {
        return Inertia::render('Respaldos/Index', [
            'respaldos' => Respaldo::orderBy('id_respaldo', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:200',
        ]);

        Respaldo::create([
            'fecha' => Carbon::now(),
            'descripcion' => $request->descripcion
        ]);

        return Redirect::route('respaldos.index');
    }

    public function destroy($id)
    {
        Respaldo::findOrFail($id)->delete();
        return Redirect::route('respaldos.index');
    }
}
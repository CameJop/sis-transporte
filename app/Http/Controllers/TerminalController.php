<?php

namespace App\Http\Controllers;

use App\Models\Terminal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TerminalController extends Controller
{
    public function index()
    {
        return Inertia::render('Terminales/Index', [
            // Orden descendente por ID para mostrar los más recientes arriba
            'terminales' => Terminal::orderBy('id_terminal', 'desc')->get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ]);

        Terminal::create($data);
        return Redirect::route('terminales.index');
    }

    public function update(Request $request, $id)
    {
        $terminal = Terminal::findOrFail($id);
        
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
        ]);

        $terminal->update($data);
        return Redirect::route('terminales.index');
    }

    public function destroy($id)
    {
        $terminal = Terminal::findOrFail($id);

        if ($terminal->rutasOrigen()->exists() || $terminal->rutasDestino()->exists()) {
            return back()->withErrors(['error' => 'No se puede eliminar la terminal porque tiene rutas vinculadas.']);
        }

        $terminal->delete();
        return Redirect::route('terminales.index');
    }
}
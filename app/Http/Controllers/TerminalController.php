<?php
namespace App\Http\Controllers;
use App\Models\Terminal;
use Illuminate\Http\Request;

class TerminalController extends Controller {
    public function index() {
        return inertia('Terminales/Index', ['items' => Terminal::all()]);
    }
    public function store(Request $request) {
        $data = $request->validate(['nombre' => 'required', 'ciudad' => 'required']);
        Terminal::create($data);
        return redirect()->back();
    }
    public function update(Request $request, $id) {
        Terminal::findOrFail($id)->update($request->all());
        return redirect()->back();
    }
    public function destroy($id) {
        Terminal::destroy($id);
        return redirect()->back();
    }
}
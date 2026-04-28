<?php
namespace App\Http\Controllers;
use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller {
    public function index() {
        return inertia('MetodosPago/Index', ['items' => MetodoPago::all()]);
    }
    public function store(Request $request) {
        MetodoPago::create($request->validate(['descripcion' => 'required']));
        return redirect()->back();
    }
}
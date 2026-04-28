<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Bus;
use App\Models\TipoMantenimiento;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MantenimientoController extends Controller
{
    public function index()
    {
        return Inertia::render('Mantenimientos/Index', [
            'mantenimientos' => Mantenimiento::with(['bus', 'tipoMantenimiento', 'empleado'])->latest('id_mantenimiento')->get(),
            'buses' => Bus::all(),
            'tipos' => TipoMantenimiento::all(),
            'empleados' => Empleado::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_bus'       => 'required|exists:BUS,id_bus',
            'id_tipo_mant' => 'required|exists:TIPO_MANTENIMIENTO,id_tipo_mant',
            'id_empleado'  => 'required|exists:EMPLEADO,id_empleado',
            'fecha'        => 'required|date',
            'costo'        => 'required|numeric|min:0',
            'descripcion'  => 'nullable|string|max:200',
            'estado'       => 'required|in:PENDIENTE,EN_PROCESO,FINALIZADO'
        ]);

        Mantenimiento::create($data);

        return Redirect::route('mantenimientos.index');
    }

    public function update(Request $request, $id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);
        
        $data = $request->validate([
            'id_bus'       => 'required|exists:BUS,id_bus',
            'id_tipo_mant' => 'required|exists:TIPO_MANTENIMIENTO,id_tipo_mant',
            'id_empleado'  => 'required|exists:EMPLEADO,id_empleado',
            'fecha'        => 'required|date',
            'costo'        => 'required|numeric|min:0',
            'descripcion'  => 'nullable|string|max:200',
            'estado'       => 'required|in:PENDIENTE,EN_PROCESO,FINALIZADO'
        ]);

        $mantenimiento->update($data);

        return Redirect::route('mantenimientos.index');
    }

    public function destroy($id)
    {
        Mantenimiento::findOrFail($id)->delete();
        return Redirect::route('mantenimientos.index');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_viajes'      => DB::table('VIAJE')->count(),
            'viajes_programados' => DB::table('VIAJE')->where('estado', 'PROGRAMADO')->count(),
            'viajes_en_curso'   => DB::table('VIAJE')->where('estado', 'EN_CURSO')->count(),
            'total_clientes'    => DB::table('CLIENTE')->count(),
            'total_empleados'   => DB::table('EMPLEADO')->where('estado', 'ACTIVO')->count(),
            'total_buses'       => DB::table('BUS')->count(),
            'boletos_hoy'       => DB::table('BOLETO')->whereDate('fecha_compra', today())->count(),
            'ingresos_hoy'      => DB::table('BOLETO')->whereDate('fecha_compra', today())->sum('precio'),
            'encomiendas_activas' => DB::table('ENCOMIENDA')->whereNotIn('estado', ['ENTREGADO'])->count(),
            'mantenimientos_pendientes' => DB::table('MANTENIMIENTO')->where('estado', 'PENDIENTE')->count(),
        ];

        $viajes_recientes = DB::table('VIAJE as v')
            ->join('ITINERARIO as i', 'v.id_itinerario', '=', 'i.id_itinerario')
            ->join('RUTA as r', 'i.id_ruta', '=', 'r.id_ruta')
            ->join('TERMINAL as orig', 'r.id_origen', '=', 'orig.id_terminal')
            ->join('TERMINAL as dest', 'r.id_destino', '=', 'dest.id_terminal')
            ->join('BUS as b', 'v.id_bus', '=', 'b.id_bus')
            ->select(
                'v.id_viaje',
                'orig.ciudad as origen',
                'dest.ciudad as destino',
                'i.hora_salida',
                'v.fecha_salida',
                'v.estado',
                'b.placa'
            )
            ->orderBy('v.fecha_salida', 'desc')
            ->limit(6)
            ->get();

        $ingresos_por_mes = DB::table('BOLETO')
            ->selectRaw('MONTH(fecha_compra) as mes, SUM(precio) as total')
            ->whereYear('fecha_compra', now()->year)
            ->groupByRaw('MONTH(fecha_compra)')
            ->orderBy('mes')
            ->get()
            ->keyBy('mes');

        return Inertia::render('Index', [  // <- sin subcarpeta
            'stats'           => $stats,
            'viajesRecientes' => $viajes_recientes,
            'ingresosPorMes'  => $ingresos_por_mes,
        ]);
    }
}

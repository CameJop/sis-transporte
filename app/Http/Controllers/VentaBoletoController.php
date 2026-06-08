<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\MetodoPago;
use App\Models\Viaje;
use App\Models\Boleto;
use App\Models\DetalleFactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class VentaBoletoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $facturasQuery = Factura::with(['cliente', 'empleado', 'metodo_pago'])
            ->whereHas('detalles', function ($query) {
                $query->where('tipo', 'BOLETO');
            });

        if ($user->hasRole('empleado')) {
            $facturasQuery->where('id_empleado', $user->id_empleado);
        }

        // Cargamos los viajes incluyendo sus rutas, la capacidad del bus y los asientos que YA están vendidos
        $viajesActivos = Viaje::with(['itinerario.ruta.origen', 'itinerario.ruta.destino', 'bus'])
            ->where('estado', 'PROGRAMADO')
            ->get()
            ->map(function ($viaje) {
                // 1. Extraemos los asientos ocupados
                $viaje->asientos_ocupados = Boleto::where('id_viaje', $viaje->id_viaje)
                    ->pluck('asiento')
                    ->toArray();

                // 2. INYECTAMOS LA HORA Y LA RUTA DIRECTAMENTE AL VIAJE (Esto sana tu Vue)
                $viaje->ruta = $viaje->itinerario->ruta ?? null;
                $viaje->hora_salida = $viaje->itinerario->hora_salida ?? null; // <-- AQUÍ ESTÁ LA CLAVE

                // 3. Calculamos el precio automático base
                $viaje->precio_automatico = round(($viaje->ruta->distancia ?? 100) * 0.22, 0);

                return $viaje;
            });

        return Inertia::render('Ventas/Index', [
            'facturas' => $facturasQuery->orderBy('id_factura', 'desc')->get(),
            'clientes' => Cliente::orderBy('nombre')->get(),
            'empleados' => $user->hasRole('admin') ? Empleado::where('rol', 'EMPLEADO')->orderBy('nombre')->get() : [],
            'metodos_pago' => MetodoPago::all(),
            'viajes' => $viajesActivos,
            'user_role' => $user->roles->first()?->name ?? 'empleado',
            // Pasamos los datos del empleado logueado para mostrarlo de forma elegante en la interfaz
            'current_user_employee' => $user->id_empleado ? Empleado::find($user->id_empleado) : null
        ]);
    }

    // NUEVO MÉTODO: Permite registrar un cliente rápidamente vía AJAX/Inertia sin recargar la página
    public function registrarClienteExpress(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'documento_identidad' => 'required|string', // Quitamos el 'unique' de aquí
        ]);

        // Busca por CI; si no existe, lo crea con los datos del request
        $cliente = Cliente::firstOrCreate(
            ['documento_identidad' => $request->documento_identidad],
            [
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'email' => $request->email
            ]
        );

        return back()->with('success', 'Cliente registrado.');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('empleado')) {
            $request->merge(['id_empleado' => $user->id_empleado]);
        }

        $request->validate([
            'id_cliente' => 'required|exists:CLIENTE,id_cliente',
            'id_empleado' => 'required|exists:EMPLEADO,id_empleado',
            'id_metodo_pago' => 'required|exists:METODO_PAGO,id_metodo_pago',
            'id_viaje' => 'required|exists:VIAJE,id_viaje',
            'asiento' => 'required|string|max:10',
            'precio' => 'required|numeric|min:0',
        ]);

        try {
            // 1. Crear el boleto de manera aislada
            $boleto = Boleto::create([
                'id_viaje' => $request->id_viaje,
                'id_cliente' => $request->id_cliente,
                'asiento' => $request->asiento,
                'precio' => $request->precio,
                'fecha_compra' => now(),
            ]);

            // 2. Crear la factura de manera aislada
            $factura = Factura::create([
                'id_cliente' => $request->id_cliente,
                'id_empleado' => $request->id_empleado,
                'id_metodo_pago' => $request->id_metodo_pago,
                'fecha' => now(),
                'total' => $request->precio,
            ]);

            // 3. Crear el detalle de la factura asociando ambos IDs
            DetalleFactura::create([
                'id_factura' => $factura->id_factura,
                'tipo' => 'BOLETO',
                'id_referencia' => $boleto->id_boleto,
                'monto' => $request->precio,
            ]);

            return redirect()->route('ventas.index')->with('success', 'Boleto vendido con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Error al registrar los datos: ' . $e->getMessage()
            ]);
        }
    }
}

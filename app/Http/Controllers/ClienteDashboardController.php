<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Encomienda;
use App\Models\Factura;
use App\Models\Boleto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClienteDashboardController extends Controller
{
    /**
     * Renderiza el panel principal del cliente con su historial completo.
     */
    public function index(Request $request)
    {
        // ── 1. Vincular usuario → cliente por documento_identidad ────────────
        $cliente = Cliente::where(
            'documento_identidad', $request->user()->documento_identidad
        )->first();

        if (! $cliente) {
            return Inertia::render('IndexCliente', [
                'cliente'     => null,
                'boletos'     => [],
                'encomiendas' => [],
                'facturas'    => [],
                'stats'       => [
                    'total_boletos'     => 0,
                    'total_encomiendas' => 0,
                    'total_facturas'    => 0,
                ],
            ]);
        }

        // ── 2. Boletos ───────────────────────────────────────────────────────
        // origen/destino están en TERMINAL, no en RUTA directamente
        $boletos = Boleto::with([
                'viaje.ruta.origen',   // Ruta::origen()  → belongsTo(Terminal, 'id_origen')
                'viaje.ruta.destino',  // Ruta::destino() → belongsTo(Terminal, 'id_destino')
            ])
            ->where('id_cliente', $cliente->id_cliente)
            ->orderByDesc('fecha_compra')
            ->get()
            ->map(fn ($b) => [
                'id_boleto'    => $b->id_boleto,
                'asiento'      => $b->asiento,
                'precio'       => number_format($b->precio, 2),
                'fecha_compra' => $b->fecha_compra,
                'origen'       => $b->viaje?->ruta?->origen?->ciudad  ?? '—',
                'destino'      => $b->viaje?->ruta?->destino?->ciudad ?? '—',
                'fecha_salida' => $b->viaje?->fecha_salida ?? '—',
                'hora_salida'  => $b->viaje?->hora_salida  ?? '—',
                'estado'       => $b->viaje?->estado       ?? '—',
            ]);

        // ── 3. Encomiendas ───────────────────────────────────────────────────
        // destino viene de viaje → ruta → destino (Terminal)
        // "descripcion" no existe en la tabla, se genera
        $encomiendas = Encomienda::with([
                'viaje.ruta.destino',
                'destinatario',   // Encomienda::destinatario() → belongsTo(Cliente, 'id_cliente_destinatario')
            ])
            ->where('id_cliente_remitente', $cliente->id_cliente)
            ->orWhere('id_cliente_destinatario', $cliente->id_cliente)
            ->orderByDesc('fecha_envio')
            ->get()
            ->map(fn ($e) => [
                'id_encomienda' => $e->id_encomienda,
                'descripcion'   => 'Encomienda #' . $e->id_encomienda,
                'destino'       => $e->viaje?->ruta?->destino?->ciudad ?? '—',
                'peso'          => $e->peso        ?? '—',
                'fecha_envio'   => $e->fecha_envio ?? '—',
                'estado'        => $e->estado      ?? '—',
                'destinatario'  => $e->destinatario?->nombre ?? '—',
            ]);

        // ── 4. Facturas ──────────────────────────────────────────────────────
        // "concepto" → metodo_pago->descripcion (FACTURA no tiene ese campo)
        // "total"    → suma de detalles->monto  (FACTURA no tiene ese campo)
        // "estado"   → no existe en FACTURA, se fija como "Pagado"
        $facturas = Factura::with(['metodo_pago', 'detalles'])
            ->where('id_cliente', $cliente->id_cliente)
            ->orderByDesc('fecha')
            ->get()
            ->map(fn ($f) => [
                'id_factura' => $f->id_factura,
                'fecha'      => $f->fecha,
                'concepto'   => $f->metodo_pago?->descripcion ?? '—',
                'total'      => number_format($f->detalles->sum('monto'), 2),
                'estado'     => 'Pagado',
            ]);

        // ── 5. Retornar vista ────────────────────────────────────────────────
        return Inertia::render('IndexCliente', [
            'cliente'     => $cliente,
            'boletos'     => $boletos,
            'encomiendas' => $encomiendas,
            'facturas'    => $facturas,
            'stats'       => [
                'total_boletos'     => $boletos->count(),
                'total_encomiendas' => $encomiendas->count(),
                'total_facturas'    => $facturas->count(),
            ],
        ]);
    }

    /**
     * Procesa la actualización del perfil desde la vista del Cliente.
     * Resuelve problemas transaccionales y de inconsistencia de nombres en peticiones AJAX.
     */
    public function updatePerfil(Request $request)
    {
        $user = $request->user();

        // 1. Validar tolerando tanto 'name' (Breeze global) como 'nombre' (Estructura de Clientes)
        $datosValidados = $request->validate([
            'nombre'   => 'nullable|string|max:100',
            'name'     => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:100',
        ]);

        // Determinamos el string correcto del nombre que viene del formulario de la modal
        $nombreFinal = $request->nombre ?? $request->name;

        if (!$nombreFinal) {
            return redirect()->back()->withErrors(['name' => 'El campo nombre es obligatorio.']);
        }

        // 2. Localizar el registro del cliente que coincide con el inicio de sesión
        $cliente = Cliente::where('documento_identidad', $user->documento_identidad)->firstOrFail();

        // 3. Actualizar la tabla CLIENTE
        $cliente->update([
            'nombre'   => $nombreFinal,
            'telefono' => $request->telefono,
            'email'    => $request->email,
        ]);

        // 4. Actualizar en caliente la tabla USERS de autenticación para evitar desincronizaciones visuales
        $user->update([
            'name'  => $nombreFinal,
            'email' => $request->email,
        ]);

        // 5. Retornar la redirección limpia hacia atrás para el Modo Ventana
        return redirect()->back()->with('success', 'Tu perfil ha sido actualizado con éxito.');
    }
}
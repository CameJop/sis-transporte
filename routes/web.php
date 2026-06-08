<?php

use App\Http\Controllers\{
    TerminalController, MetodoPagoController, TipoMantenimientoController,
    EmpleadoController, ClienteController, RoleController,
    BusController, RutaController, ViajeController, AsignacionController,
    BoletoController, FacturaController, DetalleFacturaController,
    EncomiendaController, MantenimientoController, NotificacionController,
    RespaldoController, ProfileController, UserController,
    ClienteDashboardController,
};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ─── Rutas Públicas ───────────────────────────────────────────────────────────

Route::get('/', fn () => Inertia::render('Welcome'))->name('home');

Route::get('/acceso', fn () => Inertia::render('LoginRegister', [
    'canLogin'       => Route::has('login'),
    'canRegister'    => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion'     => PHP_VERSION,
]))->name('acceso');

// ─── Rutas Protegidas ─────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard: redirige según rol e inyecta props del perfil
    Route::get('/dashboard', function () {
        if (auth()->user()->hasAnyRole(['admin', 'empleado'])) {
            return Inertia::render('Index', [
                'mustVerifyEmail' => request()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
                'status' => session('status'),
            ]);
        }
        return app(ClienteDashboardController::class)->index(request());
    })->name('dashboard');

    // Actualizar datos del pasajero (teléfono y email del cliente)
    Route::patch('/cliente/perfil', [ClienteDashboardController::class, 'updatePerfil'])
        ->name('cliente.updatePerfil');

    // ── Perfil de cuenta (User) ───────────────────────────────────────────────
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Gestión General (Admin y Empleado) ────────────────────────────────────
    Route::middleware(['role:admin|empleado'])->group(function () {
        Route::resource('users',       UserController::class);
        Route::resource('clientes',    ClienteController::class);
        Route::resource('viajes',      ViajeController::class);
        Route::resource('boletos',     BoletoController::class);
        Route::resource('encomiendas', EncomiendaController::class);
        Route::resource('facturas',    FacturaController::class);
    });

    // ── Configuración Técnica (Solo Admin) ────────────────────────────────────
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles',               RoleController::class);
        Route::resource('buses',               BusController::class);
        Route::resource('rutas',               RutaController::class);
        Route::resource('terminales',          TerminalController::class);
        Route::resource('empleados',           EmpleadoController::class);
        Route::resource('asignaciones',        AsignacionController::class);
        Route::resource('mantenimientos',      MantenimientoController::class);
        Route::resource('tipos-mantenimiento', TipoMantenimientoController::class);
        Route::resource('metodos-pago',        MetodoPagoController::class);
        Route::resource('notificaciones',      NotificacionController::class);
        Route::resource('detalles-factura',    DetalleFacturaController::class);
        Route::resource('respaldos',           RespaldoController::class);
    });
});

require __DIR__.'/auth.php';
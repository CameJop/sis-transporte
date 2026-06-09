<?php

use App\Http\Controllers\{
    TerminalController,
    MetodoPagoController,
    TipoMantenimientoController,
    EmpleadoController,
    ClienteController,
    RoleController,
    BusController,
    RutaController,
    ViajeController,
    AsignacionController,
    BoletoController,
    FacturaController,
    DetalleFacturaController,
    EncomiendaController,
    MantenimientoController,
    NotificacionController,
    RespaldoController,
    ProfileController,
    UserController,
    ClienteDashboardController,
    VentaBoletoController,
    ItinerarioController,
    DashboardController,
};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ─── Rutas Públicas ───────────────────────────────────────────────────────────
Route::get('/login', function () {
    return Inertia::render('RegisterLogin');
    // Nota: 'RegisterLogin' asume que tu archivo está en resources/js/Pages/RegisterLogin.vue
});

// ══ RUTAS PÚBLICAS — Welcome ══
Route::get('/',           fn() => Inertia::render('Welcome/Index'))->name('home');
Route::get('/destinos',   fn() => Inertia::render('Welcome/Destinos'))->name('destinos');
Route::get('/horarios',   fn() => Inertia::render('Welcome/Horarios'))->name('horarios');
Route::get('/servicios',  fn() => Inertia::render('Welcome/Servicios'))->name('servicios');
Route::get('/flota',      fn() => Inertia::render('Welcome/Nuestraflota'))->name('flota');
Route::get('/sucursales', fn() => Inertia::render('Welcome/Sucursales'))->name('sucursales');
Route::get('/contacto',   fn() => Inertia::render('Welcome/Contacto'))->name('contacto');

Route::get('/acceso', fn() => Inertia::render('LoginRegister', [
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
            return app(DashboardController::class)->index(request());
        }
        return app(ClienteDashboardController::class)->index(request());
    })->name('dashboard');

    Route::get('/mis-datos', [ClienteDashboardController::class, 'index'])
        ->name('cliente.index')
        ->middleware(['auth']);
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
        Route::resource('ventas', VentaBoletoController::class);
        Route::post('/ventas/cliente-express', [VentaBoletoController::class, 'registrarClienteExpress'])
            ->name('ventas.clienteExpress');
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
        // routes/web.php
        Route::post('respaldos/undo', [RespaldoController::class, 'undo'])->name('respaldos.undo');
        Route::resource('respaldos', RespaldoController::class);
        Route::resource('itinerarios',         ItinerarioController::class);
    });
});

require __DIR__ . '/auth.php';

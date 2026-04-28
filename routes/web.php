<?php

use App\Http\Controllers\{
    TerminalController, MetodoPagoController, TipoMantenimientoController,
    EmpleadoController, ClienteController, RolController, 
    BusController, RutaController, ViajeController, AsignacionController,
    BoletoController, FacturaController, DetalleFacturaController,
    EncomiendaController, MantenimientoController, NotificacionController, 
    RespaldoController, ProfileController, UserController
};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- Rutas Públicas ---
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// --- Rutas Protegidas (Requieren Login) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Lógica del Dashboard con redirección según Rol
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Si es Admin o Empleado, va a la vista Index (Rutas de viajes)
        if ($user->hasAnyRole(['admin', 'empleado'])) {
            return Inertia::render('Index');
        }

        // Si es otro (ej. Cliente), va al Dashboard estándar
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // 2. Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Rutas de Gestión General (Accesibles por Admin y Empleado)
    Route::middleware(['role:admin|empleado'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('clientes', ClienteController::class);
        Route::resource('viajes', ViajeController::class);
        Route::resource('boletos', BoletoController::class);
        Route::resource('encomiendas', EncomiendaController::class);
        Route::resource('facturas', FacturaController::class);
    });

    // 4. Rutas de Configuración Técnica y Sistema (Solo Admin)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles', RolController::class);
        Route::resource('buses', BusController::class);
        Route::resource('rutas', RutaController::class);
        Route::resource('terminales', TerminalController::class);
        Route::resource('empleados', EmpleadoController::class);
        Route::resource('asignaciones', AsignacionController::class);
        Route::resource('mantenimientos', MantenimientoController::class);
        Route::resource('tipos-mantenimiento', TipoMantenimientoController::class);
        Route::resource('metodos-pago', MetodoPagoController::class);
        Route::resource('notificaciones', NotificacionController::class);
        Route::resource('detalles-factura', DetalleFacturaController::class);
        Route::resource('respaldos', RespaldoController::class); // Mantengo tu controlador de respaldos
    });
});

require __DIR__.'/auth.php';
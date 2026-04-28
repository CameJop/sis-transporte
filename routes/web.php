<?php

use App\Http\Controllers\{
    TerminalController, MetodoPagoController, TipoMantenimientoController,
    EmpleadoController, ClienteController, RolController, UsuarioController,
    BusController, RutaController, ViajeController, AsignacionController,
    BoletoController, FacturaController, DetalleFacturaController,
    EncomiendaController, MantenimientoController, NotificacionController
};
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('users', UserController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('viajes', ViajeController::class);
Route::resource('terminales', TerminalController::class);
Route::resource('metodos-pago', MetodoPagoController::class);
Route::resource('tipos-mantenimiento', TipoMantenimientoController::class);
Route::resource('empleados', EmpleadoController::class);
Route::resource('roles', RolController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('buses', BusController::class);
Route::resource('rutas', RutaController::class);
Route::resource('asignaciones', AsignacionController::class);
Route::resource('boletos', BoletoController::class);
Route::resource('facturas', FacturaController::class);
Route::resource('detalles-factura', DetalleFacturaController::class);
Route::resource('encomiendas', EncomiendaController::class);
Route::resource('mantenimientos', MantenimientoController::class);
Route::resource('notificaciones', NotificacionController::class);

require __DIR__.'/auth.php';

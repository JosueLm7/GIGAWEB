<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\NosotrosController;
use App\Http\Controllers\ContactanosController; // Asegúrate de que este controlador esté importado
use Illuminate\Support\Facades\Route;

// Rutas de chat
Route::post('/chat', [ChatController::class, 'enviarMensaje'])->middleware('auth');
Route::get('/chat/{receptorId}', [ChatController::class, 'obtenerMensajes'])->middleware('auth');
Route::post('/chat/nuevos', [ChatController::class, 'obtenerNuevosMensajes']);

// Página principal (requiere autenticación)
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Ruta de "Nosotros" (sin autenticación)
Route::get('/nosotros', [NosotrosController::class, 'index'])->name('nosotros.index');

// Rutas de "Contáctanos"
Route::get('/contactanos', [ContactanosController::class, 'index'])->name('contactanos.index');
Route::post('/contactanos', [ContactanosController::class, 'store'])->name('contactanos.store');

// Autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.store');

// Rutas de gestión de usuarios
Route::middleware(['auth'])->group(function () {
    Route::get('/notificaciones/usuarios/{id}', [UsuarioController::class, 'index'])->name('notificaciones.usuarios.index');
    Route::get('notificaciones/clientes/create', [ClienteController::class, 'create'])->name('notificaciones.clientes.create');

    // Rutas de gestión de clientes
    Route::prefix('clientes')->group(function () {
        Route::get('/', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/create', [ClienteController::class, 'create'])->name('clientes.create');
        Route::post('/', [ClienteController::class, 'store'])->name('clientes.store');
        Route::get('/{cliente}', [ClienteController::class, 'show'])->name('clientes.show');
        Route::get('/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
        Route::put('/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::delete('/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');
    });

    // Rutas de gestión de notificaciones
    Route::prefix('notificaciones')->group(function () {
        Route::get('/', [NotificacionController::class, 'index'])->name('notificaciones.index');
        Route::get('/clientes', [NotificacionController::class, 'indexClientes'])->name('notificaciones.clientes.index');
    });

    // Rutas de gestión de facturas
    Route::prefix('facturas')->group(function () {
        Route::get('/', [FacturaController::class, 'index'])->name('facturas.index');
        Route::get('/create', [FacturaController::class, 'create'])->name('facturas.create');
        Route::post('/', [FacturaController::class, 'store'])->name('facturas.store');
        Route::get('/{factura}', [FacturaController::class, 'show'])->name('facturas.show');
        Route::get('/{factura}/edit', [FacturaController::class, 'edit'])->name('facturas.edit');
        Route::put('/{factura}', [FacturaController::class, 'update'])->name('facturas.update');
        Route::delete('/{factura}', [FacturaController::class, 'destroy'])->name('facturas.destroy');
        Route::post('/{factura}/pagos', [PagoController::class, 'store'])->name('pagos.store');
    });

    // Rutas de gestión de pagos
    Route::prefix('pagos')->group(function () {
        Route::get('/', [PagoController::class, 'index'])->name('pagos.index');
        Route::get('/{pago}', [PagoController::class, 'show'])->name('pagos.show');
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DetalleController;

// Página de login
Route::get('/', function () {
    return view('auth.login');
});

// Rutas de autenticación (login, register, etc.)
Auth::routes();

// Todas las rutas siguientes requieren usuario autenticado
Route::middleware('auth')->group(function () {
    // Dashboard / Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // CRUD de productos
    Route::resource('productos', ProductoController::class);

    // CRUD de tickets
    Route::resource('tickets', TicketController::class);

     // CRUD de detalles
    Route::resource('detalles', DetalleController::class);

});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DetalleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductPublicController;

// Página de login
Route::get('/', function () {
    return view('index');
});

// Rutas de autenticación (login, register, etc.)
Auth::routes();

// Rutas protegidas (requieren usuario autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('productos', ProductoController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('detalles', DetalleController::class);
});

// Rutas públicas (no requieren autenticación)
// Hojas de Seguridad
Route::get('/hojas-seguridad', function () {
    // Aquí pasamos siempre la variable, aunque esté vacía
    $hojasSeguridad = collect(); 

    return view('hojasSeguridad.index', compact('hojasSeguridad'));
})->name('hojas_seguridad.index');

// Fichas Técnicas
Route::get('/fichas-tecnicas', function () {
    return view('fichasTecnicas.index');
})->name('fichas_tecnicas.index');

// Registros COFEPRIS
Route::get('/registros/cofepris', function () {
    return view('registros.cofepris');
})->name('registros.cofepris');

// Registros OMRI
Route::get('/registros/omri', function () {
    return view('registros.omri');
})->name('registros.omri');

// Ruta de index
Route::get('/index', function () {
    return view('index');
})->name('index');

// Ruta de nosotros
Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

// Ruta de contacto
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// Público (sin auth)
Route::get('/infoProductos', [ProductPublicController::class, 'index'])->name('productos.index');
Route::get('/infoProductos/{producto:slug}', [ProductPublicController::class, 'show'])->name('productos.show');
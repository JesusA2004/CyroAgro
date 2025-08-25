<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;         // CRUD admin (layout auth)
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DetalleController;
use App\Http\Controllers\ProductPublicController;   // Listado/Detalle públicos

/**
 * ======================
 * PÁGINAS PÚBLICAS
 * ======================
 */
Route::view('/', 'index')->name('index');
Route::view('/index', 'index'); // alias opcional
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

// Hojas de Seguridad
Route::get('/hojas-seguridad', function () {
    $hojasSeguridad = collect();
    return view('hojasSeguridad.index', compact('hojasSeguridad'));
})->name('hojas_seguridad.index');

// Fichas Técnicas
Route::view('/fichas-tecnicas', 'fichasTecnicas.index')->name('fichas_tecnicas.index');

// Registros
Route::view('/registros/cofepris', 'registros.cofepris')->name('registros.cofepris');
Route::view('/registros/omri', 'registros.omri')->name('registros.omri');

/**
 * ======================
 * CATÁLOGO PÚBLICO DE PRODUCTOS (SIN LOGIN)
 * ======================
 * productos.index  -> listado público (clientes)
 * productos.show   -> detalle público
 */
Route::get('/productos', [ProductPublicController::class, 'index'])
    ->name('productos.index');

Route::get('/productos/{producto}', [ProductPublicController::class, 'show'])
    ->name('productos.show');
// Si usas slug en lugar de id, ajusta el binding en el modelo o aquí:
// ->where('producto', '^[A-Za-z0-9\-_]+$');

/**
 * ======================
 * AUTENTICACIÓN
 * ======================
 */
Auth::routes();

/**
 * ======================
 * ÁREA ADMIN (CON LOGIN) — CRUD EN SINGULAR: producto.*
 * ======================
 */
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // CRUD admin de productos (layout auth)
    Route::resource('producto', ProductoController::class);
    // Nombres generados:
    // producto.index, producto.create, producto.store, producto.show,
    // producto.edit, producto.update, producto.destroy

    // Otros recursos administrativos
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('detalles', DetalleController::class);

    // Si tu búsqueda ya es 100% en tiempo real (JS), NO necesitas esta ruta:
    // Route::get('/producto/buscar', [ProductoController::class, 'buscar'])->name('producto.buscar');
});

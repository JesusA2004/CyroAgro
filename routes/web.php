<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DetalleController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductPublicController;

/**
 * ======================
 * PÁGINAS PÚBLICAS
 * ======================
 */
Route::view('/', 'index')->name('index');
Route::view('/index', 'index');               // alias opcional de portada
Route::view('/nosotros', 'nosotros')->name('nosotros');
Route::view('/contacto', 'contacto')->name('contacto');

// Hojas de Seguridad
Route::get('/hojas-seguridad', function () {
    $hojasSeguridad = collect();              // siempre definida para evitar notices
    return view('hojasSeguridad.index', compact('hojasSeguridad'));
})->name('hojas_seguridad.index');

// Fichas Técnicas
Route::view('/fichas-tecnicas', 'fichasTecnicas.index')->name('fichas_tecnicas.index');

// Registros
Route::view('/registros/cofepris', 'registros.cofepris')->name('registros.cofepris');
Route::view('/registros/omri', 'registros.omri')->name('registros.omri');

// Página pública de productos (si usas un listado/landing informativa)
Route::get('/infoProductos', [ProductPublicController::class, 'show'])
    ->name('productos.show');                 // puedes mantener este nombre público en plural

/**
 * ======================
 * AUTENTICACIÓN
 * ======================
 */
Auth::routes();

/**
 * ======================
 * ÁREA PROTEGIDA (AUTH)
 * ======================
 */
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // CRUD de administración EN SINGULAR
    Route::resource('producto', ProductoController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('detalles', DetalleController::class);

    // Si tu búsqueda ahora es 100% front (JS en tiempo real), esta ruta NO es necesaria.
    // Déjala comentada para evitar confusiones; si la usas, descoméntala.
    // Route::get('/producto/buscar', [ProductoController::class, 'buscar'])->name('producto.buscar');
});

/**
 * ======================
 * COMPATIBILIDAD (ALIAS)
 * ======================
 * Si alguna vista antigua aún llama rutas en plural, redirigimos a las nuevas.
 * Quita estas líneas cuando ya no se usen.
 */
Route::get('/productos', fn () => redirect()->route('producto.index'))->name('productos.index');

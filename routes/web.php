<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;          // CRUD admin (layout auth)
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductPublicController;
use App\Http\Controllers\Admin\FeaturedProductController;

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
// ->where('producto', '^[A-Za-z0-9\-_]+$'); // si usas slug, ajusta binding

/**
 * ======================
 * AUTENTICACIÓN
 * ======================
 */
Auth::routes();

/**
 * ======================
 * ÁREA ADMIN (CON LOGIN)
 * ======================
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // CRUD admin de productos (layout auth)
    Route::resource('producto', ProductoController::class);

    // Usuarios
    Route::resource('usuarios', UsuarioController::class);

    /**
     * ======================
     * ADMIN: DESTACADOS (Featured Products)
     * ======================
     * Panel para seleccionar/ordenar productos destacados.
     * Si tienes gates/policies, agrega 'can:admin' en el middleware.
     */
    Route::prefix('admin/destacados')->name('admin.destacados.')->group(function () {
        Route::get('/',  [FeaturedProductController::class, 'index'])->name('index');
        Route::post('/', [FeaturedProductController::class, 'store'])->name('store');
        Route::delete('/{featuredProduct}', [FeaturedProductController::class, 'destroy'])->name('destroy');
    });
});

<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{

    /**
     * Mostrar listado de productos con paginación.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        // Base
        $base = Producto::query();
        if ($q !== '') {
            $base->where('nombre', 'like', "%{$q}%");
        }

        // Vista completa (paginada)
        $productos = $base->orderBy('nombre')->paginate(12);

        // === Datasets para filtros (usados por tu Blade) ===
        $segmentos   = Producto::whereNotNull('segmento')
                        ->where('segmento','<>','')
                        ->distinct()->orderBy('segmento')->pluck('segmento');

        $categorias  = Producto::whereNotNull('categoria')
                        ->where('categoria','<>','')
                        ->distinct()->orderBy('categoria')->pluck('categoria');

        // Controles y Cultivos: a partir de campos CSV
        $controles = Producto::whereNotNull('controla')->pluck('controla')
            ->flatMap(function ($s) {
                return collect(explode(',', (string)$s))->map(fn($v) => trim($v));
            })
            ->filter()->unique()->values();

        $cultivos = Producto::whereNotNull('usoRecomendado')->pluck('usoRecomendado')
            ->flatMap(function ($s) {
                return collect(explode(',', (string)$s))->map(fn($v) => trim($v));
            })
            ->filter()->unique()->values();

        // AJAX: devuelve TODOS los matches (sin paginar) para reemplazar el grid
        if ($request->ajax() && $q !== '') {
            $matches = Producto::where('nombre', 'like', "%{$q}%")
                        ->orderBy('nombre')->get();

            return response()
                ->view('producto.partials.cards', [
                    'productos'  => $matches,
                    // por si tu partial también usa estos:
                    'segmentos'  => $segmentos,
                    'categorias' => $categorias,
                    'controles'  => $controles,
                    'cultivos'   => $cultivos,
                ])
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        // Render normal
        return view('producto.index', compact('productos','segmentos','categorias','controles','cultivos'));
    }

    /**
     * Formulario para crear un nuevo producto.
     */
    public function create(): View
    {
        return view('producto.create', [
            'producto' => new Producto(),
        ]);
    }

    /**
     * Almacenar un nuevo producto.
     */
    public function store(ProductoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // quién creó/modificó (opcional)
        $data['creadoPor']     = Auth::user()->name ?? 'Administrador';
        $data['modificadoPor'] = Auth::user()->name ?? 'Administrador';

        // === FOTO (nuevo) ===
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $ext      = strtolower($file->getClientOriginalExtension());
            $baseName = Str::slug($data['nombre'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = $baseName . '-' . time() . '.' . $ext;

            $dest = public_path('img/FotosProducto');
            if (!is_dir($dest)) { @mkdir($dest, 0775, true); }

            // mueve a /public/img/FotosProducto
            $file->move($dest, $filename);

            // guarda URL pública en la columna correcta
            $data['fotoProducto'] = '/img/FotosProducto/' . $filename;
        }

        Producto::create($data);

        return Redirect::route('producto.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Mostrar los detalles de un producto.
     */
    public function show(Producto $producto): View
    {
        return view('producto.show', compact('producto'));
    }

    /**
     * Formulario para editar un producto existente.
     */
    public function edit(Producto $producto): View
    {
        return view('producto.edit', compact('producto'));
    }

    /**
     * Actualizar la información de un producto.
     */
    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        $data = $request->validated();
        $data['modificadoPor'] = Auth::user()->name ?? 'Administrador';

        // Acepta <input name="foto"> o <input name="fotoProducto">
        $file = $request->file('foto') ?? $request->file('fotoProducto');

        // Actualiza primero los campos normales
        $producto->fill($data);

        if ($file && $file->isValid()) {
            $ext      = strtolower($file->getClientOriginalExtension() ?: 'png');
            $baseName = Str::slug($data['nombre'] ?? $producto->nombre ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $filename = $baseName . '-' . time() . '.' . $ext;

            $dest = public_path('img/FotosProducto');
            if (!is_dir($dest)) { @mkdir($dest, 0775, true); }
            $file->move($dest, $filename);

            // Borra foto anterior (si estaba en el mismo directorio)
            if (!empty($producto->fotoProducto)) {
                $old = public_path(ltrim($producto->fotoProducto, '/'));
                if (str_starts_with($producto->fotoProducto, '/img/FotosProducto/') && file_exists($old)) {
                    @unlink($old);
                }
            }

            $newPath = '/FotosProducto/' . $filename;

            // 1) Fuerza el UPDATE directo en BD (por si $fillable u otros bloquean)
            DB::table('productos')
                ->where('id', $producto->id)
                ->update([
                    'fotoProducto' => $newPath,
                    'updated_at'   => now(),
                ]);

            // 2) Refresca el valor en el modelo para que la vista lo traiga correcto
            $producto->setAttribute('fotoProducto', $newPath);
        }

        // Guarda el resto de cambios del producto
        $producto->save();

        return Redirect::route('producto.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto.
     */
    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return Redirect::route('producto.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    public function buscar(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $query = \App\Models\Producto::query();

        if ($q !== '') {
            $query->where('nombre', 'like', "%{$q}%");
        }

        // Trae todos los que machean (o limita si prefieres)
        $productos = $query->orderBy('nombre', 'asc')->get();

        // Devolvemos solo las cards como HTML (partial)
        // Para evitar problemas con la caché del navegador:
        return response()
            ->view('producto.partials.cards', compact('productos'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductoController extends Controller
{

    /**
     * Mostrar listado de productos con paginación.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        // Consulta base
        $base = Producto::query();

        // Paginado normal para la vista completa
        $productos = $base->orderBy('nombre')->paginate(12);

        // Si es AJAX y hay búsqueda, devolvemos SOLO el parcial con TODOS los matches (sin paginar)
        if ($request->ajax() && $q !== '') {
            $matches = Producto::where('nombre', 'like', "%{$q}%")
                        ->orderBy('nombre')
                        ->get();

            return response()
                ->view('producto.partials.cards', ['productos' => $matches])
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        // Render normal (index con paginación)
        return view('producto.index', compact('productos'));
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

        // Si quieres guardar el nombre del usuario en tus columnas:
        $data['creadoPor']     = Auth::user()->name ?? 'Administrador';
        $data['modificadoPor'] = Auth::user()->name ?? 'Administrador';
        // O simplemente no pongas nada si no te interesa registrar esto.

        if ($request->hasFile('foto')) {
            $ruta = $request->file('foto')->store('FotosProductos', 'public'); // 👉 guarda en storage/app/public/FotosProductos
            $data['urlFoto'] = $ruta;
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

        // Actualiza tu columna real (opcional):
        $data['modificadoPor'] = Auth::user()->name ?? 'Administrador';

        if ($request->hasFile('foto')) {
            $ruta = $request->file('foto')->store('FotosProductos', 'public');
            $data['urlFoto'] = $ruta;
        }

        $producto->update($data);

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

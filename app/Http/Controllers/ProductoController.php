<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /**
     * Mostrar listado de productos con paginación.
     */
    public function index(Request $request): View
    {
        $productos = Producto::orderBy('created_at', 'desc')->paginate(10);

        return view('producto.index', compact('productos'))
            ->with('i', ($request->input('page', 1) - 1) * $productos->perPage());
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
        Producto::create($request->validated());

        return Redirect::route('productos.index')
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
        $producto->update($request->validated());

        return Redirect::route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar un producto.
     */
    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->delete();

        return Redirect::route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}

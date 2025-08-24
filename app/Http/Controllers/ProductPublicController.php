<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product; // Asegúrate de que este modelo apunte a la tabla 'productos'

class ProductPublicController extends Controller
{
    /**
     * Listado público de productos con catálogos para filtros.
     */
    public function index(Request $request)
    {
        // Trae SOLO columnas que existen en tu BD
        $productos = Product::select([
                'id', 'nombre', 'segmento', 'categoria', 'registro',
                'contenido', 'usoRecomendado', 'dosisSugerida', 'intervaloAplicacion',
                'controla', 'fichaTecnica', 'hojaSeguridad', 'fotoProducto',
                'presentacion', 'FotoCatalogo',
            ])
            ->orderBy('nombre', 'asc')
            ->get();

        // Colección de strings: categorías
        $categorias = $productos->pluck('categoria')
            ->filter(fn ($v) => filled($v))
            ->map(fn ($v) => trim($v))
            ->unique()
            ->sort()
            ->values();

        // Colección de strings: segmentos
        $segmentos = $productos->pluck('segmento')
            ->filter(fn ($v) => filled($v))
            ->map(fn ($v) => trim($v))
            ->unique()
            ->sort()
            ->values();

        // Helper para “explotar por comas” y normalizar
        $splitList = function ($collection, $column) {
            return $collection->pluck($column)
                ->filter(fn ($t) => filled($t))
                ->flatMap(function ($t) {
                    // separa por comas y limpia espacios extras
                    return collect(explode(',', $t))
                        ->map(fn ($s) => trim(preg_replace('/\s+/', ' ', $s)));
                })
                ->filter(fn ($s) => $s !== '')
                ->unique()
                ->sort()
                ->values();
        };

        // Colecciones de strings: controles y cultivos
        $controles = $splitList($productos, 'controla');
        $cultivos  = $splitList($productos, 'usoRecomendado');

        return view('productos.index', compact(
            'productos', 'categorias', 'segmentos', 'controles', 'cultivos'
        ));
    }

    /**
     * Vista detalle público por ID (opcional).
     */
    public function show(Product $producto)
    {
        return view('productos.show', compact('producto'));
    }
}

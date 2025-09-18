<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturedProduct;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FeaturedProductController extends Controller
{
    /** Panel de destacados */
    public function index()
    {
        // Trae productos con la relación 'featured' para saber si están activos
        $productos = Producto::with('featured:id,product_id,is_active')
            ->orderBy('nombre')
            ->get(['id','nombre','FotoCatalogo','fotoProducto']);

        // (opcional) Destacados existentes por si los usas en la vista
        $destacados = FeaturedProduct::with('product:id,nombre')->get(['id','product_id','is_active']);

        return view('admin.destacados.index', compact('productos','destacados'));
    }

    /** Guardar selección (solo Activo/Inactivo). Regla: entre 2 y 4 activos. */
    public function store(Request $request)
    {
        // items llega como arreglo sparse con product_id + is_active
        $items = collect($request->input('items', []))
            ->filter(fn($i) => isset($i['product_id']))   // ignora filas vacías
            ->values();

        // Valida la existencia de cada product_id
        $items->each(function($i) {
            validator(
                $i,
                ['product_id' => ['required','integer', Rule::exists('productos','id')],
                 'is_active'  => ['required','in:0,1']]
            )->validate();
        });

        // Solo nos interesan los ACTIVOS
        $activos = $items->filter(fn($i) => (int)$i['is_active'] === 1)
                         ->pluck('product_id')
                         ->unique()
                         ->values();

        // Reglas de negocio: mínimo 2, máximo 4
        $count = $activos->count();
        if ($count < 2 || $count > 4) {
            return back()
                ->withErrors(["Selecciona entre 2 y 4 productos activos (actualmente: {$count})."])
                ->withInput();
        }

        DB::transaction(function () use ($activos, $request) {
            // 1) Elimina TODO lo que no esté activo (simplifica el estado)
            if ($activos->isEmpty()) {
                FeaturedProduct::query()->delete(); // no pasará por la validación, pero por seguridad
            } else {
                FeaturedProduct::whereNotIn('product_id', $activos)->delete();
            }

            // 2) Upsert SOLO de los activos (marcados con is_active = 1)
            $now = now();
            $rows = $activos->map(function ($pid) use ($request, $now) {
                return [
                    'product_id' => $pid,
                    'is_active'  => 1,
                    'created_by' => optional($request->user())->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->all();

            if (!empty($rows)) {
                FeaturedProduct::upsert(
                    $rows,
                    ['product_id'],           // unique key
                    ['is_active','created_by','updated_at'] // columnas a actualizar
                );
            }
        });

        return back()->with('ok', 'Destacados actualizados correctamente.');
    }

    /** Eliminar un destacado concreto (no imprescindible con el flujo actual) */
    public function destroy(FeaturedProduct $featuredProduct)
    {
        $featuredProduct->delete();
        return back()->with('ok','Eliminado de destacados.');
    }
}

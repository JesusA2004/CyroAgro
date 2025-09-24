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
     * Listado de productos con filtros y paginación.
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $base = Producto::query();
        if ($q !== '') {
            $base->where('nombre', 'like', "%{$q}%");
        }

        $productos = $base->orderBy('nombre')->paginate(12);

        $segmentos = Producto::whereNotNull('segmento')
            ->where('segmento','<>','')
            ->distinct()->orderBy('segmento')->pluck('segmento');

        $categorias = Producto::whereNotNull('categoria')
            ->where('categoria','<>','')
            ->distinct()->orderBy('categoria')->pluck('categoria');

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

        if ($request->ajax() && $q !== '') {
            $matches = Producto::where('nombre', 'like', "%{$q}%")
                        ->orderBy('nombre')->get();

            return response()
                ->view('producto.partials.cards', [
                    'productos'  => $matches,
                    'segmentos'  => $segmentos,
                    'categorias' => $categorias,
                    'controles'  => $controles,
                    'cultivos'   => $cultivos,
                ])
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        }

        return view('producto.index', compact('productos','segmentos','categorias','controles','cultivos'));
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('producto.create', [
            'producto' => new Producto(),
        ]);
    }

    /**
     * Persistir nuevo producto.
     * PDFs:
     *  - fichaTecnica_file => /public/fichasTecnicas => BD: fichasTecnicas/<archivo>.pdf
     *  - hojaSeguridad_file => /public/hojasSeguridad => BD: hojasSeguridad/<archivo>.pdf
     * Imagen:
     *  - foto => /public/img/FotosProducto => BD: img/FotosProducto/<archivo>.<ext>
     */
    public function store(ProductoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['creadoPor']     = Auth::user()->name ?? 'Administrador';
        $data['modificadoPor'] = Auth::user()->name ?? 'Administrador';

        // PDFs opcionales (si no llegan, conservamos hidden si existiera)
        $data['fichaTecnica'] = $this->handlePdfUpload(
            $request,
            'fichaTecnica_file',
            'fichasTecnicas',
            keepIfEmpty: $request->input('fichaTecnica')
        );

        $data['hojaSeguridad'] = $this->handlePdfUpload(
            $request,
            'hojaSeguridad_file',
            'hojasSeguridad',
            keepIfEmpty: $request->input('hojaSeguridad')
        );

        // Imagen opcional
        if ($request->hasFile('foto')) {
            $data['fotoProducto'] = $this->handleImageUpload($request, 'foto', 'img/FotosProducto');
        }

        // Fechas "legacy" si las usas
        $data['fechaCreacion']      = now()->toDateString();
        $data['fechaActualizacion'] = now()->toDateString();

        Producto::create($data);

        return Redirect::route('producto.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Ver detalle.
     */
    public function show(Producto $producto): View
    {
        return view('producto.show', compact('producto'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Producto $producto): View
    {
        return view('producto.edit', compact('producto'));
    }

    /**
     * Actualizar producto.
     * Reemplaza PDFs/imagen si llegan; conserva rutas si no.
     */
    public function update(ProductoRequest $request, Producto $producto): RedirectResponse
    {
        $data = $request->validated();
        $data['modificadoPor']      = Auth::user()->name ?? 'Administrador';
        $data['fechaActualizacion'] = now()->toDateString();

        // PDFs: si viene archivo nuevo, sube y borra anterior local (si fue nuestro)
        $newFicha = $this->handlePdfUpload(
            $request,
            'fichaTecnica_file',
            'fichasTecnicas',
            keepIfEmpty: $producto->fichaTecnica
        );

        if ($newFicha !== $producto->fichaTecnica) {
            $this->deletePublicFileIfLocal($producto->fichaTecnica, ['fichasTecnicas']);
            $data['fichaTecnica'] = $newFicha;
        }

        $newHoja = $this->handlePdfUpload(
            $request,
            'hojaSeguridad_file',
            'hojasSeguridad',
            keepIfEmpty: $producto->hojaSeguridad
        );

        if ($newHoja !== $producto->hojaSeguridad) {
            $this->deletePublicFileIfLocal($producto->hojaSeguridad, ['hojasSeguridad']);
            $data['hojaSeguridad'] = $newHoja;
        }

        // Imagen (opcional): reemplaza y borra la anterior si era local en nuestro folder
        if ($request->hasFile('foto')) {
            $newFoto = $this->handleImageUpload($request, 'foto', 'img/FotosProducto');
            if (!empty($producto->fotoProducto) && $newFoto !== $producto->fotoProducto) {
                $this->deletePublicFileIfLocal($producto->fotoProducto, ['img/FotosProducto']);
            }
            $data['fotoProducto'] = $newFoto;
        }

        $producto->update($data);

        return Redirect::route('producto.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Eliminar producto (y opcionalmente sus archivos locales).
     */
    public function destroy(Producto $producto): RedirectResponse
    {
        // Limpieza opcional: elimina archivos si están en nuestros folders locales
        $this->deletePublicFileIfLocal($producto->fichaTecnica, ['fichasTecnicas']);
        $this->deletePublicFileIfLocal($producto->hojaSeguridad, ['hojasSeguridad']);
        $this->deletePublicFileIfLocal($producto->fotoProducto, ['img/FotosProducto']);

        $producto->delete();

        return Redirect::route('producto.index')
            ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Búsqueda para reemplazar grid por AJAX.
     */
    public function buscar(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $query = Producto::query();
        if ($q !== '') {
            $query->where('nombre', 'like', "%{$q}%");
        }

        $productos = $query->orderBy('nombre', 'asc')->get();

        return response()
            ->view('producto.partials.cards', compact('productos'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    /**
     * Sube un PDF al directorio público indicado y devuelve la ruta relativa guardable en BD.
     * - $publicSubdir: ejemplo 'fichasTecnicas' o 'hojasSeguridad'
     * - Si no hay archivo y existe keepIfEmpty, devuelve esa ruta
     */
    private function handlePdfUpload(Request $request, string $inputName, string $publicSubdir, ?string $keepIfEmpty = null): ?string
    {
        if (!$request->hasFile($inputName)) {
            return $keepIfEmpty;
        }

        $file = $request->file($inputName);
        if (!$file || !$file->isValid()) {
            return $keepIfEmpty;
        }

        $base = Str::slug($request->input('nombre', 'documento'));
        $filename = $base . '-' . now()->format('YmdHis') . '.' . strtolower($file->getClientOriginalExtension() ?: 'pdf');

        $destAbs = public_path($publicSubdir);
        if (!is_dir($destAbs)) {
            @mkdir($destAbs, 0755, true);
        }

        $file->move($destAbs, $filename);

        // Ruta relativa (sin slash inicial) para usar con asset()
        return $publicSubdir . '/' . $filename;
    }

    /**
     * Sube imagen a /public/{publicSubdir} y devuelve ruta relativa (sin slash inicial).
     * - $publicSubdir: ejemplo 'img/FotosProducto'
     */
    private function handleImageUpload(Request $request, string $inputName, string $publicSubdir): string
    {
        $img = $request->file($inputName);
        $base = Str::slug($request->input('nombre', 'producto'));
        $filename = $base . '-' . now()->format('YmdHis') . '.' . strtolower($img->getClientOriginalExtension() ?: 'png');

        $destAbs = public_path($publicSubdir);
        if (!is_dir($destAbs)) {
            @mkdir($destAbs, 0755, true);
        }

        $img->move($destAbs, $filename);

        return $publicSubdir . '/' . $filename;
    }

    /**
     * Borra un archivo del disco público si su ruta está dentro de alguno de los prefijos permitidos.
     * - $relativePath: ej. 'fichasTecnicas/abc.pdf' o 'img/FotosProducto/xyz.png'
     * - $allowedPrefixes: ej. ['fichasTecnicas','hojasSeguridad','img/FotosProducto']
     */
    private function deletePublicFileIfLocal(?string $relativePath, array $allowedPrefixes = []): void
    {
        if (empty($relativePath)) return;

        $clean = ltrim($relativePath, '/');
        foreach ($allowedPrefixes as $prefix) {
            if (Str::startsWith($clean, trim($prefix, '/').'/')) {
                $abs = public_path($clean);
                if (is_file($abs) && file_exists($abs)) {
                    @unlink($abs);
                }
                break;
            }
        }
    }
}

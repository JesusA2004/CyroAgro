<div class="container-fluid mt-5 px-3 px-md-5">
    {{-- Mini menú tipo panel --}}
    <div class="card shadow-sm border-0 mb-4 animate-fadein">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top px-4 py-3">
            <h5 class="mb-0 fw-bold">
                @if(Route::currentRouteName() === 'productos.create')
                    🆕 Registro de Producto
                @else
                    ✏️ Edición de Producto
                @endif
            </h5>
            <a href="{{ route('productos.index') }}" class="btn btn-outline-light btn-sm">
                ← Volver
            </a>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="product-form p-4 shadow bg-white rounded-4 mx-auto mb-5 animate-fadein" style="max-width: 1280px;">
        {{-- Campos --}}
        <div class="row gx-4 gy-4">
            @foreach ([
                'nombre' => 'Nombre',
                'segmento' => 'Segmento',
                'categoria' => 'Categoría',
                'registro' => 'Registro',
                'contenido' => 'Contenido',
                'presentaciones' => 'Presentaciones',
                'intervalo_aplicacion' => 'Intervalo de Aplicación',
                'incompatibilidad' => 'Incompatibilidad',
                'certificacion' => 'Certificación',
                'controla' => 'Controla',
                'precio' => 'Precio',
                'cantidad_inventario' => 'Inventario'
            ] as $field => $label)
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="{{ $field }}" class="form-label fw-semibold">{{ __($label) }}</label>
                    <input type="text" name="{{ $field }}" id="{{ $field }}"
                        class="form-control rounded-3 shadow-sm @error($field) is-invalid @enderror"
                        value="{{ old($field, $producto?->$field) }}">
                    @error($field)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach
        </div>

        {{-- Imagen --}}
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <label for="foto" class="form-label fw-semibold w-100 text-center">Foto del producto</label>

                <div class="preview-container rounded-4 p-3 shadow-sm animate-fadein">
                    <div class="image-preview-wrapper mx-auto mb-2 position-relative" id="imagePreview">
                        <button type="button" class="btn btn-close remove-image-btn" aria-label="Eliminar" title="Quitar imagen"></button>
                        <img id="previewImage" src="{{ $producto && $producto->urlFoto 
                            ? (Storage::disk('public')->exists($producto->urlFoto) 
                                ? asset('storage/' . $producto->urlFoto) 
                                : asset('img/generica.png')) 
                            : asset('img/generica.png') }}" alt="Vista previa">
                        <label for="foto" class="image-upload-label">Cambiar imagen</label>
                    </div>
                    <input type="file" name="foto" id="foto" class="custom-file-input" accept="image/*">
                </div>

                @error('foto')
                    <div class="invalid-feedback d-block text-danger text-center mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Botón --}}
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary px-5 py-2 shadow">Guardar</button>
            </div>
        </div>
    </div>
</div>

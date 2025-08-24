<div class="container-fluid mt-5 px-3 px-md-5">
    {{-- Mini menú tipo panel --}}
    <div class="card shadow-sm border-0 mb-4 animate-fadein">
        <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top px-4 py-3">
            <h5 class="mb-0 fw-bold">
                @if(!isset($producto) || !$producto->id)
                    🆕 Registro de Producto
                @else
                    ✏️ Edición de Producto
                @endif
            </h5>
            <a href="{{ route('producto.index') }}" class="btn btn-outline-light btn-sm">
                ← Volver
            </a>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="product-form p-4 shadow bg-white rounded-4 mx-auto mb-5 animate-fadein" style="max-width: 1280px;">
        {{-- Campos (SOLO los que existen en la tabla) --}}
        <div class="row gx-4 gy-4">
            {{-- nombre, segmento, categoria, registro --}}
            @foreach ([
                'nombre'   => 'Nombre',
                'segmento' => 'Segmento',
                'categoria'=> 'Categoría',
                'registro' => 'Registro',
            ] as $field => $label)
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="{{ $field }}" class="form-label fw-semibold">{{ $label }}</label>
                    <input type="text" name="{{ $field }}" id="{{ $field }}"
                           class="form-control rounded-3 shadow-sm @error($field) is-invalid @enderror"
                           value="{{ old($field, $producto?->$field) }}">
                    @error($field)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            {{-- contenido (largo) --}}
            <div class="col-12">
                <label for="contenido" class="form-label fw-semibold">Contenido</label>
                <textarea name="contenido" id="contenido" rows="3"
                          class="form-control rounded-3 shadow-sm @error('contenido') is-invalid @enderror">{{ old('contenido', $producto->contenido ?? '') }}</textarea>
                @error('contenido')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- usoRecomendado (largo) --}}
            <div class="col-12">
                <label for="usoRecomendado" class="form-label fw-semibold">Uso recomendado</label>
                <textarea name="usoRecomendado" id="usoRecomendado" rows="3"
                          class="form-control rounded-3 shadow-sm @error('usoRecomendado') is-invalid @enderror">{{ old('usoRecomendado', $producto->usoRecomendado ?? '') }}</textarea>
                @error('usoRecomendado')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- dosisSugerida, intervaloAplicacion --}}
            @foreach ([
                'dosisSugerida'       => 'Dosis sugerida',
                'intervaloAplicacion' => 'Intervalo de aplicación',
            ] as $field => $label)
                <div class="col-12 col-md-6">
                    <label for="{{ $field }}" class="form-label fw-semibold">{{ $label }}</label>
                    <input type="text" name="{{ $field }}" id="{{ $field }}"
                           class="form-control rounded-3 shadow-sm @error($field) is-invalid @enderror"
                           value="{{ old($field, $producto?->$field) }}">
                    @error($field)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endforeach

            {{-- controla (largo) --}}
            <div class="col-12">
                <label for="controla" class="form-label fw-semibold">Controla</label>
                <textarea name="controla" id="controla" rows="3"
                          class="form-control rounded-3 shadow-sm @error('controla') is-invalid @enderror">{{ old('controla', $producto->controla ?? '') }}</textarea>
                @error('controla')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- PRESENTACIÓN + PDFs (icono clicable) --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label for="presentacion" class="form-label fw-semibold">Presentación</label>
                <input type="text" name="presentacion" id="presentacion"
                       class="form-control rounded-3 shadow-sm @error('presentacion') is-invalid @enderror"
                       value="{{ old('presentacion', $producto->presentacion ?? '') }}">
                @error('presentacion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @php
                // Normalizamos y comprobamos existencia de PDFs en /public
                $fichaPath  = ltrim((string)($producto->fichaTecnica  ?? ''), '/');
                $hojaPath   = ltrim((string)($producto->hojaSeguridad ?? ''), '/');
                $fichaOk    = $fichaPath !== '' && file_exists(public_path($fichaPath));
                $hojaOk     = $hojaPath  !== '' && file_exists(public_path($hojaPath));
            @endphp>

            {{-- FICHA TÉCNICA (PDF) --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label fw-semibold d-block">Ficha técnica (PDF)</label>

                {{-- ruta actual para conservar si no se sube nada --}}
                <input type="hidden" name="fichaTecnica" id="fichaTecnicaRuta" value="{{ old('fichaTecnica', $producto->fichaTecnica ?? '') }}">

                {{-- input file oculto --}}
                <input type="file" name="fichaTecnica_file" id="fichaTecnicaInput" class="d-none" accept="application/pdf">

                <button type="button"
                        class="btn w-100 py-3 border rounded-3 d-flex align-items-center justify-content-center gap-2"
                        onclick="document.getElementById('fichaTecnicaInput').click()">
                    <i class="bi bi-file-earmark-pdf-fill {{ $fichaOk ? 'text-danger' : 'text-dark' }}" style="font-size:1.8rem;"></i>
                    <span id="fichaTecnicaLabel" class="small text-truncate" style="max-width: 75%;">
                        {{ $fichaOk ? basename($fichaPath) : 'Sin archivo' }}
                    </span>
                </button>

                @if($fichaOk)
                    <a href="{{ asset($fichaPath) }}" target="_blank" class="d-inline-block mt-2 small">
                        Abrir archivo actual
                    </a>
                @endif

                @error('fichaTecnica_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            {{-- HOJA DE SEGURIDAD (PDF) --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label class="form-label fw-semibold d-block">Hoja de seguridad (PDF)</label>

                <input type="hidden" name="hojaSeguridad" id="hojaSeguridadRuta" value="{{ old('hojaSeguridad', $producto->hojaSeguridad ?? '') }}">
                <input type="file" name="hojaSeguridad_file" id="hojaSeguridadInput" class="d-none" accept="application/pdf">

                <button type="button"
                        class="btn w-100 py-3 border rounded-3 d-flex align-items-center justify-content-center gap-2"
                        onclick="document.getElementById('hojaSeguridadInput').click()">
                    <i class="bi bi-file-earmark-pdf-fill {{ $hojaOk ? 'text-danger' : 'text-dark' }}" style="font-size:1.8rem;"></i>
                    <span id="hojaSeguridadLabel" class="small text-truncate" style="max-width: 75%;">
                        {{ $hojaOk ? basename($hojaPath) : 'Sin archivo' }}
                    </span>
                </button>

                @if($hojaOk)
                    <a href="{{ asset($hojaPath) }}" target="_blank" class="d-inline-block mt-2 small">
                        Abrir archivo actual
                    </a>
                @endif

                @error('hojaSeguridad_file')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Imagen (fotoProducto / FotoCatalogo) --}}
        <div class="row mt-5 justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <label for="foto" class="form-label fw-semibold w-100 text-center">Foto del producto</label>

                @php
                    // Normalización de imagen igual que en index/show
                    $imgRaw = $producto->FotoCatalogo
                            ?: ($producto->fotoProducto ?? null)
                            ?: ($producto->fotosProducto ?? null)
                            ?: ($producto->urlFoto ?? null);

                    if ($imgRaw) {
                        $imgRaw = ltrim((string)$imgRaw, '/');
                        $imgRaw = preg_replace('#^public/#i', '', $imgRaw);

                        if (!str_contains($imgRaw, '/')) {
                            $ruta = 'img/FotosProducto/' . $imgRaw;
                        } else {
                            $ruta = preg_replace('#^(img/)?Fotos(Productos?|Catalogo)/#i', 'img/FotosProducto/', $imgRaw);
                        }
                    } else {
                        $ruta = 'img/generica.png';
                    }
                @endphp

                <div class="preview-container rounded-4 p-3 shadow-sm animate-fadein">
                    <div class="image-preview-wrapper mx-auto mb-2 position-relative" id="imagePreview">
                        <button type="button" class="btn btn-close remove-image-btn" aria-label="Eliminar" title="Quitar imagen"></button>

                        <img id="previewImage"
                             src="{{ asset($ruta) }}"
                             alt="Vista previa"
                             style="width:100%; max-height:250px; object-fit:contain; object-position:center; background:#fff; border-radius:8px;"
                             onerror="this.onerror=null;this.src='{{ asset('img/generica.png') }}';">

                        <label for="foto" class="image-upload-label">Cambiar imagen</label>
                    </div>

                    {{-- Input de archivo. En el controlador, guarda en fotoProducto o en urlFoto según tu decisión. --}}
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

{{-- === JS mínimo para mostrar nombre del PDF seleccionado === --}}
@push('scripts')
<script>
document.getElementById('fichaTecnicaInput')?.addEventListener('change', function (e) {
    const f = e.target.files?.[0];
    if (f) {
        document.getElementById('fichaTecnicaLabel').textContent = f.name;
        document.querySelector('#fichaTecnicaLabel').previousElementSibling.classList.remove('text-dark');
        document.querySelector('#fichaTecnicaLabel').previousElementSibling.classList.add('text-danger');
    }
});
document.getElementById('hojaSeguridadInput')?.addEventListener('change', function (e) {
    const f = e.target.files?.[0];
    if (f) {
        document.getElementById('hojaSeguridadLabel').textContent = f.name;
        document.querySelector('#hojaSeguridadLabel').previousElementSibling.classList.remove('text-dark');
        document.querySelector('#hojaSeguridadLabel').previousElementSibling.classList.add('text-danger');
    }
});
</script>
@endpush

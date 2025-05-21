@extends('layouts.auth')

@push('styles')
<link href="{{ asset('css/showProducto.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="container py-4">
    <div class="card product-show shadow-lg border-0 animate-fadein">
        <div class="card-header d-flex justify-content-between align-items-center px-4">
            <h4 class="mb-0 fw-bold">📦 Detalles del Producto</h4>
            <a class="btn btn-outline-primary btn-sm text-white" href="{{ route('productos.index') }}">← Volver</a>
        </div>

        <div class="card-body px-5 py-4">
            <div class="row g-4">
                <!-- Detalles -->
                <div class="col-md-8">
                    @foreach([
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
                        <div class="info-block">
                            <div class="info-label"><i class="bi bi-info-circle-fill me-2 text-primary"></i>{{ __($label) }}:</div>
                            <div class="info-value">{{ $producto->$field }}</div>
                        </div>
                    @endforeach

                    <div class="info-block">
                        <div class="info-label"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Ficha Técnica:</div>
                        <div class="info-value">
                            @if($producto->ficha_tecnica)
                                <a href="{{ asset('Hojas tecnicas/' . $producto->ficha_tecnica) }}" target="_blank" class="pdf-link">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Ver archivo
                                </a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="info-label"><i class="bi bi-file-earmark-pdf-fill text-warning me-2"></i>Hoja de Seguridad:</div>
                        <div class="info-value">
                            @if($producto->hoja_seguridad)
                                <a href="{{ asset('Fichas tecnicas/' . $producto->hoja_seguridad) }}" target="_blank" class="pdf-link">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Ver archivo
                                </a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="col-md-4 text-center">
                    @php
                        $localPath = public_path('ImgProductos/' . $producto->urlFoto);
                        $localUrl = asset('ImgProductos/' . $producto->urlFoto);
                        $fallback = asset('img/generica.png');
                    @endphp
                    <img src="{{ file_exists($localPath) && $producto->urlFoto ? $localUrl : $fallback }}"
                         alt="Imagen del producto"
                         class="product-image mb-3">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

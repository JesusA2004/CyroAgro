@extends('layouts.auth')

@section('content')
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="card-title">Mostrar Producto</span>
                    <a class="btn btn-primary btn-sm" href="{{ route('productos.index') }}">Regresar</a>
                </div>
                <div class="card-body bg-white">

                    {{-- Datos del producto --}}
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
                        'cantidad_inventario' => 'Inventario',
                    ] as $field => $label)
                        <div class="mb-2">
                            <strong>{{ __($label) }}:</strong> {{ $producto->$field }}
                        </div>
                    @endforeach

                    {{-- Ficha Técnica --}}
                    <div class="mb-2">
                        <strong>Ficha Técnica:</strong>
                        @if($producto->ficha_tecnica)
                            <a href="{{ asset('archivos/' . $producto->ficha_tecnica) }}" target="_blank">Ver archivo</a>
                        @else
                            <span class="text-muted">No disponible</span>
                        @endif
                    </div>

                    {{-- Hoja de Seguridad --}}
                    <div class="mb-2">
                        <strong>Hoja de Seguridad:</strong>
                        @if($producto->hoja_seguridad)
                            <a href="{{ asset('archivos/' . $producto->hoja_seguridad) }}" target="_blank">Ver archivo</a>
                        @else
                            <span class="text-muted">No disponible</span>
                        @endif
                    </div>

                    {{-- Imagen --}}
                    @php
                        $localPath = public_path('ImgProductos/' . $producto->urlFoto);
                        $localUrl = asset('ImgProductos/' . $producto->urlFoto);
                        $fallback = asset('img/generica.png');
                    @endphp

                    <div class="mb-2">
                        <strong>Imagen del producto:</strong><br>
                        <img src="{{ file_exists($localPath) && $producto->urlFoto ? $localUrl : $fallback }}"
                             alt="Imagen del producto"
                             style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 8px;">
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

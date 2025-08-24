@extends('layouts.auth')

@push('styles')
<link href="{{ asset('css/showProducto.css') }}" rel="stylesheet">
@endpush

@section('content')
<section class="container py-4">
    <div class="card product-show shadow-lg border-0 animate-fadein">
        <div class="card-header d-flex justify-content-between align-items-center px-4">
            <h4 class="mb-0 fw-bold">📦 Detalles del Producto</h4>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-primary btn-sm text-white" href="{{ route('producto.index') }}">
                    ← Volver
                </a>
                <a class="btn btn-outline-primary btn-sm text-white" href="{{ route('producto.edit', $producto->id) }}">
                    ✏️ Modificar
                </a>
                <button type="button" class="btn btn-outline-danger btn-sm text-white" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteModal"
                        data-productid="{{ $producto->id }}">
                    🗑️ Eliminar
                </button>
            </div>
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
                            <div class="info-label">
                                <i class="bi bi-info-circle-fill me-2 text-primary" 
                                title="Información sobre {{ strtolower($label) }}"></i>{{ __($label) }}:
                            </div>
                            <div class="info-value">{{ $producto->$field }}</div>
                        </div>
                    @endforeach

                    <div class="info-block">
                        <div class="info-label"><i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Ficha Técnica:</div>
                        <div class="info-value">
                            @if($producto->ficha_tecnica)
                                <a href="{{ asset('HojasTecnicas/' . $producto->ficha_tecnica) }}" target="_blank" class="pdf-link">
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
                                <a href="{{ asset('FichasTecnicas/' . $producto->hoja_seguridad) }}" target="_blank" class="pdf-link">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Ver archivo
                                </a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if(Auth::user()->role === 'administrador')
                            <div class="info-block">
                                <div class="info-label"><i class="bi bi-calendar-plus text-success me-2"></i>Creado:</div>
                                <div class="info-value">{{ $producto->created_at?->format('d/m/Y H:i') ?? '—' }}</div>
                            </div>
                            <div class="info-block">
                                <div class="info-label"><i class="bi bi-clock-history text-info me-2"></i>Actualizado:</div>
                                <div class="info-value">{{ $producto->updated_at?->format('d/m/Y H:i') ?? '—' }}</div>
                            </div>
                            <div class="info-block">
                                <div class="info-label"><i class="bi bi-person-fill text-success me-2"></i>Creado por:</div>
                                <div class="info-value">{{ $producto->creador?->name ?? 'Desconocido' }}</div>
                            </div>
                            <div class="info-block">
                                <div class="info-label"><i class="bi bi-pencil-fill text-info me-2"></i>Última edición:</div>
                                <div class="info-value">{{ $producto->editor?->name ?? 'Sin cambios' }}</div>
                            </div>
                        @endif
                    @endauth
                </div>

                <!-- Imagen -->
                <div class="col-md-4 text-center">
                    @php
                        // Prioridad: FotoCatalogo → fotoProducto → fotosProducto → genérica
                        $imgRaw = $producto->FotoCatalogo
                                ?: ($producto->fotoProducto ?? null)
                                ?: ($producto->fotosProducto ?? null);

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

                    <img src="{{ asset($ruta) }}"
                         alt="Imagen del producto"
                         class="product-image mb-3"
                         onerror="this.onerror=null;this.src='{{ asset('img/generica.png') }}';">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-3 shadow-lg">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Eliminar producto</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p class="fs-6">¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger px-4">Eliminar</button>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

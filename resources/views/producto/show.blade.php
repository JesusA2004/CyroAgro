{{-- resources/views/producto/show.blade.php --}}
@extends('layouts.auth')

@push('styles')
<link href="{{ asset('css/showProducto.css') }}" rel="stylesheet">
@endpush

@section('content')
@auth
  @php $role = Auth::user()->role ?? null; @endphp
@endauth

<section class="container py-4">
  <div class="card product-show shadow-lg border-0 animate-fadein">
    <div class="card-header d-flex justify-content-between align-items-center px-4">
      <h4 class="mb-0 fw-bold">📦 Detalles del Producto</h4>

      <div class="d-flex gap-2">
        <a class="btn btn-outline-primary btn-sm text-white" href="{{ route('producto.index') }}">
          ← Volver
        </a>

        {{-- Modificar: visible para administrador y empleado --}}
        @auth
          @if($role === 'administrador' || $role === 'empleado')
            <a class="btn btn-outline-primary btn-sm text-white" href="{{ route('producto.edit', $producto->id) }}">
              ✏️ Modificar
            </a>
          @endif
        @endauth

        {{-- Eliminar: SOLO administrador --}}
        @auth
          @if($role === 'administrador')
            <button type="button"
                    class="btn btn-outline-danger btn-sm text-white"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal">
              🗑️ Eliminar
            </button>
          @endif
        @endauth
      </div>
    </div>

    <div class="card-body px-5 py-4">
      <div class="row g-4">
        <!-- Detalles -->
        <div class="col-md-8">
          @foreach([
            'nombre'               => 'Nombre',
            'segmento'             => 'Segmento',
            'categoria'            => 'Categoría',
            'registro'             => 'Registro',
            'contenido'            => 'Contenido',
            'usoRecomendado'       => 'Uso recomendado',
            'dosisSugerida'        => 'Dosis sugerida',
            'intervaloAplicacion'  => 'Intervalo de aplicación',
            'controla'             => 'Controla',
            'presentacion'         => 'Presentación',
          ] as $field => $label)
            @if(!empty($producto->$field))
              <div class="info-block">
                <div class="info-label">
                  <i class="bi bi-info-circle-fill me-2 text-primary"></i>{{ $label }}:
                </div>
                <div class="info-value">{{ $producto->$field }}</div>
              </div>
            @endif
          @endforeach

          {{-- Ficha técnica --}}
          <div class="info-block">
            <div class="info-label">
              <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>Ficha Técnica:
            </div>
            <div class="info-value">
              @if(!empty($producto->fichaTecnica) && file_exists(public_path($producto->fichaTecnica)))
                <a href="{{ asset($producto->fichaTecnica) }}" target="_blank" class="pdf-link">
                  <i class="bi bi-box-arrow-up-right me-1"></i> Ver archivo
                </a>
              @else
                <span class="text-muted">Sin archivo</span>
              @endif
            </div>
          </div>

          {{-- Hoja de seguridad --}}
          <div class="info-block">
            <div class="info-label">
              <i class="bi bi-file-earmark-pdf-fill text-warning me-2"></i>Hoja de Seguridad:
            </div>
            <div class="info-value">
              @if(!empty($producto->hojaSeguridad) && file_exists(public_path($producto->hojaSeguridad)))
                <a href="{{ asset($producto->hojaSeguridad) }}" target="_blank" class="pdf-link">
                  <i class="bi bi-box-arrow-up-right me-1"></i> Ver archivo
                </a>
              @else
                <span class="text-muted">Sin archivo</span>
              @endif
            </div>
          </div>

          {{-- Fechas --}}
          <div class="info-block">
            <div class="info-label">
              <i class="bi bi-calendar-plus text-success me-2"></i>Creado:
            </div>
            <div class="info-value">{{ $producto->created_at?->format('d/m/Y H:i') ?? '—' }}</div>
          </div>
          <div class="info-block">
            <div class="info-label">
              <i class="bi bi-clock-history text-info me-2"></i>Actualizado:
            </div>
            <div class="info-value">{{ $producto->updated_at?->format('d/m/Y H:i') ?? '—' }}</div>
          </div>
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

          <img
            src="{{ asset($ruta) }}"
            alt="Imagen del producto"
            class="product-image mb-3"
            style="max-height: 300px; object-fit: contain; background:#fff; border-radius:8px;"
            onerror="this.onerror=null;this.src='{{ asset('img/generica.png') }}';"
          >
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Modal de eliminación SOLO para admin --}}
@auth
  @if(($role ?? null) === 'administrador')
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow-lg">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="deleteModalLabel">Eliminar producto</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body text-center">
            <p class="fs-6">
              ¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.
            </p>
          </div>
          <div class="modal-footer justify-content-center">
            <form id="deleteForm" method="POST" action="{{ route('producto.destroy', $producto->id) }}">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger px-4">Eliminar</button>
              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif
@endauth
@endsection

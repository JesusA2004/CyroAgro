@extends('layouts.auth')

@push('styles')
<link href="{{ asset('css/productos.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/busquedaProductos.js') }}"></script>
@endpush

@section('content')
<div class="container py-4 px-3">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Productos</h2>
    @auth
      @if (Auth::user()->role === 'administrador' || Auth::user()->role === 'empleado')
        <a href="{{ route('producto.create') }}" class="btn btn-success">
          <i class="fa fa-plus me-2"></i> Registrar nuevo producto
        </a>
      @endif
    @endauth
  </div>

  @if ($message = Session::get('success'))
    <div class="alert alert-success">{{ $message }}</div>
  @endif

  <div class="input-group mb-4 shadow-sm">
    <span class="input-group-text"><i class="fa fa-search"></i></span>
    <input type="text" id="busqueda" class="form-control" placeholder="Buscar producto por nombre...">
  </div>

  <div class="row" id="productContainer">
    @foreach ($productos as $producto)
      @php
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

      <div class="col-sm-6 col-md-4 col-lg-3 mb-4 product-card">
        <div class="card h-100 shadow animate-fadein">
          <div class="position-relative">
            <img src="{{ asset($ruta) }}"
                 class="card-img-top rounded-top img-fluid"
                 alt="Imagen del producto"
                 onerror="this.onerror=null;this.src='{{ asset('img/generica.png') }}';">
          </div>
          <div class="card-body p-3">
            <h5 class="card-title text-truncate">{{ $producto->nombre }}</h5>
            <p class="text-muted small mb-1">{{ $producto->segmento }} | {{ $producto->categoria }}</p>
            <p class="small mb-1"><strong>Registro:</strong> {{ $producto->registro }}</p>
            <p class="small mb-1"><strong>Contenido:</strong> {{ Str::limit($producto->contenido, 40) }}</p>
            <p class="small mb-1"><strong>Presentación:</strong> {{ $producto->presentaciones }}</p>
            <p class="small mb-1"><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</p>
            <p class="small mb-1"><strong>Inventario:</strong> {{ $producto->cantidad_inventario }} Unidades</p>
          </div>
          <div class="crud-actions d-flex justify-content-around py-2">
            <a href="{{ route('producto.show', $producto->id) }}" class="btn btn-outline-primary" title="Ver">
              <i class="fa fa-eye fa-xl"></i>
            </a>
            @auth
              @if (Auth::user()->role === 'administrador')
                <a href="{{ route('producto.edit', $producto->id) }}" class="btn btn-outline-success" title="Editar">
                  <i class="fa fa-edit fa-xl"></i>
                </a>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-productid="{{ $producto->id }}">
                  <i class="fa fa-trash fa-xl"></i>
                </button>
              @elseif (Auth::user()->role === 'empleado')
                <a href="{{ route('producto.edit', $producto->id) }}" class="btn btn-outline-success" title="Editar">
                  <i class="fa fa-edit fa-xl"></i>
                </a>
              @endif
            @endauth
          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{-- ÚNICO paginador (Laravel), centrado y en español --}}
  @if ($productos->hasPages())
    <div class="pagination-wrap">
      {{ $productos->withQueryString()->onEachSide(1)->links() }}
      <div class="pagination-info">
        Mostrando {{ $productos->firstItem() }} a {{ $productos->lastItem() }}
        de {{ $productos->total() }} resultados
      </div>
    </div>
  @endif
</div>

@auth
  @if(Auth::user()->role === 'administrador')
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow-lg">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body text-center">
            <p class="fs-6">¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.</p>
          </div>
          <div class="modal-footer justify-content-center">
            <form id="deleteForm" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-primary px-4">Eliminar</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif
@endauth
@endsection

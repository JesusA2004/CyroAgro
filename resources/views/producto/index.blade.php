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
    <input type="text" id="busqueda" class="form-control" placeholder="Buscar producto por nombre..."
    data-url="{{ route('producto.index') }}"  {{-- mismo endpoint --}}
    >
  </div>

  <div class="row" id="productContainer">
    @include('producto.partials.cards', ['productos' => $productos]) {{-- 👈 usamos el partial --}}
  </div>

  {{-- ÚNICO paginador (Laravel), centrado y en español --}}
  @if ($productos->hasPages())
    <div class="pagination-wrap d-flex flex-column align-items-center gap-2 mt-3">
      {{ $productos->withQueryString()->onEachSide(1)->links() }}
      <div class="pagination-info small text-muted">
        Mostrando {{ $productos->firstItem() }} a {{ $productos->lastItem() }}
        de {{ $productos->total() }} resultados
      </div>
    </div>
  @endif
</div>

@auth
  @if(Auth::user()->role === 'administrador')
    {{-- tu modal de eliminación tal como lo tienes --}}
  @endif
@endauth
@endsection

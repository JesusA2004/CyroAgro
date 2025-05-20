@extends('layouts.public')

<br><br><br><br>

@section('content')
<link rel="stylesheet" href="{{ asset('css/hojasSeguridad.css') }}">

<div class="container mt-5">
  <h1 class="text-center mb-4">Hojas de Seguridad</h1>

  <div class="row">
    @forelse($hojasSeguridad as $hoja)
      <div class="col-md-4 mb-4">
        <div class="card hoja-card h-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $hoja->titulo }}</h5>
            <p class="card-text">{{ Str::limit($hoja->descripcion, 100) }}</p>
            <a href="{{ route('hojas_seguridad.show', $hoja->id) }}" class="mt-auto btn btn-outline-primary btn-readmore">
              Leer más
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <p class="text-center text-muted">No hay hojas de seguridad disponibles.</p>
      </div>
    @endforelse
  </div>

  @if(method_exists($hojasSeguridad, 'links'))
    <div class="d-flex justify-content-center">
      {{ $hojasSeguridad->links() }}
    </div>
  @endif
</div>
@endsection


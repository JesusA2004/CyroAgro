@extends('layouts.public')

@section('title', 'Registros COFEPRIS')

@section('content')
  <div class="container mt-5 registros-container">
    <h1 class="text-center mb-4">Registros COFEPRIS</h1>
    <div class="row">
      @foreach($registrosCofepris as $registro)
        <div class="col-md-4 mb-4">
          <div class="card registro-card h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $registro->nombre_producto }}</h5>
              <p class="card-text">Número de registro: <strong>{{ $registro->numero }}</strong></p>
              <p class="card-text">Fecha de emisión: {{ $registro->fecha_emision->format('d/m/Y') }}</p>
              <a href="{{ route('registros.cofepris.download', $registro->id) }}" class="mt-auto btn btn-primary btn-download">
                Descargar PDF
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="d-flex justify-content-center">
      {{ $registrosCofepris->links() }}
    </div>
  </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/registros.css') }}">
@endpush
@extends('layouts.public')

@section('title', 'Registros OMRI')

@section('content')
  <div class="container mt-5 registros-container">
    <h1 class="text-center mb-4">Registros OMRI</h1>
    <div class="row">
      @foreach($registrosOmri as $registro)
        <div class="col-md-4 mb-4">
          <div class="card registro-card h-100">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $registro->nombre_producto }}</h5>
              <p class="card-text">Certificado OMRI: <strong>{{ $registro->codigo_certificado }}</strong></p>
              <p class="card-text">Valido hasta: {{ $registro->fecha_vigencia->format('d/m/Y') }}</p>
              <a href="{{ route('registros.omri.download', $registro->id) }}" class="mt-auto btn btn-primary btn-download">
                Descargar PDF
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="d-flex justify-content-center">
      {{ $registrosOmri->links() }}
    </div>
  </div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/registros.css') }}">
@endpush
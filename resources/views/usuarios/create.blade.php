<!-- resources/views/usuarios/create.blade.php -->
@extends('layouts.auth')

@section('content')
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Registrar usuario nuevo</h1>
    <form action="{{ route('usuarios.store') }}" method="POST">
      @csrf              {{-- <-- Asegúrate de esto --}}
      @include('usuarios.form')
    </form>
  </div>
</main>
@endsection

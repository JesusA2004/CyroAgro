@extends('layouts.public')

@section('title', 'Fichas Técnicas - C Y R Agro')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/hojasSeguridad.css') }}">

    <header class="ft-masthead text-white text-center py-5">
        <div class="container">
            <h1 class="display-4">Fichas Técnicas</h1>
            <p class="lead">Explora información técnica sobre nuestros productos</p>
        </div>
    </header>

    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg ft-card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Consulta nuestras fichas técnicas</h4>
                        <p class="card-text">Aquí podrás encontrar información detallada sobre la composición, uso y manejo de nuestros productos agrícolas.</p>
                        <a href="#" class="btn btn-outline-primary">Descargar catálogo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('includes.footer')
@endsection

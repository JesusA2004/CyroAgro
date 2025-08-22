@extends('layouts.public')

@section('content')
@push('styles')
    <link href="{{ asset('css/nosotros.css') }}" rel="stylesheet">
@endpush

{{-- HERO superior con onda (ya estilizado en nosotros.css) --}}
<section class="hero-section text-center d-flex align-items-center justify-content-center">
    <div class="overlay"></div>
    <div class="container position-relative z-1">
    </div>
</section>

{{-- BLOQUE ¿QUIÉNES SOMOS? (como en la imagen) --}}
<section id="about" class="bg-white pt-5">
    <div class="container">

        {{-- Título grande debajo de la onda --}}
        <div class="row">
            <div class="col-12">
                <h2 class="display-6 fw-semibold mb-4" style="color:#2b7a77;">¿Quiénes somos?</h2>
            </div>
        </div>

        {{-- Dos columnas: imagen arriba, título y texto abajo --}}
        <div class="row g-5 align-items-start">

            {{-- Columna MISIÓN --}}
            <div class="col-lg-6">
                <div class="position-relative rounded-3 overflow-hidden shadow-sm mb-3">
                    {{-- Usa aquí tu imagen de la izquierda (la del monitor con iconos) --}}
                    <img src="{{ asset('img/mision.png') }}" class="w-100 d-block" alt="Misión CYR">
                </div>

                <div class="d-flex align-items-center gap-2 mb-2">
                    <h3 class="h3 m-0 section-title"><strong>Misión</strong></h3>
                </div>

                <p class="texto-justificado">
                    Ser una empresa de Primer Nivel en su calidad de operación y capacidad de apoyo a los Agricultores,
                    para que puedan producir eficientemente, asesorándolos y promoviendo nuestra línea de productos
                    Agroquímicos y Orgánicos a través de nuestros representantes y distribuidores a lo largo de la República.
                </p>
                <p class="texto-justificado">
                    Proveer de manera eficiente el paquete tecnológico más adecuado para el suministro correcto a los cultivos
                    de nuestros clientes, y así permitir el desarrollo competitivo de una agricultura saludable en nuestro país.
                </p>
            </div>

            {{-- Columna OBJETIVO --}}
            <div class="col-lg-6">
                <div class="position-relative rounded-3 overflow-hidden shadow-sm mb-3">
                    {{-- Usa aquí tu imagen de la derecha (la de los gráficos de colores) --}}
                    <img src="{{ asset('img/objetivo.png') }}" class="w-100 d-block" alt="Objetivo CYR">
                </div>

                <div class="d-flex align-items-center gap-2 mb-2">
                    <h3 class="h3 m-0 section-title"><strong>Objetivo</strong></h3>
                </div>

                <p class="texto-justificado">
                    Lograr la presencia de nuestra línea de productos Agroquímicos y Orgánicos con los productores en
                    todas las regiones donde exista potencial de aplicación, mejorando la productividad de nuestros clientes.
                </p>
            </div>

        </div>
    </div>
</section>
@endsection

@section('footer')
    @include('includes.footer')
@endsection

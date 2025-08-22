@extends('layouts.public')

@section('title', 'Detalle de producto - CYR Agro')

@section('content')
    <!--
        Vista de detalle de producto

        Esta plantilla está diseñada para mostrar la información detallada de un producto de manera atractiva y moderna.
        Incluye un encabezado (hero) con imagen de fondo y una onda decorativa inferior, un icono en forma de hexágono
        para representar la categoría del producto, y un contenedor con la imagen del producto y sus datos técnicos.
        Ajusta las rutas de las imágenes en función de tus propios archivos en la carpeta public/img.
    -->

    <header class="product-hero position-relative overflow-hidden">
        <!-- Capa de oscurecimiento -->
        <div class="hero-overlay"></div>
        <!-- Texto del hero -->
        <div class="container h-100 d-flex flex-column justify-content-center align-items-start text-white">
            <h2 class="display-4 fw-bold" data-aos="fade-right">
                Llevamos <span class="text-highlight">hasta ti</span> productos de alta <span class="text-highlight">calidad</span>
            </h2>
        </div>
        <!-- Icono hexagonal -->
        <div class="hex-icon product-icon position-absolute" style="top: 50%; right: 5%; transform: translateY(-50%);" data-aos="zoom-in">
            <i class="fa-solid fa-prescription-bottle-medical"></i>
        </div>
        <!-- Onda decorativa en la parte inferior -->
        <div class="hero-wave position-absolute start-0 end-0 bottom-0">
            <svg viewBox="0 0 1440 110" xmlns="http://www.w3.org/2000/svg">
                <path fill="#0e8e99" fill-opacity="1" d="M0,64L60,69.3C120,75,240,85,360,85.3C480,85,600,75,720,64C840,53,960,43,1080,37.3C1200,32,1320,32,1380,32L1440,32V110H1380C1320,110,1200,110,1080,110C960,110,840,110,720,110C600,110,480,110,360,110C240,110,120,110,60,110H0Z" />
            </svg>
        </div>
    </header>

    <!-- Sección de detalle del producto -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4 align-items-start">
                <!-- Imagen del producto -->
                <div class="col-md-4 text-center" data-aos="fade-up">
                    <img src="{{ asset('img/productos/canela.png') }}" alt="Imagen del producto" class="img-fluid shadow" style="max-height: 420px; object-fit: contain;">
                    <p class="mt-2 small fst-italic text-muted">Precaución</p>
                </div>
                <!-- Información del producto -->
                <div class="col-md-8" data-aos="fade-left" data-aos-delay="100">
                    <div class="product-info border rounded-3 bg-white shadow-sm overflow-hidden">
                        <!-- Título de categoría -->
                        <div class="bg-success text-white px-3 py-2">
                            <h5 class="mb-0 fw-bold text-uppercase">Bioinsecticida</h5>
                        </div>
                        <!-- Contenido -->
                        <div class="p-4">
                            <p class="fw-bold mb-1">Registro: RSCO-INAC-0104R-301-015-015</p>
                            <p class="mb-4">
                                <strong>Ingrediente activo:</strong> Extracto de Canela (<em>Cinnamomum zeylanicum</em>), emulsión aceite en agua (15.0%).
                            </p>
                            <!-- Lista de plagas controladas -->
                            <h6 class="fw-bold text-success mb-2">Controla:</h6>
                            <ul class="list-unstyled row">
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Araña roja (<em>Oligonychus punicea</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Trips (<em>Trips tabaci</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Araña roja (<em>Tetranychus urticae</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Trips (<em>Frankliniella occidentalis</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Mosca blanca (<em>Bemisia tabaci</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Psílido asiático (<em>Diaphorina citri</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Ácaro blanco (<em>Polyphagotarsonemus latus</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Piojo harinoso (<em>Planococcus citri</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Cochinilla (<em>Dactylopius coccus</em>)</li>
                                <li class="col-sm-6 mb-1"><i class="fa-solid fa-bug me-2 text-success"></i>Pulgón (<em>Aphis illinoisensis</em>)</li>
                            </ul>
                            <!-- Lista de cultivos -->
                            <h6 class="fw-bold text-success mt-4 mb-2">Uso en los siguientes cultivos:</h6>
                            <div class="row small">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>Aguacate</li>
                                        <li>Ajo</li>
                                        <li>Adriano</li>
                                        <li>Cebolla</li>
                                        <li>Esparrago</li>
                                        <li>Frambuesa</li>
                                        <li>Fresa</li>
                                        <li>Lima</li>
                                        <li>Limonero</li>
                                        <li>Mandarina</li>
                                        <li>Naranja</li>
                                        <li>Nopal</li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>Papaya</li>
                                        <li>Pepino</li>
                                        <li>Pimiento</li>
                                        <li>Sandía</li>
                                        <li>Tomate</li>
                                        <li>Toroño</li>
                                        <li>Vid</li>
                                        <li>Calabacita</li>
                                        <li>Zanahoria</li>
                                        <li>Berenjena</li>
                                        <li>Chile</li>
                                        <li>Chayote</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Hero del detalle de producto */
        .product-hero {
            min-height: 60vh;
            background-image: url('{{ asset('img/hero-producto.jpg') }}');
            background-size: cover;
            background-position: center;
        }
        .product-hero .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 1;
        }
        .product-hero h2 {
            position: relative;
            z-index: 2;
        }
        .product-hero .product-icon {
            z-index: 3;
            width: 90px;
            height: 90px;
            background-color: #68c4ad;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            clip-path: polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%);
            font-size: 2rem;
        }
        .product-hero .hero-wave {
            height: 110px;
            overflow: hidden;
            pointer-events: none;
            z-index: 2;
        }
        .product-info .bg-success {
            background-color: #0e8e99 !important;
        }
        .text-highlight {
            color: #68c4ad;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('js/producto.js') }}"></script>
@endpush
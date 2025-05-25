@extends('layouts.public')

@section('content')
    <!-- Carrusel simplificado -->
    <header class="position-relative">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="10000">
            <img src="{{ asset('img/slides/bg_1.jpg') }}" alt="Banner" class="d-block w-100" alt="...">
            <div class="overlay"></div>
            <div class="carousel-caption d-md-block">
            <h5>Bienvenido a CYR AGROQUÍMICA</h5>
            <p>Llevamos hasta ti productos de alta calidad</p>
            <a class="btn btn-primary btn-xl text-uppercase page-scroll" href="#services">Leer más</a>
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="5000">
            <img src="{{ asset('img/slides/bg_2.jpg') }}" alt="Banner" class="d-block w-100" alt="...">
            <div class="overlay"></div>
            <div class="carousel-caption d-md-block">
            <h5>Protección para tus cultivos</h5>
            <p>Soluciones efectivas para el campo mexicano</p>
            <a class="btn btn-primary btn-xl text-uppercase page-scroll" href="#services">Leer más</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/slides/bg_3.jpg') }}" alt="Banner" class="d-block w-100" alt="...">
            <div class="overlay"></div>
            <div class="carousel-caption d-md-block">
            <h5>Calidad garantizada</h5>
            <p>Productos certificados y de confianza</p>
            <a class="btn btn-primary btn-xl text-uppercase page-scroll" href="#services">Leer más</a>
            </div>
        </div>
        </div>
            <!-- Controles del carrusel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </header>

    <!-- Sección Consulta Rápida -->
    <section id="services" class="page-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <h2 class="section-heading text-uppercase">Consulta rápida</h2>
                <h3 class="section-subheading text-muted">Accede a nuestras secciones informativas</h3>
            </div>
            <div class="row justify-content-center">
                @foreach ([
                    ['icon' => 'fa-lock', 'title' => 'Hojas de seguridad', 'route' => 'hojas_seguridad.index'],
                    ['icon' => 'fa-file-alt', 'title' => 'Hojas técnicas', 'route' => 'fichas_tecnicas.index'],
                    ['icon' => 'fa-book', 'title' => 'Registros COFEPRIS', 'route' => 'registros.cofepris'],
                    ['icon' => 'fa-seedling', 'title' => 'Registros OMRI', 'route' => 'registros.omri'],
                ] as $item)
                    <div class="col-lg-3 col-md-6 mb-4" 
                         data-aos="fade-up" 
                         data-aos-delay="{{ $loop->index * 100 }}">
                        <a class="card-hover" href="{{ route($item['route']) }}">
                            <div class="service-card">
                                <div class="card-front">
                                    <div class="icon-wrapper">
                                        <i class="fas {{ $item['icon'] }} fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="mt-3">{{ $item['title'] }}</h4>
                                </div>
                                <div class="card-back">
                                    <div class="icon-wrapper">
                                        <i class="fas fa-arrow-circle-right fa-3x text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sección Portfolio (Nuestros productos) -->
    <section id="portfolio" class="page-section bg-light">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-heading text-uppercase">Nuestros productos</h2>
            </div>
            <div class="row">
                @foreach ([
                    ['id' => 2, 'img' => 'bg_Organicos.jpg', 'alt' => 'Orgánicos', 'modal' => '#portfolioModal1'],
                    ['id' => 1, 'img' => 'bg_Agroquimicos.jpg', 'alt' => 'Agroquímicos', 'modal' => '#portfolioModal2'],
                ] as $col)
                    <div class="col-md-6 mb-5" 
                         data-aos="{{ $loop->odd ? 'fade-right' : 'fade-left' }}" 
                         data-aos-delay="{{ $loop->index * 200 }}">
                        <div class="portfolio-item mx-auto">
                            <a class="portfolio-link" data-bs-toggle="modal" href="{{ $col['modal'] }}">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content">
                                        <i class="fas fa-plus fa-3x"></i>
                                    </div>
                                </div>
                                <img class="img-fluid rounded shadow-lg" 
                                     src="{{ asset('img/' . $col['img']) }}" 
                                     alt="{{ $col['alt'] }}">
                            </a>
                            <div class="portfolio-caption">
                                <h4 class="portfolio-caption-heading mt-3">{{ $col['alt'] }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sección Productos Estrella -->
    <section id="about" class="page-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="zoom-in">
                <h2 class="section-heading text-uppercase">Productos estrella</h2>
            </div>
            <div class="row">
                @foreach([22 => 'OMEX DP 98', 23 => 'OMEX ZN 70', 20 => 'OMEX BIO 20'] as $img => $title)
                    <div class="col-md-4" 
                         data-aos="zoom-in-up" 
                         data-aos-delay="{{ $loop->index * 150 }}">
                        <div class="product-card">
                            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal{{ $loop->iteration + 2 }}">
                                <div class="image-overlay"></div>
                                <img src="{{ asset('img/productosDestacados/' . $img . '.jpg') }}" 
                                     class="img-fluid rounded shadow" 
                                     alt="{{ $title }}">
                                <div class="card-content">
                                    <h5 class="product-title">{{ $title }}</h5>
                                    <p class="product-description">Conoce más sobre los nutrientes que fortalecen tus cultivos.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/index.js') }}"></script>
@endpush

@section('footer')
    @include('includes.footer')
@endsection
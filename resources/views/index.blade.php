@extends('layouts.public')

@section('title', 'Inicio')

@section('content')
    <!-- Masthead -->
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Bienvenido a CYR AGROQUÍMICA</div>
            <div class="masthead-heading text-uppercase">Llevamos hasta ti productos de alta calidad</div>
            <a class="btn btn-primary btn-xl text-uppercase page-scroll" href="#services">Leer más</a>
        </div>
    </header>

    <!-- Services (Consulta rápida) -->
    <section id="services" class="page-section">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Consulta rápida</h2>
                <h3 class="section-subheading text-muted">Accede a nuestras secciones informativas</h3>
            </div>
            <div class="row text-center">
                 @foreach ([
                    ['icon' => 'fa-lock',     'title' => 'Hojas de seguridad', 'route' => 'hojas_seguridad.index'],
                    ['icon' => 'fa-file-alt', 'title' => 'Hojas técnicas',     'route' => 'fichas_tecnicas.index'],
                    ['icon' => 'fa-book',     'title' => 'Registros COFEPRIS','route' => 'registros.cofepris'],
                    ['icon' => 'fa-seedling', 'title' => 'Registros OMRI',     'route' => 'registros.omri'],
                ] as $item)
                    <div class="col-md-3 col-sm-6">
                        <a class="page-scroll" href="{{ route($item['route']) }}">
                            <span class="fa-stack fa-4x mb-3">
                                <i class="fas fa-circle fa-stack-2x text-primary"></i>
                                <i class="fas {{ $item['icon'] }} fa-stack-1x fa-inverse"></i>
                            </span>
                            <h4 class="my-3">{{ $item['title'] }}</h4>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Portfolio (Nuestros productos) -->
    <section id="portfolio" class="page-section bg-light">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Nuestros productos</h2>
            </div>
            <div class="row">
                @foreach ([
                    ['id' => 2, 'img' => 'bg_Organicos.jpg', 'alt' => 'Orgánicos',   'modal' => '#portfolioModal1'],
                    ['id' => 1, 'img' => 'bg_Agroquimicos.jpg', 'alt' => 'Agroquímicos','modal' => '#portfolioModal2'],
                ] as $col)
                    <div class="col-md-6 mb-4">
                        <div class="portfolio-item mx-auto">
                            <a class="portfolio-link" data-bs-toggle="modal" href="{{ $col['modal'] }}">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid rounded" src="{{ asset('img/' . $col['img']) }}" alt="{{ $col['alt'] }}">
                            </a>
                            <div class="portfolio-caption">
                                <h4 class="portfolio-caption-heading">{{ $col['alt'] }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- About (Productos estrella) -->
    <section id="about" class="page-section">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Productos estrella</h2>
            </div>
            <div class="row">
                @foreach([22 => 'OMEX DP 98', 23 => 'OMEX ZN 70', 20 => 'OMEX BIO 20'] as $img => $title)
                <div class="col-md-4 mb-4">
                    <div class="portfolio-item mx-auto">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal{{ $loop->iteration + 2 }}">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img src="{{ asset('assets/img/works/full/' . $img . '.jpg') }}" class="img-fluid rounded" alt="{{ $title }}">
                        </a>
                        <div class="portfolio-caption">
                            <h5 class="portfolio-caption-heading">{{ $title }}</h5>
                            <p class="portfolio-caption-subheading text-muted">Conoce más sobre los nutrientes que fortalecen tus cultivos.</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('footer')
    @include('includes.footer')
@endsection

@extends('layouts.public')

@section('title', 'Inicio')

@section('content')
    <!-- Masthead -->
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Bienvenido a CYR AGROQUÍMICA</div>
            <div class="masthead-heading text-uppercase">Llevamos hasta ti productos de alta calidad</div>
            <a class="btn btn-primary btn-xl text-uppercase" href="#services">Leer más</a>
        </div>
    </header>

    <!-- Services (Consulta rápida) -->
    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Consulta rápida</h2>
                <h3 class="section-subheading text-muted">Accede a nuestras secciones informativas</h3>
            </div>
            <div class="row text-center">
                <div class="col-md-3">
                    <a href="hojas_seguridad.php" class="text-decoration-none">
                        <div class="card h-100 p-3">
                            <i class="fas fa-lock fa-2x mb-3"></i>
                            <h5>Hojas de seguridad</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="fichas_tecnicas.php" class="text-decoration-none">
                        <div class="card h-100 p-3">
                            <i class="fas fa-file-alt fa-2x mb-3"></i>
                            <h5>Hojas técnicas</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="registros.php" class="text-decoration-none">
                        <div class="card h-100 p-3">
                            <i class="fas fa-book fa-2x mb-3"></i>
                            <h5>Registros COFEPRIS</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="registrosOMRI.php" class="text-decoration-none">
                        <div class="card h-100 p-3">
                            <i class="fas fa-seedling fa-2x mb-3"></i>
                            <h5>Registros OMRI</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio (Nuestros productos) -->
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Nuestros productos</h2>
            </div>
            <div class="row text-center">
                <div class="col-md-6 mb-4">
                    <h4>Orgánicos</h4>
                    <a href="productos.php?Segmento_ID=2">
                        <img class="img-fluid rounded" src="{{ asset('img/bg_Organicos.jpg') }}" alt="Organicos">
                    </a>
                </div>
                <div class="col-md-6 mb-4">
                    <h4>Agroquímicos</h4>
                    <a href="productos.php?Segmento_ID=1">
                        <img class="img-fluid rounded" src="{{ asset('img/bg_Agroquimicos.jpg') }}" alt="Agroquimicos">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About (Productos estrella) -->
    <section class="page-section" id="about">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Productos estrella</h2>
            </div>
            <div class="row">
                @foreach([22 => 'OMEX DP 98', 23 => 'OMEX ZN 70', 20 => 'OMEX BIO 20'] as $img => $title)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('assets/img/works/full/' . $img . '.jpg') }}" class="card-img-top" alt="{{ $title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $title }}</h5>
                            <p class="card-text">Conoce más sobre los nutrientes que fortalecen tus cultivos.</p>
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

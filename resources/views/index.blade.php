@extends('layouts.public')

@section('content')
  <!-- Carrusel simplificado -->
  <header class="position-relative overflow-hidden" data-aos="fade">
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0"
                class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        @foreach ([
          ['img'=>'bg_1.jpg','h'=>'Bienvenido a CYR AGROQUÍMICA','p'=>'Llevamos hasta ti productos de alta calidad'],
          ['img'=>'bg_2.jpg','h'=>'Protección para tus cultivos','p'=>'Soluciones efectivas para el campo mexicano'],
          ['img'=>'bg_3.jpg','h'=>'Calidad garantizada','p'=>'Productos certificados y de confianza'],
        ] as $i => $slide)
        <div class="carousel-item @if($i===0) active @endif" data-bs-interval="{{ $i===0 ? 10000 : 5000 }}">
          <img src="{{ asset('img/slides/'.$slide['img']) }}"
               class="d-block w-100" style="height:100vh;object-fit:cover;filter:brightness(.5)" alt="...">
          <div class="overlay"></div>
          <div class="carousel-caption d-md-block">
            <h5>{{ $slide['h'] }}</h5>
            <p>{{ $slide['p'] }}</p>
            <a class="btn btn-success btn-xl text-uppercase page-scroll" href="#services">Leer más</a>
          </div>
        </div>
        @endforeach
      </div>
      <button class="carousel-control-prev" type="button"
              data-bs-target="#carouselExampleDark" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
      </button>
      <button class="carousel-control-next" type="button"
              data-bs-target="#carouselExampleDark" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
      </button>
    </div>
  </header>

  <!-- Consulta rápida -->
  <section id="services" class="page-section" data-aos="fade-up">
    <div class="container">
      <div class="text-center mb-5" data-aos="fade-down">
        <h2 class="section-heading text-uppercase">Consulta rápida</h2>
        <h3 class="section-subheading text-muted">Accede a nuestras secciones informativas</h3>
      </div>
      <div class="row gx-3 gy-4 justify-content-center">
        @foreach ([
          ['icon'=>'fa-lock','title'=>'Hojas de seguridad','route'=>'hojas_seguridad.index'],
          ['icon'=>'fa-file-alt','title'=>'Hojas técnicas','route'=>'fichas_tecnicas.index'],
          ['icon'=>'fa-book','title'=>'Registros COFEPRIS','route'=>'registros.cofepris'],
          ['icon'=>'fa-seedling','title'=>'Registros OMRI','route'=>'registros.omri'],
        ] as $item)
        <div class="col-12 col-sm-6 col-md-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          <a class="card-hover" href="{{ route($item['route']) }}">
            <div class="service-card">
              <div class="card-front text-center p-4">
                <i class="fas {{ $item['icon'] }} fa-3x text-primary"></i>
                <h4 class="mt-3">{{ $item['title'] }}</h4>
              </div>
              <div class="card-back text-center p-4">
                <i class="fas fa-arrow-circle-right fa-3x text-white"></i>
              </div>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Portfolio -->
  <section id="portfolio" class="page-section bg-light" data-aos="fade-up">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-heading text-uppercase">Nuestros productos</h2>
      </div>
      <div class="row gx-0 gx-md-3 gy-4">
        @foreach ([
          ['img'=>'bg_Organicos.jpg','alt'=>'Orgánicos','modal'=>'#portfolioModal1'],
          ['img'=>'bg_Agroquimicos.jpg','alt'=>'Agroquímicos','modal'=>'#portfolioModal2'],
        ] as $col)
        <div class="col-12 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 150 }}">
          <div class="portfolio-item mx-auto">
            <a class="portfolio-link" data-bs-toggle="modal" href="{{ $col['modal'] }}">
              <div class="portfolio-hover">
                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
              </div>
              <img class="img-fluid rounded shadow-lg" src="{{ asset('img/'.$col['img']) }}" alt="{{ $col['alt'] }}">
            </a>
            <div class="portfolio-caption text-center mt-3">
              <h4>{{ $col['alt'] }}</h4>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Productos estrella -->
  <section id="about" class="page-section" data-aos="fade-up">
    <div class="container">
      <div class="text-center mb-5" data-aos="zoom-in">
        <h2 class="section-heading text-uppercase">Productos estrella</h2>
      </div>
      <div class="row gx-0 gx-md-3 gy-4">
        @foreach ([22=>'OMEX DP 98',23=>'OMEX ZN 70',20=>'OMEX BIO 20'] as $img=>$title)
        <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 150 }}">
          <div class="product-card position-relative overflow-hidden">
            <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal{{ $loop->iteration + 2 }}">
              <img src="{{ asset('img/productosDestacados/'.$img.'.jpg') }}"
                   class="img-fluid rounded shadow" alt="{{ $title }}">
              <div class="card-content text-white p-4">
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

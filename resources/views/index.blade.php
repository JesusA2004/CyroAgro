@extends('layouts.public')

@section('content')
  <!-- HERO con “onda” de destacados -->
  <header class="hero position-relative overflow-hidden">
    <picture>
      <img class="hero-bg"
           src="{{ asset('img/bannerContacto.png') }}"
           alt="Campo agrícola al amanecer"
           loading="eager"
           decoding="async">
    </picture>

    <!-- Onda de íconos destacados -->
    <div class="wave-strip" id="waveStrip" aria-label="Productos destacados">
      @php
        // Usa tu colección real: Product::featured()->get()
        $destacados = $destacados ?? collect([
          (object)['id'=>22,'titulo'=>'OMEX DP 98','img'=>'22.jpg','url'=>route('fichas_tecnicas.index')],
          (object)['id'=>23,'titulo'=>'OMEX ZN 70','img'=>'23.jpg','url'=>route('fichas_tecnicas.index')],
          (object)['id'=>20,'titulo'=>'OMEX BIO 20','img'=>'20.jpg','url'=>route('fichas_tecnicas.index')],
        ]);
      @endphp

      @foreach ($destacados as $p)
        <a class="wave-item" href="{{ $p->url }}" title="{{ $p->titulo }}" data-title="{{ $p->titulo }}">
          <img src="{{ asset('img/productosDestacados/'.$p->img) }}" alt="{{ $p->titulo }}" loading="lazy" decoding="async">
        </a>
      @endforeach
    </div>

    <div class="container position-relative z-1">
      <div class="row align-items-center min-vh-100">
        <div class="col-12 col-lg-8">
          <h1 class="display-4 fw-bold mb-3 reveal lh-1">Soluciones integrales para el campo</h1>
          <p class="lead text-white-50 mb-4 reveal pe-lg-5" style="max-width:56ch">
            Productos con respaldo técnico para impulsar el rendimiento y la sanidad de tus cultivos en México.
          </p>
          <div class="d-flex flex-wrap gap-3 reveal mb-4">
            <a href="#lineas" class="btn btn-success btn-xxl btn-glow">Ver líneas de producto</a>
            <a href="{{ route('contacto') }}" class="btn btn-outline-light btn-xxl btn-outline-glow">Contacto</a>
          </div>
        </div>
      </div>
    </div>

    <div class="shape-divider">
      <svg viewBox="0 0 1200 120" preserveAspectRatio="none" aria-hidden="true">
        <path d="M1200 0L0 0 0 46.29 1200 120 1200 0z"></path>
      </svg>
    </div>
  </header>

  <!-- LÍNEAS DE PRODUCTO -->
  <section id="lineas" class="py-6 bg-body-tertiary">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="display-6 fw-bold mb-2 reveal">Líneas de producto</h2>
        <p class="text-muted reveal">Explora nuestras categorías principales</p>
      </div>

      <div class="row g-4">
        @foreach ([
          ['icon'=>'fa-seedling','title'=>'Fertilizantes y Bioestimulantes','desc'=>'Formulaciones para nutrición eficiente y vigor vegetal.'],
          ['icon'=>'fa-flask','title'=>'Coadyuvantes y Bioadhesivos','desc'=>'Mejoran cobertura, adherencia y compatibilidad.'],
          ['icon'=>'fa-shield-alt','title'=>'Protección de Cultivos','desc'=>'Manejo integrado con soluciones confiables.'],
          ['icon'=>'fa-leaf','title'=>'Orgánicos y Especialidades','desc'=>'Opciones certificables y de baja huella ambiental.'],
        ] as $i => $card)
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="feature-card h-100 p-4 reveal tilt" style="--d:{{ $i * 80 }}ms">
            <div class="icon-wrap mb-3">
              <i class="fas {{ $card['icon'] }} fa-2x"></i>
            </div>
            <h3 class="h5 fw-bold mb-2">{{ $card['title'] }}</h3>
            <p class="text-muted mb-0">{{ $card['desc'] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- DOCUMENTACIÓN TÉCNICA -->
  <section id="accesos" class="py-6">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="display-6 fw-bold mb-2 reveal">Documentación técnica</h2>
        <p class="text-muted reveal">Consulta fichas, hojas de seguridad y registros</p>
      </div>

      <div class="row g-4 justify-content-center">
        @foreach ([
          ['title'=>'Hojas de seguridad','icon'=>'fa-lock','route'=>'hojas_seguridad.index'],
          ['title'=>'Hojas técnicas','icon'=>'fa-file-alt','route'=>'fichas_tecnicas.index'],
          ['title'=>'Registros COFEPRIS','icon'=>'fa-book','route'=>'registros.cofepris'],
          ['title'=>'Registros OMRI','icon'=>'fa-seedling','route'=>'registros.omri'],
        ] as $i => $item)
        <div class="col-12 col-sm-6 col-lg-3">
          <a class="quick-link reveal hover-shift" style="--d:{{ $i * 80 }}ms" href="{{ route($item['route']) }}">
            <span class="ql-icon"><i class="fas {{ $item['icon'] }}"></i></span>
            <span class="ql-text">{{ $item['title'] }}</span>
            <span class="ql-arrow"><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- MÉTRICAS -->
  <section id="metricas" class="py-6">
    <div class="container">
      <div class="row g-4 text-center">
        <div class="col-6 col-lg-3">
          <div class="stat reveal">
            <div class="stat-num" data-count="15">0</div>
            <div class="stat-label">Años de experiencia</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat reveal">
            <div class="stat-num" data-count="120">0</div>
            <div class="stat-label">Presentaciones activas</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat reveal">
            <div class="stat-num" data-count="9">0</div>
            <div class="stat-label">Líneas de producto</div>
          </div>
        </div>
        <div class="col-6 col-lg-3">
          <div class="stat reveal">
            <div class="stat-num" data-count="32">0</div>
            <div class="stat-label">Estados con presencia</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section id="contacto-cta" class="py-6 bg-success text-white position-relative overflow-hidden">
    <div class="container position-relative z-1">
      <div class="row align-items-center">
        <div class="col-12 col-lg-8">
          <h2 class="display-6 fw-bold mb-2 reveal">¿Lista la siguiente aplicación?</h2>
          <p class="mb-0 reveal">Cuéntanos tu cultivo y te proponemos un programa técnico con respaldo de hoja de seguridad y ficha.</p>
        </div>
        <div class="col-12 col-lg-4 text-lg-end mt-3 mt-lg-0">
          <a href="{{ route('contacto') }}" class="btn btn-outline-light btn-xxl btn-outline-glow reveal">Hablar con un asesor</a>
        </div>
      </div>
    </div>
    <div class="cta-pattern" aria-hidden="true"></div>
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

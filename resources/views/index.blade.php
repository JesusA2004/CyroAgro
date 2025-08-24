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
          (object)['id'=>22,'titulo'=>'OMEX DP 98','img'=>'22.jpg','url'=>route('productos.index')],
          (object)['id'=>23,'titulo'=>'OMEX ZN 70','img'=>'23.jpg','url'=>route('productos.index')],
          (object)['id'=>20,'titulo'=>'OMEX BIO 20','img'=>'20.jpg','url'=>route('productos.index')],
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

  <!-- MARCAS (con imagen) -->
  <section id="marcas" class="py-6">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="display-6 fw-bold mb-2 reveal">Marcas</h2>
        <p class="text-muted reveal">Conoce nuestras marcas y líneas comerciales</p>
      </div>

      @php
        $marcas = [
            ['nombre' => 'Agrimycu 100',   'archivo' => 'AGRIMYCU 100.png'],
            ['nombre' => 'Agrimycu 500',   'archivo' => 'AGRIMYCU 500.png'],
            ['nombre' => 'Kborca',         'archivo' => 'AMINOFIT KBORCA.png'],
            ['nombre' => 'Aminofit Xtra',  'archivo' => 'AMINOFIT XTRA.png'],
            ['nombre' => 'Anibac 580',     'archivo' => 'ANIBAC 580.png'],
            ['nombre' => 'Anibac Cítrico', 'archivo' => 'ANIBAC CITRICO.png'],
            ['nombre' => 'Anibac Plus',    'archivo' => 'ANIBAC PLUS.png'],
            ['nombre' => 'Bio PH',         'archivo' => 'BIO PH.png'],
            ['nombre' => 'Biopunch',       'archivo' => 'BIOPUNCH.png'],
            ['nombre' => 'Bio-Stick',      'archivo' => 'BIO-STICK.png'],
            ['nombre' => 'Bioxystrobin',   'archivo' => 'BIOXYSTROBIN.png'],
            ['nombre' => 'Canela',         'archivo' => 'CANELA.png'],
            ['nombre' => 'Carbenpro 500F', 'archivo' => 'CARBENPRO 500 F.png'],
            ['nombre' => 'Cinna-NeemCE',   'archivo' => 'CINNA-NEEMCE.png'],
            ['nombre' => 'Citroil',        'archivo' => 'CITROIL.png'],
            ['nombre' => 'Coraza 720',     'archivo' => 'CORAZA 720.png'],
            ['nombre' => 'CU 25',          'archivo' => 'CU 25.png'],
            ['nombre' => 'Ecdyfinn',       'archivo' => 'ECDFYNN.png'],
            ['nombre' => 'Gamma',          'archivo' => 'GAMMA.png'],
            ['nombre' => 'Ionic Ultra',    'archivo' => 'IONIC ULTRA.png'],
            ['nombre' => 'Macroroot',      'archivo' => 'MACROROOT.png'],
            ['nombre' => 'Mega',           'archivo' => 'MEGA.png'],
            ['nombre' => 'Molusquicida',   'archivo' => 'MOLUSQUICIDA.png'],
            ['nombre' => 'Natuactivo',     'archivo' => 'NATUACTIVO.png'],
            ['nombre' => 'NeemCE 80',      'archivo' => 'NEEMCE 80.png'],
            ['nombre' => 'Nutripro CAB',   'archivo' => 'NUTRIPRO CAB.png'],
            ['nombre' => 'Nutripro Energy','archivo' => 'NUTRIPRO ENERGY.png'],
            ['nombre' => 'Nutripro Forte', 'archivo' => 'NUTRIPRO FORTE.png'],
            ['nombre' => 'Nutripro KMG',   'archivo' => 'NUTRIPRO KMG.png'],
            ['nombre' => 'Nutripro MAG',   'archivo' => 'NUTRIPRO MAG.png'],
            ['nombre' => 'Nutripro Mix',   'archivo' => 'NUTRIPRO MIX.png'],
            ['nombre' => 'Nutripro TR',    'archivo' => 'NUTRIPRO TR.png'],
            ['nombre' => 'Nutripro Xtra Alga','archivo' => 'NUTRIPRO XTRA ALGA.png'],
            ['nombre' => 'Omega',          'archivo' => 'OMEGA.png'],
            ['nombre' => 'Ovifinn',        'archivo' => 'OVIFINN.png'],
            ['nombre' => 'P Oil Premium',  'archivo' => 'P OIL PREMIUM.png'],
            ['nombre' => 'Piretrinas',     'archivo' => 'PIRETRINAS.png'],
            ['nombre' => 'Potasy Max',     'archivo' => 'POTASY MAX.png'],
            ['nombre' => 'Probac BS',      'archivo' => 'PROBAC BS.png'],
            ['nombre' => 'Progranic Citrus','archivo' => 'PROGRANIC CITRUS.png'],
            ['nombre' => 'Progranic Delphinus','archivo' => 'PROGRANIC DELPHINUS.png'],
            ['nombre' => 'Progranic Insect Out','archivo' => 'PROGRANIC INSECT OUT.png'],
            ['nombre' => 'Progranic Mix Top','archivo' => 'PROGRANIC MIX TOP.png'],
            ['nombre' => 'Progrow Activador','archivo' => 'PROGROW ACTIVADOR.png'],
            ['nombre' => 'Prolux Adherente','archivo' => 'PROLUX ADHERENTE.png'],
            ['nombre' => 'Prolux Plus PH', 'archivo' => 'PROLUX PLUS PH.png'],
            ['nombre' => 'Promethyl 70PH', 'archivo' => 'PROMETHYL 70 PH.png'],
            ['nombre' => 'Prommilo 50PH',  'archivo' => 'PROMMILO 50PH.png'],
            ['nombre' => 'Prowet BioAdher','archivo' => 'PROWET BIO ADHER.png'],
            ['nombre' => 'Prowet Biodyna', 'archivo' => 'PROWET BIODYNA.png'],
            ['nombre' => 'Prowet CL',      'archivo' => 'PROWET CL.png'],
            ['nombre' => 'Prowet Pine Oil','archivo' => 'PROWET PINE OIL.png'],
            ['nombre' => 'Prowet SA',      'archivo' => 'PROWET SA.png'],
            ['nombre' => 'Pull 75 WG',     'archivo' => 'PULL 75 WG.png'],
            ['nombre' => 'Pyraclostrobin', 'archivo' => 'PYRACLOSTROBIN.png'],
            ['nombre' => 'RepelentAjo',    'archivo' => 'REPELENTAJO.png'],
            ['nombre' => 'Sigma',          'archivo' => 'SIGMA.png'],
            ['nombre' => 'Spectrum Bea B', 'archivo' => 'SPECTRUM BEA B.png'],
            ['nombre' => 'Spectrum Meta A','archivo' => 'SPECTRUM META A.png'],
            ['nombre' => 'Spectrum Micoradix L','archivo' => 'SPECTRUM MICORADIX L.png'],
            ['nombre' => 'Spectrum Trico Bio','archivo' => 'SPECTRUM TRICO BIO.png'],
            ['nombre' => 'Sinal Frut',     'archivo' => 'SINAL FRUT.png'],
            ['nombre' => 'StarAgrícola',   'archivo' => 'STARAGRICOLA.png'],
            ['nombre' => 'Terra 5% Cu',    'archivo' => 'TERRA 5% CU.png'],
            ['nombre' => 'Tural',          'archivo' => 'TURAL.png'],
            ['nombre' => 'Ultralux N',     'archivo' => 'ULTRALUX N.png'],
        ];
    @endphp

      <div class="row g-4">
        @foreach ($marcas as $m)
          <div class="col-12 col-md-6">
            <div class="brand-card h-100 d-flex align-items-center justify-content-between p-4">
              <div class="brand-logo-wrap">
                <img class="brand-logo"
                     src="{{ asset('img/marcas/'.$m['archivo']) }}"
                     alt="{{ $m['nombre'] }}"
                     loading="lazy" decoding="async">
              </div>
              <a href="{{ route('productos.index') }}" class="btn btn-success btn-lg">Ver producto</a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- DOCUMENTACIÓN TÉCNICA (bloqueada, sin href) -->
  <section id="accesos" class="py-6">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="display-6 fw-bold mb-2 reveal">Documentación técnica</h2>
        <p class="text-muted reveal">Consulta fichas, hojas de seguridad y registros</p>
      </div>

      <div class="row g-4 justify-content-center">
        @foreach ([
          ['title'=>'Hojas de seguridad','icon'=>'fa-lock'],
          ['title'=>'Hojas técnicas','icon'=>'fa-file-alt'],
          ['title'=>'Registros COFEPRIS','icon'=>'fa-book'],
          ['title'=>'Registros OMRI','icon'=>'fa-seedling'],
        ] as $i => $item)
        <div class="col-12 col-sm-6 col-lg-3">
          <!-- Botón estilizado como card; SIN href -->
          <button type="button"
                  class="quick-link reveal hover-shift as-button"
                  style="--d:{{ $i * 80 }}ms"
                  data-maintenance="true"
                  aria-haspopup="dialog">
            <span class="ql-icon"><i class="fas {{ $item['icon'] }}"></i></span>
            <span class="ql-text">{{ $item['title'] }}</span>
            <span class="ql-arrow"><i class="fas fa-arrow-right"></i></span>
          </button>
        </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection

@push('styles')
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">

  <style>
    /* ====== MARCAS ====== */
    .brand-card{
      background:#fff;border-radius:1rem;
      box-shadow:0 6px 20px rgba(0,0,0,.08);
      transition:transform .2s ease, box-shadow .2s ease;
      gap:1rem;
    }
    .brand-card:hover{ transform:translateY(-3px); box-shadow:0 10px 26px rgba(0,0,0,.12); }
    .brand-logo-wrap{ max-width: 70%; }
    .brand-logo{ width:100%; height:auto; display:block; object-fit:contain; }

    /* ====== DOC. TÉCNICA BLOQUEADA ====== */
    .as-button{ border:none; background:transparent; padding:0; width:100%; text-align:inherit; }
    .as-button:focus{ outline: none; }
    a.quick-link, .quick-link.as-button{
      display:flex; align-items:center; justify-content:space-between;
      gap:.75rem; padding:1rem 1.25rem;
      background:#fff; border-radius:.875rem; text-decoration:none;
      box-shadow:0 6px 20px rgba(0,0,0,.06);
      transition:transform .15s ease, box-shadow .15s ease; width:100%;
    }
    .quick-link:hover{ transform:translateY(-2px); box-shadow:0 10px 22px rgba(0,0,0,.1); }
    .ql-icon i{ font-size:1.25rem; } .ql-text{ font-weight:600; } .ql-arrow i{ opacity:.7; }
    .py-6{ padding-top:4rem; padding-bottom:4rem; }

    /* ===== Modal de mantenimiento bonito ===== */
    .maint-modal .modal-content{
      border:none; border-radius:18px; backdrop-filter:blur(10px);
      background:linear-gradient(180deg, rgba(255,255,255,.92), rgba(255,255,255,.88));
      box-shadow:0 20px 60px rgba(16,24,40,.18);
    }
    .maint-modal .modal-header{ border:0; justify-content:center; padding-bottom:.25rem; }
    .maint-badge{
      width:74px; height:74px; border-radius:18px; display:grid; place-items:center;
      background: radial-gradient(120px 120px at 30% 20%, #d1f7d6, transparent 60%),
                  radial-gradient(140px 140px at 80% 20%, #e6f3ff, transparent 60%),
                  linear-gradient(135deg, #22c55e, #16a34a 60%, #0ea5e9);
      box-shadow: inset 0 0 0 2px rgba(255,255,255,.5), 0 8px 20px rgba(34,197,94,.35);
      color:#fff; animation:floaty 2.2s ease-in-out infinite;
    }
    @keyframes floaty { 0%,100%{ transform:translateY(0)} 50%{ transform:translateY(-4px)} }
    .maint-badge i{ font-size:34px }
    .maint-modal .modal-title{ font-weight:800; letter-spacing:.2px; }
    .maint-modal .modal-body{ text-align:center; color:#344054; padding-top:.25rem; }
    .maint-modal .hint{ font-size:.925rem; color:#667085; margin-top:.25rem; }
    .maint-modal .modal-footer{ border:0; justify-content:center; padding-top:0; }
    .maint-modal .btn-ok{
      --bs-btn-padding-y:.7rem; --bs-btn-padding-x:1.25rem; --bs-btn-border-radius:.8rem;
      box-shadow:0 6px 18px rgba(16,185,129,.25);
    }
  </style>
@endpush

@push('scripts')
  <script src="{{ asset('js/index.js') }}"></script>

  <!-- Bloqueo y apertura del modal “bonito” -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('[data-maintenance="true"]').forEach(function (el) {
        el.addEventListener('click', function (ev) {
          ev.preventDefault();
          const modalEl = document.getElementById('maintenanceModal');
          if (modalEl && window.bootstrap) {
            const m = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: 'static', keyboard: true });
            m.show();
          }
        }, { passive: false });
        // Por estética, desactiva menú contextual
        el.addEventListener('contextmenu', function(e){ e.preventDefault(); });
      });
    });
  </script>

  <!-- Modal bonito -->
  <div class="modal fade maint-modal" id="maintenanceModal" tabindex="-1" aria-labelledby="maintenanceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header flex-column gap-3 pt-4">
          <div class="maint-badge">
            <i class="fas fa-tools"></i>
          </div>
          <h5 class="modal-title" id="maintenanceModalLabel">Sección en mantenimiento</h5>
        </div>
        <div class="modal-body">
          Próximamente podrás consultar esta documentación técnica.
          <div class="hint">Estamos preparando todo para brindarte la mejor experiencia.</div>
        </div>
        <div class="modal-footer pb-4">
          <button type="button" class="btn btn-success btn-ok" data-bs-dismiss="modal">Entendido</button>
        </div>
      </div>
    </div>
  </div>
@endpush

@section('footer')
  @include('includes.footer')
@endsection

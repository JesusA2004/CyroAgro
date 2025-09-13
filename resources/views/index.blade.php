@extends('layouts.public')

@section('content')
  <!-- HERO con “onda” de destacados -->
  <header class="hero position-relative overflow-hidden">
    <picture>
      <img class="hero-bg"
           src="{{ asset('img/banner/PRINCIPAL.png') }}"
           alt="Campo agrícola al amanecer"
           loading="eager"
           decoding="async">
    </picture>

    <!-- Onda de íconos destacados -->
    <div class="wave-strip" id="waveStrip" aria-label="Productos destacados">
      @php
        // Usa tu colección real: Product::featured()->get()
        $destacados = $destacados ?? collect([
          (object)['id'=>22,'titulo'=>'OMEX DP 98','img'=>'22.png','url'=>route('productos.index')],
          (object)['id'=>23,'titulo'=>'OMEX ZN 70','img'=>'23.png','url'=>route('productos.index')],
          (object)['id'=>20,'titulo'=>'OMEX BIO 20','img'=>'20.png','url'=>route('productos.index')],
        ]);
      @endphp

      @foreach ($destacados as $p)
        <a class="wave-item" href="{{ $p->url }}" title="{{ $p->titulo }}" data-title="{{ $p->titulo }}">
          <img src="{{ asset('img/productosDestacados/'.$p->img) }}" alt="{{ $p->titulo }}" loading="lazy" decoding="async">
        </a>
      @endforeach
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

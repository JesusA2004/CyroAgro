@extends('layouts.public')

@section('content')
  <!-- HERO con imagen de fondo (sin recorte lateral) -->
  <header class="hero position-relative">
    <picture class="hero-media">
      <img class="hero-bg"
           src="{{ asset('img/banner/PRINCIPAL.png') }}"
           alt="Campo agrícola al amanecer" loading="eager" decoding="async">
    </picture>

    @php
      $destacados = ($destacados ?? collect([
        (object)['id'=>22,'titulo'=>'OMEX DP 98','img'=>'22.png'],
        (object)['id'=>23,'titulo'=>'OMEX ZN 70','img'=>'23.png'],
        (object)['id'=>20,'titulo'=>'OMEX BIO 20','img'=>'20.png'],
      ]))->take(3);
    @endphp

    <!-- Fila única: 3 botellas (transparente, dentro del header y bajo el navbar) -->
    <div class="bottles-strip" id="bottlesStrip" aria-label="Productos destacados">
      <div class="bottles-viewport" id="bottlesViewport">
        <div class="bottles-row" id="bottlesRow" data-speed="120">
          @foreach ($destacados as $p)
            <a class="bottle-link"
               href="{{ route('productos.index', ['open' => $p->id]) }}"
               title="{{ $p->titulo }}" data-title="{{ $p->titulo }}" data-id="{{ $p->id }}">
              <img class="bottle-img"
                   src="{{ asset('img/productosDestacados/'.$p->img) }}"
                   alt="{{ $p->titulo }}" loading="lazy" decoding="async">
            </a>
          @endforeach
        </div>
      </div>
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
          ['title'=>'Hojas de seguridad','icon'=>'fa-lock'],
          ['title'=>'Hojas técnicas','icon'=>'fa-file-alt'],
          ['title'=>'Registros COFEPRIS','icon'=>'fa-book'],
          ['title'=>'Registros OMRI','icon'=>'fa-seedling'],
        ] as $i => $item)
        <div class="col-12 col-sm-6 col-lg-3">
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
    /* ===== HERO: sin recortar laterales =====
       - La imagen ocupa 100% de ancho y altura automática (no hay crop lateral).
       - El header controla la altura con min/max y oculta sobrante vertical (si lo hay).
    */
    .hero{
      position:relative;
      display:block;
      overflow:hidden;                  /* si la imagen es muy alta, recortamos ARRIBA/ABAJO */
      min-height: clamp(48vh, 58vh, 68vh);
      max-height: 80vh;                 /* controla “lo alto” del hero en pantallas grandes */
      padding: 0;
      isolation:isolate;
    }
    .hero-media{display:block; width:100%; line-height:0;}
    .hero-bg{
      position:relative;                /* en flujo, no absoluta */
      display:block;
      width:100%;
      height:auto;                      /* no se recorta a los lados */
      object-fit:unset;                 /* sin forzar fitting */
      object-position:center top;       /* si hay recorte vertical, prioriza parte superior */
      background:#fff;
      /* Para que el hero tenga altura incluso si la imagen es bajita en móvil */
      min-height: 360px;
    }

    /* ===== Botellas (igual que tenías, dentro del header) ===== */
    .bottles-strip{
      position:absolute; left:0; right:0;
      top: calc(var(--nav-h, 72px) + 8px);
      z-index: 3;
      pointer-events:none;
    }
    @media (max-width: 991.98px){
      .bottles-strip{ top: calc(var(--nav-h-sm, 64px) + 6px); }
    }
    .bottles-viewport{ position:relative; width:100%; overflow:hidden; padding-inline:8px; }
    .bottles-row{
      display:flex; align-items:center; gap: clamp(26px, 4vw, 44px);
      width:max-content; will-change: transform;
      animation: slideLoop var(--dur, 22s) linear infinite;
      animation-play-state: running;
      pointer-events:none;
    }
    .bottles-strip:hover .bottles-row{ animation-play-state: paused; }
    @keyframes slideLoop{
      0%   { transform: translateX(var(--start, 100vw)); }
      100% { transform: translateX(var(--end, -140px));  }
    }
    .bottle-link{ display:block; flex:0 0 auto; text-decoration:none; pointer-events:auto; }
    .bottle-img{
      display:block; height: clamp(120px, 16vh, 200px); width:auto; object-fit:contain;
      filter: drop-shadow(0 12px 26px rgba(0,0,0,.22));
      transition: transform .22s ease, filter .22s ease;
      will-change: transform;
    }
    .bottle-link:hover .bottle-img{
      transform: translateY(-3px) scale(1.05);
      filter: drop-shadow(0 18px 34px rgba(0,0,0,.26));
    }

    /* Reveal + utilidades que ya usas */
    .reveal{ opacity:0; transform:translateY(16px); transition:opacity .7s, transform .7s; }
    .reveal.in-view{ opacity:1; transform:none; }
    .as-button{ border:none; background:transparent; padding:0; width:100%; text-align:inherit; }
    a.quick-link, .quick-link.as-button{
      display:flex; align-items:center; justify-content:space-between; gap:.75rem;
      padding:1rem 1.25rem; background:#fff; border-radius:.875rem; text-decoration:none;
      box-shadow:0 6px 20px rgba(0,0,0,.06); transition:transform .15s ease, box-shadow .15s ease; width:100%;
    }
    .quick-link:hover{ transform:translateY(-2px); box-shadow:0 10px 22px rgba(0,0,0,.1); }
    .ql-icon i{ font-size:1.25rem; } .ql-text{ font-weight:700; } .ql-arrow i{ opacity:.7; }
    .py-6{ padding-top:4rem; padding-bottom:4rem; }

    @media (prefers-reduced-motion:reduce){
      .bottles-row{ animation:none; }
      .bottle-img{ transition:none; }
      .reveal{ transition:none; }
    }
  </style>
@endpush

@push('scripts')
<script>
/* ===== Recorrido horizontal completo (reinicia desde derecha) ===== */
function initBottleStrip(){
  const viewport = document.getElementById('bottlesViewport');
  const row = document.getElementById('bottlesRow');
  if(!viewport || !row) return;

  function rebuild(){
    row.style.removeProperty('--start'); row.style.removeProperty('--end'); row.style.removeProperty('--dur');

    const vwPx = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    const rw = row.getBoundingClientRect().width;

    // Empieza fuera del viewport a la derecha y sale por la izquierda
    const start = vwPx;
    const end   = -rw;
    const distance = start + rw;

    const speed = parseFloat(row.dataset.speed || '120'); // px/seg
    const duration = Math.max(14, distance / speed);

    row.style.setProperty('--start', `${start}px`);
    row.style.setProperty('--end', `${end}px`);
    row.style.setProperty('--dur', `${duration.toFixed(2)}s`);
  }

  let t;
  const debounced = () => { clearTimeout(t); t = setTimeout(rebuild, 120); };
  rebuild();
  window.addEventListener('resize', debounced);

  const mq = window.matchMedia('(prefers-reduced-motion: reduce)');
  if (mq.matches) row.style.animationDuration = '0s';
}

/* ===== Reveal on scroll ===== */
function revealOnScroll() {
  const reveals = document.querySelectorAll('.reveal');
  for (let i = 0; i < reveals.length; i++) {
    const windowHeight = window.innerHeight;
    const elementTop = reveals[i].getBoundingClientRect().top;
    const elementVisible = 150;
    if (elementTop < windowHeight - elementVisible) {
      reveals[i].classList.add('in-view');
    }
  }
}

/* ===== Tilt para cards ===== */
function initTiltEffect() {
  const tiltElements = document.querySelectorAll('.tilt');
  tiltElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const rect = el.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const rotateX = (y - centerY) / 10;
      const rotateY = (centerX - x) / 10;
      el.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });
    el.addEventListener('mouseleave', () => {
      el.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
    });
  });
}

/* ===== Modal mantenimiento ===== */
function initMaintenanceModal() {
  document.querySelectorAll('[data-maintenance="true"]').forEach(function (el) {
    el.addEventListener('click', function (ev) {
      ev.preventDefault();
      const modalEl = document.getElementById('maintenanceModal');
      if (modalEl && window.bootstrap) {
        const m = bootstrap.Modal.getOrCreateInstance(modalEl, { backdrop: 'static', keyboard: true });
        m.show();
      }
    }, { passive: false });
    el.addEventListener('contextmenu', function(e){ e.preventDefault(); });
  });
}

/* ===== DOM Ready ===== */
document.addEventListener('DOMContentLoaded', function(){
  initBottleStrip();
  revealOnScroll();
  window.addEventListener('scroll', revealOnScroll);
  initTiltEffect();
  initMaintenanceModal();
});
</script>

<!-- Modal bonito -->
<div class="modal fade maint-modal" id="maintenanceModal" tabindex="-1" aria-labelledby="maintenanceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header flex-column gap-3 pt-4">
        <div class="maint-badge"><i class="fas fa-tools"></i></div>
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

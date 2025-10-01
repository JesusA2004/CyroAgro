@extends('layouts.public')

@section('content')
  <!-- HERO con imagen COMPLETA (sin recorte lateral) -->
  <header class="hero position-relative">
    <picture class="hero-media">
      <img class="hero-bg"
           src="{{ asset('img/banner/PRINCIPAL.png') }}"
           alt="Campo agrícola al amanecer" loading="eager" decoding="async">
    </picture>

    @php
      use App\Models\Producto;

      // === Destacados activos (EXACTAMENTE 3) ===
      $base = Producto::query()
          ->whereHas('featured', fn($q) => $q->where('is_active', 1))
          ->with('featured:id,product_id,is_active,position,created_at')
          ->join('featured_products','featured_products.product_id','=','productos.id')
          ->orderByRaw("CASE WHEN featured_products.position IS NULL THEN 1 ELSE 0 END,
                        featured_products.position ASC,
                        featured_products.created_at ASC")
          ->select('productos.id','productos.nombre as titulo','productos.fotoProducto');

      $destacados = $base->limit(3)->get()->map(function($p){
          $img = $p->fotoProducto;
          $rel = $img ? 'img/'.ltrim($img,'/') : 'img/FotosProducto/default.png';
          return (object)['id'=>$p->id,'titulo'=>$p->titulo,'img'=>$rel];
      });

      if ($destacados->count() < 3) {
          $faltan = 3 - $destacados->count();
          $idsTomados = $destacados->pluck('id')->all();
          $fallback = Producto::whereNotIn('id',$idsTomados)
              ->orderBy('nombre')
              ->limit($faltan)
              ->get(['id','nombre as titulo','fotoProducto'])
              ->map(function($p){
                  $img = $p->fotoProducto;
                  $rel = $img ? 'img/'.ltrim($img,'/') : 'img/FotosProducto/default.png';
                  return (object)['id'=>$p->id,'titulo'=>$p->titulo,'img'=>$rel];
              });
          $destacados = $destacados->concat($fallback)->values();
      }
      $destacados = $destacados->take(3)->values();
    @endphp

    <!-- Botellas centradas BAJO el logo -->
    <div class="bottles-strip" aria-label="Productos destacados"
         style="left:57%; right:auto; transform:translateX(-50%);">
      <div class="bottles-viewport">
        <div class="bottles-row">
          @foreach ($destacados as $p)
            <a class="bottle-link"
               href="{{ route('productos.index', ['open' => $p->id]) }}"
               title="{{ $p->titulo }}">
              <img class="bottle-img"
                   src="{{ asset($p->img) }}"
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
@endpush

@push('scripts')
<script>
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

/* ===== Tilt ligero ===== */
function initTiltEffect() {
  const tiltElements = document.querySelectorAll('.tilt');
  tiltElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const r = el.getBoundingClientRect();
      const rotateX = ( (e.clientY - r.top) - r.height/2) / 14;
      const rotateY = ( r.width/2 - (e.clientX - r.left)) / 14;
      el.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });
    el.addEventListener('mouseleave', () => {
      el.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
    });
  });
}

/* ===== Posición y tamaño responsive de las botellas (sin añadir CSS extra) ===== */
function positionFeaturedBottles() {
  const strip = document.querySelector('.bottles-strip');
  const imgs  = document.querySelectorAll('.bottle-img');
  if (!strip) return;

  const w = window.innerWidth || document.documentElement.clientWidth;

  if (w >= 1200) {
    // Pantalla grande: más a la derecha y botellas más grandes
    strip.style.left = '67%';
    imgs.forEach(img => { 
      img.style.width = '120px';
      img.style.height = 'auto';     // mantiene proporción
      img.style.maxHeight = '160px'; // opcional: límite superior
    });
  } else {
    // Pantalla pequeña/mediana
    strip.style.left = '57%';
    imgs.forEach(img => { 
      img.style.width = ''; 
      img.style.height = ''; 
      img.style.maxHeight = ''; 
    });
  }

  // Mantén centrado respecto al punto de anclaje
  strip.style.right = 'auto';
  strip.style.transform = 'translateX(-50%)';
}

document.addEventListener('DOMContentLoaded', function(){
  revealOnScroll();
  window.addEventListener('scroll', revealOnScroll);
  initTiltEffect();

  positionFeaturedBottles();
  window.addEventListener('resize', positionFeaturedBottles);
});
</script>
@endpush

@section('footer')
  @include('includes.footer')
@endsection

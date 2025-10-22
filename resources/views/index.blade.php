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

  <!-- LÍNEAS DE PRODUCTO (cada card redirige con filtro preseleccionado) -->
  <section id="lineas" class="py-6 bg-body-tertiary">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="display-6 fw-bold mb-2 reveal">Líneas de producto</h2>
        <p class="text-muted reveal">Explora nuestras categorías principales</p>
      </div>

      @php
        // SOLO estas cuatro categorías, una por DIV:
        $lineas = [
          ['icon'=>'fa-seedling', 'title'=>'Biofungicida',   'desc'=>'Nutrición vegetal eficiente.',          'class'=>'categoria', 'value'=>'biofungicida'],
          ['icon'=>'fa-seedling', 'title'=>'Bioestimulante', 'desc'=>'Estimula crecimiento y vigor.',         'class'=>'categoria', 'value'=>'bioestimulante'],
          ['icon'=>'fa-flask',    'title'=>'Coadyuvante',    'desc'=>'Mejora cobertura y adherencia.',        'class'=>'categoria', 'value'=>'coadyuvante'],
          ['icon'=>'fa-flask',    'title'=>'Aminoacidos',    'desc'=>'Mayor fijación y compatibilidad.',      'class'=>'categoria', 'value'=>'aminoacidos'],
        ];
      @endphp

      <div class="row g-4">
        @foreach ($lineas as $i => $card)
        <div class="col-12 col-sm-6 col-lg-3">
          <a href="{{ route('productos.index', ['class'=>$card['class'], 'value'=>$card['value']]) }}"
             class="text-decoration-none text-reset">
            <div class="feature-card h-100 p-4 reveal tilt" style="--d:{{ $i * 80 }}ms">
              <div class="icon-wrap mb-3">
                <i class="fas {{ $card['icon'] }} fa-2x"></i>
              </div>
              <h3 class="h5 fw-bold mb-2">{{ $card['title'] }}</h3>
              <p class="text-muted mb-3">{{ $card['desc'] }}</p>
              <button type="button" class="btn btn-success">Ver productos</button>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- DOCUMENTACIÓN TÉCNICA (ACTUALIZADA) -->
  <section id="accesos" class="py-6">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="display-6 fw-bold mb-2 reveal">Documentación técnica</h2>
        <p class="text-muted reveal">Consulta fichas y hojas de seguridad</p>
      </div>

      @php
        use Illuminate\Support\Facades\Route;
        $urlFichas = Route::has('fichasTecnicas.index') ? route('fichasTecnicas.index') : url('/fichas-tecnicas');
        $urlHojas  = Route::has('hojasSeguridad.index') ? route('hojasSeguridad.index') : url('/hojas-seguridad');
      @endphp

      <div class="row g-4 justify-content-center quick-links-grid">
        <div class="col-12 col-md-6 col-xl-5">
          <a href="{{ $urlHojas }}" class="quick-link quick-link--xl reveal hover-shift tilt-ql" style="--d:0ms">
            <span class="ql-icon ql-icon--xl"><i class="fas fa-lock"></i></span>
            <span class="ql-text">
              <span class="ql-title">Hojas de seguridad</span>
              <span class="ql-desc">Descarga SDS por producto</span>
            </span>
            <span class="ql-arrow ql-arrow--xl"><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>

        <div class="col-12 col-md-6 col-xl-5">
          <a href="{{ $urlFichas }}" class="quick-link quick-link--xl reveal hover-shift tilt-ql" style="--d:80ms">
            <span class="ql-icon ql-icon--xl"><i class="fas fa-file-alt"></i></span>
            <span class="ql-text">
              <span class="ql-title">Hojas técnicas</span>
              <span class="ql-desc">Especificaciones y uso recomendado</span>
            </span>
            <span class="ql-arrow ql-arrow--xl"><i class="fas fa-arrow-right"></i></span>
          </a>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('styles')
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script>
function revealOnScroll() {
  const reveals = document.querySelectorAll('.reveal');
  for (let i = 0; i < reveals.length; i++) {
    const windowHeight = window.innerHeight;
    const elementTop = reveals[i].getBoundingClientRect().top;
    const elementVisible = 150;
    if (elementTop < windowHeight - elementVisible) reveals[i].classList.add('in-view');
  }
}
function initTiltEffect() {
  const tiltElements = document.querySelectorAll('.tilt');
  tiltElements.forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const r = el.getBoundingClientRect();
      const rotateX = ((e.clientY - r.top) - r.height/2) / 14;
      const rotateY = (r.width/2 - (e.clientX - r.left)) / 14;
      el.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });
    el.addEventListener('mouseleave', () => {
      el.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
    });
  });
}
function positionFeaturedBottles() {
  const strip = document.querySelector('.bottles-strip');
  const imgs  = document.querySelectorAll('.bottle-img');
  if (!strip) return;
  const w = window.innerWidth || document.documentElement.clientWidth;
  if (w >= 1200) {
    strip.style.left = '60%';
    imgs.forEach(img => { img.style.width = '120px'; img.style.height = 'auto'; img.style.maxHeight = '160px'; });
  } else {
    strip.style.left = '57%';
    imgs.forEach(img => { img.style.width = ''; img.style.height = ''; img.style.maxHeight = ''; });
  }
  strip.style.right = 'auto';
  strip.style.transform = 'translateX(-50%)';
}

/* === Micro-interacciones para los 2 botones grandes === */
function initQuickLinks() {
  document.querySelectorAll('.tilt-ql').forEach(el => {
    el.addEventListener('mousemove', (e) => {
      const r = el.getBoundingClientRect();
      const dx = (e.clientX - r.left) / r.width - 0.5;
      const dy = (e.clientY - r.top) / r.height - 0.5;
      el.style.transform = `translateY(-2px) rotateX(${dy*3}deg) rotateY(${dx*-3}deg)`;
    });
    el.addEventListener('mouseleave', () => {
      el.style.transform = '';
    });

    // Ripple
    el.addEventListener('click', (e) => {
      const ripple = document.createElement('span');
      ripple.className = 'ripple';
      const rect = el.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = (e.clientX - rect.left - size/2) + 'px';
      ripple.style.top  = (e.clientY - rect.top  - size/2) + 'px';
      el.appendChild(ripple);
      setTimeout(() => ripple.remove(), 600);
    });
  });
}

document.addEventListener('DOMContentLoaded', function(){
  revealOnScroll(); window.addEventListener('scroll', revealOnScroll);
  initTiltEffect();
  positionFeaturedBottles(); window.addEventListener('resize', positionFeaturedBottles);
  initQuickLinks();
});
</script>
@endpush

@section('footer')
  @include('includes.footer')
@endsection

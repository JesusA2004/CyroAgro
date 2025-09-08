@extends('layouts.public')

@section('content')
@php
  use Illuminate\Support\Str;
  $toList = function($text) {
      if (!$text) return [];
      return collect(explode(',', $text))
          ->map(fn($v) => trim(preg_replace('/\s+/', ' ', $v)))
          ->filter()
          ->values()
          ->all();
  };
@endphp

<div class="hero-bg-gradient"></div>

<section class="section-products">
  <div class="container-fluid px-4">
    {{-- ENCABEZADO --}}
    <div class="row align-items-end mb-4">
      <div class="col-12 col-lg-6">
        <h1 class="h2 fw-bold mb-3">Productos</h1>
        <div class="input-group mb-2">
          <span class="input-group-text bg-body"><i class="fas fa-search"></i></span>
          <input id="p-search" type="search" class="form-control form-control-lg" placeholder="Buscar por nombre…">
        </div>
      </div>
      <div class="col-12 col-lg-6 d-flex align-items-end justify-content-lg-end mt-3 mt-lg-0">
        <div class="input-group input-group-lg" style="max-width: 560px;">
          <span class="input-group-text"><i class="fas fa-boxes-stacked"></i></span>
          <select id="p-quick" class="form-select form-select-lg">
            <option value="">Selecciona un producto…</option>
            @foreach($productos as $p)
              <option value="{{ $p->id }}">{{ $p->nombre }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    {{-- BARRA DE SEGMENTOS --}}
    <div class="segments-nav mb-4">
      <button class="seg-chip active" data-seg="">Todos</button>
      @foreach($segmentos as $seg)
        <button class="seg-chip" data-seg="{{ Str::slug($seg) }}">{{ $seg }}</button>
      @endforeach
    </div>

    {{-- SELECTORES --}}
    <div class="row g-3 mb-4 align-items-end classification-row">
      <div class="col-12 col-md-4 col-xl-3">
        <label for="class-select" class="form-label fw-bold">Clasificación</label>
        <select id="class-select" class="form-select form-select-lg">
          <option value="">Selecciona clasificación…</option>
          <option value="segmento">Segmento</option>
          <option value="categoria">Categoría</option>
          <option value="control">Plaga/Control</option>
          <option value="cultivo">Cultivo</option>
        </select>
      </div>
      <div class="col-12 col-md-4 col-xl-3">
        <label for="value-select" class="form-label fw-bold">Valor</label>
        <select id="value-select" class="form-select form-select-lg" disabled>
          <option value="">Selecciona valor…</option>
        </select>
      </div>
    </div>

    <div id="p-empty" class="alert alert-light border d-none">No se encontraron productos con esos filtros.</div>

    {{-- GRID --}}
    <div id="p-grid" class="row gy-4 gx-3 gx-xl-4">
      @foreach($productos as $p)
        @php
          $img = $p->FotoCatalogo ?: $p->fotoProducto;
          $listaControl = $toList($p->controla);
          $listaCultivo = $toList($p->usoRecomendado);
          $json = [
            'id'            => $p->id,
            'nombre'        => $p->nombre,
            'segmento'      => $p->segmento,
            'categoria'     => $p->categoria,
            'registro'      => $p->registro,
            'contenido'     => $p->contenido,
            'usoRecomendado'=> $p->usoRecomendado,
            'dosisSugerida' => $p->dosisSugerida,
            'intervaloAplicacion' => $p->intervaloAplicacion,
            'controla'      => $p->controla,
            'fichaTecnica'  => $p->fichaTecnica,
            'hojaSeguridad' => $p->hojaSeguridad,
            'fotoProducto'  => $p->fotoProducto,
            'presentacion'  => $p->presentacion,
            'FotoCatalogo'  => $p->FotoCatalogo,
          ];
        @endphp

        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 p-card-wrap"
             data-id="{{ $p->id }}"
             data-nombre="{{ Str::lower($p->nombre) }}"
             data-segmento="{{ Str::slug($p->segmento ?? '') }}"
             data-categoria="{{ Str::slug($p->categoria ?? '') }}"
             data-control="{{ collect($listaControl)->map(fn($v)=>Str::slug($v))->join(',') }}"
             data-cultivo="{{ collect($listaCultivo)->map(fn($v)=>Str::slug($v))->join(',') }}"
             data-json='@json($json)'>

          <article class="p-card h-100 d-flex flex-column text-center">
            <div class="p-media">
            @php
              // Solo desde BD: fotoProducto (p.ej. "/FotosProducto/ProluxAdherente.png")
              $imgBd  = $p->fotoProducto;
              $srcRel = $imgBd ? 'img/' . ltrim($imgBd, '/') : 'img/FotosProducto/default.png';
            @endphp

            <img src="{{ asset($srcRel) }}?v={{ optional($p->updated_at)->timestamp }}"
                alt="{{ $p->nombre }}" loading="lazy" decoding="async">
            </div>

            <h3 class="product-title fw-bold mb-1">{{ $p->nombre }}</h3>
            <div class="small text-muted mb-3">
              {{ $p->segmento ?? '—' }} @if($p->categoria) • {{ $p->categoria }} @endif
            </div>

            <div class="mt-auto">
              <button class="btn btn-success btn-lg w-100 p-view" data-id="{{ $p->id }}">
                Ver producto
              </button>
            </div>
          </article>
        </div>
      @endforeach
    </div>

    @if(method_exists($productos, 'links'))
      <div class="mt-4">{{ $productos->links() }}</div>
    @endif
  </div>
</section>

{{-- JS Filtros --}}
<script>
window.availableFilters = {
  segmento: @json($segmentos->map(fn($s) => trim($s))->values()),
  categoria: @json($categorias->map(fn($c) => trim($c))->values()),
  control: @json($controles->map(fn($c) => trim($c))->values()),
  cultivo: @json($cultivos->map(fn($c) => trim($c))->values()),
};
window.assetRoot = "{{ asset('') }}";
</script>

{{-- MODAL DETALLE --}}
<div class="modal fade" id="pModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
    <div class="modal-content detail-modal">
      <div class="modal-body p-0">

        {{-- Encabezado personalizado sin banner --}}
        <header class="detail-header container py-4">
          <div class="row align-items-start">
            <div class="col-12 col-lg-4 mb-3 mb-lg-0">
              <img id="d-botella" class="detail-bottle" src="" alt="">
            </div>
            <div class="col-12 col-lg-8">
              <h2 class="fw-bold text-primary mb-2" id="d-titulo">Título</h2>
              <p class="tagline text-muted mb-2">Llevamos hasta ti productos de alta <span class="fw-bolder">calidad</span>.</p>
              <div class="badge bg-success-subtle text-success-emphasis fw-semibold px-3 py-2" id="d-cat">CATEGORÍA</div>
            </div>
          </div>
          <button type="button" class="btn btn-light btn-close-detail position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Cerrar">
            <i class="fas fa-times"></i>
          </button>
        </header>

        {{-- Cuerpo de la ficha --}}
        <section class="detail-body container py-4 py-lg-5">
          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <div class="detail-block">
                <h3 class="fw-bold text-success mb-3">Ficha técnica</h3>
                <dl class="row small mb-0">
                  <dt class="col-5">Registro</dt><dd class="col-7" id="d-registro">—</dd>
                  <dt class="col-5">Contenido</dt><dd class="col-7" id="d-contenido">—</dd>
                  <dt class="col-5">Dosis sugerida</dt><dd class="col-7" id="d-dosis">—</dd>
                  <dt class="col-5">Intervalo de aplicación</dt><dd class="col-7" id="d-intervalo">—</dd>
                  <dt class="col-5">Presentación</dt><dd class="col-7" id="d-presentacion">—</dd>
                </dl>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="detail-block">
                <h3 class="fw-bold text-success mb-3">Controla</h3>
                <ul id="d-control" class="control-list"></ul>
              </div>
            </div>
            <div class="col-12">
              <div class="detail-block">
                <h3 class="fw-bold text-success mb-3">Uso en los siguientes cultivos</h3>
                <ul id="d-cultivos" class="cultivos-list list-unstyled"></ul>
              </div>
            </div>

            {{-- Botones deshabilitados: fichas y hojas de seguridad --}}
            <div class="col-12 d-flex gap-2 flex-wrap">
              <button id="d-ficha" type="button" class="btn btn-success" disabled>
                <i class="far fa-file-alt me-2"></i> Ficha técnica (en mantenimiento)
              </button>
              <button id="d-hoja" type="button" class="btn btn-outline-success" disabled>
                <i class="fas fa-lock me-2"></i> Hoja de seguridad (en mantenimiento)
              </button>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/infoProductos.css') }}">
<style>
  /* Fallback para el modal si no hay Bootstrap */
  .modal.vanilla-open { display:block; }
  .modal.vanilla-open .modal-dialog { transform:none !important; }
  .modal-backdrop.vanilla { position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1040; }

  /* Cabecera mejorada */
  .detail-modal .detail-header {
    background-color: #ffffff;
    position: relative;
    padding: 2rem 1.5rem;
    border-radius: 0 0 .75rem .75rem;
  }
  .detail-modal .detail-bottle {
    max-width: 100%;
    height: auto;
    max-height: 260px;
    object-fit: contain;
  }
  .detail-modal .detail-header h2 {
    font-size: 2.2rem;
  }
  .detail-modal .tagline {
    font-size: 1.1rem;
    color: #6c757d;
  }

  /* Cuerpo con fondo sutil */
  .detail-modal .detail-body {
    background: #f8f9fb;
    border-radius: 0 0 1rem 1rem;
    padding: 2rem;
  }
  .detail-modal .detail-block {
    background: #ffffff;
    border-radius: .75rem;
    padding: 1.5rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  }
  .detail-modal .detail-block h3 {
    font-size: 1.3rem;
  }
  .detail-modal dl dt {
    font-weight: 600;
    color: #052c65;
  }
  .detail-modal dl dd {
    font-weight: 500;
    color: #333;
  }
  /* Control list */
  .control-list li {
    margin-bottom: .25rem;
    position: relative;
    padding-left: 1em;
  }
  .control-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 8px;
    width: 6px;
    height: 6px;
    background-color: #16a34a;
    border-radius: 50%;
  }

  /* Cultivos list */
  .cultivos-list {
    margin: 0;
    padding: 0;
    column-count: 1;
  }
  @media (min-width: 768px) {
    .cultivos-list { column-count: 2; }
  }
  @media (min-width: 992px) {
    .cultivos-list { column-count: 3; }
  }
  @media (min-width: 1200px) {
    .cultivos-list { column-count: 4; }
  }
  .cultivos-list li {
    position: relative;
    padding-left: 1em;
    margin-bottom: .3rem;
    line-height: 1.4;
  }
  .cultivos-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: 8px;
    width: 6px;
    height: 6px;
    background-color: #16a34a;
    border-radius: 50%;
  }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const grid      = document.getElementById('p-grid');
  const cards     = Array.from(grid.querySelectorAll('.p-card-wrap'));
  const empty     = document.getElementById('p-empty');
  const state     = { segment:'', classAttr:'', classValue:'', q:'' };

  const slugify = (s) => (s || '').toString().trim().toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
    .replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'');

  function normalizeImgPath(p){
    if(!p) return null;
    p = p.replace(/^\/+/, '');
    return p.replace(/^Fotos(Productos?|Catalogo)\//i, 'img/FotosProducto/');
  }

  const assetRoot = (window.assetRoot || '/').replace(/\/?$/, '/');

  // Segmentos
  document.querySelectorAll('.segments-nav .seg-chip').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      document.querySelectorAll('.segments-nav .seg-chip').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      state.segment = btn.dataset.seg || '';
      applyFilters();
    });
  });

  // Selectores
  const classSelect = document.getElementById('class-select');
  const valueSelect = document.getElementById('value-select');

  classSelect.addEventListener('change', ()=>{
    const attr = classSelect.value || '';
    state.classAttr = attr;
    state.classValue = '';
    valueSelect.innerHTML = '<option value="">Selecciona valor…</option>';
    valueSelect.disabled = true;

    if(attr && window.availableFilters && window.availableFilters[attr]){
      window.availableFilters[attr].forEach(v=>{
        const opt = document.createElement('option');
        opt.value = slugify(v);
        opt.textContent = v;
        valueSelect.appendChild(opt);
      });
      valueSelect.disabled = false;
    }
    applyFilters();
  });
  valueSelect.addEventListener('change', ()=>{
    state.classValue = valueSelect.value || '';
    applyFilters();
  });

  // Buscador
  const searchInput = document.getElementById('p-search');
  searchInput.addEventListener('input', ()=>{
    state.q = searchInput.value.trim().toLowerCase();
    applyFilters();
  });

  // Selección rápida
  const quickSelect = document.getElementById('p-quick');
  if (quickSelect){
    quickSelect.addEventListener('change', e=>{
      const id = e.target.value;
      if(!id) return;
      const card = grid.querySelector(`.p-card-wrap[data-id="${id}"]`);
      if(card){
        card.scrollIntoView({behavior:'smooth', block:'center'});
        const btn = card.querySelector('.p-view');
        if(btn) btn.click();
      }
      e.target.value = '';
    });
  }

  function applyFilters(){
    let visible = 0;
    cards.forEach(card=>{
      const name = card.dataset.nombre || '';
      const seg  = card.dataset.segmento || '';
      const cat  = card.dataset.categoria || '';
      const ctrl = card.dataset.control || '';
      const cult = card.dataset.cultivo || '';
      let show = true;

      if(state.q && !name.includes(state.q)) show = false;
      if(show && state.segment && seg !== state.segment) show = false;

      if(show && state.classAttr && state.classValue){
        switch(state.classAttr){
          case 'segmento': if(seg !== state.classValue) show = false; break;
          case 'categoria': if(cat !== state.classValue) show = false; break;
          case 'control': if(!ctrl.split(',').includes(state.classValue)) show = false; break;
          case 'cultivo': if(!cult.split(',').includes(state.classValue)) show = false; break;
        }
      }

      card.classList.toggle('d-none', !show);
      if(show) visible++;
    });
    empty.classList.toggle('d-none', visible > 0);
  }
  applyFilters();

  // ===== Modal =====
  const modalEl = document.getElementById('pModal');
  const hasBootstrap = !!(window.bootstrap && bootstrap.Modal);
  const modal = hasBootstrap ? new bootstrap.Modal(modalEl) : null;

  function openModal(){
    if (hasBootstrap) {
      modal.show();
    } else {
      modalEl.classList.add('vanilla-open', 'show');
      modalEl.style.display = 'block';
      modalEl.removeAttribute('aria-hidden');
      const backdrop = document.createElement('div');
      backdrop.className = 'modal-backdrop vanilla';
      backdrop.id = 'pModalBackdrop';
      document.body.appendChild(backdrop);
      document.body.style.overflow = 'hidden';
    }
  }
  function closeModal(){
    if (hasBootstrap) {
      modal.hide();
    } else {
      modalEl.classList.remove('vanilla-open', 'show');
      modalEl.style.display = 'none';
      modalEl.setAttribute('aria-hidden','true');
      const bd = document.getElementById('pModalBackdrop');
      if (bd) bd.remove();
      document.body.style.overflow = '';
    }
  }

  // Manejador de cierre: cierra también en modo fallback
  modalEl.querySelectorAll('[data-bs-dismiss="modal"]').forEach(btn => {
    btn.addEventListener('click', ev => {
      if (!hasBootstrap) {
        ev.preventDefault();
        closeModal();
      }
    });
  });

  modalEl.addEventListener('click', (e)=>{
    if (!hasBootstrap && (e.target.matches('[data-bs-dismiss="modal"]') || e.target === modalEl)) {
      closeModal();
    }
  });

  grid.addEventListener('click', (e)=>{
    const btn = e.target.closest('.p-view');
    if(!btn) return;
    const wrap = btn.closest('.p-card-wrap');
    if(!wrap) return;

    const data = JSON.parse(wrap.dataset.json || '{}');

    // Rellenar datos
    setSrc('#d-botella', data.FotoCatalogo || data.fotoProducto || '');
    setText('#d-titulo', data.nombre || '');
    setText('#d-cat', [data.segmento, data.categoria].filter(Boolean).join(' • ') || '—');
    setText('#d-registro',     data.registro || '—');
    setText('#d-contenido',    data.contenido || '—');
    setText('#d-dosis',        data.dosisSugerida || '—');
    setText('#d-intervalo',    data.intervaloAplicacion || '—');
    setText('#d-presentacion', data.presentacion || '—');

    fillList('#d-control',  (data.controla || '').split(',').map(s=>s.trim()).filter(Boolean));
    fillCultivos('#d-cultivos', (data.usoRecomendado || '').split(',').map(s=>s.trim()).filter(Boolean));

    openModal();
  });

  // Helpers
  function setText(sel, v){ const el = document.querySelector(sel); if(el) el.textContent = v; }
  function setSrc(sel, v){
    const el = document.querySelector(sel); if(!el) return;
    const normalized = normalizeImgPath(v);
    el.src = assetRoot + (normalized || 'img/placeholder.png');
  }
  function fillList(sel, arr){
    const el = document.querySelector(sel); if(!el) return;
    el.innerHTML = '';
    (arr || []).forEach(t=>{
      const li = document.createElement('li');
      li.textContent = t;
      el.appendChild(li);
    });
  }
  function fillCultivos(sel, arr){
    const el = document.querySelector(sel); if(!el) return;
    el.innerHTML = '';
    (arr || []).forEach(t=>{
      const li = document.createElement('li');
      li.textContent = t;
      el.appendChild(li);
    });
  }

});
</script>
@endpush

@section('footer')
  @include('includes.footer')
@endsection

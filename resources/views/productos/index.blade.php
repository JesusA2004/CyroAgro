{{-- resources/views/productos/index.blade.php --}}
@extends('layouts.public')

@section('content')
@php
  use Illuminate\Support\Str;

  // Normaliza listas separadas por coma para filtros (no toca texto original)
  $toList = function($text) {
      if (!$text) return [];
      return collect(explode(',', $text))
          ->map(function($v){
              $v = trim(preg_replace('/\s+/', ' ', $v));
              return rtrim($v, " .;,");
          })
          ->filter()
          ->values()
          ->all();
  };

  // Lee query params para preselección inicial (?class=&value=)
  $initialClass = Str::lower(request()->query('class', ''));
  $initialValue = Str::slug(request()->query('value', ''));
@endphp

{{-- HEADER con imagen de fondo y overlay (no se mueve) --}}
<header id="products-header"
        class="mb-3"
        style="--nav-offset:72px; --header-img: url('{{ asset('img/banner/PRODUCTOS.png') }}');">
    </div>
  </div>
</header>

<section class="section-products">
  <div class="container-fluid px-5">

    {{-- ENCABEZADO / BUSCADOR + SELECTOR RÁPIDO --}}
    <div class="row align-items-end mb-4 g-3">
      <div class="col-12 col-lg-7">
        <div class="input-group input-group-lg shadow-sm">
          <span class="input-group-text bg-body"><i class="fas fa-search"></i></span>
          <input id="p-search" type="search" class="form-control form-control-lg" placeholder="Buscar por nombre…">
        </div>
      </div>
      <div class="col-12 col-lg-5">
        <div class="input-group input-group-lg shadow-sm" style="max-width: 560px;">
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
    <div class="segments-nav mb-4 d-flex flex-wrap gap-2">
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
          $listaControl = $toList($p->controla);
          $listaCultivo = $toList($p->usoRecomendado);

          // JSON para el modal (solo fotoProducto)
          $json = [
            'id'                 => $p->id,
            'nombre'             => $p->nombre,
            'segmento'           => $p->segmento,
            'categoria'          => $p->categoria,
            'registro'           => $p->registro,
            'contenido'          => $p->contenido,
            'usoRecomendado'     => $p->usoRecomendado,
            'dosisSugerida'      => $p->dosisSugerida,
            'intervaloAplicacion'=> $p->intervaloAplicacion,
            'controla'           => $p->controla,
            'fichaTecnica'       => $p->fichaTecnica,
            'hojaSeguridad'      => $p->hojaSeguridad,
            'fotoProducto'       => $p->fotoProducto, // ***importante***
            'presentacion'       => $p->presentacion,
            'updated_at'         => optional($p->updated_at)->timestamp,
          ];

          // Imagen de card (sin recortes). Si en BD es "FotosProducto/..." lo prefijamos con "img/"
          $imgBd = $p->fotoProducto;
          $srcRel = $imgBd ? 'img/' . ltrim($imgBd, '/') : 'img/FotosProducto/default.png';
        @endphp

        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 p-card-wrap"
             data-id="{{ $p->id }}"
             data-nombre="{{ Str::lower($p->nombre) }}"
             data-segmento="{{ Str::slug($p->segmento ?? '') }}"
             data-categoria="{{ Str::slug($p->categoria ?? '') }}"
             data-control="{{ collect($listaControl)->map(fn($v)=>Str::slug($v))->join(',') }}"
             data-cultivo="{{ collect($listaCultivo)->map(fn($v)=>Str::slug($v))->join(',') }}"
             data-json='@json($json)'>

          <article class="p-card h-100 d-flex flex-column">
            <div class="p-media">
              <img src="{{ asset($srcRel) }}?v={{ optional($p->updated_at)->timestamp }}"
                   alt="Imagen de {{ $p->nombre }}" loading="lazy" decoding="async">
            </div>

            <div class="p-body d-flex flex-column text-center">
              <h3 class="product-title fw-bold mb-1 text-truncate" title="{{ $p->nombre }}">{{ $p->nombre }}</h3>
              <div class="small text-muted mb-2">
                {{ $p->segmento ?? '—' }} @if($p->categoria) • {{ $p->categoria }} @endif
              </div>

              <div class="d-flex justify-content-center flex-wrap gap-1 mb-3">
                @foreach(array_slice($listaControl,0,2) as $c)
                  <span class="chip chip-green" title="{{ $c }}">{{ Str::limit($c, 28) }}</span>
                @endforeach
                @foreach(array_slice($listaCultivo,0,1) as $c)
                  <span class="chip chip-gray" title="{{ $c }}">{{ Str::limit($c, 26) }}</span>
                @endforeach
              </div>

              <div class="mt-auto">
                <button class="btn btn-success btn-lg w-100 p-view" data-id="{{ $p->id }}">
                  Ver producto
                </button>
              </div>
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

{{-- Datos para filtros desde el servidor + filtro inicial --}}
<script>
window.availableFilters = {
  segmento: @json($segmentos->map(fn($s) => trim($s))->values()),
  categoria: @json($categorias->map(fn($c) => trim($c))->values()),
  control:   @json($controles->map(fn($c) => trim($c))->values()),
  cultivo:   @json($cultivos->map(fn($c) => trim($c))->values()),
};
window.assetRoot = "{{ asset('') }}";
window.initialFilter = { class: @json($initialClass), value: @json($initialValue) };
</script>

{{-- MODAL DETALLE --}}
<div class="modal fade" id="pModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
    <div class="modal-content detail-modal">
      <div class="modal-body p-0">

        <header class="detail-header container py-4">
          <div class="row align-items-start gy-3">
            <div class="col-12 col-md-5 col-lg-4">
              <img id="d-botella" class="detail-bottle" src="" alt="">
            </div>
            <div class="col-12 col-md-7 col-lg-8">
              <h2 class="fw-bold text-primary mb-2" id="d-titulo">Título</h2>
              <p class="tagline text-muted mb-2">Llevamos hasta ti productos de alta <span class="fw-bolder">calidad</span>.</p>
              <div class="badge bg-success-subtle text-success-emphasis fw-semibold px-3 py-2" id="d-cat">CATEGORÍA</div>
            </div>
          </div>
          <button type="button" class="btn btn-light btn-close-detail position-absolute top-0 end-0 m-3"
                  data-bs-dismiss="modal" aria-label="Cerrar">
            <i class="fas fa-times"></i>
          </button>
        </header>

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
                <ul id="d-cultivos" class="cultivos-list"></ul>
              </div>
            </div>

            <div class="col-12 d-flex gap-2 flex-wrap">
              <a id="d-ficha" class="btn btn-success d-none" target="_blank" rel="noopener">
                <i class="far fa-file-pdf me-2"></i> Ficha técnica (PDF)
              </a>
              <a id="d-hoja" class="btn btn-outline-success d-none" target="_blank" rel="noopener">
                <i class="far fa-file-pdf me-2"></i> Hoja de seguridad (PDF)
              </a>
            </div>
          </div>
        </section>

      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
{{-- Carga tu CSS con "cache-busting" para evitar caché del navegador --}}
<link rel="stylesheet" href="{{ asset('css/infoProductos.css') }}?v={{ @filemtime(public_path('css/infoProductos.css')) }}">
<style>
  /* Fallback modal (si no hay Bootstrap) */
  .modal.vanilla-open { display:block; }
  .modal.vanilla-open .modal-dialog { transform:none !important; }
  .modal-backdrop.vanilla { position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1040; }

  /* Cards */
  .p-card{ border-radius: 1rem; overflow:hidden; border:1px solid #eef2f4; background:#fff;
           box-shadow:0 6px 16px rgba(2,18,36,.05); transition:.15s; }
  .p-card:hover{ transform: translateY(-2px); box-shadow:0 12px 28px rgba(2,18,36,.08); }
  .p-media{ background:#fff; display:grid; place-items:center; padding:1rem; }
  .p-media img{ width:auto; height:auto; max-width:100%; max-height:180px; object-fit:contain; } /* sin recorte */
  .p-body{ padding:1rem 1rem 1.25rem; }

  .chip{ display:inline-block; font-size:.75rem; padding:.25rem .5rem; border-radius:999px;
         border:1px solid #e5e7eb; background:#f9fafb; white-space:nowrap; max-width:100%;
         overflow:hidden; text-overflow:ellipsis; }
  .chip-green{ border-color:#d1fae5; background:#ecfdf5; color:#065f46; }
  .chip-gray{  border-color:#e5e7eb; background:#f3f4f6; color:#374151; }

  /* Segment chips */
  .seg-chip{
    border: 1px solid #d1e7dd; background:#f6fffa; color:#0f5132;
    border-radius: 999px; padding:.5rem 1rem; font-weight:600; cursor:pointer;
    transition: all .15s ease-in-out;
  }
  .seg-chip:hover{ background:#d1e7dd; }
  .seg-chip.active{ background:#0f5132; color:#fff; border-color:#0f5132; }

  /* Modal */
  .detail-modal .detail-header { background:#fff; position:relative; padding:2rem 1.5rem; border-radius:0 0 .75rem .75rem; }
  .detail-modal .detail-bottle { max-width:100%; height:auto; max-height:280px; object-fit:contain; }
  .detail-modal .tagline { font-size:1.1rem; color:#6c757d; }
  .detail-modal .detail-body { background:#f8f9fb; border-radius:0 0 1rem 1rem; padding:2rem; }
  .detail-modal .detail-block { background:#fff; border-radius:.75rem; padding:1.5rem; box-shadow:0 4px 10px rgba(0,0,0,0.05); }
  .detail-modal dl dt { font-weight:600; color:#052c65; }
  .detail-modal dl dd { font-weight:500; color:#333; }

  /* Listas (sin doble bullet) */
  .control-list, .cultivos-list { list-style:none; margin:0; padding-left:0; }
  .control-list li, .cultivos-list li {
    position: relative; padding-left: 1em; margin-bottom: .3rem; line-height: 1.45;
  }
  .control-list li::before, .cultivos-list li::before {
    content: ''; position: absolute; left: 0; top: 8px; width: 6px; height: 6px;
    background-color: #16a34a; border-radius: 50%;
  }

  /* Columnas responsive en cultivos */
  @media (min-width: 576px) { .cultivos-list { columns: 2; } }
  @media (min-width: 992px) { .cultivos-list { columns: 3; } }
  @media (min-width:1200px){ .cultivos-list { columns: 4; } }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const grid  = document.getElementById('p-grid');
  const cards = Array.from(grid.querySelectorAll('.p-card-wrap'));
  const empty = document.getElementById('p-empty');
  const state = { segment:'', classAttr:'', classValue:'', q:'' };

  const slugify = (s) => (s || '').toString().trim().toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
    .replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'');

  function isAbsUrl(p){ return /^https?:\/\//i.test(p || ''); }
  function normalizePath(p){
    if(!p) return null;
    if (isAbsUrl(p)) return p;
    p = p.replace(/^\/+/, '').replace(/^public\//i, '');
    if (!/^img\//i.test(p)) p = 'img/' + p; // asegura ruta pública
    return p;
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
  document.getElementById('p-search').addEventListener('input', (e)=>{
    state.q = e.target.value.trim().toLowerCase();
    applyFilters();
  });

  // Selección rápida
  const quickSelect = document.getElementById('p-quick');
  if (quickSelect){
    quickSelect.addEventListener('change', e=>{
      const id = e.target.value;
      if(!id) return;
      const card = grid.querySelector(`.p-card-wrap[data-id="${id}"]`); // <-- fix del selector
      if(card){
        card.scrollIntoView({behavior:'smooth', block:'center'});
        const btn = card.querySelector('.p-view');
        if(btn) btn.click();
      }
      e.target.value = '';
    });
  }

  // === Filtro inicial desde ?class=&value= ===
  (function applyInitialFilter(){
    const init = (window.initialFilter || {});
    if (!init.class || !init.value) return;

    classSelect.value = init.class;
    classSelect.dispatchEvent(new Event('change'));

    const trySelect = () => {
      const opts = Array.from(valueSelect.options);
      if (opts.length <= 1) { setTimeout(trySelect, 25); return; }
      const target = opts.find(o => o.value === init.value)
                   || opts.find(o => slugify(o.textContent) === init.value);
      if (target) {
        valueSelect.value = target.value;
        state.classAttr = init.class;
        state.classValue = target.value;
        applyFilters();
      }
    };
    trySelect();
  })();

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
          case 'categoria': show = (cat === state.classValue); break;
          case 'control':   show = ctrl.split(',').includes(state.classValue); break;
          case 'cultivo':   show = cult.split(',').includes(state.classValue); break;
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

  function openModal(){ hasBootstrap ? modal.show() : fallbackOpen(); }
  function closeModal(){ hasBootstrap ? modal.hide() : fallbackClose(); }

  // Fallback puro si no hay Bootstrap
  function fallbackOpen(){
    modalEl.classList.add('vanilla-open','show');
    modalEl.style.display='block';
    modalEl.removeAttribute('aria-hidden');
    const b = document.createElement('div');
    b.className='modal-backdrop vanilla';
    b.id='pModalBackdrop';
    document.body.appendChild(b);
    document.body.style.overflow='hidden';
  }
  function fallbackClose(){
    modalEl.classList.remove('vanilla-open','show');
    modalEl.style.display='none';
    modalEl.setAttribute('aria-hidden','true');
    const b = document.getElementById('pModalBackdrop');
    if (b) b.remove();
    document.body.style.overflow='';
  }

  // Cerrar al pulsar la X (funciona con o sin Bootstrap)
  modalEl.addEventListener('click', (e)=>{
    if (e.target.closest('[data-bs-dismiss="modal"]')) {
      e.preventDefault();
      closeModal();
    }
    if (!hasBootstrap && e.target === modalEl) closeModal();
  });

  // --- Reglas de listas ---
  const isEfecto = (t)=> (/^\s*efecto\b/i).test(t || '');
  const splitControl = (t)=>{
    t = (t || '').trim();
    if (!t) return [];
    if (isEfecto(t)) return [t.replace(/\s*[.;,]\s*$/,'')]; // un solo bullet
    return t.split(',').map(s=>s.trim()).filter(Boolean).map(s=>s.replace(/\s*[.;,]\s*$/,''));
  };

  // Abrir modal con datos de la card
  grid.addEventListener('click', (e)=>{
    const btn = e.target.closest('.p-view');
    if(!btn) return;
    const wrap = btn.closest('.p-card-wrap'); if(!wrap) return;

    const data = JSON.parse(wrap.dataset.json || '{}');

    // IMAGEN siempre desde fotoProducto
    setSrc('#d-botella', data.fotoProducto || '');

    // Texto
    setText('#d-titulo', data.nombre || '');
    setText('#d-cat', [data.segmento, data.categoria].filter(Boolean).join(' • ') || '—');
    setText('#d-registro',     data.registro || '—');
    setText('#d-contenido',    data.contenido || '—');
    setText('#d-dosis',        data.dosisSugerida || '—');
    setText('#d-intervalo',    data.intervaloAplicacion || '—');
    setText('#d-presentacion', data.presentacion || '—');

    // Listas
    fillList('#d-control',  splitControl(data.controla || ''));
    fillList('#d-cultivos', (data.usoRecomendado || '').split(',').map(s=>s.trim()).filter(Boolean));

    // PDFs
    toggleLink(document.getElementById('d-ficha'), normalizePath(data.fichaTecnica || ''));
    toggleLink(document.getElementById('d-hoja'),  normalizePath(data.hojaSeguridad || ''));

    openModal();
  });

  // Helpers
  function setText(sel, v){ const el = document.querySelector(sel); if(el) el.textContent = v; }
  function setSrc(sel, path){
    const el = document.querySelector(sel); if(!el) return;
    let url = normalizePath(path);
    if (!url) url = 'img/placeholder.png';
    el.src = isAbsUrl(url) ? url : (assetRoot + url);
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
  function toggleLink(aEl, url){
    if(!aEl) return;
    if(url){ aEl.href = isAbsUrl(url) ? url : (assetRoot + url); aEl.classList.remove('d-none'); }
    else { aEl.classList.add('d-none'); aEl.removeAttribute('href'); }
  }
});
</script>
@endpush

@section('footer')
  @include('includes.footer')
@endsection

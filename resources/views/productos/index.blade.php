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
  <div class="container-fluid px-4">  {{-- más ancho que container con margen horizontal --}}
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

    {{-- GRID (2 por fila en sm, 3 en lg, 4 en xl, 6 en xxl) --}}
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
                // Normaliza la ruta de la BD a la carpeta public/img/fotosproducto
                $ruta = $img
                  ? preg_replace('#^/?Fotos(Productos?|Catalogo)/#i', 'img/fotosproducto/', $img)
                  : 'img/placeholder.png';
              @endphp
              <img src="{{ asset($ruta) }}" alt="{{ $p->nombre }}" loading="lazy" decoding="async">
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

{{-- Filtros para JS --}}
<script>
window.availableFilters = {
  segmento: @json($segmentos->map(fn($s) => trim($s))->values()),
  categoria: @json($categorias->map(fn($c) => trim($c))->values()),
  control: @json($controles->map(fn($c) => trim($c))->values()),
  cultivo: @json($cultivos->map(fn($c) => trim($c))->values()),
};

// Expone el root de asset() a JS para construir URLs absolutas
window.assetRoot = "{{ asset('') }}";
</script>

{{-- MODAL DETALLE --}}
<div class="modal fade" id="pModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
    <div class="modal-content detail-modal">
      <div class="modal-body p-0">
        <header class="detail-hero position-relative">
          <img id="d-banner" class="detail-banner" src="" alt="" />
          <div class="detail-hero-overlay"></div>
          <div class="detail-hero-content container">
            <div class="row align-items-center">
              <div class="col-12 col-lg-5 text-center">
                <img id="d-botella" class="detail-bottle" src="" alt="">
              </div>
              <div class="col-12 col-lg-7">
                <h2 class="display-6 fw-bold mb-2" id="d-titulo">Título</h2>
                <p class="lead mb-3">Llevamos hasta ti productos de alta <span class="fw-bolder">calidad</span>.</p>
                <div class="badge bg-success-subtle text-success-emphasis fw-semibold px-3 py-2" id="d-cat">CATEGORÍA</div>
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-light btn-close-detail" data-bs-dismiss="modal" aria-label="Cerrar">
            <i class="fas fa-times"></i>
          </button>
        </header>

        <section class="detail-body container py-4 py-lg-5">
          <div class="row g-4">
            <div class="col-12 col-lg-6">
              <div class="detail-block">
                <h3 class="h5 fw-bold text-success mb-3">Ficha técnica</h3>
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
                <h3 class="h5 fw-bold text-success mb-3">Controla</h3>
                <ul id="d-control" class="icon-list"></ul>
              </div>
            </div>

            <div class="col-12">
              <div class="detail-block">
                <h3 class="h5 fw-bold text-success mb-3">Uso en los siguientes cultivos</h3>
                <div id="d-cultivos" class="tags"></div>
              </div>
            </div>

            <div class="col-12 d-flex gap-2 flex-wrap">
              <a id="d-ficha" href="#" target="_blank" class="btn btn-success">
                <i class="far fa-file-alt me-2"></i> Descargar ficha técnica
              </a>
              <a id="d-hoja" href="#" target="_blank" class="btn btn-outline-success">
                <i class="fas fa-lock me-2"></i> Hoja de seguridad
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
<link rel="stylesheet" href="{{ asset('css/infoProductos.css') }}">
@endpush

@push('scripts')
{{-- Recuerda incluir Bootstrap JS en tu layout o antes de este script --}}
<script src="{{ asset('js/infoProductos.js') }}"></script>
@endpush

@section('footer')
  @include('includes.footer')
@endsection

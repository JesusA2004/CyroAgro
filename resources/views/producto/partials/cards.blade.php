@foreach ($productos as $producto)
  @php
      $imgRaw = $producto->FotoCatalogo ?: ($producto->fotoProducto ?? null) ?: ($producto->fotosProducto ?? null);
      if ($imgRaw) {
          $imgRaw = ltrim((string)$imgRaw, '/');
          $imgRaw = preg_replace('#^public/#i', '', $imgRaw);
          $ruta = str_contains($imgRaw, '/')
              ? preg_replace('#^(img/)?Fotos(Productos?|Catalogo)/#i', 'img/FotosProducto/', $imgRaw)
              : 'img/FotosProducto/' . $imgRaw;
      } else {
          $ruta = 'img/generica.png';
      }
  @endphp

  <div class="col-sm-6 col-md-4 col-lg-3 mb-4 product-card">
    <div class="card h-100 shadow animate-fadein">
      <div class="position-relative">
        <img src="{{ asset($ruta) }}" class="card-img-top rounded-top img-fluid"
             alt="Imagen del producto"
             style="height:200px;object-fit:contain;background:#fff"
             onerror="this.onerror=null;this.src='{{ asset('img/generica.png') }}';">
      </div>
      <div class="card-body p-3">
        <h5 class="card-title text-truncate">{{ $producto->nombre }}</h5>
        <p class="text-muted small mb-1">{{ $producto->segmento }} | {{ $producto->categoria }}</p>
        <p class="small mb-1"><strong>Registro:</strong> {{ $producto->registro }}</p>
        <p class="small mb-1"><strong>Contenido:</strong> {{ Str::limit($producto->contenido, 40) }}</p>
      </div>
      <div class="crud-actions d-flex justify-content-around py-2">
        <a href="{{ route('producto.show', $producto->id) }}" class="btn btn-outline-primary" title="Ver">
          <i class="fa fa-eye fa-xl"></i>
        </a>
        @auth
          <a href="{{ route('producto.edit', $producto->id) }}" class="btn btn-outline-success" title="Editar">
            <i class="fa fa-edit fa-xl"></i>
          </a>
        @endauth
      </div>
    </div>
  </div>
@endforeach

@if($productos->isEmpty())
  <div class="col-12"><div class="alert alert-warning mb-0">No se encontraron productos.</div></div>
@endif

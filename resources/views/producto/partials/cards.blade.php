{{-- resources/views/producto/partials/cards.blade.php --}}
@php
  /** @var \Illuminate\Support\Collection|\Illuminate\Pagination\AbstractPaginator $productos */
  $role = auth()->check() ? auth()->user()->role : null;
@endphp

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

        @if(!empty($producto->registro))
          <p class="small mb-1"><strong>Registro:</strong> {{ $producto->registro }}</p>
        @endif

        @if(!empty($producto->contenido))
          <p class="small mb-1"><strong>Contenido:</strong> {{ \Illuminate\Support\Str::limit($producto->contenido, 40) }}</p>
        @endif
      </div>

      <div class="crud-actions d-flex justify-content-center gap-2 py-2 px-2">
        {{-- Ver: siempre visible --}}
        <a href="{{ route('producto.show', $producto->id) }}" class="btn btn-outline-primary" title="Ver">
          <i class="fa fa-eye fa-xl"></i>
        </a>

        {{-- Editar: administrador o empleado --}}
        @auth
          @if($role === 'administrador' || $role === 'empleado')
            <a href="{{ route('producto.edit', $producto->id) }}" class="btn btn-outline-success" title="Editar">
              <i class="fa fa-edit fa-xl"></i>
            </a>
          @endif
        @endauth

        {{-- Eliminar: solo administrador (abre modal de confirmación) --}}
        @auth
          @if($role === 'administrador')
            <button type="button"
                    class="btn btn-outline-danger"
                    title="Eliminar"
                    data-bs-toggle="modal"
                    data-bs-target="#confirmDeleteModal"
                    data-delete-url="{{ route('producto.destroy', $producto->id) }}"
                    data-product-name="{{ $producto->nombre }}">
              <i class="fa fa-trash fa-xl"></i>
            </button>
          @endif
        @endauth
      </div>
    </div>
  </div>
@endforeach

@if($productos->isEmpty())
  <div class="col-12">
    <div class="alert alert-warning mb-0">No se encontraron productos.</div>
  </div>
@endif

{{-- ===== Modal de confirmación (una sola vez) ===== --}}
@auth
  @if(($role ?? null) === 'administrador')
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow-lg">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title" id="confirmDeleteLabel">Eliminar producto</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p class="mb-0">
              ¿Seguro que deseas eliminar <strong id="deleteProductName">este producto</strong>?<br>
              Esta acción no se puede deshacer.
            </p>
          </div>
          <div class="modal-footer justify-content-center">
            <form id="deleteProductForm" method="POST" action="#">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger px-4">Eliminar</button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    {{-- Script mínimo para inyectar la URL y el nombre en el modal --}}
    <script>
      document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-bs-target="#confirmDeleteModal"]');
        if (!btn) return;

        const url   = btn.getAttribute('data-delete-url');
        const name  = btn.getAttribute('data-product-name') || 'este producto';

        const form  = document.getElementById('deleteProductForm');
        const label = document.getElementById('deleteProductName');

        if (form && url) form.setAttribute('action', url);
        if (label) label.textContent = name;
      });
    </script>
  @endif
@endauth

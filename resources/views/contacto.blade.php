@extends('layouts.public')

@push('styles')
<link href="{{ asset('css/contacto.css') }}" rel="stylesheet">
@endpush

@section('content')
<section id="contact-header" class="text-white text-center d-flex align-items-center justify-content-center">
  <div class="container position-relative">
  </div>
</section>

{{-- MAPA --}}
<section id="mapa-cyr" class="bg-white py-5">
  <div class="container text-center">
      <h2 class="section-title mb-5">Cobertura Nacional</h2>
      <p class="lead mb-5">Pasa el mouse por cada zona para conocer a nuestros representantes</p>

      <div class="mapa-container mx-auto" style="max-width: 900px;">
          @include('includes.mapa-mexico')
      </div>

      <div id="info-zona" class="mt-4 fw-bold fs-5 text-primary"></div>
  </div>

  {{-- Tarjeta flotante (tooltip) --}}
  <div id="tarjeta-zona" class="card shadow-lg px-4 py-3 text-start mx-auto mt-4"
       style="display: none; max-width: 400px;">
      {{-- Botón cerrar (X) arriba a la derecha --}}
      <button type="button" id="btn-cerrar" class="btn-close position-absolute top-0 end-0 m-2"
              aria-label="Cerrar"></button>

      <h5 id="titulo-zona" class="fw-bold text-success mb-2"></h5>
      <p class="mb-1"><strong>Representante:</strong> <span id="nombre-rep"></span></p>
      <p class="mb-1"><strong>Teléfono:</strong> <span id="tel-rep"></span></p>
      <p class="mb-0"><strong>Correo:</strong> <span id="correo-rep"></span></p>

      <div class="text-end mt-3">
          <button id="btn-copiar" class="btn btn-sm btn-outline-primary">
              <i class="fas fa-copy"></i> Copiar datos
          </button>
      </div>
  </div>

  <div class="clearfix mb-5"></div>
</section>

<section id="contact-form" class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2>Formulario de contacto</h2>
      <p class="text-muted">Por favor completa el siguiente formulario y nos pondremos en contacto contigo lo antes posible.</p>
    </div>
    <form action="#" method="POST" class="row g-4">
      <div class="col-md-4">
        <input type="text" name="name" class="form-control" placeholder="Tu nombre" required>
      </div>
      <div class="col-md-4">
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
      </div>
      <div class="col-md-4">
        <input type="text" name="subject" class="form-control" placeholder="Asunto" required>
      </div>
      <div class="col-12">
        <textarea name="message" class="form-control" rows="6" placeholder="Mensaje" required></textarea>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary px-5">Enviar mensaje</button>
      </div>
    </form>
  </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
  // --- Elementos del tooltip/card ---
  const card     = document.getElementById('tarjeta-zona');
  const titulo   = document.getElementById('titulo-zona');
  const nombre   = document.getElementById('nombre-rep');
  const tel      = document.getElementById('tel-rep');
  const correo   = document.getElementById('correo-rep');
  const btnCopy  = document.getElementById('btn-copiar');
  const btnClose = document.getElementById('btn-cerrar');
  const mapaContainer = document.querySelector('#mapa-cyr .mapa-container');

  if (!card || !titulo || !nombre || !tel || !correo || !mapaContainer || !btnCopy || !btnClose) return;

  card.style.display = 'block';

  const zonas = {
    'Zona Noroeste': {
      estados: ['MXSON','MXSIN','MXCHH'],
      nombre: 'Maira Olivas Olivas',
      tel: '7772338212',
      correo: 'maira@ultraquimia.com'
    },
    'Zona Bajío': {
      estados: ['MXGUA','MXQRO','MXSLP','MXMIC'],
      nombre: 'Gustavo Rico Resendiz',
      tel: '7773841658',
      correo: 'gustavo.cyr@hotmail.com'
    },
    'Zona Centro': {
      estados: ['MXCMX','MXMOR','MXPUE','MXMEX'],
      nombre: 'Oficina',
      tel: '7773218657 / 7773271756',
      correo: 'rosascordero@yahoo.com.mx'
    },
    'Zona Sureste': {
      estados: ['MXVER','MXCHP','MXOAX','MXTAB','MXCAM','MXYUC','MXROO'],
      nombre: 'Mario Alejos Peraza',
      tel: '9992400412',
      correo: 'mariopti@hotmail.com'
    },
    'Zona Baja California': {
      estados: ['MXBCN','MXBCS'],
      nombre: 'Gabriel Hernández',
      tel: '6161010081',
      correo: 'ing_gabihz@hotmail.com'
    }
  };

  let pinned = false;
  let pinRef = null;

  function setInfo(zona) {
    const info = zonas[zona];
    if (!info) return;
    titulo.textContent = zona;
    nombre.textContent = info.nombre;
    tel.textContent    = info.tel;
    correo.textContent = info.correo;
  }

  function positionNearPath(pathEl) {
    const cRect = mapaContainer.getBoundingClientRect();
    const pRect = pathEl.getBoundingClientRect();
    const margin = 12;

    const leftCand = pRect.right + 12 - cRect.left;
    const topCand  = (pRect.top + pRect.height/2) - cRect.top - (card.offsetHeight/2);

    let left = leftCand;
    let top  = topCand;

    const maxLeft = mapaContainer.clientWidth  - card.offsetWidth  - margin;
    const maxTop  = mapaContainer.clientHeight - card.offsetHeight - margin;

    if (left > maxLeft) left = Math.max(margin, pRect.left - cRect.left - card.offsetWidth - 12);
    if (left < margin)  left = margin;
    if (top  > maxTop)  top  = maxTop;
    if (top  < margin)  top  = margin;

    card.style.setProperty('--tt-left', left + 'px');
    card.style.setProperty('--tt-top',  top  + 'px');

    const centerPathX = pRect.left - cRect.left + (pRect.width/2);
    const centerCardX = left + card.offsetWidth/2;
    card.classList.remove('at-left','at-right','at-top','at-bottom');
    card.classList.add(centerCardX >= centerPathX ? 'at-left' : 'at-right');
  }

  function showFor(zona, pathEl) {
    setInfo(zona);
    positionNearPath(pathEl);
    card.classList.add('show');
  }

  function hideIfNotPinned() {
    if (!pinned) card.classList.remove('show');
  }

  Object.entries(zonas).forEach(([zona, info]) => {
    info.estados.forEach(id => {
      const estado = document.getElementById(id);
      if (!estado) return;
      estado.style.cursor = 'pointer';

      estado.addEventListener('mouseenter', () => {
        if (pinned) return;
        showFor(zona, estado);
      });
      estado.addEventListener('mousemove', () => {
        if (pinned) return;
        positionNearPath(estado);
      });
      estado.addEventListener('mouseleave', () => {
        hideIfNotPinned();
      });
      estado.addEventListener('click', (e) => {
        e.stopPropagation();
        pinned = true;
        pinRef = { zona, targetId: id };
        showFor(zona, estado);
        card.classList.add('pinned');
      });
    });
  });

  btnClose.addEventListener('click', (e) => {
    e.stopPropagation();
    pinned = false;
    pinRef = null;
    card.classList.remove('show', 'pinned');
  });

  document.addEventListener('click', (e) => {
    if (!pinned) return;
    if (!mapaContainer.contains(e.target) && !card.contains(e.target)) {
      pinned = false;
      pinRef = null;
      card.classList.remove('show', 'pinned');
    }
  });

  window.addEventListener('resize', () => {
    if (pinned && pinRef) {
      const el = document.getElementById(pinRef.targetId);
      if (el) positionNearPath(el);
    }
  });

  btnCopy.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();

    const datos = (
`${titulo.textContent}
Representante: ${nombre.textContent}
Teléfono: ${tel.textContent}
Correo: ${correo.textContent}` ).trim();

    const done = () => {
      btnCopy.innerHTML = '<i class="fas fa-check"></i> Copiado';
      setTimeout(() => btnCopy.innerHTML = '<i class="fas fa-copy"></i> Copiar datos', 1800);
    };

    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(datos).then(done).catch(() => fallbackCopy(datos, done));
    } else {
      fallbackCopy(datos, done);
    }
  });

  function fallbackCopy(text, onSuccess){
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.setAttribute('readonly', '');
    ta.style.position = 'fixed';
    ta.style.left = '-9999px';
    document.body.appendChild(ta);
    ta.select();
    try { document.execCommand('copy'); } catch(e){}
    document.body.removeChild(ta);
    if (typeof onSuccess === 'function') onSuccess();
  }
})();
</script>
@endpush

@section('footer')
  @include('includes.footer')
@endsection

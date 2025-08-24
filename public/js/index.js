(function(){
  // Normaliza rutas de imágenes a /img/fotosproducto/...
  function normalizeImgPath(p){
    if(!p) return null;
    p = p.replace(/^\/+/, ''); // quita leading slash
    p = p.replace(/^Fotos(Productos?|Catalogo)\//i, 'img/fotosproducto/');
    return p;
  }
  // Normaliza docs (PDFs) a asset()
  function normalizeDocPath(p){
    if(!p) return null;
    if(/^https?:\/\//i.test(p)) return p;
    p = p.replace(/^\/+/, '');
    return ASSET_ROOT + p;
  }

  // Root de asset() para concatenar relativo
  const ASSET_ROOT = document.querySelector('link[rel="stylesheet"][href*="css"]')
    ? document.querySelector('link[rel="stylesheet"][href*="css"]').href.replace(/\/css\/.*$/, '/')
    : (document.querySelector('script[src*="js"]')?.src.replace(/\/js\/.*$/, '/') || '/');

  const modalEl = document.getElementById('pModal');
  const bsModal = window.bootstrap ? new bootstrap.Modal(modalEl) : null;

  // Abrir modal desde botón "Ver producto"
  document.addEventListener('click', function(e){
    const btn = e.target.closest('.p-view');
    if(!btn) return;

    const wrap = btn.closest('.p-card-wrap');
    if(!wrap) return;

    let data = {};
    try { data = JSON.parse(wrap.dataset.json || '{}'); } catch(_){}

    // Título / categoría
    document.getElementById('d-titulo').textContent = data.nombre || 'Producto';
    document.getElementById('d-cat').textContent = [data.segmento, data.categoria].filter(Boolean).join(' • ');

    // Botella
    const bottle = document.getElementById('d-botella');
    const foto   = normalizeImgPath(data.FotoCatalogo || data.fotoProducto);
    bottle.src   = foto ? ASSET_ROOT + foto : ASSET_ROOT + 'img/placeholder.png';
    bottle.alt   = data.nombre || 'Producto';

    // Banner (puedes cambiarlo si tienes uno por producto)
    const banner = document.getElementById('d-banner');
    banner.src   = ASSET_ROOT + 'img/banner/BANNER MUESTRA.png';

    // Ficha técnica / campos
    const setText = (id, val) => document.getElementById(id).textContent = (val && String(val).trim()) ? val : '—';
    setText('d-registro', data.registro);
    setText('d-contenido', data.contenido);
    setText('d-dosis', data.dosisSugerida);
    setText('d-intervalo', data.intervaloAplicacion);
    setText('d-presentacion', data.presentacion);

    // Controla (lista)
    const ulCtrl = document.getElementById('d-control');
    ulCtrl.innerHTML = '';
    if(data.controla){
      data.controla.split(',').map(s=>s.trim()).filter(Boolean).forEach(item=>{
        const li = document.createElement('li');
        li.textContent = item;
        ulCtrl.appendChild(li);
      });
    }

    // Cultivos (tags)
    const tags = document.getElementById('d-cultivos');
    tags.innerHTML = '';
    if(data.usoRecomendado){
      data.usoRecomendado.split(',').map(s=>s.trim()).filter(Boolean).forEach(c=>{
        const span = document.createElement('span');
        span.className = 'badge rounded-pill text-bg-success-subtle border border-success-subtle me-2 mb-2';
        span.textContent = c;
        tags.appendChild(span);
      });
    }

    // Enlaces
    const aFicha = document.getElementById('d-ficha');
    const aHoja  = document.getElementById('d-hoja');
    const ficha  = normalizeDocPath(data.fichaTecnica);
    const hoja   = normalizeDocPath(data.hojaSeguridad);

    if(ficha){ aFicha.href = ficha; aFicha.classList.remove('disabled'); }
    else     { aFicha.href = '#'; aFicha.classList.add('disabled'); }

    if(hoja){  aHoja.href = hoja;  aHoja.classList.remove('disabled'); }
    else     { aHoja.href = '#';   aHoja.classList.add('disabled'); }

    // Mostrar modal
    if(bsModal) bsModal.show();
  });

  // Selector rápido: abre modal del seleccionado
  const quick = document.getElementById('p-quick');
  if(quick){
    quick.addEventListener('change', function(){
      const id = this.value;
      if(!id) return;
      const btn = document.querySelector(`.p-card-wrap[data-id="${id}"] .p-view`);
      btn && btn.click();
    });
  }
})();

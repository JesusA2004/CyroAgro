// public/js/busquedaProductos.js
(function () {
  const input = document.getElementById('busqueda');
  const container = document.getElementById('productContainer');
  const paginatorWrap = document.querySelector('.pagination-wrap');
  if (!input || !container) return;

  const INDEX_URL = input.getAttribute('data-url'); // /producto
  const originalHTML = container.innerHTML;
  const originalPaginator = paginatorWrap ? paginatorWrap.innerHTML : '';
  let t = null;

  function setPaginatorVisible(show) {
    if (!paginatorWrap) return;
    paginatorWrap.style.display = show ? '' : 'none';
    if (show && originalPaginator && paginatorWrap.innerHTML.trim() === '') {
      paginatorWrap.innerHTML = originalPaginator;
    }
  }

  input.addEventListener('input', function (e) {
    const q = e.target.value.trim();

    if (q === '') {
      if (t) clearTimeout(t);
      container.innerHTML = originalHTML;
      setPaginatorVisible(true);
      return;
    }

    setPaginatorVisible(false);

    if (t) clearTimeout(t);
    t = setTimeout(async () => {
      try {
        const url = new URL(INDEX_URL, window.location.origin);
        url.searchParams.set('q', q);

        const res = await fetch(url, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          cache: 'no-store',
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);

        const html = await res.text();
        container.innerHTML = html;
      } catch (err) {
        container.innerHTML = `
          <div class="col-12"><div class="alert alert-danger">
            Ocurrió un error al buscar.
          </div></div>`;
        console.error(err);
      }
    }, 250);
  });
})();

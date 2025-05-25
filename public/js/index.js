document.addEventListener('DOMContentLoaded', () => {
    const anchors = document.querySelectorAll('a.page-scroll');
    const indexUrl = document.querySelector('meta[name="index-url"]').getAttribute('content');
    const isIndex = window.location.pathname === new URL(indexUrl).pathname;

    anchors.forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            if (href && href.startsWith('#')) {
                e.preventDefault();

                if (isIndex) {
                    const target = document.querySelector(href);
                    if (target) {
                        const top = target.getBoundingClientRect().top + window.pageYOffset - 80;
                        window.scrollTo({
                            top: top,
                            behavior: 'smooth'
                        });
                    }
                } else {
                    window.location.href = indexUrl + href;
                }
            }
        });
    });
});

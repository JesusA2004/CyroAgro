document.addEventListener('DOMContentLoaded', () => {
    const anchors = document.querySelectorAll('a.page-scroll');
    const indexMeta = document.querySelector('meta[name="index-url"]');
    const indexUrl = indexMeta ? indexMeta.getAttribute('content') : '/';
    const currentPath = window.location.pathname;
    const isIndex = currentPath === new URL(indexUrl, window.location.origin).pathname;

    function slowScrollTo(targetY, duration = 1000) {
        const startY = window.scrollY;
        const distance = targetY - startY;
        const startTime = performance.now();

        function step(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const ease = easeInOutCubic(progress);
            window.scrollTo(0, startY + distance * ease);

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        }

        function easeInOutCubic(t) {
            return t < 0.5
                ? 4 * t * t * t
                : 1 - Math.pow(-2 * t + 2, 3) / 2;
        }

        requestAnimationFrame(step);
    }

    anchors.forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href || !href.startsWith('#')) return;

            e.preventDefault();

            if (isIndex) {
                const target = document.querySelector(href);
                if (target) {
                    const navbar = document.querySelector('#mainNav');
                    const offset = navbar ? navbar.offsetHeight + 10 : 80;
                    const targetY = target.getBoundingClientRect().top + window.scrollY - offset;

                    slowScrollTo(targetY, 1200); // duración en ms (ajustable)
                }
            } else {
                window.location.href = indexUrl + href;
            }
        });
    });
});

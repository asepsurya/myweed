(function () {
    'use strict';

    const slider = document.getElementById('heroSlider');
    if (!slider) return;

    const slides = Array.prototype.slice.call(slider.querySelectorAll('.ev-slide'));
    if (!slides.length) return;

    const dotsWrap = document.getElementById('heroSliderDots');
    const prevBtn = document.getElementById('heroSliderPrev');
    const nextBtn = document.getElementById('heroSliderNext');

    const AUTOPLAY_DELAY = 4500;

    let current = 0;
    let timer = null;
    let touchStartX = 0;
    let touchDeltaX = 0;

    const dots = slides.map(function (slide, index) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'ev-slider-dot';
        dot.setAttribute('aria-label', 'Tampilkan slide ' + (index + 1));
        dot.addEventListener('click', function () {
            current = index;
            render();
            restart();
        });
        if (dotsWrap) dotsWrap.appendChild(dot);
        return dot;
    });

    function getGap() {
        const raw = getComputedStyle(slider).getPropertyValue('--ev-slider-gap');
        const gap = parseFloat(raw);
        return isNaN(gap) || gap <= 0 ? 132 : gap;
    }

    function render() {
        const total = slides.length;
        const step = getGap();

        slides.forEach(function (slide, index) {
            let offset = index - current;

            if (offset > total / 2) offset -= total;
            if (offset < -total / 2) offset += total;

            const distance = Math.abs(offset);
            const scale = offset === 0 ? 1 : Math.max(0.72, 1 - distance * 0.08);

            slide.style.transform = 'translate(-50%, -50%) translateX(' + (offset * step) + 'px) scale(' + scale + ')';
            slide.style.zIndex = String(20 - distance);
            slide.style.opacity = distance > 1 ? '0' : String(1 - distance * 0.25);
            slide.style.pointerEvents = distance > 1 ? 'none' : 'auto';
            slide.classList.toggle('is-active', offset === 0);

            if (offset === 0) {
                slide.setAttribute('aria-current', 'true');
            } else {
                slide.removeAttribute('aria-current');
            }

            dots[index].classList.toggle('is-active', index === current);
        });
    }

    function goTo(index) {
        current = (index + slides.length) % slides.length;
        render();
    }

    function next() {
        goTo(current + 1);
    }

    function prev() {
        goTo(current - 1);
    }

    function start() {
        if (slides.length < 2) return;
        stop();
        timer = window.setInterval(next, AUTOPLAY_DELAY);
    }

    function stop() {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
    }

    function restart() {
        stop();
        start();
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function () {
            prev();
            restart();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function () {
            next();
            restart();
        });
    }

    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);

    slider.addEventListener('touchstart', function (e) {
        touchStartX = e.touches[0].clientX;
        touchDeltaX = 0;
        stop();
    }, { passive: true });

    slider.addEventListener('touchmove', function (e) {
        touchDeltaX = e.touches[0].clientX - touchStartX;
    }, { passive: true });

    slider.addEventListener('touchend', function () {
        if (Math.abs(touchDeltaX) > 45) {
            if (touchDeltaX < 0) {
                next();
            } else {
                prev();
            }
        }
        touchDeltaX = 0;
        start();
    });

    document.addEventListener('keydown', function (e) {
        if (!slider.closest('.ev-hero-stage')) return;
        if (e.key === 'ArrowLeft') {
            prev();
            restart();
        } else if (e.key === 'ArrowRight') {
            next();
            restart();
        }
    });

    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            stop();
        } else {
            start();
        }
    });

    let resizeTimer = null;
    window.addEventListener('resize', function () {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(render, 160);
    });

    render();
    start();
})();

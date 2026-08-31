<style>
    .auto-scroll-btn {
        position: fixed;
        bottom: 80px;
        left: 20px;
        z-index: 1040;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1.5px solid rgba(212, 175, 55, 0.4);
        color: #D4AF37;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    .auto-scroll-btn:hover {
        transform: scale(1.08);
        border-color: rgba(212, 175, 55, 0.8);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
    }
    
    .auto-scroll-btn.active {
        background: rgba(212, 175, 55, 0.15);
        border-color: rgba(212, 175, 55, 0.8);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5), 0 4px 15px rgba(255, 158, 181, 0.4);
    }
    
    .auto-scroll-btn svg {
        width: 18px;
        height: 18px;
        fill: currentColor;
        transition: transform 0.3s ease;
        filter: drop-shadow(0 0 3px rgba(212, 175, 55, 0.6));
    }
    
    .auto-scroll-btn.active svg {
        animation: scroll-bounce 2s infinite ease-in-out;
    }

    @keyframes scroll-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(3px); }
    }
</style>

<button type="button" id="autoScrollBtn" class="auto-scroll-btn" title="Auto Scroll" aria-label="Toggle Auto Scroll">
    <svg id="scrollIcon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <!-- Play / Scroll Down Icon -->
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 13.5L7.5 11l1.42-1.41L12 12.67l3.08-3.08L16.5 11 12 15.5z"/>
    </svg>
</button>

<script>
    (function() {
        const btn = document.getElementById('autoScrollBtn');
        const icon = document.getElementById('scrollIcon');
        let isScrolling = false;
        let scrollAnimationId = null;

        // Path Icon untuk Play (Mulai Scroll)
        const playPath = "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 13.5L7.5 11l1.42-1.41L12 12.67l3.08-3.08L16.5 11 12 15.5z";
        // Path Icon untuk Pause (Berhenti Scroll)
        const pausePath = "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 12H9V10h2v4zm4 0h-2V10h2v4z";

        function step() {
            if (!isScrolling) return;
            
            // Kecepatan scroll (1 pixel per frame)
            window.scrollBy(0, 1);
            
            // Cek apakah sudah mencapai bagian paling bawah halaman
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 2) {
                stopScroll();
            } else {
                scrollAnimationId = window.requestAnimationFrame(step);
            }
        }

        function stopScroll() {
            isScrolling = false;
            btn.classList.remove('active');
            icon.innerHTML = `<path d="${playPath}"/>`;
            if (scrollAnimationId) {
                window.cancelAnimationFrame(scrollAnimationId);
                scrollAnimationId = null;
            }
        }

        function startScroll() {
            isScrolling = true;
            btn.classList.add('active');
            icon.innerHTML = `<path d="${pausePath}"/>`;
            scrollAnimationId = window.requestAnimationFrame(step);
        }

        if (btn) {
            btn.addEventListener('click', function() {
                if (isScrolling) {
                    stopScroll();
                } else {
                    startScroll();
                }
            });
        }

        // Hentikan scroll otomatis jika pengguna scroll manual (scroll wheel mouse / sentuhan layar)
        // Gunakan timeout agar klik tombol tidak langsung memicu stopScroll
        let interactionTimeout;
        function handleUserInteraction() {
            if (!isScrolling) return;
            clearTimeout(interactionTimeout);
            interactionTimeout = setTimeout(() => {
                stopScroll();
            }, 50); // delay kecil untuk membedakan scroll dari sistem vs user
        }

        window.addEventListener('wheel', handleUserInteraction, { passive: true });
        window.addEventListener('touchmove', handleUserInteraction, { passive: true });
    })();
</script>

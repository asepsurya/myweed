  <!-- Audio -->
    <audio id="bgMusic" loop>
        <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg">
    </audio>

            <!-- FOOTER -->
            <div class="text-center text-sm text-gray-500 animate-on-scroll">
                <p>Terima kasih atas doa dan restunya</p>
                <p class="font-serif text-primary mt-1">{{ $invitation->bride_name }} & {{ $invitation->groom_name }}
                </p>
            </div>
    <!-- ================= SCRIPT ================= -->
    <script>
        // =======================
        // MUSIC & OPEN INVITATION
        // =======================
        const bgMusic = document.getElementById('bgMusic');
        const openBtn = document.getElementById('openInvitation');
        const musicToggle = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');

        let isPlaying = false;

        // AUTO PLAY saat page dimuat
        bgMusic.play().then(() => {
            isPlaying = true;
            if (musicIcon) musicIcon.innerHTML = `
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M10 9h2v6h-2V9zm4 0h2v6h-2V9z" />`;
        }).catch(() => {
            openBtn.addEventListener('click', () => {
                bgMusic.play();
                isPlaying = true;
                if (musicIcon) musicIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10 9h2v6h-2V9zm4 0h2v6h-2V9z" />`;
                document.getElementById('content').scrollIntoView({
                    behavior: 'smooth'
                });
            }, {
                once: true
            });
        });

        // SCROLL saat tombol di klik
        openBtn.addEventListener('click', () => {
            document.getElementById('content').scrollIntoView({
                behavior: 'smooth'
            });
        });

        // PAUSE musik saat keluar dari page
        window.addEventListener('beforeunload', () => {
            bgMusic.pause();
            isPlaying = false;
        });

        // MUSIC TOGGLE
        if (musicToggle) {
            musicToggle.addEventListener('click', () => {
                if (isPlaying) {
                    bgMusic.pause();
                    musicIcon.innerHTML =
                        `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M14.752 11.168l-6.518-3.759A1 1 0 007 8.32v7.36a1 1 0 001.234.97l6.518-1.885a1 1 0 00.75-.97v-1.87a1 1 0 00-.75-.97z" />`;
                } else {
                    bgMusic.play();
                    musicIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 9h2v6h-2V9zm4 0h2v6h-2V9z" />`;
                }
                isPlaying = !isPlaying;
            });
        }

        // COUNTDOWN
        function countdown() {
            const target = new Date('2026-05-12T10:00:00').getTime();
            const now = new Date().getTime();
            const d = target - now;
            document.getElementById('days').textContent = Math.floor(d / 86400000);
            document.getElementById('hours').textContent = Math.floor(d % 86400000 / 3600000);
            document.getElementById('minutes').textContent = Math.floor(d % 3600000 / 60000);
            document.getElementById('seconds').textContent = Math.floor(d % 60000 / 1000);
        }
        setInterval(countdown, 1000);
        countdown();

        // SCROLL ANIMATION
        const observer = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('show');
            });
        }, {
            threshold: .15
        });

        document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
    </script>

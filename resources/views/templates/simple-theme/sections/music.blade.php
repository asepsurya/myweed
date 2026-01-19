
 <!-- Audio -->
  <audio id="bgMusic" loop autoplay>
      @if($invitation->music == 0 && $invitation->music)
      <!-- Musik Custom -->
      <source src="{{ asset('storage/'.$invitation->music) }}" type="audio/mpeg">

      @elseif($invitation->music && $invitation->musicPreset)
      <!-- Musik dari Database -->
      <source src="{{ asset('storage/'.$invitation->musicPreset->audio_url) }}" type="audio/mpeg">

      @else
      <!-- Musik Default -->
      <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg">
      @endif
  </audio>


  <!-- FOOTER -->
  <div class="text-center text-sm text-gray-500 animate-on-scroll">
      <p>Terima kasih atas doa dan restunya</p>
      <p class="font-serif text-primary mt-1">{{ $invitation->bride_name }} & {{ $invitation->groom_name }}
      </p>
  </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // =======================
    // MUSIC & OPEN INVITATION
    // =======================
    const bgMusic = document.getElementById('bgMusic');
    const openBtn = document.getElementById('openInvitation');
    const musicToggle = document.getElementById('musicToggle');
    const musicIcon = document.getElementById('musicIcon');

    let isPlaying = false;
    let hasOpened = false; // hanya play setelah OPEN INVITATION

    // PLAY saat klik OPEN INVITATION
    openBtn?.addEventListener('click', () => {
        bgMusic?.play();
        isPlaying = true;
        hasOpened = true;
        setPauseIcon();

        document.body.classList.remove('lock-scroll'); // UNLOCK SCROLL

        document.getElementById('content')?.scrollIntoView({
            behavior: 'smooth'
        });
    });

    // AUTO PAUSE / PLAY saat tab berubah
    document.addEventListener("visibilitychange", () => {
        if (!hasOpened) return;

        if (document.hidden) {
            bgMusic?.pause();
            isPlaying = false;
            setPlayIcon();
        } else {
            bgMusic?.play();
            isPlaying = true;
            setPauseIcon();
        }
    });

    // Toggle manual
    musicToggle?.addEventListener('click', () => {
        if (isPlaying) {
            bgMusic?.pause();
            setPlayIcon();
        } else {
            bgMusic?.play();
            setPauseIcon();
        }
        isPlaying = !isPlaying;
    });

    // ICONS
    function setPauseIcon() {
        if(musicIcon) musicIcon.innerHTML = `
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M10 9h2v6h-2V9zm4 0h2v6h-2V9z" />`;
    }

    function setPlayIcon() {
        if(musicIcon) musicIcon.innerHTML = `
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M14.752 11.168l-6.518-3.759A1 1 0 007 8.32v7.36a1 1 0 001.234.97l6.518-1.885a1 1 0 00.75-.97v-1.87a1 1 0 00-.75-.97z" />`;
    }

    // =====================
    // COUNTDOWN
    // =====================
    const weddingDate = "{{ $invitation->wedding_date }}"; // 2026-01-15

    function countdown() {
        const target = new Date(weddingDate + "T10:00:00").getTime();
        const now = new Date().getTime();
        const d = target - now;

        const daysEl = document.getElementById('days');
        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');

        if (!daysEl || !hoursEl || !minutesEl || !secondsEl) return; // safety

        if (d <= 0) {
            daysEl.textContent = 0;
            hoursEl.textContent = 0;
            minutesEl.textContent = 0;
            secondsEl.textContent = 0;
            return;
        }

        daysEl.textContent = Math.floor(d / 86400000);
        hoursEl.textContent = Math.floor((d % 86400000) / 3600000);
        minutesEl.textContent = Math.floor((d % 3600000) / 60000);
        secondsEl.textContent = Math.floor((d % 60000) / 1000);
    }

    setInterval(countdown, 1000);
    countdown();

    // =====================
    // SCROLL ANIMATION
    // =====================
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) e.target.classList.add('show');
        });
    }, {
        threshold: 0.15
    });

    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
});
</script>

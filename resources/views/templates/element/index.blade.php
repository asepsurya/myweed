<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} | Wedding Invitation</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding Invitation">
    <meta property="og:description" content="You are invited to the wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}. Click to see the details.">
    <meta property="og:image" content="{{ asset('storage/' . $invitation->gallery_cover) }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding Invitation">
    <meta property="twitter:description" content="You are invited to the wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}. Click to see the details.">
    <meta property="twitter:image" content="{{ asset('storage/' . $invitation->gallery_cover) }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Great+Vibes&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        :root {
            --primary-color: {{ $invitation->primary_color ?? '#8E7F7F' }}; /* Warm Grey */
            --secondary-color: #D4AF37; /* Gold */
            --bg-color: #FFFCF5; /* Soft Cream */
            --text-dark: #4a4a4a;
            --text-light: #777;
            --card-shadow: 0 10px 30px rgba(0,0,0,0.05);
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #e5e5e5;
            background-image: radial-gradient(#d4af37 0.5px, transparent 0.5px), radial-gradient(#d4af37 0.5px, #e5e5e5 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .mobile-container {
            width: 100%;
            max-width: 420px;
            background-color: var(--bg-color);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 60px rgba(0,0,0,0.15);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            border-left: 1px solid rgba(212, 175, 55, 0.3);
            border-right: 1px solid rgba(212, 175, 55, 0.3);
        }

        h1, h2, h3 { font-family: 'Cinzel', serif; color: var(--primary-color); }
        .script-font { font-family: 'Great Vibes', cursive; color: var(--secondary-color); font-weight: 400; }

        .text-center { text-align: center; }
        .section-padding { padding: 60px 25px; position: relative; }
        .mb-3 { margin-bottom: 40px; }

        .corner-ornament { position: absolute; width: 100px; height: 100px; pointer-events: none; z-index: 10; opacity: 0.8; }
        .top-left { top: 10px; left: 10px; }
        .top-right { top: 10px; right: 10px; transform: scaleX(-1); }
        .bottom-left { bottom: 10px; left: 10px; transform: scaleY(-1); }
        .bottom-right { bottom: 10px; right: 10px; transform: scale(-1, -1); }

        .divider { display: flex; align-items: center; justify-content: center; margin: 20px 0; color: var(--secondary-color); }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid var(--secondary-color); margin: 0 10px; opacity: 0.5; }

        .section-title { position: relative; display: inline-block; padding-bottom: 15px; margin-bottom: 20px; font-size: 1.8rem; color: var(--primary-color); }
        .section-title::after { content: '❧'; position: absolute; bottom: -5px; left: 50%; transform: translateX(-50%); font-size: 1.5rem; color: var(--secondary-color); }

        .fade-in { opacity: 0; transform: translateY(30px); transition: all 1s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        .hero {
            height: 100vh;
            background: linear-gradient(rgba(62, 58, 57, 0.7), rgba(62, 58, 57, 0.6)), url('{{ asset('storage/' . $invitation->gallery_cover) }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero-ornament { width: 200px; height: auto; fill: var(--secondary-color); margin-bottom: 10px; opacity: 0.8; }
        .hero h1 { font-size: 2.8rem; margin: 10px 0; color: white; line-height: 1.2; text-shadow: 0 2px 4px rgba(0,0,0,0.3); }
        .hero .date { font-size: 1.2rem; letter-spacing: 3px; border: 1px solid rgba(255,255,255,0.5); padding: 10px 25px; margin-top: 25px; display: inline-block; border-radius: 50px; background: rgba(0,0,0,0.2); }

        .scroll-down { position: absolute; bottom: 30px; animation: bounce 2s infinite; cursor: pointer; color: var(--secondary-color); font-size: 1.8rem; }

        .quote-section { background-color: white; text-align: center; font-style: italic; color: var(--text-light); border-bottom: 1px solid #eee; }

        .couple-wrapper { display: flex; flex-direction: column; gap: 40px; }
        .couple-card { text-align: center; }
        .couple-img { width: 160px; height: 160px; border-radius: 50%; object-fit: cover; border: 3px solid var(--secondary-color); padding: 6px; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .couple-name { font-size: 2rem; font-family: 'Great Vibes', cursive; color: var(--primary-color); margin-bottom: 5px; }
        .parent-name { font-size: 0.9rem; color: var(--text-light); font-weight: 300; }
        .connector { font-family: 'Great Vibes', cursive; font-size: 3.5rem; color: var(--secondary-color); margin-top: -10px; }

        .event-card { background: white; padding: 35px 25px; border-radius: 15px; box-shadow: var(--card-shadow); margin-bottom: 25px; text-align: center; border: 1px solid rgba(212, 175, 55, 0.2); position: relative; overflow: hidden; }
        .event-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px; background: var(--secondary-color); }
        .event-title { font-size: 1.4rem; color: var(--primary-color); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        .event-time { font-weight: 700; color: var(--secondary-color); margin-bottom: 15px; display: block; font-size: 1.1rem; }

        .btn-map { display: inline-block; margin-top: 15px; padding: 10px 30px; background-color: white; border: 1px solid var(--primary-color); color: var(--primary-color); text-decoration: none; font-size: 0.9rem; border-radius: 50px; transition: all 0.3s; }
        .btn-map:hover { background-color: var(--primary-color); color: white; transform: translateY(-2px); }

        .countdown-section { background-color: var(--primary-color); color: white; text-align: center; position: relative; }
        .countdown-timer { display: flex; justify-content: center; gap: 15px; margin-top: 25px; }
        .timer-box { background: rgba(255,255,255,0.1); padding: 15px 10px; border-radius: 8px; min-width: 65px; backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.2); }
        .timer-val { font-size: 1.6rem; font-weight: 700; display: block; }
        .timer-label { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; }

        .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .gallery-item { width: 100%; height: 220px; object-fit: cover; border-radius: 8px; border: 5px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); transition: transform 0.3s; }

        .rsvp-form { background: white; padding: 30px; border-radius: 15px; box-shadow: var(--card-shadow); border: 1px solid #eee; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Lato', sans-serif; background: #fafafa; margin-bottom: 15px; }
        .btn-submit { width: 100%; padding: 12px; background-color: var(--primary-color); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 700; transition: background 0.3s; }

        footer { background-color: var(--primary-color); color: white; padding: 50px 20px; text-align: center; }
        footer .logo-svg { width: 50px; fill: var(--secondary-color); margin-bottom: 15px; }

        .music-control { position: fixed; bottom: 25px; left: 25px; width: 50px; height: 50px; background: var(--white); border: 1px solid var(--secondary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 100; box-shadow: 0 4px 10px rgba(0,0,0,0.1); color: var(--secondary-color); }

        @keyframes bounce { 0%, 20%, 50%, 80%, 100% {transform: translateY(0);} 40% {transform: translateY(-10px);} 60% {transform: translateY(-5px);} }
        #toast { visibility: hidden; min-width: 250px; background-color: #333; color: #fff; text-align: center; border-radius: 4px; padding: 16px; position: fixed; z-index: 99; left: 50%; bottom: 30px; transform: translateX(-50%); font-size: 14px; }
        #toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 2.5s; }
        @keyframes fadein { from {bottom: 0; opacity: 0;} to {bottom: 30px; opacity: 1;} }
        @keyframes fadeout { from {bottom: 30px; opacity: 1;} to {bottom: 0; opacity: 0;} }
        /* --- Desktop Layout (Split Screen) --- */
        @media (min-width: 1024px) {
            body { background: #e5e5e5; height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; }
            .mobile-container { max-width: 1000px !important; flex-direction: row !important; display: flex !important; height: 90vh; border-radius: 20px; overflow: hidden; border: 1px solid rgba(212, 175, 55, 0.3); }
            .hero { flex: 1.2; height: 100% !important; background-attachment: scroll; }
            .content-wrapper { flex: 1; height: 100%; overflow-y: auto; background: var(--bg-color); scrollbar-width: thin; scrollbar-color: var(--primary-color) transparent; }
            .content-wrapper::-webkit-scrollbar { width: 5px; }
            .content-wrapper::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 10px; }
            .section-padding { padding: 60px 40px; }
            .hero h1 { font-size: 4rem; }
        }
    </style>
</head>
<body>

    <!-- Music Control -->
    <div id="musicBtn" class="music-control">
        <i class="ti ti-player-play" id="musicIcon"></i>
    </div>

    <div class="mobile-container">
        <!-- Corner Ornaments -->
        <svg class="corner-ornament top-left" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="2">
            <path d="M50 50 Q 20 20, 5 5 T 50 20 Q 80 20, 95 5 T 50 50" />
            <circle cx="10" cy="10" r="3" fill="#D4AF37" />
        </svg>
        <svg class="corner-ornament top-right" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="2">
            <path d="M50 50 Q 20 20, 5 5 T 50 20 Q 80 20, 95 5 T 50 50" />
            <circle cx="10" cy="10" r="3" fill="#D4AF37" />
        </svg>

        <!-- Hero Section -->
        <header id="preview-hero-bg" class="hero">
            <p class="script-font fade-in" style="font-size: 1.6rem;">The Wedding of</p>
            <h1 class="fade-in">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>
            <div class="date fade-in">{{ \Carbon\Carbon::parse($invitation->wedding_date)->translatedFormat('d . m . Y') }}</div>
            <div class="fade-in mt-3" style="font-size: 0.9rem;">
                Kepada Yth. Bapak/Ibu/Saudara/i<br>
                <span style="font-weight: 700; font-size: 1.1rem; color: var(--primary-color);">{{ request('to') ?? 'Tamu Undangan' }}</span>
            </div>
            <div class="scroll-down" onclick="document.getElementById('intro').scrollIntoView({behavior: 'smooth'})">
                <i class="ti ti-chevron-down"></i>
            </div>
        </header>

        <div class="content-wrapper">
            <!-- Intro -->
        <section id="intro" class="section-padding quote-section">
            <div class="fade-in">
                <p class="mb-2">{!! nl2br(e($invitation->wedding_quote)) !!}</p>
                <div class="divider"><span class="divider-icon">❧</span></div>
                <p style="font-weight: 600; color: var(--primary-color); font-size: 0.9rem;">{{ $invitation->quote_id ?? '' }}</p>
            </div>
        </section>

        <!-- Mempelai -->
        <section class="section-padding">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Mempelai</h2>
            </div>
            <div class="couple-wrapper fade-in">
                <div class="couple-card">
                    <img id="preview-foto-pria" src="{{ asset('storage/' . $invitation->foto_pria) }}" alt="{{ $invitation->groom_name }}" class="couple-img">
                    <h3 class="couple-name">{{ $invitation->groom_name }}</h3>
                    <p class="parent-name">Putra dari Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}</p>
                </div>
                <div class="text-center connector">&</div>
                <div class="couple-card">
                    <img id="preview-foto-wanita" src="{{ asset('storage/' . $invitation->foto_wanita) }}" alt="{{ $invitation->bride_name }}" class="couple-img">
                    <h3 class="couple-name">{{ $invitation->bride_name }}</h3>
                    <p class="parent-name">Putri dari Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}</p>
                </div>
            </div>
        </section>

        <!-- Acara -->
        <section class="section-padding event-section">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Rangkaian Acara</h2>
            </div>
            <div class="event-card fade-in">
                <div class="script-font" style="font-size: 1.3rem; margin-bottom: 5px;">Akad Nikah</div>
                <div class="event-title">{{ $invitation->akad_time }} - {{ $invitation->akad_time_end }}</div>
                <p class="parent-name">{{ $invitation->akad_location }}<br>{{ $invitation->akad_address }}</p>
                <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-map">Lihat Lokasi</a>
            </div>
            <div class="event-card fade-in">
                <div class="script-font" style="font-size: 1.3rem; margin-bottom: 5px;">Resepsi</div>
                <div class="event-title">{{ $invitation->resepsi_time }} - {{ $invitation->resepsi_time_end }}</div>
                <p class="parent-name">{{ $invitation->resepsi_location }}<br>{{ $invitation->resepsi_address }}</p>
                <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-map">Lihat Lokasi</a>
            </div>
        </section>

        <!-- Countdown -->
        <section class="section-padding countdown-section">
            <div class="fade-in">
                <h3 style="font-family: 'Cinzel', serif; color:white;">Menuju Hari Bahagia</h3>
                <div class="countdown-timer" id="timer">
                    <div class="timer-box"><span class="timer-val" id="days">00</span><span class="timer-label">Hari</span></div>
                    <div class="timer-box"><span class="timer-val" id="hours">00</span><span class="timer-label">Jam</span></div>
                    <div class="timer-box"><span class="timer-val" id="minutes">00</span><span class="timer-label">Menit</span></div>
                    <div class="timer-box"><span class="timer-val" id="seconds">00</span><span class="timer-label">Detik</span></div>
                </div>
            </div>
        </section>

        <!-- Gallery -->
        <section class="section-padding">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Galeri Foto</h2>
            </div>
            <div class="gallery-grid fade-in" id="gallery-container">
                @foreach($invitation->galleries as $photo)
                <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery">
                    <img src="{{ asset('storage/' . $photo->image) }}" class="gallery-item" alt="Gallery Photo">
                </a>
                @endforeach
            </div>
        </section>

        <!-- Gift -->
        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Wedding Gift</h2>
            </div>
            <div class="space-y-4">
                @foreach($invitation->gifts as $gift)
                <div class="event-card fade-in" style="padding: 25px;">
                    <h4 style="font-family: 'Cinzel', serif; color: var(--primary-color);">{{ $gift->bank }}</h4>
                    <p class="text-xl font-bold my-2">{{ $gift->number }}</p>
                    <p class="text-sm">A/N: {{ $gift->name }}</p>
                    <button onclick="copyToClipboard('{{ $gift->number }}')" class="btn-map" style="margin-top: 10px; padding: 5px 20px;">Salin</button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- RSVP -->
        @if($invitation->enable_rsvp == 1)
        <section class="section-padding" style="background-color: #fafafa;">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Ucapan & Doa</h2>
            </div>
            <div class="rsvp-form fade-in">
                <form id="rsvpForm">
                    @csrf
                    <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                    <select name="attending" class="form-control">
                        <option value="1">Hadir</option>
                        <option value="0">Tidak Hadir</option>
                    </select>

                    <div class="emoji-picker" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: center;">
                        <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🎉</button>
                        <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">❤️</button>
                        <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🥳</button>
                        <button type="button" onclick="addEmoji('✨')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">✨</button>
                        <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🙏</button>
                    </div>

                    <textarea name="message" class="form-control" rows="4" placeholder="Tuliskan ucapan selamat..." required></textarea>
                    <button type="submit" id="rsvpButton" class="btn-submit">Kirim Ucapan</button>
                </form>
            </div>
            <div class="mt-5 fade-in">
                <div id="rsvpList" style="max-height: 400px; overflow-y: auto;"></div>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer>
            <h2 class="script-font mb-2" style="font-size: 2rem;">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
            <p style="font-size: 0.8rem;">Terima kasih atas doa dan restu Anda</p>
            <br>
            <small style="opacity: 0.6;">&copy; {{ date('Y') }} Wedding Invitation</small>
        </footer>
        </div>
        <div id="toast">Terima kasih! Pesan Anda telah terkirim.</div>
    </div>

    <!-- Audio Element -->
    <audio id="bgMusic" loop>
        <source src="{{ $invitation->musicPreset ? asset('storage/'.$invitation->musicPreset->audio_url) : 'https://www.bensound.com/bensound-music/bensound-romantic.mp3' }}" type="audio/mpeg">
    </audio>

    <script>
        // Countdown
        const weddingDate = new Date("{{ $invitation->wedding_date }}").getTime();
        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (distance < 0) { clearInterval(timerInterval); document.getElementById("timer").innerHTML = "<h3>Acara Dimulai</h3>"; return; }
            document.getElementById("days").innerText = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById("hours").innerText = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById("minutes").innerText = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById("seconds").innerText = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }, 1000);

        // Scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Music
        const bgMusic = document.getElementById('bgMusic'), musicBtn = document.getElementById('musicBtn'), musicIcon = document.getElementById('musicIcon');
        let hasInteracted = false;

        window.copyToClipboard = (text) => {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('toast');
                toast.textContent = "Berhasil disalin!";
                toast.className = 'show';
                setTimeout(() => toast.className = '', 3000);
            });
        };

        function playMusic() { bgMusic.play().catch(() => {}); musicIcon.classList.replace('ti-player-play', 'ti-player-pause'); }
        function pauseMusic() { bgMusic.pause(); musicIcon.classList.replace('ti-player-pause', 'ti-player-play'); }
        window.addEventListener('scroll', () => { if (!hasInteracted) { playMusic(); hasInteracted = true; } }, { once: true });
        musicBtn.onclick = () => { if (bgMusic.paused) playMusic(); else pauseMusic(); };

        // RSVP
        const invId = "{{ $invitation->id }}";
        function loadRSVPs() {
            fetch(`/invitation/${invId}/rsvps`).then(r => r.json()).then(data => {
                document.getElementById('rsvpList').innerHTML = data.map(r => `
                    <div style="background: white; padding: 15px; border-radius: 10px; border-left: 5px solid var(--primary-color); margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                        <div style="font-weight: bold; color: var(--primary-color);">${r.name} <span style="font-size: 0.7rem; background: #eee; padding: 2px 8px; border-radius: 5px; float: right;">${r.attending ? 'Hadir' : 'Absen'}</span></div>
                        <p style="font-size: 0.85rem; margin-top: 5px; color: #666;">${r.message}</p>
                    </div>
                `).join('');
            });
        }
        document.getElementById('rsvpForm').onsubmit = (e) => {
            e.preventDefault();
            const btn = document.getElementById('rsvpButton'); btn.disabled = true; btn.innerText = "Mengirim...";
            fetch(`/invitation/${invId}/rsvp`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
            }).then(() => { e.target.reset(); loadRSVPs(); const toast = document.getElementById('toast'); toast.className = 'show'; setTimeout(() => toast.className = '', 3000); }).finally(() => { btn.disabled = false; btn.innerText = "Kirim Ucapan"; });
        };
        loadRSVPs();

        // Live Preview Sync
        window.addEventListener('message', function(event) {
            if (event.data.type === 'syncImages') {
                const imgs = event.data.images;
                if (imgs.pria) {
                    const el = document.getElementById('preview-foto-pria');
                    if(el) el.src = imgs.pria;
                }
                if (imgs.wanita) {
                    const el = document.getElementById('preview-foto-wanita');
                    if(el) el.src = imgs.wanita;
                }
                if (imgs.cover) {
                    const el = document.getElementById('preview-hero-bg');
                    if(el) el.style.backgroundImage = `linear-gradient(rgba(62, 58, 57, 0.7), rgba(62, 58, 57, 0.6)), url('${imgs.cover}')`;
                }
                if (imgs.gallery && imgs.gallery.length > 0) {
                    const galleryContainer = document.getElementById('gallery-container');
                    if (galleryContainer) {
                        galleryContainer.innerHTML = imgs.gallery.map(src => `
                            <a href="${src}" data-fancybox="gallery">
                                <img src="${src}" class="gallery-item" alt="Gallery Photo">
                            </a>
                        `).join('');
                    }
                }
            }
        });

        function addEmoji(emoji) {
            const textarea = document.querySelector('textarea[name="message"]');
            textarea.value += emoji;
            textarea.focus();
        }
    </script>
</body>
</html>

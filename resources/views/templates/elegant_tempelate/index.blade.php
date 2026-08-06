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

    <!-- Google Fonts: Playfair Display (Elegant Serif) & Lato (Clean Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        :root {
            /* Elegant Palette */
            --primary-color: {{ $invitation->primary_color ?? '#1A3C34' }}; /* Deep Emerald Green */
            --secondary-color: #C5A059; /* Muted Champagne Gold */
            --text-dark: #2C2C2C;
            --text-muted: #666666;
            --bg-color: #FAF9F6; /* Off-White / Eggshell */
            --white: #FFFFFF;
            --border-color: rgba(26, 60, 52, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Lato', sans-serif; 
            background-color: #e6e6e6; 
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

        /* --- Container Mobile --- */
        .mobile-container {
            width: 100%; max-width: 414px; background-color: var(--bg-color); min-height: 100vh;
            position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.1); overflow-x: hidden;
            display: flex; flex-direction: column; border-left: 8px solid white; border-right: 8px solid white;
        }

        /* Typography Classes */
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; color: var(--primary-color); font-weight: 600; }
        .text-center { text-align: center; }
        .hairline { width: 50px; height: 1px; background-color: var(--secondary-color); margin: 15px auto; }
        .section-padding { padding: 80px 30px; position: relative; }
        .mb-4 { margin-bottom: 40px; }

        /* --- Hero Section --- */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)), url('{{ asset('storage/' . $invitation->gallery_cover) }}');
            background-size: cover; background-position: center; background-attachment: fixed;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: var(--white); text-align: center; position: relative;
        }

        .hero-subtitle { font-size: 0.9rem; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 20px; opacity: 0.9; }
        .hero h1 { font-size: 3.2rem; color: var(--white); margin-bottom: 5px; letter-spacing: -0.5px; line-height: 1.1; }
        .hero-date { font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.4rem; margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.5); border-bottom: 1px solid rgba(255,255,255,0.5); padding: 10px 30px; display: inline-block; }

        /* --- Quote Section --- */
        .quote-section { background-color: var(--white); text-align: center; color: var(--text-muted); font-style: italic; font-size: 0.95rem; line-height: 1.8; border-bottom: 1px solid var(--border-color); }

        /* --- Couple Section --- */
        .couple-section { background-color: var(--bg-color); }
        .couple-wrapper { display: flex; flex-direction: column; gap: 50px; }
        .couple-card { text-align: center; }
        .img-frame { position: relative; display: inline-block; margin-bottom: 20px; padding: 10px; border: 1px solid var(--secondary-color); }
        .couple-img { width: 180px; height: 220px; object-fit: cover; }
        .couple-name { font-size: 2rem; margin-bottom: 5px; color: var(--primary-color); }
        .parent-name { font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; }
        .ampersand { font-family: 'Playfair Display', serif; font-size: 3rem; color: var(--secondary-color); font-style: italic; margin-top: -30px; margin-bottom: 20px; }

        /* --- Event Section --- */
        .event-card { margin-bottom: 30px; padding: 40px 20px; border: 1px solid var(--border-color); text-align: center; position: relative; transition: all 0.3s ease; }
        .event-card:hover { border-color: var(--secondary-color); transform: translateY(-5px); }
        .event-title { font-size: 1.2rem; text-transform: uppercase; letter-spacing: 3px; color: var(--primary-color); margin-bottom: 15px; }
        .event-time { font-size: 1.8rem; color: var(--secondary-color); font-family: 'Playfair Display', serif; font-weight: 400; }
        .btn-outline { display: inline-block; margin-top: 25px; padding: 12px 35px; border: 1px solid var(--primary-color); color: var(--primary-color); text-decoration: none; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 2px; transition: all 0.3s; cursor: pointer; background: transparent; }
        .btn-outline:hover { background-color: var(--primary-color); color: var(--white); }

        /* --- Countdown --- */
        .countdown-section { background-color: var(--primary-color); color: var(--white); text-align: center; border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.1); }
        .countdown-timer { display: flex; justify-content: center; gap: 30px; margin-top: 40px; }
        .timer-val { font-family: 'Playfair Display', serif; font-size: 2.5rem; line-height: 1; margin-bottom: 5px; }
        .timer-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7; }

        /* --- Gallery --- */
        .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
        .gallery-item { width: 100%; height: 250px; object-fit: cover; transition: all 0.5s; border-radius: 2px; }

        /* --- RSVP Form --- */
        .rsvp-form { background: var(--white); padding: 40px 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 25px; text-align: left; }
        .form-control { width: 100%; border: none; border-bottom: 1px solid #ddd; padding: 10px 0; font-family: 'Playfair Display', serif; font-size: 1.1rem; background: transparent; color: var(--text-dark); transition: border-color 0.3s; }
        .form-control:focus { outline: none; border-bottom: 1px solid var(--secondary-color); }

        /* --- Footer --- */
        footer { background-color: var(--primary-color); color: var(--white); padding: 60px 20px; text-align: center; }
        footer p { font-size: 0.9rem; opacity: 0.8; letter-spacing: 1px; }

        /* --- Animations --- */
        .fade-in { opacity: 0; transform: translateY(40px); transition: opacity 1.2s ease-out, transform 1.2s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        #toast { visibility: hidden; min-width: 200px; background-color: var(--primary-color); color: #fff; text-align: center; padding: 15px 30px; position: fixed; z-index: 99; left: 50%; bottom: 40px; transform: translateX(-50%); font-family: 'Playfair Display', serif; letter-spacing: 1px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        #toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 2.5s; }
        @keyframes fadein { from {bottom: 0; opacity: 0;} to {bottom: 40px; opacity: 1;} }
        @keyframes fadeout { from {bottom: 40px; opacity: 1;} to {bottom: 0; opacity: 0;} }
        /* --- Desktop Layout (Split Screen) --- */
        @media (min-width: 1024px) {
            body { background: #e6e6e6; height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; }
            .mobile-container { max-width: 1000px !important; flex-direction: row !important; display: flex !important; height: 90vh; border-radius: 20px; overflow: hidden; border: 8px solid white; box-shadow: 0 20px 50px rgba(0,0,0,0.1); }
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
    <div class="mobile-container">
        <!-- Hero Section -->
        <header id="preview-hero-bg" class="hero">
            <div class="fade-in">
                <div class="hero-subtitle">The Wedding Of</div>
                <h1>{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>
                <div class="hero-date">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('d F Y') }}</div>
                <div class="mt-4 text-sm" style="opacity: 0.8;">
                    Kepada Yth. Bapak/Ibu/Saudara/i<br>
                    <span style="font-weight: 700; font-size: 1.1rem; margin-top: 5px; display: inline-block;">{{ request('to') ?? 'Tamu Undangan' }}</span>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            <!-- Quote Section -->
        <section id="quote" class="section-padding quote-section">
            <div class="fade-in">
                <p class="serif-font" style="font-size: 1.2rem; color: var(--primary-color); margin-bottom: 20px;">Quote</p>
                <p>"{{ $invitation->wedding_quote ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu...' }}"</p>
                <div class="hairline" style="margin-top:30px;"></div>
            </div>
        </section>

        <!-- Couple Section -->
        <section class="section-padding couple-section">
            <div class="text-center mb-4 fade-in">
                <h2 class="serif-font" style="font-size: 2.5rem;">Mempelai</h2>
            </div>
            <div class="couple-wrapper fade-in">
                <div class="couple-card">
                    <div class="img-frame"><img id="preview-foto-pria" src="{{ asset('storage/' . $invitation->foto_pria) }}" alt="Groom" class="couple-img"></div>
                    <h3 class="couple-name">{{ $invitation->groom_name }}</h3>
                    <p class="parent-name">Putra dari Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}</p>
                </div>
                <div class="text-center ampersand">&</div>
                <div class="couple-card">
                    <div class="img-frame"><img id="preview-foto-wanita" src="{{ asset('storage/' . $invitation->foto_wanita) }}" alt="Bride" class="couple-img"></div>
                    <h3 class="couple-name">{{ $invitation->bride_name }}</h3>
                    <p class="parent-name">Putri dari Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}</p>
                </div>
            </div>
        </section>

        <!-- Event Section -->
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <h2 class="serif-font" style="font-size: 2.5rem;">Waktu & Tempat</h2>
                <div class="hairline"></div>
            </div>
            <div class="fade-in">
                <div class="event-card">
                    <div class="event-title">Akad Nikah</div>
                    <div class="event-time">{{ $invitation->akad_time }} — {{ $invitation->akad_time_end }} WIB</div>
                    <p style="color: var(--text-muted); margin-top: 10px;">{{ $invitation->akad_location }}<br>{{ $invitation->akad_address }}</p>
                    <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                </div>
                <div class="event-card">
                    <div class="event-title">Resepsi</div>
                    <div class="event-time">{{ $invitation->resepsi_time }} — {{ $invitation->resepsi_time_end }} WIB</div>
                    <p style="color: var(--text-muted); margin-top: 10px;">{{ $invitation->resepsi_location }}<br>{{ $invitation->resepsi_address }}</p>
                    <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="section-padding countdown-section">
            <div class="fade-in">
                <h2 class="serif-font" style="color: var(--white);">Menuju Bahagia</h2>
                <div class="countdown-timer" id="timer">
                    <div class="timer-item"><span class="timer-val" id="days">00</span><span class="timer-label">Hari</span></div>
                    <div class="timer-item"><span class="timer-val" id="hours">00</span><span class="timer-label">Jam</span></div>
                    <div class="timer-item"><span class="timer-val" id="minutes">00</span><span class="timer-label">Menit</span></div>
                    <div class="timer-item"><span class="timer-val" id="seconds">00</span><span class="timer-label">Detik</span></div>
                </div>
            </div>
        </section>

        <!-- Gallery -->
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <h2 class="serif-font" style="font-size: 2.5rem;">Galeri</h2>
            </div>
            <div class="gallery-grid fade-in masonry-gallery" id="gallery-container">
                 @forelse ($invitation->galleries as $photo)
                    <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery" class="masonry-item">
                        <img src="{{ asset('storage/' . $photo->image) }}" class="gallery-item" alt="Gallery">
                    </a>
                 @empty
                    <p class="text-center w-full" style="grid-column: span 2; padding: 20px;">Belum ada foto galeri</p>
                 @endforelse
            </div>
        </section>

        <!-- Gift -->
        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <h2 class="serif-font" style="font-size: 2.5rem;">Wedding Gift</h2>
                <div class="hairline"></div>
            </div>
            <div class="space-y-4">
                @foreach($invitation->gifts as $gift)
                <div class="event-card fade-in" style="padding: 30px;">
                    <h4 class="serif-font" style="color: var(--primary-color);">{{ $gift->bank }}</h4>
                    <p class="event-time" style="margin: 10px 0;">{{ $gift->number }}</p>
                    <p class="parent-name">A/N: {{ $gift->name }}</p>
                    <button onclick="copyToClipboard('{{ $gift->number }}')" class="btn-outline" style="margin-top: 15px; padding: 10px 30px;">Salin</button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- RSVP Form -->
        @if($invitation->enable_rsvp == 1)
        <section class="section-padding" style="background-color: #f7f7f7;">
            <div class="text-center mb-4 fade-in">
                <h2 class="serif-font" style="font-size: 2.5rem;">Ucapan</h2>
            </div>
            <div class="rsvp-form fade-in">
                <form id="rsvpForm">
                    @csrf
                    <div class="form-group"><input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required></div>
                    <div class="form-group"><select name="attending" class="form-control"><option value="1">Hadir</option><option value="0">Tidak Hadir</option></select></div>
                    
                    <div class="emoji-picker" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: center;">
                        <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🎉</button>
                        <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">❤️</button>
                        <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🥳</button>
                        <button type="button" onclick="addEmoji('✨')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">✨</button>
                        <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🙏</button>
                    </div>

                    <div class="form-group"><textarea name="message" class="form-control" rows="3" placeholder="Tulis doa manis..." required></textarea></div>
                    <div class="text-center"><button type="submit" id="rsvpButton" class="btn-outline" style="padding: 15px 50px;">Kirim</button></div>
                </form>
            </div>
            <div class="mt-4" style="padding: 15px;">
                <h4 class="text-center serif-font text-lg mb-4">Doa dari Teman 💌</h4>
                <div id="rsvpList" class="max-h-64 overflow-auto" style="max-height: 300px;"></div>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer>
            <h2 class="serif-font" style="color: var(--white); margin-bottom: 10px;">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
            <p style="margin-top: 20px; font-size: 0.8rem;">Terima kasih.</p>
            <p style="font-size: 0.7rem; opacity: 0.5;">&copy; {{ date('Y') }} Elegant Wedding</p>
        </footer>
        </div>
        <div id="toast">Terima kasih! Pesan Anda terkirim.</div>
    </div>

    <!-- Music Control -->
    <div id="musicBtn" style="position: fixed; bottom: 20px; left: 20px; z-index: 100; width: 50px; height: 50px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: white; shadow: 0 4px 10px rgba(0,0,0,0.2); font-size: 1.2rem;">
        ▶
    </div>

    <!-- Audio -->
    @if($invitation->youtube_url)
        @php
            $videoId = '';
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $invitation->youtube_url, $match)) {
                $videoId = $match[1];
            }
        @endphp
        @if($videoId)
            <div id="youtubePlayer" style="display:none">
                <iframe id="ytIframe" width="0" height="0" src="https://www.youtube.com/embed/{{ $videoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $videoId }}" frameborder="0" allow="autoplay"></iframe>
            </div>
        @endif
    @endif

    <audio id="bgMusic" loop>
        @if($invitation->music == 0 && $invitation->music)
        <source src="{{ asset('storage/'.$invitation->music) }}" type="audio/mpeg">
        @elseif($invitation->music && $invitation->musicPreset)
        <source src="{{ asset('storage/'.$invitation->musicPreset->audio_url) }}" type="audio/mpeg">
        @else
        <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg">
        @endif
    </audio>

    <script>
        // Countdown
        const weddingDateString = "{{ $invitation->wedding_date }}";
        const weddingDate = new Date(weddingDateString).getTime();
        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (isNaN(weddingDate) || distance < 0) {
                clearInterval(timerInterval);
                document.getElementById("timer").innerHTML = "<h3>The Wedding Day</h3>";
                return;
            }
            document.getElementById("days").innerText = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById("hours").innerText = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById("minutes").innerText = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById("seconds").innerText = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }, 1000);

        // Scroll Animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.15 });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // Music Logic
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');
        const ytIframe = document.getElementById('ytIframe');
        let hasInteracted = false;
        let isYoutube = {{ $invitation->youtube_url ? 'true' : 'false' }};

        window.copyToClipboard = (text) => {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById("toast");
                toast.textContent = "Berhasil disalin!";
                toast.className = "show";
                setTimeout(() => { toast.className = ""; }, 3000);
            });
        };

        function playMusic() {
            if (isYoutube && ytIframe) { ytIframe.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*'); }
            else if (bgMusic) { bgMusic.play().catch(e => console.log("Autoplay blocked")); }
            musicBtn.innerHTML = '⏸';
            musicBtn.style.background = 'var(--primary-color)';
        }

        function pauseMusic() {
            if (isYoutube && ytIframe) { ytIframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*'); }
            else if (bgMusic) { bgMusic.pause(); }
            musicBtn.innerHTML = '▶';
            musicBtn.style.background = 'var(--secondary-color)';
        }

        window.addEventListener('scroll', () => { if (!hasInteracted) { playMusic(); hasInteracted = true; } }, { once: true });
        if(musicBtn) {
            musicBtn.addEventListener('click', () => {
                if (musicBtn.innerHTML.trim() === '▶') playMusic();
                else pauseMusic();
            });
        }

        // RSVP Logic
        const invitationId = "{{ $invitation->id }}";
        const form = document.getElementById('rsvpForm');
        function loadRSVPs() {
            fetch(`/invitation/${invitationId}/rsvps`).then(res => res.json()).then(data => {
                document.getElementById('rsvpList').innerHTML = data.map(r => `
                    <div class="mb-3 p-3 rounded" style="background: rgba(0,0,0,0.03); border-left: 3px solid var(--secondary-color);">
                        <div class="fw-bold small" style="color: var(--primary-color);">${r.name} <span class="badge bg-light text-dark fw-normal" style="font-size: 10px;">${r.attending ? 'Hadir' : 'Absen'}</span></div>
                        <div class="x-small mt-1">${r.message}</div>
                    </div>
                `).join('');
            });
        }
        if(form) {
            form.onsubmit = (e) => {
                e.preventDefault();
                const btn = document.getElementById('rsvpButton');
                btn.disabled = true; btn.innerText = 'Mengirim...';
                fetch(`/invitation/${invitationId}/rsvp`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(Object.fromEntries(new FormData(form)))
                })
                .then(res => res.json())
                .then(data => {
                    const toast = document.getElementById("toast"); toast.className = "show";
                    setTimeout(() => { toast.className = ""; }, 3000);
                    form.reset(); loadRSVPs();
                })
                .finally(() => { btn.disabled = false; btn.innerText = 'Kirim'; });
            };
        }
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
                    if(el) el.style.backgroundImage = `linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)), url('${imgs.cover}')`;
                }
                if (imgs.gallery && imgs.gallery.length > 0) {
                    const galleryContainer = document.getElementById('gallery-container');
                    if (galleryContainer) {
                        galleryContainer.innerHTML = imgs.gallery.map(src => `
                            <a href="${src}" data-fancybox="gallery" class="masonry-item">
                                <img src="${src}" class="gallery-item" alt="Gallery">
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

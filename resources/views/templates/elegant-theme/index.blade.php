<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nandang & Rinjani | The Wedding</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
       <!-- Include Fancybox CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        :root {
            --primary-color: #1A3C34; /* Deep Emerald Green */
            --secondary-color: #C5A059; /* Muted Champagne Gold */
            --text-dark: #2C2C2C;
            --text-muted: #666666;
            --bg-color: #FAF9F6; /* Off-White / Eggshell */
            --white: #FFFFFF;
            --border-color: rgba(26, 60, 52, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #e6e6e6;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* --- Container Mobile --- */
        .mobile-container {
            width: 100%;
            max-width: 414px;
            background-color: var(--bg-color);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* --- Typography --- */
        h1, h2, h3, .serif-font {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            font-weight: 600;
        }

        .script-font {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            color: var(--secondary-color);
        }

        /* PERBAIKAN: Paksa warna putih untuk elemen di dalam Countdown Section */
        .countdown-section h3, .countdown-section p {
            color: var(--white) !important;
        }

        .text-center { text-align: center; }
        .hairline {
            width: 50px;
            height: 1px;
            background-color: var(--secondary-color);
            margin: 15px auto;
        }
        .section-padding { padding: 80px 30px; position: relative; }
        .mb-4 { margin-bottom: 40px; }

        /* Utility Classes */
        .grid { display: grid; }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        .gap-2 { gap: 0.5rem; }
        .text-2xl { font-size: 1.5rem; font-weight: bold; }
        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .font-bold { font-weight: bold; }
        .border-b { border-bottom: 1px solid rgba(255,255,255,0.5); }
        .border { border: 1px solid #ddd; }
        .rounded { border-radius: 0.375rem; }
        .w-full { width: 100%; }
        .mt-5 { margin-top: 1.25rem; }
        .mt-6 { margin-top: 1.5rem; }
        .max-h-64 { max-height: 16rem; }
        .overflow-y-auto { overflow-y: auto; }
        .p-4 { padding: 1rem; }
        .bg-gray-50 { background-color: #f9fafb; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .flex { display: flex; }
        .justify-start { justify-content: flex-start; }
        .items-center { align-items: center; }
        .space-x-3 > * + * { margin-left: 0.75rem; }
        .text-green-600 { color: #16a34a; }
        .text-red-500 { color: #ef4444; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-600 { color: #4b5563; }
        .bg-white { background-color: white; }
        .inline-block { display: inline-block; }
        .object-cover { object-fit: cover; }

        /* Spinner */
        .hidden { display: none !important; }
        .animate-spin { animation: spin 1s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        /* --- Masonry Gallery --- */
        .masonry-gallery {
            column-count: 2;
            column-gap: 1rem;
        }
        .masonry-item {
            width: 100%;
            margin-bottom: 1rem;
            border-radius: 0.75rem;
            display: block;
        }
        .masonry-item img {
            width: 100%;
            display: block;
            border-radius: 0.75rem;
            transition: transform 0.3s;
        }
        .masonry-item img:hover {
            transform: scale(1.02);
        }

        /* --- Hero Section --- */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)), url('{{ asset('storage/' . $invitation->gallery_cover) }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--white);
            text-align: center;
            position: relative;
        }

        .hero-subtitle {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .hero h1 {
            font-size: 3.2rem;
            color: var(--white);
            margin-bottom: 5px;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .hero-date {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.4rem;
            margin-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            padding: 10px 30px;
            display: inline-block;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: bounce 3s infinite;
            opacity: 0.7;
            cursor: pointer;
        }

        /* --- Quote Section --- */
        .quote-section {
            background-color: var(--white);
            text-align: center;
            color: var(--text-muted);
            font-style: italic;
            font-size: 0.95rem;
            line-height: 1.8;
            border-bottom: 1px solid var(--border-color);
        }

        /* --- Couple Section --- */
        .couple-section { background-color: var(--bg-color); }
        .couple-wrapper { display: flex; flex-direction: column; gap: 50px; }
        .couple-card { text-align: center; }

        .img-frame {
            position: relative;
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid var(--secondary-color);
        }
        .couple-img {
            width: 180px;
            height: 220px;
            object-fit: cover;
            filter: grayscale(20%) sepia(10%);
        }
        .couple-name { font-size: 2rem; margin-bottom: 5px; color: var(--primary-color); }
        .parent-name { font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; }
        .ampersand {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            color: var(--secondary-color);
            font-style: italic;
            margin-top: -30px;
            margin-bottom: 20px;
        }

        /* --- Event Section --- */
        .event-card {
            margin-bottom: 30px;
            padding: 40px 20px;
            border: 1px solid var(--border-color);
            text-align: center;
            position: relative;
            transition: all 0.3s ease;
        }
        .event-card:hover { border-color: var(--secondary-color); transform: translateY(-5px); }
        .event-title { font-size: 1.2rem; text-transform: uppercase; letter-spacing: 3px; color: var(--primary-color); margin-bottom: 15px; }
        .event-time { font-size: 1.8rem; color: var(--secondary-color); font-family: 'Playfair Display', serif; font-weight: 400; }

        .btn-outline {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 35px;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 2px;
            transition: all 0.3s;
        }
        .btn-outline:hover { background-color: var(--primary-color); color: var(--white); }

        /* --- Countdown --- */
        .countdown-section {
            background-color: var(--primary-color);
            color: var(--white);
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 40px;
        }
        .timer-val {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            line-height: 1;
            margin-bottom: 5px;
            color: var(--white);
        }
        .timer-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.7;
        }

        /* --- RSVP Form --- */
        .rsvp-form {
            background: var(--white);
            padding: 40px 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }
        .form-group { margin-bottom: 25px; text-align: left; }
        .form-control {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem;
            background: transparent;
            color: var(--text-dark);
            transition: border-color 0.3s;
        }
        .form-control:focus { outline: none; border-bottom: 1px solid var(--secondary-color); }
        .form-control.padded { padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: #fff; font-family: 'Lato', sans-serif; }

        /* --- Footer --- */
        footer {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 60px 20px;
            text-align: center;
        }
        footer p { font-size: 0.9rem; opacity: 0.8; letter-spacing: 1px; }

        /* --- Animations --- */
        .fade-in { opacity: 0; transform: translateY(40px); transition: opacity 1.2s ease-out, transform 1.2s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translate(-50%, 0); }
            40% { transform: translate(-50%, -10px); }
            60% { transform: translate(-50%, -5px); }
        }

        /* --- Toast Notification --- */
        #toast {
            visibility: hidden;
            min-width: 200px;
            background-color: var(--primary-color);
            color: #fff;
            text-align: center;
            padding: 15px 30px;
            position: fixed;
            z-index: 99;
            left: 50%;
            bottom: 40px;
            transform: translateX(-50%);
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }
        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @keyframes fadein { from { bottom: 0; opacity: 0; } to { bottom: 40px; opacity: 1; } }
        @keyframes fadeout { from { bottom: 40px; opacity: 1; } to { bottom: 0; opacity: 0; } }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-on-scroll { opacity: 0; transform: translateY(30px); }
        .animate-on-scroll.show { animation: fadeUp .9s ease-out forwards; }

        /* --- Music Control Button --- */
        .music-control {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 9999;
            border: 2px solid white;
            animation: rotate 4s linear infinite;
            animation-play-state: paused;
            color: white;
            font-size: 18px;
        }

        .music-control.playing {
            animation-play-state: running;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

    </style>
</head>
<body>

    <!-- Audio Control Floating Button (Outside container to float above) -->
    <div id="musicBtn" class="music-control">
        ▶
    </div>

    <!-- Container Simulasi Mobile -->
    <div class="mobile-container">

        <!-- Hero Section -->
        <header class="hero">
            <div class="fade-in">
                <div class="hero-subtitle">The Wedding Of</div>
                <h1>{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} </h1>

                <p class="text-sm">
                    Kepada Yth<br>
                    <span class="border-b px-2 py-1 inline-block mt-2">
                        Bapak / Ibu / Saudara
                    </span>
                </p>

                <p class="mt-5">{{ request('to') ?? 'Keluarga Besar' }}</p>

                <div class="hero-date">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</div>
            </div>

            <div class="scroll-indicator" onclick="document.getElementById('quote').scrollIntoView({behavior: 'smooth'})">
                <span>Scroll</span>
                <div style="width:1px; height:30px; background:rgba(255,255,255,0.5);"></div>
            </div>
        </header>

        <!-- Quote Section -->
        <section id="quote" class="section-padding quote-section">
            <div class="fade-in">
                <p class="serif-font" style="font-size: 1.2rem; color: var(--primary-color); margin-bottom: 20px;">Ar-Rum: 21</p>
                <p>{{ $invitation->wedding_quote }}</p>
                <div class="hairline" style="margin-top:30px;"></div>
            </div>
        </section>

        <!-- Couple Section -->
        <section class="section-padding couple-section">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">The Bride & Groom</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Mempelai</h2>
            </div>

            <div class="couple-wrapper fade-in">
                <!-- Groom -->
                <div class="couple-card">
                    <div class="img-frame">
                        <img src="{{ asset('storage/' . $invitation->foto_pria) }}" alt="{{ $invitation->groom_name }}" class="couple-img">
                    </div>
                    <h3 class="couple-name">{{ $invitation->groom_name }}</h3>
                    <p class="parent-name">Putra dari Bpk. Fulan & Ibu Fulana</p>
                     <a href="https://instagram.com" target="_blank" class="text-primary hover:text-primary/80">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                </div>

                <div class="text-center ampersand">&</div>

                <!-- Bride -->
                <div class="couple-card">
                    <div class="img-frame">
                        <img src="{{ asset('storage/' . $invitation->foto_wanita) }}" alt="{{ $invitation->bride_name }}" class="couple-img">
                    </div>
                    <h3 class="couple-name">{{ $invitation->bride_name }}</h3>
                    <p class="parent-name">Putri dari Bpk. Surya & Ibu Dewi</p>
                     <a href="https://instagram.com" target="_blank" class="text-primary hover:text-primary/80">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                </div>
            </div>
        </section>

        <!-- Event Section -->
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Save The Date</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Waktu & Tempat</h2>
                <div class="hairline"></div>
            </div>

            <div class="fade-in">
                <!-- Akad -->
                <div class="event-card">
                    <div class="event-title">Akad Nikah</div>
                    <div class="event-time">{{ $invitation->akad_time }}</div>
                    <p style="color: var(--text-muted); margin-top: 10px;">{{ $invitation->akad_location }}</p>
                    <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                </div>

                <!-- Resepsi -->
                <div class="event-card">
                    <div class="event-title">Wedding Reception</div>
                    <div class="event-time">{{ $invitation->resepsi_time ?? '11:00 — 14:00 WIB' }}</div>
                    <p style="color: var(--text-muted); margin-top: 10px;">{{ $invitation->resepsi_location ?? 'Grand Ballroom Hotel Savoy<br>Jl. Merdeka No. 45' }}</p>
                    <a href="{{ $invitation->resepsi_maps ?? '#' }}" class="btn-outline">Lihat Peta</a>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="section-padding countdown-section">
            <div class="fade-in">
                <p class="hero-subtitle" style="color: var(--white); opacity: 0.8;">Counting Down</p>
                <h2 class="serif-font" style="color: var(--white);">Menuju Bahagia</h2>

                <div class="countdown-grid" id="countdown">
                    <div class="text-center">
                        <p id="days" class="timer-val">0</p>
                        <p class="timer-label">Hari</p>
                    </div>
                    <div class="text-center">
                        <p id="hours" class="timer-val">0</p>
                        <p class="timer-label">Jam</p>
                    </div>
                    <div class="text-center">
                        <p id="minutes" class="timer-val">0</p>
                        <p class="timer-label">Menit</p>
                    </div>
                    <div class="text-center">
                        <p id="seconds" class="timer-val">0</p>
                        <p class="timer-label">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery (Masonry) -->
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Moments</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Galeri</h2>
            </div>
            <div class="masonry-gallery fade-in">
                 @forelse ($invitation->galleries as $photo)
                    <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery" class="masonry-item">
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="Gallery Photo">
                    </a>
                 @empty
                    <p class="text-center w-full text-muted" style="grid-column: span 2;">Belum ada foto galeri.</p>
                 @endforelse
            </div>
        </section>

        <!-- RSVP Form -->
        <section class="section-padding" style="background-color: #f7f7f7;">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">RSVP</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Ucapan</h2>
            </div>

            <div class="rsvp-form fade-in">
                <form id="rsvpForm" class="space-y-4">
                    @csrf
                    <div class="form-group">
                        <input class="form-control padded w-full" placeholder="Nama" name="name" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control padded w-full" name="attending">
                            <option value="1">Hadir</option>
                            <option value="0">Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea id="rsvpMessageInput" class="form-control padded w-full resize-none" rows="3"
                            placeholder="Doa & Ucapan" name="message" style="height:100px; max-height:300px;" required></textarea>
                    </div>

                    <div class="text-center">
                        <button id="rsvpButton" type="submit" class="btn-outline" style="background:transparent; cursor:pointer;">
                            <span id="buttonText">Kirim</span>
                            <!-- SVG Spinner -->
                            <svg id="buttonSpinner" class="w-5 h-5 text-white animate-spin hidden" style="width:20px; height:20px; vertical-align:middle; display:none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div id="rsvpMessage" class="max-w-md mx-auto mt-4 text-center text-green-600"></div>

            <div class="mt-6 p-4 bg-white rounded-lg mx-auto" style="max-width: 414px;">
                <h4 class="text-center serif-font text-lg mb-4" style="color: var(--primary-color);">Tinggalkan kami doa terbaik anda untuk momen bahagia kami</h4>

                <div id="rsvpList" class="space-y-3 max-h-64 overflow-y-auto">
                    <!-- Daftar RSVP akan di-load via JS -->
                </div>
                <div class="text-center mt-2">
                    <span class="text-sm text-gray-600">({{ $invitation->rsvps->count() }} Ucapan & Doa Restu)</span>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <h2 class="serif-font" style="color: var(--white); margin-bottom: 10px;">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
            <div class="hairline" style="background-color: var(--secondary-color); width: 30px;"></div>
            <p style="margin-top: 20px; font-size: 0.8rem;">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
            <br>
            <p style="font-size: 0.7rem; opacity: 0.5;">&copy; {{ date('Y') }} Elegant Wedding Invitation</p>
        </footer>

        <!-- Toast Notification -->
        <div id="toast">Pesan terkirim dengan terima kasih.</div>

    </div>

    <!-- Audio -->
    <audio id="bgMusic" loop>
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

    <!-- Scripts -->
    <script>
        // --- 1. Logic Auto Height Textarea ---
        const textarea = document.getElementById('rsvpMessageInput');
        if(textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 300) + 'px';
            });
        }

        // --- 2. Logic Countdown (Dinamis dari Laravel) ---
        const weddingDateString = "{{ $invitation->wedding_date }}";
        const weddingDate = new Date(weddingDateString).getTime();

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = weddingDate - now;

            // Cek jika tanggal valid
            if (isNaN(weddingDate)) {
                console.error("Format tanggal tidak valid");
                clearInterval(timerInterval);
                return;
            }

            if (distance < 0) {
                clearInterval(timerInterval);
                // PERBAIKAN: Tambahkan style="color: white" agar teks terlihat
                document.getElementById("countdown").innerHTML = `
                    <div class="text-center" style="grid-column: span 4;">
                        <h3 style="color: var(--white); font-size: 1.5rem;">Acara Telah Dimulai</h3>
                        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 5px;">Terima kasih atas doa restu Anda</p>
                    </div>`;
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = String(days).padStart(2, '0');
            document.getElementById("hours").innerText = String(hours).padStart(2, '0');
            document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
            document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
        }, 1000);

        // --- 3. Logic Audio Music ---
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');

        // Coba autoplay saat scroll (karena browser sering memblokir autoplay langsung)
        let hasInteracted = false;
        window.addEventListener('scroll', () => {
            if (!hasInteracted && bgMusic.paused) {
                bgMusic.play().then(() => {
                    musicBtn.classList.add('playing');
                    musicBtn.innerHTML = '⏸'; // Icon Pause
                    hasInteracted = true;
                }).catch(e => console.log("Autoplay dicegah browser, perlu klik tombol"));
            }
        }, { once: true });

        // Fungsi Klik Tombol Musik
        musicBtn.addEventListener('click', () => {
            if (bgMusic.paused) {
                bgMusic.play();
                musicBtn.classList.add('playing');
                musicBtn.innerHTML = '⏸'; // Icon Pause
            } else {
                bgMusic.pause();
                musicBtn.classList.remove('playing');
                musicBtn.innerHTML = '▶'; // Icon Play
            }
        });

        // --- 4. Logic RSVP (Fetch & Submit) ---
        const invitationId = "{{ $invitation->id }}";
        const form = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');

        // Render List Function
        function renderRsvpList(rsvps) {
            const list = document.getElementById('rsvpList');
            if (!rsvps || rsvps.length === 0) {
                list.innerHTML = `
                    <div class="text-center text-gray-500 text-sm py-6">
                        Belum ada ucapan 🥲<br>Jadilah yang pertama memberi doa 💖
                    </div>`;
                return;
            }

            list.innerHTML = rsvps.map(rsvp => `
                <div class="flex justify-start items-center text-sm p-3 bg-gray-50 rounded space-x-3">
                    <!-- Default Image User -->
                    <img src="{{ asset('tempelate/user_default.jpg') }}" alt="User" class="object-cover" style="width:32px; height:32px; border-radius:50%;">
                    <div>
                        <p class="font-bold" style="color:var(--primary-color)">${rsvp.name}</p>
                        <p class="text-gray-600 text-xs" style="margin-top:2px;">${rsvp.message}</p>
                    </div>
                </div>
            `).join('');
        }

        // Fetch Function
        function updateRsvpList() {
            fetch(`/invitation/${invitationId}/rsvps`)
                .then(res => {
                    if(!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => renderRsvpList(data))
                .catch(err => {
                    console.error(err);
                    document.getElementById('rsvpList').innerHTML = `
                        <div class="text-center text-red-500 text-sm py-6">Gagal memuat data RSVP 😢</div>`;
                });
        }

        // Submit Form Function
        if(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // UI Loading State
                rsvpButton.disabled = true;
                buttonText.innerText = "Mengirim...";
                buttonSpinner.style.display = "inline-block";
                buttonSpinner.classList.remove('hidden');

                const formData = new FormData(form);

                fetch("{{ route('rsvp.store', $invitation->id) }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        form.reset();
                        document.getElementById('rsvpMessage').innerText = data.message || "RSVP berhasil dikirim!";
                        document.getElementById('rsvpMessage').style.display = 'block';
                        textarea.style.height = 'auto';
                        updateRsvpList();
                    } else {
                        document.getElementById('rsvpMessage').innerText = data.message || "Terjadi kesalahan.";
                        document.getElementById('rsvpMessage').classList.add('text-red-500');
                        document.getElementById('rsvpMessage').style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error(error);
                    document.getElementById('rsvpMessage').innerText = "Terjadi kesalahan saat mengirim RSVP.";
                    document.getElementById('rsvpMessage').style.display = 'block';
                })
                .finally(() => {
                    // Reset UI
                    rsvpButton.disabled = false;
                    buttonText.innerText = "Kirim";
                    buttonSpinner.style.display = "none";
                    // Hide success message after 3 sec
                    setTimeout(() => {
                         document.getElementById('rsvpMessage').style.display = 'none';
                    }, 3000);
                });
            });
        }

        // Init & Polling
        updateRsvpList();
        setInterval(updateRsvpList, 3000);

        // --- 5. Scroll Animation ---
        const observerOptions = { threshold: 0.15 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    </script>
</body>
</html>

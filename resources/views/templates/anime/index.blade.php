<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nandang & Rinjani | Anime Wedding</title>

    <!-- Google Fonts: Fredoka (Bulat/Anime), Quicksand (Modern) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;600&family=Quicksand:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Anime Pop Palette */
            --primary-color: #FF6B81; /* Sakura Pink */
            --secondary-color: #FFA502; /* Energetic Orange */
            --accent-purple: #A29BFE; /* Soft Purple */
            --bg-color: #F3F0FF; /* Light Lavender */
            --text-dark: #2F3542; /* Dark Grey (Manga Ink) */
            --white: #FFFFFF;
            --border-thick: 3px solid var(--text-dark);
            --comic-shadow: 4px 4px 0 var(--text-dark);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Quicksand', sans-serif;
            background-color: var(--bg-color);
            /* Manga Halftone Pattern */
            background-image: radial-gradient(var(--text-dark) 15%, transparent 16%), radial-gradient(var(--text-dark) 15%, transparent 16%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* --- Container Mobile --- */
        .mobile-container {
            width: 100%;
            max-width: 414px;
            background-color: var(--white);
            min-height: 100vh;
            position: relative;
            box-shadow: 10px 10px 0 rgba(0,0,0,0.1);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            border: var(--border-thick);
            border-radius: 10px; /* Sudut tumpul */
        }

        /* --- Typography --- */
        h1, h2, h3, .anime-font {
            font-family: 'Fredoka', cursive;
            color: var(--primary-color);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .text-center { text-align: center; }
        .section-padding { padding: 60px 20px; position: relative; }

        /* --- Anime UI Elements --- */
        .card-anime {
            background: var(--white);
            border: var(--border-thick);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--comic-shadow);
            margin-bottom: 20px;
            position: relative;
            transition: transform 0.2s;
        }

        .card-anime:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0 var(--text-dark);
        }

        .btn-anime {
            display: inline-block;
            padding: 12px 30px;
            border: var(--border-thick);
            background-color: var(--secondary-color);
            color: var(--text-dark);
            text-decoration: none;
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            border-radius: 50px;
            box-shadow: var(--comic-shadow);
            transition: all 0.2s;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-anime:active {
            transform: translate(4px, 4px);
            box-shadow: 0px 0px 0 var(--text-dark);
        }

        /* --- Hero Section --- */
        .hero {
            height: 100vh;
            /* Gradient cerah ala Anime */
            background: linear-gradient(rgba(255, 107, 129, 0.8), rgba(162, 155, 254, 0.8)), url('{{ asset('storage/' . $invitation->gallery_cover) }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--white);
            text-align: center;
            position: relative;
            border-bottom: var(--border-thick);
        }

        .hero h1 {
            font-size: 3rem;
            color: var(--white);
            text-shadow: 3px 3px 0 var(--text-dark);
            margin: 10px 0;
            line-height: 1.2;
            transform: rotate(-2deg); /* Sedikit miring */
        }

        .hero-date {
            background: var(--secondary-color);
            color: var(--text-dark);
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            padding: 10px 25px;
            border: var(--border-thick);
            border-radius: 20px;
            box-shadow: 3px 3px 0 var(--text-dark);
            margin-top: 15px;
            display: inline-block;
        }

        /* --- Quote (Speech Bubble) --- */
        .quote-section {
            background-color: var(--bg-color);
            padding: 40px 20px;
            position: relative;
        }

        .speech-bubble {
            background: var(--white);
            border: var(--border-thick);
            border-radius: 20px;
            padding: 30px;
            position: relative;
            color: var(--text-dark);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Ekor gelembung komik */
        .speech-bubble::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50px;
            border-width: 20px 20px 0;
            border-style: solid;
            border-color: var(--text-dark) transparent;
            display: block;
            width: 0;
        }
        .speech-bubble::before {
            content: '';
            position: absolute;
            bottom: -13px;
            left: 53px;
            border-width: 17px 17px 0;
            border-style: solid;
            border-color: var(--white) transparent;
            display: block;
            width: 0;
            z-index: 1;
        }

        /* --- Couple Section --- */
        .couple-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border: var(--border-thick);
            border-radius: 20px;
            padding: 5px;
            background: white;
            box-shadow: var(--comic-shadow);
        }

        /* --- Countdown --- */
        .countdown-section {
            background-color: var(--accent-purple);
            color: var(--white);
            text-align: center;
            border-top: var(--border-thick);
            border-bottom: var(--border-thick);
        }

        .timer-box {
            background: var(--white);
            color: var(--text-dark);
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: var(--border-thick);
            box-shadow: 4px 4px 0 rgba(0,0,0,0.2);
            margin: 0 5px;
        }
        .timer-val { font-family: 'Fredoka'; font-size: 1.8rem; font-weight: bold; color: var(--primary-color); }
        .timer-label { font-size: 0.7rem; text-transform: uppercase; font-weight: 600; }

        /* --- Gallery --- */
        .masonry-gallery {
            column-count: 2;
            column-gap: 15px;
        }
        .masonry-item {
            break-inside: avoid;
            margin-bottom: 15px;
            border-radius: 10px;
            overflow: hidden;
            border: var(--border-thick);
            background: white;
        }
        .masonry-item img {
            width: 100%;
            display: block;
            transition: transform 0.3s;
        }
        .masonry-item:hover img { transform: scale(1.1); }

        /* --- RSVP Form --- */
        .form-control {
            width: 100%;
            border: 2px solid var(--text-dark);
            border-radius: 10px;
            padding: 12px;
            font-family: 'Quicksand', sans-serif;
            font-size: 1rem;
            background: #F9F9F9;
        }
        .form-control:focus {
            outline: none;
            background: white;
            box-shadow: 3px 3px 0 var(--primary-color);
            border-color: var(--primary-color);
        }

        /* --- Footer --- */
        footer {
            background-color: var(--primary-color);
            color: var(--white);
            text-align: center;
            padding: 40px 20px;
            border-top: var(--border-thick);
        }

        /* --- Music Control --- */
        .music-control {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 50px;
            height: 50px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            border: 3px solid var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--comic-shadow);
            z-index: 9999;
            font-size: 20px;
            animation: bounce-soft 2s infinite;
        }

        @keyframes bounce-soft {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        /* Utility Classes (Tailwind-ish) */
        .grid { display: grid; }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        .text-sm { font-size: 0.875rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .flex { display: flex; }
        .justify-center { justify-content: center; }
        .items-center { align-items: center; }
        .gap-3 { gap: 0.75rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .max-h-64 { max-height: 16rem; overflow-y: auto; }
        .rounded-full { border-radius: 50%; }
        .w-10 { width: 40px; }
        .h-10 { height: 40px; }
        .object-cover { object-fit: cover; }
        .bg-white { background: white; }
        .p-3 { padding: 0.75rem; }
        .hidden { display: none; }
        .text-center { text-align: center; }
        .mt-4 { margin-top: 1rem; }

        /* Spinner */
        .animate-spin { animation: spin 1s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        /* Animations */
        .pop-in { opacity: 0; transform: scale(0.8); transition: 0.5s all; }
        .pop-in.visible { opacity: 1; transform: scale(1); }
    </style>
</head>
<body>

    <!-- Music Control -->
    <div id="musicBtn" class="music-control">
        ▶
    </div>

    <div class="mobile-container">

        <!-- Hero Section -->
        <header class="hero">
            <div class="pop-in">
                <h2 style="color: #FFA502; text-shadow: 2px 2px 0 var(--text-dark); font-size: 1.2rem;">The Wedding Of</h2>
                <h1>{{ $invitation->groom_nickname }} <span style="font-size: 0.6em; vertical-align: middle;">&</span> {{ $invitation->bride_nickname }} </h1>

                <div class="hero-date pop-in" style="transition-delay: 0.1s;">
                    {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}
                </div>

                <div style="margin-top: 20px; background: white; color: var(--text-dark); padding: 5px 15px; border-radius: 20px; border: 2px solid var(--text-dark); font-weight: bold; font-size: 0.9rem;">
                    Kepada: {{ request('to') ?? 'Tamu Undangan' }}
                </div>
            </div>
        </header>

        <!-- Quote Section (Speech Bubble) -->
        <section class="quote-section">
            <div class="speech-bubble pop-in">
                <div style="text-align: right; font-size: 0.8rem; color: var(--primary-color); font-weight: bold; margin-bottom: 10px;">Ar-Rum: 21</div>
                <p>{{ $invitation->wedding_quote }}</p>
            </div>
        </section>

        <!-- Couple Section -->
        <section class="section-padding">
            <div class="text-center mb-4 pop-in">
                <h2 style="font-size: 2rem;">Mempelai</h2>
                <div style="width: 50px; height: 5px; background: var(--secondary-color); margin: 10px auto; border-radius: 5px;"></div>
            </div>

            <div class="space-y-3">
                <!-- Groom -->
                <div class="card-anime text-center pop-in">
                    <img src="{{ asset('storage/' . $invitation->foto_pria) }}" alt="Groom" class="couple-img">
                    <h3 style="margin-top: 15px;">{{ $invitation->groom_name }}</h3>
                    <p class="text-sm" style="color: #666;">Putra dari Bpk. Fulan & Ibu Fulana</p>
                </div>

                <!-- Bride -->
                <div class="card-anime text-center pop-in">
                    <img src="{{ asset('storage/' . $invitation->foto_wanita) }}" alt="Bride" class="couple-img">
                    <h3 style="margin-top: 15px; color: var(--primary-color);">{{ $invitation->bride_name }}</h3>
                    <p class="text-sm" style="color: #666;">Putri dari Bpk. Surya & Ibu Dewi</p>
                </div>
            </div>
        </section>

        <!-- Event Section -->
        <section class="section-padding" style="background: #FFF0F5;">
            <div class="text-center mb-4 pop-in">
                <h2 style="font-size: 2rem;">Waktu & Tempat</h2>
            </div>

            <!-- Akad -->
            <div class="card-anime pop-in">
                <h3 style="color: var(--accent-purple); font-size: 1.5rem;">Akad Nikah</h3>
                <div style="font-size: 1.8rem; font-weight: bold; color: var(--primary-color); margin: 10px 0;">{{ $invitation->akad_time }}</div>
                <p>{{ $invitation->akad_location }}</p>
                <div style="margin-top: 15px;">
                    <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-anime" style="padding: 8px 20px; font-size: 0.9rem;">Lihat Peta 🗺️</a>
                </div>
            </div>

            <!-- Resepsi -->
            <div class="card-anime pop-in">
                <h3 style="color: var(--accent-purple); font-size: 1.5rem;">Resepsi</h3>
                <div style="font-size: 1.8rem; font-weight: bold; color: var(--primary-color); margin: 10px 0;">{{ $invitation->resepsi_time ?? '11:00 — 14:00 WIB' }}</div>
                <p>{{ $invitation->resepsi_location ?? 'Grand Ballroom Hotel Savoy<br>Jl. Merdeka No. 45' }}</p>
                <div style="margin-top: 15px;">
                    <a href="{{ $invitation->resepsi_maps ?? '#' }}" class="btn-anime" style="padding: 8px 20px; font-size: 0.9rem;">Lihat Peta 🗺️</a>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="section-padding countdown-section">
            <div class="pop-in">
                <h2 style="color: white; text-shadow: 2px 2px 0 rgba(0,0,0,0.2);">Menuju Hari Bahagia!</h2>

                <div class="flex justify-center gap-3 mt-4" id="countdown">
                    <!-- JS will populate this -->
                    <div class="timer-box"><span id="days" class="timer-val">0</span><span class="timer-label">Hari</span></div>
                    <div class="timer-box"><span id="hours" class="timer-val">0</span><span class="timer-label">Jam</span></div>
                    <div class="timer-box"><span id="minutes" class="timer-val">0</span><span class="timer-label">Menit</span></div>
                    <div class="timer-box"><span id="seconds" class="timer-val">0</span><span class="timer-label">Detik</span></div>
                </div>
            </div>
        </section>

        <!-- Gallery -->
        <section class="section-padding">
            <div class="text-center mb-4 pop-in">
                <h2 style="font-size: 2rem;">Galeri Foto</h2>
            </div>
            <div class="masonry-gallery pop-in">
                 @forelse ($invitation->galleries as $photo)
                    <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery" class="masonry-item">
                        <img src="{{ asset('storage/' . $photo->image) }}" alt="Gallery">
                    </a>
                 @empty
                    <p class="text-center w-full" style="grid-column: span 2; padding: 20px;">Belum ada foto galeri 😢</p>
                 @endforelse
            </div>
        </section>

        <!-- RSVP Form -->
        <section class="section-padding" style="background: #FFF0F5;">
            <div class="text-center mb-4 pop-in">
                <h2 style="font-size: 2rem;">Ucapan & Doa</h2>
            </div>

            <div class="card-anime pop-in">
                <form id="rsvpForm" class="space-y-3">
                    @csrf
                    <div>
                        <input class="form-control" placeholder="Nama Kamu 👤" name="name" required>
                    </div>
                    <div>
                        <select class="form-control" name="attending">
                            <option value="1">Saya Hadir! ✅</option>
                            <option value="0">Maaf, Tidak Bisa 😔</option>
                        </select>
                    </div>
                    <div>
                        <textarea id="rsvpMessageInput" class="form-control resize-none" rows="3"
                            placeholder="Tulis doa manis... ✨" name="message" style="height:100px; max-height:300px;" required></textarea>
                    </div>

                    <button id="rsvpButton" type="submit" class="btn-anime w-full" style="width: 100%;">
                        <span id="buttonText">Kirim Ucapan 🚀</span>
                        <svg id="buttonSpinner" class="w-5 h-5 text-white animate-spin hidden" style="width:20px; height:20px; vertical-align:middle;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <div id="rsvpMessage" class="text-center mt-4 text-white" style="background: var(--primary-color); border: var(--border-thick); border-radius: 10px; padding: 10px; max-width: 300px; margin: 20px auto; display: none; box-shadow: var(--comic-shadow);"></div>

            <div class="card-anime mt-4" style="padding: 15px;">
                <h4 class="text-center anime-font text-lg mb-4">Doa dari Teman 💌</h4>
                <div id="rsvpList" class="max-h-64">
                    <!-- List loaded via JS -->
                </div>
                <center class="mt-4"> <span class="text-sm">({{ $invitation->rsvps->count() }} Pesan)</span> </center>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <h2 class="anime-font" style="color: var(--white); font-size: 2rem; margin-bottom: 10px;">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
            <p style="font-size: 0.9rem; opacity: 0.9;">Terima kasih sudah mampir! 🎉</p>
            <p style="font-size: 0.7rem; opacity: 0.7; margin-top: 20px;">&copy; {{ date('Y') }} Anime Wedding Invitation</p>
        </footer>

    </div>

    <!-- Audio -->
    <audio id="bgMusic" loop>
        @if($invitation->music == 0 && $invitation->music)
        <source src="{{ asset('storage/'.$invitation->music) }}" type="audio/mpeg">
        @elseif($invitation->music && $invitation->musicPreset)
        <source src="{{ asset('storage/'.$invitation->musicPreset->audio_url) }}" type="audio/mpeg">
        @else
        <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg">
        @endif
    </audio>

    <!-- Scripts -->
    <script>
        // --- 1. Auto Height Textarea ---
        const textarea = document.getElementById('rsvpMessageInput');
        if(textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 300) + 'px';
            });
        }

        // --- 2. Countdown Logic ---
        const weddingDateString = "{{ $invitation->wedding_date }}";
        const weddingDate = new Date(weddingDateString).getTime();

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = weddingDate - now;

            if (isNaN(weddingDate)) {
                clearInterval(timerInterval);
                return;
            }

            if (distance < 0) {
                clearInterval(timerInterval);
                document.getElementById("countdown").innerHTML = `<div class="text-center w-full" style="color:white;"><h3>Acara Dimulai! 🎊</h3></div>`;
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

        // --- 3. Music Logic ---
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');
        let hasInteracted = false;

        window.addEventListener('scroll', () => {
            if (!hasInteracted && bgMusic.paused) {
                bgMusic.play().then(() => {
                    musicBtn.innerHTML = '⏸';
                    musicBtn.style.background = 'var(--primary-color)';
                    hasInteracted = true;
                }).catch(e => console.log("Autoplay dicegah"));
            }
        }, { once: true });

        musicBtn.addEventListener('click', () => {
            if (bgMusic.paused) {
                bgMusic.play();
                musicBtn.innerHTML = '⏸';
                musicBtn.style.background = 'var(--primary-color)';
            } else {
                bgMusic.pause();
                musicBtn.innerHTML = '▶';
                musicBtn.style.background = 'var(--secondary-color)';
            }
        });

        // --- 4. RSVP Logic ---
        const invitationId = "{{ $invitation->id }}";
        const form = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');
        const rsvpMessageEl = document.getElementById('rsvpMessage');

        function renderRsvpList(rsvps) {
            const list = document.getElementById('rsvpList');
            if (!rsvps || rsvps.length === 0) {
                list.innerHTML = `<div class="text-center text-sm py-4">Belum ada ucapan 😢</div>`;
                return;
            }
            list.innerHTML = rsvps.map(rsvp => `
                <div class="flex items-center gap-3 p-2 border-b" style="border: 1px dashed #ccc;">
                    <img src="{{ asset('tempelate/user_default.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p style="font-weight:bold; color:var(--primary-color);">${rsvp.name}</p>
                        <p class="text-sm text-gray-600">${rsvp.message}</p>
                    </div>
                </div>
            `).join('');
        }

        function updateRsvpList() {
            fetch(`/invitation/${invitationId}/rsvps`)
                .then(res => res.json())
                .then(data => renderRsvpList(data))
                .catch(err => console.error(err));
        }

        if(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                rsvpButton.disabled = true;
                buttonText.innerText = "Mengirim...";
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
                        textarea.style.height = 'auto';
                        rsvpMessageEl.innerText = "Ucapan Terkirim! ✨";
                        rsvpMessageEl.style.display = 'block';
                        updateRsvpList();
                        setTimeout(() => { rsvpMessageEl.style.display = 'none'; }, 3000);
                    }
                })
                .catch(error => {
                    rsvpMessageEl.innerText = "Gagal kirim 😢";
                    rsvpMessageEl.style.display = 'block';
                })
                .finally(() => {
                    rsvpButton.disabled = false;
                    buttonText.innerText = "Kirim Ucapan 🚀";
                    buttonSpinner.classList.add('hidden');
                });
            });
        }

        updateRsvpList();
        setInterval(updateRsvpList, 3000);

        // --- 5. Scroll Animation ---
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.pop-in').forEach(el => observer.observe(el));

    </script>
</body>
</html>

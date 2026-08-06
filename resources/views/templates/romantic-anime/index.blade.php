<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>
    <style>
        :root {
            --color-bg: #EAE3D6;
            --color-primary: #8E7C6C;
            --color-accent: #D7C4A3;
            --color-text-box: #F5F1E9;
            --color-text: #4A3E35;
            --font-main: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        * {
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #2b2622;
            font-family: var(--font-main);
            color: var(--color-text);
            display: flex;
            justify-content: center;
            align-items: center;

        }




        #mobile-app {

            width: 100%;
            max-width: 430px;
            height: 100vh;
            max-height: 932px;
            background-color: var(--color-bg);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
        }

        /* EFEK BUNGA BERJATUHAN */
        .petal {
            position: absolute;
            background-color: #ffb7c5;
            border-radius: 150% 0 150% 0;
            opacity: 0.8;
            pointer-events: none;
            z-index: 80;
            animation: fall linear infinite;
        }

        @keyframes fall {
            0% {
                opacity: 0.9;
                top: -10%;
                transform: translateX(0) rotate(0deg);
            }

            100% {
                opacity: 0.2;
                top: 105%;
                transform: translateX(80px) rotate(360deg);
            }
        }

        #cover-screen,
        #thankyou-screen {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ url('template-assets/romantic-anime/image/bg1.jpg') }}');
            background-size: cover;
            background-position: bottom;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 100;
            padding: 20px;
            text-align: center;
            transition: opacity 0.8s ease;
        }

        #thankyou-screen {
            display: none;
            z-index: 150;
        }

        .cover-card {
            background: var(--color-text-box);
            padding: 20px 15px;
            border-radius: 18px;
            border: 3px solid var(--color-primary);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            z-index: 102;
        }

        .cover-title {
            font-size: 1.4em;
            color: var(--color-primary);
            margin: 6px 0;
            font-weight: bold;
        }

        .couple-preview {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin: 8px 0;
        }

        .couple-preview img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--color-primary);
            background-color: white;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
        }

        .guest-tag {
            background-color: var(--color-accent);
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8em;
            margin: 4px 0 10px 0;
            font-weight: 600;
        }

        .btn-main {
            background-color: var(--color-primary);
            color: white;
            border: none;
            padding: 10px 14px;
            font-size: 0.8em;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-bottom: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-main:active {
            transform: scale(0.98);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--color-primary);
            border: 1.5px solid var(--color-primary);
            padding: 7px 12px;
            font-size: 0.75em;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
        }

        /* OVERLAY MEKAR BUKA SURAT SATU LAYAR */
        #fullscreen-envelope-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--color-accent);
            z-index: 120;
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            pointer-events: none;
        }

        .full-flap-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background-color: var(--color-primary);
            transform-origin: top;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 122;
            border-bottom: 3px solid var(--color-accent);
        }

        .full-flap-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50%;
            background-color: var(--color-primary);
            transform-origin: bottom;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 122;
            border-top: 3px solid var(--color-accent);
        }

        .full-card-content {
            background: var(--color-text-box);
            width: 85%;
            height: 70%;
            border-radius: 16px;
            border: 3px solid var(--color-primary);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 121;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.6s ease 0.3s;
            padding: 20px;
            text-align: center;
        }

        #fullscreen-envelope-overlay.opening .full-flap-top {
            transform: translateY(-100%);
        }

        #fullscreen-envelope-overlay.opening .full-flap-bottom {
            transform: translateY(100%);
        }

        #fullscreen-envelope-overlay.opening .full-card-content {
            opacity: 1;
            transform: scale(1);
        }

        .audio-control {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 90;
            background: var(--color-text-box);
            border: 1.5px solid var(--color-primary);
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 0.68em;
            cursor: pointer;
            font-weight: bold;
            color: var(--color-primary);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .modal {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 200;
            padding: 15px;
        }

        .modal-card {
            background: var(--color-text-box);
            padding: 16px;
            border-radius: 14px;
            border: 3px solid var(--color-primary);
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
            text-align: center;
        }

        .modal-card input,
        .modal-card select,
        .modal-card textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1.5px solid var(--color-primary);
            border-radius: 6px;
            font-size: 0.8em;
            font-family: inherit;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 6px;
            margin: 10px 0;
        }

        .gallery-grid img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid var(--color-primary);
        }

        .video-container video {
            width: 100%;
            height: 160px;
            border-radius: 6px;
            border: 2px solid var(--color-primary);
        }

        #game-container {
            background-image: url('{{ url('template-assets/romantic-anime/image/bg1.jpg') }}');
            background-size: cover;
            background-position: bottom;
            width: 100%;
            height: 100%;
            position: relative;
            display: flex;
            justify-content: center;
        }

        /* KOTAK TEKS DIALOG */
        #dialog-text {
            font-size: 0.8em;
            line-height: 1.4;
            overflow-y: auto;
            word-wrap: break-word;
            white-space: pre-line;
            flex-grow: 1;
            padding-right: 6px;

            /* Kustomisasi Scrollbar untuk Firefox */
            scrollbar-width: thin;
            scrollbar-color: rgba(142, 124, 108, 0.4) transparent;
        }

        /* Kustomisasi Scrollbar untuk Webkit (Chrome, Safari, Edge, Mobile Browser) */
        #dialog-text::-webkit-scrollbar {
            width: 3px;
            /* Dikecilkan sangat tipis */
        }

        #dialog-text::-webkit-scrollbar-track {
            background: transparent;
            /* Area track transparan agar blend */
        }

        #dialog-text::-webkit-scrollbar-thumb {
            background-color: rgba(142, 124, 108, 0.35);
            /* Warna primary dengan transparansi halus */
            border-radius: 10px;
            /* Sudut melengkung halus */
        }

        #dialog-text::-webkit-scrollbar-thumb:hover {
            background-color: rgba(142, 124, 108, 0.6);
            /* Sedikit lebih tegas saat di-hover/touch */
        }

        .character-container {
            position: absolute;
            bottom: 100px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 15px;
            z-index: 5;
        }

        .character {
            height: 40vh;
            max-height: 380px;
            filter: grayscale(100%) opacity(0.35);
            transition: filter 0.3s ease, transform 0.25s ease, opacity 0.3s ease;
            object-fit: contain;
        }

        .character.active {
            filter: grayscale(0%) opacity(1);
            transform: scale(1.06);
        }

        #reaction-gif {
            position: absolute;
            top: 8%;
            left: 50%;
            transform: translateX(-50%);
            max-width: 90px;
            display: none;
            z-index: 15;
            border-radius: 8px;
            border: 2px solid var(--color-primary);
        }

        #dialog-box {
            position: absolute;
            bottom: 20px;
            width: 92%;
            height: 110px;
            background-color: var(--color-text-box);
            border: 2px solid var(--color-primary);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            padding: 10px 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
            z-index: 30;
        }

        #speaker-name {
            font-weight: bold;
            font-size: 0.85em;
            color: var(--color-primary);
            margin-bottom: 2px;
            flex-shrink: 0;
        }

        #dialog-text {
            font-size: 0.8em;
            line-height: 1.4;
            overflow-y: auto;
            word-wrap: break-word;
            white-space: pre-line;
            flex-grow: 1;
            padding-right: 3px;
        }

        .next-arrow {
            align-self: flex-end;
            font-size: 0.65em;
            color: var(--color-primary);
            animation: blink 1s infinite;
            flex-shrink: 0;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        #options-container {
            position: absolute;
            bottom: 140px;
            left: 50%;
            transform: translateX(-50%);
            display: none;
            flex-direction: column;
            gap: 6px;
            z-index: 25;
            width: 88%;
        }

        .option-button {
            background-color: var(--color-primary);
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.78em;
            cursor: pointer;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-weight: 600;
        }

        .option-button:active {
            background-color: var(--color-text);
        }

        .comment-item { display: flex; gap: 15px; background: #f9f9f9; padding: 15px; border-radius: 12px; margin-bottom: 15px; border: 1px solid #eee; }
        .comment-avatar { width: 40px; height: 40px; border-radius: 50%; background: #ddd; flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        .comment-content h5 { font-size: 0.95rem; color: var(--color-primary); margin-bottom: 4px; font-weight: 600; }
        .comment-content p { font-size: 0.85rem; color: #555; line-height: 1.5; word-wrap: break-word; }
    </style>
</head>

<body>

    <div id="mobile-app">
        <div id="flower-container"></div>

        <audio id="bgm-player" loop
            src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=lofi-study-112191.mp3"></audio>
        <audio id="voice-player"></audio>

        <!-- OVERLAY SURAT MEKAR FULLSCREEN -->
        <div id="fullscreen-envelope-overlay">
            <div class="full-flap-top"></div>
            <div class="full-card-content">
                <span style="font-size:2.5em; margin-bottom: 10px;">💌</span>
                <h3 style="color:var(--color-primary); margin:0 0 10px 0;">UNDANGAN TERBUKA</h3>
                <p style="font-size:0.85em; line-height:1.5;">Menuju Ruang Percakapan Alvaro & Yuna...</p>
            </div>
            <div class="full-flap-bottom"></div>
        </div>

        <!-- COVER SCREEN AWAL -->
        <div id="cover-screen">
            <div class="cover-card">
                <sub style="letter-spacing: 1px; color: var(--color-primary); font-size: 0.7em;">UNDANGAN
                    PERNIKAHAN</sub>
                <div class="cover-title">{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }}</div>

                <div class="couple-preview">
                    <img src="{{ asset('storage/' . ($invitation->foto_pria ?? 'default/groom.jpg')) }}"
                        alt="Pengantin Pria">
                    <span style="font-weight: bold; color: var(--color-primary); font-size: 0.9em;">&</span>
                    <img src="{{ asset('storage/' . ($invitation->foto_wanita ?? 'default/bride.jpg')) }}"
                        alt="Pengantin Wanita">
                </div>

                <p style="margin: 2px 0; font-size: 0.8em;">Kepada Yth.</p>
                <div class="guest-tag" id="display-guest-name">{{ request('penerima') ?? 'Keluarga Besar' }}</div>

                <button class="btn-main" onclick="openInvitation()">✉️ Buka Surat Undangan</button>
                <button class="btn-secondary" onclick="toggleModal('generator-modal', true)">🔗 Buat Link
                    Kustom</button>
            </div>
        </div>

        <!-- THANK YOU SCREEN AKHIR -->
        <div id="thankyou-screen">
            <div class="cover-card">
                <div class="cover-title">Terima Kasih! ✨</div>

                <div class="couple-preview">
                    <img src="{{ asset('storage/' . ($invitation->foto_pria ?? 'default/groom.jpg')) }}"
                        alt="Pengantin Pria">
                    <span style="font-weight: bold; color: var(--color-primary); font-size: 0.9em;">&</span>
                    <img src="{{ asset('storage/' . ($invitation->foto_wanita ?? 'default/bride.jpg')) }}"
                        alt="Pengantin Wanita">
                </div>

                <p style="margin: 8px 0; line-height: 1.35; font-size: 0.8em;">
                    Terima kasih banyak telah menyempatkan waktu untuk membuka undangan interaktif kami.<br><br>
                    Kehadiran serta doa restu kalian sangat berarti bagi kami.
                </p>
                <button class="btn-main" style="margin-bottom: 6px;" onclick="addGoogleCalendar()">🗓️ Simpan ke Google
                    Calendar</button>
                <button class="btn-secondary" onclick="restartGame()">🔄 Putar Ulang Percakapan</button>
            </div>
        </div>

        <!-- MODALS -->
        <div id="calendar-modal" class="modal">
            <div class="modal-card">
                <h4 style="margin-top: 0; color: var(--color-primary); font-size: 0.9em;">Setel Pengingat Kalender</h4>
                <button class="btn-main" onclick="addGoogleCalendar()">📅 Google Calendar</button>
                <button class="btn-secondary" onclick="downloadICSFile()">🍏 Apple / Outlook (.ics)</button>
                <button class="btn-secondary" style="margin-top: 6px;"
                    onclick="toggleModal('calendar-modal', false)">Batal</button>
            </div>
        </div>

        <div id="generator-modal" class="modal">
            <div class="modal-card">
                <h4 style="margin-top: 0; color: var(--color-primary); font-size: 0.9em;">Buat Link Undangan</h4>
                <input type="text" id="custom-name-input" placeholder="Masukkan Nama Tamu...">
                <button class="btn-main" onclick="generateCustomLink()">Salin Link Undangan</button>
                <button class="btn-secondary" onclick="toggleModal('generator-modal', false)">Batal</button>
            </div>
        </div>

        <div id="gallery-modal" class="modal">
            <div class="modal-card">
                <h4 style="margin-top: 0; color: var(--color-primary); font-size: 0.9em;">Galeri Foto Momen</h4>
                <div class="gallery-grid">
                    @forelse($invitation->galleries as $photo)
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="Wedding Moment">
                    @empty
                    <p class="text-center text-gray-500">Belum ada foto galeri.</p>
                    @endforelse
                </div>
                <button class="btn-main" onclick="toggleModal('gallery-modal', false)">Kembali ke Game</button>
            </div>
        </div>

        <div id="video-modal" class="modal">
            <div class="modal-card">
                <h4 style="margin-top: 0; color: var(--color-primary); font-size: 0.9em;">Video Prewedding</h4>
                <div class="video-container">
                    @if(!empty($invitation->video_link))
                        @php
                            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
                            $youtubeVideoId = $ytVideoMatches['id'] ?? '';
                        @endphp
                        @if($youtubeVideoId)
                        <iframe width="100%" height="160" src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                        @else
                        <video controls poster="{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}">
                            <source src="{{ asset('storage/' . $invitation->video_link) }}" type="video/mp4">
                        </video>
                        @endif
                    @else
                    <video controls
                        poster="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=600&q=80">
                        <source
                            src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4"
                            type="video/mp4">
                    </video>
                    @endif
                </div>
                <button class="btn-main" onclick="toggleModal('video-modal', false)">Kembali ke Game</button>
            </div>
        </div>

        <div id="rsvp-modal" class="modal">
            <div class="modal-card">
                <h4 style="margin-top: 0; color: var(--color-primary); font-size: 0.9em;">Konfirmasi RSVP</h4>
                <form id="rsvp-form" action="{{ route('rsvp.store', $invitation) }}" method="POST">
                    @csrf
                    <input type="text" id="rsvp-name" name="name" value="{{ request('penerima') ?? 'Tamu Undangan' }}" readonly style="background-color: #e0e0e0;">
                    <select id="rsvp-status" name="attending" required>
                        <option value="1">Hadir</option>
                        <option value="2">Tidak Hadir</option>
                        <option value="3">Masih Ragu</option>
                    </select>
                    <textarea id="rsvp-message" name="message" rows="3" placeholder="Tulis doa & ucapan..." style="height: 100px;" required></textarea>
                    <div class="text-center">
                        <button id="rsvpButton" type="submit" class="btn-main" style="background: transparent;">
                            <span id="buttonText">Kirim Ucapan</span>
                        </button>
                    </div>
                </form>
                <div id="rsvpMessage" class="text-center mt-4 text-sm font-bold hidden"></div>
                @if(!empty($invitation->resepsi_maps))
                <div class="text-center mt-4">
                    <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-main" style="background: transparent; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        <span>📍 Petunjuk Lokasi Maps</span>
                    </a>
                </div>
                @endif
                <div class="mt-6 bg-white rounded-lg mx-auto p-4" style="border: 1px solid #eee;">
                    <h4 class="text-center serif-font text-lg mb-4" style="color: var(--color-primary);">Tinggalkan kami doa terbaik anda untuk momen bahagia kami</h4>
                    <div id="rsvpList" class="space-y-4" style="max-height: 400px; overflow-y: auto; padding-right: 5px;" data-url="{{ route('rsvp.list', $invitation) }}"></div>
                    <div class="text-center mt-4">
                        <span class="text-xs text-gray-400">({{ $invitation->rsvps->count() }} Ucapan)</span>
                    </div>
                </div>
                <button class="btn-secondary" style="margin-top: 4px;"
                    onclick="toggleModal('rsvp-modal', false)">Batal</button>
            </div>
        </div>

        <!-- GAMEPLAY AREA -->
        <div id="game-container">
            <button class="audio-control" onclick="toggleAudio()" id="audio-btn">🎵 Audio: ON</button>
            <img id="reaction-gif" src="" alt="Reaction GIF">

            <div class="character-container">
                <img id="char-bride" class="character" src="{{ url('template-assets/romantic-anime/image/woman.png') }}" alt="Pengantin Wanita">
                <img id="char-groom" class="character" src="{{ url('template-assets/romantic-anime/image/man.png') }}" alt="Pengantin Pria">
            </div>

            <div id="options-container"></div>

            <div id="dialog-box" onclick="nextLine()">
                <div id="speaker-name"></div>
                <div id="dialog-text"></div>
                <div class="next-arrow">Tap untuk lanjut ▶</div>
            </div>
        </div>
    </div>

    <script>
        const IMAGE_BASE = "{{ url('template-assets/romantic-anime/image') }}/";
        /* DAFTAR GAMBAR POSE KARAKTER */
        const CHARACTER_POSES = {
            bride: {
                default: IMAGE_BASE + "woman.png",      // Pose diam/mendengarkan
                happy: IMAGE_BASE + "woman.png",  // Pose tersenyum bahagia
                talk: IMAGE_BASE + "woman_bicara.png"     // Pose bicara/menjelaskan
            },
            groom: {
                default: IMAGE_BASE + "man.png",        // Pose diam/mendengarkan
                happy: IMAGE_BASE + "man.png",    // Pose tersenyum bahagia
                talk: IMAGE_BASE + "man_bicara.png"       // Pose bicara/menjelaskan
            }
        };

        let guestName = "{{ request('penerima') ?? 'Tamu Undangan' }}";
        let dialog = [];
        let currentLine = 0;
        let isAudioEnabled = true;
        let typingTimeout;

        let audioCtx;

        function initAudioCtx() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
        }

        /* SOUND EFFECT KLIK TOMBOL UI */
        function playClickSound() {
            if (!isAudioEnabled) return;
            initAudioCtx();
            try {
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();

                osc.type = 'sine';
                const now = audioCtx.currentTime;
                osc.frequency.setValueAtTime(800, now);
                osc.frequency.exponentialRampToValueAtTime(300, now + 0.04);

                gain.gain.setValueAtTime(0.08, now);
                gain.gain.exponentialRampToValueAtTime(0.001, now + 0.04);

                osc.connect(gain);
                gain.connect(audioCtx.destination);

                osc.start(now);
                osc.stop(now + 0.04);
            } catch (e) { }
        }

        const eventData = {
            title: "{{ $invitation->groom_nickname ?? 'Pasangan' }} & {{ $invitation->bride_nickname ?? 'Pasangan' }} Wedding",
            description: "Akad & Resepsi Pernikahan {{ $invitation->groom_nickname ?? 'Pasangan' }} & {{ $invitation->bride_nickname ?? 'Pasangan' }}. Ditunggu kehadirannya!",
            location: "{{ $invitation->resepsi_location ?? 'Gedung Pernikahan Impian' }}",
            startISO: "{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('Ymd') }}T{{\Carbon\Carbon::parse($invitation->akad_time)->format('Hi')}}00",
            endISO: "{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('Ymd') }}T{{\Carbon\Carbon::parse(($invitation->resepsi_time_end === 'Selesai' || !$invitation->resepsi_time_end) ? '1400' : $invitation->resepsi_time_end)->format('Hi')}}00"
        };

        const nameEl = document.getElementById('speaker-name');
        const textEl = document.getElementById('dialog-text');
        const charBride = document.getElementById('char-bride');
        const charGroom = document.getElementById('char-groom');
        const optionsEl = document.getElementById('options-container');
        const gifEl = document.getElementById('reaction-gif');
        const bgmPlayer = document.getElementById('bgm-player');
        const voicePlayer = document.getElementById('voice-player');

        bgmPlayer.volume = 0.3;

        function createFlowerPetals() {
            const container = document.getElementById('flower-container');
            const petalCount = 18;

            for (let i = 0; i < petalCount; i++) {
                const petal = document.createElement('div');
                petal.className = 'petal';

                const size = Math.random() * 10 + 10;
                const posX = Math.random() * 100;
                const duration = Math.random() * 5 + 5;
                const delay = Math.random() * 5;

                petal.style.width = `${size}px`;
                petal.style.height = `${size * 1.3}px`;
                petal.style.left = `${posX}%`;
                petal.style.animationDuration = `${duration}s`;
                petal.style.animationDelay = `${delay}s`;

                container.appendChild(petal);
            }
        }

        window.onload = function () {
            createFlowerPetals();
            const urlParams = new URLSearchParams(window.location.search);
            const nameParam = urlParams.get('to');
            if (nameParam) {
                guestName = nameParam;
                document.getElementById('display-guest-name').textContent = guestName;
            }
            document.getElementById('rsvp-name').value = guestName;
            loadRsvpList();
            const rsvpForm = document.getElementById('rsvp-form');
            if (rsvpForm) {
                rsvpForm.addEventListener('submit', submitRSVP);
            }
        };

        function toggleAudio() {
            playClickSound();
            isAudioEnabled = !isAudioEnabled;
            document.getElementById('audio-btn').textContent = isAudioEnabled ? "🎵 Audio: ON" : "🔇 Audio: OFF";
            if (isAudioEnabled) { bgmPlayer.play(); } else { bgmPlayer.pause(); voicePlayer.pause(); }
        }

        function playVoice(voiceUrl) {
            if (!isAudioEnabled || !voiceUrl) return;
            voicePlayer.src = voiceUrl;
            voicePlayer.currentTime = 0;
            voicePlayer.play().catch(e => console.log("Autoplay blocked"));
        }

        function typeWriter(text, index = 0) {
            if (index < text.length) {
                textEl.textContent += text.charAt(index);
                typingTimeout = setTimeout(() => typeWriter(text, index + 1), 25);
            }
        }

        function openInvitation() {
            playClickSound();
            const overlay = document.getElementById('fullscreen-envelope-overlay');
            overlay.style.display = 'flex';

            setTimeout(() => {
                overlay.classList.add('opening');
            }, 50);

            setTimeout(() => {
                if (isAudioEnabled) { bgmPlayer.play().catch(e => console.log("Music blocked")); }

                /* ATRIBUT POSE TERHUBUNG DENGAN KARAKTER BERSANGKUTAN */
                dialog = [
                    {
                        speaker: "???",
                        text: `Permisi... Apakah kamu yang bernama ${guestName}?`,
                        char: "both",
                        pose: { bride: "default", groom: "default" },
                         voice: "https://cdn.freesound.org/previews/411/411642_5121236-lq.mp3"
                    },
                    {
                        speaker: "{{ $invitation->bride_nickname }} (Pengantin Wanita)",
                        text: `Halo ${guestName}! Senang sekali kamu menyempatkan waktu untuk hadir di percakapan ini.`,
                        char: "bride",
                        pose: { bride: "talk", groom: "default" },
                        gif: "https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExM3p0eDZocnhreGptY3FodnA4b3RwbWx2cjVreWR2cG94OGUybzA0ZiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/artj92V8o75VPL7AeQ/giphy.gif",
                        voice: "https://cdn.freesound.org/previews/411/411642_5121236-lq.mp3"
                    },
                    {
                        speaker: "{{ $invitation->groom_nickname }} (Pengantin Pria)",
                        text: `Halo ${guestName}! Selamat datang di ruang undangan digital interaktif kami.`,
                        char: "groom",
                        pose: { bride: "default", groom: "talk" },
                        voice: "https://cdn.freesound.org/previews/523/523410_11520626-lq.mp3"
                    },
                    {
                        speaker: "{{ $invitation->bride_nickname }}",
                        text: "Sebelum masuk ke detail acara, kami menyiapkan kenangan perjalanan kami...",
                        char: "bride",
                        pose: { bride: "talk", groom: "default" }
                    },
                    {
                        speaker: "Pilihan Media",
                        text: "Silakan pilih jika ingin melihat album foto atau video prewedding kami:",
                        char: "both",
                        pose: { bride: "happy", groom: "happy" },
                        options: [
                            { text: "📸 Lihat Galeri Foto", action: () => toggleModal('gallery-modal', true) },
                            { text: "🎬 Tonton Video Prewedding", action: () => toggleModal('video-modal', true) },
                            { text: "Lanjut ke Detail Acara ⏩", action: () => nextLine() }
                        ]
                    },
                    {
                        speaker: "{{ $invitation->groom_nickname }}",
                        text: "Dengan penuh rasa syukur, kami ingin mengumumkan bahwa kami telah mantap untuk menikah!",
                        char: "groom",
                        pose: { bride: "happy", groom: "talk" }
                    },
                    {
                        speaker: "Detail Acara",
                        text: "🗓️ Tanggal: {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}\n⏰ Waktu: {{ $invitation->akad_time }} - {{ $invitation->resepsi_time_end }}\n📍 Lokasi: {{ $invitation->resepsi_location ?? 'Gedung Pernikahan Impian' }}",
                        char: "both",
                        pose: { bride: "happy", groom: "happy" },
                        options: [
                            { text: "🗓️ Simpan Tanggal ke Kalender", action: () => toggleModal('calendar-modal', true) },
                            { text: "Lanjut Konfirmasi RSVP ⏩", action: () => nextLine() }
                        ]
                    },
                    {
                        speaker: "{{ $invitation->bride_nickname }}",
                        text: `Kehadiran ${guestName} tentu akan membuat hari bahagia kami terasa makin berkesan.`,
                        char: "bride",
                        pose: { bride: "talk", groom: "happy" }
                    },
                    {
                        speaker: "{{ $invitation->groom_nickname }}",
                        text: "Silakan isi form konfirmasi kehadiran RSVP kamu di bawah ini:",
                        char: "groom",
                        pose: { bride: "default", groom: "talk" },
                        options: [
                            { text: "✍️ Isi Form RSVP Kehadiran", action: () => toggleModal('rsvp-modal', true) },
                            { text: "📍 Petunjuk Lokasi Maps", action: () => window.open('https://maps.google.com', '_blank') }
                        ]
                    }
                ];

                document.getElementById('cover-screen').style.display = 'none';
                document.getElementById('thankyou-screen').style.display = 'none';
                overlay.style.display = 'none';
                overlay.classList.remove('opening');

                currentLine = 0;
                showLine();
            }, 1400);
        }

        function showLine() {
            clearTimeout(typingTimeout);
            voicePlayer.pause();

            const line = dialog[currentLine];
            nameEl.textContent = line.speaker;
            textEl.textContent = "";

            typeWriter(line.text);

            /* MENGUBAH POSE KARAKTER SECARA DINAMIS */
            const bridePose = (line.pose && line.pose.bride) ? line.pose.bride : "default";
            const groomPose = (line.pose && line.pose.groom) ? line.pose.groom : "default";

            if (CHARACTER_POSES.bride[bridePose]) {
                charBride.src = CHARACTER_POSES.bride[bridePose];
            }
            if (CHARACTER_POSES.groom[groomPose]) {
                charGroom.src = CHARACTER_POSES.groom[groomPose];
            }

            /* SOROTAN KARAKTER AKTIF */
            charBride.classList.remove('active');
            charGroom.classList.remove('active');

            if (line.char === 'bride') charBride.classList.add('active');
            if (line.char === 'groom') charGroom.classList.add('active');
            if (line.char === 'both') {
                charBride.classList.add('active');
                charGroom.classList.add('active');
            }

            if (line.voice) playVoice(line.voice);

            if (line.gif) {
                gifEl.src = line.gif;
                gifEl.style.display = 'block';
            } else {
                gifEl.style.display = 'none';
            }

            if (line.options) {
                optionsEl.innerHTML = '';
                line.options.forEach(opt => {
                    const btn = document.createElement('button');
                    btn.className = 'option-button';
                    btn.textContent = opt.text;
                    btn.onclick = () => {
                        playClickSound();
                        opt.action();
                    };
                    optionsEl.appendChild(btn);
                });
                optionsEl.style.display = 'flex';
                document.getElementById('dialog-box').style.pointerEvents = 'none';
            } else {
                optionsEl.style.display = 'none';
                document.getElementById('dialog-box').style.pointerEvents = 'auto';
            }
        }

        function nextLine() {
            playClickSound();
            currentLine++;
            if (currentLine < dialog.length) {
                showLine();
            } else {
                showThankYouScreen();
            }
        }

        function showThankYouScreen() {
            voicePlayer.pause();
            gifEl.style.display = 'none';
            document.getElementById('thankyou-screen').style.display = 'flex';
        }

        function restartGame() {
            playClickSound();
            document.getElementById('thankyou-screen').style.display = 'none';
            document.getElementById('cover-screen').style.display = 'flex';
        }

        function toggleModal(modalId, show) {
            playClickSound();
            document.getElementById(modalId).style.display = show ? 'flex' : 'none';
            if (show) {
                voicePlayer.pause();
                if (modalId === 'rsvp-modal') {
                    loadRsvpList();
                }
            }
        }

        function loadRsvpList() {
            var rsvpList = document.getElementById('rsvpList');
            if (!rsvpList) return;

            var listUrl = rsvpList.getAttribute('data-url');
            if (!listUrl) return;

            fetch(listUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data && data.length > 0) {
                    rsvpList.innerHTML = data.map(function(item) {
                        return '<div class="comment-item">'
                            + '<div class="comment-avatar">'
                            + '<span style="color: #999;">👤</span>'
                            + '</div>'
                            + '<div style="flex: 1; min-width: 0;">'
                            + '<p style="font-weight: 600; color: var(--color-primary); margin-bottom: 4px;">' + item.name + '</p>'
                            + '<p style="font-size: 0.85rem; color: #555; line-height: 1.5; word-wrap: break-word;">' + item.message + '</p>'
                            + '<p style="font-size: 0.75rem; color: #999; margin-top: 4px;">' + timeAgo(item.created_at) + '</p>'
                            + '</div>'
                            + '</div>';
                    }).join('');
                } else {
                    rsvpList.innerHTML = '<p class="text-center text-gray-500 mb-2">Belum ada ucapan. Jadilah yang pertama!</p><span class="material-symbols-outlined text-primary block text-center">favorite</span>';
                }
            })
            .catch(function(err) { console.error('Failed to load RSVP list:', err); });
        }

        function addGoogleCalendar() {
            playClickSound();
            const googleUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventData.title)}&dates=${eventData.startISO}/${eventData.endISO}&details=${encodeURIComponent(eventData.description)}&location=${encodeURIComponent(eventData.location)}`;
            window.open(googleUrl, '_blank');
        }

        function downloadICSFile() {
            playClickSound();
            const icsContent = `BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Undangan Pernikahan Alvaro & Yuna//ID
BEGIN:VEVENT
SUMMARY:${eventData.title}
DESCRIPTION:${eventData.description}
LOCATION:${eventData.location}
DTSTART:${eventData.startISO}
DTEND:${eventData.endISO}
END:VEVENT
END:VCALENDAR`;

            const blob = new Blob([icsContent], { type: 'text/calendar;charset=utf-8' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.setAttribute('download', 'Pernikahan_Alvaro_Yuna.ics');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function generateCustomLink() {
            playClickSound();
            const input = document.getElementById('custom-name-input').value.trim();
            if (!input) {
                alert("Harap masukkan nama terlebih dahulu!");
                return;
            }
            const baseUrl = window.location.origin + window.location.pathname;
            const generatedUrl = `${baseUrl}?penerima=${encodeURIComponent(input)}`;

            navigator.clipboard.writeText(generatedUrl).then(() => {
                alert(`Link berhasil disalin!\n\nURL: ${generatedUrl}`);
                toggleModal('generator-modal', false);
            });
        }

        function submitRSVP(event) {
            event.preventDefault();
            playClickSound();
            const form = event.target;
            const formData = new FormData(form);
            const submitUrl = form.getAttribute('action');
            const rsvpButton = document.getElementById('rsvpButton');
            const buttonText = document.getElementById('buttonText');
            const rsvpMessage = document.getElementById('rsvpMessage');

            if (!submitUrl) {
                alert('URL form tidak ditemukan.');
                return;
            }

            buttonText.textContent = 'Mengirim...';
            rsvpButton.disabled = true;
            rsvpMessage.classList.add('hidden');

            fetch(submitUrl, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(response) {
                if (!response.ok) {
                    return response.json().then(function(data) {
                        throw new Error(data.message || 'Gagal mengirim ucapan.');
                    }).catch(function(err) {
                        if (err.message && err.message !== 'Gagal mengirim ucapan.') throw err;
                        throw new Error('Gagal mengirim ucapan. Silakan coba lagi.');
                    });
                }
                return response.json();
            })
            .then(function(data) {
                rsvpMessage.textContent = 'Terima kasih! Ucapan Anda telah terkirim.';
                rsvpMessage.style.color = '#22c55e';
                rsvpMessage.classList.remove('hidden');
                form.reset();
                document.getElementById('rsvp-name').value = guestName;
                setTimeout(function() {
                    toggleModal('rsvp-modal', false);
                    showThankYouScreen();
                }, 1500);
            })
            .catch(function(err) {
                rsvpMessage.textContent = err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                rsvpMessage.style.color = '#ef4444';
                rsvpMessage.classList.remove('hidden');
                setTimeout(function() { rsvpMessage.classList.add('hidden'); }, 5000);
            })
            .finally(function() {
                buttonText.textContent = 'Kirim Ucapan';
                rsvpButton.disabled = false;
            });
        }
    </script>
</body>

</html>
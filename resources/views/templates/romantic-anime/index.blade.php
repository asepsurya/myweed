<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --color-bg: #EAE3D6;
            --color-primary: #8E7C6C;
            --color-accent: #D7C4A3;
            --color-text-box: #F5F1E9;
            --color-text: #4A3E35;
            --font-main: 'Poppins', sans-serif;
            --font-handwriting: 'Great Vibes', cursive;
        }

        * { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }

        body, html {
            margin: 0; padding: 0; width: 100%; height: 100%; overflow: hidden;
            background-color: #2b2622; font-family: var(--font-main); color: var(--color-text);
            display: flex; justify-content: center; align-items: center;
        }

        #mobile-app {
            width: 100%; max-width: 430px; height: 100vh; max-height: 932px;
            background-color: var(--color-bg); position: relative; overflow: hidden;
            display: flex; flex-direction: column; box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }

        /* SCROLLBAR KECIL & BLEND */
        ::-webkit-scrollbar { width: 2px; height: 2px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: rgba(142, 124, 108, 0.3); border-radius: 2px; }
        * { scrollbar-width: thin; scrollbar-color: rgba(142, 124, 108, 0.3) transparent; }

        /* EFEK BUNGA BERJATUHAN */
        .petal {
            position: absolute; background-color: #ffb7c5; border-radius: 150% 0 150% 0;
            opacity: 0.8; pointer-events: none; z-index: 80; animation: fall linear infinite;
        }
        @keyframes fall {
            0% { opacity: 0.9; top: -10%; transform: translateX(0) rotate(0deg); }
            100% { opacity: 0.2; top: 105%; transform: translateX(80px) rotate(360deg); }
        }

        /* ANIMASI BURUNG TERBANG & HINGGAH */
        .bird-container {
            position: absolute; top: -50px; right: -50px;
            z-index: 85; pointer-events: none;
            animation: flyPath 20s linear infinite;
            opacity: 0;
        }
        .bird {
            width: 30px; height: 30px; color: var(--color-primary); opacity: 0.8;
            animation: flap 0.3s ease-in-out infinite alternate;
        }
        .bird.two { width: 20px; height: 20px; opacity: 0.6; margin-top: 10px; margin-left: -10px; animation-delay: 0.1s; }
        
        @keyframes flap {
            0% { transform: scaleY(1); }
            100% { transform: scaleY(0.5); }
        }
        @keyframes flyPath {
            0% { transform: translate(0, 0) scale(0.5); opacity: 0; }
            10% { opacity: 0.8; }
            30% { transform: translate(-150px, 50px) scale(1); } /* Hinggap di layar */
            35% { transform: translate(-150px, 50px) scale(1); } /* Diam sebentar */
            40% { transform: translate(-160px, 40px) scale(1); } /* Terbang lagi */
            90% { opacity: 0.8; }
            100% { transform: translate(-450px, 100px) scale(0.5); opacity: 0; }
        }

        /* LAYER COVER & THANK YOU SCREEN */
        #cover-screen, #thankyou-screen {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('{{ storage_url('templates/romantic-anime/image/bg1.jpg') }}');
            background-size: cover; background-position: bottom; display: flex;
            flex-direction: column; justify-content: center; align-items: center;
            z-index: 100; padding: 20px; text-align: center; transition: opacity 0.8s ease;
        }
        #thankyou-screen { display: none; z-index: 150; }

        .cover-card {
            background: rgba(245, 241, 233, 0.90); backdrop-filter: blur(8px);
            padding: 30px 25px; border-radius: 12px;
            border: 1px solid var(--color-primary); box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            width: 100%; display: flex; flex-direction: column; align-items: center; z-index: 102; position: relative;
        }
        .cover-card::before {
            content: ''; position: absolute; top: 6px; left: 6px; right: 6px; bottom: 6px;
            border: 1px solid var(--color-accent); border-radius: 8px; pointer-events: none;
        }
        .cover-subtitle { font-size: 0.7em; letter-spacing: 2px; text-transform: uppercase; color: var(--color-primary); margin-bottom: 10px; font-weight: 500; }
        .cover-title { font-family: var(--font-handwriting); font-size: 3em; color: var(--color-text); margin: 0; font-weight: 400; line-height: 1.2; }
        .cover-divider { width: 50px; height: 1px; background-color: var(--color-primary); margin: 15px 0; }
        .couple-preview { display: flex; justify-content: center; align-items: center; gap: 15px; margin: 5px 0 15px 0; }
        .couple-preview img { width: 75px; height: 75px; border-radius: 50%; object-fit: cover; border: 2px solid var(--color-primary); background-color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .couple-preview span { font-family: var(--font-handwriting); font-size: 2.5em; color: var(--color-primary); }
        .guest-tag { background-color: transparent; border: 1px dashed var(--color-primary); padding: 6px 15px; border-radius: 20px; font-size: 0.8em; margin: 5px 0 20px 0; font-weight: 600; color: var(--color-primary); }

        /* TOMBOL (Transparan & Ringkas) */
        .btn-main {
            background-color: rgba(142, 124, 108, 0.85); backdrop-filter: blur(4px);
            color: white; border: 1px solid rgba(255,255,255,0.1); padding: 10px 14px;
            font-size: 0.75em; border-radius: 18px; cursor: pointer; font-weight: 600; width: 100%;
            margin-bottom: 8px; box-shadow: 0 4px 8px rgba(142, 124, 108, 0.1); transition: transform 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-main:active { transform: scale(0.98); }
        .btn-secondary {
            background-color: rgba(245, 241, 233, 0.6); backdrop-filter: blur(4px);
            color: var(--color-primary); border: 1px solid var(--color-primary);
            padding: 8px 12px; font-size: 0.7em; border-radius: 18px; cursor: pointer;
            width: 100%; font-weight: 600; margin-bottom: 8px;
            display: flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none;
        }

        /* OVERLAY MEKAR BUKA SURAT */
        #fullscreen-envelope-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: var(--color-accent);
            z-index: 120; display: none; flex-direction: column; justify-content: center; align-items: center; pointer-events: none;
        }
        .full-flap-top, .full-flap-bottom {
            position: absolute; left: 0; width: 100%; height: 50%; background-color: var(--color-primary);
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1); z-index: 122;
        }
        .full-flap-top { top: 0; transform-origin: top; border-bottom: 3px solid var(--color-accent); }
        .full-flap-bottom { bottom: 0; transform-origin: bottom; border-top: 3px solid var(--color-accent); }
        .full-card-content {
            background: var(--color-text-box); width: 85%; height: 70%; border-radius: 16px; border: 3px solid var(--color-primary);
            display: flex; flex-direction: column; justify-content: center; align-items: center; box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 121; opacity: 0; transform: scale(0.8); transition: all 0.6s ease 0.3s; padding: 20px; text-align: center;
        }
        #fullscreen-envelope-overlay.opening .full-flap-top { transform: translateY(-100%); }
        #fullscreen-envelope-overlay.opening .full-flap-bottom { transform: translateY(100%); }
        #fullscreen-envelope-overlay.opening .full-card-content { opacity: 1; transform: scale(1); }

        /* KONTROL AUDIO */
        .audio-control {
            position: absolute; top: 10px; right: 10px; z-index: 90; background: rgba(245, 241, 233, 0.7);
            backdrop-filter: blur(4px); border: 1px solid var(--color-primary); padding: 4px 10px;
            border-radius: 15px; font-size: 0.65em; cursor: pointer; font-weight: 600; color: var(--color-primary);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 4px;
        }

        /* MODAL */
        .modal {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.65);
            display: none; justify-content: center; align-items: center; z-index: 200; padding: 15px;
        }
        .modal-card {
            background: rgba(245, 241, 233, 0.95); backdrop-filter: blur(10px);
            padding: 25px 20px; border-radius: 16px; border: 1px solid var(--color-accent);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2); width: 100%; max-width: 360px; max-height: 85vh; overflow-y: auto; text-align: center;
        }
        .modal-card h4 {
            margin-top: 0; color: var(--color-primary); font-size: 1.2em; font-weight: 600;
            margin-bottom: 15px; text-transform: uppercase; letter-spacing: 1px;
        }
        .modal-card input, .modal-card select, .modal-card textarea {
            width: 100%; padding: 10px; margin: 8px 0; border: 1.5px solid var(--color-primary); border-radius: 8px;
            font-size: 0.8em; font-family: inherit; background: #fff;
        }
        .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; margin: 15px 0; }
        .gallery-grid img { width: 100%; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid var(--color-accent); }
        .video-container video, .video-container iframe { width: 100%; height: 180px; border-radius: 8px; border: 1px solid var(--color-accent); }

        /* KONTEN MODAL GIFT & STORY */
        .card-box {
            background: rgba(255, 255, 255, 0.9); border: 1px solid var(--color-accent); border-radius: 12px; padding: 15px;
            margin-bottom: 15px; width: 100%; box-shadow: 0 2px 5px rgba(0,0,0,0.03); text-align: left;
        }
        .card-box h3 { font-size: 0.9em; color: var(--color-primary); margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 1px; }
        .card-box p { font-size: 0.85em; color: #555; line-height: 1.6; margin: 0 0 8px 0; }
        .card-box img { width: 100%; max-height: 140px; object-fit: cover; border-radius: 8px; border: 1px solid var(--color-accent); margin-top: 8px; }
        .gift-number { font-size: 1.1em; font-weight: 700; color: var(--color-text); margin: 4px 0; letter-spacing: 0.5px; }
        .copy-btn { margin-top: 8px; background: var(--color-primary); color: white; border: none; padding: 8px 12px; border-radius: 6px; font-size: 0.75em; font-weight: 600; cursor: pointer; width: 100%; }

        /* AREA GAME */
        #game-container {
            background-image: url('{{ storage_url('templates/romantic-anime/image/bg1.jpg') }}');
            background-size: cover; background-position: bottom; width: 100%; height: 100%;
            position: relative; display: flex; justify-content: center; overflow: hidden; flex-shrink: 0;
        }
        /* EFEK BLEND (GRADIENT BAWAH) */
        #game-container::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 35%;
            background: linear-gradient(to top, var(--color-bg) 10%, transparent 100%);
            pointer-events: none; z-index: 20; /* Di atas karakter, di bawah chat box */
        }

        /* KOTAK TEKS DIALOG (BUBBLE CHAT) */
        #dialog-box {
            position: absolute; bottom: 20px; width: 92%; height: 170px; 
            background-color: rgba(245, 241, 233, 0.90); backdrop-filter: blur(8px);
            border: 2px solid var(--color-primary); border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            padding: 15px 20px; display: flex; flex-direction: column;
            justify-content: space-between; cursor: pointer; z-index: 30;
        }
        #speaker-name { font-weight: bold; font-size: 1em; color: var(--color-primary); margin-bottom: 5px; flex-shrink: 0; }
        #dialog-text {
            font-size: 0.95em; line-height: 1.5; overflow-y: auto; word-wrap: break-word; 
            white-space: pre-line; flex-grow: 1; padding-right: 6px;
        }
        .next-arrow { align-self: flex-end; font-size: 0.75em; color: var(--color-primary); animation: blink 1s infinite; flex-shrink: 0; }
        @keyframes blink { 0%, 100% { opacity: 0; } 50% { opacity: 1; } }

        /* KARAKTER */
        .character-container {
            position: absolute; bottom: 0; left: 0; width: 100%; height: 100%;
            display: flex; justify-content: center; align-items: flex-end; z-index: 5; pointer-events: none;
        }
        .character {
            height: auto; max-height: 45vh; max-width: 65%; 
            object-fit: contain; margin-bottom: 140px; 
            position: absolute; bottom: 0; opacity: 0;
            transform: translateY(0) translateX(0) scale(0.9);
            transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.25, 1, 0.5, 1), filter 0.6s ease;
            filter: blur(4px) grayscale(50%) brightness(0.7);
        }
        .character.active {
            opacity: 1; z-index: 10;
            transform: translateX(0) scale(1); 
            filter: blur(0) grayscale(0%) brightness(1);
        }
        .character.bg-right {
            opacity: 0.35; z-index: 5;
            transform: translateX(35px) scale(0.85); 
            filter: blur(3px) grayscale(60%) brightness(0.8);
        }
        .character.bg-left {
            opacity: 0.35; z-index: 5;
            transform: translateX(-35px) scale(0.85); 
            filter: blur(3px) grayscale(60%) brightness(0.8);
        }

        #reaction-gif {
            position: absolute; top: 8%; left: 50%; transform: translateX(-50%); max-width: 90px;
            display: none; z-index: 15; border-radius: 8px; border: 2px solid var(--color-primary);
        }

        /* TOMBOL PILIHAN (Opsi) */
        #options-container {
            position: absolute; bottom: 200px; left: 50%; transform: translateX(-50%); 
            display: none; flex-direction: column; gap: 6px; z-index: 25; width: 88%;
        }
        .option-button {
            background-color: rgba(142, 124, 108, 0.85); backdrop-filter: blur(4px);
            color: white; border: 1px solid rgba(255,255,255,0.1);
            padding: 8px 12px; border-radius: 16px; font-size: 0.75em; cursor: pointer; text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); font-weight: 600;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .option-button:active { background-color: var(--color-text); }

        /* RSVP LIST */
        .rsvp-list-item { background: rgba(255,255,255,0.9); padding: 12px; border-radius: 8px; margin-bottom: 10px; border: 1px solid var(--color-accent); display: flex; flex-direction: column; gap: 4px; }
        .rsvp-header { display: flex; align-items: center; gap: 8px; }
        .rsvp-avatar { width: 25px; height: 25px; background: var(--color-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7em; color: var(--color-primary); }
        .rsvp-name { font-weight: 600; color: var(--color-primary); font-size: 0.85em; margin: 0; }
        .rsvp-text { font-size: 0.8em; color: #555; line-height: 1.4; margin: 4px 0 0 0; }
        .rsvp-time { font-size: 0.7em; color: #999; margin: 2px 0 0 0; text-align: right; }
    </style>
</head>

<body>
    <div id="mobile-app">
        <div id="flower-container"></div>

        <!-- ANIMASI BURUNG -->
        <div class="bird-container">
            <svg class="bird" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 50 Q25 20 40 50 Q55 20 70 50 Q85 20 100 50" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" />
            </svg>
            <svg class="bird two" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 50 Q25 20 40 50 Q55 20 70 50 Q85 20 100 50" stroke="currentColor" stroke-width="3" fill="none" stroke-linecap="round" />
            </svg>
        </div>

        <!-- Audio Elements (Musik Latar Awal) -->
        <audio id="bgm-player" loop src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=lofi-study-112191.mp3"></audio>
        <audio id="voice-player"></audio>

        <!-- OVERLAY SURAT MEKAR FULLSCREEN -->
        <div id="fullscreen-envelope-overlay">
            <div class="full-flap-top"></div>
            <div class="full-card-content">
                <span style="font-size:2.5em; margin-bottom: 10px;">💌</span>
                <h3 style="color:var(--color-primary); margin:0 0 10px 0;">UNDANGAN TERBUKA</h3>
                <p style="font-size:0.85em; line-height:1.5;">Menuju Ruang Percakapan {{ $invitation->groom_nickname ?? 'Pasangan' }} & {{ $invitation->bride_nickname ?? 'Pasangan' }}...</p>
            </div>
            <div class="full-flap-bottom"></div>
        </div>

        <!-- COVER SCREEN AWAL -->
        <div id="cover-screen">
            <div class="cover-card">
                <div class="cover-subtitle">The Wedding Of</div>
                <div class="cover-title">{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }}</div>
                <div class="cover-divider"></div>
                <div class="couple-preview">
                    <img loading="lazy" src="{{ storage_url_with_fallback($invitation->foto_pria, storage_url('default/groom.jpg')) }}" alt="Pengantin Pria">
                    <span>&</span>
                    <img loading="lazy" src="{{ storage_url_with_fallback($invitation->foto_wanita, storage_url('default/bride.jpg')) }}" alt="Pengantin Wanita">
                </div>
                <p style="margin: 2px 0; font-size: 0.7em; letter-spacing: 1px; text-transform: uppercase;">Kepada Yth.</p>
                <div class="guest-tag" id="display-guest-name">{{ request('penerima') ?? 'Keluarga Besar' }}</div>
                <button class="btn-main" onclick="openInvitation()"><i class="ti ti-mail"></i> Buka Surat Undangan</button>
                <button class="btn-secondary" onclick="toggleModal('rsvp-modal', true)"><i class="ti ti-form-check"></i> Konfirmasi Kehadiran</button>
            </div>
        </div>

        <!-- THANK YOU SCREEN AKHIR -->
        <div id="thankyou-screen">
            <div class="cover-card">
                <div class="cover-subtitle">Terima Kasih</div>
                <div class="cover-title" style="font-size: 2.2em;">Untuk Hadirmu ✨</div>
                <div class="cover-divider"></div>
                <div class="couple-preview">
                    <img loading="lazy" src="{{ storage_url_with_fallback($invitation->foto_pria, storage_url('default/groom.jpg')) }}" alt="Pengantin Pria">
                    <span>&</span>
                    <img loading="lazy" src="{{ storage_url_with_fallback($invitation->foto_wanita, storage_url('default/bride.jpg')) }}" alt="Pengantin Wanita">
                </div>
                <p style="margin: 8px 0; line-height: 1.5; font-size: 0.8em;">
                    Terima kasih banyak telah menyempatkan waktu untuk membuka undangan interaktif kami.<br>
                    Kehadiran serta doa restu kalian sangat berarti bagi kami.
                </p>
                <button class="btn-main" style="margin-top: 10px;" onclick="toggleModal('calendar-modal', true)"><i class="ti ti-calendar"></i> Simpan ke Kalender HP</button>
                <button class="btn-secondary" onclick="restartGame()"><i class="ti ti-refresh"></i> Putar Ulang Percakapan</button>
            </div>
        </div>

        <!-- MODALS -->
        <div id="calendar-modal" class="modal">
            <div class="modal-card">
                <h4>Setel Pengingat Kalender</h4>
                <button class="btn-main" onclick="downloadICSFile()"><i class="ti ti-device-mobile"></i> Kalender HP (Android/iOS)</button>
                <button class="btn-secondary" onclick="addGoogleCalendar()"><i class="ti ti-brand-google"></i> Google Calendar</button>
                <button class="btn-secondary" style="margin-top: 6px;" onclick="toggleModal('calendar-modal', false)">Batal</button>
            </div>
        </div>

        <div id="gallery-modal" class="modal">
            <div class="modal-card">
                <h4>Galeri Foto Momen</h4>
                <div class="gallery-grid">
                    @forelse($invitation->galleries as $photo)
                        <img loading="lazy" src="{{ storage_url($photo->image) }}" alt="Wedding Moment">
                    @empty
                        <p style="grid-column: span 2; color: #888; font-size: 0.8em;">Belum ada foto galeri.</p>
                    @endforelse
                </div>
                <button class="btn-main" onclick="toggleModal('gallery-modal', false)">Kembali ke Game</button>
            </div>
        </div>

        <div id="video-modal" class="modal">
            <div class="modal-card">
                <h4>Video Prewedding</h4>
                <div class="video-container">
                    @if(($invitation->enable_video ?? true) && !empty($invitation->video_link))
                        @php
                            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
                            $youtubeVideoId = $ytVideoMatches['id'] ?? '';
                        @endphp
                        @if($youtubeVideoId)
                            <iframe width="100%" height="180" src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0" frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <video controls poster="{{ storage_url_with_fallback($invitation->gallery_cover, storage_url('default/cover.jpg')) }}">
                                <source src="{{ storage_url($invitation->video_link) }}" type="video/mp4">
                            </video>
                        @endif
                    @else
                        <video controls poster="{{ storage_url('default/cover.jpg') }}">
                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="video/mp4">
                        </video>
                    @endif
                </div>
                <button class="btn-main" style="margin-top: 15px;" onclick="toggleModal('video-modal', false)">Kembali ke Game</button>
            </div>
        </div>

        <!-- MODAL LOVE STORY -->
        <div id="story-modal" class="modal">
            <div class="modal-card">
                <h4>Love Story</h4>
                <div>
                    @php
                        $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
                    @endphp
                    @if(($invitation->enable_love_story ?? true) && (!empty($loveStories[0]['title']) || !empty($loveStories[0]['story'])))
                        @foreach($loveStories as $index => $story)
                        <div class="card-box">
                            <h3>{{ $story['title'] ?? '' }}</h3>
                            <p>{{ $story['story'] ?? '' }}</p>
                            @if(!empty($story['photo']))
                            <img loading="lazy" src="{{ storage_url($story['photo']) }}" alt="Story Photo">
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p style="color: #888; font-size: 0.8em; text-align: center;">Belum ada cerita cinta.</p>
                    @endif
                </div>
                <button class="btn-main" style="margin-top: 10px;" onclick="toggleModal('story-modal', false)">Tutup</button>
            </div>
        </div>

        <!-- MODAL WEDDING GIFT -->
        <div id="gift-modal" class="modal">
            <div class="modal-card">
                <h4>Wedding Gift</h4>
                <p style="font-size: 0.8em; color: #666; margin-bottom: 15px; line-height: 1.5;">
                    Doa restu Anda adalah hadiah terindah. Namun, jika ingin memberikan tanda kasih, silakan melalui:
                </p>
                <div>
                    @if($invitation->enable_gift == 1 && $invitation->gifts->count())
                        @foreach($invitation->gifts as $gift)
                        <div class="card-box">
                            <h3>{{ $gift->bank }}</h3>
                            <div class="gift-number">{{ $gift->number }}</div>
                            <p>A/N: {{ $gift->name }}</p>
                            <button class="copy-btn" onclick="copyText('{{ $gift->number }}', this)"><i class="ti ti-copy"></i> Salin No. Rekening</button>
                        </div>
                        @endforeach
                    @else
                        <p style="color: #888; font-size: 0.8em; text-align: center;">Belum ada data rekening.</p>
                    @endif
                </div>
                <button class="btn-main" style="margin-top: 10px;" onclick="toggleModal('gift-modal', false)">Tutup</button>
            </div>
        </div>

        <div id="rsvp-modal" class="modal">
            <div class="modal-card">
                <h4>Konfirmasi RSVP</h4>
                <form id="rsvp-form" action="{{ route('rsvp.store', $invitation) }}" method="POST">
                    @csrf
                    <input type="text" id="rsvp-name" name="name" value="{{ request('penerima') ?? 'Tamu Undangan' }}" readonly style="background-color: #e0e0e0;">
                    <select id="rsvp-status" name="attending" required>
                        <option value="1">Hadir</option>
                        <option value="2">Tidak Hadir</option>
                        <option value="3">Masih Ragu</option>
                    </select>
                    <textarea id="rsvp-message" name="message" rows="3" placeholder="Tulis doa & ucapan..." required></textarea>
                    <button id="rsvpButton" type="submit" class="btn-main" style="margin-top: 5px;">
                        <span id="buttonText">Kirim Ucapan</span>
                    </button>
                </form>
                <div id="rsvpMessage" style="text-align: center; margin-top: 10px; font-size: 0.8em; font-weight: bold; display: none;"></div>
                
                <a id="mapsLink" href="#" target="_blank" class="btn-secondary" style="margin-top: 8px;">
                    <i class="ti ti-map-pin"></i> Petunjuk Lokasi Maps
                </a>
                
                <div style="margin-top: 15px; background: rgba(255,255,255,0.5); border-radius: 10px; padding: 12px; border: 1px solid var(--color-accent);">
                    <h4 style="font-size: 1em; margin-bottom: 10px;">Ucapan & Doa Restu</h4>
                    <div id="rsvpList" style="max-height: 250px; overflow-y: auto; padding-right: 5px;" data-url="{{ route('rsvp.list', $invitation) }}"></div>
                    <div style="text-align: center; margin-top: 8px;">
                        <span style="font-size: 0.7em; color: #888;">({{ $invitation->rsvps->count() }} Ucapan)</span>
                    </div>
                </div>
                <button class="btn-secondary" style="margin-top: 10px;" onclick="toggleModal('rsvp-modal', false)">Batal</button>
            </div>
        </div>

        <!-- GAMEPLAY AREA -->
        <div id="game-container">
            <button class="audio-control" onclick="toggleAudio()" id="audio-btn">
                <i class="ti ti-music"></i> <span id="audio-text">Audio: ON</span>
            </button>
            <img loading="lazy" id="reaction-gif" src="" alt="Reaction GIF">

            <div class="character-container">
                <img loading="lazy" id="char-bride" class="character" src="{{ storage_url('templates/romantic-anime/image/woman.png') }}" alt="Pengantin Wanita">
                <img loading="lazy" id="char-groom" class="character" src="{{ storage_url('templates/romantic-anime/image/man.png') }}" alt="Pengantin Pria">
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
        // ================= KONFIGURASI & VARIABEL GLOBAL =================
        const IMAGE_BASE = "{{ storage_url('templates/romantic-anime/image') }}/";
        
        // PERBAIKAN URL MAPS: Memastikan URL selalu diawali https://
        let rawMapsUrl = @json($invitation->resepsi_maps ? $invitation->resepsi_maps : 'https://maps.google.com');
        let mapsUrl = rawMapsUrl;
        if (mapsUrl && !mapsUrl.startsWith('http://') && !mapsUrl.startsWith('https://')) {
            mapsUrl = 'https://' + mapsUrl;
        }

        const CHARACTER_POSES = {
            bride: { default: IMAGE_BASE + "woman.png", happy: IMAGE_BASE + "woman.png", talk: IMAGE_BASE + "woman_bicara.png" },
            groom: { default: IMAGE_BASE + "man.png", happy: IMAGE_BASE + "man.png", talk: IMAGE_BASE + "man_bicara.png" }
        };

        let guestName = "{{ request('penerima') ?? 'Tamu Undangan' }}";
        let dialog = [];
        let currentLine = 0;
        let isAudioEnabled = true;
        let typingTimeout;
        let audioCtx;

        const eventData = {
            title: "{{ $invitation->groom_nickname ?? 'Pasangan' }} & {{ $invitation->bride_nickname ?? 'Pasangan' }} Wedding",
            description: "Akad & Resepsi Pernikahan {{ $invitation->groom_nickname ?? 'Pasangan' }} & {{ $invitation->bride_nickname ?? 'Pasangan' }}. Ditunggu kehadirannya!",
            location: "{{ $invitation->resepsi_location ?? 'Gedung Pernikahan Impian' }}",
            startISO: "{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('Ymd') }}T{{ \Carbon\Carbon::parse($invitation->akad_time)->format('Hi') }}00",
            endISO: "{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('Ymd') }}T{{ \Carbon\Carbon::parse(($invitation->resepsi_time_end === 'Selesai' || !$invitation->resepsi_time_end) ? '1400' : $invitation->resepsi_time_end)->format('Hi') }}00"
        };

        // ================= DOM ELEMENTS =================
        const nameEl = document.getElementById('speaker-name');
        const textEl = document.getElementById('dialog-text');
        const charBride = document.getElementById('char-bride');
        const charGroom = document.getElementById('char-groom');
        const optionsEl = document.getElementById('options-container');
        const gifEl = document.getElementById('reaction-gif');
        const bgmPlayer = document.getElementById('bgm-player');
        const voicePlayer = document.getElementById('voice-player');

        bgmPlayer.volume = 0.4;
        document.getElementById('mapsLink').href = mapsUrl; // Set URL yang sudah benar ke tombol HTML

        // ================= FUNGSI AUDIO =================
        function initAudioCtx() {
            if (!audioCtx) { audioCtx = new (window.AudioContext || window.webkitAudioContext)(); }
        }

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
                osc.connect(gain); gain.connect(audioCtx.destination);
                osc.start(now); osc.stop(now + 0.04);
            } catch (e) { }
        }

        function toggleAudio() {
            playClickSound();
            isAudioEnabled = !isAudioEnabled;
            document.getElementById('audio-text').textContent = isAudioEnabled ? "Audio: ON" : "Audio: OFF";
            if (isAudioEnabled) { 
                bgmPlayer.play().catch(e => console.log("BGM blocked")); 
            } else { 
                bgmPlayer.pause(); 
                voicePlayer.pause(); 
            }
        }

        function playVoice(voiceUrl) {
            if (!isAudioEnabled || !voiceUrl) return;
            voicePlayer.src = voiceUrl;
            voicePlayer.currentTime = 0;
            voicePlayer.play().catch(e => console.log("Voice blocked"));
        }

        // ================= EFEK VISUAL =================
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

        function adjustCharacterHeight() {
            const dialogBox = document.getElementById('dialog-box');
            const characters = document.querySelectorAll('.character');
            if (dialogBox && characters.length > 0) {
                const dialogTop = dialogBox.offsetTop;
                const margin = 20; 
                const maxHeight = dialogTop - margin;
                characters.forEach(char => { char.style.maxHeight = `${maxHeight}px`; });
            }
        }

        // ================= GAME ENGINE =================
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

            setTimeout(() => { overlay.classList.add('opening'); }, 50);

            setTimeout(() => {
                // Start BGM
                if (isAudioEnabled) { bgmPlayer.play().catch(e => console.log("BGM blocked")); }

                dialog = [
                    { speaker: "???", text: `Permisi... Apakah kamu yang bernama ${guestName}?`, char: "groom", pose: { groom: "default" }, voice: "https://cdn.freesound.org/previews/411/411642_5121236-lq.mp3" },
                    { speaker: "{{ $invitation->bride_nickname }} (Pengantin Wanita)", text: `Halo ${guestName}! Senang sekali kamu menyempatkan waktu untuk hadir di percakapan ini.`, char: "bride", pose: { bride: "talk" }, voice: "https://cdn.freesound.org/previews/411/411642_5121236-lq.mp3" },
                    { speaker: "{{ $invitation->groom_nickname }} (Pengantin Pria)", text: `Halo ${guestName}! Selamat datang di ruang undangan digital interaktif kami.`, char: "groom", pose: { groom: "talk" }, voice: "https://cdn.freesound.org/previews/523/523410_11520626-lq.mp3" },
                    { speaker: "{{ $invitation->bride_nickname }}", text: "Sebelum masuk ke detail acara, kami menyiapkan kenangan perjalanan cinta kami...", char: "bride", pose: { bride: "talk" },
                      options: [
                          { text: "<i class='ti ti-heart'></i> Baca Love Story", action: () => toggleModal('story-modal', true) },
                          { text: "<i class='ti ti-player-play'></i> Lanjut Percakapan", action: () => nextLine() }
                      ]
                    },
                    { speaker: "Pilihan Media", text: "Silakan pilih jika ingin melihat album foto atau video prewedding kami:", char: "groom", pose: { groom: "happy" },
                      options: [
                          { text: "<i class='ti ti-photo'></i> Lihat Galeri Foto", action: () => toggleModal('gallery-modal', true) },
                          { text: "<i class='ti ti-video'></i> Tonton Video Prewedding", action: () => toggleModal('video-modal', true) },
                          { text: "<i class='ti ti-player-play'></i> Lanjut ke Detail Acara", action: () => nextLine() }
                      ]
                    },
                    { speaker: "{{ $invitation->groom_nickname }}", text: "Dengan penuh rasa syukur, kami ingin mengumumkan bahwa kami telah mantap untuk menikah!", char: "groom", pose: { groom: "talk" } },
                    { speaker: "Detail Acara", text: "Tanggal: {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}\n⏰ Waktu: {{ $invitation->akad_time }} - {{ $invitation->resepsi_time_end }}\n📍 Lokasi: {{ $invitation->resepsi_location ?? 'Gedung Pernikahan Impian' }}", char: "bride", pose: { bride: "happy" },
                      options: [
                          { text: "<i class='ti ti-calendar'></i> Simpan Tanggal ke Kalender", action: () => toggleModal('calendar-modal', true) },
                          { text: "<i class='ti ti-player-play'></i> Lanjut Percakapan", action: () => nextLine() }
                      ]
                    },
                    { speaker: "Wedding Gift", text: "Jika kamu ingin memberikan tanda kasih untuk kami, silakan lihat detail rekeningnya di sini:", char: "groom", pose: { groom: "happy" },
                      options: [
                          { text: "<i class='ti ti-gift'></i> Lihat Wedding Gift", action: () => toggleModal('gift-modal', true) },
                          { text: "<i class='ti ti-player-play'></i> Lanjut ke RSVP", action: () => nextLine() }
                      ]
                    },
                    { speaker: "{{ $invitation->bride_nickname }}", text: `Kehadiran ${guestName} tentu akan membuat hari bahagia kami terasa makin berkesan.`, char: "bride", pose: { bride: "talk" } },
                    { speaker: "{{ $invitation->groom_nickname }}", text: "Silakan isi form konfirmasi kehadiran RSVP kamu di bawah ini:", char: "groom", pose: { groom: "talk" },
                      options: [
                          { text: "<i class='ti ti-form-check'></i> Isi Form RSVP", action: () => toggleModal('rsvp-modal', true) },
                          { text: "<i class='ti ti-map-pin'></i> Petunjuk Lokasi Maps", action: () => window.open(mapsUrl, '_blank') },
                          { text: "<i class='ti ti-checks'></i> Selesaikan Percakapan", action: () => nextLine() }
                      ]
                    }
                ];

                document.getElementById('cover-screen').style.display = 'none';
                document.getElementById('thankyou-screen').style.display = 'none';
                overlay.style.display = 'none';
                overlay.classList.remove('opening');

                currentLine = 0;
                showLine();
                adjustCharacterHeight();
            }, 1400);
        }

        function showLine() {
            clearTimeout(typingTimeout);
            voicePlayer.pause();

            const line = dialog[currentLine];
            nameEl.textContent = line.speaker;
            textEl.textContent = "";

            typeWriter(line.text);

            charBride.classList.remove('active', 'bg-left', 'bg-right');
            charGroom.classList.remove('active', 'bg-left', 'bg-right');

            if (line.char === 'bride') {
                const bridePose = (line.pose && line.pose.bride) ? line.pose.bride : "default";
                if (CHARACTER_POSES.bride[bridePose]) charBride.src = CHARACTER_POSES.bride[bridePose];
                charBride.classList.add('active');
                charGroom.classList.add('bg-right');
            } else if (line.char === 'groom') {
                const groomPose = (line.pose && line.pose.groom) ? line.pose.groom : "default";
                if (CHARACTER_POSES.groom[groomPose]) charGroom.src = CHARACTER_POSES.groom[groomPose];
                charGroom.classList.add('active');
                charBride.classList.add('bg-left');
            }

            if (line.voice) playVoice(line.voice);

            if (line.gif) { gifEl.src = line.gif; gifEl.style.display = 'block'; } 
            else { gifEl.style.display = 'none'; }

            if (line.options) {
                optionsEl.innerHTML = '';
                line.options.forEach(opt => {
                    const btn = document.createElement('button');
                    btn.className = 'option-button';
                    btn.innerHTML = opt.text; 
                    btn.onclick = (e) => { e.stopPropagation(); playClickSound(); opt.action(); };
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
            if (currentLine < dialog.length) { showLine(); } 
            else { showThankYouScreen(); }
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
            currentLine = 0;
            dialog = [];
        }

        // ================= MODAL & RSVP =================
        function toggleModal(modalId, show) {
            playClickSound();
            document.getElementById(modalId).style.display = show ? 'flex' : 'none';
            if (show) {
                voicePlayer.pause();
                if (modalId === 'rsvp-modal') { loadRsvpList(); }
            }
        }

        function loadRsvpList() {
            const rsvpList = document.getElementById('rsvpList');
            if (!rsvpList) return;
            const listUrl = rsvpList.getAttribute('data-url');
            if (!listUrl) return;

            fetch(listUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        rsvpList.innerHTML = data.map(item => `
                            <div class="rsvp-list-item">
                                <div class="rsvp-header">
                                    <div class="rsvp-avatar"><i class="ti ti-user"></i></div>
                                    <p class="rsvp-name">${item.name}</p>
                                </div>
                                <p class="rsvp-text">${item.message}</p>
                                <p class="rsvp-time">${timeAgo(item.created_at)}</p>
                            </div>
                        `).join('');
                    } else {
                        rsvpList.innerHTML = '<p style="text-align: center; color: #888; font-size: 0.8em;">Belum ada ucapan. Jadilah yang pertama! 💖</p>';
                    }
                })
                .catch(err => console.error('Failed to load RSVP list:', err));
        }
        
        function timeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            if (seconds < 60) return 'Baru saja';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes} menit lalu`;
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours} jam lalu`;
            const days = Math.floor(hours / 24);
            return `${days} hari lalu`;
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

            if (!submitUrl) { alert('URL form tidak ditemukan.'); return; }

            buttonText.textContent = 'Mengirim...';
            rsvpButton.disabled = true;
            rsvpMessage.style.display = 'none';

            fetch(submitUrl, {
                method: 'POST', body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => { throw new Error(data.message || 'Gagal mengirim ucapan.'); })
                    .catch(err => {
                        if (err.message && err.message !== 'Gagal mengirim ucapan.') throw err;
                        throw new Error('Gagal mengirim ucapan. Silakan coba lagi.');
                    });
                }
                return response.json();
            })
            .then(data => {
                rsvpMessage.textContent = 'Terima kasih! Ucapan Anda telah terkirim.';
                rsvpMessage.style.color = '#22c55e';
                rsvpMessage.style.display = 'block';
                form.reset();
                document.getElementById('rsvp-name').value = guestName;
                setTimeout(() => { toggleModal('rsvp-modal', false); showThankYouScreen(); }, 1500);
            })
            .catch(err => {
                rsvpMessage.textContent = err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                rsvpMessage.style.color = '#ef4444';
                rsvpMessage.style.display = 'block';
                setTimeout(() => { rsvpMessage.style.display = 'none'; }, 5000);
            })
            .finally(() => {
                buttonText.textContent = 'Kirim Ucapan';
                rsvpButton.disabled = false;
            });
        }

        function copyText(number, btn) {
            playClickSound();
            navigator.clipboard.writeText(number).then(() => {
                const originalText = btn.innerHTML;
                btn.innerHTML = "<i class='ti ti-check'></i> Tersalin!";
                setTimeout(() => {
                    btn.innerHTML = originalText;
                }, 2000);
            }).catch(err => console.error('Failed to copy:', err));
        }

        // ================= KALENDAR =================
        function addGoogleCalendar() {
            playClickSound();
            const googleUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(eventData.title)}&dates=${eventData.startISO}/${eventData.endISO}&details=${encodeURIComponent(eventData.description)}&location=${encodeURIComponent(eventData.location)}`;
            window.open(googleUrl, '_blank');
        }

        function downloadICSFile() {
            playClickSound();
            const fileName = `Pernikahan_${eventData.title.replace(/\s+/g, '_').replace(/&/g, '_')}.ics`;
            
            // Format ICS yang strict agar langsung terbuka di Kalender HP (Android/iOS)
            const icsContent = [
                'BEGIN:VCALENDAR',
                'VERSION:2.0',
                'PRODID:-//Events Calendar//Invitation//ID',
                'CALSCALE:GREGORIAN',
                'METHOD:PUBLISH',
                'BEGIN:VEVENT',
                `SUMMARY:${eventData.title}`,
                `DESCRIPTION:${eventData.description}`,
                `LOCATION:${eventData.location}`,
                `DTSTART:${eventData.startISO}`,
                `DTEND:${eventData.endISO}`,
                'STATUS:CONFIRMED',
                'END:VEVENT',
                'END:VCALENDAR'
            ].join('\r\n');

            const blob = new Blob([icsContent], { type: 'text/calendar;charset=utf-8' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.setAttribute('download', fileName);
            document.body.appendChild(link); 
            link.click(); 
            document.body.removeChild(link);
        }

        // ================= INITIALIZATION =================
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
            if (rsvpForm) { rsvpForm.addEventListener('submit', submitRSVP); }
            adjustCharacterHeight();
            window.addEventListener('resize', adjustCharacterHeight);
        };
    </script>
</body>

</html>
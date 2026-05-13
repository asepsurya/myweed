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

    <!-- Google Fonts: Playfair Display (Klasik) & Prata (Nuansa Kuno) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Prata&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        :root {
            /* Palet Warna Adat Jawa (Maroon & Gold) */
            --primary-color: #5D3A36;
            /* Coklat Maroon Tua */
            --accent-color: #Cfb997;
            /* Emas Pudar */
            --secondary-color: #8D6E63;
            /* Coklat Sedang */
            --bg-color: #Fdfbf7;
            /* Kertas Tua Krem */
            --text-dark: #3E2723;
            --text-gold: #B7860B;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #e0dcd5;
            background-image: radial-gradient(var(--accent-color) 15%, transparent 16%), radial-gradient(var(--accent-color) 15%, transparent 16%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
            /* Hide Scrollbar */
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .mobile-container {
            width: 100%;
            max-width: 414px;
            background-color: var(--bg-color);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.2);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            border: 10px solid white;
            outline: 1px solid var(--accent-color);
        }

        h1,
        h2,
        h3,
        .serif-font {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            font-weight: 700;
        }

        .ancient-font {
            font-family: 'Prata', serif;
        }

        .text-center {
            text-align: center;
        }

        .divider-gunungan {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px 0;
            position: relative;
        }

        .divider-line {
            height: 1px;
            background: var(--accent-color);
            width: 100%;
            position: absolute;
            z-index: 0;
        }

        .gunungan-icon {
            width: 40px;
            height: auto;
            fill: var(--primary-color);
            z-index: 1;
            background: var(--bg-color);
            padding: 0 10px;
        }

        .section-padding {
            padding: 60px 25px;
            position: relative;
        }

        .mb-5 {
            margin-bottom: 50px;
        }

        .hero {
            height: 100vh;
            background: linear-gradient(rgba(93, 58, 54, 0.8), rgba(93, 58, 54, 0.6)), url('{{ asset('storage/' . $invitation->gallery_cover) }}');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--accent-color);
            text-align: center;
            position: relative;
        }

        .flower-ornament {
            width: 100px;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .hero h1 {
            font-size: 2.8rem;
            color: var(--accent-color);
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
        }

        .hero-sub {
            font-family: 'Prata', serif;
            font-style: italic;
            font-size: 1.2rem;
            letter-spacing: 1px;
            border-top: 1px solid var(--accent-color);
            border-bottom: 1px solid var(--accent-color);
            padding: 10px 20px;
            margin-top: 20px;
            display: inline-block;
        }

        .scroll-btn {
            position: absolute;
            bottom: 30px;
            color: var(--accent-color);
            font-size: 2rem;
            animation: bounce 2s infinite;
            cursor: pointer;
        }

        .quote-section {
            background-color: var(--white);
            text-align: center;
            font-family: 'Prata', serif;
            font-style: italic;
            color: var(--secondary-color);
            border-bottom: 2px solid var(--primary-color);
            position: relative;
        }

        .couple-wrapper {
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        .couple-card {
            text-align: center;
        }

        .photo-frame-javanese {
            position: relative;
            display: inline-block;
            padding: 15px;
            border: 2px solid var(--accent-color);
            background: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .photo-frame-javanese::before,
        .photo-frame-javanese::after,
        .photo-frame-inner::before,
        .photo-frame-inner::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid var(--primary-color);
        }

        .photo-frame-javanese::before {
            top: 5px;
            left: 5px;
            border-right: none;
            border-bottom: none;
        }

        .photo-frame-javanese::after {
            top: 5px;
            right: 5px;
            border-left: none;
            border-bottom: none;
        }

        .photo-frame-javanese .photo-frame-inner {
            position: relative;
            display: block;
        }

        .photo-frame-javanese .photo-frame-inner::before {
            bottom: 5px;
            left: 5px;
            border-right: none;
            border-top: none;
        }

        .photo-frame-javanese .photo-frame-inner::after {
            bottom: 5px;
            right: 5px;
            border-left: none;
            border-top: none;
        }

        .couple-img {
            width: 200px;
            height: 250px;
            object-fit: cover;
            filter: sepia(30%) contrast(90%);
            display: block;
        }

        .couple-name {
            font-size: 1.8rem;
            margin-top: 20px;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .parent-name {
            font-size: 0.9rem;
            color: var(--secondary-color);
            font-family: 'Prata', serif;
        }

        .connector-symbol {
            font-size: 2.5rem;
            color: var(--accent-color);
            font-family: 'Playfair Display', serif;
            line-height: 1;
            margin-top: -30px;
        }

        .event-card {
            border: 1px solid var(--accent-color);
            padding: 30px 15px;
            text-align: center;
            margin-bottom: 30px;
            background: white;
            position: relative;
        }

        .event-card::before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 1px solid var(--primary-color);
            pointer-events: none;
        }

        .event-title {
            font-family: 'Prata', serif;
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .event-time {
            font-size: 1.1rem;
            font-weight: bold;
            color: var(--text-gold);
            margin-bottom: 15px;
            display: block;
        }

        .btn-map {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background-color: var(--primary-color);
            color: var(--bg-color);
            text-decoration: none;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px solid var(--primary-color);
            transition: all 0.3s;
        }

        .btn-map:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
            border-color: var(--accent-color);
        }

        .countdown-section {
            background-color: var(--primary-color);
            color: var(--accent-color);
            text-align: center;
            padding: 50px 20px;
            border-top: 5px solid var(--accent-color);
            border-bottom: 5px solid var(--accent-color);
            background-image: repeating-linear-gradient(45deg, rgba(0, 0, 0, 0.05) 0px, rgba(0, 0, 0, 0.05) 10px, transparent 10px, transparent 20px);
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .timer-box {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px 10px;
            border: 1px solid var(--accent-color);
            min-width: 60px;
        }

        .timer-val {
            font-family: 'Prata', serif;
            font-size: 1.8rem;
            display: block;
        }

        .timer-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .gallery-item {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            filter: sepia(20%);
            transition: all 0.3s;
        }

        .gallery-item:hover {
            transform: scale(1.03);
            filter: sepia(0%);
            border-color: var(--accent-color);
        }

        .gift-card {
            background: white;
            padding: 20px;
            border: 1px solid var(--accent-color);
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .rsvp-form {
            background: #fff;
            padding: 30px;
            border: 1px solid var(--secondary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .form-control {
            width: 100%;
            padding: 10px 0;
            margin-bottom: 20px;
            border: none;
            border-bottom: 1px solid var(--primary-color);
            background: transparent;
            font-family: 'Prata', serif;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .form-control:focus {
            outline: none;
            border-bottom: 2px solid var(--accent-color);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: var(--accent-color);
            border: none;
            font-family: 'Playfair Display', serif;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .music-control {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            font-size: 24px;
        }

        footer {
            background-color: var(--primary-color);
            color: var(--accent-color);
            padding: 40px 20px;
            text-align: center;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 1s;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-15px);
            }

            60% {
                transform: translateY(-7px);
            }
        }

        #toast {
            visibility: hidden;
            min-width: 200px;
            background-color: var(--primary-color);
            color: var(--accent-color);
            text-align: center;
            padding: 16px;
            position: fixed;
            z-index: 99;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-family: 'Prata', serif;
            border: 1px solid var(--accent-color);
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }

            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }

            to {
                bottom: 0;
                opacity: 0;
            }
        }

        /* --- Desktop Layout (Split Screen) --- */
        @media (min-width: 1024px) {
            body {
                background: #e0dcd5;
                height: 100vh;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mobile-container {
                max-width: 1000px !important;
                flex-direction: row !important;
                display: flex !important;
                height: 90vh;
                border-radius: 20px;
                overflow: hidden;
                border: 10px solid white;
                outline: 1px solid var(--accent-color);
            }

            .hero {
                flex: 1.2;
                height: 100% !important;
                background-attachment: scroll;
            }

            .content-wrapper {
                flex: 1;
                height: 100%;
                overflow-y: auto;
                background: var(--bg-color);
                scrollbar-width: thin;
                scrollbar-color: var(--primary-color) transparent;
            }

            .content-wrapper::-webkit-scrollbar {
                width: 5px;
            }

            .content-wrapper::-webkit-scrollbar-thumb {
                background: var(--primary-color);
                border-radius: 10px;
            }

            .section-padding {
                padding: 60px 30px;
            }

            .hero h1 {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Music Control -->
    <div id="musicBtn" class="music-control">
        <i class="ti ti-player-play" id="musicIcon"></i>
    </div>

    <div class="mobile-container">

        <!-- Hero Section -->
        <header id="preview-hero-bg" class="hero">
            <svg class="flower-ornament" viewBox="0 0 100 50">
                <path d="M50 50 C 20 50 0 30 0 10 C 20 0 40 0 50 20 C 60 0 80 0 100 10 C 100 30 80 50 50 50" fill="none"
                    stroke="#Cfb997" stroke-width="2" />
            </svg>

            <p class="fade-in" style="font-size: 0.9rem; letter-spacing: 2px;">The Wedding of</p>
            <h1 class="fade-in" style="margin-top: 10px;">
                {{ $invitation->groom_nickname }}<br>&<br>{{ $invitation->bride_nickname }}</h1>

            <div class="hero-sub fade-in">
                Kepada Yth. Bapak/Ibu/Saudara/i<br>
                <span style="font-weight: 700; font-size: 1.2rem; display: inline-block; margin-top: 5px;">{{ request('to') ?? 'Tamu Undangan' }}</span>
            </div>

            <div class="hero-sub fade-in" style="margin-top: 20px;">
                {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}
            </div>

            <div class="scroll-btn" onclick="document.getElementById('quote').scrollIntoView({behavior: 'smooth'})">
                <i class="ti ti-chevron-down"></i>
            </div>
        </header>

        <div class="content-wrapper">
            <!-- Mangayu Bagya (Quote) -->
            <section id="quote" class="section-padding quote-section">
                <div class="fade-in">
                    <h3 style="font-family: 'Prata', serif; font-size: 1.5rem; margin-bottom: 15px;">Mangayu Bagya</h3>
                    <p style="font-size: 1.1rem; line-height: 1.6;">
                        {!! nl2br(e($invitation->wedding_quote)) !!}
                    </p>
                </div>
            </section>

            <!-- Mempelai -->
            <section class="section-padding">
                <div class="couple-wrapper fade-in">
                    <!-- Groom -->
                    <div class="couple-card">
                        <div class="photo-frame-javanese">
                            <span class="photo-frame-inner"></span>
                            <img id="preview-foto-pria" src="{{ asset('storage/' . $invitation->foto_pria) }}"
                                alt="{{ $invitation->groom_name }}" class="couple-img">
                        </div>
                        <h3 class="couple-name ancient-font">{{ $invitation->groom_name }}</h3>
                        <p class="parent-name">Putra dari Bpk. {{ $invitation->groom_father_name }} & Ibu
                            {{ $invitation->groom_mother_name }}</p>
                    </div>

                    <div class="text-center connector-symbol">&</div>

                    <!-- Bride -->
                    <div class="couple-card">
                        <div class="photo-frame-javanese">
                            <span class="photo-frame-inner"></span>
                            <img id="preview-foto-wanita" src="{{ asset('storage/' . $invitation->foto_wanita) }}"
                                alt="{{ $invitation->bride_name }}" class="couple-img">
                        </div>
                        <h3 class="couple-name ancient-font">{{ $invitation->bride_name }}</h3>
                        <p class="parent-name">Putri dari Bpk. {{ $invitation->bride_father_name }} & Ibu
                            {{ $invitation->bride_mother_name }}</p>
                    </div>
                </div>
            </section>

            <!-- Divider Gunungan -->
            <div class="divider-gunungan">
                <div class="divider-line"></div>
                <svg class="gunungan-icon" viewBox="0 0 50 100">
                    <path
                        d="M25 100 Q 0 50, 25 0 Q 50 50, 25 100 M25 20 C 10 20, 5 40, 15 60 C 10 50, 0 60, 10 80 M25 20 C 40 20, 45 40, 35 60 C 40 50, 50 60, 40 80"
                        fill="currentColor" />
                </svg>
            </div>

            <!-- Acara -->
            <section class="section-padding" style="background-color: #f7f7f7;">
                <div class="text-center mb-5 fade-in">
                    <h2 class="ancient-font" style="font-size: 2rem;">Rangkaian Acara</h2>
                </div>

                <div class="fade-in">
                    <div class="event-card">
                        <div class="event-title">Akad Nikah</div>
                        <span class="event-time">{{ $invitation->akad_time }} - {{ $invitation->akad_time_end }}</span>
                        <p style="font-size: 0.9rem; color: #555;">
                            {{ $invitation->akad_location }}<br>{{ $invitation->akad_address }}</p>
                        <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-map">Lihat Lokasi</a>
                    </div>

                    <div class="event-card">
                        <div class="event-title">Resepsi</div>
                        <span class="event-time">{{ $invitation->resepsi_time }} -
                            {{ $invitation->resepsi_time_end }}</span>
                        <p style="font-size: 0.9rem; color: #555;">
                            {{ $invitation->resepsi_location }}<br>{{ $invitation->resepsi_address }}</p>
                        <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-map">Lihat Lokasi</a>
                    </div>
                </div>
            </section>

            <!-- Countdown -->
            <section class="countdown-section">
                <div class="fade-in">
                    <h3 class="ancient-font" style="font-size: 1.8rem;">Hitung Mundur</h3>
                    <div class="countdown-timer" id="timer">
                        <div class="timer-box"><span class="timer-val" id="days">00</span><span
                                class="timer-label">Hari</span></div>
                        <div class="timer-box"><span class="timer-val" id="hours">00</span><span
                                class="timer-label">Jam</span></div>
                        <div class="timer-box"><span class="timer-val" id="minutes">00</span><span
                                class="timer-label">Menit</span></div>
                        <div class="timer-box"><span class="timer-val" id="seconds">00</span><span
                                class="timer-label">Detik</span></div>
                    </div>
                </div>
            </section>

            <!-- Love Story -->
            @php
                $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
            @endphp
            @if(!empty($loveStories))
                <section class="section-padding">
                    <div class="text-center mb-5 fade-in">
                        <h2 class="ancient-font" style="font-size: 2rem;">Kisah Cinta</h2>
                    </div>
                    @foreach($loveStories as $story)
                        @if(!empty($story['title']))
                            <div class="fade-in"
                                style="background:white; padding:20px; border:1px solid var(--accent-color); margin-bottom: 20px;">
                                <h4 class="ancient-font" style="color:var(--primary-color);">{{ $story['title'] }}</h4>
                                <p style="font-size: 0.9rem; margin-top:10px;">{{ $story['story'] }}</p>
                                @if(!empty($story['photo']))
                                    <img src="{{ asset('storage/' . $story['photo']) }}"
                                        style="width:100%; border-radius:10px; margin-top:15px;">
                                @endif
                            </div>
                        @endif
                    @endforeach
                </section>
            @endif

            <!-- Gallery -->
            <section class="section-padding">
                <div class="text-center mb-5 fade-in">
                    <h2 class="ancient-font" style="font-size: 2rem;">Dokumentasi</h2>
                </div>
                <div class="gallery-grid fade-in">
                    @foreach($invitation->galleries as $photo)
                        <img src="{{ asset('storage/' . $photo->image) }}" class="gallery-item" alt="Gallery Photo">
                    @endforeach
                </div>
            </section>

            <!-- Gifts -->
            @if($invitation->enable_gift == 1 && $invitation->gifts->count())
                <section class="section-padding" style="background:#f7f7f7;">
                    <div class="text-center mb-5 fade-in">
                        <h2 class="ancient-font" style="font-size: 2rem;">Wedding Gift</h2>
                    </div>
                    @foreach($invitation->gifts as $gift)
                        <div class="gift-card fade-in">
                            <h4 class="ancient-font">{{ $gift->bank }}</h4>
                            <p style="font-size: 1.2rem; font-weight: bold; margin: 10px 0;">{{ $gift->number }}</p>
                            <p>A/N: {{ $gift->name }}</p>
                            <button onclick="copyToClipboard('{{ $gift->number }}')" class="btn-map"
                                style="padding: 5px 15px; font-size: 0.7rem; margin-top: 10px;">Salin No. Rekening</button>
                        </div>
                    @endforeach
                </section>
            @endif


            <!-- Galeri -->
            <section class="section-padding" style="background-color: var(--white);">
                <div class="text-center mb-5 fade-in">
                    <h2 class="ancient-font" style="font-size: 2rem;">Galeri Momen</h2>
                </div>
                <div class="masonry-gallery fade-in" id="gallery-container">
                    @forelse ($invitation->galleries as $photo)
                        <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery" class="masonry-item">
                            <img src="{{ asset('storage/' . $photo->image) }}" alt="Gallery Photo" loading="lazy">
                        </a>
                    @empty
                        <p class="text-center w-full text-muted">Belum ada foto galeri.</p>
                    @endforelse
                </div>
            </section>

            <!-- RSVP -->
            @if($invitation->enable_rsvp == 1)
                <section class="section-padding" style="background: #f0ebe5;">
                    <div class="text-center mb-5 fade-in">
                        <h2 class="ancient-font" style="font-size: 2rem;">Ucapan & Doa</h2>
                    </div>

                    <div class="rsvp-form fade-in">
                        <form id="rsvpForm">
                            @csrf
                            <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                            <select name="attending" class="form-control">
                                <option value="1">Hadir</option>
                                <option value="0">Berhalangan</option>
                            </select>
                            
                            <div class="emoji-picker" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: center;">
                                <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🎉</button>
                                <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">❤️</button>
                                <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🥳</button>
                                <button type="button" onclick="addEmoji('✨')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">✨</button>
                                <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🙏</button>
                            </div>

                            <textarea name="message" class="form-control" rows="3" placeholder="Tulis ucapan selamat..." required></textarea>
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
                <div class="fade-in">
                    <h2 class="ancient-font" style="font-size: 2rem; color: #Cfb997;">{{ $invitation->groom_nickname }}
                        & {{ $invitation->bride_nickname }}</h2>
                    <div class="divider-gunungan" style="margin: 15px 0;">
                        <div class="divider-line" style="background: rgba(255,255,255,0.3);"></div>
                        <svg class="gunungan-icon" style="fill: #Cfb997; padding:0 5px;" viewBox="0 0 50 100">
                            <path
                                d="M25 100 Q 0 50, 25 0 Q 50 50, 25 100 M25 20 C 10 20, 5 40, 15 60 C 10 50, 0 60, 10 80 M25 20 C 40 20, 45 40, 35 60 C 40 50, 50 60, 40 80" />
                        </svg>
                    </div>
                    <p style="font-size: 0.85rem;">Terima kasih atas doa restu Bapak/Ibu/Saudara/i.</p>
                    <br>
                    <small style="opacity: 0.5;">&copy; {{ date('Y') }} Undangan Pernikahan Adat</small>
                </div>
            </footer>
        </div>

        <!-- Toast -->
        <div id="toast">Nomor rekening berhasil disalin!</div>
    </div>

    <!-- Audio Element -->
    <audio id="bgMusic" loop>
        <source
            src="{{ $invitation->musicPreset ? asset('storage/' . $invitation->musicPreset->audio_url) : 'https://www.bensound.com/bensound-music/bensound-romantic.mp3' }}"
            type="audio/mpeg">
    </audio>

    <script>
        // --- 1. Countdown Logic ---
        const weddingDate = new Date("{{ $invitation->wedding_date }}").getTime();
        const timerInterval = setInterval(function () {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (distance < 0) {
                clearInterval(timerInterval);
                document.getElementById("timer").innerHTML = "<h3>Acara Dimulai</h3>";
                return;
            }
            document.getElementById("days").innerText = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById("hours").innerText = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById("minutes").innerText = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById("seconds").innerText = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }, 1000);

        // --- 2. Scroll Animation ---
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.15 });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // --- 3. Music Control ---
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');
        const musicIcon = document.getElementById('musicIcon');
        let hasInteracted = false;

        function playMusic() {
            bgMusic.play().catch(() => { });
            musicIcon.classList.replace('ti-player-play', 'ti-player-pause');
            musicBtn.classList.add('playing');
        }
        function pauseMusic() {
            bgMusic.pause();
            musicIcon.classList.replace('ti-player-pause', 'ti-player-play');
            musicBtn.classList.remove('playing');
        }
        window.addEventListener('scroll', () => { if (!hasInteracted) { playMusic(); hasInteracted = true; } }, { once: true });
        musicBtn.onclick = () => { if (bgMusic.paused) playMusic(); else pauseMusic(); };

        // --- 4. RSVP Logic ---
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
            const btn = document.getElementById('rsvpButton');
            btn.disabled = true; btn.innerText = "Mengirim...";
            fetch(`/invitation/${invId}/rsvp`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
            }).then(() => { e.target.reset(); loadRSVPs(); }).finally(() => { btn.disabled = false; btn.innerText = "Kirim Ucapan"; });
        };
        loadRSVPs();

        // --- 5. Clipboard ---
        window.copyToClipboard = (text) => {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('toast');
                toast.className = 'show';
                setTimeout(() => { toast.className = ''; }, 3000);
            });
        };

        // --- 6. Live Preview Sync ---
        window.addEventListener('message', function (event) {
            if (event.data.type === 'syncImages') {
                const imgs = event.data.images;
                if (imgs.pria) {
                    const el = document.getElementById('preview-foto-pria');
                    if (el) el.src = imgs.pria;
                }
                if (imgs.wanita) {
                    const el = document.getElementById('preview-foto-wanita');
                    if (el) el.src = imgs.wanita;
                }
                if (imgs.cover) {
                    const el = document.getElementById('preview-hero-bg');
                    if (el) el.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.5)), url('${imgs.cover}')`;
                }
                if (imgs.gallery && imgs.gallery.length > 0) {
                    const galleryContainer = document.getElementById('gallery-container');
                    if (galleryContainer) {
                        galleryContainer.innerHTML = imgs.gallery.map(src => `
                            <a href="${src}" data-fancybox="gallery" class="masonry-item">
                                <img src="${src}" alt="Gallery">
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
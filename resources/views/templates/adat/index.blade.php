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
    <meta property="og:description" content="You are invited to the wedding of {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}.">
    <meta property="og:image" content="{{ asset('storage/' . $invitation->gallery_cover) }}">

    <!-- Google Fonts: Cinzel (Ukiran) & Cormorant (Elegan) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        :root {
            /* Palet Warna Adat Jawa (Sogan & Emas) */
            --primary-color: #4A1018;   /* Marun Sogan Tua */
            --accent-color: #C4A668;    /* Emas Kuning Tua */
            --secondary-color: #8B5E3C; /* Coklat Kayu */
            --bg-color: #FBF7F0;        /* Krem Kertas Tua */
            --text-dark: #2C1810;
            --text-gold: #A67C00;
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Cormorant Garamond', serif;
            background-color: #e0dcd5;
            background-image: 
                radial-gradient(var(--accent-color) 15%, transparent 16%), 
                radial-gradient(var(--accent-color) 15%, transparent 16%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar { display: none; }

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
            
           
        }

        h1, h2, h3, .ancient-font {
            font-family: 'Cinzel', serif;
            color: var(--primary-color);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .text-center { text-align: center; }

        .section-padding {
            padding: 70px 25px;
            position: relative;
        }

        .mb-5 { margin-bottom: 50px; }

        /* Ornamen Pemisah Batik */
        .batik-divider {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px 0;
            position: relative;
        }
        .batik-line {
            height: 2px;
            width: 100%;
            background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        }
        .batik-icon {
            width: 50px;
            height: 50px;
            fill: var(--primary-color);
            background: var(--bg-color);
            padding: 0 10px;
            z-index: 1;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(74, 16, 24, 0.85), rgba(74, 16, 24, 0.6)), url('{{ asset('storage/' . $invitation->gallery_cover) }}');
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

        .hero-ornament {
            width: 120px;
            margin-bottom: 20px;
            stroke: var(--accent-color);
            fill: none;
            stroke-width: 1.5;
            opacity: 0.9;
        }

        .hero h1 {
            font-size: 2.5rem;
            color: var(--accent-color);
            line-height: 1.3;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-bottom: 10px;
        }

        .hero-sub {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-size: 1.3rem;
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

        /* Quote Section */
        .quote-section {
            background-color: var(--white);
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            color: var(--secondary-color);
            border-bottom: 1px solid var(--accent-color);
        }
        .quote-section h3 { font-size: 1.8rem; margin-bottom: 20px; }
        .quote-section p { font-size: 1.2rem; line-height: 1.8; }

        /* Couple Section */
        .couple-wrapper {
            display: flex;
            flex-direction: column;
            gap: 60px;
        }
        .couple-card { text-align: center; }

        /* Bingkai Foto Gaya Ukiran Jawa */
        .photo-frame-javanese {
            position: relative;
            display: inline-block;
            padding: 15px;
            background: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 2px solid var(--accent-color);
        }
        /* Ornamen Sudut (Tumpal) */
        .photo-frame-javanese::before, .photo-frame-javanese::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            border: 3px double var(--primary-color);
            background: var(--bg-color);
        }
        .photo-frame-javanese::before { top: -12px; left: -12px; }
        .photo-frame-javanese::after { bottom: -12px; right: -12px; }

        .couple-img {
            width: 220px;
            height: 270px;
            object-fit: cover;
            filter: sepia(20%) contrast(90%);
            display: block;
        }

        .couple-name { font-size: 2rem; margin-top: 25px; margin-bottom: 5px; }
        .parent-name { font-size: 1rem; color: var(--secondary-color); }

        .connector-symbol {
            font-size: 3rem;
            color: var(--accent-color);
            font-family: 'Cinzel', serif;
            margin-top: -40px;
        }

        /* Event Card */
        .event-card {
            border: 1px solid var(--accent-color);
            padding: 35px 20px;
            text-align: center;
            margin-bottom: 30px;
            background: white;
            position: relative;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .event-card::before {
            content: '';
            position: absolute;
            top: 5px; left: 5px; right: 5px; bottom: 5px;
            border: 1px solid var(--primary-color);
            pointer-events: none;
        }
        .event-title { font-size: 1.5rem; color: var(--primary-color); margin-bottom: 15px; }
        .event-time { font-size: 1.2rem; font-weight: bold; color: var(--text-gold); margin-bottom: 15px; display: block; }
        
        .btn-map {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 25px;
            background-color: var(--primary-color);
            color: var(--accent-color);
            text-decoration: none;
            font-family: 'Cinzel', serif;
            font-size: 0.8rem;
            letter-spacing: 1px;
            border: 1px solid var(--primary-color);
            transition: all 0.3s;
        }
        .btn-map:hover { background: transparent; color: var(--primary-color); }

        /* Countdown */
        .countdown-section {
            background-color: var(--primary-color);
            color: var(--accent-color);
            text-align: center;
            padding: 60px 20px;
            background-image: repeating-linear-gradient(45deg, rgba(0, 0, 0, 0.05) 0px, rgba(0, 0, 0, 0.05) 10px, transparent 10px, transparent 20px);
        }
        .countdown-timer { display: flex; justify-content: center; gap: 15px; margin-top: 30px; }
        .timer-box {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px 10px;
            border: 1px solid var(--accent-color);
            min-width: 65px;
        }
        .timer-val { font-family: 'Cinzel', serif; font-size: 1.8rem; display: block; }
        .timer-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; }

        /* Gallery */
        .masonry-gallery { column-count: 2; column-gap: 15px; }
        .masonry-item { width: 100%; margin-bottom: 15px; display: block; border-radius: 4px; overflow: hidden; border: 3px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .masonry-item img { width: 100%; display: block; filter: sepia(20%); transition: 0.3s; }
        .masonry-item:hover img { filter: sepia(0%); transform: scale(1.05); }

        /* Gift */
        .gift-card {
            background: white;
            padding: 25px;
            border: 1px solid var(--accent-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            text-align: center;
            position: relative;
        }

        /* RSVP */
        .rsvp-form {
            background: white;
            padding: 30px;
            border: 1px solid var(--accent-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .form-control {
            width: 100%;
            padding: 12px 5px;
            margin-bottom: 20px;
            border: none;
            border-bottom: 1px solid var(--primary-color);
            background: transparent;
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            color: var(--text-dark);
        }
        .form-control:focus { outline: none; border-bottom: 2px solid var(--accent-color); }
        
        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-color);
            color: var(--accent-color);
            border: none;
            font-family: 'Cinzel', serif;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-submit:hover { background-color: var(--secondary-color); }

        .rsvp-list { max-height: 500px; overflow-y: auto; padding-right: 10px; margin-top: 30px; }
        .rsvp-list::-webkit-scrollbar { width: 4px; }
        .rsvp-list::-webkit-scrollbar-thumb { background: var(--accent-color); border-radius: 4px; }
        
        .comment-item {
            background: #FBF7F0;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            animation: slideIn 0.5s ease-out;
        }
        .comment-item h5 { font-family: 'Cinzel', serif; font-size: 1rem; color: var(--primary-color); margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center; }
        .comment-item p { font-size: 1rem; color: #555; line-height: 1.5; font-family: 'Cormorant Garamond', serif; }
        .badge-hadir { font-size: 0.7rem; background: var(--accent-color); color: var(--primary-color); padding: 2px 8px; border-radius: 10px; font-family: 'Lato', sans-serif; }
        .badge-tidak { font-size: 0.7rem; background: #ccc; color: #333; padding: 2px 8px; border-radius: 10px; font-family: 'Lato', sans-serif; }

        footer {
            background-color: var(--primary-color);
            color: var(--accent-color);
            padding: 60px 20px;
            text-align: center;
        }

        .fade-in { opacity: 0; transform: translateY(30px); transition: all 1s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        @keyframes bounce { 0%,20%,50%,80%,100% {transform: translateY(0);} 40% {transform: translateY(-15px);} 60% {transform: translateY(-7px);} }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        @keyframes slideIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

        #toast {
            visibility: hidden; min-width: 200px; background-color: var(--primary-color); color: var(--accent-color);
            text-align: center; padding: 16px; position: fixed; z-index: 99; left: 50%; bottom: 30px;
            transform: translateX(-50%); font-family: 'Cinzel', serif; border: 1px solid var(--accent-color);
        }
        #toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 2.5s; }
        @keyframes fadein { from {bottom: 0; opacity: 0;} to {bottom: 30px; opacity: 1;} }
        @keyframes fadeout { from {bottom: 30px; opacity: 1;} to {bottom: 0; opacity: 0;} }

        /* Desktop Layout */
        @media (min-width: 1024px) {
            body { height: 100vh; overflow: hidden; display: flex; align-items: center; justify-content: center; }
            .mobile-container { max-width: 1000px !important; flex-direction: row !important; display: flex !important; height: 90vh; border-radius: 0; overflow: hidden; }
            .hero { flex: 1.2; height: 100% !important; background-attachment: scroll; }
            .content-wrapper { flex: 1; height: 100%; overflow-y: auto; background: var(--bg-color); scrollbar-width: thin; scrollbar-color: var(--primary-color) transparent; }
            .content-wrapper::-webkit-scrollbar { width: 5px; }
            .content-wrapper::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 10px; }
            .section-padding { padding: 70px 40px; }
            .hero h1 { font-size: 3.5rem; }
        }
    </style>
</head>

<body>

    <div class="mobile-container">

        <!-- Hero -->
        <header id="preview-hero-bg" class="hero">
            <!-- Ornamen Bunga Melati SVG -->
            <svg class="hero-ornament fade-in" viewBox="0 0 100 50">
                <path d="M50 50 C 30 30, 10 30, 0 50 M50 50 C 70 30, 90 30, 100 50 M50 0 V 50 M40 20 Q 50 10 60 20" />
                <circle cx="50" cy="10" r="3" fill="currentColor" stroke="none" />
            </svg>

            <p class="fade-in" style="font-family: 'Cinzel', serif; font-size: 0.9rem; letter-spacing: 3px;">The Wedding Of</p>
            <h1 class="fade-in" style="margin-top: 15px;">
                {{ $invitation->groom_nickname }}<br>&<br>{{ $invitation->bride_nickname }}</h1>

            <div class="hero-sub fade-in">
                Kepada Yth. Bapak/Ibu/Saudara/i<br>
                <span style="font-weight: 700; font-size: 1.3rem; display: inline-block; margin-top: 5px; color: white;">{{ request('penerima') ?? 'Tamu Undangan' }}</span>
            </div>

            <div class="hero-sub fade-in" style="margin-top: 25px; border: none; font-size: 1.1rem;">
                {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}
            </div>

            <div class="scroll-btn" onclick="document.getElementById('quote').scrollIntoView({behavior: 'smooth'})">
                <i class="ti ti-chevron-down"></i>
            </div>
        </header>

        <div class="content-wrapper">
            
            <!-- Quote -->
            <section id="quote" class="section-padding quote-section">
                <div class="fade-in">
                    <h3>Mangayu Bagya</h3>
                    <p>"{!! nl2br(e($invitation->wedding_quote)) !!}"</p>
                </div>
            </section>

            <!-- Pemisah Batik -->
            <div class="batik-divider">
                <div class="batik-line"></div>
                <svg class="batik-icon" viewBox="0 0 50 50">
                    <path d="M25 0 L30 20 L50 25 L30 30 L25 50 L20 30 L0 25 L20 20 Z" fill="currentColor"/>
                </svg>
                <div class="batik-line"></div>
            </div>

            <!-- Mempelai -->
            <section class="section-padding" style="background: var(--bg-color);">
                <div class="couple-wrapper fade-in">
                    <div class="couple-card">
                        <div class="photo-frame-javanese">
                            <img loading="lazy" id="preview-foto-pria" src="{{ asset('storage/' . $invitation->foto_pria) }}" alt="{{ $invitation->groom_name }}" class="couple-img">
                        </div>
                        <h3 class="couple-name">{{ $invitation->groom_name }}</h3>
                        <p class="parent-name">{{ $invitation->groom_child_order_text ? 'Putra ' . $invitation->groom_child_order_text . ' dari' : 'Putra dari' }} Bpk. {{ $invitation->groom_father_name }}<br>& Ibu {{ $invitation->groom_mother_name }}</p>
                    </div>

                    <div class="text-center connector-symbol">&</div>

                    <div class="couple-card">
                        <div class="photo-frame-javanese">
                            <img loading="lazy" id="preview-foto-wanita" src="{{ asset('storage/' . $invitation->foto_wanita) }}" alt="{{ $invitation->bride_name }}" class="couple-img">
                        </div>
                        <h3 class="couple-name">{{ $invitation->bride_name }}</h3>
                        <p class="parent-name">{{ $invitation->bride_child_order_text ? 'Putri ' . $invitation->bride_child_order_text . ' dari' : 'Putri dari' }} Bpk. {{ $invitation->bride_father_name }}<br>& Ibu {{ $invitation->bride_mother_name }}</p>
                    </div>
                </div>
            </section>

            <!-- Acara -->
            <section class="section-padding" style="background-color: #f7f7f7;">
                <div class="text-center mb-5 fade-in">
                    <h2 style="font-size: 2rem;">Rangkaian Acara</h2>
                    <div class="batik-line" style="width: 50px; margin: 15px auto;"></div>
                </div>

                <div class="fade-in">
                    <div class="event-card">
                        <div class="event-title">Akad Nikah</div>
                        <span class="event-time">{{ $invitation->akad_time }} - {{ $invitation->akad_time_end }}</span>
                        <p style="font-size: 1.1rem; color: #555;">
                            {{ $invitation->akad_location }}<br>{{ $invitation->akad_address }}</p>
                        <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-map">Lihat Lokasi</a>
                    </div>

                    <div class="event-card">
                        <div class="event-title">Resepsi</div>
                        <span class="event-time">{{ $invitation->resepsi_time }} - {{ $invitation->resepsi_time_end }}</span>
                        <p style="font-size: 1.1rem; color: #555;">
                            {{ $invitation->resepsi_location }}<br>{{ $invitation->resepsi_address }}</p>
                        <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-map">Lihat Lokasi</a>
                    </div>
                </div>
            </section>

            <!-- Countdown -->
            <section class="countdown-section">
                <div class="fade-in">
                    <h3 style="color: var(--accent-color); font-size: 1.8rem;">Hitung Mundur</h3>
                    <div class="countdown-timer" id="timer">
                        <div class="timer-box"><span class="timer-val" id="days">00</span><span class="timer-label">Hari</span></div>
                        <div class="timer-box"><span class="timer-val" id="hours">00</span><span class="timer-label">Jam</span></div>
                        <div class="timer-box"><span class="timer-val" id="minutes">00</span><span class="timer-label">Menit</span></div>
                        <div class="timer-box"><span class="timer-val" id="seconds">00</span><span class="timer-label">Detik</span></div>
                    </div>
                </div>
            </section>

            <!-- Galeri -->
            <section class="section-padding" style="background-color: var(--white);">
                <div class="text-center mb-5 fade-in">
                    <h2 style="font-size: 2rem;">Dokumentasi</h2>
                    <div class="batik-line" style="width: 50px; margin: 15px auto;"></div>
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

            <!-- Gifts -->
            @if($invitation->enable_gift == 1 && $invitation->gifts->count())
            <section class="section-padding" style="background:#f7f7f7;">
                <div class="text-center mb-5 fade-in">
                    <h2 style="font-size: 2rem;">Wedding Gift</h2>
                    <div class="batik-line" style="width: 50px; margin: 15px auto;"></div>
                </div>
                @foreach($invitation->gifts as $gift)
                    <div class="gift-card fade-in">
                        <h4 class="ancient-font">{{ $gift->bank }}</h4>
                        <p style="font-size: 1.4rem; font-weight: bold; margin: 10px 0; font-family: 'Cinzel', serif;">{{ $gift->number }}</p>
                        <p>A/N: {{ $gift->name }}</p>
                        <button onclick="copyToClipboard('{{ $gift->number }}')" class="btn-map" style="padding: 8px 20px; font-size: 0.8rem; margin-top: 15px;">Salin No. Rekening</button>
                    </div>
                @endforeach
            </section>
            @endif

            <!-- RSVP -->
            @if($invitation->enable_rsvp == 1)
            <section class="section-padding" style="background: var(--bg-color);">
                <div class="text-center mb-5 fade-in">
                    <h2 style="font-size: 2rem;">Ucapan & Doa</h2>
                    <div class="batik-line" style="width: 50px; margin: 15px auto;"></div>
                </div>

                <div class="rsvp-form fade-in">
                    <form id="rsvpForm">
                        @csrf
                        <input type="text" name="name" id="rsvpName" class="form-control" placeholder="Nama Anda" required>
                        <select name="attending" id="rsvpAttending" class="form-control">
                            <option value="1">Hadir</option>
                            <option value="0">Berhalangan</option>
                        </select>
                        
                        <div class="emoji-picker" style="margin-bottom: 15px; display: flex; gap: 15px; justify-content: center;">
                            <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">🎉</button>
                            <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">❤️</button>
                            <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">🥳</button>
                            <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">🙏</button>
                        </div>

                        <textarea name="message" id="rsvpMessage" class="form-control" rows="3" placeholder="Tulis ucapan selamat..." required></textarea>
                        <button type="submit" id="rsvpButton" class="btn-submit">Kirim Ucapan</button>
                    </form>
                </div>

                <div class="fade-in" style="margin-top: 40px;">
                    <div id="rsvpList" class="rsvp-list">
                        <div class="text-center" id="emptyRsvp" style="color: #888; font-style: italic;">Belum ada ucapan. Jadilah yang pertama!</div>
                    </div>
                </div>
            </section>
            @endif

            <!-- Footer -->
            <footer>
                <div class="fade-in">
                    <svg class="hero-ornament" style="margin-bottom: 20px; stroke: var(--accent-color); fill: none; stroke-width: 1.5; width: 80px;" viewBox="0 0 100 50">
                        <path d="M50 50 C 30 30, 10 30, 0 50 M50 50 C 70 30, 90 30, 100 50 M50 0 V 50 M40 20 Q 50 10 60 20" />
                    </svg>
                    <h2 style="font-size: 2rem; color: var(--accent-color);">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
                    <p style="font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; margin-top: 15px; opacity: 0.9;">Matur nuwun ingkang agung ngaturaken pangestu lan kehadiripun.</p>
                    <br>
                    <small style="opacity: 0.5; font-family: 'Lato', sans-serif;">&copy; {{ date('Y') }} Undangan Pernikahan Adat Jawa</small>
                </div>
            </footer>
        </div>

        <div id="toast">Pesan terkirim dengan sukses.</div>
    </div>

    <x-music-player :invitation="$invitation" />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Countdown
            const weddingDate = new Date("{{ $invitation->wedding_date }}").getTime();
            const timerInterval = setInterval(() => {
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

            // 2. Scroll Animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
            }, { threshold: 0.1 });
            document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

            // 4. RSVP Logic (Terbaru di Atas)
            const invId = "{{ $invitation->id }}";
            const rsvpListEl = document.getElementById('rsvpList');
            const form = document.getElementById('rsvpForm');
            const rsvpButton = document.getElementById('rsvpButton');
            let loadedRsvpIds = new Set();

            function createRsvpHtml(r) {
                const badgeClass = r.attending == 1 ? 'badge-hadir' : 'badge-tidak';
                const badgeText = r.attending == 1 ? 'Hadir' : 'Tidak Hadir';
                return `
                    <div class="comment-item" data-id="${r.id}">
                        <h5>${r.name} <span class="${badgeClass}">${badgeText}</span></h5>
                        <p>${r.message}</p>
                    </div>
                `;
            }

            function loadRSVPs() {
                fetch(`/invitation/${invId}/rsvps`)
                    .then(res => res.json())
                    .then(data => {
                        if (!data || data.length === 0) {
                            if (loadedRsvpIds.size === 0) {
                                rsvpListEl.innerHTML = `<div class="text-center" id="emptyRsvp" style="color: #888; font-style: italic;">Belum ada ucapan. Jadilah yang pertama!</div>`;
                            }
                            return;
                        }

                        // Sort ID Descending (Terbesar/Terbaru di atas)
                        data.sort((a, b) => b.id - a.id);

                        const emptyMsg = document.getElementById('emptyRsvp');
                        if (emptyMsg) emptyMsg.remove();

                        // Cek reset jika ada data yang dihapus dari DB
                        if (data.length < loadedRsvpIds.size) {
                            rsvpListEl.innerHTML = '';
                            loadedRsvpIds.clear();
                        }

                        // Filter hanya yang belum ditampilkan
                        const newItems = data.filter(rsvp => !loadedRsvpIds.has(rsvp.id));

                        if (newItems.length > 0) {
                            const html = newItems.map(r => createRsvpHtml(r)).join('');
                            // Sisipkan di ATAS (afterbegin)
                            rsvpListEl.insertAdjacentHTML('afterbegin', html);
                            newItems.forEach(item => loadedRsvpIds.add(item.id));
                        }
                    });
            }

            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    rsvpButton.disabled = true;
                    rsvpButton.innerText = "Mengirim...";
                    
                    fetch(`/invitation/${invId}/rsvp`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify(Object.fromEntries(new FormData(e.target)))
                    })
                    .then(res => res.json())
                    .then(() => { 
                        e.target.reset(); 
                        loadRSVPs(); 
                        showToast("Ucapan berhasil dikirim!"); 
                    })
                    .finally(() => { 
                        rsvpButton.disabled = false; 
                        rsvpButton.innerText = "Kirim Ucapan"; 
                    });
                });
            }

            // Polling setiap 10 detik
            loadRSVPs();
            setInterval(loadRSVPs, 10000);

            // 5. Toast & Copy
            window.copyToClipboard = (text) => {
                navigator.clipboard.writeText(text).then(() => showToast("Nomor rekening berhasil disalin!"));
            };

            function showToast(msg) {
                const toast = document.getElementById('toast');
                toast.innerText = msg;
                toast.className = 'show';
                setTimeout(() => { toast.className = ''; }, 3000);
            }

            // 6. Live Preview Sync
            window.addEventListener('message', function (event) {
                if (event.data.type === 'syncImages') {
                    const imgs = event.data.images;
                    if (imgs.pria) { const el = document.getElementById('preview-foto-pria'); if(el) el.src = imgs.pria; }
                    if (imgs.wanita) { const el = document.getElementById('preview-foto-wanita'); if(el) el.src = imgs.wanita; }
                    if (imgs.cover) {
                        const el = document.getElementById('preview-hero-bg');
                        if(el) el.style.backgroundImage = `linear-gradient(rgba(74,16,24,0.85), rgba(74,16,24,0.6)), url('${imgs.cover}')`;
                    }
                    if (imgs.gallery && imgs.gallery.length > 0) {
                        const galleryContainer = document.getElementById('gallery-container');
                        if (galleryContainer) {
                            galleryContainer.innerHTML = imgs.gallery.map(src => `<a href="${src}" data-fancybox="gallery" class="masonry-item"><img loading="lazy" src="${src}" alt="Gallery"></a>`).join('');
                        }
                    }
                }
            });

            window.addEmoji = (emoji) => {
                const textarea = document.getElementById('rsvpMessage');
                textarea.value += emoji;
                textarea.focus();
            };
        });
    </script>
</body>

</html>

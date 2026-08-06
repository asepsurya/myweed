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
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <!-- Libraries: Fancybox & Tabler Icons & jQuery -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        /* --- VARIABLES --- */
        :root {
            --primary-color: #1A3C34;   /* Deep Emerald Green */
            --secondary-color: #C5A059; /* Muted Champagne Gold */
            --text-dark: #2C2C2C;
            --text-muted: #666666;
            --bg-color: #FAF9F6;        /* Off-White / Eggshell */
            --white: #FFFFFF;
            --border-color: rgba(26, 60, 52, 0.1);
            --transition: all 0.3s ease;
        }

        /* --- RESET & BASE STYLES --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #e6e6e6;
            color: var(--text-dark);
            display: flex;
            justify-content: center;
            min-height: 100vh;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        a { text-decoration: none; color: var(--secondary-color); transition: var(--transition); }
        a:hover { color: var(--primary-color); }

        /* --- TYPOGRAPHY --- */
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; color: var(--primary-color); font-weight: 600; }
        .script-font { font-family: 'Playfair Display', serif; font-style: italic; color: var(--secondary-color); }
        .text-center { text-align: center; }

        /* --- LAYOUT: MOBILE CONTAINER --- */
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

        /* --- UTILITY CLASSES --- */
        .section-padding { padding: 80px 30px; position: relative; }
        .hairline { width: 50px; height: 1px; background-color: var(--secondary-color); margin: 15px auto; }
        .mb-4 { margin-bottom: 40px; }
        .mt-4 { margin-top: 1.5rem; }
        .mt-6 { margin-top: 2.5rem; }

        /* Grid & Flex */
        .grid { display: grid; }
        .grid-cols-4 { grid-template-columns: repeat(4, 1fr); }
        .flex { display: flex; }
        .justify-start { justify-content: flex-start; }
        .items-center { align-items: center; }
        .space-y-4 > * + * { margin-top: 1rem; }

        /* UI Elements */
        .rounded { border-radius: 0.375rem; }
        .w-full { width: 100%; }
        .hidden { display: none !important; }
        .bg-white { background-color: white; }
        .border-b { border-bottom: 1px solid rgba(255, 255, 255, 0.5); }
        .border { border: 1px solid #ddd; }

        /* --- COMPONENTS --- */

        /* Hero */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)),
                        url('https://picsum.photos/seed/wedding/800/1200'); /* Placeholder jika PHP gagal */
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
        .hero h1 { font-size: 3.2rem; color: var(--white); line-height: 1.2; margin-bottom: 5px; letter-spacing: -0.5px; }
        .hero-subtitle { font-size: 0.9rem; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 20px; opacity: 0.9; }
        .hero-date { font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.4rem; margin-top: 15px; border: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 30px; display: inline-block; }

        /* Scroll Indicator */
        .scroll-indicator {
            position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%);
            display: flex; flex-direction: column; align-items: center; gap: 8px;
            color: white; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px;
            animation: bounce 3s infinite; opacity: 0.7; cursor: pointer;
        }

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

        .btn-outline:hover {
            background-color:#1A3C34;
            color: var(--white);
        }

        .reminder-btn {
            display: inline-flex; align-items: center; gap: 8px; margin-top: 15px;
            padding: 10px 24px; font-size: 14px; color: #2b2b2b;
            background: rgba(255, 255, 255, 0.8); border: 1px solid rgba(0,0,0,0.1);
            border-radius: 50px; backdrop-filter: blur(5px); cursor: pointer;
            transition: var(--transition); box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .reminder-btn:hover { background: #fff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.1); }

        /* Couple */
        .couple-wrapper { display: flex; flex-direction: column; gap: 50px; }
        .couple-card { text-align: center; }
        .img-frame { position: relative; display: inline-block; margin-bottom: 20px; padding: 10px; border: 1px solid var(--secondary-color); }
        .couple-img { width: 180px; height: 220px; object-fit: cover; filter: grayscale(20%) sepia(10%); }
        .couple-name { font-size: 2rem; color: var(--primary-color); margin-bottom: 5px; }
        .parent-name { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; margin-bottom: 10px;}
        .ampersand { font-size: 3rem; color: var(--secondary-color); font-style: italic; margin: -30px 0 20px; font-family: 'Playfair Display', serif; }

        /* Event */
        .event-card { padding: 40px 20px; border: 1px solid var(--border-color); text-align: center; margin-bottom: 30px; transition: var(--transition); }
        .event-card:hover { border-color: var(--secondary-color); transform: translateY(-5px); }
        .event-title { font-size: 1.2rem; text-transform: uppercase; letter-spacing: 3px; color: var(--primary-color); margin-bottom: 15px; }
        .event-time { font-size: 1.8rem; color: var(--secondary-color); font-family: 'Playfair Display', serif; }

        /* Countdown */
        .countdown-section { background-color: var(--primary-color); color: var(--white); text-align: center; }
        .countdown-section h2, .countdown-section p { color: var(--white) !important; }
        .countdown-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 40px; }
        .timer-val { font-family: 'Playfair Display', serif; font-size: 2.5rem; line-height: 1; margin-bottom: 5px; }
        .timer-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7; }

        /* Love Story (Timeline) */
        #love-story { background: linear-gradient(to bottom, #ffffff, #f5f5f5); padding: 60px 20px; }
        .timeline { position: relative; max-width: 400px; margin: 0 auto; }
        .timeline::before { /* Garis Vertikal */
            content: ""; position: absolute; left: 20px; top: 0; bottom: 0; width: 2px; background: #e5e7eb;
        }
        .timeline-item { position: relative; padding-left: 50px; margin-bottom: 30px; }
        .timeline-item::before { /* Dots */
            content: ""; position: absolute; left: 14px; top: 5px; width: 14px; height: 14px;
            background: var(--secondary-color); border-radius: 50%; border: 3px solid #fff; box-shadow: 0 0 0 2px var(--secondary-color);
        }
        .timeline-item h5 { color: var(--primary-color); font-size: 1.2rem; margin-bottom: 5px; font-family: 'Playfair Display', serif; }
        .timeline-content img { border-radius: 8px; margin-top: 10px; max-height: 150px; object-fit: cover; }

        /* Gallery */
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


        /* Gifts */


        /* RSVP */
        .rsvp-form { background: var(--white); padding: 40px 30px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); border-radius: 8px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-control {
            width: 100%; border: 1px solid #ddd; border-radius: 5px; padding: 12px;
            font-family: 'Lato', sans-serif; font-size: 1rem; background: #fff; color: var(--text-dark);
            transition: border-color 0.3s;
        }
        .form-control:focus { outline: none; border-color: var(--secondary-color); }
        .rsvp-list-item { display: flex; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px; align-items: flex-start; }
        .avatar-placeholder { width: 35px; height: 35px; background: #ddd; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; }

        /* Music Control */
        .music-control {
            position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px;
            background-color: var(--primary-color); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); z-index: 9999;
            border: 2px solid white; color: white; font-size: 24px;
            transition: transform 0.3s;
        }
        .music-control.playing { animation: spin 4s linear infinite; }

        /* Footer */
        footer { background-color: var(--primary-color); color: var(--white); padding: 60px 20px; text-align: center; }

        /* --- ANIMATIONS --- */
        .fade-in { opacity: 0; transform: translateY(30px); transition: opacity 1s ease-out, transform 1s ease-out; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translate(-50%, 0); }
            40% { transform: translate(-50%, -10px); }
            60% { transform: translate(-50%, -5px); }
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        /* Toast Notification */
        #toast {
            visibility: hidden; min-width: 250px; background-color: #333; color: #fff;
            text-align: center; padding: 16px; position: fixed; z-index: 100;
            left: 50%; bottom: 30px; transform: translateX(-50%);
            font-size: 14px; border-radius: 4px; opacity: 0; transition: opacity 0.5s, bottom 0.5s;
        }
        #toast.show { visibility: visible; opacity: 1; bottom: 50px; }

        /* Spinner */
        .animate-spin { animation: spin 1s linear infinite; }
         /* --- SECTION: QUOTES (Rapi & Center) --- */
        .quote-section {
            padding: 100px 30px;
            text-align: center;
            background: var(--white);
            position: relative;
        }
        .quote-icon {
            font-size: 4rem;
            color: var(--secondary-color);
            opacity: 0.2;
            font-family: 'Playfair Display', serif;
            display: block;
            margin-bottom: -30px;
            line-height: 1;
        }
        .quote-content {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            line-height: 1.8;
            color: var(--text-dark);
            max-width: 90%; /* Membatasi lebar biar rapi */
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

 /* --- SECTION: RSVP (Rapi & Chat Style) --- */
        .rsvp-section { padding: 80px 20px; background: var(--white); }
        .rsvp-list {
            max-height: 400px; overflow-y: auto;
            padding-right: 5px; /* Space for scrollbar */
            margin-top: 30px;
        }
        /* Custom Scrollbar */
        .rsvp-list::-webkit-scrollbar { width: 4px; }
        .rsvp-list::-webkit-scrollbar-thumb { background-color: #ddd; border-radius: 4px; }

        .comment-item {
            display: flex; gap: 15px;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            animation: slideIn 0.5s ease-out;
        }
        .comment-avatar {
            width: 40px; height: 40px;
            border-radius: 50%; background: #ddd;
            flex-shrink: 0; overflow: hidden;
        }
        .comment-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .comment-content h5 { font-size: 0.95rem; color: var(--primary-color); margin-bottom: 4px; font-family: 'Playfair Display', serif; font-weight: 600; }
        .comment-content p { font-size: 0.85rem; color: #555; line-height: 1.5; word-wrap: break-word; }
        .status-badge {
            font-size: 0.7rem; padding: 2px 8px; border-radius: 4px;
            display: inline-block; margin-top: 5px;
        }
        .status-hadir { background: #dcfce7; color: #166534; } /* Green */
        .status-tidak { background: #fee2e2; color: #991b1b; } /* Red */
           #gifts .card {
            border-radius: 16px;
            transition: all 0.3s ease;
            background:white;
        }

        #gifts .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .gift-card {
            margin: 10px;
            position: relative;
            background: #dddddd;
            border-radius: 16px;
            padding: 50px;
            min-height: 140px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .gift-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: linear-gradient(135deg, #f3f3f3 25%, transparent 25%),
                linear-gradient(225deg, #f3f3f3 25%, transparent 25%);
            opacity: 0.4;
        }

        .gift-logo {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .gift-logo img {
            height: 30px;
        }

        .gift-content {
            position: relative;
            z-index: 2;
            padding: 10px;
        }

        .gift-name {
            font-weight: 600;
            letter-spacing: 1px;
            color: #7a5a2f;
        }

        .gift-number {
            font-size: 18px;
            font-weight: 500;
            color: #444;
        }

        .gift-copy {
            position: absolute;
            bottom: 20px;
            right: 20px;
            border: none;
            background: transparent;
            color: #7a5a2f;
            font-size: 14px;
            cursor: pointer;
        }
         .timeline-line { position: absolute; left: 20px; top: 0; bottom: 0; width: 1px; background: var(--secondary-color); opacity: 0.3; }
        .timeline-item { padding-left: 50px; margin-bottom: 40px; position: relative; }
        .timeline-dot {
            position: absolute; left: 14px; top: 0; width: 14px; height: 14px;
            background: var(--bg-color); border: 2px solid var(--secondary-color); border-radius: 50%;
        }
        .story-year { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--secondary-color); margin-bottom: 5px; display: block; }

        /* --- Desktop Layout (Split Screen) --- */
        @media (min-width: 1024px) {
            body {
                background: #f0f0f0;
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
                border: 1px solid rgba(0,0,0,0.1);
            }
            .hero {
                flex: 1.2;
                height: 100% !important;
            }
            .content-wrapper {
                flex: 1;
                height: 100%;
                overflow-y: auto;
                background: var(--bg-color);
                scrollbar-width: thin;
                scrollbar-color: var(--primary-color) transparent;
            }
            .content-wrapper::-webkit-scrollbar { width: 5px; }
            .content-wrapper::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 10px; }
            
            /* Adjustments for desktop */
            .section-padding { padding: 80px 40px; }
            .hero h1 { font-size: 4rem; }
        }

    </style>
</head>
<body>

    <!-- Audio Control -->
    <div id="musicBtn" class="music-control">
        <i class="ti ti-player-play" id="musicIcon"></i>
    </div>

    <!-- Main Container -->
    <div class="mobile-container">

        <!-- Hero Section -->
        <header id="preview-hero-bg" class="hero" style="background-image: linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)), url('{{ asset('storage/' . $invitation->gallery_cover) }}');">
            <div class="fade-in">
                <div class="hero-subtitle">The Wedding Of</div>
                <h1>{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>

                <p class="text-sm">
                    Kepada Yth<br>
                    <span class="border-b px-2 py-1 inline-block mt-2">Bapak / Ibu / Saudara</span>
                </p>
                <p class="mt-4">{{ request('to') ?? 'Tamu Undangan' }}</p>

                <div class="hero-date">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</div>

                <button id="reminderBtn" class="reminder-btn">
                    <i class="ti ti-calendar-event"></i>
                    <span>Setel Pengingat</span>
                </button>
            </div>

            <div class="scroll-indicator" onclick="document.getElementById('quote').scrollIntoView({behavior: 'smooth'})">
                <span>Scroll</span>
                <div style="width:1px; height:30px; background:rgba(255,255,255,0.5);"></div>
            </div>
        </header>

        <div class="content-wrapper">
            <!-- Quote Section -->
            <section id="quote" class="section-padding quote-section">
            <div class="fade-in">
                <p class="serif-font" style="font-size: 1.2rem; color: var(--primary-color); margin-bottom: 20px;">Quotes</p>
              <p style="font-size: 1rem; line-height: 1.8;">
                    {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote))) !!}
                </p>


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
                        <img id="preview-foto-pria" src="{{ asset('storage/' . $invitation->foto_pria) }}" alt="{{ $invitation->groom_name }}" class="couple-img" loading="lazy">
                    </div>
                    <h3 class="couple-name">{{ $invitation->groom_name }}</h3>
                    <p class="parent-name">Putra dari Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}</p>
                    <a href="{{ $invitation->groom_instagram }}" target="_blank" style="color: var(--text-muted); font-size: 0.9rem;margin-top:10px;">
                        <i class="ti ti-brand-instagram"></i> Instagram
                    </a>
                </div>

                <div class="text-center ampersand">&</div>

                <!-- Bride -->
                <div class="couple-card">
                    <div class="img-frame">
                        <img id="preview-foto-wanita" src="{{ asset('storage/' . $invitation->foto_wanita) }}" alt="{{ $invitation->bride_name }}" class="couple-img" loading="lazy">
                    </div>
                    <h3 class="couple-name">{{ $invitation->bride_name }}</h3>
                    <p class="parent-name">Putri dari Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}</p>
                    <a href="{{ $invitation->bride_instagram }}" target="_blank" style="color: var(--text-muted); font-size: 0.9rem;margin-top:10px;">
                        <i class="ti ti-brand-instagram"></i> Instagram
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
                    <div class="event-time">{{ $invitation->akad_time }} - {{ $invitation->akad_time_end }}</div>
                    <p style="color: var(--text-muted); margin-top: 10px;"><b>{{ $invitation->akad_location }}</b></p>
                    <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;">{{ $invitation->akad_address }}</p>
                    <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                </div>

                <!-- Resepsi -->
                <div class="event-card">
                    <div class="event-title">Wedding Reception</div>
                    <div class="event-time">{{ $invitation->resepsi_time }} - {{ $invitation->resepsi_time_end }}</div>
                    <p style="color: var(--text-muted); margin-top: 10px;"><b>{{ $invitation->resepsi_location }}</b></p>
                    <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;">{{ $invitation->resepsi_address }}</p>
                    <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="section-padding countdown-section">
            <div class="fade-in">
                <p class="hero-subtitle" style="color: var(--white); opacity: 0.8;">Counting Down</p>
                <h2 class="serif-font" style="color: var(--white);">Menuju Bahagia</h2>

                <div class="countdown-grid" id="countdown">
                    <div class="text-center"><p id="days" class="timer-val">00</p><p class="timer-label">Hari</p></div>
                    <div class="text-center"><p id="hours" class="timer-val">00</p><p class="timer-label">Jam</p></div>
                    <div class="text-center"><p id="minutes" class="timer-val">00</p><p class="timer-label">Menit</p></div>
                    <div class="text-center"><p id="seconds" class="timer-val">00</p><p class="timer-label">Detik</p></div>
                </div>
            </div>
        </section>

        <!-- Love Story -->
        @php
            $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
        @endphp

       @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
        <section id="love-story">
            <div class="text-center mb-4">
                <p class="hero-subtitle" style="color: var(--text-muted);">Kisah Kami</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Love Story</h2>
            </div>

            <div class="timeline">
                @foreach($loveStories as $story)
                <div class="timeline-item fade-in">
                    <h5 >{{ $story['title'] }}</h5>
                    <div class="timeline-content" style="font-size: 0.80rem; line-height: 1.8;">
                        <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;font-family:Arial, Helvetica, sans-serif">{{ $story['story'] }}</p>
                        @if($story['photo'])
                            <img src="{{ asset('storage/' . $story['photo']) }}" alt="Story Photo" loading="lazy">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Gallery (Masonry) -->
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Moments</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Galeri</h2>
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
        <section id="gifts" style="background-color: #f7f7f7; padding: 50px 20px;">
            <div class="text-center mb-4">
                <p class="hero-subtitle" style="color: var(--text-muted);">Beri Hadiah</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Wedding Gifts</h2>

            </div>

            <div class="grid" style="gap: 20px;">
                @foreach($invitation->gifts as $gift)
                <div class="gift-card">
                    @php
                        $bankLogos = [
                            'BCA' => 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg',
                            'BNI' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f0/Bank_Negara_Indonesia_logo_%282004%29.svg/640px-Bank_Negara_Indonesia_logo_%282004%29.svg.png',
                            'BRI' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/640px-BANK_BRI_logo.svg.png',
                            'Mandiri' => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg',
                            'CIMB' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/CIMB_Group_Logo.svg/640px-CIMB_Group_Logo.svg.png',
                            'OVO' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/640px-Logo_ovo_purple.svg.png',
                            'GoPay' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/640px-Gopay_logo.svg.png',
                            'Dana' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/960px-Logo_dana_blue.svg.png',
                            'LinkAja' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Link_logo_%282019%29.svg/3840px-Link_logo_%282019%29.svg.png',
                            'ShopeePay' => 'https://images.seeklogo.com/logo-png/40/2/shopee-pay-logo-png_seeklogo-406839.png',
                        ];
                    @endphp

                    <div class="gift-logo">
                        @if(!empty($bankLogos[$gift->bank]))
                            <img src="{{ $bankLogos[$gift->bank] }}" alt="{{ $gift->bank }}" style="height:30px; object-fit:contain;" loading="lazy">
                        @else
                            <i class="ti ti-wallet fs-1" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>

                    <div class="gift-content">
                        <h5 class="gift-name">{{ strtoupper($gift->name) }}</h5>
                        <p class="gift-number">{{ $gift->number }}</p>
                    </div>

                    <button class="gift-copy" onclick="copyText('{{ $gift->number }}')">
                        <i class="ti ti-copy"></i> Salin
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- RSVP -->
        @if($invitation->enable_rsvp == 1)
        <section id="rsvp" style="padding: 100px 20px; background-color: var(--white);">
            <div class="text-center mb-5 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">RSVP</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Ucapan & Doa</h2>
            </div>
            
            <div class="rsvp-form fade-in" style="max-width: 500px; margin: 0 auto; background: #fff; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); border-radius: 15px;">
                <form id="rsvpForm">
                    @csrf
                    <div style="margin-bottom: 20px;">
                        <input type="text" name="name" class="form-control" placeholder="Nama Anda" style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <select name="attending" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px;">
                            <option value="1">Hadir</option>
                            <option value="0">Tidak Hadir</option>
                        </select>
                    </div>

                    <div class="emoji-picker" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: center;">
                        <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🎉</button>
                        <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">❤️</button>
                        <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🥳</button>
                        <button type="button" onclick="addEmoji('✨')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">✨</button>
                        <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">🙏</button>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <textarea name="message" class="form-control" rows="4" placeholder="Tulis ucapan selamat..." style="width: 100%; padding: 12px; border: 1px solid #eee; border-radius: 8px;" required></textarea>
                    </div>
                    <button type="submit" id="rsvpButton" class="btn-primary" style="width: 100%; padding: 15px; background: var(--primary-color); color: #fff; border: none; border-radius: 8px; cursor: pointer;">Kirim Ucapan</button>
                </form>
            </div>

            <!-- RSVP List -->
            <div class="mt-6 bg-white rounded-lg mx-auto p-4" style="max-width: 414px; border: 1px solid #eee;padding:10px;">
                <h4 class="text-center serif-font text-lg mb-4" style="color: var(--primary-color);">Tinggalkan kami doa terbaik anda untuk momen bahagia kami</h4>
                <div id="rsvpList" class="space-y-4" style="max-height: 400px; overflow-y: auto;padding:10px;">
                    <!-- List loaded via JS -->
                </div>
                <div class="text-center mt-4">
                    <span class="text-xs text-gray-400">({{ $invitation->rsvps->count() }} Ucapan)</span>
                </div>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer>
            <h2 class="serif-font" style="color: var(--white); margin-bottom: 10px;">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
            <div class="hairline" style="background-color: var(--secondary-color); width: 30px;"></div>
            <p style="margin-top: 20px; font-size: 0.9rem; opacity: 0.8;">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
            <br>
            <p style="font-size: 0.7rem; opacity: 0.5;">&copy; {{ date('Y') }} Elegant Wedding Invitation</p>
        </footer>
        </div>

        <!-- Toast -->
        <div id="toast">Pesan terkirim dengan terima kasih.</div>

    </div> <!-- End Mobile Container -->

    <!-- Audio Element -->
    <audio id="bgMusic" loop>
        @if($invitation->music == 0 && $invitation->music)
            <source src="{{ asset('storage/'.$invitation->music) }}" type="audio/mpeg">
        @elseif($invitation->music && $invitation->musicPreset)
            <source src="{{ asset('storage/'.$invitation->musicPreset->audio_url) }}" type="audio/mpeg">
        @else
            <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg">
        @endif
    </audio>

    <!-- JavaScript Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* --- 1. COPY TO CLIPBOARD & TOAST --- */
            function showToast(message) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'show';
                setTimeout(() => { toast.className = toast.className.replace('show', ''); }, 3000);
            }

            window.copyText = function(text) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast("Nomor rekening berhasil disalin!");
                }).catch(err => {
                    console.error('Gagal menyalin', err);
                });
            };

            /* --- 2. MUSIC PLAYER --- */
            const bgMusic = document.getElementById('bgMusic');
            const musicBtn = document.getElementById('musicBtn');
            const musicIcon = document.getElementById('musicIcon');
            let hasInteracted = false;

            // Toggle Icon Helper
            const toggleMusicIcon = (isPlaying) => {
                if(isPlaying) {
                    musicIcon.classList.remove('ti-player-play');
                    musicIcon.classList.add('ti-player-pause');
                    musicBtn.classList.add('playing');
                } else {
                    musicIcon.classList.remove('ti-player-pause');
                    musicIcon.classList.add('ti-player-play');
                    musicBtn.classList.remove('playing');
                }
            };

            // Play on Interaction (Scroll)
            window.addEventListener('scroll', () => {
                if (!hasInteracted && bgMusic.paused) {
                    bgMusic.play().then(() => {
                        toggleMusicIcon(true);
                        hasInteracted = true;
                    }).catch(e => console.log("Autoplay dicegah browser"));
                }
            }, { once: true });

            // Click Handler
            musicBtn.addEventListener('click', () => {
                if (bgMusic.paused) {
                    bgMusic.play();
                    toggleMusicIcon(true);
                } else {
                    bgMusic.pause();
                    toggleMusicIcon(false);
                }
            });
            document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                if (!bgMusic.paused) {
                    bgMusic.pause();
                    toggleMusicIcon(false);
                }
            } else {
                // Saat balik ke tab → play lagi jika user sudah pernah interaksi
                if (hasInteracted) {
                    bgMusic.play().then(() => {
                        toggleMusicIcon(true);
                    }).catch(() => {});
                }
            }
        });

            /* --- 3. COUNTDOWN TIMER --- */
            const weddingDateString = "{{ $invitation->wedding_date }}";
            const weddingDate = new Date(weddingDateString).getTime();
            const countdownEl = document.getElementById('countdown');

            const timerInterval = setInterval(() => {
                const now = new Date().getTime();
                const distance = weddingDate - now;

                if (isNaN(weddingDate)) {
                    clearInterval(timerInterval);
                    return;
                }

                if (distance < 0) {
                    clearInterval(timerInterval);
                    countdownEl.innerHTML = `
                        <div class="text-center" style="grid-column: span 4;">
                            <h3 style="color: var(--white); font-size: 1.5rem; font-family: 'Playfair Display', serif;">Acara Telah Dimulai</h3>
                            <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 10px;">Terima kasih atas doa restu Anda</p>
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

            /* --- 4. RSVP LOGIC --- */
            const invitationId = "{{ $invitation->id }}";
            const form = document.getElementById('rsvpForm');
            const rsvpButton = document.getElementById('rsvpButton');
            const buttonText = document.getElementById('buttonText');
            const buttonSpinner = document.getElementById('buttonSpinner');
            const rsvpListEl = document.getElementById('rsvpList');
            const rsvpMessageEl = document.getElementById('rsvpMessage');

            // Auto-resize textarea
            const textarea = document.getElementById('rsvpMessageInput');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }

            // Render List
            function renderRsvpList(rsvps) {
                if (!rsvps || rsvps.length === 0) {
                    rsvpListEl.innerHTML = `<div class="text-center text-gray-400 py-4 text-sm">Belum ada ucapan. Jadilah yang pertama! 💖</div>`;
                    return;
                }

                rsvpListEl.innerHTML = rsvps.map(rsvp => `
                    <div class="rsvp-list-item comment-item">
                        <div class="avatar-placeholder">
                            <img src="{{ asset('tempelate/user_default.jpg') }}" alt="User" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div>
                            <p class="font-bold text-sm" style="color:var(--primary-color)">${rsvp.name}</p>
                            <p class="text-gray-600 text-xs mt-1" style="line-height:1.4;">${rsvp.message}</p>
                        </div>
                    </div>
                `).join('');
            }

            // Fetch Data
            function updateRsvpList() {
                fetch(`/invitation/${invitationId}/rsvps`)
                    .then(res => res.json())
                    .then(data => renderRsvpList(data))
                    .catch(err => console.error('Gagal memuat RSVP:', err));
            }

            // Submit Data
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Loading State
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
                            showToast("RSVP berhasil dikirim!");
                            updateRsvpList();
                        } else {
                            rsvpMessageEl.innerText = data.message || "Gagal mengirim RSVP.";
                            rsvpMessageEl.classList.remove('hidden', 'text-green-600');
                            rsvpMessageEl.classList.add('text-red-500');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        showToast("Terjadi kesalahan jaringan.");
                    })
                    .finally(() => {
                        rsvpButton.disabled = false;
                        buttonText.innerText = "Kirim Ucapan";
                        buttonSpinner.classList.add('hidden');
                    });
                });
            }

            // Init Polling
            updateRsvpList();
            setInterval(updateRsvpList, 5000); // Polling every 5s

            /* --- 5. SCROLL ANIMATION (OBSERVER) --- */
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

            /* --- 6. REMINDER LOGIC --- */
            const reminderBtn = document.getElementById('reminderBtn');
            if(reminderBtn) {
                reminderBtn.addEventListener("click", async () => {
                    // PERBAIKAN: Typo 'weeding_date' -> 'wedding_date'
                    const weddingTimestamp = new Date("{{ $invitation->wedding_date }}").getTime();
                    const eventName = "Undangan Pernikahan";

                    if (Notification.permission !== "granted") {
                        await Notification.requestPermission();
                    }

                    // Simpan target waktu
                    localStorage.setItem("weddingReminder", weddingTimestamp);
                    reminderBtn.style.display = 'none'; // Sembunyikan tombol setelah diset
                    showToast("Pengingat berhasil disetel! ⏰");
                });
            }

            // Cek reminder setiap 30 detik
            setInterval(() => {
                const reminder = localStorage.getItem("weddingReminder");
                if (!reminder) return;

                const now = Date.now();
                const target = parseInt(reminder);

                // Jika waktu sekarang sudah melewati target, tapi masih dalam hari yang sama (simple check)
                if (now >= target) {
                    if (Notification.permission === "granted") {
                        new Notification("💍 Wedding Reminder", {
                            body: "Hari ini adalah hari pernikahan!",
                            icon: "https://cdn-icons-png.flaticon.com/512/179/179257.png"
                        });
                    }
                    // Hapus agar notifikasi tidak spam
                    localStorage.removeItem("weddingReminder");
                }
            }, 30000);

            /* --- 7. LIVE PREVIEW SYNC --- */
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
                                    <img src="${src}" alt="Gallery Photo">
                                </a>
                            `).join('');
                        }
                    }
                }
            });
        });
        });

        function addEmoji(emoji) {
            const textarea = document.querySelector('textarea[name="message"]');
            textarea.value += emoji;
            textarea.focus();
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->groom_nickname ?? 'Mempelai Pria' }} & {{ $invitation->bride_nickname ?? 'Mempelai Wanita' }} | Wedding Invitation</title>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $invitation->groom_nickname ?? 'Mempelai Pria' }} & {{ $invitation->bride_nickname ?? 'Mempelai Wanita' }} Wedding Invitation">
    <meta property="og:description" content="You are invited to the wedding of {{ $invitation->groom_nickname ?? 'Mempelai Pria' }} & {{ $invitation->bride_nickname ?? 'Mempelai Wanita' }}. Click to see the details.">
    @if(!empty($invitation->gallery_cover))
    <meta property="og:image" content="{{ asset('storage/' . $invitation->gallery_cover) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $invitation->groom_nickname ?? 'Mempelai Pria' }} & {{ $invitation->bride_nickname ?? 'Mempelai Wanita' }} Wedding Invitation">
    <meta property="twitter:description" content="You are invited to the wedding of {{ $invitation->groom_nickname ?? 'Mempelai Pria' }} & {{ $invitation->bride_nickname ?? 'Mempelai Wanita' }}. Click to see the details.">
    @if(!empty($invitation->gallery_cover))
    <meta property="twitter:image" content="{{ asset('storage/' . $invitation->gallery_cover) }}">
    @endif

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
            --primary-color: #1A3C34;
            --secondary-color: #C5A059;
            --text-dark: #2C2C2C;
            --text-muted: #666666;
            --bg-color: #FAF9F6;
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

        body::-webkit-scrollbar { display: none; }

        a { text-decoration: none; color: var(--secondary-color); transition: var(--transition); }
        a:hover { color: var(--primary-color); }

        /* --- TYPOGRAPHY --- */
        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; color: var(--primary-color); font-weight: 600; }
        .script-font { font-family: 'Playfair Display', serif; font-style: italic; color: var(--secondary-color); }
        .text-center { text-align: center; }
        .text-sm { font-size: 0.875rem; }
        .text-muted { color: var(--text-muted); }

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
        .mb-5 { margin-bottom: 50px; }
        .mt-4 { margin-top: 1.5rem; }
        .mt-6 { margin-top: 2.5rem; }

        .grid { display: grid; }
        .flex { display: flex; }
        .justify-start { justify-content: flex-start; }
        .items-center { align-items: center; }
        .space-y-4 > * + * { margin-top: 1rem; }

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
            background-size: cover;
            background-position: center;
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

        .btn-outline:hover { background-color: var(--primary-color); color: var(--white); }

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
        .event-card { padding: 40px 20px; border: 1px solid var(--border-color); text-align: center; margin-bottom: 30px; transition: var(--transition); background: #fff; }
        .event-card:hover { border-color: var(--secondary-color); transform: translateY(-5px); }
        .event-title { font-size: 1.2rem; text-transform: uppercase; letter-spacing: 3px; color: var(--primary-color); margin-bottom: 15px; }
        .event-time { font-size: 1.8rem; color: var(--secondary-color); font-family: 'Playfair Display', serif; }

        /* Countdown */
        .countdown-section { background-color: var(--primary-color); color: var(--white); text-align: center; }
        .countdown-section h2, .countdown-section p { color: var(--white) !important; }
        .countdown-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 40px; }
        .timer-val { font-family: 'Playfair Display', serif; font-size: 2.5rem; line-height: 1; margin-bottom: 5px; }
        .timer-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7; }

        /* Love Story */
        #love-story { background: linear-gradient(to bottom, #ffffff, #f5f5f5); padding: 60px 20px; }
        .timeline { position: relative; max-width: 400px; margin: 0 auto; }
        .timeline::before { content: ""; position: absolute; left: 20px; top: 0; bottom: 0; width: 2px; background: #e5e7eb; }
        .timeline-item { position: relative; padding-left: 50px; margin-bottom: 30px; }
        .timeline-item::before { content: ""; position: absolute; left: 14px; top: 5px; width: 14px; height: 14px; background: var(--secondary-color); border-radius: 50%; border: 3px solid #fff; box-shadow: 0 0 0 2px var(--secondary-color); }
        .timeline-item h5 { color: var(--primary-color); font-size: 1.2rem; margin-bottom: 5px; font-family: 'Playfair Display', serif; }
        .timeline-content img { border-radius: 8px; margin-top: 10px; max-height: 150px; object-fit: cover; }

        /* Gallery */
        .masonry-gallery { column-count: 2; column-gap: 1rem; }
        .masonry-item { width: 100%; margin-bottom: 1rem; border-radius: 0.75rem; display: block; }
        .masonry-item img { width: 100%; display: block; border-radius: 0.75rem; transition: transform 0.3s; }
        .masonry-item img:hover { transform: scale(1.02); }

        /* Gifts */
        #gifts .card { border-radius: 16px; transition: all 0.3s ease; background:white; }
        .gift-card { margin: 10px; position: relative; background: #dddddd; border-radius: 16px; padding: 50px; min-height: 140px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); }
        .gift-card::before { content: ""; position: absolute; inset: 0; background-image: linear-gradient(135deg, #f3f3f3 25%, transparent 25%), linear-gradient(225deg, #f3f3f3 25%, transparent 25%); opacity: 0.4; }
        .gift-logo { position: absolute; top: 20px; right: 20px; }
        .gift-logo img { height: 30px; object-fit: contain; }
        .gift-content { position: relative; z-index: 2; padding: 10px; }
        .gift-name { font-weight: 600; letter-spacing: 1px; color: #7a5a2f; }
        .gift-number { font-size: 18px; font-weight: 500; color: #444; }
        .gift-copy { position: absolute; bottom: 20px; right: 20px; border: none; background: transparent; color: #7a5a2f; font-size: 14px; cursor: pointer; }

        /* RSVP */
        .rsvp-form { background: var(--white); padding: 40px 30px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); border-radius: 8px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-control { width: 100%; border: 1px solid #ddd; border-radius: 5px; padding: 12px; font-family: 'Lato', sans-serif; font-size: 1rem; background: #fff; color: var(--text-dark); transition: border-color 0.3s; }
        .form-control:focus { outline: none; border-color: var(--secondary-color); }
        .rsvp-list-item { display: flex; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px; align-items: flex-start; }
        .avatar-placeholder { width: 35px; height: 35px; background: #ddd; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        
        .quote-section { padding: 100px 30px; text-align: center; background: var(--white); position: relative; }
        .quote-content { font-family: 'Playfair Display', serif; font-size: 1.25rem; line-height: 1.8; color: var(--text-dark); max-width: 90%; margin: 0 auto; position: relative; z-index: 2; }

        .rsvp-list { max-height: 400px; overflow-y: auto; padding-right: 5px; margin-top: 30px; }
        .rsvp-list::-webkit-scrollbar { width: 4px; }
        .rsvp-list::-webkit-scrollbar-thumb { background-color: #ddd; border-radius: 4px; }

        .comment-item { display: flex; gap: 15px; background: #f9f9f9; padding: 15px; border-radius: 12px; margin-bottom: 15px; border: 1px solid #eee; animation: slideIn 0.5s ease-out; }
        .comment-avatar { width: 40px; height: 40px; border-radius: 50%; background: #ddd; flex-shrink: 0; overflow: hidden; }
        .comment-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .comment-content h5 { font-size: 0.95rem; color: var(--primary-color); margin-bottom: 4px; font-family: 'Playfair Display', serif; font-weight: 600; }
        .comment-content p { font-size: 0.85rem; color: #555; line-height: 1.5; word-wrap: break-word; }

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
        @keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        #toast {
            visibility: hidden; min-width: 250px; background-color: #333; color: #fff;
            text-align: center; padding: 16px; position: fixed; z-index: 10000;
            left: 50%; bottom: 30px; transform: translateX(-50%);
            font-size: 14px; border-radius: 4px; opacity: 0; transition: opacity 0.5s, bottom 0.5s;
        }
        #toast.show { visibility: visible; opacity: 1; bottom: 50px; }

        .animate-spin { animation: spin 1s linear infinite; display: inline-block; }

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
            .hero { flex: 1.2; height: 100% !important; }
            .content-wrapper {
                flex: 1; height: 100%; overflow-y: auto; background: var(--bg-color);
                scrollbar-width: thin; scrollbar-color: var(--primary-color) transparent;
            }
            .content-wrapper::-webkit-scrollbar { width: 5px; }
            .content-wrapper::-webkit-scrollbar-thumb { background: var(--primary-color); border-radius: 10px; }
            .section-padding { padding: 80px 40px; }
            .hero h1 { font-size: 4rem; }
        }
    </style>
</head>
<body>

    <!-- Main Container -->
    <div class="mobile-container">

        <!-- Hero Section -->
        <header id="preview-hero-bg" class="hero" style="background-image: linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)), url('{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}');">
            <div class="fade-in">
                <div class="hero-subtitle">The Wedding Of</div>
                <h1>{{ $invitation->groom_nickname ?? 'Mempelai Pria' }} & {{ $invitation->bride_nickname ?? 'Mempelai Wanita' }}</h1>

                <p class="text-sm">
                    Kepada Yth<br>
                    <span class="border-b px-2 py-1 inline-block mt-2">Bapak / Ibu / Saudara</span>
                </p>
                <p class="mt-4">{{ request('penerima') ?? 'Tamu Undangan' }}</p>

                @if(!empty($invitation->wedding_date))
                <div class="hero-date">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</div>
                @endif
<br>
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
                    <p class="quote-content" style="font-size: 1rem; line-height: 1.8;">
                        {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote ?? ''))) !!}
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
                            <img id="preview-foto-pria" src="{{ asset('storage/' . ($invitation->foto_pria ?? 'default/groom.jpg')) }}" alt="{{ $invitation->groom_name ?? 'Groom' }}" class="couple-img" loading="lazy">
                        </div>
                        <h3 class="couple-name">{{ $invitation->groom_name ?? 'Groom Name' }}</h3>
                        <p class="parent-name">Putra dari Bpk. {{ $invitation->groom_father_name ?? '-' }} & Ibu {{ $invitation->groom_mother_name ?? '-' }}</p>
                        @if(!empty($invitation->groom_instagram))
                        <a href="{{ $invitation->groom_instagram }}" target="_blank" style="color: var(--text-muted); font-size: 0.9rem;margin-top:10px;">
                            <i class="ti ti-brand-instagram"></i> Instagram
                        </a>
                        @endif
                    </div>

                    <div class="text-center ampersand">&</div>

                    <!-- Bride -->
                    <div class="couple-card">
                        <div class="img-frame">
                            <img id="preview-foto-wanita" src="{{ asset('storage/' . ($invitation->foto_wanita ?? 'default/bride.jpg')) }}" alt="{{ $invitation->bride_name ?? 'Bride' }}" class="couple-img" loading="lazy">
                        </div>
                        <h3 class="couple-name">{{ $invitation->bride_name ?? 'Bride Name' }}</h3>
                        <p class="parent-name">Putri dari Bpk. {{ $invitation->bride_father_name ?? '-' }} & Ibu {{ $invitation->bride_mother_name ?? '-' }}</p>
                        @if(!empty($invitation->bride_instagram))
                        <a href="{{ $invitation->bride_instagram }}" target="_blank" style="color: var(--text-muted); font-size: 0.9rem;margin-top:10px;">
                            <i class="ti ti-brand-instagram"></i> Instagram
                        </a>
                        @endif
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
                        <div class="event-time">{{ $invitation->akad_time ?? '00:00' }} - {{ $invitation->akad_time_end ?? 'Selesai' }}</div>
                        <p style="color: var(--text-muted); margin-top: 10px;"><b>{{ $invitation->akad_location ?? 'Lokasi Belum Ditentukan' }}</b></p>
                        <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;">{{ $invitation->akad_address ?? '' }}</p>
                        @if(!empty($invitation->akad_maps))
                        <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                        @endif
                    </div>

                    <!-- Resepsi -->
                    <div class="event-card">
                        <div class="event-title">Wedding Reception</div>
                        <div class="event-time">{{ $invitation->resepsi_time ?? '00:00' }} - {{ $invitation->resepsi_time_end ?? 'Selesai' }}</div>
                        <p style="color: var(--text-muted); margin-top: 10px;"><b>{{ $invitation->resepsi_location ?? 'Lokasi Belum Ditentukan' }}</b></p>
                        <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;">{{ $invitation->resepsi_address ?? '' }}</p>
                        @if(!empty($invitation->resepsi_maps))
                        <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Countdown -->
            @if(!empty($invitation->wedding_date))
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
            @endif

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
                        <h5>{{ $story['title'] ?? 'Untitled' }}</h5>
                        <div class="timeline-content" style="font-size: 0.80rem; line-height: 1.8;">
                            <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;font-family:Arial, Helvetica, sans-serif">{{ $story['story'] ?? '' }}</p>
                            @if(!empty($story['photo']))
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
                                <i class="ti ti-wallet" style="font-size: 1.5rem;"></i>
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
                
                <div class="rsvp-form fade-in" style="max-width: 500px; margin: 0 auto;">
                    <form id="rsvpForm">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" id="rsvpName" class="form-control" placeholder="Nama Anda" required>
                        </div>
                        <div class="form-group">
                            <select name="attending" class="form-control">
                                <option value="1">Hadir</option>
                                <option value="0">Tidak Hadir</option>
                            </select>
                        </div>

                        <div class="emoji-picker" style="margin-bottom: 10px; display: flex; gap: 10px; justify-content: center;">
                            <button type="button" onclick="addEmoji('🎉')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">🎉</button>
                            <button type="button" onclick="addEmoji('❤️')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">❤️</button>
                            <button type="button" onclick="addEmoji('🥳')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">🥳</button>
                            <button type="button" onclick="addEmoji('✨')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">✨</button>
                            <button type="button" onclick="addEmoji('🙏')" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">🙏</button>
                        </div>

                        <div class="form-group">
                            <textarea name="message" id="rsvpMessageInput" class="form-control" rows="4" placeholder="Tulis ucapan selamat..." required></textarea>
                        </div>
                        
                        <div id="rsvpMessage" class="text-center text-sm mt-2 hidden"></div>

                        <button type="submit" id="rsvpButton" class="btn-primary" style="width: 100%; padding: 15px; background: var(--primary-color); color: #fff; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <span id="buttonText">Kirim Ucapan</span>
                            <span id="buttonSpinner" class="hidden animate-spin">⏳</span>
                        </button>
                    </form>
                </div>

                <!-- RSVP List -->
                <div class="mt-6 bg-white rounded-lg mx-auto p-4" style="max-width: 500px;">
                    <h4 class="text-center serif-font text-lg mb-4" style="color: var(--primary-color);">Tinggalkan kami doa terbaik anda untuk momen bahagia kami</h4>
                    <div id="rsvpList" class="rsvp-list space-y-4">
                        <!-- List loaded via JS -->
                    </div>
                    <div class="text-center mt-4">
                        <span class="text-xs text-gray-400">(<span id="rsvpCount">{{ $invitation->rsvps->count() }}</span> Ucapan)</span>
                    </div>
                </div>
            </section>
            @endif

            <!-- Footer -->
            <footer>
                <h2 class="serif-font" style="color: var(--white); margin-bottom: 10px;">{{ $invitation->groom_nickname ?? 'Mempelai Pria' }} & {{ $invitation->bride_nickname ?? 'Mempelai Wanita' }}</h2>
                <div class="hairline" style="background-color: var(--secondary-color); width: 30px;"></div>
                <p style="margin-top: 20px; font-size: 0.9rem; opacity: 0.8;">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
                <br>
                <p style="font-size: 0.7rem; opacity: 0.5;">&copy; {{ date('Y') }} Elegant Wedding Invitation</p>
            </footer>
        </div>

        <!-- Toast -->
        <div id="toast">Pesan terkirim dengan terima kasih.</div>

    </div> <!-- End Mobile Container -->

    <x-music-player :invitation="$invitation" />

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

            /* --- 3. COUNTDOWN TIMER --- */
            const weddingDateString = "{{ $invitation->wedding_date ?? '' }}";
            if (weddingDateString) {
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
            }

            /* --- 4. RSVP LOGIC (TANPA KEDIPLAN) --- */
            const invitationId = "{{ $invitation->id }}";
            const form = document.getElementById('rsvpForm');
            const rsvpButton = document.getElementById('rsvpButton');
            const buttonText = document.getElementById('buttonText');
            const buttonSpinner = document.getElementById('buttonSpinner');
            const rsvpListEl = document.getElementById('rsvpList');
            const rsvpMessageEl = document.getElementById('rsvpMessage');
            const rsvpCountEl = document.getElementById('rsvpCount');
            const textarea = document.getElementById('rsvpMessageInput');
            
            // Set untuk menyimpan ID RSVP yang sudah ditampilkan di layar
            let loadedRsvpIds = new Set();

            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }

            // Fungsi untuk membuat 1 element HTML untuk 1 RSVP
            function createRsvpItemHtml(rsvp) {
                return `
                    <div class="rsvp-list-item comment-item" data-id="${rsvp.id}">
                        <div class="avatar-placeholder">
                            <img loading="lazy" src="https://ui-avatars.com/api/?name=${encodeURIComponent(rsvp.name)}&background=random" alt="User" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div>
                            <p class="font-bold text-sm" style="color:var(--primary-color)">${rsvp.name}</p>
                            <p class="text-gray-600 text-xs mt-1" style="line-height:1.4;">${rsvp.message}</p>
                        </div>
                    </div>
                `;
            }

            // Fungsi render hanya menambahkan item yang baru
             function renderRsvpList(rsvps) {
                if (!rsvps || rsvps.length === 0) {
                    // Jika kosong dan layar juga kosong, tampilkan pesan default
                    if (loadedRsvpIds.size === 0) {
                        rsvpListEl.innerHTML = `<div class="text-center text-gray-400 py-4 text-sm" id="emptyRsvp">Belum ada ucapan. Jadilah yang pertama! 💖</div>`;
                    }
                    return;
                }

                // Urutkan array dari ID terbesar (terbaru) ke terkecil (terlama)
                // Asumsi: ID di database auto-increment (makin besar makin baru)
                rsvps.sort((a, b) => b.id - a.id);

                // Update counter jumlah ucapan
                if (rsvpCountEl) rsvpCountEl.innerText = rsvps.length;

                // Hapus pesan kosong jika ada
                const emptyMsg = document.getElementById('emptyRsvp');
                if (emptyMsg) emptyMsg.remove();

                // Cek jika ada data lama yang dihapus dari database (opsional, untuk antisipasi)
                if (rsvps.length < loadedRsvpIds.size) {
                    rsvpListEl.innerHTML = '';
                    loadedRsvpIds.clear();
                }

                // Filter hanya item yang belum ada di layar
                const newItems = rsvps.filter(rsvp => !loadedRsvpIds.has(rsvp.id));

                if (newItems.length > 0) {
                    const newHtml = newItems.map(rsvp => createRsvpItemHtml(rsvp)).join('');
                    
                    // Tambahkan ke bagian ATAS (afterbegin) agar yang terbaru di puncak
                    rsvpListEl.insertAdjacentHTML('afterbegin', newHtml);

                    // Catat ID yang baru ditambahkan agar tidak diduplikat
                    newItems.forEach(item => loadedRsvpIds.add(item.id));
                }
            }

            // Fetch Data RSVP
            function updateRsvpList() {
                fetch(`/invitation/${invitationId}/rsvps`)
                    .then(res => res.json())
                    .then(data => renderRsvpList(data))
                    .catch(err => console.error('Gagal memuat RSVP:', err));
            }

            // Submit Data RSVP
            if (form) {
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
                            if(textarea) textarea.style.height = 'auto';
                            showToast("RSVP berhasil dikirim!");
                            updateRsvpList(); // Langsung ambil data terbaru
                        } else {
                            rsvpMessageEl.innerText = data.message || "Gagal mengirim RSVP.";
                            rsvpMessageEl.classList.remove('hidden');
                            rsvpMessageEl.style.color = 'red';
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
            // Cek RSVP baru setiap 10 detik (tidak akan kedip karena hanya nambah yang baru)
            setInterval(updateRsvpList, 10000); 

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
                    const weddingTimestamp = new Date("{{ $invitation->wedding_date ?? '' }}").getTime();
                    
                    if (!Notification) {
                        showToast("Browser tidak mendukung notifikasi.");
                        return;
                    }

                    if (Notification.permission !== "granted") {
                        await Notification.requestPermission();
                    }

                    localStorage.setItem("weddingReminder", weddingTimestamp);
                    reminderBtn.style.display = 'none'; 
                    showToast("Pengingat berhasil disetel! ⏰");
                });
            }

            setInterval(() => {
                const reminder = localStorage.getItem("weddingReminder");
                if (!reminder) return;

                const now = Date.now();
                const target = parseInt(reminder);

                if (now >= target) {
                    if (Notification.permission === "granted") {
                        new Notification("💍 Wedding Reminder", {
                            body: "Hari ini adalah hari pernikahan!",
                            icon: "https://cdn-icons-png.flaticon.com/512/179/179257.png"
                        });
                    }
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
                                    <img loading="lazy" src="${src}" alt="Gallery Photo">
                                </a>
                            `).join('');
                        }
                    }
                }
            });
        });

        function addEmoji(emoji) {
            const textarea = document.getElementById('rsvpMessageInput');
            if (textarea) {
                textarea.value += emoji;
                textarea.focus();
                textarea.dispatchEvent(new Event('input'));
            }
        }
    </script>
</body>
</html>

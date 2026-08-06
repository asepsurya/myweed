<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

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

        

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #e6e6e6;
            color: var(--text-dark);
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }

        a { text-decoration: none; color: var(--secondary-color); transition: var(--transition); }
        a:hover { color: var(--primary-color); }

        h1, h2, h3, .serif-font { font-family: 'Playfair Display', serif; color: var(--primary-color); font-weight: 600; }
        .script-font { font-family: 'Playfair Display', serif; font-style: italic; color: var(--secondary-color); }
        
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

        /* --- COMPONENTS --- */
        .section-padding { padding: 80px 24px; position: relative; }
        .hairline { width: 50px; height: 1px; background-color: var(--secondary-color); margin: 15px auto; }

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
        .hero-subtitle { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 20px; opacity: 0.9; }
        .hero-date { font-family: 'Playfair Display', serif; font-style: italic; font-size: 1.4rem; margin-top: 15px; border: 1px solid rgba(255, 255, 255, 0.5); padding: 10px 30px; display: inline-block; }

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

        .couple-wrapper { display: flex; flex-direction: column; gap: 50px; }
        .couple-card { text-align: center; }
        .img-frame { position: relative; display: inline-block; margin-bottom: 20px; padding: 10px; border: 1px solid var(--secondary-color); }
        .couple-img { width: 180px; height: 220px; object-fit: cover; filter: grayscale(20%) sepia(10%); }
        .couple-name { font-size: 2rem; color: var(--primary-color); margin-bottom: 5px; }
        .parent-name { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-top: 5px; margin-bottom: 10px;}
        .ampersand { font-size: 3rem; color: var(--secondary-color); font-style: italic; margin: -30px 0 20px; font-family: 'Playfair Display', serif; }

        .event-card { padding: 40px 20px; border: 1px solid var(--border-color); text-align: center; margin-bottom: 30px; transition: var(--transition); background: #fff; }
        .event-card:hover { border-color: var(--secondary-color); transform: translateY(-5px); }
        .event-title { font-size: 1.2rem; text-transform: uppercase; letter-spacing: 3px; color: var(--primary-color); margin-bottom: 15px; }
        .event-time { font-size: 1.8rem; color: var(--secondary-color); font-family: 'Playfair Display', serif; }

        .countdown-section { background-color: var(--primary-color); color: var(--white); text-align: center; }
        .countdown-section h2, .countdown-section p { color: var(--white) !important; }
        .countdown-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-top: 40px; }
        .timer-val { font-family: 'Playfair Display', serif; font-size: 2.5rem; line-height: 1; margin-bottom: 5px; }
        .timer-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; opacity: 0.7; }

        #love-story { background: linear-gradient(to bottom, #ffffff, #f5f5f5); padding: 60px 20px; }
        .timeline { position: relative; max-width: 400px; margin: 0 auto; }
        .timeline::before { content: ""; position: absolute; left: 20px; top: 0; bottom: 0; width: 2px; background: #e5e7eb; }
        .timeline-item { position: relative; padding-left: 50px; margin-bottom: 30px; }
        .timeline-item::before { content: ""; position: absolute; left: 14px; top: 5px; width: 14px; height: 14px; background: var(--secondary-color); border-radius: 50%; border: 3px solid #fff; box-shadow: 0 0 0 2px var(--secondary-color); }
        .timeline-item h5 { color: var(--primary-color); font-size: 1.2rem; margin-bottom: 5px; font-family: 'Playfair Display', serif; }
        .timeline-content img { border-radius: 8px; margin-top: 10px; max-height: 150px; object-fit: cover; }

        .rsvp-form { background: var(--white); padding: 40px 30px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05); border-radius: 8px; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-control {
            width: 100%; border: 1px solid #ddd; border-radius: 5px; padding: 12px;
            font-family: 'Lato', sans-serif; font-size: 1rem; background: #fff; color: var(--text-dark);
            transition: border-color 0.3s;
        }
        .form-control:focus { outline: none; border-color: var(--secondary-color); }
        .comment-item { display: flex; gap: 15px; background: #f9f9f9; padding: 15px; border-radius: 12px; margin-bottom: 15px; border: 1px solid #eee; animation: slideIn 0.5s ease-out; }
        .comment-avatar { width: 40px; height: 40px; border-radius: 50%; background: #ddd; flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; }
        .comment-content h5 { font-size: 0.95rem; color: var(--primary-color); margin-bottom: 4px; font-family: 'Playfair Display', serif; font-weight: 600; }
        .comment-content p { font-size: 0.85rem; color: #555; line-height: 1.5; word-wrap: break-word; }

        .music-control {
            position: fixed; bottom: 80px; right: 20px; width: 50px; height: 50px;
            background-color: var(--primary-color); border-radius: 50%;
            display: flex; align-items: center; justify-content: center; cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); z-index: 9999;
            border: 2px solid white; color: white; font-size: 24px;
            transition: transform 0.3s;
        }
        .music-control.playing { animation: spin 4s linear infinite; }

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
            text-align: center; padding: 16px; position: fixed; z-index: 100;
            left: 50%; bottom: 30px; transform: translateX(-50%);
            font-size: 14px; border-radius: 4px; opacity: 0; transition: opacity 0.5s, bottom 0.5s;
        }
        #toast.show { visibility: visible; opacity: 1; bottom: 50px; }
        .animate-spin { animation: spin 1s linear infinite; }

        .quote-section { padding: 100px 30px; text-align: center; background: var(--white); position: relative; }
        .quote-content { font-family: 'Playfair Display', serif; font-size: 1.25rem; line-height: 1.8; color: var(--text-dark); max-width: 90%; margin: 0 auto; position: relative; z-index: 2; }

        .gift-card { margin: 10px; position: relative; background: #dddddd; border-radius: 16px; padding: 50px; min-height: 140px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); }
        .gift-card::before { content: ""; position: absolute; inset: 0; background-image: linear-gradient(135deg, #f3f3f3 25%, transparent 25%), linear-gradient(225deg, #f3f3f3 25%, transparent 25%); opacity: 0.4; }
        .gift-logo { position: absolute; top: 20px; right: 20px; }
        .gift-content { position: relative; z-index: 2; padding: 10px; }
        .gift-name { font-weight: 600; letter-spacing: 1px; color: #7a5a2f; }
        .gift-number { font-size: 18px; font-weight: 500; color: #444; }
        .gift-copy { position: absolute; bottom: 20px; right: 20px; border: none; background: transparent; color: #7a5a2f; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 5px; }
    </style>
</head>
<body>

    <!-- Audio Control -->
    <div id="musicBtn" class="music-control">
        <span class="material-symbols-outlined" id="musicIcon">music_note</span>
    </div>

    <!-- Main Container -->
    <div class="mobile-container">

        <!-- Hero Section -->
        <header id="home" class="hero" style="background-image: linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)), url('{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}');">
            <div class="fade-in px-6">
                <div class="hero-subtitle">The Wedding Of</div>
                <h1>{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>

                <p class="text-sm mt-6">
                    Kepada Yth<br>
                    <span class="border-b border-white/50 px-2 py-1 inline-block mt-2">Bapak / Ibu / Saudara</span>
                </p>
                <p class="mt-4 font-semibold text-lg">{{ request('to') ?? 'Keluarga Besar' }}</p>

                <div class="hero-date">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</div>

                <button id="reminderBtn" class="reminder-btn">
                  
                    <span>Setel Pengingat</span>
                </button>
            </div>

            <div class="scroll-indicator" onclick="document.getElementById('quote').scrollIntoView({behavior: 'smooth'})">
                <span>Scroll</span>
                <div style="width:1px; height:30px; background:rgba(255,255,255,0.5);"></div>
            </div>
        </header>

        <!-- Quote Section -->
        <section id="quote" class="section-padding quote-section">
            <div class="fade-in">
                <p class="serif-font" style="font-size: 1.2rem; color: var(--primary-color); margin-bottom: 20px;">Quotes</p>
                <p class="quote-content">
                    {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote))) !!}
                </p>
                <div class="hairline" style="margin-top:30px;"></div>
            </div>
        </section>

        <!-- Couple Section -->
        <section id="mempelai" class="section-padding">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">The Bride & Groom</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Mempelai</h2>
            </div>

            <div class="couple-wrapper fade-in">
                <!-- Groom -->
                <div class="couple-card">
                    <div class="img-frame">
                        <img src="{{ asset('storage/' . ($invitation->foto_pria ?? 'default/groom.jpg')) }}" alt="{{ $invitation->groom_name }}" class="couple-img" loading="lazy">
                    </div>
                    <h3 class="couple-name">{{ $invitation->groom_name }}</h3>
                    <p class="parent-name">Putra dari Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}</p>
                    <a href="{{ $invitation->groom_instagram }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-sm text-gray-500 hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/></svg>
                        Instagram
                    </a>
                </div>

                <div class="text-center ampersand">&</div>

                <!-- Bride -->
                <div class="couple-card">
                    <div class="img-frame">
                        <img src="{{ asset('storage/' . ($invitation->foto_wanita ?? 'default/bride.jpg')) }}" alt="{{ $invitation->bride_name }}" class="couple-img" loading="lazy">
                    </div>
                    <h3 class="couple-name">{{ $invitation->bride_name }}</h3>
                    <p class="parent-name">Putri dari Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}</p>
                    <a href="{{ $invitation->bride_instagram }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-sm text-gray-500 hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/></svg>
                        Instagram
                    </a>
                </div>
            </div>
        </section>

        <!-- Event Section -->
        <section id="events" class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Save The Date</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Waktu & Tempat</h2>
                <div class="hairline"></div>
            </div>

            <div class="fade-in">
                <div class="event-card">
                    <div class="event-title">Akad Nikah</div>
                    <div class="event-time">{{ $invitation->akad_time }} - {{ $invitation->akad_time_end }}</div>
                    <p style="color: var(--text-muted); margin-top: 10px;"><b>{{ $invitation->akad_location }}</b></p>
                    <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;">{{ $invitation->akad_address }}</p>
                    <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-outline">Lihat Peta</a>
                </div>

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

                <div class="countdown-grid" id="countdownGrid">
                    <div class="text-center"><p id="days" class="timer-val">00</p><p class="timer-label">Hari</p></div>
                    <div class="text-center"><p id="hours" class="timer-val">00</p><p class="timer-label">Jam</p></div>
                    <div class="text-center"><p id="minutes" class="timer-val">00</p><p class="timer-label">Menit</p></div>
                    <div class="text-center"><p id="seconds" class="timer-val">00</p><p class="timer-label">Detik</p></div>
                </div>
                <div id="countdownPassed" class="hidden mt-6">
                    <p style="color: var(--white); font-size: 1.5rem; font-family: 'Playfair Display', serif;">Acara Telah Dimulai</p>
                </div>
            </div>
        </section>

        <!-- Love Story -->
        @php
            $loveStories = is_array($invitation->love_story) ? $invitation->love_story : json_decode($invitation->love_story, true);
        @endphp

        @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
        <section id="story2" class="section-padding">
            <div class="text-center mb-4">
                <p class="hero-subtitle" style="color: var(--text-muted);">Kisah Kami</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Love Story</h2>
            </div>

            <div class="timeline">
                @foreach($loveStories as $story)
                <div class="timeline-item fade-in">
                    <h5>{{ $story['title'] }}</h5>
                    <div class="timeline-content" style="font-size: 0.80rem; line-height: 1.8;">
                        <p style="color: var(--text-muted); margin-top: 5px;margin-bottom:10px;font-family:Arial, Helvetica, sans-serif">{{ $story['story'] }}</p>
                        @if(!empty($story['photo']))
                            <img src="{{ asset('storage/' . $story['photo']) }}" alt="Story Photo" loading="lazy">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Gallery -->
        <section id="gallery" class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Moments</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Galeri</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 fade-in" id="galleryGrid">
                @forelse($invitation->galleries as $index => $photo)
                <div class="gallery-item {{ $index >= 6 ? 'hidden' : '' }}" data-gallery-index="{{ $index }}">
                    <div class="{{ $index === 2 ? 'aspect-[4/3] rounded-lg overflow-hidden md:col-span-2' : ($index % 2 === 0 ? 'aspect-[3/4] rounded-lg overflow-hidden' : 'aspect-square rounded-lg overflow-hidden') }}">
                        <a href="{{ asset('storage/' . $photo->image) }}" data-fancybox="gallery" data-caption="Wedding Moment">
                            <img alt="Wedding Moment" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $photo->image) }}" loading="lazy" />
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-center col-span-full text-gray-500">Belum ada foto galeri.</p>
                @endforelse
            </div>
            @if($invitation->galleries->count() > 6)
            <div class="text-center mt-8 fade-in">
                <button id="loadMoreGallery" class="border border-primary text-primary px-6 py-2 rounded-full uppercase tracking-wider hover:bg-primary/5 transition-colors" onclick="loadMoreGallery()">
                    <span id="loadMoreText">Lihat Lebih Banyak</span>
                    <svg id="loadMoreSpinner" class="animate-spin hidden inline-block ml-2" style="width:18px;height:18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>
            </div>
            @endif
        </section>

        <!-- Gifts -->
        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section id="gifts" style="background-color: #f7f7f7; padding: 50px 20px;">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Beri Hadiah</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Wedding Gifts</h2>
            </div>

            <div class="grid gap-5">
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
                            <span class="material-symbols-outlined" style="font-size: 1.5rem; color: #7a5a2f;">wallet</span>
                        @endif
                    </div>

                    <div class="gift-content">
                        <h5 class="gift-name">{{ strtoupper($gift->name) }}</h5>
                        <p class="gift-number">{{ $gift->number }}</p>
                    </div>

                    <button class="gift-copy" onclick="copyText('{{ $gift->number }}')">
                        <span class="material-symbols-outlined" style="font-size: 16px;">content_copy</span> Salin
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- RSVP Form -->
        @if($invitation->enable_rsvp == 1)
        <section id="rsvp" class="section-padding" style="background-color: #f7f7f7;">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">RSVP</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Ucapan</h2>
            </div>

            @if($invitation->rsvp_deadline)
            <div class="text-center mb-4 fade-in">
                <p class="text-sm text-gray-500 inline-flex items-center gap-1">
                    <span class="material-symbols-outlined" style="font-size: 16px;">calendar_today</span>
                    Batas RSVP: {{ \Carbon\Carbon::parse($invitation->rsvp_deadline)->format('d/m/Y') }}
                </p>
            </div>
            @endif

            @if($invitation->rsvp_message)
            <div class="text-center mb-6 fade-in">
                <p class="text-gray-500 italic">"{{ $invitation->rsvp_message }}"</p>
            </div>
            @endif

            <div class="rsvp-form fade-in">
                <form id="rsvpForm" action="{{ route('rsvp.store', $invitation) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input class="form-control" placeholder="Nama Lengkap" name="name" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="attending" required>
                            <option value="1">Hadir</option>
                            <option value="2">Tidak Hadir</option>
                            <option value="3">Masih Ragu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea id="rsvpMessageInput" class="form-control resize-none" rows="3" placeholder="Tulis doa & ucapan..." name="message" style="height: 100px;" required></textarea>
                    </div>

                    <div class="text-center">
                        <button id="rsvpButton" type="submit" class="btn-outline w-full" style="background: transparent;">
                            <span id="buttonText">Kirim Ucapan</span>
                            <svg id="buttonSpinner" class="animate-spin hidden inline-block ml-2" style="width: 20px; height: 20px; vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div id="rsvpMessage" class="text-center mt-4 text-sm font-bold hidden"></div>

            <div class="mt-6 bg-white rounded-lg mx-auto p-4" style="border: 1px solid #eee;">
                <h4 class="text-center serif-font text-lg mb-4" style="color: var(--primary-color);">Tinggalkan kami doa terbaik anda untuk momen bahagia kami</h4>
                <div id="rsvpList" class="space-y-4" style="max-height: 400px; overflow-y: auto; padding-right: 5px;" data-url="{{ route('rsvp.list', $invitation) }}"></div>
                <div class="text-center mt-4">
                    <span class="text-xs text-gray-400">({{ $invitation->rsvps->count() }} Ucapan)</span>
                </div>

                @if($invitation->rsvp_whatsapp)
                <div class="text-center mt-6 fade-in">
                    <a href="https://wa.me/{{ $invitation->rsvp_whatsapp }}?text=Halo,%20saya%20ingin%20konfirmasi%20RSVP%20untuk%20undangan%20pernikahan." target="_blank" class="inline-flex items-center gap-2 bg-green-500 text-white px-6 py-3 rounded-full text-sm hover:bg-green-600 transition-colors">
                        <span class="material-symbols-outlined" style="font-size:18px;">chat</span> Konfirmasi via WhatsApp
                    </a>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- Video Section -->
        @if(!empty($invitation->video_link))
        @php
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
            $youtubeVideoId = $ytVideoMatches['id'] ?? '';
        @endphp
        @if($youtubeVideoId)
        <section class="section-padding" style="background-color: var(--white);" id="video">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Video</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Video Pernikahan</h2>
                <div class="hairline"></div>
            </div>
            <div class="fade-in relative aspect-video rounded-xl overflow-hidden cursor-pointer bg-black" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0">
                <img src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover opacity-80" />
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-6xl" style="font-size: 80px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.5));">play_circle</span>
                </div>
            </div>
        </section>
        @endif
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

    @php
        $navItems = [];
        $navItems[] = ['id' => 'home', 'icon' => 'favorite', 'label' => 'Home', 'href' => '#home', 'primary' => true];
        if ($invitation->love_story) {
            $navItems[] = ['id' => 'story2', 'icon' => 'auto_stories', 'label' => 'Story', 'href' => '#story2'];
        }
        $navItems[] = ['id' => 'events', 'icon' => 'event', 'label' => 'Events', 'href' => '#events'];
        if ($invitation->enable_gift == 1 && $invitation->gifts->count()) {
            $navItems[] = ['id' => 'gifts', 'icon' => 'card_giftcard', 'label' => 'Gifts', 'href' => '#gifts'];
        }
        if ($invitation->enable_rsvp == 1) {
            $navItems[] = ['id' => 'rsvp', 'icon' => 'mail', 'label' => 'RSVP', 'href' => '#rsvp'];
        }
        if (!empty($invitation->video_link)) {
            $navItems[] = ['id' => 'video', 'icon' => 'play_circle', 'label' => 'Video', 'href' => '#video'];
        }
    @endphp
    <nav id="bottomNav" class="p-5 fixed bottom-0 left-0 right-0 z-50 flex justify-around items-center px-2 py-2 pb-4 bg-white/95 backdrop-blur-md border-t border-gray-100 shadow-[0_-2px_16px_0_rgba(26,60,52,0.06)]">
        @foreach($navItems as $item)
        <a class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-medium transition-all duration-200 px-3 py-1.5 rounded-xl {{ ($item['primary'] ?? false) ? 'bg-[#1A3C34] text-white shadow-md' : 'text-[#5a5a5a] hover:text-[#1A3C34] hover:bg-[#1A3C34]/5' }}" href="{{ $item['href'] }}" data-nav="{{ $item['id'] }}">
            <span class="material-symbols-outlined" style="font-size: 20px;">{{ $item['icon'] }}</span>
            <span>{{ $item['label'] }}</span>
        </a>
        @endforeach
    </nav>

    <!-- Toast -->
    <div id="toast">Pesan terkirim dengan terima kasih.</div>

    <!-- Audio Element -->
    @php
        $ytMusicMatches = [];
        if (!empty($invitation->music_youtube_url)) {
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->music_youtube_url, $ytMusicMatches);
        }
        $youtubeMusicId = $ytMusicMatches['id'] ?? '';
    @endphp
    @if(!empty($youtubeMusicId))
    <div id="youtubePlayerContainer" class="hidden">
        <iframe id="youtubeIframe" width="2" height="2"
            src="https://www.youtube.com/embed/{{ $youtubeMusicId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeMusicId }}&controls=0&modestbranding=1&rel=0&mute=1"
            frameborder="0" allow="autoplay; encrypted-media; picture-in-picture"
            onload="window.ytIframeReady = true;">
        </iframe>
    </div>
    @endif
    @if(empty($youtubeMusicId))
    <audio id="bgMusic" loop>
        @if(!empty($invitation->music) && !isset($invitation->musicPreset))
            <source src="{{ asset('storage/' . $invitation->music) }}" type="audio/mpeg" />
        @elseif(!empty($invitation->musicPreset->audio_url))
            <source src="{{ asset('storage/' . $invitation->musicPreset->audio_url) }}" type="audio/mpeg" />
        @else
            <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg" />
        @endif
    </audio>
    @endif

    <!-- JavaScript Logic -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ---------- 1. TOAST & COPY ---------- */
         function showToast(message) {
             const toast = document.getElementById('toast');
             toast.textContent = message;
             toast.className = 'show';
             setTimeout(() => { toast.className = toast.className.replace('show', ''); }, 3000);
         }

           window.copyText = function(text) {
             navigator.clipboard.writeText(text).then(() => {
                 showToast("Nomor rekening berhasil disalin!");
             }).catch(() => {
                 const ta = document.createElement('textarea');
                 ta.value = text;
                 ta.style.position = 'fixed';
                 ta.style.left = '-9999px';
                 document.body.appendChild(ta);
                 ta.select();
                 document.execCommand('copy');
                 document.body.removeChild(ta);
                 showToast("Nomor rekening berhasil disalin!");
             });
         };

        function timeAgo(dateString) {
            const now = new Date();
            const date = new Date(dateString);
            const seconds = Math.floor((now - date) / 1000);
            if (seconds < 60) return 'Baru saja';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return minutes + ' menit yang lalu';
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return hours + ' jam yang lalu';
            const days = Math.floor(hours / 24);
            if (days < 30) return days + ' hari yang lalu';
            const months = Math.floor(days / 30);
            if (months < 12) return months + ' bulan yang lalu';
            return Math.floor(months / 12) + ' tahun yang lalu';
        }

        /* ---------- 2. MUSIC PLAYER ---------- */
        @if(!empty($youtubeMusicId))
        let ytIframe = document.getElementById('youtubeIframe');
        let ytMuted = true;
        const musicBtn = document.getElementById('musicBtn');
        const musicIcon = document.getElementById('musicIcon');
        let hasInteracted = false;

        function toggleMusicIcon(isPlaying) {
            musicIcon.textContent = isPlaying ? 'pause' : 'music_note';
            musicBtn.classList.toggle('playing', isPlaying);
        }

        function sendYtCommand(command) {
            if (!ytIframe) return;
            const msg = JSON.stringify({ event: 'command', func: command, args: [] });
            if (window.ytIframeReady) {
                setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 200);
            } else {
                const check = setInterval(() => {
                    if (window.ytIframeReady) { clearInterval(check); setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 200); }
                }, 100);
                setTimeout(() => { clearInterval(check); setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 500); }, 2000);
            }
        }

        function pauseYoutube() { sendYtCommand('pauseVideo'); sendYtCommand('pause'); toggleMusicIcon(false); }
        function playYoutube() {
            if (ytMuted) { sendYtCommand('unMute'); ytMuted = false; }
            sendYtCommand('playVideo'); sendYtCommand('play'); toggleMusicIcon(true);
        }

        window.addEventListener('scroll', () => { if (!hasInteracted) { playYoutube(); hasInteracted = true; } }, { once: true });
        if (!hasInteracted) { playYoutube(); hasInteracted = true; }
        musicBtn.addEventListener('click', () => { if (ytMuted || !hasInteracted) { playYoutube(); hasInteracted = true; } else { pauseYoutube(); } });
        document.addEventListener('visibilitychange', () => { if (document.hidden) { pauseYoutube(); } else if (hasInteracted && !ytMuted) { playYoutube(); } });
        @else
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');
        const musicIcon = document.getElementById('musicIcon');
        let hasInteracted = false;

        function toggleMusicIcon(isPlaying) {
            musicIcon.textContent = isPlaying ? 'pause' : 'music_note';
            musicBtn.classList.toggle('playing', isPlaying);
        }

        musicBtn.addEventListener('click', () => { if (bgMusic.paused) { bgMusic.play(); toggleMusicIcon(true); } else { bgMusic.pause(); toggleMusicIcon(false); } });
        bgMusic.play().then(() => { toggleMusicIcon(true); }).catch(() => {});
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) { if (!bgMusic.paused) { bgMusic.pause(); toggleMusicIcon(false); } }
        });
        @endif

        /* ---------- 3. COUNTDOWN ---------- */
        const weddingDate = new Date('{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Y-m-d H:i:s") }}').getTime();
        const countdownGrid = document.getElementById('countdownGrid');
        const countdownPassed = document.getElementById('countdownPassed');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (distance < 0) {
                countdownGrid.classList.add('hidden');
                countdownPassed.classList.remove('hidden');
                return;
            }
            document.getElementById('days').textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById('hours').textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById('minutes').textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById('seconds').textContent = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);

        /* ---------- 4. SCROLL ANIMATIONS ---------- */
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); } });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        /* ---------- 4b. BOTTOM NAV HIDE/SHOW ---------- */
        const bottomNav = document.getElementById('bottomNav');
        const heroSection = document.getElementById('home');
        if (bottomNav && heroSection) {
            let lastScrollY = window.scrollY;
            window.addEventListener('scroll', () => {
                const heroRect = heroSection.getBoundingClientRect();
                if (heroRect.bottom > 0) {
                    bottomNav.style.transform = 'translateY(100%)';
                    bottomNav.style.transition = 'transform 0.3s ease';
                } else {
                    bottomNav.style.transform = 'translateY(0)';
                }
                lastScrollY = window.scrollY;
            });
        }

        /* ---------- 4c. BOTTOM NAV ACTIVE SECTION ---------- */
        const bottomNavLinks = document.querySelectorAll('#bottomNav a[href^="#"]');
        const sections = [];
        bottomNavLinks.forEach(link => {
            const targetId = link.getAttribute('href').substring(1);
            const target = document.getElementById(targetId);
            if (target) sections.push({ id: targetId, element: target, link: link });
        });
        window.addEventListener('scroll', () => {
            let currentSection = '';
            sections.forEach(s => {
                const rect = s.element.getBoundingClientRect();
                if (rect.top <= window.innerHeight / 2) {
                    currentSection = s.id;
                }
            });
            bottomNavLinks.forEach(link => {
                link.classList.remove('bg-[#1A3C34]', 'text-white');
                if (link.getAttribute('href') === '#' + currentSection) {
                    link.classList.add('bg-[#1A3C34]', 'text-white');
                }
            });
        });

        /* ---------- 5. REMINDER BUTTON ---------- */
        const reminderBtn = document.getElementById('reminderBtn');
        if (reminderBtn) {
            if (localStorage.getItem('weddingReminder')) {
                reminderBtn.style.display = 'none';
            }
            reminderBtn.addEventListener('click', () => {
                const startDate = '{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Ymd\\THis") }}';
                const endDate = '{{ \Carbon\Carbon::parse($invitation->wedding_date)->addHours(5)->format("Ymd\\THis") }}';
                const gcalUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=Pernikahan+{{ urlencode($invitation->groom_nickname . ' & ' . $invitation->bride_nickname) }}&dates=' + startDate + '/' + endDate + '&details=Undangan+pernikahan&location={{ urlencode($invitation->resepsi_location ?? '') }}';
                window.open(gcalUrl, '_blank');
                showToast('Membuka Google Calendar...');
            });
        }

        /* ---------- 6. RSVP FORM ---------- */
        const rsvpForm = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');
        const rsvpMessage = document.getElementById('rsvpMessage');

        if (rsvpForm) {
            rsvpForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var form = this;
                var formData = new FormData(form);
                var submitUrl = form.getAttribute('action');

                if (!submitUrl) {
                    showToast('URL form tidak ditemukan.');
                    return;
                }

                buttonText.textContent = 'Mengirim...';
                buttonSpinner.classList.remove('hidden');
                rsvpButton.disabled = true;
                rsvpMessage.classList.add('hidden');

                fetch(submitUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
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
                    loadRsvpList();
                    showToast('Ucapan berhasil dikirim!');
                    setTimeout(function() { rsvpMessage.classList.add('hidden'); }, 5000);
                })
                .catch(function(err) {
                    rsvpMessage.textContent = err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                    rsvpMessage.style.color = '#ef4444';
                    rsvpMessage.classList.remove('hidden');
                    setTimeout(function() { rsvpMessage.classList.add('hidden'); }, 5000);
                })
                .finally(function() {
                    buttonText.textContent = 'Kirim Ucapan';
                    buttonSpinner.classList.add('hidden');
                    rsvpButton.disabled = false;
                });
            });
        }

        /* ---------- 7. LOAD RSVP LIST ---------- */
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
                            + '<span class="material-symbols-outlined text-gray-400">person</span>'
                            + '</div>'
                            + '<div class="flex-1 min-w-0">'
                            + '<p class="font-semibold text-primary mb-1">' + item.name + '</p>'
                            + '<p class="text-gray-600 text-sm leading-relaxed">' + item.message + '</p>'
                            + '<p class="text-gray-400 text-xs mt-1">' + timeAgo(item.created_at) + '</p>'
                            + '</div>'
                            + '</div>';
                    }).join('');
                } else {
                    rsvpList.innerHTML = '<p class="text-center text-gray-500 mb-2">Belum ada ucapan. Jadilah yang pertama!</p><span class="material-symbols-outlined text-primary block text-center">favorite</span>';
                }
            })
            .catch(function(err) { console.error('Failed to load RSVP list:', err); });
        }
        loadRsvpList();

        /* ---------- 8. SMOOTH SCROLL ---------- */
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    var offset = 80;
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        });

        /* ---------- GALLERY LOAD MORE ---------- */
        window.loadMoreGallery = function() {
            var button = document.getElementById('loadMoreGallery');
            var text = document.getElementById('loadMoreText');
            var spinner = document.getElementById('loadMoreSpinner');
            if (!button) return;
            var visibleCount = document.querySelectorAll('#galleryGrid .gallery-item:not(.hidden)').length;
            var totalCount = document.querySelectorAll('#galleryGrid .gallery-item').length;
            if (visibleCount >= totalCount) return;
            text.textContent = 'Memuat...';
            spinner.classList.remove('hidden');
            button.disabled = true;
            setTimeout(function() {
                var items = document.querySelectorAll('#galleryGrid .gallery-item.hidden');
                var shown = 0;
                items.forEach(function(item) {
                    if (shown < 6) {
                        item.classList.remove('hidden');
                        shown++;
                    }
                });
                text.textContent = visibleCount + shown >= totalCount ? 'Tampilkan Semua' : 'Lihat Lebih Banyak';
                spinner.classList.add('hidden');
                button.disabled = false;
                if (visibleCount + shown >= totalCount) {
                    button.style.display = 'none';
                }
            }, 300);
        };

    });
    </script>
</body>
</html>
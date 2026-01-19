<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Wedding of Nandang & Rinjani</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Great+Vibes&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #8E7F7F; /* Warm Grey */
            --secondary-color: #D4AF37; /* Gold */
            --bg-color: #FFFCF5; /* Soft Cream */
            --text-dark: #4a4a4a;
            --text-light: #777;
            --card-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            /* Background pola halus di luar container */
            background-color: #e5e5e5;
            background-image: radial-gradient(#d4af37 0.5px, transparent 0.5px), radial-gradient(#d4af37 0.5px, #e5e5e5 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* Container Mobile dengan Border Emas */
        .mobile-container {
            width: 100%;
            max-width: 420px;
            background-color: var(--bg-color);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 60px rgba(0,0,0,0.15);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            border-left: 1px solid rgba(212, 175, 55, 0.3);
            border-right: 1px solid rgba(212, 175, 55, 0.3);
        }

        /* Typography */
        h1, h2, h3 {
            font-family: 'Cinzel', serif;
            color: var(--primary-color);
        }

        .script-font {
            font-family: 'Great Vibes', cursive;
            color: var(--secondary-color);
            font-weight: 400;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .section-padding { padding: 60px 25px; position: relative; }
        .mb-1 { margin-bottom: 15px; }
        .mb-2 { margin-bottom: 30px; }
        .mb-3 { margin-bottom: 40px; }

        /* --- ORNAMEN CSS --- */

        /* Corner Ornaments (Sudut Hiasan) */
        .corner-ornament {
            position: absolute;
            width: 100px;
            height: 100px;
            pointer-events: none;
            z-index: 10;
            opacity: 0.8;
        }
        .top-left { top: 10px; left: 10px; transform: rotate(0deg); }
        .top-right { top: 10px; right: 10px; transform: scaleX(-1); }
        .bottom-left { bottom: 10px; left: 10px; transform: scaleY(-1); }
        .bottom-right { bottom: 10px; right: 10px; transform: scale(-1, -1); }

        /* Decorative Divider (Garis Pemisah) */
        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 0;
            color: var(--secondary-color);
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--secondary-color);
            margin: 0 10px;
            opacity: 0.5;
        }
        .divider-icon {
            font-size: 1.2rem;
            padding: 0 5px;
        }

        /* Title Decoration */
        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        .section-title::after {
            content: '❧'; /* Unicode flourish */
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.5rem;
            color: var(--secondary-color);
        }

        /* --- END ORNAMEN --- */

        /* Animasi Scroll */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            /* Background gelap agar tulisan terbaca */
            background: linear-gradient(rgba(62, 58, 57, 0.7), rgba(62, 58, 57, 0.6)), url('https://picsum.photos/seed/weddinghero/600/900.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        /* Ornamen di dalam Hero */
        .hero-ornament {
            width: 200px;
            height: auto;
            fill: var(--secondary-color);
            margin-bottom: 10px;
            opacity: 0.8;
        }

        .hero h1 {
            font-size: 2.8rem;
            margin: 10px 0;
            color: white;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .hero .date {
            font-size: 1.2rem;
            letter-spacing: 3px;
            border: 1px solid rgba(255,255,255,0.5);
            padding: 10px 25px;
            margin-top: 25px;
            display: inline-block;
            border-radius: 50px;
            background: rgba(0,0,0,0.2);
        }

        .scroll-down {
            position: absolute;
            bottom: 30px;
            animation: bounce 2s infinite;
            cursor: pointer;
            color: var(--secondary-color);
            font-size: 1.8rem;
        }

        /* Quote Section */
        .quote-section {
            background-color: white;
            text-align: center;
            font-style: italic;
            color: var(--text-light);
            border-bottom: 1px solid #eee;
        }

        /* Couple Section */
        .couple-wrapper {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .couple-card {
            text-align: center;
        }

        .couple-img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            /* Border ganda emas */
            border: 3px solid var(--secondary-color);
            padding: 6px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .couple-img:hover {
            transform: scale(1.05) rotate(2deg);
        }

        .couple-name {
            font-size: 2rem;
            font-family: 'Great Vibes', cursive;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .parent-name {
            font-size: 0.9rem;
            color: var(--text-light);
            font-weight: 300;
        }

        .connector {
            font-family: 'Great Vibes', cursive;
            font-size: 3.5rem;
            color: var(--secondary-color);
            margin-top: -10px;
        }

        /* Event Section */
        .event-section {
            background-color: var(--bg-color);
            background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d4af37' fill-opacity='0.05' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
        }

        .event-card {
            background: white;
            padding: 35px 25px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
            text-align: center;
            border: 1px solid rgba(212, 175, 55, 0.2);
            position: relative;
            overflow: hidden;
        }

        /* Hiasan sudut kecil pada kartu acara */
        .event-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 5px;
            background: var(--secondary-color);
        }

        .event-title {
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .event-time {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 15px;
            display: block;
            font-size: 1.1rem;
        }

        .btn-map {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 30px;
            background-color: white;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            border-radius: 50px;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .btn-map:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Countdown */
        .countdown-section {
            background-color: var(--primary-color);
            /* Background pattern */
            background-image: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20.5V18H0v-2h20v-2H0v-2h20v-2H0V8h20V6H0V4h20V2H0V0h22v20h2V0h2v20h2V0h2v20h2V0h2v20h2v2H22v-2h-2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            color: white;
            text-align: center;
            position: relative;
        }

        /* Countdown Border Atas Bawah */
        .countdown-section::before, .countdown-section::after {
            content: '';
            position: absolute;
            left: 0; right: 0;
            height: 5px;
            background: repeating-linear-gradient(45deg, var(--secondary-color), var(--secondary-color) 10px, var(--primary-color) 10px, var(--primary-color) 20px);
        }
        .countdown-section::before { top: 0; }
        .countdown-section::after { bottom: 0; }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .timer-box {
            background: rgba(255,255,255,0.1);
            padding: 15px 10px;
            border-radius: 8px;
            min-width: 65px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .timer-val {
            font-size: 1.6rem;
            font-weight: 700;
            display: block;
        }

        .timer-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        /* Gallery */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .gallery-item {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s;
            cursor: pointer;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .gallery-item:hover {
            transform: scale(1.03) rotate(1deg);
            z-index: 2;
        }

        /* RSVP Form */
        .rsvp-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            border: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            font-size: 0.8rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            display: block;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Lato', sans-serif;
            background: #fafafa;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            background: white;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: background 0.3s;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .btn-submit:hover {
            background-color: #756868;
        }

        /* Footer */
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 50px 20px;
            text-align: center;
            position: relative;
        }

        footer .logo-svg {
            width: 50px;
            fill: var(--secondary-color);
            margin-bottom: 15px;
        }

        /* Custom Toast Notification */
        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 16px;
            position: fixed;
            z-index: 99;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-size: 14px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }
    </style>
</head>
<body>

    <!-- Container Simulasi Mobile -->
    <div class="mobile-container">

        <!-- Corner Ornaments (Sudut Hiasan) -->
        <!-- SVG Corner Flourish -->
        <svg class="corner-ornament top-left" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="2">
            <path d="M50 50 Q 20 20, 5 5 T 50 20 Q 80 20, 95 5 T 50 50" />
            <path d="M20 20 Q 5 20, 5 35" fill="none" />
            <circle cx="10" cy="10" r="3" fill="#D4AF37" />
        </svg>
        <svg class="corner-ornament top-right" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="2">
            <path d="M50 50 Q 20 20, 5 5 T 50 20 Q 80 20, 95 5 T 50 50" />
            <path d="M20 20 Q 5 20, 5 35" fill="none" />
            <circle cx="10" cy="10" r="3" fill="#D4AF37" />
        </svg>
        <svg class="corner-ornament bottom-left" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="2">
            <path d="M50 50 Q 20 20, 5 5 T 50 20 Q 80 20, 95 5 T 50 50" />
            <path d="M20 20 Q 5 20, 5 35" fill="none" />
            <circle cx="10" cy="10" r="3" fill="#D4AF37" />
        </svg>
        <svg class="corner-ornament bottom-right" viewBox="0 0 100 100" fill="none" stroke="#D4AF37" stroke-width="2">
            <path d="M50 50 Q 20 20, 5 5 T 50 20 Q 80 20, 95 5 T 50 50" />
            <path d="M20 20 Q 5 20, 5 35" fill="none" />
            <circle cx="10" cy="10" r="3" fill="#D4AF37" />
        </svg>

        <!-- Hero Section -->
        <header class="hero">
            <!-- Ornamen bunga di atas nama -->
            <svg class="hero-ornament" viewBox="0 0 24 24">
                <path d="M12,2C12,2,8,5,8,9C8,13,12,15,12,15C12,15,16,13,16,9C16,5,12,2,12,2M12,15C12,15,8,17,8,21C8,25,12,27,12,27C12,27,16,25,16,21C16,17,12,15,12,15Z" />
            </svg>

            <p class="script-font fade-in" style="font-size: 1.6rem;">The Wedding of</p>
            <h1 class="fade-in">Nandang & Rinjani</h1>

            <div class="date fade-in">17 . 01 . 2026</div>

            <div class="scroll-down" onclick="document.getElementById('intro').scrollIntoView({behavior: 'smooth'})">
                &#x2193;
            </div>
        </header>

        <!-- Intro / Ayat -->
        <section id="intro" class="section-padding quote-section">
            <div class="fade-in">
                <p class="mb-2">"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya..."</p>

                <!-- Decorative Divider -->
                <div class="divider"><span class="divider-icon">❦</span></div>

                <p style="font-weight: 600; color: var(--primary-color); font-size: 0.9rem;">(QS. Ar-Rum: 21)</p>
            </div>
        </section>

        <!-- Mempelai -->
        <section class="section-padding">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Mempelai</h2>
                <p class="parent-name">Dengan memohon Rahmat dan Ridho Allah SWT</p>
            </div>

            <div class="couple-wrapper fade-in">
                <!-- Pria -->
                <div class="couple-card">
                    <img src="https://picsum.photos/seed/groom1/200/200" alt="Nandang Suryaman" class="couple-img">
                    <h3 class="couple-name">Nandang Suryaman</h3>
                    <p class="parent-name">Putra dari Bpk. Fulan & Ibu Fulana</p>
                    <div style="margin-top:10px;">
                        <a href="#" style="color:var(--primary-color); font-size: 0.9rem;">Instagram</a>
                    </div>
                </div>

                <div class="text-center connector">&</div>

                <!-- Wanita -->
                <div class="couple-card">
                    <img src="https://picsum.photos/seed/bride2/200/200" alt="Rinjani Maklar" class="couple-img">
                    <h3 class="couple-name">Rinjani Maklar</h3>
                    <p class="parent-name">Putri dari Bpk. Surya & Ibu Dewi</p>
                    <div style="margin-top:10px;">
                        <a href="#" style="color:var(--primary-color); font-size: 0.9rem;">Instagram</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Acara & Countdown -->
        <section class="section-padding event-section">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Rangkaian Acara</h2>
                <p>Sabtu, 17 Januari 2026</p>
            </div>

            <!-- Akad -->
            <div class="event-card fade-in">
                <div class="script-font" style="font-size: 1.3rem; margin-bottom: 5px;">Akad Nikah</div>
                <div class="event-title">08:00 - 10:00 WIB</div>
                <div class="divider" style="margin: 15px 0; opacity: 0.3;"><span class="divider-icon">•</span></div>
                <p class="parent-name">Masjid Agung Al-Falah<br>Jl. Pangeran Diponegoro No. 10</p>
                <a href="#" class="btn-map">Lihat Lokasi</a>
            </div>

            <!-- Resepsi -->
            <div class="event-card fade-in">
                <div class="script-font" style="font-size: 1.3rem; margin-bottom: 5px;">Resepsi</div>
                <div class="event-title">11:00 - 14:00 WIB</div>
                <div class="divider" style="margin: 15px 0; opacity: 0.3;"><span class="divider-icon">•</span></div>
                <p class="parent-name">Grand Ballroom Hotel Savoy<br>Jl. Merdeka No. 45</p>
                <a href="#" class="btn-map">Lihat Lokasi</a>
            </div>
        </section>

        <!-- Countdown Timer -->
        <section class="section-padding countdown-section">
            <div class="fade-in">
                <h3 style="font-family: 'Cinzel', serif; color:white;">Menuju Hari Bahagia</h3>
                <div class="divider" style="color:white; margin-top:10px;"><span class="divider-icon">❧</span></div>

                <div class="countdown-timer" id="timer">
                    <div class="timer-box">
                        <span class="timer-val" id="days">00</span>
                        <span class="timer-label">Hari</span>
                    </div>
                    <div class="timer-box">
                        <span class="timer-val" id="hours">00</span>
                        <span class="timer-label">Jam</span>
                    </div>
                    <div class="timer-box">
                        <span class="timer-val" id="minutes">00</span>
                        <span class="timer-label">Menit</span>
                    </div>
                    <div class="timer-box">
                        <span class="timer-val" id="seconds">00</span>
                        <span class="timer-label">Detik</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Galeri -->
        <section class="section-padding">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Galeri Foto</h2>
                <p class="parent-name">Momen kebahagiaan kami</p>
            </div>
            <div class="gallery-grid fade-in">
                <img src="https://picsum.photos/seed/wed1/300/400" class="gallery-item" alt="Gallery 1">
                <img src="https://picsum.photos/seed/wed2/300/400" class="gallery-item" alt="Gallery 2">
                <img src="https://picsum.photos/seed/wed3/300/400" class="gallery-item" alt="Gallery 3">
                <img src="https://picsum.photos/seed/wed4/300/400" class="gallery-item" alt="Gallery 4">
            </div>
        </section>

        <!-- RSVP / Ucapan -->
        <section class="section-padding" style="background-color: #fafafa;">
            <div class="text-center mb-3 fade-in">
                <h2 class="section-title">Ucapan & Doa</h2>
                <p class="parent-name">Kiriman doa restu Anda sangat berarti</p>
            </div>

            <div class="rsvp-form fade-in">
                <form id="wishForm" onsubmit="submitForm(event)">
                    <div class="form-group">
                        <label>Nama Anda</label>
                        <input type="text" class="form-control" placeholder="Tulis nama di sini..." required>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Kehadiran</label>
                        <select class="form-control">
                            <option value="Hadir">Hadir</option>
                            <option value="Tidak Hadir">Maaf, Tidak Bisa Hadir</option>
                            <option value="Ragu">Masih Ragu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ucapan</label>
                        <textarea class="form-control" rows="4" placeholder="Tuliskan ucapan selamat..." required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Kirim Ucapan</button>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <!-- Logo Cincin SVG -->
            <svg class="logo-svg" viewBox="0 0 24 24">
                <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
            </svg>
            <h2 class="script-font mb-2" style="font-size: 2rem;">Nandang & Rinjani</h2>
            <div class="divider" style="color:white; margin: 10px auto;"><span class="divider-icon">•</span></div>
            <p style="font-size: 0.8rem;">Terima kasih atas doa dan restu Anda</p>
            <br>
            <small style="opacity: 0.6;">&copy; 2026 Wedding Invitation Design</small>
        </footer>

        <!-- Toast Notification -->
        <div id="toast">Terima kasih! Pesan Anda telah terkirim.</div>

    </div>

    <script>
        // --- 1. Countdown Logic ---
        const weddingDate = new Date("January 17, 2026 08:00:00").getTime();

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = weddingDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("days").innerText = String(days).padStart(2, '0');
            document.getElementById("hours").innerText = String(hours).padStart(2, '0');
            document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
            document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');

            if (distance < 0) {
                clearInterval(timerInterval);
                document.getElementById("timer").innerHTML = "<h3>Acara Telah Dimulai!</h3>";
            }
        }, 1000);

        // --- 2. Scroll Animation (Intersection Observer) ---
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // --- 3. RSVP Form Handling ---
        function submitForm(e) {
            e.preventDefault();

            // Simulasi pengiriman data
            const btn = e.target.querySelector('button');
            const originalText = btn.innerText;

            btn.innerText = "Mengirim...";
            btn.disabled = true;

            setTimeout(() => {
                // Tampilkan Toast
                const toast = document.getElementById("toast");
                toast.className = "show";
                setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);

                // Reset Form
                e.target.reset();
                btn.innerText = originalText;
                btn.disabled = false;
            }, 1500);
        }
    </script>
</body>
</html>

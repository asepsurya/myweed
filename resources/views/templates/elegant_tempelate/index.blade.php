<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nandang & Rinjani | The Wedding</title>

    <!-- Google Fonts: Playfair Display (Elegant Serif) & Lato (Clean Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Elegant Palette */
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
            /* Background luar yang bersih */
            background-color: #e6e6e6;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* --- Container Mobile dengan Bingkai Halus --- */
        .mobile-container {
            width: 100%;
            max-width: 414px; /* Ukuran iPhone Max */
            background-color: var(--bg-color);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            border-left: 8px solid white; /* Bingkai putih tipis */
            border-right: 8px solid white;
        }

        /* Typography Classes */
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

        .text-center { text-align: center; }

        /* Helper untuk garis pemisah halus (Hairline) */
        .hairline {
            width: 50px;
            height: 1px;
            background-color: var(--secondary-color);
            margin: 15px auto;
        }

        .section-padding { padding: 80px 30px; position: relative; }
        .mb-4 { margin-bottom: 40px; }

        /* --- Hero Section: Dark & Moody --- */
        .hero {
            height: 100vh;
            /* Gambar gelap untuk kontras elegan */
            background: linear-gradient(rgba(26, 60, 52, 0.4), rgba(26, 60, 52, 0.7)), url('https://picsum.photos/seed/elegantwedding/600/900.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Efek Parallax */
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
        }

        .hero-date {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.4rem;
            margin-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.5);
            border-bottom: 1px solid rgba(255,255,255,0.5);
            padding: 10px 30px;
            display: inline-block;
        }

        /* Scroll Indicator */
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
        .couple-section {
            background-color: var(--bg-color);
        }

        .couple-wrapper {
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        .couple-card {
            text-align: center;
        }

        /* Frame Oval Elegan untuk Foto */
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
            filter: grayscale(20%) sepia(10%); /* Efek foto vintage halus */
        }

        .couple-name {
            font-size: 2rem;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .parent-name {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

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

        .event-card:hover {
            border-color: var(--secondary-color);
            transform: translateY(-5px);
        }

        .event-title {
            font-size: 1.2rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .event-time {
            font-size: 1.8rem;
            color: var(--secondary-color);
            font-family: 'Playfair Display', serif;
            font-weight: 400;
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
            background-color: var(--primary-color);
            color: var(--white);
        }

        /* --- Countdown --- */
        .countdown-section {
            background-color: var(--primary-color);
            color: var(--white);
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }

        .timer-item span {
            display: block;
        }

        .timer-val {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            line-height: 1;
            margin-bottom: 5px;
        }

        .timer-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.7;
        }

        /* --- Gallery --- */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .gallery-item {
            width: 100%;
            height: 250px;
            object-fit: cover;
            filter: grayscale(30%);
            transition: all 0.5s;
            border-radius: 2px;
        }

        .gallery-item:hover {
            filter: grayscale(0%);
        }

        /* --- RSVP Form --- */
        .rsvp-form {
            background: var(--white);
            padding: 40px 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

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

        .form-control:focus {
            outline: none;
            border-bottom: 1px solid var(--secondary-color);
        }

        /* --- Footer --- */
        footer {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 60px 20px;
            text-align: center;
        }

        footer p {
            font-size: 0.9rem;
            opacity: 0.8;
            letter-spacing: 1px;
        }

        /* --- Animations --- */
        .fade-in {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 1.2s ease-out, transform 1.2s ease-out;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translate(-50%, 0);}
            40% {transform: translate(-50%, -10px);}
            60% {transform: translate(-50%, -5px);}
        }

        /* Toast Elegant Style */
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
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        #toast.show {
            visibility: visible;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 40px; opacity: 1;}
        }

        @keyframes fadeout {
            from {bottom: 40px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>
</head>
<body>

    <!-- Container Simulasi Mobile -->
    <div class="mobile-container">

        <!-- Hero Section -->
        <header class="hero">
            <div class="fade-in">
                <div class="hero-subtitle">The Wedding Of</div>
                <h1>{{ $invitation->groom_nickname }} & Rinjani</h1>
                <div class="hero-date">17 January 2026</div>
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
                <p>"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya..."</p>
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
                        <img src="https://picsum.photos/seed/groomdark/300/400" alt="Nandang Suryaman" class="couple-img">
                    </div>
                    <h3 class="couple-name">Nandang Suryaman</h3>
                    <p class="parent-name">Putra dari Bpk. Fulan & Ibu Fulana</p>
                </div>

                <div class="text-center ampersand">&</div>

                <!-- Bride -->
                <div class="couple-card">
                    <div class="img-frame">
                        <img src="https://picsum.photos/seed/bridedark/300/400" alt="Rinjani Maklar" class="couple-img">
                    </div>
                    <h3 class="couple-name">Rinjani Maklar</h3>
                    <p class="parent-name">Putri dari Bpk. Surya & Ibu Dewi</p>
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
                    <div class="event-time">08:00 — 10:00 WIB</div>
                    <p style="color: var(--text-muted); margin-top: 10px;">Masjid Agung Al-Falah<br>Jl. Pangeran Diponegoro No. 10</p>
                    <a href="#" class="btn-outline">Lihat Peta</a>
                </div>

                <!-- Resepsi -->
                <div class="event-card">
                    <div class="event-title">Wedding Reception</div>
                    <div class="event-time">11:00 — 14:00 WIB</div>
                    <p style="color: var(--text-muted); margin-top: 10px;">Grand Ballroom Hotel Savoy<br>Jl. Merdeka No. 45</p>
                    <a href="#" class="btn-outline">Lihat Peta</a>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="section-padding countdown-section">
            <div class="fade-in">
                <p class="hero-subtitle" style="color: var(--white); opacity: 0.8;">Counting Down</p>
                <h2 class="serif-font" style="color: var(--white);">Menuju Bahagia</h2>

                <div class="countdown-timer" id="timer">
                    <div class="timer-item">
                        <span class="timer-val" id="days">00</span>
                        <span class="timer-label">Days</span>
                    </div>
                    <div class="timer-item">
                        <span class="timer-val" id="hours">00</span>
                        <span class="timer-label">Hours</span>
                    </div>
                    <div class="timer-item">
                        <span class="timer-val" id="minutes">00</span>
                        <span class="timer-label">Mins</span>
                    </div>
                    <div class="timer-item">
                        <span class="timer-val" id="seconds">00</span>
                        <span class="timer-label">Secs</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery -->
        <section class="section-padding" style="background-color: var(--white);">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">Moments</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Galeri</h2>
            </div>
            <div class="gallery-grid fade-in">
                <img src="https://picsum.photos/seed/eleg1/300/400" class="gallery-item" alt="Gallery 1">
                <img src="https://picsum.photos/seed/eleg2/300/400" class="gallery-item" alt="Gallery 2">
                <img src="https://picsum.photos/seed/eleg3/300/400" class="gallery-item" alt="Gallery 3">
                <img src="https://picsum.photos/seed/eleg4/300/400" class="gallery-item" alt="Gallery 4">
            </div>
        </section>

        <!-- RSVP Form -->
        <section class="section-padding" style="background-color: #f7f7f7;">
            <div class="text-center mb-4 fade-in">
                <p class="hero-subtitle" style="color: var(--text-muted);">RSVP</p>
                <h2 class="serif-font" style="font-size: 2.5rem;">Ucapan</h2>
            </div>

            <div class="rsvp-form fade-in">
                <form id="wishForm" onsubmit="submitForm(event)">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" style="color: #999;">
                            <option value="" disabled selected>Konfirmasi Kehadiran</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Tidak Hadir">Tidak Hadir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Tulis pesan Anda..." required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn-outline" style="padding: 15px 50px;">Kirim</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <h2 class="serif-font" style="color: var(--white); margin-bottom: 10px;">Nandang & Rinjani</h2>
            <div class="hairline" style="background-color: var(--secondary-color); width: 30px;"></div>
            <p style="margin-top: 20px; font-size: 0.8rem;">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
            <br>
            <p style="font-size: 0.7rem; opacity: 0.5;">&copy; 2026 Elegant Wedding Invitation</p>
        </footer>

        <!-- Toast Notification -->
        <div id="toast">Pesan terkirim dengan terima kasih.</div>

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
                document.getElementById("timer").innerHTML = "<h3>The Wedding Day</h3>";
            }
        }, 1000);

        // --- 2. Scroll Animation ---
        const observerOptions = {
            threshold: 0.15
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

            const btn = e.target.querySelector('button');
            const originalText = btn.innerText;

            btn.innerText = "Mengirim...";
            btn.style.opacity = "0.7";

            setTimeout(() => {
                const toast = document.getElementById("toast");
                toast.className = "show";
                setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);

                e.target.reset();
                btn.innerText = originalText;
                btn.style.opacity = "1";
            }, 1500);
        }
    </script>
</body>
</html>

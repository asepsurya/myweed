<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pernikahan Adat Jawa - Nandang & Rinjani</title>

    <!-- Google Fonts: Playfair Display (Klasik) & Prata (Nuansa Kuno) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Prata&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Palet Warna Adat Jawa (Maroon & Gold) */
            --primary-color: #5D3A36; /* Coklat Maroon Tua */
            --accent-color: #Cfb997; /* Emas Pudar */
            --secondary-color: #8D6E63; /* Coklat Sedang */
            --bg-color: #Fdfbf7; /* Kertas Tua Krem */
            --text-dark: #3E2723;
            --text-gold: #B7860B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lato', sans-serif;
            /* Background Luar Pola Geometris (Imitasi Kawung Sederhana) */
            background-color: #e0dcd5;
            background-image: radial-gradient(circle, #Cfb997 15%, transparent 16%), radial-gradient(circle, #Cfb997 15%, transparent 16%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        /* Container Mobile dengan Bingkai Emas Ganda */
        .mobile-container {
            width: 100%;
            max-width: 414px;
            background-color: var(--bg-color);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 40px rgba(0,0,0,0.2);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            border: 10px solid white;
            outline: 1px solid var(--accent-color); /* Garis tipis luar */
        }

        /* Typography */
        h1, h2, h3, .serif-font {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            font-weight: 700;
        }

        .ancient-font {
            font-family: 'Prata', serif; /* Font untuk kesan Jawa Kuno */
        }

        .text-center { text-align: center; }

        /* Ornamen Gunungan (Separator) */
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

        .section-padding { padding: 60px 25px; position: relative; }
        .mb-5 { margin-bottom: 50px; }

        /* --- Hero Section --- */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(93, 58, 54, 0.8), rgba(93, 58, 54, 0.6)), url('https://picsum.photos/seed/javanesewedding/600/900.jpg');
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

        /* Hiasan Bunga Emas di Hero */
        .flower-ornament {
            width: 100px;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .hero h1 {
            font-size: 2.8rem;
            color: var(--accent-color);
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
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

        /* --- Quote Section --- */
        .quote-section {
            background-color: var(--white);
            text-align: center;
            font-family: 'Prata', serif;
            font-style: italic;
            color: var(--secondary-color);
            border-bottom: 2px solid var(--primary-color);
            position: relative;
        }

        .quote-section::after {
            /* Motif Pola Sederhana */
            content: "";
            position: absolute;
            bottom: -10px;
            left: 0;
            right: 0;
            height: 20px;
            background: repeating-linear-gradient(45deg, var(--primary-color), var(--primary-color) 10px, transparent 10px, transparent 20px);
            opacity: 0.1;
        }

        /* --- Couple Section --- */
        .couple-wrapper {
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        .couple-card {
            text-align: center;
        }

        /* Bingkai Foto Emas Adat */
        .photo-frame-javanese {
            position: relative;
            display: inline-block;
            padding: 15px;
            border: 2px solid var(--accent-color);
            background: white;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        /* Sudut bingkai */
        .photo-frame-javanese::before, .photo-frame-javanese::after,
        .photo-frame-inner::before, .photo-frame-inner::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            border: 3px solid var(--primary-color);
            transition: all 0.3s;
        }
        .photo-frame-javanese::before { top: 5px; left: 5px; border-right: none; border-bottom: none; }
        .photo-frame-javanese::after { top: 5px; right: 5px; border-left: none; border-bottom: none; }
        .photo-frame-javanese .photo-frame-inner { position: relative; display: block; }
        .photo-frame-javanese .photo-frame-inner::before { bottom: 5px; left: 5px; border-right: none; border-top: none; }
        .photo-frame-javanese .photo-frame-inner::after { bottom: 5px; right: 5px; border-left: none; border-top: none; }

        .couple-img {
            width: 200px;
            height: 250px;
            object-fit: cover;
            /* Filter Sepia untuk kesan foto lama */
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

        /* --- Event Section --- */
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
            top: 5px; left: 5px; right: 5px; bottom: 5px;
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

        /* --- Countdown --- */
        .countdown-section {
            background-color: var(--primary-color);
            color: var(--accent-color);
            text-align: center;
            padding: 50px 20px;
            border-top: 5px solid var(--accent-color);
            border-bottom: 5px solid var(--accent-color);
            /* Pattern Batik CSS Simple */
            background-image: repeating-linear-gradient(45deg, rgba(0,0,0,0.05) 0px, rgba(0,0,0,0.05) 10px, transparent 10px, transparent 20px);
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .timer-box {
            background: rgba(0,0,0,0.2);
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

        /* --- Gallery --- */
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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            filter: sepia(20%);
            transition: all 0.3s;
        }
        .gallery-item:hover {
            transform: scale(1.03);
            filter: sepia(0%);
            border-color: var(--accent-color);
        }

        /* --- RSVP Form --- */
        .rsvp-form {
            background: #fff;
            padding: 30px;
            border: 1px solid var(--secondary-color);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
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

        .btn-submit:hover {
            background-color: var(--secondary-color);
        }

        /* Footer */
        footer {
            background-color: var(--primary-color);
            color: var(--accent-color);
            padding: 40px 20px;
            text-align: center;
        }

        /* Animations */
        .fade-in { opacity: 0; transform: translateY(20px); transition: all 1s; }
        .fade-in.visible { opacity: 1; transform: translateY(0); }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-15px);}
            60% {transform: translateY(-7px);}
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
        @keyframes fadein { from {bottom: 0; opacity: 0;} to {bottom: 30px; opacity: 1;} }
        @keyframes fadeout { from {bottom: 30px; opacity: 1;} to {bottom: 0; opacity: 0;} }
    </style>
</head>
<body>

    <div class="mobile-container">

        <!-- Hero Section -->
        <header class="hero">
            <!-- Ornamen Bunga SVG -->
            <svg class="flower-ornament" viewBox="0 0 100 50">
                <path d="M50 50 C 20 50 0 30 0 10 C 20 0 40 0 50 20 C 60 0 80 0 100 10 C 100 30 80 50 50 50" fill="none" stroke="#Cfb997" stroke-width="2"/>
            </svg>

            <p class="fade-in" style="font-size: 0.9rem; letter-spacing: 2px;">The Wedding of</p>
            <h1 class="fade-in" style="margin-top: 10px;">Nandang<br>&<br>Rinjani</h1>

            <div class="hero-sub fade-in">
                Sabtu, 17 Januari 2026
            </div>

            <div class="scroll-btn" onclick="document.getElementById('quote').scrollIntoView({behavior: 'smooth'})">
                &#x25BC;
            </div>
        </header>

        <!-- Mangayu Bagya (Quote) -->
        <section id="quote" class="section-padding quote-section">
            <div class="fade-in">
                <h3 style="font-family: 'Prata', serif; font-size: 1.5rem; margin-bottom: 15px;">Mangayu Bagya</h3>
                <p style="font-size: 1.1rem; line-height: 1.6;">
                    "Assalamu’alaikum Warahmatullahi Wabarakatuh"<br>
                    Dengan memohon Rahmat dan Ridho Allah SWT, kami bermaksud menyelenggarakan pernikahan putra-putri kami:
                </p>
            </div>
        </section>

        <!-- Mempelai -->
        <section class="section-padding">
            <div class="couple-wrapper fade-in">
                <!-- Pria -->
                <div class="couple-card">
                    <div class="photo-frame-javanese">
                        <span class="photo-frame-inner"></span>
                        <!-- Gunakan seed 'groom' untuk variasi -->
                        <img src="https://picsum.photos/seed/groomjava/300/400" alt="Nandang Suryaman" class="couple-img">
                    </div>
                    <h3 class="couple-name ancient-font">Nandang Suryaman</h3>
                    <p class="parent-name">Putra dari Bpk. Fulan & Ibu Fulana</p>
                </div>

                <!-- Tanda & -->
                <div class="text-center connector-symbol">&</div>

                <!-- Wanita -->
                <div class="couple-card">
                    <div class="photo-frame-javanese">
                        <span class="photo-frame-inner"></span>
                        <!-- Gunakan seed 'bride' untuk variasi -->
                        <img src="https://picsum.photos/seed/bridejava/300/400" alt="Rinjani Maklar" class="couple-img">
                    </div>
                    <h3 class="couple-name ancient-font">Rinjani Maklar</h3>
                    <p class="parent-name">Putri dari Bpk. Surya & Ibu Dewi</p>
                </div>
            </div>
        </section>

        <!-- Divider Gunungan -->
        <div class="divider-gunungan">
            <div class="divider-line"></div>
            <!-- SVG Gunungan -->
            <svg class="gunungan-icon" viewBox="0 0 50 100">
                <path d="M25 100 Q 0 50, 25 0 Q 50 50, 25 100 M25 20 C 10 20, 5 40, 15 60 C 10 50, 0 60, 10 80 M25 20 C 40 20, 45 40, 35 60 C 40 50, 50 60, 40 80" fill="currentColor"/>
            </svg>
        </div>

        <!-- Acara -->
        <section class="section-padding" style="background-color: #f7f7f7;">
            <div class="text-center mb-5 fade-in">
                <h2 class="ancient-font" style="font-size: 2rem;">Rangkaian Acara</h2>
                <p style="color: var(--secondary-color);">Dalam rangkaian pernikahan adat Jawa</p>
            </div>

            <div class="fade-in">
                <!-- Akad -->
                <div class="event-card">
                    <div class="event-title">Akad Nikah</div>
                    <span class="event-time">08:00 - 10:00 WIB</span>
                    <p style="font-size: 0.9rem; color: #555;">Masjid Agung Al-Falah<br>Jl. Pangeran Diponegoro No. 10</p>
                    <a href="#" class="btn-map">Lihat Lokasi</a>
                </div>

                <!-- Resepsi -->
                <div class="event-card">
                    <div class="event-title">Resepsi</div>
                    <span class="event-time">11:00 - 14:00 WIB</span>
                    <p style="font-size: 0.9rem; color: #555;">Grand Ballroom Hotel Savoy<br>Jl. Merdeka No. 45</p>
                    <a href="#" class="btn-map">Lihat Lokasi</a>
                </div>
            </div>
        </section>

        <!-- Countdown -->
        <section class="countdown-section">
            <div class="fade-in">
                <h3 class="ancient-font" style="font-size: 1.8rem;">Hitung Mundur</h3>

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

        <!-- Gallery -->
        <section class="section-padding">
            <div class="text-center mb-5 fade-in">
                <h2 class="ancient-font" style="font-size: 2rem;">Dokumentasi</h2>
            </div>
            <div class="gallery-grid fade-in">
                <img src="https://picsum.photos/seed/java1/300/400" class="gallery-item" alt="Gallery 1">
                <img src="https://picsum.photos/seed/java2/300/400" class="gallery-item" alt="Gallery 2">
                <img src="https://picsum.photos/seed/java3/300/400" class="gallery-item" alt="Gallery 3">
                <img src="https://picsum.photos/seed/java4/300/400" class="gallery-item" alt="Gallery 4">
            </div>
        </section>

        <!-- RSVP -->
        <section class="section-padding" style="background: #f0ebe5;">
            <div class="text-center mb-5 fade-in">
                <h2 class="ancient-font" style="font-size: 2rem;">Ucapan & Kirim Doa</h2>
            </div>

            <div class="rsvp-form fade-in">
                <form id="wishForm" onsubmit="submitForm(event)">
                    <input type="text" class="form-control" placeholder="Nama Tamu" required>
                    <select class="form-control" style="color: #999;">
                        <option value="Hadir">Hadir</option>
                        <option value="Tidak Hadir">Maaf Tidak Bisa Hadir</option>
                    </select>
                    <textarea class="form-control" rows="3" placeholder="Tuliskan ucapan selamat..." required></textarea>
                    <button type="submit" class="btn-submit">Kirim Ucapan</button>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="fade-in">
                <h2 class="ancient-font" style="font-size: 2rem; color: #Cfb997;">Nandang & Rinjani</h2>
                <div class="divider-gunungan" style="margin: 15px 0;">
                    <div class="divider-line" style="background: rgba(255,255,255,0.3);"></div>
                    <svg class="gunungan-icon" style="fill: #Cfb997; padding:0 5px;" viewBox="0 0 50 100">
                        <path d="M25 100 Q 0 50, 25 0 Q 50 50, 25 100 M25 20 C 10 20, 5 40, 15 60 C 10 50, 0 60, 10 80 M25 20 C 40 20, 45 40, 35 60 C 40 50, 50 60, 40 80"/>
                    </svg>
                </div>
                <p style="font-size: 0.85rem;">Kami mengucapkan terima kasih atas doa restu Bapak/Ibu/Saudara/i.</p>
                <br>
                <small style="opacity: 0.5;">&copy; 2026 Undangan Pernikahan Adat</small>
            </div>
        </footer>

        <!-- Toast -->
        <div id="toast">Terima kasih, kirim doa sukses.</div>

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
                document.getElementById("timer").innerHTML = "<h3>Acara Dimulai</h3>";
            }
        }, 1000);

        // --- 2. Scroll Animation ---
        const observerOptions = { threshold: 0.15 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

        // --- 3. Form Submit ---
        function submitForm(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button');
            const originalText = btn.innerText;
            btn.innerText = "Mengirim...";

            setTimeout(() => {
                const toast = document.getElementById("toast");
                toast.className = "show";
                setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);

                e.target.reset();
                btn.innerText = originalText;
            }, 1000);
        }
    </script>
</body>
</html>

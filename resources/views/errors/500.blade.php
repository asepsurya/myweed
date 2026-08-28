<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>500 - Kesalahan Server | {{ config('app.name', 'RuangUndang') }}</title>
    <meta name="description" content="Terjadi kesalahan pada server. Silakan coba lagi nanti.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/fav-icon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --gold: #C6A962;
            --gold-light: #E8D5A3;
            --gold-dark: #A68B4B;
            --navy: #1B2A4A;
            --navy-light: #2A3F6A;
            --white: #FFFFFF;
            --bg: #F7F5F2;
            --bg-alt: #FDFBF7;
            --border: #E8E4DE;
            --text: #1B2A4A;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --radius: 12px;
            --radius-lg: 20px;
            --speed: 0.4s;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-display: 'Playfair Display', Georgia, serif;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font);
            color: var(--text);
            background-color: var(--bg);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: all var(--speed) ease;
        }

        h1, h2, h3, h4 { font-family: var(--font-display); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); }
            50% { transform: translateY(-15px) translateX(5px); }
        }

        @keyframes pulseSoft {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }

        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== Navbar ===== */
        .navbar {
            padding: 1.5rem 0;
            background: transparent;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: all var(--speed) ease;
        }

        .navbar.scrolled {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 4px 20px rgba(27, 42, 74, 0.05);
        }

        .navbar-brand {
            display: inline-flex;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
            transition: opacity var(--speed) ease;
        }

        .navbar-brand .logo-light { display: none; }
        .navbar-brand .logo-dark { display: block; }

        .navbar:not(.scrolled) .navbar-brand .logo-light { display: block; }
        .navbar:not(.scrolled) .navbar-brand .logo-dark { display: none; }

        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8) !important;
            margin: 0 0.8rem;
            font-size: 0.9rem;
            position: relative;
        }

        .navbar.scrolled .nav-link { color: var(--text-secondary) !important; }
        .nav-link:hover { color: var(--gold-light) !important; }
        .navbar.scrolled .nav-link:hover { color: var(--gold-dark) !important; }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white) !important;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            transition: all var(--speed);
            box-shadow: 0 4px 15px rgba(198, 169, 98, 0.3);
        }

        .btn-gold:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(198, 169, 98, 0.5);
            color: var(--white) !important;
        }

        /* ===== Error Section ===== */
        .error-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(27, 42, 74, 0.88), rgba(27, 42, 74, 0.96)),
                        url('https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop') center/cover no-repeat;
            color: var(--white);
            position: relative;
            overflow: hidden;
            padding: 120px 20px 80px;
        }

        .error-shape {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(198, 169, 98, 0.2);
            z-index: 1;
            animation: float 10s infinite ease-in-out;
        }

        .error-shape.shape-1 {
            width: 350px;
            height: 350px;
            top: -100px;
            left: -100px;
        }

        .error-shape.shape-2 {
            width: 250px;
            height: 250px;
            bottom: -60px;
            right: -60px;
            border-color: rgba(255, 255, 255, 0.1);
            animation-direction: reverse;
            animation-duration: 12s;
        }

        .error-shape.shape-3 {
            width: 150px;
            height: 150px;
            top: 20%;
            right: 10%;
            background: radial-gradient(circle, rgba(198, 169, 98, 0.15) 0%, transparent 70%);
            border: none;
            animation: pulseSoft 6s infinite ease-in-out;
        }

        .error-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .error-code {
            font-size: 10rem;
            font-weight: 700;
            font-family: var(--font-display);
            line-height: 1;
            margin-bottom: 0;
            background: linear-gradient(135deg, var(--gold-light), var(--gold), var(--gold-dark));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s linear infinite;
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
        }

        .error-emoji {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: spin-slow 8s linear infinite, fadeInUp 1s ease-out 0.2s forwards;
            opacity: 0;
            display: inline-block;
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease-out 0.4s forwards;
            opacity: 0;
        }

        .error-desc {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 300;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            animation: fadeInUp 1s ease-out 0.6s forwards;
            opacity: 0;
        }

        .error-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.8s forwards;
            opacity: 0;
        }

        .btn-home {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            border-radius: 50px;
            padding: 0.9rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            transition: all var(--speed);
            box-shadow: 0 8px 25px rgba(198, 169, 98, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-home:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 35px rgba(198, 169, 98, 0.5);
            color: var(--white);
        }

        .btn-outline-home {
            background: transparent;
            color: var(--white);
            border-radius: 50px;
            padding: 0.9rem 2rem;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            transition: all var(--speed);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-home:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--gold-light);
            color: var(--gold-light);
            transform: translateY(-3px);
        }

        .gear-icon {
            display: inline-block;
            font-size: 5rem;
            color: var(--gold-light);
            animation: spin-slow 8s linear infinite, fadeInUp 1s ease-out 0.2s forwards;
            opacity: 0;
            margin-bottom: 1rem;
        }

        /* ===== Footer ===== */
        footer {
            background: var(--bg-alt);
            border-top: 1px solid var(--border);
            padding: 60px 0 30px;
        }

        .footer-logo {
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            height: 40px;
            width: auto;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
        }

        .footer-links li a {
            color: var(--text-secondary);
            display: inline-block;
            transition: transform 0.2s ease;
        }

        .footer-links li a:hover {
            color: var(--gold-dark);
            transform: translateX(5px);
        }

        .footer-heading {
            font-family: var(--font);
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 1.5rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            font-size: 1rem;
            transition: all var(--speed);
        }

        .social-btn:hover {
            background: var(--navy);
            color: var(--white);
            transform: translateY(-5px) rotate(5deg);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            margin-top: 40px;
            padding-top: 30px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .error-code { font-size: 6rem; }
            .error-title { font-size: 1.8rem; }
            .error-desc { font-size: 1rem; }
            .error-section { padding: 100px 20px 60px; }
        }

        .login-link {
            font-weight: 500;
            text-decoration: none;
            transition: all .3s ease;
        }

        .login-link:hover { color: #d4af37 !important; }

        .dashboard-link {
            color: #fff !important;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, .25);
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(10px);
            transition: all .3s ease;
        }

        .dashboard-link:hover {
            background: rgba(212, 175, 55, .15);
            border-color: #d4af37;
            color: #d4af37 !important;
        }
    </style>
</head>

<body>

    @include('layouts.partial.page_navbar')

    <!-- Error Section -->
    <section class="error-section">
        <div class="error-shape shape-1"></div>
        <div class="error-shape shape-2"></div>
        <div class="error-shape shape-3"></div>

        <div class="container error-content">
            <div class="gear-icon">
                <i class="bi bi-gear-wide-connected"></i>
            </div>

            <h1 class="error-code">500</h1>
            <h2 class="error-title">Terjadi Kesalahan Server</h2>
            <p class="error-desc">
                Oops! Sepertinya ada yang tidak beres di server kami. Tim teknisi kami sedang bekerja untuk memperbaiki masalah ini. Silakan coba lagi dalam beberapa saat.
            </p>
            <div class="error-actions">
                <a href="{{ url()->current() }}" class="btn-home">
                    <i class="bi bi-arrow-clockwise"></i> Coba Lagi
                </a>
                <a href="{{ route('landing') }}" class="btn-outline-home">
                    <i class="bi bi-house-door"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 reveal">
                    <a href="{{ route('landing') }}" class="footer-logo">
                        <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
                    </a>
                    <p class="text-secondary small" style="max-width: 350px;">Platform undangan digital premium untuk momen spesial Anda. Praktis, elegan, dan hemat biaya.</p>
                    <div class="footer-social">
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-tiktok"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1 reveal" style="transition-delay: 0.1s;">
                    <h5 class="footer-heading">Layanan</h5>
                    <ul class="footer-links">
                        <li><a href="#">Undangan Pernikahan</a></li>
                        <li><a href="#">Undangan Digital</a></li>
                        <li><a href="#">Cetak Undangan</a></li>
                        <li><a href="#">Video Undangan</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 reveal" style="transition-delay: 0.2s;">
                    <h5 class="footer-heading">Tema Populer</h5>
                    <ul class="footer-links">
                        <li><a href="#">Tema Modern</a></li>
                        <li><a href="#">Tema Rustic</a></li>
                        <li><a href="#">Tema Floral</a></li>
                        <li><a href="#">Tema Islami</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 reveal" style="transition-delay: 0.3s;">
                    <h5 class="footer-heading">Informasi</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('pages.cara-pemesanan') }}">Cara Pemesanan</a></li>
                        <li><a href="{{ route('pages.faq') }}">Pertanyaan (FAQ)</a></li>
                        <li><a href="{{ route('pages.syarat-ketentuan') }}">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('pages.kebijakan-privasi') }}">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} RuangUndang Digital Invitation. Dibuat dengan <i class="bi bi-heart-fill text-danger"></i> di Indonesia.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); }
            else { navbar.classList.remove('scrolled'); }
        });

        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.add('active'); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.15 });
        reveals.forEach(reveal => observer.observe(reveal));
    </script>

    @include('layouts.partial.whatsapp_float')
</body>

</html>

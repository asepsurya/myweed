<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $noIndex = $noIndex ?? false;
    @endphp
    @include('layouts.partial.seo_head')

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
        a { text-decoration: none; color: inherit; transition: all var(--speed) ease; }
        h1, h2, h3, h4 { font-family: var(--font-display); }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
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

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .reveal.active { opacity: 1; transform: translateY(0); }

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
            display: inline-block;
            padding: 0;
            margin: 0;
        }
        .navbar-brand img {
            height: 40px;
            width: auto;
            filter: brightness(0) invert(1);
            transition: filter var(--speed) ease;
        }
        .navbar.scrolled .navbar-brand img { filter: none; }
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
        }

        /* ===== Page Header ===== */
        .page-header {
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(27, 42, 74, 0.8), rgba(27, 42, 74, 0.95)), url('https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            color: var(--white);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }
        .page-header-shape {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(198, 169, 98, 0.2);
            z-index: 1;
            animation: float 10s infinite ease-in-out;
        }
        .page-header-shape.shape-1 { width: 300px; height: 300px; top: -80px; left: -80px; }
        .page-header-shape.shape-2 { width: 200px; height: 200px; bottom: -40px; right: -40px; border-color: rgba(255, 255, 255, 0.1); animation-direction: reverse; animation-duration: 12s; }
        .page-header-content { position: relative; z-index: 2; max-width: 700px; }
        .page-header h1 { font-size: 3rem; font-weight: 600; margin-bottom: 1rem; letter-spacing: -1px; animation: fadeInUp 1s ease-out forwards; }
        .page-header p { font-size: 1.1rem; color: rgba(255, 255, 255, 0.8); font-weight: 300; animation: fadeInUp 1s ease-out 0.3s forwards; opacity: 0; }
        .breadcrumb { justify-content: center; animation: fadeInUp 1s ease-out 0.5s forwards; opacity: 0; }
        .breadcrumb-item a { color: var(--gold-light); }
        .breadcrumb-item.active { color: rgba(255, 255, 255, 0.7); }

        /* ===== Content Sections ===== */
        .content-section { padding: 80px 0; background: var(--white); }
        .content-section.alt { background: var(--bg); }
        .section-title { font-size: 2.2rem; font-weight: 600; color: var(--navy); margin-bottom: 1rem; }
        .section-subtitle { color: var(--gold-dark); font-weight: 600; font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 0.5rem; display: block; }
        .section-desc { color: var(--text-secondary); max-width: 600px; margin: 0 auto; line-height: 1.7; }

        /* ===== Footer ===== */
        footer { background: var(--bg-alt); border-top: 1px solid var(--border); padding: 80px 0 30px; }
        .footer-logo { display: inline-block; margin-bottom: 1.5rem; }
        .footer-logo img { height: 40px; width: auto; }
        .footer-links { list-style: none; padding: 0; }
        .footer-links li { margin-bottom: 0.8rem; font-size: 0.9rem; }
        .footer-links li a { color: var(--text-secondary); display: inline-block; transition: transform 0.2s ease; }
        .footer-links li a:hover { color: var(--gold-dark); transform: translateX(5px); }
        .footer-heading { font-family: var(--font); font-weight: 700; color: var(--navy); margin-bottom: 1.5rem; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; }
        .footer-social { display: flex; gap: 12px; margin-top: 1.5rem; }
        .social-btn { width: 40px; height: 40px; border-radius: 50%; background: var(--bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--navy); font-size: 1rem; transition: all var(--speed); }
        .social-btn:hover { background: var(--navy); color: var(--white); transform: translateY(-5px) rotate(5deg); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); }
        .footer-bottom { border-top: 1px solid var(--border); margin-top: 60px; padding-top: 30px; text-align: center; color: var(--text-muted); font-size: 0.85rem; }

        /* ===== WhatsApp Float ===== */
        .wa-float {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #25D366;
            color: #fff;
            padding: 12px 20px 12px 16px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.4);
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            overflow: visible;
        }
        .wa-float:hover { transform: translateY(-3px) scale(1.05); box-shadow: 0 12px 40px rgba(37, 211, 102, 0.5); color: #fff; }
        .wa-float__icon { display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; font-size: 1.4rem; flex-shrink: 0; }
        .wa-float__text { white-space: nowrap; }
        .wa-float__pulse { position: absolute; top: -4px; right: -4px; width: 16px; height: 16px; background: #ff4444; border-radius: 50%; border: 2px solid #fff; animation: waPulse 2s infinite; }
        @keyframes waPulse { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.7; } 100% { transform: scale(1); opacity: 1; } }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(27, 42, 74, 0.98);
                backdrop-filter: blur(20px);
                border-radius: var(--radius-lg);
                padding: 1.5rem;
                margin-top: 1rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                border: 1px solid rgba(198, 169, 98, 0.2);
            }
            .navbar-nav { gap: 0.5rem; }
            .nav-link { padding: 0.75rem 1rem !important; border-radius: var(--radius); text-align: center; color: rgba(255, 255, 255, 0.9) !important; }
            .nav-link:hover { background: rgba(198, 169, 98, 0.15); color: var(--gold-light) !important; }
            .navbar .d-flex { flex-direction: column; gap: 0.75rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(198, 169, 98, 0.2); }
            .navbar .d-flex .nav-link, .navbar .d-flex .btn-gold { width: 100%; justify-content: center; text-align: center; }
        }

        @media (max-width: 768px) {
            .page-header h1 { font-size: 2rem; }
            .section-title { font-size: 1.8rem; }
            .wa-float { bottom: 16px; right: 16px; padding: 10px 16px 10px 14px; font-size: 0.85rem; }
            .wa-float__icon { width: 28px; height: 28px; font-size: 1.2rem; }
        }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="border-color: rgba(255,255,255,0.3);">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.cari-tema') }}">Cari Tema</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.fitur') }}">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.harga') }}">Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.bantuan') }}">Bantuan</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard.user') }}" class="nav-link text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-gold">Mulai Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 reveal">
                    <a href="{{ route('landing') }}" class="footer-logo">
                        <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
                    </a>
                    <p class="text-secondary small" style="max-width: 350px;">Platform undangan digital premium untuk pernikahan dan momen spesial. Praktis, elegan, dan hemat biaya.</p>
                    <div class="footer-social">
                        <a href="https://wa.me/6285923431716" target="_blank" rel="noopener noreferrer" class="social-btn"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1 reveal" style="transition-delay: 0.1s;">
                    <h5 class="footer-heading">Layanan</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('pages.cari-tema') }}">Undangan Pernikahan</a></li>
                        <li><a href="{{ route('pages.cari-tema') }}">Undangan Digital</a></li>
                        <li><a href="{{ route('pages.cari-tema') }}">Cetak Undangan</a></li>
                        <li><a href="{{ route('pages.cari-tema') }}">Video Undangan</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 reveal" style="transition-delay: 0.2s;">
                    <h5 class="footer-heading">Tema Populer</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('pages.cari-tema', ['category' => 'Modern']) }}">Tema Modern</a></li>
                        <li><a href="{{ route('pages.cari-tema', ['category' => 'Rustic']) }}">Tema Rustic</a></li>
                        <li><a href="{{ route('pages.cari-tema', ['category' => 'Floral']) }}">Tema Floral</a></li>
                        <li><a href="{{ route('pages.cari-tema', ['category' => 'Islami']) }}">Tema Islami</a></li>
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

    <!-- WhatsApp Float -->
    <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20undangan%20digital."
        class="wa-float" target="_blank" rel="noopener noreferrer" aria-label="Chat WhatsApp">
        <span class="wa-float__icon"><i class="bi bi-whatsapp"></i></span>
        <span class="wa-float__text">Chat Kami</span>
        <span class="wa-float__pulse"></span>
    </a>

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

    @stack('scripts')
</body>

</html>

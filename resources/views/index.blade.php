<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeddingInv - Platform Undangan Digital Premium & Elegant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Bootstrap 5 -->
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

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

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

        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-display);
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
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--white) !important;
            transition: color var(--speed);
        }

        .navbar.scrolled .navbar-brand {
            color: var(--navy) !important;
        }

        .navbar-brand span {
            color: var(--gold);
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8) !important;
            margin: 0 0.8rem;
            font-size: 0.9rem;
            position: relative;
        }

        .navbar.scrolled .nav-link {
            color: var(--text-secondary) !important;
        }

        .nav-link:hover {
            color: var(--gold-light) !important;
        }

        .navbar.scrolled .nav-link:hover {
            color: var(--gold-dark) !important;
        }

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
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(198, 169, 98, 0.4);
        }

        /* ===== Hero Section ===== */
        .hero-section {
            min-height: 100vh;
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

        .hero-shape {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(198, 169, 98, 0.2);
            z-index: 1;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
            animation: float 8s infinite ease-in-out;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            right: -50px;
            border-color: rgba(255, 255, 255, 0.1);
            animation: float 10s infinite ease-in-out reverse;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 20%;
            right: 15%;
            background: radial-gradient(circle, rgba(198, 169, 98, 0.1) 0%, transparent 70%);
            border: none;
            animation: float 6s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, -20px);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        .hero-tag {
            display: inline-block;
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            background: rgba(198, 169, 98, 0.15);
            border: 1px solid rgba(198, 169, 98, 0.3);
            color: var(--gold-light);
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .hero-section h1 em {
            font-style: italic;
            color: var(--gold-light);
        }

        .hero-section p {
            font-size: 1.15rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2.5rem;
            font-weight: 300;
            line-height: 1.7;
        }

        /* Search Bar */
        .search-container {
            max-width: 600px;
            margin: 0 auto 2.5rem;
            position: relative;
        }

        .search-container input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border-radius: 50px;
            border: 1.5px solid transparent;
            background: var(--white);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            font-family: var(--font);
            font-size: 0.95rem;
            transition: all var(--speed) ease;
            outline: none;
        }

        .search-container input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(198, 169, 98, 0.2);
        }

        .search-container i {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .search-container .btn-search {
            position: absolute;
            right: 8px;
            top: 8px;
            bottom: 8px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0 1.8rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Tags */
        .tag-list {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag-item {
            padding: 0.5rem 1.4rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.82rem;
            font-weight: 500;
        }

        .tag-item.active,
        .tag-item:hover {
            background: var(--gold);
            color: var(--white);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.5rem;
            z-index: 2;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0) translateX(-50%);
            }

            40% {
                transform: translateY(-10px) translateX(-50%);
            }

            60% {
                transform: translateY(-5px) translateX(-50%);
            }
        }

        /* ===== Real Wedding Slider ===== */
        .real-wedding-section {
            padding: 80px 0;
            background: var(--white);
            border-bottom: 1px solid var(--border);
        }

        .section-header-center {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-subtitle {
            color: var(--gold-dark);
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .section-desc {
            color: var(--text-secondary);
            max-width: 500px;
            margin: 0 auto;
        }

        .wedding-slider {
            display: flex;
            gap: 40px;
            overflow-x: auto;
            padding: 20px 0 30px;
            scrollbar-width: none;
            justify-content: center;
        }

        .wedding-slider::-webkit-scrollbar {
            display: none;
        }

        .wedding-item {
            text-align: center;
            min-width: 140px;
            transition: transform var(--speed) ease;
        }

        .wedding-item:hover {
            transform: translateY(-8px);
        }

        .couple-avatar-group {
            position: relative;
            width: 110px;
            height: 110px;
            margin: 0 auto 15px;
        }

        .couple-avatar-group::before {
            content: '';
            position: absolute;
            inset: -8px;
            border: 1px dashed var(--gold);
            border-radius: 50%;
            opacity: 0.5;
        }

        .couple-avatar {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            border: 4px solid var(--white);
            box-shadow: 0 4px 15px rgba(27, 42, 74, 0.1);
            object-fit: cover;
            position: absolute;
        }

        .avatar-1 {
            top: 0;
            left: 0;
            z-index: 2;
        }

        .avatar-2 {
            bottom: 0;
            right: 0;
            z-index: 1;
        }

        .couple-names {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 4px;
            white-space: nowrap;
        }

        .wedding-date {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* ===== Features Section ===== */
        .features-section {
            padding: 80px 0;
            background: var(--bg);
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all var(--speed) ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), var(--gold-dark));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform var(--speed) ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold-light);
            box-shadow: 0 15px 40px rgba(27, 42, 74, 0.08);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: var(--gold-dark);
        }

        .feature-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
        }

        /* ===== Templates Grid (Original Style) ===== */
        .template-section {
            padding: 80px 0 100px;
            background: var(--bg-alt);
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        .template-card {
            border-radius: var(--radius);
            overflow: hidden;
            transition: all var(--speed) ease;
            background: transparent;
        }

        .template-img-container {
            aspect-ratio: 4/3;
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
            background: var(--bg);
            border: 1px solid var(--border);
        }

        .template-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .template-card:hover .template-img-container img {
            transform: scale(1.05);
        }

        .template-overlay {
            position: absolute;
            inset: 0;
            background: rgba(27, 42, 74, 0.6);
            backdrop-filter: blur(2px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity var(--speed) ease;
            gap: 10px;
        }

        .template-card:hover .template-overlay {
            opacity: 1;
        }

        .template-footer {
            padding: 12px 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--border);
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--navy);
        }

        .card-stats {
            display: flex;
            gap: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .card-stats i {
            font-size: 0.85rem;
        }

        .badge-pro {
            background: var(--gold);
            color: white;
            font-size: 0.65rem;
            padding: 1px 5px;
            border-radius: 3px;
            font-weight: 800;
        }

        /* ===== CTA Section ===== */
        .cta-section {
            padding: 80px 0;
            background: var(--navy);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(198, 169, 98, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-box {
            text-align: center;
            color: var(--white);
            position: relative;
            z-index: 2;
        }

        .cta-box h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .cta-box p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            font-weight: 300;
        }

        /* ===== Footer ===== */
        footer {
            background: var(--bg-alt);
            border-top: 1px solid var(--border);
            padding: 80px 0 30px;
        }

        .footer-logo {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            display: block;
            color: var(--navy);
        }

        .footer-logo span {
            color: var(--gold);
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
        }

        .footer-links li a:hover {
            color: var(--gold-dark);
            padding-left: 5px;
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
        }

        .social-btn:hover {
            background: var(--navy);
            color: var(--white);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            margin-top: 60px;
            padding-top: 30px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .navbar {
                background: rgba(27, 42, 74, 0.95);
                backdrop-filter: blur(10px);
            }

            .navbar.scrolled .navbar-brand,
            .navbar.scrolled .nav-link {
                color: var(--white) !important;
            }
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .cta-box h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">Wedding<span>Inv</span>.</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="border-color: rgba(255,255,255,0.3);">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#templates">Cari Tema</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Bantuan</a></li>
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>
        <div class="hero-shape shape-3"></div>

        <div class="container hero-content">
            <span class="hero-tag">Platform Undangan Digital Premium</span>
            <h1>Unggah Momen Spesial <br> dengan <em>Keindahan Abadi</em></h1>
            <p>Rancang undangan pernikahan digital yang memikat hati tamu Anda sejak detik pertama. Eksklusif, modern,
                dan mudah dibagikan.</p>

            <form action="{{ route('landing') }}#templates" method="GET">
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="Cari tema impian... (Rustic, Modern, Floral)"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn-search">Cari</button>
                </div>
            </form>

            <div class="tag-list">
                <a href="{{ route('landing') }}#templates"
                    class="tag-item {{ !request('category') || request('category') == 'All' ? 'active' : '' }}">Semua
                    Tema</a>
                @foreach($categories as $cat)
                    <a href="{{ route('landing', ['category' => $cat['name']]) }}#templates"
                        class="tag-item {{ request('category') == $cat['name'] ? 'active' : '' }}">{{ $cat['name'] }}</a>
                @endforeach
            </div>
        </div>

        <a href="#real-weddings" class="scroll-down">
            <i class="bi bi-chevron-double-down"></i>
        </a>
    </section>

    <!-- Real Wedding Social Proof -->
    <section class="real-wedding-section" id="real-weddings">
        <div class="container">
            <div class="section-header-center">
                <span class="section-subtitle">Portofolio Nyata</span>
                <h2 class="section-title">Telah Dipercaya 10.000+ Pasangan</h2>
                <p class="section-desc">Ribuan pasangan bahagia telah mempercayakan momen sakral mereka kepada kami.</p>
            </div>

            <div class="wedding-slider">
                @foreach($invitations as $invitation)
                    <a href="{{ route('invitation.detail', ['slug' => $invitation->slug]) }}" class="wedding-item">
                        <div class="couple-avatar-group">
                            <img src="{{ $invitation->foto_pria ? asset('storage/' . $invitation->foto_pria) : 'https://ui-avatars.com/api/?name=' . urlencode($invitation->groom_name) . '&background=E8D5A3&color=fff' }}"
                                class="couple-avatar avatar-1" alt="">
                            <img src="{{ $invitation->foto_wanita ? asset('storage/' . $invitation->foto_wanita) : 'https://ui-avatars.com/api/?name=' . urlencode($invitation->bride_name) . '&background=1B2A4A&color=fff' }}"
                                class="couple-avatar avatar-2" alt="">
                        </div>
                        <div class="couple-names">{{ $invitation->groom_nickname ?? $invitation->groom_name }} &
                            {{ $invitation->bride_nickname ?? $invitation->bride_name }}</div>
                        <div class="wedding-date">{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') }}
                        </div>
                    </a>
                @endforeach

                @if($invitations->count() < 5)
                    @for($i = 0; $i < 5 - $invitations->count(); $i++)
                        <div class="wedding-item opacity-50">
                            <div class="couple-avatar-group">
                                <img src="https://i.pravatar.cc/150?u={{ $i }}" class="couple-avatar avatar-1" alt="">
                                <img src="https://i.pravatar.cc/150?u={{ $i + 10 }}" class="couple-avatar avatar-2" alt="">
                            </div>
                            <div class="couple-names">Pasangan Baru</div>
                            <div class="wedding-date">Segera Datang</div>
                        </div>
                    @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header-center">
                <span class="section-subtitle">Keunggulan Kami</span>
                <h2 class="section-title">Mengapa Memilih WeddingInv?</h2>
                <p class="section-desc">Memberikan pengalaman terbaik untuk momen sekali seumur hidup Anda.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <h4>Desain Mobile First</h4>
                        <p>Tampilan indah dan responsif di semua layar smartphone, tablet, maupun desktop. Tamu Anda
                            akan kagum saat membukanya.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-music-note-beamed"></i></div>
                        <h4>Background Musik</h4>
                        <p>Tambahkan lagu favorit Anda sebagai musik latar untuk menciptakan suasana romantis saat
                            undangan dibuka.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-map"></i></div>
                        <h4>Google Maps Integrasi</h4>
                        <p>Tamu tidak akan tersesat. Integrasi peta langsung memandu mereka ke lokasi acara dengan satu
                            klik.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-gift"></i></div>
                        <h4>Kirim Amplop Digital</h4>
                        <p>Fasilitasi tamu untuk mengirimkan tanda kasih secara digital melalui transfer bank atau
                            e-wallet dengan aman.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-people"></i></div>
                        <h4>RSVP & Hitung Tamu</h4>
                        <p>Ketahui pasti berapa tamu yang akan hadir. Sistem RSVP otomatis memudahkan Anda mempersiapkan
                            acara.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-camera-reels"></i></div>
                        <h4>Galeri Foto & Video</h4>
                        <p>Bagikan momen pra-pernikan Anda melalui galeri foto interaktif dan video sinematik yang
                            memukau.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Templates Grid (Original Layout Restored) -->
    <section id="templates" class="template-section">
        <div class="container">
            <div class="section-header-center">
                <span class="section-subtitle">Galeri Inspirasi</span>
                <h2 class="section-title">Koleksi Tema Eksklusif</h2>
                <p class="section-desc">Pilih dari puluhan desain premium yang dirancang oleh desainer profesional kami.
                </p>
            </div>

            <div class="template-grid">
                @foreach($templates as $template)
                    <div class="template-card">
                        <div class="template-img-container">
                            <img src="{{ $template->thumbnail ? asset('storage/' . $template->thumbnail) : 'https://placehold.co/600x450?text=No+Thumbnail' }}"
                                alt="{{ $template->name }}" loading="lazy">
                            <div class="template-overlay">
                                <a href="{{ route('template.demo', ['slug' => $template->slug]) }}" target="_blank"
                                    class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">Pratinjau</a>
                                <a href="{{ route('invitation.create', ['template_id' => $template->id]) }}"
                                    class="btn btn-gold rounded-pill px-4 fw-bold shadow-sm">Gunakan</a>
                            </div>
                        </div>
                        <div class="template-footer">
                            <div class="user-info">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($template->name) }}&background=random"
                                    class="user-avatar" alt="">
                                <span class="user-name">{{ $template->name }}</span>
                                @if($loop->index % 4 == 0)
                                    <span class="badge-pro">PREMIUM</span>
                                @endif
                            </div>
                            <div class="card-stats">
                                <span title="Dilihat"><i class="bi bi-eye"></i>
                                    {{ number_format($template->views_count) }}</span>
                                <span title="Suka" class="like-btn" data-id="{{ $template->id }}" style="cursor: pointer;">
                                    <i class="bi bi-heart-fill text-danger"></i>
                                    <span class="likes-count">{{ number_format($template->likes_count) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($templates->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted display-1 opacity-25"></i>
                    <h3 class="text-muted mt-3">Tema tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci lain atau lihat semua tema.</p>
                    <a href="{{ route('landing') }}" class="btn btn-outline-dark mt-2 rounded-pill px-4">Lihat Semua
                        Tema</a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-box">
                <h2>Siap Memulai Perjalanan Anda?</h2>
                <p>Buat undangan digital impian Anda hari ini. Gratis untuk memulai, tanpa kartu kredit.</p>
                <a href="{{ route('register') }}" class="btn-gold" style="font-size: 1rem; padding: 1rem 2.5rem;">
                    Buat Undangan Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <a href="#" class="footer-logo">Wedding<span>Inv</span>.</a>
                    <p class="text-secondary small" style="max-width: 350px;">Solusi undangan digital premium untuk
                        pernikahan, khitanan, aqiqah, dan berbagai momen spesial lainnya. Praktis, elegan, dan hemat
                        biaya.</p>
                    <div class="footer-social">
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-tiktok"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1">
                    <h5 class="footer-heading">Layanan</h5>
                    <ul class="footer-links">
                        <li><a href="#">Undangan Pernikahan</a></li>
                        <li><a href="#">Undangan Digital</a></li>
                        <li><a href="#">Cetak Undangan</a></li>
                        <li><a href="#">Video Undangan</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h5 class="footer-heading">Tema Populer</h5>
                    <ul class="footer-links">
                        <li><a href="#">Tema Modern</a></li>
                        <li><a href="#">Tema Rustic</a></li>
                        <li><a href="#">Tema Floral</a></li>
                        <li><a href="#">Tema Islami</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h5 class="footer-heading">Informasi</h5>
                    <ul class="footer-links">
                        <li><a href="#">Cara Pemesanan</a></li>
                        <li><a href="#">Pertanyaan (FAQ)</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 WeddingInv Digital Invitation. Dibuat dengan <i class="bi bi-heart-fill text-danger"></i>
                    di Indonesia.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar Scroll Effect
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Like Button Logic
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const countSpan = this.querySelector('.likes-count');
                const heartIcon = this.querySelector('i');

                if (this.classList.contains('processing')) return;
                this.classList.add('processing');

                fetch(`/templates/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            countSpan.textContent = data.likes_count.toLocaleString();
                            heartIcon.classList.remove('bi-heart-fill');
                            heartIcon.classList.add('bi-heart');
                            setTimeout(() => {
                                heartIcon.classList.remove('bi-heart');
                                heartIcon.classList.add('bi-heart-fill');
                            }, 200);
                        }
                        this.classList.remove('processing');
                    })
                    .catch(err => {
                        console.error(err);
                        this.classList.remove('processing');
                    });
            });
        });
    </script>
</body>

</html>
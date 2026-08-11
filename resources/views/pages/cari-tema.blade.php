<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Tema - WeddingInv</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/fav.png') }}">
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

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-15px) translateX(5px);
            }
        }

        @keyframes pulseSoft {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
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

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Navbar */
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

        /* Sistem pertukaran logo */
        .navbar-brand img {
            height: 40px;
            width: auto;
            transition: opacity var(--speed) ease;
        }

        .navbar-brand .logo-white {
            display: none;
        }

        .navbar-brand .logo-dark {
            display: block;
        }

        /* Saat navbar di atas (background gelap), tampilkan logo putih */
        .navbar:not(.scrolled) .navbar-brand .logo-white {
            display: block;
        }

        .navbar:not(.scrolled) .navbar-brand .logo-dark {
            display: none;
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
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(198, 169, 98, 0.5);
            color: var(--white) !important;
        }

        /* Page Header */
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

        .page-header-shape.shape-1 {
            width: 300px;
            height: 300px;
            top: -80px;
            left: -80px;
        }

        .page-header-shape.shape-2 {
            width: 200px;
            height: 200px;
            bottom: -40px;
            right: -40px;
            border-color: rgba(255, 255, 255, 0.1);
            animation-direction: reverse;
            animation-duration: 12s;
        }

        .page-header-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: -1px;
            animation: fadeInUp 1s ease-out forwards;
        }

        .page-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
            animation: fadeInUp 1s ease-out 0.3s forwards;
            opacity: 0;
        }

        .breadcrumb {
            justify-content: center;
            animation: fadeInUp 1s ease-out 0.5s forwards;
            opacity: 0;
        }

        .breadcrumb-item a {
            color: var(--gold-light);
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Content Sections */
        .content-section {
            padding: 80px 0;
            background: var(--white);
        }

        .content-section.alt {
            background: var(--bg);
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 1rem;
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

        .section-desc {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .theme-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            height: 100%;
        }

        .theme-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-light);
            box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1);
        }

        .theme-card-img {
            aspect-ratio: 4/3;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--gold);
            position: relative;
            overflow: hidden;
        }

        .theme-card-img::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(27, 42, 74, 0.3));
        }

        .theme-card-body {
            padding: 1.5rem;
        }

        .theme-card-body h5 {
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .theme-card-body p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        .theme-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            background: rgba(198, 169, 98, 0.1);
            color: var(--gold-dark);
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .category-scroll {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            padding: 1rem 0;
            scrollbar-width: none;
        }

        .category-scroll::-webkit-scrollbar {
            display: none;
        }

        .category-chip {
            flex: 0 0 auto;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            background: var(--white);
            border: 1px solid var(--border);
            color: var(--text);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all var(--speed);
            cursor: pointer;
            text-decoration: none;
        }

        .category-chip:hover,
        .category-chip.active {
            background: var(--navy);
            color: var(--white);
            border-color: var(--navy);
            transform: translateY(-3px);
        }

        .search-box {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }

        .search-box form {
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 1rem 1.5rem 1rem 3rem;
            border-radius: 50px;
            border: 1.5px solid var(--border);
            background: var(--white);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            font-family: var(--font);
            font-size: 0.95rem;
            outline: none;
            transition: all var(--speed);
        }

        .search-box input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(198, 169, 98, 0.2);
        }

        .search-box i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box .btn-search {
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

        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        .template-card {
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
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
            transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .template-card:hover .template-img-container img {
            transform: scale(1.08);
        }

        .template-overlay {
            position: absolute;
            inset: 0;
            background: rgba(27, 42, 74, 0.7);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s ease;
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

        .info-box {
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            border: 1px solid var(--gold-light);
            border-radius: var(--radius-lg);
            padding: 2rem;
        }

        .info-box h4 {
            color: var(--navy);
            margin-bottom: 0.75rem;
        }

        .info-box p {
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.7;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-list li {
            padding: 0.75rem 0;
            padding-left: 2.5rem;
            position: relative;
            color: var(--text-secondary);
        }

        .feature-list li i {
            position: absolute;
            left: 0;
            top: 0.85rem;
            color: var(--gold);
            font-size: 1.1rem;
        }

        /* Footer */
        footer {
            background: var(--bg-alt);
            border-top: 1px solid var(--border);
            padding: 80px 0 30px;
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
            margin-top: 60px;
            padding-top: 30px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('assets/logo-white.png') }}" alt="Logo WeddingInv" class="logo-white">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo WeddingInv" class="logo-dark">
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-shape shape-1"></div>
        <div class="page-header-shape shape-2"></div>
        <div class="container page-header-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cari Tema</li>
                </ol>
            </nav>
            <h1>Cari Tema</h1>
            <p>Temukan tema undangan digital yang sesuai dengan gaya pernikahan impian Anda.</p>
        </div>
    </section>

    <!-- Templates Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Jelajahi Koleksi</span>
                <h2 class="section-title">Temukan Tema Impian</h2>
                <p class="section-desc">Gunakan filter kategori atau kata kunci untuk menemukan tema yang pas.</p>
            </div>

            <div class="category-scroll mb-5 reveal">
                <a href="{{ route('pages.cari-tema') }}"
                    class="category-chip {{ !request('category') || request('category') == 'All' ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('pages.cari-tema', ['category' => $cat['name']]) }}#templates"
                        class="category-chip {{ request('category') == $cat['name'] ? 'active' : '' }}">
                        {{ $cat['name'] }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('pages.cari-tema') }}#templates" method="GET" class="search-box mb-5 reveal">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Cari tema... (contoh: Rustic, Modern, Floral)"
                    value="{{ request('search') }}">
                <button type="submit" class="btn-search">Cari</button>
            </form>

            <div class="template-grid">
                @foreach($templates as $template)
                    <div class="template-card reveal">
                        <div class="template-img-container">
                            <img src="{{ $template->thumbnail ? asset('storage/' . $template->thumbnail) : 'https://placehold.co/600x450?text=No+Thumbnail' }}"
                                alt="{{ $template->name }}" loading="lazy">
                            <div class="template-overlay">
                                <a href="{{ route('template.preview', ['slug' => 'romeo-juliet', 'id' => $template->id]) }}"
                                    target="_blank" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">Pratinjau</a>
                                <a href="{{ route('dashboard.user') }}?template_id={{ $template->id }}"
                                    class="btn btn-gold rounded-pill px-4 fw-bold shadow-sm">Gunakan</a>
                            </div>
                        </div>
                        <div class="template-footer">
                            <div class="user-info">
                                <img src="https://ui-avatars.com/api/?name={{urlencode($template->name)}}&background=random"
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
                <div class="text-center py-5 reveal">
                    <i class="bi bi-search text-muted display-1 opacity-25"></i>
                    <h3 class="text-muted mt-3">Tema tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci lain atau lihat semua tema.</p>
                    <a href="{{ route('pages.cari-tema') }}" class="btn btn-outline-dark mt-2 rounded-pill px-4">Lihat Semua
                        Tema</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Tips Section -->
    <section class="content-section alt">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 reveal">
                    <span class="section-subtitle">Tips Memilih Tema</span>
                    <h2 class="section-title">Pilih Tema yang Tepat</h2>
                    <p class="text-secondary mb-4">Tema yang tepat akan membuat undangan Anda terlihat lebih personal
                        dan berkesan.</p>
                    <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i> Sesuaikan dengan tema pernikahan Anda</li>
                        <li><i class="bi bi-check-circle-fill"></i> Pertimbangkan warna yang cocok dengan dress code
                        </li>
                        <li><i class="bi bi-check-circle-fill"></i> Pilih tema yang mudah dibaca di semua perangkat</li>
                        <li><i class="bi bi-check-circle-fill"></i> Gunakan pratinjau live sebelum memutuskan</li>
                    </ul>
                </div>
                <div class="col-lg-6 reveal" style="transition-delay: 0.2s;">
                    <div class="info-box">
                        <h4><i class="bi bi-lightbulb-fill text-warning me-2"></i>Siap Berkreasi?</h4>
                        <p>Jangan ragu untuk meminta bantuan tim kami dalam memilih tema yang paling cocok. Kami akan
                            membantu Anda menemukan desain yang sempurna untuk momen spesial Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="content-section text-center">
        <div class="container">
            <div class="reveal">
                <h2 class="section-title">Temukan Tema Favorit Anda</h2>
                <p class="section-desc mx-auto mb-4">Jelajahi galeri lengkap dengan puluhan tema eksklusif di halaman
                    utama.</p>
                <a href="{{ route('landing') }}#templates" class="btn-gold"
                    style="font-size: 1rem; padding: 1rem 2.5rem;">
                    Lihat Semua Tema <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 reveal">
                    <a href="#" class="footer-logo">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo WeddingInv">
                    </a>
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
                <p>&copy; 2024 WeddingInv Digital Invitation. Dibuat dengan <i class="bi bi-heart-fill text-danger"></i>
                    di Indonesia.</p>
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

        document.querySelectorAll('.category-chip').forEach(chip => {
            chip.addEventListener('click', function (e) {
                document.querySelectorAll('.category-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            });
        });

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

        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.add('active'); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.15 });
        reveals.forEach(reveal => observer.observe(reveal));
    </script>
</body>

</html>
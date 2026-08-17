<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - RuangUndang</title>
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

        /* Accordion */
        .accordion-item {
            border: 1px solid var(--border);
            border-radius: var(--radius) !important;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .accordion-item:hover {
            border-color: var(--gold-light);
        }

        .accordion-button {
            font-weight: 600;
            color: var(--navy);
            font-size: 1rem;
            padding: 1.25rem 1.5rem;
            background: var(--white);
            box-shadow: none !important;
        }

        .accordion-button:not(.collapsed) {
            color: var(--gold-dark);
            background: var(--bg-alt);
        }

        .accordion-button::after {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23C6A962' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        }

        .accordion-body {
            padding: 1.25rem 1.5rem;
            color: var(--text-secondary);
            line-height: 1.7;
            background: var(--bg-alt);
        }

        .info-box {
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            border: 1px solid var(--gold-light);
            border-radius: var(--radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
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

        .contact-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem;
            text-align: center;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .contact-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-light);
            box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1);
        }

        .contact-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
            color: var(--gold-dark);
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
                <img src="{{ asset('assets/logo-white.png') }}" alt="Logo RuangUndang" class="logo-white">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo RuangUndang" class="logo-dark">
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
                    <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                </ol>
            </nav>
            <h1>Pertanyaan Umum</h1>
            <p>Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan kami.</p>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section class="content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion reveal" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Apakah undangan digital ini bisa diakses di semua perangkat?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="faq1"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, undangan digital RuangUndang didesain dengan teknologi mobile-first sehingga
                                    dapat dibuka dengan sempurna di smartphone, tablet, maupun desktop. Tamu Anda dapat
                                    membukanya kapan saja tanpa perlu mengunduh aplikasi.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Berapa lama proses pembuatan undangan digital?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faq2"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Proses pembuatan undangan sangat cepat. Hanya membutuhkan waktu 5-10 menit untuk
                                    memilih tema, mengisi data, dan mendapatkan tautan undangan yang siap dibagikan.
                                    Untuk paket premium dengan fitur tambahan, prosesnya bisa sedikit lebih lama
                                    tergantung kompleksitas permintaan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Apakah saya bisa mengedit undangan setelah dibagikan?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faq3"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Tentu! Anda dapat mengedit teks, mengganti foto, memperbarui lokasi, dan bahkan
                                    mengubah tema sewaktu-waktu. Perubahan akan langsung terlihat oleh tamu tanpa perlu
                                    membuat undangan baru.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Bagaimana cara membagikan undangan kepada tamu?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="faq4"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Setelah undangan siap, Anda akan mendapatkan tautan unik yang dapat dibagikan
                                    melalui WhatsApp, Instagram, Facebook, Telegram, atau media sosial lainnya. Anda
                                    juga dapat mencetk kode QR untuk ditempel di kartu undangan fisik.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Apakah ada biaya bulanan atau tahunan?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="faq5"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk paket gratis, tidak ada biaya bulanan maupun tahunan. Untuk paket premium,
                                    biaya dibebankan per undangan atau per paket tertentu. Anda bebas memilih paket yang
                                    sesuai dengan kebutuhan dan anggaran.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq6">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Bagaimana jika saya membutuhkan bantuan?
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="faq6"
                                data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Tim support kami siap membantu Anda 24/7 melalui live chat, WhatsApp, dan email.
                                    Untuk paket premium, Anda juga mendapatkan dedicated support yang akan memandu
                                    proses pembuatan undangan dari awal hingga akhir.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="content-section alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Butuh Bantuan Lebih Lanjut?</span>
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-desc">Tim support kami siap membantu Anda kapan saja.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="contact-card">
                        <div class="contact-icon"><i class="bi bi-whatsapp"></i></div>
                        <h5>WhatsApp</h5>
                        <p class="text-secondary mb-0">+62 812-3456-7890</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="contact-card">
                        <div class="contact-icon"><i class="bi bi-envelope"></i></div>
                        <h5>Email</h5>
                        <p class="text-secondary mb-0">support@ruangundang.id</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="contact-card">
                        <div class="contact-icon"><i class="bi bi-chat-dots"></i></div>
                        <h5>Live Chat</h5>
                        <p class="text-secondary mb-0">Tersedia 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 reveal">
                    <a href="#" class="footer-logo">
                        <img src="{{ asset('assets/logo.png') }}" alt="Logo RuangUndang">
                    </a>
                    <p class="text-secondary small" style="max-width: 350px;">Saat ini kami menyediakan undangan digital untuk pernikahan. Untuk khitanan, aqiqah, dan momen spesial lainnya akan segera hadir. Praktis, elegan, dan hemat biaya.</p>
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
                <p>&copy; 2024 RuangUndang Digital Invitation. Dibuat dengan <i class="bi bi-heart-fill text-danger"></i>
                    di Indonesia.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        reveals.forEach(reveal => {
            observer.observe(reveal);
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeddingInv - Buat Undangan Pernikahan Digital Elegan</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Playfair Display (Elegant) & Poppins (Modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #D4AF37;
            /* Gold */
            --primary-dark: #b8962e;
            --secondary: #2C3E50;
            /* Dark Blue/Grey */
            --light-bg: #F9F9F9;
            --accent-pink: #fce4ec;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--secondary);
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Playfair Display', serif;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--secondary);
            font-size: 1.5rem;
            font-family: 'Playfair Display', serif;
        }

        .navbar-brand span {
            color: var(--primary);
        }

        .btn-nav {
            background-color: var(--secondary);
            color: white;
            border-radius: 50px;
            padding: 8px 25px;
            transition: all 0.3s;
        }

        .btn-nav:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            padding: 100px 0 80px;
            background: linear-gradient(to right, #fff 50%, var(--light-bg) 50%);
        }

        .hero-title {
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-img-wrapper {
            position: relative;
        }

        .hero-img {
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            border: 8px solid white;
            transform: rotate(-3deg);
            transition: transform 0.5s ease;
        }

        .hero-img:hover {
            transform: rotate(0deg) scale(1.02);
        }

        .float-card {
            position: absolute;
            bottom: -20px;
            left: -30px;
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Features Section */
        .feature-icon-box {
            width: 70px;
            height: 70px;
            background: var(--accent-pink);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s;
        }

        .feature-card:hover .feature-icon-box {
            background: var(--primary);
            color: white;
            transform: rotateY(180deg);
        }

        /* Template Showcase */
        .template-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            position: relative;
        }

        .template-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .template-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(44, 62, 80, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .template-card:hover .template-overlay {
            opacity: 1;
        }

        /* Steps Section */
        .step-number {
            font-size: 4rem;
            font-weight: 700;
            color: rgba(212, 175, 55, 0.2);
            /* Transparent Gold */
            font-family: 'Playfair Display', serif;
            line-height: 1;
            margin-bottom: -20px;
            position: relative;
            z-index: 0;
        }

        .step-content {
            position: relative;
            z-index: 1;
        }

        /* Pricing */
        .pricing-card {
            border: 1px solid #eee;
            border-radius: 20px;
            padding: 3rem 2rem;
            background: white;
            transition: all 0.3s;
            position: relative;
        }

        .pricing-card.popular {
            border: 2px solid var(--primary);
            box-shadow: 0 10px 40px rgba(212, 175, 55, 0.2);
            transform: scale(1.05);
            z-index: 2;
        }

        .badge-popular {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary);
            color: white;
            padding: 5px 20px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* CTA Section */
        .cta-section {
            background-color: var(--secondary);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            background-image: radial-gradient(#fff 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* Footer */
        footer {
            background-color: #1a252f;
            color: #bdc3c7;
            padding: 60px 0 20px;
        }

        .footer-link {
            color: #bdc3c7;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
            transition: color 0.3s;
        }

        .footer-link:hover {
            color: var(--primary);
        }

        @media (max-width: 991px) {
            .hero-section {
                background: var(--light-bg);
                padding: 50px 0;
                text-align: center;
            }

            .hero-img {
                transform: rotate(0);
                margin-top: 30px;
            }

            .float-card {
                left: 50%;
                transform: translateX(-50%);
                bottom: -25px;
                width: max-content;
            }

            @keyframes float {
                0% {
                    transform: translate(-50%, 0px);
                }

                50% {
                    transform: translate(-50%, -10px);
                }

                100% {
                    transform: translate(-50%, 0px);
                }
            }

            .pricing-card.popular {
                transform: scale(1);
            }
        }

    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Wedding<span>Inv</span>.
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">

                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#template">Template</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#harga">Harga</a>
                    </li>

                    {{-- AUTH --}}
                    @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="btn btn-nav">
                            Dashboard
                        </a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            Login
                        </a>
                    </li>

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-nav">
                            Register
                        </a>
                    </li>
                    @endif
                    @endauth

                </ul>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">#1 Platform Undangan Digital</span>
                    <h1 class="hero-title">Bagikan Kebahagiaan Pernikahanmu Tanpa Batas.</h1>
                    <p class="lead text-muted mb-4">Buat website undangan pernikahan yang elegan, lengkap dengan galeri foto, RSVP, dan musik latar dalam hitungan menit. Hemat biaya, ramah lingkungan.</p>
                    <div class="d-flex gap-3 flex-wrap justify-content-lg-start justify-content-center">
                        <a href="#template" class="btn btn-primary btn-lg rounded-pill px-4" style="background-color: var(--primary); border:none;">Lihat Template</a>
                        <a href="#fitur" class="btn btn-outline-secondary btn-lg rounded-pill px-4">Pelajari Lebih Lanjut</a>
                    </div>
                    <div class="mt-4 d-flex align-items-center gap-2 text-muted small">
                        <div class="d-flex">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                        </div>
                        <span>Dipercaya oleh 10.000+ Pengantin</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-img-wrapper">
                        <img src="https://picsum.photos/seed/weddingcouple/600/500" alt="Preview Undangan" class="img-fluid hero-img">
                        <div class="float-card">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div>
                                <div class="fw-bold">RSVP Masuk</div>
                                <div class="small text-muted">Anda hadir! 🎉</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-4 bg-white border-bottom">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold mb-0" style="color: var(--primary);">5k+</h2>
                    <p class="small text-muted mb-0 text-uppercase">Template Premium</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold mb-0" style="color: var(--primary);">24/7</h2>
                    <p class="small text-muted mb-0 text-uppercase">Layanan Support</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold mb-0" style="color: var(--primary);">100%</h2>
                    <p class="small text-muted mb-0 text-uppercase">Garansi Uang Kembali</p>
                </div>
                <div class="col-6 col-md-3">
                    <h2 class="fw-bold mb-0" style="color: var(--primary);">10k+</h2>
                    <p class="small text-muted mb-0 text-uppercase">Pernikahan Terlaksana</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-primary text-uppercase ls-2">Fitur Unggulan</h6>
                <h2 class="mb-3">Semua yang Anda Butuhkan dalam Satu Platform</h2>
                <p class="text-muted w-75 mx-auto">Kami menyediakan alat terbaik untuk membuat undangan pernikahan digital yang profesional dan personal.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-images"></i>
                        </div>
                        <h4>Galeri Foto Unlimited</h4>
                        <p class="text-muted">Unggah foto prewedding sebanyak yang Anda mau. Tampilkan momen indah dengan tata letak grid yang estetik.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-envelope-check"></i>
                        </div>
                        <h4>Manajemen RSVP Otomatis</h4>
                        <p class="text-muted">Pantau kehadiran tamu secara real-time. Export data tamu hadir ke Excel dengan mudah untuk keperluan catering.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-music-note-beamed"></i>
                        </div>
                        <h4>Background Music</h4>
                        <p class="text-muted">Pilih lagu romantis dari library kami atau upload lagu favorit kalian untuk mengiringi pembukaan undangan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-gift"></i>
                        </div>
                        <h4>Amplop Digital</h4>
                        <p class="text-muted">Fitur kirim hadiah atau transfer bank langsung melalui website. Praktis dan aman untuk tamu jauh.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h4>Drag & Drop Editor</h4>
                        <p class="text-muted">Sesuaikan tulisan, warna, dan layout sesuka hati tanpa perlu coding. Sangat mudah digunakan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-share"></i>
                        </div>
                        <h4>Share Link Mudah</h4>
                        <p class="text-muted">Sebarkan undangan melalui WhatsApp, Instagram, atau Facebook hanya dengan satu klik tombol share.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Template Showcase -->
    <section id="template" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-primary text-uppercase ls-2">Showcase</h6>
                <h2>Pilih Desain Sesuai Karaktermu</h2>
            </div>

            <div class="row g-4">
                <!-- Template 1 -->
                <div class="col-md-4">
                    <div class="template-card">
                        <img src="https://picsum.photos/seed/inv1/400/600" class="card-img-top" alt="Template Rustic">
                        <div class="template-overlay">
                            <button class="btn btn-light rounded-pill px-4 fw-bold">Preview Demo</button>
                        </div>
                        <div class="p-3 bg-white">
                            <h5 class="mb-1">Rustic Garden</h5>
                            <small class="text-muted">Kategori: Outdoor / Casual</small>
                        </div>
                    </div>
                </div>
                <!-- Template 2 -->
                <div class="col-md-4">
                    <div class="template-card">
                        <img src="https://picsum.photos/seed/inv2/400/600" class="card-img-top" alt="Template Elegant">
                        <div class="template-overlay">
                            <button class="btn btn-light rounded-pill px-4 fw-bold">Preview Demo</button>
                        </div>
                        <div class="p-3 bg-white">
                            <h5 class="mb-1">Gold Luxury</h5>
                            <small class="text-muted">Kategori: Indoor / Mewah</small>
                        </div>
                    </div>
                </div>
                <!-- Template 3 -->
                <div class="col-md-4">
                    <div class="template-card">
                        <img src="https://picsum.photos/seed/inv3/400/600" class="card-img-top" alt="Template Minimalist">
                        <div class="template-overlay">
                            <button class="btn btn-light rounded-pill px-4 fw-bold">Preview Demo</button>
                        </div>
                        <div class="p-3 bg-white">
                            <h5 class="mb-1">Sage Minimalist</h5>
                            <small class="text-muted">Kategori: Modern / Simple</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="#" class="btn btn-outline-dark rounded-pill px-5">Lihat Semua Template</a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <img src="https://picsum.photos/seed/weddingplanner/500/600" class="img-fluid rounded-4 shadow" alt="How it works">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h6 class="text-primary text-uppercase ls-2">Cara Kerja</h6>
                    <h2 class="mb-4">3 Langkah Mudah Menuju Hari Bahagia</h2>

                    <div class="mb-5 position-relative">
                        <div class="step-number">01</div>
                        <div class="step-content ps-4 border-start border-4 border-warning ms-2">
                            <h5>Pilih Template</h5>
                            <p class="text-muted">Telusuri ratusan desain template kami dan pilih yang paling merepresentasikan kisah cintamu.</p>
                        </div>
                    </div>

                    <div class="mb-5 position-relative">
                        <div class="step-number">02</div>
                        <div class="step-content ps-4 border-start border-4 border-warning ms-2">
                            <h5>Isi Data & Custom</h5>
                            <p class="text-muted">Masukkan detail acara, upload foto galeri, dan sesuaikan musik latar menggunakan editor kami.</p>
                        </div>
                    </div>

                    <div class="position-relative">
                        <div class="step-number">03</div>
                        <div class="step-content ps-4 border-start border-4 border-warning ms-2">
                            <h5>Sebarkan Undangan</h5>
                            <p class="text-muted">Undangan siap! Dapatkan link unik dan sebarkan ke kerabat dan sahabat via WhatsApp.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="harga" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2>Paket Harga Terjangkau</h2>
                <p class="text-muted">Investasi kecil untuk kenangan abadi.</p>
            </div>

            <div class="row align-items-center g-4 justify-content-center">
                <!-- Basic -->
                <div class="col-md-4">
                    <div class="pricing-card h-100">
                        <h4 class="text-muted mb-3">Basic</h4>
                        <h2 class="mb-4">Gratis <span class="fs-6 text-muted">/ selamanya</span></h2>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 1 Template Pilihan</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Maksimal 5 Foto</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> RSVP Standar</li>
                            <li class="mb-2 text-muted"><i class="bi bi-x-circle me-2"></i> Tanpa Musik</li>
                            <li class="mb-2 text-muted"><i class="bi bi-x-circle me-2"></i> Iklan Kecil</li>
                        </ul>
                        <a href="#" class="btn btn-outline-dark w-100 rounded-pill">Mulai Gratis</a>
                    </div>
                </div>

                <!-- Premium -->
                <div class="col-md-4">
                    <div class="pricing-card popular h-100">
                        <div class="badge-popular">Paling Laris</div>
                        <h4 class="text-dark mb-3">Premium</h4>
                        <h2 class="mb-4">Rp 149.000 <span class="fs-6 text-muted">/ undangan</span></h2>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> 100+ Template Premium</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Galeri Foto Unlimited</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Fitur Musik & Animasi</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Amplop Digital / Rekening</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Tanpa Iklan</li>
                        </ul>
                        <a href="#" class="btn w-100 rounded-pill text-white" style="background-color: var(--primary);">Pilih Premium</a>
                    </div>
                </div>

                <!-- Custom -->
                <div class="col-md-4">
                    <div class="pricing-card h-100">
                        <h4 class="text-muted mb-3">Exclusive</h4>
                        <h2 class="mb-4">Rp 499.000 <span class="fs-6 text-muted">/ undangan</span></h2>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Semua Fitur Premium</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Desain Khusus Request</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Domain Kustom (.com)</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Prioritas Support 24 Jam</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Revisi Tanpa Batas</li>
                        </ul>
                        <a href="#" class="btn btn-outline-dark w-100 rounded-pill">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container py-5 text-center">
            <i class="bi bi-quote fs-1 text-warning mb-3 d-block"></i>
            <h3 class="font-italic w-75 mx-auto mb-4">"Platform ini sangat membantu! Tamu-tamu saya banyak yang memuji undangannya karena unik dan ada galeri fotonya. Proses bikinnya juga cepet banget."</h3>
            <div>
                <img src="https://picsum.photos/seed/user1/60/60" class="rounded-circle mb-2" alt="User">
                <strong class="d-block">Sarah & Dimas</strong>
                <small class="text-muted">Pengguna Premium</small>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section text-center">
        <div class="cta-bg-pattern"></div>
        <div class="container position-relative">
            <h2 class="display-4 fw-bold mb-3">Siap Membuat Undanganmu?</h2>
            <p class="lead mb-5 text-white-50">Bergabunglah dengan ribuan pasangan lainnya. Buat undangan impianmu sekarang.</p>
            <a href="#daftar" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold text-dark shadow">Buat Undangan Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h4 class="text-white mb-3">WeddingInv.</h4>
                    <p class="small">Platform pembuatan undangan pernikahan digital #1 di Indonesia. Membantu momen bahagiamu tersebar ke seluruh dunia dengan mudah dan elegan.</p>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="text-white mb-3">Produk</h6>
                    <a href="#" class="footer-link">Template</a>
                    <a href="#" class="footer-link">Fitur</a>
                    <a href="#" class="footer-link">Harga</a>
                    <a href="#" class="footer-link">Contoh</a>
                </div>
                <div class="col-lg-2 col-6">
                    <h6 class="text-white mb-3">Perusahaan</h6>
                    <a href="#" class="footer-link">Tentang Kami</a>
                    <a href="#" class="footer-link">Karir</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Kontak</a>
                </div>
                <div class="col-lg-4">
                    <h6 class="text-white mb-3">Langganan Newsletter</h6>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email Anda" aria-label="Email">
                        <button class="btn btn-warning" type="button">Subscribe</button>
                    </div>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white fs-5"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white fs-5"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small">
                &copy; 2024 WeddingInv Digital. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Smooth Scroll Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

    </script>
</body>
</html>


@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-shape shape-1"></div>
        <div class="page-header-shape shape-2"></div>
        <div class="container page-header-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fitur</li>
                </ol>
            </nav>
            <h1>Fitur Unggulan</h1>
            <p>Semua yang Anda butuhkan untuk membuat undangan digital yang memukau.</p>
        </div>
    </section>

    <!-- Features Grid Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Keunggulan</span>
                <h2 class="section-title">Fitur Premium untuk Momen Spesial</h2>
                <p class="section-desc">Setiap fitur dirancang untuk memberikan pengalaman terbaik bagi Anda dan tamu.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <h4>Desain Mobile First</h4>
                        <p>Tampilan indah dan responsif di semua layar smartphone, tablet, maupun desktop.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.15s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-music-note-beamed"></i></div>
                        <h4>Background Musik</h4>
                        <p>Tambahkan lagu favorit sebagai musik latar untuk nuansa romantis.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-map"></i></div>
                        <h4>Google Maps Integrasi</h4>
                        <p>Peta langsung memandu tamu ke lokasi acara dengan satu klik.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.25s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-gift"></i></div>
                        <h4>Kirim Amplop Digital</h4>
                        <p>Fasilitasi tamu mengirim tanda kasih secara digital via transfer bank atau e-wallet.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-people"></i></div>
                        <h4>RSVP & Hitung Tamu</h4>
                        <p>Sistem RSVP otomatis memudahkan Anda mempersiapkan acara dengan presisi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.35s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-camera-reels"></i></div>
                        <h4>Galeri Foto & Video</h4>
                        <p>Bagikan momen pra-pernikahan melalui galeri interaktif dan video sinematik.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="content-section alt text-center">
        <div class="container">
            <div class="reveal">
                <h2 class="section-title">Semua Fitur dalam Satu Platform</h2>
                <p class="section-desc mx-auto mb-4">Dapatkan akses ke fitur-fitur premium dengan paket berlangganan kami.</p>
                <a href="{{ route('pages.harga') }}" class="btn-gold" style="font-size: 1rem; padding: 1rem 2.5rem;">
                    Lihat Harga <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <style>
        .feature-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2.5rem 2rem; height: 100%; transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1); position: relative; overflow: hidden; }
        .feature-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: linear-gradient(90deg, var(--gold), var(--gold-dark)); transform: scaleX(0); transform-origin: left; transition: transform 0.5s ease; }
        .feature-card:hover { transform: translateY(-10px); border-color: var(--gold-light); box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1); }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-icon { width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05)); display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; font-size: 1.5rem; color: var(--gold-dark); transition: all 0.5s ease; }
        .feature-card:hover .feature-icon { transform: scale(1.1) rotate(-5deg); background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--white); }
        .feature-card h4 { font-size: 1.2rem; font-weight: 600; color: var(--navy); margin-bottom: 0.75rem; }
        .feature-card p { color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6; margin: 0; }
    </style>
@endsection

@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Fitur</li>
                </ol>
            </nav>
            <h1>Fitur Unggulan</h1>
            <p>Semua yang Anda butuhkan untuk membuat undangan digital yang memukau dan berkesan.</p>
        </div>
    </section>

    <!-- Features Grid Section -->
    <section class="ev-section-light">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Keunggulan</span>
                <h2 class="ev-section-title">Fitur Premium untuk Momen Spesial</h2>
                <p class="ev-section-desc">Setiap fitur dirancang untuk memberikan pengalaman terbaik bagi Anda dan tamu.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal reveal-d1">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-phone"></i></div>
                        <h4>Desain Mobile First</h4>
                        <p>Tampilan indah dan responsif di semua layar smartphone, tablet, maupun desktop.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d15">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-music-note-beamed"></i></div>
                        <h4>Background Musik</h4>
                        <p>Tambahkan lagu favorit sebagai musik latar untuk nuansa romantis.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d2">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-map"></i></div>
                        <h4>Google Maps Integrasi</h4>
                        <p>Peta langsung memandu tamu ke lokasi acara dengan satu klik.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d25">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-gift"></i></div>
                        <h4>Kirim Amplop Digital</h4>
                        <p>Fasilitasi tamu mengirim tanda kasih secara digital via transfer bank atau e-wallet.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d3">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-people"></i></div>
                        <h4>RSVP & Hitung Tamu</h4>
                        <p>Sistem RSVP otomatis memudahkan Anda mempersiapkan acara dengan presisi.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d35">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-camera-reels"></i></div>
                        <h4>Galeri Foto & Video</h4>
                        <p>Bagikan momen pra-pernikahan melalui galeri interaktif dan video sinematik.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d1">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-camera-fill"></i></div>
                        <h4>Kamera Tamu &amp; Galeri Foto</h4>
                        <p>Tamu cukup memindai QR untuk berfoto langsung dengan bingkai elegan (Polaroid, Rustic, Minimal, atau tanpa frame). Foto otomatis tersimpan ke galeri tamu — lengkap dengan lightbox, pencarian nama, dan kuota 5 foto per perangkat.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d1">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-clock-history"></i></div>
                        <h4>Hitungan Mundur</h4>
                        <p>Jangan sampai terlewatkan momen indah, hitung mundur tanggal acara pernikahanmu.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d15">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-chat-heart"></i></div>
                        <h4>Berbagi Momen Indah dan Ucapan</h4>
                        <p>Tamu undangan bisa berbagi momen dengan mengirimkan gambar dan ucapan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d2">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-heart"></i></div>
                        <h4>Love Stories</h4>
                        <p>Ceritakan kisah cinta kamu dengan leluasa.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d25">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-camera-video"></i></div>
                        <h4>Live Streaming</h4>
                        <p>Tonton acara secara virtual agar jarak tidak menjadi keterbatasan.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d3">
                    <div class="ev-feature-card">
                        <div class="ev-feature-icon"><i class="bi bi-arrow-repeat"></i></div>
                        <h4>Live Update</h4>
                        <p>User bisa melihat update terbaru dari undangan secara langsung tanpa refresh.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="ev-section-alt text-center">
        <div class="container">
            <div class="reveal">
                <h2 class="ev-section-title">Semua Fitur dalam Satu Platform</h2>
                <p class="ev-section-desc mx-auto mb-4">Dapatkan akses ke fitur-fitur premium dengan paket berlangganan
                    kami.</p>
                <a href="{{ route('pages.harga') }}" class="ev-btn-hero-primary">
                    <span>Lihat Harga Paket</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

@endsection
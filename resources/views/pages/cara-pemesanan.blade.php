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
                    <li class="breadcrumb-item active" aria-current="page">Cara Pemesanan</li>
                </ol>
            </nav>
            <h1>Cara Pemesanan</h1>
            <p>Pelajari langkah mudah membuat undangan digital impian Anda.</p>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Langkah Mudah</span>
                <h2 class="section-title">Cara Membuat Undangan Digital</h2>
                <p class="section-desc">Hanya 4 langkah sederhana untuk membuat undangan digital yang memukau.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <ol class="guide-list">
                        <li class="reveal" style="transition-delay: 0.1s;">
                            <h5>1. Daftar Akun Gratis</h5>
                            <p>Buat akun dengan email atau Google. Proses cepat kurang dari 1 menit, tanpa kartu kredit.</p>
                        </li>
                        <li class="reveal" style="transition-delay: 0.15s;">
                            <h5>2. Pilih Template Favorit</h5>
                            <p>Jelajahi puluhan template premium dan pilih desain yang paling sesuai dengan gaya pernikahan Anda.</p>
                        </li>
                        <li class="reveal" style="transition-delay: 0.2s;">
                            <h5>3. Isi Data & Upload Foto</h5>
                            <p>Lengkapi informasi acara, upload foto pasangan, dan sesuaikan warna tema sesuai keinginan.</p>
                        </li>
                        <li class="reveal" style="transition-delay: 0.25s;">
                            <h5>4. Bagikan ke Tamu</h5>
                            <p>Dapatkan tautan unik dan bagikan via WhatsApp, Instagram, atau email dengan satu klik.</p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="content-section alt text-center">
        <div class="container">
            <div class="reveal">
                <h2 class="section-title">Siap Membuat Undangan Impian?</h2>
                <p class="section-desc mx-auto mb-4">Mulai gratis hari ini. Tanpa biaya tersembunyi, tanpa kartu kredit.</p>
                <a href="{{ route('register') }}" class="btn-gold" style="font-size: 1rem; padding: 1rem 2.5rem;">
                    Buat Undangan Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <style>
        .guide-list { list-style: none; padding: 0; counter-reset: guide-counter; }
        .guide-list li {
            padding: 1.5rem 1.5rem 1.5rem 4rem;
            position: relative;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .guide-list li:hover { border-color: var(--gold-light); transform: translateX(5px); box-shadow: 0 10px 30px rgba(27, 42, 74, 0.08); }
        .guide-list li::before {
            content: counter(guide-counter);
            counter-increment: guide-counter;
            position: absolute;
            left: 1rem;
            top: 1.5rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }
        .guide-list li h5 { color: var(--navy); margin-bottom: 0.5rem; font-size: 1.1rem; }
        .guide-list li p { color: var(--text-secondary); margin: 0; font-size: 0.9rem; }
    </style>
@endsection

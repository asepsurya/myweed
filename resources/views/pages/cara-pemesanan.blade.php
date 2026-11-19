@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cara Pemesanan</li>
                </ol>
            </nav>
            <h1>Cara Membuat & Memesan Undangan</h1>
            <p>Pelajari 4 langkah mudah untuk merancang dan membagikan undangan digital impian Anda.</p>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="ev-section-light">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Langkah Mudah</span>
                <h2 class="ev-section-title">Cara Membuat Undangan Digital</h2>
                <p class="ev-section-desc">Hanya 4 langkah sederhana untuk membuat undangan digital yang memukau.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <ol class="ev-guide-list">
                        <li class="reveal reveal-d1">
                            <h5>1. Daftar Akun Gratis</h5>
                            <p>Buat akun dengan email atau Google. Proses cepat kurang dari 1 menit, tanpa kartu kredit.</p>
                        </li>
                        <li class="reveal reveal-d2">
                            <h5>2. Pilih Template Favorit</h5>
                            <p>Jelajahi puluhan template premium dan pilih desain yang paling sesuai dengan gaya pernikahan
                                Anda.</p>
                        </li>
                        <li class="reveal reveal-d3">
                            <h5>3. Isi Data & Upload Foto</h5>
                            <p>Lengkapi informasi acara, upload foto pasangan, dan sesuaikan warna tema sesuai keinginan.
                            </p>
                        </li>
                        <li class="reveal reveal-d4">
                            <h5>4. Bagikan ke Tamu</h5>
                            <p>Dapatkan tautan unik dan bagikan via WhatsApp, Instagram, atau email dengan satu klik.</p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="ev-section-alt text-center">
        <div class="container">
            <div class="reveal">
                <h2 class="ev-section-title">Siap Membuat Undangan Impian?</h2>
                <p class="ev-section-desc mx-auto mb-4">Mulai gratis hari ini. Tanpa biaya tersembunyi, tanpa kartu kredit.
                </p>
                <a href="{{ route('register') }}" rel="nofollow" class="ev-btn-hero-primary">
                    <span>Buat Undangan Sekarang</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
@endsection
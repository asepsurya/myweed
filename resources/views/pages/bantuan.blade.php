@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pusat Bantuan</li>
                </ol>
            </nav>
            <h1>Pusat Bantuan & FAQ</h1>
            <p>Kami siap membantu Anda kapan saja. Temukan jawaban cepat atau hubungi tim support kami.</p>
        </div>
    </section>

    <!-- Help Cards Section -->
    <section class="ev-section-light">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Pusat Bantuan</span>
                <h2 class="ev-section-title">Ada Yang Bisa Dibantu?</h2>
                <p class="ev-section-desc">Pilih topik bantuan di bawah atau langsung hubungi kami.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal reveal-d1">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-book"></i></div>
                        <h4>Panduan Dasar</h4>
                        <p>Pelajari cara membuat undangan digital dari awal. Mulai dari pendaftrian hingga pembagian
                            undangan.</p>
                        <a href="{{ route('pages.cara-pemesanan') }}" class="ev-host-card-link">
                            Lihat Panduan <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d2">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-question-circle"></i></div>
                        <h4>FAQ</h4>
                        <p>Temukan jawaban cepat untuk pertanyaan yang sering diajukan seputar layanan undangan digital.</p>
                        <a href="{{ route('pages.faq') }}" class="ev-host-card-link">
                            Lihat FAQ <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d3">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>WhatsApp Support</h4>
                        <p>Chat langsung dengan tim support kami. Respons dalam 1x24 jam untuk membantu kebutuhan Anda.</p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya."
                            target="_blank" rel="noopener noreferrer" class="ev-host-card-link">
                            Hubungi Kami <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guide List Section -->
    <section class="ev-section-alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Langkah Cepat</span>
                <h2 class="ev-section-title">Mulai Membuat Undangan</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <ol class="ev-guide-list">
                        <li class="reveal reveal-d1">
                            <h5>Buat Akun Baru</h5>
                            <p>Daftar dengan email atau Google. Verifikasi otomatis langsung masuk.</p>
                        </li>
                        <li class="reveal reveal-d2">
                            <h5>Pilih Tema Favorit</h5>
                            <p>Jelajahi galeri tema dan pilih desain yang paling sesuai dengan gaya pernikahan Anda.</p>
                        </li>
                        <li class="reveal reveal-d3">
                            <h5>Isi Data & Upload Foto</h5>
                            <p>Masukkan informasi acara dan foto pasangan. Semua dapat diedit kapan saja.</p>
                        </li>
                        <li class="reveal reveal-d4">
                            <h5>Bagikan ke Tamu</h5>
                            <p>Dapatkan tautan unik dan bagikan via WhatsApp, Instagram, atau email.</p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="ev-section-light">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Kontak Kami</span>
                <h2 class="ev-section-title">Tim Support Siap Membantu</h2>
                <p class="ev-section-desc">Pilih saluran komunikasi yang paling nyaman untuk Anda.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal reveal-d1">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>WhatsApp</h4>
                        <p>Chat langsung dengan tim support. Respon cepat untuk pertanyaan teknis dan non-teknis.</p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya."
                            target="_blank" rel="noopener noreferrer" class="ev-host-card-link">+62 859-2343-1716</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d2">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-envelope"></i></div>
                        <h4>Email</h4>
                        <p>Kirim pertanyaan detail dan kami akan merespos dalam waktu kurang dari 1 jam.</p>
                        <a href="mailto:official@ruangundang.my.id" class="ev-host-card-link">official@ruangundang.my.id</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal reveal-d3">
                    <div class="ev-help-card">
                        <div class="ev-help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>Chat WhatsApp</h4>
                        <p>Tim support kami siap membantu. Klik ikon WhatsApp di pojok kanan bawah untuk memulai percakapan.
                        </p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya."
                            target="_blank" rel="noopener noreferrer" class="ev-host-card-link">Mulai Chat <i
                                class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
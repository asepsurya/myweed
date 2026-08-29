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
                    <li class="breadcrumb-item active" aria-current="page">Bantuan</li>
                </ol>
            </nav>
            <h1>Bantuan</h1>
            <p>Kami siap membantu Anda kapan saja. Temukan jawaban atau hubungi tim support kami.</p>
        </div>
    </section>

    <!-- Help Cards Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Pusat Bantuan</span>
                <h2 class="section-title">Ada Yang Bisa Dibantu?</h2>
                <p class="section-desc">Pilih topik bantuan di bawah atau langsung hubungi kami.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="help-card">
                        <div class="help-icon"><i class="bi bi-book"></i></div>
                        <h4>Panduan Dasar</h4>
                        <p>Pelajari cara membuat undangan digital dari awal. Mulai dari pendaftaran hingga pembagian undangan.</p>
                        <a href="{{ route('pages.cara-pemesanan') }}">Lihat Panduan <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="help-card">
                        <div class="help-icon"><i class="bi bi-question-circle"></i></div>
                        <h4>FAQ</h4>
                        <p>Temukan jawaban cepat untuk pertanyaan yang sering diajukan seputar layanan undangan digital.</p>
                        <a href="{{ route('pages.faq') }}">Lihat FAQ <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="help-card">
                        <div class="help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>WhatsApp Support</h4>
                        <p>Chat langsung dengan tim support kami. Respons dalam 1x24 jam untuk membantu kebutuhan Anda.</p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya." target="_blank" rel="noopener noreferrer">Hubungi Kami <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Guide List Section -->
    <section class="content-section alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Langkah Cepat</span>
                <h2 class="section-title">Mulai Membuat Undangan</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <ol class="guide-list">
                        <li class="reveal" style="transition-delay: 0.1s;">
                            <h5>Buat Akun Baru</h5>
                            <p>Daftar dengan email atau Google dalam 1 menit. Verifikasi otomatis langsung masuk.</p>
                        </li>
                        <li class="reveal" style="transition-delay: 0.15s;">
                            <h5>Pilih Tema Favorit</h5>
                            <p>Jelajahi galeri tema dan pilih desain yang paling sesuai dengan gaya pernikahan Anda.</p>
                        </li>
                        <li class="reveal" style="transition-delay: 0.2s;">
                            <h5>Isi Data & Upload Foto</h5>
                            <p>Masukkan informasi acara dan foto pasangan. Semua dapat diedit kapan saja.</p>
                        </li>
                        <li class="reveal" style="transition-delay: 0.25s;">
                            <h5>Bagikan ke Tamu</h5>
                            <p>Dapatkan tautan unik dan bagikan via WhatsApp, Instagram, atau email.</p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Kontak Kami</span>
                <h2 class="section-title">Tim Support Siap Membantu</h2>
                <p class="section-desc">Pilih saluran komunikasi yang paling nyaman untuk Anda.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="help-card">
                        <div class="help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>WhatsApp</h4>
                        <p>Chat langsung dengan tim support. Respon cepat untuk pertanyaan teknis dan non-teknis.</p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya." target="_blank" rel="noopener noreferrer">+62 859-2343-1716</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="help-card">
                        <div class="help-icon"><i class="bi bi-envelope"></i></div>
                        <h4>Email</h4>
                        <p>Kirim pertanyaan detail dan kami akan merespons dalam waktu kurang dari 1 jam.</p>
                        <a href="mailto:official@ruangundang.my.id">official@ruangundang.my.id</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="help-card">
                        <div class="help-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>Chat WhatsApp</h4>
                        <p>Tim support kami siap membantu. Klik ikon WhatsApp di pojok kanan bawah untuk memulai percakapan.</p>
                        <a href="https://wa.me/6285923431716?text=Halo%20RuangUndang%2C%20saya%20ingin%20bertanya." target="_blank" rel="noopener noreferrer">Mulai Chat <i class="bi bi-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .help-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            text-align: center;
            height: 100%;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .help-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-light);
            box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1);
        }
        .help-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.75rem;
            color: var(--gold-dark);
            transition: all 0.5s ease;
        }
        .help-card:hover .help-icon {
            transform: scale(1.1) rotate(-5deg);
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
        }
        .help-card h4 { color: var(--navy); margin-bottom: 0.75rem; }
        .help-card p { color: var(--text-secondary); font-size: 0.9rem; line-height: 1.6; margin: 0; }
        .help-card a { color: var(--gold-dark); font-weight: 600; }
        .guide-list { list-style: none; padding: 0; counter-reset: guide-counter; }
        .guide-list li {
            padding: 1rem 1.5rem;
            padding-left: 3.5rem;
            position: relative;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        .guide-list li:hover { border-color: var(--gold-light); transform: translateX(5px); }
        .guide-list li::before {
            content: counter(guide-counter);
            counter-increment: guide-counter;
            position: absolute;
            left: 1rem;
            top: 1rem;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .guide-list li h5 { color: var(--navy); margin-bottom: 0.25rem; }
        .guide-list li p { color: var(--text-secondary); margin: 0; font-size: 0.85rem; }
    </style>
@endsection

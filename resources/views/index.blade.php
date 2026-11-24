@extends('layouts.page')
@section('content')
    <style>
        .ev-hero-title,
        .ev-hero-desc {
            transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                filter 0.6s cubic-bezier(0.22, 1, 0.36, 1);
            will-change: opacity, transform, filter;
        }

        /* State saat teks keluar (menghilang ke atas + sedikit blur) */
        .ev-text-exit {
            opacity: 0;
            transform: translateY(-16px);
            filter: blur(4px);
        }

        /* State persiapan sebelum teks baru masuk (dari bawah) */
        .ev-text-enter {
            opacity: 0;
            transform: translateY(16px);
            filter: blur(4px);
            transition: none !important;
            /* Matikan transisi sesaat untuk reset posisi */
        }

        .ev-blog-meta-stats {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px 12px;
            margin-top: auto;
            padding-top: 10px;
        }

        .ev-blog-stats-right {
            display: inline-flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
            margin-left: auto;
        }

        .ev-blog-meta-stats span {
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
        }
    </style>

    <!-- =======================================================================
                                                                                                                                                                         SEARCH MODAL (Spotlight-Style)
                                                                                                                                                                         ======================================================================= -->
    <main id="mainContent">

        <!-- =======================================================================
                                                                                                                                                                             3. HERO SECTION (Evite Editorial Split Stage)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-hero-section">
            <div class="container">
                <div class="ev-hero-grid">
                    <!-- Left Editorial Content -->
                    <div class="ev-hero-content reveal">
                        <span class="ev-hero-tag">
                            <i class="bi bi-stars"></i> Platform Undangan Digital
                        </span>
                        <div class="ev-hero-content">
                            <h1 class="ev-hero-title" id="hero-title">
                                Undangan Digital &amp; Kartu Acara untuk Setiap <em>Momen Berharga.</em>
                            </h1>
                            <p class="ev-hero-desc" id="hero-desc">
                                Rancang undangan pernikahan, ulang tahun, dan syukuran dengan desain eksklusif, lagu
                                romantis,
                                buku tamu real-time, dan amplop digital. Bagikan via WhatsApp dalam hitungan detik.
                            </p>
                        </div>
                        <div class="ev-hero-actions">
                            <a href="#templates" class="ev-btn-hero-primary" id="heroExploreBtn">
                                <span>Jelajahi Tema Undangan</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="{{ route('register') }}" class="ev-btn-hero-secondary" id="heroStartFreeBtn">
                                <i class="bi bi-magic"></i>
                                <span>Buat Undangan Gratis</span>
                            </a>
                        </div>
                        <div class="ev-hero-trust">
                            <div class="ev-trust-item">
                                <i class="bi bi-patch-check-fill"></i>
                                <span>Tema Unik dan Menarik</span>
                            </div>
                            <div class="ev-trust-item">
                                <i class="bi bi-whatsapp"></i>
                                <span>100% WhatsApp Ready</span>
                            </div>
                            <div class="ev-trust-item">
                                <i class="bi bi-lightning-charge-fill"></i>
                                <span>Fitur yang Lengkap</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual Mockup Showcase (Phone Slider) -->
                    <div class="ev-hero-stage reveal reveal-d2">
                        <div class="ev-stage-backdrop"></div>

                        @php
                            $heroSlides = [
                                [
                                    'image' => asset('assets/images/hero/undangan-10.webp'),
                                    'alt' => 'Pratinjau Undangan Digital di dalam bingkai ponsel',
                                    'url' => route('pages.cari-tema'),
                                ],
                                [
                                    'image' => asset('assets/images/hero/undangan-8.webp'),
                                    'alt' => 'Pratinjau Undangan Digital di dalam bingkai ponsel',
                                    'url' => route('pages.cari-tema'),
                                ],
                                [
                                    'image' => asset('assets/images/hero/undangan-9.webp'),
                                    'alt' => 'Pratinjau Undangan Digital di dalam bingkai ponsel',
                                    'url' => route('pages.cari-tema'),
                                ],
                            ];
                        @endphp

                        <div class="ev-slider" id="heroSlider" aria-roledescription="carousel"
                            aria-label="Pratinjau Undangan Digital">
                            @foreach($heroSlides as $heroSlide)
                                <a href="{{ $heroSlide['url'] }}" class="ev-slide" aria-label="Lihat pratinjau undangan">
                                    <span class="ev-slide-device">
                                        <span class="ev-slide-screen">
                                            <img src="{{ $heroSlide['image'] }}" alt="{{ $heroSlide['alt'] }}" loading="lazy"
                                                width="229" height="500">
                                        </span>
                                        <span class="ev-slide-frame" aria-hidden="true">
                                            <img src="{{ asset('assets/images/hero/device-frame.png') }}" alt="" width="720"
                                                height="1416">
                                        </span>
                                    </span>
                                </a>
                            @endforeach
                        </div>

                        <div class="ev-slider-controls">
                            <button type="button" class="ev-slider-btn" id="heroSliderPrev"
                                aria-label="Undangan sebelumnya">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <div class="ev-slider-dots" id="heroSliderDots"></div>
                            <button type="button" class="ev-slider-btn" id="heroSliderNext"
                                aria-label="Undangan berikutnya">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>

                        <!-- Floating Badges -->
                        <div class="ev-floating-pill pill-1">
                            <span class="ev-pill-icon"><i class="bi bi-envelope-open-heart"></i></span>
                            <span>Amplop Digital &amp; QRIS</span>
                        </div>
                        <div class="ev-floating-pill pill-2">
                            <span class="ev-pill-icon"><i class="bi bi-geo-alt-fill"></i></span>
                            <span>Google Maps Presisi</span>
                        </div>
                        <!-- Floating Music Toggle -->
                        <button type="button" id="heroMusicToggle" class="ev-floating-pill hero-music-pill"
                            aria-label="Putar Musik Latar Undangan">
                            <span class="ev-pill-icon"><i class="bi bi-music-note-beamed"></i></span>
                            <span>Musik Latar</span>
                        </button>
                        <audio id="heroBgMusic" src="{{ asset('assets/audio/Ruang-Undang.mp3') }}" loop
                            preload="auto"></audio>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             4. HORIZONTAL CATEGORY CAROUSEL (Evite Invitation Categories)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-category-carousel-section" id="categories">
            <div class="container">
                <div class="ev-section-header reveal">
                    <div class="ev-section-title-wrap">
                        <span class="ev-section-subtitle">Kategori Undangan</span>
                        <h2 class="ev-section-title">Temukan Tema Sesuai Momen Spesial Anda</h2>
                        <p class="ev-section-desc">Pilihan template dirancang oleh desainer profesional untuk menciptakan
                            kesan pertama yang tak terlupakan.</p>
                    </div>
                    <div class="ev-carousel-controls">
                        <button class="ev-carousel-arrow" id="catScrollPrev" aria-label="Kategori Sebelumnya">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="ev-carousel-arrow" id="catScrollNext" aria-label="Kategori Berikutnya">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Carousel Scroll Track -->
                <div class="ev-carousel-wrapper reveal reveal-d1">
                    <div class="ev-carousel-track" id="catTrack">
                        <!-- Free Templates (All) -->
                        <div class="ev-category-card">
                            <a href="{{ route('pages.cari-tema') }}" class="ev-category-card-inner">
                                <div class="ev-category-icon-box">
                                    <i class="bi bi-grid"></i>
                                </div>
                                <h4 class="ev-category-name">Semua Tema</h4>
                                <span class="ev-category-count">{{ $templates->count() }}+ Desain</span>
                            </a>
                        </div>

                        @foreach($categories as $cat)
                            <div class="ev-category-card">
                                <a href="{{ route('pages.cari-tema', ['category' => $cat['name']]) }}"
                                    class="ev-category-card-inner">
                                    <div class="ev-category-icon-box">
                                        @if($cat['icon_svg'] || $cat['icon'])
                                            {!! category_icon_html($cat) !!}
                                        @else
                                            <img src="{{ $cat['img'] }}" alt="Undangan {{ $cat['name'] }}" loading="lazy">
                                        @endif
                                    </div>
                                    <h4 class="ev-category-name">{{ $cat['name'] }}</h4>
                                    {{-- <span class="ev-category-count">{{ $cat['count'] }}</span> --}}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             5. "WHAT DO YOU WANT TO DO TODAY?" (Evite 3-Card Value Grid)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-what-today-section">
            <div class="container">
                <div class="text-center reveal">
                    <span class="ev-section-subtitle">Pilihan Praktis</span>
                    <h2 class="ev-section-title">Apa yang Ingin Anda Buat Hari Ini?</h2>
                    <p class="ev-section-desc">Pilih kemudahan yang paling cocok untuk rencana perayaan Anda.</p>
                </div>

                <div class="ev-what-today-grid">
                    <!-- Card 1: Buat Undangan Digital -->
                    <div class="ev-action-card card-mint reveal reveal-d1">
                        <div class="ev-action-card-header">
                            <span class="ev-action-card-badge">Paling Populer</span>
                            <h3 class="ev-action-card-title">Buat Undangan Digital</h3>
                            <p class="ev-action-card-desc">
                                Pilih tema siap pakai yang elegan. Tambahkan detail acara, bagikan tautan via WhatsApp, dan
                                pantau RSVP tamu secara otomatis.
                            </p>
                        </div>
                        <div class="ev-action-card-visual">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=600&q=80"
                                alt="Buat Undangan Digital">
                        </div>
                        <a href="#templates" class="ev-action-card-cta">
                            <span>Pilih Tema Sekarang</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Card 2: Personalisasi Foto & Musik -->
                    <div class="ev-action-card card-peach reveal reveal-d2">
                        <div class="ev-action-card-header">
                            <span class="ev-action-card-badge">Kreatif &amp; Personal</span>
                            <h3 class="ev-action-card-title">Upload Foto &amp; Musik</h3>
                            <p class="ev-action-card-desc">
                                Ceritakan kisah cinta unik Anda. Unggah galeri foto pre-wedding, atur lagu latar romantis,
                                dan sertakan video sinematik.
                            </p>
                        </div>
                        <div class="ev-action-card-visual">
                            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=600&q=80"
                                alt="Personalisasi Foto dan Musik">
                        </div>
                        <a href="{{ route('register') }}" class="ev-action-card-cta">
                            <span>Mulai Personalisasi</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Card 3: Save The Date & Pengingat -->
                    <div class="ev-action-card card-buttercream reveal reveal-d3">
                        <div class="ev-action-card-header">
                            <span class="ev-action-card-badge">Fitur Eksklusif</span>
                            <h3 class="ev-action-card-title">Save The Date &amp; RSVP</h3>
                            <p class="ev-action-card-desc">
                                Kunci tanggal bahagia Anda di Google Calendar para tamu. Kirim pengingat otomatis menjelang
                                hari H tanpa repot chat satu per satu.
                            </p>
                        </div>
                        <div class="ev-action-card-visual">
                            <img src="https://images.unsplash.com/photo-1465495976277-4387d4b0b4c6?auto=format&fit=crop&w=600&q=80"
                                alt="Save the date kalender">
                        </div>
                        <a href="{{ route('pages.fitur') }}" class="ev-action-card-cta">
                            <span>Pelajari Fitur Jadwal</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                              6. PREVIEW DEMO LIVE EDITOR (Evite Signature Feature)
                                                                                                                                                                              ======================================================================= -->
        <style>
            .ev-demo-live-editor-section {
                background-color: #eef0f5;
                /* menyamakan warna latar belakang gambar */
            }

            .ev-demo-live-editor-section .ev-demo-header {
                max-width: 680px;
            }

            .ev-demo-live-editor-section .ev-demo-video-container {
                max-width: 1040px;
                margin-inline: auto;
            }

            .ev-demo-live-editor-section .ev-demo-video-wrapper {
                position: relative;
                border-radius: 1rem;
                overflow: hidden;
                background-color: #eef0f5;
            }

            .ev-demo-live-editor-section .ev-demo-video {
                display: block;
                width: 100%;
                height: auto;
                aspect-ratio: 16 / 10;
                object-fit: contain;
                /* memakai contain agar MacBook Air tidak terpotong */
                background-color: #eef0f5;
            }
        </style>
        <section class="ev-demo-live-editor-section py-5" aria-labelledby="demoLiveEditorHeading">
            <div class="container">
                <header class="ev-demo-header text-center mx-auto mb-4 mb-lg-5 reveal">
                    <span class="ev-section-subtitle d-inline-block fw-semibold text-uppercase small tracking-wide">
                        Live Editor
                    </span>
                    <h2 id="demoLiveEditorHeading" class="ev-section-title fw-bold mt-2 mb-2">
                        Atur Undangan &amp; Lihat Hasilnya Langsung
                    </h2>
                    <p class="ev-section-desc text-muted mb-0">
                        Sesuaikan kisah cinta, kutipan, musik, hingga detail acara undangan Anda dan pantau tampilannya
                        secara real-time di pratinjau.
                    </p>
                </header>

                <div class="ev-demo-video-container reveal">
                    <div class="ev-demo-video-wrapper">
                        <video class="ev-demo-video" autoplay muted loop playsinline preload="metadata"
                            aria-label="Demo langsung editor platform RuangUndang">
                            <source src="{{ asset('downloads/demo.webm') }}" type="video/webm">
                            Browser Anda tidak mendukung pemutaran video.
                        </video>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             7. "SOMETHING FOR EVERY KIND OF HOST" (Evite Feature Solutions)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-host-solutions-section">
            <div class="container">
                <div class="text-center reveal">
                    <span class="ev-section-subtitle">Solusi Lengkap</span>
                    <h2 class="ev-section-title">Fitur Terbaik untuk Setiap Tuan Rumah</h2>
                    <p class="ev-section-desc">Dari undangan hingga ucapan selamat, kami pastikan momen Anda tersaji
                        sempurna.</p>
                </div>

                <div class="ev-host-grid">
                    <!-- Feature 1 -->
                    <div class="ev-host-card reveal reveal-d1">
                        <div>
                            <div class="ev-host-icon-box">
                                <i class="bi bi-phone"></i>
                            </div>
                            <h3 class="ev-host-card-title">Undangan Web Interaktif</h3>
                            <p class="ev-host-card-text">
                                Buka amplop digital dengan animasi eksklusif, countdown hitung mundur tanggal acara, Google
                                Maps terintegrasi, dan pemutar musik autoplay.
                            </p>
                        </div>
                        <a href="{{ route('pages.fitur') }}" class="ev-host-card-link">
                            <span>Pelajari Fitur Web</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Feature 2 -->
                    <div class="ev-host-card reveal reveal-d2">
                        <div>
                            <div class="ev-host-icon-box">
                                <i class="bi bi-gift"></i>
                            </div>
                            <h3 class="ev-host-card-title">Buku Tamu &amp; Amplop QRIS</h3>
                            <p class="ev-host-card-text">
                                Tamu dapat menyampaikan doa restu yang tampil real-time serta mengirimkan amplop hadiah
                                melalui QRIS, transfer bank, atau dompet digital tanpa potongan.
                            </p>
                        </div>
                        <a href="{{ route('pages.fitur') }}" class="ev-host-card-link">
                            <span>Fitur Amplop Digital</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Feature 3 -->
                    <div class="ev-host-card reveal reveal-d3">
                        <div>
                            <div class="ev-host-icon-box">
                                <i class="bi bi-gem"></i>
                            </div>
                            <h3 class="ev-host-card-title">Beli Paket Sekali, Bebas Pilih Tema</h3>
                            <p class="ev-host-card-text">
                                Cukup beli paket satu kali dan pilih tema undangan semaunya tanpa biaya berulang, lengkap
                                dengan kustomisasi penuh dan akses praktis untuk acara Anda.
                            </p>
                        </div>
                        <a href="{{ route('pages.harga') }}" class="ev-host-card-link">
                            <span>Lihat Pilihan Paket</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Feature 4 -->
                    <div class="ev-host-card reveal reveal-d4">
                        <div>
                            <div class="ev-host-icon-box">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3 class="ev-host-card-title">Manajemen Tamu &amp; RSVP</h3>
                            <p class="ev-host-card-text">
                                Kelompokkan daftar tamu (VIP, keluarga, teman kantor), pantau jumlah hadir dan plus-one,
                                serta ekspor data ke Excel dengan satu klik mudah.
                            </p>
                        </div>
                        <a href="{{ route('pages.fitur') }}" class="ev-host-card-link">
                            <span>Kelola Daftar Tamu</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             8. "THERE'S MORE TO HOSTING THAN THE PARTY ITSELF" (Evite 3 Pillars)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-pillars-section">
            <div class="container">
                <div class="ev-pillars-header reveal">
                    <span class="text-uppercase fw-bold text-success-subtle small letter-spacing-1 d-block mb-2">KEMUDAHAN
                        PENUH</span>
                    <h2 class="ev-section-title">Lebih dari Sekadar Undangan. Kami Dampingi Kelancaran Acara Anda.</h2>
                    <p>Mempersiapkan hari bahagia tidak perlu bikin stres. Kami hadirkan fitur praktis yang menghemat waktu
                        dan biaya Anda.</p>
                </div>

                <div class="ev-pillars-grid">
                    <!-- Pillar 1: Daftar Nama Pengantin -->
                    <div class="ev-pillar-card reveal reveal-d1">
                        <div class="ev-pillar-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h3 class="ev-pillar-title">Daftar Nama Pengantin</h3>
                        <p class="ev-pillar-desc">
                            Catat dan siapkan data pasangan pengantin, nama panggilan, hingga informasi keluarga inti sejak
                            awal dengan rapi.
                        </p>
                    </div>

                    <!-- Pillar 2: Edit Undangan -->
                    <div class="ev-pillar-card reveal reveal-d2">
                        <div class="ev-pillar-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h3 class="ev-pillar-title">Edit Sesuai Selera</h3>
                        <p class="ev-pillar-desc">
                            Atur tema, kisah cinta, kutipan, musik, hingga jadwal waktu dan lokasi acara langsung dari
                            editor praktis.
                        </p>
                    </div>

                    <!-- Pillar 3: Share Undangan -->
                    <div class="ev-pillar-card reveal reveal-d3">
                        <div class="ev-pillar-icon">
                            <i class="bi bi-share"></i>
                        </div>
                        <h3 class="ev-pillar-title">Share ke Tamu Undangan</h3>
                        <p class="ev-pillar-desc">
                            Bagikan tautan undangan digital dengan cepat lewat WhatsApp atau media sosial agar tamu mudah
                            membuka kapan saja.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             9. DYNAMIC TEMPLATES GALLERY (Evite-Style Card Grid)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-templates-section" id="templates">
            <div class="container">
                <div class="ev-section-header reveal">
                    <div class="ev-section-title-wrap">
                        <span class="ev-section-subtitle">Galeri Desain</span>
                        <h2 class="ev-section-title">Koleksi Template Undangan Unggulan</h2>
                        <p class="ev-section-desc">Pilih tema favorit Anda dan langsung coba pratinjau interaktifnya.</p>
                    </div>
                    <a href="{{ route('pages.cari-tema') }}" class="ev-btn-hero-secondary d-none d-md-inline-flex">
                        Lihat Semua Tema ({{ $templates->count() }}+) →
                    </a>
                </div>
                <style>
                    /* Tampilan Default (Desktop) */
                    .ev-filter-tabs {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                        gap: 10px;
                    }

                    .ev-filter-btn {
                        padding: 10px 20px;
                        border-radius: 999px;
                        border: 1px solid #e2e8f0;
                        background-color: #ffffff;
                        color: #334155;
                        font-size: 14px;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.2s ease;
                    }

                    .ev-filter-btn.active,
                    .ev-filter-btn:hover {
                        background-color: var(--ev-green);
                        color: #ffffff;
                        border-color: var(--ev-green);
                    }

                    /* Tampilan Mobile: 1 Jajar & Bisa Digeser (Swipe) */
                    @media (max-width: 768px) {
                        .ev-filter-tabs {
                            flex-wrap: nowrap;
                            /* Paksa tetap 1 baris */
                            justify-content: flex-start;
                            /* Mulai dari rata kiri agar tidak terpotong */
                            overflow-x: auto;
                            /* Aktifkan geser samping */
                            -webkit-overflow-scrolling: touch;
                            /* Scroll halus di iOS */
                            padding: 4px 16px 12px 16px;
                            /* Ruang bernapas di sisi kiri & kanan */
                            gap: 8px;

                            /* Sembunyikan scrollbar (Firefox & IE/Edge) */
                            scrollbar-width: none;
                            -ms-overflow-style: none;
                        }

                        /* Sembunyikan scrollbar (Chrome, Safari, Opera) */
                        .ev-filter-tabs::-webkit-scrollbar {
                            display: none;
                        }

                        .ev-filter-btn {
                            flex: 0 0 auto;
                            /* Mencegah tombol menyusut/gepeng */
                            white-space: nowrap;
                            /* Mencegah teks turun ke baris baru */
                            padding: 8px 16px;
                            font-size: 13px;
                        }
                    }
                </style>
                <!-- Category Filter Tabs -->
                <div class="ev-filter-tabs reveal">
                    <button class="ev-filter-btn active" data-filter="all">Semua Tema</button>
                    @foreach($categories->take(6) as $cat)
                        <button class="ev-filter-btn" data-filter="{{ Str::slug($cat['name']) }}">
                            {{ $cat['name'] }}
                        </button>
                    @endforeach
                </div>

                <!-- Template Cards Grid -->
                <div class="ev-templates-grid" id="templateGrid">
                    @php $featuredTemplates = $templates->take(8); @endphp
                    @forelse($featuredTemplates as $template)
                        @php
                            $catSlug = $template->category ? Str::slug($template->category->name) : 'umum';
                            $thumb = template_thumbnail_url($template, $template->updated_at->timestamp);
                            $hasThumb = !empty($thumb) && !Str::contains($thumb, 'placehold.co');
                        @endphp
                        <div class="ev-template-card reveal" data-category="{{ $catSlug }}">
                            <div class="ev-template-media">
                                @if($hasThumb)
                                    <img src="{{ $thumb }}" alt="{{ $template->name }}" loading="lazy">
                                @else
                                    <div class="ev-template-noimage">
                                        <i class="bi bi-image"></i>
                                        <span>Tidak Ada Gambar</span>
                                    </div>
                                @endif
                                @if($template->templateType)
                                    <span class="ev-template-badge"
                                        style="background-color: {{ $template->templateType->color ?? '#425620' }}; color: #fff;">
                                        {{ $template->templateType->name }}
                                    </span>
                                @else
                                    <span class="ev-template-badge bg-white text-dark">
                                        {{ $template->category->name ?? 'Wedding' }}
                                    </span>
                                @endif

                                <!-- Hover Overlay with Action Buttons -->
                                <div class="ev-template-overlay">
                                    <a href="{{ route('template.frame', ['slug' => 'romeo-juliet', 'id' => $template->id]) }}"
                                        target="_blank" rel="nofollow" class="ev-overlay-btn-preview">
                                        <i class="bi bi-eye"></i> Pratinjau
                                    </a>
                                    <a href="{{ route('dashboard.user') }}?template_id={{ $template->id }}" rel="nofollow"
                                        class="ev-overlay-btn-use">
                                        <i class="bi bi-magic"></i> Gunakan Tema
                                    </a>
                                </div>
                            </div>
                            <div class="ev-template-meta">
                                <div class="ev-template-title-wrap">
                                    <h4 class="ev-template-name" title="{{ $template->name }}">{{ $template->name }}</h4>
                                    <span class="ev-template-cat-label">{{ $template->category->name ?? 'Pernikahan' }}</span>
                                </div>
                                <div class="ev-template-stats">
                                    <span class="ev-stat-item" title="Dilihat">
                                        <i class="bi bi-eye"></i> {{ number_format($template->views_count ?? 120) }}
                                    </span>
                                    <button class="ev-like-btn" data-id="{{ $template->id }}" title="Suka">
                                        <i class="bi bi-heart-fill"></i>
                                        <span class="likes-count">{{ number_format($template->likes_count ?? 24) }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-folder-x text-muted display-3 opacity-50"></i>
                            <h3 class="mt-3">Belum ada template aktif</h3>
                            <p class="text-muted">Silakan cek kembali beberapa saat lagi.</p>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('pages.cari-tema') }}" class="ev-btn-hero-primary">
                        <span>Jelajahi Semua Koleksi Desain</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             10. "OUR HOSTS SAY THE MOST" (Evite Testimonials)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-testimonials-section">
            <div class="container">
                <div class="text-center reveal">
                    <span class="ev-section-subtitle">Ulasan Nyata</span>
                    <h2 class="ev-section-title">Cerita Bahagia dari Para Tuan Rumah</h2>
                    <p class="ev-section-desc">Ribuan pasangan dan keluarga telah mempercayakan momen terbaik mereka kepada
                        RuangUndang.</p>
                </div>

                <div class="ev-testimonials-grid">
                    <!-- Testimonial 1 -->
                    <div class="ev-testimonial-card reveal reveal-d1">
                        <div>
                            <div class="ev-testi-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <blockquote class="ev-testi-quote">
                                “Sangat mudah digunakan! Tamu kami sangat terkesan dengan musik latar dan amplop digitalnya.
                                Kami bisa pantau konfirmasi kehadiran secara real-time via WhatsApp tanpa pusing.”
                            </blockquote>
                        </div>
                        <div class="ev-testi-author">
                            <div class="ev-author-avatar">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80"
                                    alt="Dinda & Farhan">
                            </div>
                            <div>
                                <h4 class="ev-author-name">Dinda &amp; Farhan</h4>
                                <p class="ev-author-event">Pernikahan di Jakarta • Tema Rustic</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="ev-testimonial-card reveal reveal-d2">
                        <div>
                            <div class="ev-testi-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <blockquote class="ev-testi-quote">
                                “Desainnya sangat elegan dan modern, jauh dari kesan pasaran. Integrasi petanya presisi
                                sekali, keluarga dari luar kota tidak ada yang tersasar ke lokasi resepsi.”
                            </blockquote>
                        </div>
                        <div class="ev-testi-author">
                            <div class="ev-author-avatar">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80"
                                    alt="Rian & Syifa">
                            </div>
                            <div>
                                <h4 class="ev-author-name">Rian &amp; Syifa</h4>
                                <p class="ev-author-event">Pernikahan di Bandung • Tema Minimalist</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="ev-testimonial-card reveal reveal-d3">
                        <div>
                            <div class="ev-testi-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <blockquote class="ev-testi-quote">
                                “Hemat budget banyak dibanding cetak fisik, dan proses pembuatannya cuma butuh waktu 10
                                menit. Fitur ucapan tamunya menghangatkan hati kami sekeluarga.”
                            </blockquote>
                        </div>
                        <div class="ev-testi-author">
                            <div class="ev-author-avatar">
                                <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=120&q=80"
                                    alt="Maya & Hendra">
                            </div>
                            <div>
                                <h4 class="ev-author-name">Maya &amp; Hendra</h4>
                                <p class="ev-author-event">Pernikahan di Surabaya • Tema Botanical</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             11. INSPIRATION & TIPS (Evite Editorial Blog Section)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-blog-section">
            <div class="container">
                <div class="ev-section-header reveal">
                    <div class="ev-section-title-wrap">
                        <span class="ev-section-subtitle">Inspirasi &amp; Panduan</span>
                        <h2 class="ev-section-title">Tips Menyelenggarakan Acara Sempurna</h2>
                        <p class="ev-section-desc">Artikel pilihan seputar etika undangan, perencanaan pernikahan, dan
                            manajemen tamu.</p>
                    </div>
                    <a href="{{ route('blog.index') }}" class="ev-btn-hero-secondary d-none d-md-inline-flex">
                        Panduan Lengkap →
                    </a>
                </div>

                <div class="ev-blog-grid">
                    @forelse($blogs ?? [] as $blog)
                        @php
                            $delayClass = 'reveal-d' . ($loop->iteration <= 4 ? $loop->iteration : 1);
                            $readingTime = max(1, (int) ceil(str_word_count(strip_tags($blog->content ?? '')) / 200));
                            $tagLabel = $blog->type === 'panduan' ? 'Panduan' : 'Inspirasi';
                        @endphp

                        <a href="{{ route('blog.show', $blog->slug) }}"
                            class="ev-blog-card reveal {{ $delayClass }} text-decoration-none">
                            <div class="ev-blog-img-box">
                                <img src="{{ $blog->image ? Storage::url($blog->image) : 'https://picsum.photos/seed/' . $blog->slug . '/500/320' }}"
                                    alt="{{ $blog->title }}" loading="lazy">
                            </div>

                            <div class="ev-blog-body">
                                <span class="ev-blog-tag">{{ $tagLabel }}</span>

                                <h4 class="ev-blog-title">{{ $blog->title }}</h4>

                                @if($blog->snippet)
                                    <p class="ev-blog-excerpt">
                                        {{ Str::limit($blog->snippet, 90, '...') }}
                                    </p>
                                @endif

                                <span class="ev-blog-meta ev-blog-meta-stats">
                                    <span class="ev-blog-read-time">
                                        <i class="bi bi-clock me-1"></i>{{ $readingTime }} menit
                                    </span>

                                    <span class="ev-blog-stats-right">
                                        {{-- <span><i class="bi bi-eye me-1"></i>{{ number_format($blog->views_count ?? 0, 0,
                                            ',', '.') }}</span> --}}
                                        <span><i
                                                class="bi bi-heart me-1"></i>{{ number_format($blog->likes_count ?? 0, 0, ',', '.') }}</span>
                                        <span><i
                                                class="bi bi-chat me-1"></i>{{ number_format($blog->comments_count ?? 0, 0, ',', '.') }}</span>
                                    </span>
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="text-muted">Belum ada artikel untuk ditampilkan.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             12. FAQ ACCORDION (Clean Evite Accordion)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-faq-section" id="faq">
            <div class="container">
                <div class="text-center reveal">
                    <span class="ev-section-subtitle">Tanya Jawab</span>
                    <h2 class="ev-section-title">Pertanyaan yang Sering Diajukan</h2>
                    <p class="ev-section-desc">Punya pertanyaan seputar undangan digital? Temukan jawabannya di sini.</p>
                </div>

                <div class="ev-faq-container">
                    <!-- Q1 -->
                    <div class="ev-faq-item is-open reveal reveal-d1">
                        <button class="ev-faq-question" type="button">
                            <span>Apa itu RuangUndang dan bagaimana cara kerjanya?</span>
                            <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                        </button>
                        <div class="ev-faq-answer">
                            <p>
                                RuangUndang adalah platform pembuatan undangan digital berbasis web yang memungkinkan Anda
                                merancang undangan pernikahan, ulang tahun, dan acara spesial dengan tampilan modern dalam
                                hitungan menit. Cukup pilih tema, isi detail acara &amp; foto, lalu sebarkan tautannya
                                melalui WhatsApp.
                            </p>
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="ev-faq-item reveal reveal-d2">
                        <button class="ev-faq-question" type="button">
                            <span>Apakah saya bisa mencoba membuat undangan secara gratis?</span>
                            <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                        </button>
                        <div class="ev-faq-answer">
                            <p>
                                Ya, tentu saja! Anda bisa mendaftar secara gratis tanpa kartu kredit, memilih template
                                gratis kami, dan melihat langsung bagaimana undangan Anda tampil sebelum memutuskan untuk
                                upgrade ke paket Pro jika membutuhkan fitur tambahan.
                            </p>
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="ev-faq-item reveal reveal-d3">
                        <button class="ev-faq-question" type="button">
                            <span>Bagaimana tamu mengakses undangan? Apakah butuh install aplikasi?</span>
                            <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                        </button>
                        <div class="ev-faq-answer">
                            <p>
                                Tamu tidak perlu mengunduh atau menginstal aplikasi apapun! Undangan dapat langsung dibuka
                                lewat browser di ponsel, tablet, atau komputer dengan mengetuk tautan yang Anda kirimkan
                                lewat WhatsApp atau media sosial.
                            </p>
                        </div>
                    </div>

                    <!-- Q4 -->
                    <div class="ev-faq-item reveal reveal-d4">
                        <button class="ev-faq-question" type="button">
                            <span>Bagaimana sistem amplop digital dan kado bekerja?</span>
                            <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                        </button>
                        <div class="ev-faq-answer">
                            <p>
                                Anda dapat mencantumkan nomor rekening bank (BCA, Mandiri, BRI, BNI) atau barcode QRIS
                                dompet digital (GoPay, OVO, ShopeePay, DANA). Tamu cukup memindai atau menyalin nomor
                                rekening untuk mentransfer kado langsung ke rekening Anda tanpa potongan perantara.
                            </p>
                        </div>
                    </div>

                    <!-- Q5 -->
                    <div class="ev-faq-item reveal">
                        <button class="ev-faq-question" type="button">
                            <span>Berapa lama masa aktif undangan digital setelah dibuat?</span>
                            <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                        </button>
                        <div class="ev-faq-answer">
                            <p>
                                Undangan digital Anda akan tetap aktif hingga acara selesai dan tersimpan abadi sebagai
                                kenang-kenangan digital yang dapat Anda buka kembali kapan saja.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =======================================================================
                                                                                                                                                                             13. FINAL CALL-TO-ACTION (Warm Evite Card Banner)
                                                                                                                                                                             ======================================================================= -->
        <section class="ev-cta-section" style="background-image: url('{{ asset('assets/cta-bg.jpg') }}');">
            <div class="container">
                <div class="ev-cta-card reveal">
                    <h2 class="ev-cta-title">Siap Mewujudkan Undangan Impian Anda?</h2>
                    <p class="ev-cta-desc">
                        Bergabunglah dengan ribuan pasangan yang telah merasakan kemudahan berbagi kabar bahagia bersama
                        RuangUndang. Gratis untuk memulai!
                    </p>
                    <div class="ev-cta-buttons">
                        <a href="{{ route('register') }}" class="ev-btn-hero-primary" id="footerCtaRegisterBtn">
                            <span>Buat Undangan Sekarang</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ route('pages.cari-tema') }}" class="ev-btn-hero-secondary">
                            <span>Lihat Koleksi Desain</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>



    <!-- =======================================================================
                                                                                                                                                                         PROMOTIONS POPUP MODAL (Preserved from original code)
                                                                                                                                                                         ======================================================================= -->
    @if($promotions->isNotEmpty())
        <style>
            #promoModal:not(.is-open) {
                display: none !important;
                pointer-events: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                z-index: 0 !important;
            }
            #promoModal:not(.is-open) *,
            #promoModal:not(.is-open) .carousel-item,
            #promoModal:not(.is-open) .carousel-item.active,
            #promoModal:not(.is-open) .promo-image,
            #promoModal:not(.is-open) .promo-video,
            #promoModal:not(.is-open) .promo-video-yt {
                display: none !important;
                pointer-events: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                z-index: 0 !important;
            }
            #promoModal.is-open {
                display: flex !important;
                pointer-events: auto !important;
                visibility: visible !important;
                opacity: 1 !important;
                z-index: 99999 !important;
            }
            #promoModal .promo-overlay__dialog {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                width: fit-content;
                max-width: 94vw;
                max-height: 92vh;
                margin: auto;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }
            #promoModal #promoCarousel {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                margin: 0 auto;
                background: transparent !important;
            }
            /* Kunci posisi selalu tepat di tengah: CSS Grid Stack */
            #promoModal .carousel-inner {
                display: grid !important;
                grid-template-areas: "slide" !important;
                align-items: center !important;
                justify-items: center !important;
                width: 100% !important;
                max-width: min(850px, 92vw) !important;
                margin: 0 auto !important;
                overflow: visible !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }
            #promoModal .carousel-item {
                grid-area: slide !important;
                float: none !important;
                margin: 0 auto !important;
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: center !important;
                justify-content: center !important;
                text-align: center !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
                pointer-events: none !important;
                transform: none !important;
                transition: opacity 0.35s ease-in-out, visibility 0.35s ease-in-out !important;
            }
            #promoModal.is-open .carousel-item.active,
            #promoModal.is-open .carousel-item.carousel-item-next.carousel-item-start,
            #promoModal.is-open .carousel-item.carousel-item-prev.carousel-item-end {
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
                transform: none !important;
            }
            #promoModal.is-open .carousel-item.active.carousel-item-start,
            #promoModal.is-open .carousel-item.active.carousel-item-end {
                opacity: 0 !important;
                transform: none !important;
            }
            #promoModal .promo-image {
                display: block !important;
                width: auto !important;
                height: auto !important;
                max-width: min(850px, 90vw) !important;
                max-height: 80vh !important;
                object-fit: contain !important;
                margin: 0 auto !important;
                border: 0 !important;
                border-radius: 0 !important;
                background: transparent !important;
                box-shadow: none !important;
                filter: drop-shadow(0 14px 32px rgba(0, 0, 0, 0.45)) !important;
            }
            /* YouTube Promo Clean (Hide Judul, Logo & Teks YouTube) */
            #promoModal .promo-youtube-clean {
                position: relative;
                width: min(850px, 90vw);
                aspect-ratio: 16 / 9;
                overflow: hidden !important;
                border-radius: 14px;
                background: #000000;
                box-shadow: 0 14px 32px rgba(0, 0, 0, 0.45);
                margin: 0 auto;
            }
            #promoModal .promo-youtube-clean .promo-video-yt {
                position: absolute;
                top: -14%;
                left: 0;
                width: 100%;
                height: 128%;
                border: 0;
                pointer-events: none;
            }
            #promoModal .promo-video-wrap,
            #promoModal .promo-video-link {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                text-decoration: none !important;
                cursor: pointer;
            }
            #promoModal video.promo-video {
                pointer-events: none !important;
            }
            #promoModal .promo-image-link {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 100% !important;
                text-decoration: none !important;
                cursor: pointer !important;
            }
            #promoModal a.promo-youtube-clean {
                cursor: pointer !important;
            }
        </style>
        <div id="promoModal" class="promo-overlay" style="display: none !important; z-index: 0 !important;" role="dialog" aria-modal="true" aria-label="Promosi" aria-hidden="true">
            <div class="promo-overlay__dialog">
                <button type="button" class="btn-close promo-modal-close" aria-label="Tutup" onclick="window.closePromo && window.closePromo()"></button>

                <div id="promoCarousel" class="carousel slide carousel-fade">
                    @if($promotions->count() > 1)
                        <div class="carousel-indicators">
                            @foreach($promotions as $index => $promotion)
                                <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="{{ $index }}"
                                    class="{{ $index === 0 ? 'active' : '' }}" aria-label="Promo {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif

                    <div class="carousel-inner">
                        @foreach($promotions as $index => $promotion)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                @if($promotion->media_type === 'video' && $promotion->video_file)
                                    @if($promotion->link_url)
                                        <a href="{{ $promotion->link_url }}" target="_blank" rel="noopener noreferrer" class="promo-video-link d-block">
                                            <video class="promo-video d-block" autoplay muted loop playsinline preload="metadata"
                                                disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback">
                                                <source src="{{ asset('storage/' . $promotion->video_file) }}">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        </a>
                                    @else
                                        <div class="promo-video-wrap">
                                            <video class="promo-video d-block" autoplay muted loop playsinline preload="metadata"
                                                disablepictureinpicture controlslist="nodownload nofullscreen noremoteplayback">
                                                <source src="{{ asset('storage/' . $promotion->video_file) }}">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        </div>
                                    @endif
                                @elseif($promotion->media_type === 'youtube' && $promotion->embed_url)
                                    @if($promotion->link_url)
                                        <a href="{{ $promotion->link_url }}" target="_blank" rel="noopener noreferrer" class="promo-youtube-clean d-block">
                                            <iframe class="promo-video-yt" src="{{ $promotion->embed_url }}"
                                                title="{{ $promotion->title ?? 'Promosi' }}" frameborder="0"
                                                allow="autoplay; encrypted-media; picture-in-picture"
                                                referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                        </a>
                                    @else
                                        <div class="promo-youtube-clean">
                                            <iframe class="promo-video-yt" src="{{ $promotion->embed_url }}"
                                                title="{{ $promotion->title ?? 'Promosi' }}" frameborder="0"
                                                allow="autoplay; encrypted-media; picture-in-picture"
                                                referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                        </div>
                                    @endif
                                @elseif($promotion->image)
                                    @if($promotion->link_url)
                                        <a href="{{ $promotion->link_url }}" target="_blank" rel="noopener noreferrer" class="promo-image-link">
                                            <img src="{{ asset('storage/' . $promotion->image) }}"
                                                alt="{{ $promotion->title ?? 'Promosi' }}" class="promo-image d-block">
                                        </a>
                                    @else
                                        <img src="{{ asset('storage/' . $promotion->image) }}"
                                            alt="{{ $promotion->title ?? 'Promosi' }}" class="promo-image d-block">
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if($promotions->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    var el = document.getElementById('promoModal');
                    if (!el) return;

                    // Render di luar <body> yang di-zoom (body { zoom: 0.8 }) agar
                    // posisi fixed menutupi seluruh viewport dan modal tidak bergeser.
                    if (el.parentNode !== document.documentElement) {
                        document.documentElement.appendChild(el);
                    }

                    var carouselEl = document.getElementById('promoCarousel');
                    var carouselInstance = null;
                    var body = document.body;
                    var previousPadding = body.style.paddingRight;

                    // Nonaktifkan geser otomatis: matikan auto-cycle Bootstrap sepenuhnya.
                    if (carouselEl && typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
                        carouselInstance = bootstrap.Carousel.getOrCreateInstance(carouselEl, {
                            interval: false,
                            ride: false,
                            pause: false,
                            touch: true,
                        });
                        carouselInstance.pause();
                    }

                    function playActiveVideo() {
                        if (!carouselEl) return;
                        carouselEl.querySelectorAll('video').forEach(function (v) {
                            v.pause();
                        });
                        var active = carouselEl.querySelector('.carousel-item.active video');
                        if (active) {
                            active.muted = true;
                            var p = active.play();
                            if (p && typeof p.catch === 'function') {
                                p.catch(function () {});
                            }
                        }
                    }

                    function openPromo() {
                        var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
                        var zoom = parseFloat(getComputedStyle(body).zoom) || 1;
                        if (scrollbarWidth > 0) {
                            body.style.paddingRight = (scrollbarWidth / zoom) + 'px';
                        }
                        body.style.overflow = 'hidden';
                        el.style.setProperty('z-index', '99999', 'important');
                        el.style.display = 'flex';
                        void el.offsetWidth;
                        el.classList.add('is-open');
                        el.setAttribute('aria-hidden', 'false');
                        if (carouselInstance) {
                            carouselInstance.pause();
                        }
                        playActiveVideo();
                    }

                    function closePromo() {
                        el.classList.remove('is-open');
                        el.setAttribute('aria-hidden', 'true');
                        el.style.setProperty('display', 'none', 'important');
                        el.style.setProperty('z-index', '0', 'important');
                        body.style.overflow = '';
                        body.style.paddingRight = previousPadding;
                        if (carouselEl) {
                            carouselEl.querySelectorAll('video').forEach(function (v) {
                                v.pause();
                            });
                        }
                    }
                    window.closePromo = closePromo;

                    var closeBtn = el.querySelector('.promo-modal-close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                            closePromo();
                        });
                    }
                    el.addEventListener('click', function (e) {
                        if (e.target === el || e.target.classList.contains('promo-overlay__dialog') || e.target.classList.contains('carousel-item')) {
                            closePromo();
                        }
                    });
                    document.addEventListener('keydown', function (e) {
                        if (e.key === 'Escape' && el.classList.contains('is-open')) closePromo();
                    });

                    if (carouselEl) {
                        carouselEl.addEventListener('slid.bs.carousel', playActiveVideo);
                        carouselEl.addEventListener('slide.bs.carousel', function () {
                            carouselEl.querySelectorAll('video').forEach(function (v) {
                                v.pause();
                            });
                        });
                    }

                    openPromo();
                }, 1500);
            });
        </script>
    @endif

    <!-- WhatsApp Floating Chat Component -->
    @include('components.wa-chat', [
        'phone' => '6285923431716',
        'message' => 'Halo RuangUndang, saya ingin bertanya tentang layanan undangan digital.',
        'title' => 'Chat WhatsApp RuangUndang',
        'mobileBottom' => 24
    ])

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Hero Phone Slider -->
    <script src="{{ asset('assets/js/landing-hero-slider.js') }}" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const heroSlides = [
                {
                    title: 'Undangan Digital &amp; Kartu Acara untuk Setiap <em>Momen Berharga.</em>',
                    desc: 'Rancang undangan pernikahan, ulang tahun, dan syukuran dengan desain eksklusif, lagu romantis, buku tamu real-time, dan amplop digital. Bagikan via WhatsApp dalam hitungan detik.'
                },
                {
                    title: 'Bagikan Kebahagiaan Pernikahan dengan <em>Desain Eksklusif.</em>',
                    desc: 'Dilengkapi fitur galeri foto HD, hitung mundur acara, navigasi Google Maps akurat, serta konfirmasi kehadiran (RSVP) langsung terhubung ke WhatsApp.'
                },
                {
                    title: 'Rayakan Ulang Tahun &amp; Syukuran Lebih <em>Praktis &amp; Berkesan.</em>',
                    desc: 'Buat kartu undangan digital kekinian tanpa ribet cetak. Kirim ke ratusan tamu hanya dengan satu klik dan pantau ucapan doa secara real-time.'
                }
            ];

            const titleEl = document.getElementById('hero-title');
            const descEl = document.getElementById('hero-desc');
            let currentIndex = 0;

            function changeHeroText() {
                // 1. Jalankan animasi keluar pada judul dan deskripsi (dengan jeda 100ms)
                titleEl.classList.add('ev-text-exit');
                setTimeout(() => {
                    descEl.classList.add('ev-text-exit');
                }, 100);

                // 2. Setelah animasi keluar selesai (600ms), ganti konten teks
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % heroSlides.length;

                    // Pindahkan posisi elemen ke bawah tanpa animasi
                    titleEl.classList.remove('ev-text-exit');
                    titleEl.classList.add('ev-text-enter');
                    titleEl.innerHTML = heroSlides[currentIndex].title;

                    descEl.classList.remove('ev-text-exit');
                    descEl.classList.add('ev-text-enter');
                    descEl.innerHTML = heroSlides[currentIndex].desc;

                    // Paksa browser membaca ulang layout (reflow)
                    void titleEl.offsetWidth;

                    // 3. Jalankan animasi masuk ke posisi normal
                    titleEl.classList.remove('ev-text-enter');
                    setTimeout(() => {
                        descEl.classList.remove('ev-text-enter');
                    }, 120);

                }, 650);
            }

            // Ganti teks setiap 4.5 detik (4500 ms)
            setInterval(changeHeroText, 4500);
        });
    </script>
    <!-- Evite Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Sticky Header Scroll Shadow
            const header = document.getElementById('mainHeader');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 30) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }, { passive: true });

            // 2. Mobile Drawer Navigation
            const drawer = document.getElementById('mobileDrawer');
            const backdrop = document.getElementById('drawerBackdrop');
            const openBtn = document.getElementById('mobileDrawerOpenBtn');
            const closeBtn = document.getElementById('mobileDrawerCloseBtn');

            function openDrawer() {
                drawer.classList.add('is-open');
                backdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                drawer.classList.remove('is-open');
                backdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            if (openBtn) openBtn.addEventListener('click', openDrawer);
            if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
            if (backdrop) backdrop.addEventListener('click', closeDrawer);

            // 3. Search Modal
            const searchModal = document.getElementById('searchModal');
            const searchModalBackdrop = document.getElementById('searchModalBackdrop');
            const searchTriggerBtn = document.getElementById('searchTriggerBtn');
            const mobileSearchBtn = document.getElementById('mobileSearchBtn');
            const searchModalClose = document.getElementById('searchModalClose');
            const searchModalInput = document.getElementById('searchModalInput');
            const searchModalClear = document.getElementById('searchModalClear');
            const searchModalForm = document.getElementById('searchModalForm');
            const searchRecentList = document.getElementById('searchRecentList');
            const searchRecentSection = document.getElementById('searchRecentSection');

            const RECENT_KEY = 'ru_recent_searches';

            function getRecentSearches() {
                try { return JSON.parse(localStorage.getItem(RECENT_KEY) || '[]'); } catch { return []; }
            }

            function saveRecentSearch(query) {
                if (!query.trim()) return;
                let arr = getRecentSearches().filter(q => q !== query);
                arr.unshift(query);
                arr = arr.slice(0, 5);
                localStorage.setItem(RECENT_KEY, JSON.stringify(arr));
            }

            function renderRecent() {
                const arr = getRecentSearches();
                if (!searchRecentList || !searchRecentSection) return;
                if (arr.length === 0) {
                    searchRecentSection.style.display = 'none';
                    return;
                }
                searchRecentSection.style.display = 'block';
                searchRecentList.innerHTML = arr.map(q => `
                                                                                                                                                                                    <li class="ev-search-recent-item">
                                                                                                                                                                                        <button type="button" class="ev-search-recent-btn" data-query="${q}">
                                                                                                                                                                                            <i class="bi bi-clock-history"></i>
                                                                                                                                                                                            <span>${q}</span>
                                                                                                                                                                                        </button>
                                                                                                                                                                                        <button type="button" class="ev-search-recent-remove" data-query="${q}" aria-label="Hapus">
                                                                                                                                                                                            <i class="bi bi-x"></i>
                                                                                                                                                                                        </button>
                                                                                                                                                                                    </li>
                                                                                                                                                                                `).join('');

                searchRecentList.querySelectorAll('.ev-search-recent-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const q = btn.getAttribute('data-query');
                        if (searchModalInput) searchModalInput.value = q;
                        if (searchModalForm) searchModalForm.submit();
                    });
                });
                searchRecentList.querySelectorAll('.ev-search-recent-remove').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const q = btn.getAttribute('data-query');
                        let arr2 = getRecentSearches().filter(x => x !== q);
                        localStorage.setItem(RECENT_KEY, JSON.stringify(arr2));
                        renderRecent();
                    });
                });
            }

            function openSearchModal() {
                if (!searchModal) return;
                searchModal.classList.add('is-open');
                searchModalBackdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
                renderRecent();
                setTimeout(() => { if (searchModalInput) searchModalInput.focus(); }, 80);
            }

            function closeSearchModal() {
                if (!searchModal) return;
                searchModal.classList.remove('is-open');
                searchModalBackdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            if (searchTriggerBtn) searchTriggerBtn.addEventListener('click', openSearchModal);
            if (mobileSearchBtn) mobileSearchBtn.addEventListener('click', openSearchModal);
            if (searchModalClose) searchModalClose.addEventListener('click', closeSearchModal);
            if (searchModalBackdrop) searchModalBackdrop.addEventListener('click', closeSearchModal);

            // Clear button
            if (searchModalInput && searchModalClear) {
                searchModalInput.addEventListener('input', () => {
                    searchModalClear.style.display = searchModalInput.value ? 'flex' : 'none';
                });
                searchModalClear.addEventListener('click', () => {
                    searchModalInput.value = '';
                    searchModalClear.style.display = 'none';
                    searchModalInput.focus();
                });
            }

            // Save on submit
            if (searchModalForm && searchModalInput) {
                searchModalForm.addEventListener('submit', () => {
                    saveRecentSearch(searchModalInput.value);
                });
            }

            // Filter pills ditangani oleh script global (layouts/page.blade.php)

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    if (searchModal && searchModal.classList.contains('is-open')) {
                        closeSearchModal();
                    } else {
                        openSearchModal();
                    }
                }
                if (e.key === 'Escape' && searchModal && searchModal.classList.contains('is-open')) {
                    closeSearchModal();
                }
            });

            // Mega menu: switch theme groups when a category is hovered/clicked
            const megaLinks = document.querySelectorAll('.mega-category-link');
            const themeGroups = document.querySelectorAll('.ev-mega-theme-group');

            function switchMegaCategory(catName) {
                megaLinks.forEach(link => link.classList.remove('active'));
                themeGroups.forEach(group => group.classList.remove('active'));
                const targetLink = document.querySelector('.mega-category-link[data-category="' + catName + '"]');
                const targetGroup = document.querySelector('.ev-mega-theme-group[data-category="' + catName + '"]');
                if (targetLink) targetLink.classList.add('active');
                if (targetGroup) targetGroup.classList.add('active');
            }

            megaLinks.forEach(link => {
                link.addEventListener('mouseenter', function () {
                    switchMegaCategory(this.getAttribute('data-category'));
                });
                link.addEventListener('click', function (e) {
                    switchMegaCategory(this.getAttribute('data-category'));
                });
            });

            // 4. Horizontal Categories Track Scroll Buttons
            const catTrack = document.getElementById('catTrack');
            const prevBtn = document.getElementById('catScrollPrev');
            const nextBtn = document.getElementById('catScrollNext');

            if (catTrack && prevBtn && nextBtn) {
                prevBtn.addEventListener('click', () => {
                    catTrack.scrollBy({ left: -320, behavior: 'smooth' });
                });
                nextBtn.addEventListener('click', () => {
                    catTrack.scrollBy({ left: 320, behavior: 'smooth' });
                });

                function updateArrows() {
                    prevBtn.disabled = catTrack.scrollLeft <= 10;
                    nextBtn.disabled = catTrack.scrollLeft >= catTrack.scrollWidth - catTrack.clientWidth - 10;
                }

                catTrack.addEventListener('scroll', updateArrows, { passive: true });
                updateArrows();
            }

            // 5. Popular Categories Interactive Switcher
            const popItems = document.querySelectorAll('.ev-popcat-item');
            const popPanels = document.querySelectorAll('.ev-preview-panel');

            popItems.forEach(item => {
                const targetId = item.getAttribute('data-target');

                function activateCategory() {
                    popItems.forEach(i => i.classList.remove('is-active'));
                    popPanels.forEach(p => p.classList.remove('is-active'));

                    item.classList.add('is-active');
                    const targetPanel = document.getElementById(targetId);
                    if (targetPanel) {
                        targetPanel.classList.add('is-active');
                    }
                }

                item.addEventListener('mouseenter', activateCategory);
                item.addEventListener('click', activateCategory);
            });

            // 6. Template Category Filtering
            const filterBtns = document.querySelectorAll('.ev-filter-btn');
            const templateCards = document.querySelectorAll('.ev-template-card');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.getAttribute('data-filter');

                    templateCards.forEach(card => {
                        const cardCat = card.getAttribute('data-category');
                        if (filter === 'all' || cardCat === filter || cardCat.includes(filter)) {
                            card.style.display = 'flex';
                            setTimeout(() => { card.style.opacity = '1'; }, 20);
                        } else {
                            card.style.opacity = '0';
                            setTimeout(() => { card.style.display = 'none'; }, 250);
                        }
                    });
                });
            });

            // 7. Interactive Like Button with AJAX
            document.querySelectorAll('.ev-like-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const id = this.getAttribute('data-id');
                    const countSpan = this.querySelector('.likes-count');
                    const heartIcon = this.querySelector('i');

                    if (this.classList.contains('processing')) return;
                    this.classList.add('processing');

                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    fetch(`/templates/${id}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken || '',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                countSpan.textContent = data.likes_count.toLocaleString();
                                heartIcon.classList.add('bi-heart');
                                heartIcon.classList.remove('bi-heart-fill');
                                setTimeout(() => {
                                    heartIcon.classList.remove('bi-heart');
                                    heartIcon.classList.add('bi-heart-fill');
                                }, 180);
                            }
                            this.classList.remove('processing');
                        })
                        .catch(err => {
                            console.error(err);
                            this.classList.remove('processing');
                        });
                });
            });

            // 8. FAQ Accordion Interaction
            const faqItems = document.querySelectorAll('.ev-faq-item');
            faqItems.forEach(item => {
                const questionBtn = item.querySelector('.ev-faq-question');
                if (questionBtn) {
                    questionBtn.addEventListener('click', () => {
                        const isOpen = item.classList.contains('is-open');
                        faqItems.forEach(i => i.classList.remove('is-open'));
                        if (!isOpen) {
                            item.classList.add('is-open');
                        }
                    });
                }
            });

            // 9. Scroll Reveal Observer
            const reveals = document.querySelectorAll('.reveal');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });

                reveals.forEach(el => observer.observe(el));
            } else {
                reveals.forEach(el => el.classList.add('active'));
            }

            // Hero Background Music Toggle
            const heroMusicToggle = document.getElementById('heroMusicToggle');
            const heroMusicIcon = document.getElementById('heroMusicIcon');
            const heroBgMusic = document.getElementById('heroBgMusic');

            if (heroMusicToggle && heroBgMusic) {
                heroMusicToggle.addEventListener('click', () => {
                    if (heroBgMusic.paused) {
                        heroBgMusic.play().then(() => {
                            heroMusicIcon.classList.replace('bi-play-circle-fill', 'bi-pause-circle-fill');
                        }).catch(() => { });
                    } else {
                        heroBgMusic.pause();
                        heroMusicIcon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
                    }
                });

                heroBgMusic.addEventListener('ended', () => {
                    heroMusicIcon.classList.replace('bi-pause-circle-fill', 'bi-play-circle-fill');
                });
            }
        });
    </script>
@endsection
@php
    $topAnnouncements = \App\Models\Announcement::query()
        ->where('is_active', true)
        ->orderByDesc('id')
        ->get();

    if ($topAnnouncements->isEmpty() && \App\Models\Announcement::query()->doesntExist()) {
        $topAnnouncements = collect([(object) [
            'message' => '✨ <strong>BARU:</strong> Buat &amp; personalisasi undangan digital pernikahan, ulang tahun, dan syukuran dalam hitungan menit.',
            'link_text' => 'Coba Sekarang →',
            'link_url' => route('pages.cari-tema'),
        ]]);
    }
@endphp
@if($topAnnouncements->isNotEmpty())
    <aside class="ev-top-banner" aria-label="Pengumuman Penting">
        <div class="ev-top-banner-viewport" id="evTopBannerViewport">
            @foreach($topAnnouncements as $topAnnouncement)
                <a href="{{ $topAnnouncement->link_url ?: route('pages.cari-tema') }}"
                    class="ev-top-banner-slide {{ $loop->first ? 'is-active' : '' }}">
                    <span>{!! $topAnnouncement->message !!}</span>
                    @if($topAnnouncement->link_text)
                        <span class="banner-link-text">{{ $topAnnouncement->link_text }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </aside>

    <style>
        .ev-top-banner {
            padding: 0.32rem 0.75rem;
            font-size: 0.78rem;
        }

        .ev-top-banner .ev-top-banner-viewport {
            position: relative;
            overflow: hidden;
            min-height: 1.9em;
        }

        .ev-top-banner .ev-top-banner-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-105%);
            transition: transform 0.45s cubic-bezier(0.22, 0.61, 0.36, 1),
                opacity 0.45s cubic-bezier(0.22, 0.61, 0.36, 1);
            will-change: transform, opacity;
        }

        .ev-top-banner .ev-top-banner-slide.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .ev-top-banner .ev-top-banner-slide.is-leaving {
            opacity: 0;
            visibility: visible;
            pointer-events: none;
            transform: translateY(105%);
        }

        @media (prefers-reduced-motion: reduce) {
            .ev-top-banner .ev-top-banner-slide {
                transition: none;
            }
        }
    </style>

    <script>
        (function () {
            var viewport = document.getElementById('evTopBannerViewport');
            if (!viewport) return;

            var slides = Array.prototype.slice.call(viewport.querySelectorAll('.ev-top-banner-slide'));
            if (slides.length === 0) return;

            var current = 0;
            var timer = null;
            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            function measure() {
                var maxHeight = 0;
                slides.forEach(function (slide) {
                    slide.style.height = 'auto';
                });
                slides.forEach(function (slide) {
                    maxHeight = Math.max(maxHeight, slide.offsetHeight);
                });
                slides.forEach(function (slide) {
                    slide.style.height = maxHeight + 'px';
                });
                viewport.style.height = maxHeight + 'px';
            }

            measure();
            window.addEventListener('resize', measure);
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(measure);
            }

            if (slides.length < 2 || reduceMotion) return;

            function goTo(index) {
                var outgoing = slides[current];
                var incoming = slides[index];

                if (outgoing && outgoing !== incoming) {
                    outgoing.classList.remove('is-active');
                    outgoing.classList.add('is-leaving');
                    window.setTimeout(function () {
                        outgoing.classList.remove('is-leaving');
                    }, 500);
                }

                if (incoming) {
                    incoming.classList.remove('is-leaving');
                    void incoming.offsetWidth;
                    incoming.classList.add('is-active');
                }

                current = index;
            }

            function next() {
                goTo((current + 1) % slides.length);
            }

            function start() {
                stop();
                timer = window.setInterval(next, 4500);
            }

            function stop() {
                if (timer) {
                    window.clearInterval(timer);
                    timer = null;
                }
            }

            viewport.addEventListener('mouseenter', stop);
            viewport.addEventListener('mouseleave', start);

            start();
        })();
    </script>
@endif
{{-- <style>
    #navKoleksiUndangan {
        position: relative;
    }

    #navKoleksiUndangan>.ev-mega-dropdown {
        position: absolute;
        top: calc(100% + 12px);
        left: 0;
        width: min(740px, calc(100vw - 32px));
        padding: 0;
        background: #ffffff;
        border: 1px solid #e9e9e4;
        border-radius: 18px;
        box-shadow: 0 18px 50px rgba(27, 39, 24, 0.14);
        z-index: 9999;
        overflow: hidden;
    }

    /* Dua kolom utama */
    .ev-mega-inner {
        display: grid;
        grid-template-columns: 210px minmax(0, 1fr);
        gap: 0;
        align-items: stretch;
        padding: 12px;
        background: #fff;
    }

    /* Kolom kategori */
    .ev-mega-categories {
        min-width: 0;
        padding: 4px 12px 4px 0;
        border-right: 1px solid #eeeeea;
    }

    .ev-mega-categories .mega-category-link {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        min-height: 44px;
        padding: 11px 12px;
        margin-bottom: 4px;
        border-radius: 9px;
        color: #62665f;
        font-size: 13px;
        line-height: 1.4;
        text-decoration: none;
        white-space: normal;
        transition: background .2s ease, color .2s ease;
    }

    .ev-mega-categories .mega-category-link:hover {
        background: #f3f5ef;
        color: #455b2b;
    }

    .ev-mega-categories .mega-category-link.active {
        background: #485f2c;
        color: #fff;
        font-weight: 600;
    }

    .mega-cat-icon {
        flex: 0 0 20px;
        width: 20px;
        text-align: center;
        font-size: 15px;
    }

    .ev-mega-categories .dropdown-divider {
        margin: 10px 0 !important;
        border-color: #ecece6;
    }

    .ev-mega-categories>.ev-dropdown-link:not(.mega-category-link) {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 12px;
        border-radius: 9px;
        font-size: 13px;
        line-height: 1.5;
        text-decoration: none;
        white-space: normal;
    }

    /* Kolom tema */
    .ev-mega-themes {
        min-width: 0;
        padding: 4px 4px 4px 16px;
    }

    .ev-mega-theme-group {
        display: none;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        align-content: start;
        gap: 14px 12px;
    }

    .ev-mega-theme-group.active {
        display: grid;
    }

    /* Kartu tema */
    .ev-mega-theme-item {
        display: flex;
        flex-direction: column;
        min-width: 0;
        gap: 8px;
        color: #4d5149;
        font-size: 12px;
        line-height: 1.4;
        text-decoration: none;
    }

    .ev-mega-theme-item:hover {
        color: #485f2c;
    }

    .ev-mega-theme-thumb {
        width: 100%;
        aspect-ratio: 3 / 4;
        min-height: 95px;
        max-height: 145px;
        border-radius: 9px;
        background-color: #f3f0e9;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        border: 1px solid #eeece5;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .ev-mega-theme-item:hover .ev-mega-theme-thumb {
        transform: translateY(-3px);
        box-shadow: 0 7px 16px rgba(0, 0, 0, .10);
    }

    .ev-mega-theme-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        color: #77796f;
        font-size: 11px;
        text-align: center;
    }

    /* Link lihat semua tema */
    .ev-mega-theme-all {
        grid-column: 1 / -1;
        display: block;
        padding: 10px 0 2px;
        border-top: 1px solid #eeeeea;
        color: #485f2c;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .ev-mega-theme-all:hover {
        color: #293b1a;
    }

    /* Pastikan menu berada di atas konten halaman */
    #navKoleksiUndangan .ev-mega-dropdown,
    #navKoleksiUndangan .ev-mega-inner {
        isolation: isolate;
    }

    /* Tablet dan layar sempit */
    @media (max-width: 767px) {
        #navKoleksiUndangan>.ev-mega-dropdown {
            width: min(600px, calc(100vw - 24px));
            left: 0;
        }

        .ev-mega-inner {
            grid-template-columns: 165px minmax(0, 1fr);
            padding: 10px;
        }

        .ev-mega-categories {
            padding-right: 8px;
        }

        .ev-mega-themes {
            padding-left: 10px;
        }

        .ev-mega-theme-group {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 8px;
        }

        .ev-mega-theme-thumb {
            min-height: 85px;
        }
    }

    /* Grup tema tetap menggunakan grid */
    .ev-mega-theme-group {
        display: none;
    }

    .ev-mega-theme-group.active {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        grid-template-rows: auto 1fr auto;
        align-content: stretch;
        align-items: start;
        gap: 14px 12px;
        min-height: 220px;
    }

    /* Item tema tetap seperti semula */
    .ev-mega-theme-item {
        display: flex;
        flex-direction: column;
        min-width: 0;
        gap: 8px;
        color: #4d5149;
        font-size: 12px;
        line-height: 1.4;
        text-decoration: none;
    }

    /* Link lihat semua berada di baris paling bawah */
    .ev-mega-theme-all {
        grid-column: 1 / -1;
        align-self: end;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        width: 100%;
        margin-top: 0;
        padding: 12px 0 2px;
        border-top: 1px solid #eeeeea;
        color: #485f2c;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
    }

    .ev-mega-theme-all:hover {
        color: #293b1a;
    }
</style> --}}
<style>
    /* Pastikan induk tidak memotong dropdown ke samping */
    header,
    nav,
    .ev-header,
    .ev-navbar,
    .ev-nav-list {
        overflow: visible !important;
    }

    .ev-nav-item.ev-has-mega {
        position: relative !important;
    }


    .ev-nav-item.ev-has-mega {
        position: static;
        /* agar mega dropdown bisa melebar penuh ke tepi navbar/layar */
    }

    /* 1. Cegah scrollbar horizontal di halaman */
    html,
    body {
        overflow-x: clip;
    }

    /* 2. Pastikan header / nav terluar selebar layar & menjadi acuan posisi */
    header,
    .ev-header,
    .ev-navbar {
        position: relative !important;
        overflow: visible !important;
    }

    /* 3. Lepas batasan posisi pada container / ul / li di dalamnya */
    .ev-header .container,
    .ev-navbar .container,
    .ev-nav-list,
    .ev-nav-item.ev-has-mega {
        position: static !important;
        overflow: visible !important;
    }

    /* 4. Mega dropdown dengan jarak kiri-kanan dari tepi layar */
    .ev-mega-dropdown {
        position: absolute !important;
        top: 100% !important;
        left: 20px !important;
        right: 20px !important;
        width: auto !important;
        max-width: 1360px !important;
        margin-inline: auto !important;
        border-radius: 0 0 14px 14px !important;
        box-sizing: border-box !important;
        z-index: 1050;
    }

    /* 5. Konten di dalamnya tetap rata dengan container halaman */
    .ev-mega-container {
        max-width: 1320px;
        width: 100%;
        margin-inline: auto;
        padding-inline: 1.5rem;
        box-sizing: border-box;
    }

    .ev-mega-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 1050;
        background-color: #ffffff;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.14);
        padding: 1.5rem 0;
    }

    .ev-mega-container {
        max-width: 1320px;
        margin-inline: auto;
        padding-inline: 1.5rem;
    }

    .ev-mega-inner {
        display: grid;
        grid-template-columns: 260px minmax(0, 1fr);
        gap: 1.75rem;
        align-items: start;
    }

    .ev-mega-heading {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #6b7280;
        padding: 0 0.75rem 0.5rem;
    }

    .ev-mega-category-list {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .mega-category-link {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        width: 100%;
        padding: 0.6rem 0.75rem;
        border-radius: 0.5rem;
        color: #374151;
        text-decoration: none;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .mega-category-link:hover,
    .mega-category-link:focus-visible,
    .mega-category-link.active {
        background-color: #f3f4f6;
        color: #111827;
        font-weight: 600;
        outline: none;
    }

    .mega-cat-arrow {
        margin-left: auto;
        font-size: 0.75rem;
        opacity: 0.55;
    }

    /* Ikon pada item aktif ikut warna teks (tidak hijau) */
    .mega-category-link.active .mega-cat-icon,
    .mega-category-link.active .mega-cat-icon > i {
        color: inherit;
    }

    .ev-mega-footer-link {
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid #e5e7eb;
    }

    .ev-mega-theme-group {
        display: none;
    }

    .ev-mega-theme-group.active {
        display: block;
    }

    .ev-mega-theme-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .ev-mega-theme-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        color: #111827;
    }

    .ev-mega-theme-all {
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .ev-mega-theme-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
        gap: 1rem;
    }

    .ev-mega-theme-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        text-decoration: none;
        color: #1f2937;
        border-radius: 0.625rem;
        padding: 0.4rem;
        transition: background-color 0.15s ease, transform 0.15s ease;
    }

    .ev-mega-theme-item:hover,
    .ev-mega-theme-item:focus-visible {
        background-color: #f8fafc;
        transform: translateY(-2px);
        outline: none;
    }

    .ev-mega-theme-thumb {
        aspect-ratio: 4 / 3;
        border-radius: 0.5rem;
        background-size: cover;
        background-position: center;
        background-color: #f1f5f9;
        border: 1px solid #e5e7eb;
    }

    .ev-mega-theme-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        color: #64748b;
    }

    .ev-mega-theme-name {
        font-size: 0.85rem;
        font-weight: 500;
        line-height: 1.35;
    }

    @media (max-width: 991.98px) {
        .ev-mega-inner {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }
</style>
<header class="ev-header" id="mainHeader">
    <div class="container-fluid px-3 px-lg-4">
        <nav class="ev-nav-container" aria-label="Navigasi Utama">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="ev-logo-link" title="RuangUndang - Platform Undangan Digital">
                <img src="{{ asset('assets/logo-new.png') }}" alt="RuangUndang Logo" class="ev-logo-img" width="180"
                    height="38">
            </a>

            <!-- Desktop Nav Menu -->
            <ul class="ev-nav-menu">
                @php
                    $megaCategories = \App\Models\Category::ordered()
                        ->get()
                        ->map(fn($c) => [
                            'name' => $c->name,
                            'label' => $c->name,
                            'icon' => $c->icon ?: 'bi-grid',
                            'icon_svg' => $c->icon_svg,
                        ])
                        ->toArray();

                    if (!isset($templates) || !$templates) {
                        $templates = \App\Models\Template::where('is_active', true)->with('category')->get();
                    }

                    $templatesByCategory = $templates->groupBy(
                        fn($t) => $t->category ? $t->category->name : 'Lainnya'
                    );

                    $activeCategories = collect($megaCategories)
                        ->filter(fn($cat) => ($templatesByCategory[$cat['name']] ?? collect())->count() > 0)
                        ->values()
                        ->take(5);
                @endphp

                <li class="ev-nav-item ev-has-mega" id="navKoleksiUndangan">
                    <a href="{{ route('pages.cari-tema') }}" class="ev-nav-link" aria-haspopup="true"
                        aria-expanded="false" aria-controls="megaDropdown">
                        <span>Koleksi Undangan</span>
                        <i class="bi bi-chevron-down small opacity-75"></i>
                    </a>

                    <div class="ev-dropdown ev-mega-dropdown" id="megaDropdown" role="region"
                        aria-label="Koleksi Undangan">
                        <div class="ev-mega-container">
                            <div class="ev-mega-inner">
                                <!-- Kolom Kiri: Kategori -->
                                <aside class="ev-mega-categories" aria-label="Kategori Undangan">
                                    <div class="ev-mega-heading">Kategori</div>

                                    <div class="ev-mega-category-list">
                                        @foreach ($activeCategories as $cat)
                                            <a href="{{ route('pages.cari-tema', ['category' => $cat['name']]) }}"
                                                class="ev-dropdown-link mega-category-link {{ $loop->first ? 'active' : '' }}"
                                                data-category="{{ $cat['name'] }}">
                                                <span class="mega-cat-icon">
                                                    {!! category_icon_html($cat) !!}
                                                </span>
                                                <span class="mega-cat-label">{{ $cat['label'] }}</span>
                                                <i class="bi bi-chevron-right mega-cat-arrow"></i>
                                            </a>
                                        @endforeach
                                    </div>

                                    <div class="ev-mega-footer-link">
                                        <a href="{{ route('pages.cari-tema') }}"
                                            class="ev-dropdown-link text-success fw-semibold">
                                            <i class="bi bi-grid"></i>
                                            <span>Semua Kategori</span>
                                            <i class="bi bi-arrow-right ms-auto"></i>
                                        </a>
                                    </div>
                                </aside>

                                <!-- Kolom Kanan: Daftar Tema per Kategori -->
                                <div class="ev-mega-themes">
                                    @foreach ($activeCategories as $cat)
                                        @php
                                            $catTemplates = $templatesByCategory[$cat['name']] ?? collect();
                                        @endphp
                                        <div class="ev-mega-theme-group {{ $loop->first ? 'active' : '' }}"
                                            data-category="{{ $cat['name'] }}">
                                            <div class="ev-mega-theme-header">
                                                <h3 class="ev-mega-theme-title">{{ $cat['label'] }}</h3>
                                                <a href="{{ route('pages.cari-tema', ['category' => $cat['name']]) }}"
                                                    class="ev-mega-theme-all">
                                                    Lihat semua {{ strtolower($cat['label']) }}
                                                    <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>

                                            <div class="ev-mega-theme-grid">
                                                @forelse ($catTemplates as $template)
                                                    @php
                                                        $thumb = template_thumbnail_url($template, $template->updated_at->timestamp ?? now()->timestamp);
                                                    @endphp
                                                    <a href="{{ route('template.preview', ['slug' => $template->slug, 'id' => $template->id]) }}"
                                                        class="ev-mega-theme-item">
                                                        <div class="ev-mega-theme-thumb"
                                                            style="background-image: url('{{ $thumb }}');"></div>
                                                        <span class="ev-mega-theme-name">{{ $template->name }}</span>
                                                    </a>
                                                @empty
                                                    <a href="{{ route('pages.cari-tema', ['category' => $cat['name']]) }}"
                                                        class="ev-mega-theme-item ev-mega-theme-empty">
                                                        <div class="ev-mega-theme-thumb ev-mega-theme-placeholder">
                                                            Segera Hadir
                                                        </div>
                                                        <span class="ev-mega-theme-name">Coming Soon</span>
                                                    </a>
                                                @endforelse
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="ev-nav-item"><a href="{{ route('pages.cari-tema') }}" class="ev-nav-link">Cari Tema</a></li>
                <li class="ev-nav-item"><a href="{{ route('pages.fitur') }}" class="ev-nav-link">Fitur Lengkap</a></li>
                <li class="ev-nav-item"><a href="{{ route('pages.harga') }}" class="ev-nav-link">Paket Harga</a></li>
                <li class="ev-nav-item"><a href="{{ route('pages.bantuan') }}" class="ev-nav-link">Bantuan</a></li>
            </ul>

            <!-- Evite Pill Search Form - Click to open modal -->
            <div class="ev-nav-search">
                <button type="button" class="ev-search-trigger" id="searchTriggerBtn" aria-label="Buka pencarian">
                    <i class="bi bi-search ev-search-icon"></i>
                    <span class="ev-search-trigger-text">Cari tema impian Anda...</span>
                    <span class="ev-search-trigger-kbd">⌘K</span>
                </button>
            </div>

            <!-- Right Nav Actions -->
            <div class="ev-nav-actions">
                @auth
                    <a href="{{ auth()->user()->hasRole('admin') ? route('dashboard') : route('dashboard.user') }}"
                        class="ev-user-pill" title="Buka Dashboard">
                        <div class="ev-user-avatar">
                            @if(Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                <span
                                    class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success text-white fw-bold"
                                    style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            @endif
                        </div>
                        <span class="d-none d-md-inline">{{ Str::limit(Auth::user()->name, 12) }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="ev-btn-ghost">Masuk</a>
                    <a href="{{ route('register') }}" class="ev-btn-primary">
                        <span>Mulai Gratis</span>
                        <i class="bi bi-arrow-right-short fs-5"></i>
                    </a>
                @endauth

                <!-- Mobile Search Icon -->
                <button class="ev-mobile-search-btn" id="mobileSearchBtn" aria-label="Buka Pencarian">
                    <i class="bi bi-search"></i>
                </button>

                <!-- Mobile Hamburger -->
                <button class="ev-mobile-toggle" id="mobileDrawerOpenBtn" aria-label="Buka Menu Navigasi">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </nav>
    </div>
</header>


<div class="ev-drawer-backdrop" id="drawerBackdrop"></div>
<div class="ev-mobile-drawer" id="mobileDrawer">
    <div>
        <div class="ev-drawer-header">
            <img src="{{ asset('assets/logo-new.png') }}" alt="RuangUndang" height="32">
            <button class="ev-drawer-close" id="mobileDrawerCloseBtn" aria-label="Tutup Menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form action="{{ route('pages.cari-tema') }}" method="GET" class="ev-search-form my-3">
            <i class="bi bi-search ev-search-icon"></i>
            <input type="text" name="search" class="ev-search-input" placeholder="Cari tema...">
            <button type="submit" class="ev-search-submit">Cari</button>
        </form>

        <nav class="ev-drawer-nav">
            <a href="{{ route('pages.cari-tema') }}" class="ev-drawer-link">
                <span>Koleksi Tema</span>
                <i class="bi bi-chevron-right small text-muted"></i>
            </a>
            <a href="{{ route('pages.fitur') }}" class="ev-drawer-link">
                <span>Fitur Unggulan</span>
                <i class="bi bi-chevron-right small text-muted"></i>
            </a>
            <a href="{{ route('pages.harga') }}" class="ev-drawer-link">
                <span>Paket Harga</span>
                <i class="bi bi-chevron-right small text-muted"></i>
            </a>
            <a href="{{ route('pages.cara-pemesanan') }}" class="ev-drawer-link">
                <span>Cara Pemesanan</span>
                <i class="bi bi-chevron-right small text-muted"></i>
            </a>
            <a href="{{ route('pages.bantuan') }}" class="ev-drawer-link">
                <span>Pusat Bantuan &amp; FAQ</span>
                <i class="bi bi-chevron-right small text-muted"></i>
            </a>
        </nav>
    </div>

    <div class="pt-3 border-top">
        @auth
            <a href="{{ auth()->user()->hasRole('admin') ? route('dashboard') : route('dashboard.user') }}"
                class="ev-btn-primary w-100 justify-content-center py-2 mb-2">
                <i class="bi bi-speedometer2"></i> Masuk Dashboard
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="ev-btn-ghost w-100 text-center py-2 text-danger">
                    Keluar (Logout)
                </button>
            </form>
        @else
            <a href="{{ route('register') }}" class="ev-btn-primary w-100 justify-content-center py-2 mb-2">
                Mulai Buat Undangan
            </a>
            <a href="{{ route('login') }}" class="ev-btn-ghost w-100 justify-content-center py-2">
                Sudah Punya Akun? Masuk
            </a>
        @endauth
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pindahkan drawer & backdrop keluar dari <body> yang di-zoom (body { zoom: 0.8 })
        // agar .ev-mobile-drawer mengisi penuh tinggi viewport pada mode mobile.
        ['mobileDrawer', 'drawerBackdrop'].forEach(function (id) {
            var node = document.getElementById(id);
            if (node && node.parentNode !== document.documentElement) {
                document.documentElement.appendChild(node);
            }
        });

        // Mega menu: switch theme groups when a category is hovered/clicked
        var megaLinks = document.querySelectorAll('.mega-category-link');
        var themeGroups = document.querySelectorAll('.ev-mega-theme-group');

        function switchMegaCategory(catName) {
            megaLinks.forEach(function (link) { link.classList.remove('active'); });
            themeGroups.forEach(function (group) { group.classList.remove('active'); });

            var targetLink = document.querySelector('.mega-category-link[data-category="' + catName + '"]');
            var targetGroup = document.querySelector('.ev-mega-theme-group[data-category="' + catName + '"]');
            if (targetLink) targetLink.classList.add('active');
            if (targetGroup) targetGroup.classList.add('active');
        }

        megaLinks.forEach(function (link) {
            link.addEventListener('mouseenter', function () {
                switchMegaCategory(this.getAttribute('data-category'));
            });
            link.addEventListener('click', function (e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                }
                switchMegaCategory(this.getAttribute('data-category'));
            });
        });
    });

    document.querySelectorAll('#megaDropdown .mega-category-link').forEach((link) => {
        const activateCategory = () => {
            const category = link.dataset.category;
            if (!category) return;

            document.querySelectorAll('#megaDropdown .mega-category-link').forEach((el) => {
                el.classList.toggle('active', el === link);
            });

            document.querySelectorAll('#megaDropdown .ev-mega-theme-group').forEach((group) => {
                group.classList.toggle('active', group.dataset.category === category);
            });
        };

        link.addEventListener('mouseenter', activateCategory);
        link.addEventListener('focus', activateCategory);
    });
</script>
<x-app-layout>
    <div class="container-fluid px-0 py-2">

        {{-- =========================================================================
        STYLE — Tema Emas (Royal Botanical)
        Dipisah per kategori: Token · Tipografi · Tombol · Badge · Animasi
        · Progress Bar · Scrollbar
        ========================================================================= --}}
        <style>
            /* --- Design Tokens --- */
            :root {
                --gold-primary: #C6A962;
                --gold-dark: #A68B4B;
                --gold-light: #E8D5A3;
                --gold-subtle: rgba(198, 169, 98, 0.08);
                --bg-surface: #f9f9ff;
                --surface-container-low: #f0f3ff;
                --surface-container: #e7eeff;
                --surface-container-high: #dee8ff;
                --text-main: #1B2A4A;
                --text-muted: #64748b;
                --font-serif: 'Playfair Display', Georgia, serif;
                --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            }

            /* --- Tipografi --- */
            .font-serif {
                font-family: var(--font-serif);
            }

            /* --- Tombol Emas --- */
            .btn-gold {
                background-color: var(--gold-primary);
                border-color: var(--gold-primary);
                color: #ffffff;
                box-shadow: 0 4px 14px rgba(197, 155, 39, 0.28);
                font-weight: 600;
            }

            .btn-gold:hover,
            .btn-gold:focus,
            .btn-gold:active {
                background-color: #aa821c;
                border-color: #aa821c;
                color: #ffffff;
            }

            /* --- Utilitas Warna Emas --- */
            .text-gold {
                color: var(--gold-primary) !important;
            }

            .text-gold-dark {
                color: var(--gold-dark) !important;
            }

            .bg-gold-subtle {
                background-color: #fbf7ee !important;
            }

            /* --- Badge --- */
            .badge-gold {
                background-color: rgba(197, 155, 39, 0.14);
                color: var(--gold-dark);
                font-weight: 600;
            }

            /* --- Animasi: Pulse Dot (indikator live) --- */
            .pulse-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background-color: var(--gold-primary);
                display: inline-block;
                animation: pulse 1.8s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(0.95);
                    box-shadow: 0 0 0 0 rgba(197, 155, 39, 0.7);
                }

                70% {
                    transform: scale(1.15);
                    box-shadow: 0 0 0 6px rgba(197, 155, 39, 0);
                }

                100% {
                    transform: scale(0.95);
                    box-shadow: 0 0 0 0 rgba(197, 155, 39, 0);
                }
            }

            /* --- Animasi: Equalizer (musik latar) --- */
            .audio-bar {
                width: 3px;
                background-color: var(--gold-primary);
                border-radius: 2px;
                display: inline-block;
                animation: equalizer 1.2s infinite ease-in-out alternate;
            }

            .audio-bar:nth-child(2) {
                animation-delay: 0.2s;
            }

            .audio-bar:nth-child(3) {
                animation-delay: 0.4s;
            }

            @keyframes equalizer {
                0% {
                    height: 6px;
                }

                100% {
                    height: 18px;
                }
            }

            /* --- Progress Bar RSVP --- */
            .progress-bar-hadir {
                background-color: var(--gold-primary);
            }

            .progress-bar-ragu {
                background-color: #fdc34d;
            }

            .progress-bar-tidak {
                background-color: #cbd5e1;
            }

            /* --- Sembunyikan scrollbar (estetika dashboard) --- */
            body,
            .adminuiux-wrap,
            .adminuiux-content,
            main,
            #mainContent,
            .card,
            .modal-content,
            .ev-mobile-drawer {
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            body::-webkit-scrollbar,
            .adminuiux-wrap::-webkit-scrollbar,
            .adminuiux-content::-webkit-scrollbar,
            main::-webkit-scrollbar,
            #mainContent::-webkit-scrollbar,
            .card::-webkit-scrollbar,
            .modal-content::-webkit-scrollbar,
            .ev-mobile-drawer::-webkit-scrollbar {
                display: none;
                width: 0;
                height: 0;
            }

            /* Grafik SVG tetap halus tanpa scroll */
            .ev-traffic-chart svg,
            .w-100.overflow-visible svg {
                overflow: visible !important;
            }
        </style>

        {{-- =========================================================================
        KONDISI 1 — Empty State: belum ada undangan sama sekali
        ========================================================================= --}}
        @php $invitation = null; @endphp

        @if($invitations->isEmpty())
            <div class="card text-center py-5">
                <div class="card-body">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                        style="width: 80px; height: 80px;">
                        <i class="bi bi-inbox text-secondary fs-3" aria-hidden="true"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark mb-2">Belum ada undangan</h5>
                    <p class="text-secondary small mb-4">
                        Anda belum memiliki undangan pernikahan. Buat undangan pertama Anda sekarang.
                    </p>
                    <button type="button" class="btn btn-gold px-4 py-2" data-bs-toggle="modal"
                        data-bs-target="#newInvitationModal">
                        Buat Undangan Pertama
                    </button>
                </div>
            </div>

            {{-- Modal: Buat Undangan Pertama --}}
            <div class="modal fade modal-theme-navy" id="newInvitationModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content"
                        style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
                        <form id="quickCreateForm" action="{{ route('invitation.quick-create') }}" method="POST">
                            @csrf

                            <div class="modal-header text-center">
                                <h5 class="modal-title w-100 fw-bold">
                                    <i class="bi bi-suit-heart-fill me-2" style="color: var(--gold-primary);"
                                        aria-hidden="true"></i>
                                    Bangun Mimpimu
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Tutup" style="opacity: 0.8;"></button>
                            </div>

                            <div class="modal-body p-4 p-md-5">
                                <p class="text-muted small text-center mb-4" style="font-style: italic;">
                                    Mulai perjalanan indah Anda dengan mengisi data berikut.
                                </p>

                                {{-- Mempelai Pria --}}
                                <div class="mb-4">
                                    <h6 class="text-uppercase mb-3 d-flex align-items-center"
                                        style="color: var(--gold-dark); font-weight: 700; letter-spacing: 1px; font-size: 0.85rem;">
                                        <i class="bi bi-gender-male me-2"
                                            style="font-size: 1.2rem; color: var(--gold-primary);" aria-hidden="true"></i>
                                        Mempelai Pria
                                    </h6>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-person" aria-hidden="true"></i>
                                        </span>
                                        <input type="text" name="groom_name" class="form-control border-start-0 py-2"
                                            placeholder="Nama lengkap" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-person-badge" aria-hidden="true"></i>
                                        </span>
                                        <input type="text" name="groom_nickname" class="form-control border-start-0 py-2"
                                            placeholder="Nama panggilan (opsional)" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                </div>

                                {{-- Pemisah berbentuk hati --}}
                                <div class="text-center my-3">
                                    <div
                                        style="display: inline-block; padding: 0 15px; margin-top: -25px; position: relative; z-index: 2; background-color: #f9f9ff;">
                                        <i class="bi bi-suit-heart-fill"
                                            style="color: var(--gold-primary); font-size: 1.4rem;" aria-hidden="true"></i>
                                    </div>
                                    <hr style="margin-top: -12px; border-color: var(--gold-primary); opacity: 0.3;">
                                </div>

                                {{-- Mempelai Wanita --}}
                                <div class="mb-3">
                                    <h6 class="text-uppercase mb-3 d-flex align-items-center"
                                        style="color: var(--gold-dark); font-weight: 700; letter-spacing: 1px; font-size: 0.85rem;">
                                        <i class="bi bi-gender-female me-2"
                                            style="font-size: 1.2rem; color: var(--gold-primary);" aria-hidden="true"></i>
                                        Mempelai Wanita
                                    </h6>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-person" aria-hidden="true"></i>
                                        </span>
                                        <input type="text" name="bride_name" class="form-control border-start-0 py-2"
                                            placeholder="Nama lengkap" required style="border-radius: 0 10px 10px 0;">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                            <i class="bi bi-person-badge" aria-hidden="true"></i>
                                        </span>
                                        <input type="text" name="bride_nickname" class="form-control border-start-0 py-2"
                                            placeholder="Nama panggilan (opsional)" style="border-radius: 0 10px 10px 0;">
                                    </div>
                                </div>

                                <input type="hidden" name="template_id" id="modalTemplateId" value="">
                                <div id="modal_error" class="alert alert-danger d-none mt-3" style="border-radius: 10px;">
                                </div>
                            </div>

                            <div class="modal-footer d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-link text-decoration-none text-muted"
                                    data-bs-dismiss="modal" style="font-weight: 600;">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-gold px-4 py-2 fw-bold shadow-sm" id="quickCreateBtn"
                                    style="border-radius: 50px; letter-spacing: 1px; font-size: 0.9rem;">
                                    <i class="bi bi-stars me-1" aria-hidden="true"></i>
                                    Buat Undangan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- =========================================================================
            KONDISI 2 — Sudah ada undangan: tampilkan dashboard
            ========================================================================= --}}
        @else
            @php
                // Pilih undangan: parameter URL ?invitation_id=..., atau published pertama, atau pertama
                $selectedId = request('invitation_id');
                $invitation = $selectedId
                    ? $invitations->firstWhere('id', $selectedId)
                    : ($invitations->where('status', 'published')->first() ?? $invitations->first());
            @endphp

            @if($invitation)

                {{-- Selector undangan jika lebih dari satu --}}
                @if($invitations->count() > 1)
                    <div
                        class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 rounded-3 border shadow-sm flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-collection text-gold fs-5" aria-hidden="true"></i>
                            <span class="small fw-bold">Pilih Undangan:</span>
                        </div>
                        <form action="" method="GET" class="d-inline-block">
                            <select name="invitation_id" class="form-select form-select-sm" onchange="this.form.submit()"
                                aria-label="Pilih undangan">
                                @foreach($invitations as $item)
                                    <option value="{{ $item->id }}" {{ (string) $invitation->id === (string) $item->id ? 'selected' : '' }}>
                                        {{ $item->groom_nickname ?? $item->groom_name }} &amp;
                                        {{ $item->bride_nickname ?? $item->bride_name }}
                                        ({{ ucfirst($item->status ?? 'Draft') }})
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif

                @php
                    // --- Statistik RSVP ---
                    $rsvpYes = $invitation->rsvps()->where('attending', '1')->count();
                    $rsvpNo = $invitation->rsvps()->where('attending', '2')->count();
                    $rsvpMaybe = $invitation->rsvps()
                        ->where('attending', '!=', '1')
                        ->where('attending', '!=', '2')
                        ->count();
                    $totalRsvp = $rsvpYes + $rsvpNo + $rsvpMaybe;

                    // --- Cover undangan ---
                    $defaultCover = 'https://lh3.googleusercontent.com/aida-public/AB6AXuAmSZnGSctHfdqb0IhvLVgBE5u4XYfs8g81c-QhYAqODH7OuNf3fsJcTNzJKWIxG_YJYE5Z2w05fZcyZWQWiNkDffxqBNcl5Q3xRuakGpV0ea_03nbND3X-_mmy2-YJkjqXxjrXwTO6cSYoN4iN39cHnqtlYU4v2nRjHUIeXotOYJOrqBXQwcDPksZ6xs2dz-tiOxYCCK6sc6Q__MKvXUMUUIyO3wsDGc87wd7OMlmOPR4pYmbOQDp7Rw';
                    $coverUrl = $invitation->gallery_cover
                        ? asset('storage/' . $invitation->gallery_cover)
                        : $defaultCover;

                    // --- Musik latar ---
                    $musicPreset = $invitation->musicPreset;
                    $musicTitle = 'Tidak ada musik';
                    $musicArtist = '-';
                    $musicCover = null;
                    $musicSource = 'none';

                    if ($invitation->music_youtube_url) {
                        $musicTitle = 'Musik Latar (YouTube)';
                        $musicArtist = 'YouTube';
                        $musicSource = 'youtube';
                    } elseif ($musicPreset) {
                        $musicTitle = $musicPreset->title;
                        $musicArtist = $musicPreset->artist ?: 'Artis';
                        $musicCover = $musicPreset->cover_url;
                        $musicSource = 'preset';
                    } elseif ($invitation->music) {
                        $musicTitle = 'Musik Latar (Upload)';
                        $musicArtist = 'Custom Upload';
                        $musicSource = 'custom';
                    }

                    // --- Ucapan terbaru ---
                    $rsvpMessages = $invitation->rsvps()
                        ->whereNotNull('message')
                        ->where('message', '!=', '')
                        ->latest()
                        ->take(6)
                        ->get();
                    $totalMessages = $invitation->rsvps()
                        ->whereNotNull('message')
                        ->where('message', '!=', '')
                        ->count();
                @endphp

                {{-- =========================================================================
                KARTU UNDANGAN AKTIF — Cover + info + countdown + aksi cepat
                ========================================================================= --}}
                <section class="card mb-4 overflow-hidden position-relative">
                    <div class="position-absolute top-0 start-0 end-0"
                        style="height: 4px; background: linear-gradient(90deg, #c59b27, #f7bd48, #805521);" aria-hidden="true">
                    </div>

                    <div class="card-body p-4 p-lg-4">
                        <div class="row g-4 align-items-stretch">

                            {{-- Kolom kiri: info, URL live, countdown, aksi cepat --}}
                            <div class="col-12 col-lg-7 d-flex flex-column justify-content-between">

                                <div>
                                    {{-- Badge status --}}
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span
                                            class="badge badge-gold px-3 py-2 rounded-pill d-inline-flex align-items-center gap-1">
                                            <span class="pulse-dot me-1" aria-hidden="true"></span>
                                            KARTU UNDANGAN AKTIF
                                        </span>
                                        <span
                                            class="badge bg-light text-secondary border px-3 py-2 rounded-pill d-inline-flex align-items-center gap-1 text-uppercase"
                                            style="letter-spacing: 0.5px;">
                                            <i class="bi bi-palette text-gold" aria-hidden="true"></i>
                                            {{ $invitation->template?->name ?? 'Tema' }}
                                        </span>
                                        <span
                                            class="badge bg-light text-secondary border px-3 py-2 rounded-pill d-inline-flex align-items-center gap-1 text-uppercase"
                                            style="letter-spacing: 0.5px;">
                                            <i class="bi bi-patch-check-fill text-gold" aria-hidden="true"></i>
                                            TERVERIFIKASI
                                        </span>
                                    </div>

                                    {{-- Nama mempelai --}}
                                    <h2 class="font-serif fw-bold text-dark display-6 mb-2">
                                        {{ $invitation->groom_name }} &amp; {{ $invitation->bride_name }}
                                    </h2>

                                    {{-- Tanggal & lokasi --}}
                                    <div class="d-flex flex-wrap align-items-center gap-3 text-secondary small mb-4">
                                        <span>
                                            <i class="bi bi-calendar3 text-gold me-1" aria-hidden="true"></i>
                                            {{ \Carbon\Carbon::parse($invitation->wedding_date)->translatedFormat('d F Y') }}
                                        </span>
                                        <span class="text-muted" aria-hidden="true">•</span>
                                        <span>
                                            <i class="bi bi-geo-alt-fill text-gold me-1" aria-hidden="true"></i>
                                            {{ $invitation->akad_location ?? 'Lokasi Akad' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Kotak URL live --}}
                                <div
                                    class="bg-light p-3 rounded-3 border border-light-subtle d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-white rounded-3 shadow-sm text-gold d-flex align-items-center justify-content-center"
                                            style="width: 44px; height: 44px;">
                                            <i class="bi bi-link-45deg fs-4" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                            <div class="text-uppercase text-secondary fw-bold"
                                                style="font-size: 10px; letter-spacing: 0.5px;">
                                                Tautan Live Undangan
                                            </div>
                                            <span class="fw-bold text-dark font-monospace truncate d-inline-block"
                                                style="max-width: 180px;" id="wedding-url-{{ $invitation->id }}">
                                                {{ parse_url(route('invitation.show', $invitation->slug), PHP_URL_HOST) }}/{{ $invitation->slug }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <button id="btn-copy-url-{{ $invitation->id }}"
                                            class="btn btn-sm btn-gold rounded-2 px-3 py-1.5 d-flex align-items-center gap-1"
                                            type="button">
                                            <i class="bi bi-clipboard" aria-hidden="true"></i>
                                            Salin
                                        </button>
                                        <a href="{{ route('invitation.show', $invitation->slug) }}"
                                            class="btn btn-sm btn-white bg-white border rounded-2 px-2 py-1.5" target="_blank"
                                            rel="noopener" title="Lihat Undangan">
                                            <i class="bi bi-box-arrow-up-right text-secondary" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('invitation.edit', $invitation) }}"
                                            class="btn btn-sm btn-white bg-white border rounded-2 px-2 py-1.5 text-secondary"
                                            type="button">
                                            Ubah Slug
                                        </a>
                                    </div>
                                </div>

                                {{-- Hitung mundur --}}
                                <div class="mb-4">
                                    <div class="text-uppercase text-secondary fw-bold small mb-2"
                                        style="font-size: 10px; letter-spacing: 0.8px;">
                                        Hitung Mundur Acara Sakral
                                    </div>
                                    <div class="row g-2 text-center">
                                        @foreach ([
                                                ['days', 'Hari'],
                                                ['hours', 'Jam'],
                                                ['minutes', 'Menit'],
                                                ['seconds', 'Detik'],
                                            ] as [$unit, $label])
                                            <div class="col-3">
                                                <div class="card bg-white border border-light-subtle p-2 py-3 rounded-3 shadow-sm">
                                                    <span id="countdown-{{ $unit }}-{{ $invitation->id }}"
                                                        class="font-serif fw-bold h3 text-gold mb-0">--</span>
                                                    <small class="text-uppercase text-muted fw-bold"
                                                        style="font-size: 10px;">{{ $label }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Aksi cepat: 5 tombol distribusi rata --}}
                                <div class="row g-2 pt-2">
                                    <div class="col-6 col-sm">
                                        <button type="button"
                                            class="btn btn-light bg-light-subtle border-0 w-100 py-2 rounded-3 text-center d-flex flex-column align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#shareModalDynamic">
                                            <i class="bi bi-share text-gold fs-5 mb-1" aria-hidden="true"></i>
                                            <span class="small fw-semibold text-dark">Bagikan Undangan</span>
                                        </button>
                                    </div>
                                    <div class="col-6 col-sm">
                                        <button id="btn-live-web-{{ $invitation->id }}"
                                            class="btn btn-light bg-light-subtle border-0 w-100 py-2 rounded-3 text-center d-flex flex-column align-items-center justify-content-center"
                                            type="button" data-url="{{ route('invitation.show', $invitation->slug) }}">
                                            <i class="bi bi-box-arrow-up-right text-gold fs-5 mb-1" aria-hidden="true"></i>
                                            <span class="small fw-semibold text-dark">Live Web</span>
                                        </button>
                                    </div>
                                    <div class="col-6 col-sm">
                                        <button id="btn-nama-tamu-{{ $invitation->id }}"
                                            class="btn btn-light bg-light-subtle border-0 w-100 py-2 rounded-3 text-center d-flex flex-column align-items-center justify-content-center"
                                            type="button" data-url="{{ route('rsvp.list', $invitation) }}">
                                            <i class="bi bi-person-badge text-gold fs-5 mb-1" aria-hidden="true"></i>
                                            <span class="small fw-semibold text-dark">Nama Tamu</span>
                                        </button>
                                    </div>
                                    <div class="col-6 col-sm">
                                        <button id="btn-download-qr-{{ $invitation->id }}"
                                            class="btn btn-light bg-light-subtle border-0 w-100 py-2 rounded-3 text-center d-flex flex-column align-items-center justify-content-center"
                                            type="button" data-url="{{ route('invitation.show', $invitation->slug) }}">
                                            <i class="bi bi-download text-gold fs-5 mb-1" aria-hidden="true"></i>
                                            <span class="small fw-semibold text-dark">Unduh QR</span>
                                        </button>
                                    </div>
                                    <div class="col-6 col-sm">
                                        <button id="btn-generate-qr-{{ $invitation->id }}"
                                            class="btn btn-light bg-light-subtle border-0 w-100 py-2 rounded-3 text-center d-flex flex-column align-items-center justify-content-center"
                                            type="button" data-invitation-id="{{ $invitation->id }}">
                                            <i class="bi bi-qr-code text-gold fs-5 mb-1" aria-hidden="true"></i>
                                            <span class="small fw-semibold text-dark">Generate QR Camera</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Kolom kanan: cover undangan --}}
                            <div class="col-12 col-lg-5">
                                <div class="position-relative w-100 h-100 rounded-4 overflow-hidden shadow"
                                    style="min-height: 400px;">
                                    <img alt="Cover undangan {{ $invitation->groom_name }} &amp; {{ $invitation->bride_name }}"
                                        class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover"
                                        src="{{ $coverUrl }}" onerror="this.src='{{ $defaultCover }}'" />

                                    {{-- Overlay gelap untuk kontras teks --}}
                                    <div class="position-absolute top-0 start-0 w-100 h-100"
                                        style="background: linear-gradient(to top, rgba(20, 28, 40, 0.9) 0%, rgba(20, 28, 40, 0.25) 50%, rgba(20, 28, 40, 0.3) 100%);"
                                        aria-hidden="true"></div>

                                    <div
                                        class="position-relative h-100 p-4 d-flex flex-column justify-content-between text-white">

                                        {{-- Badge atas --}}
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span
                                                class="badge bg-white text-dark rounded-pill shadow-sm px-3 py-1.5 d-inline-flex align-items-center gap-2"
                                                style="font-size: 11px;">
                                                <span class="pulse-dot" aria-hidden="true"></span>
                                                WEBSITE AKTIF &amp; SIAP
                                            </span>
                                            <span
                                                class="rounded-circle bg-white text-gold d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 34px; height: 34px;" aria-hidden="true">
                                                <i class="bi bi-award-fill"></i>
                                            </span>
                                        </div>

                                        {{-- Indikator musik latar --}}
                                        <div>
                                            <div class="bg-white bg-opacity-95 text-dark rounded-3 p-3 shadow-lg mb-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="rounded-circle bg-gold-subtle text-gold d-flex align-items-center justify-content-center"
                                                            style="width: 38px; height: 38px;">
                                                            @if($musicCover)
                                                                <img src="{{ $musicCover }}" alt="Music Cover"
                                                                    class="rounded-circle w-100 h-100 object-fit-cover">
                                                            @elseif($musicSource === 'youtube')
                                                                <i class="bi bi-youtube text-danger fs-5" aria-hidden="true"></i>
                                                            @elseif($musicSource === 'custom')
                                                                <i class="bi bi-cloud-arrow-up-fill text-gold fs-5"
                                                                    aria-hidden="true"></i>
                                                            @else
                                                                <i class="bi bi-music-note-beamed fs-5" aria-hidden="true"></i>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <small class="text-uppercase text-muted fw-bold d-block"
                                                                style="font-size: 9px; letter-spacing: 0.5px;">
                                                                Musik Latar Otomatis
                                                            </small>
                                                            <span class="fw-bold small">{{ $musicTitle }}</span>
                                                            <small class="text-muted d-block"
                                                                style="font-size: 9px; opacity: 0.8;">
                                                                {{ $musicArtist }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-end gap-1" style="height: 20px;"
                                                        aria-hidden="true">
                                                        <span class="audio-bar"></span>
                                                        <span class="audio-bar"></span>
                                                        <span class="audio-bar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex justify-content-between align-items-center small px-1 text-white-50">
                                                <span>Koleksi Desain: Royal Botanical 2025</span>
                                                <a class="text-white text-decoration-underline fw-semibold"
                                                    href="{{ route('invitation.edit', $invitation) }}">
                                                    Edit Tampilan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- =========================================================================
                SEKSI ANALITIK & RSVP
                ========================================================================= --}}
                <section class="row g-4 align-items-start">

                    {{-- Kolom kiri: Distribusi RSVP + Trafik --}}
                    <div class="col-12 col-lg-7 d-flex flex-column gap-4">

                        {{-- Distribusi Kehadiran --}}
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="font-serif fw-bold text-dark mb-0">Distribusi Kehadiran &amp; RSVP</h5>
                                        <small class="text-muted">Breakdown respon langsung dari undangan yang disebar</small>
                                    </div>
                                    <a class="small text-gold-dark text-decoration-none fw-semibold" href="#">
                                        Kelola Meja &amp; Sesi
                                    </a>
                                </div>

                                @php
                                    $pctHadir = $totalRsvp > 0 ? round(($rsvpYes / $totalRsvp) * 100, 1) : 0;
                                    $pctRagu = $totalRsvp > 0 ? round(($rsvpMaybe / $totalRsvp) * 100, 1) : 0;
                                    $pctTidak = $totalRsvp > 0 ? round(($rsvpNo / $totalRsvp) * 100, 1) : 0;
                                @endphp

                                {{-- Bar progres multi-segmen --}}
                                <div class="progress mb-3" style="height: 14px; border-radius: 8px;">
                                    <div class="progress-bar progress-bar-hadir" role="progressbar"
                                        style="width: {{ $pctHadir }}%;" aria-valuenow="{{ $pctHadir }}" aria-valuemin="0"
                                        aria-valuemax="100" title="Hadir: {{ $rsvpYes }}"></div>
                                    <div class="progress-bar progress-bar-ragu" role="progressbar"
                                        style="width: {{ $pctRagu }}%;" aria-valuenow="{{ $pctRagu }}" aria-valuemin="0"
                                        aria-valuemax="100" title="Ragu-ragu: {{ $rsvpMaybe }}"></div>
                                    <div class="progress-bar progress-bar-tidak" role="progressbar"
                                        style="width: {{ $pctTidak }}%;" aria-valuenow="{{ $pctTidak }}" aria-valuemin="0"
                                        aria-valuemax="100" title="Tidak Hadir: {{ $rsvpNo }}"></div>
                                </div>

                                {{-- Legenda --}}
                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle d-inline-block"
                                            style="width: 10px; height: 10px; background-color: var(--gold-primary);"
                                            aria-hidden="true"></span>
                                        <span class="small fw-semibold text-dark">{{ $rsvpYes }} Hadir</span>
                                        <span class="small text-muted">({{ $pctHadir }}%)</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle d-inline-block"
                                            style="width: 10px; height: 10px; background-color: #fdc34d;"
                                            aria-hidden="true"></span>
                                        <span class="small fw-semibold text-dark">{{ $rsvpMaybe }} Ragu-ragu</span>
                                        <span class="small text-muted">({{ $pctRagu }}%)</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle d-inline-block"
                                            style="width: 10px; height: 10px; background-color: #cbd5e1;"
                                            aria-hidden="true"></span>
                                        <span class="small fw-semibold text-dark">{{ $rsvpNo }} Tidak Hadir</span>
                                        <span class="small text-muted">({{ $pctTidak }}%)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Trafik kunjungan 24 jam --}}
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="font-serif fw-bold text-dark mb-0">Trafik Kunjungan 24 Jam Terakhir</h5>
                                        <small class="text-muted">Puncak interaksi dan pembukaan amplop terjadi saat malam
                                            hari</small>
                                    </div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Periode trafik">
                                        <button class="btn btn-light border fw-semibold active" type="button">Hari Ini</button>
                                        <button class="btn btn-white bg-white border text-secondary" type="button">7
                                            Hari</button>
                                    </div>
                                </div>

                                {{-- SVG Area Chart --}}
                                <div class="w-100 pt-2">
                                    <svg class="w-100 overflow-visible" style="height: 130px;" viewBox="0 0 500 130" role="img"
                                        aria-label="Grafik trafik kunjungan 24 jam terakhir">
                                        <defs>
                                            <linearGradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                                                <stop offset="0%" stop-color="#c59b27" stop-opacity="0.32"></stop>
                                                <stop offset="100%" stop-color="#c59b27" stop-opacity="0.0"></stop>
                                            </linearGradient>
                                        </defs>
                                        <line stroke="#dee8ff" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="500" y1="20"
                                            y2="20"></line>
                                        <line stroke="#dee8ff" stroke-dasharray="4 4" stroke-width="1" x1="0" x2="500" y1="65"
                                            y2="65"></line>
                                        <line stroke="#dee8ff" stroke-width="1" x1="0" x2="500" y1="110" y2="110"></line>
                                        <path
                                            d="M 0 110 L 0 95 Q 60 85 100 80 T 200 60 T 300 35 T 380 18 T 440 45 T 500 30 L 500 110 Z"
                                            fill="url(#chartGradient)"></path>
                                        <path d="M 0 95 Q 60 85 100 80 T 200 60 T 300 35 T 380 18 T 440 45 T 500 30" fill="none"
                                            stroke="#c59b27" stroke-linecap="round" stroke-width="2.5"></path>
                                        <circle cx="380" cy="18" fill="#c59b27" r="4.5"></circle>
                                        <circle cx="380" cy="18" fill="#c59b27" fill-opacity="0.25" r="8"></circle>
                                    </svg>
                                    <div class="d-flex justify-content-between small text-muted pt-2 px-1"
                                        style="font-size: 11px;">
                                        <span>06:00</span>
                                        <span>09:00</span>
                                        <span>12:00</span>
                                        <span>15:00</span>
                                        <span class="text-gold fw-bold">19:30 (Puncak: 284 hit)</span>
                                        <span>22:00</span>
                                        <span>02:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom kanan: Buku Tamu & Ucapan --}}
                    <div class="col-12 col-lg-5 d-flex flex-column gap-4">

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-3 bg-light text-gold p-2 d-flex align-items-center justify-content-center"
                                            style="width: 36px; height: 36px;">
                                            <i class="bi bi-chat-square-quote-fill" aria-hidden="true"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-serif fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                                Buku Tamu &amp; Ucapan
                                                <span class="badge badge-gold">{{ $totalMessages }}</span>
                                            </h5>
                                            <small class="text-muted">Ucapan hangat terkini dari kerabat</small>
                                        </div>
                                    </div>
                                    <a class="small text-gold-dark text-decoration-none fw-semibold d-inline-flex align-items-center gap-1"
                                        href="{{ route('rsvp.index', ['list' => $invitation->id]) }}">
                                        <span>Lihat Semua ({{ $invitation->rsvps()->count() }})</span>
                                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                    </a>
                                </div>

                                {{-- Daftar ucapan dari RSVP --}}
                                @if($rsvpMessages->count() > 0)
                                    @foreach($rsvpMessages as $rsvp)
                                        @php
                                            $rsvpStatusLabel = $rsvp->attending === '1'
                                                ? 'Hadir'
                                                : ($rsvp->attending === '2' ? 'Tidak Hadir' : 'Ragu-ragu');
                                            $rsvpAvatar = strtoupper(substr($rsvp->name, 0, 1));
                                            $rsvpTime = $rsvp->created_at
                                                ? \Carbon\Carbon::parse($rsvp->created_at)->diffForHumans()
                                                : 'Baru saja';
                                        @endphp
                                        <div class="p-3 bg-light rounded-3 mb-3 border border-light-subtle">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold small"
                                                        style="width: 36px; height: 36px; background-color: var(--gold-primary);">
                                                        {{ $rsvpAvatar }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold small text-dark">{{ $rsvp->name }}</div>
                                                        <small class="text-muted" style="font-size: 11px;">
                                                            {{ $rsvpStatusLabel }} • {{ $rsvpTime }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="small text-dark fst-italic mb-2 ps-1">
                                                "{{ $rsvp->message }}"
                                            </p>
                                            <div
                                                class="d-flex justify-content-between align-items-center pt-1 border-top border-light-subtle">
                                                <span class="small text-gold d-inline-flex align-items-center gap-1"
                                                    style="font-size: 11px;">
                                                    <i class="bi bi-chat-text" aria-hidden="true"></i>
                                                    Ucapan
                                                </span>
                                                <div class="d-flex gap-1">
                                                    <button
                                                        class="btn btn-sm btn-white bg-white border px-2 py-0.5 rounded-2 btn-reply-msg"
                                                        style="font-size: 11px;" type="button" data-rsvp-id="{{ $rsvp->id }}"
                                                        data-rsvp-name="{{ $rsvp->name }}">
                                                        Balas
                                                    </button>
                                                    <button
                                                        class="btn btn-sm btn-white bg-white border text-gold px-2 py-0.5 rounded-2 btn-pin-msg"
                                                        style="font-size: 11px;" title="Sematkan Pesan" type="button"
                                                        data-rsvp-id="{{ $rsvp->id }}">
                                                        <i class="bi bi-pin-angle" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-4 text-muted">
                                        <i class="bi bi-chat-square-text fs-3 mb-2" aria-hidden="true"></i>
                                        <p class="small mb-0">
                                            Belum ada ucapan dari tamu. Bagikan undangan untuk mulai menerima ucapan.
                                        </p>
                                    </div>
                                @endif

                                {{-- Trigger moderasi --}}
                                <a href="{{ route('rsvp.index', ['list' => $invitation->id]) }}"
                                    class="btn btn-light w-100 py-2 rounded-3 text-dark fw-semibold small d-flex align-items-center justify-content-center gap-2 border"
                                    type="button">
                                    <i class="bi bi-chat-text text-gold" aria-hidden="true"></i>
                                    <span>Buka Ruang Moderasi Buku Tamu</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- =========================================================================
                KONDISI 2b — Ada undangan tapi belum ada yang dipublikasikan
                ========================================================================= --}}
            @else
                <div class="card text-center py-5">
                    <div class="card-body">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px;">
                            <i class="bi bi-calendar-x text-secondary fs-3" aria-hidden="true"></i>
                        </div>
                        <h5 class="font-serif fw-bold text-dark mb-2">Belum ada undangan yang dipublikasikan</h5>
                        <p class="text-secondary small mb-4">
                            Anda belum memiliki undangan pernikahan yang sudah diterbitkan.
                            Buat undangan pertama Anda sekarang.
                        </p>
                        <a href="{{ route('invitation.create') }}" class="btn btn-gold px-4 py-2">
                            Buat Undangan Pertama
                        </a>
                    </div>
                </div>
            @endif
        @endif

        {{-- =========================================================================
        MODAL — Bagikan Undangan (dipakai oleh kartu undangan aktif)
        ========================================================================= --}}
        @if(!empty($invitation))
            <div class="modal fade" id="shareModalDynamic" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow-lg">

                        {{-- Header tema emas agar konsisten dengan dashboard --}}
                        <div class="modal-header px-4" style="background-color: var(--gold-primary); color: #fff;">
                            <h5 class="modal-title fw-bold mb-0">
                                <i class="bi bi-share me-2" aria-hidden="true"></i>
                                Bagikan Undangan
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <label for="recipientNameDynamic" class="form-label fw-semibold">
                                    Nama Penerima / Keluarga
                                </label>
                                <input type="text" class="form-control" id="recipientNameDynamic"
                                    placeholder="Nama penerima">
                            </div>

                            <div class="d-flex align-items-center mb-3">
                                <div class="me-2 text-gold">
                                    <i class="bi bi-chat-text-fill fs-4" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">Pesan Undangan</h6>
                                    <small class="text-muted">Pesan yang akan dikirim kepada penerima</small>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <textarea class="form-control" id="shareMessageDynamic" placeholder="Pesan undangan"
                                    style="height: 200px"></textarea>
                                <label for="shareMessageDynamic">Pesan Undangan</label>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-success" onclick="shareToWhatsApp()">
                                    <i class="bi bi-whatsapp me-1" aria-hidden="true"></i> WhatsApp
                                </button>
                                <button type="button" class="btn btn-primary" onclick="shareToFacebook()">
                                    <i class="bi bi-facebook me-1" aria-hidden="true"></i> Facebook
                                </button>
                                <button type="button" class="btn btn-info text-white" onclick="shareToTwitter()">
                                    <i class="bi bi-twitter-x me-1" aria-hidden="true"></i> Twitter
                                </button>
                                <button type="button" class="btn btn-primary" onclick="shareToTelegram()">
                                    <i class="bi bi-telegram me-1" aria-hidden="true"></i> Telegram
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="shareViaEmail()">
                                    <i class="bi bi-envelope me-1" aria-hidden="true"></i> Email
                                </button>
                                <button type="button" class="btn btn-outline-dark" onclick="copyInvitationLink()">
                                    <i class="bi bi-link-45deg me-1" aria-hidden="true"></i> Salin Tautan
                                </button>
                            </div>
                        </div>

                        <div class="modal-footer px-4">
                            <div class="me-auto small text-muted">
                                <i class="bi bi-shield-check me-1" aria-hidden="true"></i>
                                Data kontak tetap berada di perangkat Anda.
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- =========================================================================
        JAVASCRIPT — Diorganisasi per modul IIFE
        ========================================================================= --}}
        <script>
            (function () {
                'use strict';

                // --- Helper: ambil elemen dengan aman ---
                const $ = (sel, ctx = document) => ctx.querySelector(sel);
                const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

                // --- Helper: tampilkan notifikasi (SweetAlert bila ada, fallback alert) ---
                function notify(icon, title, text, timer = 1500) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon, title, text, timer, showConfirmButton: false });
                    } else {
                        alert(text || title);
                    }
                }

                // --- Helper: dapatkan URL undangan lengkap dengan parameter penerima ---
                function getInvitationUrl() {
                    const slug = '{{ $invitation?->slug }}';
                    if (!slug) return '';
                    const recipientEl = $('#recipientNameDynamic');
                    const recipient = recipientEl ? recipientEl.value.trim() : '';
                    const url = window.location.origin + '/' + slug;
                    return recipient ? url + '?penerima=' + encodeURIComponent(recipient) : url;
                }

                // --- Helper: validasi penerima sebelum share ---
                function getShareData() {
                    const recipientInput = $('#recipientNameDynamic');
                    if (!recipientInput) return null;
                    const recipient = recipientInput.value.trim();
                    if (!recipient) {
                        recipientInput.focus();
                        notify('warning', 'Penerima wajib diisi',
                            'Masukkan nama penerima terlebih dahulu sebelum membagikan undangan.');
                        return null;
                    }
                    const messageEl = $('#shareMessageDynamic');
                    const message = messageEl ? messageEl.value : '';
                    return { recipient, message: message.replace(/\[nama\]/g, recipient) };
                }

                // --- API publik untuk tombol share (dipanggil via onclick) ---
                window.shareToWhatsApp = function () {
                    const data = getShareData();
                    if (!data) return;
                    window.open('https://wa.me/?text=' + encodeURIComponent(data.message), '_blank', 'noopener');
                };

                window.shareToFacebook = function () {
                    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(getInvitationUrl()), '_blank', 'noopener');
                };

                window.shareToTwitter = function () {
                    const messageEl = $('#shareMessageDynamic');
                    const message = messageEl ? messageEl.value : '';
                    window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(message) +
                        '&url=' + encodeURIComponent(getInvitationUrl()), '_blank', 'noopener');
                };

                window.shareToTelegram = function () {
                    const messageEl = $('#shareMessageDynamic');
                    const message = messageEl ? messageEl.value : '';
                    window.open('https://t.me/share/url?url=' + encodeURIComponent(getInvitationUrl()) +
                        '&text=' + encodeURIComponent(message), '_blank', 'noopener');
                };

                window.shareViaEmail = function () {
                    const messageEl = $('#shareMessageDynamic');
                    const message = messageEl ? messageEl.value : '';
                    window.location.href = 'mailto:?subject=' + encodeURIComponent('Undangan Pernikahan') +
                        '&body=' + encodeURIComponent(message);
                };

                window.copyInvitationLink = function () {
                    const url = getInvitationUrl();
                    navigator.clipboard.writeText(url)
                        .then(() => notify('success', 'Tersalin', 'Tautan undangan telah disalin ke clipboard.'))
                        .catch((err) => console.error('Gagal menyalin tautan: ', err));
                };

                // --- Inisialisasi tombol berbasis prefix ID (multi-undangan) ---

                // Salin URL undangan
                $$('[id^="btn-copy-url-"]').forEach((btn) => {
                    const invitationId = btn.id.replace('btn-copy-url-', '');
                    const urlEl = $('#wedding-url-' + invitationId);
                    if (!urlEl) return;

                    const fullUrl = 'https://' + urlEl.textContent.trim();
                    const originalHtml = btn.innerHTML;

                    btn.addEventListener('click', () => {
                        navigator.clipboard.writeText(fullUrl)
                            .then(() => {
                                btn.innerHTML = '<i class="bi bi-check fs-6" aria-hidden="true"></i> <span>Disalin</span>';
                                setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
                            })
                            .catch((err) => console.error('Gagal menyalin tautan: ', err));
                    });
                });

                // Tombol "Live Web" — buka undangan di tab baru
                $$('[id^="btn-live-web-"]').forEach((btn) => {
                    const url = btn.getAttribute('data-url');
                    if (url) btn.addEventListener('click', () => window.open(url, '_blank', 'noopener'));
                });

                // Tombol "Nama Tamu" — buka daftar RSVP
                $$('[id^="btn-nama-tamu-"]').forEach((btn) => {
                    const url = btn.getAttribute('data-url');
                    if (url) btn.addEventListener('click', () => window.open(url, '_blank', 'noopener'));
                });

                // Tombol "Unduh QR" — generate & download QR via api.qrserver.com
                // (Catatan: chart.googleapis.com sudah deprecated sejak 2018)
                $$('[id^="btn-download-qr-"]').forEach((btn) => {
                    const url = btn.getAttribute('data-url');
                    if (!url) return;

                    btn.addEventListener('click', () => {
                        const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/' +
                            '?size=300x300&data=' + encodeURIComponent(url);
                        const link = document.createElement('a');
                        link.href = qrUrl;
                        link.download = 'qr-undangan.png';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });
                });

                // Tombol "Generate QR Camera" — panggil endpoint server untuk generate QR
                $$('[id^="btn-generate-qr-"]').forEach((btn) => {
                    const invitationId = btn.getAttribute('data-invitation-id');
                    if (!invitationId) return;

                    const originalHtml = btn.innerHTML;
                    const restoreButton = () => {
                        btn.disabled = false;
                        btn.innerHTML = originalHtml;
                    };

                    btn.addEventListener('click', () => {
                        const csrfToken = $('meta[name="csrf-token"]');
                        if (!csrfToken) {
                            alert('CSRF token tidak ditemukan.');
                            return;
                        }

                        btn.disabled = true;
                        btn.innerHTML = '<i class="bi bi-arrow-clockwise me-1" aria-hidden="true"></i>Membuat QR...';

                        fetch('/dashboard/invitation/' + invitationId + '/qr-code', {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                            },
                            credentials: 'include'
                        })
                            .then((response) => {
                                if (!response.ok) throw new Error('HTTP error ' + response.status);
                                return response.json();
                            })
                            .then((data) => {
                                if (data.success) {
                                    const link = document.createElement('a');
                                    link.href = '/storage/' + data['qr-code-path'];
                                    link.download = 'qr-code-' + invitationId + '.png';
                                    link.click();
                                }
                                if (data.error) alert(data.error);
                                restoreButton();
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                                restoreButton();
                                alert('Gagal generate QR code: ' + error.message);
                            });
                    });
                });

                // --- Tombol Balas ucapan ---
                $$('.btn-reply-msg').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const rsvpName = btn.getAttribute('data-rsvp-name');
                        if (typeof Swal === 'undefined') {
                            const balasan = prompt('Balas pesan dari ' + rsvpName + ':');
                            if (balasan) alert('Balasan kepada ' + rsvpName + ' telah dikirim.');
                            return;
                        }
                        Swal.fire({
                            title: 'Balas Pesan dari ' + rsvpName,
                            input: 'textarea',
                            inputPlaceholder: 'Ketik balasan Anda...',
                            showCancelButton: true,
                            confirmButtonText: 'Kirim Balasan',
                            confirmButtonColor: '#C6A962',
                            inputValidator: (value) => {
                                if (!value || !value.trim()) return 'Balasan tidak boleh kosong!';
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Balasan Terkirim',
                                    text: 'Balasan kepada ' + rsvpName + ' telah dikirim.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        });
                    });
                });

                // --- Tombol Pin ucapan ---
                $$('.btn-pin-msg').forEach((btn) => {
                    btn.addEventListener('click', () => {
                        const isPinned = btn.classList.contains('text-gold');
                        notify('info',
                            isPinned ? 'Sudah Disematkan' : 'Akan Disematkan',
                            isPinned
                                ? 'Pesan sudah disematkan sebelumnya.'
                                : 'Pesan akan ditinjau dan ditampilkan di atas.');
                    });
                });
            })();
        </script>

        {{-- Countdown timer hanya jika ada undangan aktif --}}
        @if(!empty($invitation))
            <script>
                (function () {
                    'use strict';
                    const weddingDateStr = '{{ \Carbon\Carbon::parse($invitation->wedding_date)->format('Y-m-d H:i:s') }}';
                    const weddingDate = new Date(weddingDateStr).getTime();
                    if (isNaN(weddingDate)) return;

                    const invitationId = '{{ $invitation->id }}';
                    const daysEl = document.getElementById('countdown-days-' + invitationId);
                    const hoursEl = document.getElementById('countdown-hours-' + invitationId);
                    const minutesEl = document.getElementById('countdown-minutes-' + invitationId);
                    const secondsEl = document.getElementById('countdown-seconds-' + invitationId);
                    if (!daysEl || !hoursEl || !minutesEl || !secondsEl) return;

                    function updateCountdown() {
                        const distance = weddingDate - Date.now();
                        if (distance < 0) {
                            daysEl.textContent = hoursEl.textContent =
                                minutesEl.textContent = secondsEl.textContent = '0';
                            return;
                        }
                        daysEl.textContent = Math.floor(distance / 86400000);
                        hoursEl.textContent = Math.floor((distance % 86400000) / 3600000);
                        minutesEl.textContent = Math.floor((distance % 3600000) / 60000);
                        secondsEl.textContent = Math.floor((distance % 60000) / 1000);
                    }

                    updateCountdown();
                    setInterval(updateCountdown, 1000);
                })();
            </script>
        @endif

        {{-- Submit form "Buat Undangan Pertama" via AJAX --}}
        <script>
            (function () {
                'use strict';
                const form = document.getElementById('quickCreateForm');
                if (!form) return;

                const btn = document.getElementById('quickCreateBtn');
                const errorEl = document.getElementById('modal_error');
                const modalEl = document.getElementById('newInvitationModal');

                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    errorEl.classList.add('d-none');
                    errorEl.textContent = '';
                    btn.disabled = true;
                    btn.innerHTML = '<i class="bi bi-arrow-repeat me-1" aria-hidden="true"></i> Memproses...';

                    fetch(form.action, {
                        method: 'POST',
                        headers: { 'X-Requested-With': 'XMLHttpRequest' },
                        body: new FormData(form)
                    })
                        .then((response) => {
                            if (response.status === 422) {
                                return response.json().then((data) => { throw data; });
                            }
                            if (!response.ok) {
                                throw { message: 'Terjadi kesalahan saat membuat undangan.' };
                            }
                            return response.json();
                        })
                        .then((data) => {
                            btn.innerHTML = '<i class="bi bi-check2 me-1" aria-hidden="true"></i> Berhasil';
                            setTimeout(() => {
                                if (typeof bootstrap !== 'undefined') {
                                    bootstrap.Modal.getInstance(modalEl).hide();
                                }
                                window.location.href = data.redirect || window.location.href;
                            }, 800);
                        })
                        .catch((data) => {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-stars me-1" aria-hidden="true"></i> Buat Undangan';
                            if (data && data.errors) {
                                const firstKey = Object.keys(data.errors)[0];
                                errorEl.textContent = data.errors[firstKey][0] || 'Periksa kembali data yang diinput.';
                            } else {
                                errorEl.textContent = (data && data.message) || 'Terjadi kesalahan.';
                            }
                            errorEl.classList.remove('d-none');
                        });
                });

                // Reset state saat modal ditutup
                if (modalEl) {
                    modalEl.addEventListener('hidden.bs.modal', () => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-stars me-1" aria-hidden="true"></i> Buat Undangan';
                        errorEl.classList.add('d-none');
                        errorEl.textContent = '';
                        form.reset();
                    });
                }
            })();
        </script>

    </div>
</x-app-layout>
<x-app-layout>
    <div class="container-fluid px-0 py-2 saya-page">

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

            /* --- Modal (samakan dengan /home) --- */
            .modal-theme-navy .modal-header {
                background: linear-gradient(135deg, #1B2A4A 0%, #2A3F6A 100%);
                color: #fff;
                border-bottom: 2px solid var(--adminuiux-theme-1, #C6A962);
                padding: 1.25rem 1.5rem;
            }

            .modal-theme-navy .modal-title {
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 700;
                letter-spacing: 0.3px;
            }

            .modal-theme-navy .modal-body,
            .modal-theme-navy .modal-footer {
                background-color: #FFFFFF !important;
            }

            .modal-theme-navy .modal-footer {
                border-top: 1px solid var(--bs-border-color);
                padding: 1rem 1.5rem;
            }

            [data-bs-theme="dark"] .modal-theme-navy .modal-body,
            [data-bs-theme="dark"] .modal-theme-navy .modal-footer {
                background-color: #1f2937 !important;
            }

            .modal-theme-navy .modal-content {
                background-color: #FFFFFF !important;
            }

            [data-bs-theme="dark"] .modal-theme-navy .modal-content {
                background-color: #1f2937 !important;
            }

            /* --- Category Card Selector (samakan dengan /home) --- */
            .category-option-card {
                border: 2px solid var(--bs-border-color);
                border-radius: 14px;
                background: var(--adminuiux-bg-1, #f8fafc);
                transition: all 0.25s ease;
                cursor: pointer;
                overflow: hidden;
            }

            .category-option-card:hover {
                border-color: rgba(198, 169, 98, 0.6);
                transform: translateY(-3px);
                box-shadow: 0 8px 18px rgba(198, 169, 98, 0.15);
            }

            .category-option-card.selected {
                border-color: var(--adminuiux-theme-1, #C6A962) !important;
                background: rgba(198, 169, 98, 0.06);
                box-shadow: 0 0 0 0.2rem rgba(198, 169, 98, 0.25) !important;
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

            /* =========================================================================
               DARK MODE — Dashboard Saya (Published Invitation)
               Dipisah per kategori: Token · Surface · Teks · Border · Badge
               · Tombol · Input · Progress · Chart
               ========================================================================= */
            [data-bs-theme="dark"] .saya-page {
                color-scheme: dark;
                --saya-surface-1: #111827;
                --saya-surface-2: #182234;
                --saya-surface-3: rgba(255, 255, 255, 0.05);
                --saya-surface-hover: rgba(232, 213, 163, 0.14);
                --saya-border: rgba(255, 255, 255, 0.09);
                --saya-border-strong: rgba(255, 255, 255, 0.16);
                --saya-text: #F1F5F9;
                --saya-text-secondary: #CBD5E1;
                --saya-text-muted: #94A3B8;
                --saya-gold: #E8D5A3;
                --gold-subtle: rgba(232, 213, 163, 0.12);
            }

            /* --- Surface: putih/terang → gelap --- */
            [data-bs-theme="dark"] .saya-page .card {
                background: var(--saya-surface-1) !important;
                border-color: var(--saya-border) !important;
                box-shadow: 0 6px 24px rgba(0, 0, 0, 0.35) !important;
            }

            [data-bs-theme="dark"] .saya-page .bg-white {
                background-color: var(--saya-surface-2) !important;
                color: var(--saya-text) !important;
            }

            [data-bs-theme="dark"] .saya-page .bg-light,
            [data-bs-theme="dark"] .saya-page .bg-light-subtle {
                background-color: var(--saya-surface-3) !important;
                color: var(--saya-text) !important;
            }

            [data-bs-theme="dark"] .saya-page .bg-gold-subtle {
                background-color: var(--saya-surface-hover) !important;
            }

            /* --- Teks --- */
            [data-bs-theme="dark"] .saya-page .text-dark {
                color: var(--saya-text) !important;
            }

            [data-bs-theme="dark"] .saya-page .text-secondary {
                color: var(--saya-text-secondary) !important;
            }

            [data-bs-theme="dark"] .saya-page .text-muted {
                color: var(--saya-text-muted) !important;
            }

            [data-bs-theme="dark"] .saya-page .text-gold,
            [data-bs-theme="dark"] .saya-page .text-gold-dark {
                color: var(--saya-gold) !important;
            }

            /* --- Border --- */
            [data-bs-theme="dark"] .saya-page .border,
            [data-bs-theme="dark"] .saya-page .border-light-subtle {
                border-color: var(--saya-border) !important;
            }

            /* --- Badge --- */
            [data-bs-theme="dark"] .saya-page .badge-gold {
                background-color: rgba(232, 213, 163, 0.16) !important;
                color: var(--saya-gold) !important;
            }

            [data-bs-theme="dark"] .saya-page .badge.bg-light {
                background-color: rgba(255, 255, 255, 0.06) !important;
                color: var(--saya-text-secondary) !important;
            }

            /* --- Tombol --- */
            [data-bs-theme="dark"] .saya-page .btn-light,
            [data-bs-theme="dark"] .saya-page .btn-white {
                background-color: var(--saya-surface-3) !important;
                border-color: var(--saya-border) !important;
                color: var(--saya-text) !important;
            }

            [data-bs-theme="dark"] .saya-page .btn-light:hover,
            [data-bs-theme="dark"] .saya-page .btn-white:hover {
                background-color: var(--saya-surface-hover) !important;
                border-color: rgba(232, 213, 163, 0.35) !important;
                color: var(--saya-gold) !important;
            }

            [data-bs-theme="dark"] .saya-page .btn-light.active {
                background-color: var(--saya-surface-hover) !important;
                border-color: rgba(232, 213, 163, 0.35) !important;
                color: var(--saya-gold) !important;
            }

            [data-bs-theme="dark"] .saya-page .btn-outline-dark {
                border-color: var(--saya-border-strong) !important;
                color: var(--saya-text) !important;
            }

            [data-bs-theme="dark"] .saya-page .btn-outline-dark:hover {
                background-color: rgba(255, 255, 255, 0.08) !important;
                color: #FFFFFF !important;
            }

            [data-bs-theme="dark"] .saya-page .btn-outline-secondary {
                border-color: var(--saya-border-strong) !important;
                color: var(--saya-text-secondary) !important;
            }

            [data-bs-theme="dark"] .saya-page .btn-outline-secondary:hover {
                background-color: rgba(255, 255, 255, 0.08) !important;
                color: var(--saya-text) !important;
            }

            /* --- Input & Select --- */
            [data-bs-theme="dark"] .saya-page .form-control,
            [data-bs-theme="dark"] .saya-page .form-select {
                background-color: var(--saya-surface-3) !important;
                border-color: var(--saya-border) !important;
                color: var(--saya-text) !important;
            }

            [data-bs-theme="dark"] .saya-page .form-control::placeholder {
                color: #64748B !important;
                opacity: 1;
            }

            [data-bs-theme="dark"] .saya-page .input-group-text {
                background-color: rgba(255, 255, 255, 0.05) !important;
                border-color: var(--saya-border) !important;
                color: var(--saya-text-muted) !important;
            }

            [data-bs-theme="dark"] .saya-page .form-floating>label {
                color: var(--saya-text-muted);
            }

            [data-bs-theme="dark"] .saya-page .form-text {
                color: var(--saya-text-muted) !important;
            }

            /* --- Progress & Chart --- */
            [data-bs-theme="dark"] .saya-page .progress {
                background-color: rgba(255, 255, 255, 0.08) !important;
            }

            /* --- Overlay kartu pada cover undangan --- */
            [data-bs-theme="dark"] .saya-page .saya-cover .bg-white {
                background-color: rgba(17, 24, 39, 0.82) !important;
                border: 1px solid var(--saya-border-strong);
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

            {{-- Modal: Buat Undangan Pertama (samakan dengan /home) --}}
            <div class="modal fade modal-theme-navy" id="newInvitationModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                        <form id="quickCreateForm" action="{{ route('invitation.quick-create') }}" method="POST">
                            @csrf

                            <div class="modal-header d-flex align-items-center justify-content-between px-4 py-3">
                                <h5 class="modal-title mb-0 d-flex align-items-center gap-2" id="modalStepTitle">
                                    <i class="bi bi-suit-heart-fill" style="color: var(--gold-primary, #C6A962);"></i>
                                    <span>Pilih Kategori Undangan</span>
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>

                            <div class="modal-body p-4 p-md-4" style="max-height: 72vh; overflow-y: auto;">

                                {{-- Step 1: Category Selection --}}
                                <div id="modalStepCategory" class="modal-step active">
                                    <div class="text-center mb-4">
                                        <h6 class="fw-bold mb-1">Mulai Perjalanan Undangan Anda</h6>
                                        <p class="text-muted small mb-0">Pilih jenis momen atau acara yang ingin Anda
                                            rayakan:</p>
                                    </div>

                                    <div class="row g-3" id="homeCategorySelector">
                                        @php
                                            $homeCategories = App\Models\Category::active()->ordered()->withCount([
                                                'templates as template_count' => function ($q) {
                                                    $q->where('is_active', true);
                                                }
                                            ])->get();
                                        @endphp
                                        @foreach($homeCategories as $category)
                                            <div class="col-6 col-md-4 col-lg-3">
                                                <div class="category-option category-option-card h-100 p-3 text-center d-flex flex-column align-items-center justify-content-between"
                                                    data-category-id="{{ $category->id }}"
                                                    onclick="homeSelectCategory(this, {{ $category->id }}, '{{ addslashes($category->name) }}')">
                                                    <div class="rounded-3 d-flex align-items-center justify-content-center mb-2"
                                                        style="width: 60px; height: 60px; background: rgba(198, 169, 98, 0.12);">
                                                        @if($category->thumbnail_url)
                                                            <img src="{{ $category->thumbnail_url }}" alt="{{ $category->name }}"
                                                                style="max-width: 44px; max-height: 44px; object-fit: contain;">
                                                        @else
                                                            {!! category_icon_html($category, 'fs-3', 'style="color: #A68B4B;"') !!}
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h6 class="fw-bold mb-1 small text-dark">{{ ucfirst($category->name) }}
                                                        </h6>
                                                        <span class="badge bg-light text-muted border"
                                                            style="font-size: 0.68rem;">
                                                            {{ $category->template_count }} Template
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" id="home_category_id" name="category_id">
                                </div>

                                {{-- Step 2: Form Fields --}}
                                <div id="modalStepForm" class="modal-step d-none">
                                    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark" id="homeFormTitle">Data Undangan</h6>
                                            <small class="text-muted" id="homeFormSubtitle">Lengkapi informasi dasar untuk
                                                undangan Anda</small>
                                        </div>
                                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3"
                                            onclick="homeGoToStep('category')">
                                            <i class="bi bi-arrow-left me-1"></i> Ganti Kategori
                                        </button>
                                    </div>

                                    {{-- Wedding fields --}}
                                    <div id="homeFormWedding" class="d-none">
                                        <div class="mb-4 p-3 rounded-3"
                                            style="background: rgba(198, 169, 98, 0.05); border: 1px solid rgba(198, 169, 98, 0.2);">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 28px; height: 28px; background: #C6A962; color: #fff;">
                                                    <i class="bi bi-gender-male"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0 text-dark text-uppercase small"
                                                    style="letter-spacing: 0.5px;">Mempelai Pria</h6>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-12 col-md-7">
                                                    <label class="form-label small fw-semibold mb-1">Nama Lengkap <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                        <input type="text" name="groom_name" id="wedding_groom_name"
                                                            class="form-control" placeholder="Contoh: Raden Surya" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <label class="form-label small fw-semibold mb-1">Nama Panggilan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-person-badge"></i></span>
                                                        <input type="text" name="groom_nickname" id="wedding_groom_nickname"
                                                            class="form-control" placeholder="Surya">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center my-3 position-relative">
                                            <hr class="my-0" style="border-color: rgba(198, 169, 98, 0.4);">
                                            <span
                                                class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-gold"
                                                style="font-size: 1.2rem; background-color: var(--adminuiux-bg-2, #FFFFFF) !important;">
                                                <i class="bi bi-suit-heart-fill"></i>
                                            </span>
                                        </div>

                                        <div class="mb-3 p-3 rounded-3"
                                            style="background: rgba(198, 169, 98, 0.05); border: 1px solid rgba(198, 169, 98, 0.2);">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                                    style="width: 28px; height: 28px; background: #C6A962; color: #fff;">
                                                    <i class="bi bi-gender-female"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0 text-dark text-uppercase small"
                                                    style="letter-spacing: 0.5px;">Mempelai Wanita</h6>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-12 col-md-7">
                                                    <label class="form-label small fw-semibold mb-1">Nama Lengkap <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                        <input type="text" name="bride_name" id="wedding_bride_name"
                                                            class="form-control" placeholder="Contoh: Putri Ayuningtyas"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <label class="form-label small fw-semibold mb-1">Nama Panggilan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="bi bi-person-badge"></i></span>
                                                        <input type="text" name="bride_nickname" id="wedding_bride_nickname"
                                                            class="form-control" placeholder="Putri">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Non-wedding generic fields --}}
                                    <div id="homeFormGeneric" class="d-none">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="groom_name" id="generic_groom_name"
                                                class="form-control py-2"
                                                placeholder="Contoh: Perayaan Ulang Tahun, Seminar, dll" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Deskripsi Acara (opsional)</label>
                                            <textarea name="bride_name" id="generic_bride_name" class="form-control py-2"
                                                rows="3" placeholder="Tuliskan sekilas tentang acara Anda..."
                                                disabled></textarea>
                                            <div class="form-text small">Informasi ini akan ditampilkan pada pembuka
                                                undangan digital Anda.</div>
                                        </div>
                                    </div>

                                    <div id="home_form_error" class="alert alert-danger d-none mt-3 rounded-3"></div>
                                </div>

                            </div>

                            <div class="modal-footer d-flex justify-content-between align-items-center px-4 py-3">
                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                    id="homeModalBackBtn" data-bs-dismiss="modal" style="display: none;">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="btn text-white rounded-pill px-4 py-2 fw-semibold shadow-sm ms-auto"
                                    id="homeQuickCreateBtn"
                                    style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;"
                                    disabled>
                                    <i class="bi bi-stars me-1"></i> Buat Undangan Sekarang
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

                    // --- Statistik trafik kunjungan 24 jam terakhir ---
                    $traffic = $invitation->hourlyViews(24);
                    $trafficLabels = array_column($traffic, 'label');
                    $trafficCounts = array_column($traffic, 'count');
                    $trafficTotal = array_sum($trafficCounts);
                    $trafficMax = $trafficCounts ? max($trafficCounts) : 0;
                    $trafficPeakIndex = $trafficMax > 0 ? array_search($trafficMax, $trafficCounts, true) : null;
                    $trafficPeakLabel = $trafficPeakIndex !== null ? $trafficLabels[$trafficPeakIndex] : null;
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
                                            data-bs-toggle="modal" data-bs-target="#shareModalDynamic" data-id="{{ $invitation->public_id }}">
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
                            <div class="col-12 col-lg-5 saya-cover">
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
                <section class="row g-4 align-items-stretch">

                    {{-- Distribusi Kehadiran & RSVP (Full Width) --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-4">
                                @php
                                    $pctHadir = $totalRsvp > 0 ? round(($rsvpYes / $totalRsvp) * 100, 1) : 0;
                                    $pctRagu = $totalRsvp > 0 ? round(($rsvpMaybe / $totalRsvp) * 100, 1) : 0;
                                    $pctTidak = $totalRsvp > 0 ? round(($rsvpNo / $totalRsvp) * 100, 1) : 0;
                                @endphp

                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                                    <div>
                                        <h5 class="font-serif fw-bold text-dark mb-1">Distribusi Kehadiran &amp; RSVP</h5>
                                        <small class="text-muted">Breakdown respon langsung dari undangan yang disebar</small>
                                    </div>
                                    <span class="badge badge-gold px-3 py-2 rounded-pill">{{ $totalRsvp }} Konfirmasi</span>
                                </div>

                                {{-- Stat tiles --}}
                                <div class="row g-3 mb-4">
                                    <div class="col-6 col-lg-3">
                                        <div class="p-3 rounded-3 h-100"
                                            style="background: rgba(198,169,98,.12); border: 1px solid rgba(198,169,98,.25);">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="rounded-circle flex-shrink-0"
                                                    style="width: 10px; height: 10px; background: #C6A962;"></span>
                                                <span class="text-uppercase fw-bold text-muted"
                                                    style="font-size: 10px; letter-spacing: .5px;">Hadir</span>
                                            </div>
                                            <div class="font-serif fw-bold h3 text-dark mb-0">{{ $rsvpYes }}</div>
                                            <div class="small text-muted">{{ $pctHadir }}% dari total</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="p-3 rounded-3 h-100"
                                            style="background: rgba(253,195,77,.12); border: 1px solid rgba(253,195,77,.25);">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="rounded-circle flex-shrink-0"
                                                    style="width: 10px; height: 10px; background: #fdc34d;"></span>
                                                <span class="text-uppercase fw-bold text-muted"
                                                    style="font-size: 10px; letter-spacing: .5px;">Ragu-ragu</span>
                                            </div>
                                            <div class="font-serif fw-bold h3 mb-0" style="color: #b78103;">{{ $rsvpMaybe }}
                                            </div>
                                            <div class="small text-muted">{{ $pctRagu }}% dari total</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="p-3 rounded-3 h-100"
                                            style="background: rgba(148,163,184,.12); border: 1px solid rgba(148,163,184,.25);">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <span class="rounded-circle flex-shrink-0"
                                                    style="width: 10px; height: 10px; background: #cbd5e1;"></span>
                                                <span class="text-uppercase fw-bold text-muted"
                                                    style="font-size: 10px; letter-spacing: .5px;">Tidak Hadir</span>
                                            </div>
                                            <div class="font-serif fw-bold h3 text-secondary mb-0">{{ $rsvpNo }}</div>
                                            <div class="small text-muted">{{ $pctTidak }}% dari total</div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <div class="p-3 rounded-3 h-100 bg-light border border-light-subtle">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="bi bi-envelope-check text-gold-dark"></i>
                                                <span class="text-uppercase fw-bold text-muted"
                                                    style="font-size: 10px; letter-spacing: .5px;">Total Konfirmasi</span>
                                            </div>
                                            <div class="font-serif fw-bold h3 text-dark mb-0">{{ $totalRsvp }}</div>
                                            <div class="small text-muted">seluruh respon masuk</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Bar progres multi-segmen --}}
                                <div class="d-flex justify-content-between small text-muted mb-1">
                                    <span>0%</span>
                                    <span>100%</span>
                                </div>
                                <div class="progress mb-3"
                                    style="height: 24px; border-radius: 8px; background-color: rgba(148,163,184,.15); overflow: hidden;">
                                    <div class="progress-bar progress-bar-hadir d-flex align-items-center justify-content-center"
                                        role="progressbar" style="width: {{ $pctHadir }}%;"
                                        title="Hadir: {{ $rsvpYes }} ({{ $pctHadir }}%)">
                                        @if($pctHadir >= 10)
                                            <span class="text-white fw-bold" style="font-size: 10px;">{{ $pctHadir }}%</span>
                                        @endif
                                    </div>
                                    <div class="progress-bar progress-bar-ragu d-flex align-items-center justify-content-center"
                                        role="progressbar" style="width: {{ $pctRagu }}%;"
                                        title="Ragu-ragu: {{ $rsvpMaybe }} ({{ $pctRagu }}%)">
                                        @if($pctRagu >= 10)
                                            <span class="text-dark fw-bold" style="font-size: 10px;">{{ $pctRagu }}%</span>
                                        @endif
                                    </div>
                                    <div class="progress-bar progress-bar-tidak d-flex align-items-center justify-content-center"
                                        role="progressbar" style="width: {{ $pctTidak }}%;"
                                        title="Tidak Hadir: {{ $rsvpNo }} ({{ $pctTidak }}%)">
                                        @if($pctTidak >= 10)
                                            <span class="text-dark fw-bold" style="font-size: 10px;">{{ $pctTidak }}%</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Legenda detail --}}
                                <div class="d-flex flex-wrap gap-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle"
                                            style="width: 10px; height: 10px; background: #C6A962;"></span>
                                        <span class="small fw-semibold text-dark">{{ $rsvpYes }} Hadir</span>
                                        <span class="small text-muted">({{ $pctHadir }}%)</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle"
                                            style="width: 10px; height: 10px; background: #fdc34d;"></span>
                                        <span class="small fw-semibold text-dark">{{ $rsvpMaybe }} Ragu-ragu</span>
                                        <span class="small text-muted">({{ $pctRagu }}%)</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rounded-circle"
                                            style="width: 10px; height: 10px; background: #cbd5e1;"></span>
                                        <span class="small fw-semibold text-dark">{{ $rsvpNo }} Tidak Hadir</span>
                                        <span class="small text-muted">({{ $pctTidak }}%)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom kiri: Distribusi RSVP + Trafik --}}
                    <div class="row g-4 align-items-stretch">
                        {{-- Kolom kiri: Statistik Konfirmasi Kehadiran --}}
                        <div class="col-12 col-lg-7 d-flex flex-column gap-4">
                            <div class="card flex-fill h-100">
                                <div class="card-body p-4 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <h5 class="font-serif fw-bold text-dark mb-0">Statistik Konfirmasi Kehadiran</h5>
                                            <small class="text-muted">Ringkasan respon RSVP dari undangan ini</small>
                                        </div>
                                        <span class="badge badge-gold px-3 py-2 rounded-pill">
                                            {{ $totalRsvp > 0 ? round(($rsvpYes / $totalRsvp) * 100) : 0 }}% Hadir
                                        </span>
                                    </div>

                                    <div class="row g-4 align-items-center my-auto">
                                        <div class="col-12 col-sm-5">
                                            <div class="position-relative mx-auto" style="height: 210px; max-width: 250px;">
                                                <canvas id="rsvpDoughnutChart" role="img"
                                                    aria-label="Grafik bulat konfirmasi kehadiran"></canvas>
                                                <div class="position-absolute top-50 start-50 translate-middle text-center"
                                                    style="pointer-events: none;">
                                                    <div class="font-serif fw-bold h3 text-dark mb-0">{{ $totalRsvp }}</div>
                                                    <div class="text-uppercase text-muted fw-bold"
                                                        style="font-size: 9px; letter-spacing: .6px;">Total</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-7">
                                            @php
                                                $rsvpLegend = [
                                                    ['label' => 'Hadir', 'value' => $rsvpYes, 'color' => '#C6A962'],
                                                    ['label' => 'Ragu-ragu', 'value' => $rsvpMaybe, 'color' => '#F59E0B'],
                                                    ['label' => 'Tidak Hadir', 'value' => $rsvpNo, 'color' => '#94A3B8'],
                                                ];
                                            @endphp

                                            @foreach($rsvpLegend as $item)
                                                @php
                                                    $legendPct = $totalRsvp > 0 ? round(($item['value'] / $totalRsvp) * 100, 1) : 0;
                                                @endphp
                                                <div class="d-flex align-items-center gap-3 mb-3">
                                                    <span class="rounded-circle flex-shrink-0"
                                                        style="width: 12px; height: 12px; background-color: {{ $item['color'] }};"></span>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="fw-semibold text-dark small">{{ $item['label'] }}</span>
                                                            <span class="fw-bold text-dark small">
                                                                {{ $item['value'] }}
                                                                <span class="text-muted fw-normal">({{ $legendPct }}%)</span>
                                                            </span>
                                                        </div>
                                                        <div class="progress"
                                                            style="height: 6px; border-radius: 99px; background-color: rgba(148, 163, 184, 0.18);">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $legendPct }}%; background-color: {{ $item['color'] }}; border-radius: 99px;"
                                                                aria-valuenow="{{ $legendPct }}" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom kanan: Buku Tamu & Ucapan --}}
                        <div class="col-12 col-lg-5 d-flex flex-column gap-4">
                            <div class="card flex-fill h-100">
                                <div class="card-body p-4 d-flex flex-column">
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
                                    <div class="flex-grow-1">
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
                                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold small flex-shrink-0"
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
                                            <div class="text-center py-4 text-muted my-auto">
                                                <i class="bi bi-chat-square-text fs-3 mb-2" aria-hidden="true"></i>
                                                <p class="small mb-0">
                                                    Belum ada ucapan dari tamu. Bagikan undangan untuk mulai menerima ucapan.
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Trigger moderasi --}}
                                    <a href="{{ route('rsvp.index', ['list' => $invitation->id]) }}"
                                        class="btn btn-light w-100 py-2 mt-2 rounded-3 text-dark fw-semibold small d-flex align-items-center justify-content-center gap-2 border">
                                        <i class="bi bi-chat-text text-gold" aria-hidden="true"></i>
                                        <span>Buka Ruang Moderasi Buku Tamu</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Trafik kunjungan 24 jam terakhir (full width) --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                                    <div>
                                        <h5 class="font-serif fw-bold text-dark mb-0">Trafik Kunjungan 24 Jam Terakhir</h5>
                                        <small class="text-muted">
                                            @if($trafficTotal > 0)
                                                Total {{ number_format($trafficTotal) }} kunjungan
                                                @if($trafficPeakLabel)
                                                    · Puncak pukul {{ $trafficPeakLabel }}
                                                    ({{ number_format($trafficMax) }} kunjungan)
                                                @endif
                                            @else
                                                Belum ada kunjungan yang tercatat pada 24 jam terakhir.
                                            @endif
                                        </small>
                                    </div>
                                    <span
                                        class="badge badge-gold px-3 py-2 rounded-pill d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-clock-history" aria-hidden="true"></i>
                                        <span>24 Jam Terakhir</span>
                                    </span>
                                </div>

                                <div class="w-100" style="height: 280px;">
                                    <canvas id="trafficChart" role="img"
                                        aria-label="Grafik trafik kunjungan 24 jam terakhir"></canvas>
                                </div>
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
            <div id="wa-message-{{ $invitation->public_id }}" class="d-none">
                @include('dashboard.invitation.pesan', ['inv' => $invitation])
            </div>
            @include('layouts.partial.share-modal')
        @endif
        @include('layouts.partial.share-modal-js')

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

        {{-- Modal create (samakan dengan /home): kategori -> form --}}
        <script>
            (function () {
                'use strict';
                const modalEl = document.getElementById('newInvitationModal');
                const form = document.getElementById('quickCreateForm');
                if (!modalEl || !form) return;

                const formTitle = document.getElementById('homeFormTitle');
                const formSubtitle = document.getElementById('homeFormSubtitle');
                const formWedding = document.getElementById('homeFormWedding');
                const formGeneric = document.getElementById('homeFormGeneric');
                const quickCreateBtn = document.getElementById('homeQuickCreateBtn');
                const backBtn = document.getElementById('homeModalBackBtn');
                const stepTitle = document.getElementById('modalStepTitle');
                const errorDiv = document.getElementById('home_form_error');

                function goToStep(step) {
                    document.querySelectorAll('#newInvitationModal .modal-step').forEach(s => s.classList.add('d-none'));
                    document.getElementById('modalStep' + step.charAt(0).toUpperCase() + step.slice(1)).classList.remove('d-none');

                    if (step === 'category') {
                        stepTitle.innerHTML = '<i class="bi bi-suit-heart-fill me-2" style="color: var(--gold-primary);"></i> Pilih Kategori';
                        quickCreateBtn.disabled = true;
                        backBtn.style.display = 'none';
                    } else if (step === 'form') {
                        stepTitle.innerHTML = '<i class="bi bi-pencil-square me-2"></i> Isi Data Undangan';
                        backBtn.style.display = 'inline-block';
                        validateForm();
                    }
                }

                function selectCategory(card, categoryId, categoryName) {
                    document.querySelectorAll('#homeCategorySelector .category-option').forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    document.getElementById('home_category_id').value = categoryId;

                    const catLower = (categoryName || '').toLowerCase();
                    formTitle.textContent = categoryName ? 'Data ' + categoryName : 'Data Undangan';
                    formSubtitle.textContent = 'Isi informasi undangan Anda sebelum dipublikasikan.';

                    const isWeddingLike = catLower.includes('wedding') || catLower.includes('engagement') ||
                        catLower.includes('nikah') || catLower.includes('pernikahan') || catLower.includes('lamaran');

                    if (isWeddingLike) {
                        formWedding.classList.remove('d-none');
                        formGeneric.classList.add('d-none');
                        formWedding.querySelectorAll('input').forEach(i => i.disabled = false);
                        const g = document.getElementById('wedding_groom_name');
                        const b = document.getElementById('wedding_bride_name');
                        if (g) g.required = true;
                        if (b) b.required = true;
                        formGeneric.querySelectorAll('input, textarea').forEach(i => { i.disabled = true; i.required = false; });
                    } else {
                        formGeneric.classList.remove('d-none');
                        formWedding.classList.add('d-none');
                        formGeneric.querySelectorAll('input, textarea').forEach(i => i.disabled = false);
                        const gg = document.getElementById('generic_groom_name');
                        if (gg) gg.required = true;
                        formWedding.querySelectorAll('input').forEach(i => { i.disabled = true; i.required = false; });
                    }

                    goToStep('form');
                    validateForm();
                }

                function validateForm() {
                    const categoryIdEl = document.getElementById('home_category_id');
                    const categoryId = categoryIdEl ? categoryIdEl.value : '';
                    let valid = false;
                    const stepForm = document.getElementById('modalStepForm');
                    if (stepForm && !stepForm.classList.contains('d-none')) {
                        if (!formWedding.classList.contains('d-none')) {
                            valid = !!(document.getElementById('wedding_groom_name').value.trim() && document.getElementById('wedding_bride_name').value.trim());
                        } else {
                            valid = !!document.getElementById('generic_groom_name').value.trim();
                        }
                    } else {
                        valid = !!categoryId;
                    }
                    quickCreateBtn.disabled = !valid;
                }

                document.querySelectorAll('#modalStepForm input, #modalStepForm textarea').forEach(el => {
                    el.addEventListener('input', validateForm);
                    el.addEventListener('change', validateForm);
                    el.addEventListener('keyup', validateForm);
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    errorDiv.classList.add('d-none');
                    errorDiv.innerHTML = '';
                    quickCreateBtn.disabled = true;
                    quickCreateBtn.innerHTML = '<i class="bi bi-arrow-repeat me-1"></i> Memproses...';

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : ''
                        },
                        body: new FormData(form)
                    })
                        .then(function (response) {
                            if (response.status === 422) {
                                return response.json().then(function (data) { throw data; });
                            }
                            if (!response.ok) {
                                return response.json().then(function (data) { throw data; }).catch(function () {
                                    throw { message: 'Terjadi kesalahan saat membuat undangan.' };
                                });
                            }
                            return response.json();
                        })
                        .then(function (data) {
                            quickCreateBtn.innerHTML = '<i class="bi bi-check2 me-1"></i> Berhasil';
                            setTimeout(function () {
                                const m = bootstrap.Modal.getInstance(modalEl);
                                if (m) m.hide();
                                window.location.href = data.redirect_url || data.redirect || window.location.href;
                            }, 800);
                        })
                        .catch(function (data) {
                            quickCreateBtn.disabled = false;
                            quickCreateBtn.innerHTML = '<i class="bi bi-stars me-1"></i> Buat Undangan Sekarang';
                            let msg = '';
                            if (data && data.errors) {
                                Object.keys(data.errors).some(function (key) { msg = data.errors[key][0]; return true; });
                            } else {
                                msg = (data && data.message) || 'Terjadi kesalahan saat memproses.';
                            }
                            errorDiv.textContent = msg || 'Periksa kembali data yang diinput.';
                            errorDiv.classList.remove('d-none');
                        });
                });

                modalEl.addEventListener('hidden.bs.modal', function () {
                    document.querySelectorAll('#newInvitationModal .modal-step').forEach(s => s.classList.add('d-none'));
                    document.getElementById('modalStepCategory').classList.remove('d-none');
                    stepTitle.innerHTML = '<i class="bi bi-suit-heart-fill me-2" style="color: var(--gold-primary);"></i> Pilih Kategori';
                    quickCreateBtn.disabled = true;
                    backBtn.style.display = 'none';
                    document.getElementById('home_category_id').value = '';
                    document.querySelectorAll('#homeCategorySelector .category-option').forEach(c => c.classList.remove('selected'));
                    document.querySelectorAll('#modalStepForm input, #modalStepForm textarea').forEach(i => i.value = '');
                    formWedding.classList.add('d-none');
                    formGeneric.classList.add('d-none');
                    formWedding.querySelectorAll('input').forEach(i => { i.disabled = false; i.required = false; });
                    formGeneric.querySelectorAll('input, textarea').forEach(i => { i.disabled = true; i.required = false; });
                    form.reset();
                });

                window.homeSelectCategory = selectCategory;
                window.homeGoToStep = goToStep;
            })();
        </script>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof Chart === 'undefined') return;

                const isDark = () => {
                    const attr = document.documentElement.getAttribute('data-bs-theme');
                    if (attr) return attr === 'dark';
                    const stored = localStorage.getItem('theme');
                    if (stored) return stored === 'dark';
                    return window.matchMedia('(prefers-color-scheme: dark)').matches;
                };

                // --- Grafik bulat: Statistik Konfirmasi Kehadiran ---
                const rsvpCanvas = document.getElementById('rsvpDoughnutChart');
                if (rsvpCanvas) {
                    const rsvpYes = {{ $rsvpYes ?? 0 }};
                    const rsvpMaybe = {{ $rsvpMaybe ?? 0 }};
                    const rsvpNo = {{ $rsvpNo ?? 0 }};
                    const rsvpTotal = rsvpYes + rsvpMaybe + rsvpNo;

                    const rsvpData = rsvpTotal > 0 ? [rsvpYes, rsvpMaybe, rsvpNo] : [1];
                    const rsvpColors = rsvpTotal > 0
                        ? ['#C6A962', '#F59E0B', '#94A3B8']
                        : ['rgba(148, 163, 184, 0.25)'];

                    const rsvpChart = new Chart(rsvpCanvas, {
                        type: 'doughnut',
                        data: {
                            labels: rsvpTotal > 0 ? ['Hadir', 'Ragu-ragu', 'Tidak Hadir'] : ['Belum ada data'],
                            datasets: [{
                                data: rsvpData,
                                backgroundColor: rsvpColors,
                                borderWidth: 3,
                                borderColor: isDark() ? '#111827' : '#FFFFFF',
                                hoverOffset: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '72%',
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    enabled: rsvpTotal > 0,
                                    padding: 12,
                                    boxPadding: 6,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function (context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const value = context.parsed;
                                            const pct = total > 0 ? Math.round((value / total) * 100) : 0;
                                            return ' ' + context.label + ': ' + value + ' tamu (' + pct + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });

                    const rsvpThemeObserver = new MutationObserver(function () {
                        rsvpChart.data.datasets[0].borderColor = isDark() ? '#111827' : '#FFFFFF';
                        rsvpChart.update();
                    });
                    rsvpThemeObserver.observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['data-bs-theme']
                    });
                }

                // --- Grafik trafik kunjungan 24 jam terakhir ---
                const trafficCanvas = document.getElementById('trafficChart');
                if (trafficCanvas) {
                    const trafficLabels = @json($trafficLabels ?? []);
                    const trafficCounts = @json($trafficCounts ?? []);
                    const trafficMax = {{ $trafficMax ?? 0 }};

                    const ctx = trafficCanvas.getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
                    gradient.addColorStop(0, 'rgba(198, 169, 98, 0.35)');
                    gradient.addColorStop(1, 'rgba(198, 169, 98, 0)');

                    const trafficChart = new Chart(trafficCanvas, {
                        type: 'line',
                        data: {
                            labels: trafficLabels,
                            datasets: [{
                                label: 'Kunjungan',
                                data: trafficCounts,
                                borderColor: '#C6A962',
                                backgroundColor: gradient,
                                borderWidth: 2.5,
                                fill: true,
                                tension: 0.38,
                                pointRadius: trafficCounts.some(v => v > 0) ? 3 : 0,
                                pointHoverRadius: 5,
                                pointBackgroundColor: '#C6A962',
                                pointBorderColor: isDark() ? '#111827' : '#FFFFFF',
                                pointBorderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: isDark() ? '#1F2937' : '#1B2A4A',
                                    titleColor: '#FFFFFF',
                                    bodyColor: '#E5E7EB',
                                    padding: 12,
                                    cornerRadius: 8,
                                    displayColors: false,
                                    callbacks: {
                                        title: items => items[0].label + ' WIB',
                                        label: context => ' ' + context.parsed.y + ' kunjungan'
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    border: { display: false },
                                    ticks: {
                                        color: isDark() ? '#94A3B8' : '#64748B',
                                        maxRotation: 0,
                                        autoSkip: true,
                                        maxTicksLimit: 8,
                                        font: { family: "'Plus Jakarta Sans', sans-serif", size: 11 }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: trafficMax > 0 ? undefined : 4,
                                    grid: {
                                        color: isDark() ? 'rgba(255, 255, 255, 0.08)' : 'rgba(27, 42, 74, 0.06)'
                                    },
                                    border: { display: false },
                                    ticks: {
                                        color: isDark() ? '#94A3B8' : '#64748B',
                                        precision: 0,
                                        maxTicksLimit: 5,
                                        font: { family: "'Inter', sans-serif", size: 11 }
                                    }
                                }
                            }
                        }
                    });

                    const trafficThemeObserver = new MutationObserver(function () {
                        const dark = isDark();
                        trafficChart.options.scales.x.ticks.color = dark ? '#94A3B8' : '#64748B';
                        trafficChart.options.scales.y.ticks.color = dark ? '#94A3B8' : '#64748B';
                        trafficChart.options.scales.y.grid.color = dark ? 'rgba(255, 255, 255, 0.08)' : 'rgba(27, 42, 74, 0.06)';
                        trafficChart.data.datasets[0].pointBorderColor = dark ? '#111827' : '#FFFFFF';
                        trafficChart.options.plugins.tooltip.backgroundColor = dark ? '#1F2937' : '#1B2A4A';
                        trafficChart.update();
                    });
                    trafficThemeObserver.observe(document.documentElement, {
                        attributes: true,
                        attributeFilter: ['data-bs-theme']
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>
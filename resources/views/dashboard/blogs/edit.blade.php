<x-app-layout>
    @push('styles')
    <style>
        /* --- Shell wrapper --- */
        .blogger-shell {
            background-color: #f8fafc;
            min-height: calc(100vh - 56px);
        }

        /* --- Top Bar --- */
        .blogger-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        /* --- Input Judul --- */
        .blogger-title-input {
            width: 100%;
            border: 0;
            border-bottom: 1px solid #e5e7eb;
            background: transparent;
            font-size: 1.35rem;
            font-weight: 600;
            color: #1f2937;
            padding: 0.75rem 0;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .blogger-title-input:focus {
            border-bottom-color: #ea580c;
        }

        .blogger-title-input::placeholder {
            color: #9ca3af;
            font-weight: 500;
        }

        /* --- Kanvas Editor --- */
        .blogger-editor {
            min-height: 440px;
            padding: 1.5rem 1.75rem;
            background-color: #ffffff;
            color: #1f2937;
            font-size: 1rem;
            line-height: 1.75;
            outline: none;
        }

        .blogger-editor:empty::before,
        .blogger-editor p:only-child:empty::before {
            content: attr(data-placeholder);
            color: #9ca3af;
            pointer-events: none;
            display: block;
        }

        .blogger-editor h1 { font-size: 1.75rem; font-weight: 700; margin: 1.25rem 0 0.5rem; line-height: 1.3; }
        .blogger-editor h2 { font-size: 1.4rem;  font-weight: 700; margin: 1.1rem 0 0.5rem;  line-height: 1.35; }
        .blogger-editor h3 { font-size: 1.15rem; font-weight: 600; margin: 1rem 0 0.4rem;    line-height: 1.4; }
        .blogger-editor p  { margin-bottom: 0.85rem; }
        .blogger-editor ul,
        .blogger-editor ol { padding-left: 1.5rem; margin-bottom: 0.85rem; }
        .blogger-editor img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 0.75rem 0;
        }
        .blogger-editor blockquote {
            border-left: 3px solid #ea580c;
            padding-left: 1rem;
            color: #4b5563;
            font-style: italic;
            margin: 1rem 0;
        }

        /* --- Sidebar Pengaturan --- */
        .blogger-sidebar {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .blogger-sidebar details summary {
            list-style: none;
            cursor: pointer;
            user-select: none;
        }

        .blogger-sidebar details summary::-webkit-details-marker {
            display: none;
        }

        .blogger-sidebar details[open] .chevron-icon {
            transform: rotate(180deg);
        }

        .chevron-icon {
            transition: transform 0.2s ease;
        }

        @media (min-width: 992px) {
            .blogger-sidebar-sticky {
                position: sticky;
                top: 1.25rem;
            }
        }

        /* --- Galeri Modal --- */
        .gallery-item {
            position: relative;
            aspect-ratio: 16 / 9;
            border-radius: 0.75rem;
            overflow: hidden;
            cursor: pointer;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .gallery-item:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-item .gallery-caption {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.6);
            color: #ffffff;
            font-size: 0.75rem;
            padding: 0.5rem;
        }

        /* --- Editor full height --- */
        .blogger-editor-shell {
            display: flex;
            flex-direction: column;
        }

        .blogger-editor-shell .tox-tinymce {
            border: 0 !important;
            border-radius: 0 !important;
        }

        .pixabay-thumb {
            display: block;
            cursor: pointer;
            border-radius: 0.5rem;
            overflow: hidden;
            aspect-ratio: 4 / 3;
            background: #f3f4f6;
        }

        .pixabay-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.25s ease;
        }

        .pixabay-thumb:hover img {
            transform: scale(1.06);
        }
    </style>
    @endpush

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.3.0/tinymce.min.js" referrerpolicy="origin"></script>

    {{-- =========================================================================
        BODY — Form Edit Post Blog
        ========================================================================= --}}
    <div class="blogger-shell py-4">
        <form id="blogForm"
              action="{{ route('admin.blogs.update', $blog) }}"
              method="POST"
              enctype="multipart/form-data"
              class="form-submit">
            @csrf
            @method('PUT')

            {{-- Konten & status disinkronkan dari contenteditable ke hidden input --}}
            <input type="hidden"
                   name="content"
                   id="blogContent"
                   value="{{ old('content') ? e(old('content')) : ($blog->content ?? '') }}">
            <input type="hidden" name="status" id="blogStatus" value="{{ old('status', $blog->is_active ? 'published' : 'draft') }}">

            {{-- Konteks galeri: event_id untuk fetch foto tamu --}}
            <input type="hidden"
                   name="event_id"
                   id="eventId"
                   value="{{ e(request()->input('event_id', 'default')) }}">

            <div class="container-fluid px-3 px-lg-4">

                {{-- ===== Top Bar ala Blogger ===== --}}
                <div class="blogger-topbar rounded-3 shadow-sm p-3 mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('admin.blogs.index') }}"
                               class="btn btn-light btn-sm border rounded-circle d-inline-flex align-items-center justify-content-center"
                               style="width: 36px; height: 36px;"
                               title="Kembali ke daftar post"
                               aria-label="Kembali">
                                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                            </a>
                            <div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <h1 class="h5 fw-bold mb-0 text-dark">Edit Post Blog</h1>
                                    <span id="statusBadge"
                                          class="badge rounded-pill {{ $blog->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        <i class="bi bi-{{ $blog->is_active ? 'check-circle' : 'file-earmark' }} me-1" aria-hidden="true"></i>
                                        <span id="statusBadgeText">{{ $blog->is_active ? 'Terpublikasi' : 'Draft' }}</span>
                                    </span>
                                </div>
                                <p class="text-muted small mb-0">
                                    Ubah konten post blog sebelumnya
                                </p>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <button type="button"
                                    id="btnPreview"
                                    class="btn btn-outline-secondary btn-sm px-3">
                                <i class="bi bi-eye me-1" aria-hidden="true"></i>
                                Pratinjau
                            </button>

                            <button type="button"
                                    id="btnSaveDraft"
                                    class="btn btn-light border btn-sm px-3">
                                <i class="bi bi-file-earmark me-1" aria-hidden="true"></i>
                                Simpan Draft
                            </button>

                            <button type="submit"
                                    id="btnPublish"
                                    class="btn btn-primary btn-sm px-3 fw-medium">
                                <i class="bi bi-send me-1" aria-hidden="true"></i>
                                Perbarui
                            </button>

                            <div class="dropdown">
                                <button class="btn btn-light border btn-sm"
                                        type="button"
                                        id="moreActionsDropdown"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        title="Opsi lainnya">
                                    <i class="bi bi-three-dots-vertical" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm small">
                                    <li>
                                        <button type="button"
                                                class="dropdown-item"
                                                data-action="save-draft">
                                            <i class="bi bi-file-earmark me-2 text-muted" aria-hidden="true"></i>
                                            Simpan sebagai draft
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                                class="dropdown-item"
                                                data-action="publish">
                                            <i class="bi bi-send me-2 text-primary" aria-hidden="true"></i>
                                            Publikasikan sekarang
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                                class="dropdown-item"
                                                data-action="preview">
                                            <i class="bi bi-eye me-2 text-muted" aria-hidden="true"></i>
                                            Pratinjau artikel
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('admin.blogs.index') }}">
                                            <i class="bi bi-x-circle me-2" aria-hidden="true"></i>
                                            Batalkan & keluar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== Alert error validasi ===== --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <strong class="d-block mb-1">
                            <i class="bi bi-exclamation-triangle me-1" aria-hidden="true"></i>
                            Periksa kembali isian berikut:
                        </strong>
                        <ul class="mb-0 small ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                {{-- ===== Layout 2 kolom: Editor + Sidebar ===== --}}
                <div class="row g-4 align-items-start">

                    {{-- ===== Kolom Kiri: Judul + Toolbar + Kanvas Editor ===== --}}
                    <div class="col-lg-8">
                        <div class="bg-white border rounded-3 shadow-sm overflow-hidden">

                            {{-- Input Judul --}}
                            <div class="px-4 pt-2 bg-white">
                                <label for="postTitle" class="visually-hidden">Judul Post</label>
                                <input type="text"
                                       id="postTitle"
                                       name="title"
                                       value="{{ old('title', $blog->title) }}"
                                       class="blogger-title-input @error('title') is-invalid @enderror"
                                       placeholder="Judul postingan..."
                                       required>
                                @error('title')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Area Tulis Konten (toolbar memakai TinyMCE bawaan) --}}
                            <div id="blogEditor"
                                 class="blogger-editor"
                                 contenteditable="true"
                                 data-placeholder="Mulai menulis cerita, panduan, atau inspirasi Anda...">
                                {!! old('content', $blog->content) !!}
                            </div>
                        </div>

                        {{-- Info jumlah kata --}}
                        <div class="d-flex justify-content-between align-items-center text-muted small mt-2 px-1">
                            <span id="wordCountText">0 kata Â· 0 karakter</span>
                            <span>Tip: Gunakan Heading 2/3 agar artikel mudah dibaca</span>
                        </div>
                    </div>

                    {{-- ===== Kolom Kanan: Sidebar Pengaturan Post ===== --}}
                    <div class="col-lg-4">
                        <div class="blogger-sidebar blogger-sidebar-sticky shadow-sm">
                            <div class="px-3 py-3 border-bottom bg-light d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small text-uppercase text-secondary"
                                      style="letter-spacing: 0.04em;">
                                    Setelan Postingan
                                </span>
                                <i class="bi bi-sliders2 text-secondary small" aria-hidden="true"></i>
                            </div>

                            {{-- 1. Gambar Sampul --}}
                            <details class="border-bottom p-2" open>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-card-image text-secondary" aria-hidden="true"></i>
                                        Gambar Sampul
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    {{-- Preview gambar existing --}}
                                    @if($blog->image)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($blog->image) }}"
                                                 alt="Preview sampul"
                                                 class="img-fluid rounded border"
                                                 style="max-height: 150px; object-fit: cover;">
                                        </div>
                                    @endif
                                    {{-- Input file --}}
                                    <input type="file"
                                           name="image"
                                           id="thumbnailInput"
                                           accept="image/*"
                                           class="form-control form-control-sm @error('image') is-invalid @enderror">
                                    <div class="form-text" style="font-size: 0.75rem;">
                                        Format JPG, PNG, atau WebP (maks. 2MB).
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </details>

                            {{-- 2. Label --}}
                            <details class="border-bottom p-2" open>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-tag text-secondary" aria-hidden="true"></i>
                                        Label
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <input type="text"
                                           name="label"
                                           value="{{ old('label') }}"
                                           placeholder="Contoh: Tips, Panduan, Berita"
                                           class="form-control form-control-sm">
                                    <div class="form-text" style="font-size: 0.75rem;">
                                        Pisahkan beberapa label dengan koma.
                                    </div>
                                </div>
                            </details>

                            {{-- 3. Tipe Post --}}
                            <details class="border-bottom p-2" open>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-folder text-secondary" aria-hidden="true"></i>
                                        Tipe Post
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="type"
                                               id="typeInspirasi"
                                               value="inspirasi"
                                               {{ old('type', $blog->type) === 'inspirasi' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="typeInspirasi">
                                            <i class="bi bi-star me-1 text-warning" aria-hidden="true"></i>Inspirasi
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="type"
                                               id="typePanduan"
                                               value="panduan"
                                               {{ old('type') === 'panduan' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="typePanduan">
                                            <i class="bi bi-book me-1 text-primary" aria-hidden="true"></i>Panduan
                                        </label>
                                    </div>
                                </div>
                            </details>

                            {{-- 4. Diterbitkan Pada --}}
                            <details class="border-bottom p-2">
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-calendar3 text-secondary" aria-hidden="true"></i>
                                        Diterbitkan pada
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="schedule_mode"
                                               id="scheduleAuto"
                                               value="auto"
                                               {{ old('schedule_mode', $blog->is_active && $blog->published_at ? 'auto' : 'auto') === 'auto' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="scheduleAuto">
                                            Otomatis saat dipublikasikan
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="schedule_mode"
                                               id="scheduleCustom"
                                               value="custom"
                                               {{ old('schedule_mode') === 'custom' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="scheduleCustom">
                                            Atur tanggal & waktu
                                        </label>
                                    </div>
                                    <div id="customScheduleBox"
                                         class="{{ old('schedule_mode') === 'custom' ? '' : 'd-none' }}">
                                        <input type="datetime-local"
                                               name="published_at"
                                               value="{{ old('published_at', $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d\\TH:i') : now()->format('Y-m-d\\TH:i')) }}"
                                               class="form-control form-control-sm">
                                    </div>
                                </div>
                            </details>

                            {{-- 5. Permalink --}}
                            <details class="border-bottom p-2">
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-link text-secondary" aria-hidden="true"></i>
                                        Permalink
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <input type="text"
                                           name="slug"
                                           id="permalinkInput"
                                           value="{{ old('slug', $blog->slug) }}"
                                           placeholder="slug-otomatis-dari-judul"
                                           class="form-control form-control-sm">
                                    <div class="form-text" style="font-size: 0.75rem;">
                                        Kosongkan agar dibuat otomatis dari judul.
                                    </div>
                                </div>
                            </details>

                            {{-- 6. Lokasi --}}
                            <details class="border-bottom p-2">
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-geo-alt text-secondary" aria-hidden="true"></i>
                                        Lokasi
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <input type="text"
                                           name="location"
                                           value="{{ old('location') }}"
                                           placeholder="Contoh: Tasikmalaya, Jawa Barat"
                                           class="form-control form-control-sm">
                                </div>
                            </details>

                            {{-- 7. Opsi Komentar --}}
                            <details>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-chat-dots text-secondary" aria-hidden="true"></i>
                                        Opsi
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <p class="small fw-medium text-dark mb-2">Komentar pembaca</p>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="comments"
                                               id="commentAllow"
                                               value="allow"
                                               {{ old('comments', $blog->comments ?? 'allow') === 'allow' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="commentAllow">Izinkan</label>
                                    </div>
                                    <div class="form-check mb-1">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="comments"
                                               id="commentHideNew"
                                               value="hide_new"
                                               {{ old('comments') === 'hide_new' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="commentHideNew">
                                            Tidak izinkan, tampilkan yang ada
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="comments"
                                               id="commentHideAll"
                                               value="hide_all"
                                               {{ old('comments') === 'hide_all' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="commentHideAll">
                                            Tidak izinkan, sembunyikan yang ada
                                        </label>
                                    </div>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- =========================================================================
        MODAL — Cari Gambar Pixabay
        ========================================================================= --}}
    <div class="modal fade"
         id="pixabayModal"
         tabindex="-1"
         aria-labelledby="pixabayModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom bg-light">
                    <h5 class="modal-title fw-semibold" id="pixabayModalLabel">
                        <i class="bi bi-image text-primary me-2" aria-hidden="true"></i>
                        Cari Gambar Pixabay
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="pixabaySearchForm" class="d-flex gap-2 mb-3">
                        <input type="text"
                               id="pixabayQuery"
                               class="form-control"
                               placeholder="Contoh: wedding decoration, bridal bouquet"
                               value="wedding"
                               aria-label="Kata kunci pencarian">
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="bi bi-search" aria-hidden="true"></i>
                        </button>
                    </form>

                    <div id="pixabayGrid" class="row g-2"></div>

                    <div id="pixabayEmpty" class="text-center py-4 text-muted d-none">
                        <i class="bi bi-image d-block mb-2" style="font-size: 2rem; opacity: 0.3;" aria-hidden="true"></i>
                        Belum ada hasil. Coba kata kunci lain.
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <span class="text-muted small me-auto">
                        <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
                        Klik gambar untuk menyisipkannya ke editor
                    </span>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================================
        MODAL — Pratinjau Postingan
        ========================================================================= --}}
    <div class="modal fade"
         id="previewModal"
         tabindex="-1"
         aria-labelledby="previewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="previewModalLabel">Pratinjau Postingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <h2 id="previewTitle" class="fw-bold mb-2"></h2>
                    <p id="previewMeta" class="text-muted small mb-4"></p>
                    <div id="previewContent" class="blogger-editor p-0" style="min-height: auto;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================================
        MODAL — Galeri Foto Tamu (sisipkan gambar ke editor)
        ========================================================================= --}}
    <div class="modal fade"
         id="galleryModal"
         tabindex="-1"
         aria-labelledby="galleryModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom bg-light">
                    <h5 class="modal-title fw-semibold" id="galleryModalLabel">
                        <i class="bi bi-images text-primary me-2" aria-hidden="true"></i>
                        Galeri Foto Tamu
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small" id="galleryTotal">0</span>
                        <button type="button"
                                class="btn btn-sm btn-outline-primary"
                                id="galleryRefreshBtn"
                                title="Refresh"
                                aria-label="Refresh galeri">
                            <i class="bi bi-arrow-clockwise" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                </div>
                <div class="modal-body p-4">
                    <div id="galleryLoading" class="text-center py-5 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Memuat...</span>
                        </div>
                        <p class="mt-2 text-muted">Memuat galeri...</p>
                    </div>

                    <div id="galleryError" class="alert alert-danger d-none rounded-3">
                        <i class="bi bi-exclamation-triangle-fill me-2" aria-hidden="true"></i>
                        <span></span>
                    </div>

                    <div id="galleryEmpty" class="text-center py-5 d-none">
                        <i class="bi bi-image"
                           style="font-size: 3rem; color: #d1d5db;"
                           aria-hidden="true"></i>
                        <p class="mt-3 text-muted mb-1">Tidak ada foto dari tamu</p>
                        <p class="text-muted small mb-0">
                            Minta tamu scan QR code di undangan untuk ikut berpartisipasi
                        </p>
                    </div>

                    <div class="row g-3" id="galleryGrid">
                        {{-- Diisi oleh JavaScript --}}
                    </div>
                </div>
                <div class="modal-footer border-top bg-light">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="bi bi-info-circle me-1" aria-hidden="true"></i>
                            Klik pada gambar untuk menyisipkannya ke editor
                        </div>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-1" aria-hidden="true"></i>
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- =========================================================================
        JAVASCRIPT — Logika editor, sidebar, modal, dan galeri
        Semua dalam IIFE + DOMContentLoaded agar tidak bocor ke global scope
        ========================================================================= --}}
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        'use strict';

        // --- Helper: ambil elemen ---
        const $  = (sel) => document.querySelector(sel);
        const $$ = (sel) => Array.from(document.querySelectorAll(sel));

        // --- Referensi elemen utama ---
        const editor         = $('#blogEditor');
        const hiddenContent  = $('#blogContent');
        const hiddenStatus   = $('#blogStatus');
        const eventIdInput   = $('#eventId');
        const blogForm       = $('#blogForm');
        const wordCountText  = $('#wordCountText');

        if (!editor || !blogForm) return;

        // --- Inisialisasi TinyMCE (3 baris toolbar: utama -> format -> sisanya) ---
        if (window.tinymce && typeof tinymce.init === 'function') {
            tinymce.init({
                selector: '#blogEditor',
                license_key: 'gpl',
                promotion: false,
                branding: false,
                menubar: false,
                statusbar: false,
                height: 520,
                plugins: [
                    'charmap', 'code', 'codesample', 'emoticons', 'fullscreen', 'help',
                    'image', 'insertdatetime', 'link', 'lists', 'media', 'preview',
                    'searchreplace', 'table', 'visualblocks', 'visualchars'
                ].join(' '),
                toolbar: [
                    // Baris 1 — yang utama
                    'undo redo | bold italic underline | alignleft aligncenter alignright | link image pixabay',
                    // Baris 2 — formatting lanjutan
                    'blocks fontsize | forecolor backcolor removeformat | bullist numlist outdent indent | blockquote',
                    // Baris 3 — sisanya
                    'table media codesample charmap emoticons insertdatetime | searchreplace visualblocks visualchars | preview fullscreen code help | gallery'
                ].join(' & '),
                fontsize_formats: '10pt 11pt 12pt 13pt 14pt 16pt 18pt 20pt 24pt 32pt',
                content_style: 'body { font-family: "Plus Jakarta Sans",Arial,sans-serif; font-size: 15px; line-height: 1.75; }',
                setup: function (ed) {
                    ed.on('change keyup undo redo SetContent', function () {
                        syncEditor();
                    });

                    // Tinggi editor mengikuti sisa viewport (full height)
                    ed.on('init', function () {
                        setTimeout(applyEditorHeight, 30);
                    });

                    ed.ui.registry.addButton('gallery', {
                        text: 'Galeri',
                        tooltip: 'Sisipkan Galeri Foto Tamu',
                        onAction: function () {
                            openGalleryModal();
                        }
                    });

                    ed.ui.registry.addButton('pixabay', {
                        text: 'Pixabay',
                        tooltip: 'Cari & sisipkan gambar dari Pixabay',
                        onAction: function () {
                            openPixabayModal();
                        }
                    });
                }
            });
        }

        // --- Sumber konten: TinyMCE jika aktif, fallback ke contenteditable ---
        function getEditorHtml() {
            var tiny = tinymce.get('blogEditor');
            return tiny ? tiny.getContent() : editor.innerHTML;
        }

        function getEditorText() {
            var tiny = tinymce.get('blogEditor');
            if (!tiny) return (editor.innerText || '').trim();
            var tmp = document.createElement('div');
            tmp.innerHTML = tiny.getContent();
            return (tmp.textContent || '').trim();
        }

        // --- Sinkronkan konten editor ke hidden input + hitung kata ---
        function syncEditor() {
            var rawHtml = getEditorHtml().trim();
            var isEmpty = rawHtml === '' || rawHtml === '<br>' || rawHtml === '<p><br></p>';
            hiddenContent.value = isEmpty ? '' : rawHtml;
            updateWordCount();
        }

        // --- Alias: sinkronkan konten TinyMCE ke hidden input ---
        function syncTinymceContent() {
            syncEditor();
        }

        function updateWordCount() {
            var text  = getEditorText();
            var words = text ? text.split(/\s+/).length : 0;
            wordCountText.textContent = words + ' kata Â· ' + text.length + ' karakter';
        }

        // --- Event editor (fallback contenteditable; TinyMCE memakai event sendiri) ---
        if (!tinymce.get('blogEditor')) {
            editor.addEventListener('input', syncEditor);
            editor.addEventListener('blur',  syncEditor);

            // Pastikan editor selalu punya minimal satu <p>
            if (!editor.innerHTML.trim()) {
                editor.innerHTML = '<p><br></p>';
            }
        }
        updateWordCount();

        // --- Toggle jadwal terbit kustom ---
        $$('input[name="schedule_mode"]').forEach((radio) => {
            radio.addEventListener('change', () => {
                const customBox = $('#customScheduleBox');
                if (!customBox) return;
                const checkedCustom = radio.checked && radio.value === 'custom';
                customBox.classList.toggle('d-none', !checkedCustom);
            });
        });

        // --- Preview gambar sampul (dengan revoke URL lama untuk mencegah memory leak) ---
        const thumbnailInput = $('#thumbnailInput');
        let currentObjectUrl = null;

        if (thumbnailInput) {
            thumbnailInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                const wrap = $('#thumbnailPreviewWrap');
                const img  = $('#thumbnailPreviewImg');

                if (currentObjectUrl) {
                    URL.revokeObjectURL(currentObjectUrl);
                    currentObjectUrl = null;
                }

                if (file) {
                    currentObjectUrl = URL.createObjectURL(file);
                    img.src = currentObjectUrl;
                    wrap.classList.remove('d-none');
                } else {
                    wrap.classList.add('d-none');
                    img.src = '#';
                }
            });
        }

        // --- Update badge status agar user tahu aksi mana yang sedang dipilih ---
        function setStatusBadge(published) {
            var badge = $('#statusBadge');
            var text = $('#statusBadgeText');
            if (!badge) return;

            badge.classList.toggle('bg-success', published);
            badge.classList.toggle('bg-secondary', !published);

            var icon = badge.querySelector('i');
            if (icon) {
                icon.className = 'bi bi-' + (published ? 'check-circle' : 'file-earmark') + ' me-1';
            }
            if (text) {
                text.textContent = published ? 'Terpublikasi' : 'Draft';
            }
        }

        // --- Tombol Simpan Draft / Perbarui / Publikasikan / Pratinjau ---
        $('#btnSaveDraft').addEventListener('click', () => {
            hiddenStatus.value = 'draft';
            setStatusBadge(false);
            syncTinymceContent();
            syncEditor();
            blogForm.requestSubmit();
        });

        // "Perbarui" mempertahankan status saat ini (draft tetap draft, aktif tetap aktif)
        $('#btnPublish').addEventListener('click', () => {
            syncTinymceContent();
            syncEditor();
        });

        $$('[data-action="publish"]').forEach((el) => {
            el.addEventListener('click', () => {
                hiddenStatus.value = 'published';
                setStatusBadge(true);
                syncTinymceContent();
                syncEditor();
                blogForm.requestSubmit();
            });
        });

        blogForm.addEventListener('submit', () => {
            syncTinymceContent();
            syncEditor();
        });

        $('#btnPreview').addEventListener('click', () => {
            syncTinymceContent();

            const titleInput = $('#postTitle');
            const labelInput = blogForm.querySelector('input[name="label"]');
            const locInput   = blogForm.querySelector('input[name="location"]');

            const titleVal = (titleInput.value || '').trim() || '(Tanpa Judul)';
            const labelVal = (labelInput.value || '').trim();
            const locVal   = (locInput.value || '').trim();

            $('#previewTitle').textContent = titleVal;

            const metaParts = [];
            if (labelVal) metaParts.push('Label: '   + labelVal);
            if (locVal)   metaParts.push('Lokasi: ' + locVal);
            $('#previewMeta').textContent = metaParts.join(' • ');

            $('#previewContent').innerHTML = hiddenContent.value || '<p class="text-muted">Belum ada konten.</p>';

            if (window.bootstrap && bootstrap.Modal) {
                const modal = new bootstrap.Modal($('#previewModal'));
                modal.show();
            }
        });

        // --- Item menu dropdown "Opsi lainnya" ---
        $$('[data-action="save-draft"]').forEach((el) => {
            el.addEventListener('click', () => $('#btnSaveDraft').click());
        });
        $$('[data-action="preview"]').forEach((el) => {
            el.addEventListener('click', () => $('#btnPreview').click());
        });

        // =========================================================================
        // TINGGI EDITOR (FULL HEIGHT)
        // =========================================================================

        function applyEditorHeight() {
            var ed = tinymce.get('blogEditor');
            if (!ed) return;

            var container = ed.getContentAreaContainer();
            if (!container) return;

            // Pakai posisi absolut dalam dokumen agar tinggi stabil saat halaman di-scroll
            var top = container.getBoundingClientRect().top + window.pageYOffset;
            var available = window.innerHeight - top - 24;
            var height = Math.max(340, Math.min(available, 1400));

            container.style.height = height + 'px';

            var iframe = container.querySelector('iframe');
            if (iframe) {
                iframe.style.height = '100%';
                iframe.style.display = 'block';
                iframe.style.border = '0';
            }
        }

        var resizeTimer = null;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(applyEditorHeight, 150);
        });

        // =========================================================================
        // PIXABAY IMAGE PICKER
        // =========================================================================

        const PIXABAY_SEARCH_URL = '{{ route('pixabay.search') }}';
        const pixabayModalEl = $('#pixabayModal');
        let pixabayModalInstance = null;
        let pixabayPage = 1;
        let pixabayQuery = '';

        if (pixabayModalEl && window.bootstrap && bootstrap.Modal) {
            pixabayModalInstance = new bootstrap.Modal(pixabayModalEl);
        }

        function openPixabayModal() {
            if (!pixabayModalInstance) return;

            pixabayPage = 1;
            pixabayQuery = '';

            var grid = $('#pixabayGrid');
            if (grid) grid.innerHTML = '';

            var empty = $('#pixabayEmpty');
            if (empty) empty.classList.add('d-none');

            pixabayModalInstance.show();
        }

        function insertPixabayImage(url, alt) {
            var ed = tinymce.get('blogEditor');
            var safeAlt = String(alt || 'Foto').replace(/"/g, '&quot;');

            if (ed) {
                ed.execCommand('mceInsertContent', false,
                    '<img src="' + url + '" alt="' + safeAlt + '" />');
                syncEditor();
            } else {
                document.execCommand('insertImage', false, url);
                syncEditor();
            }

            if (pixabayModalInstance) pixabayModalInstance.hide();
        }

        function renderPixabayHits(hits) {
            var grid = $('#pixabayGrid');
            var empty = $('#pixabayEmpty');
            if (!grid) return;

            grid.innerHTML = '';

            if (!hits || hits.length === 0) {
                if (empty) empty.classList.remove('d-none');
                return;
            }
            if (empty) empty.classList.add('d-none');

            var frag = document.createDocumentFragment();

            hits.forEach(function (hit) {
                var url = hit.largeImageURL || hit.webformatURL || hit.previewURL;
                if (!url) return;

                var col = document.createElement('div');
                col.className = 'col-6 col-md-4 col-lg-3';

                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'pixabay-thumb w-100 border-0 p-0 bg-transparent';
                btn.title = hit.tags || 'Pilih gambar';
                btn.setAttribute('aria-label', 'Sisipkan gambar: ' + (hit.tags || 'Pixabay'));

                var img = document.createElement('img');
                img.src = hit.previewURL || url;
                img.alt = hit.tags || 'Pixabay image';
                img.loading = 'lazy';
                img.className = 'w-100 rounded';

                btn.appendChild(img);
                btn.addEventListener('click', function () {
                    insertPixabayImage(url, hit.tags || 'Foto');
                });

                col.appendChild(btn);
                frag.appendChild(col);
            });

            grid.appendChild(frag);
        }

        function searchPixabay(query, page) {
            var grid = $('#pixabayGrid');
            var empty = $('#pixabayEmpty');

            if (grid) grid.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';
            if (empty) empty.classList.add('d-none');

            fetch(PIXABAY_SEARCH_URL + '?q=' + encodeURIComponent(query || 'wedding') + '&page=' + (page || 1), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (res) {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(function (data) {
                    if (data && data.error) {
                        throw new Error(data.error);
                    }
                    renderPixabayHits(data.hits || []);
                })
                .catch(function (err) {
                    if (grid) grid.innerHTML = '';
                    if (empty) {
                        empty.classList.remove('d-none');
                        empty.textContent = 'Gagal memuat gambar: ' + err.message;
                    }
                });
        }

        var pixabayForm = $('#pixabaySearchForm');
        if (pixabayForm) {
            pixabayForm.addEventListener('submit', function (e) {
                e.preventDefault();
                var input = $('#pixabayQuery');
                pixabayQuery = input && input.value.trim() ? input.value.trim() : 'wedding';
                pixabayPage = 1;
                searchPixabay(pixabayQuery, pixabayPage);
            });
        }

        // =========================================================================
        // GALERI FOTO TAMU
        // =========================================================================

        // Catatan keamanan: token berikut diekspos ke sisi klien.
        // Sebaiknya pindahkan otentikasi ke cookie sesi atau minta token sementara
        // dari endpoint internal yang memvalidasi user login.
        const GALLERY_TOKEN = '{{ config('services.guest_photos.token', 'guest-photos-secret-2026') }}';
        const galleryModalEl = $('#galleryModal');
        let galleryModalInstance = null;
        if (galleryModalEl && window.bootstrap && bootstrap.Modal) {
            galleryModalInstance = new bootstrap.Modal(galleryModalEl);
        }

        function openGalleryModal() {
            if (!galleryModalInstance) return;
            galleryModalInstance.show();
            fetchGalleryPhotos();
        }

        function fetchGalleryPhotos() {
            const loadingEl = $('#galleryLoading');
            const gridEl    = $('#galleryGrid');
            const errorEl   = $('#galleryError');
            const emptyEl   = $('#galleryEmpty');
            const totalEl   = $('#galleryTotal');

            if (loadingEl) loadingEl.classList.remove('d-none');
            if (gridEl)    gridEl.innerHTML = '';
            if (errorEl)   errorEl.classList.add('d-none');
            if (emptyEl)   emptyEl.classList.add('d-none');

            const eventId = (eventIdInput && eventIdInput.value) ? eventIdInput.value : 'default';

            fetch('/api/guest-photos/' + encodeURIComponent(eventId), {
                headers: { 'X-Secret-Token': GALLERY_TOKEN }
            })
            .then((response) => {
                if (!response.ok) throw new Error('HTTP error ' + response.status);
                return response.json();
            })
            .then((data) => {
                if (loadingEl) loadingEl.classList.add('d-none');

                if (!data || !data.success || !Array.isArray(data.data) || data.data.length === 0) {
                    if (emptyEl) emptyEl.classList.remove('d-none');
                    if (totalEl) totalEl.textContent = '0';
                    return;
                }

                const photos = data.data;
                if (totalEl) totalEl.textContent = String(photos.length);

                const frag = document.createDocumentFragment();
                photos.forEach((photo) => {
                    const url       = String(photo.image_url || '');
                    const guestName = String(photo.guest_name || 'Guest');

                    // Bangun card via createElement untuk menghindari XSS dari nama tamu
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-4 col-lg-3';

                    const item = document.createElement('div');
                    item.className = 'gallery-item';
                    item.setAttribute('role', 'button');
                    item.setAttribute('tabindex', '0');
                    item.setAttribute('aria-label', 'Sisipkan foto dari ' + guestName);
                    item.dataset.url  = url;
                    item.dataset.name = guestName;

                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = 'Foto tamu: ' + guestName;
                    img.loading = 'lazy';
                    item.appendChild(img);

                    const caption = document.createElement('div');
                    caption.className = 'gallery-caption';
                    caption.textContent = guestName; // textContent = aman dari XSS
                    item.appendChild(caption);

                    item.addEventListener('click', () => selectGalleryImage(item.dataset.url, item.dataset.name));
                    item.addEventListener('keydown', (ev) => {
                        if (ev.key === 'Enter' || ev.key === ' ') {
                            ev.preventDefault();
                            selectGalleryImage(item.dataset.url, item.dataset.name);
                        }
                    });

                    col.appendChild(item);
                    frag.appendChild(col);
                });

                if (gridEl) gridEl.appendChild(frag);
            })
            .catch((error) => {
                console.error('Error fetching gallery photos:', error);
                if (loadingEl) loadingEl.classList.add('d-none');
                if (errorEl) {
                    errorEl.classList.remove('d-none');
                    const span = errorEl.querySelector('span');
                    if (span) span.textContent = 'Gagal memuat galeri: ' + error.message;
                }
            });
        }

        // --- Sisipkan gambar galeri ke editor di posisi caret ---
        function selectGalleryImage(imageUrl, guestName) {
            if (!imageUrl) return;

            var alt  = guestName || 'Foto tamu';
            var tiny = tinymce.get('blogEditor');

            if (tiny) {
                tiny.execCommand('mceInsertContent', false,
                    '<img src="' + imageUrl + '" alt="' + alt.replace(/"/g, '&quot;') + '" />');
                syncEditor();
            } else {
                editor.focus();
                document.execCommand('insertImage', false, imageUrl);

                // Beri alt pada <img> yang baru saja disisipkan
                var imgs = editor.querySelectorAll('img:not([alt])');
                if (imgs.length > 0) {
                    imgs[imgs.length - 1].alt = alt;
                }
                syncEditor();
            }

            if (galleryModalInstance) galleryModalInstance.hide();
        }

        // Tombol refresh galeri
        const refreshBtn = $('#galleryRefreshBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', (e) => {
                e.preventDefault();
                fetchGalleryPhotos();
            });
        }

        // --- Auto generate slug dari judul (hanya jika slug masih kosong) ---
        const titleInput   = $('#postTitle');
        const permalinkInput = $('#permalinkInput');
        let slugAutoGenerated = false;

        function generateSlug(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')   // buang selain word, space, dash
                .replace(/\s+/g, '-')        // spasi -> dash
                .replace(/-+/g, '-')         // dash ganda -> tunggal
                .replace(/^-+|-+$/g, '');    // trim dash di awal/akhir
        }

        if (titleInput && permalinkInput) {
            titleInput.addEventListener('input', () => {
                // Harga otomatis jika user belum pernah mengetik manual di permalink
                if (!slugAutoGenerated && permalinkInput.value.trim() === '') {
                    permalinkInput.value = generateSlug(titleInput.value);
                }
            });

            permalinkInput.addEventListener('input', () => {
                slugAutoGenerated = true; // user sudah edit manual, jangan override
            });
        }
    });
    </script>
    @endpush

</x-app-layout>

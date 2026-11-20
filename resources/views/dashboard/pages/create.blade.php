<x-app-layout>

    @push('styles')
    <style>
        .page-editor-shell {
            min-height: calc(100vh - 56px);
        }

        .page-editor-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
        }

        .page-title-input {
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

        .page-title-input:focus {
            border-bottom-color: #C6A962;
        }

        .page-title-input::placeholder {
            color: #9ca3af;
            font-weight: 500;
        }

        .page-editor-canvas {
            min-height: 440px;
            padding: 1.5rem 1.75rem;
            background-color: #ffffff;
            color: #1f2937;
            font-size: 1rem;
            line-height: 1.75;
            outline: none;
        }

        .page-editor-canvas:empty::before,
        .page-editor-canvas p:only-child:empty::before {
            content: attr(data-placeholder);
            color: #9ca3af;
            pointer-events: none;
            display: block;
        }

        .page-editor-canvas h1 { font-size: 1.75rem; font-weight: 700; margin: 1.25rem 0 0.5rem; line-height: 1.3; }
        .page-editor-canvas h2 { font-size: 1.4rem;  font-weight: 700; margin: 1.1rem 0 0.5rem;  line-height: 1.35; }
        .page-editor-canvas h3 { font-size: 1.15rem; font-weight: 600; margin: 1rem 0 0.4rem;    line-height: 1.4; }
        .page-editor-canvas p  { margin-bottom: 0.85rem; }
        .page-editor-canvas ul,
        .page-editor-canvas ol { padding-left: 1.5rem; margin-bottom: 0.85rem; }
        .page-editor-canvas img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 0.75rem 0;
        }
        .page-editor-canvas blockquote {
            border-left: 3px solid #C6A962;
            padding-left: 1rem;
            color: #4b5563;
            font-style: italic;
            margin: 1rem 0;
        }

        .page-settings {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .page-settings details summary {
            list-style: none;
            cursor: pointer;
            user-select: none;
        }

        .page-settings details summary::-webkit-details-marker {
            display: none;
        }

        .page-settings details[open] .chevron-icon {
            transform: rotate(180deg);
        }

        .chevron-icon {
            transition: transform 0.2s ease;
        }

        @media (min-width: 992px) {
            .page-settings-sticky {
                position: sticky;
                top: 1.25rem;
            }
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

    <div class="page-editor-shell py-4">
        <form id="pageForm"
              action="{{ route('admin.pages.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="form-submit">
            @csrf

            <input type="hidden" name="content" id="pageContent" value="{{ old('content') ? e(old('content')) : '' }}">
            <input type="hidden" name="status" id="pageStatus" value="{{ old('status', 'published') }}">

            <div class="container-fluid px-3 px-lg-4">

                {{-- Top Bar --}}
                <div class="page-editor-topbar rounded-3 shadow-sm p-3 mb-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <a href="{{ route('admin.pages.index') }}"
                               class="btn btn-light btn-sm border rounded-circle d-inline-flex align-items-center justify-content-center"
                               style="width: 36px; height: 36px;" title="Kembali" aria-label="Kembali">
                                <i class="bi bi-arrow-left" aria-hidden="true"></i>
                            </a>
                            <div>
                                <h1 class="h5 fw-bold mb-0 text-dark">Tambah Halaman</h1>
                                <p class="text-muted small mb-0">Buat halaman statis seperti WordPress</p>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <button type="button" id="btnPreview" class="btn btn-outline-secondary btn-sm px-3">
                                <i class="bi bi-eye me-1" aria-hidden="true"></i> Pratinjau
                            </button>
                            <button type="button" id="btnSaveDraft" class="btn btn-light border btn-sm px-3">
                                <i class="bi bi-file-earmark me-1" aria-hidden="true"></i> Simpan Draft
                            </button>
                            <button type="submit" id="btnPublish" class="btn btn-primary btn-sm px-3 fw-medium">
                                <i class="bi bi-send me-1" aria-hidden="true"></i> Publikasikan
                            </button>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <strong class="d-block mb-1">
                            <i class="bi bi-exclamation-triangle me-1" aria-hidden="true"></i> Periksa kembali isian berikut:
                        </strong>
                        <ul class="mb-0 small ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                <div class="row g-4 align-items-start">
                    {{-- Kolom Kiri: Judul + Editor --}}
                    <div class="col-lg-8">
                        <div class="bg-white border rounded-3 shadow-sm overflow-hidden">
                            <div class="px-4 pt-2 bg-white">
                                <label for="pageTitle" class="visually-hidden">Judul Halaman</label>
                                <input type="text"
                                       id="pageTitle"
                                       name="title"
                                       value="{{ old('title') }}"
                                       class="page-title-input @error('title') is-invalid @enderror"
                                       placeholder="Judul halaman..."
                                       required>
                                @error('title')
                                    <div class="invalid-feedback d-block small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="pageEditor"
                                 class="page-editor-canvas"
                                 contenteditable="true"
                                 data-placeholder="Mulai menulis konten halaman Anda...">
                                {!! old('content') !!}
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center text-muted small mt-2 px-1">
                            <span id="wordCountText">0 kata · 0 karakter</span>
                            <span>Tip: Gunakan Heading 2/3 agar mudah dibaca</span>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Pengaturan --}}
                    <div class="col-lg-4">
                        <div class="page-settings page-settings-sticky shadow-sm">
                            <div class="px-3 py-3 border-bottom bg-light d-flex align-items-center justify-content-between">
                                <span class="fw-semibold small text-uppercase text-secondary" style="letter-spacing: 0.04em;">
                                    Pengaturan Halaman
                                </span>
                                <i class="bi bi-sliders2 text-secondary small" aria-hidden="true"></i>
                            </div>

                            {{-- Gambar Sampul --}}
                            <details class="border-bottom p-2" open>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-card-image text-secondary" aria-hidden="true"></i> Gambar Sampul
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <input type="file" name="image" id="coverInput" accept="image/*"
                                        class="form-control form-control-sm @error('image') is-invalid @enderror">
                                    <div class="form-text" style="font-size: 0.75rem;">JPG, PNG, atau WebP (maks. 2MB).</div>
                                    <div id="coverPreviewWrap" class="mt-2 d-none">
                                        <img id="coverPreviewImg" src="#" alt="Preview sampul"
                                            class="img-fluid rounded border" style="max-height: 150px; object-fit: cover;">
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </details>

                            {{-- Template --}}
                            <details class="border-bottom p-2" open>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-layout-text-window text-secondary" aria-hidden="true"></i> Template
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="template" id="tplDefault" value="default"
                                            {{ old('template', 'default') === 'default' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="tplDefault">Standar (kolom baca)</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="template" id="tplFull" value="full"
                                            {{ old('template') === 'full' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="tplFull">Lebar Penuh</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="template" id="tplMinimal" value="minimal"
                                            {{ old('template') === 'minimal' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="tplMinimal">Minimal (sempit)</label>
                                    </div>
                                </div>
                            </details>

                            {{-- Permalink --}}
                            <details class="border-bottom p-2" open>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-link text-secondary" aria-hidden="true"></i> Permalink
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <input type="text" name="slug" value="{{ old('slug') }}"
                                        placeholder="slug-otomatis-dari-judul"
                                        class="form-control form-control-sm @error('slug') is-invalid @enderror">
                                    <div class="form-text" style="font-size: 0.75rem;">Kosongkan agar dibuat otomatis. URL: <code>/pages/slug</code></div>
                                    @error('slug')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </details>

                            {{-- Kutipan --}}
                            <details class="border-bottom p-2" open>
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-card-text text-secondary" aria-hidden="true"></i> Kutipan
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <textarea name="excerpt" rows="3"
                                        class="form-control form-control-sm @error('excerpt') is-invalid @enderror"
                                        placeholder="Ringkasan singkat untuk daftar halaman & SEO...">{{ old('excerpt') }}</textarea>
                                    @error('excerpt')
                                        <div class="invalid-feedback d-block small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </details>

                            {{-- SEO --}}
                            <details class="border-bottom p-2">
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-search text-secondary" aria-hidden="true"></i> SEO
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <label class="form-label small mb-1">Meta Title</label>
                                    <input type="text" name="meta_title" value="{{ old('meta_title') }}"
                                        class="form-control form-control-sm mb-2" placeholder="Judul SEO (opsional)">
                                    <label class="form-label small mb-1">Meta Description</label>
                                    <textarea name="meta_description" rows="2"
                                        class="form-control form-control-sm" placeholder="Deskripsi SEO (opsional)">{{ old('meta_description') }}</textarea>
                                </div>
                            </details>

                            {{-- Urutan --}}
                            <details class="p-2">
                                <summary class="px-3 py-2 d-flex justify-content-between align-items-center small fw-semibold text-dark">
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="bi bi-sort-numeric-down text-secondary" aria-hidden="true"></i> Urutan
                                    </span>
                                    <i class="bi bi-chevron-down chevron-icon text-muted small" aria-hidden="true"></i>
                                </summary>
                                <div class="px-3 pb-3 pt-1">
                                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                        class="form-control form-control-sm">
                                    <div class="form-text" style="font-size: 0.75rem;">Semakin kecil, semakin atas.</div>
                                </div>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Modal Pixabay --}}
    <div class="modal fade" id="pixabayModal" tabindex="-1" aria-labelledby="pixabayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom bg-light">
                    <h5 class="modal-title fw-semibold" id="pixabayModalLabel">
                        <i class="bi bi-image text-primary me-2" aria-hidden="true"></i> Cari Gambar Pixabay
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="pixabaySearchForm" class="d-flex gap-2 mb-3">
                        <input type="text" id="pixabayQuery" class="form-control"
                            placeholder="Contoh: wedding decoration, bridal bouquet" value="wedding" aria-label="Kata kunci">
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
                        <i class="bi bi-info-circle me-1" aria-hidden="true"></i> Klik gambar untuk menyisipkan
                    </span>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pratinjau --}}
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="previewModalLabel">Pratinjau Halaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <h2 id="previewTitle" class="fw-bold mb-3"></h2>
                    <div id="previewContent" class="page-editor-canvas p-0" style="min-height: auto;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        'use strict';

        const $ = (sel) => document.querySelector(sel);
        const $$ = (sel) => Array.from(document.querySelectorAll(sel));

        const editor = $('#pageEditor');
        const hiddenContent = $('#pageContent');
        const hiddenStatus = $('#pageStatus');
        const pageForm = $('#pageForm');
        const wordCountText = $('#wordCountText');

        if (!editor || !pageForm) return;

        if (window.tinymce && typeof tinymce.init === 'function') {
            tinymce.init({
                selector: '#pageEditor',
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
                    'undo redo | bold italic underline | alignleft aligncenter alignright | link image pixabay',
                    'blocks fontsize | forecolor backcolor removeformat | bullist numlist outdent indent | blockquote',
                    'table media codesample charmap emoticons insertdatetime | searchreplace visualblocks visualchars | preview fullscreen code help'
                ].join(' & '),
                fontsize_formats: '10pt 11pt 12pt 13pt 14pt 16pt 18pt 20pt 24pt 32pt',
                content_style: 'body { font-family: "Plus Jakarta Sans",Arial,sans-serif; font-size: 15px; line-height: 1.75; }',
                setup: function (ed) {
                    ed.on('change keyup undo redo SetContent', function () {
                        syncEditor();
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

        function getEditorHtml() {
            const tiny = tinymce.get('pageEditor');
            return tiny ? tiny.getContent() : editor.innerHTML;
        }

        function getEditorText() {
            const tiny = tinymce.get('pageEditor');
            if (!tiny) return (editor.innerText || '').trim();
            const tmp = document.createElement('div');
            tmp.innerHTML = tiny.getContent();
            return (tmp.textContent || '').trim();
        }

        function syncEditor() {
            const rawHtml = getEditorHtml().trim();
            const isEmpty = rawHtml === '' || rawHtml === '<br>' || rawHtml === '<p><br></p>';
            hiddenContent.value = isEmpty ? '' : rawHtml;
            updateWordCount();
        }

        function updateWordCount() {
            const text = getEditorText();
            const words = text ? text.split(/\s+/).length : 0;
            wordCountText.textContent = words + ' kata · ' + text.length + ' karakter';
        }

        if (!tinymce.get('pageEditor')) {
            editor.addEventListener('input', syncEditor);
            editor.addEventListener('blur', syncEditor);
            if (!editor.innerHTML.trim()) {
                editor.innerHTML = '<p><br></p>';
            }
        }
        updateWordCount();

        // Cover preview
        const coverInput = $('#coverInput');
        let currentObjectUrl = null;

        if (coverInput) {
            coverInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                const wrap = $('#coverPreviewWrap');
                const img = $('#coverPreviewImg');

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

        // Buttons
        $('#btnSaveDraft').addEventListener('click', () => {
            hiddenStatus.value = 'draft';
            syncEditor();
            pageForm.requestSubmit();
        });

        $('#btnPublish').addEventListener('click', () => {
            hiddenStatus.value = 'published';
            syncEditor();
        });

        pageForm.addEventListener('submit', () => {
            syncEditor();
        });

        $('#btnPreview').addEventListener('click', () => {
            syncEditor();
            $('#previewTitle').textContent = ($('#pageTitle').value || '').trim() || '(Tanpa Judul)';
            $('#previewContent').innerHTML = hiddenContent.value || '<p class="text-muted">Belum ada konten.</p>';
            if (window.bootstrap && bootstrap.Modal) {
                new bootstrap.Modal($('#previewModal')).show();
            }
        });

        // Pixabay
        const PIXABAY_SEARCH_URL = '{{ route('pixabay.search') }}';
        const pixabayModalEl = $('#pixabayModal');
        let pixabayModalInstance = null;

        if (pixabayModalEl && window.bootstrap && bootstrap.Modal) {
            pixabayModalInstance = new bootstrap.Modal(pixabayModalEl);
        }

        function openPixabayModal() {
            if (!pixabayModalInstance) return;
            const grid = $('#pixabayGrid');
            if (grid) grid.innerHTML = '';
            const empty = $('#pixabayEmpty');
            if (empty) empty.classList.add('d-none');
            pixabayModalInstance.show();
        }

        function insertPixabayImage(url, alt) {
            const ed = tinymce.get('pageEditor');
            const safeAlt = String(alt || 'Foto').replace(/"/g, '&quot;');
            if (ed) {
                ed.execCommand('mceInsertContent', false, '<img src="' + url + '" alt="' + safeAlt + '" />');
                syncEditor();
            } else {
                document.execCommand('insertImage', false, url);
                syncEditor();
            }
            if (pixabayModalInstance) pixabayModalInstance.hide();
        }

        function renderPixabayHits(hits) {
            const grid = $('#pixabayGrid');
            const empty = $('#pixabayEmpty');
            if (!grid) return;
            grid.innerHTML = '';

            if (!hits || hits.length === 0) {
                if (empty) empty.classList.remove('d-none');
                return;
            }
            if (empty) empty.classList.add('d-none');

            const frag = document.createDocumentFragment();
            hits.forEach(function (hit) {
                const url = hit.largeImageURL || hit.webformatURL || hit.previewURL;
                if (!url) return;

                const col = document.createElement('div');
                col.className = 'col-6 col-md-4 col-lg-3';

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'pixabay-thumb w-100 border-0 p-0 bg-transparent';
                btn.title = hit.tags || 'Pilih gambar';
                btn.setAttribute('aria-label', 'Sisipkan gambar: ' + (hit.tags || 'Pixabay'));

                const img = document.createElement('img');
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

        $('#pixabaySearchForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const query = $('#pixabayQuery').value || 'wedding';
            const grid = $('#pixabayGrid');
            const empty = $('#pixabayEmpty');

            if (grid) grid.innerHTML = '<div class="col-12 text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';
            if (empty) empty.classList.add('d-none');

            fetch(PIXABAY_SEARCH_URL + '?q=' + encodeURIComponent(query) + '&page=1', {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (res) {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(function (data) {
                    if (data && data.error) throw new Error(data.error);
                    renderPixabayHits(data.hits || []);
                })
                .catch(function (err) {
                    if (grid) grid.innerHTML = '';
                    if (empty) {
                        empty.classList.remove('d-none');
                        empty.textContent = 'Gagal memuat gambar: ' + err.message;
                    }
                });
        });
    });
    </script>
    @endpush
</x-app-layout>
@extends('layouts.app')
@section('sidebar_class', 'adminuiux-sidebar-close')

@section('content')
    <style>
        .adminuiux-sidebar-close .adminuiux-sidebar-inner {
            display: none !important;
        }

        .adminuiux-sidebar-close .adminuiux-sidebar {
            width: 0 !important;
            border: none !important;
        }

        @media (min-width: 992px) {
            .adminuiux-sidebar-close .adminuiux-content.has-sidebar {
                padding-left: 0 !important;
                margin-left: 0 !important;
            }
        }

        .builder-wrapper {
            display: flex;
            height: calc(100vh - 100px);
            background: transparent;
            overflow: hidden;
            border-radius: 1.5rem;
            margin-top: 1rem;
            border: 1px solid var(--bs-border-color);
        }

        @media (max-width: 991px) {
            .adminuiux-content {
                padding: 0 !important;
            }

            .builder-wrapper {
                flex-direction: column;
                height: 100vh !important;
                width: 100vw !important;
                margin: 0 !important;
                border-radius: 0 !important;
                border: none !important;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 9999;
                background: var(--bs-body-bg);
            }

            .builder-sidebar {
                width: 100% !important;
                height: 100% !important;
                flex-direction: column-reverse !important;
                border-right: none !important;
            }

            .sidebar-nav-vertical {
                width: 100% !important;
                height: auto !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                border-right: none !important;
                border-top: 1px solid var(--bs-border-color);
                padding: 0.4rem !important;
                justify-content: space-around !important;
                gap: 0.25rem !important;
                background: var(--bs-card-bg);
                z-index: 1000;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .sidebar-nav-vertical::-webkit-scrollbar {
                display: none;
            }

            .nav-vertical-link {
                width: 40px !important;
                height: 40px !important;
                flex-shrink: 0 !important;
                border-radius: 0.6rem !important;
                border: none !important;
            }

            .nav-vertical-link span {
                display: none !important;
            }

            .nav-vertical-link i {
                font-size: 1.15rem !important;
            }

            .builder-canvas {
                display: none !important;
            }

            .sidebar-header {
                padding: 0.75rem 1rem !important;
                background: var(--bs-card-bg) !important;
                border-bottom: 1px solid var(--bs-border-color);
                flex-wrap: nowrap !important;
                justify-content: space-between !important;
            }

            .sidebar-content {
                padding: 1.25rem 1rem !important;
                background: rgba(var(--bs-tertiary-bg-rgb), 0.3);
            }

            /* Form field refinements for mobile */
            .form-control, .form-select {
                padding: 0.6rem 0.75rem !important;
                border-radius: 0.75rem !important;
            }
            
            label {
                margin-bottom: 0.4rem !important;
                font-size: 13px !important;
            }
        }

        .builder-sidebar {
            width: 480px;
            display: flex;
            background: var(--bs-card-bg);
            color: var(--bs-body-color);
            overflow: hidden;
            border-right: 1px solid var(--bs-border-color);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
        }

        /* Hide scrollbars but keep functionality */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .sidebar-nav-vertical {
            width: 70px;
            flex-shrink: 0;
            background: var(--bs-card-bg);
            border-right: 1px solid var(--bs-border-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem 0;
            gap: 0.75rem;
        }

        .nav-vertical-link {
            width: 44px;
            height: 44px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            color: var(--bs-secondary-color);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1.25rem;
            position: relative;
        }

        .nav-vertical-link span {
            font-size: 0.65rem;
            font-weight: 600;
            margin-top: 2px;
            display: none;
        }

        .nav-vertical-link:hover {
            background: var(--bs-secondary-bg);
            color: #0d9488;
        }

        .nav-vertical-link.active {
            background: #0d9488;
            color: #fff;
            box-shadow: 0 0 15px rgba(13, 148, 136, 0.4);
        }

        .music-list-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--bs-border-color);
            background: var(--bs-card-bg);
            margin-bottom: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            gap: 1rem;
        }

        .music-list-item:hover {
            border-color: #0d9488;
            background: rgba(13, 148, 136, 0.05);
        }

        .music-list-item.selected {
            border-color: #0d9488;
            background: rgba(13, 148, 136, 0.1);
        }

        .music-icon-box {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 0.5rem;
            color: #0d9488;
        }

        .music-list-item.selected .music-icon-box {
            background: #0d9488;
            color: #fff;
        }

        .music-title-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.2;
        }

        .music-play-btn {
            margin-left: auto;
            color: var(--bs-secondary-color);
            transition: 0.2s;
            flex-shrink: 0;
        }

        .music-play-btn:hover {
            color: #0d9488;
            transform: scale(1.1);
        }

        .sidebar-content-pane {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: transparent;
        }

        .sidebar-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--bs-border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bs-card-bg);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            scrollbar-width: thin;
        }

        .builder-canvas {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            background: rgba(var(--bs-tertiary-bg-rgb), 0.1);
            backdrop-filter: blur(10px);
        }

        .device-switcher {
            position: absolute;
            top: 2rem;
            background: white;
            padding: 0.4rem;
            border-radius: 4rem;
            display: flex;
            gap: 0.4rem;
            box-shadow: var(--bs-box-shadow);
            z-index: 100;
            border: 1px solid var(--bs-border-color);
        }


        .device-btn {
            padding: 0.6rem 1.5rem;
            border-radius: 3rem;
            border: none;
            background: transparent;
            color: var(--bs-secondary-color);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .device-btn.active {
            background: #0d9488;
            color: #fff;
        }

        .preview-window {
            background: #fff;
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.25);
        }

        .preview-window.mode-mobile {
            width: 375px;
            height: 750px;
            border-radius: 3.5rem;
            border: 12px solid #1e293b;
            outline: 1px solid #475569;
        }

        .preview-window.mode-tablet {
            width: 768px;
            height: 1024px;
            border-radius: 2rem;
            border: 18px solid #1e293b;
        }

        .preview-window.mode-desktop {
            width: 92%;
            height: 85%;
            border-radius: 1rem;
            border: 8px solid #1e293b;
            border-bottom-width: 40px;
        }

        .preview-iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        #previewLoader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 50;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(var(--bs-body-bg-rgb), 0.8);
            backdrop-filter: blur(4px);
        }

        .template-card-selector {
            position: relative;
            border: 2px solid transparent;
            transition: 0.3s;
            cursor: pointer;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .template-card-selector.selected {
            border-color: #0d9488;
        }

        .template-card-selector .check-icon {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #0d9488;
            color: #fff;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            z-index: 10;
        }

        .template-card-selector.selected .check-icon {
            display: flex;
        }

        .template-thumbnail {
            height: 140px;
            width: 100%;
            object-fit: cover;
        }

        #livePreviewIframe {
            overflow: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #livePreviewIframe::-webkit-scrollbar {
            display: none;
        }

        .grayscale {
            filter: grayscale(1);
        }

        .locked::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .premium-badge {
            background: linear-gradient(45deg, #f59e0b, #fbbf24);
            color: #000;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px !important;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .basic-badge {
            background: #10b981;
            color: #fff;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px !important;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>

    <div class="builder-wrapper">
        <div class="builder-sidebar shadow-sm">
            <div class="sidebar-nav-vertical no-scrollbar">
                <div class="nav-vertical-link active" data-tab="tab-2" title="Tema"><i class="bi bi-palette"></i><span>Tema</span></div>
                <div class="nav-vertical-link" data-tab="tab-1" title="Pria"><i class="bi bi-person"></i><span>Pria</span></div>
                <div class="nav-vertical-link" data-tab="tab-7" title="Wanita"><i class="bi bi-person-heart"></i><span>Wanita</span></div>
                <div class="nav-vertical-link" data-tab="tab-6" title="Acara"><i class="bi bi-calendar-event"></i><span>Acara</span></div>
                <div class="nav-vertical-link" data-tab="tab-3" title="Galeri">
                    <i class="bi bi-images"></i>
                    @if(!auth()->user()->isSubscribed())
                        <i class="bi bi-crown-fill position-absolute top-0 end-0 text-warning" style="font-size: 10px; margin-top: 5px; margin-right: 5px;"></i>
                    @endif
                    <span>Galeri</span>
                </div>
                <div class="nav-vertical-link" data-tab="tab-4" title="Musik"><i class="bi bi-music-note-beamed"></i><span>Musik</span></div>
                <div class="nav-vertical-link" data-tab="tab-8" title="Kisah"><i class="bi bi-journal-text"></i><span>Kisah</span></div>
                <div class="nav-vertical-link" data-tab="tab-5" title="RSVP">
                    <i class="bi bi-envelope-check"></i>
                    @if(!auth()->user()->isSubscribed())
                        <i class="bi bi-crown-fill position-absolute top-0 end-0 text-warning" style="font-size: 10px; margin-top: 5px; margin-right: 5px;"></i>
                    @endif
                    <span>RSVP</span>
                </div>
                <div class="nav-vertical-link" data-tab="tab-9" title="Hadiah">
                    <i class="bi bi-gift"></i>
                    @if(!auth()->user()->isSubscribed())
                        <i class="bi bi-crown-fill position-absolute top-0 end-0 text-warning" style="font-size: 10px; margin-top: 5px; margin-right: 5px;"></i>
                    @endif
                    <span>Hadiah</span>
                </div>
            </div>

            <div class="sidebar-content-pane">
                <div class="sidebar-header flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('dashboard.user') }}" class="btn btn-xs btn-outline-secondary border-0 px-2"
                            title="Kembali ke List"><i class="bi bi-arrow-left fs-5"></i></a>
                        <div>
                            <h6 class="mb-0 fw-bold line-height-1" style="font-size: 14px;">Buat Undangan</h6>
                            <span id="autoSaveBadge" class="x-small text-muted" style="font-size: 10px;"><i
                                    class="bi bi-cloud-check me-1"></i>Tersimpan</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-teal btn-sm px-3 text-white rounded-pill"
                        onclick="document.getElementById('myForm').submit()" style="background-color: #0d9488;"><i
                            class="bi bi-send-fill me-1"></i> Publikasikan</button>
                </div>

                <div class="sidebar-content no-scrollbar">
                    <form id="myForm" method="POST" action="{{ route('invitation.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="0">
                        @include('dashboard.invitation.form_tabs')
                        <input type="hidden" name="template_id" id="template_id_hidden">
                    </form>
                </div>
            </div>
        </div>

        <div class="builder-canvas p-3">
            <div class="device-switcher">
                <button class="device-btn active" onclick="setDeviceMode('mobile')">Mobile</button>
                <button class="device-btn" onclick="setDeviceMode('tablet')">Tablet</button>
                <button class="device-btn" onclick="setDeviceMode('desktop')">Desktop</button>
            </div>
            <div id="previewWindow" class="preview-window mode-mobile">
                <iframe id="livePreviewIframe" name="livePreviewIframe" class="preview-iframe" src="about:blank"></iframe>
                <div id="previewLoader" class="d-none">
                    <div class="spinner-border text-teal mb-3" role="status" style="color: #0d9488;"></div>
                    <p class="small fw-bold">Updating...</p>
                </div>
            </div>
            <form id="previewForm" action="{{ route('invitation.live-preview') }}" method="POST" target="livePreviewIframe"
                style="display:none">
                @csrf
                <div id="previewFormInputs"></div>
            </form>
        </div>
    </div>

    <!-- CROP MODAL -->
    <div class="modal fade" id="cropModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Sesuaikan Foto</h5><button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0 bg-dark mt-3" style="height:60vh; overflow:hidden;"><img id="cropImage"
                        style="max-width:100%; display:block;"></div>
                <div class="modal-footer border-0"><button type="button" class="btn btn-teal px-5 text-white"
                        onclick="cropImage()" style="background-color: #0d9488;">Simpan</button></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let cropper; let currentTarget = null; let previewTimer; let saveTimer; let galleryFiles = [];
        let currentPage = 1; const itemsPerPage = 6;

        function toggleGlobalSidebar() { document.body.classList.toggle('adminuiux-sidebar-close'); }

        // --- Tab Switching Logic ---
        function initTabs() {
            const links = document.querySelectorAll('.nav-vertical-link');
            const contents = document.querySelectorAll('.tab-content');
            
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active from all links
                    links.forEach(l => l.classList.remove('active'));
                    // Hide all contents
                    contents.forEach(c => {
                        c.classList.add('d-none');
                        c.classList.remove('active');
                    });
                    
                    // Add active to clicked link
                    this.classList.add('active');
                    
                    // Show target content
                    const targetId = this.getAttribute('data-tab');
                    const target = document.getElementById(targetId);
                    
                    if (target) {
                        target.classList.remove('d-none');
                        // Use a tiny timeout to ensure display:block is applied before adding active if needed
                        setTimeout(() => {
                            target.classList.add('active');
                        }, 10);
                    }
                });
            });
        }

        function setDeviceMode(mode) {
            document.getElementById('previewWindow').className = 'preview-window mode-' + mode;
            document.querySelectorAll('.device-btn').forEach(btn => btn.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }

        window.toggleSettings = (id, isChecked) => {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = isChecked ? 'block' : 'none';
                el.classList.toggle('d-none', !isChecked);
            }
            updateLivePreview();
        };

        // --- Template Logic ---
        function renderTemplates() {
            const query = document.getElementById('searchTemplate').value.toLowerCase();
            const cat = document.getElementById('categorySelect').value;
            const items = Array.from(document.querySelectorAll('.template-selector-item'));
            const filtered = items.filter(item => {
                const matchesQuery = item.dataset.name.includes(query);
                const matchesCat = (cat === 'all' || item.dataset.category === cat);
                return matchesQuery && matchesCat;
            });
            items.forEach(item => item.classList.add('d-none'));
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            filtered.slice(start, end).forEach(item => item.classList.remove('d-none'));
            document.getElementById('pageInfo').textContent = `Halaman ${currentPage}`;
            document.getElementById('prevPage').disabled = (currentPage === 1);
            document.getElementById('nextPage').disabled = (end >= filtered.length);
        }
        function selectTemplate(el, id) {
            document.querySelectorAll('.template-card-selector').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('template_id_hidden').value = id;
            
            // Update Primary Color based on Template Default
            const templateItem = el.closest('.template-selector-item');
            if (templateItem && templateItem.dataset.color) {
                const colorInput = document.getElementById('primary_color');
                if (colorInput) {
                    colorInput.value = templateItem.dataset.color;
                }
            }
            
            updateLivePreview();
        }

        window.showPremiumAlert = function() {
            Swal.fire({
                title: 'Tema Premium! 💎',
                text: 'Tema ini hanya tersedia untuk pengguna Premium. Upgrade paket Anda sekarang untuk membuka semua tema eksklusif!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Upgrade Sekarang',
                cancelButtonText: 'Mungkin Nanti'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('subscribe.page') }}";
                }
            });
        }

        // --- Quotes Logic ---
        window.showQuote = function () {
            const quotes = {
                rum21: "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum yang berpikir.",
                nisa1: "Wahai manusia! Bertakwalah kepada Tuhanmu yang telah menciptakan kamu dari diri yang satu (Adam), dan (Allah) menciptakan pasangannya (Hawa) dari (diri)-nya; dan dari keduanya Allah memperkembangbiakkan laki-laki dan perempuan yang banyak.",
                furqan74: "Dan orang-orang yang berkata, \"Ya Tuhan kami, anugerahkanlah kepada kami pasangan kami dan keturunan kami sebagai penyenang hati (kami), dan jadikanlah kami pemimpin bagi orang-orang yang bertakwa.\""
            };
            const select = document.querySelector('select[name="quote_id"]');
            if (select && quotes[select.value]) {
                document.getElementById('wedding_quote').value = quotes[select.value];
                updateLivePreview();
            }
        };

        function updateLivePreview() {
            const templateId = document.getElementById('template_id_hidden').value;
            if (!templateId) return;

            clearTimeout(previewTimer);
            const loader = document.getElementById('previewLoader');
            if (loader) loader.classList.remove('d-none');

            previewTimer = setTimeout(() => {
                const container = document.getElementById('previewFormInputs');
                if (!container) return;
                container.innerHTML = '';

                const formData = new FormData(document.getElementById('myForm'));
                formData.forEach((v, k) => {
                    // Pass everything except files
                    if (!(v instanceof File)) {
                        const i = document.createElement('input');
                        i.type = 'hidden';
                        i.name = k;
                        i.value = v;
                        container.appendChild(i);
                    }
                });

                // Collect gallery images from the preview container
                const galleryImgs = [];
                document.querySelectorAll('#gallery-preview img').forEach(img => {
                    galleryImgs.push(img.src);
                });

                // Add special preview fields for images
                const imgMap = {
                    'preview_foto_pria': document.getElementById('previewGroom')?.src,
                    'preview_foto_wanita': document.getElementById('previewBride')?.src,
                    'preview_gallery_cover': document.getElementById('previewCover')?.src,
                    'preview_gallery': galleryImgs
                };

                for (const [name, val] of Object.entries(imgMap)) {
                    if (val && (Array.isArray(val) || !val.includes('storage/'))) {
                        if (Array.isArray(val)) {
                            val.forEach(v => {
                                const i = document.createElement('input');
                                i.type = 'hidden'; i.name = name + '[]'; i.value = v;
                                container.appendChild(i);
                            });
                        } else {
                            const i = document.createElement('input');
                            i.type = 'hidden'; i.name = name; i.value = val;
                            container.appendChild(i);
                        }
                    }
                }

                const pForm = document.getElementById('previewForm');
                if (pForm) pForm.submit();

                // Sync images to iframe after a short delay to allow load
                setTimeout(() => {
                    const iframe = document.getElementById('livePreviewIframe');
                    if (iframe && iframe.contentWindow) {
                        const images = {
                            pria: document.getElementById('previewGroom')?.src,
                            wanita: document.getElementById('previewBride')?.src,
                            cover: document.getElementById('previewCover')?.src,
                            gallery: galleryImgs
                        };
                        iframe.contentWindow.postMessage({ type: 'syncImages', images }, '*');
                    }
                    if (loader) loader.classList.add('d-none');
                }, 600); // Faster sync feedback

                // Also trigger DB Auto-Save
                dbAutoSave();
            }, 300); // Ultra-fast sync (300ms)
        }

        function dbAutoSave() {
            clearTimeout(saveTimer);
            saveTimer = setTimeout(() => {
                const formData = new FormData(document.getElementById('myForm'));
                // Remove files and _method for auto-save to keep it fast and prevent route conflict
                const cleanData = new URLSearchParams();
                formData.forEach((v, k) => {
                    if (!(v instanceof File) && k !== '_method') cleanData.append(k, v);
                });

                const badge = document.getElementById('autoSaveBadge');
                if (badge) badge.innerHTML = '<i class="bi bi-cloud-arrow-up me-1 text-primary"></i>Menyimpan...';

                fetch("{{ route('invitation.autosave') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: cleanData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (badge) badge.innerHTML = '<i class="bi bi-cloud-check me-1 text-success"></i>Tersimpan ✨';
                            // Update the ID so subsequent auto-saves update the same record
                            const idInput = document.querySelector('input[name="id"]');
                            if (idInput && idInput.value == "0") {
                                idInput.value = data.id;
                            }
                            console.log('Draft otomatis disimpan ✨');
                        }
                    })
                    .catch(err => {
                        if (badge) badge.innerHTML = '<i class="bi bi-cloud-slash me-1 text-danger"></i>Gagal simpan';
                        console.error('Auto-save failed:', err);
                    });
            }, 800); // Save to DB every 800ms of inactivity
        }

        window.previewAudio = (url) => {
            const player = document.getElementById('audioPlayer');
            if (player) {
                player.src = url;
                player.play();
            }
        };

        window.selectMusic = (el, id, url) => {
            document.querySelectorAll('.music-list-item').forEach(item => item.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('music_id').value = id;
            previewAudio(url);
            updateLivePreview();
        };

        window.handleMusicClick = (el) => {
            const id = el.getAttribute('data-id');
            const url = el.getAttribute('data-url');
            selectMusic(el, id, url);
        };

        document.addEventListener('DOMContentLoaded', () => {
            initTabs();
            document.getElementById('categorySelect').onchange = () => { currentPage = 1; renderTemplates(); };
            document.getElementById('searchTemplate').oninput = () => { currentPage = 1; renderTemplates(); };
            document.getElementById('prevPage').onclick = () => { if (currentPage > 1) { currentPage--; renderTemplates(); } };
            document.getElementById('nextPage').onclick = () => { currentPage++; renderTemplates(); };
            renderTemplates();

            // Use event delegation for all inputs in #myForm
            document.getElementById('myForm').addEventListener('input', (e) => {
                if (e.target.matches('input, textarea, select')) {
                    updateLivePreview();
                }
            });
            document.getElementById('myForm').addEventListener('change', (e) => {
                if (e.target.matches('input, textarea, select')) {
                    updateLivePreview();
                }
            });

            document.getElementById('addGift').onclick = addGift;

            // Music Auto-Play Logic
            const musicSelect = document.getElementById('music_id');
            const audioPlayer = document.getElementById('audioPlayer');
            if (musicSelect && audioPlayer) {
                musicSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const audioUrl = selectedOption.dataset.audio;
                    if (audioUrl) {
                        audioPlayer.src = audioUrl;
                        audioPlayer.play().catch(e => console.log('Auto-play blocked by browser. User interaction required.'));
                    } else {
                        audioPlayer.src = '';
                    }
                });
            }

            const customMusicInput = document.querySelector('input[name="custom_music"]');
            if (customMusicInput && audioPlayer) {
                customMusicInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const url = URL.createObjectURL(file);
                        audioPlayer.src = url;
                        audioPlayer.play().catch(e => console.log('Auto-play blocked.'));
                    }
                });
            }

            document.querySelector('[data-tab="2"]').click();
        });

        // --- Media Handlers ---
        window.removePreview = (type) => {
            const capitalized = type.charAt(0).toUpperCase() + type.slice(1);
            const previewImg = document.getElementById('preview' + capitalized);
            if (previewImg) previewImg.src = '';
            const container = document.getElementById('previewContainer' + capitalized);
            if (container) container.classList.add('d-none');
            const uploadBox = document.getElementById('uploadBox' + capitalized + 'Container');
            if (uploadBox) uploadBox.classList.remove('d-none');

            const inputMap = { 'groom': 'foto_pria', 'bride': 'foto_wanita', 'cover': 'gallery_cover' };
            const inputId = inputMap[type] || ('gallery_' + type);
            const input = document.getElementById(inputId);
            if (input) input.value = '';
            updateLivePreview();
        };

        const galleryInput = document.getElementById('gallery-input');
        const galleryDropzone = document.getElementById('gallery-dropzone');
        if (galleryDropzone && galleryInput) {
            galleryDropzone.addEventListener('click', () => galleryInput.click());
            galleryInput.addEventListener('change', function (e) {
                Array.from(e.target.files).forEach(file => {
                    const id = Math.random().toString(36).substr(2, 9);
                    galleryFiles.push({ id, file });
                    const reader = new FileReader();
                    reader.onload = (re) => {
                        const div = document.createElement('div'); div.className = 'position-relative border rounded overflow-hidden gallery-item-preview shadow-sm';
                        div.id = 'gal-' + id; div.style.width = '70px'; div.style.height = '70px';
                        div.innerHTML = `<img src="${re.target.result}" class="w-100 h-100 object-fit-cover"><button type="button" class="btn btn-danger btn-xs position-absolute top-0 end-0 p-0 m-1 shadow-sm" style="width:18px;height:18px;" onclick="removeGalleryItem('${id}')">×</button>`;
                        document.getElementById('gallery-preview').appendChild(div);
                    };
                    reader.readAsDataURL(file);
                });
                const dt = new DataTransfer(); galleryFiles.forEach(item => dt.items.add(item.file)); galleryInput.files = dt.files;
                updateLivePreview();
            });
        }
        window.removeGalleryItem = (id) => {
            galleryFiles = galleryFiles.filter(item => item.id !== id);
            const el = document.getElementById('gal-' + id); if (el) el.remove();
            const dt = new DataTransfer(); galleryFiles.forEach(item => dt.items.add(item.file)); galleryInput.files = dt.files;
            updateLivePreview();
        };
        window.addLoveStory = () => {
            const div = document.createElement('div'); div.className = 'love-story-item border rounded p-2 mb-2 bg-light';
            div.innerHTML = `<input type="text" name="story_title[]" class="form-control form-control-sm mb-1" placeholder="Judul"><textarea name="love_story[]" rows="2" class="form-control form-control-sm x-small mb-1"></textarea><button type="button" class="btn btn-link text-danger btn-xs p-0" onclick="this.closest('.love-story-item').remove(); updateLivePreview();">Hapus</button>`;
            document.getElementById('loveStoryWrapper').appendChild(div); updateLivePreview();
        };
        window.addGift = () => {
            const div = document.createElement('div'); div.className = 'gift-item border rounded p-3 mb-2 bg-light position-relative shadow-sm';
            div.innerHTML = `
                                                                                                            <button type="button" class="btn-close x-small position-absolute top-0 end-0 m-2" onclick="this.closest('.gift-item').remove(); updateLivePreview();"></button>
                                                                                                            <div class="row g-2">
                                                                                                                <div class="col-12">
                                                                                                                    <label class="x-small fw-bold text-muted mb-1">Bank / E-Wallet</label>
                                                                                                                    <select name="bank[]" class="form-select form-select-sm">
                                                                                                                        <option value="BCA">BCA</option>
                                                                                                                        <option value="BNI">BNI</option>
                                                                                                                        <option value="BRI">BRI</option>
                                                                                                                        <option value="Mandiri">Mandiri</option>
                                                                                                                        <option value="Dana">DANA</option>
                                                                                                                        <option value="OVO">OVO</option>
                                                                                                                        <option value="Gopay">Gopay</option>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                                <div class="col-12">
                                                                                                                    <label class="x-small fw-bold text-muted mb-1">No. Rekening / HP</label>
                                                                                                                    <input type="text" name="number[]" placeholder="Contoh: 12345678" class="form-control form-control-sm">
                                                                                                                </div>
                                                                                                                <div class="col-12">
                                                                                                                    <label class="x-small fw-bold text-muted mb-1">Atas Nama</label>
                                                                                                                    <input type="text" name="name[]" placeholder="Nama pemilik rekening" class="form-control form-control-sm">
                                                                                                                </div>
                                                                                                            </div>`;
            document.getElementById('giftContainer').appendChild(div); updateLivePreview();
        };
        window.openCropModal = (event, target) => {
            const file = event.target.files[0]; if (!file) return;
            currentTarget = target; const image = document.getElementById('cropImage'); image.src = URL.createObjectURL(file);
            const modal = new bootstrap.Modal(document.getElementById('cropModal')); modal.show();
            document.getElementById('cropModal').addEventListener('shown.bs.modal', () => {
                if (cropper) cropper.destroy();
                const aspect = (currentTarget === 'cover') ? 16 / 9 : 1;
                cropper = new Cropper(image, { aspectRatio: aspect, viewMode: 1, dragMode: 'move', autoCropArea: 1 });
            }, { once: true });
        };
        window.cropImage = () => {
            if (!cropper) return;
            cropper.getCroppedCanvas({ width: currentTarget === 'cover' ? 1200 : 800 }).toBlob(blob => {
                const file = new File([blob], "photo.jpg", { type: "image/jpeg" });
                const dt = new DataTransfer(); dt.items.add(file);
                const capitalized = currentTarget.charAt(0).toUpperCase() + currentTarget.slice(1);
                const inputMap = { 'groom': 'foto_pria', 'bride': 'foto_wanita', 'cover': 'gallery_cover' };
                const inputId = inputMap[currentTarget];
                document.getElementById(inputId).files = dt.files;
                document.getElementById('preview' + capitalized).src = URL.createObjectURL(file);
                document.getElementById('previewContainer' + capitalized).classList.remove('d-none');
                document.getElementById('uploadBox' + capitalized + 'Container').classList.add('d-none');
                bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide(); updateLivePreview();
            }, 'image/jpeg');
        };
    </script>
@endpush
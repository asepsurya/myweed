<x-app-layout>
    <style>
        /* =============================================
           LAYOUT & BUILDER WRAPPER
        ============================================= */
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
            flex-direction: row;
            height: calc(100vh - 100px);
            background: transparent;
            overflow: hidden;
            border-radius: 1.5rem;
            margin-top: 1rem;
            border: 1px solid var(--bs-border-color);
        }

        /* =============================================
           SIDEBAR (KIRI) & NAVIGATION
        ============================================= */
        .builder-sidebar {
            width: 480px;
            display: flex;
            flex: 0 0 auto;
            background: var(--bs-card-bg);
            color: var(--bs-body-color);
            overflow: hidden;
            border-right: 1px solid var(--bs-border-color);
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
        }

        .sidebar-content-pane {
            padding: 10px;
            background-color: var(--bs-tertiary-bg);
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        [data-theme=dark] .sidebar-content-pane {
            background-color: var(--bs-dark);
        }

        .sidebar-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--bs-border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bs-card-bg);
        }

        .sidebar-nav-vertical {
            width: 70px;
            flex-shrink: 0;
            background: var(--bs-tertiary-bg);
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
            color: var(--adminuiux-theme-1);
        }

        .nav-vertical-link.active {
            background: var(--adminuiux-theme-1);
            color: #fff;
            box-shadow: 0 0 15px rgba(198, 169, 98, 0.4);
        }

        .premium-lock-icon {
            position: absolute;
            top: 2px;
            right: 2px;
            font-size: 10px;
            color: #f59e0b;
        }

        .btn-builder-next {
            background-color: var(--adminuiux-theme-1);
            border-color: var(--adminuiux-theme-1);
            color: #fff;
        }

        /* =============================================
           CANVAS & PREVIEW (KANAN)
        ============================================= */
        .builder-canvas {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            background-color: var(--bs-tertiary-bg);
            background-image: radial-gradient(var(--bs-border-color) 1px, transparent 1px);
            background-size: 24px 24px;
            backdrop-filter: blur(10px);
            overflow: hidden;
            padding: 1.5rem;
        }

        .preview-device {
            display: inline-block;
            transform-origin: center center;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .preview-window {
            background: var(--bs-body-bg);
            overflow: hidden;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            width: 375px;
            height: 750px;
            border-radius: 3rem;
            border: 10px solid var(--bs-emphasis-color);
            outline: 1px solid var(--bs-border-color);
        }

        .preview-notch {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 95px;
            height: 22px;
            background: var(--bs-emphasis-color);
            border-radius: 1rem;
            z-index: 30;
        }

        .preview-iframe {
            width: 100%;
            height: 100%;
            border: none;
            background-color: var(--bs-body-bg);
            border-radius: 2rem;
        }

        #previewLoader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 40;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(var(--bs-body-bg-rgb), 0.85);
            backdrop-filter: blur(4px);
            border-radius: 2.5rem;
        }

        /* =============================================
           UI ELEMENTS (Music, Templates, etc.)
        ============================================= */
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
            border-color: var(--adminuiux-theme-1);
            background: rgba(198, 169, 98, 0.05);
        }

        .music-list-item.selected {
            border-color: var(--adminuiux-theme-1);
            background: rgba(198, 169, 98, 0.1);
        }

        .music-icon-box {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bs-tertiary-bg);
            border-radius: 0.5rem;
            color: var(--adminuiux-theme-1);
        }

        .music-list-item.selected .music-icon-box {
            background: var(--adminuiux-theme-1);
            color: #fff;
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
            border-color: var(--adminuiux-theme-1);
        }

        .template-card-selector .check-icon {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--adminuiux-theme-1);
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

        .premium-badge {
            background: linear-gradient(45deg, #f59e0b, #fbbf24);
            color: #000;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px !important;
        }

        .basic-badge {
            background: #10b981;
            color: #fff;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px !important;
        }

        .mobile-next-prev {
            display: none;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .sidebar-content.no-scrollbar {
            overflow-y: auto;
            flex: 1;
        }

        /* =============================================
           RESPONSIVE (MOBILE)
        ============================================= */
        @media (max-width: 991px) {
            .hide {
                display: none !important;
            }

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
                background: var(--bs-tertiary-bg);
                z-index: 1000;
            }

            .nav-vertical-link {
                width: 40px !important;
                height: 40px !important;
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
                flex: 1;
                overflow-y: auto;
                min-height: 0;
                padding: 1.25rem 1rem !important;
                background: rgba(var(--bs-tertiary-bg-rgb), 0.3);
            }

            .form-control,
            .form-select {
                padding: 0.6rem 0.75rem !important;
                border-radius: 0.75rem !important;
            }

            label {
                margin-bottom: 0.4rem !important;
                font-size: 13px !important;
            }

            .mobile-next-prev {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                gap: 0.5rem;
                padding: 0.75rem;
                background: var(--bs-card-bg);
                border-top: 1px solid var(--bs-border-color);
            }

            .mobile-next-prev .btn {
                flex: 1;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .mobile-next-prev #mobileTabLabel {
                flex: 0 0 auto;
                text-align: center;
                min-width: 50px;
            }

            #cropModal,
            #cropModal .modal-dialog {
                z-index: 10001 !important;
            }

            #cropModal .modal-backdrop {
                z-index: 10000 !important;
            }

            #partnerModal,
            #partnerModal .modal-dialog {
                z-index: 10001 !important;
            }

            #partnerModal .modal-backdrop {
                z-index: 10000 !important;
            }
        }

        #prevPage:disabled,
        #nextPage:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .pagination-hidden {
            display: none !important;
        }

        /* =============================================
           UPLOAD TOAST NOTIFICATION
        ============================================= */
        .upload-toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .upload-toast {
            pointer-events: auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 400px;
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .upload-toast.show {
            transform: translateX(0);
        }

        .upload-toast.hide {
            transform: translateX(120%);
        }

        .upload-toast-thumb {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            background: #f0f0f0;
        }

        .upload-toast-body {
            flex: 1;
            min-width: 0;
        }

        .upload-toast-title {
            font-size: 13px;
            font-weight: 600;
            color: #1B2A4A;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .upload-toast-status {
            font-size: 11px;
            color: #6c757d;
            margin-bottom: 6px;
        }

        .upload-toast-progress {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }

        .upload-toast-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #C6A962, #A68B4B);
            border-radius: 2px;
            width: 0%;
            transition: width 0.3s ease;
        }

        .upload-toast-close {
            background: none;
            border: none;
            color: #adb5bd;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .upload-toast-close:hover {
            color: #dc3545;
        }

        .upload-toast.success .upload-toast-progress-bar {
            background: #198754;
        }

        .upload-toast.error .upload-toast-progress-bar {
            background: #dc3545;
        }

        /* Mobile responsive */
        @media (max-width: 576px) {
            .upload-toast-container {
                bottom: 10px;
                right: 10px;
                left: 10px;
                align-items: stretch;
            }

            .upload-toast {
                min-width: auto;
                max-width: none;
                width: 100%;
                padding: 10px 14px;
            }

            .upload-toast-thumb {
                width: 40px;
                height: 40px;
            }
        }
    </style>

    <div class="builder-wrapper mb-5">
        <!-- 1. SIDEBAR (KIRI) -->
        <div class="builder-sidebar shadow-sm">
            <div class="sidebar-nav-vertical no-scrollbar hide">
               
                <div class="nav-vertical-link active" data-tab="tab-2" title="Tema">
                    <i class="bi bi-palette"></i><span>Tema</span>
                </div>
                <div class="nav-vertical-link" data-tab="tab-1" title="Pria">
                    <i class="bi bi-person"></i><span>Pria</span>
                </div>
                <div class="nav-vertical-link" data-tab="tab-7" title="Wanita">
                    <i class="bi bi-person-heart"></i><span>Wanita</span>
                </div>
                <div class="nav-vertical-link" data-tab="tab-6" title="Acara">
                    <i class="bi bi-calendar-event"></i><span>Acara</span>
                </div>

                @if(auth()->check() ? auth()->user()->hasFeature('gallery') : true)
                    <div class="nav-vertical-link" data-tab="tab-3" title="Galeri">
                        <i class="bi bi-images"></i><span>Galeri</span>
                    </div>
                @endif

                @if(auth()->check() ? (auth()->user()->hasFeature('background_music') || auth()->user()->hasFeature('custom_music')) : true)
                    <div class="nav-vertical-link" data-tab="tab-4" title="Musik">
                        <i class="bi bi-music-note-beamed"></i><span>Musik</span>
                    </div>
                @endif

                @if(auth()->check() ? auth()->user()->hasFeature('love_story') : true)
                    <div class="nav-vertical-link" data-tab="tab-8" title="Kisah">
                        <i class="bi bi-journal-text"></i><span>Kisah</span>
                    </div>
                @endif

                @if(auth()->check() ? auth()->user()->hasFeature('rsvp_messages') : true)
                    <div class="nav-vertical-link" data-tab="tab-5" title="RSVP">
                        <i class="bi bi-envelope-check"></i><span>RSVP</span>
                    </div>
                @endif

                @if(auth()->check() ? auth()->user()->hasFeature('virtual_gift') : true)
                    <div class="nav-vertical-link" data-tab="tab-9" title="Hadiah">
                        <i class="bi bi-gift"></i><span>Hadiah</span>
                    </div>
                @endif

                <div class="nav-vertical-link" data-bs-toggle="modal" data-bs-target="#partnerModal" title="Pasangan">
                    <i class="bi bi-person-hearts"></i><span>Pasangan</span>
                </div>
            </div>

            <div class="sidebar-content-pane">
                <div class="sidebar-header flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('dashboard.user') }}" class="btn btn-xs btn-outline-secondary border-0 px-2"
                            title="Kembali ke List">
                            <i class="bi bi-arrow-left fs-5"></i>
                        </a>
                        <div>
                            <h6 class="mb-0 fw-bold line-height-1" style="font-size: 14px;">Edit Undangan</h6>
                            <span id="autoSaveBadge" class="x-small text-muted" style="font-size: 10px;">
                                <i class="bi bi-cloud-check me-1"></i>Tersimpan
                            </span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm px-3 text-white rounded-pill btn-builder-next"
                        onclick="window.publishInvitation(); return false;">
                        <i class="bi bi-send-fill me-1"></i> Publikasikan
                    </button>
                </div>

                <div class="sidebar-content no-scrollbar">
                    <form id="myForm" method="POST" action="{{ route('invitation.update', $invitation) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $invitation->id }}">
                        <input type="hidden" name="uploaded_gallery_ids" id="uploadedGalleryIds" value="">
                        @include('dashboard.invitation.form_tabs', ['invitation' => $invitation, 'music' => $music, 'templates' => $templates])
                    </form>
                </div>

                <div class="mobile-next-prev">
                    <button type="button" id="mobilePrevBtn"
                        class="btn btn-outline-secondary btn-sm">Sebelumnya</button>
                    <span id="mobileTabLabel" class="small fw-semibold text-muted">Tema</span>
                    <button type="button" id="mobileNextBtn" class="btn btn-sm btn-builder-next">Selanjutnya</button>
                </div>
            </div>
            <!-- 2. CANVAS PREVIEW (KANAN) -->
       
        </div>
 <div class="builder-canvas">
            <div class="preview-device">
                <div id="previewWindow" class="preview-window no-scrollbar">
                    <div class="preview-notch"></div>
                    <iframe id="livePreviewIframe" name="livePreviewIframe" class="preview-iframe no-scrollbar"
                        src="{{ route('invitation.show', $invitation->slug) }}?v={{ ($invitation->updated_at->timestamp ?? time()) }}"></iframe>
                    <div id="previewLoader" class="d-none">
                        <div class="spinner-border mb-3" role="status" style="color: var(--adminuiux-theme-1);"></div>
                        <p class="small fw-bold">Updating...</p>
                    </div>
                </div>
            </div>
            <form id="previewForm" action="{{ route('invitation.live-preview') }}" method="POST"
                target="livePreviewIframe" style="display:none;" class="no-scrollbar">
                @csrf
                <div id="previewFormInputs"></div>
            </form>
        </div>
        
    </div>

    <!-- UPLOAD TOAST NOTIFICATION -->
    <div class="upload-toast-container" id="uploadToastContainer"></div>

    <!-- CROP MODAL -->
    <div class="modal fade" id="cropModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Sesuaikan Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0 bg-dark mt-3" style="height:60vh; overflow:hidden;">
                    <img id="cropImage" style="max-width:100%; display:block;">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn px-5 text-white btn-builder-next"
                        onclick="cropImage()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- PARTNER MODAL -->
    <div class="modal fade" id="partnerModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Kelola Pasangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if(!$invitation)
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Simpan atau publikasikan undangan terlebih dahulu sebelum mengundang pasangan.
                        </div>
                    @elseif($invitation->partner_user_id && $invitation->partner_accepted_at)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            <strong>{{ $invitation->partner->name }}</strong> ({{ $invitation->partner->email }}) telah
                            menerima undangan.
                            @if($invitation->partner_can_edit)
                                <span class="badge bg-success-subtle text-success ms-2">Dapat mengedit</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning ms-2">Hanya melihat</span>
                            @endif
                        </div>
                        <form id="removePartnerForm" action="{{ route('invitation.remove-partner', $invitation) }}"
                            method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm" id="removePartnerBtn">
                                <i class="bi bi-person-x me-1"></i> Hapus Pasangan
                            </button>
                        </form>
                    @elseif($invitation->partner_user_id && !$invitation->partner_accepted_at)
                        <div class="alert alert-warning">
                            <i class="bi bi-clock me-2"></i>
                            Undangan sedang menunggu <strong>{{ $invitation->partner->name }}</strong>
                            ({{ $invitation->partner->email }}) menerima.
                        </div>
                    @else
                        <form id="invitePartnerForm">
                            @csrf
                            <div class="mb-3">
                                <label for="partner_email" class="form-label fw-semibold mb-2">Email Pasangan</label>
                                <input type="email" class="form-control" id="partner_email" name="email" required
                                    placeholder="contoh: pasangan@email.com">
                                <small class="text-muted">Pasangan harus sudah memiliki akun terdaftar di sistem.</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold mb-2">Hak Akses</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="can_edit" id="can_edit_yes" value="1"
                                        checked>
                                    <label class="form-check-label" for="can_edit_yes">Bisa mengedit undangan</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="can_edit" id="can_edit_no" value="0">
                                    <label class="form-check-label" for="can_edit_no">Hanya bisa melihat</label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="invitePartnerBtn">
                                <i class="bi bi-send me-1"></i> Kirim Undangan
                            </button>
                            <div id="partnerFormMessage" class="mt-2"></div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        let cropper;
        let currentTarget = null;
        let previewTimer;
        let saveTimer;
        let galleryFiles = [];

        function toggleGlobalSidebar() {
            document.body.classList.toggle('adminuiux-sidebar-close');
        }

        // --- Tab Switching Logic ---
        function initTabs() {
            const links = document.querySelectorAll('.nav-vertical-link');
            const contents = document.querySelectorAll('.tab-content');

            links.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    links.forEach(l => l.classList.remove('active'));
                    contents.forEach(c => { c.classList.add('d-none'); c.classList.remove('active'); });
                    this.classList.add('active');

                    const targetId = this.getAttribute('data-tab');
                    const target = document.getElementById(targetId);
                    if (target) {
                        target.classList.remove('d-none');
                        setTimeout(() => { target.classList.add('active'); }, 10);
                    }
                    updateMobileTabLabel(targetId);
                });
            });
        }

        const visibleTabs = Array.from(document.querySelectorAll('.nav-vertical-link')).map(link => link.getAttribute('data-tab'));
        const tabOrder = visibleTabs;
        const tabLabels = { 'tab-builder': 'Builder', 'tab-1': 'Pria', 'tab-2': 'Tema', 'tab-3': 'Galeri', 'tab-4': 'Musik', 'tab-5': 'RSVP', 'tab-6': 'Acara', 'tab-7': 'Wanita', 'tab-8': 'Kisah', 'tab-9': 'Hadiah' };

        function updateMobileTabLabel(tabId) {
            const label = document.getElementById('mobileTabLabel');
            if (label && tabId && tabLabels[tabId]) label.textContent = tabLabels[tabId];
        }

        function getCurrentTabId() {
            const activeContent = document.querySelector('.tab-content:not(.d-none)');
            return activeContent ? activeContent.id : 'tab-2';
        }

        function goToTab(tabId) {
            const link = document.querySelector(`.nav-vertical-link[data-tab="${tabId}"]`);
            if (link) link.click();
        }

        window.goNextTab = function () {
            const current = getCurrentTabId();
            const idx = tabOrder.indexOf(current);
            const next = tabOrder[idx + 1];
            if (next) goToTab(next);
        };

        window.goPrevTab = function () {
            const current = getCurrentTabId();
            const idx = tabOrder.indexOf(current);
            const prev = tabOrder[idx - 1];
            if (prev) goToTab(prev);
        };

        window.toggleSettings = (id, isChecked) => {
            const el = document.getElementById(id);
            if (el) {
                el.style.display = isChecked ? 'block' : 'none';
                el.classList.toggle('d-none', !isChecked);
            }
            updateLivePreview();
        };

        // --- Template Gallery Logic ---
        const ITEMS_PER_PAGE = 6;
        let currentPage = 1;

        function filterTemplates() {
            const query = document.getElementById('searchTemplate').value.toLowerCase();
            const cat = document.getElementById('categorySelect').value;
            const items = Array.from(document.querySelectorAll('.template-selector-item'));

            items.forEach(item => {
                const matchesQuery = item.dataset.name.includes(query);
                const matchesCat = (cat === 'all' || item.dataset.category === cat);
                item.classList.toggle('d-none', !(matchesQuery && matchesCat));
            });
            currentPage = 1;
            renderPagination();
        }

        function renderPagination() {
            const gallery = document.getElementById('templateGallery');
            if (!gallery) return;
            const items = Array.from(gallery.querySelectorAll('.template-selector-item'));
            const visibleItems = items.filter(item => !item.classList.contains('d-none'));
            const totalPages = Math.max(1, Math.ceil(visibleItems.length / ITEMS_PER_PAGE));

            if (currentPage > totalPages) currentPage = 1;

            visibleItems.forEach(function (item, index) {
                const pageIndex = Math.floor(index / ITEMS_PER_PAGE) + 1;
                item.classList.toggle('pagination-hidden', pageIndex !== currentPage);
            });

            const pageInfo = document.getElementById('pageInfo');
            if (pageInfo) pageInfo.textContent = 'Halaman ' + currentPage + ' dari ' + totalPages;

            const prevBtn = document.getElementById('prevPage');
            const nextBtn = document.getElementById('nextPage');
            if (prevBtn) prevBtn.disabled = (currentPage <= 1);
            if (nextBtn) nextBtn.disabled = (currentPage >= totalPages);
        }

        function selectTemplate(el, id) {
            document.querySelectorAll('.template-card-selector').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            const hiddenInput = document.getElementById('template_id_hidden');
            if (hiddenInput) hiddenInput.value = id;

            const templateItem = el.closest('.template-selector-item');
            if (templateItem && templateItem.dataset.color) {
                const colorInput = document.getElementById('primary_color');
                const colorText = document.getElementById('primary_color_text');
                if (colorInput) colorInput.value = templateItem.dataset.color;
                if (colorText) colorText.value = templateItem.dataset.color;
            }
            updateLivePreview();
        }

        window.selectTemplate = selectTemplate;

        function autoSelectTemplate(templateId) {
            const items = Array.from(document.querySelectorAll('.template-selector-item')).filter(item => !item.classList.contains('d-none'));
            let targetItem = null;

            if (templateId) {
                targetItem = items.find(item => item.dataset.templateId == templateId);
            }

            if (!targetItem || targetItem.querySelector('.template-card-selector.locked')) {
                targetItem = items.find(item => !item.querySelector('.template-card-selector.locked')) || items[0];
            }

            if (!targetItem) return;

            const newTemplateId = targetItem.dataset.templateId;
            const index = items.indexOf(targetItem);
            if (index !== -1) {
                const targetPage = Math.floor(index / ITEMS_PER_PAGE) + 1;
                currentPage = targetPage;
                renderPagination();
            }

            const card = targetItem.querySelector('.template-card-selector');
            if (card) {
                selectTemplate(card, newTemplateId);
            }
        }

        window.autoSelectTemplate = autoSelectTemplate;

        window.showPremiumAlert = function () {
            Swal.fire({
                title: 'Tema Premium! 💎',
                text: 'Tema ini hanya tersedia untuk pengguna Premium. Upgrade paket Anda sekarang untuk membuka semua tema eksklusif!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C6A962',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Upgrade Sekarang',
                cancelButtonText: 'Mungkin Nanti'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = "{{ route('subscribe.page') }}";
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

        // --- Live Preview & Autosave ---
        function updateLivePreview() {
            const hiddenInput = document.getElementById('template_id_hidden');
            const templateId = hiddenInput ? hiddenInput.value : '';
            if (!templateId) return;

            clearTimeout(previewTimer);
            const loader = document.getElementById('previewLoader');
            if (loader) loader.classList.remove('d-none');

            previewTimer = setTimeout(() => {
                // Reload iframe directly to invitation preview URL with cache buster
                const iframe = document.getElementById('livePreviewIframe');
                if (iframe) {
                    const previewUrl = `{{ route('invitation.show', $invitation->slug) }}?v=${Date.now()}`;
                    iframe.src = previewUrl;
                }

                if (loader) loader.classList.add('d-none');

                // Trigger autosave after preview reload
                dbAutoSave();
            }, 300);
        }

        function reloadPreview() {
            const iframe = document.getElementById('livePreviewIframe');
            if (iframe) {
                const previewUrl = `{{ route('invitation.show', $invitation->slug) }}?v=${Date.now()}`;
                iframe.src = previewUrl;
            }
        }

        window.publishInvitation = function() {
            const myForm = document.getElementById('myForm');
            if (!myForm) return;

            const toastId = window.showUploadToast({name: 'Menyimpan undangan...'}, 'save');

            const formData = new FormData(myForm);
            if (!formData.has('_method')) {
                formData.append('_method', 'PUT');
            }

            fetch("{{ route('invitation.update', $invitation) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => {
                const contentType = res.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    return res.json().then(data => ({ ok: res.ok, data }));
                }
                // If server returns HTML (redirect), treat as success
                return { ok: true, data: { success: true } };
            })
            .then(({ ok, data }) => {
                if (ok && data.success) {
                    window.hideUploadToast(toastId, true);
                    reloadPreview();
                } else {
                    window.hideUploadToast(toastId, false);
                    const badge = document.getElementById('autoSaveBadge');
                    if (badge) badge.innerHTML = '<i class="bi bi-cloud-slash me-1 text-danger"></i>Gagal publikasi';
                }
            })
            .catch(() => {
                window.hideUploadToast(toastId, false);
                const badge = document.getElementById('autoSaveBadge');
                if (badge) badge.innerHTML = '<i class="bi bi-cloud-slash me-1 text-danger"></i>Gagal publikasi';
            });
        };

        function scaleLivePreview() {
            const device = document.querySelector('.preview-device');
            if (!device) return;
            const canvas = device.closest('.builder-canvas');
            if (!canvas) return;

            const padding = 60;
            const cw = canvas.clientWidth - padding;
            const ch = canvas.clientHeight - padding;
            const deviceW = 375 + 20;
            const deviceH = 750 + 20;
            const scale = Math.min(cw / deviceW, ch / deviceH, 1);
            device.style.transform = `scale(${scale})`;
        }

        function dbAutoSave() {
            clearTimeout(saveTimer);
            saveTimer = setTimeout(() => {
                const myForm = document.getElementById('myForm');
                if (!myForm) return;

                const hiddenInput = document.getElementById('template_id_hidden');
                const templateId = hiddenInput ? hiddenInput.value : '';
                if (!templateId) return;

                const formData = new FormData(myForm);
                if (!formData.has('template_id') || !formData.get('template_id')) {
                    formData.set('template_id', templateId);
                }

                const cleanData = new URLSearchParams();
                formData.forEach((v, k) => {
                    if (!(v instanceof File) && k !== '_method') cleanData.append(k, v);
                });

                const badge = document.getElementById('autoSaveBadge');
                if (badge) badge.innerHTML = '<i class="bi bi-cloud-arrow-up me-1 text-primary"></i>Menyimpan...';

                // Show autosave toast
                if (!window.autosaveToastId) {
                    const toastId = window.showUploadToast({ name: 'Menyimpan perubahan...' }, 'save');
                    window.autosaveToastId = toastId;
                    // Update toast status after a short delay
                    setTimeout(() => {
                        const toast = document.getElementById('upload-toast-' + toastId);
                        if (toast) {
                            const statusEl = toast.querySelector('.upload-toast-status');
                            if (statusEl) statusEl.textContent = 'Menyimpan perubahan...';
                        }
                    }, 100);
                }

                fetch("{{ route('invitation.autosave') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: cleanData
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (badge) badge.innerHTML = '<i class="bi bi-cloud-check me-1 text-success"></i>Tersimpan ✨';
                            if (window.autosaveToastId) {
                                hideUploadToast(window.autosaveToastId, true);
                                window.autosaveToastId = null;
                            }
                            // Reload preview after successful autosave
                            reloadPreview();
                        } else {
                            if (badge) badge.innerHTML = '<i class="bi bi-cloud-slash me-1 text-danger"></i>Gagal simpan';
                            if (window.autosaveToastId) {
                                hideUploadToast(window.autosaveToastId, false);
                                window.autosaveToastId = null;
                            }
                        }
                    })
                    .catch(err => {
                        if (badge) badge.innerHTML = '<i class="bi bi-cloud-slash me-1 text-danger"></i>Gagal simpan';
                    });
            }, 800);
        }

        // --- Media Handlers ---
        window.previewAudio = (url) => {
            const player = document.getElementById('audioPlayer');
            if (player) { player.src = url; player.play(); }
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
        window.uploadedGalleryIds = new Set();

        if (galleryDropzone && galleryInput) {
            galleryDropzone.addEventListener('click', () => galleryInput.click());

            galleryInput.addEventListener('change', function (e) {
                Array.from(e.target.files).forEach(file => {
                    const tempId = Math.random().toString(36).substr(2, 9);
                    const reader = new FileReader();
                    reader.onload = (re) => {
                        const div = document.createElement('div');
                        div.className = 'position-relative border rounded overflow-hidden gallery-item-preview shadow-sm';
                        div.id = 'gal-' + tempId;
                        div.style.width = '70px'; div.style.height = '70px';
                        div.innerHTML = `<img src="${re.target.result}" class="w-100 h-100 object-fit-cover" style="filter: blur(2px);"><div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"><div class="spinner-border spinner-border-sm text-light" role="status"></div></div>`;
                        document.getElementById('gallery-preview').appendChild(div);

                        // Show upload toast
                        const toastId = showUploadToast(file, 'gallery');

                        // Upload immediately via AJAX
                        const formData = new FormData();
                        formData.append('image', file);

                        fetch(`{{ route('gallery.upload', $invitation) }}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: formData
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    window.uploadedGalleryIds.add(data.gallery.id);
                                    updateUploadedGalleryInput();

                                    // Update preview with real image
                                    div.innerHTML = `<img src="${data.url}" class="w-100 h-100 object-fit-cover"><button type="button" class="btn btn-danger btn-xs position-absolute top-0 end-0 p-0 m-1 shadow-sm" style="width:18px;height:18px;" onclick="deleteGallery(${data.gallery.id}, this)">&times;</button>`;
                                    hideUploadToast(toastId, true);
                                } else {
                                    div.remove();
                                    hideUploadToast(toastId, false);
                                }
                            })
                            .catch(() => {
                                div.remove();
                                hideUploadToast(toastId, false);
                            });
                    };
                    reader.readAsDataURL(file);
                });

                // Clear the input so same file can be selected again if needed
                galleryInput.value = '';
            });
        }

        window.updateUploadedGalleryInput = function () {
            const input = document.getElementById('uploadedGalleryIds');
            if (input) {
                input.value = Array.from(window.uploadedGalleryIds).join(',');
            }
        };

        window.removeGalleryItem = (id) => {
            // Check if it's an uploaded gallery ID or a local temp ID
            if (window.uploadedGalleryIds.has(id)) {
                // It's an uploaded gallery, delete from server
                window.uploadedGalleryIds.delete(id);
                updateUploadedGalleryInput();
            } else {
                // It's a local file, remove from array
                galleryFiles = galleryFiles.filter(item => item.id !== id);
                const dt = new DataTransfer();
                galleryFiles.forEach(item => dt.items.add(item.file));
                galleryInput.files = dt.files;
            }

            const el = document.getElementById('gal-' + id);
            if (el) el.remove();

            updateLivePreview();
        };

        window.deleteGallery = function (id, btn) {
            const parent = btn ? btn.closest('.position-relative') : document.querySelector(`button[onclick*="deleteGallery(${id})"]`)?.closest('.position-relative');
            if (!parent) return;

            const toastId = window.showUploadToast({ name: 'Menghapus foto...' }, 'delete');

            fetch(`/invitation/{{ $invitation->id }}/gallery/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.uploadedGalleryIds.delete(id);
                        updateUploadedGalleryInput();
                        parent.remove();
                        window.hideUploadToast(toastId, true);
                        updateLivePreview();
                    } else {
                        window.hideUploadToast(toastId, false);
                    }
                })
                .catch(() => {
                    window.hideUploadToast(toastId, false);
                });
        };

        window.addLoveStory = () => {
            const div = document.createElement('div');
            div.className = 'love-story-item border rounded p-2 mb-2 bg-body-tertiary';
            div.innerHTML = `
            <input type="text" name="story_title[]" class="form-control form-control-sm mb-1" placeholder="Judul">
            <textarea name="love_story[]" rows="2" class="form-control form-control-sm x-small mb-1"></textarea>
            <div class="mb-2">
                <label class="form-label fw-semibold mb-1" style="font-size: 12px;">Foto Kisah</label>
                <input type="file" name="story_photo[]" accept="image/*" class="form-control form-control-sm">
            </div>
            <button type="button" class="btn btn-link text-danger btn-xs p-0" onclick="this.closest('.love-story-item').remove(); updateLivePreview();">Hapus</button>
        `;
            document.getElementById('loveStoryWrapper').appendChild(div);
            updateLivePreview();
        };

        window.addGift = () => {
            const div = document.createElement('div');
            div.className = 'gift-item border rounded p-3 mb-2 bg-body-tertiary position-relative shadow-sm';
            div.innerHTML = `
            <button type="button" class="btn-close x-small position-absolute top-0 end-0 m-2" onclick="this.closest('.gift-item').remove(); updateLivePreview();"></button>
            <div class="row g-2">
                <div class="col-12">
                    <label class="x-small fw-bold text-muted mb-1">Bank / E-Wallet</label>
                    <select name="bank[]" class="form-select form-select-sm">
                        <option value="BCA">BCA</option><option value="BNI">BNI</option><option value="BRI">BRI</option>
                        <option value="Mandiri">Mandiri</option><option value="Dana">DANA</option><option value="OVO">OVO</option><option value="Gopay">Gopay</option>
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
            </div>
        `;
            document.getElementById('giftContainer').appendChild(div);
            updateLivePreview();
        };

        // --- Crop Logic ---
        window.openCropModal = (event, target) => {
            const file = event.target.files[0];
            if (!file) return;

            currentTarget = target;
            const image = document.getElementById('cropImage');
            image.src = URL.createObjectURL(file);

            // Show upload toast
            window.cropToastId = window.showUploadToast(file, 'crop');

            const modal = new bootstrap.Modal(document.getElementById('cropModal'));
            modal.show();

            document.getElementById('cropModal').addEventListener('shown.bs.modal', () => {
                if (cropper) cropper.destroy();
                const aspect = (currentTarget === 'cover') ? 9 / 16 : 1;
                cropper = new Cropper(image, { aspectRatio: aspect, viewMode: 1, dragMode: 'move', autoCropArea: 1 });
            }, { once: true });
        };

        window.cropImage = () => {
            if (!cropper) return;
            cropper.getCroppedCanvas({ width: currentTarget === 'cover' ? 1200 : 800 }).toBlob(blob => {
                const file = new File([blob], "photo.jpg", { type: "image/jpeg" });
                const dt = new DataTransfer();
                dt.items.add(file);

                const capitalized = currentTarget.charAt(0).toUpperCase() + currentTarget.slice(1);
                const inputMap = { 'groom': 'foto_pria', 'bride': 'foto_wanita', 'cover': 'gallery_cover' };
                const inputId = inputMap[currentTarget];

                document.getElementById(inputId).files = dt.files;
                document.getElementById('preview' + capitalized).src = URL.createObjectURL(file);
                document.getElementById('previewContainer' + capitalized).classList.remove('d-none');
                document.getElementById('uploadBox' + capitalized + 'Container').classList.add('d-none');

                bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();

                if (window.cropToastId) {
                    hideUploadToast(window.cropToastId, true);
                    window.cropToastId = null;
                }

                // Upload immediately via AJAX so user doesn't need to submit full form
                const uploadConfig = {
                    'cover': { url: '{{ route('cover.upload', $invitation) }}', field: 'cover', inputId: 'gallery_cover' },
                    'groom': { url: '{{ route('groom-photo.upload', $invitation) }}', field: 'photo', inputId: 'foto_pria' },
                    'bride': { url: '{{ route('bride-photo.upload', $invitation) }}', field: 'photo', inputId: 'foto_wanita' },
                };

                const config = uploadConfig[currentTarget];
                if (config) {
                    const toastId = showUploadToast(file, currentTarget);
                    const formData = new FormData();
                    formData.append(config.field, file);

                    fetch(config.url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Update preview with real URL from server
                                document.getElementById('preview' + capitalized).src = data.url;
                                // Clear the input so form submit doesn't re-upload
                                const input = document.getElementById(config.inputId);
                                if (input) input.value = '';
                                hideUploadToast(toastId, true);
                            } else {
                                hideUploadToast(toastId, false);
                            }
                        })
                        .catch(() => {
                            hideUploadToast(toastId, false);
                        });
                } else {
                    updateLivePreview();
                }
            }, 'image/jpeg');
        };

        // --- Initialization ---
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add('adminuiux-sidebar-close');

            initTabs();

            const categorySelect = document.getElementById('categorySelect');
            const searchTemplate = document.getElementById('searchTemplate');
            if (categorySelect) categorySelect.onchange = filterTemplates;
            if (searchTemplate) searchTemplate.oninput = filterTemplates;

            // Pagination
            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');
            if (prevPageBtn) {
                prevPageBtn.addEventListener('click', function () {
                    if (currentPage > 1) { currentPage--; renderPagination(); }
                });
            }
            if (nextPageBtn) {
                nextPageBtn.addEventListener('click', function () {
                    var gallery = document.getElementById('templateGallery');
                    if (!gallery) return;
                    var visibleItems = Array.from(gallery.querySelectorAll('.template-selector-item')).filter(function (item) { return !item.classList.contains('d-none'); });
                    var totalPages = Math.max(1, Math.ceil(visibleItems.length / ITEMS_PER_PAGE));
                    if (currentPage < totalPages) { currentPage++; renderPagination(); }
                });
            }
            renderPagination();

            // [FIX] Auto select template
            const urlParams = new URLSearchParams(window.location.search);
            let templateId = urlParams.get('template_id') || '{{ $invitation->template_id }}' || document.getElementById('template_id_hidden')?.value;
            autoSelectTemplate(templateId);

            // Fallback: jika masih belum ada template yang terpilih, pilih yang pertama
            const currentTemplateVal = document.getElementById('template_id_hidden')?.value;
            if (!currentTemplateVal) {
                const firstUnlocked = document.querySelector('.template-card-selector:not(.locked)');
                if (firstUnlocked) {
                    selectTemplate(firstUnlocked, firstUnlocked.closest('.template-selector-item').dataset.templateId);
                }
            }

            // Form Events
            const myForm = document.getElementById('myForm');
            if (myForm) {
                myForm.addEventListener('change', (e) => { if (e.target.matches('input, textarea, select')) updateLivePreview(); });
            }

            const addGiftBtn = document.getElementById('addGift');
            if (addGiftBtn) addGiftBtn.onclick = addGift;

            // Music
            const musicSelect = document.getElementById('music_id');
            const audioPlayer = document.getElementById('audioPlayer');
            if (musicSelect && audioPlayer) {
                musicSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const audioUrl = selectedOption.dataset.audio;
                    if (audioUrl) {
                        audioPlayer.src = audioUrl;
                        audioPlayer.play().catch(e => console.log('Auto-play blocked.'));
                    } else { audioPlayer.src = ''; }
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

            // Mobile Nav
            const tab2 = document.querySelector('[data-tab="tab-2"]');
            if (tab2) { tab2.click(); updateMobileTabLabel('tab-2'); }

            const mobileNextBtn = document.getElementById('mobileNextBtn');
            const mobilePrevBtn = document.getElementById('mobilePrevBtn');
            if (mobileNextBtn) mobileNextBtn.addEventListener('click', window.goNextTab);
            if (mobilePrevBtn) mobilePrevBtn.addEventListener('click', window.goPrevTab);

            // Initial Load
            updateLivePreview();

            // Iframe scrollbar hide + 403 retry
            const livePreviewIframe = document.getElementById('livePreviewIframe');
            if (livePreviewIframe) {
                livePreviewIframe.addEventListener('load', function () {
                    try {
                        const css = `::-webkit-scrollbar { display: none !important; } html, body { scrollbar-width: none !important; -ms-overflow-style: none !important; overflow-y: auto !important; }`;
                        const style = this.contentWindow.document.createElement('style');
                        style.innerHTML = css;
                        this.contentWindow.document.head.appendChild(style);
                    } catch (e) { console.warn("Cross-origin iframe scrollbar hide failed."); }

                    // One-time retry for 403 to keep preview loaded
                    try {
                        const bodyText = this.contentWindow.document.body?.innerText || '';
                        if ((bodyText.includes('403') || bodyText.includes('Forbidden') || bodyText.includes('Tidak memiliki akses')) && !livePreviewIframe.dataset.retried) {
                            livePreviewIframe.dataset.retried = 'true';
                            console.warn('Preview 403 detected, retrying once...');
                            setTimeout(() => updateLivePreview(), 1500);
                        }
                    } catch (e) { /* ignore cross-origin errors */ }
                });
            }

            scaleLivePreview();
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(scaleLivePreview, 100);
            });
        });

        // --- Upload Toast Notification ---
        window.uploadToastId = 0;

        window.showUploadToast = function (file, type = 'image') {
            const container = document.getElementById('uploadToastContainer');
            if (!container) return;

            const id = ++window.uploadToastId;
            let thumbUrl = '';
            let fileName = 'Upload...';

            // Only create object URL for actual File/Blob objects
            if (file instanceof File || file instanceof Blob) {
                thumbUrl = URL.createObjectURL(file);
                fileName = file.name || 'Upload...';
            } else if (file && typeof file === 'object' && file.name) {
                // Plain object with name property (for non-file toasts like autosave)
                fileName = file.name;
            }

            const toast = document.createElement('div');
            toast.className = 'upload-toast';
            toast.id = 'upload-toast-' + id;
            toast.innerHTML = `
                <img src="${thumbUrl || 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2248%22 height=%2248%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236c757d%22 stroke-width=%222%22%3E%3Cpath d=%22M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83%22/%3E%3C/svg%3E'}" class="upload-toast-thumb" alt="Preview" style="${thumbUrl ? '' : 'opacity: 0.5;'}">
                <div class="upload-toast-body">
                    <div class="upload-toast-title">${fileName}</div>
                    <div class="upload-toast-status">Sedang mengupload...</div>
                    <div class="upload-toast-progress">
                        <div class="upload-toast-progress-bar" style="width: 0%"></div>
                    </div>
                </div>
                <button type="button" class="upload-toast-close" onclick="hideUploadToast(${id})">
                    <i class="bi bi-x-lg"></i>
                </button>
            `;

            container.appendChild(toast);

            // Trigger animation
            requestAnimationFrame(() => {
                toast.classList.add('show');
            });

            // Simulate progress with smooth easing
            const progressBar = toast.querySelector('.upload-toast-progress-bar');
            const statusEl = toast.querySelector('.upload-toast-status');
            let progress = 0;

            // Smooth easing function: slow start, fast middle, slow end
            const easeInOutQuad = t => t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;

            const totalDuration = 1500; // 1.5 seconds to reach 90%
            const startTime = Date.now();

            const animateProgress = () => {
                const elapsed = Date.now() - startTime;
                const rawProgress = Math.min(elapsed / totalDuration, 1);
                progress = Math.round(easeInOutQuad(rawProgress) * 90);

                if (progressBar) {
                    progressBar.style.width = progress + '%';
                }

                if (rawProgress < 1) {
                    toast._progressRaf = requestAnimationFrame(animateProgress);
                }
            };

            toast._progressRaf = requestAnimationFrame(animateProgress);

            // Store for cleanup
            toast._thumbUrl = thumbUrl;

            return id;
        };

        window.hideUploadToast = function (id, success = true) {
            const toast = document.getElementById('upload-toast-' + id);
            if (!toast) return;

            const statusEl = toast.querySelector('.upload-toast-status');
            const progressBar = toast.querySelector('.upload-toast-progress-bar');

            // Cancel any running animation
            if (toast._progressRaf) {
                cancelAnimationFrame(toast._progressRaf);
            }

            if (progressBar) progressBar.style.width = '100%';
            if (statusEl) statusEl.textContent = success ? 'Upload berhasil' : 'Upload gagal';
            toast.classList.add(success ? 'success' : 'error');

            setTimeout(() => {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => {
                    if (toast._thumbUrl) URL.revokeObjectURL(toast._thumbUrl);
                    toast.remove();
                }, 300);
            }, 400);
        };

        window.updateUploadToast = function (id, status, message) {
            const toast = document.getElementById('upload-toast-' + id);
            if (!toast) return;
            const statusEl = toast.querySelector('.upload-toast-status');
            if (statusEl) statusEl.textContent = message || status;
        };
    </script>
</x-app-layout>
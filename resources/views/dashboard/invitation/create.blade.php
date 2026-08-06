<x-app-layout>

<style>
    /* --- Layout --- */
    .inner-sidebar-wrap .inner-sidebar { background-color: transparent; }
    .inner-sidebar,
    .inner-sidebar-wrap,
    .inner-sidebar .nav { width: 100%; max-width: 100%; }

    /* --- Theme Color --- */
    :root { --theme-color: #FF6B81; }

    /* --- Sidebar Sticky --- */
    .sidebar-sticky {
        position: sticky;
        top: 0;
        height: auto;
    }

    .sidebar-menu-wrap {
        flex: 0 0 auto;
        overflow-y: visible;
    }

    /* --- Sidebar Nav Items --- */
    .islami-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: color-mix(in srgb, #FF6B81 15%, transparent);
        border-radius: 10px;
        color: #FF6B81;
        flex-shrink: 0;
    }

    .inner-sidebar .nav-link {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        border-radius: 10px;
        color: #374151;
        transition: all 0.2s ease;
        margin-bottom: 4px;
        text-decoration: none;
    }

    .inner-sidebar .nav-link:hover {
        background-color: color-mix(in srgb, #FF6B81 10%, transparent);
        color: #FF6B81;
    }

    .inner-sidebar .nav-link.active {
        background-color: #FF6B81;
        color: #ffffff;
    }

    .inner-sidebar .nav-link.active .islami-icon {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    .inner-sidebar .nav-link span {
        font-weight: 500;
        font-size: 14px;
    }

    /* --- Dark Mode: Sidebar --- */
    [data-bs-theme="dark"] .inner-sidebar .nav-link { color: #e5e7eb; }
    [data-bs-theme="dark"] .inner-sidebar .nav-link:hover {
        background-color: color-mix(in srgb, #FF6B81 20%, transparent);
        color: #FF6B81;
    }
    [data-bs-theme="dark"] .islami-icon {
        background-color: color-mix(in srgb, #FF6B81 20%, transparent);
        color: #FF6B81;
    }
    [data-bs-theme="dark"] .inner-sidebar .nav-link.active .islami-icon {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    /* --- Dark Mode: TomSelect --- */
    [data-bs-theme="dark"] .ts-control,
    [data-bs-theme="dark"] .ts-dropdown { background-color: #1e1e2d; color: #e5e7eb; border-color: #374151; }
    [data-bs-theme="dark"] .ts-control input { color: #e5e7eb; }
    [data-bs-theme="dark"] .ts-dropdown { box-shadow: 0 10px 25px rgba(0, 0, 0, .6); }
    [data-bs-theme="dark"] .ts-dropdown .option { color: #e5e7eb; }
    [data-bs-theme="dark"] .ts-dropdown .option:hover,
    [data-bs-theme="dark"] .ts-dropdown .option.active { background-color: #374151; color: #fff; }
    [data-bs-theme="dark"] .ts-dropdown .option.selected { background-color: #2563eb; color: #fff; }
    [data-bs-theme="dark"] .ts-control::after { border-top-color: #e5e7eb; }
    .tab-btn {
    cursor: pointer;
}
    /* --- Photo Preview --- */
    #previewContainerGroom,
    #previewContainerBride { text-align: center; }

    #previewGroom,
    #previewBride {
        width: 100%;
        max-width: 300px;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin: 0 auto;
        background-color: #f8f9fa;
        display: block;
    }

    /* --- Upload Zone --- */
    .upload-zone {
        border: 2px dashed var(--bs-border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .upload-zone:hover {
        border-color: #FF6B81;
        background: color-mix(in srgb, #FF6B81 3%, transparent);
    }
    .upload-zone svg { color: var(--bs-secondary-color); }

    /* --- Instagram Input Group --- */
    .insta-group { display: flex; align-items: stretch; }
    .insta-prefix {
        display: flex;
        align-items: center;
        padding: 0 0.75rem;
        background: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
        border-right: none;
        border-radius: 0.375rem 0 0 0.375rem;
        font-weight: 600;
        color: var(--bs-secondary-color);
    }
    .insta-group .form-control { border-radius: 0 0.375rem 0.375rem 0; }

    /* --- Gallery --- */
    .gallery-thumb {
        width: 100px;
        height: 100px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
    }
    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .gallery-thumb .btn-remove {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 22px;
        height: 22px;
        padding: 0;
        border-radius: 50%;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* --- Gift Item --- */
    .gift-item {
        border: 1px solid var(--bs-border-color);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        position: relative;
    }

    /* --- Love Story Item --- */
    .love-story-item {
        border: 1px solid var(--bs-border-color);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1rem;
    }

    /* --- Android Preview Frame --- */
    .android-frame {
        width: 200px;
        height: 400px;
        border: 10px solid #111;
        border-radius: 30px;
        background: #000;
        overflow: auto;
        position: relative;
        margin: 0 auto;
    }
    .android-frame::before {
        content: '';
        position: absolute;
        top: 6px;
        left: 50%;
        transform: translateX(-50%);
        width: 70px;
        height: 6px;
        background: #333;
        border-radius: 10px;
        z-index: 2;
    }
    .android-frame .screen { width: 100%; height: 100%; overflow: auto; scrollbar-width: none; }
    .android-frame .screen::-webkit-scrollbar { display: none; width: 0; height: 0; }
    .android-frame .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 20px;
    }

    /* --- Tab Transition --- */
    .tab-content { animation: tabFade 0.2s ease-out; }
    @keyframes tabFade {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* --- Template Selection --- */
    .template-option.selected-template {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .template-option {
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .template-option:hover {
        border-color: #0d6efd !important;
        cursor: pointer;
    }

    /* --- Sticky Save (Mobile) --- */
    .sticky-save-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
    }
    .sticky-save-btn.visible {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    /* --- Layout Responsif untuk Laptop --- */
    @media (min-width: 992px) {
        .inner-sidebar-wrap {
            display: flex;
            flex-wrap: nowrap;
            align-items: flex-start;
            gap: 1rem;
        }
        .inner-sidebar-wrap > .inner-sidebar {
            width: 250px;
            max-width: 250px;
            flex-shrink: 0;
        }
        .inner-sidebar-wrap > .inner-sidebar-content {
            flex: 1 1 auto;
            min-width: 0;
        }
    }

    /* --- Live Preview Split Layout --- */
    .edit-layout {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    @media (min-width: 992px) {
        .edit-layout {
            flex-direction: row;
            align-items: flex-start;
        }
        .edit-form-panel {
            flex: 1 1 auto;
            min-width: 0;
        }
        .edit-preview-panel {
            width: 400px;
            flex-shrink: 0;
            align-self: flex-start;
        }
    }

    /* --- Live Preview Split Layout --- */
    .live-preview-frame {
        width: 360px;
        height: 640px;
        margin: 0 auto;
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        background: #fff;
    }
    @media (max-width: 991.98px) {
        .live-preview-frame {
            width: 320px;
            height: 560px;
        }
    }
    [data-bs-theme="dark"] #previewFrame {
        background: #1e1e2d;
    }

    .android-frame.live-preview-frame {
        width: 360px;
        height: 640px;
        overflow: hidden;
        position: sticky;
        top: 1rem;
        align-self: flex-start;
    }
    @media (max-width: 991.98px) {
        .android-frame.live-preview-frame {
            width: 320px;
            height: 560px;
        }
    }
    .android-frame.live-preview-frame .screen {
        width: 100%;
        height: 100%;
        overflow: auto;
        scrollbar-width: none;
    }
    .android-frame.live-preview-frame .screen::-webkit-scrollbar {
        scrollbar-color: rgba(0,0,0,0.15) transparent;
        display: block;
    }
    #previewFrame {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
        background: var(--bs-body-bg);
    }

    /* --- Global thin scrollbar --- */
    html, body {
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,0.15) transparent;
    }
    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }
    html::-webkit-scrollbar-track,
    body::-webkit-scrollbar-track {
        background: transparent;
    }
    html::-webkit-scrollbar-thumb,
    body::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.15);
        border-radius: 2px;
    }

    .inner-sidebar-wrap .inner-sidebar-content {
        overflow-y: visible !important;
        height: auto !important;
        max-height: none !important;
        align-self: flex-start;
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,0.2) transparent;
    }
    .inner-sidebar-wrap .inner-sidebar-content::-webkit-scrollbar {
        width: 4px;
    }
    .inner-sidebar-wrap .inner-sidebar-content::-webkit-scrollbar-track {
        background: transparent;
    }
    .inner-sidebar-wrap .inner-sidebar-content::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.15);
        border-radius: 2px;
    }

    /* --- Ikon style --- */
    .islami-icon {
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: color-mix(in srgb, #FF6B81 15%, transparent);
        border-radius: 8px;
        color: #FF6B81;
        flex-shrink: 0;
    }

    .inner-sidebar .nav-link {
        display: flex;
        align-items: center;
        padding: 8px 10px;
        border-radius: 8px;
        color: #374151;
        transition: all 0.2s ease;
        margin-bottom: 2px;
        text-decoration: none;
    }

    .inner-sidebar .nav-link:hover {
        background-color: color-mix(in srgb, #FF6B81 10%, transparent);
        color: #FF6B81;
    }

    .inner-sidebar .nav-link.active {
        background-color: #FF6B81;
        color: #ffffff;
    }

    .inner-sidebar .nav-link.active .islami-icon {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
    }

    .inner-sidebar .nav-link span {
        font-weight: 500;
        font-size: 13px;
    }

    /* --- Custom SweetAlert --- */
    .custom-swal-popup {
        border-radius: 16px;
        padding: 24px;
    }
    .custom-swal-title {
        font-size: 22px;
        font-weight: 700;
    }
    .custom-swal-text {
        font-size: 14px;
        color: #6b7280;
    }
    .custom-swal-confirm {
        background: #ef4444 !important;
        border-radius: 10px !important;
        padding: 10px 20px !important;
        font-weight: 600;
    }
    .custom-swal-cancel {
        background: #fff !important;
        color: #111 !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        padding: 10px 20px !important;
        font-weight: 500;
    }

    /* --- Cropper --- */
    .cropper-container,
    .cropper-wrap-box,
    .cropper-canvas,
    .cropper-drag-box {
        width: 100% !important;
        height: 100% !important;
    }
</style>

<link href="https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.css" rel="stylesheet">
<script src="https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Errors -->
@if ($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Modal: New Invitation -->
<div class="modal fade" id="newInvitationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="quickCreateForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-heart-heart me-2"></i>
                        Undangan Baru
                    </h5>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-3">Masukkan nama pengantin dan pilih template untuk memulai.</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Mempelai Pria</label>
                        <input type="text" id="modal_groom_name" class="form-control" placeholder="Nama lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Panggilan Pria</label>
                        <input type="text" id="modal_groom_nickname" class="form-control" placeholder="Nama panggilan (opsional)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Mempelai Wanita</label>
                        <input type="text" id="modal_bride_name" class="form-control" placeholder="Nama lengkap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Panggilan Wanita</label>
                        <input type="text" id="modal_bride_nickname" class="form-control" placeholder="Nama panggilan (opsional)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Template</label>
                        <div class="row g-3" id="modal_template_selector">
                            @foreach ($templates as $template)
                            <div class="col-6">
                                <label class="d-block">
                                    <input type="radio"
                                           name="modal_template_id"
                                           value="{{ $template->id }}"
                                           class="d-none template-radio"
                                           onchange="document.getElementById('modal_template_id_hidden').value = this.value">
                                    <div class="template-option card border-2 cursor-pointer h-100"
                                         style="border-color: #ddd;"
                                         onclick="selectTemplateCard(this)">
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($template->preview) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                        </div>
                                        <div class="card-body p-2 text-center">
                                            <small class="fw-medium">{{ $template->name }}</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                                            @endforeach
                                            {{ $templates->links() }}
                                        </div>
                        <input type="hidden" id="modal_template_id_hidden" name="template_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="quickCreateBtn">
                        <i class="bi bi-plus-lg me-1"></i> Buat Undangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectTemplateCard(card) {
    document.querySelectorAll('#modal_template_selector .template-option').forEach(c => {
        c.style.borderColor = '#ddd';
        c.style.boxShadow = 'none';
    });
    card.style.borderColor = '#FF6B81';
    card.style.boxShadow = '0 0 0 0.25rem rgba(255, 107, 129, 0.25)';
    const radio = card.closest('label').querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
}
</script>

@include('dashboard.invitation.mobile')

<div class="inner-sidebar-wrap">
    {{-- SIDEBAR MENU --}}
    <div class="inner-sidebar bg-none mb-5">
        <div class="card adminuiux-card">
            <div class="card-body d-flex flex-column sidebar-sticky">
                <div class="row mb-3">
                    <div class="col align-self-center">
                        <h6 class="fw-medium">Main Menu</h6>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="inner-sidebar-wrap sidebar-menu-wrap">
                    <div class="inner-sidebar">
                        <ul class="nav flex-column no-scrollbar">
                            <li class="nav-item">
                                <a class="nav-link tab-btn active" data-tab="2">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-palette fs-5"></i>
                                    </div>
                                    <span>Tema & Warna</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn " data-tab="1">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <span>Mempelai Pria</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-tab="7">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-person-heart fs-5"></i>
                                    </div>
                                    <span>Mempelai Wanita</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-tab="6">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-geo-alt-fill fs-5"></i>
                                    </div>
                                    <span>Tempat & Tanggal</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-tab="3">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-images fs-5"></i>
                                    </div>
                                    <span>Galeri Foto</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-tab="4">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-music-note-beamed fs-5"></i>
                                    </div>
                                    <span>Musik</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-tab="8">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-play fs-5"></i>
                                    </div>
                                    <span>Video dan Kisah Cinta</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-tab="5">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-chat-dots fs-5"></i>
                                    </div>
                                    <span>RSVP</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-btn" data-tab="9">
                                    <div class="islami-icon me-3">
                                        <i class="bi bi-gift fs-5"></i>
                                    </div>
                                    <span>Hadiah dan Donasi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="inner-sidebar-content" style="display:none;" id="mainFormContainer">
        <div class="edit-layout">
            <div class="edit-form-panel">
                <div class="p-3">
                    {{-- HEADER --}}
                    <form id="myForm" method="POST" action="{{ route('invitation.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row align-items-center mb-4 gy-3">
                            <div class="col-12 col-sm">
                                <h5 class="mb-0 text-center text-sm-start">
                                    Buat Baru
                                </h5>
                            </div>
                            <div class="col-12 col-sm-auto ms-sm-auto">
                                <div class="d-grid d-sm-flex gap-2">
                                    <button type="submit" class="btn btn-primary btn-sm" id="saveButton">
                                        <i class="bi bi-envelope-paper-heart me-1"></i>
                                        Create Invitation
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- 1. MEMPELAI PRIA --}}
                        <div id="1" class="tab-content  d-none">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Data Mempelai Pria</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="groom_name" class="form-label">Nama Mempelai Pria</label>
                                            <input type="text" id="groom_name" name="groom_name" value="{{ old('groom_name') }}" placeholder="Masukkan nama mempelai pria" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="groom_nickname" class="form-label">Nama Panggilan</label>
                                            <input type="text" id="groom_nickname" name="groom_nickname" value="{{ old('groom_nickname') }}" placeholder="Masukkan nama panggilan" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="groom_father_name" class="form-label">Nama Ayah Kandung</label>
                                            <input type="text" id="groom_father_name" name="groom_father_name" value="{{ old('groom_father_name') }}" placeholder="Masukkan nama lengkap ayah" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="groom_mother_name" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" id="groom_mother_name" name="groom_mother_name" value="{{ old('groom_mother_name') }}" placeholder="Masukkan nama lengkap ibu" class="form-control">
                                        </div>
                                        <div class="col-12 mb-6">
                                            <label for="groom_username_instagram" class="form-label">Username</label>
                                            <span>@</span>
                                            <input type="text" id="groom_username_instagram" name="groom_username_instagram" value="{{ old('groom_username_instagram') }}" placeholder="Contoh: gemini.ai" class="form-control insta-username">
                                        </div>
                                        <div class="col-12 mb-6">
                                            <label for="groom_instagram" class="form-label">Link Instagram (Otomatis)</label>
                                            <input type="text" id="groom_instagram" name="groom_instagram" value="{{ old('groom_instagram') }}" placeholder="Akan terisi otomatis..." class="form-control" readonly>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Foto Mempelai Pria</label>
                                            <div class="upload-zone" id="uploadBoxGroomContainer">
                                                <label id="uploadBoxGroom" for="foto_pria" class="cursor-pointer">
                                                    <div class="mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                    <input id="foto_pria" type="file" name="foto_pria" class="d-none" onchange="openCropModal(event, 'groom')">
                                                </label>
                                            </div>
                                            <div id="previewContainerGroom" class="mt-3 d-none">
                                                <img id="previewGroom" class="img-fluid rounded" alt="Preview Foto">
                                                <div class="text-center mt-2">
                                                    <button type="button" onclick="removePreview('groom')" class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. TEMA & WARNA --}}
                        <div id="2" class="tab-content  active">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-palette fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Tema & Warna</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Pilih Template</label>
                                        <input type="hidden" name="template_id" id="template_id" value="">
                                        @php
                                            $defaultThemeColors = [
                                                'simple-theme' => '#c8a97e',
                                                'elegant-theme' => '#1A3C34',
                                                'royal-gold' => '#FF6B81',
                                                'floral-botanical' => '#8B6F5E',
                                                'anime' => '#FF6B81',
                                                'adat' => '#1A4D2E',
                                                'element' => '#8E7F7F',
                                                'sample' => '#D4AF37',
                                                'elegant_tempelate' => '#1A3C34',
                                            ];
                                        @endphp
                                        <div class="row g-3" id="template-selector">
                                            @foreach ($templates as $template)
                                            @php
                                                    $templateColor = $defaultThemeColors[$template->slug] ?? '#FF6B81';
                                            @endphp
                                            <div class="col-6 col-md-4">
                                                <div class="template-option card cursor-pointer border-2"
                                                     data-template-id="{{ $template->id }}"
                                                     data-preview="{{ Storage::url($template->preview) }}"
                                                     data-slug="{{ $template->slug }}"
                                                     data-theme-color="{{ $templateColor }}">
                                                    <div class="position-relative">
                                                        <img src="{{ Storage::url($template->preview) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                    </div>
                                                    <div class="card-body p-2">
                                                        <h6 class="mb-0 text-center">{{ $template->name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                            @endforeach
                            {{ $templates->links() }}
                        </div>
                                     </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Tone Warna Tema</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <input type="hidden" name="theme_color" id="theme_color" value="#FF6B81">
                                            <input type="color" id="theme_color_picker" value="#FF6B81" class="form-control form-control-color" style="width: 60px; height: 40px; padding: 0; border: 1px solid var(--bs-border-color); border-radius: 4px; cursor: pointer; background: #FF6B81;">
                                            <input type="text" id="theme_color_text" class="form-control" style="max-width: 150px;" value="#FF6B81" readonly>
                                            <span class="text-muted small">Warna tema akan diterapkan ke template undangan.</span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="gallery_cover" class="form-label">Cover Galeri</label>
                                        <input type="file" id="gallery_cover" name="gallery_cover" accept="image/*" class="form-control" onchange="handleGalleryCover(this)">
                                        <div id="galleryCoverPreview" class="mt-2 d-none">
                                            <img src="" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>

                                    
                                </div>
                            </div>
                        </div>

                        {{-- 3. GALERI FOTO --}}
                        <div id="3" class="tab-content d-none">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-images fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Galeri Foto</h6>
                                </div>
                                <div class="card-body">
                                    <label class="form-label">Galeri Kisah</label>
                                    <div class="upload-zone" id="gallery-dropzone">
                                        <p class="mb-0">Drag & drop gambar di sini atau klik untuk memilih</p>
                                        <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="d-none">
                                    </div>
                                    <div class="mt-3">
                                        <label class="mb-2">Preview :</label>
                                        <div id="gallery-preview" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. MUSIK --}}
                        <div id="4" class="tab-content d-none">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-music-note-beamed fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Musik</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Pilih Sumber Musik</label>
                                        <div class="d-flex gap-3 mb-3" role="radiogroup">
                                            <div class="form-check form-check-inline me-3">
                                                <input class="form-check-input music-source-radio" type="radio"
                                                       name="music_source" value="internal"
                                                       id="musicSourceInternal" checked>
                                                <label class="form-check-label" for="musicSourceInternal">
                                                    <i class="bi bi-music-note-beamed me-1"></i>Perpustakaan / Upload
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input music-source-radio" type="radio"
                                                       name="music_source" value="youtube"
                                                       id="musicSourceYoutube">
                                                <label class="form-check-label" for="musicSourceYoutube">
                                                    <i class="bi bi-youtube me-1 text-danger"></i>Dari YouTube
                                                </label>
                                            </div>
                                        </div>

                                        <div id="musicInternalOptions" class="music-source-options">
                                            <div class="mb-3">
                                                <label for="music_id" class="form-label">Pilih Lagu Background</label>
                                                <select id="music_id" name="music_id" class="form-select">
                                                    <option value="">-- Pilih Lagu --</option>
                                                    @foreach ($music as $item)
                                                    <option value="{{ $item->id }}"                                                         data-audio="{{ asset('storage/' . $item->audio_url) }}">
                                                        {{ $item->title }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <script>
                                                    new TomSelect('#music_id', {
                                                        placeholder: 'Cari lagu...',
                                                        valueField: 'value',
                                                        labelField: 'text',
                                                        searchField: ['text'],
                                                        render: {
                                                            option: function(data, escape) {
                                                                return `<div class="d-flex align-items-center gap-2"><i class="bi bi-music-note-beamed fs-5"></i><span>${escape(data.text)}</span></div>`;
                                                            },
                                                            item: function(data, escape) {
                                                            return `<span><i class="bi bi-music-note-beamed me-1"></i>${escape(data.text)}</span>`;
                                                    }
                                                    }
                                                </script>

                                                <audio id="audioPlayer" controls style="margin-top:10px; width:100%;">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </div>

                                            <div class="mb-3">
                                                <label for="custom_music" class="form-label">Upload Lagu Pilihan Kamu</label>
                                                <input type="file" name="custom_music" accept="audio/*" class="form-control">
                                            </div>
                                        </div>

                                        <div id="musicYoutubeOptions" class="music-source-options" style="display:none;">
                                            <div class="mb-3">
                                                <label for="music_youtube_url" class="form-label">Link Video YouTube</label>
                                                <input type="url" id="music_youtube_url" name="music_youtube_url"
                                                       class="form-control"
                                                       placeholder="https://www.youtube.com/watch?v=...">
                                                <div class="form-text">Masukkan link video YouTube untuk digunakan sebagai musik background</div>
                                            </div>

                                            <div id="youtube-preview" class="mt-3 d-none">
                                                <div class="border rounded p-2 d-flex align-items-center gap-2">
                                                    <i class="bi bi-youtube fs-4 text-danger"></i>
                                                    <div>
                                                        <div class="fw-medium">Video YouTube Terpilih</div>
                                                        <div id="youtube-video-id" class="small text-muted"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        const musicSelect = document.getElementById('music_id');
                                        const audioPlayer = document.getElementById('audioPlayer');

                                        if (musicSelect && audioPlayer) {
                                            const initialOption = musicSelect.options[musicSelect.selectedIndex];
                                            if(initialOption && initialOption.getAttribute('data-audio')) {
                                                audioPlayer.src = initialOption.getAttribute('data-audio');
                                            }

                                            musicSelect.addEventListener('change', function() {
                                                const selectedOption = this.options[this.selectedIndex];
                                                const audioSrc = selectedOption.getAttribute('data-audio');

                                                if (audioSrc) {
                                                    audioPlayer.src = audioSrc;
                                                    audioPlayer.load();
                                                    audioPlayer.play();
                                                } else {
                                                    audioPlayer.pause();
                                                    audioPlayer.src = '';
                                                }
                                            });
                                        }

                                        const sourceRadios = document.querySelectorAll('.music-source-radio');
                                        const internalOptions = document.getElementById('musicInternalOptions');
                                        const youtubeOptions = document.getElementById('musicYoutubeOptions');

                                        function toggleSourceOptions() {
                                            const isYoutube = document.getElementById('musicSourceYoutube').checked;
                                            if (internalOptions) internalOptions.style.display = isYoutube ? 'none' : 'block';
                                            if (youtubeOptions) youtubeOptions.style.display = isYoutube ? 'block' : 'none';
                                        }

                                        sourceRadios.forEach(radio => {
                                            radio.addEventListener('change', toggleSourceOptions);
                                        });

                                        const youtubeInput = document.getElementById('music_youtube_url');
                                        const youtubePreview = document.getElementById('youtube-preview');
                                        const youtubeVideoIdSpan = document.getElementById('youtube-video-id');

                                        function extractYoutubeVideoId(url) {
                                            if (!url) return null;
                                            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)(?<videoId>[A-Za-z0-9_-]{11}).*/;
                                            const match = url.match(regExp);
                                            return match ? match.groups.videoId : null;
                                        }

                                        if (youtubeInput) {
                                            youtubeInput.addEventListener('input', function() {
                                                const url = this.value.trim();
                                                const videoId = extractYoutubeVideoId(url);
                                                if (videoId && youtubeOptions && youtubeOptions.style.display !== 'none') {
                                                    youtubeVideoIdSpan.textContent = 'Video ID: ' + videoId;
                                                    youtubePreview.classList.remove('d-none');
                                                } else {
                                                    youtubePreview.classList.add('d-none');
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>

                        {{-- 5. RSVP --}}
                        <div id="5" class="tab-content d-none">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-chat-dots fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">RSVP</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="enable_rsvp" name="enable_rsvp">
                                            <label class="form-check-label" for="enable_rsvp">
                                                Aktifkan RSVP
                                            </label>
                                        </div>
                                    </div>
                                    <div id="rsvp_settings">
                                        <div class="mb-3">
                                            <label for="rsvp_deadline" class="form-label">Batas Tanggal RSVP</label>
                                            <input type="date" name="rsvp_deadline" value="{{ old('rsvp_deadline') }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="rsvp_message" class="form-label">Pesan Konfirmasi</label>
                                            <textarea name="rsvp_message" rows="4" placeholder="Terima kasih atas konfirmasi kehadiran Anda. Kami sangat menantikan kehadiran Anda di hari bahagia kami." class="form-control">{{ old('rsvp_message') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rsvp_whatsapp" class="form-label">Nomor WhatsApp untuk Notifikasi</label>
                                            <input type="text" name="rsvp_whatsapp" value="{{ old('rsvp_whatsapp') }}" placeholder="6281234567890" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 6. TEMPAT --}}
                        <div id="6" class="tab-content d-none">
                            <div class="card mb-4">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-calendar-event fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Tanggal Pernikahan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="wedding_date" class="form-label">Tanggal</label>
                                        <input type="date" id="wedding_date" name="wedding_date" value="{{ old('wedding_date') }}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-moon-stars fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Tempat Akad</h6>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-12">
                                        <label for="akad_location" class="form-label">Nama Tempat</label>
                                        <input type="text" id="akad_location" name="akad_location" value="{{ old('akad_location') }}" placeholder="Masukkan lokasi akad" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="akad_address" class="form-label">Alamat Akad</label>
                                        <input type="text" id="akad_address" name="akad_address" value="{{ old('akad_address') }}" placeholder="Contoh : Jalan Pancasila No.41" class="form-control">
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="akad_time" class="form-label">Jam Mulai</label>
                                            <input type="time" id="akad_time" name="akad_time" placeholder="Contoh: 08:00 - Selesai" value="{{ old('akad_time') }}" class="form-control resepsi-time">
                                            <small class="text-muted time-label"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jam Selesai</label>
                                            <input type="time" name="akad_time_end" value="{{ old('akad_time_end') }}" class="form-control time-end">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="akad_maps" class="form-label">Link Maps</label>
                                        <input type="text" id="akad_maps" name="akad_maps" value="{{ old('akad_maps') }}" placeholder="Masukkan link Google Maps" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-geo-alt fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Tempat Resepsi</h6>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-12">
                                        <label for="resepsi_location" class="form-label">Lokasi Acara</label>
                                        <input type="text" id="resepsi_location" name="resepsi_location" value="{{ old('resepsi_location') }}" placeholder="Masukkan lokasi resepsi" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="resepsi_address" class="form-label">Alamat Resepsi</label>
                                        <input type="text" id="resepsi_address" name="resepsi_address" value="{{ old('resepsi_address') }}" placeholder="Contoh : Jalan Pancasila No.41" class="form-control">
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="resepsi_time" class="form-label">Jam Mulai</label>
                                            <input type="time" id="resepsi_time" name="resepsi_time" placeholder="Contoh: 08:00 - Selesai" value="{{ old('resepsi_time') }}" class="form-control resepsi-time">
                                            <small class="text-muted time-label"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jam Selesai</label>
                                            <input type="time" id="resepsi_time_end" name="resepsi_time_end" value="{{ old('resepsi_time_end') }}" class="form-control time-end">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input sampai-selesai" type="checkbox" id="sampai_selesai">
                                                <label class="form-check-label" for="sampai_selesai" name="sampai_selesai" value="1">
                                                    Sampai Selesai
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="resepsi_maps" class="form-label">Link Maps</label>
                                        <input type="text" id="resepsi_maps" name="resepsi_maps" value="{{ old('resepsi_maps') }}" placeholder="Masukkan link Google Maps" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 7. DATA WANITA --}}
                        <div id="7" class="tab-content d-none">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-person-heart fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Data Mempelai Wanita</h6>
                                </div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label for="bride_name" class="form-label">Nama Mempelai Wanita</label>
                                        <input type="text" id="bride_name" name="bride_name" value="{{ old('bride_name') }}" placeholder="Masukkan nama mempelai wanita" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bride_nickname" class="form-label">Nama Panggilan</label>
                                        <input type="text" id="bride_nickname" name="bride_nickname" value="{{ old('bride_nickname') }}" placeholder="Masukkan nama panggilan mempelai wanita" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bride_father_name" class="form-label">Nama Ayah Kandung</label>
                                        <input type="text" id="bride_father_name" name="bride_father_name" value="{{ old('bride_father_name') }}" placeholder="Masukkan nama lengkap ayah kandung mempelai wanita" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bride_mother_name" class="form-label">Nama Ibu Kandung</label>
                                        <input type="text" id="bride_mother_name" name="bride_mother_name" value="{{ old('bride_mother_name') }}" placeholder="Masukkan nama lengkap ibu kandung mempelai wanita" class="form-control">
                                    </div>
                                    <div class="col-12 mb-6">
                                        <label for="bride_username_instagram" class="form-label">Username</label>
                                        <span>@</span>
                                        <input type="text" id="bride_username_instagram" name="bride_username_instagram" value="{{ old('bride_username_instagram') }}" placeholder="Contoh: gemini.ai" class="form-control insta-username">
                                    </div>
                                    <div class="col-12 mb-6">
                                        <label for="bride_instagram" class="form-label">Link Instagram (Otomatis)</label>
                                        <input type="text" id="bride_instagram" name="bride_instagram" value="{{ old('bride_instagram') }}" placeholder="Akan terisi otomatis..." class="form-control" readonly>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Foto Mempelai Wanita</label>
                                        <div class="upload-zone" id="uploadBoxBrideContainer">
                                            <label id="uploadBoxBride" for="foto_wanita" class="cursor-pointer">
                                                <div class="mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                    </svg>
                                                </div>
                                                <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                <input id="foto_wanita" type="file" name="foto_wanita" class="d-none" onchange="openCropModal(event, 'bride')">
                                            </label>
                                        </div>
                                        <div id="previewContainerBride" class="mt-3 d-none">
                                            <img id="previewBride" class="img-fluid rounded" alt="Preview Foto">
                                            <div class="text-center mt-2">
                                                <button type="button" onclick="removePreview('bride')" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 8. VIDEO & KISAH CINTA --}}
                        <div id="8" class="tab-content d-none">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-play fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Video dan Kisah Cinta</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="wedding_quote_select" class="form-label">Kutipan Pernikahan</label>
                                            <select id="wedding_quote_select" class="form-select" onchange="showQuote()" name="quote_id">
                                                <option value="">-- Pilih Kutipan --</option>
                                                <option value="rum21">QS. Ar-Rum : 21</option>
                                                <option value="nisa1">QS. An-Nisa : 1</option>
                                                <option value="furqan74">QS. Al-Furqan : 74</option>
                                            </select>
                                            <div id="quote_result" class="mt-3 p-3 border rounded" style="display:none;">
                                                <p id="quote_text" class="mb-1 fst-italic"></p>
                                                <strong id="quote_source"></strong>
                                            </div>
                                            <input type="hidden" name="wedding_quote" id="wedding_quote">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="video_link" class="form-label">Link Video Pernikahan</label>
                                            <input type="text" id="video_link" name="video_link" value="{{ old('video_link') }}" placeholder="Masukkan link video YouTube" class="form-control">
                                        </div>
                                        <div class="col-12" id="loveStoryWrapper">
                                            <label class="form-label">Cerita Cinta</label>
                                            <div class="love-story-item border rounded p-3 mb-3">
                                                <input type="text" name="story_title[]" class="form-control mb-2" placeholder="Judul Cerita (contoh: Pertama Bertemu)">
                                                <textarea name="love_story[]" rows="4" class="form-control mb-2" placeholder="Ceritakan perjalanan cinta kalian"></textarea>
                                                <input type="file" name="story_photo[]" class="form-control" accept="image/*">
                                            </div>
                                            <button type="button" class="btn btn-outline-primary mt-2" onclick="addLoveStory()">
                                                + Tambah Cerita
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 9. HADIAH & DONASI --}}
                        <div id="9" class="tab-content d-none">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-gift fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Hadiah dan Donasi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="enable_gift" id="enableGift">
                                        <label class="form-check-label" for="enableGift">
                                            Aktifkan Fitur Hadiah & Donasi
                                        </label>
                                    </div>
                                    <div id="giftTab" class="tab-content d-none">
                                        <div id="giftContainer"></div>
                                        <button type="button" id="addGift" class="btn btn-secondary mb-3">Tambah Gift Lain</button>
                                        <div id="giftTemplate" class="gift-item card p-3 mb-3 d-none position-relative">
                                            <button type="button" class="btn-close position-absolute top-0 end-0 remove-gift" aria-label="Hapus"></button>
                                            <div class="mb-2">
                                                <label class="form-label">Bank / E-Wallet</label>
                                                <select name="bank[]" class="form-select bank-select">
                                                    <option value="">-- Pilih Bank / E-Wallet --</option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="BNI">BNI</option>
                                                    <option value="BRI">BRI</option>
                                                    <option value="Mandiri">Mandiri</option>
                                                    <option value="CIMB">CIMB</option>
                                                    <option value="OVO">OVO</option>
                                                    <option value="GoPay">GoPay</option>
                                                    <option value="Dana">Dana</option>
                                                    <option value="LinkAja">LinkAja</option>
                                                    <option value="ShopeePay">ShopeePay</option>
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Nomor Rekening / HP</label>
                                                <input type="text" name="number[]" class="form-control">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Atas Nama</label>
                                                <input type="text" name="name[]" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="edit-preview-panel">
                <div class="android-frame live-preview-frame">
                    <div class="screen">
                        <iframe id="previewFrame"
                            src=""
                            scrolling="no"
                            loading="lazy"
                            sandbox="allow-scripts allow-same-origin allow-forms"
                            width="100%"
                            height="100%">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- modal Crop --}}
<div class="modal fade" id="cropModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-2" style="height:70vh; overflow:hidden;">
                <img id="cropImage" style="max-width:100%; max-height:100%; display:block; margin:auto;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="cropImage()">
                    Crop & Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Include js-image-compressor -->
<script src="https://unpkg.com/js-image-compressor/dist/image-compressor.js"></script>
<script>
    function compressImage(file, options = {}) {
        return new Promise((resolve, reject) => {
            if (typeof ImageCompressor === 'undefined') {
                reject(new Error('ImageCompressor library not loaded'));
                return;
            }
            const defaultOptions = {
                file: file,
                quality: 0.85,
                mimeType: 'image/webp',
                maxWidth: 1920,
                maxHeight: 1920,
                convertSize: Infinity,
                loose: true,
                redressOrientation: true,
                success: resolve,
                error: reject
            };
            new ImageCompressor(Object.assign(defaultOptions, options));
        });
    }

    async function handleSingleFile(event, type) {
        const file = event.target.files[0];
        if (!file) return;
        try {
            const compressedBlob = await compressImage(file);
            const compressedFile = new File([compressedBlob], file.name.replace(/\.[^/.]+$/, ".webp"), {
                type: "image/webp",
                lastModified: Date.now()
            });
            const reader = new FileReader();
            reader.onload = function(e){
                const preview = document.getElementById(type==='bride'?'previewBride':'previewGroom');
                const container = document.getElementById(type==='bride'?'previewContainerBride':'previewContainerGroom');
                preview.src = e.target.result;
                container.classList.remove('d-none');
            }
            reader.readAsDataURL(compressedFile);
            const dt = new DataTransfer();
            dt.items.add(compressedFile);
            event.target.files = dt.files;
        } catch(err){
            console.error("Compression failed:", err);
        }
    }
</script>

<script>
    let cropper;

    function openCropModal(event, target) {
        const file = event.target.files[0];
        if (!file) return;
        const modalEl = document.getElementById('cropModal');
        modalEl.setAttribute('data-crop-target', target);
        const image = document.getElementById('cropImage');
        image.src = URL.createObjectURL(file);
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    document.getElementById('cropModal').addEventListener('shown.bs.modal', function() {
        if (cropper) cropper.destroy();
        const image = document.getElementById('cropImage');
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            zoomable: true,
            movable: true,
            dragMode: 'move',
            center: true,
        });
        cropper.zoomTo(1);
    });

    function cropImage() {
        if (!cropper) return;
        const submitBtn = document.querySelector('#saveButton');
        if (submitBtn) submitBtn.disabled = true;
        const modalEl = document.getElementById('cropModal');
        const target = modalEl.getAttribute('data-crop-target');
        if (!target) return;
        const canvas = cropper.getCroppedCanvas({
            width: 1080,
            height: 1080
        });
        canvas.toBlob(async (blob) => {
            let file;
            try {
                const compressedBlob = await compressImage(new File([blob], "photo.jpg", { type: "image/jpeg" }));
                file = new File([compressedBlob], "photo.webp", {
                    type: "image/webp",
                    lastModified: Date.now()
                });
            } catch (err) {
                console.error("Crop compression failed, using original:", err);
                file = new File([blob], "photo.jpg", {
                    type: "image/jpeg",
                    lastModified: Date.now()
                });
            }
            let inputEl, previewEl, previewContainerEl, uploadBoxEl;
            if (target === 'groom') {
                inputEl = document.getElementById('foto_pria');
                previewEl = document.getElementById('previewGroom');
                previewContainerEl = document.getElementById('previewContainerGroom');
                uploadBoxEl = document.getElementById('uploadBoxGroom');
            }
            if (target === 'bride') {
                inputEl = document.getElementById('foto_wanita');
                previewEl = document.getElementById('previewBride');
                previewContainerEl = document.getElementById('previewContainerBride');
                uploadBoxEl = document.getElementById('uploadBoxBride');
            }
            try {
                const dt = new DataTransfer();
                dt.items.add(file);
                inputEl.files = dt.files;
            } catch (dtError) {
                console.error('DataTransfer failed:', dtError);
                alert('Gagal mengatur file foto. Silakan coba lagi.');
                if (submitBtn) submitBtn.disabled = false;
                return;
            }
            if (previewEl) previewEl.src = URL.createObjectURL(file);
            if (previewContainerEl) previewContainerEl.classList.remove('d-none');
            if (uploadBoxEl && uploadBoxEl.parentElement) uploadBoxEl.parentElement.classList.add('d-none');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            if (submitBtn) submitBtn.disabled = false;
        }, 'image/jpeg', 0.9);
    }

    function removePreview(target) {
        if (target === 'groom') {
            document.getElementById('previewContainerGroom').classList.add('d-none');
            document.getElementById('uploadBoxGroom').parentElement.classList.remove('d-none');
            document.getElementById('foto_pria').value = '';
        }
        if (target === 'bride') {
            document.getElementById('previewContainerBride').classList.add('d-none');
            document.getElementById('uploadBoxBride').parentElement.classList.remove('d-none');
            document.getElementById('foto_wanita').value = '';
        }
    }

    async function handleGalleryCover(input) {
        const file = input.files[0];
        if (!file) return;
        try {
            const compressedBlob = await compressImage(file);
            const compressedFile = new File([compressedBlob], file.name.replace(/\.[^/.]+$/, ".webp"), {
                type: "image/webp",
                lastModified: Date.now()
            });
            const dt = new DataTransfer();
            dt.items.add(compressedFile);
            input.files = dt.files;
            const preview = document.getElementById('galleryCoverPreview');
            preview.querySelector('img').src = URL.createObjectURL(compressedFile);
            preview.classList.remove('d-none');
        } catch (err) {
            console.error("Gallery cover compression failed:", err);
        }
    }
</script>

<script>
    const usernameInputs = document.querySelectorAll('.insta-username');
    usernameInputs.forEach(input => {
        input.addEventListener('input', function() {
            const role = this.id.includes('groom') ? 'groom' : 'bride';
            const targetLinkInput = document.getElementById(`${role}_instagram`);
            let username = this.value.trim();
            if (username.startsWith('@')) {
                username = username.substring(1);
            }
            if (username) {
                targetLinkInput.value = `https://www.instagram.com/${username}`;
            } else {
                targetLinkInput.value = '';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const enableGift = document.getElementById('enableGift');
        const giftTab = document.getElementById('giftTab');
        enableGift.addEventListener('change', function() {
            if (this.checked) {
                giftTab.classList.remove('d-none');
            } else {
                giftTab.classList.add('d-none');
            }
        });

        const giftContainer = document.getElementById('giftContainer');
        const addGiftBtn = document.getElementById('addGift');
        const template = document.getElementById('giftTemplate');

        function addGift() {
            const clone = template.cloneNode(true);
            clone.classList.remove('d-none');
            clone.removeAttribute('id');
            clone.querySelectorAll('input').forEach(input => input.value = '');
            clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
            giftContainer.appendChild(clone);
            clone.querySelectorAll('.bank-select').forEach(select => {
                new TomSelect(select, {
                    placeholder: 'Cari Bank / E-Wallet...',
                    allowEmptyOption: true,
                    render: {
                        option: function(data, escape) {
                            return `<div class="d-flex align-items-center gap-2"><i class="bi bi-wallet2"></i><span>${escape(data.text)}</span></div>`;
                        },
                        item: function(data, escape) {
                            return `<span><i class="bi bi-wallet2 me-1"></i>${escape(data.text)}</span>`;
                        }
                    }
                });
            });
            attachRemoveEvents();
        }

        function attachRemoveEvents() {
            document.querySelectorAll('.remove-gift').forEach(btn => {
                btn.onclick = function() {
                    if (document.querySelectorAll('.gift-item').length > 1) {
                        this.closest('.gift-item').remove();
                    } else {
                        alert('Harus ada minimal 1 gift!');
                    }
                };
            });
        }

        addGift();
        addGiftBtn.addEventListener('click', addGift);
    });
</script>

<script>
    function addLoveStory() {
        const wrapper = document.getElementById("loveStoryWrapper");
        const div = document.createElement("div");
        div.className = "love-story-item border rounded p-3 mb-3";
        div.innerHTML = `
            <input type="text" name="story_title[]" class="form-control mb-2" placeholder="Judul Cerita (contoh: Lamaran)">
            <textarea name="love_story[]" rows="4" class="form-control mb-2" placeholder="Ceritakan perjalanan cinta kalian"></textarea>
            <input type="file" name="story_photo[]" class="form-control mb-2" accept="image/*">
            <button type="button" class="btn btn-sm btn-danger" onclick="this.parentElement.remove()">
                Hapus Cerita
            </button>
        `;
        wrapper.appendChild(div);
    }
</script>

<script>
    const quotes = {
        rum21: {
            text: "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan untukmu agar kamu merasa tentram.",
            source: "(QS. Ar-Rum : 21)"
        },
        nisa1: {
            text: "Bertakwalah kepada Tuhanmu yang telah menciptakan kamu dari diri yang satu dan darinya Dia menciptakan pasangannya.",
            source: "(QS. An-Nisa : 1)"
        },
        furqan74: {
            text: "Ya Tuhan kami, anugerahkanlah kepada kami pasangan dan keturunan sebagai penyejuk mata.",
            source: "(QS. Al-Furqan : 74)"
        }
    };

    function showQuote() {
        const select = document.getElementById("wedding_quote_select").value;
        const resultBox = document.getElementById("quote_result");
        if (select && quotes[select]) {
            document.getElementById("quote_text").innerText = `"${quotes[select].text}"`;
            document.getElementById("quote_source").innerText = quotes[select].source;
            document.getElementById("wedding_quote").value = `"${quotes[select].text}" ${quotes[select].source}`;
            resultBox.style.display = "block";
        } else {
            resultBox.style.display = "none";
        }
    }
</script>

<script>
    // Main tabs functionality
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content[id]');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.add('d-none'));
            tab.classList.add('active');
            const tabId = tab.dataset.tab;
            document.getElementById(tabId).classList.remove('d-none');
        });
    });

    // Template selection with grid cards
    const templateOptions = document.querySelectorAll('.template-option');
    const androidPreview = document.getElementById('androidPreview');
    const templateIdInput = document.getElementById('template_id');
    const previewFrame = document.getElementById('previewFrame');
    const themeColorPicker = document.getElementById('theme_color_picker');
    const themeColorHidden = document.getElementById('theme_color');
    const themeColorText = document.getElementById('theme_color_text');
    window.currentPreviewUrl = '';

    function getPreviewUrl(slug, id, themeColor) {
        return '/templates/' + slug + '/' + id + '?theme_color=' + encodeURIComponent(themeColor);
    }

    function reloadLivePreview() {
        if (previewFrame && window.currentPreviewUrl) {
            if (themeColorPicker) {
                const baseUrl = window.currentPreviewUrl.split('?')[0];
                const color = themeColorPicker.value;
                previewFrame.src = baseUrl + '?theme_color=' + encodeURIComponent(color) + '&t=' + Date.now();
            } else {
                previewFrame.src = window.currentPreviewUrl + '&t=' + Date.now();
            }
        }
    }

    function showPreviewUpdateIndicator() {
        const existing = document.getElementById('livePreviewUpdateIndicator');
        if (existing) existing.remove();
        const indicator = document.createElement('div');
        indicator.id = 'livePreviewUpdateIndicator';
        indicator.style.cssText = 'position:fixed;bottom:80px;right:20px;padding:8px 16px;border-radius:8px;background:#22c55e;color:#fff;font-size:13px;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);';
        indicator.innerHTML = '<i class="bi bi-check-circle me-1"></i>Preview updated';
        document.body.appendChild(indicator);
        setTimeout(() => { indicator.style.opacity = '0'; setTimeout(() => indicator.remove(), 300); }, 1500);
    }

    if (templateOptions.length > 0) {
        templateOptions.forEach(option => {
            option.addEventListener('click', function() {
                const templateId = this.dataset.templateId;
                const previewImage = this.dataset.preview;
                const templateSlug = this.dataset.slug;
                const templateThemeColor = this.dataset.themeColor;
                if (templateIdInput) templateIdInput.value = templateId;
                if (androidPreview && previewImage) {
                    androidPreview.src = previewImage;
                }
                templateOptions.forEach(o => o.classList.remove('selected-template'));
                this.classList.add('selected-template');
                // Update theme color to template default
                if (templateThemeColor && themeColorPicker) {
                    themeColorPicker.value = templateThemeColor;
                    if (themeColorHidden) themeColorHidden.value = templateThemeColor;
                    if (themeColorText) themeColorText.value = templateThemeColor;
                }
                // Update live preview iframe with template preview URL including theme color
                if (previewFrame && templateSlug) {
                    const currentColor = themeColorPicker ? themeColorPicker.value : '#FF6B81';
                    window.currentPreviewUrl = getPreviewUrl(templateSlug, templateId, currentColor);
                    previewFrame.src = window.currentPreviewUrl;
                }
            });
        });
    }

    if (themeColorPicker) {
        themeColorPicker.addEventListener('input', function() {
            const color = this.value;
            if (themeColorHidden) themeColorHidden.value = color;
            if (themeColorHidden) themeColorHidden.value = color;
            if (themeColorText) themeColorText.value = color;
            // Reload preview iframe with new theme color
            reloadLivePreview();
            showPreviewUpdateIndicator();
        });
    }

    // Gallery functionality
    const dropzone = document.getElementById('gallery-dropzone');
    const fileInput = document.getElementById('gallery-input');
    const preview = document.getElementById('gallery-preview');

    if (dropzone && fileInput && preview) {
        dropzone.addEventListener('click', () => fileInput.click());
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('bg-light');
        });
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('bg-light');
        });
        dropzone.addEventListener('drop', async e => {
            e.preventDefault();
            dropzone.classList.remove('bg-light');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            const compressedFiles = await Promise.all(files.map(f => compressImage(f).then(blob => new File([blob], f.name.replace(/\.[^/.]+$/, ".webp"), { type: "image/webp", lastModified: Date.now() }))));
            const dt = new DataTransfer();
            compressedFiles.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;
            displayPreview(fileInput.files);
        });
        fileInput.addEventListener('change', async () => {
            const files = Array.from(fileInput.files).filter(f => f.type.startsWith('image/'));
            const compressedFiles = await Promise.all(files.map(f => compressImage(f).then(blob => new File([blob], f.name.replace(/\.[^/.]+$/, ".webp"), { type: "image/webp", lastModified: Date.now() }))));
            const dt = new DataTransfer();
            compressedFiles.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;
            displayPreview(fileInput.files);
        });
        function displayPreview(files) {
            preview.innerHTML = '';
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const imgContainer = document.createElement("div");
                    imgContainer.className = 'position-relative';
                    imgContainer.style.width = '100px';
                    imgContainer.style.height = '100px';
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid rounded';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    imgContainer.appendChild(img);
                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                    deleteBtn.style.width = '24px';
                    deleteBtn.style.height = '24px';
                    deleteBtn.style.padding = '0';
                    deleteBtn.style.borderRadius = '50%';
                    deleteBtn.innerHTML = 'Ã—';
                    deleteBtn.onclick = function() {
                        imgContainer.remove();
                    };
                    imgContainer.appendChild(deleteBtn);
                    preview.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // Compress story photos automatically
    document.querySelectorAll('input[name="story_photo[]"]').forEach(input => {
        input.addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file || !file.type.startsWith('image/')) return;
            try {
                const compressedBlob = await compressImage(file);
                const compressedFile = new File([compressedBlob], file.name.replace(/\.[^/.]+$/, ".webp"), {
                    type: "image/webp",
                    lastModified: Date.now()
                });
                const dt = new DataTransfer();
                dt.items.add(compressedFile);
                e.target.files = dt.files;
            } catch (err) {
                console.error("Story photo compression failed:", err);
            }
        });
    });

    // RSVP settings toggle
    const enableRsvp = document.getElementById('enable_rsvp');
    const rsvpSettings = document.getElementById('rsvp_settings');
    if (enableRsvp && rsvpSettings) {
        if (!enableRsvp.checked) {
            rsvpSettings.style.display = 'none';
        }
        enableRsvp.addEventListener('change', () => {
            rsvpSettings.style.display = enableRsvp.checked ? 'block' : 'none';
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.resepsi-time').forEach(function (input) {
            input.addEventListener('input', function () {
                if (!this.value) return;
                const hour = parseInt(this.value.split(':')[0]);
                let label = '';
                let badgeClass = '';
                if (hour >= 5 && hour < 11) {
                    label = 'Pagi';
                    badgeClass = 'bg-warning text-dark';
                } else if (hour >= 11 && hour < 15) {
                    label = 'Siang';
                    badgeClass = 'bg-primary';
                } else if (hour >= 15 && hour < 18) {
                    label = 'Sore';
                    badgeClass = 'bg-info text-dark';
                } else {
                    label = 'Malam';
                    badgeClass = 'bg-dark';
                }
                const timeLabel = this.closest('.col-md-6')?.querySelector('.time-label');
                if (timeLabel) {
                    timeLabel.innerHTML = `<span class="badge ${badgeClass}">${label}</span>`;
                }
            });
        });

        document.querySelectorAll('.sampai-selesai').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const container = this.closest('.col-md-6');
                const endTime = container.querySelector('.time-end');
                if (!endTime) return;
                if (this.checked) {
                    endTime.value = '';
                    endTime.disabled = true;
                } else {
                    endTime.disabled = false;
                }
            });
        });
    });
 </script>

<script>
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    }).then(response => response.json());
                }
            }
        }
        function loadDraft() {
            const draft = localStorage.getItem(STORAGE_KEY);
            if (!draft) return;
            try {
                const data = JSON.parse(draft);
                Object.keys(data).forEach(key => {
                    if (key === '_token' || key === '_method') return;
                    const input = form.querySelector(`[name="${key}"]`);
                    if (!input) return;
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = data[key] === '1' || data[key] === 'on';
                    } else if (input.tagName === 'SELECT') {
                        input.value = data[key];
                    } else {
                        input.value = data[key];
                    }
                });
            } catch (e) {
                console.error('Failed to load draft:', e);
            }
        }
        let autoSaveTimer;
        form.addEventListener('input', (e) => {
            if (e.target.type === 'file') return;
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(saveDraft, 1000);
        });
        form.addEventListener('change', (e) => {
            if (e.target.type === 'file') return;
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(saveDraft, 1000);
        });
        window.addEventListener('beforeunload', saveDraft);
        loadDraft();
    })();
</script>

<script>
    (function() {
        const form = document.getElementById('myForm');
        if (!form) return;
        const saveBtn = document.getElementById('saveButton');
        const originalText = saveBtn ? saveBtn.innerHTML : '';
        function showSaveSuccess() {
            const existing = document.getElementById('saveSuccessIndicator');
            if (existing) existing.remove();
            const indicator = document.createElement('div');
            indicator.id = 'saveSuccessIndicator';
            indicator.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);padding:10px 24px;border-radius:8px;background:#28a745;color:#fff;font-size:14px;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:opacity 0.3s;';
            indicator.innerHTML = '<i class="bi bi-check-circle me-2"></i>Undangan berhasil dibuat';
            document.body.appendChild(indicator);
            setTimeout(() => { indicator.style.opacity = '0'; setTimeout(() => indicator.remove(), 300); }, 2500);
        }
        function showSaveError(message) {
            const existing = document.getElementById('saveErrorIndicator');
            if (existing) existing.remove();
            const indicator = document.createElement('div');
            indicator.id = 'saveErrorIndicator';
            indicator.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);padding:10px 24px;border-radius:8px;background:#dc3545;color:#fff;font-size:14px;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:opacity 0.3s;max-width:400px;text-align:center;';
            indicator.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>' + message;
            document.body.appendChild(indicator);
            setTimeout(() => { indicator.style.opacity = '0'; setTimeout(() => indicator.remove(), 4000); }, 4000);
        }
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (saveBtn) {
                saveBtn.disabled = true;
                saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
            }
            const formData = new FormData(form);
            const actionUrl = form.getAttribute('action');
            fetch(actionUrl, {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            })
            .then(response => {
                return response.json().then(data => ({
                    status: response.status,
                    ok: response.ok,
                    data: data,
                }));
            })
            .then(({ status, ok, data }) => {
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                }
                if (ok && data.success) {
                    showSaveSuccess();
                    if (data.invitation && data.invitation.id) {
                        window.location.href = '/invitation/' + data.invitation.id + '/edit';
                    } else if (data.redirect_to_edit && data.invitation.slug) {
                        window.location.href = '/invitation/' + data.invitation.id + '/edit';
                    }
                } else {
                    let errorMessage = 'Gagal menyimpan data';
                    if (data.message) {
                        errorMessage = data.message;
                    } else if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join(', ');
                    }
                    showSaveError(errorMessage);
                }
            })
            .catch(error => {
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                }
                console.error('Save error:', error);
                showSaveError('Terjadi kesalahan saat menyimpan data');
            });
        });
    })();
</script>

<script>
    (function() {
        const previewFrame = document.getElementById('previewFrame');
        const livePreviewFrame = document.querySelector('.android-frame.live-preview-frame');

        if (!previewFrame || !livePreviewFrame) return;

        previewFrame.scrolling = 'no';

        livePreviewFrame.addEventListener('mouseenter', function() {
            previewFrame.scrolling = 'yes';
        });
        livePreviewFrame.addEventListener('mouseleave', function() {
            previewFrame.scrolling = 'no';
        });
    })();
</script>

<script>
    (function() {
        const previewFrame = document.getElementById('previewFrame');
        if (!previewFrame) return;

        previewFrame.addEventListener('error', function() {
            const existing = document.getElementById('livePreviewError');
            if (existing) existing.remove();
            const el = document.createElement('div');
            el.id = 'livePreviewError';
            el.style.cssText = 'position:fixed;bottom:80px;right:20px;padding:8px 16px;border-radius:8px;background:#ef4444;color:#fff;font-size:13px;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);';
            el.innerHTML = '<i class="bi bi-exclamation-circle me-1"></i>Preview gagal dimuat';
            document.body.appendChild(el);
            setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 300); }, 3000);
        });
    })();
</script>

<div class="sticky-save-btn" id="stickySaveBtn">
    <button type="submit" form="myForm" class="btn btn-primary btn-lg shadow">
        <i class="bi bi-save me-1"></i> Create Invitation
    </button>
</div>

<script>
    const stickyBtn = document.getElementById('stickySaveBtn');
    const formEl = document.getElementById('myForm');

    if (stickyBtn && formEl) {
        const saveBtn = document.getElementById('saveButton');
        const originalText = saveBtn ? saveBtn.innerHTML : '';

        formEl.addEventListener('submit', function() {
            stickyBtn.style.opacity = '0.5';
            stickyBtn.style.pointerEvents = 'none';
        });

        window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            if (scrollTop > 300) {
                stickyBtn.classList.add('visible');
            } else {
                stickyBtn.classList.remove('visible');
            }
        });
    }
</script>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('newInvitationModal');
        if (modalEl) {
            const bsModal = new bootstrap.Modal(modalEl, { backdrop: 'static', keyboard: false });
            bsModal.show();

            document.getElementById('quickCreateForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const groomName = document.getElementById('modal_groom_name').value.trim();
                const brideName = document.getElementById('modal_bride_name').value.trim();
                const groomNickname = document.getElementById('modal_groom_nickname').value.trim();
                const brideNickname = document.getElementById('modal_bride_nickname').value.trim();
                const templateId = document.querySelector('input[name="modal_template_id"]:checked')?.value;

                if (!groomName) { alert('Nama mempelai pria wajib diisi.'); return; }
                if (!brideName) { alert('Nama mempelai wanita wajib diisi.'); return; }
                if (!templateId) { alert('Pilih template undangan.'); return; }

                const btn = this.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Membuat...';

                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                formData.append('groom_name', groomName);
                formData.append('bride_name', brideName);
                formData.append('groom_nickname', groomNickname);
                formData.append('bride_nickname', brideNickname);
                formData.append('template_id', templateId);

                fetch('{{ route('invitation.quick-create') }}', {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    if (data.success && data.invitation && data.invitation.id) {
                        window.location.href = '/invitation/' + data.invitation.id + '/edit';
                    } else if (data.invitation && data.invitation.slug) {
                        window.location.href = '/invitation/' + data.invitation.slug + '/edit';
                    } else {
                        alert(data.message || 'Gagal membuat undangan');
                    }
                })
                .catch(() => {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    alert('Terjadi kesalahan saat menyimpan');
                });
            });
        }
    });
})();
</script>

</x-app-layout>

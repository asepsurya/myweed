<x-app-layout>
<style>
    
        /* --- Layout --- */
        .inner-sidebar-wrap .inner-sidebar { background-color: transparent; }
        .inner-sidebar,
        .inner-sidebar-wrap,
        .inner-sidebar .nav { width: 100%; max-width: 100%; }

        /* --- Mobile Optimizations --- */
        @media (max-width: 991.98px) {
            .edit-form-panel .card {
                margin-bottom: 1rem;
            }

            .edit-form-panel .card-header {
                padding: 12px 16px !important;
            }

            .edit-form-panel .card-body {
                padding: 16px !important;
            }

            .edit-form-panel .row.g-3 {
                row-gap: 1rem;
            }

            .edit-form-panel .form-label {
                font-size: 0.85rem;
                font-weight: 600;
                margin-bottom: 6px;
            }

            .edit-form-panel .form-control {
                padding: 10px 14px;
                font-size: 1rem;
            }

            .edit-form-panel input[type="file"] {
                padding: 8px;
            }

            .edit-layout .row.align-items-center.mb-4 {
                row-gap: 12px;
            }

            .edit-layout .btn-sm {
                padding: 10px 16px;
                font-size: 0.9rem;
            }

            .islami-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
            }

            .upload-zone {
                padding: 24px 16px !important;
                min-height: 120px;
            }

            .upload-zone svg {
                width: 32px;
                height: 32px;
            }

            .gallery-thumb {
                width: 100%;
                max-width: 160px;
            }

            .sticky-save-btn {
                padding: 12px 16px;
            }

            .sticky-save-btn .btn {
                width: 100%;
                padding: 14px;
                font-size: 1rem;
                font-weight: 600;
            }

            /* Add bottom spacing for mobile bottom nav */
            .inner-sidebar-content {
                padding-bottom: 80px;
            }

            /* Hide live preview on mobile */
            .edit-preview-panel,
            .android-frame.live-preview-frame {
                display: none !important;
            }
        }

        @media (max-width: 575.98px) {
            .edit-form-panel .card-body {
                padding: 12px !important;
            }

            .edit-form-panel .row.g-3 {
                row-gap: 0.75rem;
            }

            .edit-form-panel .form-control {
                padding: 12px 14px;
                font-size: 1rem;
            }

            .edit-form-panel .btn-sm {
                padding: 12px 18px;
                font-size: 0.9rem;
            }

            .islami-icon {
                width: 36px;
                height: 36px;
            }

            .upload-zone {
                padding: 20px 12px !important;
                min-height: 100px;
            }
        }

        /* --- Theme Color --- */
        :root { --sidebar-theme-color: {{ $invitation->theme_color ?? '#3b82f6' }}; }

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
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 15%, transparent);
            border-radius: 10px;
            color: var(--sidebar-theme-color);
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
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 10%, transparent);
            color: var(--sidebar-theme-color);
        }

        .inner-sidebar .nav-link.active {
            background-color: var(--sidebar-theme-color);
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
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 20%, transparent);
            color: var(--sidebar-theme-color);
        }
        [data-bs-theme="dark"] .islami-icon {
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 20%, transparent);
            color: var(--sidebar-theme-color);
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
            border-color: var(--sidebar-theme-color);
            background: color-mix(in srgb, var(--sidebar-theme-color) 3%, transparent);
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
       .nav-link {
            cursor: pointer !important;
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

          /* Floating save button for mobile */
          #mobileSaveButton {
              width: 56px;
              height: 56px;
              border-radius: 50%;
              padding: 0;
              display: inline-flex;
              align-items: center;
              justify-content: center;
              background: var(--sidebar-theme-color, #FF6B81) !important;
              border: none;
              color: #fff;
              box-shadow: 0 4px 16px rgba(0,0,0,.25);
              transition: transform .2s ease, box-shadow .2s ease;
              position: fixed;
              bottom: 88px;
              right: 20px;
              z-index: 1050;
          }

          #mobileSaveButton:active {
              transform: scale(.92);
              box-shadow: 0 2px 8px rgba(0,0,0,.3);
          }

          /* Hide red delete buttons on mobile */
          @media (max-width: 575.98px) {
              .gallery-thumb .btn-remove {
                  display: none !important;
              }

              .edit-form-panel .btn-danger,
              .edit-form-panel .btn-close[aria-label="Hapus"] {
                  display: none !important;
              }
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
        </style>
     <style>
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

        /* notch / speaker */
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

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }

        .inner-sidebar-wrap .inner-sidebar-content {
            overflow-y: visible !important;
            height: auto !important;
            max-height: none !important;
            align-self: flex-start;
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,0.2) transparent;
        }

        /* Global thin scrollbar */
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
        .inner-sidebar-wrap .inner-sidebar-content {
            scrollbar-width: thin;
        }

        .inner-sidebar-wrap .inner-sidebar {
            background-color: transparent;
        }

        .inner-sidebar,
        .inner-sidebar-wrap,
        .inner-sidebar .nav {
            width: 100%;
            max-width: 100%;
        }

        :root {
            --sidebar-theme-color: {{ $invitation->theme_color ?? '#3b82f6' }};
        }

        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: auto;
        }

        .sidebar-menu-wrap {
            flex: 0 0 auto;
            overflow-y: visible;
        }

        [data-bs-theme="dark"] .inner-sidebar .nav-link {
            color: #e5e7eb;
        }

        [data-bs-theme="dark"] .inner-sidebar .nav-link:hover {
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 20%, transparent);
            color: var(--sidebar-theme-color);
        }

        [data-bs-theme="dark"] .islami-icon {
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 20%, transparent);
            color: var(--sidebar-theme-color);
        }

        [data-bs-theme="dark"] .inner-sidebar .nav-link.active .islami-icon {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        /* --- CSS UNTUK MEMPERBAIKI UKURAN FOTO --- */

        /* Container agar foto dan tombol delete berada di tengah */
        #previewContainerGroom,
        #previewContainerBride {
            text-align: center;
        }

        /* Style khusus untuk gambar preview agar ukurannya proporsional & profesional */
        #previewGroom,
        #previewBride {
            /* Override class img-fluid agar tidak terlalu lebar */
            width: 100%;
            max-width: 300px;
            /* Batas lebar maksimal */
            height: 400px;
            /* Tinggi tetap agar rapi (Portrait) */
            object-fit: cover;
            /* Agar gambar terpotong rapi tanpa gepeng */
            border-radius: 12px;
            /* Sudut melengkung yang modern */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Bayangan halus */
            margin: 0 auto;
            /* Posisi tengah */
            background-color: #f8f9fa;
            /* Warna background jika gambar transparan/kosong */
            display: block;
        }

        /* Tambahan style lain */
        [data-bs-theme="dark"] .ts-control,
        [data-bs-theme="dark"] .ts-dropdown {
            background-color: #1e1e2d;
            color: #e5e7eb;
            border-color: #374151;
        }

        [data-bs-theme="dark"] .ts-control input {
            color: #e5e7eb;
        }

        [data-bs-theme="dark"] .ts-dropdown {
            box-shadow: 0 10px 25px rgba(0, 0, 0, .6);
        }

        [data-bs-theme="dark"] .ts-dropdown .option {
            color: #e5e7eb;
        }

        [data-bs-theme="dark"] .ts-dropdown .option:hover,
        [data-bs-theme="dark"] .ts-dropdown .option.active {
            background-color: #374151;
            color: #fff;
        }

        [data-bs-theme="dark"] .ts-dropdown .option.selected {
            background-color: #2563eb;
            color: #fff;
        }

        [data-bs-theme="dark"] .ts-control::after {
            border-top-color: #e5e7eb;
        }

        /* Ikon style */
        .islami-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 15%, transparent);
            border-radius: 8px;
            color: var(--sidebar-theme-color);
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
            background-color: color-mix(in srgb, var(--sidebar-theme-color) 10%, transparent);
            color: var(--sidebar-theme-color);
        }

        .inner-sidebar .nav-link.active {
            background-color: var(--sidebar-theme-color);
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



    </style>

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <div class="inner-sidebar-wrap">
        {{-- SIDEBAR MENU --}}
        <div class="inner-sidebar bg-none mb-5 "  >

            <div class="card adminuiux-card ">
                <div class="card-body d-flex flex-column sidebar-sticky">

                    <div class="row mb-3">
                        <div class="col align-self-center">
                            <h6 class="fw-medium">Edit Undangan</h6>
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
                                    <a class="nav-link tab-btn" data-tab="1">
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
        <div class="inner-sidebar-content ">
            <div class="edit-layout">
                <div class="edit-form-panel">
                    <div class="">
                {{-- HEADER --}}
                <form id="myForm" method="POST" action="{{ route('invitation.update', $invitation) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row align-items-center mb-4 gy-3">
                        <!-- Title -->
                       <div class="col-12 col-sm hide-on-mobile">
    <h5 class="mb-0 text-center text-sm-start">
        Edit Undangan
    </h5>
</div>

<style>
    /* Menyembunyikan elemen pada layar mobile (di bawah 768px) dan menampilkannya di desktop */
    @media (max-width: 767.98px) {
        .hide-on-mobile {
            display: none !important;
        }
    }
</style>

                        <!-- Actions -->
                    <div class="col-12 col-sm-auto ms-sm-auto">
                        <div class="d-grid d-sm-flex gap-2">
                            <a href="{{ url($invitation->slug) }}" target="_blank"
                            class="btn btn-outline-primary btn-sm d-none d-sm-inline-flex">
                            Preview Undangan
                            </a>

                            <a href="{{ route('invitation.index') }}"
                            class="btn btn-outline-secondary btn-sm d-none d-sm-inline-flex">
                            Batal
                            </a>

                            <button type="submit"
                                    class="btn btn-primary btn-sm d-none d-sm-inline-flex"
                                    id="saveButton">
                                <i class="bi bi-save me-1"></i>
                                Simpan
                            </button>
                        </div>

                        {{-- Floating save button for mobile --}}
                        <button type="submit"
                                class="btn btn-primary btn-sm rounded-circle d-sm-none"
                                style="width: 56px; height: 56px; z-index: 1050; box-shadow: 0 4px 16px rgba(0,0,0,.2);"
                                id="mobileSaveButton">
                            <i class="bi bi-save fs-5"></i>
                        </button>
                    </div>
                    </div>

                    {{-- 1. MEMPELAI PRIA --}}
                    <div id="1" class="tab-content d-none">
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
                                        <input type="text" id="groom_name" name="groom_name"
                                            value="{{ old('groom_name', $invitation->groom_name) }}"
                                            placeholder="Masukkan nama mempelai pria" class="form-control">
                                    </div>
                                    <input name="invitation_id" value="{{ $invitation->id }}" hidden >

                                    <div class="col-md-6">
                                        <label for="groom_nickname" class="form-label">Nama Panggilan</label>
                                        <input type="text" id="groom_nickname" name="groom_nickname"
                                            value="{{ old('groom_nickname', $invitation->groom_nickname) }}"
                                            placeholder="Masukkan nama panggilan" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="groom_father_name" class="form-label">Nama Ayah Kandung</label>
                                        <input type="text" id="groom_father_name" name="groom_father_name"
                                            value="{{ old('groom_father_name', $invitation->groom_father_name) }}"
                                            placeholder="Masukkan nama lengkap ayah" class="form-control">
                                    </div>
                                        <div class="col-md-6">
                                            <label for="groom_mother_name" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" id="groom_mother_name" name="groom_mother_name" value="{{ old('groom_mother_name', $invitation->groom_mother_name) }}" placeholder="Masukkan nama lengkap ibu" class="form-control">
                                        </div>
                                        <div class="col-12 mb-6">
                                            <label for="groom_username_instagram" class="form-label">Username Instagram</label>
                                            <div class="input-group">
                                                <span class="input-group-text">@</span>
                                                <input type="text" id="groom_username_instagram" name="groom_username_instagram" value="{{ old('groom_username_instagram', $invitation->groom_username_instagram) }}" placeholder="Contoh: gemini.ai" class="form-control insta-username">
                                            </div>
                                        </div>


                                        <div class="col-12 mb-6">
                                            <label for="groom_instagram" class="form-label">Link Instagram (Otomatis)</label>
                                            <input type="text" id="groom_instagram" name="groom_instagram" value="{{ old('groom_instagram',$invitation->groom_instagram) }}" placeholder="Akan terisi otomatis..." class="form-control" readonly>
                                        </div>

                                    <div class="col-12">
                                        <label class="form-label">Foto Mempelai Pria</label>
                                        <input type="hidden" name="remove_foto_pria" id="remove_foto_pria" value="0">

                                        <div id="previewContainerGroom" class="mt-3 mb-3 text-center {{ $invitation->foto_pria ? '' : 'd-none' }}">
                                             <img id="previewGroom" src="{{ $invitation->foto_pria ? '/storage/' . $invitation->foto_pria : '' }}" class="professional-preview rounded" alt="Preview Foto">
                                            <div class="text-center mt-2">
                                                <button type="button" onclick="removePreview('groom')" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>

                                        <div class="border border-dashed p-4 text-center rounded {{ $invitation->foto_pria ? 'd-none' : '' }}" id="uploadBoxGroomContainer">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. TEMA & WARNA --}}
                    <div id="2" class="tab-content active">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pilih Template</label>
                                    <input type="hidden" name="template_id" id="template_id" value="{{ $invitation->template_id }}">
                                    @php
                                        $defaultThemeColors = [
                                            'simple-theme' => '#c8a97e',
                                            'elegant-theme' => '#1A3C34',
                                            'royal-gold' => '#C9A84C',
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
                                            $templateColor = $defaultThemeColors[$template->slug] ?? '#3b82f6';
                                        @endphp
                                        <div class="col-6 col-md-4">
                                            <div class="template-option card cursor-pointer border-2 {{ $invitation->template_id == $template->id ? 'selected-template' : '' }}"
                                                 data-template-id="{{ $template->id }}"
                                                 data-preview="{{ Storage::url($template->preview) }}"
                                                 data-theme-color="{{ $templateColor }}">
                                                <div class="position-relative">
                                                    <img src="{{ Storage::url($template->preview) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                                    @if ($invitation->template_id == $template->id)
                                                    <div class="position-absolute top-0 end-0 bg-primary text-white rounded-circle" style="width: 24px; height: 24px; margin: 4px;">
                                                        <i class="bi bi-check-lg fs-6" style="font-size: 12px;"></i>
                                                    </div>
                                                    @endif
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
                                            <input type="hidden" name="theme_color" id="theme_color" value="{{ $invitation->theme_color ?? '#3b82f6' }}">
                                            <input type="color" id="theme_color_picker" value="{{ $invitation->theme_color ?? '#3b82f6' }}" class="form-control form-control-color" style="width: 60px; height: 40px; padding: 0; border: 1px solid var(--bs-border-color); border-radius: 4px; cursor: pointer; background: {{ $invitation->theme_color ?? '#3b82f6' }};">
                                            <input type="text" id="theme_color_text" class="form-control" style="max-width: 150px;" value="{{ $invitation->theme_color ?? '#3b82f6' }}" readonly>
                                            <span class="text-muted small">Warna tema akan diterapkan ke sidebar dan elemen utama.</span>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="gallery_cover" class="form-label">Cover Galeri</label>
                                    <input type="hidden" name="remove_gallery_cover" id="remove_gallery_cover" value="0">

                                    <div id="existingGalleryCover" class="{{ $invitation->gallery_cover ? '' : 'd-none' }}">
                                        <img src="{{ $invitation->gallery_cover ? '/storage/' . $invitation->gallery_cover : '' }}" class="img-fluid rounded mb-2" style="max-height: 200px; object-fit: cover;" id="existingGalleryCoverImg">
                                        <button type="button" onclick="removeGalleryCover()" class="btn btn-danger btn-sm">Hapus</button>
                                    </div>

                                    <div id="galleryCoverPreview" class="mt-2 d-none">
                                        <img src="" class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                    </div>

                                    <input type="file" id="gallery_cover" name="gallery_cover" accept="image/*" class="form-control mt-2" onchange="handleGalleryCover(this)">
                                </div>


                            </div>
                            
                        </div>
                    </div>
                    <script>
                    window.reloadPreview = function() {
                        const previewFrame = document.getElementById('previewFrame');
                        if (!previewFrame) return;
                        const baseUrl = window.currentPreviewUrl ? window.currentPreviewUrl.split('?')[0] : previewFrame.src.split('?')[0];
                        const themeColor = document.getElementById('theme_color')?.value || '{{ $invitation->theme_color ?? "#3b82f6" }}';
                        previewFrame.src = baseUrl + '?theme_color=' + encodeURIComponent(themeColor) + '&t=' + Date.now();
                    };
                    document.addEventListener('DOMContentLoaded', function () {
                        const preview = document.getElementById('androidPreview');
                        const options = document.querySelectorAll('.template-option');

            function selectTemplate(option) {
                document.getElementById('template_id').value = option.dataset.templateId;

                const image = option.dataset.preview;
                if (image && preview) {
                    preview.src = image;
                }

                options.forEach(o => o.classList.remove('selected-template'));
                option.classList.add('selected-template');

                // Update theme color to template default
                const themeColor = option.dataset.themeColor;
                if (themeColor) {
                    const themeColorPicker = document.getElementById('theme_color_picker');
                    const themeColorHidden = document.getElementById('theme_color');
                    const themeColorText = document.getElementById('theme_color_text');
                    if (themeColorPicker) themeColorPicker.value = themeColor;
                    document.documentElement.style.setProperty('--sidebar-theme-color', themeColor);
                    if (themeColorHidden) themeColorHidden.value = themeColor;
                    if (themeColorText) themeColorText.value = themeColor;
                }

                // Reload live preview with new template
                window.reloadPreview();
            }

                            options.forEach(option => {
                                option.addEventListener('click', function () {
                                    selectTemplate(this);
                                });
                            });

                            const currentlySelected = document.querySelector('.template-option.selected-template');
                            if (currentlySelected && preview) {
                                preview.src = currentlySelected.dataset.preview;
                            }

                            // Theme color picker event handler
                            const themeColorPicker = document.getElementById('theme_color_picker');
                            const themeColorHidden = document.getElementById('theme_color');
                            const themeColorText = document.getElementById('theme_color_text');

                            if (themeColorPicker) {
                                themeColorPicker.addEventListener('input', function() {
                                    const color = this.value;
                                    document.documentElement.style.setProperty('--sidebar-theme-color', color);
                                    if (themeColorHidden) themeColorHidden.value = color;
                                    if (themeColorText) themeColorText.value = color;
// Reload live preview iframe with new theme color
                                     window.reloadPreview();
                                });
                            }
                        });
                    </script>

                    {{-- 3. GALERI FOTO --}}
                    <div id="3" class="tab-content d-none">
                        <div class="card">
                            <div class="card-body">
                                
                          
                        <label for="gallery_cover" class="form-label">Galeri Kisah</label>
                        <div class="">
                            <div class="card">
                                <div id="gallery-dropzone" class="border border-dashed  p-5 text-center rounded cursor-pointer">
                                    <p class="mb-0">Drag & drop gambar di sini atau klik untuk memilih</p>
                                    <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="d-none">
                                </div>
                            </div>
                            <div class="mt-5 ">
                                <label for="" class="mb-3">Preview :</label>
                                <div id="gallery-preview" class="d-flex gap-2 flex-wrap ">
                                    {{-- EXISTING GALLERY --}}
                                    @if($invitation->galleries)
                                        @foreach(json_decode($invitation->galleries) as $image)
                                            <div class="position-relative" id="gallery-item-{{ $image->id }}" style="width: 100px; height: 100px;">
                                                 <img src="{{ $image->image ? '/storage/' . $image->image : '' }}" class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button"
                                                        class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                        style="width: 24px; height: 24px; padding: 0; border-radius: 50%;"
                                                        onclick="deleteGallery({{ $image->id }})">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                          </div>
                        </div>
                    </div>

                    {{-- 4. MUSIK --}}
                    <div id="4" class="tab-content d-none">
                        <div class="card">
                            <div class="card-body">
                           
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Sumber Musik</label>
                            <div class="d-flex gap-3 mb-3" role="radiogroup">
                                <div class="form-check form-check-inline me-3">
                                    <input class="form-check-input music-source-radio" type="radio"
                                           name="music_source" value="internal"
                                           id="musicSourceInternal"
                                           {{ (empty($invitation->music_youtube_url) && $invitation->music) ? 'checked' : (empty($invitation->music_youtube_url) ? 'checked' : '') }}>
                                    <label class="form-check-label" for="musicSourceInternal">
                                        <i class="bi bi-music-note-beamed me-1"></i>Perpustakaan / Upload
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input music-source-radio" type="radio"
                                           name="music_source" value="youtube"
                                           id="musicSourceYoutube"
                                           {{ !empty($invitation->music_youtube_url) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="musicSourceYoutube">
                                        <i class="bi bi-youtube me-1 text-danger"></i>Dari YouTube
                                    </label>
                                </div>
                            </div>

                            {{-- Internal Music (preset + upload) --}}
                            <div id="musicInternalOptions" class="music-source-options">
                                <div class="mb-3">
                                    <label for="music_id" class="form-label">Pilih Lagu Background</label>
                                    <select id="music_id" name="music_id" class="form-select">
                                        <option value="">-- Pilih Lagu --</option>
                                        @if(isset($music))
                                        @foreach ($music as $musicItem)
                                        <option value="{{ $musicItem->id }}"
                                            {{ $invitation->music == $musicItem->id ? 'selected' : '' }}
                                            data-audio="{{ asset('storage/' . $musicItem->audio_url) }}">
                                            {{ $musicItem->title }}
                                        </option>
                                        @endforeach
                                        @endif
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
                                        });
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

                            {{-- YouTube Music --}}
                            <div id="musicYoutubeOptions" class="music-source-options" style="display:none;">
                                <div class="mb-3">
                                    <label for="music_youtube_url" class="form-label">Link Video YouTube</label>
                                    <input type="url" id="music_youtube_url" name="music_youtube_url"
                                           class="form-control"
                                           placeholder="https://www.youtube.com/watch?v=..."
                                           value="{{ $invitation->music_youtube_url ?? '' }}">
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
                             
                            </div>
                        </div>
                        <script>
                            // Toggle source options
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

                            // YouTube URL parsing
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

                                // Init
                                const initialValue = youtubeInput.value.trim();
                                if (initialValue) {
                                    const videoId = extractYoutubeVideoId(initialValue);
                                    if (videoId) {
                                        youtubeVideoIdSpan.textContent = 'Video ID: ' + videoId;
                                        youtubePreview.classList.remove('d-none');
                                    }
                                }
                            }
                        </script>
                    </div>

                    {{-- 5. RSVP --}}
                    <div id="5" class="tab-content d-none">
                        <div class="card">
                            <div class="card-body">

                           
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="enable_rsvp" name="enable_rsvp"
                                    {{ $invitation->enable_rsvp ? 'checked' : '' }}>
                                <label class="form-check-label" for="enable_rsvp">
                                    Aktifkan RSVP
                                </label>
                            </div>
                        </div>

                        <div id="rsvp_settings" style="{{ $invitation->enable_rsvp ? '' : 'display:none' }}">
                            <div class="mb-3">
                                <label for="rsvp_deadline" class="form-label">Batas Tanggal RSVP</label>
                                <input type="date" name="rsvp_deadline"
                                    value="{{ old('rsvp_deadline', $invitation->rsvp_deadline) }}"
                                    class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="rsvp_message" class="form-label">Pesan Konfirmasi</label>
                                <textarea name="rsvp_message" rows="4"
                                    placeholder="Terima kasih atas konfirmasi kehadiran Anda. Kami sangat menantikan kehadiran Anda di hari bahagia kami."
                                    class="form-control">{{ old('rsvp_message', $invitation->rsvp_message) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="rsvp_whatsapp" class="form-label">Nomor WhatsApp untuk Notifikasi</label>
                                <input type="text" name="rsvp_whatsapp"
                                    value="{{ old('rsvp_whatsapp', $invitation->rsvp_whatsapp) }}"
                                    placeholder="6281234567890" class="form-control">
                            </div>
                        </div>
                         </div>
                        </div>
                    </div>

                    {{-- 6. TEMPAT --}}
                    <div id="6" class="tab-content d-none">
                        {{-- DATE CARD --}}
                        <div class="card mb-3">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-calendar-event fs-5"></i>
                                </div>
                                <h6 class="mb-0">Tanggal Pernikahan</h6>
                            </div>
                            <div class="card-body ">
                                <div class="">
                                    <label for="wedding_date" class="form-label">Tanggal</label>
                                    <input type="date" id="wedding_date" name="wedding_date"
                                        value="{{ old('wedding_date', $invitation->wedding_date) }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- AKAD CARD --}}
                        <div class="card mb-4">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-moon-stars fs-5"></i>
                                </div>
                                <h6 class="mb-0">Tempat Akad</h6>
                            </div>
                            <div class="card-body row g-3">
                                <div class="col-12">
                                    <label for="akad_location" class="form-label">Nama Tempat atau Titik Lokasi</label>
                                    <input type="text" id="akad_location" name="akad_location"
                                        value="{{ old('akad_location', $invitation->akad_location) }}"
                                        placeholder="Contoh : Mesjid Al-Jabar" class="form-control">

                                </div>

                                <div class="col-12">
                                    <label for="akad_address" class="form-label">Alamat Akad</label>
                                    <input type="text" id="akad_address" name="akad_address"
                                        value="{{ old('akad_address', $invitation->akad_address) }}"
                                        placeholder="Contoh : Jalan Pancasila No.41 " class="form-control">
                                </div>

                                    <div class=" row g-3">
                                        <div class="col-md-6">
                                            <label for="akad_time" class="form-label">Jam Mulai</label>
                                            <input type="time" id="akad_time" name="akad_time" placeholder="Contoh: 08:00 - Selesai" value="{{ old('akad_time', $invitation->akad_time) }}" class="form-control resepsi-time">
                                            <small class="text-muted time-label"></small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Jam Selesai</label>
                                            <input type="time" name="akad_time_end" class="form-control time-end"  value="{{ old('akad_time_end', $invitation->akad_time_end) }}">
                                        </div>
                                    </div>




                                <div class="col-12">
                                    <label for="akad_maps" class="form-label">Link Maps</label>
                                    <input type="text" id="akad_maps" name="akad_maps"
                                        value="{{ old('akad_maps', $invitation->akad_maps) }}"
                                        placeholder="Masukkan link Google Maps" class="form-control"
                                        oninput="updateMapPreview('akad_maps', 'akad_map_preview')">
                                    <div id="akad_map_preview" class="mt-2 d-none">
                                        <iframe id="akad_map_iframe" width="100%" height="200" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RESEPSI CARD --}}
                        <div class="card mb-4">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-geo-alt fs-5"></i>
                                </div>
                                <h6 class="mb-0">Tempat Resepsi</h6>
                            </div>
                            <div class="card-body row g-3">
                                <div class="col-12">
                                    <label for="resepsi_location" class="form-label">Nama Tempat atau Titik Lokasi</label>
                                    <input type="text" id="resepsi_location" name="resepsi_location"
                                        value="{{ old('resepsi_location', $invitation->resepsi_location) }}"
                                        placeholder="Contoh : Gedung Mawar Putih" class="form-control">
                                </div>

                                <div class="col-12">
                                    <label for="resepsi_address" class="form-label">Alamat Resepsi</label>
                                    <input type="text" id="resepsi_address" name="resepsi_address"
                                        value="{{ old('resepsi_address',$invitation->resepsi_address) }}"
                                        placeholder="Contoh : Jalan Pancasila No.41 " class="form-control">
                                </div>
                                <div class=" row g-3">
                                    <div class="col-md-6">
                                        <label for="resepsi_time" class="form-label">Jam Mulai</label>
                                        <input type="time" id="resepsi_time" name="resepsi_time" placeholder="Contoh: 08:00 - Selesai"
                                            value="{{ old('resepsi_time', $invitation->resepsi_time) }}"
                                            class="form-control resepsi-time">
                                            <small class="text-muted time-label"></small>
                                    </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Jam Selesai</label>
                                    <input type="time" id="resepsi_time_end" name="resepsi_time_end" class="form-control time-end"    @if(old('resepsi_time_end', $invitation->resepsi_time_end) === 'Selesai') disabled @endif>

                                    <div class="form-check mt-2">
                                        <input class="form-check-input sampai-selesai" type="checkbox" name="sampai_selesai" value="1"  @if(old('resepsi_time_end', $invitation->resepsi_time_end) === 'Selesai') checked @endif>
                                        <label class="form-check-label" for="sampai_selesai">
                                            Sampai Selesai
                                        </label>
                                    </div>
                                </div>

                                </div>
                                <div class="col-12">
                                    <label for="resepsi_maps" class="form-label">Link Maps</label>
                                    <input type="text" id="resepsi_maps" name="resepsi_maps"
                                        value="{{ old('resepsi_maps', $invitation->resepsi_maps) }}"
                                        placeholder="Masukkan link Google Maps" class="form-control"
                                        oninput="updateMapPreview('resepsi_maps', 'resepsi_map_preview')">
                                    <div id="resepsi_map_preview" class="mt-2 d-none">
                                        <iframe id="resepsi_map_iframe" width="100%" height="200" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
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
                                    <input type="text" id="bride_name" name="bride_name"
                                        value="{{ old('bride_name', $invitation->bride_name) }}"
                                        placeholder="Masukkan nama mempelai wanita" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="bride_nickname" class="form-label">Nama Panggilan</label>
                                    <input type="text" id="bride_nickname" name="bride_nickname"
                                        value="{{ old('bride_nickname', $invitation->bride_nickname) }}"
                                        placeholder="Masukkan nama panggilan mempelai wanita" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="bride_father_name" class="form-label">Nama Ayah Kandung</label>
                                    <input type="text" id="bride_father_name" name="bride_father_name"
                                        value="{{ old('bride_father_name', $invitation->bride_father_name) }}"
                                        placeholder="Masukkan nama lengkap ayah kandung mempelai wanita" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="bride_mother_name" class="form-label">Nama Ibu Kandung</label>
                                    <input type="text" id="bride_mother_name" name="bride_mother_name"
                                        value="{{ old('bride_mother_name', $invitation->bride_mother_name) }}"
                                        placeholder="Masukkan nama lengkap ibu kandung mempelai wanita" class="form-control">
                                </div>
                                <div class="col-12 mb-6">
                                    <label for="bride_username_instagram" class="form-label">Username Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text">@</span>
                                        <input type="text" id="bride_username_instagram" name="bride_username_instagram"
                                            value="{{ old('bride_username_instagram',$invitation->bride_username_instagram) }}"
                                            placeholder="Contoh: gemini.ai" class="form-control insta-username">
                                    </div>
                                </div>

                                <div class="col-12 mb-6">
                                    <label for="bride_instagram" class="form-label">Link Instagram (Otomatis)</label>
                                    <input type="text" id="bride_instagram" name="bride_instagram"
                                        value="{{ old('bride_instagram',$invitation->bride_instagram) }}"
                                        placeholder="Akan terisi otomatis..." class="form-control" readonly>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Foto Mempelai Wanita</label>
                                    <input type="hidden" name="remove_foto_wanita" id="remove_foto_wanita" value="0">

                                    <div id="previewContainerBride" class="mt-3 mb-3 text-center {{ $invitation->foto_wanita ? '' : 'd-none' }}">
                                         <img id="previewBride" src="{{ $invitation->foto_wanita ? '/storage/' . $invitation->foto_wanita : '' }}" class="professional-preview rounded" alt="Preview Foto">
                                        <div class="text-center mt-2">
                                            <button type="button" onclick="removePreview('bride')" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>

                                    <div class="border border-dashed p-4 text-center rounded {{ $invitation->foto_wanita ? 'd-none' : '' }}" id="uploadBoxBrideContainer">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 8. LAINNYA (VIDEO & KISAH) --}}
                    <div id="8" class="tab-content d-none">
                        <div class="card">
                            <div class="card-body">
                        <div id="other">
                            <div class="row g-3">
                                {{-- QUOTE --}}
                                <div class="col-md-6">
                                    <label for="wedding_quote_select" class="form-label">Kutipan Pernikahan</label>
                                    <select id="wedding_quote_select" class="form-select" onchange="showQuote()" name="quote_id">
                                        <option value="">-- Pilih Kutipan --</option>
                                        <option value="rum21" {{ $invitation->quote_id == 'rum21' ? 'selected' : '' }}>QS. Ar-Rum : 21</option>
                                        <option value="nisa1" {{ $invitation->quote_id == 'nisa1' ? 'selected' : '' }}>QS. An-Nisa : 1</option>
                                        <option value="furqan74" {{ $invitation->quote_id == 'furqan74' ? 'selected' : '' }}>QS. Al-Furqan : 74</option>
                                    </select>

                                    <!-- Tampilan hasil kutipan -->
                                    <div id="quote_result" class="mt-3 p-3 border rounded" >
                                        <p id="quote_text" class="mb-1 fst-italic">{{ $invitation->wedding_quote }}</p>
                                        <strong id="quote_source"></strong>
                                    </div>

                                    <!-- Hidden input untuk submit custom text jika perlu -->
                                    <input type="hidden" name="wedding_quote" id="wedding_quote" value="{{ old('wedding_quote', $invitation->wedding_quote) }}">
                                </div>

                                {{-- VIDEO --}}
                                <div class="col-md-6">
                                    <label for="video_link" class="form-label">Link Video Pernikahan</label>
                                    <input type="text" id="video_link" name="video_link"
                                        value="{{ old('video_link', $invitation->video_link) }}"
                                        placeholder="Masukkan link video YouTube" class="form-control">
                                </div>

                                <div class="col-12" id="loveStoryWrapper">
                                    <label  class="form-label">Kisah Cinta</label>
                                    @forelse($invitation->love_story ?? [] as $index => $story)
                                    <div class="love-story-item border rounded p-3 mb-3">

                                        <input type="hidden" name="story_id[]" value="{{ $index }}">

                                        <input type="text" name="story_title[]" class="form-control mb-2" placeholder="Judul Cerita" value="{{ old('story_title.'.$index, $story['title'] ?? '') }}">

                                        <textarea name="love_story[]" rows="4" class="form-control mb-2" placeholder="Ceritakan perjalanan cinta kalian">{{ old('love_story.'.$index, $story['story'] ?? '') }}</textarea>

                                        @if(!empty($story['photo']))
                                        <div class="mb-2">
                                             <img src="{{ $story['photo'] ? '/storage/'.$story['photo'] : '' }}" class="img-fluid rounded mb-2" style="max-height:150px;object-fit:cover;">
                                        </div>
                                        @endif

                                        <input type="file" name="story_photo[]" class="form-control mb-2" accept="image/*">

                                        <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.love-story-item').remove()">
                                            Hapus Cerita
                                        </button>

                                    </div>
                                    @empty
                                    <div class="love-story-item border rounded p-3 mb-3">
                                        <input type="hidden" name="story_id[]" value="">
                                        <input type="text" name="story_title[]" class="form-control mb-2" placeholder="Judul Cerita">
                                        <textarea name="love_story[]" rows="4" class="form-control mb-2"></textarea>
                                        <input type="file" name="story_photo[]" class="form-control">
                                    </div>
                                    @endforelse
                                    <button type="button" class="btn btn-outline-primary mt-2" onclick="addLoveStory()">
                                        + Tambah Cerita
                                    </button>

                                    </div>
                            </div>
                        </div>
                        </div>
                        </div>
                    </div>

                    {{-- 9. GIFT / DONASI --}}
                    <div id="9" class="tab-content d-none">
                        <div class="card">
                            <div class="card-body">

                         
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" name="enable_gift" id="enableGift" {{ isset($invitation->enable_gift) && $invitation->enable_gift ? 'checked' : '' }}>
                            <label class="form-check-label" for="enableGift">
                                Aktifkan Fitur Hadiah & Donasi
                            </label>
                        </div>

                        <div id="giftTab" class="{{ isset($invitation->enable_gift) && $invitation->enable_gift == 1 ? '' : 'd-none' }}">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-gift-fill fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Data Hadiah & Donasi</h6>
                                </div>
                                <div class="card-body">
                                    <div id="giftContainer">

                                        {{-- Load existing gifts if stored as JSON in a single field or similar. Assuming 'gifts' relation or JSON field --}}
                                        {{-- Since Code B implies dynamic input, we will render the inputs based on available data or empty if new --}}
                                        @if(json_decode($invitation->gifts ?? '[]'))
                                            @foreach(json_decode($invitation->gifts) as $g)
                                            <div class="gift-item card p-3 mb-3 position-relative ">
                                                <a href="javascript:void(0)"
                                                class="p-3 btn-close position-absolute top-0 end-0 remove-gift"
                                                data-id="{{ $g->id }}"
                                                aria-label="Hapus">
                                                </a>

                                                <div class="mb-2">
                                                    <label class="form-label">Bank / E-Wallet</label>
                                                    <select name="bank[]" class="form-select bank-select">
                                                        <option value="">-- Pilih Bank / E-Wallet --</option>
                                                        <option value="BCA" {{ $g->bank == 'BCA' ? 'selected' : '' }}>BCA</option>
                                                        <option value="BNI" {{ $g->bank == 'BNI' ? 'selected' : '' }}>BNI</option>
                                                        <option value="BRI" {{ $g->bank == 'BRI' ? 'selected' : '' }}>BRI</option>
                                                        <option value="Mandiri" {{ $g->bank == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                        <option value="CIMB" {{ $g->bank == 'CIMB' ? 'selected' : '' }}>CIMB</option>
                                                        <option value="OVO" {{ $g->bank == 'OVO' ? 'selected' : '' }}>OVO</option>
                                                        <option value="GoPay" {{ $g->bank == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                                        <option value="Dana" {{ $g->bank == 'Dana' ? 'selected' : '' }}>Dana</option>
                                                        <option value="LinkAja" {{ $g->bank == 'LinkAja' ? 'selected' : '' }}>LinkAja</option>
                                                        <option value="ShopeePay" {{ $g->bank == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Nomor Rekening / HP</label>
                                                    <input type="text" name="number[]" class="form-control" value="{{ $g->number ?? '' }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Atas Nama</label>
                                                    <input type="text" name="name[]" class="form-control" value="{{ $g->name ?? '' }}">
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" id="addGift" class="btn btn-secondary mb-3">Tambah Gift Lain</button>

                                    <!-- Template Gift (hidden) -->
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
                        </div>
                    </div>

                </form>
            </div>
            </div>
            <div class="edit-preview-panel">
                    <div class="android-frame live-preview-frame">
                        <div class="screen">
                            <iframe id="previewFrame"
                                src="{{ url($invitation->slug) }}"
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
    </script>
    <!-- SCRIPTS -->
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
                    aspectRatio: 1
                    , viewMode: 1, // gambar dipaksa stay di dalam modal
                    autoCropArea: 1, // crop box langsung besar
                    responsive: true
                    , zoomable: true
                    , movable: true
                    , dragMode: 'move'
                    , center: true
                , });

                // Force gambar agar penuh
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
                    width: 1080
                    , height: 1080
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
                        document.getElementById('remove_foto_pria').value = '0';
                        previewEl = document.getElementById('previewGroom');
                        previewContainerEl = document.getElementById('previewContainerGroom');
                        uploadBoxEl = document.getElementById('uploadBoxGroom');
                    }

                    if (target === 'bride') {
                        inputEl = document.getElementById('foto_wanita');
                        document.getElementById('remove_foto_wanita').value = '0';
                        previewEl = document.getElementById('previewBride');
                        previewContainerEl = document.getElementById('previewContainerBride');
                        uploadBoxEl = document.getElementById('uploadBoxBride');
                    }

                    try {
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        inputEl.files = dt.files;
                    } catch (dtError) {
                        console.error('DataTransfer failed, trying fallback:', dtError);
                        try {
                            const fallbackInput = document.createElement('input');
                            fallbackInput.type = 'file';
                            fallbackInput.name = inputEl.name;
                            fallbackInput.id = inputEl.id;
                            fallbackInput.className = inputEl.className;
                            fallbackInput.style.display = 'none';
                            fallbackInput.onchange = inputEl.onchange;
                            const parent = inputEl.parentNode;
                            parent.replaceChild(fallbackInput, inputEl);
                            const dt = new DataTransfer();
                            dt.items.add(file);
                            fallbackInput.files = dt.files;
                            if (target === 'groom') {
                                inputEl = document.getElementById('foto_pria');
                            } else {
                                inputEl = document.getElementById('foto_wanita');
                            }
                        } catch (fallbackError) {
                            console.error('All file-setting methods failed:', fallbackError);
                            alert('Gagal mengatur file foto. Silakan coba lagi.');
                            if (submitBtn) submitBtn.disabled = false;
                            return;
                        }
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
                    document.getElementById('remove_foto_pria').value = '1';
                }

                if (target === 'bride') {
                    document.getElementById('previewContainerBride').classList.add('d-none');
                    document.getElementById('uploadBoxBride').parentElement.classList.remove('d-none');
                    document.getElementById('foto_wanita').value = '';
                    document.getElementById('remove_foto_wanita').value = '1';
                }
            }

            async function handleGalleryCover(input) {
                const file = input.files[0];
                if (!file) return;

                document.getElementById('existingGalleryCover')?.classList.add('d-none');

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

            function removeGalleryCover() {
                document.getElementById('remove_gallery_cover').value = '1';
                document.getElementById('existingGalleryCover').classList.add('d-none');
                document.getElementById('gallery_cover').value = '';
            }

        </script>

<script>
    // Ambil semua element yang memiliki class insta-username
    const usernameInputs = document.querySelectorAll('.insta-username');

    usernameInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Cek apakah ini milik groom atau bride berdasarkan ID
            const role = this.id.includes('groom') ? 'groom' : 'bride';
            const targetLinkInput = document.getElementById(`${role}_instagram`);

            let username = this.value.trim();

            // Hapus karakter @ jika ada
            if (username.startsWith('@')) {
                username = username.substring(1);
            }

            // Update value link instagram
            if (username) {
                targetLinkInput.value = `https://www.instagram.com/${username}`;
            } else {
                targetLinkInput.value = '';
window.currentPreviewUrl = previewFrame.src;
                             }
                         });
                     </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                const enableGift = document.getElementById('enableGift');
    const giftTab = document.getElementById('giftTab');

    // 🔥 INIT STATE DARI DATABASE
    if (enableGift && enableGift.checked) {
        giftTab.classList.remove('d-none');
    }

    if(enableGift){
        enableGift.addEventListener('change', function() {
            if (this.checked) {
                giftTab.classList.remove('d-none');
            } else {
                giftTab.classList.add('d-none');
            }
        });
    }

            // --- GIFT LOGIC ---
            const giftContainer = document.getElementById('giftContainer');
            const addGiftBtn = document.getElementById('addGift');
            const template = document.getElementById('giftTemplate');

            function addGift() {
                // clone template hidden
                const clone = template.cloneNode(true);
                clone.classList.remove('d-none');
                clone.removeAttribute('id');

                // reset input/select
                clone.querySelectorAll('input').forEach(input => input.value = '');
                clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

                giftContainer.appendChild(clone);

                // init Tom Select hanya pada select baru
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
                            // Biarkan user hapus jika kosong, atau alert jika perlu minimal 1
                            // Sesuai request user, tidak ada validasi minimal
                            this.closest('.gift-item').remove();
                        }
                    };
                });
            }

            // Init TomSelect untuk existing gifts
            document.querySelectorAll('#giftContainer .bank-select').forEach(select => {
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

            if(addGiftBtn) addGiftBtn.addEventListener('click', addGift);

            // --- ANDROID PREVIEW UPDATE ---
            const templateSelect = document.getElementById('template_id');
            const androidPreview = document.getElementById('androidPreview');

            if (templateSelect && androidPreview) {
                templateSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    androidPreview.src = selectedOption.dataset.image;
                });
            }
        });

        function addLoveStory() {
            const wrapper = document.getElementById("loveStoryWrapper");

            const div = document.createElement("div");
            div.className = "love-story-item border rounded p-3 mb-3";

            div.innerHTML = `
                <input type="text" name="story_title[]" class="form-control mb-2"
                    placeholder="Judul Cerita (contoh: Lamaran)">
                <textarea name="love_story[]" rows="4" class="form-control mb-2"
                    placeholder="Ceritakan perjalanan cinta kalian"></textarea>
                <input type="file" name="story_photo[]" class="form-control mb-2"
                    accept="image/*">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="this.parentElement.remove()">
                    Hapus Cerita
                </button>
            `;

            wrapper.appendChild(div);
        }

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
            const hiddenInput = document.getElementById("wedding_quote");

            if (select && quotes[select]) {
                document.getElementById("quote_text").innerText = `"${quotes[select].text}"`;
                document.getElementById("quote_source").innerText = quotes[select].source;

                if(hiddenInput) {
                    hiddenInput.value = `"${quotes[select].text}" ${quotes[select].source}`;
                }

                resultBox.style.display = "block";
            } else {
                resultBox.style.display = "none";
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            const savedQuote = document.getElementById("wedding_quote")?.value || '';
            const select = document.getElementById("wedding_quote_select");

            if (!savedQuote) return;

            Object.entries(quotes).forEach(([key, quote]) => {
                if (savedQuote.includes(quote.text) || savedQuote.includes(quote.source)) {
                    select.value = key;
                    showQuote();
                }
            });
        });
        // --- TABS LOGIC ---
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content[id]');
        const TAB_STORAGE_KEY = 'invitation_edit_active_tab_{{ $invitation->id }}';

        function switchTab(tabEl) {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => {
                c.classList.add('d-none');
                c.classList.remove('active');
            });

            tabEl.classList.add('active');
            const tabId = tabEl.dataset.tab;
            const content = document.getElementById(tabId);
            if (content) {
                content.classList.remove('d-none');
                content.classList.add('active');
                localStorage.setItem(TAB_STORAGE_KEY, tabId);
            }
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => switchTab(tab));
        });

        const savedTabId = localStorage.getItem(TAB_STORAGE_KEY);
        const defaultTabId = document.querySelector('.tab-btn.active')?.dataset?.tab || '2';
        const initialTabId = savedTabId || defaultTabId;

        const initialTab = document.querySelector(`.tab-btn[data-tab="${initialTabId}"]`);
        if (initialTab) {
            switchTab(initialTab);
        }

        // --- GALLERY LOGIC ---
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
                // Tidak kita reset innerHTML karena ada existing images
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

                        // Add delete button
                        const deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                        deleteBtn.style.width = '24px';
                        deleteBtn.style.height = '24px';
                        deleteBtn.style.padding = '0';
                        deleteBtn.style.borderRadius = '50%';
                        deleteBtn.innerHTML = '×';
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

        // --- RSVP LOGIC ---
        const enableRsvp = document.getElementById('enable_rsvp');
        const rsvpSettings = document.getElementById('rsvp_settings');

        if (enableRsvp && rsvpSettings) {
            enableRsvp.addEventListener('change', () => {
                rsvpSettings.style.display = enableRsvp.checked ? 'block' : 'none';
            });
        }

         // --- AUDIO PLAYER LOGIC ---
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

        // --- DELETE GALLERY FUNCTION ---
        function deleteGallery(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this filr?\nThis action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,

                confirmButtonText: 'Delete file',
                cancelButtonText: 'Cancel',

                buttonsStyling: false,

                customClass: {
                    popup: 'custom-swal-popup',
                    title: 'custom-swal-title',
                    htmlContainer: 'custom-swal-text',
                    confirmButton: 'custom-swal-confirm',
                    cancelButton: 'custom-swal-cancel'
                }

            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/gallery/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`gallery-item-${id}`).remove();

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Folder berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        }

    </script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // =============================
    // JAM MULAI → BADGE PAGI / SIANG / SORE / MALAM
    // =============================
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
                timeLabel.innerHTML = `
                    <span class="badge ${badgeClass}">
                        ${label}
                    </span>
                `;
            }
        });
    });

    // =============================
    // JAM SELESAI → SAMPAI SELESAI
    // =============================
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
});

</script>

<script>
document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('remove-gift')) return;

    const button = e.target;
    const giftId = button.dataset.id;

    Swal.fire({
        title: 'Hapus Gift?',
        text: 'Data yang dihapus tidak bisa dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33'
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch(`/gifts/${giftId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(() => {
            Swal.fire('Terhapus!', 'Gift berhasil dihapus', 'success');

            const item = button.closest('.gift-item');
            item.style.transition = '0.3s';
            item.style.opacity = 0;
            setTimeout(() => item.remove(), 300);
        })
        .catch(() => {
            Swal.fire('Error', 'Gagal menghapus gift', 'error');
        });
    });
});
</script>

    <script>
        (function() {
            const form = document.getElementById('myForm');
            if (!form) return;

            const saveBtn = document.getElementById('saveButton');
    </script>

    <script>
        (function() {
            const form = document.getElementById('myForm');
            if (!form) return;

            const saveBtn = document.getElementById('saveButton');
            const originalText = saveBtn ? saveBtn.innerHTML : '';

            // Real-time preview update on form field changes
            let previewUpdateTimer;
            form.addEventListener('input', function(e) {
                if (e.target.type === 'file') return;
                clearTimeout(previewUpdateTimer);
                previewUpdateTimer = setTimeout(function() {
                    window.reloadPreview();
                }, 1200);
            });

            form.addEventListener('change', function(e) {
                if (e.target.type === 'file') return;
                window.reloadPreview();
            });

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
                        const indicator = document.createElement('div');
                        indicator.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);padding:10px 24px;border-radius:8px;background:#28a745;color:#fff;font-size:14px;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:opacity 0.3s;';
                        indicator.innerHTML = '<i class="bi bi-check-circle me-2"></i>Undangan berhasil disimpan';
                        document.body.appendChild(indicator);
                        setTimeout(() => { indicator.style.opacity = '0'; setTimeout(() => indicator.remove(), 300); }, 2500);

const previewFrame = document.getElementById('previewFrame');
                         if (previewFrame) {
                             window.reloadPreview();
                         }

                        if (data.invitation && data.invitation.slug) {
                            const newSlug = data.invitation.slug;
                            const currentSlug = window.location.pathname.split('/').pop();
                            if (newSlug !== currentSlug) {
                                window.history.replaceState(null, '', '/' + newSlug);
                            }
                        }
                    } else {
                        let errorMessage = 'Gagal menyimpan data';
                        if (data.message) {
                            errorMessage = data.message;
                        } else if (data.errors) {
                            errorMessage = Object.values(data.errors).flat().join(', ');
                        }
                        const errorIndicator = document.createElement('div');
                        errorIndicator.style.cssText = 'position:fixed;bottom:20px;left:50%;transform:translateX(-50%);padding:10px 24px;border-radius:8px;background:#dc3545;color:#fff;font-size:14px;z-index:9999;box-shadow:0 4px 12px rgba(0,0,0,0.15);transition:opacity 0.3s;max-width:400px;text-align:center;';
                        errorIndicator.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>' + errorMessage;
                        document.body.appendChild(errorIndicator);
                        setTimeout(() => { errorIndicator.style.opacity = '0'; setTimeout(() => errorIndicator.remove(), 300); }, 4000);
                    }
                })
                .catch(error => {
                    if (saveBtn) {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = originalText;
                    }
                    console.error('Save error:', error);
                });
            });
        })();
    </script>

    <div class="sticky-save-btn" id="stickySaveBtn">
        <button type="submit" form="myForm" class="btn btn-primary btn-lg shadow">
            <i class="bi bi-save me-1"></i> Simpan
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
              const previewFrame = document.getElementById('previewFrame');
              const livePreviewFrame = document.querySelector('.android-frame.live-preview-frame');

             if (!previewFrame || !livePreviewFrame) return;

             // By default, scrollbar is hidden (scrolling="no")
             previewFrame.scrolling = 'no';

             // On hover: enable scrolling (scrolling="yes")
             livePreviewFrame.addEventListener('mouseenter', function() {
                 previewFrame.scrolling = 'yes';
             });
             livePreviewFrame.addEventListener('mouseleave', function() {
                 previewFrame.scrolling = 'no';
             });
         })();
     </script>

</x-app-layout>


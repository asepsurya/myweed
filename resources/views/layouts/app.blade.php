<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title id="dynamicTitle">{{ config('app.name', 'WeddingInv') }} — Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('tempelate/logo_apps.png') }}">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.css" rel="stylesheet">
    <script src="https://unpkg.com/cropperjs@1.6.1/dist/cropper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

    <!-- AdminUIUX Framework -->
    <link href="{{ asset('assets/css/app435e.css?1096aad991449c8654b2') }}" rel="stylesheet">
    <script defer src="{{ asset('assets/js/app435e.js?1096aad991449c8654b2') }}"></script>
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- WeddingInv Theme Overrides -->
 
    <style>
        :root {
            --adminuiux-content-font: "Inter", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Playfair Display", "Inter", sans-serif;
            --adminuiux-title-font-weight: 600;

            

            /* Mobile bottom nav */
            --mobile-nav-active-color: var(--wedding-pink, #FF6B81);
        }

        /* Override framework accent to match wedding brand */
        .theme-gold .btn-primary,
        .theme-gold .btn.btn-primary,
        .theme-gold .badge.bg-primary {
            background: linear-gradient(135deg, var(--wedding-pink), var(--wedding-pink-dark)) !important;
            border-color: var(--wedding-pink-dark) !important;
        }

        .theme-gold .btn-primary:hover,
        .theme-gold .btn.btn-primary:hover {
            box-shadow: 0 4px 14px rgba(255, 107, 129, 0.35);
        }

        .theme-gold .text-primary,
        .theme-gold .link-primary {
            color: var(--wedding-pink-dark) !important;
        }

        .theme-gold .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--wedding-pink), var(--wedding-pink-dark)) !important;
            color: #fff !important;
        }

        .theme-gold .form-check-input:checked {
            background-color: var(--wedding-pink-dark);
            border-color: var(--wedding-pink-dark);
        }

        .theme-gold .form-control:focus,
        .theme-gold .form-select:focus {
            border-color: var(--wedding-pink);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 129, 0.25);
        }

        .theme-gold .page-link {
            color: var(--wedding-navy);
        }

        .theme-gold .page-item.active .page-link {
            background-color: var(--wedding-pink-dark);
            border-color: var(--wedding-pink-dark);
        }

        .theme-gold .progress-bar {
            background: linear-gradient(135deg, var(--wedding-pink), var(--wedding-pink-dark));
        }

        /* Card accents */
        .theme-gold .card.border-start {
            border-left-color: var(--wedding-pink) !important;
        }

        .theme-gold .card.border-top {
            border-top-color: var(--wedding-pink) !important;
        }

        /* =============================================
           MUSIC PLAYER
        ============================================= */
        .wedding-music-player {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 1050;
            width: 320px;
            max-width: calc(100vw - 40px);
        }

        .music-player-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            padding: 12px 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        [data-bs-theme="dark"] .music-player-inner {
            background: rgba(33, 37, 41, 0.95);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .music-toggle-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, var(--wedding-pink, #FF6B81), var(--wedding-pink-dark, #e84a6a));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(255, 107, 129, 0.4);
            transition: transform 0.2s ease;
        }

        .music-toggle-btn:hover {
            transform: scale(1.05);
        }

        .music-toggle-btn svg {
            width: 20px;
            height: 20px;
        }

        .music-player-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .music-cover {
            width: 40px;
            height: 40px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .music-details {
            flex: 1;
            min-width: 0;
        }

        .music-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #1e293b;
        }

        .music-artist {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .music-player-controls {
            display: none;
        }

        .music-progress {
            height: 4px;
            accent-color: var(--wedding-pink, #FF6B81);
            cursor: pointer;
        }

        .music-time {
            font-size: 10px;
            white-space: nowrap;
        }

        .music-volume-control {
            display: none;
        }

        @media (min-width: 576px) {
            .wedding-music-player {
                width: 380px;
            }

            .music-player-controls {
                display: flex;
                align-items: center;
                gap: 8px;
                flex: 1;
                min-width: 0;
            }

            .music-progress {
                flex: 1;
                min-width: 60px;
            }

            .music-volume-control {
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .music-volume {
                width: 60px;
                height: 4px;
                accent-color: var(--wedding-pink, #FF6B81);
                cursor: pointer;
            }
        }

        @media (max-width: 575.98px) {
            .wedding-music-player {
                bottom: 80px;
                left: 10px;
                width: calc(100vw - 20px);
            }

            .music-player-inner {
                padding: 10px 12px;
                gap: 8px;
            }

            .music-toggle-btn {
                width: 38px;
                height: 38px;
            }

            .music-cover {
                width: 32px;
                height: 32px;
            }

            .music-title {
                font-size: 12px;
            }

            .music-artist {
                font-size: 10px;
            }

            .music-time {
                font-size: 9px;
            }

            .music-progress {
                height: 3px;
            }
        }

        /* GitHub Update Badge */
        #update-dropdown .update-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #dc3545;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        #update-btn.text-warning {
            color: #f59f00 !important;
        }

        #update-btn.text-warning i {
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<!-- roundedui -->
<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed  theme-teal adminuiux-header-standard adminuiux-sidebar-iconic adminuiux-header-transparent scrolldown"
      data-theme="theme-teal"
      data-sidebarfill="adminuiux-sidebar-fill-white"
      data-headerlayout="adminuiux-header-standard"
      data-sidebarlayout="adminuiux-sidebar-iconic"
      data-bs-spy="scroll"
      data-bs-target="#list-example"
      data-bs-smooth-scroll="true"
      tabindex="0">

    {{-- Header --}}
    @include('layouts.partial.header')

    {{-- Page Wrapper --}}
    <div class="adminuiux-wrap">

        {{-- Sidebar --}}
        @include('layouts.partial.user_sidebar')

        {{-- Main Content --}}
        <main class="adminuiux-content has-sidebar" onclick="contentClick()" style="padding-top: 68px;">
            <div class="container-fluid mt-4" id="main-content">

                @if(session('warning'))
                    <div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                        <div>{{ session('warning') }}</div>
                    </div>
                @endif

                @if(auth()->check() && !auth()->user()->hasVerifiedEmail() && !auth()->user()->isAdmin())
                    <div class="alert alert-warning d-flex align-items-center justify-content-between gap-2" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope-exclamation-fill flex-shrink-0"></i>
                            <div>
                                Email Anda belum diverifikasi.
                                <a href="{{ route('verification.notice') }}" class="alert-link">Verifikasi sekarang</a>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-send me-1"></i>Kirim Ulang
                            </button>
                        </form>
                    </div>
                @endif

                @if(request()->has('verified'))
                    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                        <div>Email Anda berhasil diverifikasi.</div>
                    </div>
                @endif

                {{ $slot }}

                @include('layouts.partial.toastr')
            </div>
        </main>
    </div>

    {{-- Mobile Bottom Nav --}}
    @include('layouts.partial.mobile_global')

    {{-- Page-level scripts (loaded by child views) --}}
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ── Page Title & Breadcrumb ── */
            const path = window.location.pathname.split('/').filter(Boolean);
            const current = path[path.length - 1] || 'dashboard';
            const pageName = current
                .replace(/-/g, ' ')
                .replace(/\b\w/g, c => c.toUpperCase());

            const breadcrumb = document.getElementById('currentPage');
            const pageTitle  = document.getElementById('pageTitle');

            if (breadcrumb) breadcrumb.textContent = pageName;
            if (pageTitle)  pageTitle.textContent  = pageName;

            document.getElementById('dynamicTitle').textContent =
                '{{ config("app.name", "WeddingInv") }} — ' + pageName;

            /* ── Toast Init ── */
            function initToasts() {
                document.querySelectorAll('.toast:not(.show)').forEach(el => {
                    new bootstrap.Toast(el).show();
                });
            }

            // Wait for framework loader if present
            const loader = document.getElementById('pageLoader');
            if (loader) {
                const obs = new MutationObserver(() => {
                    if (loader.style.display === 'none' || loader.classList.contains('d-none')) {
                        initToasts();
                        obs.disconnect();
                    }
                });
                obs.observe(loader, { attributes: true });
                // Fallback: init after 5s even if loader stuck
                setTimeout(() => { initToasts(); obs.disconnect(); }, 5000);
            } else {
                initToasts();
            }

        });

        function contentClick() {
            // Close sidebar collapse elements when clicking main content
            const sidebarProfile = document.getElementById('usersidebarprofile');
            if (sidebarProfile && sidebarProfile.classList.contains('show')) {
                const collapse = bootstrap.Collapse.getOrCreateInstance(sidebarProfile);
                collapse.hide();
            }
        }
    </script>
    
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('assets/js/component/component-toasts.js') }}"></script>

</body>

</html>
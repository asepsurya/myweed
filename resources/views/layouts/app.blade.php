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
<<<<<<< HEAD
    <script defer src="https://unpkg.com/face-api.js"></script>

    <!-- AdminUIUX Framework -->
    <link href="{{ asset('assets/css/app435e.css?1096aad991449c8654b2') }}" rel="stylesheet">
    <script defer src="{{ asset('assets/js/app435e.js?1096aad991449c8654b2') }}"></script>
=======
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b

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

       
    </style>
</head>
<<<<<<< HEAD
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
=======
<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed roundedui theme-teal adminuiux-header-standard adminuiux-sidebar-iconic adminuiux-header-transparent scrolldown @yield('sidebar_class')" data-theme="theme-teal" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0" data-headerlayout="adminuiux-header-standard" data-sidebarlayout="adminuiux-sidebar-iconic">
    {{-- header layout --}}
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
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
<<<<<<< HEAD

                {{ $slot }}

=======
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
                @include('layouts.partial.toastr')
            </div>
        </main>
    </div>

    {{-- Mobile Bottom Nav --}}
    @include('layouts.partial.mobile_global')

    {{-- Page-level scripts (loaded by child views) --}}
    @stack('scripts')

    <script>
<<<<<<< HEAD
        document.addEventListener('DOMContentLoaded', function () {
=======
        document.addEventListener('DOMContentLoaded', function() {

            const showToast = () => {
                document.querySelectorAll('.toast').forEach(toastEl => {
                    new bootstrap.Toast(toastEl).show();
                });
            };

            // ⏳ tunggu loader hilang
            const loader = document.getElementById('pageLoader');

            if (loader) {
                const observer = new MutationObserver(() => {
                    if (loader.style.display === 'none' || loader.classList.contains('d-none')) {
                        showToast();
                        observer.disconnect();
                    }
                });

                observer.observe(loader, {
                    attributes: true
                });
            } else {
                showToast();
            }

        });

    </script>
    <!-- Page Level js -->
    <script src="{{ asset('assets/js/investment/investment-loan-list.js') }}"></script>
    <!-- Page Level js -->
    <script src="{{ asset('assets/js/component/component-toasts.js') }}"></script>
    <script>
        const themeMedia = window.matchMedia('(prefers-color-scheme: dark)');
        const toggleBtn = document.getElementById('themeToggle');

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
        }

        // AUTO DARI WINDOWS / LOCALSTORAGE
        function initTheme() {
            const savedTheme = localStorage.getItem('theme');

            if (savedTheme) {
                applyTheme(savedTheme);
            } else {
                applyTheme(themeMedia.matches ? 'dark' : 'light');
            }
        }

        // UPDATE JIKA WINDOWS BERUBAH
        themeMedia.addEventListener('change', e => {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });

        // MANUAL TOGGLE
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const current = document.documentElement.getAttribute('data-bs-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                applyTheme(next);
            });
        }

        initTheme();

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const path = window.location.pathname.split("/").filter(Boolean);
            const current = path[path.length - 1] || "dashboard";
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b

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
    </script>

<<<<<<< HEAD
    <script src="{{ asset('assets/js/component/component-toasts.js') }}"></script>
=======

    @stack('scripts')
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
</body>

</html>
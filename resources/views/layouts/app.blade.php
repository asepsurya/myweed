<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title id="dynamicTitle">{{ config('app.name', 'RuangUndang') }} — Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/fav.png') }}">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- RuangUndang Theme Overrides -->
    <style>
        :root,
        [data-bs-theme=light] {
            /* Font Profesional */
            --adminuiux-content-font: "Inter", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Plus Jakarta Sans", "Inter", sans-serif;
            --adminuiux-title-font-weight: 700;

            /* Warna Utama Tema Gold */
            --adminuiux-theme-1: #C6A962;
            --adminuiux-theme-1-hover: #A68B4B;
            --adminuiux-theme-1-active: #8f743e;
            --adminuiux-theme-1-rgb: 198, 169, 98;
            --adminuiux-theme-1-text: #FFFFFF;

            /* Warna Sekunder Tema Navy */
            --adminuiux-theme-2: #1B2A4A;
            --adminuiux-theme-2-rgb: 27, 42, 74;
            --adminuiux-theme-2-text: #FFFFFF;

            /* Aksen Warna */
            --adminuiux-theme-accent-1: #C6A962;
            --adminuiux-theme-accent-1-hover: #A68B4B;
            --adminuiux-theme-accent-1-active: #8f743e;
            --adminuiux-theme-accent-1-rgb: 198, 169, 98;
            --adminuiux-theme-accent-1-text: #FFFFFF;
            --adminuiux-theme-accent-2: #E8D5A3;
            --adminuiux-theme-accent-2-rgb: 232, 213, 163;
            --adminuiux-theme-accent-2-text: #1B2A4A;

            /* Background Dasar (Light) */
            --adminuiux-bg-1: #F7F5F2;
            --adminuiux-bg-2: #FDFBF7;
            --adminuiux-text: #1B2A4A;

            /* Layout */
            --adminuiux-sidebar-width: 280px;
            --adminuiux-sidebar-iconic-width: 60px;
            --adminuiux-header-active-bg-rgb: 255, 255, 255;
            --adminuiux-header-active-opacity: 0.95;
            --adminuiux-footer-bg: #FFFFFF;
            --adminuiux-footer-bg-rgb: 255, 255, 255;

            /* Bootstrap Overrides (Light) */
            --bs-primary: #C6A962;
            --bs-primary-rgb: 198, 169, 98;
            --bs-secondary: #1B2A4A;
            --bs-secondary-rgb: 27, 42, 74;
            --bs-body-bg: #F7F5F2;
            --bs-body-color: #1B2A4A;
            --bs-border-color: rgba(27, 42, 74, 0.125);
            --bs-link-color-rgb: 166, 139, 75;

            /* Text Emphasis (Light) */
            --bs-primary-text-emphasis: #A68B4B;
            --bs-secondary-text-emphasis: #1B2A4A;
        }

        /* =============================================
           DARK MODE PROFESSIONAL
        ============================================= */
        [data-bs-theme="dark"] {
            /* Warna Utama Gold (Diterangkan sedikit untuk kontras dark mode) */
            --adminuiux-theme-1: #E8D5A3;
            --adminuiux-theme-1-hover: #C6A962;
            --adminuiux-theme-1-active: #C6A962;
            --adminuiux-theme-1-rgb: 232, 213, 163;
            --adminuiux-theme-1-text: #0B0F19;

            /* Warna Sekunder Navy (Diterangkan untuk kontras) */
            --adminuiux-theme-2: #2A3F6A;
            --adminuiux-theme-2-rgb: 42, 63, 106;
            --adminuiux-theme-2-text: #FFFFFF;

            /* Aksen Warna */
            --adminuiux-theme-accent-1: #E8D5A3;
            --adminuiux-theme-accent-1-hover: #C6A962;
            --adminuiux-theme-accent-1-active: #C6A962;
            --adminuiux-theme-accent-1-rgb: 232, 213, 163;
            --adminuiux-theme-accent-1-text: #0B0F19;

            --adminuiux-theme-accent-2: #2A3F6A;
            --adminuiux-theme-accent-2-rgb: 42, 63, 106;
            --adminuiux-theme-accent-2-text: #FFFFFF;

            /* Background Dasar (Dark Navy Pekat) */
            --adminuiux-bg-1: #0B0F19;
            --adminuiux-bg-2: #111827;
            --adminuiux-text: #F1F5F9;

            /* Layout Dark */
            --adminuiux-header-active-bg-rgb: 11, 15, 25;
            --adminuiux-header-active-opacity: 0.95;
            --adminuiux-footer-bg: #0B0F19;
            --adminuiux-footer-bg-rgb: 11, 15, 25;

            /* Bootstrap Overrides (Dark) */
            --bs-primary: #E8D5A3;
            --bs-primary-rgb: 232, 213, 163;
            --bs-secondary: #2A3F6A;
            --bs-secondary-rgb: 42, 63, 106;
            --bs-body-bg: #0B0F19;
            --bs-body-color: #F1F5F9;
            --bs-border-color: rgba(255, 255, 255, 0.1);
            --bs-link-color-rgb: 232, 213, 163;

            /* Text Emphasis (Dark) */
            --bs-primary-text-emphasis: #E8D5A3;
            --bs-secondary-text-emphasis: #94A3B8;
            --bs-light-text-emphasis: #F1F5F9;
            --bs-dark-text-emphasis: #94A3B8;
        }

        /* Override framework accent to match wedding brand */
        .theme-gold .btn-primary,
        .theme-gold .btn.btn-primary,
        .theme-gold .badge.bg-primary {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover)) !important;
            border-color: var(--adminuiux-theme-1-hover) !important;
            color: var(--adminuiux-theme-1-text) !important;
        }

        .theme-gold .btn-primary:hover,
        .theme-gold .btn.btn-primary:hover {
            box-shadow: 0 4px 14px rgba(198, 169, 98, 0.35);
        }

        .theme-gold .text-primary,
        .theme-gold .link-primary {
            color: var(--adminuiux-theme-1) !important;
        }

        .theme-gold .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover)) !important;
            color: var(--adminuiux-theme-1-text) !important;
        }

        .theme-gold .form-check-input:checked {
            background-color: var(--adminuiux-theme-1);
            border-color: var(--adminuiux-theme-1);
        }

        .theme-gold .form-control:focus,
        .theme-gold .form-select:focus {
            border-color: var(--adminuiux-theme-1);
            box-shadow: 0 0 0 0.2rem rgba(198, 169, 98, 0.25);
        }

        .theme-gold .page-link {
            color: var(--adminuiux-text);
        }

        .theme-gold .page-item.active .page-link {
            background-color: var(--adminuiux-theme-1);
            border-color: var(--adminuiux-theme-1);
            color: var(--adminuiux-theme-1-text);
        }

        .theme-gold .progress-bar {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover));
        }

        .theme-gold .card.border-start {
            border-left-color: var(--adminuiux-theme-1) !important;
        }

        .theme-gold .card.border-top {
            border-top-color: var(--adminuiux-theme-1) !important;
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
            background: rgba(17, 24, 39, 0.95);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .music-toggle-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: none;
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover));
            color: var(--adminuiux-theme-1-text);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(198, 169, 98, 0.4);
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
            color: var(--adminuiux-text);
        }

        .music-artist {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--adminuiux-text);
            opacity: 0.7;
        }

        .music-player-controls {
            display: none;
        }

        .music-progress {
            height: 4px;
            accent-color: var(--adminuiux-theme-1);
            cursor: pointer;
        }

        .music-time {
            font-size: 10px;
            white-space: nowrap;
            color: var(--adminuiux-text);
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
                accent-color: var(--adminuiux-theme-1);
                cursor: pointer;
            }
        }

        @media (max-width: 575.98px) {
            .adminuiux-wrap {
                margin-bottom: 100px;
            }

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

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* =============================================
           ADMINUIUX CARD PREMIUM OVERRIDE
        ============================================= */
        .adminuiux-card {
            border: 1px solid var(--bs-border-color) !important;
            border-radius: 16px !important;
            background-color: var(--adminuiux-bg-2) !important;
            color: var(--adminuiux-text) !important;
            transition: all 0.3s ease-in-out !important;
            box-shadow: 0 4px 20px rgba(27, 42, 74, 0.04) !important;
            overflow: hidden;
        }

        .adminuiux-card.h-100:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 12px 30px rgba(27, 42, 74, 0.08) !important;
            border-color: rgba(198, 169, 98, 0.3) !important;
        }

        .adminuiux-card .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid var(--bs-border-color) !important;
            padding: 1rem 1.25rem !important;
            font-family: var(--adminuiux-title-font) !important;
            font-weight: 600 !important;
        }

        .adminuiux-card .card-body {
            padding: 1.25rem !important;
        }

        .adminuiux-card .avatar {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 12px !important;
        }

        [data-bs-theme="dark"] .adminuiux-card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2) !important;
        }

        [data-bs-theme="dark"] .adminuiux-card.h-100:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4) !important;
            border-color: rgba(232, 213, 163, 0.3) !important;
        }

        /* Sidebar dropdown animation */
        .adminuiux-sidebar .collapse {
            transition: all 0.3s ease-in-out;
        }

        .adminuiux-sidebar .nav-item:hover>.collapse {
            display: block;
        }

        .adminuiux-sidebar .nav-item>a[data-bs-toggle="collapse"] .bi-chevron-down {
            transition: transform 0.3s ease;
        }

        .adminuiux-sidebar .nav-item>a[aria-expanded="true"] .bi-chevron-down {
            transform: rotate(180deg);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "\f285";
            font-family: "bootstrap-icons";
            padding-right: 0.5rem;
            color: var(--bs-secondary-color);
        }
        [data-bs-theme=dark] .breadcrumb .breadcrumb-item a {
            color: #f9fafb;
        }
        .breadcrumb .breadcrumb-item a {
            color: #000000ff;
        }
        .breadcrumb .breadcrumb-item.active {
            color: #C6A962;
        }
        @media (max-width: 1400px) {
            .readcrumb-card {
                display: none !important;
            }
        }
}
    </style>
</head>

<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed theme-gold"
    data-theme="theme-gold" data-sidebarfill="adminuiux-sidebar-fill-white"
    data-headerlayout="adminuiux-header-standard" data-sidebarlayout="adminuiux-sidebar-iconic" data-bs-spy="scroll"
    data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0">

    @include('layouts.partial.header')

    {{-- Page Wrapper --}}
    <div class="adminuiux-wrap">

        {{-- Sidebar --}}
        @include('layouts.partial.user_sidebar')

        {{-- Main Content --}}
        <main class="adminuiux-content has-sidebar" onclick="contentClick()" style="padding-top: 68px;">
            <div class="container-fluid mt-4" id="main-content">

              

                {{-- Breadcrumbs dibungkus dalam Card --}}
                @php
                    $breadcrumbs = get_breadcrumbs();
                @endphp

                @if(!empty($breadcrumbs) && count($breadcrumbs) > 1)
                    <div class="card border-1 mb-4 readcrumb-card"
                        style="background-color: rgba(198, 169, 98, 0.1); border-color: rgba(198, 169, 98, 0.2) !important;">
                        <div class="card-body py-2 px-3">
                            <nav aria-label="breadcrumb" class="mb-0">
                                <ol class="breadcrumb mb-0 align-items-center">
                                    @foreach($breadcrumbs as $crumb)
                                        @if($loop->last)
                                            <li class="breadcrumb-item active" aria-current="page">
                                                @if(!empty($crumb['icon']))
                                                    <i class="bi {{ $crumb['icon'] }} me-1 fs-14"></i>
                                                @endif
                                                {{ $crumb['label'] }}
                                            </li>
                                        @else
                                            <li class="breadcrumb-item">
                                                @if(!empty($crumb['icon']))
                                                    <i class="bi {{ $crumb['icon'] }} me-1 fs-14"></i>
                                                @endif
                                                @if(!empty($crumb['url']))
                                                    <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                                                @elseif(!empty($crumb['route']))
                                                    <a href="{{ route($crumb['route']) }}">{{ $crumb['label'] }}</a>
                                                @else
                                                    {{ $crumb['label'] }}
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ol>
                            </nav>
                        </div>
                    </div>
                @endif
                {{-- Notifikasi / Alert Premium Gold --}}
                @if(session('warning') || (auth()->check() && !auth()->user()->hasVerifiedEmail() && !auth()->user()->isAdmin()) || request()->has('verified'))
                    <div class="mb-3">
                        
                        {{-- 1. Warning Session --}}
                        @if(session('warning'))
                            <div class="d-flex align-items-center gap-3 p-3 rounded-4 mb-2" style="background-color: rgba(198, 169, 98, 0.15); border: 1px solid rgba(198, 169, 98, 0.4);">
                                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 text-white" style="width: 42px; height: 42px; background: linear-gradient(135deg, #C6A962, #A68B4B);">
                                    <i class="bi bi-exclamation-triangle-fill fs-6"></i>
                                </div>
                                <div class="fw-medium" style="color: #8f743e;">
                                    {{ session('warning') }}
                                </div>
                            </div>
                        @endif

                        {{-- 2. Unverified Email --}}
                        @if(auth()->check() && !auth()->user()->hasVerifiedEmail() && !auth()->user()->isAdmin())
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 p-3 rounded-4 mb-2" style="background-color: rgba(198, 169, 98, 0.15); border: 1px solid rgba(198, 169, 98, 0.4);">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 text-white" style="width: 42px; height: 42px; background: linear-gradient(135deg, #C6A962, #A68B4B);">
                                        <i class="bi bi-envelope-exclamation-fill fs-6"></i>
                                    </div>
                                    <div class="fw-medium" style="color: #8f743e;">
                                        Email Anda belum diverifikasi.
                                        <a href="{{ route('verification.notice') }}" class="fw-bold text-decoration-underline" style="color: #A68B4B;">Verifikasi sekarang</a>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('verification.send') }}" class="d-inline flex-shrink-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm fw-semibold rounded-pill px-3 py-2 text-white border-0" style="background: linear-gradient(135deg, #C6A962, #A68B4B);">
                                        <i class="bi bi-send-fill me-1"></i>Kirim Ulang
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- 3. Verified Success --}}
                        {{-- Untuk sukses, saya tetap menggunakan warna emas agar konsisten dengan tema, namun dengan ikon checklis --}}
                        @if(request()->has('verified'))
                            <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background-color: rgba(198, 169, 98, 0.15); border: 1px solid rgba(198, 169, 98, 0.4);">
                                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 text-white" style="width: 42px; height: 42px; background: linear-gradient(135deg, #C6A962, #A68B4B);">
                                    <i class="bi bi-check-lg fs-5"></i>
                                </div>
                                <div class="fw-medium" style="color: #8f743e;">
                                    Email Anda berhasil diverifikasi.
                                </div>
                            </div>
                        @endif

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

            /* ── Dark/Light Mode Toggle ── */
            const themeBtn = document.getElementById('btn-layout-modes-dark-page');
            const htmlEl = document.documentElement;

            function getSystemTheme() {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            function getStoredTheme() {
                return localStorage.getItem('theme');
            }

            function setTheme(theme) {
                htmlEl.setAttribute('data-bs-theme', theme);
                localStorage.setItem('theme', theme);
                updateButtonIcon(theme);
            }

            function updateButtonIcon(theme) {
                if (!themeBtn) return;
                const sunIcon = themeBtn.querySelector('.sun');
                const moonIcon = themeBtn.querySelector('.moon');
                if (theme === 'dark') {
                    if (sunIcon) sunIcon.style.display = 'none';
                    if (moonIcon) moonIcon.style.display = 'block';
                } else {
                    if (sunIcon) sunIcon.style.display = 'block';
                    if (moonIcon) moonIcon.style.display = 'none';
                }
            }

            if (themeBtn) {
                themeBtn.addEventListener('click', function () {
                    const current = htmlEl.getAttribute('data-bs-theme') || getSystemTheme();
                    const next = current === 'dark' ? 'light' : 'dark';
                    setTheme(next);
                });
            }

            const stored = getStoredTheme();
            if (stored) {
                setTheme(stored);
            } else {
                setTheme(getSystemTheme());
                if (window.autoThemeMode) {
                    window.autoThemeMode();
                }
            }

            /* ── Page Title & Breadcrumb ── */
            const path = window.location.pathname.split('/').filter(Boolean);
            const current = path[path.length - 1] || 'dashboard';
            const pageName = current
                .replace(/-/g, ' ')
                .replace(/\b\w/g, c => c.toUpperCase());

            const breadcrumb = document.getElementById('currentPage');
            const pageTitle = document.getElementById('pageTitle');

            if (breadcrumb) breadcrumb.textContent = pageName;
            if (pageTitle) pageTitle.textContent = pageName;

            document.getElementById('dynamicTitle').textContent =
                '{{ config("app.name", "RuangUndang") }} — ' + pageName;

            /* ── Toast Init ── */
            function initToasts() {
                document.querySelectorAll('.toast:not(.show)').forEach(el => {
                    new bootstrap.Toast(el).show();
                });
            }

            const loader = document.getElementById('pageLoader');
            if (loader) {
                const obs = new MutationObserver(() => {
                    if (loader.style.display === 'none' || loader.classList.contains('d-none')) {
                        initToasts();
                        obs.disconnect();
                    }
                });
                obs.observe(loader, { attributes: true });
                setTimeout(() => { initToasts(); obs.disconnect(); }, 5000);
            } else {
                initToasts();
            }
        });

        function contentClick() {
            const sidebarProfile = document.getElementById('usersidebarprofile');
            if (sidebarProfile && sidebarProfile.classList.contains('show')) {
                const collapse = bootstrap.Collapse.getOrCreateInstance(sidebarProfile);
                collapse.hide();
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('assets/js/component/component-toasts.js') }}"></script>
        @yield('js')

</body>

</html>
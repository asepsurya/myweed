<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title id="dynamicTitle">{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('tempelate/logo_apps.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Open+Sans:ital,wght@0,300..800;1,300..800&amp;display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


    <style>
        :root {
            --adminuiux-content-font: "Open Sans", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Lexend", sans-serif;
            --adminuiux-title-font-weight: 600;
        }
    </style>

    <script defer src="{{ asset('assets/js/app435e.js?1096aad991449c8654b2') }}"></script>
    <link href="{{ asset('assets/css/app435e.css?1096aad991449c8654b2') }}" rel="stylesheet">
</head>
<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed roundedui theme-teal adminuiux-header-standard adminuiux-sidebar-iconic adminuiux-header-transparent scrolldown" data-theme="theme-teal" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0" data-headerlayout="adminuiux-header-standard" data-sidebarlayout="adminuiux-sidebar-iconic">
    {{-- header layout --}}
    @include('layouts.partial.header')

    <!-- page wrapper -->
    <div class="adminuiux-wrap">
        {{-- @include('layouts.partial.pageloader') --}}
        <!-- User sidebar -->
        @include('layouts.partial.user_sidebar')
        <!-- Standard sidebar -->


        <main class="adminuiux-content has-sidebar" onclick="contentClick()" style="padding-top: 68px;">
            <div class="container-fluid mt-4" id="main-content">
                {{ $slot }}
                @include('layouts.partial.toastr')
            </div>
        </main>
    </div>

   <script>
    document.addEventListener('DOMContentLoaded', function () {

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

            observer.observe(loader, { attributes: true });
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
        toggleBtn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
        });

        initTheme();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const path = window.location.pathname.split("/").filter(Boolean);
            const current = path[path.length - 1] || "dashboard";

            const pageName = current
                .replace(/-/g, " ")
                .replace(/\b\w/g, char => char.toUpperCase());

            // Breadcrumb
            const breadcrumb = document.getElementById("currentPage");
            const pageTitle = document.getElementById("pageTitle");

            if (breadcrumb) breadcrumb.textContent = pageName;
            if (pageTitle) pageTitle.textContent = pageName;

            // Title Browser Tab
            document.title = "Admin - " + pageName;
        });
    </script>

</script>

</body>


</html>

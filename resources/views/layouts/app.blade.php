{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/@tabler/icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css" integrity="sha512-gzw5zNP2TRq+DKyAqZfDclaTG4dOrGJrwob2Fc8xwcJPDPVij0HowLIMZ8c1NefFM0OZZYUUUNoPfcoI5jqudw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://unpkg.com/wavesurfer.js@7"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title id="dynamicTitle">Admin</title>

    <link rel="icon" type="image/png" href="{{ asset('tempelate/logo_apps.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Open+Sans:ital,wght@0,300..800;1,300..800&amp;display=swap" rel="stylesheet">
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

<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed  theme-blue roundedui" data-theme="theme-blue" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0">

    {{-- Page Loader --}}
    @include('layouts.partial.pageloader')
    {{-- header layout --}}
    @include('layouts.partial.header')

    <!-- page wrapper -->
    <div class="adminuiux-wrap">
        <!-- Standard sidebar -->
        @include('layouts.partial.sidebar')

        <main class="adminuiux-content has-sidebar" onclick="contentClick()">
            <!-- body content of pages -->

            <div class="container-fluid mt-4">
                <div class="row gx-3 align-items-center">
                    <div class="col col-sm">
                        <h5 id="pageTitle"></h5>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const path = window.location.pathname.split("/").filter(Boolean);
                    const current = path[path.length - 1] || "dashboard";

                    // Format nama: dashboard -> Dashboard, data-pasangan -> Data Pasangan
                    const pageName = current
                        .replace(/-/g, " ")
                        .replace(/\b\w/g, char => char.toUpperCase());
                    document.getElementById("pageTitle").textContent = pageName;
                });

            </script>

            <div class="container mt-4" id="main-content">
               {{ $slot }}
            </div>
        </main>
    </div>



    <!-- Page Level js -->
    <script src="assets/js/investment/investment-loan-list.js"></script>
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

</body>


</html>

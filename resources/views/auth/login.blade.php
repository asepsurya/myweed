<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags  -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Login</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Open+Sans:ital,wght@0,300..800;1,300..800&amp;display=swap" rel="stylesheet">
    <style>
        :root {
            --adminuiux-content-font: "Open Sans", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Lexend", sans-serif;
            --adminuiux-title-font-weight: 600;
        }

        .form-control {
            border-radius: 0 !important;
        }

    </style>

    <script defer src="{{ asset('assets/js/app435e.js?1096aad991449c8654b2') }}"></script>
    <link href="{{ asset('assets/css/app435e.css?1096aad991449c8654b2') }}" rel="stylesheet">
</head>

<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed  theme-blue roundedui" data-theme="theme-blue" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0">
    <!-- Pageloader -->
    <main class="flex-shrink-0 pt-0 h-100">
        <div class="container-fluid">
            <div class="auth-wrapper">
                <!--Page body-->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- login wrap -->
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-4 minvheight-100 d-flex flex-column px-0">
                            <!-- standard header -->
                            <!-- standard header -->
                            <header class="adminuiux-header">
                                <!-- Fixed navbar -->
                                <nav class="navbar">
                                    <div class="container-fluid">

                                        <div class=" ms-auto "></div>
                                        <!-- right icons button -->
                                        <div class="ms-auto">
                                        </div>
                                    </div>
                                </nav>
                            </header>

                            <div class="h-100 py-4 px-3">
                                <div class="row h-100 align-items-center justify-content-center mt-md-4">
                                    <div class="col-11 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box">
                                        <div class="text-center mb-4">
                                            <h1 class="mb-2">Selamat Datang </h1>
                                            <p class="text-secondary">Silakan masuk untuk mengakses akun Anda</p>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                                            <label for="email">Email Address</label>

                                            @error('email')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="position-relative">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                                                <label for="password">Password</label>
                                            </div>

                                            <button type="button" class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            @error('password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="rememberme" id="rememberme">
                                                    <label class="form-check-label" for="rememberme">Remember me</label>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <a href="investment-forgot-password.html" class=" ">Lupa Password?</a>
                                            </div>
                                        </div>
                                        <button type="submit" id="loginBtn" class="btn btn-lg btn-theme w-100 mb-4">
                                            <span class="btn-text">Masuk</span>
                                            <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                        </button>

                                        <!-- <button class="btn btn-lg btn-theme w-100 mb-4">Login</button> -->
                                        <div class="text-center mb-3">
                                            Tidak Punya Akun? <a href="investment-signup.html" class=" ">Buat Akun Baru</a>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col">
                                                <hr class="">
                                            </div>
                                            <div class="col-auto">
                                                <p class="text-secondary">Atau</p>
                                            </div>
                                            <div class="col">
                                                <hr class="">
                                            </div>
                                        </div>

                                        <button class="btn btn-lg btn-outline-theme w-100 mb-3 text-start">
                                            <img src="{{ asset('assets/img/g-logo.png') }}" alt="" class="me-2"> Sign in with Google
                                        </button>
                                        <button class="btn btn-lg btn-outline-theme w-100 mb-4 text-start">
                                            <img src="{{ asset('assets/img/f-logo.png') }}" alt="" class="me-2"> Sign in with Facebook
                                        </button>
                                        <br><br>
                                    </div>
                                </div>
                            </div>


                            <!-- theming action-->
                            <div class="position-fixed bottom-0 end-0 m-3 z-index-5">
                                <button class="btn btn-square btn-theme shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#theming" aria-controls="theming"><i class="bi bi-palette"></i></button>
                                <br>
                                <button class="btn btn-theme btn-square rounded-circle shadow mt-2 d-none" id="backtotop"><i class="bi bi-arrow-up"></i></button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-8 p-4 d-none d-md-block">
                            <div class="card adminuiux-card bg-theme-1-space position-relative overflow-hidden h-100">
                                <div class="position-absolute start-0 top-0 h-100 w-100 coverimg opacity-75 z-index-0">
                                    <img src="assets/img/background-image/background-image-8.html" alt="">
                                </div>
                                <div class="card-body position-relative z-index-1">
                                    <div class="row h-100 d-flex flex-column justify-content-center align-items-center gx-0 text-center">
                                        <div class="col-10 col-md-11 col-xl-8 mb-4 mx-auto">

                                            <!-- Slider container -->
                                            <div class="swiper swipernavpagination pb-5">
                                                <div class="swiper-wrapper">

                                                    <!-- Slide 1 -->
                                                    <div class="swiper-slide">
                                                        <img src="assets/img/investment/slider.png" alt="Undangan Digital" class="mw-100 mb-3">
                                                        <h2 class="text-white mb-3">
                                                            Wujudkan undangan pernikahan digital yang indah dan berkesan.
                                                        </h2>
                                                        <p class="lead opacity-75">
                                                            Desain eksklusif, fitur lengkap, dan mudah dibagikan<br>
                                                            untuk hari spesial Anda.
                                                        </p>
                                                    </div>

                                                    <!-- Slide 2 -->
                                                    <div class="swiper-slide">
                                                        <img src="assets/img/investment/slider.png" alt="Website Wedding" class="mw-100 mb-3">
                                                        <h2 class="text-white mb-3">
                                                            Ceritakan kisah cinta Anda dalam undangan digital yang istimewa.
                                                        </h2>
                                                        <p class="lead opacity-75">
                                                            Dari awal bertemu hingga hari bahagia,<br>
                                                            semuanya dalam satu undangan online yang elegan.
                                                        </p>
                                                    </div>

                                                    <!-- Slide 3 -->
                                                    <div class="swiper-slide">
                                                        <img src="assets/img/investment/slider.png" alt="Undangan Online" class="mw-100 mb-3">
                                                        <h2 class="text-white mb-3">
                                                            Undangan pernikahan modern untuk momen tak terlupakan.
                                                        </h2>
                                                        <p class="lead opacity-75">
                                                            Praktis, elegan, dan penuh makna<br>
                                                            untuk Anda dan orang terkasih.
                                                        </p>
                                                    </div>

                                                </div>

                                                <!-- Pagination -->
                                                <div class="swiper-pagination white bottom-0"></div>
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
    </main>

    <!-- Page Level js -->
    <script src="{{ asset('assets/js/investment/investment-auth.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const btn = document.getElementById("loginBtn");
            const text = btn.querySelector(".btn-text");
            const spinner = btn.querySelector(".spinner-border");

            form.addEventListener("submit", function() {
                // Tampilkan loading
                text.textContent = "Memproses...";
                spinner.classList.remove("d-none");

                // Disable tombol SAJA (jangan disable input)
                btn.disabled = true;
            });
        });

    </script>


</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MyWeed</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css for entrance effects -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary: #1A1A1A;
            --accent: #E8B4B8;
            --accent-glow: rgba(232, 180, 184, 0.4);
            --text-main: #2D3436;
            --text-muted: #636E72;
            --white: #FFFFFF;
            --soft-bg: #F8FAFB;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            background-color: var(--white);
            height: 100vh;
            margin: 0;
            overflow: hidden; /* NO SCROLL ON BODY */
        }

        .auth-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* Left Column: Interactive Form */
        .form-side {
            flex: 0 0 500px;
            height: 100vh;
            background: var(--white);
            display: flex;
            flex-direction: column;
            padding: 40px 60px;
            position: relative;
            z-index: 10;
            overflow: hidden; /* REMOVE SCROLL */
        }

        @media (max-width: 992px) {
            .form-side {
                flex: 1;
                max-width: 100%;
                padding: 40px 30px;
            }
        }

        .home-link {
            position: absolute;
            top: 40px;
            right: 40px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: 0.3s;
        }

        .home-link:hover {
            color: var(--accent);
        }

        .brand-area {
            margin-bottom: auto; /* Push down content */
        }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .brand-logo span {
            color: var(--accent);
        }

        .main-form-container {
            margin: auto 0; /* Center vertically */
            width: 100%;
            max-width: 380px;
            align-self: center;
        }

        .form-header {
            margin-bottom: 35px;
        }

        .form-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .form-header a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
            margin-left: 5px;
        }

        .input-group-custom {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group-custom label {
            display: block;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 8px;
            color: var(--primary);
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #A0AEC0;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .input-custom {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border-radius: 14px;
            border: 2px solid #EDF2F7;
            background: #F7FAFC;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .input-custom:focus {
            outline: none;
            border-color: var(--accent);
            background: var(--white);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .input-custom:focus + i {
            color: var(--accent);
        }

        .btn-signin {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 10px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-signin:hover {
            background: #000;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0;
            color: #CBD5E0;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1.5px solid #EDF2F7;
        }

        .divider span {
            padding: 0 15px;
        }

        .social-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border: 2px solid #EDF2F7;
            border-radius: 14px;
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-social:hover {
            background: #F7FAFC;
            border-color: #CBD5E0;
            transform: translateY(-2px);
        }

        .btn-social img {
            width: 18px;
        }

        .footer-area {
            margin-top: auto;
            text-align: center;
            font-size: 0.75rem;
            color: #A0AEC0;
        }

        /* Right Column: Dynamic Visuals */
        .visual-side {
            flex: 1;
            background: #000;
            position: relative;
            display: none;
            border-radius: 40px 0 0 40px;
            margin: 15px 15px 15px 0;
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .visual-side {
                display: block;
            }
        }

        .bg-image {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2069&auto=format&fit=crop') center/cover no-repeat;
            opacity: 0.8;
            transition: transform 10s linear;
        }

        .visual-side:hover .bg-image {
            transform: scale(1.1);
        }

        .visual-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: var(--white);
        }

        .visual-overlay h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.1;
        }

        .visual-overlay p {
            font-size: 1.2rem;
            opacity: 0.8;
            max-width: 500px;
        }

        /* Animations */
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <!-- Form Side -->
        <div class="form-side">
            <a href="/" class="home-link"><i class="bi bi-house-door me-2"></i>Beranda</a>

            <div class="brand-area animate__animated animate__fadeIn">
                <a href="/" class="brand-logo">My<span>Weed</span>.</a>
            </div>

            <div class="main-form-container">
                <div class="form-header animate__animated animate__fadeInUp animate-delay-1">
                    <h1>Selamat Datang</h1>
                    <p>Masuk ke akun Anda atau <a href="{{ route('register') }}">Buat akun baru</a></p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success py-2 small mb-4 animate__animated animate__fadeIn" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="input-group-custom animate__animated animate__fadeInUp animate-delay-1">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" class="input-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@example.com" required autofocus>
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group-custom animate__animated animate__fadeInUp animate-delay-2">
                        <div class="d-flex justify-content-between">
                            <label>Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-muted text-decoration-none small fw-bold">Lupa?</a>
                            @endif
                        </div>
                        <div class="input-wrapper">
                            <input type="password" name="password" class="input-custom @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 animate__animated animate__fadeInUp animate-delay-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label text-muted small fw-bold" for="remember_me">Biarkan saya tetap masuk</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-signin animate__animated animate__fadeInUp animate-delay-3">
                        Masuk Sekarang
                    </button>

                    <div class="divider animate__animated animate__fadeIn animate-delay-3">
                        <span>Atau</span>
                    </div>

                    <div class="social-grid animate__animated animate__fadeInUp animate-delay-3">
                        <a href="{{ url('/auth/google') }}" class="btn-social">
                            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="G">
                            <span>Google</span>
                        </a>
                        <a href="#" class="btn-social">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="F">
                            <span>Facebook</span>
                        </a>
                    </div>
                </form>
            </div>

            <div class="footer-area">
                &copy; 2024 MyWeed Invitation. Seluruh hak cipta dilindungi.
            </div>
        </div>

        <!-- Visual Side -->
        <div class="visual-side">
            <div class="bg-image"></div>
            <div class="visual-overlay">
                <div class="animate__animated animate__fadeInRight">
                    <h2>Abadikan Momen Terindah Anda.</h2>
                    <p>Lebih dari sekadar undangan, ini adalah gerbang menuju hari paling bahagia dalam hidup Anda.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

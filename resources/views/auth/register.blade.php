<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MyWeed</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary: #1A1A1A;
            --accent: #E8B4B8;
            --accent-glow: rgba(232, 180, 184, 0.4);
            --text-main: #2D3436;
            --text-muted: #636E72;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            background-color: var(--white);
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .auth-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .form-side {
            flex: 0 0 500px;
            height: 100vh;
            background: var(--white);
            display: flex;
            flex-direction: column;
            padding: 40px 60px;
            position: relative;
            z-index: 10;
            overflow: hidden;
        }

        @media (max-width: 992px) {
            .form-side {
                flex: 1;
                max-width: 100%;
                padding: 30px;
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
        }

        .brand-area { margin-bottom: 20px; }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -1px;
        }

        .brand-logo span { color: var(--accent); }

        .main-form-container {
            margin: auto 0;
            width: 100%;
            max-width: 380px;
            align-self: center;
        }

        .form-header { margin-bottom: 25px; }

        .form-header h1 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-header p { color: var(--text-muted); font-size: 0.95rem; }

        .form-header a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }

        .input-group-custom {
            margin-bottom: 15px;
            position: relative;
        }

        .input-group-custom label {
            display: block;
            font-weight: 700;
            font-size: 0.8rem;
            margin-bottom: 6px;
            color: var(--primary);
        }

        .input-wrapper { position: relative; }

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
            padding: 12px 16px 12px 48px;
            border-radius: 14px;
            border: 2px solid #EDF2F7;
            background: #F7FAFC;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .input-custom:focus {
            outline: none;
            border-color: var(--accent);
            background: var(--white);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .btn-register {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background: #000;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }

        .footer-area {
            margin-top: auto;
            text-align: center;
            font-size: 0.75rem;
            color: #A0AEC0;
        }

        .visual-side {
            flex: 1;
            background: #000;
            position: relative;
            display: none;
            border-radius: 40px 0 0 40px;
            margin: 15px;
            overflow: hidden;
        }

        @media (min-width: 992px) { .visual-side { display: block; } }

        .bg-image {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            opacity: 0.8;
            transition: 10s linear;
        }

        .visual-side:hover .bg-image { transform: scale(1.1); }

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

        .visual-overlay h2 { font-size: 3rem; font-weight: 800; margin-bottom: 20px; }

        /* Animations */
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="form-side">
            <a href="/" class="home-link"><i class="bi bi-house-door me-2"></i>Beranda</a>

            <div class="brand-area animate__animated animate__fadeIn">
                <a href="/" class="brand-logo">My<span>Weed</span>.</a>
            </div>

            <div class="main-form-container">
                <div class="form-header animate__animated animate__fadeInUp animate-delay-1">
                    <h1>Buat Akun</h1>
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="input-group-custom animate__animated animate__fadeInUp animate-delay-1">
                        <label>Nama Lengkap</label>
                        <div class="input-wrapper">
                            <input type="text" name="name" class="input-custom @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Romeo" required autofocus>
                            <i class="bi bi-person"></i>
                        </div>
                        @error('name') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group-custom animate__animated animate__fadeInUp animate-delay-1">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" class="input-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@example.com" required>
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group-custom animate__animated animate__fadeInUp animate-delay-2">
                        <label>Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" class="input-custom @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password') <div class="invalid-feedback d-block small">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group-custom animate__animated animate__fadeInUp animate-delay-2">
                        <label>Konfirmasi Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password_confirmation" class="input-custom" placeholder="••••••••" required>
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-register animate__animated animate__fadeInUp animate-delay-3">
                        Daftar Sekarang
                    </button>
                </form>
            </div>

            <div class="footer-area">
                &copy; 2024 MyWeed Invitation. Seluruh hak cipta dilindungi.
            </div>
        </div>

        <div class="visual-side">
            <div class="bg-image"></div>
            <div class="visual-overlay">
                <div class="animate__animated animate__fadeInRight">
                    <h2>Mulai Perjalanan Cinta Anda.</h2>
                    <p>Hanya selangkah lagi untuk membagikan momen kebahagiaan Anda ke seluruh penjuru dunia.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

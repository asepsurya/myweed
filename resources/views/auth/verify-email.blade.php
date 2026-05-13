<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - MyWeed</title>
    
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
        }

        @media (max-width: 992px) {
            .form-side {
                flex: 1;
                max-width: 100%;
                padding: 30px;
            }
        }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--primary);
            text-decoration: none;
            letter-spacing: -1px;
            margin-bottom: 50px;
            display: block;
        }

        .brand-logo span { color: var(--accent); }

        .main-form-container {
            margin: auto 0;
            width: 100%;
            max-width: 380px;
            align-self: center;
        }

        .form-header { margin-bottom: 35px; }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .form-header p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .btn-submit:hover { background: #000; transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

        .btn-logout {
            width: 100%;
            background: transparent;
            color: var(--text-muted);
            border: 2px solid #EDF2F7;
            padding: 14px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-logout:hover { background: #F7FAFC; color: var(--primary); }

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
            background: url('https://images.unsplash.com/photo-1510076857177-7470076d4098?q=80&w=2072&auto=format&fit=crop') center/cover no-repeat;
            opacity: 0.7;
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

        .visual-overlay h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <div class="form-side">
            <div class="brand-area animate__animated animate__fadeIn">
                <a href="/" class="brand-logo">My<span>Weed</span>.</a>
            </div>

            <div class="main-form-container">
                <div class="form-header animate__animated animate__fadeInUp">
                    <h1>Verifikasi Email</h1>
                    <p>Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan.</p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success py-2 small mb-4 animate__animated animate__fadeIn" role="alert">
                        Tautan verifikasi baru telah dikirim ke alamat email Anda.
                    </div>
                @endif

                <div class="animate__animated animate__fadeInUp">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn-submit">
                            Kirim Ulang Email Verifikasi
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="visual-side">
            <div class="bg-image"></div>
            <div class="visual-overlay">
                <div class="animate__animated animate__fadeInRight">
                    <h2>Hampir Sampai.</h2>
                    <p>Satu langkah kecil untuk memastikan akun Anda tetap aman dan terhubung dengan kami.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

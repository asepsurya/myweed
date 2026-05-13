<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Password - MyWeed</title>
    
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
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .form-header p { color: var(--text-muted); font-size: 0.95rem; }

        .input-group-custom { margin-bottom: 20px; position: relative; }
        .input-group-custom label { display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 8px; color: var(--primary); }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #A0AEC0; font-size: 1.1rem; }
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

        .input-custom:focus { outline: none; border-color: var(--accent); background: var(--white); box-shadow: 0 0 0 4px var(--accent-glow); }

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
        }

        .btn-submit:hover { background: #000; transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }

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
            background: url('https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
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
                    <h1>Password Baru</h1>
                    <p>Silakan buat password baru yang kuat untuk akun Anda.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    
                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="input-group-custom animate__animated animate__fadeInUp">
                        <label>Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" class="input-custom @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required readonly>
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group-custom animate__animated animate__fadeInUp">
                        <label>Password Baru</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" class="input-custom @error('password') is-invalid @enderror" placeholder="••••••••" required autofocus>
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="input-group-custom animate__animated animate__fadeInUp">
                        <label>Konfirmasi Password Baru</label>
                        <div class="input-wrapper">
                            <input type="password" name="password_confirmation" class="input-custom" placeholder="••••••••" required>
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit animate__animated animate__fadeInUp">
                        Perbarui Password
                    </button>
                </form>
            </div>
        </div>

        <div class="visual-side">
            <div class="bg-image"></div>
            <div class="visual-overlay">
                <div class="animate__animated animate__fadeInRight">
                    <h2>Masa Depan Menanti.</h2>
                    <p>Kembalilah merencanakan hari istimewa Anda dengan keamanan yang lebih baik.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

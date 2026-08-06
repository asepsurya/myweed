<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
<<<<<<< HEAD
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Masuk — WeddingInv</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
=======
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
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
<<<<<<< HEAD
            --gold: #C6A962;
            --gold-light: #E8D5A3;
            --gold-dark: #A68B4B;
            --navy: #1B2A4A;
            --navy-light: #2A3F6A;
            --white: #FFFFFF;
            --bg: #F7F5F2;
            --border: #E8E4DE;
            --border-focus: var(--gold);
            --text: #1B2A4A;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --error: #DC2626;
            --error-bg: #FEF2F2;
            --error-border: #FECACA;
            --success: #16A34A;
            --success-bg: #F0FDF4;
            --success-border: #BBF7D0;
            --radius: 12px;
            --radius-lg: 18px;
            --speed: 0.3s;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-display: 'Playfair Display', Georgia, serif;
        }

        html { height: 100%; }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(198,169,98,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -25%;
            left: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(27,42,74,0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ===== Card ===== */
        .login-card {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: cardIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ===== Header ===== */
        .card-header {
            padding: 2.5rem 2rem 0;
            text-align: center;
        }

        .card-brand {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.25rem;
            display: inline-block;
        }

        .card-brand span { color: var(--gold); }

        .card-header h1 {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--navy);
            line-height: 1.35;
            margin-bottom: 0.4rem;
        }

        .card-header p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* ===== Body ===== */
        .card-body {
            padding: 1.75rem 2rem 0.5rem;
        }

        /* ===== Session Alert ===== */
        .session-alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.84rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            animation: fadeUp 0.35s ease;
        }

        .session-alert.success {
            background: var(--success-bg);
            color: #166534;
            border: 1px solid var(--success-border);
        }

        .session-alert.error {
            background: var(--error-bg);
            color: #991B1B;
            border: 1px solid var(--error-border);
        }

        .session-alert i { font-size: 1rem; flex-shrink: 0; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== Form Field ===== */
        .field {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .field-input {
            width: 100%;
            height: 50px;
            padding: 0 2.75rem 0 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.9rem;
            color: var(--text);
            background: var(--bg);
            outline: none;
            transition: border-color var(--speed), box-shadow var(--speed), background var(--speed);
        }

        .field-input::placeholder { color: transparent; }

        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198,169,98,0.12);
            background: var(--white);
        }

        .field-label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.9rem;
            color: var(--text-muted);
            pointer-events: none;
            transition: all var(--speed) ease;
            background: var(--bg);
            padding: 0 0.3rem;
            border-radius: 4px;
        }

        .field-input:focus + .field-label,
        .field-input:not(:placeholder-shown) + .field-label {
            top: 0;
            transform: translateY(-50%) scale(0.82);
            color: var(--gold-dark);
            background: var(--white);
            font-weight: 500;
        }

        /* Valid state */
        .field-input.is-valid {
            border-color: var(--success);
            background: var(--success-bg);
        }
        .field-input.is-valid:focus {
            box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
            background: var(--white);
        }
        .field-input.is-valid + .field-label {
            color: var(--success);
        }

        /* Invalid state */
        .field-input.is-invalid {
            border-color: var(--error);
            background: var(--error-bg);
            animation: shake 0.4s ease;
        }
        .field-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
            background: var(--white);
        }
        .field-input.is-invalid + .field-label {
            color: var(--error);
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%  { transform: translateX(-5px); }
            40%  { transform: translateX(5px); }
            60%  { transform: translateX(-3px); }
            80%  { transform: translateX(3px); }
        }

        /* Field icon */
        .field-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1rem;
            pointer-events: none;
            transition: color var(--speed);
        }

        .field-input:focus ~ .field-icon { color: var(--gold-dark); }
        .field-input.is-valid ~ .field-icon { color: var(--success); }
        .field-input.is-invalid ~ .field-icon { color: var(--error); }

        /* Password toggle */
        .pwd-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 1rem;
            z-index: 2;
            transition: color var(--speed);
            line-height: 1;
        }
        .pwd-toggle:hover { color: var(--text); }

        .field.has-toggle .field-input { padding-right: 3rem; }
        .field.has-toggle .field-icon { right: 2.75rem; }

        /* Error message */
        .field-error {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.8rem;
            color: var(--error);
            padding-left: 0.25rem;
            margin-top: 0;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: all var(--speed) ease;
        }
        .field-error.show {
            opacity: 1;
            max-height: 2rem;
            margin-top: 0.4rem;
        }
        .field-error i { font-size: 0.85rem; flex-shrink: 0; }

        /* ===== Remember / Forgot Row ===== */
        .form-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check-input {
            width: 1rem;
            height: 1rem;
            border-radius: 4px;
            border: 1.5px solid var(--border);
            cursor: pointer;
            transition: all var(--speed);
        }
        .form-check-input:checked {
            background-color: var(--gold-dark);
            border-color: var(--gold-dark);
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(198,169,98,0.15);
            border-color: var(--gold);
        }

        .form-check-label {
            font-size: 0.84rem;
            color: var(--text-secondary);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--gold-dark);
            text-decoration: none;
            transition: color var(--speed);
        }
        .forgot-link:hover {
            color: var(--navy);
            text-decoration: underline;
        }

        /* ===== Buttons ===== */
        .btn-submit {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            transition: all var(--speed);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-submit:hover {
            box-shadow: 0 6px 20px rgba(198,169,98,0.35);
            transform: translateY(-1px);
        }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .btn-submit .spinner {
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: none;
        }
        .btn-submit.loading .spinner { display: block; }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ===== Divider ===== */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span {
            font-size: 0.78rem;
            color: var(--text-muted);
            white-space: nowrap;
        }

        /* ===== Google Button ===== */
        .btn-google {
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            background: var(--white);
            font-family: var(--font);
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text);
            cursor: pointer;
            text-decoration: none;
            transition: all var(--speed);
        }
        .btn-google:hover {
            border-color: #CBD5E1;
            background: var(--bg);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .btn-google img {
            width: 1.125rem;
            height: 1.125rem;
        }

        /* ===== Footer ===== */
        .card-footer {
            padding: 1.5rem 2rem 2rem;
            text-align: center;
            font-size: 0.84rem;
            color: var(--text-secondary);
        }
        .card-footer a {
            color: var(--gold-dark);
            font-weight: 600;
            text-decoration: none;
            transition: color var(--speed);
        }
        .card-footer a:hover {
            color: var(--navy);
            text-decoration: underline;
        }

        /* ===== Toast ===== */
        .toast-wrap {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .toast-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.2rem;
            border-radius: var(--radius);
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--white);
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            animation: toastIn 0.35s ease;
            min-width: 260px;
        }
        .toast-item.error   { background: var(--error); }
        .toast-item.success { background: var(--success); }

        .toast-item.out {
            animation: toastOut 0.3s ease forwards;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(100%); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes toastOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(100%); }
        }

        /* ===== Responsive ===== */
        @media (max-width: 480px) {
            body { padding: 1rem; }
            .card-header { padding: 2rem 1.5rem 0; }
            .card-body    { padding: 1.5rem 1.5rem 0.5rem; }
            .card-footer  { padding: 1.25rem 1.5rem 1.75rem; }
            .card-header h1 { font-size: 1.25rem; }
            .field-input { height: 48px; font-size: 0.875rem; }
            .btn-submit, .btn-google { height: 48px; }
        }

        @media (min-width: 1600px) {
            .login-card { max-width: 460px; }
        }
=======
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
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
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

<<<<<<< HEAD
<body>

    <div class="login-card">
        <!-- Header -->
        <div class="card-header">
            <div class="card-brand">Wedding<span>Inv</span>.</div>
            <h1>Masuk ke Akun Anda</h1>
            <p>Silakan masuk untuk mengelola undangan</p>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Session Status -->
            @if(session('status'))
                <div class="session-alert success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                <!-- Email -->
                <div class="field">
                    <input type="email"
                        class="field-input @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        placeholder=" "
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email">
                    <label class="field-label" for="email">Alamat Email</label>
                    <i class="bi bi-at field-icon"></i>
                    <div class="field-error {{ $errors->has('email') ? 'show' : '' }}" id="emailError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('email'){{ $message }}@enderror</span>
                    </div>
                </div>

                <!-- Password -->
                <div class="field has-toggle">
                    <input type="password"
                        class="field-input @error('password') is-invalid @enderror"
                        id="password"
                        name="password"
                        placeholder=" "
                        required
                        autocomplete="current-password">
                    <label class="field-label" for="password">Password</label>
                    <i class="bi bi-lock field-icon"></i>
                    <button type="button" class="pwd-toggle" id="togglePwd" aria-label="Tampilkan password">
                        <i class="bi bi-eye" id="pwdIcon"></i>
                    </button>
                    <div class="field-error {{ $errors->has('password') ? 'show' : '' }}" id="passwordError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('password'){{ $message }}@enderror</span>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="form-meta">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="loginBtn">
                    <span class="btn-text">Masuk</span>
                    <span class="spinner"></span>
                </button>
            </form>

            <!-- Divider -->
            <div class="divider"><span>atau lanjutkan dengan</span></div>

            <!-- Google -->
            <a href="{{ url('/auth/google') }}" class="btn-google">
                <img src="{{ asset('assets/img/g-logo.png') }}" alt="Google">
                Masuk dengan Google
            </a>
        </div>

        <!-- Footer -->
        <div class="card-footer">
            Belum punya akun? <a href="/register">Daftar sekarang</a>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-wrap" id="toastWrap"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form       = document.getElementById('loginForm');
            const btn        = document.getElementById('loginBtn');
            const btnText    = btn.querySelector('.btn-text');
            const email      = document.getElementById('email');
            const password   = document.getElementById('password');
            const emailErr   = document.getElementById('emailError');
            const pwdErr     = document.getElementById('passwordError');
            const togglePwd  = document.getElementById('togglePwd');
            const pwdIcon    = document.getElementById('pwdIcon');

            /* ── Helpers ── */
            function setError(input, errEl, msg) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                errEl.querySelector('span').textContent = msg;
                errEl.classList.add('show');
            }

            function clearState(input, errEl) {
                input.classList.remove('is-valid', 'is-invalid');
                errEl.classList.remove('show');
            }

            function setValid(input, errEl) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                errEl.classList.remove('show');
            }

            /* ── Validate ── */
            function checkEmail() {
                const v = email.value.trim();
                clearState(email, emailErr);
                if (!v) { setError(email, emailErr, 'Email tidak boleh kosong'); return false; }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { setError(email, emailErr, 'Format email tidak valid'); return false; }
                setValid(email, emailErr);
                return true;
            }

            function checkPassword() {
                const v = password.value;
                clearState(password, pwdErr);
                if (!v) { setError(password, pwdErr, 'Password tidak boleh kosong'); return false; }
                if (v.length < 6) { setError(password, pwdErr, 'Password minimal 6 karakter'); return false; }
                setValid(password, pwdErr);
                return true;
            }

            /* ── Events ── */
            email.addEventListener('blur', function () {
                if (this.value.trim()) checkEmail(); else clearState(email, emailErr);
            });
            email.addEventListener('input', function () {
                if (this.classList.contains('is-invalid')) checkEmail(); else clearState(email, emailErr);
            });

            password.addEventListener('blur', function () {
                if (this.value) checkPassword(); else clearState(password, pwdErr);
            });
            password.addEventListener('input', function () {
                if (this.classList.contains('is-invalid')) checkPassword(); else clearState(password, pwdErr);
            });

            /* ── Toggle Password ── */
            togglePwd.addEventListener('click', function () {
                const show = password.type === 'password';
                password.type = show ? 'text' : 'password';
                pwdIcon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            });

            /* ── Submit ── */
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const eOk = checkEmail();
                const pOk = checkPassword();
                if (!eOk || !pOk) {
                    (eOk ? password : email).focus();
                    return;
                }
                btnText.textContent = 'Memproses...';
                btn.classList.add('loading');
                btn.disabled = true;
                form.submit();
            });

            /* ── Session Toasts ── */
            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
            @endif
        });

        function showToast(message, type) {
            var wrap = document.getElementById('toastWrap');
            var el = document.createElement('div');
            el.className = 'toast-item ' + type;
            var icon = type === 'error' ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill';
            el.innerHTML = '<i class="bi ' + icon + '"></i> ' + message;
            wrap.appendChild(el);
            setTimeout(function () {
                el.classList.add('out');
                setTimeout(function () { el.remove(); }, 300);
            }, 4000);
        }
    </script>
=======
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
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
</body>
</html>
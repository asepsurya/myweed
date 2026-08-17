<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Reset Password — RuangUndang</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/fav.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --gold: #C6A962;
            --gold-light: #E8D5A3;
            --gold-dark: #A68B4B;
            --gold-pale: #F9F5EB;
            --navy: #1B2A4A;
            --navy-light: #2C3E5F;
            --white: #FFFFFF;
            --bg: #F5F3EF;
            --surface: #FAFAF8;
            --border: #E8E4DE;
            --border-light: #F0EBE3;
            --text: #1B2A4A;
            --text-secondary: #5A6478;
            --text-muted: #9CA3AF;
            --error: #DC2626;
            --error-bg: #FEF2F2;
            --error-border: #FECACA;
            --success: #16A34A;
            --success-bg: #F0FDF4;
            --success-border: #BBF7D0;
            --radius: 14px;
            --radius-lg: 20px;
            --radius-sm: 10px;
            --speed: 0.3s;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-display: 'Playfair Display', Georgia, serif;
        }

        html {
            height: 100%;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            background-image:
                radial-gradient(ellipse at 20% 10%, rgba(198, 169, 98, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 90%, rgba(27, 42, 74, 0.05) 0%, transparent 60%);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow-x: hidden;
        }

        /* ===== Card ===== */
        .login-card {
            width: 100%;
            max-width: 460px;
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            z-index: 1;
            animation: cardIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            box-shadow:
                0 1px 2px rgba(0, 0, 0, 0.04),
                0 4px 12px rgba(0, 0, 0, 0.04),
                0 16px 40px rgba(0, 0, 0, 0.06);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold), var(--gold-light), var(--gold), var(--gold-dark));
            z-index: 2;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ===== Header ===== */
        .card-header {
            padding: 2.5rem 2.25rem 0;
            text-align: center;
        }

        .card-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .card-logo img {
            width: 160px;
            /* Ukuran logo diatur disini */
            height: auto;
        }

        .header-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: var(--gold-pale);
            border: 1.5px solid var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.1rem;
            font-size: 1.5rem;
            color: var(--gold-dark);
            position: relative;
        }

        .header-icon::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.02));
            z-index: -1;
        }

        .card-header h1 {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--navy);
            line-height: 1.3;
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .card-header p {
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.65;
            max-width: 340px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ===== Body ===== */
        .card-body {
            padding: 2rem 2.25rem 0.5rem;
        }

        /* ===== Session Alert ===== */
        .session-alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.8rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.84rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            animation: fadeUp 0.4s ease;
            border: 1px solid transparent;
        }

        .session-alert.success {
            background: var(--success-bg);
            color: #166534;
            border-color: var(--success-border);
        }

        .session-alert.error {
            background: var(--error-bg);
            color: #991B1B;
            border-color: var(--error-border);
        }

        .session-alert i {
            font-size: 1rem;
            flex-shrink: 0;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== Info Box ===== */
        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem 1.1rem;
            border-radius: var(--radius-sm);
            background: var(--surface);
            border: 1px solid var(--border-light);
            margin-bottom: 1.75rem;
            animation: fadeUp 0.5s ease;
        }

        .info-box-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #D97706;
            flex-shrink: 0;
        }

        .info-box-body {
            flex: 1;
        }

        .info-box-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.15rem;
        }

        .info-box p {
            font-size: 0.8rem;
            color: var(--text-secondary);
            line-height: 1.55;
            margin: 0;
        }

        /* ===== Form Field ===== */
        .field {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .field-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .field-input {
            width: 100%;
            height: 52px;
            padding: 0 2.75rem 0 2.75rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text);
            background: var(--white);
            outline: none;
            transition: border-color var(--speed), box-shadow var(--speed), background var(--speed);
        }

        .field-input::placeholder {
            color: transparent;
        }

        .field-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(198, 169, 98, 0.1), 0 1px 2px rgba(0, 0, 0, 0.02);
            background: var(--white);
        }

        .field-label {
            position: absolute;
            left: 2.75rem;
            top: 26px;
            /* Ubah dari 50% menjadi 26px (setengah dari tinggi input 52px) */
            transform: translateY(-50%);
            font-size: 0.88rem;
            color: var(--text-muted);
            pointer-events: none;
            transition: all var(--speed) ease;
            background: var(--white);
            padding: 0 0.35rem;
            border-radius: 4px;
            font-weight: 500;
            z-index: 2;
        }

        /* Floating Label Effect */
        .field-input:focus+.field-label,
        .field-input:not(:placeholder-shown)+.field-label {
            top: 0;
            transform: translateY(-50%) scale(0.82);
            color: var(--gold-dark);
            font-weight: 600;
        }

        .field-icon-left {
            position: absolute;
            left: 1rem;
            top: 26px;
            /* Samakan dengan posisi label */
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
            pointer-events: none;
            transition: color var(--speed);
            z-index: 2;
        }

        .field-input:focus~.field-icon-left {
            color: var(--gold-dark);
        }

        /* Valid */
        .field-input.is-valid {
            border-color: var(--success);
            background: var(--success-bg);
        }

        .field-input.is-valid:focus {
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.08);
            background: var(--white);
        }

        .field-input.is-valid+.field-label {
            color: var(--success);
        }

        .field-input.is-valid~.field-icon-left {
            color: var(--success);
        }

        /* Invalid */
        .field-input.is-invalid {
            border-color: var(--error);
            background: var(--error-bg);
            animation: shake 0.4s ease;
        }

        .field-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
            background: var(--white);
        }

        .field-input.is-invalid+.field-label {
            color: var(--error);
        }

        .field-input.is-invalid~.field-icon-left {
            color: var(--error);
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-4px);
            }

            40% {
                transform: translateX(4px);
            }

            60% {
                transform: translateX(-2px);
            }

            80% {
                transform: translateX(2px);
            }
        }

        /* Password toggle */
        .pwd-toggle {
            position: absolute;
            right: 0.85rem;
            top: 26px;
            /* Samakan dengan posisi label */
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 6px;
            font-size: 0.95rem;
            z-index: 2;
            transition: color var(--speed);
            line-height: 1;
            border-radius: 6px;
        }

        .pwd-toggle:hover {
            color: var(--text);
            background: var(--bg);
        }

        /* Error message */
        .field-error {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.78rem;
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

        .field-error i {
            font-size: 0.82rem;
            flex-shrink: 0;
        }

        /* ===== Password Strength ===== */
        .pwd-strength-wrap {
            margin-top: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .pwd-strength {
            display: flex;
            gap: 5px;
            margin-bottom: 0.35rem;
        }

        .pwd-strength-bar {
            flex: 1;
            height: 4px;
            border-radius: 4px;
            background: var(--border);
            transition: background 0.3s ease;
        }

        .pwd-strength-bar.active-weak {
            background: #EF4444;
        }

        .pwd-strength-bar.active-medium {
            background: #F59E0B;
        }

        .pwd-strength-bar.active-strong {
            background: #22C55E;
        }

        .pwd-strength-text {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--text-muted);
            transition: color var(--speed);
            min-height: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .pwd-strength-text i {
            font-size: 0.75rem;
        }

        .pwd-strength-text.weak {
            color: #EF4444;
        }

        .pwd-strength-text.medium {
            color: #F59E0B;
        }

        .pwd-strength-text.strong {
            color: #22C55E;
        }

        /* ===== Button ===== */
        .btn-submit {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
            color: var(--white);
            transition: all var(--speed);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            box-shadow: 0 8px 24px rgba(27, 42, 74, 0.25);
            transform: translateY(-1px);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-submit .spinner {
            width: 1.1rem;
            height: 1.1rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-top-color: var(--white);
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        .btn-submit.loading .spinner {
            display: block;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ===== Footer ===== */
        .card-footer {
            padding: 1.5rem 2.25rem 2rem;
            text-align: center;
            font-size: 0.84rem;
            color: var(--text-secondary);
        }

        .card-footer a {
            color: var(--navy);
            font-weight: 600;
            text-decoration: none;
            transition: color var(--speed);
            position: relative;
        }

        .card-footer a::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 0;
            height: 1.5px;
            background: var(--gold);
            transition: width var(--speed);
        }

        .card-footer a:hover {
            color: var(--gold-dark);
        }

        .card-footer a:hover::after {
            width: 100%;
        }

        /* ===== Toast ===== */
        .toast-wrap {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .toast-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 1.25rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--white);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            animation: toastIn 0.4s cubic-bezier(0.22, 1, 0.36, 1);
            min-width: 280px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .toast-item.error {
            background: var(--error);
        }

        .toast-item.success {
            background: var(--success);
        }

        .toast-item.out {
            animation: toastOut 0.3s ease forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateX(120%) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        @keyframes toastOut {
            from {
                opacity: 1;
                transform: translateX(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateX(120%) scale(0.95);
            }
        }

        /* ===== Responsive ===== */
        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }

            .card-header {
                padding: 2rem 1.5rem 0;
            }

            .card-body {
                padding: 1.75rem 1.5rem 0.5rem;
            }

            .card-footer {
                padding: 1.25rem 1.5rem 1.75rem;
            }

            .card-header h1 {
                font-size: 1.3rem;
            }

            .card-header p {
                font-size: 0.84rem;
            }

            .field-input {
                height: 50px;
                font-size: 0.875rem;
            }

            /* Setengah dari 50px adalah 25px */
            .field-label,
            .field-icon-left,
            .pwd-toggle {
                top: 25px;
            }

            .btn-submit {
                height: 50px;
            }

            .header-icon {
                width: 56px;
                height: 56px;
                font-size: 1.3rem;
            }
        }

        @media (min-width: 1600px) {
            .login-card {
                max-width: 480px;
            }
        }
    </style>
</head>

<body>
    <div class="login-card">
        <!-- Header -->
        <div class="card-header">
            <div class="card-logo">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo RuangUndang">
            </div>
            <div class="header-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h1>Atur Ulang Password</h1>
            <p>Buat password baru yang kuat untuk melindungi akun Anda.</p>
        </div>

        <!-- Body -->
        <div class="card-body">
            @if(session('status'))
                <div class="session-alert success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="session-alert error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Info box -->
            <div class="info-box">
                <div class="info-box-icon">
                    <i class="bi bi-lightbulb-fill"></i>
                </div>
                <div class="info-box-body">
                    <div class="info-box-title">Tips Password Kuat</div>
                    <p>Gunakan kombinasi huruf besar, kecil, angka, dan karakter spesial. Minimal 8 karakter.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('password.store') }}" id="resetForm" novalidate>
                @csrf

                <!-- Hidden Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="field has-icon">
                    <div class="field-input-wrap">
                        <input type="email" class="field-input @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder=" " value="{{ old('email', $request->email) }}" required autofocus
                            autocomplete="username">
                        <label class="field-label" for="email">Alamat Email</label>
                        <i class="bi bi-at field-icon-left"></i>
                    </div>
                    <div class="field-error {{ $errors->has('email') ? 'show' : '' }}" id="emailError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('email'){{ $message }}@enderror</span>
                    </div>
                </div>

                <!-- Password -->
                <div class="field has-toggle has-icon">
                    <div class="field-input-wrap">
                        <input type="password" class="field-input @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder=" " required autocomplete="new-password">
                        <label class="field-label" for="password">Password Baru</label>
                        <i class="bi bi-lock field-icon-left"></i>
                        <button type="button" class="pwd-toggle" data-target="password" aria-label="Tampilkan password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="field-error {{ $errors->has('password') ? 'show' : '' }}" id="passwordError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('password'){{ $message }}@enderror</span>
                    </div>
                    <div class="pwd-strength-wrap">
                        <div class="pwd-strength" id="pwdStrength">
                            <div class="pwd-strength-bar" id="bar1"></div>
                            <div class="pwd-strength-bar" id="bar2"></div>
                            <div class="pwd-strength-bar" id="bar3"></div>
                            <div class="pwd-strength-bar" id="bar4"></div>
                        </div>
                        <div class="pwd-strength-text" id="pwdStrengthText"></div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="field has-toggle has-icon">
                    <div class="field-input-wrap">
                        <input type="password" class="field-input @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation" placeholder=" " required
                            autocomplete="new-password">
                        <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
                        <i class="bi bi-lock-fill field-icon-left"></i>
                        <button type="button" class="pwd-toggle" data-target="password_confirmation"
                            aria-label="Tampilkan password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="field-error {{ $errors->has('password_confirmation') ? 'show' : '' }}"
                        id="confirmError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('password_confirmation'){{ $message }}@enderror</span>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-text">Reset Password</span>
                    <span class="spinner"></span>
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="card-footer">
            <a href="{{ route('login') }}">Kembali ke halaman login</a>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-wrap" id="toastWrap"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('resetForm');
            const btn = document.getElementById('submitBtn');
            const btnText = btn.querySelector('.btn-text');
            const emailEl = document.getElementById('email');
            const pwdEl = document.getElementById('password');
            const confEl = document.getElementById('password_confirmation');
            const emailErr = document.getElementById('emailError');
            const pwdErr = document.getElementById('passwordError');
            const confErr = document.getElementById('confirmError');
            const bars = [
                document.getElementById('bar1'),
                document.getElementById('bar2'),
                document.getElementById('bar3'),
                document.getElementById('bar4')
            ];
            const strText = document.getElementById('pwdStrengthText');

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

            /* ── Password Strength ── */
            function getStrength(pwd) {
                let score = 0;
                if (pwd.length >= 6) score++;
                if (pwd.length >= 8) score++;
                if (/[A-Z]/.test(pwd) && /[a-z]/.test(pwd)) score++;
                if (/\d/.test(pwd)) score++;
                if (/[^A-Za-z0-9]/.test(pwd)) score++;
                return Math.min(score, 4);
            }

            function updateStrength(pwd) {
                let s = getStrength(pwd);
                bars.forEach(function (b, i) {
                    b.className = 'pwd-strength-bar';
                    if (i < s) {
                        if (s <= 1) b.classList.add('active-weak');
                        else if (s <= 2) b.classList.add('active-medium');
                        else b.classList.add('active-strong');
                    }
                });
                strText.className = 'pwd-strength-text';
                if (pwd.length === 0) { strText.textContent = ''; return; }
                if (s <= 1) { strText.innerHTML = '<i class="bi bi-shield-x"></i> Lemah — tambahkan huruf & angka'; strText.classList.add('weak'); }
                else if (s <= 2) { strText.innerHTML = '<i class="bi bi-shield-plus"></i> Cukup — tambahkan karakter spesial'; strText.classList.add('medium'); }
                else if (s <= 3) { strText.innerHTML = '<i class="bi bi-shield-check"></i> Kuat'; strText.classList.add('strong'); }
                else { strText.innerHTML = '<i class="bi bi-shield-lock"></i> Sangat kuat'; strText.classList.add('strong'); }
            }

            /* ── Validate ── */
            function checkEmail() {
                let v = emailEl.value.trim();
                clearState(emailEl, emailErr);
                if (!v) { setError(emailEl, emailErr, 'Email tidak boleh kosong'); return false; }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { setError(emailEl, emailErr, 'Format email tidak valid'); return false; }
                setValid(emailEl, emailErr);
                return true;
            }

            function checkPassword() {
                let v = pwdEl.value;
                clearState(pwdEl, pwdErr);
                if (!v) { setError(pwdEl, pwdErr, 'Password tidak boleh kosong'); return false; }
                if (v.length < 8) { setError(pwdEl, pwdErr, 'Password minimal 8 karakter'); return false; }
                setValid(pwdEl, pwdErr);
                return true;
            }

            function checkConfirm() {
                let v = confEl.value;
                clearState(confEl, confErr);
                if (!v) { setError(confEl, confErr, 'Konfirmasi password tidak boleh kosong'); return false; }
                if (v !== pwdEl.value) { setError(confEl, confErr, 'Password tidak cocok'); return false; }
                setValid(confEl, confErr);
                return true;
            }

            /* ── Field Events ── */
            function bindField(input, errEl, checkFn) {
                input.addEventListener('blur', function () {
                    if (this.value.trim() || this.value) checkFn(); else clearState(input, errEl);
                });
                input.addEventListener('input', function () {
                    if (this.classList.contains('is-invalid')) checkFn(); else clearState(input, errEl);
                });
            }

            bindField(emailEl, emailErr, checkEmail);
            bindField(pwdEl, pwdErr, checkPassword);
            bindField(confEl, confErr, checkConfirm);

            /* Password strength */
            pwdEl.addEventListener('input', function () { updateStrength(this.value); });

            /* Re-check confirm when password changes */
            pwdEl.addEventListener('input', function () {
                if (confEl.value && confEl.classList.contains('is-valid')) checkConfirm();
            });

            /* ── Password Toggles ── */
            document.querySelectorAll('.pwd-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    let target = document.getElementById(this.getAttribute('data-target'));
                    let icon = this.querySelector('i');
                    let show = target.type === 'password';
                    target.type = show ? 'text' : 'password';
                    icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                });
            });

            /* ── Submit ── */
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                let em = checkEmail();
                let p = checkPassword();
                let c = checkConfirm();

                if (!em || !p || !c) {
                    if (!em) emailEl.focus();
                    else if (!p) pwdEl.focus();
                    else confEl.focus();
                    return;
                }

                btnText.textContent = 'Menyimpan...';
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
            let wrap = document.getElementById('toastWrap');
            let el = document.createElement('div');
            el.className = 'toast-item ' + type;
            let icon = type === 'error' ? 'bi-exclamation-triangle-fill' : 'bi-check-circle-fill';
            el.innerHTML = '<i class="bi ' + icon + '"></i> ' + message;
            wrap.appendChild(el);
            setTimeout(function () {
                el.classList.add('out');
                setTimeout(function () { el.remove(); }, 300);
            }, 4000);
        }
    </script>
</body>

</html>
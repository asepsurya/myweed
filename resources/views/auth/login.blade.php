<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <!-- Perbaikan viewport untuk mencegah zoom dan geser tidak sengaja -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Masuk — RuangUndang</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/fav.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

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

        /* Perbaikan mencegah horizontal scroll di mobile */
        html, body {
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        html {
            height: 100%;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            min-height: 100dvh;
            min-height: -webkit-fill-available;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Elemen dekoratif diubah menjadi fixed agar tidak memperlebar body */
        body::before {
            content: '';
            position: fixed; /* Ubah dari absolute ke fixed */
            top: -30%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(198, 169, 98, 0.07) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed; /* Ubah dari absolute ke fixed */
            bottom: -25%;
            left: -15%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(27, 42, 74, 0.04) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
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
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ===== Header ===== */
        .card-header {
            padding: 2.5rem 2rem 0;
            text-align: center;
        }

        .card-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .card-logo img {
            width: 160px;
            height: auto;
        }

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

        .session-alert i {
            font-size: 1rem;
            flex-shrink: 0;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
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
            box-shadow: 0 0 0 3px rgba(198, 169, 98, 0.12);
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

        .field-input:focus+.field-label,
        .field-input:not(:placeholder-shown)+.field-label {
            top: 0;
            transform: translateY(-50%) scale(0.82);
            color: var(--gold-dark);
            background: var(--white);
            font-weight: 500;
        }

        .field-input.is-valid { border-color: var(--success); background: var(--success-bg); }
        .field-input.is-valid:focus { box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1); background: var(--white); }
        .field-input.is-valid+.field-label { color: var(--success); }

        .field-input.is-invalid { border-color: var(--error); background: var(--error-bg); animation: shake 0.4s ease; }
        .field-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1); background: var(--white); }
        .field-input.is-invalid+.field-label { color: var(--error); }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20% { transform: translateX(-5px); }
            40% { transform: translateX(5px); }
            60% { transform: translateX(-3px); }
            80% { transform: translateX(3px); }
        }

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

        .field-input:focus~.field-icon { color: var(--gold-dark); }
        .field-input.is-valid~.field-icon { color: var(--success); }
        .field-input.is-invalid~.field-icon { color: var(--error); }

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

        .field-error.show { opacity: 1; max-height: 2rem; margin-top: 0.4rem; }
        .field-error i { font-size: 0.85rem; flex-shrink: 0; }

        .form-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .form-check { display: flex; align-items: center; gap: 0.5rem; }
        .form-check-input {
            width: 1rem; height: 1rem; border-radius: 4px;
            border: 1.5px solid var(--border); cursor: pointer; transition: all var(--speed);
        }
        .form-check-input:checked { background-color: var(--gold-dark); border-color: var(--gold-dark); }
        .form-check-input:focus { box-shadow: 0 0 0 3px rgba(198, 169, 98, 0.15); border-color: var(--gold); }
        .form-check-label { font-size: 0.84rem; color: var(--text-secondary); cursor: pointer; }

        .forgot-link {
            font-size: 0.84rem; font-weight: 500; color: var(--gold-dark);
            text-decoration: none; transition: color var(--speed);
        }
        .forgot-link:hover { color: var(--navy); text-decoration: underline; }

        .btn-submit {
            width: 100%; height: 50px; border: none; border-radius: var(--radius);
            font-family: var(--font); font-size: 0.9rem; font-weight: 600; cursor: pointer;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: var(--white);
            transition: all var(--speed); display: flex; align-items: center; justify-content: center; gap: 0.5rem;
        }
        .btn-submit:hover { box-shadow: 0 6px 20px rgba(198, 169, 98, 0.35); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.65; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-submit .spinner {
            width: 1rem; height: 1rem; border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: var(--white); border-radius: 50%; animation: spin 0.6s linear infinite; display: none;
        }
        .btn-submit.loading .spinner { display: block; }

        @keyframes spin { to { transform: rotate(360deg); } }

        .divider { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 0.78rem; color: var(--text-muted); white-space: nowrap; }

        .btn-google {
            width: 100%; height: 50px; display: flex; align-items: center; justify-content: center;
            gap: 0.6rem; border: 1.5px solid var(--border); border-radius: var(--radius);
            background: var(--white); font-family: var(--font); font-size: 0.9rem; font-weight: 500;
            color: var(--text); cursor: pointer; text-decoration: none; transition: all var(--speed);
        }
        .btn-google:hover { border-color: #CBD5E1; background: var(--bg); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04); }
        .btn-google img { width: 1.125rem; height: 1.125rem; }

        .card-footer { padding: 1.5rem 2rem 2rem; text-align: center; font-size: 0.84rem; color: var(--text-secondary); }
        .card-footer a { color: var(--gold-dark); font-weight: 600; text-decoration: none; transition: color var(--speed); }
        .card-footer a:hover { color: var(--navy); text-decoration: underline; }

        .toast-wrap {
            position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999;
            display: flex; flex-direction: column; gap: 0.5rem; max-width: calc(100% - 2.5rem);
        }
        .toast-item {
            display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.2rem; border-radius: var(--radius);
            font-size: 0.84rem; font-weight: 500; color: var(--white); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: toastIn 0.35s ease; min-width: 260px;
        }
        .toast-item.error { background: var(--error); }
        .toast-item.success { background: var(--success); }
        .toast-item.out { animation: toastOut 0.3s ease forwards; }

        @keyframes toastIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(100%); } }

        @media (max-width: 480px) {
            body { padding: 1rem; }
            .card-header { padding: 2rem 1.25rem 0; }
            .card-body { padding: 1.5rem 1.25rem 0.5rem; }
            .card-footer { padding: 1.25rem 1.25rem 1.75rem; }
            .card-header h1 { font-size: 1.2rem; }
            .field-input { height: 48px; font-size: 0.875rem; }
            .btn-submit, .btn-google { height: 48px; }
            .toast-item { min-width: auto; width: 100%; }
        }

        @media (max-width: 360px) {
            body { padding: 0.75rem; }
            .card-header { padding: 1.5rem 1rem 0; }
            .card-body { padding: 1.25rem 1rem 0.5rem; }
            .card-footer { padding: 1rem 1rem 1.5rem; }
            .card-logo img { width: 130px; }
        }

        @media (min-width: 1600px) {
            .login-card { max-width: 460px; }
        }
    </style>
</head>

<body>

    <div class="login-card">
        <!-- Header -->
        <div class="card-header">
            <div class="card-logo">
                <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
            </div>
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
                    <input type="email" class="field-input @error('email') is-invalid @enderror" id="email" name="email" placeholder=" " value="{{ old('email') }}" required autofocus autocomplete="email">
                    <label class="field-label" for="email">Alamat Email</label>
                    <i class="bi bi-at field-icon"></i>
                    <div class="field-error {{ $errors->has('email') ? 'show' : '' }}" id="emailError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('email'){{ $message }}@enderror</span>
                    </div>
                </div>

                <!-- Password -->
                <div class="field has-toggle">
                    <input type="password" class="field-input @error('password') is-invalid @enderror" id="password" name="password" placeholder=" " required autocomplete="current-password">
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
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
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
            const form = document.getElementById('loginForm');
            const btn = document.getElementById('loginBtn');
            const btnText = btn.querySelector('.btn-text');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const emailErr = document.getElementById('emailError');
            const pwdErr = document.getElementById('passwordError');
            const togglePwd = document.getElementById('togglePwd');
            const pwdIcon = document.getElementById('pwdIcon');

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
</body>

</html>
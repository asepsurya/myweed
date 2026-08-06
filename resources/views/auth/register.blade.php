<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Daftar — WeddingInv</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold: #C6A962;
            --gold-light: #E8D5A3;
            --gold-dark: #A68B4B;
            --navy: #1B2A4A;
            --white: #FFFFFF;
            --bg: #F7F5F2;
            --border: #E8E4DE;
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
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -30%; right: -20%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(198,169,98,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: -25%; left: -15%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(27,42,74,0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ===== Card ===== */
        .login-card {
            width: 100%;
            max-width: 440px;
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
            padding: 2.25rem 2rem 0;
            text-align: center;
        }

        .card-brand {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.1rem;
            display: inline-block;
        }
        .card-brand span { color: var(--gold); }

        .card-header h1 {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--navy);
            line-height: 1.35;
            margin-bottom: 0.35rem;
        }

        .card-header p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* ===== Body ===== */
        .card-body {
            padding: 1.5rem 2rem 0.5rem;
        }

        /* ===== Session Alert ===== */
        .session-alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.7rem 1rem;
            border-radius: var(--radius);
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.15rem;
            animation: fadeUp 0.35s ease;
        }
        .session-alert.success { background: var(--success-bg); color: #166534; border: 1px solid var(--success-border); }
        .session-alert.error   { background: var(--error-bg); color: #991B1B; border: 1px solid var(--error-border); }
        .session-alert i { font-size: 0.95rem; flex-shrink: 0; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== Form Field ===== */
        .field {
            position: relative;
            margin-bottom: 1.15rem;
        }

        .field-input {
            width: 100%;
            height: 48px;
            padding: 0 2.75rem 0 1rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.88rem;
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
            font-size: 0.88rem;
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

        /* Valid */
        .field-input.is-valid { border-color: var(--success); background: var(--success-bg); }
        .field-input.is-valid:focus { box-shadow: 0 0 0 3px rgba(22,163,74,0.1); background: var(--white); }
        .field-input.is-valid + .field-label { color: var(--success); }

        /* Invalid */
        .field-input.is-invalid { border-color: var(--error); background: var(--error-bg); animation: shake 0.4s ease; }
        .field-input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(220,38,38,0.1); background: var(--white); }
        .field-input.is-invalid + .field-label { color: var(--error); }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%  { transform: translateX(-5px); }
            40%  { transform: translateX(5px); }
            60%  { transform: translateX(-3px); }
            80%  { transform: translateX(3px); }
        }

        /* Icon */
        .field-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
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
            font-size: 0.95rem;
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
            gap: 0.3rem;
            font-size: 0.78rem;
            color: var(--error);
            padding-left: 0.25rem;
            margin-top: 0;
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            transition: all var(--speed) ease;
        }
        .field-error.show { opacity: 1; max-height: 2rem; margin-top: 0.35rem; }
        .field-error i { font-size: 0.82rem; flex-shrink: 0; }

        /* ===== Password Strength ===== */
        .pwd-strength {
            display: flex;
            gap: 4px;
            margin-top: 0.5rem;
            margin-bottom: 0.25rem;
        }
        .pwd-strength-bar {
            flex: 1;
            height: 3px;
            border-radius: 3px;
            background: var(--border);
            transition: background var(--speed);
        }
        .pwd-strength-bar.active-weak   { background: #EF4444; }
        .pwd-strength-bar.active-medium { background: #F59E0B; }
        .pwd-strength-bar.active-strong { background: #22C55E; }

        .pwd-strength-text {
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.15rem;
            transition: color var(--speed);
            min-height: 1rem;
        }
        .pwd-strength-text.weak   { color: #EF4444; }
        .pwd-strength-text.medium { color: #F59E0B; }
        .pwd-strength-text.strong { color: #22C55E; }

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
            margin-top: 0.5rem;
        }
        .btn-submit:hover {
            box-shadow: 0 6px 20px rgba(198,169,98,0.35);
            transform: translateY(-1px);
        }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.65; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-submit .spinner {
            width: 1rem; height: 1rem;
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
            margin: 1.35rem 0;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span { font-size: 0.78rem; color: var(--text-muted); white-space: nowrap; }

        /* ===== Google Button ===== */
        .btn-google {
            width: 100%;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            background: var(--white);
            font-family: var(--font);
            font-size: 0.88rem;
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
        .btn-google img { width: 1.1rem; height: 1.1rem; }

        /* ===== Terms ===== */
        .terms-text {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 1rem;
            line-height: 1.55;
        }
        .terms-text a {
            color: var(--gold-dark);
            font-weight: 500;
            text-decoration: none;
            transition: color var(--speed);
        }
        .terms-text a:hover { color: var(--navy); text-decoration: underline; }

        /* ===== Footer ===== */
        .card-footer {
            padding: 1.25rem 2rem 1.75rem;
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
        .card-footer a:hover { color: var(--navy); text-decoration: underline; }

        /* ===== Toast ===== */
        .toast-wrap {
            position: fixed;
            top: 1.25rem; right: 1.25rem;
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
        .toast-item.out { animation: toastOut 0.3s ease forwards; }

        @keyframes toastIn  { from { opacity:0; transform:translateX(100%); } to { opacity:1; transform:translateX(0); } }
        @keyframes toastOut { from { opacity:1; transform:translateX(0); } to { opacity:0; transform:translateX(100%); } }

        /* ===== Responsive ===== */
        @media (max-width: 480px) {
            body { padding: 1rem; }
            .card-header { padding: 1.75rem 1.5rem 0; }
            .card-body    { padding: 1.25rem 1.5rem 0.5rem; }
            .card-footer  { padding: 1.1rem 1.5rem 1.5rem; }
            .card-header h1 { font-size: 1.2rem; }
            .field-input { height: 46px; font-size: 0.85rem; }
            .btn-submit, .btn-google { height: 46px; }
        }

        @media (min-width: 1600px) {
            .login-card { max-width: 480px; }
        }
    </style>
</head>

<body>

    <div class="login-card">
        <!-- Header -->
        <div class="card-header">
            <div class="card-brand">Wedding<span>Inv</span>.</div>
            <h1>Buat Akun Baru</h1>
            <p>Daftar untuk mulai membuat undangan impianmu</p>
        </div>

        <!-- Body -->
        <div class="card-body">

            @if(session('status'))
                <div class="session-alert success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                @csrf

                <!-- Name -->
                <div class="field">
                    <input type="text"
                        class="field-input @error('name') is-invalid @enderror"
                        id="name"
                        name="name"
                        placeholder=" "
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name">
                    <label class="field-label" for="name">Nama Lengkap</label>
                    <i class="bi bi-person field-icon"></i>
                    <div class="field-error {{ $errors->has('name') ? 'show' : '' }}" id="nameError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('name'){{ $message }}@enderror</span>
                    </div>
                </div>

                <!-- Email -->
                <div class="field">
                    <input type="email"
                        class="field-input @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        placeholder=" "
                        value="{{ old('email') }}"
                        required
                        autocomplete="username">
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
                        autocomplete="new-password">
                    <label class="field-label" for="password">Password</label>
                    <i class="bi bi-lock field-icon"></i>
                    <button type="button" class="pwd-toggle" data-target="password" aria-label="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                    <div class="field-error {{ $errors->has('password') ? 'show' : '' }}" id="passwordError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('password'){{ $message }}@enderror</span>
                    </div>
                    <div class="pwd-strength" id="pwdStrength">
                        <div class="pwd-strength-bar" id="bar1"></div>
                        <div class="pwd-strength-bar" id="bar2"></div>
                        <div class="pwd-strength-bar" id="bar3"></div>
                        <div class="pwd-strength-bar" id="bar4"></div>
                    </div>
                    <div class="pwd-strength-text" id="pwdStrengthText"></div>
                </div>

                <!-- Confirm Password -->
                <div class="field has-toggle">
                    <input type="password"
                        class="field-input @error('password_confirmation') is-invalid @enderror"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder=" "
                        required
                        autocomplete="new-password">
                    <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
                    <i class="bi bi-lock-fill field-icon"></i>
                    <button type="button" class="pwd-toggle" data-target="password_confirmation" aria-label="Tampilkan password">
                        <i class="bi bi-eye"></i>
                    </button>
                    <div class="field-error {{ $errors->has('password_confirmation') ? 'show' : '' }}" id="confirmError">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>@error('password_confirmation'){{ $message }}@enderror</span>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="registerBtn">
                    <span class="btn-text">Daftar Sekarang</span>
                    <span class="spinner"></span>
                </button>
            </form>

            <!-- Divider -->
            <div class="divider"><span>atau daftar dengan</span></div>

            <!-- Google -->
            <a href="{{ url('/auth/google') }}" class="btn-google">
                <img src="{{ asset('assets/img/g-logo.png') }}" alt="Google">
                Daftar dengan Google
            </a>

            <!-- Terms -->
            <p class="terms-text">
                Dengan mendaftar, Anda menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a> kami.
            </p>
        </div>

        <!-- Footer -->
        <div class="card-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-wrap" id="toastWrap"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form     = document.getElementById('registerForm');
            const btn      = document.getElementById('registerBtn');
            const btnText  = btn.querySelector('.btn-text');
            const nameEl   = document.getElementById('name');
            const emailEl  = document.getElementById('email');
            const pwdEl    = document.getElementById('password');
            const confEl   = document.getElementById('password_confirmation');
            const nameErr  = document.getElementById('nameError');
            const emailErr = document.getElementById('emailError');
            const pwdErr   = document.getElementById('passwordError');
            const confErr  = document.getElementById('confirmError');
            const bars     = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
            const strText  = document.getElementById('pwdStrengthText');

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
                var score = 0;
                if (pwd.length >= 6) score++;
                if (pwd.length >= 8) score++;
                if (/[A-Z]/.test(pwd) && /[a-z]/.test(pwd)) score++;
                if (/\d/.test(pwd)) score++;
                if (/[^A-Za-z0-9]/.test(pwd)) score++;
                return Math.min(score, 4);
            }

            function updateStrength(pwd) {
                var s = getStrength(pwd);
                bars.forEach(function (b, i) {
                    b.className = 'pwd-strength-bar';
                    if (i < s) {
                        if (s <= 1)      b.classList.add('active-weak');
                        else if (s <= 2) b.classList.add('active-medium');
                        else             b.classList.add('active-strong');
                    }
                });
                strText.className = 'pwd-strength-text';
                if (pwd.length === 0) { strText.textContent = ''; return; }
                if (s <= 1)      { strText.textContent = 'Lemah — tambahkan huruf & angka'; strText.classList.add('weak'); }
                else if (s <= 2) { strText.textContent = 'Cukup — tambahkan karakter spesial'; strText.classList.add('medium'); }
                else if (s <= 3) { strText.textContent = 'Kuat'; strText.classList.add('strong'); }
                else             { strText.textContent = 'Sangat kuat'; strText.classList.add('strong'); }
            }

            /* ── Validate ── */
            function checkName() {
                var v = nameEl.value.trim();
                clearState(nameEl, nameErr);
                if (!v) { setError(nameEl, nameErr, 'Nama tidak boleh kosong'); return false; }
                if (v.length < 2) { setError(nameEl, nameErr, 'Nama minimal 2 karakter'); return false; }
                setValid(nameEl, nameErr);
                return true;
            }

            function checkEmail() {
                var v = emailEl.value.trim();
                clearState(emailEl, emailErr);
                if (!v) { setError(emailEl, emailErr, 'Email tidak boleh kosong'); return false; }
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) { setError(emailEl, emailErr, 'Format email tidak valid'); return false; }
                setValid(emailEl, emailErr);
                return true;
            }

            function checkPassword() {
                var v = pwdEl.value;
                clearState(pwdEl, pwdErr);
                if (!v) { setError(pwdEl, pwdErr, 'Password tidak boleh kosong'); return false; }
                if (v.length < 8) { setError(pwdEl, pwdErr, 'Password minimal 8 karakter'); return false; }
                setValid(pwdEl, pwdErr);
                return true;
            }

            function checkConfirm() {
                var v = confEl.value;
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

            bindField(nameEl, nameErr, checkName);
            bindField(emailEl, emailErr, checkEmail);
            bindField(pwdEl, pwdErr, checkPassword);
            bindField(confEl, confErr, checkConfirm);

            /* Password strength on input */
            pwdEl.addEventListener('input', function () { updateStrength(this.value); });

            /* Re-check confirm when password changes */
            pwdEl.addEventListener('input', function () {
                if (confEl.value && confEl.classList.contains('is-valid')) {
                    checkConfirm();
                }
            });

            /* ── Password Toggles ── */
            document.querySelectorAll('.pwd-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var target = document.getElementById(this.getAttribute('data-target'));
                    var icon = this.querySelector('i');
                    var show = target.type === 'password';
                    target.type = show ? 'text' : 'password';
                    icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
                });
            });

            /* ── Submit ── */
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var n = checkName();
                var em = checkEmail();
                var p = checkPassword();
                var c = checkConfirm();

                if (!n || !em || !p || !c) {
                    if (!n) nameEl.focus();
                    else if (!em) emailEl.focus();
                    else if (!p) pwdEl.focus();
                    else confEl.focus();
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
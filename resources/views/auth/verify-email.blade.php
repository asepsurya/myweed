<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Verifikasi Email — RuangUndang</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/fav-icon.png') }}">

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
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
            border: 2px solid #FDE68A;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.75rem;
            color: #D97706;
            position: relative;
            box-shadow: 0 4px 16px rgba(217, 119, 6, 0.12);
        }

        .header-icon::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.08) 0%, transparent 70%);
            z-index: -1;
            animation: pulse-ring 2.5s ease-in-out infinite;
        }

        @keyframes pulse-ring {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.08);
                opacity: 0.3;
            }
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

        /* ===== Success Alert ===== */
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

        /* ===== Email Preview ===== */
        .email-preview {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem 1.1rem;
            border-radius: var(--radius-sm);
            background: var(--surface);
            border: 1.5px solid var(--border);
            margin-bottom: 1.75rem;
            animation: fadeUp 0.5s ease;
            transition: border-color var(--speed);
        }

        .email-preview:hover {
            border-color: var(--gold-light);
        }

        .email-preview-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--white);
            border: 1.5px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--gold-dark);
            flex-shrink: 0;
            transition: all var(--speed);
        }

        .email-preview:hover .email-preview-icon {
            background: var(--gold-pale);
            border-color: var(--gold-light);
        }

        .email-preview-body {
            flex: 1;
            min-width: 0;
        }

        .email-preview-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 0.2rem;
        }

        .email-preview-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--navy);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ===== Steps indicator ===== */
        .steps-wrap {
            margin-bottom: 1.75rem;
            animation: fadeUp 0.55s ease;
        }

        .steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 0.75rem;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .step-dot {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all var(--speed);
            flex-shrink: 0;
        }

        .step-dot.done {
            background: var(--success);
            color: var(--white);
            box-shadow: 0 2px 8px rgba(22, 163, 74, 0.25);
        }

        .step-dot.active {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            box-shadow: 0 3px 12px rgba(198, 169, 98, 0.35);
            animation: step-pulse 2s ease-in-out infinite;
        }

        .step-dot.pending {
            background: var(--bg);
            border: 1.5px solid var(--border);
            color: var(--text-muted);
        }

        @keyframes step-pulse {

            0%,
            100% {
                box-shadow: 0 3px 12px rgba(198, 169, 98, 0.35);
            }

            50% {
                box-shadow: 0 3px 20px rgba(198, 169, 98, 0.5);
            }
        }

        .step-line {
            width: 48px;
            height: 2.5px;
            border-radius: 3px;
            transition: background var(--speed);
            margin: 0 4px;
        }

        .step-line.done {
            background: var(--success);
        }

        .step-line.pending {
            background: var(--border);
        }

        .step-labels {
            display: flex;
            justify-content: space-between;
            padding: 0 4px;
        }

        .step-label {
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--text-muted);
            text-align: center;
            flex: 1;
        }

        .step-label.active {
            color: var(--gold-dark);
            font-weight: 600;
        }

        .step-label.done {
            color: var(--success);
        }

        /* ===== Buttons ===== */
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

        .btn-logout {
            width: 100%;
            height: 46px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: var(--font);
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            background: var(--white);
            color: var(--text-secondary);
            transition: all var(--speed);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            margin-top: 0.75rem;
        }

        .btn-logout:hover {
            border-color: #CBD5E1;
            background: var(--bg);
            color: var(--text);
            transform: translateY(-1px);
        }

        .btn-logout i {
            font-size: 0.9rem;
        }

        /* ===== Tip ===== */
        .tip-text {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 1.25rem;
            line-height: 1.55;
        }

        /* ===== Footer ===== */
        .card-footer {
            padding: 1.5rem 2.25rem 2rem;
            text-align: center;
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

            .btn-submit {
                height: 50px;
            }

            .btn-logout {
                height: 44px;
            }

            .header-icon {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }

            .step-line {
                width: 32px;
            }

            .step-labels {
                font-size: 0.65rem;
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
                <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
            </div>

            <div class="header-icon">
                <i class="bi bi-envelope-check"></i>
            </div>

            <h1>Verifikasi Email Anda</h1>
            <p>Kami telah mengirimkan link verifikasi ke email Anda. Silakan cek inbox atau folder spam.</p>
        </div>

        <!-- Body -->
        <div class="card-body">

            <!-- Sent confirmation -->
            @if(session('status') == 'verification-link-sent')
                <div class="session-alert success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Link verifikasi baru telah dikirim ke email Anda.</span>
                </div>
            @endif

            <!-- Email preview -->
            <div class="email-preview">
                <div class="email-preview-icon">
                    <i class="bi bi-envelope"></i>
                </div>
                <div class="email-preview-body">
                    <div class="email-preview-label">Dikirim ke</div>
                    <div class="email-preview-value">{{ auth()->user()->email }}</div>
                </div>
            </div>

            <!-- Steps -->
            <div class="steps-wrap">
                <div class="steps">
                    <div class="step-item">
                        <div class="step-dot done"><i class="bi bi-check" style="font-size:0.7rem"></i></div>
                    </div>
                    <div class="step-line done"></div>
                    <div class="step-item">
                        <div class="step-dot active">2</div>
                    </div>
                    <div class="step-line pending"></div>
                    <div class="step-item">
                        <div class="step-dot pending">3</div>
                    </div>
                </div>
                <div class="step-labels">
                    <div class="step-label done">Daftar</div>
                    <div class="step-label active">Verifikasi</div>
                    <div class="step-label">Selesai</div>
                </div>
            </div>

            <!-- Resend Form -->
            <form method="POST" action="{{ route('verification.send') }}" id="resendForm">
                @csrf
                <button type="submit" class="btn-submit" id="resendBtn">
                    <i class="bi bi-send" style="font-size:0.9rem"></i>
                    <span class="btn-text">Kirim Ulang Link Verifikasi</span>
                    <span class="spinner"></span>
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i>
                    Keluar dari akun
                </button>
            </form>

            <!-- Tip -->
            <p class="tip-text">
                Belum menerima email? Cek folder spam atau<br>coba kirim ulang dalam beberapa menit.
            </p>
        </div>

        <!-- Footer -->
        <div class="card-footer"></div>
    </div>

    <!-- Toast -->
    <div class="toast-wrap" id="toastWrap"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var resendForm = document.getElementById('resendForm');
            var resendBtn = document.getElementById('resendBtn');
            var btnText = resendBtn.querySelector('.btn-text');

            /* ── Resend with loading state ── */
            resendForm.addEventListener('submit', function (e) {
                btnText.textContent = 'Mengirim...';
                resendBtn.classList.add('loading');
                resendBtn.disabled = true;
                /* Form submits normally after this */
            });

            /* ── If link was just sent, show toast ── */
            @if(session('status') == 'verification-link-sent')
                showToast('Link verifikasi berhasil dikirim!');
            @endif
        });

        function showToast(message) {
            var wrap = document.getElementById('toastWrap');
            var el = document.createElement('div');
            el.className = 'toast-item success';
            el.innerHTML = '<i class="bi bi-check-circle-fill"></i> ' + message;
            wrap.appendChild(el);
            setTimeout(function () {
                el.classList.add('out');
                setTimeout(function () { el.remove(); }, 300);
            }, 4000);
        }
    </script>
</body>

</html>

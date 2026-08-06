<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Verifikasi Email — WeddingInv</title>
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
            padding: 2.5rem 2rem 0;
            text-align: center;
        }

        .card-brand {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.5rem;
            display: inline-block;
        }
        .card-brand span { color: var(--gold); }

        /* Icon circle */
        .verify-icon {
            width: 72px; height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFFBEB, #FEF3C7);
            border: 2px solid #FDE68A;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            font-size: 1.6rem;
            color: #D97706;
        }

        .card-header h1 {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--navy);
            line-height: 1.35;
            margin-bottom: 0.5rem;
        }

        .card-header p {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.65;
        }

        /* ===== Body ===== */
        .card-body {
            padding: 1.75rem 2rem 0.5rem;
        }

        /* ===== Success Alert ===== */
        .session-alert {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 1.25rem;
            animation: fadeUp 0.35s ease;
        }
        .session-alert.success { background: var(--success-bg); color: #166534; border: 1px solid var(--success-border); }
        .session-alert i { font-size: 0.95rem; flex-shrink: 0; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== Email Preview ===== */
        .email-preview {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.9rem 1rem;
            border-radius: var(--radius);
            background: var(--bg);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }
        .email-preview-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: var(--white);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: var(--gold-dark);
            flex-shrink: 0;
        }
        .email-preview-body { flex: 1; min-width: 0; }
        .email-preview-label {
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 0.15rem;
        }
        .email-preview-value {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--navy);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* ===== Steps indicator ===== */
        .steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 1.75rem;
        }
        .step-dot {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            transition: all var(--speed);
        }
        .step-dot.done {
            background: var(--success);
            color: var(--white);
        }
        .step-dot.active {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            box-shadow: 0 2px 8px rgba(198,169,98,0.3);
        }
        .step-dot.pending {
            background: var(--bg);
            border: 1.5px solid var(--border);
            color: var(--text-muted);
        }
        .step-line {
            width: 40px; height: 2px;
            border-radius: 2px;
            transition: background var(--speed);
        }
        .step-line.done { background: var(--success); }
        .step-line.pending { background: var(--border); }

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
        }
        .btn-logout i { font-size: 0.9rem; }

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
            padding: 1.25rem 2rem 1.75rem;
            text-align: center;
        }

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
        .toast-item.success { background: var(--success); }
        .toast-item.out { animation: toastOut 0.3s ease forwards; }

        @keyframes toastIn  { from { opacity:0; transform:translateX(100%); } to { opacity:1; transform:translateX(0); } }
        @keyframes toastOut { from { opacity:1; transform:translateX(0); } to { opacity:0; transform:translateX(100%); } }

        /* ===== Responsive ===== */
        @media (max-width: 480px) {
            body { padding: 1rem; }
            .card-header { padding: 2rem 1.5rem 0; }
            .card-body    { padding: 1.5rem 1.5rem 0.5rem; }
            .card-footer  { padding: 1.1rem 1.5rem 1.5rem; }
            .card-header h1 { font-size: 1.2rem; }
            .verify-icon { width: 64px; height: 64px; font-size: 1.4rem; }
            .btn-submit { height: 48px; }
            .btn-logout { height: 44px; }
            .step-line { width: 28px; }
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

            <div class="verify-icon">
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
            <div class="steps">
                <div class="step-dot done"><i class="bi bi-check" style="font-size:0.7rem"></i></div>
                <div class="step-line done"></div>
                <div class="step-dot active">2</div>
                <div class="step-line pending"></div>
                <div class="step-dot pending">3</div>
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
            var resendBtn  = document.getElementById('resendBtn');
            var btnText    = resendBtn.querySelector('.btn-text');

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
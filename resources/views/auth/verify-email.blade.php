<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
<<<<<<< HEAD
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
=======
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
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b

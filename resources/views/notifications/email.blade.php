<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — WeddingInv</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #F5F3EF;
            color: #1B2A4A;
            margin: 0;
            padding: 2rem 1rem;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            max-width: 560px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 1px 2px rgba(0,0,0,0.04),
                0 4px 12px rgba(0,0,0,0.04),
                0 16px 40px rgba(0,0,0,0.06);
        }
        .email-top-bar {
            height: 4px;
            background: linear-gradient(90deg, #A68B4B, #C6A962, #E8D5A3, #C6A962, #A68B4B);
        }
        .email-header {
            padding: 2.5rem 2.25rem 0;
            text-align: center;
        }
        .email-brand {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #1B2A4A;
            margin-bottom: 1.5rem;
            display: inline-block;
            letter-spacing: -0.01em;
        }
        .email-brand span { color: #C6A962; }
        .email-icon {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
            border: 2px solid #FDE68A;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: #D97706;
            box-shadow: 0 4px 16px rgba(217,119,6,0.12);
        }
        .email-header h1 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: #1B2A4A;
            line-height: 1.3;
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
        }
        .email-header p {
            font-size: 0.9rem;
            color: #5A6478;
            line-height: 1.65;
            max-width: 380px;
            margin: 0 auto;
        }
        .email-body {
            padding: 2rem 2.25rem 1.5rem;
        }
        .email-verify-box {
            background: #FAFAF8;
            border: 1.5px solid #E8E4DE;
            border-radius: 14px;
            padding: 1.5rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .email-verify-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #9CA3AF;
            margin-bottom: 0.75rem;
        }
        .email-verify-name {
            font-size: 1rem;
            font-weight: 600;
            color: #1B2A4A;
            margin-bottom: 1.25rem;
        }
        .email-btn {
            display: inline-block;
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 14px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            background: linear-gradient(135deg, #1B2A4A 0%, #2C3E5F 100%);
            color: #FFFFFF;
            transition: all 0.3s ease;
            line-height: 52px;
        }
        .email-btn:hover {
            box-shadow: 0 8px 24px rgba(27,42,74,0.25);
        }
        .email-tip {
            font-size: 0.8rem;
            color: #9CA3AF;
            text-align: center;
            line-height: 1.6;
            margin-top: 1.25rem;
        }
        .email-tip a {
            color: #C6A962;
            text-decoration: none;
            font-weight: 500;
        }
        .email-footer {
            padding: 1.5rem 2.25rem 2rem;
            text-align: center;
            font-size: 0.78rem;
            color: #9CA3AF;
            line-height: 1.6;
            border-top: 1px solid #F0EBE3;
        }
        @media (max-width: 480px) {
            body { padding: 1rem; }
            .email-header { padding: 2rem 1.5rem 0; }
            .email-body { padding: 1.75rem 1.5rem 1.25rem; }
            .email-footer { padding: 1.25rem 1.5rem 1.75rem; }
            .email-header h1 { font-size: 1.3rem; }
            .email-icon { width: 64px; height: 64px; font-size: 1.5rem; }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="email-wrapper">
        <div class="email-top-bar"></div>

        <div class="email-header">
            <div class="email-brand">Wedding<span>Inv</span>.</div>
            <div class="email-icon">&#x2709;</div>
            <h1>Verifikasi Email Anda</h1>
            <p>Terima kasih telah bergabung dengan WeddingInv. Silakan verifikasi alamat email Anda untuk mengakses semua fitur.</p>
        </div>

        <div class="email-body">
            <div class="email-verify-box">
                <div class="email-verify-label">Akun atas nama</div>
                <div class="email-verify-name">{{ $name }}</div>
                <a href="{{ $verificationUrl }}" class="email-btn">Verifikasi Email</a>
            </div>

            <p class="email-tip">
                Tidak menerima email? Periksa folder spam atau<br>
                <a href="{{ $verificationUrl }}">klik di sini untuk mencoba lagi</a>.
            </p>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} WeddingInv. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>

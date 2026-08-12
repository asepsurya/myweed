<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Undangan Kelola Bersama Pasangan</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #1B2A4A;
            --color-accent: #C6A962;
            --color-bg: #F5F3EF;
            --color-surface: #FFFFFF;
            --color-text: #1B2A4A;
            --color-text-secondary: #5A6478;
            --color-border: #E8E4DE;
            --radius-lg: 20px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
            margin: 0;
            padding: 2rem 1rem;
        }

        .email-container {
            max-width: 560px;
            margin: 0 auto;
            background: var(--color-surface);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 16px 40px rgba(0,0,0,0.06);
        }

        .email-top-accent {
            height: 4px;
            background: linear-gradient(90deg, #A68B4B, #C6A962, #E8D5A3, #C6A962, #A68B4B);
        }

        .email-header {
            padding: 2.5rem 2.25rem 0;
            text-align: center;
        }

        .email-logo-text {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--color-primary);
        }

        .email-logo-text span { 
            color: var(--color-accent); 
        }

        .email-body {
            padding: 2rem 2.25rem 2.5rem;
            text-align: center;
        }

        .email-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-primary);
            margin-bottom: 1rem;
        }

        .email-desc {
            font-size: 0.95rem;
            color: var(--color-text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .email-card {
            background: #F9F8F5;
            border: 1px solid var(--color-border);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.75rem;
            text-align: left;
        }

        .btn-accept {
            display: inline-block;
            background: var(--color-accent);
            color: #FFFFFF !important;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.85rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(198, 169, 98, 0.4);
            transition: all 0.2s ease;
        }

        .email-footer {
            padding: 1.5rem;
            background: #FAFAFA;
            border-top: 1px solid var(--color-border);
            text-align: center;
            font-size: 0.8rem;
            color: #9CA3AF;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-top-accent"></div>
        <div class="email-header">
            <div class="email-logo-text">Wedding<span>Inv</span></div>
        </div>
        <div class="email-body">
            <h1 class="email-title">Undangan Pasangan Pernikahan 💍</h1>
            <p class="email-desc">
                <strong>{{ $inviterName }}</strong> mengundang Anda sebagai pasangan untuk 
                {{ $canEdit ? 'mengedit dan mengelola bersama' : 'melihat' }} undangan pernikahan 
                <strong>{{ $invitationTitle }}</strong>.
            </p>

            <div class="email-card">
                <p style="margin: 0 0 0.5rem; font-weight: 600; color: #1B2A4A;">Detail Undangan:</p>
                <p style="margin: 0 0 0.25rem; font-size: 0.9rem; color: #5A6478;"><strong>Pasangan:</strong> {{ $invitationTitle }}</p>
                <p style="margin: 0; font-size: 0.9rem; color: #5A6478;"><strong>Hak Akses:</strong> {{ $canEdit ? 'Bisa Mengedit & Mengelola Data' : 'Hanya Melihat' }}</p>
            </div>

            <a href="{{ $acceptUrl }}" class="btn-accept">
                Terima Undangan Pasangan ✨
            </a>

            <p style="margin-top: 1.5rem; font-size: 0.8rem; color: #9CA3AF;">
                Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut ke peramban Anda:<br>
                <a href="{{ $acceptUrl }}" style="color: #C6A962; word-break: break-all;">{{ $acceptUrl }}</a>
            </p>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} WeddingInv. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light only">
    <title>{{ $subject ?? 'Verify Your Email' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #1B2A4A;
            --color-primary-light: #2C3E5F;
            --color-accent: #C6A962;
            --color-accent-dark: #A68B4B;
            --color-bg: #F5F3EF;
            --color-surface: #FFFFFF;
            --color-text: #1B2A4A;
            --color-text-secondary: #5A6478;
            --color-text-muted: #9CA3AF;
            --color-border: #E8E4DE;
            --radius-lg: 20px;
            --radius-md: 14px;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.04);
            --shadow-lg: 0 16px 40px rgba(0,0,0,0.06);
        }

        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
            margin: 0;
            padding: 2rem 1rem;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .email-container {
            max-width: 560px;
            margin: 0 auto;
            background: var(--color-surface);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm), var(--shadow-md), var(--shadow-lg);
        }

        .email-top-accent {
            height: 4px;
            background: linear-gradient(90deg, var(--color-accent-dark), var(--color-accent), #E8D5A3, var(--color-accent), var(--color-accent-dark));
        }

        .email-header {
            padding: 2.5rem 2.25rem 0;
            text-align: center;
        }

        .email-logo {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            margin-bottom: 1.5rem;
        }

        .email-logo img {
            height: 40px;
            width: auto;
            display: block;
        }

        .email-logo-text {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--color-primary);
            letter-spacing: -0.01em;
        }

        .email-logo-text span { 
            color: var(--color-accent); 
        }

        .email-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%);
            border: 2px solid #FDE68A;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 16px rgba(217,119,6,0.12);
        }

        .email-icon svg {
            width: 38px;
            height: 38px;
            color: #D97706;
        }

        .email-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--color-primary);
            line-height: 1.3;
            margin-bottom: 0.75rem;
            letter-spacing: -0.01em;
        }

        .email-description {
            font-size: 0.95rem;
            color: var(--color-text-secondary);
            line-height: 1.65;
            max-width: 400px;
            margin: 0 auto;
        }

        .email-body {
            padding: 2rem 2.25rem 1.5rem;
        }

        .email-card {
            background: #FAFAF8;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .email-card-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--color-text-muted);
            margin-bottom: 0.5rem;
        }

        .email-card-value {
            font-size: 1rem;
            font-weight: 600;
            color: var(--color-primary);
            margin-bottom: 1.5rem;
            word-break: break-all;
        }

        .email-button {
            display: block;
            width: 100%;
            height: 52px;
            border: none;
            border-radius: var(--radius-md);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            color: #FFFFFF !important;
            line-height: 52px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .email-button:hover {
            box-shadow: 0 8px 24px rgba(27,42,74,0.25);
            transform: translateY(-1px);
            color: #FFFFFF !important;
        }

        .email-tip {
            font-size: 0.85rem;
            color: var(--color-text-muted);
            text-align: center;
            line-height: 1.6;
            margin-top: 1.25rem;
        }

        .email-tip a {
            color: var(--color-accent-dark);
            text-decoration: none;
            font-weight: 500;
        }

        .email-tip a:hover { 
            text-decoration: underline; 
        }

        .email-footer {
            padding: 1.5rem 2.25rem 2rem;
            text-align: center;
            font-size: 0.78rem;
            color: var(--color-text-muted);
            line-height: 1.6;
            border-top: 1px solid var(--color-border);
        }

        .email-footer a {
            color: var(--color-accent-dark);
            text-decoration: none;
            font-weight: 500;
        }

        .email-footer a:hover { 
            text-decoration: underline; 
        }

        @media (max-width: 480px) {
            body { padding: 1rem; }
            .email-header { padding: 2rem 1.5rem 0; }
            .email-body { padding: 1.75rem 1.5rem 1.25rem; }
            .email-footer { padding: 1.25rem 1.5rem 1.75rem; }
            .email-title { font-size: 1.35rem; }
            .email-icon { width: 64px; height: 64px; }
            .email-icon svg { width: 30px; height: 30px; }
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <div class="email-container">
                    <div class="email-top-accent"></div>

                    <div class="email-header">
                        @if (!empty($logoUrl))
                            <a href="{{ $logoUrl ?? url('/') }}" class="email-logo">
                                <img src="{{ $logoUrl }}" alt="{{ $brandName ?? 'Logo' }}" style="display: block;">
                            </a>
                        @else
                            <div class="email-logo">
                                <span class="email-logo-text">{{ $brandName ?? 'Brand' }}<span>.</span></span>
                            </div>
                        @endif

                        <div class="email-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                                <path d="M15 16.5l2 2 4-4" stroke-width="2.5"></path>
                            </svg>
                        </div>
                        
                        <h1 class="email-title">Verify Your Email</h1>
                        <p class="email-description">Thank you for joining {{ $brandName ?? config('app.name') }}. Please verify your email address to access all features and secure your account.</p>
                    </div>

                    <div class="email-body">
                        <div class="email-card">
                            <div class="email-card-label">Account</div>
                            <div class="email-card-value">{{ $userName }}</div>
                            <a href="{{ $verificationUrl }}" class="email-button">Verify Email Address</a>
                        </div>

                        <p class="email-tip">
                            Didn't receive the email? Check your spam folder or<br>
                            <a href="{{ $verificationUrl }}">click here to try again</a>.
                        </p>
                    </div>

                    <div class="email-footer">
                        &copy; {{ date('Y') }} {{ $brandName ?? config('app.name') }}. All rights reserved.<br>
                        <a href="{{ $supportUrl ?? url('/') }}">Contact Support</a>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
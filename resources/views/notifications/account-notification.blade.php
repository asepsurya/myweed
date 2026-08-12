<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light only">
    <title>{{ $subject ?? 'Account Notification' }}</title>
    
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
            --color-success: #16A34A;
            --color-success-bg: #F0FDF4;
            --color-success-border: #BBF7D0;
            --color-info: #2563EB;
            --color-info-bg: #EFF6FF;
            --color-info-border: #BFDBFE;
            --color-warning: #D97706;
            --color-warning-bg: #FFFBEB;
            --color-warning-border: #FDE68A;
            --color-error: #DC2626;
            --color-error-bg: #FEF2F2;
            --color-error-border: #FECACA;
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
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .email-icon svg {
            width: 36px;
            height: 36px;
        }

        .email-icon.type-success {
            background: var(--color-success-bg);
            border: 2px solid var(--color-success-border);
            color: var(--color-success);
        }

        .email-icon.type-info {
            background: var(--color-info-bg);
            border: 2px solid var(--color-info-border);
            color: var(--color-info);
        }

        .email-icon.type-warning {
            background: var(--color-warning-bg);
            border: 2px solid var(--color-warning-border);
            color: var(--color-warning);
        }

        .email-icon.type-error {
            background: var(--color-error-bg);
            border: 2px solid var(--color-error-border);
            color: var(--color-error);
        }

        .email-icon.type-default {
            background: #F9F5EB;
            border: 2px solid #E8D5A3;
            color: var(--color-accent-dark);
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

        /* Details List Styling */
        .email-details-list {
            text-align: left;
            margin-top: 1rem;
            border-top: 1px solid var(--color-border);
            padding-top: 1rem;
        }
        .email-detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }
        .email-detail-label {
            font-size: 0.85rem;
            color: var(--color-text-secondary);
            font-weight: 500;
            padding-right: 1rem;
        }
        .email-detail-value {
            font-size: 0.9rem;
            color: var(--color-primary);
            font-weight: 600;
            text-align: right;
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

        .email-button-secondary {
            display: block;
            width: 100%;
            height: 44px;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            background: var(--color-surface);
            color: var(--color-text-secondary) !important;
            line-height: 42px;
            text-align: center;
            margin-top: 0.75rem;
        }

        .email-button-secondary:hover {
            background: var(--color-bg);
            color: var(--color-primary) !important;
        }

        .email-tip {
            font-size: 0.85rem;
            color: var(--color-text-muted);
            text-align: center;
            line-height: 1.6;
            margin-top: 1.5rem;
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
            .email-icon svg { width: 28px; height: 28px; }
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

                        <div class="email-icon type-{{ $type ?? 'default' }}">
                            @switch($type ?? 'default')
                                @case('success')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                    @break
                                @case('warning')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                                    @break
                                @case('error')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                    @break
                                @case('info')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    @break
                                @default
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                            @endswitch
                        </div>
                        
                        <h1 class="email-title">{{ $title }}</h1>
                        <p class="email-description">{{ $message }}</p>
                    </div>

                    <div class="email-body">
                        @if (!empty($details))
                            <div class="email-card">
                                <div class="email-card-label">Account Details</div>
                                <div class="email-card-value">{{ $userName }}</div>
                                
                                <div class="email-details-list">
                                    @foreach($details as $label => $value)
                                        <div class="email-detail-item">
                                            <span class="email-detail-label">{{ $label }}</span>
                                            <span class="email-detail-value">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if (!empty($actionUrl))
                            <a href="{{ $actionUrl }}" class="email-button">{{ $actionText ?? 'Take Action' }}</a>
                        @endif

                        @if (!empty($secondaryActionUrl))
                            <a href="{{ $secondaryActionUrl }}" class="email-button-secondary">{{ $secondaryActionText ?? 'Learn More' }}</a>
                        @endif

                        <p class="email-tip">
                            @if (!empty($actionUrl))
                                The button above will take you directly to your account.<br>
                            @endif
                            Need help? <a href="{{ $supportUrl ?? url('/') }}">Contact our support team</a>.
                        </p>
                    </div>

                    <div class="email-footer">
                        &copy; {{ date('Y') }} {{ $brandName ?? config('app.name') }}. All rights reserved.<br>
                        <a href="{{ $preferencesUrl ?? url('/settings') }}">Notification Preferences</a>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
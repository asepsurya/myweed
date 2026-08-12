<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
@media only screen and (max-width: 600px) {
    .inner-body {
        width: 100% !important;
    }

    .footer {
        width: 100% !important;
    }
}

@media only screen and (max-width: 500px) {
    .button {
        width: 100% !important;
    }
}

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

.content-cell {
    padding: 0 2.25rem 1.5rem;
}

.button {
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
    color: #FFFFFF !important;
    line-height: 52px;
    text-align: center;
}

.button:hover {
    box-shadow: 0 8px 24px rgba(27,42,74,0.25);
}

.panel {
    background: #FAFAF8;
    border: 1.5px solid #E8E4DE;
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.subcopy {
    border-top: 1px solid #F0EBE3;
    padding-top: 1rem;
    font-size: 0.8rem;
    color: #9CA3AF;
    text-align: center;
}

.footer {
    padding: 1.5rem 2.25rem 2rem;
    text-align: center;
    font-size: 0.78rem;
    color: #9CA3AF;
    line-height: 1.6;
    border-top: 1px solid #F0EBE3;
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

@media (max-width: 480px) {
    body { padding: 1rem; }
    .content-cell { padding: 0 1.5rem 1.25rem; }
    .footer { padding: 1.25rem 1.5rem 1.75rem; }
}
</style>
{!! $head ?? '' !!}
</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td align="center">
            <div class="email-wrapper">
                <div class="email-top-bar"></div>

                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    {!! $header ?? '' !!}

                    <!-- Email Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
                            <table class="inner-body" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        {!! Illuminate\Mail\Markdown::parse($slot) !!}

                                        {!! $subcopy ?? '' !!}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {!! $footer ?? '' !!}
                </table>
            </div>
        </td>
    </tr>
</table>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nandang & Rinjani | The Wedding</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Lato:wght@300;400;700&family=Great+Vibes&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    <style>
        /* =============================================
           1. VARIABLES & TOKENS
        ============================================= */
        :root {
            --primary: {{ $themeColor ?? '#1A3C34' }};
            --primary-light: color-mix(in srgb, var(--primary) 60%, white);
            --primary-dark: color-mix(in srgb, var(--primary) 80%, black);
            --gold: #C5A059;
            --gold-light: #D4B97A;
            --gold-dark: #A6843E;
            --text-dark: #2C2C2C;
            --text-muted: #777777;
            --bg: #FAF9F6;
            --bg-warm: #F5F0E8;
            --white: #FFFFFF;
            --border: color-mix(in srgb, var(--primary) 8%, transparent);
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
            --shadow-md: 0 8px 30px rgba(0,0,0,0.08);
            --shadow-lg: 0 20px 60px rgba(0,0,0,0.12);
            --shadow-gold: 0 4px 20px rgba(197,160,89,0.2);
            --transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --radius: 16px;
        }

        /* =============================================
           2. RESET & BASE
        ============================================= */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Lato', sans-serif;
            background-color: #d4d0c8;
            color: var(--text-dark);
            display: flex;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
        }

        a { text-decoration: none; color: var(--gold); transition: var(--transition); }
        a:hover { color: var(--gold-dark); }

        img { display: block; max-width: 100%; }

        ::selection {
            background: var(--gold);
            color: white;
        }

        /* =============================================
           3. TYPOGRAPHY
        ============================================= */
        h1, h2, h3, h4, h5, .serif-font {
            font-family: 'Cormorant Garamond', serif;
            color: var(--primary);
            font-weight: 500;
        }

        .script-font {
            font-family: 'Great Vibes', cursive;
            color: var(--gold);
        }

        .section-eyebrow {
            font-family: 'Lato', sans-serif;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: var(--gold-dark);
            font-weight: 400;
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.6rem;
            font-weight: 300;
            margin-top: 8px;
            letter-spacing: 1px;
            line-height: 1.2;
        }

        .text-center { text-align: center; }

        /* =============================================
           4. LAYOUT
        ============================================= */
        .mobile-container {
            width: 100%;
            max-width: 414px;
            background-color: var(--bg);
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 80px rgba(0,0,0,0.15);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .section-padding {
            padding: 90px 32px;
            position: relative;
        }

        /* =============================================
           5. UTILITIES
        ============================================= */
        .ornament-line {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin: 18px auto;
        }
        .ornament-line::before,
        .ornament-line::after {
            content: '';
            width: 40px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }
        .ornament-dot {
            width: 6px; height: 6px;
            background: var(--gold);
            border-radius: 50%;
            display: inline-block;
        }

        .mb-4 { margin-bottom: 45px; }
        .mt-4 { margin-top: 1.5rem; }
        .mt-6 { margin-top: 2.5rem; }
        .w-full { width: 100%; }
        .hidden { display: none !important; }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 22px;
            padding: 14px 36px;
            border: 1px solid var(--primary);
            color: var(--primary);
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 3px;
            transition: var(--transition);
            background: transparent;
            cursor: pointer;
            border-radius: 2px;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            z-index: 0;
        }
        .btn-primary:hover::before { transform: scaleX(1); }
        .btn-primary:hover { color: var(--white); }
        .btn-primary span, .btn-primary i { position: relative; z-index: 1; }

        /* =============================================
           6. PETAL CANVAS
        ============================================= */
        #petalCanvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 9998;
            opacity: 0.6;
        }

        /* =============================================
           7. HERO
        ============================================= */
        .hero {
            height: 100vh;
            min-height: 700px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: var(--white);
            text-align: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://picsum.photos/seed/wedding-elegant/800/1400') center/cover no-repeat;
            transform: scale(1.05);
            transition: transform 8s ease-out;
        }
        .hero-bg.loaded { transform: scale(1); }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(180deg,
                    rgba(0,0,0,0.15) 0%,
                    color-mix(in srgb, var(--primary) 55%, transparent) 50%,
                    color-mix(in srgb, var(--primary) 80%, transparent) 100%
                );
        }

        .hero-vignette {
            position: absolute;
            inset: 0;
            box-shadow: inset 0 0 120px rgba(0,0,0,0.4);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 0 30px;
        }

        .hero-label {
            font-family: 'Lato', sans-serif;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 6px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 24px;
            font-weight: 300;
        }

        .hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.6rem;
            font-weight: 300;
            color: var(--white);
            line-height: 1.15;
            letter-spacing: 2px;
        }

        .hero-amp {
            font-family: 'Great Vibes', cursive;
            font-size: 2.8rem;
            color: var(--gold-light);
            display: block;
            margin: -5px 0;
            line-height: 1;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .hero-guest {
            font-size: 0.8rem;
            margin-top: 28px;
            opacity: 0.8;
            font-weight: 300;
            letter-spacing: 1px;
        }

        .hero-guest-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 500;
            display: inline-block;
            margin-top: 6px;
            padding-bottom: 4px;
            border-bottom: 1px solid rgba(255,255,255,0.4);
            letter-spacing: 1px;
        }

        .hero-date {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 300;
            font-size: 1.15rem;
            margin-top: 22px;
            letter-spacing: 3px;
            display: inline-block;
            padding: 10px 28px;
            border: 1px solid rgba(197,160,89,0.5);
            border-radius: 2px;
            color: var(--gold-light);
        }

        .reminder-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 18px;
            padding: 11px 26px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--primary-dark);
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .reminder-btn:hover {
            background: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: scrollBounce 3s ease-in-out infinite;
            opacity: 0.6;
            cursor: pointer;
            z-index: 2;
        }

        .scroll-mouse {
            width: 20px;
            height: 32px;
            border: 1.5px solid rgba(255,255,255,0.5);
            border-radius: 12px;
            position: relative;
        }
        .scroll-mouse::after {
            content: '';
            position: absolute;
            top: 6px;
            left: 50%;
            transform: translateX(-50%);
            width: 3px;
            height: 8px;
            background: rgba(255,255,255,0.7);
            border-radius: 2px;
            animation: scrollDot 2s ease-in-out infinite;
        }

        /* =============================================
           8. QUOTE
        ============================================= */
        .quote-section {
            text-align: center;
            background: var(--white);
            position: relative;
        }

        .quote-section::before {
            content: '\201C';
            font-family: 'Cormorant Garamond', serif;
            font-size: 8rem;
            color: var(--gold);
            opacity: 0.12;
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
            line-height: 1;
            pointer-events: none;
        }

        .quote-content {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            font-weight: 300;
            font-style: italic;
            line-height: 2;
            color: var(--text-dark);
            max-width: 88%;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        /* =============================================
           9. COUPLE
        ============================================= */
        .couple-section {
            background: var(--bg);
            position: relative;
        }

        .couple-wrapper {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .couple-card { text-align: center; }

        .img-frame-ornate {
            position: relative;
            display: inline-block;
            margin-bottom: 24px;
        }

        .img-frame-ornate::before {
            content: '';
            position: absolute;
            inset: -8px;
            border: 1px solid var(--gold);
            border-radius: 2px;
            opacity: 0.5;
        }
        .img-frame-ornate::after {
            content: '';
            position: absolute;
            inset: -14px;
            border: 1px solid var(--gold);
            border-radius: 2px;
            opacity: 0.2;
        }

        .couple-img {
            width: 175px;
            height: 220px;
            object-fit: cover;
            filter: grayscale(15%) contrast(1.05);
            transition: filter 0.5s;
        }
        .couple-card:hover .couple-img {
            filter: grayscale(0%) contrast(1);
        }

        .couple-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.2rem;
            font-weight: 400;
            color: var(--primary);
            margin-bottom: 4px;
            letter-spacing: 1px;
        }

        .couple-nickname {
            font-family: 'Great Vibes', cursive;
            font-size: 1.6rem;
            color: var(--gold);
            margin-bottom: 8px;
        }

        .parent-name {
            font-size: 0.72rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 6px;
            margin-bottom: 8px;
            font-weight: 400;
        }

        .couple-instagram {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 10px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 14px;
            border: 1px solid var(--border);
            border-radius: 50px;
            transition: var(--transition);
        }
        .couple-instagram:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .ampersand-divider {
            text-align: center;
            margin: -10px 0 10px;
            position: relative;
        }
        .ampersand-divider::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            border: 1px solid var(--gold);
            border-radius: 50%;
            opacity: 0.3;
        }
        .ampersand-divider span {
            font-family: 'Great Vibes', cursive;
            font-size: 2.8rem;
            color: var(--gold);
            position: relative;
            z-index: 1;
            line-height: 60px;
        }

        /* =============================================
           10. EVENT
        ============================================= */
        .event-section {
            background: var(--white);
            position: relative;
        }
        .event-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.3;
        }

        .event-card {
            padding: 40px 24px;
            border: 1px solid var(--border);
            text-align: center;
            margin-bottom: 24px;
            transition: var(--transition);
            border-radius: var(--radius);
            position: relative;
            overflow: hidden;
            background: var(--bg);
        }
        .event-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }
        .event-card:hover::before { opacity: 1; }
        .event-card:hover {
            border-color: color-mix(in srgb, var(--gold) 40%, transparent);
            transform: translateY(-4px);
            box-shadow: var(--shadow-gold);
        }

        .event-icon {
            font-size: 1.8rem;
            color: var(--gold);
            margin-bottom: 12px;
        }

        .event-title {
            font-family: 'Lato', sans-serif;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: var(--text-muted);
            margin-bottom: 16px;
            font-weight: 700;
        }

        .event-time {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 400;
            color: var(--primary);
            letter-spacing: 1px;
        }

        .event-location {
            color: var(--text-dark);
            margin-top: 12px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .event-address {
            color: var(--text-muted);
            margin-top: 4px;
            margin-bottom: 8px;
            font-size: 0.82rem;
            line-height: 1.5;
        }

        /* =============================================
           11. COUNTDOWN
        ============================================= */
        .countdown-section {
            background:
                radial-gradient(ellipse at 30% 20%, rgba(197,160,89,0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 80%, rgba(255,255,255,0.03) 0%, transparent 50%),
                var(--primary);
            color: var(--white);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .countdown-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.02) 0%, transparent 60%);
            animation: rotateSlow 60s linear infinite;
            pointer-events: none;
        }
        .countdown-section h2,
        .countdown-section p { color: var(--white) !important; }

        .countdown-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 45px;
            position: relative;
            z-index: 1;
        }

        .timer-box {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 18px 8px 14px;
            backdrop-filter: blur(5px);
            transition: var(--transition);
        }
        .timer-box:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(197,160,89,0.3);
        }

        .timer-val {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.6rem;
            font-weight: 300;
            line-height: 1;
            margin-bottom: 6px;
            color: var(--gold-light);
        }

        .timer-label {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            opacity: 0.5;
            font-weight: 300;
        }

        /* =============================================
           12. LOVE STORY
        ============================================= */
        .love-story-section {
            background: linear-gradient(180deg, var(--white) 0%, var(--bg-warm) 100%);
            padding: 80px 24px;
        }

        .timeline {
            position: relative;
            max-width: 380px;
            margin: 0 auto;
        }

        .timeline-line {
            position: absolute;
            left: 18px;
            top: 0;
            bottom: 0;
            width: 1px;
            background: linear-gradient(180deg, var(--gold), transparent);
            opacity: 0.3;
        }

        .timeline-item {
            position: relative;
            padding-left: 52px;
            margin-bottom: 44px;
        }
        .timeline-item:last-child { margin-bottom: 0; }

        .timeline-dot {
            position: absolute;
            left: 11px;
            top: 4px;
            width: 16px;
            height: 16px;
            background: var(--bg);
            border: 2px solid var(--gold);
            border-radius: 50%;
            transition: var(--transition);
            z-index: 1;
        }
        .timeline-item:hover .timeline-dot {
            background: var(--gold);
            box-shadow: 0 0 0 4px rgba(197,160,89,0.2);
        }

        .timeline-date {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--gold-dark);
            margin-bottom: 4px;
            font-weight: 700;
        }

        .timeline-item h5 {
            font-family: 'Cormorant Garamond', serif;
            color: var(--primary);
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .timeline-content {
            font-size: 0.85rem;
            line-height: 1.8;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .timeline-content img {
            border-radius: 12px;
            margin-top: 12px;
            max-height: 160px;
            object-fit: cover;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        .timeline-content img:hover {
            box-shadow: var(--shadow-md);
            transform: scale(1.01);
        }

        /* =============================================
           13. GALLERY
        ============================================= */
        .gallery-section {
            background: var(--white);
            position: relative;
        }

        .masonry-gallery {
            column-count: 2;
            column-gap: 10px;
        }

        .masonry-item {
            width: 100%;
            margin-bottom: 10px;
            display: block;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .masonry-item img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94), filter 0.6s;
        }
        .masonry-item:hover img {
            transform: scale(1.05);
            filter: brightness(0.9);
        }
        .masonry-item::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 10px;
            border: 1px solid rgba(197,160,89,0);
            transition: border-color 0.4s;
            pointer-events: none;
        }
        .masonry-item:hover::after {
            border-color: rgba(197,160,89,0.3);
        }

        /* =============================================
           14. GIFTS
        ============================================= */
        .gifts-section {
            background: var(--bg-warm);
            padding: 80px 24px;
        }

        .gifts-grid {
            display: grid;
            gap: 16px;
        }

        .gift-card {
            position: relative;
            background: linear-gradient(135deg, #e8e4dc 0%, #ddd8ce 100%);
            border-radius: 16px;
            padding: 40px 24px 24px;
            min-height: 130px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid rgba(197,160,89,0.15);
        }
        .gift-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-gold);
            border-color: rgba(197,160,89,0.3);
        }

        .gift-card::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(197,160,89,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }

        .gift-logo {
            position: absolute;
            top: 18px;
            right: 18px;
        }
        .gift-logo img { height: 26px; object-fit: contain; }

        .gift-content { position: relative; z-index: 2; }

        .gift-name {
            font-family: 'Lato', sans-serif;
            font-weight: 700;
            font-size: 0.7rem;
            letter-spacing: 2px;
            color: var(--gold-dark);
            text-transform: uppercase;
        }

        .gift-number {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            font-weight: 500;
            color: var(--text-dark);
            margin-top: 4px;
            letter-spacing: 2px;
        }

        .gift-copy {
            position: absolute;
            bottom: 16px;
            right: 18px;
            border: none;
            background: rgba(197,160,89,0.15);
            color: var(--gold-dark);
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            cursor: pointer;
            padding: 6px 14px;
            border-radius: 50px;
            transition: var(--transition);
            text-transform: uppercase;
        }
        .gift-copy:hover {
            background: var(--gold);
            color: white;
        }

        /* =============================================
           15. RSVP
        ============================================= */
        .rsvp-section {
            padding: 80px 24px;
            background: var(--white);
            position: relative;
        }
        .rsvp-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.3;
        }

        .rsvp-form {
            background: var(--bg);
            padding: 36px 28px;
            box-shadow: var(--shadow-sm);
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        .form-group {
            margin-bottom: 18px;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            border: 1px solid #e0ddd6;
            border-radius: 8px;
            padding: 13px 16px;
            font-family: 'Lato', sans-serif;
            font-size: 0.9rem;
            background: var(--white);
            color: var(--text-dark);
            transition: var(--transition);
            -webkit-appearance: none;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(197,160,89,0.1);
        }

        .rsvp-meta {
            max-width: 414px;
            margin: 0 auto 20px;
            padding: 14px 20px;
            background: var(--bg);
            border-radius: 8px;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-style: italic;
            text-align: center;
            border-left: 3px solid var(--gold);
        }

        .rsvp-deadline {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 16px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            background: var(--bg);
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .rsvp-whatsapp {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #22c55e;
            color: white;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(34,197,94,0.3);
        }
        .rsvp-whatsapp:hover {
            background: #16a34a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34,197,94,0.4);
        }

        /* Comment List */
        .rsvp-list-wrapper {
            max-width: 414px;
            margin: 30px auto 0;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
        }

        .rsvp-list {
            max-height: 400px;
            overflow-y: auto;
            padding: 4px;
        }
        .rsvp-list::-webkit-scrollbar { width: 3px; }
        .rsvp-list::-webkit-scrollbar-thumb {
            background-color: var(--gold);
            border-radius: 3px;
        }

        .comment-item {
            display: flex;
            gap: 14px;
            background: var(--white);
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 12px;
            border: 1px solid var(--border);
            animation: commentSlide 0.5s ease-out;
            transition: var(--transition);
        }
        .comment-item:hover {
            box-shadow: var(--shadow-sm);
        }

        .comment-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold-light), var(--gold-dark));
            flex-shrink: 0;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1rem;
        }
        .comment-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .comment-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            color: var(--primary);
            margin-bottom: 3px;
            font-weight: 600;
        }

        .comment-text {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.6;
            word-wrap: break-word;
        }

        .rsvp-count {
            text-align: center;
            margin-top: 14px;
            font-size: 0.7rem;
            color: #bbb;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* =============================================
           16. MUSIC CONTROL
        ============================================= */
        .music-control {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            z-index: 9999;
            border: 2px solid var(--gold);
            color: var(--gold-light);
            font-size: 20px;
            transition: var(--transition);
        }
        .music-control:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(0,0,0,0.3);
        }
        .music-control.playing {
            animation: musicPulse 2s ease-in-out infinite;
            border-color: var(--gold-light);
        }

        /* =============================================
           17. FOOTER
        ============================================= */
        .footer {
            background:
                radial-gradient(ellipse at 50% 0%, rgba(197,160,89,0.08) 0%, transparent 60%),
                var(--primary-dark);
            color: var(--white);
            padding: 70px 24px 50px;
            text-align: center;
            position: relative;
        }
        .footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.4;
        }

        .footer-names {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.4rem;
            font-weight: 300;
            color: var(--white);
            letter-spacing: 2px;
            margin-bottom: 6px;
        }

        .footer-script {
            font-family: 'Great Vibes', cursive;
            font-size: 1.6rem;
            color: var(--gold-light);
            margin-bottom: 20px;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 0.85rem;
            opacity: 0.6;
            line-height: 1.8;
            font-weight: 300;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-copy {
            font-size: 0.65rem;
            opacity: 0.3;
            margin-top: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* =============================================
           18. TOAST
        ============================================= */
        #toast {
            visibility: hidden;
            min-width: 260px;
            background: var(--primary);
            color: var(--gold-light);
            text-align: center;
            padding: 16px 24px;
            position: fixed;
            z-index: 10000;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%) translateY(20px);
            font-size: 0.82rem;
            border-radius: 50px;
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 1px solid rgba(197,160,89,0.2);
            backdrop-filter: blur(10px);
            letter-spacing: 0.5px;
        }
        #toast.show {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(0);
            bottom: 40px;
        }

        /* =============================================
           19. ANIMATIONS
        ============================================= */
        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                        transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-in-scale {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .fade-in-scale.visible {
            opacity: 1;
            transform: scale(1);
        }

        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }

        @keyframes scrollBounce {
            0%, 100% { transform: translate(-50%, 0); }
            50% { transform: translate(-50%, -8px); }
        }

        @keyframes scrollDot {
            0%, 100% { opacity: 1; top: 6px; }
            50% { opacity: 0.3; top: 16px; }
        }

        @keyframes rotateSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes musicPulse {
            0%, 100% { box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
            50% { box-shadow: 0 4px 30px rgba(197,160,89,0.4); }
        }

        @keyframes commentSlide {
            from { opacity: 0; transform: translateX(-15px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .animate-spin { animation: spin 1s linear infinite; }

        @keyframes spin { 100% { transform: rotate(360deg); } }

        @keyframes heroReveal {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-reveal {
            animation: heroReveal 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            opacity: 0;
        }
        .hero-reveal-delay-1 { animation-delay: 0.3s; }
        .hero-reveal-delay-2 { animation-delay: 0.6s; }
        .hero-reveal-delay-3 { animation-delay: 0.9s; }
        .hero-reveal-delay-4 { animation-delay: 1.2s; }
        .hero-reveal-delay-5 { animation-delay: 1.5s; }

        /* Prefers reduced motion */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>

    <!-- Floating Petals -->
    <canvas id="petalCanvas"></canvas>

    <!-- Audio Control -->
    <div id="musicBtn" class="music-control" aria-label="Toggle music">
        <i class="ti ti-player-play" id="musicIcon"></i>
    </div>

    <!-- Main Container -->
    <div class="mobile-container">

        <!-- ==================== HERO ==================== -->
        <header class="hero">
            <div class="hero-bg" id="heroBg" style="background-image: url('{{ '/storage/' . $invitation->gallery_cover }}');"></div>
            <div class="hero-overlay"></div>
            <div class="hero-vignette"></div>

            <div class="hero-content">
                <p class="hero-label hero-reveal hero-reveal-delay-1">The Wedding Of</p>
                <h1 class="hero-reveal hero-reveal-delay-2">{{ $invitation->groom_nickname }}</h1>
                <span class="hero-amp hero-reveal hero-reveal-delay-3">&</span>
                <h1 class="hero-reveal hero-reveal-delay-3">{{ $invitation->bride_nickname }}</h1>

                <p class="hero-guest hero-reveal hero-reveal-delay-4">
                    Kepada Yth.<br>
                    <span class="hero-guest-name">{{ request('to') ?? 'Keluarga Besar' }}</span>
                </p>

                <div class="hero-date hero-reveal hero-reveal-delay-4">
                    {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('d F Y') }}
                </div>

                <button id="reminderBtn" class="reminder-btn hero-reveal hero-reveal-delay-5">
                    <i class="ti ti-calendar-event"></i>
                    <span>Setel Pengingat</span>
                </button>
            </div>

            <div class="scroll-indicator" onclick="document.getElementById('quote').scrollIntoView({behavior: 'smooth'})">
                <div class="scroll-mouse"></div>
                <span>Scroll</span>
            </div>
        </header>

        <!-- ==================== QUOTE ==================== -->
        <section id="quote" class="section-padding quote-section">
            <div class="fade-up">
                <p class="section-eyebrow">Bismillahirrahmanirrahim</p>
                <h2 class="section-title">Doa Kami</h2>
                <div class="ornament-line"><span class="ornament-dot"></span></div>
                <div class="quote-content" style="margin-top: 28px;">
                    {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote))) !!}
                </div>
            </div>
        </section>

        <!-- ==================== COUPLE ==================== -->
        <section class="section-padding couple-section">
            <div class="text-center mb-4 fade-up">
                <p class="section-eyebrow">The Bride & Groom</p>
                <h2 class="section-title">Mempelai</h2>
                <div class="ornament-line"><span class="ornament-dot"></span></div>
            </div>

            <div class="couple-wrapper">
                <!-- Groom -->
                <div class="couple-card fade-up stagger-1">
                    <div class="img-frame-ornate">
                        <img src="{{ '/storage/' . $invitation->foto_pria }}" alt="{{ $invitation->groom_name }}" class="couple-img" loading="lazy">
                    </div>
                    <p class="couple-nickname">{{ $invitation->groom_nickname }}</p>
                    <h3 class="couple-name">{{ $invitation->groom_name }}</h3>
                    <p class="parent-name">
                        Putra dari<br>Bpk. {{ $invitation->groom_father_name }} & Ibu {{ $invitation->groom_mother_name }}
                    </p>
                    <a href="{{ $invitation->groom_instagram }}" target="_blank" class="couple-instagram">
                        <i class="ti ti-brand-instagram"></i> Instagram
                    </a>
                </div>

                <div class="ampersand-divider fade-up">
                    <span>&</span>
                </div>

                <!-- Bride -->
                <div class="couple-card fade-up stagger-2">
                    <div class="img-frame-ornate">
                        <img src="{{ '/storage/' . $invitation->foto_wanita }}" alt="{{ $invitation->bride_name }}" class="couple-img" loading="lazy">
                    </div>
                    <p class="couple-nickname">{{ $invitation->bride_nickname }}</p>
                    <h3 class="couple-name">{{ $invitation->bride_name }}</h3>
                    <p class="parent-name">
                        Putri dari<br>Bpk. {{ $invitation->bride_father_name }} & Ibu {{ $invitation->bride_mother_name }}
                    </p>
                    <a href="{{ $invitation->bride_instagram }}" target="_blank" class="couple-instagram">
                        <i class="ti ti-brand-instagram"></i> Instagram
                    </a>
                </div>
            </div>
        </section>

        <!-- ==================== EVENT ==================== -->
        <section class="section-padding event-section">
            <div class="text-center mb-4 fade-up">
                <p class="section-eyebrow">Save The Date</p>
                <h2 class="section-title">Waktu & Tempat</h2>
                <div class="ornament-line"><span class="ornament-dot"></span></div>
            </div>

            <div>
                <!-- Akad -->
                <div class="event-card fade-up stagger-1">
                    <div class="event-icon"><i class="ti ti-ring"></i></div>
                    <div class="event-title">Akad Nikah</div>
                    <div class="event-time">{{ $invitation->akad_time }} — {{ $invitation->akad_time_end }}</div>
                    <p class="event-location">{{ $invitation->akad_location }}</p>
                    <p class="event-address">{{ $invitation->akad_address }}</p>
                    <a href="{{ $invitation->akad_maps }}" target="_blank" class="btn-primary">
                        <i class="ti ti-map-pin"></i>
                        <span>Lihat Peta</span>
                    </a>
                </div>

                <!-- Resepsi -->
                <div class="event-card fade-up stagger-2">
                    <div class="event-icon"><i class="ti ti-champagne"></i></div>
                    <div class="event-title">Wedding Reception</div>
                    <div class="event-time">{{ $invitation->resepsi_time }} — {{ $invitation->resepsi_time_end }}</div>
                    <p class="event-location">{{ $invitation->resepsi_location }}</p>
                    <p class="event-address">{{ $invitation->resepsi_address }}</p>
                    <a href="{{ $invitation->resepsi_maps }}" target="_blank" class="btn-primary">
                        <i class="ti ti-map-pin"></i>
                        <span>Lihat Peta</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ==================== COUNTDOWN ==================== -->
        <section class="section-padding countdown-section">
            <div class="fade-up">
                <p class="section-eyebrow" style="color: var(--gold-light); opacity: 0.7;">Counting Down To</p>
                <h2 class="section-title" style="color: var(--white);">Menuju Hari Bahagia</h2>
                <div class="ornament-line"><span class="ornament-dot" style="background: var(--gold-light);"></span></div>

                <div class="countdown-grid" id="countdown">
                    <div class="timer-box">
                        <p id="days" class="timer-val">00</p>
                        <p class="timer-label">Hari</p>
                    </div>
                    <div class="timer-box">
                        <p id="hours" class="timer-val">00</p>
                        <p class="timer-label">Jam</p>
                    </div>
                    <div class="timer-box">
                        <p id="minutes" class="timer-val">00</p>
                        <p class="timer-label">Menit</p>
                    </div>
                    <div class="timer-box">
                        <p id="seconds" class="timer-val">00</p>
                        <p class="timer-label">Detik</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== LOVE STORY ==================== -->
        @php
            $loveStories = is_array($invitation->love_story)
                ? $invitation->love_story
                : json_decode($invitation->love_story, true);
        @endphp

        @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
        <section id="love-story" class="love-story-section">
            <div class="text-center mb-4 fade-up">
                <p class="section-eyebrow">Our Journey</p>
                <h2 class="section-title">Kisah Cinta Kami</h2>
                <div class="ornament-line"><span class="ornament-dot"></span></div>
            </div>

            <div class="timeline">
                <div class="timeline-line"></div>
                @foreach($loveStories as $index => $story)
                <div class="timeline-item fade-up stagger-{{ min($index + 1, 4) }}">
                    <div class="timeline-dot"></div>
                    @if(!empty($story['date']))
                        <p class="timeline-date">{{ $story['date'] }}</p>
                    @endif
                    <h5>{{ $story['title'] }}</h5>
                    <div class="timeline-content">
                        <p>{{ $story['story'] }}</p>
                        @if(!empty($story['photo']))
                            <img src="{{ '/storage/' . $story['photo'] }}" alt="Story Photo" loading="lazy">
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- ==================== GALLERY ==================== -->
        <section class="section-padding gallery-section">
            <div class="text-center mb-4 fade-up">
                <p class="section-eyebrow">Our Moments</p>
                <h2 class="section-title">Galeri Foto</h2>
                <div class="ornament-line"><span class="ornament-dot"></span></div>
            </div>
            <div class="masonry-gallery fade-up">
                @forelse($invitation->galleries as $photo)
                <a href="{{ '/storage/' . $photo->image }}" data-fancybox="gallery" class="masonry-item" data-caption="">
                    <img src="{{ '/storage/' . $photo->image }}" alt="Gallery Photo" loading="lazy">
                </a>
                @empty
                <p class="text-center w-full" style="color: #bbb; font-style: italic;">Belum ada foto galeri.</p>
                @endforelse
            </div>
        </section>

        <!-- ==================== GIFTS ==================== -->
        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section id="gifts" class="gifts-section">
            <div class="text-center mb-4 fade-up">
                <p class="section-eyebrow">Wedding Gift</p>
                <h2 class="section-title">Kado Pernikahan</h2>
                <div class="ornament-line"><span class="ornament-dot"></span></div>
            </div>

            <div class="gifts-grid">
                @foreach($invitation->gifts as $gift)
                @php
                    $bankLogos = [
                        'BCA'      => 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg',
                        'BNI'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f0/Bank_Negara_Indonesia_logo_%282004%29.svg/640px-Bank_Negara_Indonesia_logo_%282004%29.svg.png',
                        'BRI'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/640px-BANK_BRI_logo.svg.png',
                        'Mandiri'  => 'https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg',
                        'CIMB'     => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/CIMB_Group_Logo.svg/640px-CIMB_Group_Logo.svg.png',
                        'OVO'      => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/640px-Logo_ovo_purple.svg.png',
                        'GoPay'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gopay_logo.svg/640px-Gopay_logo.svg.png',
                        'Dana'     => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/960px-Logo_dana_blue.svg.png',
                        'LinkAja'  => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Link_logo_%282019%29.svg/3840px-Link_logo_%282019%29.svg.png',
                        'ShopeePay'=> 'https://images.seeklogo.com/logo-png/40/2/shopee-pay-logo-png_seeklogo-406839.png',
                    ];
                @endphp

                <div class="gift-card fade-up stagger-{{ min($loop->index + 1, 4) }}">
                    <div class="gift-logo">
                        @if(!empty($bankLogos[$gift->bank]))
                            <img src="{{ $bankLogos[$gift->bank] }}" alt="{{ $gift->bank }}" loading="lazy">
                        @else
                            <i class="ti ti-wallet" style="font-size: 1.3rem; color: var(--gold-dark);"></i>
                        @endif
                    </div>

                    <div class="gift-content">
                        <h5 class="gift-name">{{ strtoupper($gift->name) }}</h5>
                        <p class="gift-number">{{ $gift->number }}</p>
                    </div>

                    <button class="gift-copy" onclick="copyText('{{ $gift->number }}')">
                        <i class="ti ti-copy"></i> Salin
                    </button>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- ==================== RSVP ==================== -->
        @if($invitation->enable_rsvp == 1)
        <section class="rsvp-section">
            <div class="text-center mb-4 fade-up">
                <p class="section-eyebrow">RSVP</p>
                <h2 class="section-title">Ucapan & Doa</h2>
                <div class="ornament-line"><span class="ornament-dot"></span></div>
            </div>

            @if($invitation->rsvp_deadline)
            <div class="text-center mb-4 fade-up">
                <span class="rsvp-deadline">
                    <i class="ti ti-clock"></i>
                    Batas RSVP: {{ \Carbon\Carbon::parse($invitation->rsvp_deadline)->format('d/m/Y') }}
                </span>
            </div>
            @endif

            @if($invitation->rsvp_message)
            <div class="rsvp-meta fade-up">
                "{{ $invitation->rsvp_message }}"
            </div>
            @endif

            <div class="rsvp-form fade-up">
                <form id="rsvpForm">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input class="form-control" placeholder="Masukkan nama Anda" name="name" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Kehadiran</label>
                        <select class="form-control" name="attending" required>
                            <option value="1">Hadir</option>
                            <option value="2">Tidak Hadir</option>
                            <option value="3">Masih Ragu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ucapan & Doa</label>
                        <textarea id="rsvpMessageInput" class="form-control" rows="3" placeholder="Tulis doa & ucapan terbaik untuk kedua mempelai..." name="message" style="height: 110px; resize: none;" required></textarea>
                    </div>
                    <div class="text-center">
                        <button id="rsvpButton" type="submit" class="btn-primary" style="width: 100%; margin-top: 0; padding: 16px;">
                            <span id="buttonText">Kirim Ucapan</span>
                            <svg id="buttonSpinner" class="animate-spin hidden" style="width: 18px; height: 18px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div id="rsvpMessage" class="text-center mt-4 text-sm font-bold hidden"></div>

            <div class="rsvp-list-wrapper fade-up">
                <h4 class="text-center" style="font-family: 'Cormorant Garamond', serif; font-size: 1.05rem; color: var(--primary); margin-bottom: 16px; font-weight: 500;">
                    Doa Terbaik dari Tamu Undangan
                </h4>
                <div id="rsvpList" class="rsvp-list"></div>
                <div class="rsvp-count">({{ $invitation->rsvps->count() }} Ucapan)</div>
            </div>

            @if($invitation->rsvp_whatsapp)
            <div class="text-center mt-6 fade-up">
                <a href="https://wa.me/{{ $invitation->rsvp_whatsapp }}?text=Halo,%20saya%20ingin%20konfirmasi%20RSVP%20untuk%20undangan%20pernikahan."
                   target="_blank" class="rsvp-whatsapp">
                    <i class="ti ti-brand-whatsapp" style="font-size: 1.1rem;"></i> Konfirmasi via WhatsApp
                </a>
            </div>
            @endif
        </section>
        @endif

        <!-- ==================== FOOTER ==================== -->
        <footer class="footer">
            <div class="footer-script">With Love</div>
            <h2 class="footer-names">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h2>
            <div class="ornament-line"><span class="ornament-dot" style="background: var(--gold-light);"></span></div>
            <p class="footer-text">Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir untuk memberikan doa restu.</p>
            <p class="footer-copy">&copy; {{ date('Y') }} Elegant Wedding Invitation</p>
        </footer>

        <!-- Toast -->
        <div id="toast">Berhasil disalin</div>

    </div>

    <!-- Audio Element -->
    @if(!empty($invitation->music_youtube_url))
        @php
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->music_youtube_url, $ytMatches);
            $youtubeId = $ytMatches['id'] ?? '';
        @endphp
        @if($youtubeId)
        <div id="youtubePlayerContainer" style="position:absolute; left:-9999px; width:2px; height:2px; overflow:hidden;">
            <iframe id="youtubeIframe" width="2" height="2"
                src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeId }}&controls=0&modestbranding=1&rel=0&mute=1"
                frameborder="0" allow="autoplay; encrypted-media; picture-in-picture"
                onload="window.ytIframeReady = true;">
            </iframe>
        </div>
        @endif
    @else
    <audio id="bgMusic" loop>
        @if(!empty($invitation->music) && !isset($invitation->musicPreset))
            <source src="{{ '/storage/' . $invitation->music }}" type="audio/mpeg">
        @elseif(!empty($invitation->musicPreset->audio_url))
            <source src="{{ '/storage/' . $invitation->musicPreset->audio_url }}" type="audio/mpeg">
        @else
            <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg">
        @endif
    </audio>
    @endif

    <!-- ==================== JAVASCRIPT ==================== -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ---------- 0. HERO BG LOAD ---------- */
        const heroBg = document.getElementById('heroBg');
        if (heroBg) {
            const bgImg = new Image();
            bgImg.onload = () => heroBg.classList.add('loaded');
            bgImg.src = heroBg.style.backgroundImage.replace(/url\(['"]?|['"]?\)/g, '');
        }

        /* ---------- 1. FLOATING PETALS ---------- */
        const canvas = document.getElementById('petalCanvas');
        const ctx = canvas.getContext('2d');
        let petals = [];
        const PETAL_COUNT = 15;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        /* Warna kelopak: emas, krem, rose muda */
        const petalColors = [
            'rgba(197,160,89,0.35)',
            'rgba(212,185,122,0.3)',
            'rgba(220,200,170,0.25)',
            'rgba(180,140,100,0.2)',
            'rgba(200,170,140,0.3)',
        ];

        function createPetal() {
            return {
                x: Math.random() * canvas.width,
                y: -20 - Math.random() * 100,
                size: 4 + Math.random() * 6,
                speedY: 0.3 + Math.random() * 0.6,
                speedX: -0.3 + Math.random() * 0.6,
                rotation: Math.random() * Math.PI * 2,
                rotSpeed: (Math.random() - 0.5) * 0.02,
                wobble: Math.random() * Math.PI * 2,
                wobbleSpeed: 0.01 + Math.random() * 0.02,
                color: petalColors[Math.floor(Math.random() * petalColors.length)],
                aspectRatio: 0.5 + Math.random() * 0.3,
            };
        }

        for (let i = 0; i < PETAL_COUNT; i++) {
            const p = createPetal();
            p.y = Math.random() * canvas.height; /* Sebar awal */
            petals.push(p);
        }

        function drawPetal(p) {
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rotation);
            ctx.fillStyle = p.color;
            ctx.beginPath();
            const r = Math.max(1, p.size);
            const rw = r * p.aspectRatio;
            ctx.ellipse(0, 0, rw, r, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }

        function animatePetals() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            petals.forEach((p, i) => {
                p.wobble += p.wobbleSpeed;
                p.x += p.speedX + Math.sin(p.wobble) * 0.5;
                p.y += p.speedY;
                p.rotation += p.rotSpeed;

                drawPetal(p);

                /* Reset jika keluar layar */
                if (p.y > canvas.height + 20 || p.x < -30 || p.x > canvas.width + 30) {
                    petals[i] = createPetal();
                }
            });
            requestAnimationFrame(animatePetals);
        }

        /* Cek preferensi reduced motion */
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            animatePetals();
        }

        /* ---------- 2. TOAST & COPY ---------- */
        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'show';
            setTimeout(() => { toast.className = toast.className.replace('show', ''); }, 3000);
        }

        window.copyText = function(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast("Nomor rekening berhasil disalin!");
            }).catch(() => {
                /* Fallback */
                const ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showToast("Nomor rekening berhasil disalin!");
            });
        };

        /* ---------- 3. SCROLL ANIMATIONS ---------- */
        const observerOptions = { threshold: 0.15, rootMargin: '0px 0px -40px 0px' };
        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    scrollObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-up, .fade-in-scale').forEach(el => {
            scrollObserver.observe(el);
        });

        /* ---------- 4. MUSIC PLAYER ---------- */
        @if(!empty($invitation->music_youtube_url) && !empty($youtubeId))
        let ytIframe = document.getElementById('youtubeIframe');
        let ytMuted = true;
        const musicBtn = document.getElementById('musicBtn');
        const musicIcon = document.getElementById('musicIcon');
        let hasInteracted = false;

        function toggleMusicIcon(isPlaying) {
            musicIcon.classList.toggle('ti-player-play', !isPlaying);
            musicIcon.classList.toggle('ti-player-pause', isPlaying);
            musicBtn.classList.toggle('playing', isPlaying);
        }

        function sendYtCommand(command) {
            if (!ytIframe) return;
            const msg = JSON.stringify({ event: 'command', func: command, args: [] });
            const post = () => ytIframe.contentWindow.postMessage(msg, '*');
            if (window.ytIframeReady) { setTimeout(post, 200); }
            else {
                const check = setInterval(() => {
                    if (window.ytIframeReady) { clearInterval(check); setTimeout(post, 200); }
                }, 100);
                setTimeout(() => { clearInterval(check); setTimeout(post, 500); }, 2000);
            }
        }

        function pauseYoutube() { sendYtCommand('pauseVideo'); sendYtCommand('pause'); toggleMusicIcon(false); }
        function playYoutube() {
            if (ytMuted) { sendYtCommand('unMute'); ytMuted = false; }
            sendYtCommand('playVideo'); sendYtCommand('play'); toggleMusicIcon(true);
        }

        window.addEventListener('scroll', () => {
            if (!hasInteracted) { playYoutube(); hasInteracted = true; }
        }, { once: true });

        musicBtn.addEventListener('click', () => {
            if (ytMuted || !hasInteracted) { playYoutube(); hasInteracted = true; }
            else { pauseYoutube(); }
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) pauseYoutube();
            else if (hasInteracted && !ytMuted) playYoutube();
        });
        @else
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicBtn');
        const musicIcon = document.getElementById('musicIcon');
        let hasInteracted = false;

        function toggleMusicIcon(isPlaying) {
            musicIcon.classList.toggle('ti-player-play', !isPlaying);
            musicIcon.classList.toggle('ti-player-pause', isPlaying);
            musicBtn.classList.toggle('playing', isPlaying);
        }

        window.addEventListener('scroll', () => {
            if (!hasInteracted && bgMusic.paused) {
                bgMusic.play().then(() => { toggleMusicIcon(true); hasInteracted = true; }).catch(() => {});
            }
        }, { once: true });

        musicBtn.addEventListener('click', () => {
            if (bgMusic.paused) { bgMusic.play(); toggleMusicIcon(true); }
            else { bgMusic.pause(); toggleMusicIcon(false); }
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) { if (!bgMusic.paused) { bgMusic.pause(); toggleMusicIcon(false); } }
            else if (hasInteracted) { bgMusic.play().then(() => toggleMusicIcon(true)).catch(() => {}); }
        });
        @endif

        /* ---------- 5. COUNTDOWN ---------- */
        const weddingDate = new Date("{{ $invitation->wedding_date }}").getTime();
        const countdownEl = document.getElementById('countdown');

        const timerInterval = setInterval(() => {
            if (isNaN(weddingDate)) { clearInterval(timerInterval); return; }
            const distance = weddingDate - new Date().getTime();

            if (distance < 0) {
                clearInterval(timerInterval);
                countdownEl.innerHTML = `
                    <div style="grid-column: span 4; text-align: center;">
                        <p style="font-family: 'Great Vibes', cursive; font-size: 2rem; color: var(--gold-light);">Sudah Hari Bahagia!</p>
                        <p style="color: rgba(255,255,255,0.7); font-size: 0.85rem; margin-top: 10px;">Terima kasih atas doa restu Anda</p>
                    </div>`;
                return;
            }

            document.getElementById("days").innerText    = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            document.getElementById("hours").innerText   = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            document.getElementById("minutes").innerText = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            document.getElementById("seconds").innerText = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }, 1000);

        /* ---------- 6. RSVP ---------- */
        const invitationId = "{{ $invitation->id }}";
        const form = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');
        const rsvpListEl = document.getElementById('rsvpList');
        const rsvpMessageEl = document.getElementById('rsvpMessage');
        const textarea = document.getElementById('rsvpMessageInput');

        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });
        }

        /* Ambil inisial untuk avatar */
        function getInitials(name) {
            return name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
        }

        function renderRsvpList(rsvps) {
            if (!rsvps || rsvps.length === 0) {
                rsvpListEl.innerHTML = '<div class="text-center" style="color: #bbb; padding: 24px; font-size: 0.82rem; font-style: italic;">Belum ada ucapan. Jadilah yang pertama!</div>';
                return;
            }
            rsvpListEl.innerHTML = rsvps.map(rsvp => `
                <div class="comment-item">
                    <div class="comment-avatar">${getInitials(rsvp.name)}</div>
                    <div>
                        <p class="comment-name">${rsvp.name}</p>
                        <p class="comment-text">${rsvp.message}</p>
                    </div>
                </div>
            `).join('');
        }

        function updateRsvpList() {
            fetch(`/invitation/${invitationId}/rsvps`)
                .then(res => res.json())
                .then(data => renderRsvpList(data))
                .catch(() => {});
        }

        /* Load awal */
        updateRsvpList();

        /* Auto-refresh setiap 10 detik */
        setInterval(updateRsvpList, 10000);

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (rsvpButton.disabled) return;

                rsvpButton.disabled = true;
                buttonText.textContent = 'Mengirim...';
                buttonSpinner.classList.remove('hidden');

                const formData = new FormData(form);
                fetch(`/invitation/${invitationId}/rsvp`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': formData.get('_token') },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        form.reset();
                        if (textarea) { textarea.style.height = 'auto'; }
                        showToast('Terima kasih! Ucapan Anda telah terkirim.');
                        updateRsvpList();
                    } else {
                        showToast(data.message || 'Gagal mengirim ucapan.');
                    }
                })
                .catch(() => {
                    showToast('Terjadi kesalahan. Silakan coba lagi.');
                })
                .finally(() => {
                    rsvpButton.disabled = false;
                    buttonText.textContent = 'Kirim Ucapan';
                    buttonSpinner.classList.add('hidden');
                });
            });
        }

        /* ---------- 7. REMINDER BTN ---------- */
        const reminderBtn = document.getElementById('reminderBtn');
        if (reminderBtn && 'shared' in navigator) {
            reminderBtn.addEventListener('click', async () => {
                try {
                    await navigator.share({
                        title: '{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} Wedding',
                        text: 'Anda diundang ke pernikahan {{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }} pada {{ \Carbon\Carbon::parse($invitation->wedding_date)->locale("id")->translatedFormat("d F Y") }}',
                        url: window.location.href
                    });
                } catch(err) {
                    /* Jika share dibatalkan, biarkan saja */
                }
            });
        } else if (reminderBtn) {
            reminderBtn.addEventListener('click', () => {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    showToast('Link undangan berhasil disalin!');
                });
            });
        }

    });
    </script>

</body>
</html>
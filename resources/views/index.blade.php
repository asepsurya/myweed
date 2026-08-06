<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeddingInv — Undangan Pernikahan Digital Elegan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --gold: #C6A962;
            --gold-light: #E8D5A3;
            --gold-dark: #A68B4B;
            --navy: #1B2A4A;
            --navy-light: #2A3F6A;
            --charcoal: #2D2D2D;
            --warm-gray: #F7F5F2;
            --mid-gray: #E8E4DE;
            --text-primary: #1B2A4A;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --white: #FFFFFF;
            --glass-bg: rgba(255,255,255,0.72);
            --glass-border: rgba(255,255,255,0.3);
            --shadow-sm: 0 1px 3px rgba(27,42,74,0.04), 0 1px 2px rgba(27,42,74,0.06);
            --shadow-md: 0 4px 16px rgba(27,42,74,0.06), 0 2px 4px rgba(27,42,74,0.04);
            --shadow-lg: 0 12px 40px rgba(27,42,74,0.08), 0 4px 12px rgba(27,42,74,0.04);
            --shadow-xl: 0 24px 60px rgba(27,42,74,0.10), 0 8px 20px rgba(27,42,74,0.06);
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --transition: 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-primary);
            background: var(--white);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 600;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        ::selection {
            background: var(--gold-light);
            color: var(--navy);
        }

        /* ========== SCROLL ANIMATIONS ========== */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        @media (prefers-reduced-motion: reduce) {
            .reveal { opacity: 1; transform: none; transition: none; }
            .float-card, .hero-img, .feature-icon-box, .template-card, .pricing-card { transition: none !important; animation: none !important; }
        }

        /* ========== NAVBAR ========== */
        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-bottom: 1px solid rgba(27,42,74,0.06);
            padding: 0.85rem 0;
            transition: var(--transition);
        }
        .navbar.scrolled {
            padding: 0.6rem 0;
            box-shadow: var(--shadow-md);
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.45rem;
            color: var(--navy);
            letter-spacing: -0.02em;
        }
        .navbar-brand span { color: var(--gold); }
        .nav-link {
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 0.5rem 1rem !important;
            border-radius: 50px;
            transition: var(--transition);
            position: relative;
        }
        .nav-link:hover { color: var(--navy); background: rgba(27,42,74,0.04); }
        .btn-nav {
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            background: var(--navy);
            color: var(--white);
            border-radius: 50px;
            padding: 0.55rem 1.6rem;
            border: none;
            transition: var(--transition);
            letter-spacing: 0.01em;
        }
        .btn-nav:hover {
            background: var(--gold-dark);
            color: var(--white);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(198,169,98,0.3);
        }
        .navbar-toggler { border: none; padding: 0.4rem; }
        .navbar-toggler:focus { box-shadow: none; }

        /* ========== HERO ========== */
        .hero-section {
            margin-top: 72px;
            padding: 80px 0 100px;
            background: var(--warm-gray);
            position: relative;
            overflow: hidden;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(198,169,98,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -150px;
            left: -150px;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(27,42,74,0.04) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--white);
            border: 1px solid var(--mid-gray);
            padding: 0.4rem 1rem 0.4rem 0.5rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 1.8rem;
            box-shadow: var(--shadow-sm);
        }
        .hero-badge-dot {
            width: 22px; height: 22px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--white);
            font-size: 0.65rem;
        }
        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.4rem);
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            line-height: 1.12;
        }
        .hero-title em {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 600;
            color: var(--gold-dark);
        }
        .hero-desc {
            font-size: 1.05rem;
            line-height: 1.75;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            max-width: 480px;
        }
        .hero-actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .btn-gold {
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            border: none;
            border-radius: 50px;
            padding: 0.85rem 2rem;
            transition: var(--transition);
            letter-spacing: 0.01em;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(198,169,98,0.35);
            color: var(--white);
        }
        .btn-ghost {
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            font-weight: 600;
            background: transparent;
            color: var(--navy);
            border: 1.5px solid rgba(27,42,74,0.15);
            border-radius: 50px;
            padding: 0.8rem 2rem;
            transition: var(--transition);
        }
        .btn-ghost:hover {
            border-color: var(--navy);
            background: rgba(27,42,74,0.03);
            transform: translateY(-1px);
        }
        .hero-trust {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 2rem;
            font-size: 0.82rem;
            color: var(--text-muted);
        }
        .hero-trust-stars { display: flex; gap: 1px; }
        .hero-trust-stars i { font-size: 0.8rem; color: var(--gold); }

        /* Hero Image */
        .hero-visual { position: relative; padding: 1.5rem 0 1.5rem 2rem; }
        .hero-img-main {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            width: 100%;
            object-fit: cover;
            aspect-ratio: 4/5;
            max-height: 520px;
        }
        .hero-float-card {
            position: absolute;
            bottom: 30px;
            left: -10px;
            background: var(--white);
            border: 1px solid rgba(27,42,74,0.06);
            padding: 0.9rem 1.3rem;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 0.85rem;
            animation: heroFloat 4s ease-in-out infinite;
            z-index: 2;
        }
        @keyframes heroFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .hero-float-icon {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .hero-float-label { font-size: 0.75rem; color: var(--text-muted); }
        .hero-float-value { font-size: 0.85rem; font-weight: 600; color: var(--navy); }

        .hero-float-card-2 {
            position: absolute;
            top: 20px;
            right: -5px;
            background: var(--white);
            border: 1px solid rgba(27,42,74,0.06);
            padding: 0.75rem 1.1rem;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 0.6rem;
            animation: heroFloat2 5s ease-in-out infinite;
            z-index: 2;
        }
        @keyframes heroFloat2 {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        /* ========== STATS BAR ========== */
        .stats-bar {
            background: var(--white);
            border-bottom: 1px solid rgba(27,42,74,0.05);
            padding: 2.5rem 0;
        }
        .stat-item { text-align: center; }
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy);
            line-height: 1;
            margin-bottom: 0.4rem;
        }
        .stat-number span { color: var(--gold); }
        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* ========== SECTION COMMONS ========== */
        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gold-dark);
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 1rem;
        }
        .section-tag::before {
            content: '';
            width: 24px; height: 1.5px;
            background: var(--gold);
        }
        .section-title {
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            color: var(--navy);
            margin-bottom: 1rem;
        }
        .section-desc {
            font-size: 1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            max-width: 560px;
        }
        .section-desc.mx-auto { text-align: center; }

        /* ========== FEATURES ========== */
        .features-section { padding: 6rem 0; background: var(--white); }
        .feature-card {
            background: var(--white);
            border: 1px solid rgba(27,42,74,0.06);
            border-radius: var(--radius-lg);
            padding: 2.2rem 1.8rem;
            height: 100%;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 3px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }
        .feature-card:hover {
            border-color: transparent;
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-icon {
            width: 52px; height: 52px;
            background: var(--warm-gray);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            color: var(--gold-dark);
            margin-bottom: 1.4rem;
            transition: var(--transition);
        }
        .feature-card:hover .feature-icon {
            background: var(--navy);
            color: var(--gold-light);
        }
        .feature-card h4 {
            font-size: 1.15rem;
            margin-bottom: 0.7rem;
            color: var(--navy);
        }
        .feature-card p {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.65;
            margin: 0;
        }

        /* ========== TEMPLATES ========== */
        .templates-section {
            padding: 6rem 0;
            background: var(--warm-gray);
        }
        .template-card {
            border: none;
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: var(--white);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
        }
        .template-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }
        .template-img-wrap {
            position: relative;
            overflow: hidden;
            aspect-ratio: 3/4;
        }
        .template-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .template-card:hover .template-img-wrap img {
            transform: scale(1.05);
        }
        .template-overlay {
            position: absolute;
            inset: 0;
            background: rgba(27,42,74,0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: var(--transition);
        }
        .template-card:hover .template-overlay { opacity: 1; }
        .btn-template-preview {
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            font-weight: 600;
            background: var(--white);
            color: var(--navy);
            border: none;
            border-radius: 50px;
            padding: 0.65rem 1.5rem;
            transition: var(--transition);
            transform: translateY(10px);
        }
        .template-card:hover .btn-template-preview { transform: translateY(0); }
        .btn-template-preview:hover { background: var(--gold); color: var(--white); }
        .template-info { padding: 1.1rem 1.3rem; }
        .template-info h5 {
            font-size: 1rem;
            margin-bottom: 0.15rem;
            color: var(--navy);
        }
        .template-info small {
            font-size: 0.78rem;
            color: var(--text-muted);
        }
        .btn-all-templates {
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--navy);
            background: var(--white);
            border: 1.5px solid rgba(27,42,74,0.12);
            border-radius: 50px;
            padding: 0.8rem 2.2rem;
            transition: var(--transition);
        }
        .btn-all-templates:hover {
            border-color: var(--navy);
            background: var(--navy);
            color: var(--white);
            transform: translateY(-1px);
        }

        /* ========== HOW IT WORKS ========== */
        .how-section { padding: 6rem 0; background: var(--white); }
        .how-image-wrap {
            position: relative;
            border-radius: var(--radius-xl);
            overflow: hidden;
        }
        .how-image-wrap img {
            width: 100%;
            aspect-ratio: 4/5;
            object-fit: cover;
            border-radius: var(--radius-xl);
        }
        .how-image-badge {
            position: absolute;
            bottom: 1.5rem;
            left: 1.5rem;
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-md);
            padding: 1rem 1.4rem;
            box-shadow: var(--shadow-md);
        }
        .how-image-badge-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gold-dark);
            line-height: 1;
        }
        .how-image-badge-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        .step-item {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 2rem;
            position: relative;
        }
        .step-item:last-child { margin-bottom: 0; }
        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 44px;
            bottom: -16px;
            width: 2px;
            background: linear-gradient(to bottom, var(--mid-gray), transparent);
        }
        .step-num {
            width: 40px; height: 40px;
            min-width: 40px;
            border-radius: 50%;
            background: var(--warm-gray);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--gold-dark);
            transition: var(--transition);
            position: relative;
            z-index: 1;
        }
        .step-item:hover .step-num {
            background: var(--navy);
            color: var(--gold-light);
        }
        .step-body h5 {
            font-size: 1.1rem;
            margin-bottom: 0.35rem;
            color: var(--navy);
        }
        .step-body p {
            font-size: 0.88rem;
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 0;
        }

        /* ========== PRICING ========== */
        .pricing-section { padding: 6rem 0; background: var(--warm-gray); }
        .pricing-card {
            background: var(--white);
            border: 1px solid rgba(27,42,74,0.06);
            border-radius: var(--radius-xl);
            padding: 2.8rem 2.2rem;
            transition: var(--transition);
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .pricing-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }
        .pricing-card.featured {
            border-color: var(--gold);
            box-shadow: 0 8px 40px rgba(198,169,98,0.15);
            transform: scale(1.03);
            z-index: 2;
        }
        .pricing-card.featured:hover {
            transform: scale(1.03) translateY(-4px);
        }
        .pricing-badge {
            position: absolute;
            top: -13px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.35rem 1.2rem;
            border-radius: 50px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .pricing-tier {
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 0.8rem;
        }
        .pricing-price {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.3rem;
            line-height: 1;
        }
        .pricing-price span {
            font-family: 'Inter', sans-serif;
            font-size: 0.82rem;
            font-weight: 400;
            color: var(--text-muted);
        }
        .pricing-desc {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 1.8rem;
            padding-bottom: 1.8rem;
            border-bottom: 1px solid var(--mid-gray);
        }
        .pricing-features { list-style: none; padding: 0; margin: 0 0 2rem; flex: 1; }
        .pricing-features li {
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 0.85rem;
            line-height: 1.45;
        }
        .pricing-features li i {
            font-size: 0.85rem;
            margin-top: 2px;
            flex-shrink: 0;
        }
        .pricing-features li .check { color: #22C55E; }
        .pricing-features li .cross { color: var(--text-muted); }
        .btn-pricing {
            font-family: 'Inter', sans-serif;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: 50px;
            padding: 0.85rem 1.5rem;
            width: 100%;
            text-align: center;
            transition: var(--transition);
            border: 1.5px solid rgba(27,42,74,0.12);
            background: transparent;
            color: var(--navy);
        }
        .btn-pricing:hover {
            background: var(--navy);
            color: var(--white);
            border-color: var(--navy);
            transform: translateY(-1px);
        }
        .btn-pricing.primary {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            border: none;
        }
        .btn-pricing.primary:hover {
            box-shadow: 0 8px 24px rgba(198,169,98,0.35);
            transform: translateY(-2px);
        }

        /* ========== CTA ========== */
        .cta-section {
            padding: 6rem 0;
            background: var(--navy);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%; left: -20%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(198,169,98,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        .cta-section::after {
            content: '';
            position: absolute;
            bottom: -40%; right: -10%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(198,169,98,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .cta-title {
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            color: var(--white);
            margin-bottom: 0.8rem;
        }
        .cta-desc {
            font-size: 1rem;
            color: rgba(255,255,255,0.55);
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }
        .btn-cta {
            font-family: 'Inter', sans-serif;
            font-size: 0.92rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
            border: none;
            border-radius: 50px;
            padding: 1rem 2.5rem;
            transition: var(--transition);
            letter-spacing: 0.01em;
        }
        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(198,169,98,0.4);
            color: var(--white);
        }

        /* ========== FOOTER ========== */
        .site-footer {
            background: #111827;
            color: rgba(255,255,255,0.5);
            padding: 3.5rem 0 1.5rem;
        }
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 0.6rem;
        }
        .footer-brand span { color: var(--gold); }
        .footer-tagline {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.35);
            line-height: 1.6;
            max-width: 280px;
        }
        .footer-heading {
            font-family: 'Inter', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.7);
            margin-bottom: 1.2rem;
        }
        .footer-link {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            display: block;
            margin-bottom: 0.7rem;
            transition: var(--transition);
        }
        .footer-link:hover { color: var(--gold-light); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.06);
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.3);
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 991px) {
            .hero-section { padding: 50px 0 70px; text-align: center; }
            .hero-desc { margin-left: auto; margin-right: auto; }
            .hero-actions { justify-content: center; }
            .hero-trust { justify-content: center; }
            .hero-visual { padding: 2rem 1rem 0; }
            .hero-float-card {
                left: 50%;
                transform: translateX(-50%);
                bottom: -10px;
            }
            @keyframes heroFloat {
                0%, 100% { transform: translateX(-50%) translateY(0); }
                50% { transform: translateX(-50%) translateY(-8px); }
            }
            .hero-float-card-2 {
                right: 10px;
                top: 10px;
            }
            @keyframes heroFloat2 {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-6px); }
            }
            .pricing-card.featured { transform: scale(1); }
            .pricing-card.featured:hover { transform: translateY(-4px); }
            .how-image-wrap { margin-bottom: 2.5rem; }
        }

        @media (max-width: 575px) {
            .hero-section { margin-top: 64px; padding: 40px 0 60px; }
            .stat-number { font-size: 1.6rem; }
            .features-section, .templates-section, .how-section, .pricing-section { padding: 4rem 0; }
            .cta-section { padding: 4rem 0; }
            .pricing-card { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Wedding<span>Inv</span>.
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#template">Template</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cara-kerja">Cara Kerja</a></li>
                    <li class="nav-item"><a class="nav-link" href="#harga">Harga</a></li>
                    @auth
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-nav">Dashboard</a>
                    </li>
                    @else
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('login') }}" class="btn btn-nav">Mulai Sekarang</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="hero-badge reveal">
                        <span class="hero-badge-dot"><i class="bi bi-arrow-up-right"></i></span>
                        #1 Platform Undangan Digital Indonesia
                    </div>
                    <h1 class="hero-title reveal reveal-delay-1">
                        Bagikan Kebahagiaan<em> Pernikahanmu</em> Tanpa Batas
                    </h1>
                    <p class="hero-desc reveal reveal-delay-2">
                        Buat website undangan pernikahan yang elegan dalam hitungan menit. Lengkap dengan galeri, RSVP, musik latar, dan amplop digital.
                    </p>
                    <div class="hero-actions reveal reveal-delay-3">
                        <a href="#template" class="btn btn-gold">Lihat Template <i class="bi bi-arrow-right ms-1"></i></a>
                        <a href="#fitur" class="btn btn-ghost">Pelajari Lebih Lanjut</a>
                    </div>
                    <div class="hero-trust reveal reveal-delay-4">
                        <div class="hero-trust-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <span>Dipercaya 10.000+ pasangan pengantin</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-visual reveal reveal-delay-2">
                        <img src="{{ asset('tempelate/hero2.jpg') }}" alt="Preview Undangan Digital" class="hero-img-main">
                        <div class="hero-float-card">
                            <div class="hero-float-icon" style="background:#ECFDF5; color:#22C55E;">
                                <i class="bi bi-check2-all"></i>
                            </div>
                            <div>
                                <div class="hero-float-label">RSVP Terbaru</div>
                                <div class="hero-float-value">Anda hadir! 🎉</div>
                            </div>
                        </div>
                        <div class="hero-float-card-2">
                            <div class="hero-float-icon" style="background:#FEF3C7; color:#D97706;">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <div>
                                <div class="hero-float-label">Wisih</div>
                                <div class="hero-float-value">+248 hari</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats-bar">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-3 stat-item reveal">
                    <div class="stat-number">5<span>K+</span></div>
                    <div class="stat-label">Template Premium</div>
                </div>
                <div class="col-6 col-md-3 stat-item reveal reveal-delay-1">
                    <div class="stat-number">24<span>/7</span></div>
                    <div class="stat-label">Layanan Support</div>
                </div>
                <div class="col-6 col-md-3 stat-item reveal reveal-delay-2">
                    <div class="stat-number">100<span>%</span></div>
                    <div class="stat-label">Garansi Uang Kembali</div>
                </div>
                <div class="col-6 col-md-3 stat-item reveal reveal-delay-3">
                    <div class="stat-number">10<span>K+</span></div>
                    <div class="stat-label">Pernikahan Sukses</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="fitur" class="features-section">
        <div class="container">
            <div class="text-center mb-5 pb-2">
                <div class="section-tag justify-content-center reveal">Fitur Unggulan</div>
                <h2 class="section-title reveal reveal-delay-1">Semua yang Anda Butuhkan<br>dalam Satu Platform</h2>
                <p class="section-desc mx-auto reveal reveal-delay-2">Alat terlengkap untuk membuat undangan pernikahan digital yang profesional, personal, dan berkesan.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 reveal reveal-delay-1">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-images"></i></div>
                        <h4>Galeri Foto Unlimited</h4>
                        <p>Unggah foto prewedding tanpa batas. Tampilkan momen indah dengan tata letak grid yang estetik.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-2">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-envelope-check"></i></div>
                        <h4>Manajemen RSVP Otomatis</h4>
                        <p>Pantau kehadiran tamu real-time. Export data ke Excel untuk keperluan seating & catering.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-music-note-beamed"></i></div>
                        <h4>Background Music</h4>
                        <p>Pilih lagu romantis dari library kami atau upload lagu favorit sebagai pengiring undangan.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-1">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-gift"></i></div>
                        <h4>Amplop Digital</h4>
                        <p>Terima kado dan transfer bank langsung via website. Praktis dan aman untuk tamu jauh.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-2">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-share"></i></div>
                        <h4>Share Link Mudah</h4>
                        <p>Sebarkan undangan via WhatsApp, Instagram, atau Facebook hanya dengan satu klik share.</p>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-3">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-palette"></i></div>
                        <h4>Kustomisasi Warna</h4>
                        <p>Sesuaikan warna tema undangan dengan nuansa acara pernikahanmu. Fleksibel dan mudah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Templates -->
    <section id="template" class="templates-section">
        <div class="container">
            <div class="text-center mb-5 pb-2">
                <div class="section-tag justify-content-center reveal">Showcase</div>
                <h2 class="section-title reveal reveal-delay-1">Pilih Desain Sesuai Karaktermu</h2>
                <p class="section-desc mx-auto reveal reveal-delay-2">Ratusan template premium yang siap pakai, dari yang minimalis hingga mewah.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 reveal reveal-delay-1">
                    <div class="template-card">
                        <div class="template-img-wrap">
                            <img src="https://picsum.photos/seed/rustic-garden/400/530" alt="Rustic Garden">
                            <div class="template-overlay">
                                <button class="btn-template-preview">Preview Demo <i class="bi bi-arrow-up-right ms-1"></i></button>
                            </div>
                        </div>
                        <div class="template-info">
                            <h5>Rustic Garden</h5>
                            <small>Outdoor · Casual · Earth Tone</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-2">
                    <div class="template-card">
                        <div class="template-img-wrap">
                            <img src="https://picsum.photos/seed/gold-lux/400/530" alt="Gold Luxury">
                            <div class="template-overlay">
                                <button class="btn-template-preview">Preview Demo <i class="bi bi-arrow-up-right ms-1"></i></button>
                            </div>
                        </div>
                        <div class="template-info">
                            <h5>Gold Luxury</h5>
                            <small>Indoor · Mewah · Elegant</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-3">
                    <div class="template-card">
                        <div class="template-img-wrap">
                            <img src="https://picsum.photos/seed/sage-min/400/530" alt="Sage Minimalist">
                            <div class="template-overlay">
                                <button class="btn-template-preview">Preview Demo <i class="bi bi-arrow-up-right ms-1"></i></button>
                            </div>
                        </div>
                        <div class="template-info">
                            <h5>Sage Minimalist</h5>
                            <small>Modern · Simple · Soft</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5 reveal">
                <a href="#" class="btn-all-templates">Lihat Semua Template <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="cara-kerja" class="how-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0 reveal">
                    <div class="how-image-wrap">
                        <img src="{{ asset('tempelate/hero.jpg') }}" alt="Cara Kerja">
                        <div class="how-image-badge">
                            <div class="how-image-badge-num">3</div>
                            <div class="how-image-badge-label">Langkah<br>Mudah</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="section-tag reveal">Cara Kerja</div>
                    <h2 class="section-title reveal reveal-delay-1 mb-4">Menuju Hari Bahagia dalam 3 Langkah</h2>

                    <div class="step-item reveal reveal-delay-1">
                        <div class="step-num">1</div>
                        <div class="step-body">
                            <h5>Pilih Template</h5>
                            <p>Telusuri ratusan desain dan pilih yang paling merepresentasikan kisah cintamu.</p>
                        </div>
                    </div>
                    <div class="step-item reveal reveal-delay-2">
                        <div class="step-num">2</div>
                        <div class="step-body">
                            <h5>Isi Data & Kustomisasi</h5>
                            <p>Masukkan detail acara, upload foto, pilih musik latar, dan sesuaikan warna tema.</p>
                        </div>
                    </div>
                    <div class="step-item reveal reveal-delay-3">
                        <div class="step-num">3</div>
                        <div class="step-body">
                            <h5>Sebarkan Undangan</h5>
                            <p>Dapatkan link unik dan sebarkan ke kerabat & sahabat via WhatsApp dalam sekejap.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="harga" class="pricing-section">
        <div class="container">
            <div class="text-center mb-5 pb-2">
                <div class="section-tag justify-content-center reveal">Harga</div>
                <h2 class="section-title reveal reveal-delay-1">Investasi Kecil untuk<br>Kenangan Abadi</h2>
                <p class="section-desc mx-auto reveal reveal-delay-2">Pilih paket yang sesuai kebutuhanmu. Semua paket sudah termasuk hosting dan domain.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 reveal reveal-delay-1">
                    <div class="pricing-card">
                        <div class="pricing-tier">Basic</div>
                        <div class="pricing-price">Gratis <span>/ selamanya</span></div>
                        <div class="pricing-desc">Cocok untuk pasangan yang ingin coba-coba terlebih dahulu.</div>
                        <ul class="pricing-features">
                            <li><i class="bi bi-check-circle-fill check"></i> 1 Template Pilihan</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Maksimal 5 Foto</li>
                            <li><i class="bi bi-check-circle-fill check"></i> RSVP Standar</li>
                            <li><i class="bi bi-x-circle cross"></i> <span style="color:var(--text-muted)">Tanpa Musik Latar</span></li>
                            <li><i class="bi bi-x-circle cross"></i> <span style="color:var(--text-muted)">Terdapat Iklan Kecil</span></li>
                        </ul>
                        <a href="#" class="btn-pricing">Mulai Gratis</a>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-2">
                    <div class="pricing-card featured">
                        <div class="pricing-badge">Paling Laris</div>
                        <div class="pricing-tier">Premium</div>
                        <div class="pricing-price">Rp 149K <span>/ undangan</span></div>
                        <div class="pricing-desc">Paket terlengkap untuk undangan yang berkesan.</div>
                        <ul class="pricing-features">
                            <li><i class="bi bi-check-circle-fill check"></i> 100+ Template Premium</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Galeri Foto Unlimited</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Musik & Animasi</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Amplop Digital / Rekening</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Tanpa Iklan</li>
                        </ul>
                        <a href="#" class="btn-pricing primary">Pilih Premium</a>
                    </div>
                </div>
                <div class="col-md-4 reveal reveal-delay-3">
                    <div class="pricing-card">
                        <div class="pricing-tier">Exclusive</div>
                        <div class="pricing-price">Rp 499K <span>/ undangan</span></div>
                        <div class="pricing-desc">Untuk pasangan yang menginginkan sentuhan personal penuh.</div>
                        <ul class="pricing-features">
                            <li><i class="bi bi-check-circle-fill check"></i> Semua Fitur Premium</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Desain Khusus Request</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Domain Kustom (.com)</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Prioritas Support 24 Jam</li>
                            <li><i class="bi bi-check-circle-fill check"></i> Revisi Tanpa Batas</li>
                        </ul>
                        <a href="#" class="btn-pricing">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section text-center">
        <div class="container position-relative">
            <h3 class="cta-title reveal">Siap Membuat Undangan Impianmu?</h3>
            <p class="cta-desc reveal reveal-delay-1">Bergabunglah dengan ribuan pasangan lainnya. Buat undangan pernikahan digital yang elegan dan berkesan.</p>
            <a href="#" class="btn btn-cta reveal reveal-delay-2">Buat Undangan Sekarang <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4">
                    <div class="footer-brand">Wedding<span>Inv</span>.</div>
                    <p class="footer-tagline">Platform pembuat undangan pernikahan digital #1 di Indonesia. Elegan, mudah, dan terjangkau.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="footer-heading">Produk</div>
                    <a href="#template" class="footer-link">Template</a>
                    <a href="#harga" class="footer-link">Harga</a>
                    <a href="#fitur" class="footer-link">Fitur</a>
                    <a href="#" class="footer-link">Demo</a>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="footer-heading">Perusahaan</div>
                    <a href="#" class="footer-link">Tentang Kami</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Karir</a>
                    <a href="#" class="footer-link">Kontak</a>
                </div>
                <div class="col-lg-4">
                    <div class="footer-heading">Bantuan</div>
                    <a href="#" class="footer-link">Pusat Bantuan</a>
                    <a href="#" class="footer-link">Panduan Penggunaan</a>
                    <a href="#" class="footer-link">Kebijakan Privasi</a>
                    <a href="#" class="footer-link">Syarat & Ketentuan</a>
                </div>
            </div>
            <div class="footer-bottom text-center">
                &copy; 2024 WeddingInv Digital. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        const nav = document.getElementById('mainNav');
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const st = window.scrollY;
            if (st > 20) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
            lastScroll = st;
        }, { passive: true });

        // Scroll reveal
        const revealElements = document.querySelectorAll('.reveal');
        const observerOptions = {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        revealElements.forEach(el => observer.observe(el));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    const offset = nav.offsetHeight + 16;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });

                    // Close mobile menu if open
                    const navCollapse = document.getElementById('navbarNav');
                    const bsCollapse = bootstrap.Collapse.getInstance(navCollapse);
                    if (bsCollapse) bsCollapse.hide();
                }
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RuangUndang - Platform Undangan Digital Premium & Elegant</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/fav-icon.png') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --gold: #C6A962;
            --gold-light: #E8D5A3;
            --gold-dark: #A68B4B;
            --navy: #1B2A4A;
            --navy-light: #2A3F6A;
            --white: #FFFFFF;
            --bg: #F7F5F2;
            --bg-alt: #FDFBF7;
            --border: #E8E4DE;
            --text: #1B2A4A;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --radius: 12px;
            --radius-lg: 20px;
            --speed: 0.4s;
            --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-display: 'Playfair Display', Georgia, serif;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font);
            color: var(--text);
            background-color: var(--bg);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: all var(--speed) ease;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-display);
        }

        /* ===== Keyframes ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-15px) translateX(5px);
            }
        }

        @keyframes pulseSoft {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        /* ===== Scroll Reveal ===== */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== Navbar ===== */
        .navbar {
            padding: 1.5rem 0;
            background: transparent;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            transition: all var(--speed) ease;
        }

        .navbar.scrolled {
            padding: 1rem 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 4px 20px rgba(27, 42, 74, 0.05);
        }

        .navbar-brand {
            display: inline-block;
            padding: 0;
            margin: 0;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
            filter: brightness(0) invert(1);
            transition: filter var(--speed) ease;
        }

        .navbar.scrolled .navbar-brand img {
            filter: none;
        }

        .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8) !important;
            margin: 0 0.8rem;
            font-size: 0.9rem;
            position: relative;
        }

        .navbar.scrolled .nav-link {
            color: var(--text-secondary) !important;
        }

        .nav-link:hover {
            color: var(--gold-light) !important;
        }

        .navbar.scrolled .nav-link:hover {
            color: var(--gold-dark) !important;
        }

        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white) !important;
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            transition: all var(--speed);
            box-shadow: 0 4px 15px rgba(198, 169, 98, 0.3);
        }

        .btn-gold:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(198, 169, 98, 0.5);
        }

        /* ===== Hero Section ===== */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }

        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(27, 42, 74, 0.8), rgba(27, 42, 74, 0.95));
            z-index: 1;
        }

        .hero-shape {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(198, 169, 98, 0.2);
            z-index: 2;
            animation: float 10s infinite ease-in-out;
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            right: -50px;
            border-color: rgba(255, 255, 255, 0.1);
            animation-direction: reverse;
            animation-duration: 12s;
        }

        .shape-3 {
            width: 150px;
            height: 150px;
            top: 20%;
            right: 15%;
            background: radial-gradient(circle, rgba(198, 169, 98, 0.2) 0%, transparent 70%);
            border: none;
            animation: pulseSoft 6s infinite ease-in-out;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 800px;
        }

        .hero-tag {
            display: inline-block;
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            background: rgba(198, 169, 98, 0.15);
            border: 1px solid rgba(198, 169, 98, 0.3);
            color: var(--gold-light);
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            animation: fadeInDown 1s ease-out forwards;
            opacity: 0;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
            line-height: 1.2;
            animation: fadeInUp 1s ease-out 0.3s forwards;
            opacity: 0;
        }

        .hero-section h1 em {
            font-style: italic;
            color: var(--gold-light);
        }

        .hero-section p {
            font-size: 1.15rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2.5rem;
            font-weight: 300;
            line-height: 1.7;
            animation: fadeInUp 1s ease-out 0.6s forwards;
            opacity: 0;
        }

        .search-container {
            max-width: 600px;
            margin: 0 auto 2.5rem;
            position: relative;
            animation: fadeInUp 1s ease-out 0.9s forwards;
            opacity: 0;
        }

        .search-container input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3.5rem;
            border-radius: 50px;
            border: 1.5px solid transparent;
            background: var(--white);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            font-family: var(--font);
            font-size: 0.95rem;
            transition: all var(--speed) ease;
            outline: none;
        }

        .search-container input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(198, 169, 98, 0.2);
        }

        .search-container i {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .search-container .btn-search {
            position: absolute;
            right: 8px;
            top: 8px;
            bottom: 8px;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0 1.8rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Tags */
        .tag-list {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag-item {
            padding: 0.5rem 1.4rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.82rem;
            font-weight: 500;
        }

        .tag-item.active,
        .tag-item:hover {
            background: var(--gold);
            color: var(--white);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.5rem;
            z-index: 3;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0) translateX(-50%);
            }

            40% {
                transform: translateY(-10px) translateX(-50%);
            }

            60% {
                transform: translateY(-5px) translateX(-50%);
            }
        }

        /* =========================
           ART GALLERY WEDDING SECTION
        ========================== */
        .real-wedding-section {
            padding: 120px 0;
            background: var(--bg-alt);
            border-bottom: 1px solid var(--border);
        }

        .section-header-center {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-subtitle {
            font-family: var(--font);
            color: var(--gold-dark);
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 1rem;
            display: block;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 400;
            font-style: italic;
            /* Gaya Gallery Exhibition */
            color: var(--navy);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .section-desc {
            color: var(--text-secondary);
            max-width: 500px;
            margin: 0 auto;
            font-size: 0.95rem;
        }

        .wedding-slider {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            margin-top: 50px;
        }

        .wedding-item {
            flex: 0 1 320px;
            max-width: 320px;
            display: flex;
            flex-direction: column;
            background: var(--white);
            border: 1px solid var(--border);
            padding: 15px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 15px 40px rgba(27, 42, 74, 0.06);
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            position: relative;
        }

        .wedding-item::before {
            content: '';
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border: 1px solid rgba(198, 169, 98, 0.3);
            pointer-events: none;
            transition: all 0.5s ease;
            z-index: 1;
        }

        .wedding-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(27, 42, 74, 0.12);
        }

        .wedding-item:hover::before {
            border-color: var(--gold);
            top: 8px;
            left: 8px;
            right: 8px;
            bottom: 8px;
        }

        .couple-avatar-group {
            position: relative;
            width: 100%;
            height: 250px;
            background: var(--bg);
            margin-bottom: 25px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .couple-avatar {
            position: absolute;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--white);
            border: 5px solid var(--white);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.5s ease;
            z-index: 2;
        }

        .avatar-1 {
            left: 50px;
            top: 50%;
            transform: translateY(-50%);
        }

        .avatar-2 {
            right: 50px;
            top: 50%;
            transform: translateY(-50%);
        }

        .wedding-item:hover .avatar-1 {
            transform: translateY(-50%) translateX(-8px);
        }

        .wedding-item:hover .avatar-2 {
            transform: translateY(-50%) translateX(8px);
        }

        .wedding-info {
            padding: 0 10px 15px;
            position: relative;
            z-index: 2;
        }

        .couple-names {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 400;
            font-style: italic;
            color: var(--navy);
            margin-bottom: 15px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wedding-divider {
            width: 40px;
            height: 1px;
            background: var(--gold);
            margin: 0 auto 15px;
            transition: width 0.5s ease;
        }

        .wedding-item:hover .wedding-divider {
            width: 70px;
        }

        .wedding-date {
            font-family: var(--font);
            font-size: 0.75rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Responsive Mobile - 1 Item Slide Horizontal */
        @media (max-width: 768px) {
            .real-wedding-section {
                padding: 70px 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .wedding-slider {
                flex-wrap: nowrap;
                /* Cegah turun baris */
                overflow-x: auto;
                /* Aktifkan swipe horizontal */
                justify-content: flex-start;
                /* Mulai dari kiri */
                scroll-snap-type: x mandatory;
                /* Snap saat geser */
                gap: 16px;
                padding: 10px 15px 30px;
                /* Ruang agar tak ketabrak layar */
                margin: 0 -15px;
                /* Tarik ke tepi layar */
                -webkit-overflow-scrolling: touch;
                /* Halus di iOS */
                scrollbar-width: none;
                /* Sembunyikan scrollbar Firefox */
            }

            .wedding-slider::-webkit-scrollbar {
                display: none;
                /* Sembunyikan scrollbar Chrome/Safari */
            }

            .wedding-item {
                flex: 0 0 85%;
                /* Lebar 85% layar, sisanya mengintip */
                max-width: 85%;
                scroll-snap-align: center;
                /* Selalu di tengah saat di swipe */
                padding: 12px;
            }

            .couple-avatar-group {
                height: 220px;
            }

            .avatar-1 {
                left: 30px;
            }

            .avatar-2 {
                right: 30px;
            }
        }

        /* ===== Wedding Slider Carousel ===== */
        .wedding-slider-wrapper {
            position: relative;
            max-width: 1100px;
            margin: 0 auto;
        }

        .wedding-slider {
            display: flex;
            flex-wrap: nowrap;
            gap: 40px;
            margin-top: 50px;
            overflow: hidden;
            scroll-behavior: smooth;
        }

        .wedding-item {
            flex: 0 0 calc(33.333% - 27px);
            max-width: calc(33.333% - 27px);
        }

        .wedding-slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--navy);
            font-size: 1.2rem;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .wedding-slider-btn:hover {
            background: var(--navy);
            color: var(--white);
            border-color: var(--navy);
            box-shadow: 0 6px 20px rgba(27, 42, 74, 0.2);
        }

        .wedding-slider-prev {
            left: -20px;
        }

        .wedding-slider-next {
            right: -20px;
        }

        .wedding-slider-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }

        .wedding-slider-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: none;
            background: var(--border);
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }

        .wedding-slider-dot.active {
            background: var(--gold);
            width: 28px;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .wedding-slider {
                gap: 16px;
                margin-top: 30px;
            }

            .wedding-item {
                flex: 0 0 85%;
                max-width: 85%;
            }

            .wedding-slider-btn {
                display: none;
            }
        }

        /* ===== Features Section ===== */
        .features-section {
            padding: 80px 0;
            background: var(--bg);
        }

        .feature-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), var(--gold-dark));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-light);
            box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1);
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            color: var(--gold-dark);
            transition: all 0.5s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(-5deg);
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: var(--white);
        }

        .feature-card h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
        }

        /* ===== Templates Grid ===== */
        .template-section {
            padding: 80px 0 100px;
            background: var(--bg-alt);
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 20px 0;
        }

        .template-card {
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            background: transparent;
        }

        .template-img-container {
            aspect-ratio: 4/3;
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
            background: var(--bg);
            border: 1px solid var(--border);
        }

        .template-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .template-card:hover .template-img-container img {
            transform: scale(1.08);
        }

        .template-overlay {
            position: absolute;
            inset: 0;
            background: rgba(27, 42, 74, 0.7);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s ease;
            gap: 10px;
        }

        .template-card:hover .template-overlay {
            opacity: 1;
        }

        .template-footer {
            padding: 12px 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .user-avatar {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--border);
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--navy);
        }

        .card-stats {
            display: flex;
            gap: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .card-stats i {
            font-size: 0.85rem;
        }

        .badge-pro {
            background: var(--gold);
            color: white;
            font-size: 0.65rem;
            padding: 1px 5px;
            border-radius: 3px;
            font-weight: 800;
        }

        .type-badge-card {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 4px;
            color: #fff;
            pointer-events: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
        }

        /* ===== CTA Section ===== */
        .cta-section {
            padding: 80px 0;
            background: var(--navy);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(198, 169, 98, 0.15) 0%, transparent 70%);
            pointer-events: none;
            animation: pulseSoft 8s infinite ease-in-out;
        }

        .cta-box {
            text-align: center;
            color: var(--white);
            position: relative;
            z-index: 2;
        }

        .cta-box h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .cta-box p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            font-weight: 300;
        }

        /* ===== Footer ===== */
        footer {
            background: var(--bg-alt);
            border-top: 1px solid var(--border);
            padding: 80px 0 30px;
        }

        .footer-logo {
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            height: 40px;
            width: auto;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
            font-size: 0.9rem;
        }

        .footer-links li a {
            color: var(--text-secondary);
            display: inline-block;
            transition: transform 0.2s ease;
        }

        .footer-links li a:hover {
            color: var(--gold-dark);
            transform: translateX(5px);
        }

        .footer-heading {
            font-family: var(--font);
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
            margin-top: 1.5rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            font-size: 1rem;
        }

        .social-btn:hover {
            background: var(--navy);
            color: var(--white);
            transform: translateY(-5px) rotate(5deg);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            margin-top: 60px;
            padding-top: 30px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* Tag Wrapper Animation */
        .tag-wrapper {
            width: 100%;
            overflow: hidden;
            animation: fadeInUp 1s ease-out 1.2s forwards;
            opacity: 0;
        }

        .tag-list {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 10px;
            width: max-content;
            animation: tagScroll 25s linear infinite;
        }

        .tag-item {
            flex: 0 0 auto;
            white-space: nowrap;
            border-radius: 50px;
            padding: 8px 18px;
            text-decoration: none;
            transition: all .3s ease;
        }

        .tag-item:hover {
            transform: translateY(-2px);
        }

        .tag-wrapper:hover .tag-list {
            animation-play-state: paused;
        }

        @keyframes tagScroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @media (max-width: 768px) {
            .tag-list {
                gap: 8px;
                animation-duration: 20s;
            }

            .tag-item {
                padding: 7px 15px;
            }

            .hero-section h1 {
                font-size: 2.5rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .cta-box h2 {
                font-size: 2rem;
            }
        }

        /* =========================================================== */
        /* =========================================================== */

        .tag-wrapper {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .tag-list {
            display: flex;
            width: max-content;
            animation: tagLoop 25s linear infinite;
        }

        /* Jangan ubah style tag-item yang sudah ada */
        .tag-list .tag-item {
            flex-shrink: 0;
            white-space: nowrap;
        }

        /* Grup kedua untuk looping */
        .tag-group {
            display: flex;
            gap: inherit;
            flex-shrink: 0;
        }

        /* Bergerak terus ke kiri */
        @keyframes tagLoop {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .tag-wrapper:hover .tag-list {
            animation-play-state: paused;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="border-color: rgba(255,255,255,0.3);">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.cari-tema') }}">Cari Tema</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.fitur') }}">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.harga') }}">Harga</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pages.bantuan') }}">Bantuan</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard.user') }}" class="nav-link text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-gold">Mulai Gratis</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <video class="hero-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/189858-886618183_medium.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-shape shape-1"></div>
        <div class="hero-shape shape-2"></div>
        <div class="hero-shape shape-3"></div>

        <div class="container hero-content">
            <span class="hero-tag">Platform Undangan Digital Premium</span>
            <h1>Unggah Momen Spesial <br> dengan <em>Keindahan Abadi</em></h1>
            <p>Rancang undangan pernikahan digital yang memikat hati tamu Anda sejak detik pertama. Eksklusif, modern,
                dan mudah dibagikan.</p>

            <form action="{{ route('landing') }}#templates" method="GET">
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="Cari tema impian... (Rustic, Modern, Floral)"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn-search">Cari</button>
                </div>
            </form>

            <div class="tag-wrapper">
                <div class="tag-list">

                    {{-- TAG ASLI --}}
                    <div class="tag-group">
                        <a href="{{ route('landing') }}#templates"
                            class="tag-item {{ !request('category') || request('category') == 'All' ? 'active' : '' }}">
                            Semua Tema
                        </a>

                        @foreach($categories as $cat)
                            <a href="{{ route('landing', ['category' => $cat['name']]) }}#templates"
                                class="tag-item {{ request('category') == $cat['name'] ? 'active' : '' }}">
                                {{ $cat['name'] }}
                            </a>
                        @endforeach
                    </div>

                    {{-- DUPLIKAT UNTUK LOOP --}}
                    <div class="tag-group" aria-hidden="true">
                        <a href="{{ route('landing') }}#templates"
                            class="tag-item {{ !request('category') || request('category') == 'All' ? 'active' : '' }}">
                            Semua Tema
                        </a>

                        @foreach($categories as $cat)
                            <a href="{{ route('landing', ['category' => $cat['name']]) }}#templates"
                                class="tag-item {{ request('category') == $cat['name'] ? 'active' : '' }}">
                                {{ $cat['name'] }}
                            </a>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>

        <a href="#real-weddings" class="scroll-down">
            <i class="bi bi-chevron-double-down"></i>
        </a>
    </section>

    <!-- Real Wedding Social Proof (Art Gallery Style) -->
    <section class="real-wedding-section" id="real-weddings">
        <div class="container">
            <div class="section-header-center reveal">
                <span class="section-subtitle">Portofolio Nyata</span>
                <h2 class="section-title">Karya Cinta Yang Abadi</h2>
                <p class="section-desc">Setiap pasangan memiliki cerita unik. Biarkan momen sakral Anda menjadi karya
                    seni yang tak terlupakan.</p>
            </div>

            <div class="wedding-slider-wrapper reveal">
                <button class="wedding-slider-btn wedding-slider-prev" aria-label="Sebelumnya">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="wedding-slider reveal">
                    @foreach($invitations as $invitation)
                        <a href="{{ route('template.frame', ['slug' => $invitation->slug, 'id' => $invitation->template_id]) }}"
                            class="wedding-item">
                            <div class="couple-avatar-group">
                                <img src="{{ $invitation->foto_pria ? storage_url_with_fallback($invitation->foto_pria, 'https://ui-avatars.com/api/?name=' . urlencode($invitation->groom_name) . '&background=E8D5A3&color=fff', $invitation->updated_at->timestamp) : 'https://ui-avatars.com/api/?name=' . urlencode($invitation->groom_name) . '&background=E8D5A3&color=fff' }}"
                                    class="couple-avatar avatar-1" alt="Foto Mempelai Pria">
                                <img src="{{ $invitation->foto_wanita ? storage_url_with_fallback($invitation->foto_wanita, 'https://ui-avatars.com/api/?name=' . urlencode($invitation->bride_name) . '&background=1B2A4A&color=fff', $invitation->updated_at->timestamp) : 'https://ui-avatars.com/api/?name=' . urlencode($invitation->bride_name) . '&background=1B2A4A&color=fff' }}"
                                    class="couple-avatar avatar-2" alt="Foto Mempelai Wanita">
                            </div>

                            <div class="wedding-info">
                                <div class="couple-names">{{ $invitation->groom_nickname ?? $invitation->groom_name }} &amp;
                                    {{ $invitation->bride_nickname ?? $invitation->bride_name }}
                                </div>
                                <div class="wedding-divider"></div>
                                <div class="wedding-date">
                                    {{ \Carbon\Carbon::parse($invitation->wedding_date)->format('d M Y') }}
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if($invitations->count() < 3)
                        @for($i = 0; $i < 3 - $invitations->count(); $i++)
                            <div class="wedding-item opacity-50">
                                <div class="couple-avatar-group">
                                    <img src="https://i.pravatar.cc/150?u={{ $i }}" class="couple-avatar avatar-1" alt="">
                                    <img src="https://i.pravatar.cc/150?u={{ $i + 10 }}" class="couple-avatar avatar-2" alt="">
                                </div>
                                <div class="wedding-info">
                                    <div class="couple-names">Pasangan Baru</div>
                                    <div class="wedding-divider"></div>
                                    <div class="wedding-date">Segera Datang</div>
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>

                <button class="wedding-slider-btn wedding-slider-next" aria-label="Berikutnya">
                    <i class="bi bi-chevron-right"></i>
                </button>

                <div class="wedding-slider-dots"></div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="section-header-center reveal">
                <span class="section-subtitle">Keunggulan Kami</span>
                <h2 class="section-title">Mengapa Memilih RuangUndang?</h2>
                <p class="section-desc">Memberikan pengalaman terbaik untuk momen sekali seumur hidup Anda.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <h4>Desain Mobile First</h4>
                        <p>Tampilan indah dan responsif di semua layar smartphone, tablet, maupun desktop. Tamu Anda
                            akan kagum saat membukanya.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-music-note-beamed"></i></div>
                        <h4>Background Musik</h4>
                        <p>Tambahkan lagu favorit Anda sebagai musik latar untuk menciptakan suasana romantis saat
                            undangan dibuka.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-map"></i></div>
                        <h4>Google Maps Integrasi</h4>
                        <p>Tamu tidak akan tersesat. Integrasi peta langsung memandu mereka ke lokasi acara dengan satu
                            klik.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-gift"></i></div>
                        <h4>Kirim Amplop Digital</h4>
                        <p>Fasilitasi tamu untuk mengirimkan tanda kasih secara digital melalui transfer bank atau
                            e-wallet dengan aman.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-people"></i></div>
                        <h4>RSVP & Hitung Tamu</h4>
                        <p>Ketahui pasti berapa tamu yang akan hadir. Sistem RSVP otomatis memudahkan Anda mempersiapkan
                            acara.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-camera-reels"></i></div>
                        <h4>Galeri Foto & Video</h4>
                        <p>Bagikan momen pra-pernikan Anda melalui galeri foto interaktif dan video sinematik yang
                            memukau.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Templates Grid -->
    <section id="templates" class="template-section">
        <div class="container">
            <div class="section-header-center reveal">
                <span class="section-subtitle">Galeri Inspirasi</span>
                <h2 class="section-title">Koleksi Tema Eksklusif</h2>
                <p class="section-desc">Pilih dari puluhan desain premium yang dirancang oleh desainer profesional kami.
                </p>
            </div>

            <div class="template-grid">
                @foreach($templates as $template)
                    <div class="template-card reveal">
                        <div class="template-img-container">
                            <img src="{{ template_thumbnail_url($template, $template->updated_at->timestamp) }}"
                                alt="{{ $template->name }}" loading="lazy">
                            @if($template->templateType)
                                <div class="type-badge-card" style="background-color: {{ $template->templateType->color }};">
                                    {{ $template->templateType->name }}
                                </div>
                            @endif
                            <div class="template-overlay">
                                <a href="{{ route('template.frame', ['slug' => 'romeo-juliet', 'id' => $template->id]) }}"
                                    target="_blank" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">Pratinjau</a>
                                <a href="{{ route('dashboard.user') }}?template_id={{ $template->id }}"
                                    class="btn btn-gold rounded-pill px-4 fw-bold shadow-sm">Gunakan</a>
                            </div>
                        </div>
                        <div class="template-footer">
                            <div class="user-info">
                                <img src="https://ui-avatars.com/api/?name={{urlencode($template->name)}}&background=random"
                                    class="user-avatar" alt="">
                                <span class="user-name">{{ $template->name }}</span>

                            </div>
                            <div class="card-stats">
                                <span title="Dilihat"><i class="bi bi-eye"></i>
                                    {{ number_format($template->views_count) }}</span>
                                <span title="Suka" class="like-btn" data-id="{{ $template->id }}" style="cursor: pointer;">
                                    <i class="bi bi-heart-fill text-danger"></i>
                                    <span class="likes-count">{{ number_format($template->likes_count) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($templates->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted display-1 opacity-25"></i>
                    <h3 class="text-muted mt-3">Tema tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci lain atau lihat semua tema.</p>
                    <a href="{{ route('landing') }}" class="btn btn-outline-dark mt-2 rounded-pill px-4">Lihat Semua
                        Tema</a>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Siap Memulai Perjalanan Anda?</h2>
                <p>Buat undangan digital impian Anda hari ini. Gratis untuk memulai, tanpa kartu kredit.</p>
                <a href="{{ route('register') }}" class="btn-gold" style="font-size: 1rem; padding: 1rem 2.5rem;">
                    Buat Undangan Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4 reveal">
                    <a href="#" class="footer-logo">
                        <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
                    </a>
                    <p class="text-secondary small" style="max-width: 350px;">Saat ini kami menyediakan undangan digital
                        untuk pernikahan. Untuk khitanan, aqiqah, dan momen spesial lainnya akan segera hadir. Praktis,
                        elegan, dan hemat biaya.</p>
                    <div class="footer-social">
                        <a href="#" class="social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-tiktok"></i></a>
                        <a href="#" class="social-btn"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1 reveal" style="transition-delay: 0.1s;">
                    <h5 class="footer-heading">Layanan</h5>
                    <ul class="footer-links">
                        <li><a href="#">Undangan Pernikahan</a></li>
                        <li><a href="#">Undangan Digital</a></li>
                        <li><a href="#">Cetak Undangan</a></li>
                        <li><a href="#">Video Undangan</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 reveal" style="transition-delay: 0.2s;">
                    <h5 class="footer-heading">Tema Populer</h5>
                    <ul class="footer-links">
                        <li><a href="#">Tema Modern</a></li>
                        <li><a href="#">Tema Rustic</a></li>
                        <li><a href="#">Tema Floral</a></li>
                        <li><a href="#">Tema Islami</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2 reveal" style="transition-delay: 0.3s;">
                    <h5 class="footer-heading">Informasi</h5>

                    <ul class="footer-links">
                        <li><a href="{{ route('pages.cara-pemesanan') }}">Cara Pemesanan</a></li>
                        <li><a href="{{ route('pages.faq') }}">Pertanyaan (FAQ)</a></li>
                        <li><a href="{{ route('pages.syarat-ketentuan') }}">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('pages.kebijakan-privasi') }}">Kebijakan Privasi</a></li>
                        <li><a href="https://www.freewebsubmission.com">
                                <img src="https://www.freewebsubmission.com/images/fwsbutton10.gif" width="88"
                                    height="31" border="0"
                                    alt="Submit Your Site To The Web's Top 50 Search Engines for Free!"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 RuangUndang Digital Invitation. Dibuat dengan <i
                        class="bi bi-heart-fill text-danger"></i>
                    di Indonesia.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar Scroll Effect
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Scroll Reveal Animation (Intersection Observer)
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        reveals.forEach(reveal => {
            observer.observe(reveal);
        });

        // Like Button Logic
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const countSpan = this.querySelector('.likes-count');
                const heartIcon = this.querySelector('i');

                if (this.classList.contains('processing')) return;
                this.classList.add('processing');

                fetch(`/templates/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            countSpan.textContent = data.likes_count.toLocaleString();
                            heartIcon.classList.remove('bi-heart-fill');
                            heartIcon.classList.add('bi-heart');
                            setTimeout(() => {
                                heartIcon.classList.remove('bi-heart');
                                heartIcon.classList.add('bi-heart-fill');
                            }, 200);
                        }
                        this.classList.remove('processing');
                    })
                    .catch(err => {
                        console.error(err);
                        this.classList.remove('processing');
                    });
            });
        });

        // Wedding Slider Carousel
        const weddingSlider = document.querySelector('.wedding-slider');
        const weddingWrapper = document.querySelector('.wedding-slider-wrapper');
        if (weddingSlider && weddingWrapper) {
            const prevBtn = weddingWrapper.querySelector('.wedding-slider-prev');
            const nextBtn = weddingWrapper.querySelector('.wedding-slider-next');
            const dotsContainer = weddingWrapper.querySelector('.wedding-slider-dots');
            const items = weddingSlider.querySelectorAll('.wedding-item');

            let currentIndex = 0;
            let itemsPerView = 3;
            let autoScrollInterval;
            let isDragging = false;
            let startX, scrollLeftPos;

            const getItemsPerView = () => {
                return window.innerWidth <= 768 ? 1 : 3;
            };

            const getTotalSlides = () => {
                const total = items.length;
                const perView = getItemsPerView();
                return Math.max(1, total - perView + 1);
            };

            const getItemWidth = () => {
                const item = items[0];
                if (!item) return 320;
                const style = window.getComputedStyle(weddingSlider);
                const gap = parseFloat(style.gap) || 40;
                return item.offsetWidth + gap;
            };

            const updateDots = () => {
                if (!dotsContainer) return;
                dotsContainer.innerHTML = '';
                const totalSlides = getTotalSlides();
                for (let i = 0; i < totalSlides; i++) {
                    const dot = document.createElement('button');
                    dot.className = 'wedding-slider-dot' + (i === currentIndex ? ' active' : '');
                    dot.setAttribute('aria-label', 'Slide ' + (i + 1));
                    dot.addEventListener('click', () => goToSlide(i));
                    dotsContainer.appendChild(dot);
                }
            };

            const goToSlide = (index) => {
                const totalSlides = getTotalSlides();
                currentIndex = Math.max(0, Math.min(index, totalSlides - 1));
                const scrollAmount = currentIndex * getItemWidth();
                weddingSlider.scrollTo({ left: scrollAmount, behavior: 'smooth' });
                updateDots();
                resetAutoScroll();
            };

            const nextSlide = () => {
                const totalSlides = getTotalSlides();
                if (currentIndex >= totalSlides - 1) {
                    goToSlide(0);
                } else {
                    goToSlide(currentIndex + 1);
                }
            };

            const prevSlide = () => {
                const totalSlides = getTotalSlides();
                if (currentIndex <= 0) {
                    goToSlide(totalSlides - 1);
                } else {
                    goToSlide(currentIndex - 1);
                }
            };

            const startAutoScroll = () => {
                stopAutoScroll();
                autoScrollInterval = setInterval(nextSlide, 3000);
            };

            const stopAutoScroll = () => {
                clearInterval(autoScrollInterval);
            };

            const resetAutoScroll = () => {
                stopAutoScroll();
                startAutoScroll();
            };

            if (prevBtn) prevBtn.addEventListener('click', prevSlide);
            if (nextBtn) nextBtn.addEventListener('click', nextSlide);

            weddingSlider.addEventListener('mouseenter', stopAutoScroll);
            weddingSlider.addEventListener('mouseleave', startAutoScroll);
            weddingSlider.addEventListener('touchstart', stopAutoScroll, { passive: true });
            weddingSlider.addEventListener('touchend', () => setTimeout(startAutoScroll, 3000));

            weddingSlider.addEventListener('scroll', () => {
                const itemWidth = getItemWidth();
                const newIndex = Math.round(weddingSlider.scrollLeft / itemWidth);
                if (newIndex !== currentIndex) {
                    currentIndex = newIndex;
                    updateDots();
                }
            });

            weddingSlider.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.pageX - weddingSlider.offsetLeft;
                scrollLeftPos = weddingSlider.scrollLeft;
                stopAutoScroll();
            });

            weddingSlider.addEventListener('mouseleave', () => {
                if (isDragging) {
                    isDragging = false;
                    setTimeout(startAutoScroll, 2000);
                }
            });

            weddingSlider.addEventListener('mouseup', () => {
                if (isDragging) {
                    isDragging = false;
                    setTimeout(startAutoScroll, 2000);
                }
            });

            weddingSlider.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const x = e.pageX - weddingSlider.offsetLeft;
                const walk = (x - startX) * 1.5;
                weddingSlider.scrollLeft = scrollLeftPos - walk;
            });

            updateDots();
            startAutoScroll();
        }
    </script>

    <!-- ============================================================= -->
    @include('components.ai-chat')


    @if($promotions->isNotEmpty())
        <div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">

            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg promo-modal-content">

                    <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">

                        {{-- Banner --}}
                        <div class="carousel-inner">

                            @foreach($promotions as $index => $promotion)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                                    <div class="position-relative">

                                        <img src="{{ asset('storage/' . $promotion->image) }}"
                                            alt="{{ $promotion->title ?? 'Promosi' }}" class="w-100 promo-image">

                                        {{-- Tombol Close --}}
                                        <button type="button" class="promo-close" data-bs-dismiss="modal" aria-label="Tutup">
                                            <span>×</span>
                                        </button>

                                    </div>

                                </div>
                            @endforeach

                        </div>

                        {{-- Tombol Previous --}}
                        @if($promotions->count() > 1)
                            <button class="carousel-control-prev promo-control" type="button" data-bs-target="#promoCarousel"
                                data-bs-slide="prev">

                                <span class="promo-arrow">
                                    ‹
                                </span>

                                <span class="visually-hidden">
                                    Sebelumnya
                                </span>
                            </button>

                            {{-- Tombol Next --}}
                            <button class="carousel-control-next promo-control" type="button" data-bs-target="#promoCarousel"
                                data-bs-slide="next">

                                <span class="promo-arrow">
                                    ›
                                </span>

                                <span class="visually-hidden">
                                    Berikutnya
                                </span>
                            </button>
                        @endif

                        {{-- Indicator --}}
                        @if($promotions->count() > 1)
                            <div class="carousel-indicators promo-indicators">

                                @foreach($promotions as $index => $promotion)
                                    <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="{{ $index }}"
                                        class="{{ $index === 0 ? 'active' : '' }}"
                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Banner {{ $index + 1 }}">
                                    </button>
                                @endforeach

                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    @endif


    <style>
        /* ================================
       MODAL
    ================================= */

        .promo-modal-content {
            border-radius: 16px;
            overflow: hidden;
            background: transparent;
        }

        .promo-image {
            display: block;
            width: 100%;
            max-height: 500px;
            object-fit: cover;
        }


        /* ================================
       CLOSE BUTTON
    ================================= */

        .promo-close {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 20;

            width: 40px;
            height: 40px;

            border: 0;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(0, 0, 0, 0.55);
            color: #fff;

            font-size: 30px;
            line-height: 1;

            cursor: pointer;

            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.4);

            transition: all 0.2s ease;
        }

        .promo-close:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.08);
        }

        .promo-close span {
            margin-top: -4px;
        }


        /* ================================
       ARROW
    ================================= */

        .promo-control {
            width: 55px;
            opacity: 1;
            z-index: 10;
        }

        .promo-arrow {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: rgba(0, 0, 0, 0.55);
            color: #fff;

            font-size: 32px;
            line-height: 1;

            transition: all 0.2s ease;
        }

        .promo-control:hover .promo-arrow {
            background: rgba(0, 0, 0, 0.8);
            transform: scale(1.08);
        }


        /* ================================
       INDICATORS
    ================================= */

        .promo-indicators {
            margin-bottom: 12px;
            z-index: 15;
        }

        .promo-indicators button {
            width: 8px;
            height: 8px;

            border: 0;
            border-radius: 50%;

            margin: 0 4px;

            background-color: rgba(255, 255, 255, 0.65);

            opacity: 1;

            transition: all 0.2s ease;
        }

        .promo-indicators button.active {
            width: 24px;
            border-radius: 10px;
            background-color: #fff;
        }


        /* ================================
       BACKDROP BLUR
    ================================= */

        .modal-backdrop.show {
            opacity: 1 !important;
            background: rgba(0, 0, 0, 0.35) !important;

            backdrop-filter: blur(15px) saturate(120%) !important;
            -webkit-backdrop-filter: blur(15px) saturate(120%) !important;
        }

        .modal {
            z-index: 1060 !important;
        }

        .modal-backdrop {
            z-index: 1050 !important;
        }


        /* ================================
       MODAL ANIMATION
    ================================= */

        #promoModal .modal-dialog {
            animation: promoModalIn 0.35s ease-out;
        }

        @keyframes promoModalIn {
            from {
                opacity: 0;
                transform: scale(0.92) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }


        /* ================================
       MOBILE
    ================================= */

        @media (max-width: 576px) {

            #promoModal .modal-dialog {
                margin: 15px;
            }

            .promo-image {
                max-height: 75vh;
                object-fit: contain;
                background: #111;
            }

            .promo-close {
                top: 10px;
                right: 10px;

                width: 36px;
                height: 36px;

                font-size: 27px;
            }

            .promo-arrow {
                width: 34px;
                height: 34px;

                font-size: 28px;
            }

            .promo-control {
                width: 45px;
            }
        }
    </style>

    <script>
        @if($promotions->isNotEmpty())
            document.addEventListener('DOMContentLoaded', function () {
                setTimeout(function () {
                    const promoModal = new bootstrap.Modal(document.getElementById('promoModal'));
                    promoModal.show();
                }, 1500);
            });
        @endif
    </script>
</body>

</html>
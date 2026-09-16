<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $noIndex = !empty(request('search')) || (!empty(request('category')) && request('category') != 'All');
    @endphp
    @include('layouts.partial.seo_head')

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

        .user-avatar-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all var(--speed) ease;
        }

        .navbar.scrolled .user-avatar-circle {
            border-color: var(--gold-light);
        }

        .user-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-avatar-initial {
            color: var(--white);
            font-weight: 700;
            font-size: 0.9rem;
            line-height: 1;
        }

        .nav-link .user-avatar-circle:hover {
            transform: scale(1.1);
            border-color: var(--gold);
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
            margin-bottom: 1rem;
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
            margin-bottom: 0;
            font-weight: 300;
            line-height: 1.7;
            animation: fadeInUp 1s ease-out 0.6s forwards;
            opacity: 0;
        }

        .search-container {
            max-width: 600px;
            margin: 2.5rem auto 0;
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

        .hero-text-slider {
            position: relative;
            min-height: 220px;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .hero-slide.active {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .hero-slider-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 1.25rem;
        }

        .hero-slider-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
        }

        .hero-slider-dot.active {
            background: var(--gold);
            width: 28px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(198, 169, 98, 0.5);
        }

        @media (max-width: 768px) {
            .hero-text-slider {
                min-height: 280px;
            }

            .hero-slider-dot {
                width: 8px;
                height: 8px;
            }

            .hero-slider-dot.active {
                width: 22px;
            }
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
            position: relative;
            padding: 120px 0;
            background: #1B2A4A;
            border-bottom: 1px solid var(--border);
            overflow: hidden;
        }

        .real-wedding-bg {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(rgba(27, 42, 74, 0.85), rgba(27, 42, 74, 0.95)),
                url('{{ asset('assets/img/innokurnia-wedding-4297343_1920.jpg') }}') center/cover no-repeat;
            opacity: 0.35;
            z-index: 0;
            pointer-events: none;
        }

        .real-wedding-section .container {
            position: relative;
            z-index: 1;
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

        .real-wedding-section .section-title {
            color: var(--white);
        }

        .real-wedding-section .section-desc {
            color: rgba(255, 255, 255, 0.8);
        }

        .wedding-showcase {
            display: flex;
            gap: 30px;
            align-items: stretch;
        }

        .wedding-list-col {
            flex: 0 0 340px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: var(--radius-lg);
            padding: 24px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            max-height: 540px;
            overflow-y: auto;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .wedding-preview-col {
            flex: 1;
            min-width: 0;
        }

        .couple-list-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-decoration: none;
            color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            border-radius: 12px;
            cursor: pointer;
        }

        .couple-list-item:last-child {
            border-bottom: none;
        }

        .couple-list-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .couple-list-item.active {
            background: rgba(198, 169, 98, 0.25);
            border: 1px solid var(--gold-light);
            padding: 11px;
        }

        .couple-list-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.35);
            flex-shrink: 0;
            background: rgba(255, 255, 255, 0.1);
        }

        .couple-list-info {
            min-width: 0;
        }

        .couple-list-names {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--white);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .couple-list-date {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.65);
            margin-top: 2px;
        }

        .couple-preview-panel {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-lg);
            padding: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
            height: 100%;
            min-height: 540px;
            display: flex;
            flex-direction: column;
        }

        .couple-preview-header {
            position: relative;
        }

        .couple-preview-close {
            border: 0;
            background: transparent;
            color: var(--text-secondary);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            transition: color 0.2s ease;
        }

        .couple-preview-close:hover {
            color: var(--navy);
        }

        .couple-preview-frame-wrapper {
            position: relative;
            flex: 1;
            border-radius: 12px;
            overflow: hidden;
            background: var(--bg);
            border: 1px solid var(--border);
            min-height: 400px;
        }

        .couple-preview-frame-wrapper iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .couple-preview-empty {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-align: center;
            padding: 24px;
            gap: 12px;
        }

        .couple-preview-empty i {
            font-size: 3rem;
            opacity: 0.4;
        }

        .couple-preview-empty p {
            margin: 0;
            font-size: 0.95rem;
            max-width: 260px;
        }

        @media (max-width: 992px) {
            .wedding-showcase {
                flex-direction: column;
            }

            .wedding-list-col {
                flex: 0 0 auto;
                width: 100%;
                max-height: none;
            }

            .couple-preview-panel {
                min-height: 400px;
            }
        }

        @media (max-width: 768px) {
            .real-wedding-section {
                padding: 80px 0;
            }

            .couple-preview-frame-wrapper {
                min-height: 300px;
            }

            .couple-preview-panel {
                min-height: 360px;
                padding: 12px;
            }

            .section-title {
                font-size: 1.8rem;
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

        /* ===== Features Auto Scroll ===== */
        .features-scroll-wrapper {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .features-scroll-wrapper::before,
        .features-scroll-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 80px;
            z-index: 2;
            pointer-events: none;
        }

        .features-scroll-wrapper::before {
            left: 0;
            background: linear-gradient(to right, var(--bg), transparent);
        }

        .features-scroll-wrapper::after {
            right: 0;
            background: linear-gradient(to left, var(--bg), transparent);
        }

        .features-scroll-track {
            display: flex;
            gap: 24px;
            width: max-content;
            animation: featuresScroll 40s linear infinite;
        }

        .features-scroll-track:hover {
            animation-play-state: paused;
        }

        .features-scroll-track .feature-card {
            min-width: 280px;
            max-width: 320px;
            flex: 0 0 auto;
        }

        @keyframes featuresScroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
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

        /* ===== Midtrans Security Badge ===== */
        .midtrans-security {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            border-radius: 50px;
            background: #f0f7ff;
            border: 1px solid #cce5ff;
            color: #004085;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .midtrans-security:hover {
            background: #e0f0ff;
            border-color: #0068FF;
            color: #0068FF;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 104, 255, 0.15);
        }

        .midtrans-security .midtrans-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #0068FF;
            color: #fff;
            font-size: 14px;
            flex-shrink: 0;
        }

        .midtrans-security .midtrans-logo-text {
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #0068FF;
        }

        .midtrans-security .midtrans-label {
            font-weight: 500;
            color: #004085;
        }

        @media (max-width: 768px) {
            .midtrans-security {
                font-size: 0.75rem;
                padding: 8px 14px;
                gap: 6px;
            }

            .midtrans-security .midtrans-icon {
                width: 24px;
                height: 24px;
                font-size: 12px;
            }
        }

        /* ===== How It Works Section ===== */
        .how-it-works-section {
            padding: 100px 0;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
        }

        .step-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem 1.5rem;
            height: 100%;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            position: relative;
            overflow: hidden;
        }

        .step-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-light);
            box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1);
        }

        .step-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            transition: all 0.5s ease;
        }

        .step-icon img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            transition: transform 0.5s ease;
        }

        .step-card:hover .step-icon {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            transform: scale(1.1);
        }

        .step-card:hover .step-icon img {
            transform: scale(1.1);
        }

        .step-number {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gold);
            color: var(--white);
            font-weight: 700;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.9;
            transition: all 0.5s ease;
        }

        .step-card:hover .step-number {
            background: var(--navy);
            transform: scale(1.1);
        }

        .step-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 0.75rem;
        }

        .step-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
            margin: 0;
        }

        @media (max-width: 768px) {
            .how-it-works-section {
                padding: 60px 0;
            }

            .step-card {
                padding: 2rem 1.25rem;
            }

            .step-icon {
                width: 64px;
                height: 64px;
            }

            .step-icon img {
                width: 36px;
                height: 36px;
            }

            .step-number {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
                top: 10px;
                right: 10px;
            }

            .step-title {
                font-size: 1.1rem;
            }

            .step-desc {
                font-size: 0.85rem;
            }
        }

        /* Tag Wrapper Animation */
        .tag-wrapper {

            margin-top: 50px;

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

        /* ===== WhatsApp Float: provided by components.wa-chat (floating round button) ===== */
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
                        <a href="{{ route('dashboard.user') }}" class="nav-link d-flex align-items-center gap-2">
                            <div class="user-avatar-circle">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}"
                                        class="user-avatar-img">
                                @else
                                    <span class="user-avatar-initial">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" rel="nofollow" class="nav-link">Masuk</a>
                        <a href="{{ route('register') }}" rel="nofollow" class="btn-gold">Mulai Gratis</a>
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
            <div class="hero-text-slider">
                <div class="hero-slide active">
                    <h1>Unggah Momen Spesial <br> dengan <em>Keindahan Abadi</em></h1>
                    <p>Rancang undangan pernikahan digital yang memikat hati tamu Anda sejak detik pertama. Eksklusif,
                        modern,
                        dan mudah dibagikan.</p>
                </div>
                <div class="hero-slide">
                    <h1>Wujudkan Cinta Anda <br> dalam <em>Tema Eksklusif</em></h1>
                    <p>Pilih dari koleksi template premium yang dirancang untuk menceritakan kisah cinta Anda dengan
                        sentuhan personal.</p>
                </div>
                <div class="hero-slide">
                    <h1>Bagikan Kabar Bahagia <br> dengan <em>Sentuhan Modern</em></h1>
                    <p>Kirim undangan digital ke seluruh tamu dalam hitungan detik. Hemat waktu, tetap elegan, dan
                        berkesan
                        forever.</p>
                </div>
            </div>

            <form action="{{ route('landing') }}#templates" method="GET">
                <div class="search-container">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="Cari tema impian... (Rustic, Modern, Floral)"
                        value="{{ request('search') }}">
                    <button type="submit" class="btn-search">Cari</button>
                </div>
            </form>

            <div class="hero-slider-dots"></div>

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
                @php $featuredTemplates = $templates->take(8); @endphp
                @foreach($featuredTemplates as $template)
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
                                    target="_blank" rel="nofollow"
                                    class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">Pratinjau</a>
                                <a href="{{ route('dashboard.user') }}?template_id={{ $template->id }}" rel="nofollow"
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

            @if($featuredTemplates->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-search text-muted display-1 opacity-25"></i>
                    <h3 class="text-muted mt-3">Tema tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci lain atau lihat semua tema.</p>
                    <a href="{{ route('pages.cari-tema') }}" class="btn btn-outline-dark mt-2 rounded-pill px-4">Lihat Semua
                        Tema</a>
                </div>
            @else
                <div class="text-center mt-4">
                    <a href="{{ route('pages.cari-tema') }}" class="btn btn-outline-dark rounded-pill px-4">Lihat Semua
                        Tema</a>
                </div>
            @endif
        </div>
    </section>
    <!-- How It Works Section -->
    <section class="how-it-works-section" id="how-it-works">
        <div class="container">
            <div class="section-header-center reveal">
                <span class="section-subtitle">Mudah & Cepat</span>
                <h2 class="section-title">Cara Membuat Undangan Digital</h2>
                <p class="section-desc">Hanya 4 langkah sederhana untuk memiliki undangan pernikahan digital yang
                    memukau.</p>
            </div>

            <div class="row g-4 mt-4">
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.1s;">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <img src="{{ asset('assets/img/step/Registrasi.png') }}" alt="Registrasi">
                        </div>
                        <div class="step-number">1</div>
                        <h4 class="step-title">Registrasi Akun</h4>
                        <p class="step-desc">Daftar dan buat akun undangan kamu di sini untuk memulai.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.2s;">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <img src="{{ asset('assets/img/step/isidata.png') }}" alt="Isi Data">
                        </div>
                        <div class="step-number">2</div>
                        <h4 class="step-title">Isi Data & Upload Foto</h4>
                        <p class="step-desc">Isi info acara & profile serta upload foto/gallery. Customize undangan
                            kamu.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.3s;">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <img src="{{ asset('assets/img/step/design.png') }}" alt="Pilih Design">
                        </div>
                        <div class="step-number">3</div>
                        <h4 class="step-title">Pilih Template</h4>
                        <p class="step-desc">Pilih preset/template. Lihat daftar template eksklusif kami.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 reveal" style="transition-delay: 0.4s;">
                    <div class="step-card text-center">
                        <div class="step-icon">
                            <img src="{{ asset('assets/img/step/share.png') }}" alt="Sebarkan">
                        </div>
                        <div class="step-number">4</div>
                        <h4 class="step-title">Sebarkan Undangan</h4>
                        <p class="step-desc">Aktifkan, dan undangan kamu siap untuk disebarkan ke tamu.</p>
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

            <div class="features-scroll-wrapper">
                <div class="features-scroll-track">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-clock-history"></i></div>
                        <h4>Hitungan Mundur</h4>
                        <p>Jangan sampai terlewatkan moment indah kamu, hitung mundur tanggal acara pernikahanmu.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <h4>Design Modern dan Responsif</h4>
                        <p>Say good bye untuk design jadul. Biar undanganmu makin wow.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-music-note-beamed"></i></div>
                        <h4>Background Music</h4>
                        <p>Pilih musik sesuai keinginan kamu agar undanganmu lebih eksklusif dan romantis.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-chat-heart"></i></div>
                        <h4>Berbagi Momen Indah dan Ucapan</h4>
                        <p>Tamu undangan bisa berbagi momen dengan mengirimkan gambar dan ucapan.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-gift"></i></div>
                        <h4>Amplop Digital</h4>
                        <p>Tamu undangan bisa mengirim amplop secara digital dengan mudah.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-heart"></i></div>
                        <h4>Love Stories</h4>
                        <p>Ceritakan Kisah Cinta kamu dengan leluasa.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-camera-video"></i></div>
                        <h4>Live Streaming</h4>
                        <p>Temui acara secara virtual agar jarang tidak membuat keterbatasan.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-map"></i></div>
                        <h4>Google Maps Integrasi</h4>
                        <p>Tamu tidak akan tersesat. Integrasi peta langsung memandu mereka ke lokasi acara dengan satu
                            klik.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-people"></i></div>
                        <h4>RSVP & Hitung Tamu</h4>
                        <p>Ketahui pasti berapa tamu yang akan hadir. Sistem RSVP otomatis memudahkan Anda mempersiapkan
                            acara.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon"><i class="bi bi-camera-reels"></i></div>
                        <h4>Galeri Foto & Video</h4>
                        <p>Bagikan momen pra-pernikan Anda melalui galeri foto interaktif dan video sinematik yang
                            memukau.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-clock-history"></i></div>
                        <h4>Hitungan Mundur</h4>
                        <p>Jangan sampai terlewatkan moment indah kamu, hitung mundur tanggal acara pernikahanmu.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-phone"></i></div>
                        <h4>Design Modern dan Responsif</h4>
                        <p>Say good bye untuk design jadul. Biar undanganmu makin wow.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-music-note-beamed"></i></div>
                        <h4>Background Music</h4>
                        <p>Pilih musik sesuai keinginan kamu agar undanganmu lebih eksklusif dan romantis.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-chat-heart"></i></div>
                        <h4>Berbagi Momen Indah dan Ucapan</h4>
                        <p>Tamu undangan bisa berbagi momen dengan mengirimkan gambar dan ucapan.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-gift"></i></div>
                        <h4>Amplop Digital</h4>
                        <p>Tamu undangan bisa mengirim amplop secara digital dengan mudah.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-heart"></i></div>
                        <h4>Love Stories</h4>
                        <p>Ceritakan Kisah Cinta kamu dengan leluasa.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-camera-video"></i></div>
                        <h4>Live Streaming</h4>
                        <p>Temui acara secara virtual agar jarang tidak membuat keterbatasan.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-map"></i></div>
                        <h4>Google Maps Integrasi</h4>
                        <p>Tamu tidak akan tersesat. Integrasi peta langsung memandu mereka ke lokasi acara dengan satu
                            klik.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-people"></i></div>
                        <h4>RSVP & Hitung Tamu</h4>
                        <p>Ketahui pasti berapa tamu yang akan hadir. Sistem RSVP otomatis memudahkan Anda mempersiapkan
                            acara.</p>
                    </div>
                    <div class="feature-card" aria-hidden="true">
                        <div class="feature-icon"><i class="bi bi-camera-reels"></i></div>
                        <h4>Galeri Foto & Video</h4>
                        <p>Bagikan momen pra-pernikan Anda melalui galeri foto interaktif dan video sinematik yang
                            memukau.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <h2>Siap Memulai Perjalanan Anda?</h2>
                <p>Buat undangan digital impian Anda hari ini. Gratis untuk memulai, tanpa kartu kredit.</p>
                <a href="{{ route('register') }}" rel="nofollow" class="btn-gold"
                    style="font-size: 1rem; padding: 1rem 2.5rem;">
                    Buat Undangan Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <!-- Styling Tambahan agar Tampil Rapi -->
            <style>
                .footer-payment-icons img {
                    object-fit: contain;
                    transition: opacity 0.2s ease-in-out;
                    opacity: 0.85;
                    align-self: start;
                }

                .footer-payment-icons img:hover {
                    opacity: 1;
                }
            </style>
            <div class="row gy-5">
                <div class="col-lg-4 reveal">
                    <a href="#" class="footer-logo">
                        <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
                    </a>
                    <div
                        class="footer-payment-icons d-flex align-items-center justify-content-center flex-wrap gap-3 py-3">

                        <!-- GoPay -->
                        <img src="https://thumb.wikimedia.org/wikipedia/commons/thumb/6/65/Gopay_logo_%282019%29.svg/3840px-Gopay_logo_%282019%29.svg.png?utm_source=id.wikipedia.org&utm_campaign=index&utm_content=thumbnail"
                            alt="GoPay" height="24" title="GoPay">

                        <!-- QRIS -->
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/QRIS_logo.svg" alt="QRIS"
                            height="26" title="QRIS">

                        <!-- Bank Mandiri -->
                        <img src="https://thumb.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/1280px-Bank_Mandiri_logo_2016.svg.png?utm_source=id.wikipedia.org&utm_campaign=index&utm_content=thumbnail"
                            alt="Mandiri" height="20" title="Bank Mandiri">

                        <!-- Bank BNI -->
                        <img src="https://thumb.wikimedia.org/wikipedia/commons/thumb/f/f0/Bank_Negara_Indonesia_logo_%282004%29.svg/1280px-Bank_Negara_Indonesia_logo_%282004%29.svg.png?utm_source=id.wikipedia.org&utm_campaign=index&utm_content=thumbnail"
                            alt="BNI" height="22" title="BNI">

                        <!-- Bank BRI -->
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5b/Logo_Bank_Rakyat_Indonesia.svg?utm_source=id.wikipedia.org&utm_campaign=index&utm_content=original"
                            alt="BRI" height="20" title="Bank BRI">

                        <!-- Permata Bank -->
                        <img src="https://upload.wikimedia.org/wikipedia/en/archive/4/48/20250913151534%21PermataBank_logo.svg"
                            alt="Permata" height="20" title="Permata Bank">

                        <!-- DANA -->
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/52/Dana_logo.png?utm_source=id.wikipedia.org&utm_campaign=index&utm_content=original"
                            alt="Dana" height="24" title="DANA">
                    </div>


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

                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 RuangUndang Digital Invitation. Dibuat dengan <i
                        class="bi bi-heart-fill text-danger"></i>
                    di Indonesia.</p>
            </div>

            <div class="text-center mt-4">
                <a href="https://midtrans.com" target="_blank" rel="noopener noreferrer" class="midtrans-security"
                    title="Pembayaran aman diproses oleh Midtrans">
                    <span class="midtrans-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                    </span>
                    <span class="midtrans-label">Pembayaran Aman</span>
                    <span class="midtrans-logo-text">Midtrans</span>
                </a>
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

        // Hero Text Slider
        const heroSlides = document.querySelectorAll('.hero-slide');
        const heroDotsContainer = document.querySelector('.hero-slider-dots');
        let currentHeroSlide = 0;
        let heroInterval;

        function createHeroDots() {
            if (!heroDotsContainer) return;
            heroDotsContainer.innerHTML = '';
            heroSlides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = 'hero-slider-dot' + (index === 0 ? ' active' : '');
                dot.setAttribute('aria-label', 'Slide ' + (index + 1));
                dot.addEventListener('click', () => goToHeroSlide(index));
                heroDotsContainer.appendChild(dot);
            });
        }

        function goToHeroSlide(index) {
            heroSlides[currentHeroSlide].classList.remove('active');
            currentHeroSlide = index;
            heroSlides[currentHeroSlide].classList.add('active');
            updateHeroDots();
            resetHeroAutoPlay();
        }

        function updateHeroDots() {
            if (!heroDotsContainer) return;
            const dots = heroDotsContainer.querySelectorAll('.hero-slider-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentHeroSlide);
            });
        }

        function nextHeroSlide() {
            const next = (currentHeroSlide + 1) % heroSlides.length;
            goToHeroSlide(next);
        }

        function startHeroAutoPlay() {
            stopHeroAutoPlay();
            heroInterval = setInterval(nextHeroSlide, 5000);
        }

        function stopHeroAutoPlay() {
            clearInterval(heroInterval);
        }

        function resetHeroAutoPlay() {
            stopHeroAutoPlay();
            startHeroAutoPlay();
        }

        if (heroSlides.length > 0) {
            createHeroDots();
            startHeroAutoPlay();
        }

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

        // Features Auto Scroll
        const featuresScrollWrapper = document.querySelector('.features-scroll-wrapper');
        const featuresScrollTrack = document.querySelector('.features-scroll-track');
        if (featuresScrollWrapper && featuresScrollTrack) {
            featuresScrollWrapper.addEventListener('mouseenter', () => {
                featuresScrollTrack.style.animationPlayState = 'paused';
            });
            featuresScrollWrapper.addEventListener('mouseleave', () => {
                featuresScrollTrack.style.animationPlayState = 'running';
            });
        }

        // Couple List Live Preview Toggle
        const coupleListItems = document.querySelectorAll('.couple-list-item[data-slug]');
        const previewPanel = document.getElementById('couplePreviewPanel');
        const previewFrame = document.getElementById('couplePreviewFrame');
        const previewEmpty = document.getElementById('couplePreviewEmpty');
        const previewCloseBtn = previewPanel ? previewPanel.querySelector('.couple-preview-close') : null;
        let activeCoupleItem = null;

        function openCouplePreview(item) {
            if (!previewPanel || !previewFrame) return;

            const slug = item.getAttribute('data-slug');
            const templateId = item.getAttribute('data-template-id');
            const previewUrl = `/template/frame/${slug}/${templateId}`;

            previewFrame.src = previewUrl;
            previewPanel.classList.remove('d-none');
            if (previewEmpty) previewEmpty.classList.add('d-none');

            if (activeCoupleItem && activeCoupleItem !== item) {
                activeCoupleItem.classList.remove('active');
            }
            item.classList.add('active');
            activeCoupleItem = item;
        }

        function closeCouplePreview() {
            if (!previewPanel || !previewFrame) return;
            previewFrame.src = '';
            previewPanel.classList.add('d-none');
            if (previewEmpty) previewEmpty.classList.remove('d-none');

            if (activeCoupleItem) {
                activeCoupleItem.classList.remove('active');
                activeCoupleItem = null;
            }
        }

        coupleListItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                if (activeCoupleItem === this) {
                    closeCouplePreview();
                } else {
                    openCouplePreview(this);
                }
            });
        });

        if (previewCloseBtn) {
            previewCloseBtn.addEventListener('click', closeCouplePreview);
        }
    </script>

    <!-- ============================================================= -->



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

    @include('components.wa-chat', [
        'phone' => '6285923431716',
        'message' => 'Halo RuangUndang, saya ingin bertanya tentang layanan undangan digital.',
        'title' => 'Chat WhatsApp RuangUndang',
        'mobileBottom' => 24
    ])
</body>

</html>
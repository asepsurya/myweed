<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Harga - RuangUndang</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/fav-icon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1), transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Navbar */
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
            display: inline-flex;
            align-items: center;
            padding: 0;
            margin: 0;
        }

        /* Sistem pertukaran logo */
        .navbar-brand img {
            height: 40px;
            width: auto;
            transition: opacity var(--speed) ease;
        }

        .navbar-brand .logo-white {
            display: none;
        }

        .navbar-brand .logo-dark {
            display: block;
        }

        /* Saat navbar di atas (background gelap), tampilkan logo putih */
        .navbar:not(.scrolled) .navbar-brand .logo-white {
            display: block;
        }

        .navbar:not(.scrolled) .navbar-brand .logo-dark {
            display: none;
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
            color: var(--white) !important;
        }

        /* Page Header */
        .page-header {
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(27, 42, 74, 0.8), rgba(27, 42, 74, 0.95)), url('https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            color: var(--white);
            position: relative;
            overflow: hidden;
            padding: 120px 0 80px;
        }

        .page-header-shape {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(198, 169, 98, 0.2);
            z-index: 1;
            animation: float 10s infinite ease-in-out;
        }

        .page-header-shape.shape-1 {
            width: 300px;
            height: 300px;
            top: -80px;
            left: -80px;
        }

        .page-header-shape.shape-2 {
            width: 200px;
            height: 200px;
            bottom: -40px;
            right: -40px;
            border-color: rgba(255, 255, 255, 0.1);
            animation-direction: reverse;
            animation-duration: 12s;
        }

        .page-header-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: -1px;
            animation: fadeInUp 1s ease-out forwards;
        }

        .page-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
            animation: fadeInUp 1s ease-out 0.3s forwards;
            opacity: 0;
        }

        .breadcrumb {
            justify-content: center;
            animation: fadeInUp 1s ease-out 0.5s forwards;
            opacity: 0;
        }

        .breadcrumb-item a {
            color: var(--gold-light);
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Content Sections */
        .content-section {
            padding: 80px 0;
            background: var(--white);
        }

        .content-section.alt {
            background: var(--bg);
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--gold-dark);
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            display: block;
        }

        .section-desc {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Pricing Cards */
        .pricing-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            height: 100%;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            position: relative;
            overflow: hidden;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            border-color: var(--gold-light);
            box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1);
        }

        .pricing-card.featured {
            border-color: var(--gold);
            box-shadow: 0 10px 40px rgba(198, 169, 98, 0.15);
        }

        .pricing-card.featured::before {
            content: 'POPULER';
            position: absolute;
            top: 20px;
            right: -30px;
            background: var(--gold);
            color: var(--white);
            padding: 0.25rem 2.5rem;
            font-size: 0.7rem;
            font-weight: 700;
            transform: rotate(45deg);
            letter-spacing: 1px;
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .pricing-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: var(--gold-dark);
        }

        .pricing-card h4 {
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .pricing-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--navy);
            font-family: var(--font);
        }

        .pricing-price span {
            font-size: 1rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .pricing-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .pricing-features {
            list-style: none;
            padding: 0;
            margin: 0 0 2rem;
        }

        .pricing-features li {
            padding: 0.6rem 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .pricing-features li i {
            color: var(--gold);
        }

        .pricing-features li.disabled {
            color: var(--text-muted);
            text-decoration: line-through;
        }

        .pricing-features li.disabled i {
            color: var(--text-muted);
        }

        /* Comparison Table */
        .comparison-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .comparison-table th {
            background: var(--navy);
            color: var(--white);
            padding: 1rem 1.5rem;
            font-weight: 600;
            text-align: center;
        }

        .comparison-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            background: var(--white);
            color: var(--text-secondary);
        }

        .comparison-table tr:last-child td {
            border-bottom: none;
        }

        .comparison-table tr:hover td {
            background: var(--bg-alt);
        }

        .comparison-table td:first-child {
            font-weight: 600;
            color: var(--navy);
        }

        .comparison-table td i {
            font-size: 1.1rem;
        }

        .text-gold {
            color: var(--gold-dark) !important;
        }

        .text-muted-custom {
            color: var(--text-muted) !important;
        }

        /* FAQ Items */
        .faq-item {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: var(--gold-light);
        }

        .faq-item h5 {
            color: var(--navy);
            margin-bottom: 0.5rem;
        }

        .faq-item p {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.9rem;
        }

        /* Footer */
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
            transition: all var(--speed);
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

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .comparison-table {
                font-size: 0.85rem;
            }

            .comparison-table th,
            .comparison-table td {
                padding: 0.75rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src="{{ asset('assets/logo-white.png') }}" alt="Logo RuangUndang" class="logo-white">
                <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang" class="logo-dark">
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-shape shape-1"></div>
        <div class="page-header-shape shape-2"></div>
        <div class="container page-header-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Harga</li>
                </ol>
            </nav>
            <h1>Harga Paket</h1>
            <p>Pilih paket yang sesuai dengan kebutuhan undangan impian Anda.</p>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Investasi Momen</span>
                <h2 class="section-title">Paket yang Fleksibel</h2>
                <p class="section-desc">Mulai dari gratis, upgrade kapan saja sesuai kebutuhan.</p>
            </div>

            <div class="row g-4">
                @forelse($plans as $index => $plan)
                    @php
                        $features = json_decode($plan->description ?? '[]', true) ?: [];
                        $isFeatured = $plan->slug === 'pro' || $index === 1;
                        $delay = 0.1 + ($index * 0.1);
                    @endphp
                    <div class="col-lg-4 col-md-6 reveal" style="transition-delay: {{ $delay }}s;">
                        <div class="pricing-card {{ $isFeatured ? 'featured' : '' }}">
                            <div class="pricing-header">
                                <div class="pricing-icon">
                                    <i
                                        class="bi bi-{{ $plan->is_free ? 'gift' : ($plan->slug === 'pro' ? 'award' : 'gem') }}"></i>
                                </div>
                                <h4>{{ $plan->name }}</h4>
                                <div class="pricing-price">
                                    {{ $plan->is_free ? 'Gratis' : 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                                    <span>{{ $plan->is_free ? '' : '/undangan' }}</span>
                                </div>
                                <p class="pricing-desc">{{ $plan->duration }} Hari aktif</p>
                            </div>
                            <ul class="pricing-features">
                                @php
                                    $sortedFeatures = $features;
                                    usort($sortedFeatures, function ($a, $b) {
                                        $aYes = preg_match('/:\s*Yes$/', $a) ? 0 : (preg_match('/:\s*No$/', $a) ? 1 : 2);
                                        $bYes = preg_match('/:\s*Yes$/', $b) ? 0 : (preg_match('/:\s*No$/', $b) ? 1 : 2);
                                        return $aYes <=> $bYes;
                                    });
                                @endphp
                                @forelse($sortedFeatures as $feature)
                                    @php
                                        $featureName = preg_replace('/:\s*(Yes|No)$/', '', $feature);
                                        $isYes = preg_match('/:\s*Yes$/', $feature);
                                        $isNo = preg_match('/:\s*No$/', $feature);
                                    @endphp
                                    <li class="{{ $isNo ? 'text-muted' : '' }}">
                                        @if($isYes)
                                            <i class="bi bi-check-circle-fill text-gold"></i>
                                        @elseif($isNo)
                                            <i class="bi bi-x-circle text-muted-custom"></i>
                                        @else
                                            <i class="bi bi-check-circle-fill text-gold"></i>
                                        @endif
                                        {{ $featureName }}
                                    </li>
                                @empty
                                    <li class="text-muted fst-italic">Belum ada fitur ditambahkan.</li>
                                @endforelse
                            </ul>
                            <a href="{{ route('subscribe', $plan->id) }}"
                                class="btn {{ $isFeatured ? 'btn-gold' : 'btn-outline-dark' }} w-100 rounded-pill py-2 fw-semibold">
                                {{ $plan->is_free ? 'Mulai Gratis' : 'Pilih ' . $plan->name }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                        <h6 class="text-muted">Belum ada paket harga.</h6>
                        <p class="text-muted small">Silakan hubungi admin untuk informasi paket terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Comparison Table Section -->
    <section class="content-section alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Perbandingan</span>
                <h2 class="section-title">Fitur per Paket</h2>
            </div>
            @if($plans->count() > 1)
                <div class="reveal">
                    <div class="table-responsive">
                        <table class="comparison-table">
                            <thead>
                                <tr>
                                    <th>Fitur</th>
                                    @foreach($plans as $index => $plan)
                                        <th class="{{ $index === 1 ? 'text-gold' : '' }}">{{ $plan->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $allFeatures = [];
                                    foreach ($plans as $plan) {
                                        $features = json_decode($plan->description ?? '[]', true) ?: [];
                                        foreach ($features as $feature) {
                                            $baseFeature = preg_replace('/:\s*(Yes|No)$/', '', $feature);
                                            $allFeatures[$baseFeature] = $feature;
                                        }
                                    }
                                    $uniqueFeatures = array_keys($allFeatures);
                                    usort($uniqueFeatures, function ($featureA, $featureB) use ($plans) {
                                        $scoreA = 2;
                                        $scoreB = 2;
                                        foreach ($plans as $plan) {
                                            $planFeatures = json_decode($plan->description ?? '[]', true) ?: [];
                                            foreach ($planFeatures as $pf) {
                                                $baseFeature = preg_replace('/:\s*(Yes|No)$/', '', $pf);
                                                if ($baseFeature === $featureA && preg_match('/:\s*Yes$/', $pf)) {
                                                    $scoreA = min($scoreA, 0);
                                                }
                                                if ($baseFeature === $featureA && preg_match('/:\s*No$/', $pf)) {
                                                    $scoreA = min($scoreA, 1);
                                                }
                                                if ($baseFeature === $featureB && preg_match('/:\s*Yes$/', $pf)) {
                                                    $scoreB = min($scoreB, 0);
                                                }
                                                if ($baseFeature === $featureB && preg_match('/:\s*No$/', $pf)) {
                                                    $scoreB = min($scoreB, 1);
                                                }
                                            }
                                        }
                                        return $scoreA <=> $scoreB;
                                    });
                                @endphp

                                @forelse($uniqueFeatures as $feature)
                                    @php
                                        $planFeatureMap = [];
                                        foreach ($plans as $plan) {
                                            $planFeatures = json_decode($plan->description ?? '[]', true) ?: [];
                                            $hasFeature = false;
                                            $isNo = false;
                                            foreach ($planFeatures as $pf) {
                                                $baseFeature = preg_replace('/:\s*(Yes|No)$/', '', $pf);
                                                if ($baseFeature === $feature) {
                                                    $hasFeature = true;
                                                    if (preg_match('/:\s*No$/', $pf)) {
                                                        $isNo = true;
                                                    }
                                                    break;
                                                }
                                            }
                                            $planFeatureMap[$plan->id] = [
                                                'has' => $hasFeature,
                                                'isNo' => $isNo,
                                            ];
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $feature }}</td>
                                        @foreach($plans as $plan)
                                            <td class="{{ $loop->iteration === 2 ? 'text-gold' : '' }}">
                                                @if($planFeatureMap[$plan->id]['has'] && !$planFeatureMap[$plan->id]['isNo'])
                                                    <i class="bi bi-check-circle-fill"></i>
                                                @elseif($planFeatureMap[$plan->id]['isNo'])
                                                    <i class="bi bi-x-circle text-muted-custom"></i>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $plans->count() + 1 }}" class="text-center text-muted">Belum ada fitur
                                            yang ditambahkan untuk perbandingan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="bi bi-info-circle me-2"></i>
                    Perbandingan fitur akan muncul setelah ada minimal 2 paket.
                </div>
            @endif
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">FAQ Harga</span>
                <h2 class="section-title">Pertanyaan Umum</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-item reveal">
                        <h5><i class="bi bi-question-circle text-gold me-2"></i>Apakah ada biaya tersembunyi?</h5>
                        <p>Tidak ada biaya tersembunyi. Semua yang tercantum adalah biaya final. Anda hanya membayar
                            sesuai paket yang dipilih.</p>
                    </div>
                    <div class="faq-item reveal" style="transition-delay: 0.1s;">
                        <h5><i class="bi bi-question-circle text-gold me-2"></i>Bisa upgrade paket nanti?</h5>
                        <p>Ya, Anda bisa upgrade kapan saja. Data undangan akan tetap tersimpan dan Anda hanya membayar
                            selisih harga.</p>
                    </div>
                    <div class="faq-item reveal" style="transition-delay: 0.2s;">
                        <h5><i class="bi bi-question-circle text-gold me-2"></i>Metode pembayaran apa saja?</h5>
                        <p>Kami menerima transfer bank, e-wallet (GoPay, OVO, DANA), kartu kredit, dan QRIS.</p>
                    </div>
                </div>
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
                    <p class="text-secondary small" style="max-width: 350px;">Saat ini kami menyediakan undangan digital untuk pernikahan. Untuk khitanan, aqiqah, dan momen spesial lainnya akan segera hadir. Praktis, elegan, dan hemat biaya.</p>
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
                <p>&copy; 2024 RuangUndang Digital Invitation. Dibuat dengan <i class="bi bi-heart-fill text-danger"></i>
                    di Indonesia.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) { navbar.classList.add('scrolled'); }
            else { navbar.classList.remove('scrolled'); }
        });

        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) { entry.target.classList.add('active'); observer.unobserve(entry.target); }
            });
        }, { threshold: 0.15 });
        reveals.forEach(reveal => observer.observe(reveal));
    </script>
</body>

</html>

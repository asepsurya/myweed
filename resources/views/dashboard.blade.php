<x-app-layout>
    @php
        // Logika Sapaan Dinamis & Tanggal Indonesia
        $hour = (int) now()->format('H');
        if ($hour >= 4 && $hour < 11) {
            $greeting = 'Selamat Pagi';
            $greetingIcon = 'bi-sunrise-fill';
            $greetingColor = '#F59E0B';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Selamat Siang';
            $greetingIcon = 'bi-sun-fill';
            $greetingColor = '#EAB308';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Selamat Sore';
            $greetingIcon = 'bi-sunset-fill';
            $greetingColor = '#F97316';
        } else {
            $greeting = 'Selamat Malam';
            $greetingIcon = 'bi-moon-stars-fill';
            $greetingColor = '#818CF8';
        }

        $todayIndo = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y');
        $attendanceRate = ($totalGuests ?? 0) > 0 ? round((($rsvpYes ?? 0) / $totalGuests) * 100) : 0;
    @endphp

    <style>
        /* ================================================================
           DASHBOARD REDESIGN - RUANGUNDANG PROFESSIONAL SUITE
           Aligned with Gold & Deep Navy palette + Modern Glassmorphism
        ================================================================ */
        .ru-dashboard {
            --ru-gold: #C6A962;
            --ru-gold-hover: #A68B4B;
            --ru-gold-soft: rgba(198, 169, 98, 0.12);
            --ru-gold-border: rgba(198, 169, 98, 0.28);
            --ru-navy: #1B2A4A;
            --ru-navy-soft: rgba(27, 42, 74, 0.05);
            --ru-navy-border: rgba(27, 42, 74, 0.1);
            --ru-card-bg: #FFFFFF;
            --ru-card-border: rgba(27, 42, 74, 0.08);
            --ru-card-shadow: 0 4px 20px rgba(27, 42, 74, 0.05);
            --ru-card-shadow-hover: 0 12px 32px rgba(27, 42, 74, 0.1);
            --ru-text-title: #1B2A4A;
            --ru-text-body: #475569;
            --ru-text-muted: #64748B;
            --ru-radius-sm: 10px;
            --ru-radius-md: 14px;
            --ru-radius-lg: 18px;
            --ru-radius-xl: 22px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        [data-bs-theme="dark"] .ru-dashboard {
            --ru-gold-soft: rgba(198, 169, 98, 0.18);
            --ru-gold-border: rgba(198, 169, 98, 0.35);
            --ru-navy-soft: rgba(255, 255, 255, 0.05);
            --ru-card-bg: #111827;
            --ru-card-border: rgba(255, 255, 255, 0.08);
            --ru-card-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
            --ru-card-shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.55);
            --ru-text-title: #F8FAFC;
            --ru-text-body: #CBD5E1;
            --ru-text-muted: #94A3B8;
        }

        /* 1. Hero Welcome Banner */
        .ru-welcome-banner {
            background: linear-gradient(135deg, #1B2A4A 0%, #243B68 60%, #1B2A4A 100%);
            border-radius: var(--ru-radius-xl);
            padding: 1.75rem 2rem;
            color: #FFFFFF;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(27, 42, 74, 0.18);
            border: 1px solid rgba(198, 169, 98, 0.25);
            margin-bottom: 1.75rem;
        }

        .ru-welcome-banner::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -40px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(198, 169, 98, 0.25) 0%, rgba(198, 169, 98, 0) 70%);
            pointer-events: none;
        }

        .ru-welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -50px;
            left: 20%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .ru-welcome-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .ru-welcome-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 0;
            color: #FFFFFF;
        }

        .ru-welcome-subtitle {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.82);
            margin-top: 4px;
            margin-bottom: 0;
        }

        .ru-welcome-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: rgba(255, 255, 255, 0.95);
        }

        .ru-status-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10B981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: ru-pulse 2s infinite;
        }

        @keyframes ru-pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .btn-ru-gold {
            background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%);
            color: #FFFFFF !important;
            border: none;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px 20px;
            border-radius: var(--ru-radius-md);
            box-shadow: 0 4px 14px rgba(198, 169, 98, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-ru-gold:hover {
            background: linear-gradient(135deg, #A68B4B 0%, #8F743E 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(198, 169, 98, 0.45);
            color: #FFFFFF !important;
        }

        .btn-ru-ghost {
            background: rgba(255, 255, 255, 0.12);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.22);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 10px 18px;
            border-radius: var(--ru-radius-md);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            backdrop-filter: blur(6px);
        }

        .btn-ru-ghost:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #FFFFFF !important;
            transform: translateY(-2px);
        }

        /* 2. Stat Cards Grid */
        .ru-stat-card {
            background: var(--ru-card-bg);
            border: 1px solid var(--ru-card-border);
            border-radius: var(--ru-radius-lg);
            padding: 1.25rem 1.15rem;
            box-shadow: var(--ru-card-shadow);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .ru-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--ru-card-shadow-hover);
            border-color: var(--ru-gold-border);
        }

        .ru-stat-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
            margin-bottom: 0.85rem;
        }

        .ru-stat-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--ru-text-title);
            line-height: 1.1;
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }

        .ru-stat-title {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--ru-text-muted);
            margin-bottom: 6px;
            letter-spacing: 0.01em;
        }

        .ru-stat-meta {
            font-size: 0.75rem;
            color: var(--ru-text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: auto;
        }

        /* Stat Icon Themes */
        .ru-icon-gold { background: rgba(198, 169, 98, 0.15); color: #C6A962; }
        .ru-icon-blue { background: rgba(59, 130, 246, 0.15); color: #3B82F6; }
        .ru-icon-green { background: rgba(16, 185, 129, 0.15); color: #10B981; }
        .ru-icon-red { background: rgba(239, 68, 68, 0.15); color: #EF4444; }
        .ru-icon-purple { background: rgba(139, 92, 246, 0.15); color: #8B5CF6; }
        .ru-icon-amber { background: rgba(245, 158, 11, 0.15); color: #F59E0B; }

        /* 3. Section Cards */
        .ru-panel-card {
            background: var(--ru-card-bg);
            border: 1px solid var(--ru-card-border);
            border-radius: var(--ru-radius-xl);
            box-shadow: var(--ru-card-shadow);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.25s ease;
        }

        .ru-panel-card:hover {
            box-shadow: var(--ru-card-shadow-hover);
        }

        .ru-panel-header {
            padding: 1.15rem 1.4rem;
            border-bottom: 1px solid var(--ru-card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--ru-navy-soft);
        }

        .ru-panel-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ru-panel-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .ru-panel-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--ru-text-title);
            margin: 0;
            letter-spacing: -0.01em;
        }

        .ru-panel-subtitle {
            font-size: 0.75rem;
            color: var(--ru-text-muted);
            margin: 2px 0 0;
        }

        .ru-panel-body {
            padding: 0;
            flex: 1;
        }

        /* 4. Invitations List Items */
        .ru-invitation-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.4rem;
            border-bottom: 1px solid var(--ru-card-border);
            gap: 14px;
            transition: background 0.2s ease;
        }

        .ru-invitation-item:last-child {
            border-bottom: none;
        }

        .ru-invitation-item:hover {
            background-color: var(--ru-navy-soft);
        }

        .ru-invitation-avatar {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--ru-gold-border);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        .ru-invitation-avatar.placeholder {
            background: linear-gradient(135deg, #1B2A4A, #243B68);
            color: #C6A962;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.05rem;
            border: 2px solid var(--ru-gold-border);
        }

        .ru-invitation-info {
            flex: 1;
            min-width: 0;
        }

        .ru-invitation-names {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--ru-text-title);
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ru-invitation-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            font-size: 0.775rem;
            color: var(--ru-text-muted);
        }

        .ru-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .ru-btn-action {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            font-size: 0.775rem;
            font-weight: 600;
            border-radius: var(--ru-radius-sm);
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .ru-btn-action-preview {
            background: var(--ru-navy-soft);
            color: var(--ru-text-title);
            border: 1px solid var(--ru-card-border);
        }

        .ru-btn-action-preview:hover {
            background: var(--ru-navy);
            color: #FFFFFF;
            border-color: var(--ru-navy);
        }

        .ru-btn-action-edit {
            background: var(--ru-gold-soft);
            color: #8F743E;
            border: 1px solid var(--ru-gold-border);
        }

        .ru-btn-action-edit:hover {
            background: #C6A962;
            color: #FFFFFF;
            border-color: #C6A962;
        }

        /* 5. RSVP Feed Items */
        .ru-rsvp-item {
            display: flex;
            align-items: flex-start;
            padding: 1rem 1.4rem;
            border-bottom: 1px solid var(--ru-card-border);
            gap: 12px;
            transition: background 0.2s ease;
        }

        .ru-rsvp-item:last-child {
            border-bottom: none;
        }

        .ru-rsvp-item:hover {
            background-color: var(--ru-navy-soft);
        }

        .ru-rsvp-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: #FFFFFF;
            background: linear-gradient(135deg, #C6A962, #1B2A4A);
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .ru-rsvp-content {
            flex: 1;
            min-width: 0;
        }

        .ru-rsvp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 2px;
        }

        .ru-rsvp-name {
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--ru-text-title);
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ru-rsvp-target {
            font-size: 0.75rem;
            color: var(--ru-text-muted);
            margin-bottom: 4px;
        }

        .ru-rsvp-target a {
            color: #C6A962;
            text-decoration: none;
            font-weight: 500;
        }

        .ru-rsvp-target a:hover {
            text-decoration: underline;
        }

        .ru-rsvp-quote {
            font-size: 0.8rem;
            font-style: italic;
            color: var(--ru-text-body);
            background: var(--ru-navy-soft);
            border-left: 3px solid #C6A962;
            padding: 6px 10px;
            border-radius: 4px 8px 8px 4px;
            margin-top: 5px;
            line-height: 1.4;
        }

        /* 6. Empty States */
        .ru-empty-box {
            padding: 3rem 1.5rem;
            text-align: center;
        }

        .ru-empty-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--ru-navy-soft);
            color: var(--ru-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1rem;
            border: 1px dashed var(--ru-gold-border);
        }

        .ru-empty-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--ru-text-title);
            margin-bottom: 0.35rem;
        }

        .ru-empty-desc {
            font-size: 0.825rem;
            color: var(--ru-text-muted);
            max-width: 320px;
            margin: 0 auto 1.25rem;
            line-height: 1.5;
        }

        /* 7. Quick Management Tools */
        .ru-quick-tile {
            background: var(--ru-card-bg);
            border: 1px solid var(--ru-card-border);
            border-radius: var(--ru-radius-lg);
            padding: 1.15rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: var(--ru-card-shadow);
            height: 100%;
        }

        .ru-quick-tile:hover {
            transform: translateY(-3px);
            box-shadow: var(--ru-card-shadow-hover);
            border-color: var(--ru-gold-border);
            text-decoration: none;
        }

        .ru-quick-tile-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
            transition: transform 0.25s ease;
        }

        .ru-quick-tile:hover .ru-quick-tile-icon {
            transform: scale(1.08);
        }

        .ru-quick-tile-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.925rem;
            font-weight: 700;
            color: var(--ru-text-title);
            margin: 0 0 2px 0;
        }

        .ru-quick-tile-desc {
            font-size: 0.75rem;
            color: var(--ru-text-muted);
            margin: 0;
        }

        .ru-quick-tile-arrow {
            margin-left: auto;
            color: var(--ru-text-muted);
            font-size: 1.1rem;
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .ru-quick-tile:hover .ru-quick-tile-arrow {
            transform: translateX(4px);
            color: #C6A962;
        }

        /* 8. Mobile Responsiveness */
        @media (max-width: 767.98px) {
            .ru-welcome-banner {
                padding: 1.25rem 1rem;
            }

            .ru-welcome-title {
                font-size: 1.15rem;
            }

            .ru-welcome-actions {
                flex-direction: column;
                width: 100%;
                gap: 8px !important;
            }

            .ru-welcome-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .ru-invitation-actions {
                flex-direction: column;
                gap: 4px;
            }

            .ru-stat-value {
                font-size: 1.45rem;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4 py-3 ru-dashboard" id="main-content">

        {{-- ================================================================
             1. HERO WELCOME & QUICK ACTION BANNER
        ================================================================ --}}
        <div class="ru-welcome-banner">
            <div class="row align-items-center g-3">
                <div class="col-12 col-lg-7">
                    <div class="d-flex align-items-center gap-3">
                        <div class="ru-welcome-icon" style="color: {{ $greetingColor }};">
                            <i class="bi {{ $greetingIcon }}"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                <h1 class="ru-welcome-title">
                                    {{ $greeting }}, {{ auth()->user()->name }}! 👋
                                </h1>
                                <span class="ru-welcome-badge">
                                    <span class="ru-status-pulse"></span>
                                    <span>Realtime Active</span>
                                </span>
                            </div>
                            <p class="ru-welcome-subtitle">
                                <i class="bi bi-calendar2-event me-1"></i> {{ $todayIndo }} &middot; Pantau metrik dan respon tamu pernikahan secara instan
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="d-flex align-items-center justify-content-lg-end gap-2 flex-wrap ru-welcome-actions">
                        <a href="{{ route('invitation.create') }}" class="btn-ru-gold">
                            <i class="bi bi-plus-circle-fill"></i>
                            <span>Buat Undangan Baru</span>
                        </a>
                        <a href="{{ route('invitation.index') }}" class="btn-ru-ghost">
                            <i class="bi bi-gem"></i>
                            <span>Kelola Pasangan</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================================================================
             2. METRICS & KPI CARDS GRID (6 Balanced responsive cards)
        ================================================================ --}}
        <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-xl-6 mb-4">

            {{-- 1. Total Undangan --}}
            <div class="col">
                <a href="{{ route('invitation.index') }}" class="text-decoration-none">
                    <div class="ru-stat-card">
                        <div>
                            <div class="ru-stat-icon-wrap ru-icon-gold">
                                <i class="bi bi-envelope-paper-heart-fill"></i>
                            </div>
                            <div class="ru-stat-value">{{ number_format($totalInvitations ?? 0) }}</div>
                            <div class="ru-stat-title">Total Undangan</div>
                        </div>
                        <div class="ru-stat-meta">
                            <span class="badge bg-gold-subtle text-warning-emphasis p-1 px-2 rounded-pill small">
                                {{ $publishedInvitations ?? 0 }} Terbit
                            </span>
                            <span class="text-muted">&middot; {{ $draftInvitations ?? 0 }} Draf</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 2. Total Tamu (RSVP) --}}
            <div class="col">
                <a href="{{ route('rsvp.index') }}" class="text-decoration-none">
                    <div class="ru-stat-card">
                        <div>
                            <div class="ru-stat-icon-wrap ru-icon-blue">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="ru-stat-value">{{ number_format($totalGuests ?? 0) }}</div>
                            <div class="ru-stat-title">Total Tamu Respon</div>
                        </div>
                        <div class="ru-stat-meta text-primary-emphasis">
                            <i class="bi bi-journal-check"></i>
                            <span>Buku tamu digital</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 3. RSVP Hadir --}}
            <div class="col">
                <div class="ru-stat-card">
                    <div>
                        <div class="ru-stat-icon-wrap ru-icon-green">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="ru-stat-value text-success">{{ number_format($rsvpYes ?? 0) }}</div>
                        <div class="ru-stat-title">Konfirmasi Hadir</div>
                    </div>
                    <div class="ru-stat-meta">
                        @if(($totalGuests ?? 0) > 0)
                            <span class="badge bg-success-subtle text-success rounded-pill px-2">
                                <i class="bi bi-arrow-up-short"></i>{{ $attendanceRate }}% Rasio
                            </span>
                        @else
                            <span class="text-muted">Belum ada respon</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 4. RSVP Tidak Hadir --}}
            <div class="col">
                <div class="ru-stat-card">
                    <div>
                        <div class="ru-stat-icon-wrap ru-icon-red">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <div class="ru-stat-value text-danger">{{ number_format($rsvpNo ?? 0) }}</div>
                        <div class="ru-stat-title">Berhalangan Hadir</div>
                    </div>
                    <div class="ru-stat-meta">
                        @if(($totalGuests ?? 0) > 0)
                            @php $absentRate = round((($rsvpNo ?? 0) / $totalGuests) * 100); @endphp
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-2">
                                {{ $absentRate }}% Tamu
                            </span>
                        @else
                            <span class="text-muted">Belum ada respon</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 5. Total Musik Pustaka --}}
            <div class="col">
                <a href="{{ route('music.index') }}" class="text-decoration-none">
                    <div class="ru-stat-card">
                        <div>
                            <div class="ru-stat-icon-wrap ru-icon-purple">
                                <i class="bi bi-music-note-beamed"></i>
                            </div>
                            <div class="ru-stat-value">{{ number_format($totalMusic ?? 0) }}</div>
                            <div class="ru-stat-title">Pustaka Audio</div>
                        </div>
                        <div class="ru-stat-meta text-purple">
                            <i class="bi bi-soundwave"></i>
                            <span>Lagu latar wedding</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- 6. Musik Aktif --}}
            <div class="col">
                <a href="{{ route('music.index') }}" class="text-decoration-none">
                    <div class="ru-stat-card">
                        <div>
                            <div class="ru-stat-icon-wrap ru-icon-amber">
                                <i class="bi bi-disc-fill"></i>
                            </div>
                            <div class="ru-stat-value text-warning-emphasis">{{ number_format($activeMusic ?? 0) }}</div>
                            <div class="ru-stat-title">Musik Aktif</div>
                        </div>
                        <div class="ru-stat-meta text-warning-emphasis">
                            <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2">
                                Siap digunakan
                            </span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

        {{-- ================================================================
             3. MAIN CONTENT: INVITATIONS & REALTIME RSVP FEED
        ================================================================ --}}
        <div class="row g-4 mb-4">

            {{-- KOLOM KIRI: DAFTAR UNDANGAN TERBARU (7 COLS / 8 COLS) --}}
            <div class="col-12 col-xl-7">
                <div class="ru-panel-card">
                    <div class="ru-panel-header">
                        <div class="ru-panel-title-wrap">
                            <div class="ru-panel-icon ru-icon-gold">
                                <i class="bi bi-envelope-heart-fill"></i>
                            </div>
                            <div>
                                <h3 class="ru-panel-title">Daftar Undangan Terbaru</h3>
                                <p class="ru-panel-subtitle">Undangan yang aktif dan baru diperbarui</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-2 py-1 small">
                                {{ $invitations->count() }} Ditampilkan
                            </span>
                            <a href="{{ route('invitation.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 font-weight-medium">
                                Lihat Semua <i class="bi bi-arrow-right small ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ru-panel-body">
                        @if($invitations->count() > 0)
                            <div class="ru-invitation-list">
                                @foreach($invitations as $inv)
                                    @php
                                        $initials = strtoupper(substr($inv->groom_nickname ?? $inv->groom_name ?? 'P', 0, 1)) . '&' . strtoupper(substr($inv->bride_nickname ?? $inv->bride_name ?? 'W', 0, 1));
                                        $coverUrl = $inv->gallery_cover ? storage_url_with_fallback($inv->gallery_cover, null, $inv->updated_at->timestamp) : null;
                                        $coupleDisplay = ($inv->groom_name ?: $inv->groom_nickname) . ' & ' . ($inv->bride_name ?: $inv->bride_nickname);
                                    @endphp
                                    <div class="ru-invitation-item">
                                        {{-- Avatar / Cover --}}
                                        @if($coverUrl)
                                            <img src="{{ $coverUrl }}" alt="{{ $coupleDisplay }}" class="ru-invitation-avatar" loading="lazy">
                                        @else
                                            <div class="ru-invitation-avatar placeholder">
                                                {{ $initials }}
                                            </div>
                                        @endif

                                        {{-- Detail Info --}}
                                        <div class="ru-invitation-info">
                                            <div class="ru-invitation-names">
                                                {{ $coupleDisplay }}
                                            </div>
                                            <div class="ru-invitation-meta">
                                                <span>
                                                    <i class="bi bi-calendar3 me-1 text-muted"></i>
                                                    {{ $inv->wedding_date ? \Carbon\Carbon::parse($inv->wedding_date)->locale('id')->isoFormat('D MMM Y') : 'Tanggal belum diatur' }}
                                                </span>
                                                <span>&middot;</span>
                                                @if($inv->status === 'published')
                                                    <span class="ru-badge-pill bg-success-subtle text-success">
                                                        <i class="bi bi-check2"></i> Terbit
                                                    </span>
                                                @else
                                                    <span class="ru-badge-pill bg-secondary-subtle text-secondary">
                                                        <i class="bi bi-pencil-fill"></i> Draf
                                                    </span>
                                                @endif

                                                @if($inv->template)
                                                    <span class="ru-badge-pill bg-gold-subtle text-warning-emphasis d-none d-sm-inline-flex">
                                                        <i class="bi bi-palette2"></i> {{ $inv->template->name }}
                                                    </span>
                                                @endif

                                                <span class="ru-badge-pill bg-primary-subtle text-primary">
                                                    <i class="bi bi-people"></i> {{ $inv->rsvps_count ?? 0 }} RSVP
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="d-flex align-items-center gap-2 ru-invitation-actions flex-shrink-0">
                                            <a href="{{ url($inv->slug) }}" target="_blank" class="ru-btn-action ru-btn-action-preview" title="Lihat Website Undangan">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                                <span class="d-none d-md-inline">Lihat</span>
                                            </a>
                                            <a href="{{ route('invitation.edit', $inv) }}" class="ru-btn-action ru-btn-action-edit" title="Edit Detail Undangan">
                                                <i class="bi bi-pencil-square"></i>
                                                <span class="d-none d-md-inline">Edit</span>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-link text-muted p-1 copy-invitation-link" data-url="{{ url($inv->slug) }}" title="Salin URL">
                                                <i class="bi bi-link-45deg fs-6"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="ru-empty-box">
                                <div class="ru-empty-icon">
                                    <i class="bi bi-envelope-plus"></i>
                                </div>
                                <h4 class="ru-empty-title">Belum Ada Undangan</h4>
                                <p class="ru-empty-desc">Buat dan publikasikan undangan digital pertama Anda dalam hitungan menit.</p>
                                <a href="{{ route('invitation.create') }}" class="btn-ru-gold">
                                    <i class="bi bi-plus-lg"></i>
                                    <span>Buat Undangan Sekarang</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: AKTIVITAS RSVP & UCAPAN DOA TERBARU (5 COLS / 4 COLS) --}}
            <div class="col-12 col-xl-5">
                <div class="ru-panel-card">
                    <div class="ru-panel-header">
                        <div class="ru-panel-title-wrap">
                            <div class="ru-panel-icon ru-icon-purple">
                                <i class="bi bi-chat-heart-fill"></i>
                            </div>
                            <div>
                                <h3 class="ru-panel-title">Aktivitas RSVP & Ucapan</h3>
                                <p class="ru-panel-subtitle">Konfirmasi dan doa restu tamu terbaru</p>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('rsvp.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 font-weight-medium">
                                Semua <i class="bi bi-arrow-right small ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ru-panel-body">
                        @if($recentRsvps->count() > 0)
                            <div class="ru-rsvp-list">
                                @foreach($recentRsvps as $rsvp)
                                    @php
                                        $guestName = $rsvp->name ?? $rsvp->guest_name ?? 'Tamu Undangan';
                                        $guestInitial = strtoupper(substr($guestName, 0, 1));
                                        $isAttending = (string) $rsvp->attending === '1';
                                        $isNotAttending = (string) $rsvp->attending === '2';
                                        $isMaybe = (string) $rsvp->attending === '3';
                                    @endphp
                                    <div class="ru-rsvp-item">
                                        <div class="ru-rsvp-avatar">
                                            {{ $guestInitial }}
                                        </div>

                                        <div class="ru-rsvp-content">
                                            <div class="ru-rsvp-header">
                                                <h5 class="ru-rsvp-name">{{ $guestName }}</h5>
                                                @if($isAttending)
                                                    <span class="ru-badge-pill bg-success-subtle text-success">
                                                        <i class="bi bi-check-circle-fill"></i> Hadir
                                                    </span>
                                                @elseif($isNotAttending)
                                                    <span class="ru-badge-pill bg-danger-subtle text-danger">
                                                        <i class="bi bi-x-circle-fill"></i> Berhalangan
                                                    </span>
                                                @elseif($isMaybe)
                                                    <span class="ru-badge-pill bg-warning-subtle text-warning">
                                                        <i class="bi bi-question-circle-fill"></i> Ragu
                                                    </span>
                                                @else
                                                    <span class="ru-badge-pill bg-secondary-subtle text-secondary">
                                                        Terkirim
                                                    </span>
                                                @endif
                                            </div>

                                            @if($rsvp->invitation)
                                                <div class="ru-rsvp-target">
                                                    <span>Untuk:</span>
                                                    <a href="{{ url($rsvp->invitation->slug) }}" target="_blank">
                                                        {{ $rsvp->invitation->groom_name }} & {{ $rsvp->invitation->bride_name }}
                                                    </a>
                                                    <span class="text-muted ms-1">&middot; {{ $rsvp->created_at->diffForHumans() }}</span>
                                                </div>
                                            @endif

                                            @if(!empty($rsvp->message))
                                                <div class="ru-rsvp-quote">
                                                    &ldquo;{{ Str::limit($rsvp->message, 120) }}&rdquo;
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="ru-empty-box">
                                <div class="ru-empty-icon ru-icon-purple">
                                    <i class="bi bi-chat-quote"></i>
                                </div>
                                <h4 class="ru-empty-title">Belum Ada Respon RSVP</h4>
                                <p class="ru-empty-desc">Saat tamu membuka undangan dan mengisi kehadiran atau ucapan doa, konfirmasi akan muncul otomatis di sini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ================================================================
             4. ANALYTICS & INSIGHT CHARTS (RSVP Breakdown & Template Views)
        ================================================================ --}}
        <div class="row g-4 mb-4">

            {{-- GRAFIK RASIO KEHADIRAN RSVP --}}
            <div class="col-12 col-lg-6">
                <div class="ru-panel-card">
                    <div class="ru-panel-header">
                        <div class="ru-panel-title-wrap">
                            <div class="ru-panel-icon ru-icon-green">
                                <i class="bi bi-pie-chart-fill"></i>
                            </div>
                            <div>
                                <h3 class="ru-panel-title">Statistik Konfirmasi Kehadiran</h3>
                                <p class="ru-panel-subtitle">Perbandingan status respon tamu dari seluruh undangan</p>
                            </div>
                        </div>

                        <div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 small">
                                Total: {{ $totalGuests ?? 0 }} Respon
                            </span>
                        </div>
                    </div>

                    <div class="p-4">
                        @if(($totalGuests ?? 0) > 0)
                            <div class="row align-items-center">
                                <div class="col-12 col-sm-6 mb-3 mb-sm-0" style="position: relative; height: 230px;">
                                    <canvas id="rsvpAnalyticsChart"></canvas>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="d-flex flex-column gap-3">
                                        <div class="p-3 rounded-3 border" style="background-color: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2) !important;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #10B981; display: inline-block;"></span>
                                                    <span class="small font-weight-bold">Konfirmasi Hadir</span>
                                                </div>
                                                <span class="fw-bold text-success">{{ $rsvpYes ?? 0 }} Tamu</span>
                                            </div>
                                            <div class="small text-muted mt-1">{{ $attendanceRate }}% dari total respon</div>
                                        </div>

                                        <div class="p-3 rounded-3 border" style="background-color: rgba(239, 68, 68, 0.05); border-color: rgba(239, 68, 68, 0.2) !important;">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #EF4444; display: inline-block;"></span>
                                                    <span class="small font-weight-bold">Berhalangan Hadir</span>
                                                </div>
                                                <span class="fw-bold text-danger">{{ $rsvpNo ?? 0 }} Tamu</span>
                                            </div>
                                            <div class="small text-muted mt-1">{{ round((($rsvpNo ?? 0) / max($totalGuests, 1)) * 100) }}% dari total respon</div>
                                        </div>

                                        @if(($rsvpMaybe ?? 0) > 0)
                                            <div class="p-3 rounded-3 border" style="background-color: rgba(245, 158, 11, 0.05); border-color: rgba(245, 158, 11, 0.2) !important;">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span style="width: 12px; height: 12px; border-radius: 50%; background: #F59E0B; display: inline-block;"></span>
                                                        <span class="small font-weight-bold">Masih Ragu</span>
                                                    </div>
                                                    <span class="fw-bold text-warning-emphasis">{{ $rsvpMaybe }} Tamu</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="ru-empty-box py-4">
                                <div class="ru-empty-icon ru-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                    <i class="bi bi-pie-chart"></i>
                                </div>
                                <h5 class="ru-empty-title">Data RSVP Belum Tersedia</h5>
                                <p class="ru-empty-desc mb-0">Grafik perbandingan akan terisi secara otomatis setelah tamu merespon undangan.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- GRAFIK TEMPLATE TERPOPULER (VIEWS) --}}
            <div class="col-12 col-lg-6">
                <div class="ru-panel-card">
                    <div class="ru-panel-header">
                        <div class="ru-panel-title-wrap">
                            <div class="ru-panel-icon ru-icon-gold">
                                <i class="bi bi-bar-chart-fill"></i>
                            </div>
                            <div>
                                <h3 class="ru-panel-title">Template Terpopuler</h3>
                                <p class="ru-panel-subtitle">Tema dengan jumlah pengunjung & dilihat terbanyak</p>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('tema.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 font-weight-medium">
                                Katalog Tema <i class="bi bi-arrow-right small ms-1"></i>
                            </a>
                        </div>
                    </div>

                    <div class="p-4">
                        @if(($topTemplates ?? collect())->count() > 0)
                            <div style="position: relative; height: 230px;">
                                <canvas id="popularTemplatesChart"></canvas>
                            </div>
                        @else
                            <div class="ru-empty-box py-4">
                                <div class="ru-empty-icon ru-icon-gold" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                    <i class="bi bi-palette"></i>
                                </div>
                                <h5 class="ru-empty-title">Data Pengunjung Belum Tersedia</h5>
                                <p class="ru-empty-desc mb-0">Statistik tayangan template akan tampil saat ada kunjungan ke halaman demo tema.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- ================================================================
             5. QUICK MANAGEMENT TILES (SHORTCUTS)
        ================================================================ --}}
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-xl-3">
                <a href="{{ route('invitation.index') }}" class="ru-quick-tile">
                    <div class="ru-quick-tile-icon ru-icon-gold">
                        <i class="bi bi-gem"></i>
                    </div>
                    <div>
                        <h4 class="ru-quick-tile-title">Kelola Pasangan</h4>
                        <p class="ru-quick-tile-desc">Manajemen data dan link undangan</p>
                    </div>
                    <i class="bi bi-chevron-right ru-quick-tile-arrow"></i>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <a href="{{ route('music.index') }}" class="ru-quick-tile">
                    <div class="ru-quick-tile-icon ru-icon-purple">
                        <i class="bi bi-music-note-list"></i>
                    </div>
                    <div>
                        <h4 class="ru-quick-tile-title">Pustaka Musik</h4>
                        <p class="ru-quick-tile-desc">Kelola lagu & audio latar pernikahan</p>
                    </div>
                    <i class="bi bi-chevron-right ru-quick-tile-arrow"></i>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <a href="{{ route('tema.index') }}" class="ru-quick-tile">
                    <div class="ru-quick-tile-icon ru-icon-blue">
                        <i class="bi bi-palette"></i>
                    </div>
                    <div>
                        <h4 class="ru-quick-tile-title">Katalog Tema</h4>
                        <p class="ru-quick-tile-desc">Eksplorasi dan pratinjau tema desain</p>
                    </div>
                    <i class="bi bi-chevron-right ru-quick-tile-arrow"></i>
                </a>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <a href="{{ route('invitation.import-kontak') }}" class="ru-quick-tile">
                    <div class="ru-quick-tile-icon ru-icon-green">
                        <i class="bi bi-file-earmark-spreadsheet"></i>
                    </div>
                    <div>
                        <h4 class="ru-quick-tile-title">Buku Tamu & Kontak</h4>
                        <p class="ru-quick-tile-desc">Import daftar tamu & generator link</p>
                    </div>
                    <i class="bi bi-chevron-right ru-quick-tile-arrow"></i>
                </a>
            </div>
        </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDarkMode = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                const textColor = isDarkMode ? '#CBD5E1' : '#475569';
                const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.08)' : 'rgba(27, 42, 74, 0.06)';

                // 1. Chart Rasio Kehadiran (Doughnut)
                const rsvpCanvas = document.getElementById('rsvpAnalyticsChart');
                if (rsvpCanvas) {
                    const rsvpData = [
                        {{ $rsvpYes ?? 0 }},
                        {{ $rsvpNo ?? 0 }}
                        @if(($rsvpMaybe ?? 0) > 0), {{ $rsvpMaybe }}@endif
                    ];
                    const rsvpLabels = ['Hadir', 'Berhalangan'@if(($rsvpMaybe ?? 0) > 0), 'Ragu'@endif];
                    const rsvpColors = ['#10B981', '#EF4444'@if(($rsvpMaybe ?? 0) > 0), '#F59E0B'@endif];

                    new Chart(rsvpCanvas, {
                        type: 'doughnut',
                        data: {
                            labels: rsvpLabels,
                            datasets: [{
                                data: rsvpData,
                                backgroundColor: rsvpColors,
                                borderWidth: 3,
                                borderColor: isDarkMode ? '#111827' : '#FFFFFF',
                                hoverOffset: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '72%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    padding: 12,
                                    boxPadding: 6,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function (context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const value = context.parsed;
                                            const pct = total > 0 ? Math.round((value / total) * 100) : 0;
                                            return ` ${context.label}: ${value} tamu (${pct}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // 2. Chart Template Terpopuler (Bar Chart)
                const templateCanvas = document.getElementById('popularTemplatesChart');
                if (templateCanvas) {
                    const templateNames = {!! json_encode(($topTemplates ?? collect())->pluck('name')->values()) !!};
                    const templateViews = {!! json_encode(($topTemplates ?? collect())->pluck('views_count')->values()) !!};

                    new Chart(templateCanvas, {
                        type: 'bar',
                        data: {
                            labels: templateNames,
                            datasets: [{
                                label: 'Jumlah Dilihat',
                                data: templateViews,
                                backgroundColor: '#C6A962',
                                hoverBackgroundColor: '#A68B4B',
                                borderRadius: 8,
                                barThickness: 28,
                                maxBarThickness: 40
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    padding: 12,
                                    boxPadding: 6,
                                    cornerRadius: 8
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: textColor,
                                        font: {
                                            family: "'Plus Jakarta Sans', sans-serif",
                                            size: 11
                                        }
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: gridColor
                                    },
                                    ticks: {
                                        color: textColor,
                                        precision: 0,
                                        font: {
                                            family: "'Inter', sans-serif",
                                            size: 11
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // 3. Tombol Salin Link Cepat
                document.querySelectorAll('.copy-invitation-link').forEach(button => {
                    button.addEventListener('click', function () {
                        const url = this.getAttribute('data-url');
                        if (!url) return;

                        navigator.clipboard.writeText(url).then(() => {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Link Berhasil Disalin!',
                                    text: url,
                                    timer: 1800,
                                    showConfirmButton: false,
                                    toast: true,
                                    position: 'top-end'
                                });
                            } else {
                                alert('Link berhasil disalin: ' + url);
                            }
                        }).catch(err => {
                            console.error('Gagal menyalin:', err);
                        });
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
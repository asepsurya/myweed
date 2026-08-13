<x-app-layout>
    @php
        // Logika Sapaan Dinamis
        $hour = now()->format('H');
        if ($hour < 11) {
            $greeting = 'Selamat Pagi';
            $greetingIcon = 'bi-sunrise-fill';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
            $greetingIcon = 'bi-brightness-high-fill';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
            $greetingIcon = 'bi-sunset-fill';
        } else {
            $greeting = 'Selamat Malam';
            $greetingIcon = 'bi-moon-stars-fill';
        }
    @endphp


    <style>
        /* ============================================= 
           1. VARIABLES & FONTS (Tema Gold/Navy)
        ============================================= */
        .dashboard-page {
            --primary: #C6A962;
            --primary-dark: #A68B4B;
            --primary-light: #F9F5EB;
            --secondary: #1B2A4A;
            --success: #16A34A;
            --success-light: #F0FDF4;
            --danger: #DC2626;
            --danger-light: #FEF2F2;
            --warning: #F59E0B;
            --bg-body: #F7F5F2;
            --bg-card: #FFFFFF;
            --border: #E8E4DE;
            --text-dark: #1B2A4A;
            --text-muted: #6B7280;
            --font-title: 'Plus Jakarta Sans', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        /* DARK MODE OVERRIDES */
        [data-bs-theme="dark"] .dashboard-page {
            --bg-body: #0B0F19;
            --bg-card: #111827;
            --border: rgba(255, 255, 255, 0.1);
            --text-dark: #F1F5F9;
            --text-muted: #94A3B8;
            --primary-light: rgba(198, 169, 98, 0.1);
            --success-light: rgba(22, 163, 74, 0.1);
            --danger-light: rgba(220, 38, 38, 0.1);
        }

        /* ============================================= 
           2. HEADER
        ============================================= */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            margin-bottom: 24px;

            position: relative;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), transparent);
            border-radius: 1px;
            opacity: 0.8;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(198, 169, 98, 0.3);
        }

        .dashboard-title {
            font-family: var(--font-title);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-dark);
            line-height: 1.2;
            margin: 0;
        }

        .dashboard-subtitle {
            font-family: var(--font-body);
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--secondary), #2A3F6A);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(27, 42, 74, 0.2);
        }

        [data-bs-theme="dark"] .btn-create {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--bg-card);
        }

        .btn-create:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(27, 42, 74, 0.3);
            color: #fff;
            text-decoration: none;
        }

        /* ============================================= 
           3. STAT CARDS & SCROLL
        ============================================= */
        .stats-scroll {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 15px;
            margin-bottom: -5px;
            scroll-snap-type: x mandatory;
        }

        .stats-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .stats-scroll::-webkit-scrollbar-track {
            background: var(--bg-body);
            border-radius: 10px;
        }

        .stats-scroll::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
            border: 2px solid var(--bg-body);
        }

        .stats-scroll::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        .stats-scroll {
            scrollbar-width: thin;
            scrollbar-color: var(--primary) var(--bg-body);
        }

        .stats-row {
            display: flex;
            flex-wrap: nowrap;
            gap: 1rem;
            width: max-content;
        }

        .stat-item {
            flex: 0 0 240px;
            width: 240px;
            scroll-snap-align: start;
        }

        @media (min-width: 992px) {
            .stat-item {
                flex: 0 0 calc((100vw - 320px) / 4);
                width: calc((100vw - 320px) / 4);
                max-width: 300px;
            }
        }

        .stat-card {
            background: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            border-radius: 16px !important;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        [data-bs-theme="dark"] .stat-card {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 98, 0.4) !important;
        }

        [data-bs-theme="dark"] .stat-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border-color: var(--primary) !important;
        }

        .stat-card .card-body {
            padding: 1.25rem;
            text-align: center;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            margin: 0 auto 12px;
        }

        .stat-icon.blue {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .stat-icon.green {
            background: var(--success-light);
            color: var(--success);
        }

        .stat-icon.red {
            background: var(--danger-light);
            color: var(--danger);
        }

        .stat-icon.pink {
            background: #FDF2F8;
            color: #DB2777;
        }

        .stat-icon.teal {
            background: #F0FDFA;
            color: #0D9488;
        }

        [data-bs-theme="dark"] .stat-icon.pink {
            background: rgba(219, 39, 119, 0.1);
        }

        [data-bs-theme="dark"] .stat-icon.teal {
            background: rgba(13, 148, 136, 0.1);
        }

        .stat-number {
            font-family: var(--font-title);
            font-weight: 700;
            font-size: 1.75rem;
            color: var(--text-dark);
            line-height: 1;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .stat-label {
            font-family: var(--font-body);
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            margin: 0;
        }

        /* ============================================= 
           4. SECTION CARDS
        ============================================= */
        .section-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        [data-bs-theme="dark"] .section-card {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .section-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .section-icon.blue {
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .section-icon.purple {
            background: #F3E8FF;
            color: #7C3AED;
        }

        [data-bs-theme="dark"] .section-icon.purple {
            background: rgba(124, 58, 237, 0.1);
            color: #A78BFA;
        }

        .section-title {
            font-family: var(--font-title);
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
            margin: 0;
            flex: 1;
        }

        .section-count {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            background: var(--bg-body);
            padding: 2px 8px;
            border-radius: 10px;
        }

        /* ============================================= 
           5. INVITATION LIST
        ============================================= */
        .invite-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            transition: all 0.2s ease;
            gap: 16px;
        }

        .invite-item:last-child {
            border-bottom: none;
        }

        .invite-item:hover {
            background-color: var(--bg-body);
        }

        .invite-avatar {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--border);
        }

        .invite-avatar.placeholder {
            background: linear-gradient(135deg, var(--primary-light), #E8D5A3);
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1rem;
        }

        .invite-info {
            flex: 1;
            min-width: 0;
        }

        .invite-name {
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .invite-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 5px;
            margin: 0;
        }

        .invite-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-preview,
        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-preview {
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-dark);
        }

        .btn-preview:hover {
            border-color: var(--secondary);
            background: var(--secondary);
            color: #fff;
            text-decoration: none;
        }

        .btn-edit {
            border: 1px solid var(--primary);
            background: var(--primary-light);
            color: var(--primary-dark);
        }

        .btn-edit:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            text-decoration: none;
        }

        /* ============================================= 
           6. RSVP ACTIVITY
        ============================================= */
        .activity-item {
            display: flex;
            align-items: flex-start;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            gap: 12px;
            transition: background 0.2s ease;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-item:hover {
            background: var(--bg-body);
        }

        .activity-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--border);
        }

        .activity-avatar.placeholder {
            background: linear-gradient(135deg, #E0E7FF, #C7D2FE);
            color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .activity-info {
            flex: 1;
            min-width: 0;
        }

        .activity-name {
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-dark);
            margin-bottom: 2px;
        }

        .activity-meta {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin: 0;
        }

        .activity-meta a {
            color: var(--primary-dark);
            text-decoration: none;
        }

        .activity-meta a:hover {
            text-decoration: underline;
        }

        .badge-hadir,
        .badge-tidak {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 20px;
        }

        .badge-hadir {
            background: var(--success-light);
            color: var(--success);
        }

        .badge-tidak {
            background: var(--danger-light);
            color: var(--danger);
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-hadir .badge-dot {
            background: var(--success);
        }

        .badge-tidak .badge-dot {
            background: var(--danger);
        }

        /* ============================================= 
           7. EMPTY STATE
        ============================================= */
        .empty-state {
            padding: 40px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--bg-body);
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin: 0 auto 12px;
        }

        .empty-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.5;
        }

        /* ============================================= 
           8. RESPONSIVE
        ============================================= */
        @media (max-width: 767.98px) {

            .dashboard-header {
                display: none !important;
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .btn-create {
                width: 100%;
                justify-content: center;
            }

            .invite-avatar {
                display: none;
            }
        }

        .dashboard-header {
            width: 100%;
        }

        .dashboard-header .min-w-0 {
            min-width: 0;
        }

        .dashboard-title {
            font-size: 1.5rem;
            line-height: 1.2;
        }

        .dashboard-subtitle {
            font-size: .9rem;
            opacity: .65;
        }

        .dashboard-action .btn {
            white-space: nowrap;
        }

        /* Mobile */
        @media (max-width: 576px) {

            .dashboard-header {
                gap: .5rem !important;
            }

            .header-icon {
                width: 38px;
                height: 38px;
                min-width: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .dashboard-title {
                font-size: 1rem;
                line-height: 1.25;
                margin: 0;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .dashboard-subtitle {
                font-size: .68rem;
                line-height: 1.3;
                margin-top: 2px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .dashboard-action .btn {
                width: 38px;
                height: 38px;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .dashboard-action .btn i {
                margin: 0 !important;
                font-size: 1rem;
            }

            .dashboard-action .btn span {
                display: none;
            }
        }
    </style>

    <div class="container mt-4 dashboard-page" id="main-content">
        <div class="dashboard-header d-flex align-items-center justify-content-between gap-2 mb-3">

            <!-- Greeting -->
            <div class="d-flex align-items-center gap-2 min-w-0">
                <div class="header-icon flex-shrink-0">
                    <i class="bi {{ $greetingIcon }}"></i>
                </div>

                <div class="min-w-0">
                    <h2 class="dashboard-title mb-1">
                        {{ $greeting }}, {{ auth()->user()->name }}! 👋
                    </h2>

                    <p class="dashboard-subtitle mb-0">
                        Selamat datang kembali di Wedding Dashboard
                    </p>
                </div>
            </div>

            <!-- Tombol -->
            <div class="dashboard-action flex-shrink-0">
                <a href="{{ route('invitation.create') }}" class="btn-create">
                    <i class="bi bi-plus-lg"></i>
                    <span>Buat Undangan</span>
                </a>
            </div>

        </div>



        <div class="row g-3">

            {{-- ============================================== --}}
            {{-- STAT CARDS --}}
            {{-- ============================================== --}}
            <div class="col-12">
                <div class="stats-scroll">
                    <div class="stats-row">
                        <!-- Total Undangan -->
                        <div class="stat-item">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <div class="stat-icon blue">
                                        <i class="bi bi-envelope-heart-fill"></i>
                                    </div>
                                    <div class="stat-number">{{ $totalInvitations ?? 0 }}</div>
                                    <div class="stat-label">Total Undangan</div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Tamu -->
                        <div class="stat-item">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <div class="stat-icon green">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div class="stat-number">{{ $totalGuests ?? 0 }}</div>
                                    <div class="stat-label">Total Tamu</div>
                                </div>
                            </div>
                        </div>

                        <!-- RSVP Hadir -->
                        <div class="stat-item">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <div class="stat-icon green">
                                        <i class="bi bi-check-circle-fill"></i>
                                    </div>
                                    <div class="stat-number">{{ $rsvpYes ?? 0 }}</div>
                                    <div class="stat-label">RSVP Hadir</div>
                                </div>
                            </div>
                        </div>

                        <!-- Tidak Hadir -->
                        <div class="stat-item">
                            <div class="card stat-card h-100">
                                <div class="card-body">
                                    <div class="stat-icon red">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </div>
                                    <div class="stat-number">{{ $rsvpNo ?? 0 }}</div>
                                    <div class="stat-label">Tidak Hadir</div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Lagu -->
                        <div class="stat-item">
                            <a href="{{ route('music.index') }}" class="text-decoration-none d-block h-100">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="stat-icon pink">
                                            <i class="bi bi-music-note-list"></i>
                                        </div>
                                        <div class="stat-number">{{ $totalMusic ?? 0 }}</div>
                                        <div class="stat-label">Total Lagu</div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <!-- Lagu Aktif -->
                        <div class="stat-item">
                            <a href="{{ route('music.index') }}" class="text-decoration-none d-block h-100">
                                <div class="card stat-card h-100">
                                    <div class="card-body">
                                        <div class="stat-icon teal">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                        <div class="stat-number">{{ $activeMusic ?? 0 }}</div>
                                        <div class="stat-label">Lagu Aktif</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================== --}}
            {{-- DAFTAR UNDANGAN --}}
            {{-- ============================================== --}}
            <div class="col-12 col-lg-8">
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon blue">
                            <i class="bi bi-envelope-heart-fill"></i>
                        </div>
                        <h5 class="section-title">Daftar Undangan</h5>
                        <span class="section-count">{{ $invitations->count() }}</span>
                    </div>

                    @if($invitations->count() > 0)
                        <div>
                            @foreach($invitations as $inv)
                                <div class="invite-item">
                                    @if($inv->gallery_cover)
                                        <img src="{{ storage_url($inv->gallery_cover, $inv->updated_at->timestamp) }}" alt="Cover" class="invite-avatar"
                                            loading="lazy">
                                    @else
                                        <div class="invite-avatar placeholder">
                                            {{ strtoupper(substr($inv->bride_nickname ?? 'B', 0, 1)) }}{{ strtoupper(substr($inv->groom_nickname ?? 'P', 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="invite-info">
                                        <div class="invite-name">
                                            {{ $inv->bride_name }} & {{ $inv->groom_name }}
                                        </div>
                                        <div class="invite-date">
                                            <i class="bi bi-calendar3"></i>
                                            {{ \Carbon\Carbon::parse($inv->wedding_date)->locale('id')->translatedFormat('d M Y') }}
                                        </div>
                                    </div>

                                    <div class="invite-actions">
                                        <a href="{{ url($inv->slug) }}" target="_blank" class="btn-preview">
                                            <i class="bi bi-eye"></i>
                                            <span>Preview</span>
                                        </a>
                                        <a href="{{ route('invitation.edit', $inv) }}" class="btn-edit">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Edit</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <p class="empty-text">Belum ada undangan.<br>Buat undangan pertama Anda untuk memulai di sini.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ============================================== --}}
            {{-- AKTIVITAS RSVP --}}
            {{-- ============================================== --}}
            <div class="col-12 col-lg-4">
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon purple">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <h5 class="section-title">Aktivitas RSVP</h5>
                        <span class="section-count">{{ $recentRsvps->count() }}</span>
                    </div>

                    @if($recentRsvps->count() > 0)
                        <div>
                            @foreach($recentRsvps as $rsvp)
                                <div class="activity-item">
                                    @if($rsvp->guest_avatar)
                                        <img src="{{ asset('storage/' . $rsvp->guest_avatar) }}" alt="Avatar"
                                            class="activity-avatar" loading="lazy">
                                    @else
                                        <div class="activity-avatar placeholder">
                                            {{ strtoupper(substr($rsvp->guest_name ?? 'T', 0, 1)) }}
                                        </div>
                                    @endif

                                    <div class="activity-info">
                                        <div class="activity-name">{{ $rsvp->guest_name }}</div>
                                        <div class="activity-meta">
                                            <a href="{{ url($rsvp->invitation->slug) }}" target="_blank">
                                                {{ $rsvp->invitation->bride_name }} & {{ $rsvp->invitation->groom_name }}
                                            </a>
                                            · {{ $rsvp->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <div>
                                        @if($rsvp->status == 'hadir')
                                            <span class="badge-hadir"><span class="badge-dot"></span>Hadir</span>
                                        @else
                                            <span class="badge-tidak"><span class="badge-dot"></span>Tidak</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-chat-square-text"></i>
                            </div>
                            <p class="empty-text">Belum ada aktivitas RSVP.<br>RSVP tamu akan muncul di sini secara
                                real-time.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
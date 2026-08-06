<x-app-layout>
    <x-slot name="header">
        <div class="dashboard-header">
            <div>
                <div class="d-flex align-items-center gap-3 mb-2">
                    <div class="header-icon">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <div>
                        <h2 class="dashboard-title">Wedding Dashboard</h2>
                        <p class="dashboard-subtitle">Kelola undangan dan aktivitas Anda</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('invitation.create') }}" class="btn-create">
                <i class="bi bi-plus-lg"></i>
                <span>Buat Undangan</span>
            </a>
        </div>
    </x-slot>

    <style>
        /* ============================================= 
           1. VARIABLES
        ============================================= */
        :root {
            --primary: #7c3aed;
            --primary-dark: #6d28d9;
            --primary-light: #ede9fe;
            --secondary: #64748b;
            --success: #10b981;
            --success-light: #d1fae5;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --warning: #f59e0b;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --border: #e2e8f0;
            --text-dark: #1e293b;
            --text-muted: #94a3b8;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.07), 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 25px -3px rgba(0, 0, 0, 0.08), 0 20px 50px -5px rgba(0, 0, 0, 0.04);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-xs: 6px;
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
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--warning), var(--primary));
            border-radius: 1px;
            opacity: 0.6;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
        }

        .dashboard-title {
            font-family: 'Lexend', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-dark);
            line-height: 1.2;
            margin: 0;
        }

        .dashboard-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 2px 0 0;
        }

        .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);
        }

        .btn-create:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(124, 58, 237, 0.35);
            color: #fff;
            text-decoration: none;
        }

        /* ============================================= 
           3. STAT CARDS
        ============================================= */
       

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            border-color: transparent;
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
            position: relative;
        }

        .stat-icon::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 17px;
            opacity: 0.15;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            color: var(--primary);
        }
        .stat-icon.blue::after { background: var(--primary); }

        .stat-icon.green {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: var(--success);
        }
        .stat-icon.green::after { background: var(--success); }

        .stat-icon.emerald {
            background: linear-gradient(135deg, #d1fae5, #6ee7b7);
            color: #059669;
        }
        .stat-icon.emerald::after { background: #059669; }

        .stat-icon.red {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: var(--danger);
        }
        .stat-icon.red::after { background: var(--danger); }

        .stat-number {
            font-family: 'Lexend', sans-serif;
            font-weight: 700;
            font-size: 1.75rem;
         
            line-height: 1;
            margin-bottom: 2px;
            letter-spacing: -0.5px;
        }

        .stat-label {
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
            border-radius: var(--radius);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .section-card:hover {
            box-shadow: var(--shadow-md);
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
            color: var(--primary);
        }

        .section-icon.purple {
            background: #f3e8ff;
            color: #7c3aed;
        }

        .section-title {
            font-family: 'Lexend', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
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
            background: linear-gradient(135deg, var(--primary-light), #ddd6fe);
            color: var(--primary);
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
            font-weight: 600;
            font-size: 0.9rem;
         
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

        .invite-date i {
            font-size: 0.7rem;
        }

        .invite-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .btn-preview {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: var(--radius-xs);
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-preview:hover {
            border-color: var(--primary-light);
            background: var(--primary-light);
            color: var(--primary);
            text-decoration: none;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 500;
            border-radius: var(--radius-xs);
            border: 1px solid var(--primary-light);
            background: var(--bg-card);
            color: var(--primary);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            white-space: nowrap;
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
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: var(--primary);
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
            color: var(--primary);
            text-decoration: none;
        }

        .activity-meta a:hover {
            text-decoration: underline;
        }

        .badge-hadir {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 20px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #059669;
        }

        .badge-tidak {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 20px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        /* Dot indicator */
        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-hadir .badge-dot { background: #059669; }
        .badge-tidak .badge-dot { background: #dc2626; }

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
           8. ANIMATIONS
        ============================================= */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .stat-card,
        .section-card,
        .invite-item,
        .activity-item {
            animation: fadeInUp 0.4s ease-out both;
        }

        .stat-card:nth-child(1) { animation-delay: 0ms; }
        .stat-card:nth-child(2) { animation-delay: 60ms; }
        .stat-card:nth-child(3) { animation-delay: 120ms; }
        .stat-card:nth-child(4) { animation-delay: 180ms; }
        .section-card:nth-child(1) { animation-delay: 100ms; }
        .section-card:nth-child(2) { animation-delay: 150ms; }

        .invite-item:nth-child(1) { animation-delay: 200ms; }
        .invite-item:nth-child(2) { animation-delay: 220ms; }
        .invite-item:nth-child(3) { animation-delay: 240ms; }
        .invite-item:nth-child(4) { animation-delay: 260ms; }
        .invite-item:nth-child(5) { animation-delay: 280ms; }

        .activity-item:nth-child(1) { animation-delay: 200ms; }
        .activity-item:nth-child(2) { animation-delay: 220ms; }
        .activity-item:nth-child(3) { animation-delay: 240ms; }
        .activity-item:nth-child(4) { animation-delay: 260ms; }
        .activity-item:nth-child(5) { animation-delay: 280ms; }

        @media (prefers-reduced-motion: reduce) {
            .stat-card, .section-card, .invite-item, .activity-item {
                animation: none;
            }
        }

        /* ============================================= 
           9. RESPONSIVE
        ============================================= */
        @media (max-width: 991.98px) {
            .stat-card .card-body { padding: 1rem; }
            .stat-icon { width: 46px; height: 46px; font-size: 1.2rem; border-radius: 12px; }
            .stat-number { font-size: 1.5rem; }
        }

        @media (max-width: 767.98px) {
            .dashboard-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding-bottom: 16px;
            }

            .btn-create {
                width: 100%;
                justify-content: center;
                padding: 12px 20px;
                font-size: 1rem;
            }

            .dashboard-title {
                font-size: 1.25rem;
            }

            .dashboard-subtitle {
                font-size: 0.8rem;
            }

            .stat-card .card-body {
                padding: 1rem;
            }

            .stat-icon {
                width: 44px;
                height: 44px;
                font-size: 1.2rem;
                border-radius: 12px;
                margin-bottom: 8px;
            }

            .stat-number {
                font-size: 1.4rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }

            .invite-item {
                flex-wrap: wrap;
                gap: 10px;
                padding: 12px 16px;
            }

            .invite-actions {
                width: 100%;
                display: flex;
                gap: 8px;
            }

            .invite-actions .btn-preview,
            .invite-actions .btn-edit {
                flex: 1;
                justify-content: center;
                padding: 10px 12px;
                font-size: 0.85rem;
            }

            .invite-avatar,
            .activity-avatar {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .stat-card .card-body {
                padding: 0.875rem;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
                margin-bottom: 6px;
            }

            .stat-number {
                font-size: 1.2rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .invite-item {
                padding: 10px 12px;
            }

            .invite-name {
                font-size: 0.85rem;
            }

            .invite-date {
                font-size: 0.75rem;
            }
        }
    </style>

    <div class="container mt-4" id="main-content">
        <div class="row g-3">

            {{-- ============================================== --}}
            {{-- STAT CARDS                               --}}
            {{-- ============================================== --}}
            <div class="col-6 col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon blue">
                            <i class="bi bi-envelope-heart-fill"></i>
                        </div>
                        <div class="stat-number">{{ $totalInvitations ?? 3 }}</div>
                        <div class="stat-label">Total Undangan</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon green">
                            <i class="bi-people-fill"></i>
                        </div>
                        <div class="stat-number">{{ $totalGuests ?? 120 }}</div>
                        <div class="stat-label">Total Tamu</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon emerald">
                            <i class="bi-check-circle-fill"></i>
                        </div>
                        <div class="stat-number">{{ $rsvpYes ?? 75 }}</div>
                        <div class="stat-label">RSVP Hadir</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-6 col-lg-3">
                <div class="card stat-card">
                    <div class="card-body">
                        <div class="stat-icon red">
                            <i class="bi-x-circle-fill"></i>
                        </div>
                        <div class="stat-number">{{ $rsvpNo ?? 20 }}</div>
                        <div class="stat-label">Tidak Hadir</div>
                    </div>
                </div>
            </div>

            {{-- ============================================== --}}
            {{-- DAFTAR UNDANGAN                         --}}
            {{-- ============================================== --}}
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="section-header">
                        <div class="section-icon blue">
                            <i class="bi-envelope-heart-fill"></i>
                        </div>
                        <h5 class="">Daftar Undangan</h5>
                        <span class="section-count">{{ $invitations->count() }}</span>
                    </div>

                    @if($invitations->count() > 0)
                    <div>
                        @foreach($invitations as $inv)
                        <div class="invite-item">
                            @if($inv->gallery_cover)
                                <img src="{{ '/storage/' . $inv->gallery_cover }}" alt="" class="invite-avatar" loading="lazy">
                            @else
                                <div class="invite-avatar placeholder">
                                    {{ substr($inv->bride_nickname ?? 'B', 0, 1) }}{{ substr($inv->groom_nickname ?? 'P', 0, 1) }}
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
                                <i class="bi-inbox"></i>
                            </div>
                            <p class="empty-text">Belum ada undangan.<br>Buat undangan pertama Anda untuk memulai di sini.</p>
                        </div>
                    @endif
                </div>
            </div>


            <!-- AKTIVITAS RSVP -->
   
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="section-header">
                        <div class="section-icon purple">
                            <i class="bi-chat-dots-fill"></i>
                        </div>
                        <h5 class="">Aktivitas RSVP</h5>
                        <span class="section-count">{{ $recentRsvps->count() }}</span>
                    </div>

                    @if($recentRsvps->count() > 0)
                    <div>
                        @foreach($recentRsvps as $rsvp)
                        <div class="activity-item">
                            @if($rsvp->guest_avatar)
                                <img src="{{ '/storage/' . $rsvp->guest_avatar }}" alt="" class="activity-avatar" loading="lazy">
                            @else
                                <div class="activity-avatar placeholder">
                                    {{ substr($rsvp->guest_name ?? 'T', 0, 1) }}
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
                                <i class="bi-chat-square-text"></i>
                            </div>
                            <p class="empty-text">Belum ada aktivitas RSVP.<br>RSVP tamu akan muncul di sini secara real-time.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
@auth
    <div class="adminuiux-sidebar">
        <div class="adminuiux-sidebar-inner">
            <!-- Brand & Profile Area -->
            <div class="px-3 not-iconic mt-3 mb-2">
                <div class="d-flex align-items-center justify-content-between p-2 rounded-3"
                    style="background: rgba(198, 169, 98, 0.08); border: 1px solid rgba(198, 169, 98, 0.2);">
                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                        <img src="{{ asset('assets/fav-icon.png') }}" alt="Logo RuangUndang"
                            style="width: 32px; height: 32px; object-fit: contain;" class="flex-shrink-0">
                        <div class="overflow-hidden">
                            <h6 class="mb-0 fw-bold text-truncate"
                                style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 0.9rem; color: var(--adminuiux-text);">
                                RuangUndang</h6>
                            <small class="text-muted d-block text-truncate" style="font-size: 0.7rem;">Dashboard
                                Panel</small>
                        </div>
                    </div>
                    <a class="btn btn-sm btn-link text-muted p-1" data-bs-toggle="collapse"
                        data-bs-target="#usersidebarprofile" aria-expanded="false" role="button"
                        aria-controls="usersidebarprofile" title="Profil Singkat">
                        <i class="bi bi-person-circle fs-5" style="color: var(--adminuiux-theme-1, #C6A962);"></i>
                    </a>
                </div>
                <div class="text-center collapse pt-3 pb-2" id="usersidebarprofile">
                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow-sm"
                        style="width: 54px; height: 54px; background: rgba(198, 169, 98, 0.15); color: #C6A962; border: 2px solid #C6A962;">
                        <span class="fw-bold fs-5">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                    </div>
                    <h6 class="mb-0 fw-bold small text-truncate px-2">{{ auth()->user()->name }}</h6>
                    <small class="text-muted d-block text-truncate px-2 mb-2"
                        style="font-size: 0.72rem;">{{ auth()->user()->email }}</small>
                    <span class="badge rounded-pill"
                        style="background: rgba(198, 169, 98, 0.15); color: #A68B4B; font-size: 0.7rem; border: 1px solid rgba(198, 169, 98, 0.3);">
                        {{ auth()->user()->hasRole('admin') ? 'Administrator' : (auth()->user()->isPaidSubscribed() ? 'Member Premium' : 'Free Member') }}
                    </span>
                </div>
            </div>

            <ul class="nav flex-column menu-active-line">
                {{-- GRUP: NAVIGASI UTAMA --}}
                <li class="nav-item menu-group">
                    <span class="menu-group-label">Navigasi Utama</span>
                </li>

                @role('admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Admin Overview">
                        <i class="menu-icon bi bi-speedometer2 me-2"></i>
                        <span class="menu-name">Admin Overview</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('invitation.index') ? 'active' : '' }}"
                        href="{{ route('invitation.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Semua Undangan">
                        <i class="menu-icon bi bi-card-checklist me-2"></i>
                        <span class="menu-name">Semua Undangan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tempelate.*') ? 'active' : '' }}"
                        href="{{ route('tempelate.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Template Desain">
                        <i class="menu-icon bi bi-palette me-2"></i>
                        <span class="menu-name">Template Desain</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs(['music.*', 'youtube-music.*']) ? 'active' : '' }}"
                        href="{{ route('music.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Pustaka Musik">
                        <i class="menu-icon bi bi-music-note-beamed me-2"></i>
                        <span class="menu-name">Pustaka Musik</span>
                    </a>
                </li>
                @endrole

                {{-- USER MENU --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}"
                        href="{{ route('dashboard.user') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Undangan Saya">
                        <i class="menu-icon bi bi-heart-fill me-2 text-danger"></i>
                        <span class="menu-name">Undangan Saya</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard.saya') ? 'active' : '' }}"
                        href="{{ route('dashboard.saya') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Undangan Aktif">
                        <i class="menu-icon bi bi-broadcast me-2" style="color: var(--adminuiux-theme-1, #C6A962);"></i>
                        <span class="menu-name">Undangan Aktif</span>
                    </a>
                </li>

                {{-- GRUP: TAMU & INTERAKSI --}}
                <li class="nav-item menu-group">
                    <span class="menu-group-label">Tamu & Konfirmasi</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rsvp.index') ? 'active' : '' }}"
                        href="{{ route('rsvp.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="RSVP & Ucapan Tamu">
                        <i class="menu-icon bi bi-chat-heart me-2"></i>
                        <span class="menu-name">RSVP & Ucapan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('invitation.import-kontak') ? 'active' : '' }}"
                        href="{{ route('invitation.import-kontak') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Buku Tamu & Kontak">
                        <i class="menu-icon bi bi-person-lines-fill me-2"></i>
                        <span class="menu-name">Buku Tamu</span>
                    </a>
                </li>

                {{-- GRUP: PERENCANAAN & KEUANGAN --}}
                @if(auth()->user()->hasFeature('budget_management'))
                    <li class="nav-item menu-group">
                        <span class="menu-group-label">Perencanaan Acara</span>
                    </li>

                    @php 
                                                                                    $isWeddingPlannerActive = request()->routeIs(['weeding-plan.*', 'budget.*', 'savings.*', 'financial-overview.*']);
                        $isBudgetActive = request()->routeIs('budget.*');
                        $isSavingsActive = request()->routeIs('savings.*');
                    @endphp
                    <li class="nav-item">
                        <a href="#financeMenu" class="nav-link {{ $isWeddingPlannerActive ? 'active' : '' }}"
                            data-bs-toggle="collapse" aria-expanded="{{ $isWeddingPlannerActive ? 'true' : 'false' }}"
                            aria-controls="financeMenu" role="button">
                            <i class="menu-icon bi bi-journal-bookmark me-2"></i>
                            <span class="menu-name">Wedding Planner</span>
                            <i class="bi bi-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
                        </a>
                        <div class="collapse ps-3 {{ $isWeddingPlannerActive ? 'show' : '' }}" id="financeMenu">
                            <a href="{{ route('weeding-plan.index') }}"
                                class="nav-link ps-3 {{ request()->routeIs('weeding-plan.*') ? 'active' : '' }}">
                                <i class="menu-icon bi bi-check2-square me-2"></i>
                                <span class="menu-name">Rencana & Jadwal</span>
                            </a>

                            <a href="#budgetMenu" class="nav-link ps-3 {{ $isBudgetActive ? 'active' : '' }}"
                                data-bs-toggle="collapse" aria-expanded="{{ $isBudgetActive ? 'true' : 'false' }}"
                                aria-controls="budgetMenu" role="button">
                                <i class="menu-icon bi bi-calculator me-2"></i>
                                <span class="menu-name">Anggaran Biaya</span>
                                <i class="bi bi-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
                            </a>
                            <div class="collapse ps-3 {{ $isBudgetActive ? 'show' : '' }}" id="budgetMenu">
                                <a href="{{ route('budget.dashboard') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('budget.dashboard') ? 'active' : '' }}">
                                    <span class="menu-name">Ringkasan</span>
                                </a>
                                <a href="{{ route('budget.category.index') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('budget.category.*') ? 'active' : '' }}">
                                    <span class="menu-name">Kategori Pos</span>
                                </a>
                                <a href="{{ route('budget.expense.index') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('budget.expense.*') ? 'active' : '' }}">
                                    <span class="menu-name">Pengeluaran</span>
                                </a>
                                <a href="{{ route('budget.payment.index') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('budget.payment.*') ? 'active' : '' }}">
                                    <span class="menu-name">Pembayaran Vendor</span>
                                </a>
                            </div>

                            <a href="#savingsMenu" class="nav-link ps-3 {{ $isSavingsActive ? 'active' : '' }}"
                                data-bs-toggle="collapse" aria-expanded="{{ $isSavingsActive ? 'true' : 'false' }}"
                                aria-controls="savingsMenu" role="button">
                                <i class="menu-icon bi bi-piggy-bank me-2"></i>
                                <span class="menu-name">Tabungan Bersama</span>
                                <i class="bi bi-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
                            </a>
                            <div class="collapse ps-3 {{ $isSavingsActive ? 'show' : '' }}" id="savingsMenu">
                                <a href="{{ route('savings.dashboard') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('savings.dashboard') ? 'active' : '' }}">
                                    <span class="menu-name">Ringkasan</span>
                                </a>
                                <a href="{{ route('savings.goal.index') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('savings.goal.*') ? 'active' : '' }}">
                                    <span class="menu-name">Target Sasaran</span>
                                </a>
                                <a href="{{ route('savings.contributor.index') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('savings.contributor.*') ? 'active' : '' }}">
                                    <span class="menu-name">Kontributor</span>
                                </a>
                                <a href="{{ route('savings.contribution.index') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('savings.contribution.*') ? 'active' : '' }}">
                                    <span class="menu-name">Buku Setoran</span>
                                </a>
                                <a href="{{ route('savings.projection') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('savings.projection') ? 'active' : '' }}">
                                    <span class="menu-name">Proyeksi Dana</span>
                                </a>
                                <a href="{{ route('savings.automation.index') }}"
                                    class="nav-link ps-3 {{ request()->routeIs('savings.automation.*') ? 'active' : '' }}">
                                    <span class="menu-name">Otomatisasi</span>
                                </a>
                            </div>

                            <a href="{{ route('financial-overview.index') }}"
                                class="nav-link ps-3 {{ request()->routeIs('financial-overview.*') ? 'active' : '' }}">
                                <i class="menu-icon bi bi-graph-up-arrow me-2"></i>
                                <span class="menu-name">Ikhtisar Keuangan</span>
                            </a>
                        </div>
                    </li>
                @endif

                {{-- GRUP: PEMBAYARAN --}}
                @php
                    $isPaymentActive = request()->routeIs(['payments.status', 'payments.index']);
                @endphp
                <li class="nav-item">
                    <a class="nav-link {{ $isPaymentActive ? 'active' : '' }}" data-bs-toggle="collapse"
                        data-bs-target="#paymentMenu" aria-expanded="{{ $isPaymentActive ? 'true' : 'false' }}"
                        aria-controls="paymentMenu" role="button">
                        <i class="menu-icon bi bi-credit-card-2-front me-2"></i>
                        <span class="menu-name">Pembayaran</span>
                        @if(isset($pendingPaymentCount) && $pendingPaymentCount > 0)
                            <span class="badge bg-warning text-dark ms-auto me-2">{{ $pendingPaymentCount }}</span>
                        @endif
                        <i class="bi bi-chevron-down ms-auto" style="font-size: 0.75rem;"></i>
                    </a>
                    <div class="collapse ps-3 {{ $isPaymentActive ? 'show' : '' }}" id="paymentMenu">
                        <a href="{{ route('payments.status') }}"
                            class="nav-link ps-3 {{ request()->routeIs('payments.status') ? 'active' : '' }}">
                            <i class="menu-icon bi bi-hourglass-split me-2"></i>
                            <span class="menu-name">Status Pembayaran</span>
                        </a>
                        <a href="{{ route('payments.index') }}"
                            class="nav-link ps-3 {{ request()->routeIs('payments.index') ? 'active' : '' }}">
                            <i class="menu-icon bi bi-receipt me-2"></i>
                            <span class="menu-name">Riwayat Transaksi</span>
                        </a>
                    </div>
                </li>

                {{-- GRUP: ADMINISTRASI (ADMIN ONLY) --}}
                @role('admin')
                <li class="nav-item menu-group">
                    <span class="menu-group-label">Sistem & Master</span>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                        href="{{ route('admin.categories.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Kategori Undangan">
                        <i class="menu-icon bi bi-grid-1x2 me-2"></i>
                        <span class="menu-name">Kategori Undangan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}"
                        href="{{ route('user.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Kelola Pengguna">
                        <i class="menu-icon bi bi-people-fill me-2"></i>
                        <span class="menu-name">Pengguna</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('subscription-plans.*') ? 'active' : '' }}"
                        href="{{ route('subscription-plans.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Paket Berlangganan">
                        <i class="menu-icon bi bi-award me-2"></i>
                        <span class="menu-name">Paket Langganan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('coupons.*') ? 'active' : '' }}"
                        href="{{ route('coupons.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Kupon Diskon">
                        <i class="menu-icon bi bi-ticket-perforated me-2"></i>
                        <span class="menu-name">Kupon Diskon</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('promotions.*') ? 'active' : '' }}"
                        href="{{ route('promotions.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Promosi & Banner">
                        <i class="menu-icon bi bi-megaphone me-2"></i>
                        <span class="menu-name">Promosi & Banner</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}"
                        href="{{ route('admin.blogs.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Kelola Post Blog">
                        <i class="menu-icon bi bi-chat-dots me-2"></i>
                        <span class="menu-name">Post Blog</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                        href="{{ route('settings.env') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                        title="Pengaturan Sistem (.env)">
                        <i class="menu-icon bi bi-sliders me-2"></i>
                        <span class="menu-name">Pengaturan Sistem</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}" href="{{ route('logs.index') }}"
                        data-bs-toggle="tooltip" data-bs-placement="right" title="Log Aktivitas">
                        <i class="menu-icon bi bi-journal-code me-2"></i>
                        <span class="menu-name">Log Aktivitas</span>
                    </a>
                </li>
                @endrole
            </ul>
        </div>
    </div>
@endauth

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Tooltip Bootstrap pada sidebar
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('.adminuiux-sidebar [data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
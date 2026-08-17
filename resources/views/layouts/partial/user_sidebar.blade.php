<div class="adminuiux-sidebar">
    <div class="adminuiux-sidebar-inner">
        <!-- Profile -->
        <div class="px-3 not-iconic mt-3">
            <div class="row">
                <div class="col align-self-center">
                    <h6 class="fw-medium">Menu Saya</h6>
                </div>
                <div class="col-auto">
                    <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile"
                        aria-expanded="false" role="button" aria-controls="usersidebarprofile">
                        <i data-feather="user"></i>
                    </a>
                </div>
            </div>
            <div class="text-center collapse" id="usersidebarprofile">
                <figure class="avatar avatar-100 rounded-circle coverimg my-3">
                    <img src="{{ asset('assets/fav.png') }}" alt="Logo RuangUndang.id">
                </figure>
                <h5 class="mb-1 fw-medium">RuangUndang.id</h5>
                <p class="small text-muted">Make your moment unforgettable</p>
            </div>
        </div>

        <ul class="nav flex-column menu-active-line">
            @role('admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Dashboard">
                    <i class="menu-icon bi bi-columns-gap me-2"></i>
                    <span class="menu-name">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('invitation.index') ? 'active' : '' }}"
                    href="{{ route('invitation.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Daftar Pasangan">
                    <i class="menu-icon bi bi-gem me-2"></i>
                    <span class="menu-name">Daftar Pasangan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('music.index') ? 'active' : '' }}"
                    href="{{ route('music.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Music Library">
                    <i class="menu-icon bi bi-music-note-list me-2"></i>
                    <span class="menu-name">Music Library</span>
                </a>
            </li>
            @endrole

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}"
                    href="{{ route('dashboard.user') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Pasangan Saya">
                    <i class="menu-icon bi bi-heart me-2"></i>
                    <span class="menu-name">Pasangan Saya</span>
                </a>
            </li>

            @if(auth()->user()->hasFeature('budget_management'))
            <?php 
                // Cek apakah rute saat ini berada di dalam menu Wedding Planner
                $isWeddingPlannerActive = request()->routeIs(['weeding-plan.index', 'budget.dashboard', 'savings.dashboard', 'financial-overview.index']);
            ?>
            <li class="nav-item">
                <a class="nav-link " data-bs-toggle="collapse" data-bs-target="#financeMenu"
                    aria-expanded="{{ $isWeddingPlannerActive ? 'true' : 'false' }}" aria-controls="financeMenu"
                    role="button">
                    <i class="menu-icon bi bi-folder me-2"></i>
                    <span class="menu-name">Wedding Planner</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse ps-3 {{ $isWeddingPlannerActive ? 'show' : '' }}" id="financeMenu">
                    <a href="{{ route('weeding-plan.index') }}"
                        class="nav-link ps-4 {{ request()->routeIs('weeding-plan.index') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-calendar-check me-2"></i>
                        <span class="menu-name">Rencana</span>
                    </a>
                    <a href="{{ route('budget.dashboard') }}"
                        class="nav-link ps-4 {{ request()->routeIs('budget.dashboard') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-calculator me-2"></i>
                        <span class="menu-name">Anggaran</span>
                    </a>
                    <a href="{{ route('savings.dashboard') }}"
                        class="nav-link ps-4 {{ request()->routeIs('savings.dashboard') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-piggy-bank me-2"></i>
                        <span class="menu-name">Tabungan</span>
                    </a>
                    <a href="{{ route('financial-overview.index') }}"
                        class="nav-link ps-4 {{ request()->routeIs('financial-overview.index') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-bar-chart-line me-2"></i>
                        <span class="menu-name">Ikhtisar Keuangan</span>
                    </a>
                </div>
            </li>
            @endif

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rsvp.index') ? 'active' : '' }}"
                    href="{{ route('rsvp.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Ucapan & Doa">
                    <i class="menu-icon bi bi-clipboard-check me-2"></i>
                    <span class="menu-name">Ucapan & Doa</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('documentation.index') ? 'active' : '' }}"
                    href="{{ route('documentation.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Dokumentasi">
                    <i class="menu-icon bi bi-book me-2"></i>
                    <span class="menu-name">Dokumentasi</span>
                </a>
            </li>

            @role('admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('subscription-plans.index') ? 'active' : '' }}"
                    href="{{ route('subscription-plans.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Paket & Harga">
                    <i class="menu-icon bi bi-tags me-2"></i>
                    <span class="menu-name">Paket & Harga</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('coupons.index') ? 'active' : '' }}"
                    href="{{ route('coupons.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Kupon Promo">
                    <i class="menu-icon bi bi-ticket-perforated me-2"></i>
                    <span class="menu-name">Kupon Promo</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('promotions.index') ? 'active' : '' }}"
                    href="{{ route('promotions.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Promosi">
                    <i class="menu-icon bi bi-megaphone me-2"></i>
                    <span class="menu-name">Promosi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}"
                    href="{{ route('user.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Daftar Pengguna">
                    <i class="menu-icon bi bi-people me-2"></i>
                    <span class="menu-name">Daftar Pengguna</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('settings.env') ? 'active' : '' }}"
                    href="{{ route('settings.env') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Pengaturan .env">
                    <i class="menu-icon bi bi-sliders me-2"></i>
                    <span class="menu-name">Pengaturan .env</span>
                </a>
            </li>
            @endrole
        </ul>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi Tooltip Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Inisialisasi Feather Icons (jika digunakan)
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
@endpush
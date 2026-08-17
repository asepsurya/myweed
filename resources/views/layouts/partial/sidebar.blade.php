<div class="adminuiux-sidebar">
    <div class="adminuiux-sidebar-inner">
        <!-- Profile -->
        <div class="px-3 not-iconic mt-3">
            <div class="row">
                <div class="col align-self-center ">
                    <h6 class="fw-medium">Menu Saya</h6>
                </div>
                <div class="col-auto">
                    <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile"
                        aria-expanded="false" role="button" aria-controls="usersidebarprofile">
                        <i data-feather="user"></i>
                    </a>
                </div>
            </div>
            <div class="text-center collapse " id="usersidebarprofile">
                <figure class="avatar avatar-100 rounded-circle coverimg my-3">
                    <img src="{{ asset('assets/fav.png') }}" alt="">
                </figure>
                <h5 class="mb-1 fw-medium">RuangUndang.id</h5>
                <p class="small">Make your moment unforgettable</p>
            </div>
        </div>

        <ul class="nav flex-column menu-active-line">

            @role('admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Dashboard">
                    <i class="menu-icon bi bi-columns-gap me-2"></i>
                    <span class="menu-name">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('invitation.index') }}" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Daftar Pasangan">
                    <i class="menu-icon bi bi-gem me-2"></i>
                    <span class="menu-name">Daftar Pasangan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('music.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Music Library">
                    <i class="menu-icon bi bi-music-note-list me-2"></i>
                    <span class="menu-name">Music Library</span>
                </a>
            </li>
            @endrole

            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.user') }}" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Pasangan Saya">
                    <i class="menu-icon bi bi-heart me-2"></i>
                    <span class="menu-name">Pasangan Saya</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="menu-icon bi bi-folder me-2"></i>
                    <span class="menu-name">Planner</span>
                </a>
                <div class="dropdown-menu" id="financeMenu">
                    <div class="nav-item">
                        <a href="{{ route('weeding-plan.index') }}" class="nav-link"
                            :active="request()->routeIs('weeding-plan.index')">
                            <i class="menu-icon bi bi-calendar-check me-2"></i>
                            <span class="menu-name">Rencana Pernikahan</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('budget.dashboard') }}" class="nav-link"
                            :active="request()->routeIs('budget.dashboard')">
                            <i class="menu-icon bi bi-calculator me-2"></i>
                            <span class="menu-name">Anggaran</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('savings.dashboard') }}" class="nav-link"
                            :active="request()->routeIs('savings.dashboard')">
                            <i class="menu-icon bi bi-piggy-bank me-2"></i>
                            <span class="menu-name">Tabungan</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('financial-overview.index') }}" class="nav-link"
                            :active="request()->routeIs('financial-overview.index')">
                            <i class="menu-icon bi bi-bar-chart-line me-2"></i>
                            <span class="menu-name">Ikhtisar Keuangan</span>
                        </a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('rsvp.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Ucapan & Doa">
                    <i class="menu-icon bi bi-clipboard-check me-2"></i>
                    <span class="menu-name">Ucapan & Doa</span>
                </a>
            </li>


            @role('admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('subscription-plans.index') }}" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Paket & Harga">
                    <i class="menu-icon bi bi-tags me-2"></i>
                    <span class="menu-name">Paket & Harga</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('coupons.index') }}" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Kupon Promo">
                    <i class="menu-icon bi bi-ticket-perforated me-2"></i>
                    <span class="menu-name">Kupon Promo</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('promotions.index') }}" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Promosi">
                    <i class="menu-icon bi bi-megaphone me-2"></i>
                    <span class="menu-name">Promosi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('user.index') }}" data-bs-toggle="tooltip" data-bs-placement="right"
                    title="Daftar Pengguna">
                    <i class="menu-icon bi bi-people me-2"></i>
                    <span class="menu-name">Daftar Pengguna</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('settings.env') }}" data-bs-toggle="tooltip"
                    data-bs-placement="right" title="Pengaturan .env">
                    <i class="menu-icon bi bi-sliders me-2"></i>
                    <span class="menu-name">Pengaturan .env</span>
                </a>
            </li>
            @endrole

        </ul>


    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );

        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        const financeDropdown = document.getElementById('financeMenu');
        if (financeDropdown) {
            const activeLink = financeDropdown.querySelector('.nav-link.active');
            if (activeLink) {
                const dropdownToggle = financeDropdown.closest('.dropdown').querySelector('[data-bs-toggle="dropdown"]');
                const dropdownMenu = financeDropdown.closest('.dropdown').querySelector('.dropdown-menu');
                if (dropdownToggle) dropdownToggle.classList.add('show');
                if (dropdownMenu) dropdownMenu.classList.add('show');
                dropdownToggle.setAttribute('aria-expanded', 'true');
            }
        }
    });

</script>
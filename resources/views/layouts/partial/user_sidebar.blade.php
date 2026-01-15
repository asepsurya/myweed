<div class="adminuiux-sidebar">
    <div class="adminuiux-sidebar-inner">
        <!-- Profile -->
        <div class="px-3 not-iconic mt-3">
            <div class="row">
                <div class="col align-self-center ">
                    <h6 class="fw-medium">Menu Saya</h6>
                </div>
                <div class="col-auto">
                    <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile" aria-expanded="false" role="button" aria-controls="usersidebarprofile">
                        <i data-feather="user"></i>
                    </a>
                </div>
            </div>
            <div class="text-center collapse " id="usersidebarprofile">
                <figure class="avatar avatar-100 rounded-circle coverimg my-3">
                    <img src="{{ asset('tempelate/logo_apps.png') }}" alt="">
                </figure>
                <h5 class="mb-1 fw-medium">Weeding Creative</h5>
                <p class="small">The Investment UI Kit</p>
            </div>
        </div>

        <ul class="nav flex-column menu-active-line">



            <!-- Data Pasangan -->
            <li class="nav-item">
                <a class="nav-link"href="{{ route('dashboard.user') }}" :active="request()->routeIs('dashboard.user*')">
                    <i class=" menu-icon bi bi-heart me-2"></i>
                    <span class="menu-name"> Data Pasangan</span>
                </a>
            </li>
            <!-- Ucapan -->
            <li class="nav-item">
                <a href="{{ route('rsvp.index') }}" class="nav-link" :active="request()->routeIs('rsvp.index')">
                    <i class="bi bi-clipboard-check"></i>
                    <span class="menu-name">Ucapan & Doa</span>
                </a>
            </li>

            <!-- Hadiah -->
            <li class="nav-item">
                <a href="{{ route('gift.index') }}" class="nav-link">
                    <i class="menu-icon bi bi-gift"></i>
                    <span class="menu-name">Hadiah Digital</span>
                </a>
            </li>


        </ul>

        <div class=" mt-auto "></div>

        <!-- User account -->
        <ul class="nav flex-column menu-active-line">
            <!-- bottom sidebar menu -->
            <li class="nav-item">
                <a href="investment-referral.html" class="nav-link">
                    <i class="menu-icon" data-feather="users"></i>
                    <span class="menu-name">Akun Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="investment-settings.html" class="nav-link">
                    <i class="menu-icon" data-feather="settings"></i>
                    <span class="menu-name">Setelan</span>
                </a>
            </li>
        </ul>
    </div>
</div>

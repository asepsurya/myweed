<style>
    /* Mobile: pastikan dropdown fit ke layar */
@media (max-width: 575.98px) {
    #profile-dropdown-menu {
        margin-inline: 0 !important;
        right: -0.5rem !important;
        left: auto !important;
        max-width: calc(100vw - 2rem) !important;
        width: 300px !important;
    }
}

/* Desktop: pertahankan offset margin seperti semula */
@media (min-width: 576px) {
    #profile-dropdown-menu {
        margin-inline-start: -45px;
    }
}
.logo-dark {
    display: none;
}

[data-bs-theme="dark"] .logo-light {
    display: none;
}

[data-bs-theme="dark"] .logo-dark {
    display: block;
}
</style>
<!-- standard header -->
<header class="adminuiux-header">
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">

            <!-- main sidebar toggle -->
            <button class="btn btn-link btn-square sidebar-toggler" type="button" onclick="initSidebar()">
                <i class="sidebar-svg" data-feather="menu"></i>
            </button>

            <!-- logo -->
            <a class="navbar-brand d-flex align-items-center" href="/">
    <img class="logo-light"
         src="{{ asset('assets/logo-new.png') }}"
         alt="Logo RuangUndang"
         style="height: 30px; width: auto;">

    <img class="logo-dark"
         src="{{ asset('assets/logo-white-new.png') }}"
         alt="Logo RuangUndang"
         style="height: 30px; width: auto;">
</a>

            @role('admin')
            <!-- navigation inline -->
            <div class="collapse navbar-collapse right-in-device justify-content-center" id="header-navbar">
                <ul class="navbar-nav mx-lg-3 mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('tempelate.index') }}"
                            :active="request()->routeIs('tempelate.index')">
                            <i class="menu-icon bi bi-palette me-2"></i> Tema
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('music.index') }}"
                            :active="request()->routeIs('music.index')">
                            <i class="menu-icon bi bi-music-note-beamed me-2"></i> Music
                        </a>
                    </li>
                </ul>
            </div>
            @endrole

            <!-- right icons button -->
            <div class="ms-auto">
                <!-- dark mode -->
                <button class="btn btn-link btn-square btnsunmoon btn-link-header" id="btn-layout-modes-dark-page">
                    <i class="sun mx-auto" data-feather="sun"></i>
                    <i class="moon mx-auto" data-feather="moon"></i>
                </button>

                <!-- github update check -->
                <div class="dropdown d-none d-sm-inline-block" id="update-dropdown">
                    <button class="btn btn-link btn-square btn-icon btn-link-header dropdown-toggle no-caret"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false" id="update-btn">
                        <i class="bi bi-github"></i>
                        <span class="update-badge d-none" id="update-badge">!</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end width-300 pt-0 px-0">
                        <div class="bg-theme-1-space rounded py-3 mb-2 dropdown-dontclose text-center">
                            <p class="mb-0">Update Tersedia</p>
                            <p class="opacity-50 small" id="update-version">v1.0.0</p>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-theme btn-sm" href="https://github.com/asepsurya/myweed/releases"
                                target="_blank">
                                <i class="bi bi-arrow-down-circle me-1"></i> Update Sekarang
                            </a>
                        </div>
                    </div>
                </div>

        

                @auth
                <!-- profile dropdown -->
                <div class="dropdown d-inline-block">
                    <a class="dropdown-toggle btn btn-link btn-square btn-link-header style-none no-caret px-0"
                        id="userprofiledd" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                        <div class="row gx-0 d-inline-flex">
                            <div class="col-auto align-self-center">
                                <figure class="avatar avatar-28 rounded-circle">
                                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('tempelate/user_default.jpg') }}"
                                        alt="User Avatar" id="userphotoonboarding2" class="rounded-circle"
                                        referrerpolicy="no-referrer"
                                        onerror="this.onerror=null;this.src='{{ asset('tempelate/user_default.jpg') }}';">
                                </figure>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end width-300 p-0"
                        aria-labelledby="userprofiledd" id="profile-dropdown-menu">

                        {{-- USER HEADER --}}
                        <div class="bg-theme-1-space rounded-top py-3 px-3 mb-2 dropdown-dontclose">
                            <div class="d-flex align-items-center gap-3">
                                <figure class="avatar avatar-50 rounded-circle mb-0">
                                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('tempelate/user_default.jpg') }}"
                                        class="rounded-circle w-100 h-100 object-fit-cover" alt="User Avatar">
                                </figure>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-1 fw-semibold text-truncate" title="{{ auth()->user()->name }}">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="mb-0 small text-truncate">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- MENU --}}
                        <div class="px-2 pb-2">
                            <a class="dropdown-item d-flex align-items-center gap-2"
                                href="{{ auth()->user()->hasRole('admin') ? route('dashboard') : route('dashboard.user') }}">
                                <i class="bi bi-speedometer2 fs-6"></i>
                                Dashboard Saya
                            </a>

                            @php $status = auth()->user()->subscriptionStatus(); @endphp

                            <a class="dropdown-item d-flex align-items-center justify-content-between"
                                href="{{ route('subscribe.page') }}">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-gift fs-6"></i>
                                    Subscription
                                </div>
                                <span
                                    class="small {{ $status === 'active' ? 'text-success' : ($status === 'expired' ? 'text-danger' : 'text-muted') }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </a>

                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                                <i class="bi bi-shield-lock fs-6"></i>
                                Ganti Password
                            </a>

                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                                <i class="bi bi-gear fs-6"></i>
                                Setelan Akun
                            </a>

                            <hr class="my-2">

                            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                @csrf
                            </form>

                            <a href="#" class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                <i class="bi bi-power fs-6"></i>
                                Keluar
                            </a>
                        </div>
                    </div>
                </div>
                @endauth

                @role('admin')
                <!-- navigation inline toggler for small screen-->
                <button class="navbar-toggler btn btn-link btn-link-header btn-square btn-icon collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#header-navbar" aria-controls="header-navbar"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i data-feather="more-vertical" class="openbtn"></i>
                    <i data-feather="x" class="closebtn"></i>
                </button>
                @endrole
            </div>
        </div>
    </nav>


</header>

<script>
    (function () {
        const updateBtn = document.getElementById('update-btn');
        const updateBadge = document.getElementById('update-badge');
        const updateVersion = document.getElementById('update-version');
        const updateDropdown = document.getElementById('update-dropdown');

        if (!updateBtn) return;

        fetch("{{ route('dashboard.check-update') }}")
            .then(res => res.json())
            .then(data => {
                if (data.has_update) {
                    updateBadge.classList.remove('d-none');
                    if (updateVersion) {
                        updateVersion.textContent = 'v' + data.latest_version;
                    }
                    if (updateDropdown) {
                        updateDropdown.querySelector('.dropdown-toggle').classList.add('text-warning');
                    }
                }
            })
            .catch(() => { });
    })();
</script>
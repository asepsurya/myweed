<nav class="navbar navbar-expand-lg" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing') }}">
            <img src="{{ asset('assets/logo-white.png') }}" alt="Logo RuangUndang" class="logo-light">
            <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang" class="logo-dark">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
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
                    <a href="{{ route('dashboard.user') }}"
                        class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2 rounded-pill dashboard-link">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="nav-link text-white login-link px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="btn-gold d-flex align-items-center gap-2 px-4 py-2 rounded-pill">
                        <span>Mulai Gratis</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

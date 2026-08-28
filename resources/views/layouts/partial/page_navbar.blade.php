<nav class="navbar" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('landing') }}">
            <img src="{{ asset('assets/logo-new.png') }}" alt="RuangUndang" class="logo-dark" style="height: 40px; width: auto;">
            <img src="{{ asset('assets/logo-new-white.png') }}" alt="RuangUndang" class="logo-light" style="height: 40px; width: auto;">
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('landing') }}" class="nav-link">Beranda</a>
            <a href="{{ route('pages.harga') }}" class="nav-link">Harga</a>
            <a href="{{ route('pages.faq') }}" class="nav-link">FAQ</a>
            <a href="{{ route('login') }}" class="btn btn-gold">Masuk</a>
        </div>
    </div>
</nav>

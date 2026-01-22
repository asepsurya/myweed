<style>
    .mobile-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 64px;
    background: #fff;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: space-around;
    align-items: center;
    z-index: 1030;
}

.mobile-bottom-nav .nav-item {
    flex: 1;
    text-align: center;
    font-size: 11px;
    color: #6c757d;
    text-decoration: none;
    padding: 6px 0;
}

.mobile-bottom-nav .nav-item i {
    font-size: 18px;
    display: block;
    margin-bottom: 2px;
}

.mobile-bottom-nav .nav-item.active {
    color: #0d6efd;
    font-weight: 600;
}

.mobile-bottom-nav .nav-item.active i {
    transform: scale(1.1);
}
@media (max-width: 768px) {
    body {
        padding-bottom: 70px;
    }
}
/* Dark mode */
@media (prefers-color-scheme: dark) {
    .mobile-bottom-nav {
        background: #073833;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    .mobile-bottom-nav .nav-item {
        color: rgba(255,255,255,0.6);
    }
    .mobile-bottom-nav .nav-item.active {
        color: #fff;
    }
    .mobile-bottom-nav .nav-item.active i {
        color: #8ff3e8;
    }
}

</style>
@if(Request::is('invitation/create'))
@else
<nav class="mobile-bottom-nav d-md-none">
    <a href="{{ route('dashboard') }}"
       class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-columns-gap"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('dashboard.user') }}"
       class="nav-item {{ request()->routeIs('dashboard.user') ? 'active' : '' }}">
        <i class="bi bi-heart"></i>
        <span>Pasangan</span>
    </a>

    <a href="{{ route('rsvp.index') }}"
       class="nav-item {{ request()->routeIs('rsvp.*') ? 'active' : '' }}">
        <i class="bi bi-clipboard-check"></i>
        <span>Ucapan</span>
    </a>

    <a href="{{ route('gift.index') }}"
       class="nav-item {{ request()->routeIs('gift.*') ? 'active' : '' }}">
        <i class="bi bi-gift"></i>
        <span>Hadiah</span>
    </a>

    @role('admin')
    <a href="{{ route('user.index') }}"
       class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>User</span>
    </a>
    @endrole
</nav>
@endif

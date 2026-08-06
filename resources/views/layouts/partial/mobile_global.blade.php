<style>
    /* ==========================================
       Mobile Bottom Navigation Styles (Full Width)
       ================================---------- */
    .mobile-bottom-nav {
        position: fixed;
        left: 0;
        bottom: 0;
        transform: none;
        width: 100%;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-around;
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-top: 1px solid #ececec;
        border-bottom: none;
        border-left: none;
        border-right: none;
        border-radius: 0;
        box-shadow: 0 -4px 18px rgba(0, 0, 0, 0.05);
        z-index: 1050;
    }

    .mobile-bottom-nav .nav-item {
        flex: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        text-decoration: none;
        color: #9ca3af;
        transition: color 0.2s ease;
        position: relative;
    }

    .mobile-bottom-nav .nav-item i {
        font-size: 1.25rem;
        transition: transform 0.2s ease;
    }

    .mobile-bottom-nav .nav-item span {
        font-size: 0.68rem;
        font-weight: 500;
    }

    .mobile-bottom-nav .nav-item:hover {
        color: #4b5563;
    }

    .mobile-bottom-nav .nav-item.active {
        color: #111827;
    }

    .mobile-bottom-nav .nav-item.active i {
        transform: translateY(-1px);
    }

    /* Garis bawah dihilangkan */
    .mobile-bottom-nav .nav-item.active::after {
        display: none;
    }

    /* ==========================================
       More Menu Overlay Styles
       ================================---------- */
    .more-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }

    .more-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }

    /* ==========================================
       More Menu Drawer Styles
       ================================---------- */
    .more-menu {
        position: fixed;
        bottom: -100%;
        left: 0;
        right: 0;
        height: 60%;
        background: #ffffff;
        color: #111827;
        border-radius: 20px 20px 0 0;
        transition: bottom 0.3s ease;
        z-index: 9999;
        box-shadow: 0 -4px 20px rgba(0,0,0,.1);
    }

    .more-menu.show {
        bottom: 0;
    }

    .more-menu-content {
        padding: 20px;
        overflow-y: auto;
        height: 100%;
    }

    .more-menu .handle {
        width: 50px;
        height: 5px;
        background: #d1d5db;
        border-radius: 10px;
        margin: 0 auto 20px;
    }

    .more-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        text-decoration: none;
        color: #111827;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .more-item i {
        font-size: 18px;
        color: #6b7280;
    }

    .more-item:hover,
    .more-item.active {
        background: #f9fafb;
        color: #111827;
    }

    .more-item.active i {
        color: #111827;
    }

    /* ==========================================
       Dark Mode Support ([data-bs-theme="dark"])
       ================================---------- */
    [data-bs-theme="dark"] .mobile-bottom-nav {
        background: rgba(28, 28, 30, .95);
        border-top-color: rgba(255,255,255,.08);
        box-shadow: none;
    }

    [data-bs-theme="dark"] .mobile-bottom-nav .nav-item {
        color: #9ca3af;
    }

    [data-bs-theme="dark"] .mobile-bottom-nav .nav-item:hover,
    [data-bs-theme="dark"] .mobile-bottom-nav .nav-item.active {
        color: #ffffff;
    }

    [data-bs-theme="dark"] .more-menu {
        background: #1c1c1e;
        color: #f3f4f6;
    }

    [data-bs-theme="dark"] .more-item {
        color: #9ca3af;
        border-bottom-color: rgba(255, 255, 255, .05);
    }

    [data-bs-theme="dark"] .more-item:hover,
    [data-bs-theme="dark"] .more-item.active {
        background: rgba(255, 255, 255, 0.05);
        color: #ffffff;
    }

    [data-bs-theme="dark"] .more-item.active i {
        color: #ffffff;
    }

    [data-bs-theme="dark"] .more-menu .handle {
        background: #4b5563;
    }

    /* ==========================================
       Responsive Visibility Control (CSS Biasa)
       ================================---------- */
    /* Sembunyikan elemen pada layar mobile */
    @media (max-width: 767.98px) {
        .hide-on-mobile {
            display: none !important;
        }
    }

    /* Sembunyikan navigasi bawah full width pada layar desktop */
    @media (min-width: 768px) {
        .mobile-bottom-nav,
        .more-overlay,
        .more-menu {
            display: none !important;
        }
    }
</style>

{{-- Navbar Utama Dashboard/Umum --}}
@if(!Request::is('invitation/create') && !request()->routeIs('invitation.edit*'))
<nav class="mobile-bottom-nav">
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

{{-- Navbar Khusus Edit Undangan (Tabbed Menu & More Drawer) --}}
@if(request()->routeIs('invitation.edit*'))
<nav class="mobile-bottom-nav">
    <a class="nav-item tab-btn active" data-tab="2">
        <i class="bi bi-palette"></i>
        <span>Tema</span>
    </a>

    <a class="nav-item tab-btn" data-tab="1">
        <i class="bi bi-person-fill"></i>
        <span>Pria</span>
    </a>

    <a class="nav-item tab-btn" data-tab="7">
        <i class="bi bi-person-heart"></i>
        <span>Wanita</span>
    </a>

    <a class="nav-item tab-btn" data-tab="6">
        <i class="bi bi-geo-alt-fill"></i>
        <span>Lokasi</span>
    </a>

    <a class="nav-item" id="openMore">
        <i class="bi bi-list"></i>
        <span>More</span>
    </a>
</nav>

{{-- Overlay & Menu Drawer --}}
<div id="moreOverlay" class="more-overlay"></div>

<div id="moreMenu" class="more-menu">
    <div class="more-menu-content">
        <div class="handle"></div>

        <a class="more-item tab-btn" data-tab="3"><i class="bi bi-images"></i> Galeri</a>
        <a class="more-item tab-btn" data-tab="4"><i class="bi bi-music-note"></i> Musik</a>
        <a class="more-item tab-btn" data-tab="8"><i class="bi bi-play"></i> Video & Kisah</a>
        <a class="more-item tab-btn" data-tab="5"><i class="bi bi-chat-dots"></i> RSVP</a>
        <a class="more-item tab-btn" data-tab="9"><i class="bi bi-gift"></i> Hadiah & Donasi</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const moreBtn = document.getElementById('openMore');
        const moreMenu = document.getElementById('moreMenu');
        const overlay = document.getElementById('moreOverlay');

        if (moreBtn && moreMenu && overlay) {
            moreBtn.addEventListener('click', () => {
                moreMenu.classList.add('show');
                overlay.classList.add('show');
            });

            const closeMore = () => {
                moreMenu.classList.remove('show');
                overlay.classList.remove('show');
            };

            overlay.addEventListener('click', closeMore);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeMore();
            });
        }

        const openTab = (tabId) => {
            const tabEl = document.querySelector(`.tab-btn[data-tab="${tabId}"]`);
            if (tabEl && typeof switchTab === 'function') {
                switchTab(tabEl);
            } else if (tabEl) {
                tabEl.click();
            }
        };

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                openTab(this.dataset.tab);
            });
        });

        document.querySelectorAll('.more-item').forEach(item => {
            item.addEventListener('click', function () {
                if (typeof closeMore === 'function') {
                    moreMenu.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });
    });
</script>
@endif
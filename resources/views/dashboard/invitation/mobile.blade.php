<style>
.mobile-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 65px;
    background: #ffffff;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-around;
    align-items: center;
    z-index: 9999;
}

.mobile-bottom-nav .nav-item {
    flex: 1;
    text-align: center;
    color: #6b7280;
    font-size: 12px;
    text-decoration: none;
    padding: 6px 0;
    transition: all 0.2s ease;
}

.mobile-bottom-nav .nav-item i {
    font-size: 20px;
    display: block;
    margin-bottom: 2px;
}

.mobile-bottom-nav .nav-item.active {
    color: #111827;
    font-weight: 600;
}

.mobile-bottom-nav .nav-item.active i {
    color: #2563eb;
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

/* Overlay */
.more-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}
.more-overlay.show {
    opacity: 1;
    pointer-events: auto;
}

/* More Menu */
.more-menu {
    position: fixed;
    bottom: -100%;
    left: 0;
    right: 0;
    height: 60%;
    background: #073833;
    color: #fff;
    border-radius: 20px 20px 0 0;
    transition: bottom 0.3s ease;
    z-index: 9999;
}
.more-menu.show {
    bottom: 65px;
}

.more-menu-content {
    padding: 20px;
}

.more-menu .handle {
    width: 50px;
    height: 5px;
    background: #ccc;
    border-radius: 10px;
    margin: 0 auto 15px;
}

.more-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px;
    text-decoration: none;
    color: #fff;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    font-size: 14px;
}
.more-item i {
    font-size: 18px;
}
.more-item:hover {
    background: rgba(255,255,255,0.05);
}
</style>
<div class="mobile-bottom-nav d-md-none">
    <a class="nav-item tab-btn active" data-tab="1">
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

    <a class="nav-item tab-btn" data-tab="3">
        <i class="bi bi-images"></i>
        <span>Galeri</span>
    </a>



    <a class="nav-item" id="openMore">
        <i class="bi bi-list"></i>
        <span>More</span>
    </a>
</div>

<div id="moreOverlay" class="more-overlay"></div>

<div id="moreMenu" class="more-menu">
    <div class="more-menu-content">
        <div class="handle"></div>

        <a class="more-item" data-tab="2"><i class="bi bi-palette"></i> Tema & Warna</a>
        <a class="more-item" data-tab="4"><i class="bi bi-music-note"></i> Musik</a>
        <a class="more-item" data-tab="8"><i class="bi bi-play"></i> Video & Kisah</a>
        <a class="more-item" data-tab="5"><i class="bi bi-chat-dots"></i> RSVP</a>
        <a class="more-item" data-tab="9"><i class="bi bi-gift"></i> Hadiah & Donasi</a>
    </div>
</div>
<script>
const moreBtn = document.getElementById('openMore');
const moreMenu = document.getElementById('moreMenu');
const overlay = document.getElementById('moreOverlay');

// Open More
moreBtn.addEventListener('click', () => {
    moreMenu.classList.add('show');
    overlay.classList.add('show');
});

// Close More
function closeMore() {
    moreMenu.classList.remove('show');
    overlay.classList.remove('show');
}
overlay.addEventListener('click', closeMore);

// Fungsi buka tab
function openTab(tabId) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('d-none'));

    const activeBtn = document.querySelector(`.tab-btn[data-tab="${tabId}"]`);
    const activeTab = document.getElementById(tabId);

    if (activeBtn) activeBtn.classList.add('active');
    if (activeTab) activeTab.classList.remove('d-none');
}

// Klik tab utama
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        openTab(this.dataset.tab);
    });
});

// Klik menu More
document.querySelectorAll('.more-item').forEach(item => {
    item.addEventListener('click', function () {
        openTab(this.dataset.tab);
        closeMore();
    });
});
</script>

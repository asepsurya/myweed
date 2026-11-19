<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $noIndex = $noIndex ?? false;
    @endphp
    @include('layouts.partial.seo_head')

    <!-- Evite Inspired Typography: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/fav-icon.png') }}">

    <!-- Icons -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Evite Design System CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/page.css') }}">

    @if(config('services.facebook.pixel_id'))
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ config('services.facebook.pixel_id') }}');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ config('services.facebook.pixel_id') }}&ev=PageView&noscript=1"
        alt=""/></noscript>
    @endif

    @stack('styles')
</head>

<body>

    @include('layouts.partial.ev-header')
    @include('layouts.partial.ev-search-modal')

    <main id="mainContent">
        @yield('content')
    </main>

    @include('layouts.partial.ev-footer')

    <!-- WhatsApp Floating Chat Component -->
    @include('components.wa-chat', [
        'phone' => '6285923431716',
        'message' => 'Halo RuangUndang, saya ingin bertanya tentang layanan undangan digital.',
        'title' => 'Chat WhatsApp RuangUndang',
        'mobileBottom' => 24
    ])

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Evite Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('mainHeader');
            if (header) {
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 30) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                }, { passive: true });
            }

            const drawer = document.getElementById('mobileDrawer');
            const backdrop = document.getElementById('drawerBackdrop');
            const openBtn = document.getElementById('mobileDrawerOpenBtn');
            const closeBtn = document.getElementById('mobileDrawerCloseBtn');

            function openDrawer() {
                if (drawer) drawer.classList.add('is-open');
                if (backdrop) backdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                if (drawer) drawer.classList.remove('is-open');
                if (backdrop) backdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            if (openBtn) openBtn.addEventListener('click', openDrawer);
            if (closeBtn) closeBtn.addEventListener('click', closeDrawer);
            if (backdrop) backdrop.addEventListener('click', closeDrawer);

            const searchModal = document.getElementById('searchModal');
            const searchModalBackdrop = document.getElementById('searchModalBackdrop');
            const searchTriggerBtn = document.getElementById('searchTriggerBtn');
            const mobileSearchBtn = document.getElementById('mobileSearchBtn');
            const searchModalClose = document.getElementById('searchModalClose');
            const searchModalInput = document.getElementById('searchModalInput');
            const searchModalClear = document.getElementById('searchModalClear');
            const searchModalForm = document.getElementById('searchModalForm');
            const searchRecentList = document.getElementById('searchRecentList');
            const searchRecentSection = document.getElementById('searchRecentSection');

            const RECENT_KEY = 'ru_recent_searches';

            function getRecentSearches() {
                try { return JSON.parse(localStorage.getItem(RECENT_KEY) || '[]'); } catch { return []; }
            }

            function saveRecentSearch(query) {
                if (!query.trim()) return;
                let arr = getRecentSearches().filter(q => q !== query);
                arr.unshift(query);
                arr = arr.slice(0, 5);
                localStorage.setItem(RECENT_KEY, JSON.stringify(arr));
            }

            function renderRecent() {
                const arr = getRecentSearches();
                if (!searchRecentList || !searchRecentSection) return;
                if (arr.length === 0) {
                    searchRecentSection.style.display = 'none';
                    return;
                }
                searchRecentSection.style.display = 'block';
                searchRecentList.innerHTML = arr.map(q => `
                    <li class="ev-search-recent-item">
                        <button type="button" class="ev-search-recent-btn" data-query="${q}">
                            <i class="bi bi-clock-history"></i>
                            <span>${q}</span>
                        </button>
                        <button type="button" class="ev-search-recent-remove" data-query="${q}" aria-label="Hapus">
                            <i class="bi bi-x"></i>
                        </button>
                    </li>
                `).join('');

                searchRecentList.querySelectorAll('.ev-search-recent-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const q = btn.getAttribute('data-query');
                        if (searchModalInput) searchModalInput.value = q;
                        if (searchModalForm) searchModalForm.submit();
                    });
                });
                searchRecentList.querySelectorAll('.ev-search-recent-remove').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const q = btn.getAttribute('data-query');
                        let arr2 = getRecentSearches().filter(x => x !== q);
                        localStorage.setItem(RECENT_KEY, JSON.stringify(arr2));
                        renderRecent();
                    });
                });
            }

            function openSearchModal() {
                if (!searchModal) return;
                searchModal.classList.add('is-open');
                if (searchModalBackdrop) searchModalBackdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
                renderRecent();
                setTimeout(() => { if (searchModalInput) searchModalInput.focus(); }, 80);
            }

            function closeSearchModal() {
                if (!searchModal) return;
                searchModal.classList.remove('is-open');
                if (searchModalBackdrop) searchModalBackdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            if (searchTriggerBtn) searchTriggerBtn.addEventListener('click', openSearchModal);
            if (mobileSearchBtn) mobileSearchBtn.addEventListener('click', openSearchModal);
            if (searchModalClose) searchModalClose.addEventListener('click', closeSearchModal);
            if (searchModalBackdrop) searchModalBackdrop.addEventListener('click', closeSearchModal);

            if (searchModalInput && searchModalClear) {
                searchModalInput.addEventListener('input', () => {
                    searchModalClear.style.display = searchModalInput.value ? 'flex' : 'none';
                });
                searchModalClear.addEventListener('click', () => {
                    searchModalInput.value = '';
                    searchModalClear.style.display = 'none';
                    searchModalInput.focus();
                });
            }

            if (searchModalForm && searchModalInput) {
                searchModalForm.addEventListener('submit', () => {
                    saveRecentSearch(searchModalInput.value);
                });
            }

            document.addEventListener('keydown', (e) => {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    if (searchModal && searchModal.classList.contains('is-open')) {
                        closeSearchModal();
                    } else {
                        openSearchModal();
                    }
                }
                if (e.key === 'Escape' && searchModal && searchModal.classList.contains('is-open')) {
                    closeSearchModal();
                }
            });

            const reveals = document.querySelectorAll('.reveal');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('active');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });

                reveals.forEach(el => observer.observe(el));
            } else {
                reveals.forEach(el => el.classList.add('active'));
            }
        });
    </script>

    @stack('scripts')
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $invitation->groom_nickname ?? 'Pasangan' }} &amp; {{ $invitation->bride_nickname ?? 'Pasangan' }} | The Wedding</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <!-- Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Playfair Display'],
                        sans: ['Lato']
                    },
                    colors: {
                        primary: '#c8a97e',
                        'outline-variant': '#c8c8c8',
                        'tertiary-fixed-dim': '#d4c5a0',
                        'surface-variant': '#f5f0e8',
                        'on-surface-variant': '#6b6b6b',
                        'headline-md': '#333333',
                        'on-surface': '#333333',
                        'surface': '#fdfaf6',
                        'surface-container-low': '#f0ebe3',
                        'surface-container-high': '#e8e4db',
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style>
        body {
            overflow: auto;
            min-height: 100vh;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
        }

        .animate-on-scroll.show {
            animation: fadeUp .9s ease-out forwards;
        }

        .youtube-player-container {
            position: absolute;
            left: -9999px;
            width: 2px;
            height: 2px;
            overflow: hidden;
        }

        h2 {
            font-family: 'Great Vibes', cursive;
            letter-spacing: 0.05em;
        }

        #toast {
            visibility: hidden;
            min-width: 250px;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 16px;
            position: fixed;
            z-index: 100;
            left: 50%;
            bottom: 30px;
            transform: translateX(-50%);
            font-size: 14px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.5s, bottom 0.5s;
        }

        #toast.show {
            visibility: visible;
            opacity: 1;
            bottom: 50px;
        }
    </style>
</head>

<body class="bg-gray-300 flex justify-center font-sans">

    <!-- Tombol Floating Music -->
    <button id="musicToggle" class="fixed bottom-6 right-6 bg-primary text-white p-3 rounded-full shadow-lg flex items-center justify-center z-50 hover:bg-primary/90 transition">
        <svg id="musicIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.518-3.759A1 1 0 007 8.32v7.36a1 1 0 001.234.97l6.518-1.885a1 1 0 00.75-.97v-1.87a1 1 0 00-.75-.97z" />
        </svg>
    </button>

    <!-- MOBILE WRAPPER -->
    <div class="w-full max-w-[420px] min-h-screen bg-[#fdfaf6] relative overflow-hidden shadow-2xl">

        <!-- ================= COVER ================= -->
        <section id="home" class="relative h-screen flex items-center justify-center text-center">
            <div class="absolute inset-0 bg-cover bg-center lazy-bg" style="background-image: url('{{ asset('storage/' . ($invitation->gallery_cover ?? 'default/cover.jpg')) }}')"></div>
            <div class="absolute inset-0 bg-black/50"></div>

            <div class="relative z-10 text-white px-6 space-y-4">
                <p class="text-sm tracking-widest uppercase">Undangan Pernikahan</p>
                <h1 class="font-serif text-5xl font-bold">{{ $invitation->groom_nickname }} & {{ $invitation->bride_nickname }}</h1>
                <p class="text-sm">
                    Kepada Yth<br>
                    <span class="border-b border-white px-2 py-1 inline-block mt-2">
                        Bapak / Ibu / Saudara
                    </span>
                </p>
                <span class="mt-3">{{ request('to') ?? 'Keluarga Besar' }}</span>
                <p class="text-sm">{{ \Carbon\Carbon::parse($invitation->wedding_date)->locale('id')->translatedFormat('l, d F Y') }}</p>

                <button id="openInvitation" class="bg-primary px-8 py-3 rounded-full text-sm font-semibold shadow-lg active:scale-95 transition">
                    <i class="ti ti-mail-opened text-lg"></i> Buka Undangan
                </button>
            </div>
        </section>

        <!-- ================= QUOTES ================= -->
        <section id="quote" class="py-16 px-6 text-center max-w-2xl mx-auto">
            <div class="animate-on-scroll">
                <h2 class="font-serif text-3xl text-primary mb-6">Quotes</h2>
                <span class="material-symbols-outlined text-outline-variant text-4xl mb-4 block">format_quote</span>
                <p class="text-gray-600 leading-relaxed mb-6 italic">
                    {!! nl2br(e(str_replace('(', "\n(", $invitation->wedding_quote))) !!}
                </p>
                <div class="w-16 h-[1px] bg-outline-variant mx-auto mt-8"></div>
            </div>
        </section>

        <!-- ================= CONTENT ================= -->
        <section id="content" class="space-y-14 py-12">
            @foreach ($invitation->template->sections as $section)
                @includeIf('templates.' . $invitation->template->slug . '.sections.' . $section)
            @endforeach
        </section>

        @php
            $loveStories = is_array($invitation->love_story)
                ? $invitation->love_story
                : json_decode($invitation->love_story, true);
        @endphp

        @if(!empty($loveStories[0]['title']) || !empty($loveStories[0]['story']))
        <section id="story2" class="py-16 px-6">
            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-12 animate-on-scroll">
                    <p class="text-sm text-outline tracking-widest uppercase mb-2">Kisah Kami</p>
                    <h2 class="font-serif text-3xl text-primary">Love Story</h2>
                </div>
                <div class="relative pl-6 animate-on-scroll">
                    @foreach($loveStories as $index => $story)
                    <div class="{{ $index < count($loveStories) - 1 ? 'mb-8' : '' }} relative timeline-item {{ $index < count($loveStories) - 1 ? 'timeline-line' : '' }}">
                        <div class="absolute -left-6 top-1 w-6 h-6 rounded-full border-2 border-tertiary-fixed-dim bg-surface flex items-center justify-center z-10">
                            <div class="w-2 h-2 rounded-full bg-tertiary-fixed-dim"></div>
                        </div>
                        <h3 class="font-body-lg text-body-lg font-semibold text-primary mb-2">{{ $story['title'] }}</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">{{ $story['story'] }}</p>
                        @if($story['photo'])
                            <img src="{{ asset('storage/' . $story['photo']) }}" alt="{{ $story['title'] }}" loading="lazy" class="mt-3 rounded-lg max-h-[200px] object-cover w-full" />
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        @if($invitation->enable_gift == 1 && $invitation->gifts->count())
        <section id="gifts" class="py-16 px-6 bg-surface">
            <div class="max-w-xl mx-auto">
                <div class="text-center mb-12 animate-on-scroll">
                    <p class="text-sm text-outline tracking-widest uppercase mb-2">Beri Hadiah</p>
                    <h2 class="font-serif text-3xl text-primary">Wedding Gifts</h2>
                </div>
                <div class="space-y-4 animate-on-scroll">
                    @foreach($invitation->gifts as $gift)
                    <div class="bg-surface-variant/50 rounded-xl p-6 relative overflow-hidden">
                        <div class="absolute right-4 top-4 font-bold text-primary text-xl italic">{{ $gift->bank }}</div>
                        <p class="text-xs text-on-surface-variant uppercase mb-1">{{ $gift->name }}</p>
                        <p class="font-headline-md text-headline-md text-on-surface mb-4">{{ $gift->number }}</p>
                        <button onclick="copyText('{{ $gift->number }}')" class="inline-flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">content_copy</span> Salin
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        @if(!empty($invitation->video_link))
        @php
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->video_link, $ytVideoMatches);
            $youtubeVideoId = $ytVideoMatches['id'] ?? '';
        @endphp
        @if($youtubeVideoId)
        <section id="video" class="py-16 px-6 bg-surface-container-low">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12 animate-on-scroll">
                    <p class="text-sm text-outline tracking-widest uppercase mb-2">Video</p>
                    <h2 class="font-serif text-3xl text-primary">Video Pernikahan</h2>
                </div>
                <div class="animate-on-scroll relative aspect-video rounded-xl overflow-hidden bg-surface-container-high cursor-pointer" data-fancybox="video" data-src="https://www.youtube.com/embed/{{ $youtubeVideoId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeVideoId }}&controls=1&modestbranding=1&rel=0">
                    <img src="https://img.youtube.com/vi/{{ $youtubeVideoId }}/hqdefault.jpg" alt="Video Pernikahan" class="w-full h-full object-cover" />
                    <div class="absolute inset-0 flex items-center justify-center bg-primary/30">
                        <span class="material-symbols-outlined text-white text-6xl">play_circle</span>
                    </div>
                </div>
            </div>
        </section>
        @endif
        @endif

    </div>
    <!-- End MOBILE WRAPPER -->

    @php
        $navItems = [];
        $navItems[] = ['id' => 'home', 'icon' => 'favorite', 'label' => 'Home', 'href' => '#home', 'primary' => true];
        if ($invitation->love_story) {
            $navItems[] = ['id' => 'story2', 'icon' => 'auto_stories', 'label' => 'Story', 'href' => '#story2'];
        }
        $navItems[] = ['id' => 'events', 'icon' => 'event', 'label' => 'Events', 'href' => '#events'];
        if ($invitation->enable_gift == 1 && $invitation->gifts->count()) {
            $navItems[] = ['id' => 'gifts', 'icon' => 'card_giftcard', 'label' => 'Gifts', 'href' => '#gifts'];
        }
        if ($invitation->enable_rsvp == 1) {
            $navItems[] = ['id' => 'rsvp', 'icon' => 'mail', 'label' => 'RSVP', 'href' => '#rsvp'];
        }
        if (!empty($invitation->video_link)) {
            $navItems[] = ['id' => 'video', 'icon' => 'play_circle', 'label' => 'Video', 'href' => '#video'];
        }
    @endphp

    <nav id="bottomNav" class="fixed bottom-0 left-0 right-0 z-50 flex justify-around items-center px-2 py-2 pb-4 bg-white/95 backdrop-blur-md border-t border-gray-100 shadow-[0_-2px_16px_0_rgba(200,169,126,0.1)]">
        @foreach($navItems as $item)
        <a class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-medium transition-all duration-200 px-3 py-1.5 rounded-xl {{ ($item['primary'] ?? false) ? 'bg-primary text-white shadow-md' : 'text-[#5a5a5a] hover:text-primary hover:bg-primary/5' }}" href="{{ $item['href'] }}">
            <span class="material-symbols-outlined" style="font-size: 20px;">{{ $item['icon'] }}</span>
            <span>{{ $item['label'] }}</span>
        </a>
        @endforeach
    </nav>

    <!-- Toast -->
    <div id="toast">Pesan terkirim dengan terima kasih.</div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* ---------- TOAST ---------- */
            function showToast(message) {
                const toast = document.getElementById('toast');
                toast.textContent = message;
                toast.className = 'show';
                setTimeout(() => { toast.className = ''; }, 3000);
            }

            /* ---------- OPEN INVITATION ---------- */
            const openBtn = document.getElementById('openInvitation');
            if (openBtn) {
                openBtn.addEventListener('click', () => {
                    const content = document.getElementById('content');
                    if (content) {
                        content.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }

            /* ---------- COUNTDOWN ---------- */
            const weddingDate = new Date('{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Y-m-d H:i:s") }}').getTime();
            function updateCountdown() {
                const now = new Date().getTime();
                const distance = weddingDate - now;
                if (distance < 0) {
                    const grid = document.getElementById('countdownGrid');
                    const passed = document.getElementById('countdownPassed');
                    if (grid) grid.classList.add('hidden');
                    if (passed) passed.classList.remove('hidden');
                    return;
                }
                const days = document.getElementById('days');
                const hours = document.getElementById('hours');
                const minutes = document.getElementById('minutes');
                const seconds = document.getElementById('seconds');
                if (days) days.textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                if (hours) hours.textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                if (minutes) minutes.textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                if (seconds) seconds.textContent = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
            }
            updateCountdown();
            setInterval(updateCountdown, 1000);

            /* ---------- SCROLL ANIMATIONS ---------- */
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

            /* ---------- RSVP FORM ---------- */
            const rsvpForm = document.getElementById('rsvpForm');
            if (rsvpForm) {
                rsvpForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const form = this;
                    const formData = new FormData(form);
                    const submitUrl = form.getAttribute('action');
                    const buttonText = document.getElementById('buttonText');
                    const buttonSpinner = document.getElementById('buttonSpinner');
                    const rsvpMessage = document.getElementById('rsvpMessage');
                    const rsvpButton = document.getElementById('rsvpButton');

                    if (!submitUrl) return;

                    if (buttonText) buttonText.textContent = 'Mengirim...';
                    if (buttonSpinner) buttonSpinner.classList.remove('hidden');
                    if (rsvpButton) rsvpButton.disabled = true;
                    if (rsvpMessage) rsvpMessage.classList.add('hidden');

                    fetch(submitUrl, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Gagal mengirim ucapan.');
                            }).catch(err => {
                                if (err.message && err.message !== 'Gagal mengirim ucapan.') throw err;
                                throw new Error('Gagal mengirim ucapan. Silakan coba lagi.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (rsvpMessage) {
                            rsvpMessage.textContent = 'Terima kasih! Ucapan Anda telah terkirim.';
                            rsvpMessage.style.color = '#22c55e';
                            rsvpMessage.classList.remove('hidden');
                        }
                        form.reset();
                        loadRsvpList();
                        showToast('Ucapan berhasil dikirim!');
                        setTimeout(() => { if (rsvpMessage) rsvpMessage.classList.add('hidden'); }, 5000);
                    })
                    .catch(err => {
                        if (rsvpMessage) {
                            rsvpMessage.textContent = err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                            rsvpMessage.style.color = '#ef4444';
                            rsvpMessage.classList.remove('hidden');
                        }
                        setTimeout(() => { if (rsvpMessage) rsvpMessage.classList.add('hidden'); }, 5000);
                    })
                    .finally(() => {
                        if (buttonText) buttonText.textContent = 'Kirim Ucapan';
                        if (buttonSpinner) buttonSpinner.classList.add('hidden');
                        if (rsvpButton) rsvpButton.disabled = false;
                    });
                });
            }

            /* ---------- LOAD RSVP LIST ---------- */
            function loadRsvpList() {
                const rsvpList = document.getElementById('rsvpList');
                if (!rsvpList) return;
                const listUrl = rsvpList.getAttribute('data-url');
                if (!listUrl) return;

                fetch(listUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        rsvpList.innerHTML = data.map(item =>
                            '<div class="comment-item flex gap-3 bg-gray-50 p-3 rounded-lg mb-3">' +
                            '<div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 flex items-center justify-center">' +
                            '<span class="material-symbols-outlined text-gray-400" style="font-size:16px;">person</span>' +
                            '</div>' +
                            '<div class="flex-1 min-w-0">' +
                            '<p class="font-semibold text-sm text-primary mb-1">' + item.name + '</p>' +
                            '<p class="text-sm text-gray-600 leading-relaxed">' + item.message + '</p>' +
                            '<p class="text-xs text-gray-400 mt-1">' + timeAgo(item.created_at) + '</p>' +
                            '</div></div>'
                        ).join('');
                    } else {
                        rsvpList.innerHTML = '<p class="text-center text-gray-500 text-sm">Belum ada ucapan. Jadilah yang pertama!</p>';
                    }
                })
                .catch(err => console.error('Failed to load RSVP list:', err));
            }
            loadRsvpList();

            function timeAgo(dateString) {
                const now = new Date();
                const date = new Date(dateString);
                const seconds = Math.floor((now - date) / 1000);
                if (seconds < 60) return 'Baru saja';
                const minutes = Math.floor(seconds / 60);
                if (minutes < 60) return minutes + ' menit yang lalu';
                const hours = Math.floor(minutes / 60);
                if (hours < 24) return hours + ' jam yang lalu';
                const days = Math.floor(hours / 24);
                if (days < 30) return days + ' hari yang lalu';
                const months = Math.floor(days / 30);
                if (months < 12) return months + ' bulan yang lalu';
                return Math.floor(months / 12) + ' tahun yang lalu';
            }

            /* ---------- GALLERY LOAD MORE ---------- */
            window.loadMoreGallery = function() {
                const button = document.getElementById('loadMoreGallery');
                const text = document.getElementById('loadMoreText');
                const spinner = document.getElementById('loadMoreSpinner');
                if (!button) return;
                const visibleCount = document.querySelectorAll('#galleryGrid .gallery-item:not(.hidden)').length;
                const totalCount = document.querySelectorAll('#galleryGrid .gallery-item').length;
                if (visibleCount >= totalCount) return;
                if (text) text.textContent = 'Memuat...';
                if (spinner) spinner.classList.remove('hidden');
                button.disabled = true;
                setTimeout(() => {
                    const items = document.querySelectorAll('#galleryGrid .gallery-item.hidden');
                    let shown = 0;
                    items.forEach(item => {
                        if (shown < 6) { item.classList.remove('hidden'); shown++; }
                    });
                    if (text) text.textContent = visibleCount + shown >= totalCount ? 'Tampilkan Semua' : 'Lihat Lebih Banyak';
                    if (spinner) spinner.classList.add('hidden');
                    button.disabled = false;
                    if (visibleCount + shown >= totalCount) button.style.display = 'none';
                }, 300);
            };

            /* ---------- BOTTOM NAV ACTIVE SECTION ---------- */
            const bottomNavLinks = document.querySelectorAll('#bottomNav a[href^="#"]');
            const sections = [];
            bottomNavLinks.forEach(link => {
                const targetId = link.getAttribute('href').substring(1);
                const target = document.getElementById(targetId);
                if (target) sections.push({ id: targetId, element: target, link: link });
            });
            window.addEventListener('scroll', () => {
                let currentSection = '';
                sections.forEach(s => {
                    const rect = s.element.getBoundingClientRect();
                    if (rect.top <= window.innerHeight / 2) {
                        currentSection = s.id;
                    }
                });
                bottomNavLinks.forEach(link => {
                    link.classList.remove('bg-primary', 'text-white');
                    if (link.getAttribute('href') === '#' + currentSection) {
                        link.classList.add('bg-primary', 'text-white');
                    }
                });
            });

            /* ---------- SMOOTH SCROLL ---------- */
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        const offset = 80;
                        const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                        window.scrollTo({ top, behavior: 'smooth' });
                    }
                });
            });

        });
    </script>

</body>

</html>
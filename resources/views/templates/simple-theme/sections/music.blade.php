
    @php
        $ytMusicMatches = [];
        if (!empty($invitation->music_youtube_url)) {
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $invitation->music_youtube_url, $ytMusicMatches);
        }
        $youtubeMusicId = $ytMusicMatches['id'] ?? '';
    @endphp
    @if(!empty($youtubeMusicId))
    <div id="youtubePlayerContainer" class="youtube-player-container">
        <iframe id="youtubeIframe" width="2" height="2"
            src="https://www.youtube.com/embed/{{ $youtubeMusicId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeMusicId }}&controls=0&modestbranding=1&rel=0&mute=1"
            frameborder="0" allow="autoplay; encrypted-media; picture-in-picture"
            onload="window.ytIframeReady = true;">
        </iframe>
    </div>
    @endif
    @if(empty($youtubeMusicId))
    <audio id="bgMusic" loop>
        @if(!empty($invitation->music) && !isset($invitation->musicPreset))
            <source src="{{ asset('storage/' . $invitation->music) }}" type="audio/mpeg" />
        @elseif(!empty($invitation->musicPreset->audio_url))
            <source src="{{ asset('storage/' . $invitation->musicPreset->audio_url) }}" type="audio/mpeg" />
        @else
            <source src="https://www.bensound.com/bensound-music/bensound-romantic.mp3" type="audio/mpeg" />
        @endif
    </audio>
    @endif

    <!-- FOOTER -->
    <div class="text-center text-sm text-gray-500 animate-on-scroll">
        <p>Terima kasih atas doa dan restunya</p>
        <p class="font-serif text-primary mt-1">{{ $invitation->bride_name }} & {{ $invitation->groom_name }}
        </p>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ---------- 1. TOAST & COPY ---------- */
         function showToast(message) {
             const toast = document.getElementById('toast');
             toast.textContent = message;
             toast.className = 'show';
             setTimeout(() => { toast.className = toast.className.replace('show', ''); }, 3000);
         }

           window.copyText = function(text) {
             navigator.clipboard.writeText(text).then(() => {
                 showToast("Nomor rekening berhasil disalin!");
             }).catch(() => {
                 const ta = document.createElement('textarea');
                 ta.value = text;
                 ta.style.position = 'fixed';
                 ta.style.left = '-9999px';
                 document.body.appendChild(ta);
                 ta.select();
                 document.execCommand('copy');
                 document.body.removeChild(ta);
                 showToast("Nomor rekening berhasil disalin!");
             });
         };

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

        /* ---------- 2. MUSIC PLAYER ---------- */
        @if(!empty($youtubeMusicId))
        let ytIframe = document.getElementById('youtubeIframe');
        let ytMuted = true;
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');
        let hasInteracted = false;

        function toggleMusicIcon(isPlaying) {
            if (isPlaying) {
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9h2v6h-2V9zm4 0h2v6h-2V9z" />';
                musicBtn.classList.add('playing');
            } else {
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.518-3.759A1 1 0 007 8.32v7.36a1 1 0 001.234.97l6.518-1.885a1 1 0 00.75-.97v-1.87a1 1 0 00-.75-.97z" />';
                musicBtn.classList.remove('playing');
            }
        }

        function sendYtCommand(command) {
            if (!ytIframe) return;
            const msg = JSON.stringify({ event: 'command', func: command, args: [] });
            if (window.ytIframeReady) {
                setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 200);
            } else {
                const check = setInterval(() => {
                    if (window.ytIframeReady) { clearInterval(check); setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 200); }
                }, 100);
                setTimeout(() => { clearInterval(check); setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 500); }, 2000);
            }
        }

        function pauseYoutube() { sendYtCommand('pauseVideo'); sendYtCommand('pause'); toggleMusicIcon(false); }
        function playYoutube() {
            if (ytMuted) { sendYtCommand('unMute'); ytMuted = false; }
            sendYtCommand('playVideo'); sendYtCommand('play'); toggleMusicIcon(true);
        }

        window.addEventListener('scroll', () => { if (!hasInteracted) { playYoutube(); hasInteracted = true; } }, { once: true });
        musicBtn.addEventListener('click', () => { if (ytMuted || !hasInteracted) { playYoutube(); hasInteracted = true; } else { pauseYoutube(); } });
        document.addEventListener('visibilitychange', () => { if (document.hidden) { pauseYoutube(); } else if (hasInteracted && !ytMuted) { playYoutube(); } });
        @else
        const bgMusic = document.getElementById('bgMusic');
        const musicBtn = document.getElementById('musicToggle');
        const musicIcon = document.getElementById('musicIcon');
        let isPlaying = false;
        let hasOpened = false;

        function toggleMusicIcon(playing) {
            if (playing) {
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9h2v6h-2V9zm4 0h2v6h-2V9z" />';
            } else {
                musicIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-6.518-3.759A1 1 0 007 8.32v7.36a1 1 0 001.234.97l6.518-1.885a1 1 0 00.75-.97v-1.87a1 1 0 00-.75-.97z" />';
            }
        }

        const openBtn = document.getElementById('openInvitation');
        openBtn?.addEventListener('click', () => {
            bgMusic?.play();
            isPlaying = true;
            hasOpened = true;
            toggleMusicIcon(true);
            document.body.classList.remove('lock-scroll');
            document.getElementById('content')?.scrollIntoView({ behavior: 'smooth' });
        });

        musicBtn?.addEventListener('click', () => {
            if (bgMusic.paused) {
                bgMusic.play();
                toggleMusicIcon(true);
            } else {
                bgMusic.pause();
                toggleMusicIcon(false);
            }
            isPlaying = !bgMusic.paused;
        });

        document.addEventListener("visibilitychange", () => {
            if (!hasOpened) return;
            if (document.hidden) {
                bgMusic?.pause();
                toggleMusicIcon(false);
            } else {
                bgMusic?.play();
                toggleMusicIcon(true);
            }
        });
        @endif

        /* ---------- 3. COUNTDOWN ---------- */
        const weddingDate = new Date('{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Y-m-d H:i:s") }}').getTime();
        const countdownGrid = document.getElementById('countdownGrid');
        const countdownPassed = document.getElementById('countdownPassed');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            if (distance < 0) {
                if (countdownGrid) countdownGrid.classList.add('hidden');
                if (countdownPassed) countdownPassed.classList.remove('hidden');
                return;
            }
            const daysEl = document.getElementById('days');
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            const secondsEl = document.getElementById('seconds');
            if (daysEl) daysEl.textContent = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
            if (hoursEl) hoursEl.textContent = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
        }
        updateCountdown();
        setInterval(updateCountdown, 1000);

        /* ---------- 4. SCROLL ANIMATIONS ---------- */
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('show'); } });
        }, { threshold: 0.1 });
        document.querySelectorAll('.animate-on-scroll, .fade-in').forEach(el => observer.observe(el));

        /* ---------- 4b. BOTTOM NAV HIDE/SHOW ---------- */
        const bottomNav = document.getElementById('bottomNav');
        const heroSection = document.getElementById('home');
        if (bottomNav && heroSection) {
            window.addEventListener('scroll', () => {
                const heroRect = heroSection.getBoundingClientRect();
                if (heroRect.bottom > 0) {
                    bottomNav.style.transform = 'translateY(100%)';
                    bottomNav.style.transition = 'transform 0.3s ease';
                } else {
                    bottomNav.style.transform = 'translateY(0)';
                }
            });
        }

        /* ---------- 4c. BOTTOM NAV ACTIVE SECTION ---------- */
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
                link.classList.remove('bg-primary', 'text-white', 'rounded-full', 'px-4', 'py-1');
                if (link.getAttribute('href') === '#' + currentSection) {
                    link.classList.add('bg-primary', 'text-white', 'rounded-full', 'px-4', 'py-1');
                }
            });
        });

        /* ---------- 5. REMINDER BUTTON ---------- */
        const reminderBtn = document.getElementById('reminderBtn');
        if (reminderBtn) {
            if (localStorage.getItem('weddingReminder')) {
                reminderBtn.style.display = 'none';
            }
            reminderBtn.addEventListener('click', () => {
                const startDate = '{{ \Carbon\Carbon::parse($invitation->wedding_date)->format("Ymd\\THis") }}';
                const endDate = '{{ \Carbon\Carbon::parse($invitation->wedding_date)->addHours(5)->format("Ymd\\THis") }}';
                const gcalUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE&text=Pernikahan+{{ urlencode($invitation->groom_nickname . ' & ' . $invitation->bride_nickname) }}&dates=' + startDate + '/' + endDate + '&details=Undangan+pernikahan&location={{ urlencode($invitation->resepsi_location ?? '') }}';
                window.open(gcalUrl, '_blank');
                showToast('Membuka Google Calendar...');
            });
        }

        /* ---------- 6. RSVP FORM ---------- */
        const rsvpForm = document.getElementById('rsvpForm');
        const rsvpButton = document.getElementById('rsvpButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');
        const rsvpMessage = document.getElementById('rsvpMessage');

        if (rsvpForm) {
            rsvpForm.addEventListener('submit', function(e) {
                e.preventDefault();

                var form = this;
                var formData = new FormData(form);
                var submitUrl = form.getAttribute('action');

                if (!submitUrl) {
                    showToast('URL form tidak ditemukan.');
                    return;
                }

                buttonText.textContent = 'Mengirim...';
                buttonSpinner.classList.remove('hidden');
                rsvpButton.disabled = true;
                rsvpMessage.classList.add('hidden');

                fetch(submitUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(function(response) {
                    if (!response.ok) {
                        return response.json().then(function(data) {
                            throw new Error(data.message || 'Gagal mengirim ucapan.');
                        }).catch(function(err) {
                            if (err.message && err.message !== 'Gagal mengirim ucapan.') throw err;
                            throw new Error('Gagal mengirim ucapan. Silakan coba lagi.');
                        });
                    }
                    return response.json();
                })
                .then(function(data) {
                    rsvpMessage.textContent = 'Terima kasih! Ucapan Anda telah terkirim.';
                    rsvpMessage.style.color = '#22c55e';
                    rsvpMessage.classList.remove('hidden');
                    form.reset();
                    loadRsvpList();
                    showToast('Ucapan berhasil dikirim!');
                    setTimeout(function() { rsvpMessage.classList.add('hidden'); }, 5000);
                })
                .catch(function(err) {
                    rsvpMessage.textContent = err.message || 'Terjadi kesalahan jaringan. Silakan coba lagi.';
                    rsvpMessage.style.color = '#ef4444';
                    rsvpMessage.classList.remove('hidden');
                    setTimeout(function() { rsvpMessage.classList.add('hidden'); }, 5000);
                })
                .finally(function() {
                    buttonText.textContent = 'Kirim Ucapan';
                    buttonSpinner.classList.add('hidden');
                    rsvpButton.disabled = false;
                });
            });
        }

        /* ---------- 7. LOAD RSVP LIST ---------- */
        function loadRsvpList() {
            var rsvpList = document.getElementById('rsvpList');
            if (!rsvpList) return;

            var listUrl = rsvpList.getAttribute('data-url');
            if (!listUrl) return;

            fetch(listUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data && data.length > 0) {
                    rsvpList.innerHTML = data.map(function(item) {
                        return '<div class="comment-item flex gap-3 mb-4 pb-4 border-b border-outline-variant/30 last:border-0 last:mb-0 last:pb-0">'
                            + '<div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center flex-shrink-0">'
                            + '<span class="material-symbols-outlined text-outline-variant" style="font-size:20px;">person</span>'
                            + '</div>'
                            + '<div class="flex-1 min-w-0">'
                            + '<p class="font-body-md text-body-md font-semibold text-primary mb-1">' + item.name + '</p>'
                            + '<p class="font-body-md text-body-md text-on-surface-variant text-sm leading-relaxed">' + item.message + '</p>'
                            + '<p class="font-label-sm text-label-sm text-outline mt-1">' + timeAgo(item.created_at) + '</p>'
                            + '</div>'
                            + '</div>';
                    }).join('');
                } else {
                    rsvpList.innerHTML = '<p class="font-body-md text-body-md text-on-surface-variant text-center mb-2">Belum ada ucapan. Jadilah yang pertama!</p><span class="material-symbols-outlined text-primary block text-center mb-2">favorite</span>';
                }
            })
            .catch(function(err) { console.error('Failed to load RSVP list:', err); });
        }
        loadRsvpList();

        /* ---------- 8. SMOOTH SCROLL ---------- */
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                var target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    var offset = 80;
                    var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                }
            });
        });

        /* ---------- GALLERY LOAD MORE ---------- */
        window.loadMoreGallery = function() {
            var button = document.getElementById('loadMoreGallery');
            var text = document.getElementById('loadMoreText');
            var spinner = document.getElementById('loadMoreSpinner');
            if (!button) return;
            var visibleCount = document.querySelectorAll('#galleryGrid .gallery-item:not(.hidden)').length;
            var totalCount = document.querySelectorAll('#galleryGrid .gallery-item').length;
            if (visibleCount >= totalCount) return;
            text.textContent = 'Memuat...';
            spinner.classList.remove('hidden');
            button.disabled = true;
            setTimeout(function() {
                var items = document.querySelectorAll('#galleryGrid .gallery-item.hidden');
                var shown = 0;
                items.forEach(function(item) {
                    if (shown < 6) {
                        item.classList.remove('hidden');
                        shown++;
                    }
                });
                text.textContent = visibleCount + shown >= totalCount ? 'Tampilkan Semua' : 'Lihat Lebih Banyak';
                spinner.classList.add('hidden');
                button.disabled = false;
                if (visibleCount + shown >= totalCount) {
                    button.style.display = 'none';
                }
            }, 300);
        };

    });
    </script>

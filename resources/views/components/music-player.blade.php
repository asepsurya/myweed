@php
    $musicId = $invitation->music ?? null;
    $youtubeUrl = $invitation->music_youtube_url ?? $invitation->youtube_url ?? null;
    $youtubeId = '';
    if ($youtubeUrl) {
        preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)(?<id>[A-Za-z0-9_-]{11}))/i', $youtubeUrl, $ytMatches);
        $youtubeId = $ytMatches['id'] ?? '';
    }
    $isCustomUpload = $musicId && !is_numeric($musicId);
    $apiMusicId = $isCustomUpload ? '' : $musicId;
    $customAudioUrl = $isCustomUpload ? ($musicId ? Storage::disk('public')->url($musicId) : '') : '';
@endphp

<style>
    .music-waveform-container {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, opacity 0.3s ease, padding 0.3s ease;
        opacity: 0;
        padding: 0;
    }

    .music-waveform-container.active {
        max-height: 120px;
        opacity: 1;
        padding: 8px 0;
    }

    .music-waveform-canvas {
        width: 100%;
        height: 80px;
        display: block;
    }

    @media (max-width: 576px) {
        .music-waveform-container.active {
            max-height: 90px;
        }

        .music-waveform-canvas {
            height: 60px;
        }
    }
</style>

<style>
    .youtube-player-container {
        position: fixed;
        bottom: 0;
        right: 0;
        width: 2px;
        height: 2px;
        overflow: hidden;
        opacity: 0;
        pointer-events: none;
        z-index: -1;
    }

    /* ====== Tombol Musik Konsep Wedding (Lebih Kecil & Glassmorphism) ====== */
    .music-toggle-btn {
        position: fixed;
        top: 16px;
        right: 16px;
        z-index: 1050;
        width: 42px;
        /* Ukuran lebih kecil */
        height: 42px;
        border-radius: 50%;
        border: 1.5px solid rgba(212, 175, 55, 0.4);
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        color: #D4AF37;
        /* Warna Emas */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
    }

    .music-toggle-btn:hover {
        transform: scale(1.08);
        border-color: rgba(212, 175, 55, 0.8);
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
    }

    .music-toggle-btn svg {
        width: 18px;
        /* Ikon lebih kecil */
        height: 18px;
        position: relative;
        z-index: 4;
        transition: all 0.3s ease;
        filter: drop-shadow(0 0 3px rgba(212, 175, 55, 0.6));
    }

    /* Sembunyikan ikon SVG saat playing */
    .music-toggle-btn.playing svg {
        opacity: 0;
        transform: scale(0);
    }

    /* Efek Glow saat Playing */
    .music-toggle-btn.playing {
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.5), 0 4px 15px rgba(255, 158, 181, 0.4);
    }

    /* Equalizer Bars */
    .wed-equalizer {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 2px;
        height: 14px;
        /* Eq lebih kecil */
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .music-toggle-btn.playing .wed-equalizer {
        opacity: 1;
    }

    .wed-eq-bar {
        width: 3px;
        height: 100%;
        background: linear-gradient(to top, #D4AF37, #FF9EB5);
        border-radius: 4px;
        transform-origin: center;
    }

    .music-toggle-btn.playing .wed-eq-bar:nth-child(1) {
        animation: wed-eq-bounce 1s ease-in-out infinite;
    }

    .music-toggle-btn.playing .wed-eq-bar:nth-child(2) {
        animation: wed-eq-bounce 1s ease-in-out infinite 0.2s;
    }

    .music-toggle-btn.playing .wed-eq-bar:nth-child(3) {
        animation: wed-eq-bounce 1s ease-in-out infinite 0.4s;
    }

    .music-toggle-btn.playing .wed-eq-bar:nth-child(4) {
        animation: wed-eq-bounce 1s ease-in-out infinite 0.6s;
    }

    @keyframes wed-eq-bounce {

        0%,
        100% {
            transform: scaleY(0.3);
        }

        50% {
            transform: scaleY(1);
        }
    }

    /* Pulsing Rings */
    .wed-pulse-ring {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        border: 1.5px solid #D4AF37;
        opacity: 0;
        pointer-events: none;
    }

    .music-toggle-btn.playing .wed-pulse-ring {
        animation: wedding-pulse 2.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }

    .music-toggle-btn.playing .wed-pulse-ring:nth-child(2) {
        animation-delay: 0.8s;
    }

    .music-toggle-btn.playing .wed-pulse-ring:nth-child(3) {
        animation-delay: 1.6s;
    }

    @keyframes wedding-pulse {
        0% {
            transform: scale(1);
            opacity: 0.7;
            border-color: #D4AF37;
        }

        50% {
            border-color: #FF9EB5;
        }

        100% {
            transform: scale(2.3);
            opacity: 0;
            border-color: #FF9EB5;
        }
    }

    /* Floating Hearts & Flowers */
    .wed-floats {
        position: absolute;
        inset: 0;
        pointer-events: none;
        overflow: visible;
    }

    .wed-float {
        position: absolute;
        bottom: 50%;
        font-size: 10px;
        /* Float lebih kecil */
        opacity: 0;
        pointer-events: none;
    }

    .music-toggle-btn.playing .wed-float {
        animation: float-romantic 3.5s ease-out infinite;
    }

    .music-toggle-btn.playing .wed-float:nth-child(1) {
        left: 20%;
        animation-delay: 0s;
        color: #FF9EB5;
    }

    .music-toggle-btn.playing .wed-float:nth-child(2) {
        left: 45%;
        animation-delay: 1s;
        color: #D4AF37;
    }

    .music-toggle-btn.playing .wed-float:nth-child(3) {
        left: 70%;
        animation-delay: 2s;
        color: #FF9EB5;
    }

    .music-toggle-btn.playing .wed-float:nth-child(4) {
        left: 30%;
        animation-delay: 2.5s;
        color: #F7E7CE;
    }

    @keyframes float-romantic {
        0% {
            opacity: 0;
            transform: translateY(0) translateX(0) rotate(0deg) scale(0.5);
        }

        20% {
            opacity: 1;
            transform: translateY(-12px) translateX(0) rotate(15deg) scale(1);
        }

        80% {
            opacity: 0.8;
            transform: translateY(-35px) translateX(5px) rotate(-10deg) scale(0.8);
        }

        100% {
            opacity: 0;
            transform: translateY(-50px) translateX(-5px) rotate(20deg) scale(0.4);
        }
    }
</style>

@if(($invitation->enable_music ?? true) && ($musicId || $youtubeId || $isCustomUpload))
    <button type="button" id="musicToggle" class="music-toggle-btn" aria-label="Play/Pause Music">
        {{-- Pulse rings --}}
        <span class="wed-pulse-ring"></span>
        <span class="wed-pulse-ring"></span>
        <span class="wed-pulse-ring"></span>

        {{-- Equalizer bars (visible when playing) --}}
        <span class="wed-equalizer">
            <span class="wed-eq-bar"></span>
            <span class="wed-eq-bar"></span>
            <span class="wed-eq-bar"></span>
            <span class="wed-eq-bar"></span>
        </span>

        {{-- Original Icon (Play/Pause) --}}
        <svg id="musicIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24"
            height="24">
            <path d="M8 5v14l11-7z" />
        </svg>

        {{-- Floating hearts and flowers --}}
        <span class="wed-floats">
            <span class="wed-float">♥</span>
            <span class="wed-float">✦</span>
            <span class="wed-float">♥</span>
            <span class="wed-float">✿</span>
        </span>
    </button>

    <div id="wedding-music-player" class="wedding-music-player" style="display:none;" data-music-id="{{ $apiMusicId }}"
        data-youtube-id="{{ $youtubeId }}" data-custom-audio="{{ $customAudioUrl }}">
        <div class="music-player-inner">
            <div class="music-player-info">
                <img id="musicCover" src="" alt="Cover" class="music-cover rounded-circle border">
                <div class="music-details">
                    <div id="musicTitle" class="music-title fw-semibold small mb-0">Memuat...</div>
                    <div id="musicArtist" class="music-artist text-muted mb-0" style="font-size: 11px;">-</div>
                </div>
            </div>
            <div class="music-player-controls d-flex align-items-center gap-2">
                <span id="musicCurrentTime" class="music-time small text-muted">0:00</span>
                <input type="range" id="musicProgress" class="music-progress" value="0" min="0" max="100" step="0.1">
                <span id="musicDuration" class="music-time small text-muted">0:00</span>
            </div>
            <div class="music-volume-control d-flex align-items-center gap-1">
                <i class="bi bi-volume-up text-muted" style="font-size: 12px;"></i>
                <input type="range" id="musicVolume" class="music-volume" value="40" min="0" max="100" step="1">
            </div>
        </div>
        <div id="musicWaveformContainer" class="music-waveform-container">
            <canvas id="musicWaveformCanvas" class="music-waveform-canvas" width="600" height="80"></canvas>
        </div>
    </div>

    @if($youtubeId)
        <div id="youtubePlayerContainer" class="youtube-player-container">
            <iframe id="youtubeIframe" width="2" height="2"
                src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeId }}&controls=0&modestbranding=1&rel=0&mute=1"
                frameborder="0" allow="autoplay; encrypted-media; picture-in-picture">
            </iframe>
        </div>
    @endif

    <audio id="bgMusic" loop style="display:none;" preload="auto"></audio>

    <script>
        (function () {
            const musicId = "{{ $musicId }}";
            const youtubeId = "{{ $youtubeId }}";
            const customAudioUrl = "{{ $customAudioUrl }}";
            const isYoutube = youtubeId.length > 0;
            const isCustom = "{{ $isCustomUpload ? 'true' : 'false' }}" === 'true';
            const isPreviewMode = "{{ request('muted') ? '1' : '0' }}" === '1';
            let muteFromParent = false;
            const bgMusic = document.getElementById('bgMusic');
            if (bgMusic && isPreviewMode) {
                bgMusic.muted = true;
            }

            window.addEventListener('message', (e) => {
                if (e.data && e.data.type === 'mute-music') {
                    muteFromParent = true;
                    if (bgMusic) bgMusic.muted = true;
                }
                if (e.data && e.data.type === 'unmute-music') {
                    muteFromParent = false;
                    if (bgMusic) bgMusic.muted = false;
                }
            });
            const musicToggle = document.getElementById('musicToggle');
            const musicIcon = document.getElementById('musicIcon');
            const musicCover = document.getElementById('musicCover');
            const musicTitle = document.getElementById('musicTitle');
            const musicArtist = document.getElementById('musicArtist');
            const musicProgress = document.getElementById('musicProgress');
            const musicCurrentTime = document.getElementById('musicCurrentTime');
            const musicDuration = document.getElementById('musicDuration');
            const musicVolume = document.getElementById('musicVolume');
            const waveformContainer = document.getElementById('musicWaveformContainer');
            const waveformCanvas = document.getElementById('musicWaveformCanvas');
            let ytIframe = null;
            let ytPlaying = false;
            let ytMuted = true;
            let waveformAudioCtx = null;
            let waveformAnalyser = null;
            let waveformSource = null;
            let waveformDataArray = null;
            let waveformAnimationId = null;
            let waveformSourceCreated = false;
            let currentAudioSrc = '';
            let audioReady = false;

            function formatTime(seconds) {
                if (!seconds || isNaN(seconds)) return '0:00';
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return mins + ':' + String(secs).padStart(2, '0');
            }

            function setPlayIcon() {
                musicIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
                if (musicToggle) musicToggle.classList.remove('playing');
            }

            function setPauseIcon() {
                musicIcon.innerHTML = '<path d="M6 5h4v14H6zm8 0h4v14h-4z"/>';
                if (musicToggle) musicToggle.classList.add('playing');
            }

            function showWaveform() {
                if (waveformContainer) waveformContainer.classList.add('active');
            }

            function hideWaveform() {
                if (waveformContainer) waveformContainer.classList.remove('active');
                stopWaveformAnimation();
            }

            function stopWaveformAnimation() {
                if (waveformAnimationId) {
                    cancelAnimationFrame(waveformAnimationId);
                    waveformAnimationId = null;
                }
            }

            function ensureAudioContext() {
                if (waveformSourceCreated) {
                    if (waveformAudioCtx && waveformAudioCtx.state === 'suspended') {
                        waveformAudioCtx.resume();
                    }
                    return true;
                }

                try {
                    waveformAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
                    waveformSource = waveformAudioCtx.createMediaElementSource(bgMusic);
                    waveformAnalyser = waveformAudioCtx.createAnalyser();
                    waveformAnalyser.fftSize = 128;
                    waveformSource.connect(waveformAnalyser);
                    waveformAnalyser.connect(waveformAudioCtx.destination);
                    waveformDataArray = new Uint8Array(waveformAnalyser.frequencyBinCount);
                    waveformSourceCreated = true;
                    return true;
                } catch (e) {
                    console.error('Waveform init failed:', e);
                    return false;
                }
            }

            function drawWaveform() {
                if (!waveformAnalyser || !waveformDataArray || !waveformCanvas) return;

                const ctx = waveformCanvas.getContext('2d');
                const dpr = window.devicePixelRatio || 1;
                const rect = waveformCanvas.getBoundingClientRect();

                if (waveformCanvas.width !== Math.floor(rect.width * dpr) || waveformCanvas.height !== Math.floor(rect.height * dpr)) {
                    waveformCanvas.width = Math.floor(rect.width * dpr);
                    waveformCanvas.height = Math.floor(rect.height * dpr);
                }

                const displayWidth = rect.width;
                const displayHeight = rect.height;

                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                waveformAnalyser.getByteFrequencyData(waveformDataArray);

                ctx.clearRect(0, 0, displayWidth, displayHeight);

                const totalBars = waveformDataArray.length;
                const gap = 2;
                const barWidth = Math.max(3, (displayWidth - gap * totalBars) / totalBars);
                const maxBarHeight = displayHeight * 0.85;
                const centerY = displayHeight / 2;
                let x = 0;

                for (let i = 0; i < totalBars; i++) {
                    const value = waveformDataArray[i] / 255;
                    const barHeight = Math.max(4, value * maxBarHeight);

                    const gradient = ctx.createLinearGradient(0, centerY - barHeight / 2, 0, centerY + barHeight / 2);
                    gradient.addColorStop(0, '#D4AF37');
                    gradient.addColorStop(0.5, '#FF9EB5');
                    gradient.addColorStop(1, '#D4AF37');

                    ctx.fillStyle = gradient;
                    if (ctx.roundRect) {
                        ctx.beginPath();
                        ctx.roundRect(x, centerY - barHeight / 2, barWidth, barHeight, 3);
                        ctx.fill();
                    } else {
                        ctx.fillRect(x, centerY - barHeight / 2, barWidth, barHeight);
                    }

                    x += barWidth + gap;
                }

                waveformAnimationId = requestAnimationFrame(drawWaveform);
            }

            function startWaveformAnimation() {
                if (!waveformCanvas) return;

                if (!ensureAudioContext()) {
                    return;
                }

                showWaveform();
                drawWaveform();
            }

            function isAudioPlaying() {
                if (isYoutube) {
                    return ytPlaying;
                }
                if (!bgMusic || !bgMusic.src) return false;
                return !bgMusic.paused;
            }

            async function playAudio() {
                if (!bgMusic || !bgMusic.src) {
                    console.log('playAudio: bgMusic or src missing');
                    return;
                }

                if (isAudioPlaying()) {
                    return;
                }

                bgMusic.volume = (musicVolume ? musicVolume.value / 100 : 0.4);

                if (waveformAudioCtx && waveformAudioCtx.state === 'suspended') {
                    await waveformAudioCtx.resume();
                }

                // TRIK AUTO-PLAY: Mute sebentar untuk mengakali browser, lalu langsung unmute
                bgMusic.muted = true;
                const playPromise = bgMusic.play();

                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        if (!isPreviewMode && !muteFromParent) {
                            bgMusic.muted = false;
                        }
                        setPauseIcon();
                        startWaveformAnimation();
                    }).catch((e) => {
                        console.log('Autoplay blocked by browser:', e);
                        if (!isPreviewMode && !muteFromParent) {
                            bgMusic.muted = false;
                        }
                        setPlayIcon();
                    });
                }
            }

            function pauseAudio() {
                if (!bgMusic) return;

                if (bgMusic.paused) {
                    return;
                }

                bgMusic.pause();
                setPlayIcon();
                stopWaveformAnimation();
            }

            function sendYtCommand(command, args) {
                if (!ytIframe) return;
                const msg = JSON.stringify({ event: 'command', func: command, args: args ? args : [] });
                try {
                    ytIframe.contentWindow.postMessage(msg, '*');
                } catch (e) {
                    console.warn('YouTube command failed:', e);
                }
            }

            function pauseYoutube() { 
                sendYtCommand('pauseVideo'); 
                sendYtCommand('pause'); 
                setPlayIcon(); 
                stopWaveformAnimation(); 
                ytPlaying = false; 
            }
            function playYoutube() {
                if (isPreviewMode || muteFromParent) {
                    sendYtCommand('mute');
                    ytMuted = true;
                } else {
                    sendYtCommand('unMute');
                    ytMuted = false;
                }
                sendYtCommand('playVideo');
                setTimeout(() => sendYtCommand('setVolume', [100]), 500);
                ytPlaying = true;
                setPauseIcon();
            }

            function toggleMusic() {
                if (isAudioPlaying()) {
                    if (isYoutube) pauseYoutube();
                    else pauseAudio();
                } else {
                    if (isYoutube) playYoutube();
                    else playAudio();
                }
            }

            async function loadMusicData() {
                if (isYoutube || isCustom) return;

                const rawMusicId = musicId || document.getElementById('wedding-music-player')?.dataset?.musicId;
                const numericId = Number(rawMusicId);

                if (!rawMusicId || !Number.isInteger(numericId) || numericId <= 0) {
                    musicTitle.textContent = 'Pilih musik terlebih dahulu';
                    return;
                }

                try {
                    const response = await fetch('/api/music/' + numericId);
                    if (!response.ok) throw new Error('Failed to fetch music');
                    const musicData = await response.json();

                    if (musicData.title) musicTitle.textContent = musicData.title;
                    if (musicData.artist) musicArtist.textContent = musicData.artist;
                    if (musicData.cover) musicCover.src = musicData.cover;
                    if (musicData.audio) {
                        const newSrc = musicData.audio;
                        if (currentAudioSrc !== newSrc) {
                            currentAudioSrc = newSrc;
                            bgMusic.src = newSrc;
                            bgMusic.load();
                            audioReady = false;
                        }
                    }
                } catch (e) {
                    console.error('Failed to load music data:', e);
                    musicTitle.textContent = 'Gagal memuat lagu';
                }
            }

            function loadCustomAudio() {
                if (!isCustom || !customAudioUrl) return;
                currentAudioSrc = customAudioUrl;
                bgMusic.src = customAudioUrl;
                bgMusic.load();
                musicTitle.textContent = 'Custom Upload';
                musicArtist.textContent = '';
                musicCover.src = "{{ asset('tempelate/no_sound.webp') }}";
                audioReady = false;
            }

            if (musicToggle) {
                musicToggle.addEventListener('click', () => {
                    toggleMusic();
                });
            }

            if (musicVolume) {
                musicVolume.addEventListener('input', () => {
                    if (bgMusic) bgMusic.volume = musicVolume.value / 100;
                });
            }

            if (bgMusic) {
                bgMusic.addEventListener('timeupdate', () => {
                    if (bgMusic.duration) {
                        const progress = (bgMusic.currentTime / bgMusic.duration) * 100;
                        musicProgress.value = progress;
                        musicCurrentTime.textContent = formatTime(bgMusic.currentTime);
                        musicDuration.textContent = formatTime(bgMusic.duration);
                    }
                });

                bgMusic.addEventListener('loadedmetadata', () => {
                    musicDuration.textContent = formatTime(bgMusic.duration);
                    audioReady = true;
                });

                bgMusic.addEventListener('ended', () => {
                    bgMusic.currentTime = 0;
                    hideWaveform();
                    setPlayIcon();
                });

                bgMusic.addEventListener('pause', () => {
                    setPlayIcon();
                    hideWaveform();
                });

                bgMusic.addEventListener('error', (e) => {
                    console.error('Music player error:', e);
                    setPlayIcon();
                    hideWaveform();
                });

                bgMusic.volume = 0.4;
            }

            if (musicProgress) {
                musicProgress.addEventListener('input', () => {
                    if (bgMusic && bgMusic.duration) {
                        bgMusic.currentTime = (musicProgress.value / 100) * bgMusic.duration;
                    }
                });
            }

            // LOGIKA AUTOPLAY DIPERCEPAT
            if (isYoutube) {
                ytIframe = document.getElementById('youtubeIframe');
                setTimeout(() => {
                    if (!isAudioPlaying()) {
                        if (isPreviewMode || muteFromParent) {
                            sendYtCommand('mute');
                            ytMuted = true;
                        } else {
                            sendYtCommand('unMute');
                            ytMuted = false;
                        }
                        sendYtCommand('playVideo');
                        setTimeout(() => sendYtCommand('setVolume', [100]), 500);
                        ytPlaying = true;
                        setPauseIcon();
                    }
                }, 300);
            } else if (isCustom) {
                setTimeout(() => loadCustomAudio(), 0);
                const shouldAutoplay = !isPreviewMode && !muteFromParent;
                if (shouldAutoplay) {
                    setTimeout(() => {
                        if (!isAudioPlaying()) playAudio();
                    }, 400);
                }
            } else {
                setTimeout(() => {
                    loadMusicData().then(() => {
                        const shouldAutoplay = !isPreviewMode && !muteFromParent;
                        if (shouldAutoplay) {
                            setTimeout(() => {
                                if (!isAudioPlaying()) playAudio();
                            }, 400);
                        }
                    }).catch(() => {
                        const shouldAutoplay = !isPreviewMode && !muteFromParent;
                        if (shouldAutoplay) {
                            setTimeout(() => {
                                if (!isAudioPlaying()) playAudio();
                            }, 400);
                        }
                    });
                }, 0);
            }
        })();
    </script>
@endif
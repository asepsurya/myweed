@props(['invitation'])

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
.music-toggle-btn {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background: linear-gradient(135deg, #FF6B81, #e84a6a);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(255, 107, 129, 0.4);
    transition: transform 0.2s ease;
}
.music-toggle-btn:hover {
    transform: scale(1.05);
}
.music-toggle-btn svg {
    width: 20px;
    height: 20px;
}
</style>

@if($musicId || $youtubeId)
<button type="button" id="musicToggle" class="music-toggle-btn" aria-label="Play/Pause Music">
    <svg id="musicIcon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
        <path d="M8 5v14l11-7z"/>
    </svg>
</button>

<div id="wedding-music-player" class="wedding-music-player" style="display:none;" data-music-id="{{ $apiMusicId }}" data-youtube-id="{{ $youtubeId }}" data-custom-audio="{{ $customAudioUrl }}">
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
<div id="youtubePlayerContainer" class="youtube-player-container" style="display:none;">
    <iframe id="youtubeIframe" width="2" height="2"
        src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&autoplay=1&loop=1&playlist={{ $youtubeId }}&controls=0&modestbranding=1&rel=0&mute=1"
        frameborder="0" allow="autoplay; encrypted-media; picture-in-picture"
        onload="window.ytIframeReady = true;">
    </iframe>
</div>
@endif

<audio id="bgMusic" loop style="display:none;"></audio>

<script>
(function() {
    const musicId = "{{ $musicId }}";
    const youtubeId = "{{ $youtubeId }}";
    const customAudioUrl = "{{ $customAudioUrl }}";
    const isYoutube = youtubeId.length > 0;
    const isCustom = "{{ $isCustomUpload ? 'true' : 'false' }}" === 'true';
    const bgMusic = document.getElementById('bgMusic');
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
    let musicData = null;
    let isPlaying = false;
    let hasInteracted = false;
    let ytIframe = null;
    let ytMuted = true;
    let waveformAudioCtx = null;
    let waveformAnalyser = null;
    let waveformSource = null;
    let waveformDataArray = null;
    let waveformAnimationId = null;

    function formatTime(seconds) {
        if (!seconds || isNaN(seconds)) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return mins + ':' + String(secs).padStart(2, '0');
    }

    function setPlayIcon() {
        musicIcon.innerHTML = '<path d="M8 5v14l11-7z"/>';
    }

    function setPauseIcon() {
        musicIcon.innerHTML = '<path d="M6 5h4v14H6zm8 0h4v14h-4z"/>';
    }

    function showWaveform() {
        if (waveformContainer) {
            waveformContainer.classList.add('active');
        }
    }

    function hideWaveform() {
        if (waveformContainer) {
            waveformContainer.classList.remove('active');
        }
        stopWaveformAnimation();
    }

    function stopWaveformAnimation() {
        if (waveformAnimationId) {
            cancelAnimationFrame(waveformAnimationId);
            waveformAnimationId = null;
        }
        if (waveformAnalyser) {
            waveformAnalyser.disconnect();
            waveformAnalyser = null;
        }
        if (waveformAudioCtx && waveformAudioCtx.state !== 'closed') {
            waveformAudioCtx.close().catch(() => {});
            waveformAudioCtx = null;
        }
        waveformSource = null;
        waveformDataArray = null;
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
            gradient.addColorStop(0, '#0d9488');
            gradient.addColorStop(0.5, '#14b8a6');
            gradient.addColorStop(1, '#0d9488');

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

        if (!waveformAudioCtx) {
            try {
                waveformAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
                waveformSource = waveformAudioCtx.createMediaElementSource(bgMusic);
                waveformAnalyser = waveformAudioCtx.createAnalyser();
                waveformAnalyser.fftSize = 128;
                waveformSource.connect(waveformAnalyser);
                waveformAnalyser.connect(waveformAudioCtx.destination);
                waveformDataArray = new Uint8Array(waveformAnalyser.frequencyBinCount);
            } catch (e) {
                console.error('Waveform init failed (CORS?):', e);
                return;
            }
        }

        if (waveformAudioCtx.state === 'suspended') {
            waveformAudioCtx.resume();
        }

        showWaveform();
        drawWaveform();
    }

    function playAudio() {
        if (!bgMusic || !bgMusic.src) {
            console.log('playAudio: bgMusic or src missing');
            return;
        }
        console.log('playAudio: src=', bgMusic.src, 'volume=', bgMusic.volume);
        bgMusic.volume = (musicVolume ? musicVolume.value / 100 : 0.4);
        bgMusic.play().then(() => {
            console.log('playAudio: success');
            hasInteracted = true;
            isPlaying = true;
            setPauseIcon();
            startWaveformAnimation();
        }).catch(e => console.log('playAudio failed:', e));
    }

    function pauseAudio() {
        if (!bgMusic) return;
        bgMusic.pause();
        isPlaying = false;
        setPlayIcon();
        stopWaveformAnimation();
    }

    function sendYtCommand(command, args) {
        if (!ytIframe) return;
        const msg = JSON.stringify({ event: 'command', func: command, args: args ? args : [] });
        if (window.ytIframeReady) {
            setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 200);
        } else {
            const check = setInterval(() => {
                if (window.ytIframeReady) { clearInterval(check); setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 200); }
            }, 100);
            setTimeout(() => { clearInterval(check); setTimeout(() => ytIframe.contentWindow.postMessage(msg, '*'), 500); }, 2000);
        }
    }

    function pauseYoutube() { sendYtCommand('pauseVideo'); sendYtCommand('pause'); setPlayIcon(); stopWaveformAnimation(); }
    function playYoutube() {
        if (ytMuted) { sendYtCommand('unMute'); ytMuted = false; }
        sendYtCommand('playVideo');
        setTimeout(() => sendYtCommand('setVolume', [100]), 500);
        setPauseIcon();
    }

    function toggleMusic() {
        console.log('toggleMusic: isYoutube=', isYoutube, 'paused=', bgMusic ? bgMusic.paused : 'no-bgMusic');
        if (isYoutube) {
            if (ytMuted || !hasInteracted) { playYoutube(); hasInteracted = true; }
            else { pauseYoutube(); }
        } else {
            if (bgMusic.paused) { playAudio(); }
            else { pauseAudio(); }
        }
    }

    async function loadMusicData() {
        if (isYoutube || isCustom) return;

        try {
            const response = await fetch('/api/music/' + musicId);
            if (!response.ok) throw new Error('Failed to fetch music');
            musicData = await response.json();

            if (musicData.title) musicTitle.textContent = musicData.title;
            if (musicData.artist) musicArtist.textContent = musicData.artist;
            if (musicData.cover) musicCover.src = musicData.cover;
            if (musicData.audio) {
                bgMusic.src = musicData.audio;
                bgMusic.load();
                const tryPlayWhenReady = () => {
                    if (!hasInteracted) playAudio();
                    bgMusic.removeEventListener('canplay', tryPlayWhenReady);
                };
                bgMusic.addEventListener('canplay', tryPlayWhenReady);
                if (!hasInteracted) {
                    setTimeout(() => {
                        if (!hasInteracted && bgMusic.src) playAudio();
                    }, 300);
                }
            }
        } catch (e) {
            console.error('Failed to load music data:', e);
            musicTitle.textContent = 'Memuat lagu...';
        }
    }

    function loadCustomAudio() {
        if (!isCustom || !customAudioUrl) return;
        console.log('loadCustomAudio:', customAudioUrl);
        bgMusic.src = customAudioUrl;
        bgMusic.load();
        musicTitle.textContent = 'Custom Upload';
        musicArtist.textContent = '';
        musicCover.src = "{{ asset('tempelate/no_sound.webp') }}";
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
        });

        bgMusic.addEventListener('ended', () => {
            bgMusic.currentTime = 0;
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

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            if (isYoutube) pauseYoutube();
            else pauseAudio();
        } else {
            if (hasInteracted) {
                if (isYoutube) playYoutube();
                else playAudio();
            }
        }
    });

    window.addEventListener('scroll', () => {
        if (!hasInteracted) {
            hasInteracted = true;
            if (isYoutube) playYoutube();
            else if (bgMusic && bgMusic.src) playAudio();
        }
    }, { once: true });

    document.addEventListener('click', () => {
        if (!hasInteracted) {
            hasInteracted = true;
            if (isYoutube) playYoutube();
            else if (bgMusic && bgMusic.src) playAudio();
        }
    }, { once: true });

    function tryAutoplay() {
        if (hasInteracted) return;
        if (isYoutube) {
            hasInteracted = true;
            playYoutube();
        } else if (bgMusic && bgMusic.src) {
            playAudio();
        }
    }

    if (isYoutube) {
        ytIframe = document.getElementById('youtubeIframe');
        setTimeout(tryAutoplay, 500);
    } else if (isCustom) {
        loadCustomAudio();
        setTimeout(tryAutoplay, 800);
    } else {
        loadMusicData().then(() => {
            setTimeout(tryAutoplay, 800);
        }).catch(() => {
            setTimeout(tryAutoplay, 800);
        });
    }
})();
</script>
@endif

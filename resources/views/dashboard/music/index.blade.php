<x-app-layout>
    <style>
        /* Pindahkan mobile-detail-row ke luar media query agar berfungsi global */
        .mobile-detail-row {
            display: none;
        }
        .mobile-detail-row.mobile-visible {
            display: table-row !important;
        }

        .waveform-wrapper {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, opacity 0.3s ease;
            opacity: 0;
        }
        .waveform-wrapper.waveform-active {
            max-height: 120px;
            opacity: 1;
        }

        @media (max-width: 576px) {
            .waveform-wrapper.waveform-active {
                max-height: 90px;
            }

            .table td, .table th {
                padding: 0.5rem;
            }
            .music-mobile-cover {
                width: 40px !important;
                height: 40px !important;
            }
            .music-mobile-title {
                font-size: 0.85rem;
                line-height: 1.2;
                /* Hitungan agar tidak menabrak tombol dropdown (40px cover + 40px dropdown + 60px padding/gap) */
                max-width: calc(100vw - 140px); 
            }
            .music-mobile-dropdown {
                padding: 0.35rem 0.5rem !important;
            }
            .music-mobile-detail {
                padding: 0.75rem !important;
            }
            .music-mobile-detail .row {
                margin-bottom: 0.5rem;
            }
            .mobile-row-toggle {
                cursor: pointer;
            }
            .mobile-chevron {
                transition: transform 0.2s ease;
                font-size: 0.75rem;
            }
            .mobile-chevron.expanded {
                transform: rotate(180deg);
            }
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Music Library</h4>
            <p class="text-muted mb-0">Kelola lagu latar untuk undangan pernikahan</p>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto">
            <button type="button" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0" id="syncLocalBtn" onclick="syncLocal()">
                <i class="bi bi-arrow-clockwise me-1"></i> Sinkron Lokal
            </button>
            <a href="{{ route('music.create') }}" class="btn btn-primary flex-grow-1 flex-md-grow-0 text-white">
                <i class="bi bi-plus-lg me-1"></i> Tambah Lagu
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon blue" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-music-note-list"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['total'] }}</div>
                            <div class="text-muted small">Total Lagu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon green" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['active'] }}</div>
                            <div class="text-muted small">Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon red" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['inactive'] }}</div>
                            <div class="text-muted small">Nonaktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon teal" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-hdd"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['storage'] }}</div>
                            <div class="text-muted small">Total Penyimpanan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <div class="input-group flex-grow-1 flex-md-grow-0" style="max-width: 320px;">
                    <span class="input-group-text border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchMusic" class="form-control border-start-0"
                        placeholder="Cari judul atau penyanyi..." value="{{ request('search') }}">
                </div>
                <div class="d-flex gap-2">
                    <select id="statusFilter" class="form-select" style="max-width: 160px;">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Cover</th>
                        <th>Judul Lagu</th>
                        <th class="d-none d-sm-table-cell">Penyanyi</th>
                        <th class="d-none d-md-table-cell">Ukuran</th>
                        <th class="d-none d-sm-table-cell">Status</th>
                        <th class="d-none d-lg-table-cell">Tanggal Upload</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($musics as $music)
                        <tr class="mobile-row-toggle" data-id="{{ $music->id }}" onclick="if(window.innerWidth < 576 && !event.target.closest('button') && !event.target.closest('a') && !event.target.closest('img')) { toggleMobileDetail({{ $music->id }}); }">
                            <td class="ps-4">
                                <img src="{{ $music->full_cover_url ?? asset('tempelate/no_sound.webp') }}"
                                    class="rounded border object-fit-cover music-mobile-cover" style="width: 48px; height: 48px;" alt="cover"
                                    onerror="this.src='{{ asset('tempelate/no_sound.webp') }}'">
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="fw-semibold text-break music-mobile-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">{{ $music->title }}</div>
                                    <i class="bi bi-chevron-down mobile-chevron d-sm-none" id="chevron-{{ $music->id }}"></i>
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell text-break" style="max-width: 150px;">{{ $music->artist }}</td>
                            <td class="d-none d-md-table-cell">{{ $music->file_size ? \App\Services\MusicUploadService::formatFileSize($music->file_size) : '-' }}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                @if($music->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Nonaktif</span>
                                @endif
                            </td>
                            <td class="d-none d-lg-table-cell">{{ $music->created_at->format('d M Y H:i') }}</td>
                            <td class="text-end pe-4">
                                <div class="d-none d-sm-flex justify-content-end gap-1 gap-sm-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-circle p-1 p-sm-2"
                                        onclick="playMusicDirect({{ json_encode($music->full_audio_url) }})" title="Play">
                                        <i class="bi bi-play-fill"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-1 p-sm-2"
                                        onclick="previewMusic({{ json_encode($music->id) }}, {{ json_encode($music->title) }}, {{ json_encode($music->artist) }}, {{ json_encode($music->full_cover_url ?? asset('tempelate/no_sound.webp')) }}, {{ json_encode($music->full_audio_url) }})"
                                        title="Preview">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <a href="{{ route('music.edit', $music) }}"
                                        class="btn btn-sm btn-outline-secondary rounded-circle p-1 p-sm-2" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1 p-sm-2"
                                        onclick="confirmDelete({{ json_encode($music->id) }})" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="d-block d-sm-none">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary rounded-circle p-2 music-mobile-dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><button class="dropdown-item py-2" type="button" onclick="playMusicDirect({{ json_encode($music->full_audio_url) }})"><i class="bi bi-play-fill me-2"></i>Play</button></li>
                                            <li><button class="dropdown-item py-2" type="button" onclick="previewMusic({{ json_encode($music->id) }}, {{ json_encode($music->title) }}, {{ json_encode($music->artist) }}, {{ json_encode($music->full_cover_url ?? asset('tempelate/no_sound.webp')) }}, {{ json_encode($music->full_audio_url) }})"><i class="bi bi-eye me-2"></i>Preview</button></li>
                                            <li><a class="dropdown-item py-2" href="{{ route('music.edit', $music) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><button class="dropdown-item text-danger py-2" type="button" onclick="confirmDelete({{ json_encode($music->id) }})"><i class="bi bi-trash me-2"></i>Hapus</button></li>
                                        </ul>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $music->id }}" action="{{ route('music.destroy', $music->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        <tr id="mobile-detail-{{ $music->id }}" class="mobile-detail-row d-none">
                            <td colspan="7" class="p-0">
                                <div class="p-3 bg-light border-top music-mobile-detail">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="text-muted small">Penyanyi</div>
                                            <div class="fw-semibold text-break">{{ $music->artist }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">Ukuran</div>
                                            <div class="fw-semibold">{{ $music->file_size ? \App\Services\MusicUploadService::formatFileSize($music->file_size) : '-' }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">Status</div>
                                            <div class="fw-semibold">
                                                @if($music->is_active)
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Nonaktif</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted small">Tanggal Upload</div>
                                            <div class="fw-semibold">{{ $music->created_at->format('d M Y H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="preview-row-{{ $music->id }}" class="d-none">
                            <td colspan="7" class="p-0">
                                <div class="p-3 bg-light border-top">
                                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
                                        <img id="preview-img-{{ $music->id }}" src="" class="rounded-circle border flex-shrink-0"
                                            style="width:48px;height:48px;object-fit:cover;">
                                        <div class="flex-grow-1 w-100">
                                            <div class="fw-bold" id="preview-title-{{ $music->id }}"></div>
                                            <div class="text-muted small" id="preview-artist-{{ $music->id }}"></div>
                                            <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-2 mt-2">
                                                <audio id="preview-audio-{{ $music->id }}" controls class="w-100"
                                                    style="max-width: 100%;"></audio>
                                            </div>
                                            <div id="waveform-wrapper-{{ $music->id }}" class="waveform-wrapper mt-2">
                                                <canvas id="visualizer-{{ $music->id }}" width="600" height="80"
                                                    style="width:100%; height:80px; display:block; border-radius:8px; background:#fff; border:1px solid #dee2e6;"></canvas>
                                            </div>
                                            <div class="text-muted small mt-1" id="preview-duration-{{ $music->id }}"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-music-note-list"></i>
                                    </div>
                                    <p class="empty-text">Belum ada lagu.<br>Tambahkan lagu pertama untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($musics->hasPages())
            <div class="card-footer bg-transparent border-0 py-3">
                {{ $musics->links() }}
            </div>
        @endif
    </div>

    <script>
        let sharedAudioCtx = null;
        const sourceMap = new WeakMap();
        let activeAnimationId = null;

        function getAudioContext() {
            if (!sharedAudioCtx || sharedAudioCtx.state === 'closed') {
                sharedAudioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (sharedAudioCtx.state === 'suspended') {
                sharedAudioCtx.resume();
            }
            return sharedAudioCtx;
        }

        function stopActiveVisualizer() {
            if (activeAnimationId) {
                cancelAnimationFrame(activeAnimationId);
                activeAnimationId = null;
            }
            document.querySelectorAll('[id^="waveform-wrapper-"]').forEach(function (wrapper) {
                wrapper.classList.remove('waveform-active');
                const canvas = wrapper.querySelector('canvas');
                if (canvas) {
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            });
        }

        function previewMusic(id, title, artist, cover, url) {
            const row = document.getElementById('preview-row-' + id);
            const isHidden = row.classList.contains('d-none');

            document.querySelectorAll('[id^="preview-row-"]').forEach(function (el) {
                el.classList.add('d-none');
                const audio = el.querySelector('audio');
                if (audio) {
                    audio.pause();
                    audio.currentTime = 0;
                }
            });

            stopActiveVisualizer();

            if (isHidden) {
                document.getElementById('preview-img-' + id).src = cover;
                document.getElementById('preview-title-' + id).textContent = title;
                document.getElementById('preview-artist-' + id).textContent = artist;
                document.getElementById('preview-duration-' + id).textContent = '';

                const audio = document.getElementById('preview-audio-' + id);
                const waveformWrapper = document.getElementById('waveform-wrapper-' + id);
                const canvas = document.getElementById('visualizer-' + id);

                // ★★★ CRITICAL: crossOrigin MUST be set BEFORE src ★★★
                audio.crossOrigin = 'anonymous';
                audio.src = encodeURI(url);
                audio.load();

                if (waveformWrapper) {
                    setTimeout(() => {
                        waveformWrapper.classList.add('waveform-active');
                    }, 100);
                }

                row.classList.remove('d-none');

                if (canvas && audio) {
                    setupWaveformVisualizer(audio, canvas, waveformWrapper);
                }

                if (!audio._metaLoaded) {
                    audio.addEventListener('loadedmetadata', function () {
                        const durEl = document.getElementById('preview-duration-' + id);
                        if (durEl && audio.duration && isFinite(audio.duration)) {
                            const mins = Math.floor(audio.duration / 60);
                            const secs = Math.floor(audio.duration % 60);
                            durEl.textContent = 'Durasi: ' + mins + ':' + String(secs).padStart(2, '0');
                        }
                    });
                    audio.addEventListener('error', function (e) {
                        console.error('Audio playback error for:', url, e);
                        const durEl = document.getElementById('preview-duration-' + id);
                        if (durEl) {
                            durEl.textContent = 'Gagal memuat audio. Periksa console untuk detail.';
                        }
                    });
                    audio._metaLoaded = true;
                }
            }
        }

        function setupWaveformVisualizer(audio, canvas, wrapper) {
            if (!canvas || !audio) return;

            const ctx = canvas.getContext('2d');
            const dpr = window.devicePixelRatio || 1;
            const audioCtx = getAudioContext();

            let source;
            if (sourceMap.has(audio)) {
                source = sourceMap.get(audio);
            } else {
                try {
                    source = audioCtx.createMediaElementSource(audio);
                    sourceMap.set(audio, source);
                } catch (e) {
                    console.error('Failed to create MediaElementSource:', e);
                    return;
                }
            }

            if (audio._analyser) {
                try { audio._analyser.disconnect(); } catch (e) {}
            }

            const analyser = audioCtx.createAnalyser();
            analyser.fftSize = 128;
            source.connect(analyser);
            analyser.connect(audioCtx.destination);
            const dataArray = new Uint8Array(analyser.frequencyBinCount);

            audio._analyser = analyser;
            audio._canvas = canvas;
            audio._wrapper = wrapper;

            function draw() {
                if (audio._analyser !== analyser) return;
                activeAnimationId = requestAnimationFrame(draw);

                analyser.getByteFrequencyData(dataArray);

                const rect = canvas.getBoundingClientRect();
                if (canvas.width !== Math.floor(rect.width * dpr) || canvas.height !== Math.floor(rect.height * dpr)) {
                    canvas.width = Math.floor(rect.width * dpr);
                    canvas.height = Math.floor(rect.height * dpr);
                }
                const width = rect.width;
                const height = rect.height;

                ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                ctx.clearRect(0, 0, width, height);

                const totalBars = dataArray.length;
                const gap = 2;
                const barWidth = Math.max(3, (width - gap * totalBars) / totalBars);
                const maxBarHeight = height * 0.85;
                const centerY = height / 2;
                let x = 0;

                for (let i = 0; i < totalBars; i++) {
                    const value = dataArray[i] / 255;
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
            }

            audio._draw = draw;

            if (!audio._vizListenersAdded) {
                audio.addEventListener('play', function () {
                    if (audioCtx.state === 'suspended') audioCtx.resume();
                    if (audio._wrapper) audio._wrapper.classList.add('waveform-active');
                    if (audio._draw) audio._draw();
                });
                audio.addEventListener('pause', function () {
                    if (activeAnimationId) {
                        cancelAnimationFrame(activeAnimationId);
                        activeAnimationId = null;
                    }
                    if (audio._wrapper) audio._wrapper.classList.remove('waveform-active');
                    if (audio._canvas) {
                        const c = audio._canvas.getContext('2d');
                        const rect = audio._canvas.getBoundingClientRect();
                        c.clearRect(0, 0, rect.width, rect.height);
                    }
                });
                audio.addEventListener('ended', function () {
                    if (activeAnimationId) {
                        cancelAnimationFrame(activeAnimationId);
                        activeAnimationId = null;
                    }
                    if (audio._wrapper) audio._wrapper.classList.remove('waveform-active');
                    if (audio._canvas) {
                        const c = audio._canvas.getContext('2d');
                        const rect = audio._canvas.getBoundingClientRect();
                        c.clearRect(0, 0, rect.width, rect.height);
                    }
                });
                audio._vizListenersAdded = true;
            }
        }

        function toggleMobileDetail(id) {
            const row = document.getElementById('mobile-detail-' + id);
            const chevron = document.getElementById('chevron-' + id);
            if (!row) return;
            row.classList.toggle('mobile-visible');
            if (chevron) {
                chevron.classList.toggle('expanded');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchMusic');
            const statusFilter = document.getElementById('statusFilter');

            function applyFilters() {
                const search = searchInput.value;
                const status = statusFilter.value;
                const url = new URL(window.location.href);
                if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
                if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
                window.location.href = url.toString();
            }

            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });

            statusFilter.addEventListener('change', applyFilters);
        });

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus lagu ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function syncLocal() {
            const btn = document.getElementById('syncLocalBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sinkron...';

            fetch('{{ route('music.sync-local') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Sinkronisasi berhasil! ' + data.created + ' lagu baru.');
                    location.reload();
                } else {
                    alert('Gagal sinkronisasi: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi kesalahan saat sinkronisasi.');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-arrow-clockwise me-1"></i> Sinkron Lokal';
            });
        }

        function playMusicDirect(url) {
            stopActiveVisualizer();

            const existingPlayer = document.getElementById('directAudioPlayer');
            if (existingPlayer) {
                existingPlayer.pause();
                existingPlayer.remove();
            }

            const audio = document.createElement('audio');
            audio.id = 'directAudioPlayer';
            audio.controls = true;
            audio.volume = 1.0;
            audio.preload = 'auto';
            audio.style.cssText = 'position:fixed; bottom:20px; right:20px; z-index:9999; width:320px; max-width:calc(100vw - 40px); box-shadow:0 4px 12px rgba(0,0,0,0.15); border-radius:8px;';
            audio.src = encodeURI(url);
            document.body.appendChild(audio);

            audio.play().then(() => {
                console.log('Playing:', url);
            }).catch(err => {
                console.error('Playback failed:', err);
                alert('Gagal memutar audio. Pastikan file tidak diproteksi dan URL valid.');
            });
        }
    </script>
</x-app-layout>
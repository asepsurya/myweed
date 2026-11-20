<x-app-layout>
    @push('styles')
        <style>
            /* Masonry columns */
            .masonry {
                column-gap: 1rem;
            }

            @media (min-width: 640px) {
                .masonry {
                    column-count: 3;
                }
            }

            @media (min-width: 1024px) {
                .masonry {
                    column-count: 4;
                }
            }

            .masonry-item {
                break-inside: avoid;
                margin-bottom: 1rem;
                position: relative;
            }

            .gallery-del {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                width: 1.8rem;
                height: 1.8rem;
                border-radius: 9999px;
                background: rgba(220, 38, 38, 0.92);
                color: #fff;
                font-size: 1.2rem;
                line-height: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                border: none;
                cursor: pointer;
                z-index: 5;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            }

            .masonry-item a {
                display: block;
                position: relative;
                border-radius: 1rem;
                overflow: hidden;
                box-shadow: 0 6px 20px rgba(27, 42, 74, 0.08);
                background: #fff;
                transition: box-shadow 0.3s ease, transform 0.3s ease;
            }

            .masonry-item a:hover {
                box-shadow: 0 12px 30px rgba(27, 42, 74, 0.16);
                transform: translateY(-2px);
            }

            .masonry-item img {
                width: 100%;
                height: auto;
                display: block;
            }

            /* Overlay nama + tanggal */
            .gallery-overlay {
                position: absolute;
                left: 0;
                right: 0;
                bottom: 0;
                padding: 1.6rem 0.65rem 0.55rem;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0));
                color: #fff;
                pointer-events: none;
            }

            .gallery-overlay .g-name {
                font-weight: 600;
                font-size: 0.8rem;
                line-height: 1.2;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .gallery-overlay .g-date {
                font-size: 0.68rem;
                opacity: 0.85;
                margin-top: 1px;
            }

            /* Lightbox */
            .lb-overlay {
                position: fixed;
                inset: 0;
                z-index: 3000;
                background: rgba(10, 14, 24, 0.92);
                display: none;
                align-items: center;
                justify-content: center;
                padding: 1.5rem;
            }

            .lb-overlay.lb-open {
                display: flex;
            }

            .lb-img {
                max-width: 92vw;
                max-height: 82vh;
                object-fit: contain;
                border-radius: 0.5rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            }

            .lb-caption {
                position: absolute;
                bottom: 26px;
                left: 0;
                right: 0;
                text-align: center;
                color: #fff;
                font-size: 0.95rem;
                padding: 0 60px;
            }

            .lb-close,
            .lb-nav {
                position: absolute;
                background: rgba(255, 255, 255, 0.14);
                border: none;
                color: #fff;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.2s ease;
            }

            .lb-close:hover,
            .lb-nav:hover {
                background: rgba(255, 255, 255, 0.28);
            }

            .lb-close {
                top: 20px;
                right: 24px;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                font-size: 1.5rem;
                line-height: 1;
            }

            .lb-nav {
                top: 50%;
                transform: translateY(-50%);
                width: 50px;
                height: 50px;
                border-radius: 50%;
                font-size: 1.5rem;
            }

            .lb-prev {
                left: 20px;
            }

            .lb-next {
                right: 20px;
            }

            @media (max-width: 575.98px) {
                .lb-nav {
                    width: 42px;
                    height: 42px;
                }

                .lb-prev {
                    left: 10px;
                }

                .lb-next {
                    right: 10px;
                }

                .lb-close {
                    top: 12px;
                    right: 12px;
                }
            }
        </style>
    @endpush

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11 col-xl-10">

                {{-- Header --}}
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <span class="badge rounded-pill px-3 py-2 mb-2"
                            style="background: rgba(198,169,98,.15); color:#A68B4B; border:1px solid rgba(198,169,98,.3); font-size:.65rem; letter-spacing:.18em;">
                            RUANGUNDANG
                        </span>
                        <h2 class="fw-bold mb-1" style="font-family:'Playfair Display', Georgia, serif;">Galeri Foto Tamu</h2>
                        @if($invitation ?? null)
                            <p class="text-muted mb-1 small">
                                {{ trim(($invitation->groom_nickname ?: $invitation->groom_name ?: '').' & '.($invitation->bride_nickname ?: $invitation->bride_name ?: '')) }}
                            </p>
                        @endif
                        <p class="text-muted mb-0 small">
                            Total foto: <span id="totalPhotos" class="fw-semibold">{{ $photos->count() }}</span>
                        </p>
                    </div>
                    <a href="{{ route('guest.camera', $event_id) }}" target="_blank"
                        class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="bi bi-camera me-1"></i> Buka Kamera
                    </a>
                </div>

                {{-- Filter --}}
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-3">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0">
                                <i class="bi bi-search" style="color: var(--adminuiux-theme-1, #C6A962);"></i>
                            </span>
                            <input type="text" id="guestSearch" class="form-control border-0"
                                placeholder="Cari nama tamu..." autocomplete="off">
                        </div>
                    </div>
                </div>

                {{-- Grid --}}
                <div class="masonry" id="photosGrid">
                    @forelse($photos as $photo)
                        <div class="masonry-item guest-item" data-name="{{ mb_strtolower($photo->guest_name ?? '') }}">
                            <a href="{{ $photo->image_url }}"
                                data-caption="{{ $photo->guest_name ?? 'Tamu' }}{{ $photo->created_at ? ' · '.$photo->created_at->format('d M Y') : '' }}">
                                <img src="{{ $photo->image_url }}" alt="{{ $photo->guest_name ?? 'Foto tamu' }}" loading="lazy">
                                <div class="gallery-overlay">
                                    <div class="g-name">{{ $photo->guest_name ?? 'Tamu' }}</div>
                                    <div class="g-date">{{ $photo->created_at?->format('d M Y') }}</div>
                                </div>
                            </a>
                            @if($isOwner ?? false)
                                <button type="button" class="gallery-del" data-del="{{ $photo->id }}" aria-label="Hapus foto">&times;</button>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted" style="column-span: all;">
                            <i class="bi bi-image fs-1 d-block mb-3"></i>
                            <p class="mb-1">Belum ada foto dari tamu</p>
                            <p class="small mb-0">Minta tamu memindai QR kamera di undangan untuk ikut berpartisipasi</p>
                        </div>
                    @endforelse
                </div>

                <div class="text-center text-muted py-5 d-none" id="noResults">
                    <i class="bi bi-search fs-3 d-block mb-2"></i>
                    Tidak ada foto yang cocok dengan pencarian.
                </div>

            </div>
        </div>
    </div>

    {{-- Lightbox --}}
    <div class="lb-overlay" id="lightbox" role="dialog" aria-modal="true" aria-label="Pratinjau foto">
        <button type="button" class="lb-close" aria-label="Tutup">&times;</button>
        <button type="button" class="lb-nav lb-prev" aria-label="Sebelumnya">&#10094;</button>
        <img class="lb-img" src="" alt="Foto tamu">
        <div class="lb-caption"></div>
        <button type="button" class="lb-nav lb-next" aria-label="Berikutnya">&#10095;</button>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const eventId = @js($event_id);
                const isOwner = @js($isOwner ?? false);
                const photosGrid = document.getElementById('photosGrid');
                const totalPhotosSpan = document.getElementById('totalPhotos');
                const searchInput = document.getElementById('guestSearch');
                const noResults = document.getElementById('noResults');
                const overlay = document.getElementById('lightbox');
                const lbImg = overlay.querySelector('.lb-img');
                const lbCaption = overlay.querySelector('.lb-caption');

                let currentItems = [];
                let currentIndex = 0;

                function esc(str) {
                    return String(str == null ? '' : str).replace(/[&<>"']/g, function (c) {
                        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
                    });
                }

                function getDeviceId() {
                    let id = localStorage.getItem('guest_device_id');
                    if (!id) {
                        id = 'guest_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                        localStorage.setItem('guest_device_id', id);
                    }
                    return id;
                }

                function visibleItems() {
                    return Array.prototype.slice.call(photosGrid.querySelectorAll('.guest-item'))
                        .filter(function (el) { return !el.classList.contains('d-none'); });
                }

                function render(index) {
                    if (!currentItems.length) return;
                    currentIndex = (index + currentItems.length) % currentItems.length;
                    const a = currentItems[currentIndex];
                    const im = a.querySelector('img');
                    lbImg.src = im.currentSrc || im.src;
                    lbCaption.textContent = a.dataset.caption || '';
                }

                function openLightbox(index) {
                    currentItems = visibleItems();
                    if (!currentItems.length) return;
                    render(index);
                    overlay.classList.add('lb-open');
                    document.body.style.overflow = 'hidden';
                }

                function closeLightbox() {
                    overlay.classList.remove('lb-open');
                    lbImg.src = '';
                    document.body.style.overflow = '';
                }

                function step(delta) {
                    if (!overlay.classList.contains('lb-open')) return;
                    render(currentIndex + delta);
                }

                photosGrid.addEventListener('click', function (e) {
                    const del = e.target.closest('.gallery-del');
                    if (del) {
                        e.preventDefault();
                        e.stopPropagation();
                        deleteGalleryPhoto(del.getAttribute('data-del'));
                        return;
                    }
                    const a = e.target.closest('a[data-caption]');
                    if (!a) return;
                    e.preventDefault();
                    const items = visibleItems();
                    openLightbox(items.indexOf(a.closest('.guest-item')));
                });

                function deleteGalleryPhoto(id) {
                    if (!confirm('Hapus foto ini?')) return;
                    const url = isOwner
                        ? '/dashboard/guest-photos/' + encodeURIComponent(id)
                        : '/api/guest-photos/' + encodeURIComponent(id);
                    const headers = { 'Accept': 'application/json' };
                    if (isOwner) {
                        const token = document.querySelector('meta[name="csrf-token"]');
                        headers['X-CSRF-TOKEN'] = token ? token.content : '';
                    } else {
                        headers['X-Device-Id'] = getDeviceId();
                    }
                    fetch(url, { method: 'DELETE', headers })
                        .then(function (r) { return r.json(); })
                        .then(function (data) {
                            if (data.success) {
                                const btn = photosGrid.querySelector('.gallery-del[data-del="' + id + '"]');
                                const item = btn ? btn.closest('.guest-item') : null;
                                if (item) item.remove();
                                if (totalPhotosSpan) totalPhotosSpan.textContent = photosGrid.querySelectorAll('.guest-item').length;
                            } else {
                                alert(data.message || 'Gagal menghapus foto.');
                            }
                        })
                        .catch(function () { alert('Gagal menghapus foto.'); });
                }

                overlay.querySelector('.lb-close').addEventListener('click', closeLightbox);
                overlay.querySelector('.lb-prev').addEventListener('click', function (e) { e.stopPropagation(); step(-1); });
                overlay.querySelector('.lb-next').addEventListener('click', function (e) { e.stopPropagation(); step(1); });
                overlay.addEventListener('click', function (e) { if (e.target === overlay) closeLightbox(); });

                document.addEventListener('keydown', function (e) {
                    if (!overlay.classList.contains('lb-open')) return;
                    if (e.key === 'Escape') closeLightbox();
                    else if (e.key === 'ArrowLeft') step(-1);
                    else if (e.key === 'ArrowRight') step(1);
                });

                function applyFilter() {
                    const q = (searchInput.value || '').toLowerCase().trim();
                    let visible = 0;
                    photosGrid.querySelectorAll('.guest-item').forEach(function (el) {
                        const match = (el.dataset.name || '').includes(q);
                        el.classList.toggle('d-none', !match);
                        if (match) visible++;
                    });
                    const total = photosGrid.querySelectorAll('.guest-item').length;
                    noResults.classList.toggle('d-none', total === 0 || visible > 0);
                }
                if (searchInput) searchInput.addEventListener('input', applyFilter);

                fetch('/api/guest-photos/' + encodeURIComponent(eventId), {
                    headers: {
                        'X-Secret-Token': 'guest-photos-secret-2026',
                        'X-Device-Id': getDeviceId(),
                        'Accept': 'application/json'
                    }
                })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (!data.success || !Array.isArray(data.data)) return;
                        const photos = data.data;
                        if (totalPhotosSpan) totalPhotosSpan.textContent = photos.length;
                        if (photos.length === 0) return;

                        photosGrid.innerHTML = photos.map(function (p) {
                            const name = p.guest_name || 'Tamu';
                            const date = p.created_at ? ' · ' + p.created_at : '';
                            return '' +
                                '<div class="masonry-item guest-item" data-name="' + esc((name || '').toLowerCase()) + '">' +
                                    '<a href="' + esc(p.image_url) + '" data-caption="' + esc(name + date) + '">' +
                                        '<img src="' + esc(p.image_url) + '" alt="' + esc(name) + '" loading="lazy">' +
                                        '<div class="gallery-overlay">' +
                                            '<div class="g-name">' + esc(name) + '</div>' +
                                            '<div class="g-date">' + esc(p.created_at || '') + '</div>' +
                                        '</div>' +
                                    '</a>' +
                                    ((isOwner || p.can_delete) ? '<button type="button" class="gallery-del" data-del="' + esc(p.id) + '" aria-label="Hapus foto">&times;</button>' : '') +
                                '</div>';
                        }).join('');

                        applyFilter();
                    })
                    .catch(function (err) { console.error('Error fetching photos:', err); });
            });
        </script>
    @endpush
</x-app-layout>
<div class="ev-search-modal-backdrop" id="searchModalBackdrop"></div>
<div class="ev-search-modal" id="searchModal" role="dialog" aria-modal="true" aria-label="Pencarian Tema">
    <div class="ev-search-sheet-handle" aria-hidden="true"></div>
    <div class="ev-search-modal-header">
        <h2 class="ev-search-modal-title">Cari Tema Undangan</h2>
        <button class="ev-search-modal-close" id="searchModalClose" aria-label="Tutup">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <form action="{{ route('pages.cari-tema') }}" method="GET" id="searchModalForm">
        <div class="ev-search-modal-input-wrap">
            <i class="bi bi-search ev-search-modal-icon"></i>
            <input
                type="text"
                name="search"
                id="searchModalInput"
                class="ev-search-modal-input"
                placeholder="Ketik nama tema atau acara..."
                autocomplete="off"
                autofocus
            >
            <button type="button" class="ev-search-modal-clear" id="searchModalClear" aria-label="Hapus">
                <i class="bi bi-x-circle-fill"></i>
            </button>
        </div>
    </form>

    @php
    $searchModalCategories = \App\Models\Category::query()
        ->where('is_active', true)
        ->whereHas('templates')
        ->ordered()
        ->take(6)
        ->get();
@endphp

<div class="ev-search-modal-filters">
        <span class="ev-search-filter-label">Saya mencari...</span>
        <div class="ev-search-filter-pills">
            @forelse($searchModalCategories as $cat)
                @php
                    $catLower = \Illuminate\Support\Str::lower($cat->name);
                    $catEmoji = match (true) {
                        str_contains($catLower, 'wedding') || str_contains($catLower, 'nikah') => '💍',
                        str_contains($catLower, 'birth') || str_contains($catLower, 'ultah') => '🎂',
                        str_contains($catLower, 'aqiqah') => '🌿',
                        str_contains($catLower, 'khitan') => '🌙',
                        str_contains($catLower, 'graduation') || str_contains($catLower, 'wisuda') => '🎓',
                        str_contains($catLower, 'seminar') => '💼',
                        str_contains($catLower, 'syukuran') => '🙏',
                        str_contains($catLower, 'party') || str_contains($catLower, 'pesta') => '🎉',
                        str_contains($catLower, 'christmas') || str_contains($catLower, 'natal') => '🎄',
                        str_contains($catLower, 'corporate') || str_contains($catLower, 'kantor') => '🏢',
                        str_contains($catLower, 'engagement') || str_contains($catLower, 'lamaran') => '💑',
                        default => '✨',
                    };
                @endphp
                <a href="{{ route('pages.cari-tema', ['category' => $cat->name]) }}"
                    class="ev-search-filter-pill {{ $loop->first ? 'active' : '' }}"
                    data-filter="{{ \Illuminate\Support\Str::slug($cat->name) }}">
                    <span>{{ $catEmoji }}</span> {{ $cat->name }}
                </a>
            @empty
                <a href="{{ route('pages.cari-tema') }}" class="ev-search-filter-pill active">
                    <span>✨</span> Semua Tema
                </a>
            @endforelse
        </div>
    </div>

    <div class="ev-search-modal-section" id="searchRecentSection">
        <span class="ev-search-section-label">Pencarian Terakhir</span>
        <ul class="ev-search-recent-list" id="searchRecentList">
        </ul>
    </div>

    <div class="ev-search-modal-section">
        <span class="ev-search-section-label">Tema Populer</span>
        <div class="ev-search-popular-grid">
            @forelse(isset($templates) ? $templates->take(12) : [] as $template)
                @php
                    $catSlug = $template->category ? Str::slug($template->category->name) : 'umum';
                    $thumb = template_thumbnail_url($template, $template->updated_at->timestamp);
                @endphp
                <a href="{{ route('template.preview', ['slug' => $template->slug, 'id' => $template->id]) }}" class="ev-search-popular-item" data-category="{{ $catSlug }}">
                    <div class="ev-search-popular-thumb" style="background-image: url('{{ $thumb }}');"></div>
                    <span>{{ $template->name }}</span>
                </a>
            @empty
                <a href="{{ route('pages.cari-tema', ['category' => $searchModalCategories->first()?->name ?? 'Wedding Invitation']) }}" class="ev-search-popular-item">
                    <div class="ev-search-popular-icon" style="background:#F4D9C8">💍</div>
                    <span>{{ $searchModalCategories->first()?->name ?? 'Wedding Elegan' }}</span>
                </a>
                <a href="{{ route('pages.cari-tema', ['search' => 'Rustic']) }}" class="ev-search-popular-item">
                    <div class="ev-search-popular-icon" style="background:#DBE9E8">🌿</div>
                    <span>Rustic Botanical</span>
                </a>
                <a href="{{ route('pages.cari-tema', ['search' => 'Islami']) }}" class="ev-search-popular-item">
                    <div class="ev-search-popular-icon" style="background:#E3EED8">☪️</div>
                    <span>Islami Modern</span>
                </a>
                <a href="{{ route('pages.cari-tema', ['search' => 'Minimalis']) }}" class="ev-search-popular-item">
                    <div class="ev-search-popular-icon" style="background:#F7F5E5">✨</div>
                    <span>Minimalis</span>
                </a>
                <a href="{{ route('pages.cari-tema', ['search' => 'Floral']) }}" class="ev-search-popular-item">
                    <div class="ev-search-popular-icon" style="background:#F4D9C8">🌸</div>
                    <span>Floral Garden</span>
                </a>
                <a href="{{ route('pages.cari-tema', ['search' => 'Modern']) }}" class="ev-search-popular-item">
                    <div class="ev-search-popular-icon" style="background:#C0D1CC">🖤</div>
                    <span>Modern Luxury</span>
                </a>
            @endforelse
        </div>
    </div>

    <div class="ev-search-modal-footer">
        <span><kbd>↑</kbd><kbd>↓</kbd> Navigasi</span>
        <span><kbd>↵</kbd> Buka</span>
        <span><kbd>Esc</kbd> Tutup</span>
    </div>
</div>

<style>
    .ev-search-sheet-handle {
        display: none;
    }

    @media (max-width: 768px) {
        .ev-search-sheet-handle {
            display: block;
            width: 38px;
            height: 4px;
            border-radius: 9999px;
            background: #D5D2C9;
            margin: 10px auto 2px;
            flex-shrink: 0;
        }

        .ev-search-modal {
            position: fixed !important;
            top: auto !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            max-height: 88vh !important;
            max-height: 88dvh !important;
            border-radius: 20px 20px 0 0 !important;
            border: 1px solid #E8E5DD !important;
            border-bottom: none !important;
            box-shadow: 0 -12px 40px rgba(18, 26, 21, 0.22) !important;
            transform: translateY(105%) !important;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease !important;
            overscroll-behavior: contain;
            -webkit-overflow-scrolling: touch;
            padding-bottom: calc(1rem + env(safe-area-inset-bottom, 16px)) !important;
        }

        .ev-search-modal.is-open {
            transform: translateY(0) !important;
        }

        .ev-search-modal-header {
            padding: 0.6rem 1rem 0 !important;
        }

        .ev-search-modal-title {
            font-size: 1.05rem !important;
            font-weight: 700 !important;
        }

        .ev-search-modal-close {
            width: 32px !important;
            height: 32px !important;
            font-size: 0.85rem !important;
        }

        .ev-search-modal-input-wrap {
            margin: 0.75rem 1rem 0.5rem !important;
            padding: 0.65rem 0.85rem !important;
            border-radius: 12px !important;
            gap: 0.5rem !important;
        }

        .ev-search-modal-input {
            font-size: 16px !important;
        }

        .ev-search-modal-filters {
            padding: 0 1rem !important;
            margin-bottom: 0.25rem !important;
        }

        .ev-search-filter-label,
        .ev-search-section-label {
            font-size: 0.7rem !important;
            margin-bottom: 0.35rem !important;
        }

        .ev-search-filter-pills {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            gap: 0.45rem !important;
            padding-bottom: 6px !important;
            scrollbar-width: none !important;
            -webkit-overflow-scrolling: touch !important;
            margin: 0 -1rem !important;
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .ev-search-filter-pills::-webkit-scrollbar {
            display: none !important;
        }

        .ev-search-filter-pill {
            flex-shrink: 0 !important;
            padding: 0.35rem 0.75rem !important;
            font-size: 0.78rem !important;
            border-radius: 9999px !important;
        }

        .ev-search-modal-section {
            padding: 0.5rem 1rem 0 !important;
        }

        .ev-search-recent-btn {
            padding: 0.45rem 0.6rem !important;
            font-size: 0.85rem !important;
        }

        .ev-search-popular-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 0.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        .ev-search-popular-item {
            padding: 0.45rem 0.6rem !important;
            gap: 0.5rem !important;
            border-radius: 10px !important;
            min-width: 0 !important;
            background: #F8F7F4 !important;
        }

        .ev-search-popular-thumb,
        .ev-search-popular-icon {
            width: 32px !important;
            height: 32px !important;
            border-radius: 6px !important;
            font-size: 0.95rem !important;
            flex-shrink: 0 !important;
        }

        .ev-search-popular-item span {
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            min-width: 0 !important;
            flex: 1 !important;
        }

        .ev-search-modal-footer {
            display: none !important;
        }
    }
</style>

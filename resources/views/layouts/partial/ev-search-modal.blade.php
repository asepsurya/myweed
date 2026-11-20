<div class="ev-search-modal-backdrop" id="searchModalBackdrop"></div>
<div class="ev-search-modal" id="searchModal" role="dialog" aria-modal="true" aria-label="Pencarian Tema">
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

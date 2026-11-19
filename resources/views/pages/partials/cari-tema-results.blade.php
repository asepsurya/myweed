@php
    $activePrice = $isPremiumFilter ?? null;
    $activeCategory = $categoryFilter ?? null;
    $activeType = $typeFilter ?? null;
    $activeSearch = $searchQuery ?? null;

    $activeFilters = [];
    if ($activeSearch) {
        $activeFilters['search'] = '"'.$activeSearch.'"';
    }
    if ($activeCategory && $activeCategory !== 'All') {
        $activeFilters['category'] = $activeCategory;
    }
    if ($activePrice !== null && $activePrice !== '') {
        $activeFilters['is_premium'] = $activePrice === '1' ? 'Premium' : 'Gratis';
    }
    if ($activeType) {
        $typeLabel = $activeType;
        foreach (($templateTypes ?? []) as $type) {
            if ($type['slug'] === $activeType) {
                $typeLabel = $type['name'];
                break;
            }
        }
        $activeFilters['type'] = $typeLabel;
    }
@endphp

<!-- Toolbar -->
<div class="ev-ct-toolbar">
    <div class="ev-ct-toolbar-left">
        <button type="button" class="ev-ct-filter-toggle" id="filterToggle" title="Tampilkan / Sembunyikan filter" aria-expanded="true" aria-controls="filterSidebar">
            <i class="bi bi-sliders2"></i>
            <span class="ev-ct-filter-toggle-text">Sembunyikan filter</span>
        </button>
        <span class="ev-ct-results-count">
            {{ $templates->total() }} tema ditemukan
        </span>
    </div>
    <form method="GET" action="{{ route('pages.cari-tema') }}" class="ev-ct-sort-form" data-ajax-form>
        <span class="ev-ct-sort-label">Urutkan:</span>
        <select name="sort" class="ev-ct-sort-select" data-ajax-sort>
            <option value="newest" {{ ($sortField ?? 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
            <option value="popular" {{ ($sortField ?? 'newest') === 'popular' ? 'selected' : '' }}>Paling Populer</option>
            <option value="name_asc" {{ ($sortField ?? 'newest') === 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
            <option value="name_desc" {{ ($sortField ?? 'newest') === 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
        </select>
        @if($activeCategory && $activeCategory !== 'All')
            <input type="hidden" name="category" value="{{ $activeCategory }}">
        @endif
        @if($activeSearch)
            <input type="hidden" name="search" value="{{ $activeSearch }}">
        @endif
        @if($activePrice !== null && $activePrice !== '')
            <input type="hidden" name="is_premium" value="{{ $activePrice }}">
        @endif
        @if($activeType)
            <input type="hidden" name="type" value="{{ $activeType }}">
        @endif
    </form>
</div>

@if(count($activeFilters) > 0)
    <div class="ev-ct-active-filters">
        <span class="ev-ct-active-label">Filter aktif:</span>
        @foreach($activeFilters as $filterKey => $filterLabel)
            <a href="{{ route('pages.cari-tema', array_merge($baseParams, [$filterKey => null])) }}#templates"
               class="ev-ct-active-chip" data-ajax-link>
                {{ $filterLabel }} <i class="bi bi-x"></i>
            </a>
        @endforeach
        <a href="{{ route('pages.cari-tema') }}#templates" class="ev-ct-active-clear" data-ajax-link>Hapus semua</a>
    </div>
@endif

@if($templates->isEmpty())
    <div class="ev-ct-empty-state text-center reveal">
        <i class="bi bi-search display-1 text-muted opacity-25"></i>
        <h3 class="text-muted mt-3">Tema tidak ditemukan</h3>
        <p class="ev-text-secondary">Coba gunakan kata kunci lain atau hapus filter pencarian.</p>
        <a href="{{ route('pages.cari-tema') }}" class="ev-btn-hero-secondary d-inline-flex" data-ajax-link>
            <span>Lihat Semua Tema</span>
        </a>
    </div>
@else
    <div class="ev-templates-grid">
        @foreach($templates as $template)
            @php
                $catSlug = $template->category ? Str::slug($template->category->name) : 'umum';
                $thumb = template_thumbnail_url($template, $template->updated_at->timestamp) ?? 'C:/Users/Admin/Downloads/image-notfound.png';
                $previewUrl = route('template.frame', ['slug' => 'romeo-juliet', 'id' => $template->id]);
                $useUrl = route('dashboard.user').'?template_id='.$template->id;
            @endphp
            <div class="ev-template-card ev-gallery-card reveal" data-category="{{ $catSlug }}">
                <div class="ev-template-media ev-gallery-media">
                    <a href="{{ $previewUrl }}" target="_blank" rel="nofollow" class="ev-gallery-link">
                        <img src="{{ $thumb }}" alt="Template Undangan {{ $template->name }}"
                             loading="lazy" width="400" height="300" decoding="async">
                    </a>
                    <span class="ev-gallery-badge" style="background-color: {{ $template->templateType->color ?? '#425620' }}; color: var(--ev-bg-white);">
                        {{ $template->templateType->name ?? 'Umum' }}
                    </span>
                    <div class="ev-gallery-hover-actions">
                        <a href="{{ $previewUrl }}" target="_blank" rel="nofollow" class="ev-gallery-hover-btn ev-hover-preview" title="Pratinjau">
                            <i class="bi bi-eye"></i> Pratinjau
                        </a>
                        <a href="{{ $useUrl }}" rel="nofollow" class="ev-gallery-hover-btn ev-hover-use" title="Gunakan Tema">
                            <i class="bi bi-magic"></i> Gunakan
                        </a>
                    </div>
                </div>
                <div class="ev-template-meta ev-gallery-meta">
                    <div class="ev-gallery-info">
                        <div class="ev-gallery-title-row">
                            <h4 class="ev-gallery-name" title="{{ $template->name }}">{{ $template->name }}</h4>
                            <button class="ev-like-btn ev-like-btn-inline" data-id="{{ $template->id }}" title="Suka">
                                <i class="bi bi-heart-fill"></i>
                                <span class="ev-likes-count">{{ number_format($template->likes_count ?? 0) }}</span>
                            </button>
                        </div>
                        <span class="ev-gallery-cat">{{ $template->category->name ?? 'Pernikahan' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($templates->hasPages())
        @php
            $currentPage = $templates->currentPage();
            $lastPage = $templates->lastPage();
            $windowStart = max(1, $currentPage - 2);
            $windowEnd = min($lastPage, $currentPage + 2);
        @endphp
        <nav class="ev-ct-pagination" aria-label="Navigasi halaman">
            @if($currentPage > 1)
                <a class="ev-ct-page" href="{{ $templates->url($currentPage - 1) }}#templates" rel="prev" aria-label="Halaman sebelumnya" data-ajax-link>
                    <i class="bi bi-chevron-left"></i>
                </a>
            @else
                <span class="ev-ct-page is-disabled" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
            @endif

            @if($windowStart > 1)
                <a class="ev-ct-page" href="{{ $templates->url(1) }}#templates" data-ajax-link>1</a>
                @if($windowStart > 2)
                    <span class="ev-ct-page is-ellipsis">&hellip;</span>
                @endif
            @endif

            @for($page = $windowStart; $page <= $windowEnd; $page++)
                @if($page === $currentPage)
                    <span class="ev-ct-page is-active" aria-current="page">{{ $page }}</span>
                @else
                    <a class="ev-ct-page" href="{{ $templates->url($page) }}#templates" data-ajax-link>{{ $page }}</a>
                @endif
            @endfor

            @if($windowEnd < $lastPage)
                @if($windowEnd < $lastPage - 1)
                    <span class="ev-ct-page is-ellipsis">&hellip;</span>
                @endif
                <a class="ev-ct-page" href="{{ $templates->url($lastPage) }}#templates" data-ajax-link>{{ $lastPage }}</a>
            @endif

            @if($currentPage < $lastPage)
                <a class="ev-ct-page" href="{{ $templates->url($currentPage + 1) }}#templates" rel="next" aria-label="Halaman berikutnya" data-ajax-link>
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="ev-ct-page is-disabled" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
            @endif
        </nav>
    @endif
@endif

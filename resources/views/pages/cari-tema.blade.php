@extends('layouts.page')

@php
    $isSearchResult = ! empty($searchQuery) || (! empty($categoryFilter) && $categoryFilter != 'All');
    $noIndex = $isSearchResult;
@endphp

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-shape shape-1"></div>
        <div class="page-header-shape shape-2"></div>
        <div class="container page-header-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cari Tema</li>
                </ol>
            </nav>
            <h1>Cari Tema</h1>
            <p>Temukan tema undangan digital yang sesuai dengan gaya pernikahan impian Anda.</p>
        </div>
    </section>

    <!-- Templates Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Jelajahi Koleksi</span>
                <h2 class="section-title">Temukan Tema Impian</h2>
                <p class="section-desc">Gunakan filter kategori atau kata kunci untuk menemukan tema yang pas.</p>
            </div>

            <div class="category-scroll mb-5 reveal">
                <a href="{{ route('pages.cari-tema') }}"
                    class="category-chip {{ !request('category') || request('category') == 'All' ? 'active' : '' }}">Semua</a>
                @foreach($categories as $cat)
                    <a href="{{ route('pages.cari-tema', ['category' => $cat['name']]) }}#templates"
                        class="category-chip {{ request('category') == $cat['name'] ? 'active' : '' }}">
                        {{ $cat['name'] }}
                    </a>
                @endforeach
            </div>

            <form action="{{ route('pages.cari-tema') }}#templates" method="GET" class="search-box mb-5 reveal">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <i class="bi bi-search"></i>
                <input type="text" name="search" placeholder="Cari tema... (contoh: Rustic, Modern, Floral)"
                    value="{{ request('search') }}">
                <button type="submit" class="btn-search">Cari</button>
            </form>

            <div class="template-grid">
                @foreach($templates as $template)
                    <div class="template-card reveal">
                        <div class="template-img-container">
                            <img src="{{ template_thumbnail_url($template, $template->updated_at->timestamp) }}"
                                alt="{{ $template->name }}" loading="lazy">
                            @if($template->templateType)
                                <div class="type-badge-card" style="background-color: {{ $template->templateType->color }};">
                                    {{ $template->templateType->name }}
                                </div>
                            @endif
                            <div class="template-overlay">
                                <a href="{{ route('template.frame', ['slug' => 'romeo-juliet', 'id' => $template->id]) }}"
                                    target="_blank" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">Pratinjau</a>
                                <a href="{{ route('dashboard.user') }}?template_id={{ $template->id }}"
                                    class="btn btn-gold rounded-pill px-4 fw-bold shadow-sm">Gunakan</a>
                            </div>
                        </div>
                        <div class="template-footer">
                            <div class="user-info">
                                <img src="https://ui-avatars.com/api/?name={{urlencode($template->name)}}&background=random"
                                    class="user-avatar" alt="">
                                <span class="user-name">{{ $template->name }}</span>
                            </div>
                            <div class="card-stats">
                                <span title="Dilihat"><i class="bi bi-eye"></i> {{ number_format($template->views_count) }}</span>
                                <span title="Suka" class="like-btn" data-id="{{ $template->id }}" style="cursor: pointer;">
                                    <i class="bi bi-heart-fill text-danger"></i>
                                    <span class="likes-count">{{ number_format($template->likes_count) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($templates->isEmpty())
                <div class="text-center py-5 reveal">
                    <i class="bi bi-search text-muted display-1 opacity-25"></i>
                    <h3 class="text-muted mt-3">Tema tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci lain atau lihat semua tema.</p>
                    <a href="{{ route('pages.cari-tema') }}" class="btn btn-outline-dark mt-2 rounded-pill px-4">Lihat Semua Tema</a>
                </div>
            @endif
        </div>
    </section>

    <style>
        .category-scroll { display: flex; gap: 1rem; overflow-x: auto; padding: 1rem 0; scrollbar-width: none; }
        .category-scroll::-webkit-scrollbar { display: none; }
        .category-chip { flex: 0 0 auto; padding: 0.75rem 1.5rem; border-radius: 50px; background: var(--white); border: 1px solid var(--border); color: var(--text); font-weight: 600; font-size: 0.9rem; transition: all var(--speed); cursor: pointer; text-decoration: none; }
        .category-chip:hover, .category-chip.active { background: var(--navy); color: var(--white); border-color: var(--navy); transform: translateY(-3px); }
        .search-box { max-width: 600px; margin: 0 auto; position: relative; }
        .search-box form { position: relative; }
        .search-box input { width: 100%; padding: 1rem 1.5rem 1rem 3rem; border-radius: 50px; border: 1.5px solid var(--border); background: var(--white); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); font-family: var(--font); font-size: 0.95rem; outline: none; transition: all var(--speed); }
        .search-box input:focus { border-color: var(--gold); box-shadow: 0 0 0 4px rgba(198, 169, 98, 0.2); }
        .search-box i { position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .search-box .btn-search { position: absolute; right: 8px; top: 8px; bottom: 8px; background: linear-gradient(135deg, var(--gold), var(--gold-dark)); color: white; border: none; border-radius: 50px; padding: 0 1.8rem; font-weight: 600; font-size: 0.9rem; }
        .template-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; padding: 20px 0; }
        .template-card { border-radius: var(--radius); overflow: hidden; transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1); background: transparent; }
        .template-img-container { aspect-ratio: 4/3; border-radius: var(--radius); overflow: hidden; position: relative; background: var(--bg); border: 1px solid var(--border); }
        .template-img-container img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1); }
        .template-card:hover .template-img-container img { transform: scale(1.08); }
        .template-overlay { position: absolute; inset: 0; background: rgba(27, 42, 74, 0.7); backdrop-filter: blur(3px); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.4s ease; gap: 10px; }
        .template-card:hover .template-overlay { opacity: 1; }
        .template-footer { padding: 12px 4px; display: flex; justify-content: space-between; align-items: center; }
        .user-info { display: flex; align-items: center; gap: 8px; }
        .user-avatar { width: 24px; height: 24px; border-radius: 50%; background: var(--border); }
        .user-name { font-size: 0.85rem; font-weight: 700; color: var(--navy); }
        .card-stats { display: flex; gap: 10px; font-size: 0.75rem; font-weight: 600; color: var(--text-secondary); }
        .card-stats i { font-size: 0.85rem; }
        .badge-pro { background: var(--gold); color: white; font-size: 0.65rem; padding: 1px 5px; border-radius: 3px; font-weight: 800; }
        .type-badge-card { position: absolute; top: 10px; right: 10px; z-index: 10; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 4px; color: #fff; pointer-events: none; box-shadow: 0 2px 6px rgba(0,0,0,0.25); }
    </style>

    @push('scripts')
    <script>
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const countSpan = this.querySelector('.likes-count');
                if (this.classList.contains('processing')) return;
                this.classList.add('processing');
                fetch(`/templates/${id}/like`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) { countSpan.textContent = data.likes_count.toLocaleString(); }
                    this.classList.remove('processing');
                })
                .catch(() => this.classList.remove('processing'));
            });
        });
    </script>
    @endpush
@endsection

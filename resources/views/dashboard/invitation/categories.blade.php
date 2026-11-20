<x-app-layout>
<style>
    :root {
        --card-bg: #ffffff;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .category-card {
        background: var(--card-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 1.5rem;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border-color: var(--adminuiux-theme-accent-1);
    }

    .category-thumb {
        height: 180px;
        overflow: hidden;
        background: var(--bs-tertiary-bg);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .category-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .category-card:hover .category-thumb img {
        transform: scale(1.08);
    }

    .category-icon-fallback {
        font-size: 3rem;
        color: var(--bs-secondary-color);
        opacity: 0.6;
    }

    .category-badge-active {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(255, 255, 255, 0.9);
        color: var(--bs-success);
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid var(--bs-success);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .category-badge-inactive {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(255, 255, 255, 0.9);
        color: var(--bs-secondary);
        padding: 0.4rem 0.8rem;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid var(--bs-secondary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .category-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .category-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: var(--bs-body-color);
    }

    .category-desc {
        font-size: 0.9rem;
        color: var(--bs-secondary-color);
        margin: 0 0 1rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .category-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--bs-border-color);
    }

    .template-count {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--adminuiux-theme-accent-1);
        background: rgba(198, 169, 98, 0.1);
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        border: 1px solid rgba(198, 169, 98, 0.2);
    }

    .category-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-category {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
    }

    .btn-view-templates {
        background: var(--bs-body-bg);
        color: var(--bs-body-color);
        border: 1px solid var(--bs-border-color);
    }

    .btn-view-templates:hover {
        background: var(--adminuiux-theme-accent-1);
        color: #fff;
        border-color: var(--adminuiux-theme-accent-1);
    }

    .btn-create {
        background: var(--adminuiux-theme-accent-1);
        color: #fff;
        border: none;
    }

    .btn-create:hover {
        background: var(--adminuiux-theme-accent-1-hover);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(198, 169, 98, 0.3);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--bs-secondary-color);
        margin-bottom: 1rem;
        opacity: 0.4;
    }

    .search-bar {
        max-width: 500px;
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Buat Undangan Baru</h1>
            <p class="text-muted mb-0">Pilih kategori undangan yang ingin Anda buat.</p>
        </div>
        <a href="{{ route('dashboard.user') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" id="categorySearch" class="form-control" placeholder="Cari kategori undangan...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="category-grid" id="categoryGrid">
        @foreach($categories as $category)
        <a href="{{ route('invitation.create.category', $category) }}" class="category-card" data-name="{{ strtolower($category->name) }}">
            <div class="category-thumb position-relative">
                @if($category->thumbnail_url)
                    <img src="{{ $category->thumbnail_url }}" alt="{{ $category->name }}">
                @else
                    <div class="category-icon-fallback">
                        {!! category_icon_html($category) !!}
                    </div>
                @endif
                @if($category->is_active)
                    <span class="category-badge-active">Aktif</span>
                @else
                    <span class="category-badge-inactive">Tidak Aktif</span>
                @endif
            </div>
            <div class="category-body">
                <h6 class="category-name">{{ $category->name }}</h6>
                <p class="category-desc">{{ $category->description ?? 'Tidak ada deskripsi.' }}</p>
                <div class="category-meta">
                    <span class="template-count">
                        <i class="bi bi-layout-template me-1"></i> {{ $category->template_count ?? 0 }} Template
                    </span>
                </div>
            </div>
            <div class="category-actions position-absolute bottom-0 start-0 end-0 p-3">
                <button type="button" class="btn btn-category btn-create w-100" onclick="window.location.href='{{ route('invitation.create.category', $category) }}'">
                    <i class="bi bi-plus-circle"></i> Buat Undangan
                </button>
            </div>
        </a>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4>Belum ada kategori tersedia</h4>
                <p class="text-muted">Silakan hubungi administrator untuk menambahkan kategori undangan.</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('categorySearch')?.addEventListener('input', function (e) {
        const query = e.target.value.toLowerCase();
        const cards = document.querySelectorAll('#categoryGrid .category-card');

        cards.forEach(card => {
            const name = card.dataset.name || '';
            const match = name.includes(query);
            card.style.display = match ? '' : 'none';
        });
    });
</script>
@endpush
</x-app-layout>

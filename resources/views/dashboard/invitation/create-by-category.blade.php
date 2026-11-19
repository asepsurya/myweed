<x-app-layout>
<style>
    .template-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 1.5rem;
    }

    .template-card {
        border: 1px solid var(--bs-border-color);
        border-radius: 1rem;
        overflow: hidden;
        background: var(--bs-body-bg);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    .template-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: var(--adminuiux-theme-accent-1);
    }

    .template-thumb {
        height: 160px;
        overflow: hidden;
        background: var(--bs-tertiary-bg);
        position: relative;
    }

    .template-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .template-locked {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 1rem 1.5rem;
        border-radius: 0.75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .template-body {
        padding: 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .template-name {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: var(--bs-body-color);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .template-premium {
        font-size: 0.75rem;
        font-weight: 700;
        background: #f59e0b;
        color: #fff;
        padding: 0.2rem 0.5rem;
        border-radius: 0.375rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .template-actions {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--bs-border-color);
        display: flex;
        gap: 0.5rem;
    }

    .btn-template {
        flex: 1;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .btn-create-template {
        background: var(--adminuiux-theme-accent-1);
        color: #fff;
        border: none;
    }

    .btn-create-template:hover {
        background: var(--adminuiux-theme-accent-1-hover);
        transform: translateY(-1px);
    }

    .btn-preview-template {
        background: var(--bs-body-bg);
        color: var(--bs-body-color);
        border: 1px solid var(--bs-border-color);
    }

    .btn-preview-template:hover {
        background: var(--bs-secondary-bg);
        border-color: var(--bs-secondary-color);
    }

    .btn-locked {
        background: var(--bs-secondary-bg);
        color: var(--bs-secondary-color);
        border: 1px solid var(--bs-border-color);
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('invitation.categories') }}" class="text-decoration-none text-muted small mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Kategori
            </a>
            <h1 class="h3 fw-bold mb-1">{{ $category->name }}</h1>
            <p class="text-muted mb-0">{{ $category->description ?? 'Pilih template untuk kategori ini.' }}</p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if($templates->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-layout-template fs-1 text-muted mb-3"></i>
            <h4>Belum ada template untuk kategori ini</h4>
            <p class="text-muted">Silakan hubungi administrator untuk menambahkan template.</p>
            <a href="{{ route('invitation.categories') }}" class="btn btn-outline-secondary">Pilih Kategori Lainnya</a>
        </div>
    @else
        <div class="template-grid">
            @foreach($templates as $template)
            @php
                $user = auth()->user();
                $isLocked = false;
                if ($user->isOnFreePlan() && $template->slug !== 'simple-theme') {
                    $isLocked = true;
                } elseif ($template->template_type_id) {
                    $isLocked = ! $user->canAccessTemplateType($template->template_type_id);
                } elseif ($template->is_premium && ! $user->hasFeature('all_themes')) {
                    $isLocked = true;
                }
            @endphp
            <a href="{{ $isLocked ? '#' : route('invitation.quick-create', ['category_id' => $category->id, 'template_id' => $template->id]) }}"
               class="template-card {{ $isLocked ? 'opacity-75' : '' }}"
               {{ $isLocked ? 'style="pointer-events: none;"' : '' }}>
                <div class="template-thumb position-relative">
                    <img src="{{ Storage::url($template->preview) }}" alt="{{ $template->name }}">
                    @if($isLocked)
                        <div class="template-locked text-center">
                            <i class="bi bi-lock-fill fs-3"></i>
                            <div class="template-premium">Premium</div>
                        </div>
                    @endif
                    @if($template->is_premium)
                        <span class="position-absolute top-3 end-3 template-premium">Premium</span>
                    @endif
                </div>
                <div class="template-body">
                    <h6 class="template-name">{{ $template->name }}</h6>
                </div>
                <div class="template-actions">
                    @if(!$isLocked)
                        <button type="button" class="btn btn-template btn-create-template" onclick="window.location.href='{{ route('invitation.quick-create', ['category_id' => $category->id, 'template_id' => $template->id]) }}'">
                            <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                        </button>
                    @else
                        <button type="button" class="btn btn-template btn-locked" disabled>
                            <i class="bi bi-lock me-1"></i> Terkunci
                        </button>
                    @endif
                    <button type="button" class="btn btn-template btn-preview-template" onclick="window.open('{{ route('template.preview', [$template->slug, $template->id]) }}', '_blank')">
                        <i class="bi bi-eye me-1"></i> Preview
                    </button>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>

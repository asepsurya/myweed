<x-app-layout>

    <div class="container-fluid py-4" style="padding-bottom: 100px">
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold mb-1">Template Creator</h4>
                <p class="text-muted mb-0">Buat template undangan sendiri dengan bantuan AI</p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-48 rounded bg-primary bg-gradient bg-opacity-10 text-primary d-flex align-items-center justify-content-center">
                                <i class="bi bi-stars fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Buat dengan AI</h6>
                                <p class="text-muted small mb-0">Generate template otomatis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-48 rounded bg-success bg-gradient bg-opacity-10 text-success d-flex align-items-center justify-content-center">
                                <i class="bi bi-palette fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Kustomisasi</h6>
                                <p class="text-muted small mb-0">Edit kode sesuai keinginan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-48 rounded bg-warning bg-gradient bg-opacity-10 text-warning d-flex align-items-center justify-content-center">
                                <i class="bi bi-heart fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Gunakan</h6>
                                <p class="text-muted small mb-0">Untuk undangan pribadi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2">
                <a href="{{ route('template-creator.index') }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Semua
                </a>
                <a href="{{ route('template-creator.index', ['filter' => 'mine']) }}" class="btn btn-sm {{ request('filter') == 'mine' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Template Saya
                </a>
                <a href="{{ route('template-creator.index', ['filter' => 'system']) }}" class="btn btn-sm {{ request('filter') == 'system' ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Template Sistem
                </a>
            </div>
            <a href="{{ route('template-creator.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Buat Template Baru
            </a>
        </div>

        <div class="row g-3 g-md-4">
            @forelse ($templates as $template)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card border-0 shadow-sm h-100">
                        @php
                            $thumbSrc = template_thumbnail_url($template);
                        @endphp
                        <img src="{{ $thumbSrc }}" loading="lazy" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $template->name }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-semibold mb-1 text-truncate">{{ $template->name }}</h6>
                            <p class="text-muted small mb-2 text-truncate">{{ $template->description ?: ($template->category->name ?? 'Template') }}</p>
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('template-creator.editor', $template) }}" class="btn btn-outline-dark btn-sm" title="Code Editor">
                                    <i class="bi bi-code-slash"></i>
                                </a>
                                <a href="{{ route('template-creator.preview', $template) }}" target="_blank" class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="bi bi-eye me-1"></i> Preview
                                </a>
                                <a href="{{ route('template-creator.edit', $template) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('template-creator.destroy', $template) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus template ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                    <h6 class="text-muted">Belum ada template</h6>
                    <a href="{{ route('template-creator.create') }}" class="btn btn-primary btn-sm mt-2">
                        <i class="bi bi-plus-lg me-1"></i> Buat Template Pertama
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $templates->links() }}
        </div>
    </div>

</x-app-layout>

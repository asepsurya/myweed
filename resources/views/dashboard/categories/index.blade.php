<x-app-layout>
<style>
    .category-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid var(--bs-border-color);
        border-radius: 1rem;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        background-color: var(--adminuiux-bg-2, #ffffff);
    }
    .category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        border-color: rgba(198, 169, 98, 0.4);
    }
    .category-thumb {
        height: 160px;
        overflow: hidden;
        background: var(--bs-tertiary-bg);
        position: relative;
    }
    .category-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .category-card:hover .category-thumb img {
        transform: scale(1.05);
    }
    .category-no-thumb {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(198, 169, 98, 0.08), rgba(27, 42, 74, 0.05));
    }
    .badge-status {
        font-size: 0.72rem;
        padding: 0.35rem 0.75rem;
        border-radius: 999px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .fields-preview {
        font-size: 0.72rem;
        color: var(--bs-secondary-color);
        margin-top: 0.5rem;
    }
    .fields-preview span {
        display: inline-block;
        background: var(--bs-tertiary-bg);
        padding: 2px 7px;
        border-radius: 4px;
        margin-right: 4px;
        margin-bottom: 4px;
        border: 1px solid var(--bs-border-color);
    }
    .toggle-status-btn {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid var(--bs-border-color);
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    }
    .toggle-status-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    [data-bs-theme="dark"] .toggle-status-btn {
        background: var(--adminuiux-bg-1, #111827);
    }
</style>

<div class="container-fluid py-4">
    <!-- Header Halaman -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h4 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Kategori Undangan</h4>
                <span class="badge rounded-pill px-2.5 py-1 small" style="background: rgba(198, 169, 98, 0.15); color: #A68B4B; border: 1px solid rgba(198, 169, 98, 0.3);">
                    {{ $categories->count() }} Kategori
                </span>
            </div>
            <p class="text-muted mb-0 small">Kelola kategori undangan digital dan field formulir khusus untuk pengguna</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.create') }}" class="btn text-white rounded-pill px-4 fw-semibold shadow-sm"
                style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse($categories as $category)
        <div class="col-xl-3 col-lg-4 col-md-6 category-col" data-id="{{ $category->id }}">
            <div class="category-card">
                <!-- Thumbnail -->
                <div class="category-thumb position-relative">
                    @if($category->thumbnail_url)
                        <img src="{{ $category->thumbnail_url }}" alt="{{ $category->name }}">
                    @else
                        <div class="category-no-thumb">
                            {!! category_icon_html($category, 'text-muted', 'style="font-size: 2.5rem; opacity: 0.4;"') !!}
                        </div>
                    @endif

                    <!-- Status Badge -->
                    <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }} badge-status position-absolute" style="top: 12px; left: 12px;">
                        <i class="bi bi-{{ $category->is_active ? 'check-circle' : 'dash-circle' }} me-1"></i>{{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>

                    <!-- Status Toggle Form (PATCH) -->
                    <form action="{{ route('admin.categories.toggle', $category) }}" method="POST"
                          class="position-absolute" style="top: 10px; right: 10px; z-index: 5;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="toggle-status-btn"
                                onclick="return confirm('Ubah status kategori \'{{ addslashes($category->name) }}\'?')"
                                title="Klik untuk {{ $category->is_active ? 'menonaktifkan' : 'mengaktifkan' }}">
                            <i class="bi bi-toggle-{{ $category->is_active ? 'on text-success' : 'off text-secondary' }}" style="font-size: 1.15rem;"></i>
                        </button>
                    </form>
                </div>

                <!-- Card Content -->
                <div class="d-flex flex-column p-3 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0 text-truncate me-2" title="{{ $category->name }}">{{ $category->name }}</h6>
                        <span class="badge bg-light text-dark border flex-shrink-0" style="font-size: 0.72rem;">
                            {{ $category->active_template_count ?? 0 }} Template
                        </span>
                    </div>

                    @if($category->description)
                        <p class="card-text text-muted small mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                            {{ $category->description }}
                        </p>
                    @endif

                    <!-- Dynamic Fields Preview -->
                    <div class="fields-preview mb-3">
                        @php $fields = $category->dynamic_fields ?? []; @endphp
                        @forelse($fields as $field)
                            <span>{{ $field['label'] ?? $field['name'] ?? 'Field' }}</span>
                        @empty
                            <span class="text-muted fst-italic">Belum ada field khusus</span>
                        @endforelse
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto d-flex gap-2 align-items-center">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Urutan kategori">
                            <button type="button" class="btn btn-outline-secondary btn-reorder-cat"
                                data-id="{{ $category->id }}" data-direction="up" title="Naikkan urutan"
                                {{ $loop->first ? 'disabled' : '' }}>
                                <i class="bi bi-arrow-up"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-reorder-cat"
                                data-id="{{ $category->id }}" data-direction="down" title="Turunkan urutan"
                                {{ $loop->last ? 'disabled' : '' }}>
                                <i class="bi bi-arrow-down"></i>
                            </button>
                        </div>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary flex-fill rounded-pill">
                            <i class="bi bi-pencil me-1"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;"
                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirm Modal -->
        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header border-bottom-0 pb-0">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger-subtle text-danger" style="width: 40px; height: 40px;">
                                    <i class="bi bi-trash-fill fs-5"></i>
                                </div>
                                <h5 class="modal-title fw-bold mb-0">Hapus Kategori</h5>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body py-3">
                            <p class="text-secondary mb-0">
                                Yakin ingin menghapus kategori <strong class="text-dark">{{ $category->name }}</strong>?
                                Kategori yang masih memiliki template aktif tidak dapat dihapus.
                            </p>
                        </div>
                        <div class="modal-footer border-top-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm text-center py-5 rounded-4">
                <div class="card-body">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width: 72px; height: 72px; background: rgba(198, 169, 98, 0.12); color: #C6A962;">
                        <i class="bi bi-folder-plus fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Belum Ada Kategori</h5>
                    <p class="text-muted small mb-4">Tambahkan kategori pertama untuk mengelompokkan template undangan Anda.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn text-white rounded-pill px-4 fw-semibold shadow-sm"
                       style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            const csrf = '{{ csrf_token() }}';

            function applyOrder(order) {
                const row = document.querySelector('.row.g-4');
                if (!row || !Array.isArray(order)) return;

                order.forEach(function (id) {
                    const col = row.querySelector('.category-col[data-id="' + id + '"]');
                    if (col) row.appendChild(col);
                });

                const cols = row.querySelectorAll('.category-col[data-id]');
                cols.forEach(function (col, i) {
                    const up = col.querySelector('[data-direction="up"]');
                    const down = col.querySelector('[data-direction="down"]');
                    if (up) up.disabled = i === 0;
                    if (down) down.disabled = i === cols.length - 1;
                });
            }

            document.querySelectorAll('.btn-reorder-cat').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    if (btn.disabled) return;

                    fetch('{{ route("admin.categories.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            id: parseInt(btn.dataset.id, 10),
                            direction: btn.dataset.direction
                        })
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                applyOrder(data.order);
                            } else if (data.message && typeof Swal !== 'undefined') {
                                Swal.fire({ icon: 'info', title: 'Info', text: data.message, timer: 1600, showConfirmButton: false });
                            }
                        })
                        .catch(() => {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan' });
                            }
                        });
                });
            });
        })();
    </script>
@endpush
</x-app-layout>
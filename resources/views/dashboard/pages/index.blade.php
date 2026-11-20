<x-app-layout>
    <style>
        .page-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: 1px solid var(--bs-border-color);
            border-radius: 1rem;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .page-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }

        .page-thumb {
            height: 180px;
            overflow: hidden;
            background: var(--bs-tertiary-bg);
            position: relative;
        }

        .page-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .page-card:hover .page-thumb img {
            transform: scale(1.05);
        }

        .page-no-thumb {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.08), rgba(27, 42, 74, 0.05));
        }

        .badge-template {
            font-size: 0.72rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: 0.3px;
            background: rgba(27, 42, 74, 0.08);
            color: #1B2A4A;
            border: 1px solid rgba(27, 42, 74, 0.2);
        }

        .status-badge {
            font-size: 0.72rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .status-active {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
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
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        }

        .toggle-status-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        [data-bs-theme="dark"] .toggle-status-btn {
            background: var(--adminuiux-bg-1, #111827);
        }
    </style>

    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h4 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Halaman Statis</h4>
                    <span class="badge rounded-pill px-2.5 py-1 small"
                        style="background: rgba(198, 169, 98, 0.15); color: #A68B4B; border: 1px solid rgba(198, 169, 98, 0.3);">
                        {{ $pages->count() }} Halaman
                    </span>
                </div>
                <p class="text-muted mb-0 small">Kelola halaman statis (Tentang, Kontak, FAQ, dsb.) seperti WordPress</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pages.index') }}" target="_blank"
                    class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                    <i class="bi bi-eye me-1"></i> Lihat Semua
                </a>
                <a href="{{ route('admin.pages.create') }}"
                    class="btn text-white rounded-pill px-4 fw-semibold shadow-sm"
                    style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Halaman
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Filter --}}
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-6 col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="form-control" placeholder="Cari judul atau slug halaman...">
                </div>
            </div>
            <div class="col-md-4 col-lg-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-2 d-grid">
                <button type="submit" class="btn btn-outline-primary rounded-3">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
            </div>
        </form>

        <div class="row g-4">
            @forelse($pages as $page)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="page-card">
                        {{-- Thumbnail --}}
                        <div class="page-thumb position-relative">
                            @if($page->image)
                                <img src="{{ asset('storage/'.$page->image) }}" alt="{{ $page->title }}">
                            @else
                                <div class="page-no-thumb">
                                    <i class="bi bi-file-earmark-text text-muted" style="font-size: 3rem; opacity: 0.4;"></i>
                                </div>
                            @endif

                            <span class="badge badge-template position-absolute" style="top: 12px; left: 12px;">
                                <i class="bi bi-layout-text-window me-1"></i>{{ $page->template_label }}
                            </span>

                            <span class="status-badge position-absolute status-{{ $page->is_active ? 'active' : 'inactive' }}"
                                style="bottom: 12px; left: 12px;">
                                <i class="bi bi-{{ $page->is_active ? 'check-circle' : 'dash-circle' }} me-1"></i>
                                {{ $page->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                        </div>

                        {{-- Content --}}
                        <div class="d-flex flex-column p-3 flex-grow-1">
                            <h6 class="fw-bold mb-2 text-truncate" title="{{ $page->title }}">{{ $page->title }}</h6>

                            <p class="text-muted small mb-2 flex-grow-1"
                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                {{ $page->snippet ?: 'Belum ada ringkasan.' }}
                            </p>

                            <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                                <span title="Slug"><i class="bi bi-link-45deg me-1"></i>/{{ $page->slug }}</span>
                            </div>

                            <div class="mt-auto d-flex gap-2 align-items-center">
                                <a href="{{ route('admin.pages.edit', $page) }}"
                                    class="btn btn-sm btn-outline-primary flex-fill rounded-pill">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <a href="{{ route('pages.show', $page->slug) }}" target="_blank"
                                    class="btn btn-sm btn-outline-secondary rounded-circle p-2"
                                    style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;"
                                    title="Lihat halaman">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <button type="button"
                                    class="toggle-status-btn border-0 js-toggle-status"
                                    data-url="{{ route('admin.pages.toggle', $page) }}"
                                    title="{{ $page->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="bi bi-{{ $page->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                    style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $page->id }}" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Delete Modal --}}
                <div class="modal fade" id="deleteModal{{ $page->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header border-bottom-0 pb-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger-subtle text-danger"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-trash-fill fs-5"></i>
                                        </div>
                                        <h5 class="modal-title fw-bold mb-0">Hapus Halaman</h5>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body py-3">
                                    <p class="text-secondary mb-0">
                                        Yakin ingin menghapus halaman <strong class="text-dark">{{ $page->title }}</strong>?
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
                                <i class="bi bi-file-earmark-text fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-1">Belum Ada Halaman</h5>
                            <p class="text-muted small mb-4">Tambahkan halaman statis pertama Anda.</p>
                            <a href="{{ route('admin.pages.create') }}"
                                class="btn text-white rounded-pill px-4 fw-semibold shadow-sm"
                                style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Halaman
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            document.querySelectorAll('.js-toggle-status').forEach(function (btn) {
                btn.addEventListener('click', async function () {
                    if (btn.disabled) return;
                    btn.disabled = true;

                    try {
                        const res = await fetch(btn.dataset.url, {
                            method: 'PATCH',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await res.json();
                        if (data.success) {
                            window.location.reload();
                        }
                    } catch (e) {
                        console.error('Gagal mengubah status:', e);
                        btn.disabled = false;
                    }
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
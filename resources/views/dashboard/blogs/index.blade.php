<x-app-layout>
    <style>
        .blog-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: 1px solid var(--bs-border-color);
            border-radius: 1rem;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
        }

        .blog-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }

        .blog-thumb {
            height: 200px;
            overflow: hidden;
            background: var(--bs-tertiary-bg);
            position: relative;
        }

        .blog-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .blog-card:hover .blog-thumb img {
            transform: scale(1.05);
        }

        .blog-no-thumb {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(198, 169, 98, 0.08), rgba(27, 42, 74, 0.05));
        }

        .badge-type {
            font-size: 0.72rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-inspirasi {
            background: rgba(198, 169, 98, 0.15);
            color: #A68B4B;
            border: 1px solid rgba(198, 169, 98, 0.3);
        }

        .badge-panduan {
            background: rgba(27, 42, 74, 0.15);
            color: #1B2A4A;
            border: 1px solid rgba(27, 42, 74, 0.3);
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
    </style>

    <div class="container-fluid py-4">
        <!-- Header Halaman -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h4 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Blog Inspirasi &
                        Panduan</h4>
                    <span class="badge rounded-pill px-2.5 py-1 small"
                        style="background: rgba(198, 169, 98, 0.15); color: #A68B4B; border: 1px solid rgba(198, 169, 98, 0.3);">
                        {{ $blogs->count() }} Post
                    </span>
                </div>
                <p class="text-muted mb-0 small">Kelola inspirasi dan panduan untuk website undangan ini</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.blogs.comments') }}"
                    class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                    <i class="bi bi-chat-dots me-1"></i> Komentar
                </a>
                <a href="{{ route('admin.blogs.create') }}"
                    class="btn text-white rounded-pill px-4 fw-semibold shadow-sm"
                    style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Post
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
            @forelse($blogs as $blog)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="blog-card">
                        <!-- Thumbnail -->
                        <div class="blog-thumb position-relative">
                            @if($blog->image)
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}">
                            @else
                                <div class="blog-no-thumb">
                                    <i class="bi bi-text-width text-muted" style="font-size: 3rem; opacity: 0.4;"></i>
                                </div>
                            @endif

                            <!-- Type Badge -->
                            <span
                                class="badge badge-type badge-{{ $blog->type === 'inspirasi' ? 'inspirasi' : 'panduan' }} position-absolute"
                                style="top: 12px; left: 12px;">
                                <i
                                    class="bi bi-{{ $blog->type === 'inspirasi' ? 'star' : 'book' }} me-1"></i>{{ ucfirst($blog->type) }}
                            </span>

                            <!-- Status Badge -->
                            <span class="status-badge position-absolute" style="bottom: 12px; left: 12px;">
                                <i class="bi bi-{{ $blog->is_active ? 'check-circle' : 'dash-circle' }} me-1"></i>
                                {{ $blog->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <!-- Card Content -->
                        <div class="d-flex flex-column p-3 flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="fw-bold mb-0 text-truncate me-2" title="{{ $blog->title }}">{{ $blog->title }}
                                </h6>
                                <span class="badge bg-light text-dark flex-shrink-0" style="font-size: 0.72rem;">
                                    {{ ucfirst($blog->type) }}
                                </span>
                            </div>

                            @if($blog->excerpt)
                                <p class="card-text text-muted small mb-2"
                                    style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                    {{ $blog->excerpt }}
                                </p>
                            @endif

                            <!-- Statistik -->
                            <div class="d-flex align-items-center gap-3 text-muted small mb-3">
                                <span title="Jumlah view"><i class="bi bi-eye me-1"></i>{{ number_format($blog->views_count ?? 0, 0, ',', '.') }}</span>
                                <span title="Jumlah suka"><i class="bi bi-heart me-1"></i>{{ $blog->likes_count }}</span>
                                <a href="{{ route('admin.blogs.comments', ['blog' => $blog->id]) }}"
                                    class="text-decoration-none" title="Lihat komentar">
                                    <i class="bi bi-chat me-1"></i>{{ $blog->comments_count }}
                                </a>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('admin.blogs.edit', $blog) }}"
                                    class="btn btn-sm btn-outline-primary flex-fill rounded-pill">
                                    <i class="bi bi-pencil me-1"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                    style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $blog->id }}" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirm Modal -->
                <div class="modal fade" id="deleteModal{{ $blog->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4">
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header border-bottom-0 pb-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="d-flex align-items-center justify-content-center rounded-3 bg-danger-subtle text-danger"
                                            style="width: 40px; height: 40px;">
                                            <i class="bi bi-trash-fill fs-5"></i>
                                        </div>
                                        <h5 class="modal-title fw-bold mb-0">Hapus Post</h5>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body py-3">
                                    <p class="text-secondary mb-0">
                                        Yakin ingin menghapus post <strong class="text-dark">{{ $blog->title }}</strong>?
                                    </p>
                                </div>
                                <div class="modal-footer border-top-0 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal</button>
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
                                <i class="bi bi-text-width fs-2"></i>
                            </div>
                            <h5 class="fw-bold mb-1">Belum Ada Post</h5>
                            <p class="text-muted small mb-4">Tambahkan post blog pertama untuk berbagi inspirasi dan
                                panduan.</p>
                            <a href="{{ route('admin.blogs.create') }}"
                                class="btn text-white rounded-pill px-4 fw-semibold shadow-sm"
                                style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Post
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <style>
        .promo-card {
            background: var(--bs-card-bg, #ffffff);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
        }

        .promo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }

        .promo-thumb {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 16px 16px 0 0;
        }
    </style>

    <div class="container-fluid py-3 py-md-4">
        {{-- Page Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="mb-1 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <i class="bi bi-megaphone-fill me-2" style="color: #C6A962;"></i> Manajemen Promosi & Banner
                </h4>
                <p class="text-muted small mb-0">Kelola banner promosi dan penawaran khusus yang tampil pada platform</p>
            </div>
            <a href="{{ route('promotions.create') }}" class="btn text-white btn-sm px-3 py-2 fw-semibold rounded-3 shadow-sm"
               style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Promosi
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($promotions as $promo)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card promo-card shadow-sm border-0">
                        @if($promo->media_type === 'video' && $promo->video_file)
                            <video class="promo-thumb" muted>
                                <source src="{{ asset('storage/' . $promo->video_file) }}" type="video/mp4">
                            </video>
                        @elseif($promo->media_type === 'youtube' && $promo->embed_url)
                            <div class="promo-thumb d-flex align-items-center justify-content-center bg-dark position-relative">
                                <i class="bi bi-youtube text-danger" style="font-size: 2.5rem;"></i>
                                <span class="position-absolute bottom-0 end-0 badge bg-danger-subtle text-danger border border-danger-subtle m-2">
                                    YouTube
                                </span>
                            </div>
                        @elseif($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title ?? 'Promosi' }}" class="promo-thumb">
                        @else
                            <div class="promo-thumb d-flex align-items-center justify-content-center bg-light">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $promo->title ?? 'Tanpa Judul' }}</h5>
                                    <span
                                        class="badge rounded-pill {{ $promo->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                                        {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;"
                                            type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3" style="z-index: 1050;">
                                        <li>
                                            <a class="dropdown-item py-2"
                                                href="{{ route('promotions.edit', $promo) }}">
                                                <i class="bi bi-pencil me-2 text-warning"></i> Edit Banner
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item py-2 text-danger"
                                                onclick="confirmDeletePromo({{ $promo->id }})">
                                                <i class="bi bi-trash me-2"></i> Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <form id="delete-promo-form-{{ $promo->id }}" action="{{ route('promotions.destroy', $promo) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>

                            <div class="mb-3 text-muted small">
                                <p class="mb-1 d-flex align-items-center gap-1">
                                    <i class="bi bi-collection-play text-gold"></i> Tipe Media:
                                    @if($promo->media_type === 'video')
                                        <span class="badge bg-info-subtle text-info border border-info-subtle">Video</span>
                                    @elseif($promo->media_type === 'youtube')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">YouTube</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Gambar</span>
                                    @endif
                                </p>
                                @if($promo->video_url)
                                    <p class="mb-1 text-truncate d-flex align-items-center gap-1">
                                        <i class="bi bi-youtube text-danger"></i> {{ $promo->video_url }}
                                    </p>
                                @endif
                                @if($promo->link_url)
                                    <p class="mb-1 text-truncate d-flex align-items-center gap-1">
                                        <i class="bi bi-link-45deg text-primary"></i> {{ $promo->link_url }}
                                    </p>
                                @endif
                                <p class="mb-0 d-flex align-items-center gap-1">
                                    <i class="bi bi-sort-numeric-down text-gold"></i> Urutan Tayang: {{ $promo->sort_order }}
                                </p>
                            </div>

                            <div class="mt-auto pt-3 border-top" style="border-color: var(--bs-border-color) !important;">
                                <small class="text-muted">
                                    Dibuat: {{ $promo->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card promo-card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <div class="empty-icon mb-3 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 64px; height: 64px; background: rgba(198, 169, 98, 0.12); color: #C6A962; font-size: 1.8rem;">
                                <i class="bi bi-megaphone"></i>
                            </div>
                            <h6 class="fw-bold mb-1">Belum ada promosi</h6>
                            <p class="text-muted small mb-3">Mulai buat banner promosi pertama Anda sekarang.</p>
                            <a href="{{ route('promotions.create') }}" class="btn text-white btn-sm px-4 py-2 fw-semibold rounded-3 shadow-sm"
                               style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Promosi Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function confirmDeletePromo(id) {
            Swal.fire({
                title: 'Hapus promosi ini?',
                text: "Data promosi yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-promo-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

<x-app-layout>
   
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold m-0" style="font-family: 'Plus Jakarta Sans', sans-serif; color: var(--bs-body-color);">
                <i class="bi bi-megaphone me-2" style="color: var(--adminuiux-theme-1);"></i> Manajemen Promosi
            </h2>
            <a href="{{ route('promotions.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold"
                style="border-radius: 10px;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Promosi
            </a>
        </div>
  

    <style>
        .promo-card {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .promo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }

        .promo-thumb {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }
    </style>

    <div class="container mt-4" style="padding-bottom: 100px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($promotions as $promo)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card promo-card shadow-sm">
                        <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title ?? 'Promosi' }}" class="promo-thumb">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $promo->title ?? 'Tanpa Judul' }}</h5>
                                    <span
                                        class="badge rounded-pill {{ $promo->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                                        {{ $promo->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button
                                        class="btn btn-sm btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center"
                                        type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                        <li>
                                            <a class="dropdown-item py-2"
                                                href="{{ route('promotions.edit', $promo) }}">
                                                <i class="bi bi-pencil me-2"></i> Edit
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

                            <div class="mb-3">
                                @if($promo->link_url)
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-link-45deg me-1"></i> {{ $promo->link_url }}
                                    </p>
                                @endif
                                <p class="text-muted small mb-0">
                                    <i class="bi bi-sort-numeric-down me-1"></i> Urutan: {{ $promo->sort_order }}
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
                    <div class="card promo-card shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="empty-icon mb-3"
                                style="width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg); color: var(--bs-secondary-color); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto;">
                                <i class="bi bi-megaphone"></i>
                            </div>
                            <h6 class="text-muted mb-1">Belum ada promosi.</h6>
                            <p class="text-muted small mb-3">Mulai buat banner promosi pertama Anda di sini.</p>
                            <a href="{{ route('promotions.create') }}" class="btn btn-primary btn-sm px-4 py-2"
                                style="border-radius: 10px;">
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

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold m-0" style="font-family: 'Plus Jakarta Sans', sans-serif; color: var(--bs-body-color);">
                <i class="bi bi-ticket-perforated me-2" style="color: var(--adminuiux-theme-1);"></i> Manajemen Kupon Promo
            </h2>
            <a href="{{ route('coupons.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold"
                style="border-radius: 10px;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kupon
            </a>
        </div>
    </x-slot>

    <style>
        .coupon-card {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .coupon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }

        .coupon-code {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: 1px;
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
            @forelse($coupons as $coupon)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card coupon-card shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="fw-bold mb-1">Kupon Promo</h5>
                                    <span
                                        class="badge rounded-pill {{ $coupon->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                                        {{ $coupon->is_active ? 'Aktif' : 'Nonaktif' }}
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
                                                href="{{ route('coupons.edit', $coupon) }}">
                                                <i class="bi bi-pencil me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item py-2 text-danger"
                                                onclick="confirmDeleteCoupon({{ $coupon->id }})">
                                                <i class="bi bi-trash me-2"></i> Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="coupon-code mb-0">
                                    {{ $coupon->code }}
                                </div>
                                <p class="text-muted small mb-0 mt-1">
                                    {{ $coupon->type === 'percentage' ? 'Diskon ' . $coupon->value . '%' : 'Potongan Rp ' . number_format($coupon->value, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="mb-3">
                                @if($coupon->min_amount)
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-currency-exchange me-1"></i> Minimal pembelian Rp {{ number_format($coupon->min_amount, 0, ',', '.') }}
                                    </p>
                                @endif
                                @if($coupon->max_uses)
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-ticket me-1"></i> Sisa kuota: {{ max(0, $coupon->max_uses - $coupon->used_count) }} / {{ $coupon->max_uses }}
                                    </p>
                                @else
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-ticket me-1"></i> Kuota: Unlimited
                                    </p>
                                @endif
                                @if($coupon->starts_at)
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-calendar-event me-1"></i> Mulai {{ $coupon->starts_at->format('d M Y H:i') }}
                                    </p>
                                @endif
                                @if($coupon->expires_at)
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-calendar-x me-1"></i> Berakhir {{ $coupon->expires_at->format('d M Y H:i') }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-auto pt-3 border-top" style="border-color: var(--bs-border-color) !important;">
                                <small class="text-muted">
                                    Tipe: <span class="text-capitalize">{{ $coupon->type }}</span>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card coupon-card shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="empty-icon mb-3"
                                style="width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg); color: var(--bs-secondary-color); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto;">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <h6 class="text-muted mb-1">Belum ada kupon promo.</h6>
                            <p class="text-muted small mb-3">Mulai buat kupon promo pertama Anda di sini.</p>
                            <a href="{{ route('coupons.create') }}" class="btn btn-primary btn-sm px-4 py-2"
                                style="border-radius: 10px;">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Kupon Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function confirmDeleteCoupon(id) {
            Swal.fire({
                title: 'Hapus kupon ini?',
                text: "Data kupon yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-coupon-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

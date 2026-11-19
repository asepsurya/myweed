<x-app-layout>
    <style>
        .coupon-card {
            background: var(--bs-card-bg, #ffffff);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .coupon-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }

        .coupon-code {
            font-family: 'Plus Jakarta Sans', monospace, sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: 1.5px;
            color: #C6A962;
        }

        .coupon-code-badge {
            background: rgba(198, 169, 98, 0.12);
            border: 1px dashed #C6A962;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            display: inline-block;
        }
    </style>

    <div class="container-fluid py-3 py-md-4">
        {{-- Page Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="mb-1 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <i class="bi bi-ticket-perforated-fill me-2" style="color: #C6A962;"></i> Manajemen Kupon & Voucher
                </h4>
                <p class="text-muted small mb-0">Kelola kode diskon, voucher berlangganan, dan promo spesial untuk pelanggan</p>
            </div>
            <a href="{{ route('coupons.create') }}" class="btn text-white btn-sm px-3 py-2 fw-semibold rounded-3 shadow-sm"
               style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kupon
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
            @forelse($coupons as $coupon)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card coupon-card shadow-sm border-0">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge rounded-pill {{ $coupon->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                                        {{ $coupon->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;"
                                            type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('coupons.edit', $coupon) }}">
                                                <i class="bi bi-pencil me-2 text-warning"></i> Edit Kupon
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item py-2 text-danger"
                                                onclick="confirmDeleteCoupon({{ $coupon->id }})">
                                                <i class="bi bi-trash me-2"></i> Hapus Kupon
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-3 text-center py-2">
                                <div class="coupon-code-badge mb-2">
                                    <span class="coupon-code">{{ $coupon->code }}</span>
                                </div>
                                <p class="text-body fw-semibold small mb-0">
                                    @if($coupon->type === 'percentage')
                                        Diskon {{ $coupon->value }}%
                                    @elseif($coupon->type === 'fixed')
                                        Potongan Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                    @elseif($coupon->type === 'voucher')
                                        Voucher Langganan
                                        @if($coupon->plan)
                                            ({{ $coupon->plan->name }})
                                        @else
                                            (Semua Paket)
                                        @endif
                                    @endif
                                </p>
                            </div>

                            <div class="mb-3 text-muted small border-top pt-3">
                                @if($coupon->type !== 'voucher' && $coupon->min_amount)
                                    <p class="mb-1 d-flex align-items-center gap-1">
                                        <i class="bi bi-currency-exchange text-gold"></i> Min. beli: Rp {{ number_format($coupon->min_amount, 0, ',', '.') }}
                                    </p>
                                @endif
                                @if($coupon->type !== 'voucher')
                                    <p class="mb-1 d-flex align-items-center gap-1">
                                        <i class="bi bi-ticket-detailed text-primary"></i> Sisa kuota:
                                        {{ max(0, $coupon->max_uses - $coupon->used_count) }} /
                                        {{ $coupon->max_uses ?? 'Unlimited' }}
                                    </p>
                                @endif
                                @if($coupon->starts_at)
                                    <p class="mb-1 d-flex align-items-center gap-1">
                                        <i class="bi bi-calendar-check text-info"></i> Mulai: {{ $coupon->starts_at->format('d M Y H:i') }}
                                    </p>
                                @endif
                                @if($coupon->expires_at)
                                    <p class="mb-1 d-flex align-items-center gap-1">
                                        <i class="bi bi-calendar-x text-danger"></i> Berakhir: {{ $coupon->expires_at->format('d M Y H:i') }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    Tipe: <span class="badge bg-light text-dark border">{{ $coupon->type === 'voucher' ? 'Voucher Langganan' : ucfirst($coupon->type) }}</span>
                                </small>
                            </div>

                            <form id="delete-coupon-form-{{ $coupon->id }}" action="{{ route('coupons.destroy', $coupon) }}"
                                method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card coupon-card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <div class="empty-icon mb-3 rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 64px; height: 64px; background: rgba(198, 169, 98, 0.12); color: #C6A962; font-size: 1.8rem;">
                                <i class="bi bi-ticket-perforated"></i>
                            </div>
                            <h6 class="fw-bold mb-1">Belum ada kupon promo</h6>
                            <p class="text-muted small mb-3">Mulai buat kupon promo atau voucher pertama Anda sekarang.</p>
                            <a href="{{ route('coupons.create') }}" class="btn text-white btn-sm px-4 py-2 fw-semibold rounded-3 shadow-sm"
                               style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
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
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-people me-2"></i> Manajemen Langganan Pengguna
            </h2>
            <a href="{{ route('subscription-plans.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Paket
            </a>
        </div>
    </x-slot>

    <style>
        .plan-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 20px;
        }
        .plan-free {
            background: #d1fae5;
            color: #065f46;
        }
        .plan-basic {
            background: #dbeafe;
            color: #1e40af;
        }
        .plan-pro {
            background: #fef3c7;
            color: #92400e;
        }
        .plan-expired {
            background: #fee2e2;
            color: #991b1b;
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

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-muted">Cari Pengguna</label>
                        <input type="text" name="search" class="form-control" placeholder="Nama atau email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted">Filter Paket</label>
                        <select name="plan" class="form-select">
                            <option value="">Semua Paket</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ request('plan') == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <span class="text-muted small">Total: <strong>{{ $users->total() }}</strong> pengguna</span>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Pengguna</th>
                                <th>Paket Aktif</th>
                                <th>Status</th>
                                <th>Berlaku Sampai</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                @php
                                    $subscription = $user->subscription;
                                    $plan = $subscription->plan ?? null;
                                    $isActive = $subscription && $subscription->is_active && $subscription->end_date->isFuture();
                                    $isExpired = $subscription && (!$subscription->is_active || !$subscription->end_date->isFuture());
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; font-weight: 700;">
                                                {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <div class="small text-muted">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($plan)
                                            <span class="plan-badge plan-{{ $plan->slug }}">
                                                {{ $plan->name }}
                                            </span>
                                        @else
                                            <span class="text-muted small">Belum berlangganan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($isActive)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                        @elseif($isExpired)
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Expired</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($subscription && $subscription->end_date)
                                            {{ $subscription->end_date->format('d M Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                                <li>
                                                    <button type="button" class="dropdown-item py-2" data-bs-toggle="modal" data-bs-target="#changePlanModal{{ $user->id }}">
                                                        <i class="bi bi-arrow-repeat me-2"></i> Ganti Paket
                                                    </button>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider my-1">
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item py-2 text-danger" onclick="confirmCancel({{ $user->id }})">
                                                        <i class="bi bi-x-circle me-2"></i> Batalkan Langganan
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>

                                        <form id="cancel-form-{{ $user->id }}" action="{{ route('admin.subscriptions.cancel', $user) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('POST')
                                        </form>

                                        <div class="modal fade" id="changePlanModal{{ $user->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4">
                                                    <div class="modal-header border-0 pb-0">
                                                        <h5 class="modal-title fw-bold">Ganti Paket - {{ $user->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.subscriptions.update-plan', $user) }}" method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Pilih Paket Baru</label>
                                                                <select name="subscription_plan_id" class="form-select" required>
                                                                    @foreach($plans as $planOption)
                                                                        <option value="{{ $planOption->id }}" {{ $plan && $plan->id == $planOption->id ? 'selected' : '' }}>
                                                                            {{ $planOption->name }} - {{ $planOption->is_free ? 'Gratis' : 'Rp ' . number_format($planOption->price, 0, ',', '.') }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Perpanjang (Hari)</label>
                                                                <input type="number" name="duration" class="form-control" value="{{ $plan->duration ?? 30 }}" min="1">
                                                                <div class="form-text">Jumlah hari untuk memperpanjang langganan.</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 pt-0">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="empty-icon mb-3" style="width: 50px; height: 50px; border-radius: 50%; background: var(--bs-tertiary-bg); color: var(--bs-secondary-color); display: flex; align-items: center; justify-content: center; font-size: 1.25rem; margin: 0 auto;">
                                            <i class="bi bi-inbox"></i>
                                        </div>
                                        <h6 class="text-muted mb-1">Belum ada pengguna berlangganan.</h6>
                                        <p class="text-muted small mb-0">Pengguna yang berlangganan akan muncul di sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    <script>
        function confirmCancel(userId) {
            Swal.fire({
                title: 'Batalkan langganan?',
                text: "Pengguna akan kehilangan akses ke fitur premium.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, batalkan!',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-form-' + userId).submit();
                }
            });
        }
    </script>
</x-app-layout>

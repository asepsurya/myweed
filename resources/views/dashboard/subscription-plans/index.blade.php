<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0" style="font-family: 'Plus Jakarta Sans', sans-serif; color: var(--bs-body-color);">
                <i class="bi bi-tags me-2" style="color: var(--adminuiux-theme-1);"></i> Manajemen Paket & Harga
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-primary btn-sm px-3 py-2 fw-bold"
                    style="border-radius: 10px;">
                    <i class="bi bi-people me-1"></i> Pengguna
                </a>
                <a href="{{ route('subscription-plans.create') }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold"
                    style="border-radius: 10px;">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Paket
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        /* Plan Card Custom */
        .plan-card {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 98, 0.4);
        }

        [data-bs-theme="dark"] .plan-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            border-color: var(--adminuiux-theme-1);
        }

        .plan-price {
            color: var(--adminuiux-theme-1);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.75rem;
        }

        .feature-list-item {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            color: var(--bs-secondary-color);
            margin-bottom: 0.5rem;
        }

        .feature-list-item i {
            color: var(--adminuiux-theme-1);
            /* Gold checkmark */
            margin-top: 2px;
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

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-tags"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Total Paket</div>
                                <div class="fw-bold fs-5">{{ $plans->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Total Pengguna Berlangganan</div>
                                <div class="fw-bold fs-5">{{ \App\Models\Subscription::where('is_active', true)->where('end_date', '>', now())->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Pendapatan Bulan Ini</div>
                                <div class="fw-bold fs-5">Rp {{ number_format(\App\Models\Payment::where('status', 'paid')->whereMonth('created_at', now()->month)->sum('amount'), 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-sm bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Akan Expired (7 Hari)</div>
                                <div class="fw-bold fs-5">{{ \App\Models\Subscription::where('is_active', true)->whereBetween('end_date', [now(), now()->addDays(7)])->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($plans as $plan)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card plan-card shadow-sm">
                        <div class="card-body d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div>
                                    <h5 class="fw-bold mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        {{ $plan->name }}
                                    </h5>
                                    <span
                                        class="badge rounded-pill {{ $plan->is_free ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-primary-subtle text-primary border border-primary-subtle' }}">
                                        {{ $plan->is_free ? 'Gratis' : 'Berbayar' }}
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
                                                href="{{ route('subscription-plans.edit', $plan) }}">
                                                <i class="bi bi-pencil me-2"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider my-1">
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item py-2 text-danger"
                                                onclick="confirmDeletePlan({{ $plan->id }})">
                                                <i class="bi bi-trash me-2"></i> Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="mb-4">
                                @if(!$plan->is_free && $plan->original_price && $plan->original_price > $plan->price)
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="text-muted text-decoration-line-through small">
                                            Rp {{ number_format($plan->original_price, 0, ',', '.') }}
                                        </span>
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1" style="font-size: 0.65rem;">
                                            <i class="bi bi-fire me-1"></i>{{ $plan->badge_text ?: 'Spesial Launching' }}
                                        </span>
                                    </div>
                                @endif
                                <div class="plan-price mb-0">
                                    {{ $plan->is_free ? 'Gratis' : 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                                </div>
                                <p class="text-muted small mb-0 mt-1">
                                    <i class="bi bi-clock me-1"></i> Berlaku selama {{ $plan->duration }} Hari
                                </p>
                            </div>

                            <div class="mb-3 flex-grow-1">
                                <p class="text-muted small fw-semibold mb-3 text-uppercase" style="letter-spacing: 0.5px;">
                                    Keunggulan Paket:</p>
                                <ul class="list-unstyled mb-0">
                                    @php
                                        $features = json_decode($plan->description ?? '[]') ?: [];
                                        usort($features, function($a, $b) {
                                            $aYes = preg_match('/:\s*Yes$/', $a) ? 0 : (preg_match('/:\s*No$/', $a) ? 1 : 2);
                                            $bYes = preg_match('/:\s*Yes$/', $b) ? 0 : (preg_match('/:\s*No$/', $b) ? 1 : 2);
                                            return $aYes <=> $bYes;
                                        });
                                    @endphp
                                    @foreach($features as $feature)
                                        @php
                                            $featureName = preg_replace('/:\s*(Yes|No)$/', '', $feature);
                                            $isYes = preg_match('/:\s*Yes$/', $feature);
                                            $isNo = preg_match('/:\s*No$/', $feature);
                                        @endphp
                                        <li class="feature-list-item small {{ $isNo ? 'text-muted' : '' }}">
                                            @if($isYes)
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            @elseif($isNo)
                                                <i class="bi bi-x-circle text-muted-custom"></i>
                                            @else
                                                <i class="bi bi-check-circle-fill"></i>
                                            @endif
                                            <span>{{ $featureName }}</span>
                                        </li>
                                    @endforeach
                                    @if(empty($features))
                                        <li class="small text-muted fst-italic">Belum ada fitur ditambahkan.</li>
                                    @endif
                                </ul>
                            </div>

                            <div class="mt-auto pt-3 border-top" style="border-color: var(--bs-border-color) !important;">
                                <small class="text-muted d-flex align-items-center">
                                    Slug: <code class="ms-1 text-primary">{{ $plan->slug }}</code>
                                </small>
                            </div>

                            <form id="delete-plan-form-{{ $plan->id }}"
                                action="{{ route('subscription-plans.destroy', $plan) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card plan-card shadow-sm">
                        <div class="card-body text-center py-5">
                            <div class="empty-icon mb-3"
                                style="width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg); color: var(--bs-secondary-color); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto;">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h6 class="text-muted mb-1">Belum ada paket tersedia.</h6>
                            <p class="text-muted small mb-3">Mulai buat paket berlangganan pertama Anda di sini.</p>
                            <a href="{{ route('subscription-plans.create') }}" class="btn btn-primary btn-sm px-4 py-2"
                                style="border-radius: 10px;">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Paket Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // Swal2 Delete Confirmation for Plan
        function confirmDeletePlan(id) {
            Swal.fire({
                title: 'Hapus paket ini?',
                text: "Data paket yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-plan-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
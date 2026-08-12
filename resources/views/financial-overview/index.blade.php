<x-app-layout>
    @php
        $data = $financialData;
    @endphp

    <style>
        h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--bs-body-color);
        }

        .stat-card-custom {
            background: #ffffff;
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            transition: all 0.3s ease;
            height: 100%;
        }

        [data-bs-theme=dark] .stat-card-custom {
            background: none;
        }

        .stat-card-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 92, 0.4);
        }

        [data-bs-theme="dark"] .stat-card-custom:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            border-color: var(--adminuiux-theme-1);
        }

        .stat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .progress-budget {
            height: 10px;
            border-radius: 10px;
            overflow: hidden;
            background: var(--bs-tertiary-bg);
        }

        .activity-item {
            border-bottom: 1px solid var(--bs-border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .payment-badge {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .activity-feed {
            max-height: 320px;
            overflow-y: auto;
        }
    </style>

    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Ikhtisar Keuangan</h4>
            <p class="text-muted mb-0">Pantau anggaran, tabungan, dan jadwal pembayaran dalam satu tampilan</p>
        </div>
    </div>

    <!-- Money Available -->
    <div class="alert alert-gold d-flex align-items-center gap-3" role="alert" style="background: linear-gradient(135deg, rgba(198, 169, 92, 0.1), rgba(198, 169, 92, 0.05));
                border: 1px solid rgba(198, 169, 92, 0.3); border-radius: 16px;">
        <div class="stat-icon-box bg-success-subtle text-success flex-shrink-0">
            <i class="bi bi-pig-coin fs-4"></i>
        </div>
        <div>
            <div class="fw-bold fs-5" style="color: var(--adminuiux-theme-2);">
                Dana Tersedia: Rp {{ number_format($data['money_available'], 0, ',', '.') }}
            </div>
            <small class="text-muted" style="color: var(--adminuiux-theme-2);">
                Total tabungan + anggaran tersisa — gunakan untuk jadwal pembayaran vendor.
            </small>
        </div>
    </div>

    <!-- Top Row: Budget + Savings Snapshot -->
    <div class="row g-4 mb-4">
        <!-- Budget Snapshot -->
        <div class="col-lg-6">
            <div class="card stat-card-custom shadow-sm h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-wallet2 me-2" style="color: var(--adminuiux-theme-2);"></i>
                        Ringkasan Anggaran
                    </h6>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Total: Rp
                                {{ number_format($data['budget']['total_amount'], 0, ',', '.') }}</small>
                            <small class="text-muted">Terpakai: {{ $data['budget']['usage_percent'] }}%</small>
                        </div>
                        <div class="progress-budget">
                            <div class="track"
                                style="width: {{ min(100, $data['budget']['usage_percent']) }}%; background: var(--adminuiux-theme-1);">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 text-center mb-2">
                        <div class="col-4">
                            <div class="fw-bold">{{ number_format($data['budget']['total_spent'], 0, ',', '.') }}</div>
                            <small class="text-muted">Terpakai</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold text-success">
                                {{ number_format($data['budget']['total_remaining'], 0, ',', '.') }}
                            </div>
                            <small class="text-muted">Tersisa</small>
                        </div>
                        <div class="col-4">
                            <div
                                class="fw-bold {{ $data['budget']['is_over_budget'] ? 'text-danger' : 'text-success' }}">
                                {{ $data['budget']['is_over_budget'] ? 'Over' : 'Seimbang' }}
                            </div>
                            <small class="text-muted">Status</small>
                        </div>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted fw-semibold d-block mb-1">Kategori:</small>
                        @foreach($data['budget']['categories'] as $cat)
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge rounded-circle"
                                    style="background: {{ $cat['colour'] }}; width: 14px; height: 14px;"></span>
                                <span class="small">{{ $cat['name'] }}</span>
                                <span class="ms-auto small text-muted">
                                    {{ number_format($cat['spent'], 0, ',', '.') }} /
                                    {{ number_format($cat['allocated'], 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Savings Snapshot -->
        <div class="col-lg-6">
            <div class="card stat-card-custom shadow-sm h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-pig-coin me-2" style="color: var(--adminuiux-theme-2);"></i>
                        Ringkasan Tabungan
                    </h6>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Total Target: Rp
                                {{ number_format($data['savings']['total_target'], 0, ',', '.') }}</small>
                            <small class="text-muted">Progres: {{ $data['savings']['progress_percent'] }}%</small>
                        </div>
                        <div class="progress-budget">
                            <div class="track"
                                style="width: {{ min(100, $data['savings']['progress_percent']) }}%; background: #28a745;">
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 text-center mb-2">
                        <div class="col-6">
                            <div class="fw-bold">{{ number_format($data['savings']['total_saved'], 0, ',', '.') }}</div>
                            <small class="text-muted">Tertabung</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold text-success">
                                {{ number_format($data['savings']['total_target'] - $data['savings']['total_saved'], 0, ',', '.') }}
                            </div>
                            <small class="text-muted">Tersisa</small>
                        </div>
                    </div>

                    @if($data['savings']['next_auto_contribution'])
                        <div class="alert alert-info d-flex align-items-center gap-2 py-2 mb-0 rounded"
                            style="background: rgba(23, 162, 184, 0.1);">
                            <i class="bi bi-automation"></i>
                            <div class="small">
                                <strong>Setoran otomatis berikutnya:</strong> Rp
                                {{ number_format($data['savings']['next_auto_contribution']['amount'], 0, ',', '.') }}
                                pada
                                {{ \Carbon\Carbon::parse($data['savings']['next_auto_contribution']['date'])->format('d M Y') }}
                                (Target: {{ $data['savings']['next_auto_contribution']['goal'] }})
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <small class="text-muted fw-semibold d-block mb-1">Target Tabungan:</small>
                        @foreach($data['savings']['goals'] as $goal)
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="small">{{ $goal['name'] }}</span>
                                <span
                                    class="small text-muted">{{ number_format($goal['saved'], 0, ',', '.') }}/{{ number_format($goal['target'], 0, ',', '.') }}</span>
                            </div>
                            <div class="progress-budget mb-2" style="height: 6px;">
                                <div class="track"
                                    style="width: {{ min(100, $goal['progress_percent']) }}%; background: {{ $goal['colour'] }};">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: Payments + Activity -->
    <div class="row g-4">
        <!-- Upcoming Payments -->
        <div class="col-lg-7 mb-5">
            <div class="card stat-card-custom shadow-sm h-100 ">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-calendar-check me-2"></i> Pembayaran Mendatang (30 hari)</span>
                        <a href="{{ route('budget.payment.index') }}" class="btn btn-sm btn-outline-secondary">Lihat
                            Semua</a>
                    </h6>

                    @if(empty($data['payments']['upcoming']))
                        <div class="text-center py-4">
                            <div class="empty-icon"><i class="bi bi-calendar-check"></i></div>
                            <p class="text-muted mb-0">Tidak ada pembayaran mendatang.</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($data['payments']['upcoming'] as $p)
                                <div class="d-flex align-items-center justify-content-between p-3 border rounded"
                                    style="border-radius: 12px;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="stat-icon-box bg-warning-subtle text-warning">
                                            <i class="bi bi-cash-coin"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $p['vendor'] }}</div>
                                            <small
                                                class="text-muted">{{ \Carbon\Carbon::parse($p['scheduled_date'])->format('d M Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">Rp {{ number_format($p['amount'], 0, ',', '.') }}</div>
                                        <span
                                            class="badge payment-badge bg-warning-subtle text-warning border border-warning-subtle">
                                            {{ ucfirst($p['status'] == 'scheduled' ? 'Terjadwal' : 'Terlambat') }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-5 mb-5">
            <div class="card stat-card-custom shadow-sm h-100 ">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-clock-history me-2"></i> Aktivitas Terbaru
                    </h6>

                    @if(empty($data['activity']))
                        <div class="text-center py-4">
                            <div class="empty-icon"><i class="bi bi-info-circle"></i></div>
                            <p class="text-muted mb-0">Belum ada aktivitas.</p>
                        </div>
                    @else
                        <div class="activity-feed">
                            @foreach($data['activity'] as $act)
                                <div class="activity-item d-flex align-items-center gap-3 py-2">
                                    <div
                                        class="stat-icon-box {{ $act['type'] == 'contribution' ? 'bg-success-subtle text-success' : 'bg-primary-subtle text-primary' }} flex-shrink-0">
                                        <i
                                            class="bi {{ $act['type'] == 'contribution' ? 'bi-plus-circle' : 'bi-receipt' }}"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="small">
                                            <span class="fw-semibold">{{ $act['user'] }}</span>
                                            {{ $act['type'] == 'contribution' ? 'menabung' : 'mencatat pengeluaran' }}
                                        </div>
                                        <small class="text-muted d-block">{{ $act['detail'] }}</small>
                                    </div>
                                    <div class="text-end">
                                        <div
                                            class="fw-bold {{ $act['type'] == 'contribution' ? 'text-success' : 'text-danger' }}">
                                            {{ $act['type'] == 'contribution' ? '+' : '-' }}Rp
                                            {{ number_format($act['amount'], 0, ',', '.') }}
                                        </div>
                                        <small class="text-muted">{{ $act['ago'] }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
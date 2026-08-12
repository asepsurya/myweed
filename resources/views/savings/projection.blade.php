<x-app-layout>
    <style>
        h4 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: var(--bs-body-color); }
        .stat-card-custom {
            background: #ffffff; border: 1px solid var(--bs-border-color); border-radius: 16px;
            transition: all 0.3s ease; height: 100%;
        }
        [data-bs-theme=dark] .stat-card-custom { background: none; }
        .stat-card-custom:hover {
            transform: translateY(-3px); box-shadow: 0 10px 25px rgba(27, 42, 74, 0.08);
            border-color: rgba(198, 169, 92, 0.4);
        }
        [data-bs-theme="dark"] .stat-card-custom:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4); border-color: var(--adminuiux-theme-1);
        }
        .stat-icon-box {
            width: 48px; height: 48px; border-radius: 12px; display: flex;
            align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;
        }
        .projection-card {
            background: #ffffff; border: 1px solid var(--bs-border-color);
            border-radius: 16px; overflow: hidden;
        }
        [data-bs-theme=dark] .projection-card { background: none; }
        .progress-thin { height: 8px; border-radius: 10px; overflow: hidden; }
        .empty-icon {
            width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color); display: flex; align-items: center;
            justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;
        }
        .on-track { color: #1cc88a; }
        .off-track { color: #dc3545; }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Proyeksi Tabungan</h4>
            <p class="text-muted mb-0">Estimasi tabungan harian yang dibutuhkan untuk mencapai target</p>
        </div>
        <a href="{{ route('savings.dashboard') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if($projections->isEmpty())
    <div class="text-center py-5">
        <div class="empty-icon"><i class="bi bi-emoji-frown"></i></div>
        <p class="text-muted mb-0">Tidak ada target tabungan aktif.</p>
    </div>
    @else
    <div class="row g-3 mb-4">
        @php
            $totalRemaining = $projections->sum('remaining');
            $totalDays = $projections->max('days_left');
            $avgDaily = $totalDays > 0 ? $totalRemaining / $totalDays : 0;
        @endphp
        <div class="col-6 col-md-4">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon-box bg-success-subtle text-success mx-auto"><i class="bi bi-currency-exchange"></i></div>
                    <div class="fw-bold fs-5 mt-2">{{ number_format($totalRemaining, 0, ',', '.') }}</div>
                    <div class="text-muted small">Total Tersisa</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon-box bg-primary-subtle text-primary mx-auto"><i class="bi bi-calculator"></i></div>
                    <div class="fw-bold fs-5 mt-2">Rp {{ number_format($avgDaily, 0, ',', '.') }}</div>
                    <div class="text-muted small">Rata-rata/Hari (simulasi)</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body text-center">
                    <div class="stat-icon-box bg-info-subtle text-info mx-auto"><i class="bi bi-graph-up-arrow"></i></div>
                    <div class="fw-bold fs-5 mt-2">{{ $projections->filter(fn ($p) => $p['is_on_track'])->count() }}/{{ $projections->count() }}</div>
                    <div class="text-muted small">Target On Track</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach($projections as $proj)
        <div class="col-12 col-lg-6">
            <div class="card projection-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h6 class="fw-bold mb-0">{{ $proj['goal']->name }}</h6>
                        @if($proj['is_on_track'])
                            <span class="badge bg-success-subtle text-success border border-success-subtle on-track">
                                <i class="bi bi-check-circle me-1"></i>On Track
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle off-track">
                                <i class="bi bi-exclamation-circle me-1"></i>Needs Attention
                            </span>
                        @endif
                    </div>

                    <div class="progress-thin mb-3">
                        <div class="progress-bar" style="width: {{ min(100, $proj['goal']->progressPercent()) }}%; background: {{ $proj['goal']->colour }};"></div>
                    </div>

                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div class="fw-bold">{{ number_format($proj['target'] ?? $proj['goal']->target_amount, 0, ',', '.') }}</div>
                            <small class="text-muted">Target</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold">{{ number_format($proj['saved'], 0, ',', '.') }}</div>
                            <small class="text-muted">Terkumpul</small>
                        </div>
                        <div class="col-4">
                            <div class="fw-bold">{{ number_format($proj['remaining'], 0, ',', '.') }}</div>
                            <small class="text-muted">Tersisa</small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Hari tersisa</small>
                            <div class="fw-bold">{{ $proj['days_left'] }} hari</div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">Butuh per hari</small>
                            <div class="fw-bold">Rp {{ number_format($proj['daily_required'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</x-app-layout>

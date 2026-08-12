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
        .goal-card {
            background: #ffffff; border: 1px solid var(--bs-border-color);
            border-radius: 16px; transition: all 0.3s ease; height: 100%; cursor: pointer;
        }
        [data-bs-theme=dark] .goal-card { background: none; }
        .goal-card:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(27, 42, 74, 0.08); }
        .progress-ring { height: 10px; border-radius: 10px; overflow: hidden; background: var(--bs-tertiary-bg); }
        .progress-ring .fill { height: 100%; border-radius: 10px; transition: width 0.5s ease; }
        .empty-icon {
            width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color); display: flex; align-items: center;
            justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;
        }
        .fab-btn {
            position: fixed; bottom: 30px; right: 30px; width: 56px; height: 56px;
            border-radius: 50%; box-shadow: 0 4px 15px rgba(198, 169, 92, 0.4);
            z-index: 1040; display: flex; align-items: center; justify-content: center;
        }
        @media (max-width: 576px) { .fab-btn { bottom: 20px; right: 20px; width: 50px; height: 50px; } }
        .contrib-badge {
            position: absolute; top: 8px; right: 8px; font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Tabungan NIKAH</h4>
            <p class="text-muted mb-0">Kelola target tabungan dan kontribusi bersama pasangan</p>
        </div>
        <a href="{{ route('savings.goal.index') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
            <i class="bi bi-list-ul me-1"></i> Lihat Semua Target
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-pig-coin"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($totalSaved, 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Tertabung</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-target"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($totalTarget, 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Target</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-info-subtle text-info"><i class="bi bi-graph-up-arrow"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $overallProgress }}%</div>
                        <div class="text-muted small">Progres Keseluruhan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-automation"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $nextAuto ? 'Rp ' . number_format($nextAuto['amount'], 0, ',', '.') : '-' }}</div>
                        <div class="text-muted small">
                            @if($nextAuto)
                                Next: {{ \Carbon\Carbon::parse($nextAuto['date'])->format('d M Y') }}
                            @else
                                Tidak ada otomatis
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Goal Cards -->
    <h5 class="fw-bold mb-3">Target Tabungan</h5>
    <div class="row g-3 mb-4">
        @forelse($goals as $goal)
        @php $progress = $goal->progressPercent(); @endphp
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card goal-card shadow-sm position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0">{{ $goal->name }}</h6>
                        <span class="badge" style="background-color: {{ $goal->colour }}; color: #fff; border: none;">
                            {{ $goal->currency == 'IDR' ? 'Rp ' : $goal->currency . ' ' }}{{ number_format($goal->target_amount, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($goal->deadline)
                        <small class="text-muted mb-2 d-block">
                            <i class="bi bi-calendar me-1"></i>Deadline: {{ $goal->deadline->format('d M Y') }}
                            @if($goal->daysRemaining() < 0)
                                <span class="text-danger">(Lewat {{ abs($goal->daysRemaining()) }} hari)</span>
                            @endif
                        </small>
                    @endif

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">{{ number_format($goal->totalSaved(), 0, ',', '.') }} terkumpul</small>
                            <small class="fw-bold">{{ $progress }}%</small>
                        </div>
                        <div class="progress-ring">
                            <div class="fill" style="width: {{ min(100, $progress) }}%; background: {{ $goal->colour }};"></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            @if($goal->dailyRequired() > 0)
                                Butuh Rp {{ number_format($goal->dailyRequired(), 0, ',', '.') }}/hari
                            @else
                                🎉 Tercapai!
                            @endif
                        </small>
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-sm btn-outline-success rounded-circle p-1"
                                title="Tambah Setoran" data-bs-toggle="modal"
                                data-bs-target="#contributeModal"
                                data-goal-id="{{ $goal->id }}"
                                data-goal-name="{{ $goal->name }}">
                                <i class="bi bi-plus"></i>
                            </button>
                            <a href="{{ route('savings.goal.edit', $goal) }}" class="btn btn-sm btn-outline-secondary rounded-circle p-1" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
                </div>

                @if($contributors->count() > 1)
                <span class="contrib-badge bg-light text-dark border rounded">
                    <i class="bi bi-people me-1"></i>{{ $contributors->count() }} mitra
                </span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-icon"><i class="bi bi-pig"></i></div>
            <p class="text-muted mb-0">Belum ada target tabungan.<br>Klik di bawah untuk membuat target pertama.</p>
        </div>
        @endforelse
    </div>

    <!-- Quick Links -->
    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('savings.contribution.index') }}" class="text-decoration-none">
                <div class="card stat-card-custom shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon-box bg-primary-subtle text-primary mx-auto"><i class="bi bi-journal-text"></i></div>
                        <h6 class="fw-bold mt-2 mb-0">Ledger Setoran</h6>
                        <small class="text-muted">Riwayat semua kontribusi</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('savings.projection') }}" class="text-decoration-none">
                <div class="card stat-card-custom shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon-box bg-info-subtle text-info mx-auto"><i class="bi bi-calculator"></i></div>
                        <h6 class="fw-bold mt-2 mb-0">Proyeksi</h6>
                        <small class="text-muted">Hitung tabungan harian</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('savings.automation.index') }}" class="text-decoration-none">
                <div class="card stat-card-custom shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon-box bg-warning-subtle text-warning mx-auto"><i class="bi bi-automation"></i></div>
                        <h6 class="fw-bold mt-2 mb-0">Automasi</h6>
                        <small class="text-muted">Atur tabungan rutin</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Floating Action Button -->
    <button type="button" class="btn btn-gold-custom fab-btn" data-bs-toggle="modal" data-bs-target="#contributeModal">
        <i class="bi bi-plus-lg"></i>
    </button>

    <!-- Contribution Modal -->
    <div class="modal fade" id="contributeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <form method="POST" action="{{ route('savings.contribution.store') }}">
                    @csrf
                    <input type="hidden" name="goal_id_for_select" id="goal_id_for_select">
                    <div class="modal-header" style="background-color: #F7F5F2;">
                        <h5 class="modal-title fw-bold mb-0"><i class="bi bi-pig-coin me-2"></i> Tambah Setoran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="savings_goal_id" class="form-label">Target *</label>
                            <select name="savings_goal_id" id="savings_goal_id" class="form-select" required>
                                <option value="">Pilih Target</option>
                                @foreach($goals as $g)
                                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="contributor_id" class="form-label">Dari *</label>
                            <select name="contributor_id" id="contributor_id" class="form-select" required>
                                @foreach($contributors as $c)
                                    <option value="{{ $c->id }}" {{ $c->id == $user->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah *</label>
                            <input type="number" name="amount" id="amount" class="form-control" required min="1" step="1000" placeholder="0">
                        </div>
                        <div class="mb-3">
                            <label for="method" class="form-label">Metode</label>
                            <select name="method" id="method" class="form-select">
                                <option value="transfer">Transfer</option>
                                <option value="e-wallet">E-Wallet</option>
                                <option value="cash">Tunai</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-gold-custom">Simpan Setoran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('contributeModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const goalId = button.getAttribute('data-goal-id');
            const goalName = button.getAttribute('data-goal-name');

            const goalSelect = document.getElementById('savings_goal_id');
            if (goalId && goalSelect) {
                goalSelect.value = goalId;
            }
            document.getElementById('goal_id_for_select').value = goalId || '';
        });
    </script>
</x-app-layout>

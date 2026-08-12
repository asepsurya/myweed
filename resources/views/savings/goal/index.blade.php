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
        .filter-pill {
            border-radius: 50px; padding: 0.5rem 1rem;
            border: 1px solid var(--bs-border-color); background: var(--bs-body-bg);
            color: var(--bs-body-color); font-size: 0.875rem;
        }
        .input-group-pill {
            border-radius: 50px; background: var(--bs-body-bg); border: 1px solid var(--bs-border-color);
        }
        .input-group-pill .form-control { border: none; background: transparent; color: var(--bs-body-color); }
        .input-group-pill .form-control:focus { box-shadow: none; }
        .input-group-pill .input-group-text { border: none; background: transparent; color: var(--bs-secondary-color); }
        .table-custom thead th {
            background-color: rgba(27, 42, 74, 0.03); color: var(--bs-secondary-color);
            font-weight: 600; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;
            border-bottom: 2px solid var(--bs-border-color); padding: 1rem 1.25rem; white-space: nowrap;
        }
        [data-bs-theme="dark"] .table-custom thead th { background-color: rgba(255, 255, 255, 0.03); }
        .table-custom tbody td { padding: 1rem 1.25rem; vertical-align: middle; border-color: var(--bs-border-color); }
        .table-custom tbody tr:hover { background-color: rgba(198, 169, 92, 0.05); }
        .progress-budget { height: 8px; border-radius: 10px; overflow: hidden; background: var(--bs-tertiary-bg); }
        .empty-icon {
            width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color); display: flex; align-items: center;
            justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;
        }
        .goal-card-grid {
            .card { border-radius: 16px; }
        }
        .btn-gold-custom {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover));
            border: none; color: var(--adminuiux-theme-1-text);
            padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;
        }
        .btn-gold-custom:hover {
            transform: translateY(-1px); box-shadow: 0 6px 16px rgba(198, 169, 92, 0.3);
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Target Tabungan</h4>
            <p class="text-muted mb-0">Kelola semua target tabungan untuk pernikahan Anda</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('savings.dashboard') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('savings.goal.create') }}" class="btn btn-gold-custom flex-grow-1 flex-md-grow-0">
                <i class="bi bi-plus-lg me-1"></i> Tambah Target
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-target"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $goals->count() }}</div>
                        <div class="text-muted small">Total Target</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-pig-coin"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($goals->sum('contributions_sum_amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Tertabung</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-graph-up-arrow"></i></div>
                    <div>
                        <div class="fw-bold fs-5">
                            @php
                                $target = $goals->sum('target_amount');
                                $saved = $goals->sum('contributions_sum_amount');
                                echo $target > 0 ? round(($saved / $target) * 100, 1) : 0;
                            @endphp%
                        </div>
                        <div class="text-muted small">Progres</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-danger-subtle text-danger"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="fw-bold fs-5">
                            @php
                                $overdue = 0;
                                foreach($goals as $g) {
                                    if ($g->deadline && $g->deadline->isPast() && $g->progressPercent() < 100) {
                                        $overdue++;
                                    }
                                }
                                echo $overdue;
                            @endphp
                        </div>
                        <div class="text-muted small">Lewat Deadline</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Goal List Table -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <div class="input-group input-group-pill flex-grow-1 flex-md-grow-0" style="max-width: 320px;">
                    <span class="input-group-text border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchGoal" class="form-control border-0 ps-0" placeholder="Cari target..." value="{{ request('search') }}">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Target</th>
                        <th>Target Jumlah</th>
                        <th class="d-none d-sm-table-cell">Terkumpul</th>
                        <th class="d-none d-sm-table-cell">Deadline</th>
                        <th class="d-none d-md-table-cell">Auto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($goals as $goal)
                    @php $progress = $goal->progressPercent(); @endphp
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-circle" style="background: {{ $goal->colour }}; width: 24px; height: 24px;"></span>
                                <div>
                                    <div class="fw-semibold">{{ $goal->name }}</div>
                                    @if($goal->contributions_count > 0)
                                        <small class="text-muted d-block">{{ $goal->contributions_count }} setoran</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ number_format($goal->target_amount, 0, ',', '.') }}</td>
                        <td class="d-none d-sm-table-cell">{{ number_format($goal->contributions_sum_amount ?? 0, 0, ',', '.') }}</td>
                        <td class="d-none d-sm-table-cell">
                            @if($goal->deadline)
                                <span class="{{ $goal->deadline->isPast() && $progress < 100 ? 'text-danger fw-bold' : 'text-muted' }}">
                                    {{ $goal->deadline->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">
                            @if($goal->auto_savings_rule)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-automation me-1"></i>Aktif
                                </span>
                            @else
                                <span class="text-muted small">Non-aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2 justify-content-end">
                                <span class="badge bg-light text-dark">{{ $progress }}%</span>
                                <div class="progress" style="height: 6px; width: 60px;">
                                    <div class="progress-bar" style="width: {{ min(100, $progress) }}%; background: {{ $goal->colour }};"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-1">
                                <form action="{{ route('savings.goal.toggle', $goal) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-sm {{ $goal->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-circle p-1"
                                        title="{{ $goal->is_active ? 'Non-aktifkan' : 'Aktifkan' }}">
                                        <i class="bi {{ $goal->is_active ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                                    </button>
                                </form>
                                <a href="{{ route('savings.goal.edit', $goal) }}" class="btn btn-sm btn-outline-secondary rounded-circle p-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1"
                                    onclick="confirmDeleteGoal({{ $goal->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-goal-form-{{ $goal->id }}" action="{{ route('savings.goal.destroy', $goal) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-icon"><i class="bi bi-pig-coin"></i></div>
                            <p class="text-muted mb-0">Belum ada target tabungan.<br>Klik "Tambah Target" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDeleteGoal(id) {
            Swal.fire({
                title: 'Hapus target ini?',
                text: "Target dan semua setorannya tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-goal-form-' + id).submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchGoal');
            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function () {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('search');
                    if (searchInput.value) url.searchParams.set('search', searchInput.value);
                    window.location.href = url.toString();
                }, 500);
            });
        });
    </script>
</x-app-layout>

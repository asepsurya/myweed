<x-app-layout>
    <style>
        h4 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: var(--bs-body-color); }
        .stat-card-custom {
            background: #ffffff; border: 1px solid var(--bs-border-color); border-radius: 16px;
            transition: all 0.3s ease; height: 100%;
        }
        [data-bs-theme=dark] .stat-card-custom { background: none; }
        .stat-icon-box {
            width: 48px; height: 48px; border-radius: 12px; display: flex;
            align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0;
        }
        .auto-rule-card {
            border: 1px solid var(--bs-border-color); border-radius: 16px; overflow: hidden;
            background: #ffffff; transition: all 0.2s ease;
        }
        [data-bs-theme=dark] .auto-rule-card { background: none; }
        .auto-rule-card:hover { box-shadow: 0 4px 15px rgba(27, 42, 74, 0.05); }
        .form-label { font-size: 0.875rem; color: var(--bs-secondary-color); font-weight: 600; margin-bottom: 0.5rem; }
        .form-control, .form-select {
            border-radius: 10px; padding: 0.75rem 1rem;
            background-color: var(--bs-body-bg); border-color: var(--bs-border-color); color: var(--bs-body-color);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--adminuiux-theme-1); box-shadow: 0 0 0 0.2rem rgba(198, 169, 92, 0.2);
        }
        .btn-gold-custom {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover));
            border: none; color: var(--adminuiux-theme-1-text);
            padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;
        }
        .btn-gold-custom:hover {
            transform: translateY(-1px); box-shadow: 0 6px 16px rgba(198, 169, 92, 0.3);
        }
        .toggle-switch {
            position: relative; display: inline-block; width: 50px; height: 26px;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc; border-radius: 26px; transition: .3s;
        }
        .toggle-slider:before {
            position: absolute; content: ""; height: 20px; width: 20px;
            left: 3px; bottom: 3px; background-color: white; border-radius: 50%; transition: .3s;
        }
        .toggle-switch input:checked + .toggle-slider { background-color: var(--adminuiux-theme-1); }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(24px); }
        .empty-icon {
            width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color); display: flex; align-items: center;
            justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;
        }
        .badge-saved { background: rgba(28, 200, 138, 0.15); color: #1cc88a; }
        .badge-pending { background: rgba(255, 193, 7, 0.15); color: #ffc107; }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Automasi Tabungan</h4>
            <p class="text-muted mb-0">Atur setoran otomatis untuk tiap target tabungan</p>
        </div>
        <a href="{{ route('savings.dashboard') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-target"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $goals->count() }}</div>
                        <div class="text-muted small">Target Aktif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-automation"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ collect($goals)->filter(fn ($g) => $g['has_rule'])->count() }}</div>
                        <div class="text-muted small">Aturan Aktif</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-currency-exchange"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format(collect($goals)->sum(fn ($g) => $g['rule']['amount'] ?? 0), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total/Round</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @forelse($goals as $goal)
        <div class="col-12 col-lg-6">
            <div class="card auto-rule-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $goal['name'] }}</h6>
                            <small class="text-muted">Deadline: {{ \Carbon\Carbon::parse($goal['deadline'])->format('d M Y') }}</small>
                        </div>
                        <span class="badge badge-saved">{{ $goal['progress_percent'] }}%</span>
                    </div>

                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar" style="width: {{ min(100, $goal['progress_percent']) }}%; background: {{ $goal['colour'] ?? '#C6A962' }};"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <small class="text-muted">Setoran: {{ number_format($goal['saved'], 0, ',', '.') }} / {{ number_format($goal['target_amount'], 0, ',', '.') }}</small>
                        @if($goal['next_run'])
                            <small class="text-info">
                                <i class="bi bi-clock me-1"></i>Next: {{ \Carbon\Carbon::parse($goal['next_run'])->format('d M Y') }}
                            </small>
                        @endif
                    </div>

                    <form action="{{ route('savings.automation.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="goal_id" value="{{ $goal['id'] }}">

                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <label class="form-label mb-0">Aktifkan Otomatis</label>
                            <label class="toggle-switch">
                                <input type="checkbox" name="enabled" value="1"
                                    {{ $goal['has_rule'] ? 'checked' : '' }}
                                    onchange="toggleRuleForm(this, {{ $goal['id'] }})">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div id="ruleForm-{{ $goal['id'] }}" class="{{ $goal['has_rule'] ? '' : 'd-none' }}">
                            <div class="mb-3">
                                <label class="form-label">Frekuensi</label>
                                <select name="frequency" class="form-select form-select-sm">
                                    <option value="daily" {{ ($goal['rule']['frequency'] ?? '') == 'daily' ? 'selected' : '' }}>Harian</option>
                                    <option value="weekly" {{ ($goal['rule']['frequency'] ?? '') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                    <option value="monthly" {{ ($goal['rule']['frequency'] ?? '') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                    <option value="custom" {{ ($goal['rule']['frequency'] ?? '') == 'custom' ? 'selected' : '' }}>Kustom</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Jumlah per Setoran</label>
                                <input type="number" name="amount" class="form-control form-control-sm" min="1"
                                    value="{{ $goal['rule']['amount'] ?? '' }}" placeholder="0">
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Interval (hari) - kustom</label>
                                <input type="number" name="interval_days" class="form-control form-control-sm" min="1"
                                    value="{{ $goal['rule']['interval_days'] ?? 7 }}" placeholder="7">
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-gold-custom btn-sm flex-grow-1">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            @if($goal['has_rule'])
                                <button type="submit" name="action" value="disable"
                                    class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-icon"><i class="bi bi-pig"></i></div>
            <p class="text-muted mb-0">Belum ada target tabungan aktif.</p>
        </div>
        @endforelse
    </div>

    <script>
        function toggleRuleForm(checkbox, goalId) {
            const form = document.getElementById('ruleForm-' + goalId);
            if (form) {
                form.classList.toggle('d-none', !checkbox.checked);
            }
        }
    </script>
</x-app-layout>

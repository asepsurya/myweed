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
        .empty-icon {
            width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color); display: flex; align-items: center;
            justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Ledger Setoran</h4>
            <p class="text-muted mb-0">Riwayat semua kontribusi tabungan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('savings.dashboard') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="button" class="btn btn-gold-custom flex-grow-1 flex-md-grow-0"
                data-bs-toggle="modal" data-bs-target="#contributeModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Setoran
            </button>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-currency-exchange"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($contributions->where('is_automatic', false)->sum('amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Manual</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-info-subtle text-info"><i class="bi bi-automation"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($contributions->where('is_automatic', true)->sum('amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Otomatis</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $contributors->count() }}</div>
                        <div class="text-muted small">Kontributor</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-list-ul"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $contributions->count() }}</div>
                        <div class="text-muted small">Total Setoran</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <div class="input-group input-group-pill flex-grow-1 flex-md-grow-0" style="max-width: 320px;">
                    <span class="input-group-text border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchContrib" class="form-control border-0 ps-0" placeholder="Cari setoran..." value="{{ request('search') }}">
                </div>
                <div class="d-flex gap-2">
                    <select id="goalFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Target</option>
                        @foreach($goals as $id => $name)
                            <option value="{{ $id }}" {{ request('goal_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select id="contributorFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Kontributor</option>
                        @foreach($contributors as $c)
                            <option value="{{ $c->id }}" {{ request('contributor_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>Target</th>
                        <th>Kontributor</th>
                        <th>Metode</th>
                        <th class="text-end">Jumlah</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contributions as $contribution)
                    <tr>
                        <td class="ps-4">{{ \Carbon\Carbon::parse($contribution->contributed_at)->format('d M Y') }}</td>
                        <td>{{ $contribution->goal?->name ?? '-' }}</td>
                        <td>
                            @if($contribution->contributor)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar avatar-sm bg-primary-subtle text-primary rounded-circle"
                                         style="width: 32px; height: 32px; font-size: 0.75rem;">
                                        {{ strtoupper(substr($contribution->contributor->name ?? '?', 0, 1)) }}
                                    </div>
                                    {{ $contribution->contributor->name }}
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $contribution->method_name }}</td>
                        <td class="text-end fw-bold">{{ number_format($contribution->amount, 0, ',', '.') }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('savings.contribution.edit', $contribution) }}" class="btn btn-sm btn-outline-secondary rounded-circle p-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($contribution->is_automatic)
                                    <span class="text-muted small" title="Setoran otomatis"><i class="bi bi-automation"></i></span>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1"
                                    onclick="confirmDeleteContrib({{ $contribution->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-contrib-form-{{ $contribution->id }}" action="{{ route('savings.contribution.destroy', $contribution) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-icon"><i class="bi bi-pig"></i></div>
                            <p class="text-muted mb-0">Belum ada setoran.<br>Klik "Tambah Setoran" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($contributions->hasPages())
    <div class="card-footer bg-transparent border-0 py-3">
        {{ $contributions->links() }}
    </div>
    @endif

    <!-- Add Contribution Modal -->
    <div class="modal fade" id="contributeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <form method="POST" action="{{ route('savings.contribution.store') }}">
                    @csrf
                    <div class="modal-header" style="background-color: #F7F5F2;">
                        <h5 class="modal-title fw-bold mb-0"><i class="bi bi-plus-circle me-2"></i> Tambah Setoran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="savings_goal_id" class="form-label">Target *</label>
                            <select name="savings_goal_id" id="savings_goal_id" class="form-select" required>
                                <option value="">Pilih Target</option>
                                @foreach($goals as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="contributor_id" class="form-label">Dari *</label>
                            <select name="contributor_id" id="contributor_id" class="form-select" required>
                                @foreach($contributors as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
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
                                <option value="card">Kartu</option>
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
        function confirmDeleteContrib(id) {
            Swal.fire({
                title: 'Hapus setoran ini?',
                text: "Data setoran yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-contrib-form-' + id).submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchContrib');
            const goalFilter = document.getElementById('goalFilter');
            const contributorFilter = document.getElementById('contributorFilter');

            function applyFilters() {
                const url = new URL(window.location.href);
                url.searchParams.delete('search');
                url.searchParams.delete('goal_id');
                url.searchParams.delete('contributor_id');
                if (searchInput.value) url.searchParams.set('search', searchInput.value);
                if (goalFilter.value) url.searchParams.set('goal_id', goalFilter.value);
                if (contributorFilter.value) url.searchParams.set('contributor_id', contributorFilter.value);
                window.location.href = url.toString();
            }

            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });
            goalFilter.addEventListener('change', applyFilters);
            contributorFilter.addEventListener('change', applyFilters);
        });
    </script>
</x-app-layout>

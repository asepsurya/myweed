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
        .empty-icon {
            width: 60px; height: 60px; border-radius: 50%; background: var(--bs-tertiary-bg);
            color: var(--bs-secondary-color); display: flex; align-items: center;
            justify-content: center; font-size: 1.5rem; margin: 0 auto 1rem;
        }
        .receipt-thumb { width: 48px; height: 48px; object-fit: cover; border-radius: 8px; }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Daftar Pengeluaran</h4>
            <p class="text-muted mb-0">Catat dan kelola semua pengeluaran anggaran pernikahan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('budget.dashboard') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('budget.expense.create') }}" class="btn btn-primary flex-grow-1 flex-md-grow-0 text-white">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pengeluaran
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-receipt-cutoff"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($expenses->sum('amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Pengeluaran</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-hourglass-top"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($expenses->where('is_paid', false)->sum('amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Belum Dibayar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-cash-coin"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($expenses->where('is_paid', true)->sum('amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Sudah Dibayar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-info-subtle text-info"><i class="bi bi-list-ul"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $expenses->count() }}</div>
                        <div class="text-muted small">Total Transaksi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <div class="input-group input-group-pill flex-grow-1 flex-md-grow-0" style="max-width: 320px;">
                    <span class="input-group-text border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchExpense" class="form-control border-0 ps-0" placeholder="Cari pengeluaran..." value="{{ request('search') }}">
                </div>
                <div class="d-flex gap-2">
                    <select id="categoryFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ request('category') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select id="methodFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Metode</option>
                        <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ request('method') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="e-wallet" {{ request('method') == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="credit" {{ request('method') == 'credit' ? 'selected' : '' }}>Kartu Kredit</option>
                        <option value="card" {{ request('method') == 'card' ? 'selected' : '' }}>Kartu Debit</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Vendor</th>
                        <th>Kategori</th>
                        <th class="d-none d-sm-table-cell">Tanggal</th>
                        <th class="d-none d-sm-table-cell">Metode</th>
                        <th class="text-nowrap">Jumlah</th>
                        <th class="d-none d-md-table-cell">Bukti</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr class="{{ $expense->is_paid ? '' : 'table-warning bg-transparent' }}">
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $expense->vendor_name }}</div>
                            @if($expense->description)
                                <small class="text-muted d-block text-truncate" style="max-width: 200px;" title="{{ $expense->description }}">
                                    {{ $expense->description }}
                                </small>
                            @endif
                        </td>
                        <td>
                            @if($expense->category)
                                <span class="badge bg-light text-dark border" style="border-color: {{ $expense->category->colour }}20;">
                                    {{ $expense->category->name }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $expense->payment_method_name }}
                        </td>
                        <td class="text-nowrap fw-bold">{{ number_format($expense->amount, 0, ',', '.') }}</td>
                        <td class="d-none d-md-table-cell">
                            @if($expense->receipt_path)
                                <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $expense->receipt_path) }}" class="receipt-thumb" alt="Bukti">
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <form action="{{ route('budget.expense.update', $expense) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <button type="submit"
                                        class="btn btn-sm {{ $expense->is_paid ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-circle p-2"
                                        title="{{ $expense->is_paid ? 'Tandai belum dibayar' : 'Tandai sudah dibayar' }}">
                                        <i class="bi {{ $expense->is_paid ? 'bi-check-square' : 'bi-square' }}"></i>
                                    </button>
                                </form>
                                <a href="{{ route('budget.expense.edit', $expense) }}"
                                   class="btn btn-sm btn-outline-secondary rounded-circle p-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                    onclick="confirmDeleteExp({{ $expense->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-exp-form-{{ $expense->id }}" action="{{ route('budget.expense.destroy', $expense) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="empty-icon"><i class="bi bi-receipt"></i></div>
                            <p class="text-muted mb-0">Belum ada pengeluaran.<br>Klik "Tambah Pengeluaran" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($expenses->hasPages())
    <div class="card-footer bg-transparent border-0 py-3">
        {{ $expenses->links() }}
    </div>
    @endif

    <script>
        function confirmDeleteExp(id) {
            Swal.fire({
                title: 'Hapus pengeluaran ini?',
                text: "Data pengeluaran yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-exp-form-' + id).submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchExpense');
            const categoryFilter = document.getElementById('categoryFilter');
            const methodFilter = document.getElementById('methodFilter');

            function applyFilters() {
                const url = new URL(window.location.href);
                url.searchParams.delete('search');
                url.searchParams.delete('category');
                url.searchParams.delete('method');
                if (searchInput.value) url.searchParams.set('search', searchInput.value);
                if (categoryFilter.value) url.searchParams.set('category', categoryFilter.value);
                if (methodFilter.value) url.searchParams.set('method', methodFilter.value);
                window.location.href = url.toString();
            }

            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });
            categoryFilter.addEventListener('change', applyFilters);
            methodFilter.addEventListener('change', applyFilters);
        });
    </script>
</x-app-layout>

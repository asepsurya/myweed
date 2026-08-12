<x-app-layout>
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

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            background-color: var(--bs-body-bg);
            border-color: var(--bs-border-color);
            color: var(--bs-body-color);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--adminuiux-theme-1);
            box-shadow: 0 0 0 0.2rem rgba(198, 169, 92, 0.2);
        }

        .form-label {
            font-size: 0.875rem;
            color: var(--bs-secondary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn-gold-custom {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover));
            border: none;
            color: var(--adminuiux-theme-1-text);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gold-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(198, 169, 92, 0.3);
        }

        .btn-outline-custom {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-color: var(--bs-border-color);
            color: var(--bs-secondary-color);
        }

        .table-custom thead th {
            background-color: rgba(27, 42, 74, 0.03);
            color: var(--bs-secondary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--bs-border-color);
            padding: 1rem 1.25rem;
            white-space: nowrap;
        }

        [data-bs-theme="dark"] .table-custom thead th {
            background-color: rgba(255, 255, 255, 0.03);
        }

        .table-custom tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-color: var(--bs-border-color);
        }

        .table-custom tbody tr:hover {
            background-color: rgba(198, 169, 92, 0.05);
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

        .input-group-pill {
            border-radius: 50px;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
        }

        .input-group-pill .form-control {
            border: none;
            background: transparent;
            color: var(--bs-body-color);
        }

        .input-group-pill .form-control:focus {
            box-shadow: none;
        }

        .input-group-pill .input-group-text {
            border: none;
            background: transparent;
            color: var(--bs-secondary-color);
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Kategori Anggaran</h4>
            <p class="text-muted mb-0">Alokasikan anggaran per kategori untuk memantau pengeluaran</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('budget.dashboard') }}" class="btn btn-outline-custom">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="button" class="btn btn-gold-custom" data-bs-toggle="modal" data-bs-target="#categoryModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-tag-fill"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $categories->count() }}</div>
                        <div class="text-muted small">Total Kategori</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-receipt-cutoff"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($categories->sum('expenses_sum_amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Terpakai</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-lock"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($categories->sum('allocated_amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Dialokasikan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-info-subtle text-info"><i class="bi bi-graph-up-arrow"></i></div>
                    <div>
                        <div class="fw-bold fs-5">
                            @php
                                $alloc = $categories->sum('allocated_amount');
                                $spent = $categories->sum('expenses_sum_amount');
                                echo $alloc > 0 ? round(($spent / $alloc) * 100, 1) : 0;
                            @endphp%
                        </div>
                        <div class="text-muted small">Penggunaan Rata-rata</div>
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
                    <input type="text" id="searchCategory" class="form-control border-0 ps-0" placeholder="Cari kategori..." value="{{ request('search') }}">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Kategori</th>
                        <th>Dialokasikan</th>
                        <th class="d-none d-sm-table-cell">Terpakai</th>
                        <th class="d-none d-sm-table-cell">Tersisa</th>
                        <th class="d-none d-md-table-cell">% Terpakai</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="ps-4">
                            <span class="badge" style="background-color: {{ $category->colour }}; color: #fff; border: none;">
                                {{ $category->name }}
                            </span>
                        </td>
                        <td>{{ number_format($category->allocated_amount, 0, ',', '.') }}</td>
                        <td class="d-none d-sm-table-cell {{ ($category->expenses_sum_amount ?? 0) > $category->allocated_amount ? 'text-danger fw-bold' : 'text-muted' }}">
                            {{ number_format($category->expenses_sum_amount ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            @php $remaining = ($category->allocated_amount ?? 0) - ($category->expenses_sum_amount ?? 0); @endphp
                            <span class="{{ $remaining < 0 ? 'text-danger fw-bold' : 'text-muted' }}">
                                {{ $remaining >= 0 ? number_format($remaining, 0, ',', '.') : 'Lebih ' . number_format(abs($remaining), 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="d-none d-md-table-cell">
                            @php $pct = ($category->allocated_amount ?? 0) > 0 ? round((($category->expenses_sum_amount ?? 0) / $category->allocated_amount) * 100, 1) : 0; @endphp
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress" style="height: 8px; width: 80px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ min(100, $pct) }}%; background: {{ $category->colour }};"></div>
                                </div>
                                <span class="small">{{ $pct }}%</span>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('budget.category.edit', $category) }}"
                                   class="btn btn-sm btn-outline-secondary rounded-circle p-2" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                    onclick="confirmDeleteCat({{ $category->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-cat-form-{{ $category->id }}" action="{{ route('budget.category.destroy', $category) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-icon">
                                <i class="bi bi-tag"></i>
                            </div>
                            <p class="text-muted mb-0">Belum ada kategori anggaran.<br>Klik "Tambah Kategori" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <form id="categoryForm" method="POST" action="{{ route('budget.category.store') }}">
                    @csrf
                    <div class="modal-header" style="background-color: #F7F5F2;">
                        <h5 class="modal-title fw-bold mb-0"><i class="bi bi-tag-fill me-2"></i> Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori *</label>
                            <input type="text" name="name" id="name" class="form-control" required placeholder="Contoh: Catering">
                        </div>
                        <div class="mb-3">
                            <label for="colour" class="form-label">Warna Label</label>
                            <input type="color" name="colour" id="colour" class="form-control form-control-color" value="#C6A962" style="width: 60px; height: 40px;">
                        </div>
                        <div class="mb-3">
                            <label for="allocated_amount" class="form-label">Jumlah Dialokasikan *</label>
                            <input type="number" name="allocated_amount" id="allocated_amount" class="form-control" required min="0" value="0">
                        </div>
                        <div class="mb-0">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea name="note" id="note" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-gold-custom">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteCat(id) {
            Swal.fire({
                title: 'Hapus kategori ini?',
                text: "Data kategori dan penggunaannya tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-cat-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

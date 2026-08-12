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
        .payment-row { border-left: 3px solid var(--adminuiux-theme-1); }
        .payment-row.overdue { border-left-color: #dc3545; }
        .payment-row.paid { border-left-color: #1cc88a; }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Jadwal Pembayaran Vendor</h4>
            <p class="text-muted mb-0">Kelola jadwal pembayaran ke vendor dengan status real-time</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('budget.dashboard') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button type="button" class="btn btn-primary flex-grow-1 flex-md-grow-0 text-white" data-bs-toggle="modal" data-bs-target="#paymentModal">
                <i class="bi bi-plus-lg me-1"></i> Jadwalkan Pembayaran
            </button>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $payments->where('status', 'scheduled')->count() }}</div>
                        <div class="text-muted small">Terjadwal</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $payments->where('status', 'paid')->count() }}</div>
                        <div class="text-muted small">Lunas</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-danger-subtle text-danger"><i class="bi bi-exclamation-triangle"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $payments->where('status', 'overdue')->count() }}</div>
                        <div class="text-muted small">Terlambat</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-currency-exchange"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ number_format($payments->sum('amount'), 0, ',', '.') }}</div>
                        <div class="text-muted small">Total Nilai</div>
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
                    <input type="text" id="searchPayment" class="form-control border-0 ps-0" placeholder="Cari vendor..." value="{{ request('search') }}">
                </div>
                <div class="d-flex gap-2">
                    <select id="statusFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Status</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
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
                        <th class="d-none d-sm-table-cell">Jadwal</th>
                        <th class="d-none d-sm-table-cell">Jumlah</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    @php
                        $isOverdue = $payment->isOverdue() || $payment->status === 'overdue';
                        $rowClass = $isOverdue ? 'overdue' : ($payment->status === 'paid' ? 'paid' : 'payment-row');
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $payment->vendor_name }}</div>
                            @if($payment->vendor_contact)
                                <small class="text-muted d-block">{{ $payment->vendor_contact }}</small>
                            @endif
                        </td>
                        <td>
                            @if($payment->category)
                                <span class="badge bg-light text-dark border" style="border-color: {{ $payment->category->colour }}20;">
                                    {{ $payment->category->name }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ \Carbon\Carbon::parse($payment->scheduled_date)->format('d M Y') }}
                        </td>
                        <td class="d-none d-sm-table-cell fw-bold">{{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $payment->status_badge_class }}">
                                {{ $payment->status_label }}
                            </span>
                            @if($isOverdue)
                                <span class="badge bg-danger-subtle text-danger ms-1">
                                    <i class="bi bi-exclamation-circle"></i>
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                @if($payment->status !== 'paid' && $payment->status !== 'cancelled')
                                    <form action="{{ route('budget.payment.mark-paid', $payment) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-circle p-2" title="Tandai Lunas">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle p-2" title="Edit"
                                    onclick="openEditModal({{ $payment->id }}, '{{ $payment->vendor_name }}', '{{ $payment->scheduled_date->format('Y-m-d') }}', '{{ $payment->amount }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                    onclick="confirmDeletePay({{ $payment->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-pay-form-{{ $payment->id }}" action="{{ route('budget.payment.destroy', $payment) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-icon"><i class="bi bi-calendar-check"></i></div>
                            <p class="text-muted mb-0">Belum ada jadwal pembayaran.<br>Klik "Jadwalkan Pembayaran" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($payments->hasPages())
    <div class="card-footer bg-transparent border-0 py-3">
        {{ $payments->links() }}
    </div>
    @endif

    <!-- Add Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <form method="POST" action="{{ route('budget.payment.store') }}">
                    @csrf
                    <div class="modal-header" style="background-color: #F7F5F2;">
                        <h5 class="modal-title fw-bold mb-0"><i class="bi bi-calendar-plus me-2"></i> Jadwalkan Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="vendor_name" class="form-label">Nama Vendor *</label>
                            <input type="text" name="vendor_name" id="vendor_name" class="form-control" required placeholder="Contoh: Toko Bunga Cantik">
                        </div>
                        <div class="mb-3">
                            <label for="vendor_contact" class="form-label">Kontak</label>
                            <input type="text" name="vendor_contact" id="vendor_contact" class="form-control" placeholder="No. HP atau email">
                        </div>
                        <div class="mb-3">
                            <label for="budget_category_id" class="form-label">Kategori</label>
                            <select name="budget_category_id" id="budget_category_id" class="form-select">
                                <option value="">Pilih Kategori (Opsional)</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Jumlah *</label>
                                    <input type="number" name="amount" id="amount" class="form-control" required min="0" step="1000" placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="currency" class="form-label">Mata Uang</label>
                                    <select name="currency" id="currency" class="form-select">
                                        <option value="IDR">IDR</option>
                                        <option value="USD">USD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="scheduled_date" class="form-label">Tanggal Dijadwalkan *</label>
                            <input type="date" name="scheduled_date" id="scheduled_date" class="form-control" required value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <div class="mb-0">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-gold-custom">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDeletePay(id) {
            Swal.fire({
                title: 'Hapus jadwal ini?',
                text: "Data jadwal pembayaran yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-pay-form-' + id).submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchPayment');
            const statusFilter = document.getElementById('statusFilter');

            function applyFilters() {
                const url = new URL(window.location.href);
                url.searchParams.delete('search');
                url.searchParams.delete('status');
                if (searchInput.value) url.searchParams.set('search', searchInput.value);
                if (statusFilter.value) url.searchParams.set('status', statusFilter.value);
                window.location.href = url.toString();
            }

            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });
            statusFilter.addEventListener('change', applyFilters);
        });
    </script>
</x-app-layout>

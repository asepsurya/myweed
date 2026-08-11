<x-app-layout>
    <style>
        /* Tema & Font */
        h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--bs-body-color);
        }

        /* Stat Cards */
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
            border-color: rgba(198, 169, 98, 0.4);
        }

        [data-bs-theme="dark"] .stat-card-custom:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            border-color: var(--adminuiux-theme-1);
        }

        .stat-card-custom.border-start-danger {
            border-left: 4px solid #dc3545 !important;
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

        /* Filter Area */
        .filter-pill {
            border-radius: 50px;
            padding: 0.5rem 1rem;
            border: 1px solid var(--bs-border-color);
            background: var(--bs-body-bg);
            color: var(--bs-body-color);
            font-size: 0.875rem;
        }

        .filter-pill:focus {
            border-color: var(--adminuiux-theme-1);
            box-shadow: 0 0 0 0.2rem rgba(198, 169, 98, 0.25);
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

        /* Table Custom */
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
            color: var(--bs-body-color);
        }

        .table-custom tbody tr:hover {
            background-color: rgba(198, 169, 98, 0.05);
        }

        /* Empty State */
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
    </style>

    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Rencana Pernikahan</h4>
            <p class="text-muted mb-0">Kelola dan pantau persiapan pernikahanmu</p>
        </div>
        <a href="{{ route('weeding-plan.create') }}"
            class="btn btn-primary flex-grow-1 flex-md-grow-0 text-white px-4 py-2 fw-bold"
            style="border-radius: 12px;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Rencana
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-primary-subtle text-primary"><i class="bi bi-list-task"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $stats['total'] }}</div>
                        <div class="text-muted small">Total Tugas</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-warning-subtle text-warning"><i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $stats['pending'] }}</div>
                        <div class="text-muted small">Menunggu</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-info-subtle text-info"><i class="bi bi-arrow-repeat"></i></div>
                    <div>
                        <div class="fw-bold fs-5">{{ $stats['in_progress'] }}</div>
                        <div class="text-muted small">Sedang Dikerjakan</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card stat-card-custom shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="stat-icon-box bg-success-subtle text-success"><i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-5">{{ $stats['completed'] }}</div>
                        <div class="text-muted small">Selesai</div>
                    </div>
                </div>
            </div>
        </div>
        @if($stats['overdue'] > 0)
            <div class="col-6 col-md-3">
                <div class="card stat-card-custom shadow-sm border-start-danger">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon-box bg-danger-subtle text-danger"><i
                                class="bi bi-exclamation-triangle-fill"></i></div>
                        <div>
                            <div class="fw-bold fs-5 text-danger">{{ $stats['overdue'] }}</div>
                            <div class="text-muted small">Terlambat</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Tabel Rencana -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <div class="input-group input-group-pill flex-grow-1 flex-md-grow-0" style="max-width: 320px;">
                    <span class="input-group-text border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchPlan" class="form-control border-0 ps-0" placeholder="Cari tugas..."
                        value="{{ request('search') }}">
                </div>
                <div class="d-flex  gap-2">
                    <select id="statusFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang
                            Dikerjakan</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                        </option>
                    </select>
                    <select id="categoryFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Kategori</option>
                        <option value="akad" {{ request('category') == 'akad' ? 'selected' : '' }}>Akad</option>
                        <option value="resepsi" {{ request('category') == 'resepsi' ? 'selected' : '' }}>Resepsi</option>
                        <option value="persiapan" {{ request('category') == 'persiapan' ? 'selected' : '' }}>Persiapan
                        </option>
                        <option value="pakaian" {{ request('category') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                        <option value="kado" {{ request('category') == 'kado' ? 'selected' : '' }}>Kado</option>
                        <option value="tamu" {{ request('category') == 'tamu' ? 'selected' : '' }}>Tamu</option>
                        <option value="dokumentasi" {{ request('category') == 'dokumentasi' ? 'selected' : '' }}>
                            Dokumentasi</option>
                        <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <select id="priorityFilter" class="form-select filter-pill" style="max-width: 180px;">
                        <option value="">Semua Prioritas</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Tugas</th>
                        <th>Kategori</th>
                        <th class="d-none d-sm-table-cell">Prioritas</th>
                        <th class="d-none d-md-table-cell">Batas Waktu</th>
                        <th class="text-nowrap">Status</th> <!-- Tambahan text-nowrap di header -->
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($plans as $plan)
                                        <tr
                                            class="{{ $plan->isOverdue() && $plan->status !== 'completed' ? 'table-danger bg-transparent' : '' }}">
                                            <td class="ps-4">
                                                <div class="fw-semibold">{{ $plan->task_name }}</div>
                                                @if($plan->description)
                                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;"
                                                        title="{{ $plan->description }}">
                                                        {{ $plan->description }}
                                                    </small>
                                                @endif
                                                @if($plan->invitation)
                                                    <small class="text-primary d-block mt-1">
                                                        <i class="bi bi-link-45deg me-1"></i>{{ $plan->invitation->groom_name }} &
                                                        {{ $plan->invitation->bride_name }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border text-capitalize">
                                                    {{ match ($plan->category) {
                            'akad' => 'Akad',
                            'resepsi' => 'Resepsi',
                            'persiapan' => 'Persiapan',
                            'pakaian' => 'Pakaian',
                            'kado' => 'Kado',
                            'tamu' => 'Tamu',
                            'dokumentasi' => 'Dokumentasi',
                            'lainnya' => 'Lainnya',
                            default => $plan->category
                        } }}
                                                </span>
                                            </td>
                                            <td class="d-none d-sm-table-cell">
                                                @if($plan->priority == 'high')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Tinggi</span>
                                                @elseif($plan->priority == 'medium')
                                                    <span
                                                        class="badge bg-warning-subtle text-warning border border-warning-subtle">Sedang</span>
                                                @else
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle">Rendah</span>
                                                @endif
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                @if($plan->due_date)
                                                    <span
                                                        class="{{ $plan->isOverdue() && $plan->status !== 'completed' ? 'text-danger fw-bold' : 'text-muted' }}">
                                                        {{ \Carbon\Carbon::parse($plan->due_date)->format('d M Y') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-nowrap"> <!-- Tambahan text-nowrap agar status 1 baris -->
                                                @if($plan->status == 'completed')
                                                    <span
                                                        class="badge bg-success-subtle text-success border border-success-subtle">Selesai</span>
                                                @elseif($plan->status == 'in_progress')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Sedang
                                                        Dikerjakan</span>
                                                @else
                                                    <span
                                                        class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Menunggu</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="d-none d-sm-flex justify-content-end gap-2">
                                                    <form action="{{ route('weeding-plan.toggle', $plan) }}" method="POST" class="d-inline"
                                                        title="Ubah Status">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-success rounded-circle p-2 d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('weeding-plan.edit', $plan) }}"
                                                        class="btn btn-sm btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center"
                                                        title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger rounded-circle p-2 d-flex align-items-center justify-content-center"
                                                        onclick="confirmDelete({{ $plan->id }})" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>

                                                <div class="d-block d-sm-none">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary rounded-circle p-2 dropdown-toggle"
                                                            type="button" data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <form action="{{ route('weeding-plan.toggle', $plan) }}" method="POST"
                                                                    class="d-inline w-100">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button type="submit" class="dropdown-item py-2">
                                                                        <i class="bi bi-arrow-repeat me-2"></i>Ubah Status
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li><a class="dropdown-item py-2"
                                                                    href="{{ route('weeding-plan.edit', $plan) }}"><i
                                                                        class="bi bi-pencil me-2"></i>Edit</a></li>
                                                            <li><button type="button" class="dropdown-item text-danger py-2"
                                                                    onclick="confirmDelete({{ $plan->id }})"><i
                                                                        class="bi bi-trash me-2"></i>Hapus</button></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <form id="delete-form-{{ $plan->id }}" action="{{ route('weeding-plan.destroy', $plan) }}"
                                                    method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <p class="text-muted mb-0">Belum ada rencana weeding.<br>Tambahkan rencana pertama untuk
                                        memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($plans->hasPages())
            <div class="card-footer bg-transparent border-0 py-3">
                {{ $plans->links() }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchPlan');
            const statusFilter = document.getElementById('statusFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const priorityFilter = document.getElementById('priorityFilter');

            function applyFilters() {
                const search = searchInput.value;
                const status = statusFilter.value;
                const category = categoryFilter.value;
                const priority = priorityFilter.value;
                const url = new URL(window.location.href);

                // Bersihkan parameter yang ada
                url.searchParams.delete('search');
                url.searchParams.delete('status');
                url.searchParams.delete('category');
                url.searchParams.delete('priority');

                // Set parameter hanya jika ada nilainya
                if (search) url.searchParams.set('search', search);
                if (status) url.searchParams.set('status', status);
                if (category) url.searchParams.set('category', category);
                if (priority) url.searchParams.set('priority', priority);

                window.location.href = url.toString();
            }

            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });

            statusFilter.addEventListener('change', applyFilters);
            categoryFilter.addEventListener('change', applyFilters);
            priorityFilter.addEventListener('change', applyFilters);
        });

        // Swal2 Delete Confirmation
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus rencana ini?',
                text: "Data rencana yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
<x-app-layout>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Rencana Pernikahan</h4>
            <p class="text-muted mb-0">Kelola dan pantau persiapan pernikahanmu</p>
        </div>
        <a href="{{ route('weeding-plan.create') }}" class="btn btn-primary flex-grow-1 flex-md-grow-0 text-white">
            <i class="bi bi-plus-lg me-1"></i> Tambah Rencana
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon blue" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-list-task"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['total'] }}</div>
                            <div class="text-muted small">Total Tugas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon yellow" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['pending'] }}</div>
                            <div class="text-muted small">Menunggu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon orange" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['in_progress'] }}</div>
                            <div class="text-muted small">Sedang Dikerjakan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon green" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['completed'] }}</div>
                            <div class="text-muted small">Selesai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($stats['overdue'] > 0)
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100 border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon red" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['overdue'] }}</div>
                            <div class="text-muted small">Terlambat</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <div class="input-group flex-grow-1 flex-md-grow-0" style="max-width: 320px;">
                    <span class="input-group-text border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchPlan" class="form-control border-start-0"
                        placeholder="Cari tugas..." value="{{ request('search') }}">
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <select id="statusFilter" class="form-select" style="max-width: 160px;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <select id="categoryFilter" class="form-select" style="max-width: 160px;">
                        <option value="">Semua Kategori</option>
                        <option value="akad" {{ request('category') == 'akad' ? 'selected' : '' }}>Akad</option>
                        <option value="resepsi" {{ request('category') == 'resepsi' ? 'selected' : '' }}>Resepsi</option>
                        <option value="persiapan" {{ request('category') == 'persiapan' ? 'selected' : '' }}>Persiapan</option>
                        <option value="pakaian" {{ request('category') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                        <option value="kado" {{ request('category') == 'kado' ? 'selected' : '' }}>Kado</option>
                        <option value="tamu" {{ request('category') == 'tamu' ? 'selected' : '' }}>Tamu</option>
                        <option value="dokumentasi" {{ request('category') == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                        <option value="lainnya" {{ request('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <select id="priorityFilter" class="form-select" style="max-width: 160px;">
                        <option value="">Semua Prioritas</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Tugas</th>
                        <th>Kategori</th>
                        <th class="d-none d-sm-table-cell">Prioritas</th>
                        <th class="d-none d-md-table-cell">Batas Waktu</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($plans as $plan)
                        <tr class="{{ $plan->isOverdue() && $plan->status !== 'completed' ? 'table-danger' : '' }}">
                            <td class="ps-4">
                                <div class="fw-semibold">{{ $plan->task_name }}</div>
                                @if($plan->description)
                                    <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                        {{ $plan->description }}
                                    </small>
                                @endif
                                @if($plan->invitation)
                                    <small class="text-primary d-block">
                                        <i class="bi bi-link-45deg me-1"></i>{{ $plan->invitation->groom_name }} & {{ $plan->invitation->bride_name }}
                                    </small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ match($plan->category) {
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
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Sedang</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Rendah</span>
                                @endif
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if($plan->due_date)
                                    <span class="{{ $plan->isOverdue() && $plan->status !== 'completed' ? 'text-danger fw-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($plan->due_date)->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($plan->status == 'completed')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Selesai</span>
                                @elseif($plan->status == 'in_progress')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Sedang Dikerjakan</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Menunggu</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-none d-sm-flex justify-content-end gap-1 gap-sm-2">
                                    <form action="{{ route('weeding-plan.toggle', $plan) }}" method="POST" class="d-inline" title="Ubah Status">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-circle p-1 p-sm-2">
                                            <i class="bi bi-arrow-repeat"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('weeding-plan.edit', $plan) }}"
                                        class="btn btn-sm btn-outline-secondary rounded-circle p-1 p-sm-2" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1 p-sm-2"
                                        onclick="confirmDelete({{ $plan->id }})" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="d-block d-sm-none">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary rounded-circle p-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form action="{{ route('weeding-plan.toggle', $plan) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="dropdown-item py-2">
                                                        <i class="bi bi-arrow-repeat me-2"></i>Ubah Status
                                                    </button>
                                                </form>
                                            </li>
                                            <li><a class="dropdown-item py-2" href="{{ route('weeding-plan.edit', $plan) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><button type="button" class="dropdown-item text-danger py-2" onclick="confirmDelete({{ $plan->id }})"><i class="bi bi-trash me-2"></i>Hapus</button></li>
                                        </ul>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $plan->id }}" action="{{ route('weeding-plan.destroy', $plan) }}" method="POST" style="display:none;">
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
                                    <p class="empty-text">Belum ada rencana weeding.<br>Tambahkan rencana pertama untuk memulai.</p>
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
                if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
                if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
                if (category) url.searchParams.set('category', category); else url.searchParams.delete('category');
                if (priority) url.searchParams.set('priority', priority); else url.searchParams.delete('priority');
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

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus rencana ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</x-app-layout>

<x-app-layout>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">YouTube Music Library</h4>
            <p class="text-muted mb-0">Kelola lagu latar dari YouTube untuk undangan pernikahan</p>
        </div>
        <div class="w-100 w-md-auto">
            <a href="{{ route('youtube-music.create') }}" class="btn btn-primary text-white w-100 w-md-auto">
                <i class="bi bi-plus-lg me-1"></i> Tambah YouTube Music
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon blue" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-youtube"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['total'] }}</div>
                            <div class="text-muted small">Total</div>
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
                            <div class="fw-bold fs-5">{{ $stats['active'] }}</div>
                            <div class="text-muted small">Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon red" style="width:48px;height:48px;font-size:1.2rem;">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $stats['inactive'] }}</div>
                            <div class="text-muted small">Nonaktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent border-0 py-3">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">
                <div class="input-group flex-grow-1 flex-md-grow-0" style="max-width: 320px;">
                    <span class="input-group-text border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchYoutubeMusic" class="form-control border-start-0"
                        placeholder="Cari judul atau penyanyi..." value="{{ request('search') }}">
                </div>
                <div class="d-flex gap-2">
                    <select id="statusFilter" class="form-select" style="max-width: 160px;">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Cover</th>
                        <th>Judul Lagu</th>
                        <th class="d-none d-sm-table-cell">Penyanyi</th>
                        <th class="d-none d-md-table-cell">YouTube ID</th>
                        <th class="d-none d-sm-table-cell">Status</th>
                        <th class="d-none d-lg-table-cell">Tanggal Upload</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($youtubeMusics as $ym)
                        <tr>
                            <td class="ps-4">
                                <img src="{{ $ym->cover_url ?? asset('tempelate/no_sound.webp') }}"
                                    class="rounded border object-fit-cover" style="width: 48px; height: 48px;" alt="cover"
                                    onerror="this.src='{{ asset('tempelate/no_sound.webp') }}'">
                            </td>
                            <td>
                                <div class="fw-semibold text-break">{{ $ym->title }}</div>
                            </td>
                            <td class="d-none d-sm-table-cell text-break" style="max-width: 150px;">{{ $ym->artist }}</td>
                            <td class="d-none d-md-table-cell"><code>{{ $ym->youtube_id }}</code></td>
                            <td class="d-none d-sm-table-cell">
                                @if($ym->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Nonaktif</span>
                                @endif
                            </td>
                            <td class="d-none d-lg-table-cell">{{ $ym->created_at->format('d M Y H:i') }}</td>
                            <td class="text-end pe-4">
                                <div class="d-none d-sm-flex justify-content-end gap-1 gap-sm-2">
                                    <a href="{{ route('youtube-music.edit', $ym) }}"
                                        class="btn btn-sm btn-outline-secondary rounded-circle p-1 p-sm-2" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1 p-sm-2"
                                        onclick="confirmDelete({{ json_encode($ym->id) }})" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                                <div class="d-block d-sm-none">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary rounded-circle p-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item py-2" href="{{ route('youtube-music.edit', $ym) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                                            <li><button class="dropdown-item text-danger py-2" type="button" onclick="confirmDelete({{ json_encode($ym->id) }})"><i class="bi bi-trash me-2"></i>Hapus</button></li>
                                        </ul>
                                    </div>
                                </div>
                                <form id="delete-form-{{ $ym->id }}" action="{{ route('youtube-music.destroy', $ym->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="bi bi-youtube"></i>
                                    </div>
                                    <p class="empty-text">Belum ada YouTube music.<br>Tambahkan YouTube music pertama untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($youtubeMusics->hasPages())
            <div class="card-footer bg-transparent border-0 py-3">
                {{ $youtubeMusics->links() }}
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchYoutubeMusic');
            const statusFilter = document.getElementById('statusFilter');

            function applyFilters() {
                const search = searchInput.value;
                const status = statusFilter.value;
                const url = new URL(window.location.href);
                if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
                if (status) url.searchParams.set('status', status); else url.searchParams.delete('status');
                window.location.href = url.toString();
            }

            let searchTimeout;
            searchInput.addEventListener('input', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });

            statusFilter.addEventListener('change', applyFilters);
        });

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus YouTube music ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</x-app-layout>

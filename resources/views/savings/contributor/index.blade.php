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
            <h4 class="mb-1">Kontributor</h4>
            <p class="text-muted mb-0">Kelola daftar kontributor tabungan</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-custom flex-grow-1 flex-md-grow-0" data-bs-toggle="modal" data-bs-target="#inviteModal">
                <i class="bi bi-envelope me-1"></i> Undang
            </button>
            <a href="{{ route('savings.contributor.create') }}" class="btn btn-gold-custom flex-grow-1 flex-md-grow-0">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </a>
        </div>
    </div>

    <div class="card adminuiux-card shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-custom table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Nama</th>
                        <th>Email</th>
                        <th>Hubungan</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contributors as $contributor)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $contributor->name }}</div>
                        </td>
                        <td>{{ $contributor->email ?? '-' }}</td>
                        <td>{{ $contributor->relationship ?? '-' }}</td>
                        <td>
                            @if($contributor->is_external)
                                <span class="badge bg-info-subtle text-info border border-info-subtle">Eksternal</span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle">User</span>
                            @endif
                        </td>
                        <td>
                            @if($contributor->accepted_at)
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                            @elseif($contributor->invite_token)
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Menunggu</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">-</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('savings.contributor.edit', $contributor) }}" class="btn btn-sm btn-outline-secondary rounded-circle p-1" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1"
                                    onclick="confirmDeleteContributor({{ $contributor->id }})" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-contributor-form-{{ $contributor->id }}" action="{{ route('savings.contributor.destroy', $contributor) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-icon"><i class="bi bi-people"></i></div>
                            <p class="text-muted mb-0">Belum ada kontributor.<br>Klik "Tambah Kontributor" untuk memulai.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($contributors->hasPages())
    <div class="card-footer bg-transparent border-0 py-3">
        {{ $contributors->links() }}
    </div>
    @endif

    <!-- Invite Contributor Modal -->
    <div class="modal fade" id="inviteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <form method="POST" action="{{ route('savings.contributor.invite') }}">
                    @csrf
                    <div class="modal-header" style="background-color: #F7F5F2;">
                        <h5 class="modal-title fw-bold mb-0"><i class="bi bi-envelope me-2"></i> Undang Kontributor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="invite_name" class="form-label">Nama *</label>
                            <input type="text" name="name" id="invite_name" class="form-control" required value="{{ old('name') }}" placeholder="Nama kontributor">
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="invite_email" class="form-label">Email *</label>
                            <input type="email" name="email" id="invite_email" class="form-control" required value="{{ old('email') }}" placeholder="email@example.com">
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="invite_relationship" class="form-label">Hubungan</label>
                            <input type="text" name="relationship" id="invite_relationship" class="form-control" value="{{ old('relationship') }}" placeholder="Contoh: Keluarga, Teman, dll">
                            @error('relationship')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="can_edit" id="invite_can_edit" value="1" {{ old('can_edit') ? 'checked' : '' }}>
                                <label class="form-check-label" for="invite_can_edit">Bisa mengedit tabungan</label>
                            </div>
                            <small class="text-muted">Jika aktif, kontributor dapat menambah dan mengedit setoran.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-gold-custom">Kirim Undangan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteContributor(id) {
            Swal.fire({
                title: 'Hapus kontributor ini?',
                text: "Data kontributor yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-contributor-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

<x-app-layout>
    <div class="container-fluid py-3 py-md-4">
        {{-- Page Header --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="mb-1 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    <i class="bi bi-pin-angle-fill me-2" style="color: #C6A962;"></i> Pengumuman (Banner Atas)
                </h4>
                <p class="text-muted small mb-0">Kelola teks pengumuman pada banner paling atas. Jika lebih dari satu aktif, akan tampil bergilir (slide ke bawah).</p>
            </div>
            <a href="{{ route('announcements.create') }}" class="btn text-white btn-sm px-3 py-2 fw-semibold rounded-3 shadow-sm"
               style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
                <i class="bi bi-plus-lg me-1"></i> Tambah Pengumuman
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0" style="border-radius: 18px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width: 60px;" class="text-center">#</th>
                                <th>Pesan Pengumuman</th>
                                <th class="d-none d-lg-table-cell">Teks Link</th>
                                <th class="d-none d-xl-table-cell">URL Tujuan</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $announcement)
                                <tr>
                                    <td class="text-center text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="fw-semibold d-block text-truncate" style="max-width: 380px;"
                                            title="{{ strip_tags($announcement->message) }}">
                                            {{ strip_tags($announcement->message) }}
                                        </span>
                                        <small class="text-muted">Diperbarui: {{ $announcement->updated_at->format('d M Y H:i') }}</small>
                                    </td>
                                    <td class="d-none d-lg-table-cell text-muted">
                                        {{ $announcement->link_text ?: '-' }}
                                    </td>
                                    <td class="d-none d-xl-table-cell text-muted">
                                        @if($announcement->link_url)
                                            <span class="text-truncate d-inline-block" style="max-width: 220px;"
                                                title="{{ $announcement->link_url }}">{{ $announcement->link_url }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill {{ $announcement->is_active ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-danger-subtle text-danger border border-danger-subtle' }}">
                                            {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('announcements.edit', $announcement) }}"
                                                class="btn btn-sm btn-light rounded-3" title="Edit">
                                                <i class="bi bi-pencil text-warning"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-light rounded-3" title="Hapus"
                                                onclick="confirmDeleteAnnouncement({{ $announcement->id }})">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </div>
                                        <form id="delete-announcement-form-{{ $announcement->id }}"
                                            action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="empty-state-icon mb-3">
                                            <i class="bi bi-megaphone"></i>
                                        </div>
                                        <h6 class="fw-bold mb-1">Belum ada pengumuman</h6>
                                        <p class="text-muted small mb-3">Tambahkan pengumuman untuk menampilkan banner di bagian atas website.</p>
                                        <a href="{{ route('announcements.create') }}" class="btn text-white btn-sm px-4 py-2 fw-semibold rounded-3 shadow-sm"
                                            style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
                                            <i class="bi bi-plus-lg me-1"></i> Tambah Pengumuman
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteAnnouncement(id) {
            Swal.fire({
                title: 'Hapus pengumuman ini?',
                text: "Data pengumuman yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-announcement-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>
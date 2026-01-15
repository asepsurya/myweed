<x-app-layout>
    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">RSVP</h5>
            </div>

            <!-- Statistik -->
            <div class="row g-3 mb-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <i class="bi bi-people-fill fs-3 mb-1"></i>
                            <div class="fw-bold fs-4">{{ $stats['total'] }}</div>
                            <small class="text-muted d-block">Total Tamu</small>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <i class="bi bi-check-circle-fill fs-3 text-success mb-1"></i>
                            <div class="fw-bold fs-4 text-success">{{ $stats['hadir'] }}</div>
                            <small class="text-muted d-block">Hadir</small>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <i class="bi bi-x-circle-fill fs-3 text-danger mb-1"></i>
                            <div class="fw-bold fs-4 text-danger">{{ $stats['tidak_hadir'] }}</div>
                            <small class="text-muted d-block">Tidak Hadir</small>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="border rounded p-3 text-center">
                            <i class="bi bi-question-circle-fill fs-3 text-warning mb-1"></i>
                            <div class="fw-bold fs-4 text-warning">{{ $stats['ragu'] }}</div>
                            <small class="text-muted d-block">Masih Ragu</small>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card shadow-sm mb-4">
                <!-- Header -->
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Aktivitas RSVP Terbaru</h6>

                    <div class="d-flex gap-2">
                        <a href="{{ route('rsvp.index') }}" class="btn btn-sm btn-link">Lihat Semua</a>

                    </div>
                </div>

                <!-- List RSVP -->
                <ul class="list-group list-group-flush">
                    @foreach ($rsvps as $rsvp)
                        <li class="list-group-item px-3 py-2">
                            <div class="row align-items-center gx-3">

                                <!-- Info Tamu -->
                                <div class="col">
                                    <p class="mb-1 fw-medium">{{ $rsvp->name }}</p>
                                    <p class="text-secondary small mb-0">
                                        {{ $rsvp->message }}
                                    </p>
                                </div>

                                <!-- Status RSVP -->
                                <div class="col-auto text-end">
                                    <span
                                        class="badge
                        @if ($rsvp->attending == 1) bg-success
                        @elseif($rsvp->attending == 2) bg-danger
                        @else bg-warning text-dark @endif">
                                        @if ($rsvp->attending == 1)
                                            Hadir
                                        @elseif($rsvp->attending == 2)
                                            Tidak Hadir
                                        @else
                                            Ragu
                                        @endif
                                    </span>

                                    <p class="text-muted small mb-0">
                                        {{ $rsvp->created_at->format('d M Y') }}
                                    </p>
                                </div>

                                <!-- Aksi (Hapus) -->
                                <div class="col-auto">
                                    <a href="#"
                                        class="btn btn-sm btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center"
                                        onclick="confirmDelete({{ $rsvp->id }})">
                                        <i class="bi bi-trash"></i>
                                    </a>

                                    <form id="delete-form-{{ $rsvp->id }}"
                                        action="{{ route('rsvp.destroy', $rsvp->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>

                            </div>
                        </li>
                    @endforeach

                    @if ($rsvps->isEmpty())
                        <li class="list-group-item text-center text-muted py-3">
                            Belum ada RSVP terbaru
                        </li>
                    @endif
                </ul>
            </div>


            <!-- Pagination -->
            <div class="mt-3">
                {{ $rsvps->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
<script>
    function confirmDelete(rsvpId) {
        if (confirm('Apakah Anda yakin ingin menghapus RSVP ini?')) {
            document.getElementById('delete-form-' + rsvpId).submit();
        }
    }
</script>

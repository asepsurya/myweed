<x-app-layout>
                <div class="row g-3 mb-4">

                <!-- Total Tamu -->
                <div class="col-md-3">
                    <div class="card adminuiux-card theme-teal mb-4">
                        <div class="card-body z-index-1">
                            <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded mb-3">
                                <i class="bi bi-people-fill h4"></i>
                            </div>
                            <h4 class="fw-medium">{{ $stats['total'] }}</h4>
                            <p><span class="text-secondary">Total:</span> <b>Semua Tamu</b></p>
                        </div>
                    </div>
                </div>

                <!-- Hadir -->
                <div class="col-md-3">
                    <div class="card adminuiux-card theme-success mb-4">
                        <div class="card-body z-index-1">
                            <div class="avatar avatar-60 bg-success-subtle text-success rounded mb-3">
                                <i class="bi bi-check-circle-fill h4"></i>
                            </div>
                            <h4 class="fw-medium text-success">{{ $stats['hadir'] }}</h4>
                            <p><span class="text-secondary">Status:</span> <b>Hadir</b></p>
                        </div>
                    </div>
                </div>

                <!-- Tidak Hadir -->
                <div class="col-md-3">
                    <div class="card adminuiux-card theme-danger mb-4">
                        <div class="card-body z-index-1">
                            <div class="avatar avatar-60 bg-danger-subtle text-danger rounded mb-3">
                                <i class="bi bi-x-circle-fill h4"></i>
                            </div>
                            <h4 class="fw-medium text-danger">{{ $stats['tidak_hadir'] }}</h4>
                            <p><span class="text-secondary">Status:</span> <b>Tidak Hadir</b></p>
                        </div>
                    </div>
                </div>

                <!-- Masih Ragu -->
                <div class="col-md-3">
                    <div class="card adminuiux-card theme-warning mb-4">
                        <div class="card-body z-index-1">
                            <div class="avatar avatar-60 bg-warning-subtle text-warning rounded mb-3">
                                <i class="bi bi-question-circle-fill h4"></i>
                            </div>
                            <h4 class="fw-medium text-warning">{{ $stats['ragu'] }}</h4>
                            <p><span class="text-secondary">Status:</span> <b>Masih Ragu</b></p>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Statistik -->

            <div class="card shadow-sm mb-4">
                <!-- Header -->
                <div class="card-header  d-flex align-items-center justify-content-between">
                    <h6 class="mb-0">Aktivitas RSVP Terbaru</h6>

                    <div class="d-flex gap-2">
                        <a href="{{ route('rsvp.index') }}" class="btn btn-sm btn-link">Pasangan</a>
                        <select name="list" id="list" class="form-control">
                            @foreach ($inviation as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
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


</x-app-layout>
<script>
    function confirmDelete(rsvpId) {
        if (confirm('Apakah Anda yakin ingin menghapus RSVP ini?')) {
            document.getElementById('delete-form-' + rsvpId).submit();
        }
    }
</script>

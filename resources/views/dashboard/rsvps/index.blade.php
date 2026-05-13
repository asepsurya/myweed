<x-app-layout>
    <style>
        /* Tambahan style lain */
        [data-bs-theme="dark"] .ts-control,
        [data-bs-theme="dark"] .ts-dropdown {
            background-color: #1e1e2d;
            color: #e5e7eb;
            border-color: #374151;
        }

        [data-bs-theme="dark"] .ts-control input {
            color: #e5e7eb;
        }

        [data-bs-theme="dark"] .ts-dropdown {
            box-shadow: 0 10px 25px rgba(0, 0, 0, .6);
        }

        [data-bs-theme="dark"] .ts-dropdown .option {
            color: #e5e7eb;
        }

        [data-bs-theme="dark"] .ts-dropdown .option:hover,
        [data-bs-theme="dark"] .ts-dropdown .option.active {
            background-color: #374151;
            color: #fff;
        }

        [data-bs-theme="dark"] .ts-dropdown .option.selected {
            background-color: #2563eb;
            color: #fff;
        }

        [data-bs-theme="dark"] .ts-control::after {
            border-top-color: #e5e7eb;
        }

    </style>
    <div class="row g-3 mb-4">

        <!-- Total Tamu -->
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card theme-teal h-100">
                <div class="card-body">
                    <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded mb-3">
                        <i class="bi bi-people-fill h4"></i>
                    </div>
                    <h4 class="fw-medium">{{ $stats['total'] }}</h4>
                    <p class="mb-0">
                        <span class="text-secondary">Total:</span> <b>Semua Tamu</b>
                    </p>
                </div>
            </div>
        </div>

        <!-- Hadir -->
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card theme-success h-100">
                <div class="card-body">
                    <div class="avatar avatar-60 bg-success-subtle text-success rounded mb-3">
                        <i class="bi bi-check-circle-fill h4"></i>
                    </div>
                    <h4 class="fw-medium text-success">{{ $stats['hadir'] }}</h4>
                    <p class="mb-0">
                        <span class="text-secondary">Status:</span> <b>Hadir</b>
                    </p>
                </div>
            </div>
        </div>

        <!-- Tidak Hadir -->
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card theme-danger h-100">
                <div class="card-body">
                    <div class="avatar avatar-60 bg-danger-subtle text-danger rounded mb-3">
                        <i class="bi bi-x-circle-fill h4"></i>
                    </div>
                    <h4 class="fw-medium text-danger">{{ $stats['tidak_hadir'] }}</h4>
                    <p class="mb-0">
                        <span class="text-secondary">Status:</span> <b>Tidak Hadir</b>
                    </p>
                </div>
            </div>
        </div>

        <!-- Masih Ragu -->
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card theme-warning h-100">
                <div class="card-body">
                    <div class="avatar avatar-60 bg-warning-subtle text-warning rounded mb-3">
                        <i class="bi bi-question-circle-fill h4"></i>
                    </div>
                    <h4 class="fw-medium text-warning">{{ $stats['ragu'] }}</h4>
                    <p class="mb-0">
                        <span class="text-secondary">Status:</span> <b>Masih Ragu</b>
                    </p>
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
                <form action="" method="GET">
                    <select name="list" id="list" class="form-control" onchange="form.submit()">
                        <option value="">Pilih Undangan</option>
                        @foreach ($invitations as $item)
                        <option value="{{ $item->id }}" {{ $activeInvitationId == $item->id ? 'selected' : '' }}>
                            {{ $item->groom_nickname }} & {{ $item->bride_nickname }}
                        </option>
                        @endforeach
                    </select>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        new TomSelect('#list', {
                            placeholder: 'Pilih Undangan'
                            , allowEmptyOption: true
                            , create: false
                            , maxOptions: 500
                            , searchField: ['text']
                            , render: {
                                no_results: function(data, escape) {
                                    return '<div class="no-results">Tidak ditemukan</div>';
                                }
                            }
                        });
                    });

                </script>

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
                        <span class="badge
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
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle p-2 d-flex align-items-center justify-content-center" onclick="confirmDelete({{ $rsvp->id }})">
                            <i class="bi bi-trash"></i>
                        </a>

                        <form id="delete-form-{{ $rsvp->id }}" action="{{ route('rsvp.destroy', $rsvp->id) }}" method="POST" class="d-none">
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

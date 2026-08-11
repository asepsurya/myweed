<x-app-layout>
    <style>
        /* Override Tom-Select agar sesuai tema Gold/Navy */
        .ts-wrapper.focus .ts-control {
            border-color: var(--adminuiux-theme-1) !important;
            box-shadow: 0 0 0 0.2rem rgba(198, 169, 98, 0.25) !important;
        }

        .ts-dropdown .option.active,
        .ts-dropdown .option:hover {
            background-color: rgba(198, 169, 98, 0.1) !important;
            color: var(--adminuiux-text) !important;
        }

        .ts-dropdown .option.selected {
            background-color: var(--adminuiux-theme-1) !important;
            color: var(--adminuiux-theme-1-text) !important;
        }

        [data-bs-theme="dark"] .ts-control,
        [data-bs-theme="dark"] .ts-dropdown {
            background-color: var(--adminuiux-bg-2) !important;
            color: var(--adminuiux-text) !important;
            border-color: var(--bs-border-color) !important;
        }

        [data-bs-theme="dark"] .ts-control input {
            color: var(--adminuiux-text) !important;
        }

        [data-bs-theme="dark"] .ts-dropdown {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
        }

        [data-bs-theme="dark"] .ts-control::after {
            border-top-color: var(--adminuiux-text) !important;
        }

        /* =============================================
           STATISTIK CARDS (SCROLL)
        ============================================= */
        .stats-scroll {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: var(--adminuiux-theme-1) transparent;
            padding-bottom: 10px;
            margin-bottom: 1.5rem;
        }

        .stats-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .stats-scroll::-webkit-scrollbar-thumb {
            background: var(--adminuiux-theme-1);
            border-radius: 10px;
        }

        .stats-row {
            display: flex;
            flex-wrap: nowrap;
            gap: 1rem;
            min-width: 100%;
        }

        .stat-item {
            flex: 1 1 0;
            min-width: 0;
        }

        /* Tablet & Mobile */
        @media (max-width: 991.98px) {
            .stats-row {
                width: max-content;
            }

            .stat-item {
                flex: 0 0 200px;
                width: 200px;
            }
        }

        /* Mobile Kecil */
        @media (max-width: 575.98px) {
            .stats-row {
                gap: 0.75rem;
            }

            .stat-item {
                flex: 0 0 165px;
                width: 165px;
            }

            .stat-item .card-body {
                padding: 1rem;
            }

            .stat-item .avatar {
                width: 42px !important;
                height: 42px !important;
                margin-bottom: 0.75rem !important;
            }

            .stat-item .avatar i {
                font-size: 1rem !important;
            }

            .stat-item h4 {
                font-size: 1.25rem !important;
            }

            .stat-item p {
                font-size: 0.7rem !important;
            }
        }

        /* =============================================
           LIST RSVP (FLEX & STICKY HEADER)
        ============================================= */
        .rsvp-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.25rem;
            transition: background-color 0.2s ease;
        }

        .rsvp-item:hover {
            background-color: var(--adminuiux-bg-1);
        }

        .rsvp-info {
            flex: 1;
            min-width: 0;
        }

        .rsvp-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-shrink: 0;
        }

        .min-w-200px {
            min-width: 200px;
        }

        /* Sticky Header untuk Kartu RSVP */
        .sticky-rsvp-header {
            position: sticky;
            top: 68px;
            z-index: 1020;
            background-color: var(--adminuiux-bg-2) !important;
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--bs-border-color) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        [data-bs-theme="dark"] .sticky-rsvp-header {
            background-color: var(--adminuiux-bg-2) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 575.98px) {
            .sticky-rsvp-header {
                z-index: 50;
            }

            .rsvp-item {
                flex-wrap: wrap;
            }

            .rsvp-actions {
                width: 100%;
                justify-content: space-between;
                padding-top: 0.5rem;
                border-top: 1px dashed var(--bs-border-color);
                margin-top: 0.5rem;
            }

            .sticky-rsvp-header {
                top: 56px;
            }
        }
    </style>

    <!-- Statistik Cards -->
    <div class="stats-scroll">
        <div class="stats-row">
            <!-- Total Tamu -->
            <div class="stat-item">
                <div class="card adminuiux-card theme-teal h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded mb-3">
                            <i class="bi bi-people-fill h4"></i>
                        </div>
                        <h4 class="fw-bold mb-0">{{ $stats['total'] }}</h4>
                        <p class="mb-0 text-secondary small">
                            <span>Total:</span> <b>Semua Tamu</b>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hadir -->
            <div class="stat-item">
                <div class="card adminuiux-card theme-success h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-success-subtle text-success rounded mb-3">
                            <i class="bi bi-check-circle-fill h4"></i>
                        </div>
                        <h4 class="fw-bold text-success mb-0">{{ $stats['hadir'] }}</h4>
                        <p class="mb-0 text-secondary small">
                            <span>Status:</span> <b>Hadir</b>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tidak Hadir -->
            <div class="stat-item">
                <div class="card adminuiux-card theme-danger h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-danger-subtle text-danger rounded mb-3">
                            <i class="bi bi-x-circle-fill h4"></i>
                        </div>
                        <h4 class="fw-bold text-danger mb-0">{{ $stats['tidak_hadir'] }}</h4>
                        <p class="mb-0 text-secondary small">
                            <span>Status:</span> <b>Tidak Hadir</b>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Masih Ragu -->
            <div class="stat-item">
                <div class="card adminuiux-card theme-warning h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="avatar avatar-60 bg-warning-subtle text-warning rounded mb-3">
                            <i class="bi bi-question-circle-fill h4"></i>
                        </div>
                        <h4 class="fw-bold text-warning mb-0">{{ $stats['ragu'] }}</h4>
                        <p class="mb-0 text-secondary small">
                            <span>Status:</span> <b>Masih Ragu</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List RSVP -->
    <div class="card shadow-sm mb-4">
        <!-- Header (Sticky) -->
        <div
            class="card-header sticky-rsvp-header d-flex align-items-center justify-content-between flex-wrap gap-2 py-3">
            <h6 class="mb-0 fw-bold text-uppercase text-secondary ls-2">Aktivitas RSVP Terbaru</h6>

            <div class="d-flex align-items-center gap-2 w-100 w-md-auto">
                <a href="{{ route('rsvp.index') }}" class="btn btn-sm btn-outline-secondary flex-shrink-0">
                    <i class="bi bi-people me-1"></i> Kelola
                </a>
                <form action="" method="GET" class="flex-grow-1">
                    <select name="list" id="list" class="form-control" onchange="form.submit()">
                        <option value="">Pilih Undangan</option>
                        @foreach ($invitations as $item)
                            <option value="{{ $item->id }}" {{ $activeInvitationId == $item->id ? 'selected' : '' }}>
                                {{ $item->groom_nickname }} & {{ $item->bride_nickname }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <!-- List Items -->
        <ul class="list-group list-group-flush">
            @foreach ($rsvps as $rsvp)
                <li class="list-group-item rsvp-item">
                    <!-- Info Tamu -->
                    <div class="rsvp-info">
                        <p class="mb-1 fw-medium">{{ $rsvp->name }}</p>
                        <p class="text-secondary small mb-0 text-truncate" title="{{ $rsvp->message }}">
                            {{ $rsvp->message }}
                        </p>
                    </div>

                    <!-- Aksi & Status -->
                    <div class="rsvp-actions">
                        <div class="text-end">
                            <span class="badge rounded-pill
                                            @if ($rsvp->attending == 1) bg-success-subtle text-success
                                            @elseif($rsvp->attending == 2) bg-danger-subtle text-danger
                                            @else bg-warning-subtle text-warning @endif px-3 py-2">
                                @if ($rsvp->attending == 1) Hadir
                                @elseif($rsvp->attending == 2) Tidak Hadir
                                @else Ragu @endif
                            </span>
                            <p class="text-muted small mb-0 mt-1">
                                {{ $rsvp->created_at->format('d M Y') }}
                            </p>
                        </div>

                        <button type="button"
                            class="btn btn-sm btn-outline-danger rounded-circle p-2 d-flex align-items-center justify-content-center"
                            onclick="confirmDelete({{ $rsvp->id }})">
                            <i class="bi bi-trash"></i>
                        </button>

                        <form id="delete-form-{{ $rsvp->id }}" action="{{ route('rsvp.destroy', $rsvp->id) }}" method="POST"
                            class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </li>
            @endforeach

            @if ($rsvps->isEmpty())
                <li class="list-group-item text-center text-muted py-5">
                    <i class="bi bi-inbox display-6 d-block mb-2 opacity-50"></i>
                    Belum ada RSVP terbaru
                </li>
            @endif
        </ul>
    </div>

    <!-- Pagination -->
    <div class="mt-3 d-flex justify-content-center">
        {{ $rsvps->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Init TomSelect
            new TomSelect('#list', {
                placeholder: 'Pilih Undangan...',
                allowEmptyOption: true,
                create: false,
                maxOptions: 500,
                searchField: ['text'],
                render: {
                    no_results: function (data, escape) {
                        return '<div class="no-results p-2 text-muted">Tidak ditemukan</div>';
                    }
                }
            });
        });

        // Swal2 Delete Confirmation
        function confirmDelete(rsvpId) {
            Swal.fire({
                title: 'Hapus RSVP ini?',
                text: "Data tamu yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + rsvpId).submit();
                }
            });
        }
    </script>
</x-app-layout>
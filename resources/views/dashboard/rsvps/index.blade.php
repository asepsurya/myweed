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

        /* =============================================
           STATISTIK CARDS
        ============================================= */
        .stat-card-gold {
            border: 1px solid var(--bs-border-color);
            background-color: var(--adminuiux-bg-2, #ffffff);
            border-radius: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        /* =============================================
           LIST RSVP
        ============================================= */
        .rsvp-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.1rem 1.25rem;
            transition: background-color 0.2s ease;
        }

        .rsvp-item:hover {
            background-color: var(--adminuiux-bg-1, rgba(0, 0, 0, 0.02));
        }

        .rsvp-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            flex-shrink: 0;
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

        /* Sticky Header untuk Kartu RSVP */
        .sticky-rsvp-header {
            position: sticky;
            top: 68px;
            z-index: 20;
            background-color: var(--adminuiux-bg-2, #ffffff) !important;
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--bs-border-color) !important;
        }

        @media (max-width: 575.98px) {
            .rsvp-item {
                flex-wrap: wrap;
                padding: 1rem;
            }

            .rsvp-actions {
                width: 100%;
                justify-content: space-between;
                padding-top: 0.5rem;
                border-top: 1px dashed var(--bs-border-color);
                margin-top: 0.25rem;
            }

            .sticky-rsvp-header {
                top: 56px;
            }
        }
    </style>

    <!-- Page Header -->
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h4 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Data RSVP & Konfirmasi
                    Kehadiran</h4>
                <span class="badge rounded-pill px-2.5 py-1 small"
                    style="background: rgba(198, 169, 98, 0.15); color: #A68B4B; border: 1px solid rgba(198, 169, 98, 0.3);">
                    {{ $stats['total'] }} Tamu
                </span>
            </div>
            <p class="text-muted mb-0 small">Pantau respon kehadiran serta ucapan dan doa dari para tamu undangan</p>
        </div>
        @if(request('list'))
            <a href="{{ route('rsvp.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-x-circle me-1"></i> Tampilkan Semua Undangan
            </a>
        @endif
    </div>

    <!-- Invitation Banner (ditampilkan saat halaman RSVP dibuka per-undangan) -->
    @if(isset($showInvitation) && $showInvitation)
        @php
            $invCover = $showInvitation->gallery_cover
                ? storage_url_with_fallback($showInvitation->gallery_cover, null, $showInvitation->updated_at?->timestamp)
                : null;
        @endphp
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="row g-0">
                <div class="col-12 col-md-4 col-lg-3"
                    style="min-height: 190px; background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%);">
                    @if($invCover)
                        <img src="{{ $invCover }}" alt="Cover Undangan"
                            class="w-100 h-100 object-fit-cover" style="min-height: 190px;">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-white"
                            style="min-height: 190px;">
                            <i class="bi bi-envelope-heart" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="card-body p-3 p-md-4">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <span class="badge rounded-pill px-3 py-2 small"
                                style="background: rgba(198,169,98,.15); color:#A68B4B; border:1px solid rgba(198,169,98,.3);">
                                <i class="bi bi-envelope-heart me-1"></i> Undangan
                            </span>
                            <span class="badge rounded-pill px-3 py-2 small text-uppercase
                                {{ $showInvitation->status === 'published' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                {{ $showInvitation->status ?? 'draft' }}
                            </span>
                        </div>
                        <h4 class="fw-bold mb-2" style="font-family:'Plus Jakarta Sans',sans-serif;">
                            {{ $showInvitation->groom_nickname ?? $showInvitation->groom_name }}
                            &amp;
                            {{ $showInvitation->bride_nickname ?? $showInvitation->bride_name }}
                        </h4>
                        <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
                            <span>
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $showInvitation->wedding_date ? \Carbon\Carbon::parse($showInvitation->wedding_date)->translatedFormat('d M Y') : 'Tanggal belum ditentukan' }}
                            </span>
                            @if($showInvitation->akad_location)
                                <span class="text-truncate">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $showInvitation->akad_location }}
                                </span>
                            @endif
                            <span class="text-truncate">
                                <i class="bi bi-link-45deg me-1"></i>/{{ $showInvitation->slug }}
                            </span>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('invitation.show', $showInvitation->slug) }}" target="_blank"
                                class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="bi bi-eye me-1"></i> Lihat Undangan
                            </a>
                            <a href="{{ route('guest.camera', $showInvitation->slug) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-camera me-1"></i> Kamera Tamu
                            </a>
                            <a href="{{ route('guest.gallery', $showInvitation->slug) }}" target="_blank"
                                class="btn btn-sm btn-outline-success rounded-pill">
                                <i class="bi bi-images me-1"></i> Galeri Tamu
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Statistik Cards Grid -->
    <div class="row g-3 row-cols-2 row-cols-md-4 mb-4">
        <!-- Total Tamu -->
        <div class="col">
            <div class="card stat-card-gold h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-44 rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 44px; height: 44px; background: rgba(59, 130, 246, 0.12); color: #3b82f6;">
                        <i class="bi bi-people-fill fs-5"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $stats['total'] }}
                        </h4>
                        <p class="mb-0 text-muted small">Semua Respon</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hadir -->
        <div class="col">
            <div class="card stat-card-gold h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-44 rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 44px; height: 44px; background: rgba(16, 185, 129, 0.12); color: #10b981;">
                        <i class="bi bi-check-circle-fill fs-5"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-success mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $stats['hadir'] }}
                        </h4>
                        <p class="mb-0 text-muted small">Hadir</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masih Ragu -->
        <div class="col">
            <div class="card stat-card-gold h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-44 rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 44px; height: 44px; background: rgba(245, 158, 11, 0.12); color: #f59e0b;">
                        <i class="bi bi-question-circle-fill fs-5"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-warning mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $stats['ragu'] }}
                        </h4>
                        <p class="mb-0 text-muted small">Masih Ragu</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tidak Hadir -->
        <div class="col">
            <div class="card stat-card-gold h-100 border-0 shadow-sm p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-44 rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0"
                        style="width: 44px; height: 44px; background: rgba(239, 68, 68, 0.12); color: #ef4444;">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-danger mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $stats['tidak_hadir'] }}
                        </h4>
                        <p class="mb-0 text-muted small">Tidak Hadir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- List RSVP -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <!-- Header (Sticky) -->
        <div class="card-header  d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 px-3 px-md-4">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-chat-heart text-gold fs-5"></i>
                <h6 class="mb-0 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Konfirmasi Tamu
                </h6>
            </div>

            <div class="d-flex align-items-center gap-2 w-100 w-md-auto ms-auto" style="max-width: 380px;">
                <form action="{{ isset($showInvitation) ? route('rsvp.index') : '' }}" method="GET" class="w-100">
                    <select name="list" id="list" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Undangan</option>
                        @foreach ($invitations as $item)
                            <option value="{{ $item->id }}" {{ $activeInvitationId == $item->id ? 'selected' : '' }}>
                                {{ $item->groom_nickname ?? $item->groom_name }} &
                                {{ $item->bride_nickname ?? $item->bride_name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <!-- List Items -->
        <ul class="list-group list-group-flush mb-0">
            @forelse ($rsvps as $rsvp)
                @php
                    $initial = strtoupper(mb_substr($rsvp->name ?? 'G', 0, 1));
                    $bgColor = 'rgba(198, 169, 98, 0.15)';
                    $textColor = '#A68B4B';
                    if ($rsvp->attending == 1) {
                        $bgColor = 'rgba(16, 185, 129, 0.12)';
                        $textColor = '#10b981';
                    } elseif ($rsvp->attending == 2) {
                        $bgColor = 'rgba(239, 68, 68, 0.12)';
                        $textColor = '#ef4444';
                    } else {
                        $bgColor = 'rgba(245, 158, 11, 0.12)';
                        $textColor = '#f59e0b';
                    }
                @endphp
                <li class="list-group-item rsvp-item border-bottom">
                    <!-- Avatar Inisial -->
                    <div class="rsvp-avatar" style="background: {{ $bgColor }}; color: {{ $textColor }};">
                        {{ $initial }}
                    </div>

                    <!-- Info Tamu -->
                    <div class="rsvp-info">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h6 class="mb-0 fw-bold">{{ $rsvp->name }}</h6>
                            @if($rsvp->invitation)
                                <span class="badge bg-light text-muted border small" style="font-size: 0.7rem;">
                                    {{ $rsvp->invitation->groom_nickname ?? 'Groom' }} &
                                    {{ $rsvp->invitation->bride_nickname ?? 'Bride' }}
                                </span>
                            @endif
                        </div>
                        <p class="text-secondary small mb-0" style="line-height: 1.4;">
                            {{ $rsvp->message ?: 'Tidak ada pesan' }}
                        </p>
                    </div>

                    <!-- Aksi & Status -->
                    <div class="rsvp-actions">
                        <div class="text-end">
                            <span
                                class="badge rounded-pill
                                            @if ($rsvp->attending == 1) bg-success-subtle text-success border border-success-subtle
                                            @elseif($rsvp->attending == 2) bg-danger-subtle text-danger border border-danger-subtle
                                            @else bg-warning-subtle text-warning border border-warning-subtle @endif px-3 py-1.5 small">
                                @if ($rsvp->attending == 1)
                                    <i class="bi bi-check-circle me-1"></i>Hadir
                                @elseif($rsvp->attending == 2)
                                    <i class="bi bi-x-circle me-1"></i>Tidak Hadir
                                @else
                                    <i class="bi bi-question-circle me-1"></i>Ragu
                                @endif
                            </span>
                            <div class="text-muted small mt-1" style="font-size: 0.75rem;">
                                {{ $rsvp->created_at ? $rsvp->created_at->format('d M Y, H:i') : '-' }}
                            </div>
                        </div>

                        <button type="button"
                            class="btn btn-sm btn-outline-danger rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" onclick="confirmDelete({{ $rsvp->id }})" title="Hapus RSVP">
                            <i class="bi bi-trash"></i>
                        </button>

                        <form id="delete-form-{{ $rsvp->id }}" action="{{ route('rsvp.destroy', $rsvp->id) }}" method="POST"
                            class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </li>
            @empty
                <li class="list-group-item text-center py-5">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                        style="width: 64px; height: 64px; background: rgba(198, 169, 98, 0.1); color: #C6A962;">
                        <i class="bi bi-inbox fs-2"></i>
                    </div>
                    <h6 class="fw-bold mb-1">Belum Ada RSVP</h6>
                    <p class="text-muted small mb-0">Belum ada tamu yang mengirimkan konfirmasi kehadiran untuk undangan
                        ini.</p>
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Pagination -->
    @if($rsvps->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $rsvps->links() }}
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Init TomSelect
            if (document.getElementById('list')) {
                new TomSelect('#list', {
                    placeholder: 'Semua Undangan...',
                    allowEmptyOption: true,
                    create: false,
                    maxOptions: 500,
                    searchField: ['text'],
                });
            }
        });

        // Swal2 Delete Confirmation
        function confirmDelete(rsvpId) {
            Swal.fire({
                title: 'Hapus RSVP ini?',
                text: "Data tamu yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + rsvpId).submit();
                }
            });
        }
    </script>
</x-app-layout>
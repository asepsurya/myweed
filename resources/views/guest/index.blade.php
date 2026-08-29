<x-app-layout>
    @php
        $firstInvitation = $invitations->first();
        $themeColor = $firstInvitation->theme_color ?? '#C6A962'; // Default Gold
    @endphp

    <style>
        :root {
            --mobile-nav-active-color: {{ $themeColor }};
        }

        .invitation-list-item {
            padding: 14px 16px;
            transition: background-color 0.2s ease;
            background-color: var(--bs-body-bg);
            border-color: var(--bs-border-color);
        }
        
        [data-bs-theme="dark"] .invitation-list-item {
            background-color: var(--adminuiux-bg-2);
        }

        .invitation-list-item:hover {
            background-color: rgba(198, 169, 98, 0.05); /* Hover Gold lembut */
        }

        .info-text {
            min-width: 0; /* Penting agar flexbox text-truncate berfungsi */
        }

        .info-text h6 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            color: var(--bs-body-color);
        }

        /* Ukuran Touch Target yang Nyaman untuk Mobile */
        @media (max-width: 767.98px) {
            .invitation-list-item {
                padding: 12px 14px;
            }
            .w-md-100 {
                width: 100% !important;
            }
            .btn-icon-mobile {
                width: 44px;
                height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                font-size: 1.1rem;
                border-radius: 50% !important;
            }
        }

        @media (max-width: 575.98px) {
            .btn-icon-mobile {
                width: 40px;
                height: 40px;
            }
        }

        /* Modal Custom Styles */
        .modal-theme-navy .modal-header {
            background-color: var(--adminuiux-theme-2, #1B2A4A);
            color: #fff;
            border-bottom: 3px solid var(--adminuiux-theme-1, #C6A962);
            padding: 20px;
        }
        .modal-theme-navy .modal-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .modal-theme-navy .modal-body {
            background-color: var(--bs-body-bg);
        }
        .modal-theme-navy .modal-footer {
            background-color: var(--bs-body-bg);
            border-top: none;
        }
        .input-group-text {
            background-color: var(--adminuiux-bg-1, #F7F5F2);
            border-color: var(--bs-border-color);
            color: var(--adminuiux-theme-1, #C6A962);
        }
        .form-control {
            border-color: var(--bs-border-color);
        }
    </style>

    <!-- TAB 1: Aktivitas Undangan -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="py-10">
            <div class="container-fluid">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;">Aktivitas Undangan Terbaru</h4>
                        @php $status = auth()->user()->subscriptionStatus(); @endphp
                        @if($status == 'active')
                            <span class="badge bg-warning text-dark small">
                                <i class="bi bi-star-fill me-1"></i> Premium
                                @if(auth()->user()->isAdmin())
                                    (Admin Access)
                                @elseif(auth()->user()->subscription)
                                    (Aktif s/d: {{ auth()->user()->subscription->end_date->format('d M Y') }})
                                @endif
                            </span>
                            @php $partnerOwner = auth()->user()->getPartnerSubscriptionOwner(); @endphp
                            @if($partnerOwner)
                                <span class="badge bg-info text-dark small ms-1">
                                    <i class="bi bi-people me-1"></i> Aku bersama {{ $partnerOwner->name }}
                                </span>
                            @endif
                        @else
                            @php $partnerOwner = auth()->user()->getPartnerSubscriptionOwner(); @endphp
                            @if($partnerOwner)
                                <span class="badge bg-info text-dark small">
                                    <i class="bi bi-people me-1"></i> Aku bersama {{ $partnerOwner->name }}
                                </span>
                            @else
                                <span class="badge bg-light text-dark border small">Free Plan (Limit 1 Undangan)</span>
                            @endif
                        @endif
                    </div>

                    <div class="w-md-100 d-flex justify-content-md-end">
                        @php
                            $user = auth()->user();
                            $canCreateMore = $user->isAdmin() || $user->isSubscribed() || $user->invitations->count() < 1;
                        @endphp

                        @if($canCreateMore)
                            <button type="button" class="btn btn-sm btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#newInvitationModal">
                                <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-warning w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#upgradeModal">
                                <i class="bi bi-star me-1"></i> Upgrade ke Premium
                            </button>
                        @endif
                            </div>
                </div>

                <!-- Buku Tamu Header -->
           

                <form id="bulkDeleteForm" action="{{ route('invitation.bulk-delete') }}" method="POST">
                    @csrf

                            @if($invitations->isNotEmpty())
                            <div class="d-flex align-items-center justify-content-between mb-3 px-3 py-2 rounded border" 
                                 style="background-color: rgba(198, 169, 98, 0.1); border-color: rgba(198, 169, 98, 0.2) !important;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label small fw-bold" for="selectAll">Pilih Semua</label>
                                </div>
                                
                                <button type="submit" class="btn btn-danger btn-sm btn-bulk-delete" disabled>
                                    <i class="bi bi-trash me-1"></i> Hapus (<span id="selectedCount">0</span>)
                                </button>
                            </div>
                            @endif

                    <ul class="list-group">
                        @forelse ($invitations as $inv)
                            <li class="list-group-item invitation-list-item d-flex align-items-center gap-3">
                                <!-- Checkbox -->
                                <input type="checkbox" name="ids[]" value="{{ $inv->public_id }}" class="form-check-input flex-shrink-0 m-0 bulk-checkbox">

                                <!-- Cover -->
                                <div class="flex-shrink-0">
                                @if($inv->gallery_cover)
                                    <img src="{{ storage_url_with_fallback($inv->gallery_cover, null, $inv->updated_at->timestamp) }}" class="rounded object-fit-cover" style="width: 48px; height: 48px;" alt="Cover">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: rgba(198, 169, 98, 0.1); color: var(--adminuiux-theme-1);">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-grow-1 info-text">
                                    <h6 class="mb-0 fw-bold">
                                        {{ $inv->groom_nickname ?? $inv->groom_name }} & {{ $inv->bride_nickname ?? $inv->bride_name }}
                                    </h6>
                                    <small class="text-muted d-block text-truncate">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $inv->wedding_date ? \Carbon\Carbon::parse($inv->wedding_date)->format('d M Y') : 'Tanggal belum ditentukan' }}
                                    </small>
                                    @if(auth()->user()->id === $inv->partner_user_id && $inv->partner_accepted_at)
                                        <small class="text-muted d-block">
                                            <i class="bi bi-person-heart me-1"></i>
                                            Sebagai pasangan
                                            @if($inv->partner_can_edit)
                                                <span class="badge bg-success-subtle text-success ms-1">Dapat mengedit</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning ms-1">Hanya melihat</span>
                                            @endif
                                        </small>
                                    @elseif(auth()->user()->id === $inv->partner_user_id && !$inv->partner_accepted_at)
                                        <small class="text-muted d-block">
                                            <i class="bi bi-clock me-1"></i>
                                            <span class="badge bg-warning-subtle text-warning">Menunggu penerimaan</span>
                                        </small>
                                    @endif
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex-shrink-0 d-flex align-items-center gap-2">
                                    <!-- Desktop -->
                                    <div class="d-none d-md-flex gap-2">
                                        <a href="{{ route('invitation.show', $inv->slug) }}" class="btn btn-outline-secondary btn-sm" target="_blank" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if(auth()->user()->id === $inv->user_id || (auth()->user()->id === $inv->partner_user_id && $inv->partner_accepted_at && $inv->partner_can_edit))
                                            <a href="{{ route('invitation.edit', $inv) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        @if(auth()->user()->id === $inv->partner_user_id && !$inv->partner_accepted_at)
                                            <button type="button" class="btn btn-outline-success btn-sm accept-partner-btn" title="Terima Undangan" data-url="{{ route('partner.accept-direct', $inv) }}">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        @endif
                                        @if(auth()->user()->isPaidSubscribed())
                                                <button type="button" class="btn btn-outline-success btn-icon-mobile" data-bs-toggle="modal" data-bs-target="#shareModalDynamic" data-id="{{ $inv->public_id }}" data-invitation-id="{{ $inv->id }}" title="Bagikan Undangan">
                                                    <i class="bi bi-share"></i>
                                                </button>
                                        @endif

                                        @if(auth()->user()->id === $inv->user_id && !$inv->is_default)
                                            <a href="{{ route('invitation.destroy.get', $inv) }}" class="btn btn-outline-danger btn-sm btn-delete-single" data-name="{{ $inv->groom_nickname ?? $inv->groom_name }} & {{ $inv->bride_nickname ?? $inv->bride_name }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Mobile -->
                                    <div class="dropdown d-md-none">
                                        <button class="btn btn-outline-secondary btn-icon-mobile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('invitation.show', $inv->slug) }}" target="_blank">
                                                    <i class="bi bi-eye me-2"></i> Lihat
                                                </a>
                                            </li>
                                            @if(auth()->user()->id === $inv->user_id || (auth()->user()->id === $inv->partner_user_id && $inv->partner_accepted_at && $inv->partner_can_edit))
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('invitation.edit', $inv) }}">
                                                        <i class="bi bi-pencil me-2"></i> Edit
                                                    </a>
                                                </li>
                                            @endif
                                            @if(auth()->user()->id === $inv->partner_user_id && !$inv->partner_accepted_at)
                                                <li>
                                                    <button type="button" class="dropdown-item text-success w-100 text-start accept-partner-btn" data-url="{{ route('partner.accept-direct', $inv) }}">
                                                        <i class="bi bi-check-lg me-2"></i> Terima Undangan
                                                    </button>
                                                </li>
                                            @endif
                                            <li>
                                                @if(auth()->user()->isPaidSubscribed())
                                                     <button type="button" class="dropdown-item text-success" data-bs-toggle="modal" data-bs-target="#shareModalDynamic" data-id="{{ $inv->public_id }}" data-invitation-id="{{ $inv->id }}">
                                                        <i class="bi bi-share me-2"></i> Bagikan
                                                    </button>
                                                @endif
                                            </li>
                                            @if(auth()->user()->id === $inv->user_id && !$inv->is_default)
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a href="{{ route('invitation.destroy.get', $inv) }}" class="dropdown-item text-danger w-100 text-start btn-delete-single" data-name="{{ $inv->groom_nickname ?? $inv->groom_name }} & {{ $inv->bride_nickname ?? $inv->bride_name }}">
                                                        <i class="bi bi-trash me-2"></i> Hapus
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-5 border-0">
                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                <h6 class="text-dark">Belum ada undangan yang dibuat</h6>
                                <p class="text-muted small mb-3">Mulai buat undangan pertamamu sekarang</p>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#newInvitationModal">
                                    <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                                </button>
                            </li>
                        @endforelse
                    </ul>
                </form>

            </div>
        </div>

        <!-- Hidden Divs untuk Menyimpan Template Pesan WhatsApp (Mencegah DOM bloat) -->
        @foreach ($invitations as $inv)
            <div id="wa-message-{{ $inv->public_id }}" class="d-none">
                @include('dashboard.invitation.pesan')
            </div>
        @endforeach

        <!-- Modal: New Invitation -->
        <div class="modal fade modal-theme-navy" id="newInvitationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.2);">
                    <form id="quickCreateForm" action="{{ route('invitation.quick-create') }}" method="POST">
                        @csrf
                        
                        <div class="modal-header text-center">
                            <h5 class="modal-title w-100 fw-bold">
                                <i class="bi bi-suit-heart-fill me-2" style="color: var(--adminuiux-theme-1, #C6A962);"></i> Bangun Mimpimu
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup" style="opacity: 0.8;"></button>
                        </div>

                        <div class="modal-body p-4 p-md-5">
                            <p class="text-muted small text-center mb-4" style="font-style: italic;">Mulai perjalanan indah Anda dengan mengisi data berikut.</p>

                            <div class="mb-4">
                                <h6 class="text-uppercase mb-3 d-flex align-items-center" style="color: var(--adminuiux-theme-2, #1B2A4A); font-weight: 700; letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="bi bi-gender-male me-2" style="font-size: 1.2rem; color: var(--adminuiux-theme-1, #C6A962);"></i> Mempelai Pria
                                </h6>
                                <div class="input-group mb-2">
                                    <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="groom_name" class="form-control border-start-0 py-2" placeholder="Nama lengkap" required style="border-radius: 0 10px 10px 0;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person-badge"></i>
                                    </span>
                                    <input type="text" name="groom_nickname" class="form-control border-start-0 py-2" placeholder="Nama panggilan (opsional)" style="border-radius: 0 10px 10px 0;">
                                </div>
                            </div>

                            <div class="text-center my-3">
                                <div style="display: inline-block; padding: 0 15px; margin-top: -25px; position: relative; z-index: 2; background-color: var(--bs-body-bg);">
                                    <i class="bi bi-suit-heart-fill" style="color: var(--adminuiux-theme-1, #C6A962); font-size: 1.4rem;"></i>
                                </div>
                                <hr style="margin-top: -12px; border-color: var(--adminuiux-theme-1, #C6A962); opacity: 0.3;">
                            </div>

                            <div class="mb-3">
                                <h6 class="text-uppercase mb-3 d-flex align-items-center" style="color: var(--adminuiux-theme-2, #1B2A4A); font-weight: 700; letter-spacing: 1px; font-size: 0.85rem;">
                                    <i class="bi bi-gender-female me-2" style="font-size: 1.2rem; color: var(--adminuiux-theme-1, #C6A962);"></i> Mempelai Wanita
                                </h6>
                                <div class="input-group mb-2">
                                    <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="bride_name" class="form-control border-start-0 py-2" placeholder="Nama lengkap" required style="border-radius: 0 10px 10px 0;">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text border-end-0" style="border-radius: 10px 0 0 10px;">
                                        <i class="bi bi-person-badge"></i>
                                    </span>
                                    <input type="text" name="bride_nickname" class="form-control border-start-0 py-2" placeholder="Nama panggilan (opsional)" style="border-radius: 0 10px 10px 0;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="hidden" name="template_id" id="modalTemplateId" value="">
                            </div>

                           

                            <div id="modal_error" class="alert alert-danger d-none mt-3" style="border-radius: 10px;"></div>
                        </div>

                        <div class="modal-footer d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-link text-decoration-none text-muted" data-bs-dismiss="modal" style="font-weight: 600;">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold shadow-sm" id="quickCreateBtn" style="border-radius: 50px; letter-spacing: 1px; font-size: 0.9rem;">
                                <i class="bi bi-stars me-1"></i> Buat Undangan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Upgrade to Premium -->
        <div class="modal fade" id="upgradeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title"><i class="bi bi-star me-2"></i> Upgrade ke Premium</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda telah mencapai batas maksimal <strong>1 undangan</strong> untuk akun gratis.</p>
                        <p>Upgrade ke berlangganan premium untuk membuat undangan tanpa batas dan mengakses fitur eksklusif lainnya.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Nanti</button>
                        <a href="{{ route('subscribe.page') }}" class="btn btn-warning text-white">
                            <i class="bi bi-star me-1"></i> Lihat Paket Premium
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Share Invitation -->
       @if(auth()->user()->isPaidSubscribed())
<div class="modal fade" id="shareModalDynamic" tabindex="-1" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            {{-- HEADER --}}
            <div class="modal-header bg-success text-white px-4">
                <div class="d-flex align-items-center gap-3">
                    <button
                        type="button"
                        class="btn btn-sm btn-outline-light"
                        id="toggleBukuTamu"
                        title="Buka Buku Tamu">
                        <i class="bi bi-people"></i>
                    </button>
                    <div>
                        <h5 class="modal-title fw-bold mb-1">
                            <i class="bi bi-whatsapp me-2"></i>
                            Bagikan Undangan
                        </h5>
                        <small class="opacity-75">
                            Pilih tamu dan bagikan undangan
                        </small>
                    </div>
                </div>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Tutup">
                </button>
            </div>

            <div class="modal-body p-0">
                <div class="d-flex position-relative" style="min-height: 400px;">

                    {{-- ========================= --}}
                    {{-- SIDEBAR: BUKU TAMU (OFF-CANVAS) --}}
                    {{-- ========================= --}}
                    <div
                        class="bg-light border-end position-absolute h-100"
                        id="bukuTamuSidebar"
                        style="width: 300px; left: -320px; transition: left 0.3s ease; z-index: 10; overflow-y: auto;">

                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">
                                    <i class="bi bi-people me-2"></i>Buku Tamu
                                </h6>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    id="closeBukuTamu">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="selectAllGuests">
                                    <label
                                        class="form-check-label small"
                                        for="selectAllGuests">
                                        Pilih Semua
                                    </label>
                                </div>
                                <a href="{{ route('invitation.import-kontak') }}" class="btn btn-sm btn-primary" title="Tambah tamu baru">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                            </div>

                            {{-- LIST TAMU --}}
                            <div
                                class="list-group"
                                id="savedGuestsList"
                                style="max-height: 300px; overflow-y: auto;">
                            </div>

                            {{-- TOMBOL BULK --}}
                            <button
                                type="button"
                                class="btn btn-sm btn-success mt-2 w-100"
                                id="bulkSendBtn"
                                style="display: none;">
                                <i class="bi bi-whatsapp me-1"></i>
                                Kirim ke Terpilih
                            </button>
                        </div>
                    </div>

                    {{-- ========================= --}}
                    {{-- KONTEN UTAMA --}}
                    {{-- ========================= --}}
                    <div class="flex-grow-1 p-4" id="mainContent">

                {{-- ========================= --}}
                {{-- ATAS: NAMA PENERIMA --}}
                {{-- ========================= --}}
                <div class="mb-4">
                    <label for="recipientNameDynamic" class="form-label fw-semibold">
                        Nama Penerima / Keluarga
                    </label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="recipientNameDynamic"
                            placeholder="Nama penerima"
                            required
                        >
                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            id="pickContactBtn"
                            title="Pilih dari kontak HP">
                            <i class="bi bi-person-lines-fill"></i>
                        </button>
                    </div>
                    <div
                        id="contactUnsupported"
                        class="form-text text-warning"
                        style="display: none;">
                       
                    </div>
                </div>

                {{-- ========================= --}}
                {{-- PESAN UNDANGAN --}}
                {{-- ========================= --}}
                <div class="d-flex align-items-center mb-3">
                    <div class="me-2 text-primary">
                        <i class="bi bi-chat-text-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">Pesan Undangan</h6>
                        <small class="text-muted">
                            Pesan yang akan dikirim kepada penerima
                        </small>
                    </div>
                </div>

                <div class="form-floating mb-3">
                    <textarea
                        class="form-control"
                        id="shareMessageDynamic"
                        placeholder="Pesan undangan"
                        style="height: 220px"></textarea>
                    <label for="shareMessageDynamic">
                        Pesan Undangan
                    </label>
                </div>

                {{-- TOMBOL SHARE --}}
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-success" onclick="shareToWhatsApp()">
                        <i class="bi bi-whatsapp me-1"></i>WhatsApp
                    </button>
                    <button type="button" class="btn btn-primary" onclick="shareToFacebook()">
                        <i class="bi bi-facebook me-1"></i>Facebook
                    </button>
                    <button type="button" class="btn btn-info text-white" onclick="shareToTwitter()">
                        <i class="bi bi-twitter-x me-1"></i>Twitter
                    </button>
                    <button type="button" class="btn btn-primary" onclick="shareToTelegram()">
                        <i class="bi bi-telegram me-1"></i>Telegram
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="shareViaEmail()">
                        <i class="bi bi-envelope me-1"></i>Email
                    </button>
                    <button type="button" class="btn btn-outline-dark" onclick="copyInvitationLink()">
                        <i class="bi bi-link-45deg me-1"></i>Salin Tautan
                    </button>
                </div>

            </div>{{-- /main-content --}}

    </div>
</div>


            {{-- FOOTER --}}
            <div class="modal-footer bg-light px-4">

                <div class="me-auto small text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Data kontak tetap berada di perangkat Anda.
                </div>

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>
    </div>
</div>
@endif
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('selectAll');
            const deleteBtn = document.querySelector('.btn-bulk-delete');
            const itemCheckboxes = document.querySelectorAll('.bulk-checkbox');
            const selectedCountSpan = document.getElementById('selectedCount');

            // Fungsi untuk update status tombol hapus
            function updateDeleteButton() {
                const checkedCount = document.querySelectorAll('.bulk-checkbox:checked').length;
                
                if (selectedCountSpan) {
                    selectedCountSpan.textContent = checkedCount;
                }

                // Aktifkan tombol jika ada minimal 1 yang diceklis
                if (checkedCount > 0) {
                    if (deleteBtn) deleteBtn.disabled = false;
                } else {
                    if (deleteBtn) deleteBtn.disabled = true;
                }
            }

            // Event saat "Pilih Semua" diklik
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateDeleteButton();
                });
            }

            // Event saat salah satu item di-check/uncheck
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Jika salah satu tidak diceklis, maka "Pilih Semua" jadi uncheck
                    if (!this.checked) {
                        if (selectAll) selectAll.checked = false;
                    } else {
                        // Jika semua diceklis, maka "Pilih Semua" ikut terceklik
                        const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                        if (allChecked && selectAll) selectAll.checked = true;
                    }
                    updateDeleteButton();
                });
            });

            // Validasi sebelum form disubmit
            const bulkForm = document.getElementById('bulkDeleteForm');
            if (bulkForm) {
                bulkForm.addEventListener('submit', function(e) {
                    const checkedCount = document.querySelectorAll('.bulk-checkbox:checked').length;
                    if (checkedCount === 0) {
                        e.preventDefault();
                        alert('Silakan pilih minimal satu undangan untuk dihapus.');
                    } else {
                        if (!confirm(`Apakah Anda yakin ingin menghapus ${checkedCount} undangan terpilih?`)) {
                            e.preventDefault();
                        }
                    }
                });
            }
        });
    </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Auto-open modal jika ada template_id di query string
                const urlParams = new URLSearchParams(window.location.search);
                const templateId = urlParams.get('template_id');
                if (templateId) {
                    const hiddenInput = document.getElementById('modalTemplateId');
                    if (hiddenInput) {
                        hiddenInput.value = templateId;
                    }
                    const modalEl = document.getElementById('newInvitationModal');
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();

                    // Bersihkan URL tanpa reload
                    window.history.replaceState({}, document.title, '/home');
                }

                // Handle Quick Create Form
                const quickCreateForm = document.getElementById('quickCreateForm');
                if (quickCreateForm) {
                    quickCreateForm.addEventListener('submit', async function (e) {
                        e.preventDefault();
                        const errorDiv = document.getElementById('modal_error');
                        errorDiv.classList.add('d-none');
                        errorDiv.innerHTML = '';
                        const formData = new FormData(this);

                        try {
                            const response = await fetch(this.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                },
                                body: formData,
                            });

                            const result = await response.json();

                            if (!response.ok) {
                                let errorMsg = result.message || 'Terjadi kesalahan.';
                                if (result.errors) {
                                    errorMsg += '<br><ul class="mb-0">' + Object.values(result.errors).map(function (e) { return '<li>' + e[0] + '</li>'; }).join('') + '</ul>';
                                }
                                errorDiv.innerHTML = errorMsg;
                                errorDiv.classList.remove('d-none');
                                return;
                            }

                            const modalEl = document.getElementById('newInvitationModal');
                            const modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: result.message || 'Undangan berhasil dibuat.',
                                confirmButtonColor: '#C6A962', // Gold theme
                                timer: 1500,
                                showConfirmButton: false,
                            }).then(function () {
                                window.location.href = result.redirect_url || '/home';
                            });

                        } catch (error) {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat membuat undangan.',
                                confirmButtonColor: '#C6A962',
                            });
                        }
                    });
                }

                // Handle Dynamic Share Modal
                const shareModal = document.getElementById('shareModalDynamic');
                if (shareModal) {
                    shareModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget;
                        const invId = button.getAttribute('data-id');
                        const messageDiv = document.getElementById('wa-message-' + invId);
                        
                        const messageInput = document.getElementById('shareMessageDynamic');
                        const recipientInput = document.getElementById('recipientNameDynamic');
                        
                        if (messageDiv) {
                            messageInput.value = messageDiv.textContent.trim();
                        }
                        recipientInput.value = '';
                    });
                }

                // Contact Picker API
                const pickContactBtn = document.getElementById('pickContactBtn');
                const contactUnsupported = document.getElementById('contactUnsupported');
                const recipientNameDynamic = document.getElementById('recipientNameDynamic');

                if (pickContactBtn) {
                    if ('contacts' in navigator) {
                        pickContactBtn.addEventListener('click', async () => {
                            try {
                                const contacts = await navigator.contacts.select(['name', 'tel'], {
                                    multiple: false,
                                });

                                if (contacts && contacts.length > 0) {
                                    const contact = contacts[0];
                                    const fullName = [
                                        contact.name[0] || '',
                                        contact.name[1] || '',
                                    ].filter(Boolean).join(' ');
                                    if (fullName && recipientNameDynamic) {
                                        recipientNameDynamic.value = fullName;
                                    }
                                }
                            } catch (err) {
                                if (err.name !== 'AbortError') {
                                    console.error('Contact Picker error:', err);
                                }
                            }
                        });
                    } else {
                        pickContactBtn.disabled = true;
                        pickContactBtn.classList.add('disabled');
                        if (contactUnsupported) contactUnsupported.style.display = 'block';
                    }
                }

                // Bulk Send to Saved Guests
                const savedGuestsList = document.getElementById('savedGuestsList');
                const selectAllGuests = document.getElementById('selectAllGuests');
                const bulkSendBtn = document.getElementById('bulkSendBtn');
                const guestCountBadge = document.getElementById('guestCountBadge');
                const bukuTamuSidebar = document.getElementById('bukuTamuSidebar');
                const toggleBukuTamu = document.getElementById('toggleBukuTamu');
                const closeBukuTamu = document.getElementById('closeBukuTamu');

                if (toggleBukuTamu) {
                    toggleBukuTamu.addEventListener('click', () => {
                        if (bukuTamuSidebar) {
                            const isHidden = bukuTamuSidebar.style.left === '-320px' || !bukuTamuSidebar.style.left;
                            bukuTamuSidebar.style.left = isHidden ? '0' : '-320px';
                        }
                    });
                }

                if (closeBukuTamu) {
                    closeBukuTamu.addEventListener('click', () => {
                        if (bukuTamuSidebar) {
                            bukuTamuSidebar.style.left = '-320px';
                        }
                    });
                }

                shareModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const publicId = button.getAttribute('data-id');

                    const messageDiv = document.getElementById('wa-message-' + publicId);
                    const messageInput = document.getElementById('shareMessageDynamic');
                    const recipientInput = document.getElementById('recipientNameDynamic');

                    if (messageDiv) {
                        messageInput.value = messageDiv.textContent.trim();
                    }
                    recipientInput.value = '';

                    loadSavedGuests();
                });

                function loadSavedGuests() {
                    if (!savedGuestsList) return;

                    savedGuestsList.innerHTML = '<div class="text-center py-2"><small class="text-muted">Memuat...</small></div>';

                    fetch('/invitation/import-kontak/guests')
                        .then(res => res.json())
                        .then(data => {
                            if (data.guests && data.guests.length > 0) {
                                if (guestCountBadge) guestCountBadge.textContent = data.guests.length;
                                savedGuestsList.innerHTML = '';
                                data.guests.forEach(guest => {
                                    const item = document.createElement('div');
                                    item.className = 'list-group-item d-flex align-items-center justify-content-between py-2';
                                    item.innerHTML = `
                                        <div class="d-flex align-items-center gap-2">
                                            <input class="form-check-input guest-checkbox" type="checkbox" value="${guest.id}" data-name="${guest.name}" data-phone="${guest.phone}">
                                            <div>
                                                <div class="small fw-semibold">${guest.name}</div>
                                                <div class="small text-muted">${guest.phone}</div>
                                            </div>
                                        </div>
                                    `;
                                    savedGuestsList.appendChild(item);
                                });
                                bindGuestCheckboxes();
                            } else {
                                if (guestCountBadge) guestCountBadge.textContent = '0';
                                savedGuestsList.innerHTML = '<div class="text-center py-3"><small class="text-muted">Belum ada kontak tersimpan</small></div>';
                                if (bulkSendBtn) bulkSendBtn.style.display = 'none';
                            }
                        })
                        .catch(err => {
                            console.error('Load guests error:', err);
                            savedGuestsList.innerHTML = '<div class="text-center py-2"><small class="text-danger">Gagal memuat kontak</small></div>';
                        });
                }

                function bindGuestCheckboxes() {
                    const checkboxes = savedGuestsList.querySelectorAll('.guest-checkbox');
                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', updateBulkButton);
                    });
                }

                function updateBulkButton() {
                    const checked = savedGuestsList.querySelectorAll('.guest-checkbox:checked');
                    if (bulkSendBtn) {
                        bulkSendBtn.style.display = checked.length > 0 ? 'block' : 'none';
                    }
                    if (selectAllGuests) {
                        const allCheckboxes = savedGuestsList.querySelectorAll('.guest-checkbox');
                        selectAllGuests.checked = allCheckboxes.length > 0 && checked.length === allCheckboxes.length;
                    }
                }

                if (selectAllGuests) {
                    selectAllGuests.addEventListener('change', function () {
                        const checkboxes = savedGuestsList.querySelectorAll('.guest-checkbox');
                        checkboxes.forEach(cb => {
                            cb.checked = this.checked;
                        });
                        updateBulkButton();
                    });
                }

                if (bulkSendBtn) {
                    bulkSendBtn.addEventListener('click', () => {
                        const checked = savedGuestsList.querySelectorAll('.guest-checkbox:checked');
                        if (checked.length === 0) return;

                        const messageInput = document.getElementById('shareMessageDynamic');
                        const template = messageInput.value || 'Halo [nama], undangan untuk Anda:\n\n{link}\n\nTerima kasih!';

                        const selectedGuests = [];
                        checked.forEach(cb => {
                            selectedGuests.push({
                                name: cb.dataset.name,
                                phone: cb.dataset.phone,
                            });
                        });

                        if (!confirm(`Kirim WhatsApp ke ${selectedGuests.length} kontak?\n\nWhatsApp akan terbuka satu per satu.`)) return;

                        let delay = 0;
                        selectedGuests.forEach((guest) => {
                            const message = template.replace(/\[nama\]/g, guest.name);
                            const phone = guest.phone.replace(/[^0-9]/g, '');
                            const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;

                            setTimeout(() => {
                                window.open(url, '_blank');
                            }, delay);

                            delay += 1500;
                        });
                    });
                }

                // Handle Select All Checkbox
                const selectAll = document.getElementById('selectAll');
                if(selectAll) {
                    selectAll.addEventListener('change', function() {
                        document.querySelectorAll('.bulk-checkbox').forEach(cb => {
                            cb.checked = this.checked;
                        });
                    });
                }

                // Handle Delete Confirmation (Swal2)
                document.querySelectorAll('.delete-invitation-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Hapus undangan ini?',
                            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            });

            function getShareData() {
                const recipientInput = document.getElementById('recipientNameDynamic');
                const recipient = recipientInput.value.trim();
                if (!recipient) {
                    recipientInput.focus();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Penerima wajib diisi',
                        text: 'Masukkan nama penerima terlebih dahulu sebelum membagikan undangan.',
                        confirmButtonColor: '#C6A962'
                    });
                    return null;
                }
                let message = document.getElementById('shareMessageDynamic').value;
                message = message.replace(/\[nama\]/g, recipient);
                message = message.replace(/(\?penerima=)([^&\n]+)/g, function(match, prefix, value) {
                    return prefix + encodeURIComponent(value.trim());
                });
                return { recipient, message };
            }

            function getInvitationUrl() {
                const invitation = @json($invitations->first());
                const recipient = document.getElementById('recipientNameDynamic').value.trim();
                if (invitation && invitation.slug) {
                    let url = @json(url('/')) + '/' + invitation.slug;
                    if (recipient) {
                        url += '?penerima=' + encodeURIComponent(recipient);
                    }
                    return url;
                }
                return window.location.href;
            }

            function shareToWhatsApp() {
                const data = getShareData();
                if (!data) return;
                const { message } = data;
                const url = "https://wa.me/?text=" + encodeURIComponent(message);
                window.open(url, '_blank');
            }

            function shareToFacebook() {
                const data = getShareData();
                if (!data) return;
                const { message } = data;
                const url = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(getInvitationUrl());
                window.open(url, '_blank');
            }

            function shareToTwitter() {
                const data = getShareData();
                if (!data) return;
                const { message } = data;
                const url = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(message) + "&url=" + encodeURIComponent(getInvitationUrl());
                window.open(url, '_blank');
            }

            function shareToTelegram() {
                const data = getShareData();
                if (!data) return;
                const { message } = data;
                const url = "https://t.me/share/url?url=" + encodeURIComponent(getInvitationUrl()) + "&text=" + encodeURIComponent(message);
                window.open(url, '_blank');
            }

            function shareViaEmail() {
                const data = getShareData();
                if (!data) return;
                const { message } = data;
                const subject = "Undangan Pernikahan";
                const body = message;
                const url = "mailto:?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(body);
                window.location.href = url;
            }

            function copyInvitationLink() {
                const data = getShareData();
                if (!data) return;
                const url = getInvitationUrl();
                navigator.clipboard.writeText(url).then(function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: 'Tautan undangan berhasil disalin.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }).catch(function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menyalin tautan.',
                    });
                });
            }

            // Accept Partner Direct
            document.querySelectorAll('.accept-partner-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    const btn = this;
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal menerima undangan.');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
                        }
                    })
                    .catch(err => {
                        alert('Terjadi kesalahan. Coba lagi.');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-check-lg"></i>';
                    });
                });
            });

            // SweetAlert confirm for single delete
            document.querySelectorAll('.btn-delete-single').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    const name = this.getAttribute('data-name') || 'undangan ini';
                    Swal.fire({
                        title: 'Hapus undangan?',
                        text: "Anda akan menghapus: " + name + ". Data yang sudah dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    });
                });
            });

            // SweetAlert confirm for bulk delete
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            if (bulkDeleteForm) {
                const bulkDeleteBtn = bulkDeleteForm.querySelector('.btn-bulk-delete');
                if (bulkDeleteBtn) {
                    bulkDeleteBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const checked = bulkDeleteForm.querySelectorAll('.bulk-checkbox:checked');
                        if (checked.length === 0) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Tidak ada yang dipilih',
                                text: 'Pilih minimal satu undangan untuk dihapus.',
                                confirmButtonColor: '#C6A962'
                            });
                            return;
                        }
                        Swal.fire({
                            title: 'Hapus undangan yang dipilih?',
                            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, hapus semua!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                bulkDeleteForm.submit();
                            }
                        });
                    });
                }
            }

            // Auto-open create modal for new users with no invitations
            const invitationsList = document.querySelector('.list-group');
            if (invitationsList && invitationsList.querySelector('.list-group-item.text-center')) {
                const newInvitationModal = document.getElementById('newInvitationModal');
                if (newInvitationModal) {
                    const modal = new bootstrap.Modal(newInvitationModal);
                    modal.show();
                }
            }
        </script>
    </div>
</x-app-layout>
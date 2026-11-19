<x-app-layout>
    @php
        $firstInvitation = $invitations->first();
        $themeColor = $firstInvitation->theme_color ?? '#FF6B81';
    @endphp

    <style>
        :root {
            --mobile-nav-active-color:
                {{ $themeColor }}
            ;
        }

        .list-group-item {
            padding: 14px 16px;
            transition: background-color 0.2s ease;
        }

        .info-text {
            min-width: 0;
            /* Penting agar flexbox text-truncate berfungsi */
        }

        .info-text h6 {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* Ukuran Touch Target yang Nyaman untuk Mobile */
        @media (max-width: 767.98px) {
            .list-group-item {
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
            }

            .dropdown-toggle.btn-icon-mobile {
                border-radius: 50%;
            }
        }

        @media (max-width: 575.98px) {
            .btn-icon-mobile {
                width: 40px;
                height: 40px;
            }
        }

        .btn-bulk-delete {
            width: auto !important;
            display: inline-flex !important;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .form-check {
            margin-bottom: 0 !important;
        }

        /* Modal Custom Styles */
        .modal-theme-navy .modal-header {
            background: linear-gradient(135deg, #1B2A4A 0%, #2A3F6A 100%);
            color: #fff;
            border-bottom: 2px solid var(--adminuiux-theme-1, #C6A962);
            padding: 1.25rem 1.5rem;
        }
        .modal-theme-navy .modal-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .modal-theme-navy .modal-body {
            background-color: var(--adminuiux-bg-2, #FFFFFF);
        }
        .modal-theme-navy .modal-footer {
            background-color: var(--adminuiux-bg-2, #FFFFFF);
            border-top: 1px solid var(--bs-border-color);
            padding: 1rem 1.5rem;
        }

        /* Category Card Selector */
        .category-option-card {
            border: 2px solid var(--bs-border-color);
            border-radius: 14px;
            background: var(--adminuiux-bg-1, #f8fafc);
            transition: all 0.25s ease;
            cursor: pointer;
            overflow: hidden;
        }
        .category-option-card:hover {
            border-color: rgba(198, 169, 98, 0.6);
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(198, 169, 98, 0.15);
        }
        .category-option-card.selected {
            border-color: var(--adminuiux-theme-1, #C6A962) !important;
            background: rgba(198, 169, 98, 0.06);
            box-shadow: 0 0 0 0.2rem rgba(198, 169, 98, 0.25) !important;
        }
    </style>

    <!-- TAB 1: Aktivitas Undangan -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="py-3 py-md-4">
            <div class="container-fluid">

                @php
                    $user = auth()->user();
                    $subscriptionStatus = $user->subscriptionStatus();
                    $canCreateMore = $user->isAdmin() || $user->isSubscribed() || $user->invitations->count() < 1;
                    $partnerOwner = $user->getPartnerSubscriptionOwner();
                    $publishedCount = $invitations->where('status', 'published')->count();
                    $draftCount = $invitations->where('status', 'draft')->count();
                @endphp

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h4 class="mb-0 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Pasangan & Undangan</h4>
                            @if($subscriptionStatus == 'active')
                                <span class="badge rounded-pill bg-warning text-dark small px-2 py-1">
                                    <i class="bi bi-star-fill me-1"></i> Premium
                                    @if(auth()->user()->isAdmin())
                                        (Admin Access)
                                    @elseif(auth()->user()->subscription)
                                        (Aktif s/d: {{ auth()->user()->subscription->end_date->format('d M Y') }})
                                    @endif
                                </span>
                            @else
                                <span class="badge rounded-pill bg-light text-dark border small px-2 py-1">Free Plan</span>
                            @endif
                        </div>
                        <p class="text-muted small mb-0">Kelola semua undangan pernikahan digital yang telah dibuat di sistem</p>
                    </div>

                    <div class="w-md-100 d-flex justify-content-md-end gap-2">
                        @if($canCreateMore)
                            <button type="button" class="btn btn-sm text-white px-3 py-2 rounded-3 fw-semibold shadow-sm w-100 w-md-auto"
                                    style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;"
                                    data-bs-toggle="modal" data-bs-target="#newInvitationModal">
                                <i class="bi bi-plus-circle-fill me-1"></i> Buat Undangan
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-warning w-100 w-md-auto rounded-3 fw-semibold shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#upgradeModal">
                                <i class="bi bi-star-fill me-1"></i> Upgrade ke Premium
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Card Kontainer --}}
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="card-header bg-transparent py-3 px-3 px-md-4 border-bottom d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-gem text-warning-emphasis fs-5"></i>
                            <h5 class="mb-0 fw-bold fs-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Semua Pasangan</h5>
                        </div>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-2 py-1 small">
                            Total: {{ $invitations->count() }}
                        </span>
                    </div>

                    <div class="card-body p-0">
                        <form id="bulkDeleteForm" action="{{ route('invitation.bulk-delete') }}" method="POST">
                            @csrf

                            @if($invitations->isNotEmpty())
                        <div class="d-flex flex-nowrap align-items-center justify-content-between w-100 mb-2 px-2 py-2 rounded border"
                            style="background-color: rgba(198, 169, 98, 0.1); border-color: rgba(198, 169, 98, 0.2) !important;">

                            {{-- Pilih Semua --}}
                            <div class="form-check mb-0 d-flex align-items-center">
                                <input class="form-check-input mt-0 me-2" type="checkbox" id="selectAll">

                                <label class="form-check-label small fw-bold text-nowrap" for="selectAll">
                                    Pilih Semua
                                </label>
                            </div>

                            {{-- Tombol Hapus --}}
                            <button type="submit" class="btn btn-danger btn-sm btn-bulk-delete ms-auto flex-shrink-0"
                                disabled>
                                <i class="bi bi-trash me-1"></i>
                                Hapus yang Dipilih
                            </button>

                        </div>
                    @endif

                    <ul class="list-group">
                        @forelse ($invitations as $inv)
                                            <li class="list-group-item d-flex align-items-center gap-3">
                                                <!-- Checkbox -->
                                                <input type="checkbox" name="ids[]" value="{{ $inv->public_id }}"
                                                    class="form-check-input flex-shrink-0 m-0 bulk-checkbox">

                                                <!-- Cover -->
                                                <div class="flex-shrink-0">
                                                    @if($inv->gallery_cover)
                                                        <img src="{{ storage_url_with_fallback($inv->gallery_cover, null, $inv->updated_at->timestamp) }}"
                                                            class="rounded object-fit-cover" style="width: 48px; height: 48px;" alt="Cover">
                                                    @else
                                                        <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 48px; height: 48px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Info -->
                                                <div class="flex-grow-1 min-w-0 info-text">

                                                    {{-- Nama Pasangan --}}
                                                    <div class="d-flex align-items-center gap-2 min-w-0 mb-1">
                                                        <h6 class="mb-0 fw-semibold text-body text-truncate invitation-title">
                                                            {{ $inv->groom_nickname ?? $inv->groom_name }}
                                                            <span class="text-muted fw-normal mx-1">&</span>
                                                            {{ $inv->bride_nickname ?? $inv->bride_name }}
                                                        </h6>
                                                    </div>

                                                    {{-- Tanggal --}}
                                                    <div class="d-flex align-items-center text-muted invitation-date mb-2">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        <span>
                                                            {{ $inv->wedding_date
                            ? \Carbon\Carbon::parse($inv->wedding_date)->format('d M Y')
                            : 'Tanggal belum ditentukan'
                                                    }}
                                                        </span>
                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="d-flex align-items-center gap-1 flex-wrap">

                                                        <x-status-badge :status="$inv->status" />

                                                        @if($inv->is_default)
                                                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                                                <i class="bi bi-star-fill me-1"></i>
                                                                Default
                                                            </span>
                                                        @endif

                                                    </div>

                                                </div>

                                                <!-- Tombol Aksi -->
                                                <div class="flex-shrink-0 d-flex align-items-center gap-2">
                                                    <!-- Desktop -->
                                                    <div class="d-none d-md-flex gap-2">
                                                        <a href="{{ route('invitation.show', $inv->slug) }}"
                                                            class="btn btn-outline-primary btn-sm" target="_blank" title="Lihat">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="{{ route('invitation.edit', $inv) }}"
                                                            class="btn btn-outline-primary btn-sm" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        @if(auth()->user()->isPaidSubscribed())
                                                            <button type="button" class="btn btn-outline-success btn-icon-mobile" data-bs-toggle="modal"
                                                                data-bs-target="#shareModalDynamic" data-id="{{ $inv->public_id }}"
                                                                title="Bagikan Undangan">
                                                                <i class="bi bi-share"></i>
                                                            </button>
                                                        @endif

                                                        @if(!$inv->is_default)
                                                            <a href="{{ route('invitation.destroy.get', $inv) }}"
                                                                class="btn btn-outline-danger btn-sm btn-delete-single"
                                                                data-name="{{ $inv->groom_nickname ?? $inv->groom_name }} & {{ $inv->bride_nickname ?? $inv->bride_name }}"
                                                                title="Hapus">
                                                                <i class="bi bi-trash"></i>
                                                            </a>
                                                        @endif
                                                    </div>

                                                    <!-- MOBILE -->
                                                    <div class="dropdown d-md-none">
                                                        <button class="btn btn-outline-secondary btn-icon-mobile" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('invitation.show', $inv->slug) }}"
                                                                    target="_blank">
                                                                    <i class="bi bi-eye me-2"></i> Lihat
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('invitation.edit', $inv) }}">
                                                                    <i class="bi bi-pencil me-2"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                @if(auth()->user()->isPaidSubscribed())
                                                                    <button type="button" class="dropdown-item text-success"
                                                                        data-bs-toggle="modal" data-bs-target="#shareModalDynamic"
                                                                        data-id="{{ $inv->public_id }}">
                                                                        <i class="bi bi-share me-2"></i> Bagikan
                                                                    </button>
                                                                @endif
                                                            </li>
                                                            @if(!$inv->is_default)
                                                                <li>
                                                                    <hr class="dropdown-divider">
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('invitation.destroy.get', $inv) }}"
                                                                        class="dropdown-item text-danger w-100 text-start btn-delete-single"
                                                                        data-name="{{ $inv->groom_nickname ?? $inv->groom_name }} & {{ $inv->bride_nickname ?? $inv->bride_name }}">
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
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#newInvitationModal">
                                    <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                                </button>
                            </li>
                        @endforelse
                    </ul>
                </form>
            </div>
        </div>

    </div>
</div>

        <!-- Hidden Divs untuk Menyimpan Template Pesan WhatsApp (Mencegah DOM bloat) -->
        @foreach ($invitations as $inv)
            <div id="wa-message-{{ $inv->public_id }}" class="d-none">
                @include('dashboard.invitation.pesan')
            </div>
        @endforeach

        <!-- Modal: New Invitation (Category -> Form) -->
        <div class="modal fade modal-theme-navy" id="newInvitationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                    <form id="quickCreateForm" action="{{ route('invitation.quick-create') }}" method="POST">
                        @csrf

                        <div class="modal-header d-flex align-items-center justify-content-between px-4 py-3">
                            <h5 class="modal-title mb-0 d-flex align-items-center gap-2" id="modalStepTitle">
                                <i class="bi bi-suit-heart-fill" style="color: var(--gold-primary, #C6A962);"></i>
                                <span>Pilih Kategori Undangan</span>
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body p-4 p-md-4" style="max-height: 72vh; overflow-y: auto;">

                            {{-- Step 1: Category Selection --}}
                            <div id="modalStepCategory" class="modal-step active">
                                <div class="text-center mb-4">
                                    <h6 class="fw-bold mb-1">Mulai Perjalanan Undangan Anda</h6>
                                    <p class="text-muted small mb-0">Pilih jenis momen atau acara yang ingin Anda rayakan:</p>
                                </div>

                                <div class="row g-3" id="homeCategorySelector">
                                    @php
                                        $homeCategories = App\Models\Category::active()->ordered()->withCount(['templates as template_count' => function ($q) {
                                            $q->where('is_active', true);
                                        }])->get();
                                    @endphp
                                    @foreach($homeCategories as $category)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="category-option category-option-card h-100 p-3 text-center d-flex flex-column align-items-center justify-content-between"
                                             data-category-id="{{ $category->id }}"
                                             onclick="homeSelectCategory(this, {{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->template_count }})">
                                            <div class="rounded-3 d-flex align-items-center justify-content-center mb-2"
                                                 style="width: 60px; height: 60px; background: rgba(198, 169, 98, 0.12);">
                                                @if($category->thumbnail_url)
                                                    <img src="{{ $category->thumbnail_url }}" alt="{{ $category->name }}" style="max-width: 44px; max-height: 44px; object-fit: contain;">
                                                @else
                                                    <i class="bi {{ $category->icon ?? 'bi-folder' }} fs-3" style="color: #A68B4B;"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-1 small text-dark">{{ ucfirst($category->name) }}</h6>
                                                <span class="badge bg-light text-muted border" style="font-size: 0.68rem;">
                                                    {{ $category->template_count }} Template
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="home_category_id" name="category_id">
                            </div>

                            {{-- Step 2: Form Fields --}}
                            <div id="modalStepForm" class="modal-step d-none">
                                <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark" id="homeFormTitle">Data Undangan</h6>
                                        <small class="text-muted" id="homeFormSubtitle">Lengkapi informasi dasar untuk undangan Anda</small>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="homeGoToStep('category')">
                                        <i class="bi bi-arrow-left me-1"></i> Ganti Kategori
                                    </button>
                                </div>

                                {{-- Wedding fields --}}
                                <div id="homeFormWedding" class="d-none">
                                    {{-- Mempelai Pria --}}
                                    <div class="mb-4 p-3 rounded-3" style="background: rgba(198, 169, 98, 0.05); border: 1px solid rgba(198, 169, 98, 0.2);">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                                 style="width: 28px; height: 28px; background: #C6A962; color: #fff;">
                                                <i class="bi bi-gender-male"></i>
                                            </div>
                                            <h6 class="fw-bold mb-0 text-dark text-uppercase small" style="letter-spacing: 0.5px;">Mempelai Pria</h6>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-12 col-md-7">
                                                <label class="form-label small fw-semibold mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                    <input type="text" name="groom_name" id="wedding_groom_name" class="form-control" placeholder="Contoh: Raden Surya" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label class="form-label small fw-semibold mb-1">Nama Panggilan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                                    <input type="text" name="groom_nickname" id="wedding_groom_nickname" class="form-control" placeholder="Surya">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Heart Divider --}}
                                    <div class="text-center my-3 position-relative">
                                        <hr class="my-0" style="border-color: rgba(198, 169, 98, 0.4);">
                                        <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-gold"
                                              style="font-size: 1.2rem; background-color: var(--adminuiux-bg-2, #FFFFFF) !important;">
                                            <i class="bi bi-suit-heart-fill"></i>
                                        </span>
                                    </div>

                                    {{-- Mempelai Wanita --}}
                                    <div class="mb-3 p-3 rounded-3" style="background: rgba(198, 169, 98, 0.05); border: 1px solid rgba(198, 169, 98, 0.2);">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                                 style="width: 28px; height: 28px; background: #C6A962; color: #fff;">
                                                <i class="bi bi-gender-female"></i>
                                            </div>
                                            <h6 class="fw-bold mb-0 text-dark text-uppercase small" style="letter-spacing: 0.5px;">Mempelai Wanita</h6>
                                        </div>

                                        <div class="row g-2">
                                            <div class="col-12 col-md-7">
                                                <label class="form-label small fw-semibold mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                                    <input type="text" name="bride_name" id="wedding_bride_name" class="form-control" placeholder="Contoh: Putri Ayuningtyas" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label class="form-label small fw-semibold mb-1">Nama Panggilan</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                                    <input type="text" name="bride_nickname" id="wedding_bride_nickname" class="form-control" placeholder="Putri">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Non-wedding generic fields --}}
                                <div id="homeFormGeneric" class="d-none">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nama Kegiatan / Acara <span class="text-danger">*</span></label>
                                        <input type="text" name="groom_name" id="generic_groom_name" class="form-control py-2" placeholder="Contoh: Perayaan Ulang Tahun, Seminar, dll" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Deskripsi Acara (opsional)</label>
                                        <textarea name="bride_name" id="generic_bride_name" class="form-control py-2" rows="3" placeholder="Tuliskan sekilas tentang acara Anda..." disabled></textarea>
                                        <div class="form-text small">Informasi ini akan ditampilkan pada pembuka undangan digital Anda.</div>
                                    </div>
                                </div>

                                <div id="home_form_error" class="alert alert-danger d-none mt-3 rounded-3"></div>
                            </div>

                        </div>

                        <div class="modal-footer d-flex justify-content-between align-items-center px-4 py-3">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" id="homeModalBackBtn" data-bs-dismiss="modal" style="display: none;">
                                Batal
                            </button>
                            <button type="submit" class="btn text-white rounded-pill px-4 py-2 fw-semibold shadow-sm ms-auto"
                                    id="homeQuickCreateBtn"
                                    style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;"
                                    disabled>
                                <i class="bi bi-stars me-1"></i> Buat Undangan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Upgrade to Premium -->
        <div class="modal fade" id="upgradeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                    <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #1B2A4A 0%, #2A3F6A 100%); border-bottom: 2px solid #C6A962;">
                        <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2 mb-0">
                            <i class="bi bi-star-fill text-gold" style="color: #C6A962;"></i>
                            <span>Upgrade ke Paket Premium</span>
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                             style="width: 72px; height: 72px; background: rgba(198, 169, 98, 0.15); color: #C6A962;">
                            <i class="bi bi-gem fs-1"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Buka Semua Potensi Momen Bahagiamu</h5>
                        <p class="text-muted small mb-4">
                            Akun gratis dibatasi maksimal 1 undangan. Dapatkan fitur tak terbatas dengan berlangganan:
                        </p>

                        <div class="text-start bg-light p-3 rounded-3 mb-4 border">
                            <div class="d-flex align-items-center gap-2 mb-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span class="fw-semibold">Buat Undangan Tanpa Batas</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Akses Semua Tema Eksklusif & Musik Latar</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Buku Tamu WhatsApp & Check-in QR</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 small">
                                <i class="bi bi-check-circle-fill text-success"></i>
                                <span>Bebas Watermark & Domain Kustom</span>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Nanti Saja</button>
                            <a href="{{ route('subscribe.page') }}" class="btn text-white rounded-pill px-4 fw-semibold shadow-sm"
                               style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;">
                                <i class="bi bi-rocket-takeoff me-1"></i> Lihat Paket Premium
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal: Share Invitation -->
        @if(auth()->user()->isPaidSubscribed())
            <div class="modal fade" id="shareModalDynamic" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title"><i class="bi bi-share me-2"></i> Bagikan Undangan</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="recipientNameDynamic"
                                    placeholder="Nama penerima" required>
                                <label for="recipientNameDynamic">Nama Penerima</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="shareMessageDynamic" placeholder="Pesan undangan"
                                    style="height: 180px"></textarea>
                                <label for="shareMessageDynamic">Pesan Undangan</label>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <button type="button" class="btn btn-success" onclick="shareToWhatsApp()">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </button>
                                <button type="button" class="btn btn-primary" onclick="shareToFacebook()">
                                    <i class="bi bi-facebook me-1"></i> Facebook
                                </button>
                                <button type="button" class="btn btn-info text-white" onclick="shareToTwitter()">
                                    <i class="bi bi-twitter-x me-1"></i> Twitter
                                </button>
                                <button type="button" class="btn btn-primary" onclick="shareToTelegram()">
                                    <i class="bi bi-telegram me-1"></i> Telegram
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="shareViaEmail()">
                                    <i class="bi bi-envelope me-1"></i> Email
                                </button>
                                <button type="button" class="btn btn-outline-dark" onclick="copyInvitationLink()">
                                    <i class="bi bi-link-45deg me-1"></i> Salin Tautan
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // ===== New Invitation Modal: Category -> Form =====
                const homeModalEl = document.getElementById('newInvitationModal');
                const homeFormTitle = document.getElementById('homeFormTitle');
                const homeFormSubtitle = document.getElementById('homeFormSubtitle');
                const homeFormWedding = document.getElementById('homeFormWedding');
                const homeFormGeneric = document.getElementById('homeFormGeneric');
                const homeQuickCreateBtn = document.getElementById('homeQuickCreateBtn');
                const homeModalBackBtn = document.getElementById('homeModalBackBtn');
                const homeModalStepTitle = document.getElementById('modalStepTitle');

                let homeSelectedCategoryId = null;

                function homeGoToStep(step) {
                    document.querySelectorAll('#newInvitationModal .modal-step').forEach(s => s.classList.add('d-none'));
                    const targetStep = document.getElementById('modalStep' + step.charAt(0).toUpperCase() + step.slice(1));
                    if (targetStep) targetStep.classList.remove('d-none');

                    if (step === 'category') {
                        if (homeModalStepTitle) homeModalStepTitle.innerHTML = '<i class="bi bi-suit-heart-fill me-2" style="color: var(--gold-primary, #C6A962);"></i> Pilih Kategori Undangan';
                        if (homeQuickCreateBtn) homeQuickCreateBtn.disabled = true;
                        if (homeModalBackBtn) homeModalBackBtn.style.display = 'none';
                    } else if (step === 'form') {
                        if (homeModalStepTitle) homeModalStepTitle.innerHTML = '<i class="bi bi-pencil-square me-2" style="color: var(--gold-primary, #C6A962);"></i> Isi Data Undangan';
                        if (homeModalBackBtn) homeModalBackBtn.style.display = 'inline-block';
                        homeValidateForm();
                    }
                }

                function homeSelectCategory(card, categoryId, categoryName, templateCount) {
                    document.querySelectorAll('#homeCategorySelector .category-option').forEach(c => {
                        c.classList.remove('selected');
                        c.style.borderColor = '';
                        c.style.boxShadow = '';
                    });
                    card.classList.add('selected');
                    const catIdInput = document.getElementById('home_category_id');
                    if (catIdInput) catIdInput.value = categoryId;
                    homeSelectedCategoryId = categoryId;

                    // Set form fields based on category
                    const catLower = (categoryName || '').toLowerCase();
                    if (homeFormTitle) homeFormTitle.textContent = categoryName ? 'Data ' + categoryName : 'Data Undangan';
                    if (homeFormSubtitle) homeFormSubtitle.textContent = 'Isi informasi undangan Anda sebelum dipublikasikan.';

                    const isWeddingLike = catLower.includes('wedding') || catLower.includes('engagement') || catLower.includes('nikah') || catLower.includes('pernikahan') || catLower.includes('lamaran');

                    if (isWeddingLike) {
                        if (homeFormWedding) homeFormWedding.classList.remove('d-none');
                        if (homeFormGeneric) homeFormGeneric.classList.add('d-none');

                        // Enable wedding inputs & set required
                        if (homeFormWedding) {
                            homeFormWedding.querySelectorAll('input').forEach(i => i.disabled = false);
                        }
                        const groomInput = document.getElementById('wedding_groom_name');
                        const brideInput = document.getElementById('wedding_bride_name');
                        if (groomInput) groomInput.required = true;
                        if (brideInput) brideInput.required = true;

                        // Disable generic inputs & remove required
                        if (homeFormGeneric) {
                            homeFormGeneric.querySelectorAll('input, textarea').forEach(i => {
                                i.disabled = true;
                                i.required = false;
                            });
                        }
                    } else {
                        if (homeFormGeneric) homeFormGeneric.classList.remove('d-none');
                        if (homeFormWedding) homeFormWedding.classList.add('d-none');

                        // Enable generic inputs & set required
                        if (homeFormGeneric) {
                            homeFormGeneric.querySelectorAll('input, textarea').forEach(i => i.disabled = false);
                        }
                        const genericGroom = document.getElementById('generic_groom_name');
                        if (genericGroom) genericGroom.required = true;

                        // Disable wedding inputs & remove required
                        if (homeFormWedding) {
                            homeFormWedding.querySelectorAll('input').forEach(i => {
                                i.disabled = true;
                                i.required = false;
                            });
                        }
                    }

                    homeGoToStep('form');
                    homeValidateForm();
                }

                function homeValidateForm() {
                    const categoryId = document.getElementById('home_category_id')?.value;
                    let formValid = false;

                    const stepForm = document.getElementById('modalStepForm');
                    if (stepForm && !stepForm.classList.contains('d-none')) {
                        // Cek hanya field yang aktif/terlihat
                        if (homeFormWedding && !homeFormWedding.classList.contains('d-none')) {
                            const groomVal = document.getElementById('wedding_groom_name')?.value.trim();
                            const brideVal = document.getElementById('wedding_bride_name')?.value.trim();
                            formValid = !!(groomVal && brideVal);
                        } else {
                            const eventName = document.getElementById('generic_groom_name')?.value.trim();
                            formValid = !!eventName;
                        }
                    } else {
                        formValid = !!categoryId;
                    }

                    if (homeQuickCreateBtn) {
                        homeQuickCreateBtn.disabled = !formValid;
                    }
                }

                // Pasang event listener ke seluruh input form
                document.querySelectorAll('#modalStepForm input, #modalStepForm textarea').forEach(el => {
                    el.addEventListener('input', homeValidateForm);
                    el.addEventListener('change', homeValidateForm);
                    el.addEventListener('keyup', homeValidateForm);
                });

                // Reset modal state when hidden
                if (homeModalEl) {
                    homeModalEl.addEventListener('hidden.bs.modal', function () {
                        document.querySelectorAll('#newInvitationModal .modal-step').forEach(s => s.classList.add('d-none'));
                        const stepCat = document.getElementById('modalStepCategory');
                        if (stepCat) stepCat.classList.remove('d-none');
                        if (homeModalStepTitle) homeModalStepTitle.innerHTML = '<i class="bi bi-suit-heart-fill me-2" style="color: var(--gold-primary, #C6A962);"></i> Pilih Kategori Undangan';
                        if (homeQuickCreateBtn) homeQuickCreateBtn.disabled = true;
                        if (homeModalBackBtn) homeModalBackBtn.style.display = 'none';
                        homeSelectedCategoryId = null;
                        const catIdInput = document.getElementById('home_category_id');
                        if (catIdInput) catIdInput.value = '';
                        document.querySelectorAll('#homeCategorySelector .category-option').forEach(c => {
                            c.classList.remove('selected');
                            c.style.borderColor = '';
                            c.style.boxShadow = '';
                        });
                        const formInputs = document.querySelectorAll('#modalStepForm input, #modalStepForm textarea');
                        formInputs.forEach(i => i.value = '');
                        if (homeFormWedding) {
                            homeFormWedding.classList.add('d-none');
                            homeFormWedding.querySelectorAll('input').forEach(i => i.disabled = false);
                        }
                        if (homeFormGeneric) {
                            homeFormGeneric.classList.add('d-none');
                            homeFormGeneric.querySelectorAll('input, textarea').forEach(i => i.disabled = true);
                        }
                    });
                }

                // Expose handlers for inline onclick in template
                window.homeSelectCategory = homeSelectCategory;
                window.homeGoToStep = homeGoToStep;

                // Handle Quick Create Form Submission
                const quickCreateForm = document.getElementById('quickCreateForm');
                if (quickCreateForm) {
                    quickCreateForm.addEventListener('submit', function (e) {
                        e.preventDefault();
                        const errorDiv = document.getElementById('home_form_error') || document.getElementById('modal_error');
                        if (errorDiv) {
                            errorDiv.classList.add('d-none');
                            errorDiv.innerHTML = '';
                        }
                        const btn = document.getElementById('homeQuickCreateBtn') || document.getElementById('quickCreateBtn');
                        if (btn) {
                            btn.disabled = true;
                            btn.innerHTML = '<i class="bi bi-arrow-repeat spin me-1"></i> Memproses...';
                        }

                        const formData = new FormData(this);

                        fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            },
                            body: formData
                        })
                        .then(function (response) {
                            if (response.status === 422) {
                                return response.json().then(function (data) {
                                    throw data;
                                });
                            }
                            if (!response.ok) {
                                return response.json().then(function (data) {
                                    throw data;
                                }).catch(function () {
                                    throw { message: 'Terjadi kesalahan saat membuat undangan.' };
                                });
                            }
                            return response.json();
                        })
                        .then(function (data) {
                            if (btn) {
                                btn.innerHTML = '<i class="bi bi-check2 me-1"></i> Berhasil';
                            }
                            setTimeout(function () {
                                const modalEl = document.getElementById('newInvitationModal');
                                if (modalEl) {
                                    const modal = bootstrap.Modal.getInstance(modalEl);
                                    if (modal) modal.hide();
                                }
                                window.location.href = data.redirect_url || data.redirect || window.location.href;
                            }, 800);
                        })
                        .catch(function (data) {
                            if (btn) {
                                btn.disabled = false;
                                btn.innerHTML = '<i class="bi bi-stars me-1"></i> Buat Undangan Sekarang';
                            }
                            if (data && data.errors) {
                                let firstMsg = '';
                                Object.keys(data.errors).some(function (key) {
                                    firstMsg = data.errors[key][0];
                                    return true;
                                });
                                if (errorDiv) {
                                    errorDiv.textContent = firstMsg || 'Periksa kembali data yang diinput.';
                                    errorDiv.classList.remove('d-none');
                                }
                            } else {
                                if (errorDiv) {
                                    errorDiv.textContent = (data && data.message) ? data.message : 'Terjadi kesalahan saat memproses.';
                                    errorDiv.classList.remove('d-none');
                                }
                            }
                        });
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

                // Handle Select All Checkbox
                const selectAll = document.getElementById('selectAll');
                if (selectAll) {
                    selectAll.addEventListener('change', function () {
                        document.querySelectorAll('.bulk-checkbox').forEach(cb => {
                            cb.checked = this.checked;
                        });
                        updateBulkDeleteButton();
                    });
                }

                function updateBulkDeleteButton() {
                    const checked = document.querySelectorAll('.bulk-checkbox:checked').length;
                    const bulkDeleteBtn = document.querySelector('.btn-bulk-delete');
                    if (bulkDeleteBtn) {
                        bulkDeleteBtn.disabled = checked === 0;
                    }
                }

                document.querySelectorAll('.bulk-checkbox').forEach(cb => {
                    cb.addEventListener('change', updateBulkDeleteButton);
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
                        confirmButtonColor: '#FF6B81'
                    });
                    return null;
                }
                let message = document.getElementById('shareMessageDynamic').value;
                message = message.replace(/\[nama\]/g, recipient);
                message = message.replace(/(\?penerima=)([^&\n]+)/g, function (match, prefix, value) {
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
                    alert('Tautan undangan berhasil disalin!');
                }).catch(function () {
                    alert('Gagal menyalin tautan.');
                });
            }

            // SweetAlert confirm for single delete
            document.querySelectorAll('.btn-delete-single').forEach(btn => {
                btn.addEventListener('click', function (e) {
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
                    bulkDeleteBtn.addEventListener('click', function (e) {
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
        </script>
    </div>
</x-app-layout>
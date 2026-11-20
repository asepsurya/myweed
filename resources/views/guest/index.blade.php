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
        .modal-theme-navy .modal-body,
        .modal-theme-navy .modal-footer {
            background-color: #FFFFFF !important;
        }
        .modal-theme-navy .modal-footer {
            border-top: 1px solid var(--bs-border-color);
            padding: 1rem 1.5rem;
        }
        [data-bs-theme="dark"] .modal-theme-navy .modal-body,
        [data-bs-theme="dark"] .modal-theme-navy .modal-footer {
            background-color: #1f2937 !important;
        }
        .modal-theme-navy .modal-content {
            background-color: #FFFFFF !important;
        }
        [data-bs-theme="dark"] .modal-theme-navy .modal-content {
            background-color: #1f2937 !important;
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

        /* Share Modal Styling */
        .share-channel-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.65rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            border: 1px solid transparent;
        }
        .share-channel-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
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
        <div class="py-3 py-md-4">
            <div class="container-fluid">

                @php
                    $user = auth()->user();
                    $subscriptionStatus = $user->subscriptionStatus();
                    $canCreateMore = $user->isAdmin() || $user->isSubscribed() || $user->invitations->count() < 1;
                    $partnerOwner = $user->getPartnerSubscriptionOwner();
                    $publishedCount = $invitations->where('status', 'published')->count();
                    $draftCount = $invitations->where('status', 'draft')->count();

                    $hour = (int) now()->format('H');
                    if ($hour >= 4 && $hour < 11) {
                        $greeting = 'Selamat Pagi';
                        $greetingIcon = 'bi-sunrise-fill';
                    } elseif ($hour >= 11 && $hour < 15) {
                        $greeting = 'Selamat Siang';
                        $greetingIcon = 'bi-sun-fill';
                    } elseif ($hour >= 15 && $hour < 18) {
                        $greeting = 'Selamat Sore';
                        $greetingIcon = 'bi-sunset-fill';
                    } else {
                        $greeting = 'Selamat Malam';
                        $greetingIcon = 'bi-moon-stars-fill';
                    }
                @endphp

                {{-- User Welcome & Subscription Hero --}}
                <div class="rounded-4 p-3 p-md-4 mb-4 text-white position-relative overflow-hidden shadow-sm"
                     style="background: linear-gradient(135deg, #1B2A4A 0%, #243B68 100%); border: 1px solid rgba(198, 169, 98, 0.25);">
                    <div class="row align-items-center g-3">
                        <div class="col-12 col-lg-8">
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0 text-white"
                                     style="width: 48px; height: 48px; background: rgba(255, 255, 255, 0.12); border: 1px solid rgba(255, 255, 255, 0.2); font-size: 1.35rem;">
                                    <i class="bi {{ $greetingIcon }} text-warning"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                        <h3 class="mb-0 fw-bold fs-5 text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                            {{ $greeting }}, {{ $user->name }}!
                                        </h3>

                                        @if($subscriptionStatus == 'active')
                                            <span class="badge rounded-pill bg-warning text-dark px-2 py-1 small">
                                                <i class="bi bi-star-fill me-1"></i> Premium
                                                @if($user->isAdmin())
                                                    (Admin)
                                                @elseif($user->subscription)
                                                    s/d {{ $user->subscription->end_date->format('d M Y') }}
                                                @endif
                                            </span>
                                            @if($partnerOwner)
                                                <span class="badge rounded-pill bg-info text-dark px-2 py-1 small">
                                                    <i class="bi bi-people me-1"></i> Bersama {{ $partnerOwner->name }}
                                                </span>
                                            @endif
                                        @else
                                            @if($partnerOwner)
                                                <span class="badge rounded-pill bg-info text-dark px-2 py-1 small">
                                                    <i class="bi bi-people me-1"></i> Bersama {{ $partnerOwner->name }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-light text-dark px-2 py-1 small">
                                                    Free Plan (Maks. 1 Undangan)
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                    <p class="mb-0 text-white-50 small">
                                        Kelola website undangan pernikahan dan pantau kehadiran tamu Anda di satu tempat.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 text-lg-end">
                            @if($canCreateMore)
                                <button type="button" class="btn btn-sm text-white px-3 py-2 rounded-3 fw-semibold shadow-sm w-100 w-lg-auto"
                                        style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;"
                                        data-bs-toggle="modal" data-bs-target="#newInvitationModal">
                                    <i class="bi bi-plus-circle-fill me-1"></i> Buat Undangan Baru
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-warning text-dark px-3 py-2 rounded-3 fw-semibold shadow-sm w-100 w-lg-auto"
                                        data-bs-toggle="modal" data-bs-target="#upgradeModal">
                                    <i class="bi bi-star-fill me-1"></i> Upgrade ke Premium
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Quick Summary Badges --}}
                    <div class="row g-2 mt-2 pt-3 border-top border-white border-opacity-10">
                        <div class="col-auto">
                            <span class="badge bg-white bg-opacity-10 text-white px-3 py-1 rounded-pill small">
                                <i class="bi bi-envelope-heart me-1 text-warning"></i> {{ $invitations->count() }} Total Undangan
                            </span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-white bg-opacity-10 text-white px-3 py-1 rounded-pill small">
                                <i class="bi bi-check-circle me-1 text-success"></i> {{ $publishedCount }} Sudah Terbit
                            </span>
                        </div>
                        @if($draftCount > 0)
                            <div class="col-auto">
                                <span class="badge bg-white bg-opacity-10 text-white px-3 py-1 rounded-pill small">
                                    <i class="bi bi-pencil-square me-1 text-info"></i> {{ $draftCount }} Draf
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Card Kontainer Daftar Undangan --}}
                <div class="card border-0 rounded-4 shadow-sm overflow-hidden mb-4" style="background-color: var(--bs-card-bg, #FFFFFF);">
                    <div class="card-header bg-transparent py-3 px-3 px-md-4 border-bottom d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-card-checklist fs-5 text-warning-emphasis"></i>
                            <h5 class="mb-0 fw-bold fs-6" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Undangan Saya</h5>
                        </div>
                        <span class="badge bg-secondary-subtle text-secondary-emphasis rounded-pill px-2 py-1 small">
                            {{ $invitations->count() }} Undangan
                        </span>
                    </div>

                    <div class="card-body p-0">
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

    </div>
</div>

        <!-- Hidden Divs untuk Menyimpan Template Pesan WhatsApp (Mencegah DOM bloat) -->
        @foreach ($invitations as $inv)
            <div id="wa-message-{{ $inv->public_id }}" class="d-none">
                @include('dashboard.invitation.pesan')
            </div>
        @endforeach
        <!-- Modal: New Invitation (Category -> Template -> Form) -->
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
                                                    {!! category_icon_html($category, 'fs-3', 'style="color: #A68B4B;"') !!}
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
                            <i class="bi bi-star-fill text-gold"></i>
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
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">

                    {{-- HEADER --}}
                    <div class="modal-header px-4 py-3" style="background: linear-gradient(135deg, #1B2A4A 0%, #2A3F6A 100%); border-bottom: 2px solid #C6A962; color: #fff;">
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn-sm btn-outline-light rounded-pill px-3" id="toggleBukuTamu" title="Buka/Tutup Buku Tamu">
                                <i class="bi bi-people me-1"></i> Buku Tamu
                            </button>
                            <div>
                                <h5 class="modal-title fw-bold mb-0 d-flex align-items-center gap-2">
                                    <i class="bi bi-share text-gold"></i>
                                    <span>Bagikan Undangan Digital</span>
                                </h5>
                                <small class="text-white-50" style="font-size: 0.78rem;">Pilih tamu atau kirim pesan undangan instan ke kerabat</small>
                            </div>
                        </div>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body p-0">
                        <div class="d-flex position-relative" style="min-height: 440px;">

                            {{-- SIDEBAR: BUKU TAMU --}}
                            <div class="bg-light border-end position-absolute h-100 shadow-sm" id="bukuTamuSidebar"
                                style="width: 320px; left: -340px; transition: left 0.3s ease; z-index: 10; overflow-y: auto;">
                                <div class="p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0 d-flex align-items-center gap-2">
                                            <i class="bi bi-people-fill text-gold"></i> Kontak Tersimpan
                                        </h6>
                                        <button type="button" class="btn btn-sm btn-light border rounded-circle" id="closeBukuTamu" style="width: 28px; height: 28px; padding: 0;">
                                            <i class="bi bi-x-lg small"></i>
                                        </button>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAllGuests">
                                            <label class="form-check-label small fw-semibold" for="selectAllGuests">Pilih Semua</label>
                                        </div>
                                        <a href="{{ route('invitation.import-kontak') }}" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5" title="Import Kontak">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah
                                        </a>
                                    </div>

                                    {{-- LIST TAMU --}}
                                    <div class="list-group rounded-3 shadow-none border" id="savedGuestsList" style="max-height: 320px; overflow-y: auto;"></div>
                                    <small class="text-muted mt-2 d-block" style="font-size: 0.75rem;">Centang kontak untuk langsung membuka percakapan WhatsApp.</small>
                                </div>
                            </div>

                            {{-- KONTEN UTAMA --}}
                            <div class="flex-grow-1 p-4" id="mainContent">
                                {{-- NAMA PENERIMA --}}
                                <div class="mb-4">
                                    <label for="recipientNameDynamic" class="form-label fw-bold small text-uppercase" style="letter-spacing: 0.5px;">
                                        Nama Penerima / Keluarga <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input type="text" class="form-control" id="recipientNameDynamic" placeholder="Masukkan nama tamu (misal: Bpk. Bambang & Keluarga)" required>
                                        <button type="button" class="btn btn-outline-secondary" id="pickContactBtn" title="Pilih dari kontak HP">
                                            <i class="bi bi-person-lines-fill me-1"></i> Kontak HP
                                        </button>
                                    </div>
                                    <div id="contactUnsupported" class="form-text text-muted small mt-1" style="display: none;">
                                        <i class="bi bi-info-circle me-1"></i>Fitur buku kontak didukung pada perangkat Android Chrome.
                                    </div>
                                </div>

                                {{-- PESAN UNDANGAN --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="shareMessageDynamic" class="form-label fw-bold small text-uppercase mb-0" style="letter-spacing: 0.5px;">
                                            Teks Pesan Undangan
                                        </label>
                                        <small class="text-muted">Kode <code class="text-gold">[nama]</code> otomatis disesuaikan</small>
                                    </div>
                                    <textarea class="form-control rounded-3" id="shareMessageDynamic" placeholder="Pesan undangan..." rows="7" style="font-size: 0.9rem; line-height: 1.5;"></textarea>
                                </div>

                                {{-- TOMBOL SHARE --}}
                                <div>
                                    <label class="form-label fw-bold small text-uppercase mb-2" style="letter-spacing: 0.5px;">Kirim Lewat Platform:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="share-channel-btn btn btn-success" onclick="shareToWhatsApp()">
                                            <i class="bi bi-whatsapp fs-6"></i> WhatsApp
                                        </button>
                                        <button type="button" class="share-channel-btn btn btn-primary" onclick="shareToFacebook()">
                                            <i class="bi bi-facebook fs-6"></i> Facebook
                                        </button>
                                        <button type="button" class="share-channel-btn btn btn-dark" onclick="shareToTwitter()">
                                            <i class="bi bi-twitter-x fs-6"></i> Twitter (X)
                                        </button>
                                        <button type="button" class="share-channel-btn btn btn-info text-white" onclick="shareToTelegram()">
                                            <i class="bi bi-telegram fs-6"></i> Telegram
                                        </button>
                                        <button type="button" class="share-channel-btn btn btn-secondary" onclick="shareViaEmail()">
                                            <i class="bi bi-envelope fs-6"></i> Email
                                        </button>
                                        <button type="button" class="share-channel-btn btn btn-outline-dark" onclick="copyInvitationLink()">
                                            <i class="bi bi-link-45deg fs-6"></i> Salin Tautan
                                        </button>
                                    </div>
                                </div>

                            </div>{{-- /main-content --}}

                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer px-4 py-3 d-flex justify-content-between align-items-center">
                        <div class="small text-muted">
                            <i class="bi bi-shield-check text-success me-1"></i> Data kontak diproses aman di peramban Anda.
                        </div>
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
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
                    const hiddenInput = document.getElementById('home_template_id_hidden');
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
                            if (data.errors) {
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
                                    errorDiv.textContent = data.message || 'Terjadi kesalahan saat memproses.';
                                    errorDiv.classList.remove('d-none');
                                }
                            }
                        });
                    });

                    const modalEl = document.getElementById('newInvitationModal');
                    modalEl.addEventListener('hidden.bs.modal', function () {
                        const btn = document.getElementById('homeQuickCreateBtn') || document.getElementById('quickCreateBtn');
                        const errorDiv = document.getElementById('home_form_error') || document.getElementById('modal_error');
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bi bi-stars me-1"></i> Buat Undangan';
                        }
                        if (errorDiv) {
                            errorDiv.classList.add('d-none');
                            errorDiv.textContent = '';
                        }
                        quickCreateForm.reset();
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

                                    if (recipientNameDynamic) {
                                        recipientNameDynamic.value = fullName;
                                    }

                                    const phone = ((contact.tel && contact.tel[0]) || '').replace(/[^0-9]/g, '');
                                    if (phone) {
                                        const messageInput = document.getElementById('shareMessageDynamic');
                                        let message = messageInput.value || 'Halo [nama], undangan untuk Anda.\n\nTerima kasih!';
                                        message = message.replace(/\[nama\]/g, fullName || '');
                                        window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(message), '_blank');
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
                        cb.addEventListener('change', function () {
                            if (this.checked) {
                                openWaToGuest(this);
                            }
                            updateBulkButton();
                        });
                    });
                }

                function openWaToGuest(cb) {
                    const messageInput = document.getElementById('shareMessageDynamic');
                    let message = messageInput.value || 'Halo [nama], undangan untuk Anda.\n\nTerima kasih!';
                    message = message.replace(/\[nama\]/g, cb.dataset.name || '');

                    const phone = (cb.dataset.phone || '').replace(/[^0-9]/g, '');
                    if (!phone) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Nomor tidak valid',
                            text: 'Kontak "' + (cb.dataset.name || '') + '" belum memiliki nomor WhatsApp.',
                            confirmButtonColor: '#C6A962'
                        });
                        cb.checked = false;
                        return;
                    }

                    // Isi nama penerima cukup dengan nama saja
                    const recipientInput = document.getElementById('recipientNameDynamic');
                    if (recipientInput) recipientInput.value = cb.dataset.name || '';

                    const url = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(message);
                    window.open(url, '_blank');
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

                // ===== Home New Invitation Modal: Category -> Template -> Form =====
                const homeModalEl = document.getElementById('newInvitationModal');
                const homeCategorySelector = document.getElementById('homeCategorySelector');
                const homeTemplateSelector = document.getElementById('homeTemplateSelector');
                const homeSelectedCategoryName = document.getElementById('homeSelectedCategoryName');
                const homeSelectedCategoryDesc = document.getElementById('homeSelectedCategoryDesc');
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
                    document.getElementById('modalStep' + step.charAt(0).toUpperCase() + step.slice(1)).classList.remove('d-none');

                    if (step === 'category') {
                        homeModalStepTitle.innerHTML = '<i class="bi bi-suit-heart-fill me-2" style="color: var(--gold-primary);"></i> Pilih Kategori';
                        homeQuickCreateBtn.disabled = true;
                        homeModalBackBtn.style.display = 'none';
                    } else if (step === 'form') {
                        homeModalStepTitle.innerHTML = '<i class="bi bi-pencil-square me-2"></i> Isi Data Undangan';
                        homeModalBackBtn.style.display = 'inline-block';
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
                    document.getElementById('home_category_id').value = categoryId;
                    homeSelectedCategoryId = categoryId;

                    // Set form fields based on category
                    const catLower = (categoryName || '').toLowerCase();
                    homeFormTitle.textContent = categoryName ? 'Data ' + categoryName : 'Data Undangan';
                    homeFormSubtitle.textContent = 'Isi informasi undangan Anda sebelum dipublikasikan.';

                    const isWeddingLike = catLower.includes('wedding') || catLower.includes('engagement') || catLower.includes('nikah') || catLower.includes('pernikahan') || catLower.includes('lamaran');

                    if (isWeddingLike) {
                        homeFormWedding.classList.remove('d-none');
                        homeFormGeneric.classList.add('d-none');

                        // Enable wedding inputs & set required
                        homeFormWedding.querySelectorAll('input').forEach(i => i.disabled = false);
                        const groomInput = document.getElementById('wedding_groom_name');
                        const brideInput = document.getElementById('wedding_bride_name');
                        if (groomInput) groomInput.required = true;
                        if (brideInput) brideInput.required = true;

                        // Disable generic inputs & remove required
                        homeFormGeneric.querySelectorAll('input, textarea').forEach(i => {
                            i.disabled = true;
                            i.required = false;
                        });
                    } else {
                        homeFormGeneric.classList.remove('d-none');
                        homeFormWedding.classList.add('d-none');

                        // Enable generic inputs & set required
                        homeFormGeneric.querySelectorAll('input, textarea').forEach(i => i.disabled = false);
                        const genericGroom = document.getElementById('generic_groom_name');
                        if (genericGroom) genericGroom.required = true;

                        // Disable wedding inputs & remove required
                        homeFormWedding.querySelectorAll('input').forEach(i => {
                            i.disabled = true;
                            i.required = false;
                        });
                    }

                    homeGoToStep('form');
                    homeValidateForm();
                }

                function homeSelectTemplateCard(card, templateId) {
                    document.querySelectorAll('#homeTemplateSelector .template-option').forEach(c => {
                        c.style.borderColor = '#ddd';
                        c.style.boxShadow = 'none';
                    });
                    card.style.borderColor = '#C6A962';
                    card.style.boxShadow = '0 0 0 0.25rem rgba(198, 169, 98, 0.25)';
                    document.getElementById('home_template_id_hidden').value = templateId;
                    homeSelectedTemplateId = templateId;

                    // Set form fields based on category
                    const catId = document.getElementById('home_category_id').value;
                    const isWedding = catId && document.querySelector('#homeCategorySelector .category-option[data-category-id="' + catId + '"]');
                    const catLabel = isWedding ? isWedding.querySelector('.fw-bold').textContent : '';

                    homeFormTitle.textContent = catLabel ? 'Data ' + catLabel : 'Data Undangan';
                    homeFormSubtitle.textContent = 'Isi informasi undangan Anda sebelum publish.';

                    const catLower = (catLabel || '').toLowerCase();
                    const isWeddingLike = catLower.includes('wedding') || catLower.includes('engagement') || catLower.includes('nikah') || catLower.includes('pernikahan') || catLower.includes('lamaran');

                    if (isWeddingLike) {
                        homeFormWedding.classList.remove('d-none');
                        homeFormGeneric.classList.add('d-none');
                        homeFormWedding.querySelectorAll('input').forEach(i => i.disabled = false);
                        homeFormGeneric.querySelectorAll('input, textarea').forEach(i => i.disabled = true);
                    } else {
                        homeFormGeneric.classList.remove('d-none');
                        homeFormWedding.classList.add('d-none');
                        homeFormGeneric.querySelectorAll('input, textarea').forEach(i => i.disabled = false);
                        homeFormWedding.querySelectorAll('input').forEach(i => i.disabled = true);
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
                        if (!homeFormWedding.classList.contains('d-none')) {
                            const groomVal = document.getElementById('wedding_groom_name')?.value.trim();
                            const brideVal = document.getElementById('wedding_bride_name')?.value.trim();
                            formValid = !!(groomVal && brideVal);
                        } else {
                            const eventName = document.getElementById('generic_groom_name')?.value.trim();
                            formValid = !!eventName;
                        }
                    } else {
                        // Di step kategori, perlu pilih kategori
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
                homeModalEl?.addEventListener('hidden.bs.modal', function () {
                    document.querySelectorAll('#newInvitationModal .modal-step').forEach(s => s.classList.add('d-none'));
                    document.getElementById('modalStepCategory').classList.remove('d-none');
                    homeModalStepTitle.innerHTML = '<i class="bi bi-suit-heart-fill me-2" style="color: var(--gold-primary);"></i> Pilih Kategori';
                    if (homeQuickCreateBtn) homeQuickCreateBtn.disabled = true;
                    if (homeModalBackBtn) homeModalBackBtn.style.display = 'none';
                    homeSelectedCategoryId = null;
                    document.getElementById('home_category_id').value = '';
                    document.querySelectorAll('#homeCategorySelector .category-option').forEach(c => {
                        c.classList.remove('selected');
                        c.style.borderColor = '';
                        c.style.boxShadow = '';
                    });
                    const formInputs = document.querySelectorAll('#modalStepForm input, #modalStepForm textarea');
                    formInputs.forEach(i => i.value = '');
                    homeFormWedding.classList.add('d-none');
                    homeFormGeneric.classList.add('d-none');
                    homeFormWedding.querySelectorAll('input').forEach(i => i.disabled = false);
                    homeFormGeneric.querySelectorAll('input, textarea').forEach(i => i.disabled = true);
                });

                // Expose handlers for inline onclick in template
                window.homeSelectCategory = homeSelectCategory;
                window.homeGoToStep = homeGoToStep;

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
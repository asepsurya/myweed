<x-app-layout>

    @push('styles')
    <style>
        .import-kontak-page {
            --ik-primary: var(--adminuiux-theme-1, #C6A962);
            --ik-primary-hover: var(--adminuiux-theme-1-hover, #A68B4B);
            --ik-navy: var(--adminuiux-theme-2, #1B2A4A);
        }

        .btn-tambah {
            background: linear-gradient(135deg, var(--ik-primary) 0%, var(--ik-primary-hover) 100%);
            border: none;
            color: #fff !important;
            padding: 0.65rem 1.35rem;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 14px rgba(198, 169, 98, 0.3);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
        }
        .btn-tambah:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(198, 169, 98, 0.4);
            filter: brightness(1.03);
        }

        /* Stat Cards */
        .ik-stat-card {
            border-radius: 1rem;
            border: 1px solid var(--bs-border-color);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .ik-stat-card:hover {
            transform: translateY(-2px);
        }
        .ik-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }
        .ik-stat-icon.bg-primary-soft {
            background: rgba(198, 169, 98, 0.14);
            color: var(--ik-primary);
        }
        .ik-stat-icon.bg-success-soft {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }
        .ik-stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin: 0;
        }
        .ik-stat-label {
            color: var(--bs-secondary-color);
            font-size: 0.82rem;
            margin: 0.15rem 0 0;
        }

        /* Guest Table */
        .ik-card {
            border-radius: 1rem;
            border: 1px solid var(--bs-border-color);
            overflow: hidden;
        }
        .ik-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--bs-border-color);
            background: transparent;
        }
        .ik-search-wrap {
            position: relative;
            min-width: 220px;
        }
        .ik-search-wrap i {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--bs-secondary-color);
            font-size: 0.875rem;
            pointer-events: none;
        }
        .ik-search-input {
            padding-left: 2.25rem;
            border-radius: 0.65rem;
            font-size: 0.875rem;
        }

        .guest-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }
        .guest-table thead th {
            background: rgba(var(--adminuiux-theme-2-rgb, 27, 42, 74), 0.03);
            font-weight: 600;
            font-size: 0.75rem;
            color: var(--bs-secondary-color);
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid var(--bs-border-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        [data-bs-theme="dark"] .guest-table thead th {
            background: rgba(255, 255, 255, 0.03);
        }
        .guest-table tbody td {
            padding: 0.9rem 1.25rem;
            border-bottom: 1px solid var(--bs-border-color);
            vertical-align: middle;
        }
        .guest-table tbody tr:last-child td {
            border-bottom: none;
        }
        .guest-table tbody tr {
            transition: background-color 0.15s ease;
        }
        .guest-table tbody tr:hover {
            background: rgba(198, 169, 98, 0.05);
        }

        .guest-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(198, 169, 98, 0.15);
            color: var(--ik-primary);
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            text-transform: uppercase;
        }
        .guest-name {
            font-weight: 600;
            color: var(--bs-body-color);
            font-size: 0.925rem;
            line-height: 1.3;
        }
        .guest-phone {
            color: var(--bs-secondary-color);
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
        }
        .guest-phone::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #25D366;
            flex-shrink: 0;
        }

        .link-preview {
            color: var(--ik-primary-hover);
            text-decoration: none;
            font-size: 0.82rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.35rem 0.75rem;
            border-radius: 0.5rem;
            background: rgba(198, 169, 98, 0.12);
            transition: all 0.2s ease;
            font-weight: 600;
            white-space: nowrap;
        }
        [data-bs-theme="dark"] .link-preview {
            color: var(--ik-primary);
        }
        .link-preview:hover {
            background: rgba(198, 169, 98, 0.22);
            color: var(--ik-primary-hover);
        }

        /* Action Buttons */
        .action-btns {
            display: flex;
            gap: 0.45rem;
            justify-content: flex-end;
            align-items: center;
        }
        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 0.55rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            flex-shrink: 0;
        }
        .btn-action.copy {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }
        .btn-action.copy:hover {
            background: #0d6efd;
            color: #fff;
        }
        .btn-action.wa {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }
        .btn-action.wa:hover {
            background: #198754;
            color: #fff;
        }
        .btn-action.delete {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        .btn-action.delete:hover {
            background: #dc3545;
            color: #fff;
        }

        .empty-state {
            text-align: center;
            padding: 3.5rem 1.25rem;
        }
        .empty-state-icon {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: rgba(198, 169, 98, 0.12);
            color: var(--ik-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        /* Modal Theme */
        .modal-theme-navy .modal-header {
            background: linear-gradient(135deg, #1B2A4A 0%, #2A3F6A 100%);
            color: #fff;
            border-bottom: 2px solid var(--ik-primary);
            padding: 1.15rem 1.5rem;
        }
        .modal-theme-navy .modal-title {
            font-weight: 700;
            font-size: 1.05rem;
        }
        .contact-item-card {
            border-radius: 0.75rem;
            border: 1px solid var(--bs-border-color);
            background: var(--bs-tertiary-bg);
        }

        /* Mobile Responsive Card Layout for Table */
        .mobile-select-all {
            display: none;
        }
        @media (max-width: 767.98px) {
            .ik-card-header {
                padding: 0.9rem 1rem;
            }
            .ik-search-wrap {
                width: 100%;
                min-width: 0;
            }
            .mobile-select-all {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.65rem 1rem;
                border-bottom: 1px solid var(--bs-border-color);
                background: rgba(var(--adminuiux-theme-2-rgb, 27, 42, 74), 0.02);
                font-size: 0.82rem;
                color: var(--bs-secondary-color);
            }
            .guest-table thead {
                display: none;
            }
            .guest-table,
            .guest-table tbody {
                display: block;
                width: 100%;
            }
            .guest-table tbody tr {
                display: grid;
                grid-template-columns: auto 1fr auto;
                grid-template-areas:
                    "check name link"
                    "check phone actions";
                gap: 0.35rem 0.75rem;
                padding: 0.9rem 1rem;
                border-bottom: 1px solid var(--bs-border-color);
                align-items: center;
            }
            .guest-table tbody tr:last-child {
                border-bottom: none;
            }
            .guest-table tbody td {
                display: block;
                padding: 0 !important;
                border: none !important;
            }
            .guest-table tbody td.col-check {
                grid-area: check;
                align-self: start;
                padding-top: 0.25rem !important;
            }
            .guest-table tbody td.col-name {
                grid-area: name;
                min-width: 0;
            }
            .guest-table tbody td.col-phone {
                grid-area: phone;
            }
            .guest-table tbody td.col-link {
                grid-area: link;
                justify-self: end;
            }
            .guest-table tbody td.col-actions {
                grid-area: actions;
                justify-self: end;
            }
            .guest-name {
                font-size: 0.92rem;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .guest-phone {
                font-size: 0.82rem;
            }
            .btn-action {
                width: 36px;
                height: 36px;
            }
        }
    </style>
    @endpush

    <div class="container-fluid py-4 import-kontak-page">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Daftar Tamu &amp; Import Kontak</h4>
                <p class="text-muted small mb-0">Kelola daftar tamu undangan, salin tautan personal, atau kirim via WhatsApp.</p>
            </div>
            <div class="d-flex gap-2">
                @if(auth()->user()->isPaidSubscribed() && !empty($invitation))
                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                        data-bs-target="#shareModalDynamic" data-id="{{ $invitation->public_id }}">
                        <i class="bi bi-share"></i>
                        <span>Bagikan Undangan</span>
                    </button>
                @endif
                <button type="button" class="btn btn-tambah" id="openTambahModal">
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Tamu</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-6">
                <div class="card adminuiux-card ik-stat-card h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-3 p-sm-4">
                        <div class="ik-stat-icon bg-primary-soft">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <p class="ik-stat-value">{{ $guests->count() }}</p>
                            <p class="ik-stat-label">Total Tamu</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="card adminuiux-card ik-stat-card h-100">
                    <div class="card-body d-flex align-items-center gap-3 p-3 p-sm-4">
                        <div class="ik-stat-icon bg-success-soft">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <p class="ik-stat-value">{{ $guests->count() }}</p>
                            <p class="ik-stat-label">Siap Kirim</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guest List Card -->
        <div class="card adminuiux-card ik-card">
            <div class="ik-card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <h6 class="fw-semibold mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-person-lines-fill text-primary"></i>
                        <span>Semua Tamu</span>
                        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-body fw-medium">{{ $guests->count() }}</span>
                    </h6>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    @if($guests->isNotEmpty())
                        <div class="ik-search-wrap">
                            <i class="bi bi-search"></i>
                            <input type="text" id="guestSearchInput" class="form-control form-control-sm ik-search-input" placeholder="Cari nama atau nomor HP...">
                        </div>
                    @endif
                    <button type="button" class="btn btn-sm btn-outline-success rounded-3" id="bulkWhatsappBtn" style="display: none;">
                        <i class="bi bi-whatsapp me-1"></i> Kirim Terpilih
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-3" id="deleteSelectedBtn" style="display: none;">
                        <i class="bi bi-trash me-1"></i> Hapus Terpilih
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                @if($guests->isNotEmpty())
                    <!-- Mobile Select All Bar -->
                    <div class="mobile-select-all">
                        <label class="d-flex align-items-center gap-2 mb-0" for="selectAllMobile">
                            <input class="form-check-input m-0" type="checkbox" id="selectAllMobile">
                            <span>Pilih Semua Tamu</span>
                        </label>
                        <span id="mobileSelectedCount" class="small"></span>
                    </div>

                    <div class="table-responsive">
                        <table class="guest-table">
                            <thead>
                                <tr>
                                    <th style="width: 44px;" class="ps-4">
                                        <input class="form-check-input" type="checkbox" id="selectAll" aria-label="Pilih semua">
                                    </th>
                                    <th>Nama Tamu</th>
                                    <th>Nomor HP</th>
                                    <th>Link Undangan</th>
                                    <th style="width: 150px;" class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="guestTableBody">
                                @foreach($guests as $guest)
                                    <tr class="guest-row" data-id="{{ $guest->id }}" data-name="{{ $guest->name }}" data-phone="{{ $guest->phone }}" data-link="{{ $guest->personalLink() }}">
                                        <td class="ps-4 col-check">
                                            <input class="form-check-input guest-checkbox" type="checkbox" value="{{ $guest->id }}" aria-label="Pilih {{ $guest->name }}">
                                        </td>
                                        <td class="col-name">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="guest-avatar d-none d-md-inline-flex">{{ mb_substr($guest->name, 0, 1) }}</span>
                                                <div class="guest-name">{{ $guest->name }}</div>
                                            </div>
                                        </td>
                                        <td class="col-phone">
                                            <div class="guest-phone">{{ $guest->phone }}</div>
                                        </td>
                                        <td class="col-link">
                                            <a href="{{ $guest->personalLink() }}" target="_blank" class="link-preview">
                                                <i class="bi bi-box-arrow-up-right"></i> Lihat
                                            </a>
                                        </td>
                                        <td class="pe-4 col-actions">
                                            <div class="action-btns">
                                                <button type="button" class="btn-action copy copy-link-btn" data-link="{{ $guest->personalLink() }}" title="Salin Link">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                                <a href="{{ $guest->whatsappLink() }}" target="_blank" class="btn-action wa" title="Kirim WhatsApp">
                                                    <i class="bi bi-whatsapp"></i>
                                                </a>
                                                <form action="{{ route('invitation.import-kontak.destroy', $guest) }}" method="POST" class="m-0 p-0 d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action delete" onclick="return confirm('Hapus kontak ini?')" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div id="searchEmptyState" class="empty-state" style="display: none;">
                        <div class="empty-state-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">Tamu tidak ditemukan</h6>
                        <p class="text-muted small mb-0">Coba kata kunci nama atau nomor HP yang lain.</p>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h6 class="fw-semibold mb-1">Belum ada daftar tamu</h6>
                        <p class="text-muted small mb-3">Tambahkan tamu pertama Anda dari kontak HP atau secara manual.</p>
                        <button type="button" class="btn btn-tambah btn-sm" onclick="document.getElementById('openTambahModal').click()">
                            <i class="bi bi-plus-lg"></i> Tambah Tamu Sekarang
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal: Share Invitation -->
    @if(auth()->user()->isPaidSubscribed() && !empty($invitation))
        <div id="wa-message-{{ $invitation->public_id }}" class="d-none">
            @include('dashboard.invitation.pesan', ['inv' => $invitation])
        </div>
        @include('layouts.partial.share-modal')
    @endif
    @include('layouts.partial.share-modal-js')

    <!-- Tambah Tamu Modal -->
    <div class="modal fade modal-theme-navy" id="tambahModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center gap-2 mb-0">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>Tambah Tamu Undangan</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="unsupportedWarning" class="alert alert-warning d-flex align-items-start gap-2 rounded-3 small" style="display: none !important;">
                        <i class="bi bi-exclamation-triangle-fill mt-1 flex-shrink-0"></i>
                        <div>Browser Anda tidak mendukung Contact Picker API. Gunakan Chrome/Edge di Android untuk impor otomatis, atau klik <strong>Tambah Manual</strong> di bawah.</div>
                    </div>

                    <button type="button" id="pickContactsBtn" class="btn btn-tambah w-100 py-2 mb-2">
                        <i class="bi bi-journal-bookmark-fill"></i>
                        <span>Pilih dari Kontak HP</span>
                    </button>

                    <hr class="my-3 opacity-25">

                    <form id="contactForm" action="{{ route('invitation.import-kontak.store') }}" method="POST">
                        @csrf

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0">Daftar Kontak Baru</h6>
                            <button type="button" id="addManualBtn" class="btn btn-sm btn-outline-secondary rounded-3">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Manual
                            </button>
                        </div>

                        <div class="text-center text-muted py-4 border rounded-3 border-dashed" id="emptyState">
                            <i class="bi bi-person-lines-fill fs-2 d-block mb-2 opacity-50"></i>
                            <small>Belum ada kontak. Pilih dari HP atau klik Tambah Manual.</small>
                        </div>

                        <div id="contactList" class="d-flex flex-column gap-2"></div>

                        <div id="formActions" class="mt-4" style="display: none;">
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold rounded-3" id="saveBtn" disabled>
                                <i class="bi bi-check-lg me-1"></i> Simpan Kontak
                            </button>
                        </div>
                    </form>

                    <div id="successMessage" class="alert alert-success mt-3 rounded-3 mb-0" style="display: none;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span id="successText">Kontak berhasil disimpan!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    (function () {
        const pickBtn = document.getElementById('pickContactsBtn');
        const addManualBtn = document.getElementById('addManualBtn');
        const contactList = document.getElementById('contactList');
        const emptyState = document.getElementById('emptyState');
        const formActions = document.getElementById('formActions');
        const contactForm = document.getElementById('contactForm');
        const successMessage = document.getElementById('successMessage');
        const successText = document.getElementById('successText');
        const unsupportedWarning = document.getElementById('unsupportedWarning');
        const saveBtn = document.getElementById('saveBtn');
        const selectAllCheckbox = document.getElementById('selectAll');
        const selectAllMobile = document.getElementById('selectAllMobile');
        const mobileSelectedCount = document.getElementById('mobileSelectedCount');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const bulkWhatsappBtn = document.getElementById('bulkWhatsappBtn');
        const openTambahModal = document.getElementById('openTambahModal');
        const guestSearchInput = document.getElementById('guestSearchInput');
        const searchEmptyState = document.getElementById('searchEmptyState');

        let contactIndex = 0;

        const supported = 'contacts' in navigator;

        if (supported) {
            if (pickBtn) {
                pickBtn.addEventListener('click', async () => {
                    try {
                        const contacts = await navigator.contacts.select(['name', 'tel'], { multiple: true });
                        if (!contacts || contacts.length === 0) return;
                        contacts.forEach(contact => {
                            const fullName = [contact.name[0] || '', contact.name[1] || ''].filter(Boolean).join(' ') || 'Tanpa Nama';
                            const phone = (contact.tel && contact.tel[0]) || '';
                            addContactRow(fullName, phone);
                        });
                        updateUI();
                    } catch (err) {
                        if (err.name !== 'AbortError') {
                            console.error('Contact Picker error:', err);
                            alert('Gagal memilih kontak: ' + err.message);
                        }
                    }
                });
            }
        } else {
            if (pickBtn) {
                pickBtn.disabled = true;
                pickBtn.classList.add('disabled');
            }
            if (unsupportedWarning) unsupportedWarning.style.removeProperty('display');
        }

        function updateSaveButton() {
            const hasContacts = contactList.querySelectorAll('.contact-item-card').length > 0;
            if (saveBtn) saveBtn.disabled = !hasContacts;
        }

        if (addManualBtn) {
            addManualBtn.addEventListener('click', () => {
                addContactRow('', '');
                updateUI();
            });
        }

        function addContactRow(name, phone) {
            const index = contactIndex++;
            const div = document.createElement('div');
            div.className = 'card contact-item-card mb-0';
            div.innerHTML = `
                <div class="card-body p-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-5">
                            <label class="form-label small text-muted mb-1">Nama</label>
                            <input type="text" name="contacts[${index}][name]" class="form-control form-control-sm" placeholder="Nama kontak" value="${escapeHtml(name)}" required>
                        </div>
                        <div class="col-10 col-md-5">
                            <label class="form-label small text-muted mb-1">Nomor HP</label>
                            <input type="tel" name="contacts[${index}][phone]" class="form-control form-control-sm" placeholder="08xxxxxxxxxx" value="${escapeHtml(phone)}" required>
                        </div>
                        <div class="col-2 col-md-2">
                            <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-btn" title="Hapus baris">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            div.querySelector('.remove-btn').addEventListener('click', () => {
                div.remove();
                updateUI();
            });
            contactList.appendChild(div);
        }

        function updateUI() {
            const hasContacts = contactList.querySelectorAll('.contact-item-card').length > 0;
            if (emptyState) emptyState.style.display = hasContacts ? 'none' : 'block';
            if (formActions) formActions.style.display = hasContacts ? 'block' : 'none';
            updateSaveButton();
        }

        if (contactForm) {
            contactForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(contactForm);
                if (saveBtn) saveBtn.disabled = true;
                try {
                    const response = await fetch(contactForm.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });
                    const data = await response.json();
                    if (data.success) {
                        successText.textContent = data.message;
                        successMessage.style.display = 'block';
                        contactList.innerHTML = '';
                        contactIndex = 0;
                        updateUI();
                        setTimeout(() => { window.location.reload(); }, 1200);
                    } else {
                        alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                        updateSaveButton();
                    }
                } catch (err) {
                    console.error('Submit error:', err);
                    alert('Gagal mengirim data: ' + err.message);
                    updateSaveButton();
                }
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function syncSelectAll(checked) {
            document.querySelectorAll('.guest-row').forEach(row => {
                if (row.style.display !== 'none') {
                    const cb = row.querySelector('.guest-checkbox');
                    if (cb) cb.checked = checked;
                }
            });
            if (selectAllCheckbox) selectAllCheckbox.checked = checked;
            if (selectAllMobile) selectAllMobile.checked = checked;
            updateSelectedCount();
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                syncSelectAll(this.checked);
            });
        }
        if (selectAllMobile) {
            selectAllMobile.addEventListener('change', function () {
                syncSelectAll(this.checked);
            });
        }

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('guest-checkbox')) {
                updateSelectedCount();
            }
        });

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.guest-checkbox:checked');
            const count = checked.length;
            if (count > 0) {
                if (deleteSelectedBtn) deleteSelectedBtn.style.display = 'inline-flex';
                if (bulkWhatsappBtn) bulkWhatsappBtn.style.display = 'inline-flex';
                if (mobileSelectedCount) mobileSelectedCount.textContent = count + ' dipilih';
            } else {
                if (deleteSelectedBtn) deleteSelectedBtn.style.display = 'none';
                if (bulkWhatsappBtn) bulkWhatsappBtn.style.display = 'none';
                if (mobileSelectedCount) mobileSelectedCount.textContent = '';
            }
        }

        if (guestSearchInput) {
            guestSearchInput.addEventListener('input', function () {
                const query = this.value.trim().toLowerCase();
                let visibleCount = 0;
                document.querySelectorAll('.guest-row').forEach(row => {
                    const name = (row.dataset.name || '').toLowerCase();
                    const phone = (row.dataset.phone || '').toLowerCase();
                    const match = name.includes(query) || phone.includes(query);
                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });
                if (searchEmptyState) {
                    searchEmptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            });
        }

        if (deleteSelectedBtn) {
            deleteSelectedBtn.addEventListener('click', async () => {
                const checked = document.querySelectorAll('.guest-checkbox:checked');
                if (checked.length === 0) return;
                if (!confirm('Hapus ' + checked.length + ' kontak terpilih?')) return;
                const ids = Array.from(checked).map(cb => cb.value);
                for (const id of ids) {
                    try {
                        const response = await fetch('/invitation/import-kontak/guest/' + id, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json',
                            },
                        });
                        if (response.ok) {
                            const row = document.querySelector(`.guest-row[data-id="${id}"]`);
                            if (row) row.remove();
                        }
                    } catch (err) {
                        console.error('Delete error:', err);
                    }
                }
                updateSelectedCount();
                if (selectAllCheckbox) selectAllCheckbox.checked = false;
                if (selectAllMobile) selectAllMobile.checked = false;
                setTimeout(() => { window.location.reload(); }, 500);
            });
        }

        if (bulkWhatsappBtn) {
            bulkWhatsappBtn.addEventListener('click', () => {
                const checked = document.querySelectorAll('.guest-checkbox:checked');
                if (checked.length === 0) return;
                const selectedGuests = [];
                checked.forEach(cb => {
                    const row = document.querySelector(`.guest-row[data-id="${cb.value}"]`);
                    selectedGuests.push({
                        name: row.dataset.name,
                        phone: row.dataset.phone,
                        link: row.dataset.link,
                    });
                });
                let delay = 0;
                selectedGuests.forEach((guest) => {
                    const message = `Halo ${guest.name}, undangan untuk Anda:\n\n${guest.link}\n\nTerima kasih!`;
                    const phone = guest.phone.replace(/[^0-9]/g, '');
                    const url = `https://wa.me/${phone}?text=${encodeURIComponent(message)}`;
                    setTimeout(() => { window.open(url, '_blank'); }, delay);
                    delay += 1500;
                });
            });
        }

        document.addEventListener('click', function (e) {
            const copyBtn = e.target.closest('.copy-link-btn');
            if (copyBtn) {
                const link = copyBtn.dataset.link;
                copyToClipboard(link, copyBtn);
            }
        });

        async function copyToClipboard(text, btn) {
            try {
                await navigator.clipboard.writeText(text);
                const original = btn.innerHTML;
                btn.innerHTML = '<i class="bi bi-check-lg"></i>';
                setTimeout(() => { btn.innerHTML = original; }, 2000);
            } catch (err) {
                prompt('Copy link ini:', text);
            }
        }

        if (openTambahModal) {
            openTambahModal.addEventListener('click', () => {
                const modal = new bootstrap.Modal(document.getElementById('tambahModal'));
                modal.show();
            });
        }

        updateSaveButton();
    })();
    </script>

    <script>
        function ikGetShareData() {
            const recipientInput = document.getElementById('recipientNameDynamic');
            const recipient = recipientInput ? recipientInput.value.trim() : '';
            if (!recipient) {
                if (recipientInput) recipientInput.focus();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'warning', title: 'Penerima wajib diisi', text: 'Masukkan nama penerima terlebih dahulu sebelum membagikan undangan.', confirmButtonColor: '#C6A962' });
                } else {
                    alert('Masukkan nama penerima terlebih dahulu.');
                }
                return null;
            }
            const messageEl = document.getElementById('shareMessageDynamic');
            let message = messageEl ? messageEl.value : '';
            message = message.replace(/\[nama\]/g, recipient);
            message = message.replace(/(\?penerima=)([^&\n]+)/g, function (match, prefix, value) {
                return prefix + encodeURIComponent(value.trim());
            });
            return { recipient, message };
        }

        function ikGetInvitationUrl() {
            const slug = @json($invitation?->slug ?? '');
            const recipientEl = document.getElementById('recipientNameDynamic');
            const recipient = recipientEl ? recipientEl.value.trim() : '';
            if (slug) {
                let url = @json(url('/')) + '/' + slug;
                if (recipient) url += '?penerima=' + encodeURIComponent(recipient);
                return url;
            }
            return window.location.href;
        }

        window.shareToWhatsApp = function () {
            const data = ikGetShareData(); if (!data) return;
            window.open('https://wa.me/?text=' + encodeURIComponent(data.message), '_blank');
        };
        window.shareToFacebook = function () {
            const data = ikGetShareData(); if (!data) return;
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(ikGetInvitationUrl()), '_blank');
        };
        window.shareToTwitter = function () {
            const data = ikGetShareData(); if (!data) return;
            window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(data.message) + '&url=' + encodeURIComponent(ikGetInvitationUrl()), '_blank');
        };
        window.shareToTelegram = function () {
            const data = ikGetShareData(); if (!data) return;
            window.open('https://t.me/share/url?url=' + encodeURIComponent(ikGetInvitationUrl()) + '&text=' + encodeURIComponent(data.message), '_blank');
        };
        window.shareViaEmail = function () {
            const data = ikGetShareData(); if (!data) return;
            window.location.href = 'mailto:?subject=' + encodeURIComponent('Undangan Pernikahan') + '&body=' + encodeURIComponent(data.message);
        };
        window.copyInvitationLink = function () {
            const data = ikGetShareData(); if (!data) return;
            const url = ikGetInvitationUrl();
            navigator.clipboard.writeText(url).then(function () {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Tersalin!', text: 'Tautan undangan berhasil disalin.', timer: 1500, showConfirmButton: false });
                } else { alert('Tautan undangan berhasil disalin!'); }
            }).catch(function () { alert('Gagal menyalin tautan.'); });
        };
    </script>
    @endpush

</x-app-layout>
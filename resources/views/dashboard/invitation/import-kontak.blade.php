<x-app-layout>

    @push('styles')
    <style>
        :root {
            --primary: #C6A962;
            --primary-dark: #A68B4B;
        }
        .btn-tambah {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(198, 169, 98, 0.3);
            transition: all 0.3s;
        }
        .btn-tambah:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(198, 169, 98, 0.4);
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid var(--bs-border-color);
        }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .stat-card .stat-icon.bg-primary-soft {
            background: rgba(198, 169, 98, 0.1);
            color: var(--primary);
        }
        .stat-card .stat-icon.bg-success-soft {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
        }
        .stat-card .stat-label {
            color: #6c757d;
            font-size: 0.85rem;
            margin: 0;
        }
        .guest-table {
            width: 100%;
            margin: 0;
        }
        .guest-table th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.8rem;
            color: #6c757d;
            padding: 0.85rem 1rem;
            border-bottom: 2px solid #e9ecef;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .guest-table td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        .guest-table tr:last-child td {
            border-bottom: none;
        }
        .guest-table tr:hover {
            background: rgba(198, 169, 98, 0.02);
        }
        .guest-name {
            font-weight: 600;
            color: #212529;
            font-size: 0.95rem;
        }
        .guest-phone {
            color: #6c757d;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .guest-phone::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #28a745;
        }
        .action-btns {
            display: flex;
            gap: 0.4rem;
        }
        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 0.85rem;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-action.copy {
            background: rgba(13, 110, 253, 0.08);
            color: #0d6efd;
        }
        .btn-action.copy:hover {
            background: #0d6efd;
            color: #fff;
        }
        .btn-action.wa {
            background: rgba(25, 135, 84, 0.08);
            color: #198754;
        }
        .btn-action.wa:hover {
            background: #198754;
            color: #fff;
        }
        .btn-action.delete {
            background: rgba(220, 53, 69, 0.08);
            color: #dc3545;
        }
        .btn-action.delete:hover {
            background: #dc3545;
            color: #fff;
        }
        .link-preview {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.4rem;
            background: rgba(198, 169, 98, 0.08);
            transition: all 0.2s;
        }
        .link-preview:hover {
            background: rgba(198, 169, 98, 0.15);
            color: var(--primary-dark);
        }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }
        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
        .empty-state p {
            color: #adb5bd;
            margin: 0;
        }
    </style>
    @endpush

    <div class="container-fluid py-4">
        <div class="dashboard-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-0">Daftar Tamu</h4>
                <p class="text-muted mb-0">Kelola tamu undangan Anda</p>
            </div>
            <button class="btn btn-tambah" id="openTambahModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Tamu
            </button>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card adminuiux-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon bg-primary-soft">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <p class="stat-value">{{ $guests->count() }}</p>
                            <p class="stat-label">Total Tamu</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card adminuiux-card">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon bg-success-soft">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <p class="stat-value">{{ $guests->count() }}</p>
                            <p class="stat-label">Siap Kirim</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guest List -->
        <div class="card adminuiux-card">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3 px-4">
                <h6 class="fw-semibold mb-0"><i class="bi bi-people me-2"></i>Semua Tamu</h6>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-success" id="bulkWhatsappBtn" style="display: none;">
                        <i class="bi bi-whatsapp me-1"></i> Kirim Terpilih
                    </button>
                    <button class="btn btn-sm btn-outline-danger" id="deleteSelectedBtn" style="display: none;">
                        <i class="bi bi-trash me-1"></i> Hapus Terpilih
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                @if($guests->isNotEmpty())
                    <table class="guest-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;" class="ps-4">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </th>
                                <th>Nama</th>
                                <th>Nomor HP</th>
                                <th>Link</th>
                                <th style="width: 140px;" class="pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guests as $guest)
                                <tr class="guest-row" data-id="{{ $guest->id }}" data-name="{{ $guest->name }}" data-phone="{{ $guest->phone }}" data-link="{{ $guest->personalLink() }}">
                                    <td class="ps-4">
                                        <input class="form-check-input guest-checkbox" type="checkbox" value="{{ $guest->id }}">
                                    </td>
                                    <td>
                                        <div class="guest-name">{{ $guest->name }}</div>
                                    </td>
                                    <td>
                                        <div class="guest-phone">{{ $guest->phone }}</div>
                                    </td>
                                    <td>
                                        <a href="{{ $guest->personalLink() }}" target="_blank" class="link-preview">
                                            <i class="bi bi-link-45deg"></i> Lihat
                                        </a>
                                    </td>
                                    <td class="pe-4">
                                        <div class="action-btns">
                                            <button class="btn-action copy copy-link-btn" data-link="{{ $guest->personalLink() }}" title="Copy Link">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                            <a href="{{ $guest->whatsappLink() }}" target="_blank" class="btn-action wa" title="Chat WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            <form action="{{ route('invitation.import-kontak.destroy', $guest) }}" method="POST" class="d-inline">
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
                @else
                    <div class="empty-state">
                        <i class="bi bi-people d-block"></i>
                        <p>Belum ada tamu. Tambahkan tamu pertama Anda!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tambah Tamu Modal -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i> Tambah Tamu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="unsupportedWarning" class="alert alert-warning" style="display: none;">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Browser Anda tidak mendukung Contact Picker API. Silakan gunakan Chrome atau Edge di Android.
                    </div>

                    <button id="pickContactsBtn" class="btn btn-primary btn-lg w-100 mb-3">
                        <i class="bi bi-people me-2"></i> Pilih dari Kontak HP
                    </button>

                    <hr class="my-4">

                    <form id="contactForm" action="{{ route('invitation.import-kontak.store') }}" method="POST">
                        @csrf

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0">Daftar Kontak Baru</h6>
                            <button type="button" id="addManualBtn" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Manual
                            </button>
                        </div>

                        <div id="contactList">
                            <div class="text-center text-muted py-4" id="emptyState">
                                <i class="bi bi-person-lines-fill display-6 d-block mb-2"></i>
                                <small>Belum ada kontak. Pilih dari HP atau tambah manual.</small>
                            </div>
                        </div>

                        <div id="formActions" class="mt-4" style="display: none;">
                            <button type="submit" class="btn btn-success btn-lg w-100" id="saveBtn" disabled>
                                <i class="bi bi-check-lg me-2"></i> Simpan Kontak
                            </button>
                        </div>
                    </form>

                    <div id="successMessage" class="alert alert-success mt-3" style="display: none;">
                        <i class="bi bi-check-circle me-2"></i>
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
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const bulkWhatsappBtn = document.getElementById('bulkWhatsappBtn');
        const openTambahModal = document.getElementById('openTambahModal');

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
            if (unsupportedWarning) unsupportedWarning.style.display = 'block';
        }

        function updateSaveButton() {
            const hasContacts = contactList.querySelectorAll('.card').length > 0;
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
            div.className = 'card mb-2 border';
            div.innerHTML = `
                <div class="card-body p-3">
                    <div class="row g-2">
                        <div class="col-12 col-md-5">
                            <label class="form-label small text-muted mb-1">Nama</label>
                            <input type="text" name="contacts[${index}][name]" class="form-control form-control-sm" placeholder="Nama kontak" value="${escapeHtml(name)}" required>
                        </div>
                        <div class="col-10 col-md-5">
                            <label class="form-label small text-muted mb-1">Nomor HP</label>
                            <input type="tel" name="contacts[${index}][phone]" class="form-control form-control-sm" placeholder="+628xxxxxxxxxx" value="${escapeHtml(phone)}" required>
                        </div>
                        <div class="col-2 col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-btn">
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
            const hasContacts = contactList.querySelectorAll('.card').length > 0;
            if (emptyState) emptyState.style.display = hasContacts ? 'none' : 'block';
            if (formActions) formActions.style.display = hasContacts ? 'block' : 'none';
            updateSaveButton();
        }

        if (contactForm) {
            contactForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(contactForm);
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
                        if (emptyState) emptyState.style.display = 'block';
                        if (formActions) formActions.style.display = 'none';
                        contactIndex = 0;
                        setTimeout(() => { window.location.reload(); }, 1500);
                    } else {
                        alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                    }
                } catch (err) {
                    console.error('Submit error:', err);
                    alert('Gagal mengirim data: ' + err.message);
                }
            });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                document.querySelectorAll('.guest-checkbox').forEach(cb => {
                    cb.checked = this.checked;
                });
                updateSelectedCount();
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
                if (deleteSelectedBtn) deleteSelectedBtn.style.display = 'inline-block';
                if (bulkWhatsappBtn) bulkWhatsappBtn.style.display = 'inline-block';
            } else {
                if (deleteSelectedBtn) deleteSelectedBtn.style.display = 'none';
                if (bulkWhatsappBtn) bulkWhatsappBtn.style.display = 'none';
            }
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
                btn.innerHTML = '<i class="bi bi-check"></i>';
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
    @endpush

</x-app-layout>

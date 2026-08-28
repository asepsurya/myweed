<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Kontak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container py-4" style="max-width: 640px;">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h4 class="fw-bold mb-0">Import Kontak</h4>
                <p class="text-muted small mb-0">Pilih kontak dari HP atau tambah manual</p>
            </div>
            <div class="card-body px-4 pb-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div id="unsupportedWarning" class="alert alert-warning" style="display: none;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Browser Anda tidak mendukung Contact Picker API. Silakan gunakan Chrome atau Edge di Android.
                </div>

                <div class="mb-4">
                    <label for="invitationSelect" class="form-label fw-semibold">Pilih Undangan</label>
                    <select id="invitationSelect" class="form-select">
                        <option value="">-- Pilih undangan --</option>
                        @foreach($invitations as $inv)
                            <option value="{{ $inv->id }}" {{ $invitationId == $inv->id ? 'selected' : '' }}>
                                {{ $inv->groom_name }} & {{ $inv->bride_name }} ({{ $inv->slug }})
                            </option>
                        @endforeach
                    </select>
                    @if($invitations->isEmpty())
                        <div class="form-text text-warning">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Belum ada undangan. Buat undangan terlebih dahulu.
                        </div>
                    @endif
                </div>

                <button id="pickContactsBtn" class="btn btn-primary btn-lg w-100 mb-3">
                    <i class="bi bi-people me-2"></i> Pilih dari Kontak
                </button>

                <hr class="my-4">

                <form id="contactForm" action="{{ route('invitation.import-kontak.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="invitation_id" id="invitationIdInput" value="{{ $invitationId }}">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-semibold mb-0">Daftar Kontak</h6>
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

                @if($guests->isNotEmpty())
                    <hr class="my-4">
                    <h6 class="fw-semibold mb-3">Kontak Tersimpan ({{ $guests->count() }})</h6>
                    <div class="list-group">
                        @foreach($guests as $guest)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $guest->name }}</div>
                                    <div class="small text-muted">{{ $guest->phone }}</div>
                                </div>
                                <form action="{{ route('invitation.import-kontak.destroy', $guest) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus kontak ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

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
        const invitationSelect = document.getElementById('invitationSelect');
        const invitationIdInput = document.getElementById('invitationIdInput');
        const saveBtn = document.getElementById('saveBtn');

        let contactIndex = 0;

        const supported = 'contacts' in navigator;

        if (!supported) {
            pickBtn.disabled = true;
            pickBtn.classList.add('disabled');
            unsupportedWarning.style.display = 'block';
        }

        if (invitationSelect) {
            invitationSelect.addEventListener('change', function () {
                const invitationId = this.value;
                if (invitationId) {
                    window.location.href = '{{ route("invitation.import-kontak") }}?invitation_id=' + invitationId;
                }
            });
        }

        function updateSaveButton() {
            const hasInvitation = invitationIdInput && invitationIdInput.value;
            const hasContacts = contactList.querySelectorAll('.card').length > 0;
            if (saveBtn) {
                saveBtn.disabled = !(hasInvitation && hasContacts);
            }
        }

        pickBtn.addEventListener('click', async () => {
            if (!invitationIdInput.value) {
                alert('Pilih undangan terlebih dahulu!');
                return;
            }

            try {
                const contacts = await navigator.contacts.select(['name', 'tel'], {
                    multiple: true,
                });

                if (!contacts || contacts.length === 0) {
                    return;
                }

                contacts.forEach(contact => {
                    const fullName = [
                        contact.name[0] || '',
                        contact.name[1] || '',
                    ].filter(Boolean).join(' ') || 'Tanpa Nama';

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

        addManualBtn.addEventListener('click', () => {
            if (!invitationIdInput.value) {
                alert('Pilih undangan terlebih dahulu!');
                return;
            }
            addContactRow('', '');
            updateUI();
        });

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
            emptyState.style.display = hasContacts ? 'none' : 'block';
            formActions.style.display = hasContacts ? 'block' : 'none';
            updateSaveButton();
        }

        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!invitationIdInput.value) {
                alert('Pilih undangan terlebih dahulu!');
                return;
            }

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
                    emptyState.style.display = 'block';
                    formActions.style.display = 'none';
                    contactIndex = 0;

                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                }
            } catch (err) {
                console.error('Submit error:', err);
                alert('Gagal mengirim data: ' + err.message);
            }
        });

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        updateSaveButton();
    })();
    </script>
</body>
</html>

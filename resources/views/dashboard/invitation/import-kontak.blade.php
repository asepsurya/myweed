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
                <p class="text-muted small mb-0">Pilih kontak dari buku kontak HP Anda</p>
            </div>
            <div class="card-body px-4 pb-4">
                <div id="unsupportedWarning" class="alert alert-warning" style="display: none;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Browser Anda tidak mendukung Contact Picker API. Silakan gunakan Chrome atau Edge di Android.
                </div>

                <button id="pickContactsBtn" class="btn btn-primary btn-lg w-100 mb-3">
                    <i class="bi bi-people me-2"></i> Pilih dari Kontak
                </button>

                <div id="contactResult" class="mt-3" style="display: none;">
                    <h6 class="fw-semibold mb-2">Kontak Terpilih</h6>
                    <div id="contactList" class="list-group"></div>
                </div>

                <div id="emptyState" class="text-center text-muted py-4">
                    <i class="bi bi-person-lines-fill display-6 d-block mb-2"></i>
                    <small>Belum ada kontak yang dipilih</small>
                </div>
            </div>
        </div>
    </div>

    <script>
    (function () {
        const pickBtn = document.getElementById('pickContactsBtn');
        const resultDiv = document.getElementById('contactResult');
        const contactList = document.getElementById('contactList');
        const emptyState = document.getElementById('emptyState');
        const unsupportedWarning = document.getElementById('unsupportedWarning');

        const supported = 'contacts' in navigator;

        if (!supported) {
            pickBtn.disabled = true;
            pickBtn.classList.add('disabled');
            unsupportedWarning.style.display = 'block';
            return;
        }

        pickBtn.addEventListener('click', async () => {
            try {
                const contacts = await navigator.contacts.select(['name', 'tel'], {
                    multiple: true,
                });

                if (!contacts || contacts.length === 0) {
                    alert('Tidak ada kontak yang dipilih.');
                    return;
                }

                renderContacts(contacts);
            } catch (err) {
                if (err.name !== 'AbortError') {
                    console.error('Contact Picker error:', err);
                    alert('Gagal memilih kontak: ' + err.message);
                }
            }
        });

        function renderContacts(contacts) {
            contactList.innerHTML = '';

            contacts.forEach((contact, index) => {
                const fullName = [
                    contact.name[0] || '',
                    contact.name[1] || '',
                ].filter(Boolean).join(' ') || 'Tanpa Nama';

                const phone = (contact.tel && contact.tel[0]) || '-';

                const item = document.createElement('div');
                item.className = 'list-group-item d-flex align-items-center justify-content-between';
                item.innerHTML = `
                    <div>
                        <div class="fw-semibold">${escapeHtml(fullName)}</div>
                        <div class="small text-muted">${escapeHtml(phone)}</div>
                    </div>
                    <span class="badge bg-light text-dark border">#${index + 1}</span>
                `;

                contactList.appendChild(item);
            });

            emptyState.style.display = 'none';
            resultDiv.style.display = 'block';
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    })();
    </script>
</body>
</html>

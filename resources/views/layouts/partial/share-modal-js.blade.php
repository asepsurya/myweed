{{-- JavaScript pendukung modal share (samakan dengan rute /home) --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shareModal = document.getElementById('shareModalDynamic');
        if (!shareModal) return;

        const savedGuestsList = document.getElementById('savedGuestsList');
        const selectAllGuests = document.getElementById('selectAllGuests');
        const bulkSendBtn = document.getElementById('bulkSendBtn');
        const guestCountBadge = document.getElementById('guestCountBadge');
        const bukuTamuSidebar = document.getElementById('bukuTamuSidebar');
        const toggleBukuTamu = document.getElementById('toggleBukuTamu');
        const closeBukuTamu = document.getElementById('closeBukuTamu');

        function notifySwal(icon, title, text) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon: icon, title: title, text: text, confirmButtonColor: '#C6A962' });
            } else {
                alert(text || title);
            }
        }

        if (toggleBukuTamu) {
            toggleBukuTamu.addEventListener('click', () => {
                if (bukuTamuSidebar) {
                    const isHidden = bukuTamuSidebar.style.left === '-340px' || !bukuTamuSidebar.style.left;
                    bukuTamuSidebar.style.left = isHidden ? '0' : '-340px';
                }
            });
        }

        if (closeBukuTamu) {
            closeBukuTamu.addEventListener('click', () => {
                if (bukuTamuSidebar) {
                    bukuTamuSidebar.style.left = '-340px';
                }
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
                        const contacts = await navigator.contacts.select(['name', 'tel'], { multiple: false });
                        if (contacts && contacts.length > 0) {
                            const contact = contacts[0];
                            const fullName = [contact.name[0] || '', contact.name[1] || ''].filter(Boolean).join(' ');
                            if (recipientNameDynamic) {
                                recipientNameDynamic.value = fullName;
                            }
                            const phone = ((contact.tel && contact.tel[0]) || '').replace(/[^0-9]/g, '');
                            if (phone) {
                                const messageInput = document.getElementById('shareMessageDynamic');
                                let message = (messageInput && messageInput.value) || 'Halo [nama], undangan untuk Anda.\n\nTerima kasih!';
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

        shareModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const invId = button ? button.getAttribute('data-id') : null;
            const messageInput = document.getElementById('shareMessageDynamic');
            const recipientInput = document.getElementById('recipientNameDynamic');

            if (invId) {
                const messageDiv = document.getElementById('wa-message-' + invId);
                if (messageDiv && messageInput) {
                    messageInput.value = messageDiv.textContent.trim();
                }
            }
            if (recipientInput) recipientInput.value = '';

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
                    updateBulkButton();
                });
            });
        }

        function buildGuestMessage(name) {
            const messageInput = document.getElementById('shareMessageDynamic');
            let message = (messageInput && messageInput.value) || 'Halo [nama], undangan untuk Anda.\n\nTerima kasih!';
            return message.replace(/\[nama\]/g, name || '');
        }

        function openWaToGuest(cb) {
            const phone = (cb.dataset.phone || '').replace(/[^0-9]/g, '');
            if (!phone) {
                notifySwal('warning', 'Nomor tidak valid', 'Kontak "' + (cb.dataset.name || '') + '" belum memiliki nomor WhatsApp.');
                cb.checked = false;
                updateBulkButton();
                return;
            }
            const recipientInput = document.getElementById('recipientNameDynamic');
            if (recipientInput) recipientInput.value = cb.dataset.name || '';
            const url = 'https://wa.me/' + phone + '?text=' + encodeURIComponent(buildGuestMessage(cb.dataset.name));
            window.open(url, '_blank');
        }

        function sendToCheckedGuests() {
            const checked = savedGuestsList.querySelectorAll('.guest-checkbox:checked');
            if (checked.length === 0) return;

            const guests = Array.from(checked).map(cb => ({
                name: cb.dataset.name || '',
                phone: (cb.dataset.phone || '').replace(/[^0-9]/g, ''),
            })).filter(g => g.phone);

            if (guests.length === 0) {
                notifySwal('warning', 'Nomor tidak valid', 'Tidak ada kontak terpilih yang memiliki nomor WhatsApp.');
                return;
            }

            const recipientInput = document.getElementById('recipientNameDynamic');
            if (recipientInput && guests.length === 1) recipientInput.value = guests[0].name;

            let delay = 0;
            guests.forEach((guest) => {
                const url = 'https://wa.me/' + guest.phone + '?text=' + encodeURIComponent(buildGuestMessage(guest.name));
                setTimeout(() => { window.open(url, '_blank'); }, delay);
                delay += 1500;
            });

            checked.forEach(cb => { cb.checked = false; });
            updateBulkButton();
        }

        function updateBulkButton() {
            const checked = savedGuestsList.querySelectorAll('.guest-checkbox:checked');
            const count = checked.length;
            if (bulkSendBtn) {
                bulkSendBtn.style.display = count > 0 ? 'block' : 'none';
            }
            const countEl = document.getElementById('bulkSendCount');
            if (countEl) countEl.textContent = count;
            if (selectAllGuests) {
                const allCheckboxes = savedGuestsList.querySelectorAll('.guest-checkbox');
                selectAllGuests.checked = allCheckboxes.length > 0 && count === allCheckboxes.length;
            }
        }

        if (bulkSendBtn) {
            bulkSendBtn.addEventListener('click', sendToCheckedGuests);
        }

        if (selectAllGuests) {
            selectAllGuests.addEventListener('change', function () {
                const checkboxes = savedGuestsList.querySelectorAll('.guest-checkbox');
                checkboxes.forEach(cb => { cb.checked = this.checked; });
                updateBulkButton();
            });
        }
    });
</script>
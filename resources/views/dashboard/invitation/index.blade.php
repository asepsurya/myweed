<x-app-layout>
    <style>
        .card {
            border-radius: 10px 10px 0 0 !important;
        }
    </style>
    <div class=" py-10">
        <div class="max-w-7xl container mx-auto sm:px-6 lg:px-8">
            <div class="card adminuiux-card">
                <div class="card-header">
                    <div class="row g-2 align-items-center">

                        <!-- Judul -->
                        <div class="col-12 col-md">
                            <h6 class="mb-1 text-center text-md-start">
                                Aktivitas Undangan Terbaru
                            </h6>
                        </div>

                        <!-- Search -->
                        <div class="col-12 col-md-auto">
                            <input type="text" id="filterInvitation" class="form-control"
                                placeholder="Cari nama mempelai...">
                        </div>

                        <!-- Button -->
                        <div class="col-12 col-md-auto d-flex gap-2">
                            <button type="button" id="bulkDeleteBtn" class="btn btn-outline-danger d-none"
                                onclick="submitBulkDelete()">
                                <i class="bi bi-trash me-1"></i> Hapus Terpilih (<span id="selectedCount">0</span>)
                            </button>
                            <a href="{{ route('invitation.create') }}" class="btn btn-outline-theme w-100 w-md-auto">
                                <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                            </a>
                        </div>

                    </div>
                </div>


                <!-- List Aktivitas -->
                <form id="bulkDeleteForm" action="{{ route('invitation.bulk-delete') }}" method="POST">
                    @csrf
                    <ul class="list-group list-group-flush bg-none">
                        <li class="list-group-item  py-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label small fw-bold" for="selectAll">Pilih Semua</label>
                            </div>
                        </li>

                        @forelse ($invitations as $inv)
                            <li class="list-group-item invitation-item"
                                data-name="{{ strtolower($inv->groom_name . ' ' . $inv->bride_name) }}">
                                <div class="row gx-3 align-items-center">
                                    <div class="col-auto">
                                        <div class="form-check">
                                            <input class="form-check-input row-checkbox" type="checkbox" name="ids[]"
                                                value="{{ $inv->id }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <p class="mb-1 fw-medium">
                                            <a href="{{ route('invitation.detail', $inv->slug) }}">
                                                {{ ($inv->bride_name ?: 'Mempelai Wanita') }} & {{ ($inv->groom_name ?: 'Mempelai Pria') }}
                                            </a>
                                        </p>
                                        <p class="text-secondary small">
                                            Tanggal Nikah: {{ $inv->wedding_date ?: '-' }} | Dibuat oleh: <span
                                                class="fw-medium">{{ $inv->user->name }}</span>
                                        </p>

                                    </div>

                                    <div class="col-auto text-end">

                                        <div class="badge badge-sm text-bg-primary">
                                            Aktif
                                        </div>
                                    </div>

                                    <div class="col-auto d-flex gap-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('invitation.edit', $inv) }}"
                                            class="avatar avatar-40 rounded-circle border border-theme-1 bg-theme-1-subtle text-theme-1 d-flex align-items-center justify-content-center">
                                            <i class="bi bi-pencil h5 mb-0"></i>
                                        </a>

                                        <!-- Tombol Share WA -->
                                        <button type="button"
                                            class="avatar avatar-40 rounded-circle border border-success bg-success-subtle text-success d-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#waModal{{ $inv->id }}"
                                            title="Bagikan via WhatsApp">
                                            <i class="bi bi-whatsapp h5 mb-0"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button"
                                            onclick="confirmDelete('{{ route('invitation.destroy', $inv) }}')"
                                            class="avatar avatar-40 rounded-circle border border-danger bg-danger-subtle text-danger d-flex align-items-center justify-content-center">
                                            <i class="bi bi-trash h5 mb-0"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>

                        @empty
                            <div
                                class="card-body d-flex flex-column justify-content-center align-items-center p-5 text-muted">
                                <i class="bi bi-folder-x fs-1 mb-3"></i>
                                <p class="mb-0">Data Tidak Ditemukan</p>
                            </div>

                        @endforelse

                    </ul>
                </form>
            </div>
        </div>
    </div>

    <!-- Hidden form for single delete -->
    <form id="deleteForm" method="POST" style="display:none">
        @csrf
        @method('DELETE')
    </form>

    @foreach ($invitations as $inv)
        <div class="modal fade" id="waModal{{ $inv->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bagikan Undangan via WhatsApp</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Input Nama Penerima -->
                        <div class="mb-3">
                            <label for="recipientName{{ $inv->id }}" class="form-label">Nama Penerima:</label>
                            <input type="text" class="form-control" id="recipientName{{ $inv->id }}"
                                placeholder="Masukkan nama penerima">
                        </div>

                        <!-- Pesan Undangan -->
                        <div class="mb-3">
                            <label for="waMessage{{ $inv->id }}" class="form-label">Pesan Undangan:</label>
                            <textarea class="form-control" id="waMessage{{ $inv->id }}" rows="10">@include('dashboard.invitation.pesan')
                            </textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success"
                            onclick="shareWAWithRecipient('recipientName{{ $inv->id }}','waMessage{{ $inv->id }}')">
                            <i class="bi bi-whatsapp me-1"></i> Share via WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function confirmDelete(url) {
            if (confirm('Apakah Anda yakin ingin menghapus undangan ini? Semua data dan file akan dihapus permanen.')) {
                const form = document.getElementById('deleteForm');
                form.action = url;
                form.submit();
            }
        }

        document.getElementById('filterInvitation').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const items = document.querySelectorAll('.invitation-item');
            const noData = document.getElementById('noDataMessage');

            let visibleCount = 0;

            items.forEach(item => {
                const name = item.dataset.name;
                if (name.includes(keyword)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Tampilkan pesan jika tidak ada data
            if (visibleCount === 0) {
                noData.classList.remove('d-none');
            } else {
                noData.classList.add('d-none');
            }
        });

        // --- Bulk Delete Logic ---
        const selectAll = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        const selectedCount = document.getElementById('selectedCount');

        function updateBulkDeleteUI() {
            const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
            selectedCount.textContent = checkedCount;
            if (checkedCount > 0) {
                bulkDeleteBtn.classList.remove('d-none');
            } else {
                bulkDeleteBtn.classList.add('d-none');
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                rowCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateBulkDeleteUI();
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBulkDeleteUI);
        });

        function submitBulkDelete() {
            if (confirm('Apakah Anda yakin ingin menghapus ' + document.querySelectorAll('.row-checkbox:checked').length + ' undangan terpilih?')) {
                document.getElementById('bulkDeleteForm').submit();
            }
        }
    </script>


    <script>
        function shareWAWithRecipient(recipientId, messageId) {
            const recipient = document.getElementById(recipientId).value.trim();
            if (!recipient) {
                alert('Silakan masukkan nama penerima!');
                return;
            }

            let message = document.getElementById(messageId).value;

            // Ganti placeholder untuk tampilan nama di pesan
            message = message.replace(/\[nama\]/g, recipient);
            
            // Ganti placeholder untuk parameter URL dengan URL encoded string (spasi menjadi %20 atau +)
            // encodeURIComponent akan membuat spasi menjadi %20
            message = message.replace(/\[nama_url\]/g, encodeURIComponent(recipient));

            // Buka WhatsApp
            const waUrl = "https://wa.me/?text=" + encodeURIComponent(message);
            window.open(waUrl, '_blank');
        }
    </script>

</x-app-layout>
<x-app-layout>
    <!-- TAB 1: Aktivitas Undangan -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="py-10">
            <div class="container">

                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="mb-0">Aktivitas Undangan Terbaru</h4>
                        @php $status = auth()->user()->subscriptionStatus(); @endphp
                        @if($status == 'active')
                            <span class="badge bg-warning text-dark small mt-1">
                                <i class="bi bi-star-fill me-1"></i> Premium 
                                @if(auth()->user()->isAdmin())
                                    (Admin Access)
                                @elseif(auth()->user()->subscription)
                                    (Aktif s/d: {{ auth()->user()->subscription->end_date->format('d M Y') }})
                                @endif
                            </span>
                        @else
                            <span class="badge bg-light text-dark border small mt-1">Free Plan (Limit 1 Undangan)</span>
                        @endif
                    </div>

                    <!-- Container tombol -->
                    <div class=" w-md-100 d-flex justify-content-md-end gap-2">
                        @if($status == 'free' || $status == 'expired')
                             <a href="{{ route('subscribe.page') }}" class="btn btn-sm btn-warning d-flex align-items-center">
                                <i class="bi bi-gem me-2"></i> Aktifkan Subscription
                             </a>
                        @endif
                        <button type="button" id="bulkDeleteBtn" class="btn btn-sm btn-outline-danger d-none"
                            onclick="submitBulkDelete()">
                            <i class="bi bi-trash me-1"></i> Hapus (<span id="selectedCount">0</span>)
                        </button>
                        <a href="{{ route('invitation.create') }}" class="btn btn-sm btn-outline-primary  w-md-auto">
                            <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                        </a>
                    </div>
                </div>

                <form id="bulkDeleteForm" action="{{ route('invitation.bulk-delete') }}" method="POST">
                    @csrf
                    <div class="mb-2 px-3 py-2  rounded d-flex align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label small fw-bold" for="selectAll">Pilih Semua</label>
                        </div>
                    </div>
                    <ul class="list-group">
                        @forelse ($invitations as $inv)
                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-2 shadow-sm rounded"
                                style="transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.transform='translateY(0)'">
                                <div class="d-flex align-items-center flex-grow-1 gap-3">
                                    <div class="form-check me-2">
                                        <input class="form-check-input row-checkbox" type="checkbox" name="ids[]"
                                            value="{{ $inv->id }}">
                                    </div>

                                    <!-- Info Undangan -->
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-person-circle fs-3 text-primary"></i>
                                        <div>
                                            <p class="mb-0 fw-semibold">
                                                <a href="{{ route('invitation.detail', $inv->slug) }}">
                                                    {{ ($inv->bride_name ?: 'Mempelai Wanita') }} & {{ ($inv->groom_name ?: 'Mempelai Pria') }}
                                                </a>
                                            </p>
                                            <small class="text-muted">Tanggal Nikah: {{ $inv->wedding_date ?: '-' }}</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Badge Status -->


                                <!-- Tombol Aksi -->
                                <div class="d-flex justify-content-end">

                                    <!-- DESKTOP -->
                                    <div class="d-none d-md-flex gap-2">
                                        <a href="{{ route('invitation.show', $inv->slug) }}"
                                            class="btn btn-outline-primary btn-sm" target="_blank" title="Lihat">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('invitation.edit', $inv) }}"
                                            class="btn btn-outline-primary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#waModal{{ $inv->id }}" title="Bagikan WhatsApp">
                                            <i class="bi bi-whatsapp"></i>
                                        </button>

                                        <!-- Tombol Hapus (Desktop) -->
                                        <button type="button"
                                            onclick="confirmDelete('{{ route('invitation.destroy', $inv) }}')"
                                            class="btn btn-outline-danger btn-sm" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- MOBILE -->
                                    <div class="dropdown d-md-none">
                                        <button class="btn btn-outline-secondary btn-sm" type="button"
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
                                                <button class="dropdown-item text-success" data-bs-toggle="modal"
                                                    data-bs-target="#waModal{{ $inv->id }}">
                                                    <i class="bi bi-whatsapp me-2"></i> Bagikan WhatsApp
                                                </button>
                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>
                                                <button type="button"
                                                    onclick="confirmDelete('{{ route('invitation.destroy', $inv) }}')"
                                                    class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i> Hapus
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                            </li>

                            <!-- Modal WhatsApp -->
                            <div class="modal fade" id="waModal{{ $inv->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title"><i class="bi bi-whatsapp me-2"></i> Bagikan Undangan
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="recipientName{{ $inv->id }}"
                                                    placeholder="Nama penerima">
                                                <label for="recipientName{{ $inv->id }}">Nama Penerima</label>
                                            </div>
                                            <div class="form-floating">
                                                <textarea class="form-control" id="waMessage{{ $inv->id }}"
                                                    placeholder="Pesan undangan" style="height:250px">Assalamu’alaikum Wr. Wb.

Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i [nama] untuk menghadiri acara pernikahan kami:

{{ $inv->bride_name }} & {{ $inv->groom_name }}

Detail acara dan lokasi dapat dilihat melalui tautan undangan digital berikut:
{{ route('invitation.show', [$inv->slug]) }}?to=[nama]

Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.

Terima kasih.
Wassalamu’alaikum Wr. Wb.</textarea>
                                                <label for="waMessage{{ $inv->id }}">Pesan Undangan</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="button" class="btn btn-success"
                                                onclick="shareWAWithRecipient('recipientName{{ $inv->id }}','waMessage{{ $inv->id }}')">
                                                <i class="bi bi-whatsapp me-1"></i> Share via WhatsApp
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card flex items-center justify-center min-h-[60vh] p-5">
                                <div class="text-center">
                                    <!-- Icon -->


                                    <!-- Text -->
                                    <h3 class="text-lg font-semibold text-gray-700">
                                        Belum ada undangan yang dibuat
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Mulai buat undangan pertamamu sekarang
                                    </p>

                                    <!-- Button -->
                                    <a href="{{ route('invitation.create') }}" class="btn btn-sm  btn-outline-primary">
                                        + Buat Undangan
                                    </a>
                                </div>
                            </div>


                        @endforelse
                    </ul>
                </form>

            </div>
        </div>
        <!-- Hidden form for single delete -->
        <form id="deleteForm" method="POST" style="display:none">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function confirmDelete(url) {
                if (confirm('Hapus undangan ini? Semua data akan hilang permanen.')) {
                    const form = document.getElementById('deleteForm');
                    form.action = url;
                    form.submit();
                }
            }

            function shareWAWithRecipient(recipientId, messageId) {
                const recipient = document.getElementById(recipientId).value.trim();
                if (!recipient) {
                    alert('Silakan masukkan nama penerima!');
                    return;
                }

                let message = document.getElementById(messageId).value;
                message = message.replace(/\[nama\]/g, recipient);

                const waUrl = "https://wa.me/?text=" + encodeURIComponent(message);
                window.open(waUrl, '_blank');
            }

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
                if (confirm('Hapus ' + document.querySelectorAll('.row-checkbox:checked').length + ' undangan terpilih?')) {
                    document.getElementById('bulkDeleteForm').submit();
                }
            }
        </script>
</x-app-layout>
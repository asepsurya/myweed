<x-app-layout>
    <!-- TAB 1: Aktivitas Undangan -->
    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
        <div class="py-10">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Aktivitas Undangan Terbaru</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('invitation.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
                        <a href="{{ route('invitation.create') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                        </a>
                    </div>
                </div>

                <ul class="list-group">
                    @forelse ($invitations as $inv)
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-2 shadow-sm rounded" style="transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">

                        <!-- Info Undangan -->
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-person-circle fs-3 text-primary"></i>
                            <div>
                                <p class="mb-0 fw-semibold">
                                    <a href="{{ route('invitation.detail', $inv->slug) }}">
                                        {{ $inv->bride_name }} & {{ $inv->groom_name }}
                                    </a>
                                </p>
                                <small class="text-muted">Tanggal Nikah: {{ $inv->wedding_date }}</small>
                            </div>
                        </div>

                        <!-- Badge Status -->


                        <!-- Tombol Aksi -->
                        <div class="d-flex gap-2">
                            <a href="{{ route('invitation.show', $inv->slug) }}" class="btn btn-outline-primary btn-sm" title="Edit" target="_blank">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('invitation.edit', $inv) }}" class="btn btn-outline-primary btn-sm" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#waModal{{ $inv->id }}" title="Bagikan via WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </button>
                        </div>
                    </li>

                    <!-- Modal WhatsApp -->
                    <div class="modal fade" id="waModal{{ $inv->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title"><i class="bi bi-whatsapp me-2"></i> Bagikan Undangan</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="recipientName{{ $inv->id }}" placeholder="Nama penerima">
                                        <label for="recipientName{{ $inv->id }}">Nama Penerima</label>
                                    </div>
                                    <div class="form-floating">
                                        <textarea class="form-control" id="waMessage{{ $inv->id }}" placeholder="Pesan undangan" style="height:200px">
Assalamu’alaikum Wr. Wb.,

Dengan hormat, kami mengundang Bapak/Ibu/Saudara/i [nama] untuk hadir dalam acara pernikahan kami.

Detail acara dapat dilihat di tautan berikut:
{{ route('invitation.show', [$inv->slug]) }}?to=[nama]

Kami merasa bahagia dan terhormat apabila Bapak/Ibu/Saudara/i berkenan hadir serta memberikan doa restu.

Hormat kami,
Maisaroh & Aceng Fikri

Wassalamu’alaikum Wr. Wb.
                                            </textarea>
                                        <label for="waMessage{{ $inv->id }}">Pesan Undangan</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-success" onclick="shareWAWithRecipient('recipientName{{ $inv->id }}','waMessage{{ $inv->id }}')">
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

            </div>
        </div>
        <script>
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

        </script>
</x-app-layout>

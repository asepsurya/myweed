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
                            <input type="text"
                                id="filterInvitation"
                                class="form-control"
                                placeholder="Cari nama mempelai...">
                        </div>

                        <!-- Button -->
                        <div class="col-12 col-md-auto d-grid d-md-block">
                            <a href="{{ route('invitation.create') }}"
                            class="btn btn-outline-theme w-100 w-md-auto">
                                <i class="bi bi-plus-circle me-1"></i> Buat Undangan
                            </a>
                        </div>

                    </div>
                </div>


                <!-- List Aktivitas -->
                <ul class="list-group list-group-flush bg-none">

                    @forelse ($invitations as $inv)
                        <li class="list-group-item invitation-item"  data-name="{{ strtolower($inv->groom_name . ' ' . $inv->bride_name) }}">
                            <div class="row gx-3 align-items-center">

                                <div class="col">
                                    <p class="mb-1 fw-medium">
                                       <a href="{{ route('invitation.detail', $inv->slug) }}">{{ $inv->bride_name }} & {{ $inv->groom_name }}</a>
                                    </p>
                                    <p class="text-secondary small">
                                        Tanggal Nikah: {{ $inv->wedding_date }}  |  Dibuat oleh: <span class="fw-medium">{{ $inv->user->name }}</span>
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
                                </div>
                            </div>
                        </li>

                    @empty
                        <div class="card-body d-flex flex-column justify-content-center align-items-center p-5 text-muted">
                            <i class="bi bi-folder-x fs-1 mb-3"></i>
                            <p class="mb-0">Data Tidak Ditemukan</p>
                        </div>

                    @endforelse

                </ul>
            </div>
        </div>
    </div>
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
                        <input type="text" class="form-control" id="recipientName{{ $inv->id }}" placeholder="Masukkan nama penerima">
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
                    <button type="button" class="btn btn-success" onclick="shareWAWithRecipient('recipientName{{ $inv->id }}','waMessage{{ $inv->id }}')">
                        <i class="bi bi-whatsapp me-1"></i> Share via WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

<script>
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
</script>


    <script>
        function shareWAWithRecipient(recipientId, messageId) {
            const recipient = document.getElementById(recipientId).value.trim();
            if (!recipient) {
                alert('Silakan masukkan nama penerima!');
                return;
            }

            let message = document.getElementById(messageId).value;

            // Ganti semua placeholder [nama] dengan nama penerima
            message = message.replace(/\[nama\]/g, recipient);

            // Buka WhatsApp
            const waUrl = "https://wa.me/?text=" + encodeURIComponent(message);
            window.open(waUrl, '_blank');
        }
    </script>

</x-app-layout>

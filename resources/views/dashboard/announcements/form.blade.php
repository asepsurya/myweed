<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-pin-angle-fill me-2"></i>
                {{ isset($announcement) ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}
            </h2>
            <a href="{{ route('announcements.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="container mt-4" style="max-width: 700px;">
        <div class="card">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($announcement) ? route('announcements.update', $announcement) : route('announcements.store') }}" method="POST">
                    @csrf
                    @if(isset($announcement))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="message" class="form-label fw-semibold">Pesan Pengumuman</label>
                        <textarea name="message" id="message" class="form-control" rows="3" maxlength="1000"
                            placeholder="Contoh: ✨ BARU: Buat & personalisasi undangan digital dalam hitungan menit.">{{ old('message', $announcement->message ?? '✨ <strong>BARU:</strong> Buat &amp; personalisasi undangan digital pernikahan, ulang tahun, dan syukuran dalam hitungan menit.') }}</textarea>
                        <div class="form-text">Teks yang tampil pada banner. Boleh menyertakan tag HTML dasar seperti &lt;strong&gt;.</div>
                    </div>

                    <div class="mb-3">
                        <label for="link_text" class="form-label fw-semibold">Teks Link (Opsional)</label>
                        <input type="text" name="link_text" id="link_text" class="form-control"
                            value="{{ old('link_text', $announcement->link_text ?? 'Coba Sekarang →') }}"
                            placeholder="Contoh: Coba Sekarang →">
                        <div class="form-text">Teks ajakan yang tampil di sisi kanan banner.</div>
                    </div>

                    <div class="mb-3">
                        <label for="link_url" class="form-label fw-semibold">URL Tujuan (Opsional)</label>
                        <input type="text" name="link_url" id="link_url" class="form-control"
                            value="{{ old('link_url', $announcement->link_url ?? '/cari-tema') }}"
                            placeholder="Contoh: /cari-tema atau https://contoh.com">
                        <div class="form-text">Bisa berupa path internal (mis. /cari-tema) atau URL lengkap. Kosongkan untuk memakai /cari-tema.</div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                {{ old('is_active', isset($announcement) ? $announcement->is_active : true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Aktif (tampilkan banner)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('announcements.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> {{ isset($announcement) ? 'Simpan Perubahan' : 'Tambah Pengumuman' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('music.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Tambah Lagu</h4>
            <p class="text-muted mb-0 small">Unggah file musik dan cover lagu</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data" id="musicForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Judul Lagu <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="Contoh: Perfect" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penyanyi <span class="text-danger">*</span></label>
                        <input type="text" name="artist" class="form-control @error('artist') is-invalid @enderror"
                            value="{{ old('artist') }}" placeholder="Contoh: Ed Sheeran" required>
                        @error('artist')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">File Musik <span class="text-danger">*</span></label>
                        <input type="file" name="music_file" id="musicFileInput" class="form-control @error('music_file') is-invalid @enderror"
                            accept="audio/mp3,audio/wav,audio/ogg" required>
                        <div class="form-text">Format: MP3, WAV, OGG. Maksimal 20 MB.</div>
                        <audio id="uploadPreviewAudio" controls class="mt-2" style="max-width: 320px; display: none;"></audio>
                        <div class="text-muted small mt-1" id="uploadDuration"></div>
                        @error('music_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cover Lagu</label>
                        <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">Format: JPG, JPEG, PNG, WebP. Maksimal 5 MB.</div>
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('music.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const musicInput = document.getElementById('musicFileInput');
            const previewAudio = document.getElementById('uploadPreviewAudio');
            const durationText = document.getElementById('uploadDuration');

            if (musicInput && previewAudio && durationText) {
                musicInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (!file) {
                        previewAudio.style.display = 'none';
                        durationText.textContent = '';
                        return;
                    }

                    const url = URL.createObjectURL(file);
                    previewAudio.src = url;
                    previewAudio.style.display = 'block';
                    durationText.textContent = 'Memuat durasi...';

                    previewAudio.addEventListener('loadedmetadata', function () {
                        const mins = Math.floor(previewAudio.duration / 60);
                        const secs = Math.floor(previewAudio.duration % 60);
                        durationText.textContent = 'Durasi terdeteksi: ' + mins + ':' + String(secs).padStart(2, '0');
                    });

                    previewAudio.addEventListener('error', function () {
                        durationText.textContent = 'Gagal membaca durasi.';
                    });
                });
            }
        });
    </script>
</x-app-layout>

<x-app-layout>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Tambah YouTube Music</h4>
            <p class="text-muted mb-0">Masukkan link YouTube untuk menambahkan lagu ke library</p>
        </div>
        <div class="w-100 w-md-auto">
            <a href="{{ route('youtube-music.index') }}" class="btn btn-outline-secondary w-100 w-md-auto">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-plus-lg me-1"></i> Tambah Satu</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('youtube-music.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold mb-2">Judul Lagu <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Contoh: Romantic Wedding" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="artist" class="form-label fw-semibold mb-2">Penyanyi</label>
                            <input type="text" id="artist" name="artist" value="{{ old('artist') }}" class="form-control @error('artist') is-invalid @enderror" placeholder="Contoh: Unknown Artist">
                            @error('artist')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                <div class="mb-3">
                    <label for="youtube_url" class="form-label fw-semibold mb-2">Link YouTube <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white border-0"><i class="bi bi-youtube"></i></span>
                        <input type="text" id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}" class="form-control @error('youtube_url') is-invalid @enderror" placeholder="https://www.youtube.com/watch?v=..." required>
                        <button type="button" class="btn btn-outline-secondary" id="fetchYoutubeInfo" title="Ambil info dari YouTube">
                            <i class="bi bi-arrow-clockwise"></i>
                        </button>
                    </div>
                    @error('youtube_url')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                        <div class="mb-3">
                            <label for="cover_url" class="form-label fw-semibold mb-2">Cover URL (Opsional)</label>
                            <input type="text" id="cover_url" name="cover_url" value="{{ old('cover_url') }}" class="form-control @error('cover_url') is-invalid @enderror" placeholder="https://...">
                            <small class="text-muted">Kosongkan untuk menggunakan thumbnail YouTube secara otomatis.</small>
                            @error('cover_url')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Aktif</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary text-white">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-list-ul me-1"></i> Tambah Beberapa (Bulk)</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('youtube-music.bulk-store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="bulk_youtube" class="form-label fw-semibold mb-2">Daftar Link YouTube</label>
                            <textarea id="bulk_youtube" name="bulk_youtube" rows="12" class="form-control @error('bulk_youtube') is-invalid @enderror" placeholder="Format: Judul | Penyanyi | Link YouTube&#10;Contoh:&#10;Romantic Wedding | Unknown Artist | https://www.youtube.com/watch?v=...&#10;https://www.youtube.com/watch?v=...&#10;https://youtu.be/..."></textarea>
                            <small class="text-muted">Satu baris per lagu. Format: <code>Judul | Penyanyi | URL</code> atau hanya <code>URL</code> saja. Jika hanya URL, judul dan penyanyi akan diambil otomatis dari YouTube. Cover otomatis dari thumbnail YouTube.</small>
                            @error('bulk_youtube')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="bulk_is_active" name="is_active" value="1" checked>
                                <label class="form-check-label fw-semibold" for="bulk_is_active">Aktifkan semua</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary text-white">
                            <i class="bi bi-check-lg me-1"></i> Import Semua
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlInput = document.getElementById('youtube_url');
        const fetchBtn = document.getElementById('fetchYoutubeInfo');
        const titleInput = document.getElementById('title');
        const artistInput = document.getElementById('artist');
        const coverInput = document.getElementById('cover_url');

        function extractYoutubeId(url) {
            const match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/|u\/\w\/|shorts\/)([A-Za-z0-9_-]{11}))/i);
            return match ? match[1] : null;
        }

        async function fetchYoutubeInfo() {
            const url = urlInput.value.trim();
            if (!url) {
                alert('Masukkan link YouTube terlebih dahulu.');
                return;
            }

            const youtubeId = extractYoutubeId(url);
            if (!youtubeId) {
                alert('Format link YouTube tidak valid.');
                return;
            }

            fetchBtn.disabled = true;
            fetchBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            try {
                const response = await fetch('https://www.youtube.com/oembed?url=' + encodeURIComponent(url) + '&format=json');
                if (!response.ok) throw new Error('Failed');

                const data = await response.json();
                if (data.title && !titleInput.value) titleInput.value = data.title;
                if (data.author_name && !artistInput.value) artistInput.value = data.author_name;
                if (!coverInput.value) coverInput.value = 'https://img.youtube.com/vi/' + youtubeId + '/mqdefault.jpg';
            } catch (e) {
                console.error('Failed to fetch YouTube info:', e);
                if (!titleInput.value) titleInput.value = 'YouTube Music';
                if (!artistInput.value) artistInput.value = 'Unknown Artist';
                if (!coverInput.value) coverInput.value = 'https://img.youtube.com/vi/' + youtubeId + '/mqdefault.jpg';
            } finally {
                fetchBtn.disabled = false;
                fetchBtn.innerHTML = '<i class="bi bi-arrow-clockwise"></i>';
            }
        }

        if (fetchBtn) {
            fetchBtn.addEventListener('click', fetchYoutubeInfo);
        }

        if (urlInput) {
            urlInput.addEventListener('blur', function () {
                if (urlInput.value && !titleInput.value && !artistInput.value) {
                    fetchYoutubeInfo();
                }
            });
        }
    });
</script>

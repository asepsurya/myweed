<x-app-layout>
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('music.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Edit Lagu</h4>
            <p class="text-muted mb-0 small">Perbarui informasi lagu</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('music.update', $music) }}" method="POST" enctype="multipart/form-data" id="musicForm">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Judul Lagu <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $music->title) }}" placeholder="Contoh: Perfect" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penyanyi <span class="text-danger">*</span></label>
                        <input type="text" name="artist" class="form-control @error('artist') is-invalid @enderror"
                            value="{{ old('artist', $music->artist) }}" placeholder="Contoh: Ed Sheeran" required>
                        @error('artist')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cover Lagu</label>
                        <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah cover.</div>
                        @if($music->cover_url)
                            <img src="{{ filter_var($music->cover_url, FILTER_VALIDATE_URL) ? $music->cover_url : asset('storage/' . $music->cover_url) }}"
                                class="mt-2 rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" {{ old('is_active', $music->is_active) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !old('is_active', $music->is_active) ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('music.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-megaphone me-2"></i>
                {{ isset($promotion) ? 'Edit Promosi' : 'Tambah Promosi' }}
            </h2>
            <a href="{{ route('promotions.index') }}" class="btn btn-outline-secondary btn-sm">
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

                <form action="{{ isset($promotion) ? route('promotions.update', $promotion) : route('promotions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($promotion))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Promosi</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $promotion->title ?? '') }}" placeholder="Contoh: Diskon Akhir Tahun">
                    </div>

                    <div class="alert alert-light border small mb-4">
                        <div class="fw-semibold mb-1">Pilih salah satu jenis media promosi:</div>
                        <ul class="mb-0 ps-3">
                            <li>Gambar (jpg, png, webp)</li>
                            <li>Video (mp4, mov, webm, ogv, m4v) &mdash; otomatis diputar tanpa suara</li>
                            <li>Link YouTube &mdash; otomatis diputar tanpa suara</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">Gambar Promosi</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        @if(isset($promotion) && $promotion->image)
                            <div class="mt-3 position-relative d-inline-block">
                                <img src="{{ asset('storage/' . $promotion->image) }}" alt="Preview" style="max-height: 200px; border-radius: 12px; border: 1px solid var(--bs-border-color);">
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                <label class="form-check-label small text-danger" for="remove_image">Hapus gambar saat ini</label>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="video_file" class="form-label fw-semibold">Video Promosi</label>
                        <input type="file" name="video_file" id="video_file" class="form-control" accept="video/*">
                        @if(isset($promotion) && $promotion->video_file)
                            <div class="mt-3">
                                <video src="{{ asset('storage/' . $promotion->video_file) }}" controls muted style="max-height: 200px; border-radius: 12px; border: 1px solid var(--bs-border-color);"></video>
                                <div class="form-text text-truncate">File saat ini: {{ basename($promotion->video_file) }}</div>
                            </div>
                        @endif
                        @if(isset($promotion) && ($promotion->video_file || $promotion->video_url))
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_video" id="remove_video" value="1">
                                <label class="form-check-label small text-danger" for="remove_video">Hapus video / link YouTube saat ini</label>
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="video_url" class="form-label fw-semibold">Link YouTube (Opsional)</label>
                        <input type="url" name="video_url" id="video_url" class="form-control" value="{{ old('video_url', $promotion->video_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=...">
                        <div class="form-text">Tempel link YouTube. Video akan diputar otomatis tanpa suara.</div>
                    </div>

                    <div class="mb-3">
                        <label for="link_url" class="form-label fw-semibold">Link URL Tujuan (Opsional)</label>
                        <input type="url" name="link_url" id="link_url" class="form-control" value="{{ old('link_url', $promotion->link_url ?? '') }}" placeholder="https://contoh.com/promo">
                        <div class="form-text">Link tujuan saat banner promosi diklik. Kosongkan jika tidak ada.</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label fw-semibold">Urutan Tampil</label>
                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $promotion->sort_order ?? 0) }}" min="0">
                                <div class="form-text">Semakin kecil, semakin awal ditampilkan.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', isset($promotion) ? $promotion->is_active : true) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('promotions.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> {{ isset($promotion) ? 'Simpan Perubahan' : 'Tambah Promosi' }}
                        </button>
                    </div>
                </form>

                @if(isset($promotion))
                    <form id="delete-promo-form-{{ $promotion->id }}" action="{{ route('promotions.destroy', $promotion) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
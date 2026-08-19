<x-app-layout>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Tambah Kontributor</h4>
            <p class="text-muted mb-0">Tambahkan kontributor baru untuk tabungan</p>
        </div>
        <a href="{{ route('savings.contributor.index') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card adminuiux-card shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header bg-transparent border-0 py-3">
            <h5 class="mb-0 fw-bold">Form Kontributor</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('savings.contributor.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama *</label>
                    <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}" placeholder="Nama kontributor">
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Tautkan ke User</label>
                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">Pilih User (opsional)</option>
                        @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $u)
                            <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Pilih user yang sudah terdaftar, atau kosongkan untuk mengundang via email.</small>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="email@example.com">
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="relationship" class="form-label">Hubungan</label>
                    <input type="text" name="relationship" id="relationship" class="form-control" value="{{ old('relationship') }}" placeholder="Contoh: Keluarga, Teman, dll">
                    @error('relationship')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_external" id="is_external" value="1" {{ old('is_external') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_external">Kontributor Eksternal</label>
                    </div>
                    <small class="text-muted">Aktifkan jika kontributor bukan user terdaftar.</small>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gold-custom">Simpan Kontributor</button>
                    <a href="{{ route('savings.contributor.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

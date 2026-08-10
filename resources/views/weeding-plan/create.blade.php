<x-app-layout>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Tambah Rencana Weeding</h4>
            <p class="text-muted mb-0">Buat rencana persiapan pernikahan baru</p>
        </div>
        <a href="{{ route('weeding-plan.index') }}" class="btn btn-outline-secondary flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('weeding-plan.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="task_name" class="form-label fw-semibold">Nama Tugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('task_name') is-invalid @enderror"
                                id="task_name" name="task_name" value="{{ old('task_name') }}" required
                                placeholder="Contoh: Pesan akad nikah">
                            @error('task_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="3"
                                placeholder="Jelaskan detail tugas...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror"
                                        id="category" name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="akad" {{ old('category') == 'akad' ? 'selected' : '' }}>Akad</option>
                                        <option value="resepsi" {{ old('category') == 'resepsi' ? 'selected' : '' }}>Resepsi</option>
                                        <option value="persiapan" {{ old('category') == 'persiapan' ? 'selected' : '' }}>Persiapan</option>
                                        <option value="pakaian" {{ old('category') == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                                        <option value="kado" {{ old('category') == 'kado' ? 'selected' : '' }}>Kado</option>
                                        <option value="tamu" {{ old('category') == 'tamu' ? 'selected' : '' }}>Tamu</option>
                                        <option value="dokumentasi" {{ old('category') == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                                        <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label fw-semibold">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror"
                                        id="priority" name="priority" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label fw-semibold">Batas Waktu</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                        id="due_date" name="due_date" value="{{ old('due_date') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="invitation_id" class="form-label fw-semibold">Terkait Undangan</label>
                                    <select class="form-select @error('invitation_id') is-invalid @enderror"
                                        id="invitation_id" name="invitation_id">
                                        <option value="">Pilih Undangan (Opsional)</option>
                                        @foreach($invitations as $inv)
                                            <option value="{{ $inv->id }}" {{ old('invitation_id') == $inv->id ? 'selected' : '' }}>
                                                {{ $inv->groom_name }} & {{ $inv->bride_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('invitation_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-semibold">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                id="notes" name="notes" rows="8"
                                placeholder="Tambahkan catatan tambahan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('weeding-plan.index') }}" class="btn btn-outline-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary text-white">
                        <i class="bi bi-check-lg me-1"></i> Simpan Rencana
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

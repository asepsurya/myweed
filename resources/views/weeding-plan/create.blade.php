<x-app-layout>
    <style>
        /* Tema & Font */
        h4 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: var(--bs-body-color);
        }

        .form-card {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(27, 42, 74, 0.05);
            overflow: hidden;
        }

        [data-bs-theme="dark"] .form-card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-size: 0.875rem;
            color: var(--bs-secondary-color);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            background-color: var(--bs-body-bg);
            border-color: var(--bs-border-color);
            color: var(--bs-body-color);
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--adminuiux-theme-1);
            box-shadow: 0 0 0 0.2rem rgba(198, 169, 98, 0.2);
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
        }

        .form-control::placeholder {
            color: var(--bs-tertiary-color);
        }

        /* Tom-Select Theme Adaptation */
        .ts-wrapper .ts-control {
            border-radius: 10px !important;
            padding: 0.75rem 1rem !important;
            background-color: var(--bs-body-bg) !important;
            border-color: var(--bs-border-color) !important;
            color: var(--bs-body-color) !important;
            box-shadow: none !important;
        }

        .ts-wrapper.focus .ts-control {
            border-color: var(--adminuiux-theme-1) !important;
            box-shadow: 0 0 0 0.2rem rgba(198, 169, 98, 0.2) !important;
        }

        /* Button Styles */
        .btn-gold-custom {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover));
            border: none;
            color: var(--adminuiux-theme-1-text);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-gold-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(198, 169, 98, 0.3);
            color: var(--adminuiux-theme-1-text);
        }

        .btn-outline-custom {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-color: var(--bs-border-color);
            color: var(--bs-secondary-color);
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            background-color: var(--bs-tertiary-bg);
            border-color: var(--bs-secondary-color);
            color: var(--bs-body-color);
        }
    </style>

    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Tambah Rencana Weeding</h4>
            <p class="text-muted mb-0">Buat rencana persiapan pernikahan baru</p>
        </div>
        <a href="{{ route('weeding-plan.index') }}" class="btn btn-outline-custom flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('weeding-plan.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <!-- Kolom Kiri -->
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="task_name" class="form-label">Nama Tugas <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('task_name') is-invalid @enderror"
                                id="task_name" name="task_name" value="{{ old('task_name') }}" required
                                placeholder="Contoh: Pesan akad nikah">
                            @error('task_name')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" rows="3"
                                placeholder="Jelaskan detail tugas...">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Kategori <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('category') is-invalid @enderror" id="category"
                                        name="category" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="akad" {{ old('category') == 'akad' ? 'selected' : '' }}>Akad
                                        </option>
                                        <option value="resepsi" {{ old('category') == 'resepsi' ? 'selected' : '' }}>
                                            Resepsi</option>
                                        <option value="persiapan" {{ old('category') == 'persiapan' ? 'selected' : '' }}>
                                            Persiapan</option>
                                        <option value="pakaian" {{ old('category') == 'pakaian' ? 'selected' : '' }}>
                                            Pakaian</option>
                                        <option value="kado" {{ old('category') == 'kado' ? 'selected' : '' }}>Kado
                                        </option>
                                        <option value="tamu" {{ old('category') == 'tamu' ? 'selected' : '' }}>Tamu
                                        </option>
                                        <option value="dokumentasi" {{ old('category') == 'dokumentasi' ? 'selected' : '' }}>Dokumentasi</option>
                                        <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                    @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Prioritas <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror" id="priority"
                                        name="priority" required>
                                        <option value="">Pilih Prioritas</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi
                                        </option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Sedang
                                        </option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah
                                        </option>
                                    </select>
                                    @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Batas Waktu</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                        id="due_date" name="due_date" value="{{ old('due_date') }}">
                                    @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="invitation_id" class="form-label">Terkait Undangan</label>
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
                                    <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
                                rows="10" placeholder="Tambahkan catatan tambahan...">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('weeding-plan.index') }}" class="btn btn-outline-custom">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-gold-custom">
                        <i class="bi bi-check-lg me-1"></i> Simpan Rencana
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Init TomSelect untuk Undangan jika ada
            if (document.getElementById('invitation_id')) {
                new TomSelect('#invitation_id', {
                    placeholder: 'Pilih Undangan...',
                    allowEmptyOption: true,
                    create: false,
                    maxOptions: 500,
                    searchField: ['text'],
                    render: {
                        no_results: function (data, escape) {
                            return '<div class="no-results p-2 text-muted">Tidak ditemukan</div>';
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
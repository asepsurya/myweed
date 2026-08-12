<x-app-layout>
    <style>
        h4 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: var(--bs-body-color); }

        .form-card {
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(27, 42, 74, 0.05);
            overflow: hidden;
        }

        .form-label { font-size: 0.875rem; color: var(--bs-secondary-color); font-weight: 600; margin-bottom: 0.5rem; }
        .form-control, .form-select {
            border-radius: 10px; padding: 0.75rem 1rem;
            background-color: var(--bs-body-bg); border-color: var(--bs-border-color); color: var(--bs-body-color);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--adminuiux-theme-1); box-shadow: 0 0 0 0.2rem rgba(198, 169, 92, 0.2);
        }
        .btn-gold-custom {
            background: linear-gradient(135deg, var(--adminuiux-theme-1), var(--adminuiux-theme-1-hover));
            border: none; color: var(--adminuiux-theme-1-text);
            padding: 0.75rem 1.5rem; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;
        }
        .btn-gold-custom:hover {
            transform: translateY(-1px); box-shadow: 0 6px 16px rgba(198, 169, 92, 0.3);
        }
        .btn-outline-custom {
            border-radius: 10px; padding: 0.75rem 1.5rem; font-weight: 600;
            border-color: var(--bs-border-color); color: var(--bs-secondary-color);
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">Edit Kategori Anggaran</h4>
            <p class="text-muted mb-0">{{ $budget->title }}</p>
        </div>
        <a href="{{ route('budget.category.index') }}" class="btn btn-outline-custom flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('budget.category.update', $category) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $category->name) }}" required
                                placeholder="Contoh: Catering">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="allocated_amount" class="form-label">Jumlah Dialokasikan <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('allocated_amount') is-invalid @enderror"
                                        id="allocated_amount" name="allocated_amount"
                                        value="{{ old('allocated_amount', $category->allocated_amount) }}" required min="0" step="1000">
                                    @error('allocated_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="colour" class="form-label">Warna Label</label>
                    <div class="d-flex gap-2 align-items-center">
                        <input type="color" name="colour" id="colour" class="form-control form-control-color"
                               value="{{ old('colour', $category->colour ?? '#6c757d') }}" style="width: 50px; height: 40px;">
                        <input type="text" name="colour_text" class="form-control @error('colour') is-invalid @enderror"
                               value="{{ old('colour', $category->colour ?? '#6c757d') }}" placeholder="#XXXXXX" maxlength="7">
                    </div>
                                    @error('colour')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Catatan</label>
                    <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                        rows="3" placeholder="Catatan tambahan...">{{ old('note', $category->note) }}</textarea>
                    @error('note')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('budget.category.index') }}" class="btn btn-outline-custom">Batal</a>
                    <button type="submit" class="btn btn-gold-custom">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

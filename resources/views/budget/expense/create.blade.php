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
            <h4 class="mb-1">{{ isset($expense) ? 'Edit' : 'Tambah' }} Pengeluaran</h4>
            <p class="text-muted mb-0">{{ isset($expense) ? 'Perbarui' : 'Catat' }} pengeluaran anggaran baru</p>
        </div>
        <a href="{{ route('budget.expense.index') }}" class="btn btn-outline-custom flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            <form action="{{ isset($expense) ? route('budget.expense.update', $expense) : route('budget.expense.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($expense))
                    @method('PUT')
                @endif

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="budget_category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('budget_category_id') is-invalid @enderror" id="budget_category_id" name="budget_category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('budget_category_id', $expense->budget_category_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('budget_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="vendor_name" class="form-label">Nama Vendor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                                id="vendor_name" name="vendor_name"
                                value="{{ old('vendor_name', $expense->vendor_name ?? '') }}" required
                                placeholder="Contoh: Toko Florist ABC">
                            @error('vendor_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                        id="amount" name="amount"
                                        value="{{ old('amount', $expense->amount ?? '') }}" required min="0" step="1000"
                                        placeholder="0">
                                    @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expense_date" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('expense_date') is-invalid @enderror"
                                        id="expense_date" name="expense_date"
                                        value="{{ old('expense_date', isset($expense) ? $expense->expense_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
                                    @error('expense_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_method') is-invalid @enderror"
                                id="payment_method" name="payment_method" required>
                                <option value="">Pilih Metode</option>
                                <option value="cash" {{ old('payment_method', $expense->payment_method ?? '') == 'cash' ? 'selected' : '' }}>Tunai</option>
                                <option value="transfer" {{ old('payment_method', $expense->payment_method ?? '') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="e-wallet" {{ old('payment_method', $expense->payment_method ?? '') == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="credit" {{ old('payment_method', $expense->payment_method ?? '') == 'credit' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="card" {{ old('payment_method', $expense->payment_method ?? '') == 'card' ? 'selected' : '' }}>Kartu Debit</option>
                            </select>
                            @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="receipt" class="form-label">Bukti Pembayaran</label>
                            @if(isset($expense) && $expense->receipt_path)
                                <div class="text-center mb-2">
                                    <a href="{{ asset('storage/' . $expense->receipt_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $expense->receipt_path) }}" class="img-fluid rounded border shadow-sm" style="max-height: 120px;" alt="Bukti">
                                    </a>
                                </div>
                            @endif
                            <div class="upload-zone border border-dashed rounded p-3 text-center">
                                <label for="receipt" class="cursor-pointer mb-0 d-block">
                                    <i class="bi bi-image fs-3 text-muted"></i>
                                    <p class="text-muted mb-0 mt-1 small">Klik untuk upload</p>
                                    <input id="receipt" type="file" name="receipt" class="d-none" accept="image/*">
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1">Format: JPG/PNG, maks 2MB.</small>
                            @error('receipt')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_paid" name="is_paid" value="1"
                                    {{ old('is_paid', $expense->is_paid ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_paid">Sudah dibayar</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3" placeholder="Detail tambahan tentang pengeluaran ini...">{{ old('description', $expense->description ?? '') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('budget.expense.index') }}" class="btn btn-outline-custom">Batal</a>
                    <button type="submit" class="btn btn-gold-custom">
                        <i class="bi bi-check-lg me-1"></i> {{ isset($expense) ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

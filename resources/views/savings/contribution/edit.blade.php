<x-app-layout>
    <style>
        h4 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; color: var(--bs-body-color); }
        .form-card {
            background: var(--bs-body-bg); border: 1px solid var(--bs-border-color); border-radius: 16px;
            box-shadow: 0 4px 20px rgba(27, 42, 74, 0.05); overflow: hidden;
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
            <h4 class="mb-1">Edit Setoran</h4>
            <p class="text-muted mb-0">{{ $contribution->goal?->name ?? 'Target tidak ditemukan' }}</p>
        </div>
        <a href="{{ route('savings.contribution.index') }}" class="btn btn-outline-custom flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('savings.contribution.update', $contribution) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="savings_goal_id" class="form-label">Target Tabungan *</label>
                            <select class="form-select @error('savings_goal_id') is-invalid @enderror"
                                id="savings_goal_id" name="savings_goal_id" required>
                                <option value="">Pilih Target</option>
                                @foreach($goals as $id => $name)
                                    <option value="{{ $id }}" {{ old('savings_goal_id', $contribution->savings_goal_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('savings_goal_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="savings_contributor_id" class="form-label">Kontributor *</label>
                            <select class="form-select @error('savings_contributor_id') is-invalid @enderror"
                                id="savings_contributor_id" name="savings_contributor_id" required>
                                @foreach($contributors as $c)
                                    <option value="{{ $c->id }}" {{ old('savings_contributor_id', $contribution->savings_contributor_id) == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('savings_contributor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Jumlah *</label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                        id="amount" name="amount"
                                        value="{{ old('amount', $contribution->amount) }}" required min="1" step="1000"
                                        placeholder="0">
                                    @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="method" class="form-label">Metode *</label>
                                    <select class="form-select @error('method') is-invalid @enderror"
                                        id="method" name="method" required>
                                        <option value="transfer" {{ old('method', $contribution->method) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                        <option value="e-wallet" {{ old('method', $contribution->method) == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                                        <option value="cash" {{ old('method', $contribution->method) == 'cash' ? 'selected' : '' }}>Tunai</option>
                                        <option value="card" {{ old('method', $contribution->method) == 'card' ? 'selected' : '' }}>Kartu</option>
                                    </select>
                                    @error('method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contributed_at" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('contributed_at') is-invalid @enderror"
                                id="contributed_at" name="contributed_at"
                                value="{{ old('contributed_at', $contribution->contributed_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}">
                            @error('contributed_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="note" class="form-label">Catatan</label>
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                                rows="5" placeholder="Catatan tambahan (opsional)...">{{ old('note', $contribution->note) }}</textarea>
                            @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('savings.contribution.index') }}" class="btn btn-outline-custom">Batal</a>
                    <button type="submit" class="btn btn-gold-custom">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

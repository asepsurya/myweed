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
        .auto-section {
            background: rgba(26, 115, 231, 0.03); border-radius: 12px; padding: 1.5rem;
        }
    </style>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="mb-1">{{ isset($goal) ? 'Edit' : 'Tambah' }} Target Tabungan</h4>
            <p class="text-muted mb-0">{{ isset($goal) ? 'Perbarui' : 'Buat' }} target tabungan baru untuk pernikahan</p>
        </div>
        <a href="{{ route('savings.goal.index') }}" class="btn btn-outline-custom flex-grow-1 flex-md-grow-0">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card form-card">
        <div class="card-body p-4 p-md-5">
            <form action="{{ isset($goal) ? route('savings.goal.update', $goal) : route('savings.goal.store') }}" method="POST">
                @csrf
                @if(isset($goal)) @method('PUT') @endif

                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Target <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $goal->name ?? '') }}" required
                                placeholder="Contoh: Tabungan Honeymoon">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="target_amount" class="form-label">Jumlah Target <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('target_amount') is-invalid @enderror"
                                        id="target_amount" name="target_amount"
                                        value="{{ old('target_amount', $goal->target_amount ?? '') }}" required min="0" step="1000"
                                        placeholder="0">
                                    @error('target_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Deadline <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                        id="deadline" name="deadline"
                                        value="{{ old('deadline', isset($goal) ? $goal->deadline->format('Y-m-d') : now()->addMonths(6)->format('Y-m-d')) }}" required>
                                    @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="currency" class="form-label">Mata Uang</label>
                            <select class="form-select" id="currency" name="currency">
                                <option value="IDR" {{ old('currency', $goal->currency ?? 'IDR') == 'IDR' ? 'selected' : '' }}>IDR (Rupiah)</option>
                                <option value="USD" {{ old('currency', $goal->currency ?? '') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="MYR" {{ old('currency', $goal->currency ?? '') == 'MYR' ? 'selected' : '' }}>MYR</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="colour" class="form-label">Warna</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="color" name="colour" id="colour" class="form-control form-control-color"
                                    value="{{ old('colour', $goal->colour ?? '#C6A962') }}" style="width: 50px; height: 40px;">
                                <input type="text" name="colour_text" class="form-control" value="{{ old('colour', $goal->colour ?? '#C6A962') }}" maxlength="7">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description"
                                rows="3" placeholder="Deskripsi singkat tentang target ini...">{{ old('description', $goal->description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_shared" name="is_shared" value="1"
                                    {{ old('is_shared', $goal->is_shared ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_shared">Bagikan dengan pasangan (multi-user)</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        @php
                            $hasRule = isset($goal) && $goal->auto_savings_rule;
                            $rule = $hasRule ? $goal->auto_savings_rule : [];
                        @endphp

                        <div class="auto-section" style="border: 1px solid var(--bs-border-color);">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Tabungan Otomatis</h6>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auto_toggle"
                                        {{ $hasRule ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div id="autoFields" class="{{ $hasRule ? '' : 'd-none' }}">
                                <div class="mb-3">
                                    <label for="frequency" class="form-label">Frekuensi</label>
                                    <select class="form-select" id="frequency" name="frequency">
                                        <option value="daily" {{ old('frequency', $rule['frequency'] ?? '') == 'daily' ? 'selected' : '' }}>Harian</option>
                                        <option value="weekly" {{ old('frequency', $rule['frequency'] ?? '') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                        <option value="monthly" {{ old('frequency', $rule['frequency'] ?? '') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                                        <option value="custom" {{ old('frequency', $rule['frequency'] ?? '') == 'custom' ? 'selected' : '' }}>Kustom</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Jumlah per Setoran</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        min="1" step="1000" value="{{ old('amount', $rule['amount'] ?? '') }}"
                                        placeholder="0">
                                </div>
                                <div class="mb-0">
                                    <label for="interval_days" class="form-label">Interval (hari) - kustom</label>
                                    <input type="number" class="form-control" id="interval_days" name="interval_days"
                                        min="1" value="{{ old('interval_days', $rule['interval_days'] ?? '') }}" placeholder="7">
                                </div>
                            </div>

                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Sistem akan otomatis menambahkan setoran rutin sesuai frekuensi yang ditentukan.
                            </small>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="auto_frequency" id="auto_frequency" value="{{ old('frequency', $rule['frequency'] ?? '') }}">
                <input type="hidden" name="auto_amount" id="auto_amount" value="{{ old('amount', $rule['amount'] ?? '') }}">
                <input type="hidden" name="auto_interval_days" id="auto_interval_days" value="{{ old('interval_days', $rule['interval_days'] ?? '') }}">

                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('savings.goal.index') }}" class="btn btn-outline-custom">Batal</a>
                    <button type="submit" class="btn btn-gold-custom">
                        <i class="bi bi-check-lg me-1"></i> {{ isset($goal) ? 'Perbarui' : 'Simpan' }} Target
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('auto_toggle').addEventListener('change', function () {
            const fields = document.getElementById('autoFields');
            if (this.checked) {
                fields.classList.remove('d-none');
            } else {
                fields.classList.add('d-none');
            }
        });

        // Sync hidden fields from visible inputs before submit
        document.querySelector('form').addEventListener('submit', function () {
            document.getElementById('auto_frequency').value = document.getElementById('frequency').value;
            document.getElementById('auto_amount').value = document.getElementById('amount').value;
            document.getElementById('auto_interval_days').value = document.getElementById('interval_days').value;
        });
    </script>
</x-app-layout>

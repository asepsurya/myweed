<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-ticket-perforated me-2"></i>
                {{ isset($coupon) ? 'Edit Kupon' : 'Tambah Kupon' }}
            </h2>
            <a href="{{ route('coupons.index') }}" class="btn btn-outline-secondary btn-sm">
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

                <form action="{{ isset($coupon) ? route('coupons.update', $coupon) : route('coupons.store') }}" method="POST">
                    @csrf
                    @if(isset($coupon))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="code" class="form-label fw-semibold">Kode Kupon</label>
                        <input type="text" name="code" id="code" class="form-control text-uppercase" value="{{ old('code', $coupon->code ?? '') }}" required placeholder="Contoh: WEDDING50">
                        <div class="form-text">Huruf besar, tanpa spasi, dan unik.</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label fw-semibold">Tipe Diskon</label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="percentage" {{ old('type', $coupon->type ?? '') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                    <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="value" class="form-label fw-semibold">Nilai Diskon</label>
                                <input type="number" name="value" id="value" class="form-control" value="{{ old('value', $coupon->value ?? '') }}" min="1" required placeholder="Contoh: 10 atau 50000">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="min_amount" class="form-label fw-semibold">Minimal Pembelian (Rp)</label>
                        <input type="number" name="min_amount" id="min_amount" class="form-control" value="{{ old('min_amount', $coupon->min_amount ?? '') }}" min="0" placeholder="Kosongkan jika tidak ada">
                    </div>

                    <div class="mb-3">
                        <label for="max_uses" class="form-label fw-semibold">Maksimal Penggunaan</label>
                        <input type="number" name="max_uses" id="max_uses" class="form-control" value="{{ old('max_uses', $coupon->max_uses ?? '') }}" min="1" placeholder="Kosongkan untuk unlimited">
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="starts_at" class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="datetime-local" name="starts_at" id="starts_at" class="form-control" value="{{ old('starts_at', isset($coupon->starts_at) ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expires_at" class="form-label fw-semibold">Tanggal Berakhir</label>
                                <input type="datetime-local" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at', isset($coupon->expires_at) ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', isset($coupon) && $coupon->is_active ? 'checked' : '') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('coupons.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> {{ isset($coupon) ? 'Simpan Perubahan' : 'Tambah Kupon' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

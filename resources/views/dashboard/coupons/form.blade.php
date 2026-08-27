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
                        <label for="code" class="form-label fw-semibold">Kode Kupon / Voucher</label>
                        <input type="text" name="code" id="code" class="form-control text-uppercase" value="{{ old('code', $coupon->code ?? '') }}" required placeholder="Contoh: WEDDING50">
                        <div class="form-text">Huruf besar, tanpa spasi, dan unik.</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label fw-semibold">Tipe</label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="percentage" {{ old('type', $coupon->type ?? '') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                    <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
                                    <option value="voucher" {{ old('type', $coupon->type ?? '') === 'voucher' ? 'selected' : '' }}>Voucher Langganan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="value-field">
                            <div class="mb-3">
                                <label for="value" class="form-label fw-semibold">Nilai Diskon (%)</label>
                                <input type="number" name="value" id="value" class="form-control" value="{{ old('value', $coupon->value ?? '') }}" min="1" max="100" placeholder="Contoh: 10">
                                <div class="form-text">Otomatis 100% untuk tipe Voucher.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="plan-field">
                        <label for="subscription_plan_id" class="form-label fw-semibold">Paket Langganan (untuk Voucher)</label>
                        <select name="subscription_plan_id" id="subscription_plan_id" class="form-select">
                            <option value="">-- Semua Paket --</option>
                            @foreach(\App\Models\SubscriptionPlan::all() as $plan)
                                <option value="{{ $plan->id }}" {{ old('subscription_plan_id', $coupon->subscription_plan_id ?? '') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} ({{ $plan->duration }} Hari)
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">Pilih paket yang akan diberikan saat voucher ditukar. Kosongkan untuk menerapkan ke paket apapun.</div>
                    </div>

                    <div class="mb-3" id="min-amount-field">
                        <label for="min_amount" class="form-label fw-semibold">Minimal Pembelian (Rp)</label>
                        <input type="number" name="min_amount" id="min_amount" class="form-control" value="{{ old('min_amount', $coupon->min_amount ?? '') }}" min="0" placeholder="Kosongkan jika tidak ada">
                        <div class="form-text">Tidak berlaku untuk tipe Voucher.</div>
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

    <script>
        function toggleCouponFields() {
            const type = document.getElementById('type').value;
            const planField = document.getElementById('plan-field');
            const minAmountField = document.getElementById('min-amount-field');
            const valueField = document.getElementById('value-field');
            const valueInput = document.getElementById('value');

            if (!planField || !minAmountField || !valueField || !valueInput) {
                return;
            }

            if (type === 'voucher') {
                planField.style.display = 'block';
                minAmountField.style.display = 'none';
                valueField.style.display = 'none';
                valueInput.value = '100';
                valueInput.readOnly = true;
            } else {
                planField.style.display = 'none';
                minAmountField.style.display = 'block';
                valueField.style.display = 'block';
                valueInput.readOnly = false;
            }
        }

        const typeSelect = document.getElementById('type');
        if (typeSelect) {
            typeSelect.addEventListener('change', toggleCouponFields);
        }
        document.addEventListener('DOMContentLoaded', toggleCouponFields);
    </script>

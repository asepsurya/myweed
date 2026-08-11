<x-app-layout>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    <h4 class="fw-bold mb-1">Konfirmasi Pembayaran</h4>
                    <p class="text-muted mb-4">
                        Selesaikan pembayaran untuk mengaktifkan paket langganan
                    </p>

                    <!-- PLAN INFO -->
                    <div class="border rounded-3 p-3 mb-4">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Paket</span>
                            <span>{{ $plan->name }}</span>
                        </div>

                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-semibold">Durasi</span>
                            <span>{{ $plan->duration }} Hari</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-primary" id="plan-price">
                                Rp {{ number_format($plan->price, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mt-2 d-none" id="coupon-discount-row">
                            <span class="fw-semibold text-success">Diskon Kupon</span>
                            <span class="fw-semibold text-success" id="coupon-discount">- Rp 0</span>
                        </div>

                        <div class="d-flex justify-content-between mt-2">
                            <span class="fw-bold">Total Bayar</span>
                            <span class="fw-bold text-primary" id="final-price">
                                Rp {{ number_format($plan->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- COUPON FORM -->
                    <form id="couponForm" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" id="coupon_code" class="form-control text-uppercase"
                                placeholder="Masukkan kode kupon">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bi bi-ticket-perforated"></i> Pakai
                            </button>
                        </div>
                        <div id="coupon-message" class="mt-2 small"></div>
                    </form>

                    <!-- PAYMENT METHOD -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Metode Pembayaran</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary flex-fill payment-method-btn" data-method="midtrans" @if(!config('midtrans.client_key') || !isset($snapToken)) style="display:none;" @endif>
                                Midtrans
                            </button>
                            <button type="button" class="btn btn-outline-success flex-fill payment-method-btn active" data-method="mayar">
                                Mayar
                            </button>
                        </div>
                        @if(!config('midtrans.client_key'))
                            <div class="alert alert-info py-2 small mb-0 mt-2">
                                <i class="bi bi-info-circle me-1"></i> Midtrans belum dikonfigurasi. Silakan lanjutkan dengan Mayar.
                            </div>
                        @endif
                    </div>

                    <!-- BUTTON -->
                    <button id="payBtn" class="btn btn-primary w-100 rounded-3 py-2">
                        💳 Bayar Sekarang
                    </button>

                    <p class="text-center text-muted small mt-3 mb-0">
                        Pembayaran diproses dengan aman
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

@if(config('midtrans.client_key') && isset($snapToken))
<!-- MIDTRANS SNAP -->
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const couponForm = document.getElementById('couponForm');
    const couponInput = document.getElementById('coupon_code');
    const couponMessage = document.getElementById('coupon-message');
    const couponDiscountRow = document.getElementById('coupon-discount-row');
    const couponDiscountEl = document.getElementById('coupon-discount');
    const finalPriceEl = document.getElementById('final-price');
    const payBtn = document.getElementById('payBtn');
    const methodButtons = document.querySelectorAll('.payment-method-btn');

    let appliedCoupon = null;
    let originalPrice = {{ $plan->price }};
    let discountedPrice = originalPrice;
    let selectedMethod = 'mayar';

    methodButtons.forEach(btn => {
        if (btn.dataset.method === 'mayar') {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    function formatRupiah(number) {
        return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    methodButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            methodButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedMethod = this.dataset.method;
        });
    });

    couponForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const code = couponInput.value.trim();
        if (!code) {
            couponMessage.innerHTML = '<span class="text-danger">Masukkan kode kupon.</span>';
            return;
        }

        fetch('{{ route('coupons.validate') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code, amount: originalPrice })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                appliedCoupon = data.coupon;
                discountedPrice = Math.max(0, originalPrice - data.discount);
                couponDiscountRow.classList.remove('d-none');
                couponDiscountEl.textContent = '- ' + formatRupiah(data.discount);
                finalPriceEl.textContent = formatRupiah(discountedPrice);
                couponMessage.innerHTML = '<span class="text-success">Kupon berhasil diterapkan!</span>';
            } else {
                appliedCoupon = null;
                discountedPrice = originalPrice;
                couponDiscountRow.classList.add('d-none');
                finalPriceEl.textContent = formatRupiah(originalPrice);
                couponMessage.innerHTML = '<span class="text-danger">' + data.message + '</span>';
            }
        })
        .catch(() => {
            couponMessage.innerHTML = '<span class="text-danger">Terjadi kesalahan, coba lagi.</span>';
        });
    });

    payBtn.addEventListener('click', function () {
        if (selectedMethod === 'mayar') {
            payBtn.disabled = true;
            payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

            fetch('{{ route('mayar.create-payment-link') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    plan_id: {{ $plan->id }},
                    coupon: appliedCoupon
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.payment_url;
                } else {
                    payBtn.disabled = false;
                    payBtn.innerHTML = '💳 Bayar Sekarang';
                    alert(data.message || 'Gagal membuat link pembayaran.');
                }
            })
            .catch(() => {
                payBtn.disabled = false;
                payBtn.innerHTML = '💳 Bayar Sekarang';
                alert('Terjadi kesalahan, coba lagi.');
            });
        } else {
            if (typeof snap === 'undefined') {
                alert('Konfigurasi Midtrans belum lengkap. Silakan pilih metode pembayaran Mayar.');
                return;
            }
            snap.pay('{{ $snapToken ?? '' }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('dashboard') }}";
                },
                onPending: function(result) {
                    window.location.href =
                        "{{ route('payment.pending') }}?order_id=" + result.order_id;
                },
                onError: function() {
                    window.location.href = "{{ route('payment.failed') }}";
                },
                onClose: function() {
                    console.log('Popup ditutup');
                }
            });
        }
    });
});
</script>

</x-app-layout>


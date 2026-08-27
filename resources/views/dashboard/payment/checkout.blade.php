<x-app-layout>
    @php
        $defaultGateway = config('payment.default_gateway', 'midtrans');
    @endphp
    <style>
        .card-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .card-logo img {
            width: 160px;
            height: auto;
        }
       
        .method-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

    </style>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card  shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="card-logo">
                            <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang">
                        </div>
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

                        <!-- METODE PEMBAYARAN (dari ENV) -->
                        <div class="text-center mb-4">
                            @if($defaultGateway === 'local')
                                <span class="method-badge bg-success-subtle text-success">
                                    <i class="bi bi-qr-code"></i> QRIS Langsung
                                </span>
                            @else
                                <span class="method-badge bg-primary-subtle text-primary">
                                    <i class="bi bi-credit-card-2-front"></i> Midtrans
                                </span>
                            @endif
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

                        @if($defaultGateway === 'local')
                            <!-- QRIS LOCAL PAYMENT BUTTON -->
                            <button id="payLocalBtn" class="btn btn-success w-100 rounded-3 py-2">
                                <i class="bi bi-qr-code me-1"></i> Bayar via QRIS
                            </button>
                        @else
                            <!-- MIDTRANS PAYMENT BUTTON -->
                            <button id="payBtn" class="btn btn-primary w-100 rounded-3 py-2">
                                Bayar Sekarang
                            </button>
                        @endif

                        <p class="text-center text-muted small mt-3 mb-0">
                            Pembayaran diproses dengan aman
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @if($defaultGateway === 'midtrans')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const couponForm = document.getElementById('couponForm');
            const couponInput = document.getElementById('coupon_code');
            const couponMessage = document.getElementById('coupon-message');
            const couponDiscountRow = document.getElementById('coupon-discount-row');
            const couponDiscountEl = document.getElementById('coupon-discount');
            const finalPriceEl = document.getElementById('final-price');
            const payBtn = document.getElementById('payBtn');

            let appliedCoupon = null;
            let originalPrice = {{ $plan->price }};
            let discountedPrice = originalPrice;
            let currentSnapToken = null;
            let isProcessing = false;

            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function loadMidtransSnap() {
                return new Promise((resolve, reject) => {
                    if (typeof snap !== 'undefined') {
                        resolve();
                        return;
                    }
                    const script = document.createElement('script');
                    script.src = '{{ config("midtrans.is_production") ? "https://app.midtrans.com/snap/snap.js" : "https://app.sandbox.midtrans.com/snap/snap.js" }}';
                    script.setAttribute('data-client-key', '{{ config('midtrans.client_key') }}');
                    script.onload = resolve;
                    script.onerror = reject;
                    document.body.appendChild(script);
                });
            }

            couponForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const code = couponInput.value.trim();
                if (!code) {
                    couponMessage.innerHTML = '<span class="text-danger">Masukkan kode kupon.</span>';
                    return;
                }

                couponMessage.innerHTML = '<span class="text-muted">Memverifikasi kupon...</span>';

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
                            currentSnapToken = null;
                        } else {
                            appliedCoupon = null;
                            discountedPrice = originalPrice;
                            couponDiscountRow.classList.add('d-none');
                            finalPriceEl.textContent = formatRupiah(originalPrice);
                            couponMessage.innerHTML = '<span class="text-danger">' + data.message + '</span>';
                            currentSnapToken = null;
                        }
                    })
                    .catch(() => {
                        couponMessage.innerHTML = '<span class="text-danger">Terjadi kesalahan, coba lagi.</span>';
                    });
            });

            payBtn.addEventListener('click', async function () {
                if (isProcessing) return;
                if (typeof snap === 'undefined') {
                    try {
                        couponMessage.innerHTML = '<span class="text-muted">Memuat gateway pembayaran...</span>';
                        await loadMidtransSnap();
                    } catch (e) {
                        alert('Gagal memuat Midtrans. Silakan muat ulang halaman.');
                        return;
                    }
                }

                isProcessing = true;
                payBtn.disabled = true;
                payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

                try {
                    const response = await fetch('{{ route('checkout.initiate-payment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            plan_id: {{ $plan->id }},
                            coupon: appliedCoupon,
                            payment_method: 'midtrans'
                        })
                    });

                    const data = await response.json();

                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }

                    if (!data.snap_token) {
                        couponMessage.innerHTML = '<span class="text-danger">' + (data.error || 'Gagal membuat token pembayaran.') + '</span>';
                        return;
                    }

                    currentSnapToken = data.snap_token;

                    snap.pay(currentSnapToken, {
                        onSuccess: function (result) {
                            window.location.href = "{{ config('app.url') }}/api/payment/success?order_id=" + result.order_id;
                        },
                        onPending: function (result) {
                            window.location.href =
                                "{{ config('app.url') }}/api/payment/pending?order_id=" + result.order_id;
                        },
                        onError: function (result) {
                            window.location.href =
                                "{{ config('app.url') }}/api/payment/failed?order_id=" + (result.order_id || '');
                        },
                        onClose: function () {
                            console.log('Popup ditutup');
                        }
                    });
                } catch (e) {
                    couponMessage.innerHTML = '<span class="text-danger">Terjadi kesalahan. Silakan coba lagi.</span>';
                } finally {
                    isProcessing = false;
                    payBtn.disabled = false;
                    payBtn.innerHTML = 'Bayar Sekarang';
                }
            });
        });
    </script>
    @else
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const couponForm = document.getElementById('couponForm');
            const couponInput = document.getElementById('coupon_code');
            const couponMessage = document.getElementById('coupon-message');
            const couponDiscountRow = document.getElementById('coupon-discount-row');
            const couponDiscountEl = document.getElementById('coupon-discount');
            const finalPriceEl = document.getElementById('final-price');
            const payLocalBtn = document.getElementById('payLocalBtn');

            let appliedCoupon = null;
            let originalPrice = {{ $plan->price }};
            let discountedPrice = originalPrice;
            let isProcessing = false;

            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            couponForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const code = couponInput.value.trim();
                if (!code) {
                    couponMessage.innerHTML = '<span class="text-danger">Masukkan kode kupon.</span>';
                    return;
                }

                couponMessage.innerHTML = '<span class="text-muted">Memverifikasi kupon...</span>';

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

            payLocalBtn.addEventListener('click', async function () {
                if (isProcessing) return;

                isProcessing = true;
                payLocalBtn.disabled = true;
                payLocalBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

                try {
                    const response = await fetch('{{ route('checkout.initiate-payment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            plan_id: {{ $plan->id }},
                            coupon: appliedCoupon,
                            payment_method: 'local'
                        })
                    });

                    const data = await response.json();

                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }

                    if (data.error) {
                        couponMessage.innerHTML = '<span class="text-danger">' + (data.error || 'Gagal membuat pesanan.') + '</span>';
                        return;
                    }

                    if (data.order_id) {
                        window.location.href = '{{ route('payment.local.index') }}?order_id=' + data.order_id;
                    }
                } catch (e) {
                    couponMessage.innerHTML = '<span class="text-danger">Terjadi kesalahan. Silakan coba lagi.</span>';
                } finally {
                    isProcessing = false;
                    payLocalBtn.disabled = false;
                    payLocalBtn.innerHTML = '<i class="bi bi-qr-code me-1"></i> Bayar via QRIS';
                }
            });
        });
    </script>
    @endif

</x-app-layout>

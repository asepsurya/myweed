<x-app-layout :showSidebar="false">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">

            <div class="mb-4">
                <i class="bi bi-clock-history text-warning" style="font-size: 80px;"></i>
            </div>

            <h2 class="fw-bold mb-3">Pembayaran Sedang Diproses</h2>

            <p class="text-muted mb-4">
                Pembayaran kamu belum selesai. Silakan selesaikan pembayaran atau tunggu konfirmasi.
            </p>

            @if($payment)
                <div class="text-start bg-light rounded-3 p-4 mb-4 border">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="text-muted text-uppercase small">Order ID</span>
                        <span class="fw-semibold text-truncate ms-2" style="max-width: 150px;">
                            {{ $payment->order_id }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="text-muted text-uppercase small">Paket</span>
                        <span class="fw-semibold">
                            {{ $payment->subscriptionPlan->name ?? '-' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted text-uppercase small">Status</span>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">PENDING</span>
                    </div>
                </div>

                <button class="btn btn-warning btn-lg me-2 retry-payment-btn"
                    data-order-id="{{ $payment->order_id }}"
                    data-payment-method="{{ $payment->payment_method ?? 'midtrans' }}"
                    data-plan-id="{{ $payment->subscriptionPlan->id ?? '' }}">
                    <i class="bi bi-arrow-repeat me-1"></i> Coba Bayar Lagi
                </button>
            @else
                <a href="{{ route('subscribe.page') }}" class="btn btn-warning btn-lg">
                    Coba Bayar Lagi
                </a>
            @endif

            <a href="{{ route('dashboard.user') }}" class="btn btn-outline-warning btn-lg ms-2">
                Kembali ke Dashboard
            </a>

        </div>
    </div>
</div>

@push('scripts')
<script>
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

    document.querySelectorAll('.retry-payment-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            const orderId = this.getAttribute('data-order-id');
            const paymentMethod = this.getAttribute('data-payment-method');
            const planId = this.getAttribute('data-plan-id');

            if (!orderId) return;

            this.disabled = true;
            const originalHtml = this.innerHTML;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...';

            try {
                if (paymentMethod === 'local') {
                    window.location.href = '{{ route('payment.local.index') }}?order_id=' + encodeURIComponent(orderId);
                    return;
                }

                let snapLoaded = false;
                if (typeof snap === 'undefined') {
                    await loadMidtransSnap();
                    snapLoaded = true;
                }

                const response = await fetch('{{ route('checkout.retry', ['orderId' => '__ORDER_ID__']) }}'.replace('__ORDER_ID__', orderId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        plan_id: planId ? parseInt(planId) : null,
                        payment_method: 'midtrans'
                    })
                });

                if (!response.ok) {
                    if (response.status === 419) {
                        alert('Sesi Anda telah berakhir. Silakan muat ulang halaman dan coba lagi.');
                    } else if (response.status === 401 || response.status === 403) {
                        alert('Anda tidak memiliki akses. Silakan login kembali.');
                    } else {
                        alert('Gagal memproses permintaan (HTTP ' + response.status + '). Silakan coba lagi.');
                    }
                    return;
                }

                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    alert('Respons server tidak valid. Silakan coba lagi atau muat ulang halaman.');
                    return;
                }

                if (data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }

                if (!data.snap_token) {
                    alert(data.error || 'Gagal membuat token pembayaran. Silakan coba lagi.');
                    return;
                }

                snap.pay(data.snap_token, {
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
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                this.disabled = false;
                this.innerHTML = originalHtml;
            }
        });
    });
</script>
@endpush
</x-app-layout>


<x-app-layout>
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

                <a href="{{ $payment->subscriptionPlan ? route('subscribe', $payment->subscriptionPlan->id) : route('subscribe.page') }}" class="btn btn-warning btn-lg me-2">
                    Coba Bayar Lagi
                </a>
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
</x-app-layout>


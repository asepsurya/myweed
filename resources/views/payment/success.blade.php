<x-app-layout>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">

            <div class="card shadow-sm border-0 rounded-4 text-center p-4">

                {{-- LOTTIE --}}
                <div id="lottie-success" style="height: 180px;"></div>

                <h3 class="fw-bold mt-3">Pembayaran Berhasil 🎉</h3>
                <p class="text-muted mb-4">
                    Paket langganan kamu sudah aktif dan siap digunakan.
                </p>

                {{-- DETAIL TRANSAKSI --}}
                @if($payment)
                <div class="text-start bg-light rounded-3 p-3 mb-4">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Order ID</span>
                        <span class="fw-semibold">{{ $payment->order_id }}</span>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span class="text-muted">Paket</span>
                        <span class="fw-semibold">
                            {{ $payment->subscriptionPlan->name ?? '-' }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <span class="text-muted">Status</span>
                        <span class="badge bg-success">PAID</span>
                    </div>
                </div>
                @endif

                {{-- CTA --}}
                <a href="{{ route('dashboard.user') }}" class="btn btn-primary btn-lg w-100">
                    Masuk ke Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script>
    lottie.loadAnimation({
        container: document.getElementById('lottie-success'),
        renderer: 'svg',
        loop: false,
        autoplay: true,
        path: 'https://assets10.lottiefiles.com/packages/lf20_jbrw3hcz.json'
    });
</script>
</x-app-layout>


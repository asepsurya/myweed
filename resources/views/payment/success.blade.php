<x-app-layout>
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-7 col-12">

                <div class="card shadow-lg border-0 rounded-4 text-center p-4 p-md-5">

                    {{-- LOTTIE ANIMATION --}}
                    <div id="lottie-success" class="mb-3" style="height: 150px;"></div>

                    {{-- TITLE --}}
                    <h3 class="fw-bold mb-2">Pembayaran Berhasil 🎉</h3>
                    <p class="text-muted mb-4">
                        Paket langganan kamu sudah aktif dan siap digunakan.
                    </p>

                    {{-- DETAIL TRANSAKSI --}}
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
                                <span class="badge bg-success rounded-pill px-3 py-2">PAID</span>
                            </div>

                        </div>
                    @endif

                    {{-- CTA --}}
                    <a href="{{ route('dashboard.user') }}" class="btn btn-primary btn-lg w-100 rounded-3 fw-bold">
                        Masuk ke Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    {{-- Catatan: Menggunakan bodymovin (lottie-web) karena script menggunakan lottie.loadAnimation --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <script>
        // Pastikan element ada sebelum load animation
        const lottieElement = document.getElementById('lottie-success');
        if (lottieElement && typeof lottie !== 'undefined') {
            lottie.loadAnimation({
                container: lottieElement,
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: 'https://assets10.lottiefiles.com/packages/lf20_jbrw3hcz.json'
            });
        }
    </script>
</x-app-layout>
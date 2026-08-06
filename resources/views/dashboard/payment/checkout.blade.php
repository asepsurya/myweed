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
                            <span class="fw-bold text-primary">
                                Rp {{ number_format($plan->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- BUTTON -->
                    <button id="payBtn" class="btn btn-primary w-100 rounded-3 py-2">
                        💳 Bayar Sekarang
                    </button>

                    <p class="text-center text-muted small mt-3 mb-0">
                        Pembayaran diproses dengan aman melalui Midtrans
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- MIDTRANS SNAP -->
<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('payBtn').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
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
    });
});
</script>

</x-app-layout>


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

            <a href="{{ route('dashboard.user') }}" class="btn btn-outline-warning btn-lg me-2">
                Kembali ke Dashboard
            </a>

            <a href="{{ route('pricing') }}" class="btn btn-warning btn-lg">
                Coba Bayar Lagi
            </a>

        </div>
    </div>
</div>
</x-app-layout>


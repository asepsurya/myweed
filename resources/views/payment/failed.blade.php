<x-app-layout>
    <div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">

            <div class="mb-4">
                <i class="bi bi-x-circle-fill text-danger" style="font-size: 80px;"></i>
            </div>

            <h2 class="fw-bold mb-3">Pembayaran Gagal</h2>

            <p class="text-muted mb-4">
                Maaf, pembayaran kamu gagal. Silakan coba lagi atau gunakan metode pembayaran lain.
            </p>

            <a href="{{ route('pricing') }}" class="btn btn-danger btn-lg me-2">
                Coba Lagi
            </a>

            <a href="{{ route('dashboard.user') }}" class="btn btn-outline-secondary btn-lg">
                Kembali ke Dashboard
            </a>

        </div>
    </div>
</div>
</x-app-layout>


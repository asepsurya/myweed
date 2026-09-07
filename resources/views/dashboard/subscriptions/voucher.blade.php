<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-ticket-perforated me-2"></i>
                Klaim Voucher
            </h2>
            <a href="{{ route('subscribe.page') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="container mt-4" style="max-width: 640px;">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="d-flex justify-content-center mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; background: rgba(198, 169, 98, 0.1); color: var(--gold-dark); font-size: 1.75rem;">
                            <i class="bi bi-gift"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold" style="font-family: var(--font-display); color: var(--navy);">Punya Voucher?</h5>
                    <p class="text-muted small mb-0">Tukar kode voucher untuk mendapatkan paket langganan secara gratis.</p>
                </div>

                <form action="{{ route('voucher.redeem') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="voucher_code" class="form-label fw-semibold">Kode Voucher</label>
                        <input type="text" name="voucher_code" id="voucher_code" class="form-control text-uppercase" placeholder="Masukkan kode voucher" required style="border-radius: 10px;">
                        <div class="form-text">Masukkan kode voucher yang diberikan.</div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger rounded-3">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success rounded-3">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" style="border-radius: 10px;">
                            <i class="bi bi-ticket-perforated me-1"></i> Tukar Voucher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

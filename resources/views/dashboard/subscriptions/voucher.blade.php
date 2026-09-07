<x-app-layout>
    <div class="subscription-page">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="text-center mb-4">
                        <span class="section-subtitle">Paket RuangUndang</span>
                        <h2 class="section-title">Klaim Voucher</h2>
                        <p class="section-desc">
                            Tukar kode voucher untuk mendapatkan paket langganan secara gratis.
                        </p>
                    </div>

                    <div class="premium-card p-4" style="background: linear-gradient(135deg, #FFFEF9 0%, var(--white) 100%); border: 2px dashed var(--gold);">
                        <div class="text-center mb-3">
                            <i class="bi bi-gift" style="font-size: 2.5rem; color: var(--gold);"></i>
                            <h5 class="fw-bold mt-2" style="font-family: var(--font-display); color: var(--navy);">Punya Voucher?</h5>
                            <p class="text-muted small mb-0">Masukkan kode voucher Anda untuk menukarnya dengan paket langganan.</p>
                        </div>
                        <form action="{{ route('voucher.redeem') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="voucher_code" class="form-control text-uppercase" placeholder="Masukkan kode voucher" required style="border-radius: 50px; border: 2px solid var(--border); padding: 0.75rem 1.5rem;">
                            <button type="submit" class="btn btn-gold" style="border-radius: 50px; padding: 0.75rem 1.5rem; white-space: nowrap;">
                                <i class="bi bi-ticket-perforated me-1"></i> Tukar
                            </button>
                        </form>
                        @if(session('error'))
                            <div class="alert alert-danger mt-3 mb-0 rounded-3 small">{{ session('error') }}</div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success mt-3 mb-0 rounded-3 small">{{ session('success') }}</div>
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('subscribe.page') }}" class="btn btn-outline-secondary rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i> Lihat Paket Langganan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

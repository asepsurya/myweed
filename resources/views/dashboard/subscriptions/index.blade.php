<x-app-layout>
@php
    $user = auth()->user();
    $subscription = $user->subscription;
@endphp

<style>
    /* ===== Import Fonts ===== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    /* ===== Custom Theme Variables ===== */
    :root {
        --gold: #C6A962;
        --gold-light: #E8D5A3;
        --gold-dark: #A68B4B;
        --navy: #1B2A4A;
        --navy-light: #2A3F6A;
        --white: #FFFFFF;
        --bg: #F7F5F2;
        --bg-alt: #FDFBF7;
        --border: #E8E4DE;
        --text: #1B2A4A;
        --text-secondary: #6B7280;
        --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        --font-display: 'Playfair Display', Georgia, serif;
        --danger: #dc3545;
    }

    /* ===== Dark Mode Overrides ===== */
    [data-bs-theme="dark"] {
        --gold: #E8D5A3;
        --gold-light: #C6A962;
        --gold-dark: #E8D5A3;
        --navy: #F7F5F2;
        --navy-light: #2A3F6A;
        --white: #1B2A4A;
        --bg: #0F1623;
        --bg-alt: #172033;
        --border: #2A3F6A;
        --text: #F7F5F2;
        --text-secondary: #94A3B8;
        --danger: #f87171;
    }

    /* ===== Page Layout ===== */
    .subscription-page {
        font-family: var(--font);
        color: var(--text);
        min-height: 80vh;
        padding: 60px 0;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .section-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 60px;
    }

    .section-subtitle {
        color: var(--gold-dark);
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        display: block;
    }

    .section-title {
        font-family: var(--font-display);
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 1rem;
    }

    .section-desc {
        color: var(--text-secondary);
        font-size: 1.1rem;
    }

    /* ===== Cards General ===== */
    .premium-card {
        border: 1px solid var(--border);
        border-radius: 20px;
        background: var(--white);
        box-shadow: 0 10px 40px rgba(27, 42, 74, 0.08);
        transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1), background-color 0.3s ease, border-color 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    [data-bs-theme="dark"] .premium-card {
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    /* ===== Admin & Active Subscription States ===== */
    .status-card {
        max-width: 600px;
        margin: 0 auto;
        padding: 3rem 2rem;
        text-align: center;
    }

    .status-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    .status-icon.active { background: rgba(28, 200, 138, 0.1); color: #1cc88a; }
    .status-icon.admin { background: rgba(78, 115, 223, 0.1); color: #4e73df; }
    
    .status-title {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 0.5rem;
    }

    .status-date {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gold-dark);
        margin: 1rem 0 2rem;
        letter-spacing: 1px;
    }

    /* ===== Pricing Cards ===== */
    .pricing-card {
        padding: 2.5rem 2rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .pricing-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(27, 42, 74, 0.15);
        border-color: var(--gold-light);
    }
    
    [data-bs-theme="dark"] .pricing-card:hover {
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    .pricing-card.popular {
        border: 2px solid var(--gold);
        background: linear-gradient(180deg, #FFFEF9 0%, var(--white) 100%);
        transform: scale(1.03);
    }

    .pricing-card.popular:hover {
        transform: scale(1.03) translateY(-10px);
    }

    [data-bs-theme="dark"] .pricing-card.popular {
        background: linear-gradient(180deg, #1B2A4A 0%, #172033 100%);
    }

    .badge-popular {
        position: absolute;
        top: 20px;
        right: -40px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: #fff;
        padding: 0.4rem 3rem;
        transform: rotate(45deg);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(198, 169, 98, 0.3);
    }

    .plan-name {
        font-family: var(--font-display);
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--navy);
        margin-bottom: 0.5rem;
    }

    .plan-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--navy);
        margin-bottom: 0.2rem;
    }

    .plan-duration {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 2rem;
        display: block;
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem 0;
        width: 100%;
    }

    .features-list li {
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
        color: var(--text-secondary);
    }

    .features-list li i {
        color: var(--gold);
        margin-right: 0.8rem;
        font-size: 1.1rem;
    }

    /* ===== Buttons ===== */
    .btn-gold {
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        color: #fff !important;
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(198, 169, 98, 0.3);
        display: inline-block;
        text-decoration: none;
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(198, 169, 98, 0.4);
        color: #fff !important;
    }

    .btn-outline-navy {
        background: transparent;
        color: var(--navy) !important;
        border: 2px solid var(--border);
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
    }

    .btn-outline-navy:hover {
        background: var(--navy);
        color: var(--bg) !important;
        border-color: var(--navy);
        transform: translateY(-2px);
    }

    .btn-outline-danger-custom {
        background: transparent;
        color: var(--danger) !important;
        border: 2px solid rgba(220, 53, 69, 0.2);
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
    }

    .btn-outline-danger-custom:hover {
        background: var(--danger);
        color: #fff !important;
        border-color: var(--danger);
        transform: translateY(-2px);
    }

    .btn-disabled-custom {
        background: #e9ecef;
        color: #6c757d !important;
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        width: 100%;
        border: none;
        cursor: not-allowed;
        display: block;
        text-align: center;
    }

    [data-bs-theme="dark"] .btn-disabled-custom {
        background: #243353;
        color: #5f6985 !important;
    }

    /* ===== Guarantee Section ===== */
    .guarantee-box {
        text-align: center;
        margin-top: 4rem;
        padding: 2rem;
        background: var(--white);
        border-radius: 20px;
        border: 1px solid var(--border);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .guarantee-icon {
        font-size: 2rem;
        color: var(--gold);
        margin-bottom: 1rem;
    }

    /* ===== Modal Custom ===== */
    .modal-content.custom-modal {
        border: none;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    [data-bs-theme="dark"] .modal-content.custom-modal {
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .modal-header.custom-modal-header {
        border-bottom: 1px solid var(--border);
        padding: 1.5rem 2rem;
    }

    .modal-title.custom-modal-title {
        font-family: var(--font-display);
        font-weight: 600;
        color: var(--navy);
    }

    .modal-body.custom-modal-body {
        padding: 2rem;
        color: var(--text-secondary);
    }

    .modal-footer.custom-modal-footer {
        border-top: 1px solid var(--border);
        padding: 1.5rem 2rem;
        gap: 10px;
    }

    [data-bs-theme="dark"] .modal-backdrop.show {
        opacity: 0.8;
    }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        .pricing-card.popular {
            transform: scale(1);
        }
        .pricing-card.popular:hover {
            transform: translateY(-10px);
        }
        .section-title { 
            font-size: 2rem; 
        }
    }
</style>

<div class="subscription-page">

    {{-- ================= ADMIN ================= --}}
    @if($user->isAdmin())
        <div class="container">
            <div class="premium-card status-card">
                <div class="status-icon admin">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h3 class="status-title">Admin Panel Access</h3>
                <p class="text-muted mb-4" style="font-size: 1.1rem;">
                    Selamat datang kembali, Admin. <br> Akun ini tidak memerlukan subscription untuk mengakses sistem.
                </p>
                <a href="{{ route('dashboard') }}" class="btn-gold" style="max-width: 250px;">
                    <i class="bi bi-speedometer2 me-2"></i> Ke Dashboard
                </a>
            </div>
        </div>

    {{-- ================= SUBSCRIPTION ACTIVE ================= --}}
    @elseif($subscription && $subscription->plan && $subscription->end_date && $subscription->end_date->isFuture())
        <div class="container">
            <div class="premium-card status-card">
                <div class="status-icon active">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <span class="section-subtitle">Status Membership</span>
                <h3 class="status-title">Subscription Aktif 🎉</h3>
                <p class="text-muted mb-2">
                    Terima kasih! Paket <strong style="color: var(--navy);">{{ $subscription->plan->name }}</strong> Anda saat ini sedang aktif.
                </p>
                <p class="text-muted mb-3">Berlaku hingga:</p>
                <div class="status-date">
                    <i class="bi bi-calendar-check me-2"></i>
                    {{ $subscription->end_date->format('d F Y') }}
                </div>
                
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('dashboard') }}" class="btn-gold" style="width: auto;">
                        <i class="bi bi-grid-1x2-fill me-2"></i> Ke Dashboard
                    </a>
                    <button type="button" class="btn-outline-danger-custom" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionModal">
                        <i class="bi bi-x-circle me-2"></i> Batalkan Langganan
                    </button>
                </div>
            </div>
        </div>

        <!-- Cancel Subscription Modal -->
        <div class="modal fade" id="cancelSubscriptionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content custom-modal">
                    <div class="modal-header custom-modal-header">
                        <h5 class="modal-title custom-modal-title">
                            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Batalkan Langganan?
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body custom-modal-body">
                        <p>Anda yakin ingin membatalkan langganan <strong style="color: var(--navy);">{{ $subscription->plan->name }}</strong>?</p>
                        <p class="mb-0">Anda akan kehilangan akses ke semua fitur premium setelah periode berlangganan berakhir. Tindakan ini tidak dapat dibatalkan.</p>
                    </div>
                    <div class="modal-footer custom-modal-footer">
                        <button type="button" class="btn-outline-navy" data-bs-dismiss="modal" style="width: auto;">Tidak, Tetap Berlangganan</button>
                        <form action="{{ route('subscription.cancel') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-outline-danger-custom" style="width: auto;">
                                <i class="bi bi-check-lg me-1"></i> Ya, Batalkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    {{-- ================= FREE / EXPIRED / BELUM SUBSCRIBE ================= --}}
    @else
        <div class="container">
            <!-- Header -->
            <div class="section-header">
                <span class="section-subtitle">Paket WeddingInv</span>
                <h2 class="section-title">Rencanakan Hari Bahagia Anda</h2>
                <p class="section-desc">
                    Pilih paket yang paling sesuai dengan kebutuhan pernikahan impian Anda. Tanpa biaya tersembunyi.
                </p>
            </div>

            <!-- Pricing Grid -->
            <div class="row row-cols-1 row-cols-md-3 g-4 align-items-stretch justify-content-center">
                @foreach($plans as $plan)
                    <div class="col">
                        <div class="premium-card pricing-card {{ $plan->slug === 'pro' ? 'popular' : '' }}">
                            @if($plan->slug === 'pro')
                                <div class="badge-popular">Paling Populer</div>
                            @endif

                            <div class="plan-name">{{ $plan->name }}</div>
                            
                            <div class="plan-price">
                                @if($plan->price > 0)
                                    Rp {{ number_format($plan->price, 0, ',', '.') }}
                                @else
                                    Gratis
                                @endif
                            </div>
                            <span class="plan-duration">
                                <i class="bi bi-clock-history me-1"></i> {{ $plan->duration }} Hari
                            </span>

                            <ul class="features-list">
                                @foreach(json_decode($plan->description) as $feature)
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-auto w-100">
                                @php
                                    $usedFree = $plan->is_free && !empty($subscription?->subscription_plan_id);
                                    $isActive = $subscription && $subscription->end_date?->isFuture();
                                @endphp

                                @if($usedFree)
                                    <button class="btn-disabled-custom" disabled>
                                        <i class="bi bi-lock-fill me-2"></i> Paket Free Sudah Digunakan
                                    </button>
                                @else
                                    <a href="{{ route('subscribe', $plan->id) }}" class="{{ $plan->slug === 'pro' ? 'btn-gold' : 'btn-outline-navy' }} w-100 text-center d-block">
                                        @if($isActive)
                                            <i class="bi bi-arrow-repeat me-2"></i> Perpanjang Paket
                                        @else
                                            <i class="bi bi-rocket-takeoff me-2"></i> Aktifkan Paket
                                        @endif
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Guarantee Section -->
            <div class="guarantee-box">
                <div class="guarantee-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4 style="font-family: var(--font-display); color: var(--navy); font-weight: 600;">Jaminan Kepuasan 100%</h4>
                <p class="text-muted mb-0 mt-2">
                    Jika ada kendala teknis dalam 7 hari pertama, tim kami siap membantu Anda sepenuhnya. Kepuasan Anda adalah prioritas utama kami.
                </p>
            </div>
        </div>
    @endif

</div>
</x-app-layout>
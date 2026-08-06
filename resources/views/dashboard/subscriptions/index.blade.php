<x-app-layout>
@php
    $user = auth()->user();
    $subscription = $user->subscription;
@endphp

{{-- ================= ADMIN ================= --}}
@if($user->isAdmin())
    <div class="container py-5 text-center">
        <i class="bi bi-shield-lock-fill text-primary fs-1 mb-3"></i>
        <h3 class="fw-bold">Admin Panel</h3>
        <p class="text-muted">
            Akun admin tidak memerlukan subscription.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
            Ke Dashboard
        </a>
    </div>

{{-- ================= SUBSCRIPTION ACTIVE ================= --}}
@elseif(
    $subscription &&
    $subscription->plan &&
    $subscription->end_date &&
    $subscription->end_date->isFuture()
)
    <div class="container pb-5">
        <div class="card pricing-card popular text-center p-5">
            <i class="bi bi-patch-check-fill text-success fs-1 mb-3"></i>

            <h3 class="fw-bold mb-2">
                Subscription Aktif 🎉
            </h3>

            <p class="text-muted mb-3">
                Paket <strong>{{ $subscription->plan->name }}</strong> aktif sampai:
            </p>

            <h4 class="text-primary fw-bold">
                {{ $subscription->end_date->format('d F Y') }}
            </h4>

            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-custom me-2">
                    Ke Dashboard
                </a>

                {{-- <a href="{{ route('subscribe.page') }}" class="btn btn-outline-primary btn-custom">
                    Perpanjang Paket
                </a> --}}
            </div>
        </div>
    </div>

{{-- ================= FREE / EXPIRED / BELUM SUBSCRIBE ================= --}}
@else
<style>
:root {
    --primary-color: #4e73df;
    --secondary-color: #858796;
    --accent-color: #1cc88a;
}
.badge-popular {
    position: absolute;
    top: 0;
    right: 0;
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1.5rem;
    border-bottom-left-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
}
.pricing-header {
    text-align: center;
    margin-bottom: 3rem;
    padding-top: 3rem;
}
.pricing-card {
    border: none;
    border-radius: 1rem;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 0.15rem 1.75rem rgba(58,59,69,.1);
}
.pricing-card:hover {
    transform: scale(1.02);
}
.pricing-card.popular {
    border: 2px solid var(--primary-color);
}
.plan-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary-color);
    text-transform: uppercase;
}
.features-list {
    list-style: none;
    padding: 1.5rem;
}
.features-list li {
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}
.features-list li i {
    color: var(--accent-color);
    margin-right: .75rem;
}
.btn-custom {
    border-radius: 50rem;
    padding: .75rem 2rem;
    font-weight: 600;
}
</style>

<div class="container pricing-header">
    <h6 class="text-primary text-uppercase fw-bold">Paket Wedding</h6>
    <h2>Rencanakan Hari Bahagia Anda</h2>
    <p class="text-muted w-75 mx-auto">
        Pilih paket yang sesuai untuk pernikahan Anda.
    </p>
</div>

<div class="container pb-5">
    <div class="row row-cols-1 row-cols-md-3 g-4 align-items-stretch">
        @foreach($plans as $plan)
            <div class="col">
                <div class="card h-100 pricing-card {{ $plan->slug === 'pro' ? 'popular' : '' }}">
                    @if($plan->slug === 'pro')
                        <div class="badge-popular">Paling Populer</div>
                    @endif

                    <div class="card-header text-center pt-4">
                        <div class="plan-name">{{ $plan->name }}</div>
                        <h3 class="fw-bold">
                            Rp {{ number_format($plan->price,0,',','.') }}
                        </h3>
                        <small class="text-muted">
                             {{ $plan->duration }} Hari
                        </small>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <ul class="features-list">
                            @foreach(json_decode($plan->description) as $feature)
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-auto text-center">
                          @php
                                $usedFree = $plan->id == 1 && !empty($subscription?->subscription_plan_id);
                            @endphp

                            @if($usedFree)
                                <button class="btn btn-secondary btn-custom w-100" disabled>
                                    Paket Free Sudah Digunakan
                                </button>
                            @else
                                <a href="{{ route('subscribe', $plan->id) }}"
                                class="btn {{ $plan->slug === 'pro' ? 'btn-primary' : 'btn-outline-primary' }} btn-custom w-100">

                                    {{ auth()->user()->subscription?->end_date?->isFuture()
                                        ? 'Perpanjang Paket'
                                        : 'Aktifkan Paket'
                                    }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="container text-center pb-5">
    <i class="bi bi-shield-check fs-1 text-success"></i>
    <h4 class="fw-bold mt-2">Jaminan Kepuasan</h4>
    <p class="text-muted w-50 mx-auto">
        Jika ada kendala dalam 7 hari pertama, kami siap membantu sepenuhnya.
    </p>
</div>
@endif


</x-app-layout>


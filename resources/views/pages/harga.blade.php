@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="page-header-shape shape-1"></div>
        <div class="page-header-shape shape-2"></div>
        <div class="container page-header-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Harga</li>
                </ol>
            </nav>
            <h1>Harga Paket</h1>
            <p>Pilih paket yang sesuai dengan kebutuhan undangan impian Anda.</p>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="content-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Investasi Momen</span>
                <h2 class="section-title">Paket yang Fleksibel</h2>
                <p class="section-desc">Mulai dari gratis, upgrade kapan saja sesuai kebutuhan.</p>
            </div>

            <div class="row g-4">
                @forelse($plans as $index => $plan)
                    @php
                        $features = json_decode($plan->description ?? '[]', true) ?: [];
                        $isFeatured = $plan->slug === 'pro' || $index === 1;
                        $delay = 0.1 + ($index * 0.1);
                    @endphp
                    <div class="col-lg-4 col-md-6 reveal" style="transition-delay: {{ $delay }}s;">
                        <div class="pricing-card {{ $isFeatured ? 'featured' : '' }}">
                            <div class="pricing-header">
                                <div class="pricing-icon">
                                    <i class="bi bi-{{ $plan->is_free ? 'gift' : ($plan->slug === 'pro' ? 'award' : 'gem') }}"></i>
                                </div>
                                <h4>{{ $plan->name }}</h4>
                                @if(!$plan->is_free && $plan->original_price && $plan->original_price > $plan->price)
                                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                        <span class="text-muted text-decoration-line-through small">
                                            Rp {{ number_format($plan->original_price, 0, ',', '.') }}
                                        </span>
                                        <span class="badge bg-danger-subtle text-danger px-2 py-1" style="font-size: 0.65rem;">
                                            <i class="bi bi-fire me-1"></i>{{ $plan->badge_text ?: 'Spesial Launching' }}
                                        </span>
                                    </div>
                                @endif
                                <div class="pricing-price">
                                    {{ $plan->is_free ? 'Gratis' : 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                                    <span>{{ $plan->is_free ? '' : '/undangan' }}</span>
                                </div>
                                <p class="pricing-desc">{{ $plan->duration }} Hari aktif</p>
                            </div>
                            <ul class="pricing-features">
                                @php
                                    $sortedFeatures = $features;
                                    usort($sortedFeatures, function ($a, $b) {
                                        $aYes = preg_match('/:\s*Yes$/', $a) ? 0 : (preg_match('/:\s*No$/', $a) ? 1 : 2);
                                        $bYes = preg_match('/:\s*Yes$/', $b) ? 0 : (preg_match('/:\s*No$/', $b) ? 1 : 2);
                                        return $aYes <=> $bYes;
                                    });
                                @endphp
                                @forelse($sortedFeatures as $feature)
                                    @php
                                        $featureName = preg_replace('/:\s*(Yes|No)$/', '', $feature);
                                        $isYes = preg_match('/:\s*Yes$/', $feature);
                                        $isNo = preg_match('/:\s*No$/', $feature);
                                    @endphp
                                    <li class="{{ $isNo ? 'text-muted' : '' }}">
                                        @if($isYes)
                                            <i class="bi bi-check-circle-fill text-gold"></i>
                                        @elseif($isNo)
                                            <i class="bi bi-x-circle text-muted-custom"></i>
                                        @else
                                            <i class="bi bi-check-circle-fill text-gold"></i>
                                        @endif
                                        {{ $featureName }}
                                    </li>
                                @empty
                                    <li class="text-muted fst-italic">Belum ada fitur ditambahkan.</li>
                                @endforelse
                            </ul>
                            <a href="{{ route('subscribe', $plan->id) }}"
                                class="btn {{ $isFeatured ? 'btn-gold' : 'btn-outline-dark' }} w-100 rounded-pill py-2 fw-semibold">
                                {{ $plan->is_free ? 'Mulai Gratis' : 'Pilih ' . $plan->name }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
                        <h6 class="text-muted">Belum ada paket harga.</h6>
                        <p class="text-muted small">Silakan hubungi admin untuk informasi paket terbaru.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="content-section alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">FAQ Harga</span>
                <h2 class="section-title">Pertanyaan Umum</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-item reveal">
                        <h5><i class="bi bi-question-circle text-gold me-2"></i>Apakah ada biaya tersembunyi?</h5>
                        <p>Tidak ada biaya tersembunyi. Semua yang tercantum adalah biaya final.</p>
                    </div>
                    <div class="faq-item reveal" style="transition-delay: 0.1s;">
                        <h5><i class="bi bi-question-circle text-gold me-2"></i>Bisa upgrade paket nanti?</h5>
                        <p>Ya, Anda bisa upgrade kapan saja dan hanya membayar selisih harga.</p>
                    </div>
                    <div class="faq-item reveal" style="transition-delay: 0.2s;">
                        <h5><i class="bi bi-question-circle text-gold me-2"></i>Metode pembayaran apa saja?</h5>
                        <p>Kami menerima transfer bank, e-wallet, kartu kredit, dan QRIS.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .pricing-card { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2.5rem 2rem; height: 100%; transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1); position: relative; overflow: hidden; }
        .pricing-card:hover { transform: translateY(-10px); border-color: var(--gold-light); box-shadow: 0 20px 50px rgba(27, 42, 74, 0.1); }
        .pricing-card.featured { border-color: var(--gold); box-shadow: 0 10px 40px rgba(198, 169, 98, 0.15); }
        .pricing-card.featured::before { content: 'POPULER'; position: absolute; top: 20px; right: -30px; background: var(--gold); color: var(--white); padding: 0.25rem 2.5rem; font-size: 0.7rem; font-weight: 700; transform: rotate(45deg); letter-spacing: 1px; }
        .pricing-header { text-align: center; margin-bottom: 2rem; }
        .pricing-icon { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, rgba(198, 169, 98, 0.1), rgba(198, 169, 98, 0.05)); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 1.5rem; color: var(--gold-dark); }
        .pricing-card h4 { color: var(--navy); margin-bottom: 0.5rem; }
        .pricing-price { font-size: 2.5rem; font-weight: 700; color: var(--navy); font-family: var(--font); }
        .pricing-price span { font-size: 1rem; color: var(--text-muted); font-weight: 400; }
        .pricing-desc { color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 1.5rem; }
        .pricing-features { list-style: none; padding: 0; margin: 0 0 2rem; }
        .pricing-features li { padding: 0.6rem 0; color: var(--text-secondary); font-size: 0.9rem; display: flex; align-items: center; gap: 0.75rem; }
        .pricing-features li i { color: var(--gold); }
        .pricing-features li.disabled { color: var(--text-muted); text-decoration: line-through; }
        .pricing-features li.disabled i { color: var(--text-muted); }
        .text-gold { color: var(--gold-dark) !important; }
        .text-muted-custom { color: var(--text-muted) !important; }
        .faq-item { background: var(--white); border: 1px solid var(--border); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1rem; transition: all 0.3s ease; }
        .faq-item:hover { border-color: var(--gold-light); }
        .faq-item h5 { color: var(--navy); margin-bottom: 0.5rem; }
        .faq-item p { color: var(--text-secondary); margin: 0; font-size: 0.9rem; }
    </style>
@endsection

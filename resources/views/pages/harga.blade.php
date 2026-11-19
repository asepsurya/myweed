@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Harga Paket</li>
                </ol>
            </nav>
            <h1>Pilihan Paket Undangan Digital</h1>
            <p>Pilih paket fleksibel yang sesuai dengan kebutuhan dan momen istimewa Anda.</p>
        </div>
    </section>

    <!-- Pricing Cards Section -->
    <section class="ev-section-light">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Investasi Momen</span>
                <h2 class="ev-section-title">Paket yang Fleksibel</h2>
                <p class="ev-section-desc">Mulai dari gratis, upgrade kapan saja sesuai kebutuhan.</p>
            </div>

            <div class="row g-4">
                @forelse($plans as $index => $plan)
                    @php
                        $features = json_decode($plan->description ?? '[]', true) ?: [];
                        $isFeatured = $plan->slug === 'pro' || $index === 1;
                        $delayClass = 'reveal-d' . min(1 + $index, 4);
                    @endphp
                    <div class="col-lg-4 col-md-6 reveal {{ $delayClass }}">
                        <div class="ev-pricing-card {{ $isFeatured ? 'featured' : '' }}">
                            <div class="ev-pricing-header">
                                <div class="ev-pricing-icon">
                                    <i
                                        class="bi bi-{{ $plan->is_free ? 'gift' : ($plan->slug === 'pro' ? 'award' : 'gem') }}"></i>
                                </div>
                                <h4>{{ $plan->name }}</h4>
                                @if(!$plan->is_free && $plan->original_price && $plan->original_price > $plan->price)
                                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                                        <span class="text-muted text-decoration-line-through small">
                                            Rp {{ number_format($plan->original_price, 0, ',', '.') }}
                                        </span>
                                        <span class="ev-badge-sale">
                                            <i class="bi bi-fire me-1"></i>{{ $plan->badge_text ?: 'Spesial Launching' }}
                                        </span>
                                    </div>
                                @endif
                                <div class="ev-pricing-price">
                                    {{ $plan->is_free ? 'Gratis' : 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                                    <span>{{ $plan->is_free ? '' : '/undangan' }}</span>
                                </div>
                                <p class="ev-pricing-desc">{{ $plan->duration }} Hari aktif</p>
                            </div>
                            <ul class="ev-pricing-features">
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
                                    <li class="{{ $isNo ? 'disabled' : '' }}">
                                        @if($isYes)
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @elseif($isNo)
                                            <i class="bi bi-x-circle text-muted"></i>
                                        @else
                                            <i class="bi bi-check-circle-fill text-success"></i>
                                        @endif
                                        {{ $featureName }}
                                    </li>
                                @empty
                                    <li class="text-muted fst-italic">Belum ada fitur ditambahkan.</li>
                                @endforelse
                            </ul>
                            <a href="{{ route('subscribe', $plan->id) }}"
                                class="ev-btn-primary w-100 justify-content-center mt-auto">
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

    <!-- Feature Comparison Table -->
    <section class="ev-comparison-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">Detail Perbandingan</span>
                <h2 class="ev-section-title">Fitur Semua Paket</h2>
                <p class="ev-section-desc">Bandingkan fitur setiap paket untuk memilih yang paling sesuai.</p>
            </div>

            <div class="ev-comparison-wrapper reveal">
                <div class="table-responsive">
                    <table class="ev-comparison-table">
                        <thead>
                            <tr>
                                <th class="feature-col">Fitur</th>
                                @forelse($plans as $plan)
                                    <th class="plan-col {{ $plan->slug === 'pro' ? 'plan-highlight' : '' }}">
                                        <div class="plan-name">{{ $plan->name }}</div>
                                        <div class="plan-price">
                                            {{ $plan->is_free ? 'Gratis' : 'Rp ' . number_format($plan->price, 0, ',', '.') }}
                                        </div>
                                        <div class="plan-duration">{{ $plan->duration }} Hari</div>
                                    </th>
                                @empty
                                    <th>Paket</th>
                                @endforelse
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $allFeatures = [];
                                foreach ($plans as $plan) {
                                    foreach (($plan->features ?? []) as $key => $value) {
                                        $allFeatures[$key] = true;
                                    }
                                }
                                ksort($allFeatures);

                                $featureLabels = [
                                    'all_themes' => 'Akses Semua Tema',
                                    'edit_guest_name' => 'Edit Nama Tamu',
                                    'rsvp_messages' => 'RSVP & Ucapan',
                                    'maps_location' => 'Lokasi Maps',
                                    'unlimited_recipients' => 'Unlimited Penerima',
                                    'countdown_calendar' => 'Countdown & Save the Date',
                                    'gallery' => 'Galeri Foto',
                                    'gallery_limit' => 'Batas Galeri',
                                    'virtual_gift' => 'Amplop Digital',
                                    'shareable' => 'Bisa Dibagikan',
                                    'background_music' => 'Musik Latar',
                                    'gift_accounts' => 'Rekening Hadiah',
                                    'streaming_video' => 'Video Streaming',
                                    'auto_scroll' => 'Auto Scroll',
                                    'custom_music' => 'Musik Kustom',
                                    'love_story' => 'Love Story',
                                    'custom_theme_color' => 'Warna Tema Custom',
                                    'admin_setup' => 'Setup oleh Admin',
                                    'website_builder' => 'Website Builder',
                                    'budget_management' => 'Manajemen Anggaran',
                                    'budget_expenses' => 'Pengeluaran Anggaran',
                                    'vendor_payments' => 'Pembayaran Vendor',
                                    'vendor_payment_limit' => 'Limit Pembayaran Vendor',
                                    'savings_goals' => 'Target Tabungan',
                                    'savings_multi_user' => 'Tabungan Multi-User',
                                    'auto_savings_rules' => 'Aturan Tabungan Otomatis',
                                    'savings_projection' => 'Proyeksi Tabungan',
                                    'financial_export' => 'Ekspor Keuangan',
                                ];

                                $groupedFeatures = [
                                    'Undangan' => ['all_themes', 'edit_guest_name', 'rsvp_messages', 'maps_location', 'unlimited_recipients', 'countdown_calendar'],
                                    'Media & Konten' => ['gallery', 'gallery_limit', 'background_music', 'custom_music', 'streaming_video', 'auto_scroll', 'love_story'],
                                    'Interaksi Tamu' => ['virtual_gift', 'gift_accounts', 'shareable'],
                                    'Kustomisasi' => ['custom_theme_color', 'website_builder', 'admin_setup'],
                                    'Keuangan' => ['budget_management', 'budget_expenses', 'vendor_payments', 'vendor_payment_limit', 'savings_goals', 'savings_multi_user', 'auto_savings_rules', 'savings_projection', 'financial_export'],
                                ];
                            @endphp

                            @foreach($groupedFeatures as $groupName => $featureKeys)
                                <tr class="group-row">
                                    <td colspan="{{ $plans->count() + 1 }}">{{ $groupName }}</td>
                                </tr>
                                @foreach($featureKeys as $featureKey)
                                    @if(isset($allFeatures[$featureKey]))
                                        <tr class="feature-row">
                                            <td class="feature-col">
                                                {{ $featureLabels[$featureKey] ?? ucfirst(str_replace('_', ' ', $featureKey)) }}
                                            </td>
                                            @forelse($plans as $plan)
                                                @php
                                                    $value = data_get($plan->features, $featureKey);
                                                    $isIncluded = (bool) $value;
                                                @endphp
                                                <td class="plan-col text-center">
                                                    @if(is_numeric($value) && !is_bool($value))
                                                        @if($value == 0)
                                                            <span class="feature-na">-</span>
                                                        @elseif($value == 1)
                                                            <i class="bi bi-check-circle-fill text-success"></i>
                                                        @else
                                                            <span class="feature-number">{{ $value }}</span>
                                                        @endif
                                                    @elseif($isIncluded)
                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                    @else
                                                        <i class="bi bi-x-circle text-muted"></i>
                                                    @endif
                                                </td>
                                            @empty
                                                <td>-</td>
                                            @endforelse
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="ev-section-alt">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="ev-section-subtitle">FAQ Harga</span>
                <h2 class="ev-section-title">Pertanyaan Umum</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="ev-faq-container">
                        <div class="ev-faq-item is-open reveal reveal-d1">
                            <button class="ev-faq-question" type="button">
                                <span>Apakah ada biaya tersembunyi?</span>
                                <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                            </button>
                            <div class="ev-faq-answer">
                                <p>Tidak ada biaya tersembunyi. Semua yang tercantum adalah biaya final.</p>
                            </div>
                        </div>
                        <div class="ev-faq-item reveal reveal-d2">
                            <button class="ev-faq-question" type="button">
                                <span>Bisa upgrade paket nanti?</span>
                                <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                            </button>
                            <div class="ev-faq-answer">
                                <p>Ya, Anda bisa upgrade kapan saja dan hanya membayar selisih harga.</p>
                            </div>
                        </div>
                        <div class="ev-faq-item reveal reveal-d3">
                            <button class="ev-faq-question" type="button">
                                <span>Metode pembayaran apa saja?</span>
                                <span class="ev-faq-icon"><i class="bi bi-plus-lg"></i></span>
                            </button>
                            <div class="ev-faq-answer">
                                <p>Kami menerima transfer bank, e-wallet, kartu kredit, dan QRIS.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const faqItems = document.querySelectorAll('.ev-faq-item');
                faqItems.forEach(item => {
                    const questionBtn = item.querySelector('.ev-faq-question');
                    if (questionBtn) {
                        questionBtn.addEventListener('click', () => {
                            const isOpen = item.classList.contains('is-open');
                            faqItems.forEach(i => i.classList.remove('is-open'));
                            if (!isOpen) {
                                item.classList.add('is-open');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
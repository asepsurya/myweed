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

    <!-- Feature Comparison Table -->
    <section class="content-section comparison-section">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="section-subtitle">Detail Perbandingan</span>
                <h2 class="section-title">Fitur Semua Paket</h2>
                <p class="section-desc">Bandingkan fitur setiap paket untuk memilih yang paling sesuai.</p>
            </div>

            <div class="comparison-table-wrapper reveal">
                <div class="table-responsive">
                    <table class="comparison-table">
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
                                                            <i class="bi bi-check-circle-fill text-gold"></i>
                                                        @else
                                                            <span class="feature-number">{{ $value }}</span>
                                                        @endif
                                                    @elseif($isIncluded)
                                                        <i class="bi bi-check-circle-fill text-gold"></i>
                                                    @else
                                                        <i class="bi bi-x-circle text-muted-custom"></i>
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

    <style>
        .comparison-section {
            padding: 100px 0;
            background: var(--bg-alt);
        }

        .comparison-table-wrapper {
            overflow-x: auto;
            border-radius: var(--radius-lg);
            box-shadow: 0 20px 60px rgba(27, 42, 74, 0.08);
            border: 1px solid var(--border);
        }

        .comparison-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: var(--white);
            min-width: 800px;
        }

        .comparison-table thead th {
            background: var(--navy);
            color: var(--white);
            padding: 1.5rem 1rem;
            font-family: var(--font);
            font-weight: 600;
            font-size: 0.95rem;
            text-align: center;
            border-bottom: 3px solid var(--gold);
        }

        .comparison-table thead th.feature-col {
            text-align: left;
            min-width: 220px;
            background: var(--navy);
        }

        .comparison-table thead th.plan-highlight {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold));
            color: var(--white);
        }

        .comparison-table thead th.plan-highlight .plan-price {
            color: var(--white);
        }

        .comparison-table .plan-name {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .comparison-table .plan-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 0.25rem;
        }

        .comparison-table .plan-duration {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.75);
        }

        .comparison-table tbody td {
            padding: 1rem 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
            color: var(--text-secondary);
            vertical-align: middle;
        }

        .comparison-table tbody td.feature-col {
            font-weight: 600;
            color: var(--navy);
            background: var(--bg-alt);
        }

        .comparison-table tbody td.plan-col {
            text-align: center;
        }

        .comparison-table .group-row td {
            background: linear-gradient(90deg, rgba(198, 169, 98, 0.08), rgba(198, 169, 98, 0.03));
            padding: 0.75rem 1rem;
            font-weight: 700;
            color: var(--navy);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.75rem;
            border-bottom: 1px solid var(--border);
        }

        .comparison-table .feature-row:hover td {
            background: rgba(198, 169, 98, 0.04);
        }

        .comparison-table .text-gold {
            color: var(--gold-dark) !important;
            font-size: 1.2rem;
        }

        .comparison-table .text-muted-custom {
            color: var(--text-muted) !important;
            font-size: 1.2rem;
        }

        .comparison-table .feature-na {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .comparison-table .feature-number {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .comparison-section {
                padding: 70px 0;
            }

            .comparison-table thead th,
            .comparison-table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.8rem;
            }

            .comparison-table .plan-price {
                font-size: 1.1rem;
            }
        }
    </style>

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

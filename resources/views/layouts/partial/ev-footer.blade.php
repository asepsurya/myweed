<footer class="ev-footer">
    <div class="container-wide">
        <div class="ev-footer-grid">
            <div class="ev-footer-brand">
                <a href="{{ route('landing') }}">
                    <img src="{{ asset('assets/logo-new.png') }}" alt="Logo RuangUndang" class="ev-footer-logo"
                        width="180" height="40">
                </a>
                <p class="ev-footer-text">
                    Platform undangan digital premium untuk pernikahan dan momen bahagia lainnya. Dirancang praktis,
                    hemat biaya, dan memukau para tamu.
                </p>
                <div class="ev-footer-socials">
                    <a href="{{ config('services.socials.instagram', 'https://instagram.com') }}" target="_blank"
                        rel="noopener noreferrer" class="ev-social-btn" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="{{ config('services.socials.facebook', 'https://facebook.com') }}" target="_blank"
                        rel="noopener noreferrer" class="ev-social-btn" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="{{ config('services.socials.tiktok', 'https://tiktok.com') }}" target="_blank"
                        rel="noopener noreferrer" class="ev-social-btn" aria-label="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    <a href="{{ config('services.socials.youtube', 'https://youtube.com') }}" target="_blank"
                        rel="noopener noreferrer" class="ev-social-btn" aria-label="YouTube">
                        <i class="bi bi-youtube"></i>
                    </a>
                </div>
            </div>

            <div>
                <h5 class="ev-footer-heading">Layanan</h5>
                <ul class="ev-footer-links">
                    <li><a href="{{ route('pages.cari-tema', ['category' => 'Wedding']) }}">Undangan Pernikahan</a></li>
                    <li><a href="{{ route('pages.cari-tema', ['category' => 'Birthday']) }}">Undangan Ulang Tahun</a>
                    </li>
                    <li><a href="{{ route('pages.cari-tema', ['category' => 'Aqiqah']) }}">Undangan Aqiqah &amp;
                            Bayi</a></li>
                    <li><a href="{{ route('pages.cari-tema', ['category' => 'Khitan']) }}">Undangan Khitanan</a></li>
                    <li><a href="{{ route('pages.cari-tema') }}">Semua Koleksi Template</a></li>
                </ul>
            </div>

            <div>
                <h5 class="ev-footer-heading">Produk &amp; Fitur</h5>
                <ul class="ev-footer-links">
                    <li><a href="{{ route('pages.fitur') }}">RSVP &amp; Buku Tamu</a></li>
                    <li><a href="{{ route('pages.fitur') }}">Amplop Digital &amp; QRIS</a></li>
                    <li><a href="{{ route('pages.fitur') }}">Musik &amp; Galeri Sinematik</a></li>
                    <li><a href="{{ route('pages.harga') }}">Paket Langganan Pro</a></li>
                    <li><a href="{{ route('pages.cara-pemesanan') }}">Cara Pemesanan</a></li>
                </ul>
            </div>

            <div>
                <h5 class="ev-footer-heading">Bantuan &amp; Legal</h5>
                <ul class="ev-footer-links">
                    <li><a href="{{ route('pages.bantuan') }}">Pusat Bantuan</a></li>
                    <li><a href="{{ route('pages.faq') }}">Pertanyaan Umum (FAQ)</a></li>
                    <li><a href="{{ route('pages.syarat-ketentuan') }}">Syarat &amp; Ketentuan</a></li>
                    <li><a href="{{ route('pages.kebijakan-privasi') }}">Kebijakan Privasi</a></li>
                    <li><a href="https://wa.me/6285923431716" target="_blank" rel="noopener noreferrer">Hubungi
                            Support</a></li>
                </ul>
            </div>
        </div>

        <div class="ev-footer-payments">
            <div class="ev-payment-logos">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/QRIS_logo.svg" alt="QRIS" height="24"
                    width="70" loading="lazy">
                <img src="https://thumb.wikimedia.org/wikipedia/commons/thumb/6/65/Gopay_logo_%282019%29.svg/3840px-Gopay_logo_%282019%29.svg.png"
                    alt="GoPay" height="20" width="60" loading="lazy">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/52/Dana_logo.png" alt="DANA" height="20"
                    width="60" loading="lazy">
                <img src="https://thumb.wikimedia.org/wikipedia/commons/thumb/a/ad/Bank_Mandiri_logo_2016.svg/1280px-Bank_Mandiri_logo_2016.svg.png"
                    alt="Bank Mandiri" height="18" width="55" loading="lazy">
                <img src="https://thumb.wikimedia.org/wikipedia/commons/thumb/f/f0/Bank_Negara_Indonesia_logo_%282004%29.svg/1280px-Bank_Negara_Indonesia_logo_%282004%29.svg.png"
                    alt="Bank BNI" height="18" width="55" loading="lazy">
                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5b/Logo_Bank_Rakyat_Indonesia.svg"
                    alt="Bank BRI" height="18" width="55" loading="lazy">
            </div>

            <div class="ev-midtrans-badge">
                <i class="bi bi-shield-lock-fill"></i>
                <span>Transaksi Aman &amp; Terenkripsi oleh Midtrans</span>
            </div>
        </div>
        <style>
            .ev-footer-bottom {
                padding-top: 1.25rem;
                padding-bottom: 1.25rem;
                border-top: 1px solid rgba(15, 23, 42, 0.08);
                font-size: 0.875rem;
            }

            .ev-footer-marketplaces .ev-marketplace-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.35rem 0.6rem;
                border-radius: 0.5rem;
                background-color: rgba(15, 23, 42, 0.03);
                border: 1px solid rgba(15, 23, 42, 0.08);
                transition: transform 0.15s ease, background-color 0.15s ease, border-color 0.15s ease;
            }

            .ev-footer-marketplaces .ev-marketplace-link:hover,
            .ev-footer-marketplaces .ev-marketplace-link:focus-visible {
                transform: translateY(-1px);
                background-color: rgba(15, 23, 42, 0.06);
                border-color: rgba(15, 23, 42, 0.16);
                outline: 2px solid currentColor;
                outline-offset: 2px;
            }

            .ev-footer-marketplaces .ev-marketplace-logo {
                display: block;
                width: auto;
                height: 16px;
                object-fit: contain;
            }

            .ev-marketplace-label {
                font-size: 0.8125rem;
                font-weight: 500;
                line-height: 1.2;
            }
        </style>
        @php
            $tokopediaUrl = trim((string) config('services.socials.tokopedia', 'https://tokopedia.com'));
            $shopeeUrl = trim((string) config('services.socials.shopee', 'https://shopee.co.id'));
            $hasMarketplaces = $tokopediaUrl !== '' || $shopeeUrl !== '';
        @endphp

        <div class="ev-footer-bottom d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <p class="ev-footer-copy m-0 text-center text-sm-start">
                &copy; {{ date('Y') }} RuangUndang Platform Undangan Digital. Dibuat dengan cinta di Indonesia.
            </p>

            @if ($hasMarketplaces)
                <div
                    class="ev-footer-bottom-right d-flex flex-wrap align-items-center justify-content-center justify-content-sm-end gap-2">
                    <span class="ev-marketplace-label small text-muted">Kunjungi toko kami</span>

                    <div class="ev-footer-marketplaces d-flex align-items-center gap-2" role="group"
                        aria-label="Kunjungi toko kami di marketplace">
                        @if ($tokopediaUrl !== '')
                            <a href="{{ $tokopediaUrl }}" target="_blank" rel="noopener noreferrer"
                                aria-label="Kunjungi toko kami di Tokopedia" title="Tokopedia" class="ev-marketplace-link">
                                <img src="{{ asset('assets/tokopedia.svg') }}" alt="Tokopedia" height="16" loading="lazy"
                                    class="ev-marketplace-logo">
                            </a>
                        @endif

                        @if ($shopeeUrl !== '')
                            <a href="{{ $shopeeUrl }}" target="_blank" rel="noopener noreferrer"
                                aria-label="Kunjungi toko kami di Shopee" title="Shopee" class="ev-marketplace-link">
                                <img src="{{ asset('assets/shopee.svg') }}" alt="Shopee" height="16" loading="lazy"
                                    class="ev-marketplace-logo">
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
</footer>
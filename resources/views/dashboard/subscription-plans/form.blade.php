<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                <i class="bi bi-tags me-2"></i>
                {{ isset($subscriptionPlan) ? 'Edit Paket' : 'Tambah Paket' }}
            </h2>
            <a href="{{ route('subscription-plans.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </x-slot>

    @php
        $planFeatures = old('features', isset($subscriptionPlan) ? ($subscriptionPlan->features ?? []) : []);
        if (! is_array($planFeatures)) {
            $planFeatures = json_decode($planFeatures, true) ?: [];
        }

        $featureGroups = [
            'konten' => [
                'all_themes' => 'Akses Seluruh Tema',
                'gallery' => 'Galeri Foto',
                'gallery_limit' => 'Batas Galeri',
                'background_music' => 'Background Music',
                'custom_music' => 'Custom Music',
                'streaming_video' => 'Link Streaming/Video',
                'love_story' => 'Love Story',
                'countdown_calendar' => 'Countdown & Save to Calendar',
            ],
            'interaksi' => [
                'rsvp_messages' => 'RSVP & Ucapan',
                'virtual_gift' => 'Virtual Gift',
                'gift_accounts' => 'Rekening Titip Hadiah',
                'maps_location' => 'Lokasi Maps',
                'auto_scroll' => 'Auto Scroll',
                'edit_guest_name' => 'Ubah Nama Tamu',
                'unlimited_recipients' => 'Unlimited Penerima',
            ],
            'tampilan' => [
                'custom_theme_color' => 'Custom Warna Tema',
                'shareable' => 'Bisa Disebar',
            ],
            'admin' => [
                'admin_setup' => 'Dibuatin Admin Terima Beres',
                'website_builder' => 'Website Builder',
            ],
            'keuangan' => [
                'budget_management' => 'Manajemen Anggaran',
                'budget_expenses' => 'Pencatatan Pengeluaran',
                'vendor_payments' => 'Penjadwalan Pembayaran Vendor',
                'vendor_payment_limit' => 'Batas Jadwal Pembayaran',
                'savings_goals' => 'Target Tabungan',
                'savings_multi_user' => 'Tabungan Bersama (Multi-user)',
                'auto_savings_rules' => 'Aturan Tabungan Otomatis',
                'savings_projection' => 'Proyeksi Tabungan',
                'financial_export' => 'Ekspor Laporan Keuangan',
            ],
        ];

        $numericFeatures = ['gallery_limit', 'vendor_payment_limit', 'savings_goals'];
    @endphp

    <div class="container mt-4" style="max-width: 1000px;">
        <div class="card">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($subscriptionPlan) ? route('subscription-plans.update', $subscriptionPlan) : route('subscription-plans.store') }}" method="POST">
                    @csrf
                    @if(isset($subscriptionPlan))
                        @method('PUT')
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nama Paket</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $subscriptionPlan->name ?? '') }}" required placeholder="Contoh: Pro Wedding">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug" class="form-label fw-semibold">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $subscriptionPlan->slug ?? '') }}" required placeholder="Contoh: pro-wedding">
                                <div class="form-text">Huruf kecil, tanpa spasi, dan unik.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="price" class="form-label fw-semibold">Harga (Rp)</label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $subscriptionPlan->price ?? 0) }}" min="0" required>
                                <div class="form-text">Harga saat ini.</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="original_price" class="form-label fw-semibold">Harga Asli (Rp)</label>
                                <input type="number" name="original_price" id="original_price" class="form-control" value="{{ old('original_price', $subscriptionPlan->original_price ?? '') }}" min="0" placeholder="Contoh: 149000">
                                <div class="form-text">Kosongkan jika tidak ada harga coret.</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="badge_text" class="form-label fw-semibold">Teks Badge</label>
                                <input type="text" name="badge_text" id="badge_text" class="form-control" value="{{ old('badge_text', $subscriptionPlan->badge_text ?? '') }}" maxlength="50" placeholder="Contoh: Spesial Launching">
                                <div class="form-text">Teks label kecil di atas harga. Maks 50 karakter.</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="duration" class="form-label fw-semibold">Durasi (Hari)</label>
                                <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration', $subscriptionPlan->duration ?? 30) }}" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="invitation_limit" class="form-label fw-semibold">Batas Undangan</label>
                                <input type="number" name="invitation_limit" id="invitation_limit" class="form-control" value="{{ old('invitation_limit', $subscriptionPlan->invitation_limit ?? 1) }}" min="1" required>
                                <div class="form-text">Jumlah maksimal undangan yang bisa dibuat pengguna dalam paket ini.</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Paket Gratis</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free', isset($subscriptionPlan) && $subscriptionPlan->is_free ? 'checked' : '') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_free">Aktifkan sebagai paket gratis</label>
                                </div>
                                <div class="form-text">Jika dicentang, harga otomatis menjadi Rp 0.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Fitur / Keunggulan (Deskripsi)</label>
                        <textarea name="description" id="description" rows="4" class="form-control" placeholder="Satu fitur per baris">{{ old('description', isset($subscriptionPlan) ? implode("\n", json_decode($subscriptionPlan->description ?? '[]')) : '') }}</textarea>
                        <div class="form-text">Setiap baris akan menjadi satu poin keunggulan yang ditampilkan di halaman harga.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Matrix Fitur Teknis</label>
                        <div class="alert alert-info py-2">
                            <small><i class="bi bi-info-circle me-1"></i> Aktifkan/nonaktifkan fitur untuk paket ini. Fitur yang aktif akan tersedia untuk pengguna yang berlangganan paket ini.</small>
                        </div>

                        <div class="row g-3">
                            @foreach($featureGroups as $groupLabel => $features)
                                <div class="col-12">
                                    <h6 class="text-uppercase text-muted mb-2" style="font-size: 11px; letter-spacing: 0.5px;">{{ $groupLabel }}</h6>
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="row g-2">
                                                @foreach($features as $key => $label)
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form-check form-switch">
                                                            @if(in_array($key, $numericFeatures))
                                                                <input class="form-check-input" type="checkbox" name="features[{{ $key }}]" id="feature_{{ $key }}" value="1" {{ old('features.' . $key, isset($planFeatures[$key]) && $planFeatures[$key] ? 'checked' : '') ? 'checked' : '' }} onchange="toggleNumericInput(this, '{{ $key }}')">
                                                            @else
                                                                <input class="form-check-input" type="checkbox" name="features[{{ $key }}]" id="feature_{{ $key }}" value="1" {{ old('features.' . $key, isset($planFeatures[$key]) && $planFeatures[$key] ? 'checked' : '') ? 'checked' : '' }}>
                                                            @endif
                                                            <label class="form-check-label small" for="feature_{{ $key }}">{{ $label }}</label>
                                                        </div>
                                                        @if(in_array($key, $numericFeatures))
                                                            <div class="mt-1 numeric-input-wrapper" id="numeric-wrapper-{{ $key }}" style="{{ isset($planFeatures[$key]) && $planFeatures[$key] ? '' : 'display:none;' }}">
                                                                <input type="number" name="features[{{ $key }}_value]" class="form-control form-control-sm" style="max-width: 120px;" placeholder="Nilai" value="{{ old('features.' . $key . '_value', isset($planFeatures[$key]) && is_numeric($planFeatures[$key]) ? $planFeatures[$key] : '') }}" min="0">
                                                                <small class="text-muted" style="font-size: 10px;">Nilai numerik untuk batas/limit.</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('subscription-plans.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> {{ isset($subscriptionPlan) ? 'Simpan Perubahan' : 'Tambah Paket' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleNumericInput(checkbox, key) {
            const wrapper = document.getElementById('numeric-wrapper-' + key);
            if (wrapper) {
                wrapper.style.display = checkbox.checked ? 'block' : 'none';
            }
        }
    </script>
</x-app-layout>

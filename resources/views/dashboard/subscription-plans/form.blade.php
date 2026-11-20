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
            'guest_camera' => 'Kamera Tamu & Galeri Tamu',
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

    $groupIcons = [
        'konten' => 'bi-images',
        'interaksi' => 'bi-chat-square-dots',
        'tampilan' => 'bi-palette',
        'admin' => 'bi-sliders',
        'keuangan' => 'bi-wallet2',
    ];

    $numericFeatures = ['gallery_limit', 'vendor_payment_limit', 'savings_goals'];
@endphp

<x-app-layout>
<style>
    .feature-item {
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }

    .feature-item:has(input:checked) {
        background-color: rgba(198, 169, 98, 0.08);
        border-color: rgba(198, 169, 98, 0.45) !important;
    }

    .feature-item .form-check-label {
        cursor: pointer;
    }

    .form-section-header {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .form-section-header i {
        color: var(--adminuiux-theme-1, #C6A962);
    }
</style>

<div class="container py-4" style="max-width: 1080px;">
    {{-- Page Header --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                {{ isset($subscriptionPlan) ? 'Edit Paket Langganan' : 'Tambah Paket Langganan' }}</h3>
            <p class="text-muted small mb-0">Atur paket langganan beserta fitur yang termasuk di dalamnya.</p>
        </div>
        <a href="{{ route('subscription-plans.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle me-1"></i> Periksa kembali isian berikut:</div>
            <ul class="mb-0 small">
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

        {{-- Section: Informasi Paket --}}
        <div class="card mb-4">
            <div class="form-section-header">
                <i class="bi bi-box-seam"></i>
                <h6 class="fw-bold mb-0">Informasi Paket</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Nama Paket</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ old('name', $subscriptionPlan->name ?? '') }}" required placeholder="Contoh: Pro Wedding">
                    </div>
                    <div class="col-md-6">
                        <label for="slug" class="form-label fw-semibold">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control"
                            value="{{ old('slug', $subscriptionPlan->slug ?? '') }}" required placeholder="Contoh: pro-wedding">
                        <div class="form-text">Huruf kecil, tanpa spasi, dan unik.</div>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label for="price" class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="number" name="price" id="price" class="form-control"
                            value="{{ old('price', $subscriptionPlan->price ?? 0) }}" min="0" required>
                        <div class="form-text">Harga saat ini.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="original_price" class="form-label fw-semibold">Harga Asli (Rp)</label>
                        <input type="number" name="original_price" id="original_price" class="form-control"
                            value="{{ old('original_price', $subscriptionPlan->original_price ?? '') }}" min="0" placeholder="Contoh: 149000">
                        <div class="form-text">Kosongkan jika tidak ada harga coret.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="duration" class="form-label fw-semibold">Durasi (Hari)</label>
                        <input type="number" name="duration" id="duration" class="form-control"
                            value="{{ old('duration', $subscriptionPlan->duration ?? 30) }}" min="1" required>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label for="invitation_limit" class="form-label fw-semibold">Batas Undangan</label>
                        <input type="number" name="invitation_limit" id="invitation_limit" class="form-control"
                            value="{{ old('invitation_limit', $subscriptionPlan->invitation_limit ?? 1) }}" min="1" required>
                        <div class="form-text">Maksimal undangan yang bisa dibuat pengguna.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="template_type_access" class="form-label fw-semibold">Akses Tipe Template</label>
                        <select name="template_type_access" id="template_type_access" class="form-select">
                            <option value="1" {{ old('template_type_access', isset($subscriptionPlan) ? ($subscriptionPlan->template_type_access ?? 1) : 1) == 1 ? 'selected' : '' }}>Basic (Template Type 1)</option>
                            <option value="2" {{ old('template_type_access', isset($subscriptionPlan) ? ($subscriptionPlan->template_type_access ?? 1) : 1) == 2 ? 'selected' : '' }}>Premium (Template Type 1 + 2)</option>
                            <option value="3" {{ old('template_type_access', isset($subscriptionPlan) ? ($subscriptionPlan->template_type_access ?? 1) : 1) == 3 ? 'selected' : '' }}>Luxury (Semua Template Type)</option>
                        </select>
                        <div class="form-text">Tingkat akses template untuk paket ini.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="badge_text" class="form-label fw-semibold">Teks Badge</label>
                        <input type="text" name="badge_text" id="badge_text" class="form-control"
                            value="{{ old('badge_text', $subscriptionPlan->badge_text ?? '') }}" maxlength="50" placeholder="Contoh: Spesial Launching">
                        <div class="form-text">Label kecil di atas harga. Maks 50 karakter.</div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="border rounded-3 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <span class="fw-semibold d-block">Paket Gratis</span>
                            <small class="text-muted">Jika aktif, harga otomatis menjadi Rp 0.</small>
                        </div>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_free" id="is_free" value="1" {{ old('is_free', isset($subscriptionPlan) && $subscriptionPlan->is_free ? 'checked' : '') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_free">Aktifkan</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Deskripsi Keunggulan --}}
        <div class="card mb-4">
            <div class="form-section-header">
                <i class="bi bi-card-checklist"></i>
                <h6 class="fw-bold mb-0">Deskripsi Keunggulan</h6>
            </div>
            <div class="card-body p-4">
                <label for="description" class="form-label fw-semibold">Fitur / Keunggulan</label>
                <textarea name="description" id="description" rows="4" class="form-control" placeholder="Satu fitur per baris">{{ old('description', isset($subscriptionPlan) ? implode("\n", json_decode($subscriptionPlan->description ?? '[]')) : '') }}</textarea>
                <div class="form-text">Setiap baris menjadi satu poin keunggulan di halaman harga. Tersinkron otomatis dengan fitur aktif di bawah.</div>
            </div>
        </div>

        {{-- Section: Matrix Fitur Teknis --}}
        <div class="card mb-4">
            <div class="form-section-header">
                <i class="bi bi-sliders"></i>
                <div>
                    <h6 class="fw-bold mb-0">Matrix Fitur Teknis</h6>
                    <small class="text-muted">Aktifkan fitur yang termasuk dalam paket ini.</small>
                </div>
            </div>
            <div class="card-body p-4">
                @foreach($featureGroups as $groupLabel => $features)
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="bi {{ $groupIcons[$groupLabel] ?? 'bi-grid' }}" style="color: var(--adminuiux-theme-1, #C6A962);"></i>
                            <h6 class="fw-bold mb-0 text-uppercase" style="font-size: 12px; letter-spacing: 0.5px;">{{ $groupLabel }}</h6>
                            <span class="badge rounded-pill bg-light text-dark border" data-group-count="{{ $groupLabel }}">0</span>
                        </div>
                        <div class="row g-2">
                            @foreach($features as $key => $label)
                                <div class="col-md-6 col-lg-4">
                                    <div class="feature-item border rounded-3 p-2 h-100">
                                        <div class="form-check form-switch mb-0">
                                            @if(in_array($key, $numericFeatures))
                                                <input class="form-check-input feature-checkbox" type="checkbox" name="features[{{ $key }}]" id="feature_{{ $key }}" value="1" {{ old('features.' . $key, isset($planFeatures[$key]) && $planFeatures[$key] ? 'checked' : '') ? 'checked' : '' }} onchange="toggleNumericInput(this, '{{ $key }}')">
                                            @else
                                                <input class="form-check-input feature-checkbox" type="checkbox" name="features[{{ $key }}]" id="feature_{{ $key }}" value="1" {{ old('features.' . $key, isset($planFeatures[$key]) && $planFeatures[$key] ? 'checked' : '') ? 'checked' : '' }}>
                                            @endif
                                            <label class="form-check-label small" for="feature_{{ $key }}">{{ $label }}</label>
                                        </div>
                                        @if(in_array($key, $numericFeatures))
                                            <div class="mt-2 numeric-input-wrapper" id="numeric-wrapper-{{ $key }}" style="{{ isset($planFeatures[$key]) && $planFeatures[$key] ? '' : 'display:none;' }}">
                                                <input type="number" name="features[{{ $key }}_value]" class="form-control form-control-sm" placeholder="Nilai" value="{{ old('features.' . $key . '_value', isset($planFeatures[$key]) && is_numeric($planFeatures[$key]) ? $planFeatures[$key] : '') }}" min="0">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Sticky Footer --}}
        <div class="d-flex justify-content-end gap-2 py-3 bg-white border-top rounded-3">
            <a href="{{ route('subscription-plans.index') }}" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-1"></i> {{ isset($subscriptionPlan) ? 'Simpan Perubahan' : 'Tambah Paket' }}
            </button>
        </div>
    </form>
</div>

<script>
    const featureLabelMap = @json($featureGroups);

    function updateDescriptionFromFeatures() {
        const checkedBoxes = document.querySelectorAll('input[name^="features["]:checked');
        const lines = [];
        checkedBoxes.forEach(box => {
            const label = box.closest('.form-check')?.querySelector('.form-check-label');
            if (label) {
                lines.push(label.textContent.trim());
            }
        });
        const descriptionField = document.getElementById('description');
        if (descriptionField) {
            const cursorPosition = descriptionField.selectionStart;
            const oldLength = descriptionField.value.length;
            descriptionField.value = lines.join('\n');
            if (document.activeElement === descriptionField) {
                const newLength = descriptionField.value.length;
                descriptionField.setSelectionRange(
                    Math.min(cursorPosition, newLength),
                    Math.min(cursorPosition + (newLength - oldLength), newLength)
                );
            }
        }
        updateGroupCounts();
    }

    function updateGroupCounts() {
        const groups = {};
        document.querySelectorAll('input[name^="features["]').forEach(box => {
            const id = box.id.replace('feature_', '');
            for (const [group, features] of Object.entries(featureLabelMap)) {
                if (Object.prototype.hasOwnProperty.call(features, id)) {
                    groups[group] = (groups[group] || 0) + (box.checked ? 1 : 0);
                    break;
                }
            }
        });
        document.querySelectorAll('[data-group-count]').forEach(badge => {
            const g = badge.getAttribute('data-group-count');
            if (groups[g] !== undefined) {
                badge.textContent = groups[g];
            }
        });
    }

    function toggleNumericInput(checkbox, key) {
        const wrapper = document.getElementById('numeric-wrapper-' + key);
        if (wrapper) {
            wrapper.style.display = checkbox.checked ? 'block' : 'none';
        }
        updateDescriptionFromFeatures();
    }

    document.querySelectorAll('input[name^="features["]').forEach(box => {
        box.addEventListener('change', updateDescriptionFromFeatures);
    });

    document.addEventListener('DOMContentLoaded', updateDescriptionFromFeatures);
</script>
</x-app-layout>
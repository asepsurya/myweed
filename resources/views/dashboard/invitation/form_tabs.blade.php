@php
    $inv = $invitation ?? null;
@endphp

<style>
    /* =============================================
       RESPONSIVE (MOBILE)
    ============================================= */
    @media (max-width: 991px) {
        .adminuiux-content {
            padding: 0 !important;
        }

        .builder-wrapper {
            flex-direction: column;
            height: 100vh !important;
            width: 100vw !important;
            margin: 0 !important;
            border-radius: 0 !important;
            border: none !important;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            background: var(--bs-body-bg);
        }

        .builder-sidebar {
            width: 100% !important;
            height: 100% !important;
            flex-direction: column-reverse !important;
            border-right: none !important;
        }

        .sidebar-nav-vertical {
            width: 100% !important;
            height: auto !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            border-right: none !important;
            border-top: 1px solid var(--bs-border-color);
            padding: 0.4rem !important;
            justify-content: space-around !important;
            gap: 0.25rem !important;
            background: var(--bs-tertiary-bg);
            z-index: 1041;
        }

        .nav-vertical-link {
            width: 40px !important;
            height: 40px !important;
            border-radius: 0.6rem !important;
            border: none !important;
        }

        .nav-vertical-link span {
            display: none !important;
        }

        .nav-vertical-link i {
            font-size: 1.15rem !important;
        }

        .builder-canvas {
            display: none !important;
        }

        .sidebar-header {
            padding: 0.75rem 1rem !important;
            background: var(--bs-card-bg) !important;
            border-bottom: 1px solid var(--bs-border-color);
            flex-wrap: nowrap !important;
            justify-content: space-between !important;
        }

        .sidebar-content {
            padding: 1.25rem 1rem !important;
            background: rgba(var(--bs-tertiary-bg-rgb), 0.3);
        }

        .form-control,
        .form-select {
            padding: 0.6rem 0.75rem !important;
            border-radius: 0.75rem !important;
        }

        label {
            margin-bottom: 0.4rem !important;
            font-size: 13px !important;
        }

        .mobile-next-prev {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 0.75rem;
            background: var(--bs-card-bg);
            border-top: 1px solid var(--bs-border-color);
        }

        .mobile-next-prev .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-next-prev #mobileTabLabel {
            flex: 0 0 auto;
            text-align: center;
            min-width: 50px;
        }

        #cropModal {
            z-index: 1070 !important;
        }

        .modal-backdrop {
            z-index: 1060 !important;
        }
    }

    /* === Music Source Tabs (Segmented Control) === */
    .music-source-tabs {
        display: flex;
        background: var(--bs-tertiary-bg);
        padding: 5px;
        border-radius: 12px;
        gap: 5px;
        border: 1px solid var(--bs-border-color);
        margin-bottom: 1.2rem;
    }

    .music-source-tabs input {
        display: none;
    }

    .music-source-tabs label {
        flex: 1;
        text-align: center;
        padding: 10px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--bs-secondary-color);
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin: 0;
    }

    .music-source-tabs label:hover {
        color: var(--bs-primary);
        background: rgba(var(--bs-primary-rgb), 0.05);
    }

    .music-source-tabs input:checked+label {
        background: var(--bs-body-bg);
        color: var(--bs-primary);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    [data-bs-theme="dark"] .music-source-tabs input:checked+label {
        background: var(--bs-primary);
        color: #fff;
        box-shadow: 0 4px 14px rgba(var(--bs-primary-rgb), 0.4);
    }

    /* === Music Content Box === */
    .music-content-box {
        background: var(--bs-tertiary-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 14px;
        padding: 16px;
        margin-top: 12px;
    }

    /* === Music List Items === */
    .music-list-item {
        background: var(--bs-body-bg) !important;
        transition: all 0.25s ease;
    }

    .music-list-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.07);
        border-color: var(--bs-primary) !important;
    }

    .music-list-item.selected {
        border-color: var(--bs-primary) !important;
        background: rgba(var(--bs-primary-rgb), 0.1) !important;
    }

    .music-list-item.selected .music-icon-box {
        background: var(--bs-primary) !important;
        color: #fff;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(var(--bs-primary-rgb), 0.4);
        }

        70% {
            transform: scale(1.05);
            box-shadow: 0 0 0 8px rgba(var(--bs-primary-rgb), 0);
        }

        100% {
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(var(--bs-primary-rgb), 0);
        }
    }

    /* === Audio Player Wrapper === */
    .audio-player-wrapper {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 12px;
        padding: 10px;
        margin-top: 1.2rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .audio-player-wrapper audio {
        width: 100%;
        height: 38px;
    }

    /* === Custom Upload Box === */
    .upload-box-custom {
        border: 2px dashed var(--bs-border-color);
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: var(--bs-body-bg);
    }

    .upload-box-custom:hover {
        border-color: var(--bs-primary);
        background: rgba(var(--bs-primary-rgb), 0.05);
        transform: translateY(-2px);
    }

    /* === Country Code Dropdown === */
    .country-dropdown-btn {
        min-width: 120px;
        border-radius: 0.5rem 0 0 0.5rem;
    }

    .country-dropdown-btn .flag-emoji,
    .country-dropdown-menu .flag-emoji {
        font-size: 1.1rem;
    }

    .country-dropdown-menu .country-option:hover {
        background-color: var(--bs-primary-bg-subtle);
    }
</style>

{{-- 1. MEMPELAI PRIA --}}
<div id="tab-1" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3 d-flex align-items-center gap-2 mb-3">
            <div class="islami-icon"><i class="bi bi-person-fill fs-5"></i></div>
            <h6 class="mb-0 fw-bold">Data Mempelai Pria</h6>
        </div>
        <div class="card-body p-0">
            <div class="row g-3">
                <div class="col-12">
                    <label for="groom_name" class="form-label fw-semibold mb-2">Nama Lengkap</label>
                    <input type="text" id="groom_name" name="groom_name"
                        value="{{ old('groom_name', $inv?->groom_name ?? '') }}" placeholder="Contoh: Ahmad Fauzan"
                        class="form-control">
                    <small class="text-muted">Nama lengkap sesuai KTP.</small>
                </div>
                <div class="col-12">
                    <label for="groom_nickname" class="form-label fw-semibold mb-2">Nama Panggilan</label>
                    <input type="text" id="groom_nickname" name="groom_nickname"
                        value="{{ old('groom_nickname', $inv?->groom_nickname ?? '') }}" placeholder="Contoh: Fauzan"
                        class="form-control">
                    <small class="text-muted">Nama panggilan yang akan ditampilkan di undangan.</small>
                </div>
                <div class="col-md-6">
                    <label for="groom_father_name" class="form-label fw-semibold mb-2">Nama Ayah</label>
                    <input type="text" id="groom_father_name" name="groom_father_name"
                        value="{{ old('groom_father_name', $inv?->groom_father_name ?? '') }}"
                        placeholder="Contoh: Bapak Hadi" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="groom_mother_name" class="form-label fw-semibold mb-2">Nama Ibu</label>
                    <input type="text" id="groom_mother_name" name="groom_mother_name"
                        value="{{ old('groom_mother_name', $inv?->groom_mother_name ?? '') }}"
                        placeholder="Contoh: Ibu Siti" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold mb-2">Anak ke-...</label>
                    <div class="d-flex gap-2 align-items-center">
                        <select id="groom_child_order_select" class="form-select"
                            onchange="handleChildOrderChange('groom', this.value)">
                            <option value="">-- Pilih --</option>
                            <option value="Anak pertama">Anak pertama</option>
                            <option value="Anak ke-2">Anak ke-2</option>
                            <option value="Anak ke-3">Anak ke-3</option>
                            <option value="Anak ke-4">Anak ke-4</option>
                            <option value="Anak ke-5">Anak ke-5</option>
                            <option value="__other__">Lebih dari 5...</option>
                        </select>
                        <input type="number" id="groom_child_order_number" class="form-control"
                            style="display: none; max-width: 120px;" placeholder="Nomor" min="6"
                            oninput="formatChildOrderNumber('groom', this.value)">
                        <input type="hidden" id="groom_child_order" name="groom_child_order"
                            value="{{ old('groom_child_order', $inv?->groom_child_order ?? '') }}">
                    </div>
                    <small class="text-muted">Tulis urutan anak mempelai pria dalam keluarganya.</small>
                </div>
                <div class="col-12">
                    <label for="groom_username_instagram" class="form-label fw-semibold mb-2">Instagram Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">@</span>
                        <input type="text" id="groom_username_instagram" name="groom_username_instagram"
                            value="{{ old('groom_username_instagram', $inv?->groom_username_instagram ?? '') }}"
                            class="form-control insta-username" placeholder="fauzan_akbar">
                    </div>
                    <small class="text-muted">Username Instagram tanpa tanda @.</small>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold mb-2">Foto Mempelai Pria</label>
                    <div class="upload-zone border rounded p-4 text-center {{ ($inv && $inv->foto_pria) ? 'd-none' : '' }}"
                        id="uploadBoxGroomContainer">
                        <label for="foto_pria" class="cursor-pointer mb-0 d-block">
                            <i class="bi bi-cloud-upload fs-3 text-primary"></i>
                            <p class="text-muted mb-0 mt-2">Klik untuk upload foto</p>
                            <input id="foto_pria" type="file" name="foto_pria" class="d-none"
                                onchange="openCropModal(event, 'groom')">
                        </label>
                    </div>
                    <div id="previewContainerGroom"
                        class="mt-3 {{ ($inv && $inv->foto_pria) ? '' : 'd-none' }} text-center position-relative">
                        <img id="previewGroom"
                            src="{{ ($inv && $inv->foto_pria) ? asset('storage/' . $inv->foto_pria) : '' }}"
                            class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: cover;">
                        <button type="button" onclick="removePreview('groom')"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"><i
                                class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. TEMA & WARNA --}}
<div id="tab-2" class="tab-content active">
    @php
        $selectedTemplateId = old('template_id', $inv?->template_id ?? ($templates->first()?->id ?? ''));
    @endphp
    <input type="hidden" name="template_id" id="template_id_hidden" value="{{ $selectedTemplateId }}">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-3 d-flex align-items-center justify-content-between mb-3">
            <h6 class="mb-0 fw-bold">Pilih Template</h6>
            <input type="text" id="searchTemplate" class="form-control w-50" placeholder="Cari template...">
        </div>
        <div class="card-body p-0">
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Kategori</label>
                <select id="categorySelect" class="form-select">
                    <option value="all">Semua Kategori</option>
                    @php $categories = $templates->load('category')->pluck('category.name')->filter()->unique(); @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3" id="templateGallery">
                @foreach ($templates as $template)
                    @php $isLocked = !auth()->user()->hasFeature('all_themes') && $template->slug !== 'simple-theme'; @endphp
                    <div class="col-6 template-selector-item" data-category="{{ $template->category->name ?? 'modern' }}"
                        data-name="{{ strtolower($template->name) }}"
                        data-color="{{ $template->primary_color ?? '#0d9488' }}" data-template-id="{{ $template->id }}">
                        <div class="card template-card-selector h-100 {{ $isLocked ? 'locked opacity-75' : '' }} {{ ($selectedTemplateId == $template->id) ? 'selected' : '' }}"
                            onclick="{{ $isLocked ? 'showPremiumAlert()' : 'selectTemplate(this, ' . $template->id . ')' }}">
                            <div class="position-absolute top-0 end-0 m-1 z-1">
                                @if ($template->is_premium)
                                    <span class="premium-badge shadow-sm"><i class="bi bi-gem me-1"></i>PREMIUM</span>
                                @else
                                    <span class="basic-badge shadow-sm">BASIC</span>
                                @endif
                            </div>
                            @if ($isLocked)
                                <div class="position-absolute top-50 start-50 translate-middle z-2">
                                    <i class="bi bi-lock-fill fs-2 text-white shadow-lg"></i>
                                </div>
                            @endif
                            <div class="check-icon"><i class="bi bi-check-lg"></i></div>
                            @php
                                $thumb = $template->thumbnail ?? $template->preview;
                                $thumbUrl = $thumb ? asset('storage/' . $thumb) : 'https://placehold.co/300x400';
                            @endphp
                            <img src="{{ $thumbUrl }}"
                                class="card-img-top template-thumbnail {{ $isLocked ? 'grayscale' : '' }}"
                                alt="{{ $template->name }}" onerror="this.src='https://placehold.co/300x400?text=No+Image'">
                            <div class="card-body p-2 text-center">
                                <span class="fw-bold text-truncate d-block"
                                    style="font-size: 12px;">{{ $template->name }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center align-items-center gap-3 mt-4 mb-4">
                <button type="button" id="prevPage" class="btn btn-sm btn-outline-secondary" disabled>
                    <i class="bi bi-chevron-left"></i> Sebelumnya
                </button>
                <span id="pageInfo" class="small text-muted">Halaman 1 dari 1</span>
                <button type="button" id="nextPage" class="btn btn-sm btn-outline-secondary" disabled>
                    Selanjutnya <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">Background Header (Sampul)</label>
                <div class="upload-zone border rounded p-4 text-center {{ ($inv && $inv->gallery_cover) ? 'd-none' : '' }}"
                    id="uploadBoxCoverContainer">
                    <label for="gallery_cover" class="cursor-pointer mb-0 d-block">
                        <i class="bi bi-image fs-3 text-primary"></i>
                        <p class="text-muted mb-0 mt-2">Klik untuk upload Background Header</p>
                        <input id="gallery_cover" type="file" name="gallery_cover" class="d-none"
                            onchange="openCropModal(event, 'cover')">
                    </label>
                </div>
                <div id="previewContainerCover"
                    class="mt-3 {{ ($inv && $inv->gallery_cover) ? '' : 'd-none' }} text-center position-relative">
                    <img id="previewCover"
                        src="{{ ($inv && $inv->gallery_cover) ? asset('storage/' . $inv->gallery_cover) : '' }}"
                        class="img-fluid rounded border shadow-sm w-100" style="max-height: 250px; object-fit: cover;">
                    <button type="button" onclick="removePreview('cover')"
                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"><i class="bi bi-x"></i></button>
                </div>
                <small class="text-muted mt-1 d-block">Foto sampul akan ditampilkan di bagian atas undangan.</small>
            </div>

            <div class="mb-3">
                <label for="primary_color" class="form-label fw-semibold mb-2">Warna Utama</label>
                <div class="d-flex gap-3 align-items-center">
                    <input type="color" name="primary_color" id="primary_color" class="form-control form-control-color"
                        value="{{ $inv?->primary_color ?? '#0d9488' }}" style="width: 60px; height: 40px;">
                    <span class="text-muted">Warna untuk teks, tombol, dan aksen pada undangan.</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. GALERI FOTO --}}
@auth
    @if(auth()->user()->hasFeature('gallery'))
        <div id="tab-3" class="tab-content d-none">
            <div class="mb-3">
                <div
                    class="card-header bg-transparent border-0 p-0 pb-3 d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0">Galeri Foto</h6>
                </div>
                <div class="card-body p-0">
                    <div id="gallery-dropzone" class="border border-dashed p-5 text-center rounded cursor-pointer">
                        <i class="bi bi-images fs-3 text-muted"></i>
                        <p class="mb-0 mt-2">Klik atau drag & drop foto di sini</p>
                        <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="d-none">
                    </div>
                    <div id="gallery-preview" class="d-flex gap-2 flex-wrap mt-3">
                        @if($inv && $inv->galleries)
                            @foreach($inv->galleries as $image)
                                <div class="position-relative border rounded overflow-hidden" style="width: 80px; height: 80px;">
                                    <img src="{{ asset('storage/' . $image->image) }}" class="w-100 h-100 object-fit-cover">
                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0"
                                        style="width:20px;height:20px; line-height: 1;"
                                        onclick="deleteGallery({{ $image->id }})">&times;</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <small class="text-muted mt-2 d-block">Maksimal 10 foto. Format: JPG, PNG, atau WebP.</small>
                </div>
            </div>
        </div>
    @endif
@endauth

{{-- 4. MUSIK --}}
@auth
    @if(auth()->user()->hasFeature('background_music') || auth()->user()->hasFeature('custom_music'))
        <div id="tab-4" class="tab-content d-none">
            <div class="mb-3">
                <div class="card-header bg-transparent border-0 p-3 mb-3">
                    <h6 class="fw-bold mb-0">Lagu Latar</h6>
                </div>
                <div class="card-body p-0">
                    @php $musicSource = $inv?->music_source ?? 'library'; @endphp
                    <input type="hidden" id="music_id" name="music_id" value="{{ $inv?->music ?? '' }}">

                    <div class="music-source-tabs">
                        <input type="radio" class="btn-check" name="music_source" id="srcLibrary" value="library" {{ $musicSource == 'library' ? 'checked' : '' }} onchange="switchMusicSource('library')">
                        <label for="srcLibrary"><i class="bi bi-music-note-list"></i> Library</label>

                        <input type="radio" class="btn-check" name="music_source" id="srcYoutube" value="youtube" {{ $musicSource == 'youtube' ? 'checked' : '' }} onchange="switchMusicSource('youtube')">
                        <label for="srcYoutube"><i class="bi bi-youtube"></i> YouTube</label>

                        <input type="radio" class="btn-check" name="music_source" id="srcUpload" value="upload" {{ $musicSource == 'upload' ? 'checked' : '' }} onchange="switchMusicSource('upload')">
                        <label for="srcUpload"><i class="bi bi-cloud-upload"></i> Upload</label>
                    </div>

                    <div class="music-content-box">
                        <div id="source-library" class="music-source-div {{ $musicSource != 'library' ? 'd-none' : '' }}">
                            <label class="form-label fw-semibold mb-2">Pilih Lagu dari Library</label>
                            <div id="musicListContainer" class="d-flex flex-column gap-2"
                                style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                                @foreach ($music as $m)
                                    <div class="music-list-item border rounded {{ ($inv && $inv->music == $m->id) ? 'selected' : '' }}"
                                        data-id="{{ $m->id }}" data-url="{{ $m->full_audio_url }}"
                                        data-cover="{{ $m->full_cover_url ?? asset('tempelate/no_sound.webp') }}"
                                        data-artist="{{ $m->artist }}" data-title="{{ $m->title }}"
                                        onclick="handleMusicClick(this)">
                                        <div class="music-icon-box">
                                            <i class="bi bi-music-note-beamed"></i>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-0 fw-bold music-title-clamp">{{ $m->title }}</p>
                                            <p class="mb-0 text-muted" style="font-size: 11px;">{{ $m->artist }}</p>
                                        </div>
                                        <div class="music-play-btn"
                                            onclick="event.stopPropagation(); previewAudio('{{ $m->full_audio_url }}')">
                                            <i class="bi bi-play-circle-fill fs-4"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mt-2">Pilih lagu latar yang akan ditampilkan di undangan.</small>
                        </div>

                        <div id="source-youtube" class="music-source-div {{ $musicSource != 'youtube' ? 'd-none' : '' }}">
                            <label class="form-label fw-semibold mb-2">Link YouTube (Musik)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-danger text-white border-0"><i
                                        class="bi bi-youtube"></i></span>
                                <input type="text" name="music_youtube_url" class="form-control"
                                    placeholder="https://www.youtube.com/watch?v=..."
                                    value="{{ $inv?->music_youtube_url ?? '' }}" oninput="updateLivePreview()">
                            </div>
                            <small class="text-muted d-block">Masukkan link YouTube untuk musik latar undangan.</small>
                        </div>

                        <div id="source-upload" class="music-source-div {{ $musicSource != 'upload' ? 'd-none' : '' }}">
                            @if(auth()->user()->hasFeature('custom_music'))
                                <label class="form-label fw-semibold mb-2">Upload File Audio</label>
                                <div class="upload-box-custom" onclick="document.getElementById('custom_music_input').click()">
                                    <input type="file" id="custom_music_input" name="custom_music" accept="audio/*" class="d-none"
                                        onchange="updateLivePreview(); document.getElementById('upload_file_name').innerText = this.files[0] ? this.files[0].name : 'Belum ada file terpilih';">
                                    <i class="bi bi-cloud-arrow-up fs-2 text-primary d-block mb-2"></i>
                                    <p class="mb-1 fw-bold">Klik untuk memilih file</p>
                                    <small class="text-muted" id="upload_file_name">@if(!empty($inv->custom_music))
                                    {{ basename($inv->custom_music) }} @else Belum ada file terpilih @endif</small>
                                </div>
                                <small class="text-muted d-block mt-2">Format: MP3, WAV, OGG (Maks 5MB).</small>
                            @else
                                <div class="border border-dashed p-5 text-center rounded bg-light">
                                    <i class="bi bi-lock fs-3 text-muted"></i>
                                    <p class="mb-0 mt-2 text-muted">Fitur Custom Music tersedia untuk paket berbayar.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="audio-player-wrapper">
                        <i class="bi bi-headphones fs-4 text-muted"></i>
                        <audio id="audioPlayer" controls></audio>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth

{{-- 5. RSVP --}}
<div id="tab-5" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-3 mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enable_rsvp" name="enable_rsvp" value="1" {{ ($inv && $inv->enable_rsvp) ? 'checked' : '' }} onchange="toggleSettings('rsvp_settings', this.checked)">
                <label class="form-check-label fw-bold" for="enable_rsvp">Aktifkan RSVP</label>
            </div>
        </div>
        <div class="card-body p-0" id="rsvp_settings" style="{{ ($inv && $inv->enable_rsvp) ? '' : 'display:none' }}">
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Batas Tanggal RSVP</label>
                <input type="date" name="rsvp_deadline" value="{{ $inv?->rsvp_deadline ?? '' }}" class="form-control">
                <small class="text-muted">Tanggal batas akhir tamu mengirimkan konfirmasi kehadiran.</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Nomor WhatsApp Notifikasi</label>
                <div class="input-group">
                    <select class="d-none" id="countryCode">
                        <option value="+62">🇮🇩 +62</option>
                        <option value="+60">🇲🇾 +60</option>
                        <option value="+65">🇸🇬 +65</option>
                        <option value="+66">🇹🇭 +66</option>
                        <option value="+1">🇺🇸 +1</option>
                        <option value="+81">🇯🇵 +81</option>
                        <option value="+82">🇰🇷 +82</option>
                        <option value="+44">🇬🇧 +44</option>
                        <option value="+91">🇮🇳 +91</option>
                    </select>
                    <button type="button"
                        class="btn btn-outline-secondary dropdown-toggle country-dropdown-btn flex-shrink-0"
                        id="countryDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                        <span id="selectedFlagCountry" class="flag-emoji">🇮🇩</span>
                        <span class="ms-1" id="selectedCodeCountry">+62</span>
                    </button>
                    <ul class="dropdown-menu country-dropdown-menu" aria-labelledby="countryDropdownBtn">
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+62" data-flag="🇮🇩"><span class="flag-emoji">🇮🇩</span> <span
                                    class="fw-medium">+62</span> <span class="text-muted ms-2">Indonesia</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+60" data-flag="🇲🇾"><span class="flag-emoji">🇲🇾</span> <span
                                    class="fw-medium">+60</span> <span class="text-muted ms-2">Malaysia</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+65" data-flag="🇸🇬"><span class="flag-emoji">🇸🇬</span> <span
                                    class="fw-medium">+65</span> <span class="text-muted ms-2">Singapura</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+66" data-flag="🇹🇭"><span class="flag-emoji">🇹🇭</span> <span
                                    class="fw-medium">+66</span> <span class="text-muted ms-2">Thailand</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+1" data-flag="🇺🇸"><span class="flag-emoji">🇺🇸</span> <span
                                    class="fw-medium">+1</span> <span class="text-muted ms-2">USA/Canada</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+81" data-flag="🇯🇵"><span class="flag-emoji">🇯🇵</span> <span
                                    class="fw-medium">+81</span> <span class="text-muted ms-2">Jepang</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+82" data-flag="🇰🇷"><span class="flag-emoji">🇰🇷</span> <span
                                    class="fw-medium">+82</span> <span class="text-muted ms-2">Korea</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+44" data-flag="🇬🇧"><span class="flag-emoji">🇬🇧</span> <span
                                    class="fw-medium">+44</span> <span class="text-muted ms-2">Inggris</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#"
                                data-code="+91" data-flag="🇮🇳"><span class="flag-emoji">🇮🇳</span> <span
                                    class="fw-medium">+91</span> <span class="text-muted ms-2">India</span></a></li>
                    </ul>
                    <input type="tel" id="phoneNumber" class="form-control" placeholder="81234567890"
                        autocomplete="off">
                </div>
                <input type="hidden" name="rsvp_whatsapp" id="fullPhone" value="{{ $inv?->rsvp_whatsapp ?? '' }}">
                <small class="text-muted">Nomor HP untuk menerima notifikasi RSVP dari tamu.</small>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Pesan Konfirmasi</label>
                <textarea name="rsvp_message" rows="3" class="form-control">{{ $inv?->rsvp_message ?? '' }}</textarea>
                <small class="text-muted">Pesan yang akan ditampilkan di halaman RSVP.</small>
            </div>
        </div>
    </div>
</div>

{{-- 6. TEMPAT & TANGGAL --}}
<div id="tab-6" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-3 mb-3">
            <h6 class="fw-bold mb-0">Jadwal Acara</h6>
        </div>
        <div class="card-body p-0">
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">Tanggal Pernikahan</label>
                <input type="date" id="wedding_date" name="wedding_date" value="{{ $inv?->wedding_date ?? '' }}"
                    class="form-control">
                <small class="text-muted">Tanggal pelaksanaan acara pernikahan.</small>
            </div>

            <hr class="my-4">
            <div class="mb-4">
                <label class="form-label fw-bold text-primary mb-3">Akad Nikah</label>
                <input type="text" name="akad_location" value="{{ $inv?->akad_location ?? '' }}"
                    placeholder="Contoh: Gedung Merdeka" class="form-control mb-2">
                <small class="text-muted">Nama tempat pelaksanaan akad nikah.</small>
                <input type="text" name="akad_address" value="{{ $inv?->akad_address ?? '' }}"
                    placeholder="Alamat lengkap" class="form-control mt-3 mb-2">
                <div class="row g-2 mt-1">
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Mulai</small>
                        <input type="time" name="akad_time" value="{{ $inv?->akad_time ?? '' }}" class="form-control">
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Selesai</small>
                        <input type="time" name="akad_time_end" value="{{ $inv?->akad_time_end ?? '' }}"
                            class="form-control time-end">
                        <div class="form-check mt-2">
                            <input class="form-check-input sampai-selesai" type="checkbox" id="akad_time_end_done">
                            <label class="form-check-label" for="akad_time_end_done">Selesai</label>
                        </div>
                    </div>
                </div>
                <input type="text" name="akad_maps" value="{{ $inv?->akad_maps ?? '' }}" placeholder="Link Google Maps"
                    class="form-control mt-3" oninput="updateMapEmbed('akad_maps', 'akad_map_embed')">
                <small class="text-muted">Link peta lokasi akad nikah.</small>
                <div id="akad_map_embed" class="mt-2 rounded overflow-hidden border"
                    style="height: 0; transition: height 0.3s;"></div>
            </div>

            <hr class="my-4">
            <div class="mb-3">
                <label class="form-label fw-bold text-primary mb-3">Resepsi</label>
                <input type="text" name="resepsi_location" value="{{ $inv?->resepsi_location ?? '' }}"
                    placeholder="Contoh: Hotel Mulia" class="form-control mb-2">
                <small class="text-muted">Nama tempat pelaksanaan resepsi.</small>
                <input type="text" name="resepsi_address" value="{{ $inv?->resepsi_address ?? '' }}"
                    placeholder="Alamat lengkap" class="form-control mt-3 mb-2">
                <div class="row g-2 mt-1">
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Mulai</small>
                        <input type="time" name="resepsi_time" value="{{ $inv?->resepsi_time ?? '' }}"
                            class="form-control">
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Selesai</small>
                        <input type="time" name="resepsi_time_end" value="{{ $inv?->resepsi_time_end ?? '' }}"
                            class="form-control time-end">
                        <div class="form-check mt-2">
                            <input class="form-check-input sampai-selesai" type="checkbox" id="sampai_selesai"
                                name="sampai_selesai" value="1">
                            <label class="form-check-label" for="sampai_selesai">Selesai</label>
                        </div>
                    </div>
                </div>
                <input type="text" name="resepsi_maps" value="{{ $inv?->resepsi_maps ?? '' }}"
                    placeholder="Link Google Maps" class="form-control mt-3"
                    oninput="updateMapEmbed('resepsi_maps', 'resepsi_map_embed')">
                <small class="text-muted">Link peta lokasi resepsi.</small>
                <div id="resepsi_map_embed" class="mt-2 rounded overflow-hidden border"
                    style="height: 0; transition: height 0.3s;"></div>
            </div>
        </div>
    </div>
</div>

{{-- 7. MEMPELAI WANITA --}}
<div id="tab-7" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-3 d-flex align-items-center gap-2 mb-3">
            <div class="islami-icon"><i class="bi bi-person-heart fs-5"></i></div>
            <h6 class="mb-0 fw-bold">Data Mempelai Wanita</h6>
        </div>
        <div class="card-body p-0">
            <div class="row g-3">
                <div class="col-12">
                    <label for="bride_name" class="form-label fw-semibold mb-2">Nama Lengkap</label>
                    <input type="text" id="bride_name" name="bride_name"
                        value="{{ old('bride_name', $inv?->bride_name ?? '') }}" placeholder="Contoh: Siti Rahayu"
                        class="form-control">
                    <small class="text-muted">Nama lengkap sesuai KTP.</small>
                </div>
                <div class="col-12">
                    <label for="bride_nickname" class="form-label fw-semibold mb-2">Nama Panggilan</label>
                    <input type="text" id="bride_nickname" name="bride_nickname"
                        value="{{ old('bride_nickname', $inv?->bride_nickname ?? '') }}" placeholder="Contoh: Rahayu"
                        class="form-control">
                    <small class="text-muted">Nama panggilan yang akan ditampilkan di undangan.</small>
                </div>
                <div class="col-md-6">
                    <label for="bride_father_name" class="form-label fw-semibold mb-2">Nama Ayah</label>
                    <input type="text" id="bride_father_name" name="bride_father_name"
                        value="{{ old('bride_father_name', $inv?->bride_father_name ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="bride_mother_name" class="form-label fw-semibold mb-2">Nama Ibu</label>
                    <input type="text" id="bride_mother_name" name="bride_mother_name"
                        value="{{ old('bride_mother_name', $inv?->bride_mother_name ?? '') }}" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold mb-2">Anak ke-...</label>
                    <div class="d-flex gap-2 align-items-center">
                        <select id="bride_child_order_select" class="form-select"
                            onchange="handleChildOrderChange('bride', this.value)">
                            <option value="">-- Pilih --</option>
                            <option value="Anak pertama">Anak pertama</option>
                            <option value="Anak ke-2">Anak ke-2</option>
                            <option value="Anak ke-3">Anak ke-3</option>
                            <option value="Anak ke-4">Anak ke-4</option>
                            <option value="Anak ke-5">Anak ke-5</option>
                            <option value="__other__">Lebih dari 5...</option>
                        </select>
                        <input type="number" id="bride_child_order_number" class="form-control"
                            style="display: none; max-width: 120px;" placeholder="Nomor" min="6"
                            oninput="formatChildOrderNumber('bride', this.value)">
                        <input type="hidden" id="bride_child_order" name="bride_child_order"
                            value="{{ old('bride_child_order', $inv?->bride_child_order ?? '') }}">
                    </div>
                    <small class="text-muted">Tulis urutan anak mempelai wanita dalam keluarganya.</small>
                </div>
                <div class="col-12">
                    <label for="bride_username_instagram" class="form-label fw-semibold mb-2">Instagram Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">@</span>
                        <input type="text" id="bride_username_instagram" name="bride_username_instagram"
                            value="{{ old('bride_username_instagram', $inv?->bride_username_instagram ?? '') }}"
                            class="form-control insta-username" placeholder="siti_rahayu">
                    </div>
                    <small class="text-muted">Username Instagram tanpa tanda @.</small>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold mb-2">Foto Mempelai Wanita</label>
                    <div class="upload-zone border rounded p-4 text-center bg-light {{ ($inv && $inv->foto_wanita) ? 'd-none' : '' }}"
                        id="uploadBoxBrideContainer">
                        <label for="foto_wanita" class="cursor-pointer mb-0 d-block">
                            <i class="bi bi-cloud-upload fs-3 text-primary"></i>
                            <p class="text-muted mb-0 mt-2">Klik untuk upload foto</p>
                            <input id="foto_wanita" type="file" name="foto_wanita" class="d-none"
                                onchange="openCropModal(event, 'bride')">
                        </label>
                    </div>
                    <div id="previewContainerBride"
                        class="mt-3 {{ ($inv && $inv->foto_wanita) ? '' : 'd-none' }} text-center position-relative">
                        <img id="previewBride"
                            src="{{ ($inv && $inv->foto_wanita) ? asset('storage/' . $inv->foto_wanita) : '' }}"
                            class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: cover;">
                        <button type="button" onclick="removePreview('bride')"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"><i
                                class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 8. VIDEO & KISAH --}}
@auth
    @if(auth()->user()->hasFeature('love_story') || auth()->user()->hasFeature('streaming_video'))
        <div id="tab-8" class="tab-content d-none">
            <div class="mb-3">
                <div class="card-header bg-transparent border-0 p-3 mb-3">
                    <h6 class="fw-bold mb-0">Video & Kisah Cinta</h6>
                </div>
                <div class="card-body p-0">
                    <div class="mb-3">
                        <label class="form-label fw-semibold mb-2">Link YouTube Video</label>
                        <input type="text" name="video_link" value="{{ $inv?->video_link ?? '' }}"
                            placeholder="https://youtube.com/..." class="form-control" {{ auth()->user()->hasFeature('streaming_video') ? '' : 'disabled' }}>
                        @if(!auth()->user()->hasFeature('streaming_video'))
                            <small class="text-muted">Fitur Link Video tersedia untuk paket berbayar.</small>
                        @else
                            <small class="text-muted">Link video YouTube untuk ditampilkan di undangan (opsional).</small>
                        @endif
                    </div>
                    <hr class="my-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold mb-2">Kutipan Pernikahan</label>
                        <select name="quote_id" class="form-select mb-2" onchange="showQuote()">
                            <option value="">-- Pilih Kutipan --</option>
                            <option value="rum21" {{ ($inv && $inv->quote_id == 'rum21') ? 'selected' : '' }}>QS. Ar-Rum : 21
                            </option>
                            <option value="nisa1" {{ ($inv && $inv->quote_id == 'nisa1') ? 'selected' : '' }}>QS. An-Nisa : 1
                            </option>
                            <option value="furqan74" {{ ($inv && $inv->quote_id == 'furqan74') ? 'selected' : '' }}>QS. Al-Furqan
                                : 74</option>
                        </select>
                        <small class="text-muted">Pilih ayat Al-Qur'an yang akan ditampilkan sebagai kutipan.</small>
                        <textarea name="wedding_quote" id="wedding_quote" rows="3"
                            class="form-control mt-3">{{ $inv?->wedding_quote ?? '' }}</textarea>
                    </div>
                    <hr class="my-4">
                    @if(auth()->user()->hasFeature('love_story'))
                        <div id="loveStoryWrapper">
                            <label class="form-label fw-semibold mb-2">Kisah Cinta</label>
                            <small class="text-muted d-block mb-3">Ceritakan perjalanan cinta kalian agar tamu merasa lebih
                                dekat.</small>
                            @forelse($inv?->love_story ?? [] as $index => $story)
                                <div class="love-story-item border rounded p-3 mb-3 bg-light">
                                    <input type="text" name="story_title[]" value="{{ $story['title'] ?? '' }}"
                                        class="form-control mb-2" placeholder="Judul kisah">
                                    <textarea name="love_story[]" rows="2"
                                        class="form-control mb-2">{{ $story['story'] ?? '' }}</textarea>
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold mb-1" style="font-size: 12px;">Foto Kisah</label>
                                        @if(!empty($story['photo']))
                                            <div class="position-relative d-inline-block">
                                                <img src="{{ asset('storage/' . $story['photo']) }}" class="img-fluid rounded border"
                                                    style="max-height: 120px; object-fit: cover;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                    style="width:20px;height:20px;line-height:1;padding:0;"
                                                    onclick="this.closest('.position-relative').remove(); this.closest('.love-story-item').querySelector('input[name=\'story_photo[]\']').value = '';">&times;</button>
                                            </div>
                                        @endif
                                        <input type="file" name="story_photo[]" accept="image/*"
                                            class="form-control form-control-sm mt-1">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-link text-danger p-0"
                                        onclick="this.closest('.love-story-item').remove()">Hapus</button>
                                </div>
                            @empty
                                <p class="text-muted">Belum ada kisah cinta.</p>
                            @endforelse
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="addLoveStory()">+ Tambah
                            Kisah</button>
                    @else
                        <div class="border border-dashed p-5 text-center rounded bg-light">
                            <i class="bi bi-lock fs-3 text-muted"></i>
                            <p class="mb-0 mt-2 text-muted">Fitur Kisah Cinta tersedia untuk paket berbayar.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endauth

{{-- 9. HADIAH --}}
@auth
    @if(auth()->user()->hasFeature('virtual_gift'))
        <div id="tab-9" class="tab-content d-none">
            <div class="mb-3">
                <div class="card-header bg-transparent border-0 p-3 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="enableGift" name="enable_gift" value="1" {{ ($inv && $inv->enable_gift) ? 'checked' : '' }} onchange="toggleSettings('giftTab', this.checked)" {{ auth()->user()->hasFeature('virtual_gift') ? '' : 'disabled' }}>
                        <label class="form-check-label fw-bold" for="enableGift">Aktifkan Hadiah Digital</label>
                        @if(!auth()->user()->hasFeature('virtual_gift'))
                            <span class="premium-badge ms-2"><i class="bi bi-gem me-1"></i>PREMIUM</span>
                        @endif
                    </div>
                </div>
                @if(auth()->user()->hasFeature('virtual_gift'))
                    <div class="card-body p-0 {{ ($inv && $inv->enable_gift) ? '' : 'd-none' }}" id="giftTab">
                        <div id="giftContainer">
                            @if($inv && $inv->gifts)
                                @foreach($inv->gifts as $g)
                                    <div class="gift-item border rounded p-3 mb-3 position-relative shadow-sm">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 m-2"
                                            onclick="this.closest('.gift-item').remove(); updateLivePreview();"></button>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="fw-bold text-muted mb-1">Bank / E-Wallet</label>
                                                <select name="bank[]" class="form-select">
                                                    <option value="BCA" {{ $g->bank == 'BCA' ? 'selected' : '' }}>BCA</option>
                                                    <option value="BNI" {{ $g->bank == 'BNI' ? 'selected' : '' }}>BNI</option>
                                                    <option value="BRI" {{ $g->bank == 'BRI' ? 'selected' : '' }}>BRI</option>
                                                    <option value="Mandiri" {{ $g->bank == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                    <option value="Dana" {{ $g->bank == 'Dana' ? 'selected' : '' }}>DANA</option>
                                                    <option value="OVO" {{ $g->bank == 'OVO' ? 'selected' : '' }}>OVO</option>
                                                    <option value="Gopay" {{ $g->bank == 'Gopay' ? 'selected' : '' }}>Gopay</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="fw-bold text-muted mb-1">No. Rekening / HP</label>
                                                <input type="text" name="number[]" value="{{ $g->number ?? '' }}"
                                                    placeholder="Contoh: 12345678" class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label class="fw-bold text-muted mb-1">Atas Nama</label>
                                                <input type="text" name="name[]" value="{{ $g->name ?? '' }}"
                                                    placeholder="Nama pemilik rekening" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="addGift" class="btn btn-sm btn-outline-secondary mt-2">+ Tambah Rekening</button>
                        <small class="text-muted d-block mt-2">Tambahkan rekening atau e-wallet untuk hadiah digital.</small>
                    </div>
                @else
                    <div class="card-body p-0 bg-light border border-dashed rounded text-center p-5">
                        <i class="bi bi-lock fs-3 text-muted"></i>
                        <p class="mb-0 mt-2 text-muted">Fitur Hadiah Digital tersedia untuk paket berbayar.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endauth
@push('scripts')
    <script>
        (function initPartnerTab() {
            // DOMContentLoaded may have already fired when @stack('scripts') renders,
            // so we attach directly — DOM elements are already in the page.
            const inviteForm = document.getElementById('invitePartnerForm');
            const inviteBtn = document.getElementById('invitePartnerBtn');
            const partnerMessage = document.getElementById('partnerFormMessage');

            if (inviteForm && inviteBtn) {
                inviteBtn.addEventListener('click', function () {
                    const emailInput = document.getElementById('partner_email');
                    const canEditInput = document.querySelector('input[name="can_edit"]:checked');
                    const email = emailInput ? emailInput.value.trim() : '';
                    const canEdit = canEditInput ? canEditInput.value : '1';
                    const submitBtn = this;

                    if (!email) {
                        if (partnerMessage) partnerMessage.innerHTML = '<div class="alert alert-danger">Email pasangan wajib diisi.</div>';
                        return;
                    }

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengirim...';

                    fetch("{{ $inv ? route('invitation.invite-partner', $inv) : '' }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ email: email, can_edit: canEdit })
                    })
                        .then(res => res.json().then(data => ({ status: res.status, body: data })))
                        .then(({ status, body }) => {
                            if (status >= 200 && status < 300 && body.success) {
                                if (partnerMessage) partnerMessage.innerHTML = '<div class="alert alert-success">' + body.message + '</div>';
                                inviteForm.reset();
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                if (partnerMessage) partnerMessage.innerHTML = '<div class="alert alert-danger">' + (body.message || 'Gagal mengirim undangan.') + '</div>';
                            }
                        })
                        .catch(err => {
                            console.error('Partner invite error:', err);
                            if (partnerMessage) partnerMessage.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan. Coba lagi.</div>';
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-send me-1"></i> Kirim Undangan';
                        });
                });
            }

            const removeBtn = document.getElementById('removePartnerBtn');
            const removeForm = document.getElementById('removePartnerForm');
            if (removeBtn && removeForm) {
                removeBtn.addEventListener('click', function () {
                    if (!confirm('Hapus pasangan dari undangan ini?')) return;

                    const submitBtn = this;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghapus...';

                    fetch(removeForm.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: new URLSearchParams(new FormData(removeForm))
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert(data.message || 'Gagal menghapus pasangan.');
                            }
                        })
                        .catch(err => {
                            alert('Terjadi kesalahan. Coba lagi.');
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bi bi-person-x me-1"></i> Hapus Pasangan';
                        });
                });
            }

            // Country Code Dropdown Logic
            const country = document.getElementById('countryCode');
            const phone = document.getElementById('phoneNumber');
            const full = document.getElementById('fullPhone');
            const flagEl = document.getElementById('selectedFlagCountry');
            const codeEl = document.getElementById('selectedCodeCountry');
            const dropdownBtn = document.getElementById('countryDropdownBtn');

            if (country && phone && full) {
                let selectedCountryCode = '+62';

                if (full.value) {
                    const match = full.value.match(/^(\+\d+)(.*)$/);
                    if (match) {
                        selectedCountryCode = match[1];
                        country.value = match[1];
                        phone.value = match[2].trim();
                    } else {
                        phone.value = full.value.replace('+', '');
                    }
                }

                function syncDisplay(code) {
                    const opt = document.querySelector('.country-option[data-code="' + code + '"]');
                    if (opt) {
                        flagEl.textContent = opt.getAttribute('data-flag');
                        codeEl.textContent = code;
                        country.value = code;
                    }
                }

                document.querySelectorAll('.country-option').forEach(function (opt) {
                    opt.addEventListener('click', function (e) {
                        e.preventDefault();
                        selectedCountryCode = this.getAttribute('data-code');
                        syncDisplay(selectedCountryCode);
                        updateValue();
                        var dd = bootstrap.Dropdown.getInstance(dropdownBtn);
                        if (dd) dd.hide();
                        if (typeof updateLivePreview === 'function') updateLivePreview();
                    });
                });

                function updateValue() {
                    let number = phone.value.replace(/\D/g, '');
                    number = number.replace(/^0+/, '');
                    phone.value = number;
                    full.value = selectedCountryCode + number;
                }

                phone.addEventListener('input', updateValue);
                syncDisplay(selectedCountryCode);
                updateValue();
            }

            // Sampai Selesai Logic
            document.querySelectorAll('.sampai-selesai').forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    const container = this.closest('.col-6');
                    const endTime = container.querySelector('.time-end');
                    if (!endTime) return;
                    if (this.checked) {
                        endTime.value = '';
                        endTime.disabled = true;
                    } else {
                        endTime.disabled = false;
                    }
                    if (typeof updateLivePreview === 'function') updateLivePreview();
                });
            });

            // Initialize Maps if values exist
            if (document.getElementById('akad_maps') && document.getElementById('akad_maps').value) {
                updateMapEmbed('akad_maps', 'akad_map_embed');
            }
            if (document.getElementById('resepsi_maps') && document.getElementById('resepsi_maps').value) {
                updateMapEmbed('resepsi_maps', 'resepsi_map_embed');
            }

            // Child Order Logic
            initChildOrder('groom');
            initChildOrder('bride');
        })();

        function switchMusicSource(source) {
            document.querySelectorAll('.music-source-div').forEach(div => div.classList.add('d-none'));
            const activeDiv = document.getElementById('source-' + source);
            if (activeDiv) activeDiv.classList.remove('d-none');

            const audioPlayer = document.getElementById('audioPlayer');
            if (audioPlayer) {
                audioPlayer.pause();
                audioPlayer.currentTime = 0;
            }
            if (typeof updateLivePreview === 'function') {
                updateLivePreview();
            }
        }

        function updateMapEmbed(inputId, embedId) {
            const input = document.getElementById(inputId);
            const embed = document.getElementById(embedId);
            if (!input || !embed) return;

            const url = input.value.trim();
            if (!url) {
                embed.style.height = '0';
                embed.innerHTML = '';
                return;
            }

            let embedUrl = url;
            if (url.includes('google.com/maps') && !url.includes('/embed')) {
                if (url.includes('/maps/place/')) {
                    const placeMatch = url.match(/\/place\/([^\/\?]+)/);
                    if (placeMatch) {
                        const placeName = decodeURIComponent(placeMatch[1]);
                        embedUrl = 'https://maps.google.com/maps?q=' + encodeURIComponent(placeName) + '&output=embed';
                    }
                } else if (url.includes('/maps/')) {
                    embedUrl = url.replace('/maps/', '/maps/embed?');
                }
            }

            embed.innerHTML = '<iframe src="' + embedUrl + '" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>';
            embed.style.height = '200px';
        }

        function initChildOrder(type) {
            const select = document.getElementById(type + '_child_order_select');
            const numberInput = document.getElementById(type + '_child_order_number');
            const hiddenInput = document.getElementById(type + '_child_order');
            if (!select || !numberInput || !hiddenInput) return;

            const val = hiddenInput.value.trim();
            if (!val) return;

            const match = val.match(/^Anak\s+ke-(\d+)$/);
            if (match) {
                const num = parseInt(match[1]);
                if (num >= 6) {
                    select.style.display = 'none';
                    numberInput.style.display = 'block';
                    numberInput.value = num;
                } else {
                    select.value = val;
                }
            } else {
                select.value = val;
            }
        }

        function handleChildOrderChange(type, value) {
            const select = document.getElementById(type + '_child_order_select');
            const numberInput = document.getElementById(type + '_child_order_number');
            const hiddenInput = document.getElementById(type + '_child_order');
            if (!select || !numberInput || !hiddenInput) return;

            if (value === '__other__') {
                select.style.display = 'none';
                numberInput.style.display = 'block';
                numberInput.value = '';
                hiddenInput.value = '';
                numberInput.focus();
            } else {
                select.style.display = 'block';
                numberInput.style.display = 'none';
                hiddenInput.value = value;
                if (typeof updateLivePreview === 'function') updateLivePreview();
            }
        }

        function formatChildOrderNumber(type, value) {
            const numberInput = document.getElementById(type + '_child_order_number');
            const hiddenInput = document.getElementById(type + '_child_order');
            if (!numberInput || !hiddenInput) return;

            const num = parseInt(value);
            if (!isNaN(num) && num >= 6) {
                hiddenInput.value = 'Anak ke-' + num;
            } else {
                hiddenInput.value = '';
            }
            if (typeof updateLivePreview === 'function') updateLivePreview();
        }
    </script>
@endpush
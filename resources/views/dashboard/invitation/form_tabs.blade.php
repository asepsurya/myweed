@php
    $inv = $invitation ?? null;
@endphp

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
                        value="{{ old('groom_name', $inv->groom_name ?? '') }}" placeholder="Contoh: Ahmad Fauzan"
                        class="form-control">
                    <small class="text-muted">Nama lengkap sesuai KTP.</small>
                </div>
                <div class="col-12">
                    <label for="groom_nickname" class="form-label fw-semibold mb-2">Nama Panggilan</label>
                    <input type="text" id="groom_nickname" name="groom_nickname"
                        value="{{ old('groom_nickname', $inv->groom_nickname ?? '') }}" placeholder="Contoh: Fauzan"
                        class="form-control">
                    <small class="text-muted">Nama panggilan yang akan ditampilkan di undangan.</small>
                </div>
                <div class="col-md-6">
                    <label for="groom_father_name" class="form-label fw-semibold mb-2">Nama Ayah</label>
                    <input type="text" id="groom_father_name" name="groom_father_name"
                        value="{{ old('groom_father_name', $inv->groom_father_name ?? '') }}"
                        placeholder="Contoh: Ahmad Fauzan" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="groom_mother_name" class="form-label fw-semibold mb-2">Nama Ibu</label>
                    <input type="text" id="groom_mother_name" name="groom_mother_name"
                        value="{{ old('groom_mother_name', $inv->groom_mother_name ?? '') }}"
                        placeholder="Contoh: Siti Rahayu" class="form-control">
                </div>
                <div class="col-12">
                    <label for="groom_username_instagram" class="form-label fw-semibold mb-2">Instagram Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">@</span>
                        <input type="text" id="groom_username_instagram" name="groom_username_instagram"
                            value="{{ old('groom_username_instagram', $inv->groom_username_instagram ?? '') }}"
                            class="form-control insta-username" placeholder="fauzan_akbar">
                    </div>
                    <small class="text-muted">Username Instagram tanpa tanda @.</small>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold mb-2">Foto Mempelai Pria</label>
                    <div class="upload-zone border rounded p-4 text-center bg-light {{ ($inv && $inv->foto_pria) ? 'd-none' : '' }}"
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
    <div class="mb-3">
        <div class="card-header bg-transparent border-0  p-3 d-flex align-items-center justify-content-between mb-3">
            <h6 class="mb-0 fw-bold">Pilih Template</h6>
            <input type="text" id="searchTemplate" class="form-control w-50" placeholder="Cari template...">
        </div>
        <div class="card-body p-0">
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Kategori</label>
                <select id="categorySelect" class="form-select">
                    <option value="all">Semua Kategori</option>
                    @php $categories = $templates->pluck('category')->unique()->filter(); @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-3" id="templateGallery">
                @foreach ($templates as $template)
                    @php
                        $isSubscribed = auth()->user()->isSubscribed();
                        $isLocked = $template->is_premium && !$isSubscribed;
                    @endphp
                    <div class="col-6 template-selector-item" data-category="{{ $template->category ?? 'modern' }}"
                        data-name="{{ strtolower($template->name) }}"
                        data-color="{{ $template->primary_color ?? '#0d9488' }}">
                        <div class="card template-card-selector h-100 {{ $isLocked ? 'locked opacity-75' : '' }} {{ ($inv && $inv->template_id == $template->id) ? 'selected' : '' }}"
                            onclick="{{ $isLocked ? 'showPremiumAlert()' : 'selectTemplate(this, ' . $template->id . ')' }}">

                            <!-- Badge Premium/Basic -->
                            <div class="position-absolute top-0 end-0 m-1 z-1">
                                @if ($template->is_premium)
                                    <span class="premium-badge shadow-sm">
                                        <i class="bi bi-gem me-1"></i>PREMIUM
                                    </span>
                                @else
                                    <span class="basic-badge shadow-sm">
                                        BASIC
                                    </span>
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

            <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="prevPage"><i
                        class="bi bi-chevron-left"></i></button>
                <span class="text-muted" id="pageInfo">Halaman 1</span>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="nextPage"><i
                        class="bi bi-chevron-right"></i></button>
            </div>

            <hr class="my-4">
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">Background Header (Sampul)</label>
                <div class="upload-zone border rounded p-4 text-center bg-light {{ ($inv && $inv->gallery_cover) ? 'd-none' : '' }}"
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
                        value="{{ $inv->primary_color ?? '#0d9488' }}" style="width: 60px; height: 40px;">
                    <span class="text-muted">Warna untuk teks, tombol, dan aksen pada undangan.</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. GALERI FOTO --}}
<div id="tab-3" class="tab-content d-none">
    <div class="mb-3">
        <div
            class="card-header bg-transparent border-0 p-0 pb-3 d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Galeri Foto</h6>
            @if(!auth()->user()->isSubscribed())
                <span class="premium-badge">
                    <i class="bi bi-gem me-1"></i>PREMIUM
                </span>
            @endif
        </div>
        <div class="card-body p-0">
            <div id="gallery-dropzone" class="border border-dashed p-5 text-center rounded cursor-pointer bg-light">
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
<style>
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

    /* === Music List Items (Enhanced) === */
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

    /* === Custom Audio Player Wrapper === */
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

    .country-dropdown-btn .flag-emoji {
        font-size: 1.1rem;
    }

    .country-dropdown-menu .flag-emoji {
        font-size: 1.1rem;
    }

    .country-dropdown-menu .country-option:hover {
        background-color: var(--bs-primary-bg-subtle);
    }
</style>
{{-- 4. MUSIK --}}
<div id="tab-4" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-0 p-3 mb-3">
            <h6 class="fw-bold mb-0">Lagu Latar</h6>
        </div>
        <div class="card-body p-0">

            @php $musicSource = $inv->music_source ?? 'library'; @endphp
            <input type="hidden" id="music_id" name="music_id" value="{{ $inv->music ?? '' }}">

            {{-- Pilihan Sumber Musik (Segmented Control) --}}
            <div class="music-source-tabs">
                <input type="radio" class="btn-check" name="music_source" id="srcLibrary" value="library" {{ $musicSource == 'library' ? 'checked' : '' }} onchange="switchMusicSource('library')">
                <label for="srcLibrary"><i class="bi bi-music-note-list"></i> Library</label>

                <input type="radio" class="btn-check" name="music_source" id="srcYoutube" value="youtube" {{ $musicSource == 'youtube' ? 'checked' : '' }} onchange="switchMusicSource('youtube')">
                <label for="srcYoutube"><i class="bi bi-youtube"></i> YouTube</label>

                <input type="radio" class="btn-check" name="music_source" id="srcUpload" value="upload" {{ $musicSource == 'upload' ? 'checked' : '' }} onchange="switchMusicSource('upload')">
                <label for="srcUpload"><i class="bi bi-cloud-upload"></i> Upload</label>
            </div>

            <div class="music-content-box">
                {{-- Konten: Library --}}
                <div id="source-library" class="music-source-div {{ $musicSource != 'library' ? 'd-none' : '' }}">
                    <label class="form-label fw-semibold mb-2">Pilih Lagu dari Library</label>
                    <div id="musicListContainer" class="d-flex flex-column gap-2"
                        style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                        @foreach ($music as $m)
                            <div class="music-list-item {{ ($inv && $inv->music == $m->id) ? 'selected' : '' }}"
                                data-id="{{ $m->id }}" data-url="{{ asset('storage/' . $m->audio_url) }}"
                                onclick="handleMusicClick(this)">
                                <div class="music-icon-box">
                                    <i class="bi bi-music-note-beamed"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="mb-0 fw-bold music-title-clamp">{{ $m->title }}</p>
                                    <p class="mb-0 text-muted" style="font-size: 11px;">{{ $m->category ?? 'Romantis' }}</p>
                                </div>
                                <div class="music-play-btn"
                                    onclick="event.stopPropagation(); previewAudio('{{ asset('storage/' . $m->audio_url) }}')">
                                    <i class="bi bi-play-circle-fill fs-4"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Konten: YouTube --}}
                <div id="source-youtube" class="music-source-div {{ $musicSource != 'youtube' ? 'd-none' : '' }}">
                    <label class="form-label fw-semibold mb-2">Link YouTube (Musik)</label>
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-danger text-white border-0"><i
                                class="bi bi-youtube"></i></span>
                        <input type="text" name="music_youtube_url" class="form-control"
                            placeholder="https://www.youtube.com/watch?v=..." value="{{ $inv->music_youtube_url ?? '' }}"
                            oninput="updateLivePreview()">
                    </div>
                    <small class="text-muted d-block">Masukkan link YouTube untuk musik latar undangan.</small>
                </div>

                {{-- Konten: Upload --}}
                <div id="source-upload" class="music-source-div {{ $musicSource != 'upload' ? 'd-none' : '' }}">
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
                </div>
            </div>

            {{-- Audio Player Wrapper --}}
            <div class="audio-player-wrapper">
                <i class="bi bi-headphones fs-4 text-muted"></i>
                <audio id="audioPlayer" controls></audio>
            </div>

        </div>
    </div>
</div>
{{-- 5. RSVP --}}
<div id="tab-5" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-0 p-3 mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enable_rsvp" name="enable_rsvp" value="1" {{ ($inv && $inv->enable_rsvp) ? 'checked' : '' }} onchange="toggleSettings('rsvp_settings', this.checked)">
                <label class="form-check-label fw-bold" for="enable_rsvp">Aktifkan RSVP</label>
            </div>
        </div>
        <div class="card-body p-0" id="rsvp_settings" style="{{ ($inv && $inv->enable_rsvp) ? '' : 'display:none' }}">
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Batas Tanggal RSVP</label>
                <input type="date" name="rsvp_deadline" value="{{ $inv->rsvp_deadline ?? '' }}" class="form-control">
                <small class="text-muted">Tanggal batas akhir tamu mengirimkan konfirmasi kehadiran.</small>
            </div>
           <div class="mb-3">
                <label class="form-label fw-semibold mb-2">
                    Nomor WhatsApp Notifikasi
                </label>

                <div class="input-group">
                    <!-- Hidden native select (for value reference) -->
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

                    <!-- Custom country code dropdown with flag icons -->
                    <button type="button"
                        class="btn btn-outline-secondary dropdown-toggle country-dropdown-btn flex-shrink-0"
                        id="countryDropdownBtn"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <span id="selectedFlagCountry" class="flag-emoji">🇮🇩</span>
                        <span class="ms-1" id="selectedCodeCountry">+62</span>
                    </button>
                    <ul class="dropdown-menu country-dropdown-menu"
                        aria-labelledby="countryDropdownBtn">
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+62" data-flag="🇮🇩"><span class="flag-emoji">🇮🇩</span> <span class="fw-medium">+62</span> <span class="text-muted ms-2">Indonesia</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+60" data-flag="🇲🇾"><span class="flag-emoji">🇲🇾</span> <span class="fw-medium">+60</span> <span class="text-muted ms-2">Malaysia</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+65" data-flag="🇸🇬"><span class="flag-emoji">🇸🇬</span> <span class="fw-medium">+65</span> <span class="text-muted ms-2">Singapura</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+66" data-flag="🇹🇭"><span class="flag-emoji">🇹🇭</span> <span class="fw-medium">+66</span> <span class="text-muted ms-2">Thailand</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+1" data-flag="🇺🇸"><span class="flag-emoji">🇺🇸</span> <span class="fw-medium">+1</span> <span class="text-muted ms-2">USA/Canada</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+81" data-flag="🇯🇵"><span class="flag-emoji">🇯🇵</span> <span class="fw-medium">+81</span> <span class="text-muted ms-2">Jepang</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+82" data-flag="🇰🇷"><span class="flag-emoji">🇰🇷</span> <span class="fw-medium">+82</span> <span class="text-muted ms-2">Korea</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+44" data-flag="🇬🇧"><span class="flag-emoji">🇬🇧</span> <span class="fw-medium">+44</span> <span class="text-muted ms-2">Inggris</span></a></li>
                        <li><a class="dropdown-item country-option d-flex align-items-center gap-2" href="#" data-code="+91" data-flag="🇮🇳"><span class="flag-emoji">🇮🇳</span> <span class="fw-medium">+91</span> <span class="text-muted ms-2">India</span></a></li>
                    </ul>

                    <input
                        type="tel"
                        id="phoneNumber"
                        class="form-control"
                        placeholder="81234567890"
                        autocomplete="off">
                </div>

                {{-- Yang akan disimpan --}}
                <input
                    type="hidden"
                    name="rsvp_whatsapp"
                    id="fullPhone"
                    value="{{ $inv->rsvp_whatsapp ?? '' }}">

                <small class="text-muted">
                    Nomor HP untuk menerima notifikasi RSVP dari tamu.
                </small>
            </div>
            <script>
document.addEventListener('DOMContentLoaded', function () {
    const country = document.getElementById('countryCode');
    const phone = document.getElementById('phoneNumber');
    const full = document.getElementById('fullPhone');
    const flagEl = document.getElementById('selectedFlagCountry');
    const codeEl = document.getElementById('selectedCodeCountry');
    const dropdownBtn = document.getElementById('countryDropdownBtn');

    let selectedCountryCode = '+62';

    // Isi data lama
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

    // Sync tampilan dengan nilai terpilih
    function syncDisplay(code) {
        const opt = document.querySelector('.country-option[data-code="' + code + '"]');
        if (opt) {
            flagEl.textContent = opt.getAttribute('data-flag');
            codeEl.textContent = code;
            country.value = code;
        }
    }

    // Klik pada opsi negara
    document.querySelectorAll('.country-option').forEach(function(opt) {
        opt.addEventListener('click', function(e) {
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

        // Hilangkan angka 0 depan
        number = number.replace(/^0+/, '');

        phone.value = number;
        full.value = selectedCountryCode + number;
    }

    phone.addEventListener('input', updateValue);

    syncDisplay(selectedCountryCode);
    updateValue();
});
</script>
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Pesan Konfirmasi</label>
                <textarea name="rsvp_message" rows="3" class="form-control">{{ $inv->rsvp_message ?? '' }}</textarea>
                <small class="text-muted">Pesan yang akan ditampilkan di halaman RSVP.</small>
            </div>
        </div>
    </div>
</div>

{{-- 6. TEMPAT & TANGGAL --}}
<div id="tab-6" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0  p-3 mb-3">
            <h6 class="fw-bold mb-0">Jadwal Acara</h6>
        </div>
        <div class="card-body p-0">
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2">Tanggal Pernikahan</label>
                <input type="date" id="wedding_date" name="wedding_date" value="{{ $inv->wedding_date ?? '' }}"
                    class="form-control">
                <small class="text-muted">Tanggal pelaksanaan acara pernikahan.</small>
            </div>

            <hr class="my-4">
            <div class="mb-4">
                <label class="form-label fw-bold text-primary mb-3">Akad Nikah</label>
                <input type="text" name="akad_location" value="{{ $inv->akad_location ?? '' }}"
                    placeholder="Contoh: Gedung Merdeka" class="form-control mb-2">
                <small class="text-muted">Nama tempat pelaksanaan akad nikah.</small>

                <input type="text" name="akad_address" value="{{ $inv->akad_address ?? '' }}"
                    placeholder="Alamat lengkap" class="form-control mt-3 mb-2">

                <div class="row g-2 mt-1">
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Mulai</small>
                        <input type="time" name="akad_time" value="{{ $inv->akad_time ?? '' }}" class="form-control">
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Selesai</small>
                        <input type="time" name="akad_time_end" value="{{ $inv->akad_time_end ?? '' }}"
                            class="form-control">
                    </div>
                </div>

                <input type="text" name="akad_maps" value="{{ $inv->akad_maps ?? '' }}" placeholder="Link Google Maps"
                    class="form-control mt-3">
                <small class="text-muted">Link peta lokasi akad nikah.</small>
            </div>

            <hr class="my-4">
            <div class="mb-3">
                <label class="form-label fw-bold text-primary mb-3">Resepsi</label>
                <input type="text" name="resepsi_location" value="{{ $inv->resepsi_location ?? '' }}"
                    placeholder="Contoh: Hotel Mulia" class="form-control mb-2">
                <small class="text-muted">Nama tempat pelaksanaan resepsi.</small>

                <input type="text" name="resepsi_address" value="{{ $inv->resepsi_address ?? '' }}"
                    placeholder="Alamat lengkap" class="form-control mt-3 mb-2">

                <div class="row g-2 mt-1">
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Mulai</small>
                        <input type="time" name="resepsi_time" value="{{ $inv->resepsi_time ?? '' }}"
                            class="form-control">
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block mb-1">Waktu Selesai</small>
                        <input type="time" name="resepsi_time_end" value="{{ $inv->resepsi_time_end ?? '' }}"
                            class="form-control">
                    </div>
                </div>

                <input type="text" name="resepsi_maps" value="{{ $inv->resepsi_maps ?? '' }}"
                    placeholder="Link Google Maps" class="form-control mt-3">
                <small class="text-muted">Link peta lokasi resepsi.</small>
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
                        value="{{ old('bride_name', $inv->bride_name ?? '') }}" placeholder="Contoh: Siti Rahayu"
                        class="form-control">
                    <small class="text-muted">Nama lengkap sesuai KTP.</small>
                </div>
                <div class="col-12">
                    <label for="bride_nickname" class="form-label fw-semibold mb-2">Nama Panggilan</label>
                    <input type="text" id="bride_nickname" name="bride_nickname"
                        value="{{ old('bride_nickname', $inv->bride_nickname ?? '') }}" placeholder="Contoh: Rahayu"
                        class="form-control">
                    <small class="text-muted">Nama panggilan yang akan ditampilkan di undangan.</small>
                </div>
                <div class="col-md-6">
                    <label for="bride_father_name" class="form-label fw-semibold mb-2">Nama Ayah</label>
                    <input type="text" id="bride_father_name" name="bride_father_name"
                        value="{{ old('bride_father_name', $inv->bride_father_name ?? '') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="bride_mother_name" class="form-label fw-semibold mb-2">Nama Ibu</label>
                    <input type="text" id="bride_mother_name" name="bride_mother_name"
                        value="{{ old('bride_mother_name', $inv->bride_mother_name ?? '') }}" class="form-control">
                </div>
                <div class="col-12">
                    <label for="bride_username_instagram" class="form-label fw-semibold mb-2">Instagram Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">@</span>
                        <input type="text" id="bride_username_instagram" name="bride_username_instagram"
                            value="{{ old('bride_username_instagram', $inv->bride_username_instagram ?? '') }}"
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
<div id="tab-8" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-3 mb-3">
            <h6 class="fw-bold mb-0">Video & Kisah Cinta</h6>
        </div>
        <div class="card-body p-0">
            <div class="mb-3">
                <label class="form-label fw-semibold mb-2">Link YouTube Video</label>
                <input type="text" name="video_link" value="{{ $inv->video_link ?? '' }}"
                    placeholder="https://youtube.com/..." class="form-control">
                <small class="text-muted">Link video YouTube untuk ditampilkan di undangan (opsional).</small>
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
                    class="form-control mt-3">{{ $inv->wedding_quote ?? '' }}</textarea>
            </div>
            <hr class="my-4">
            <div id="loveStoryWrapper">
                <label class="form-label fw-semibold mb-2">Kisah Cinta</label>
                <small class="text-muted d-block mb-3">Ceritakan perjalanan cinta kalian agar tamu merasa lebih
                    dekat.</small>
                @forelse($inv->love_story ?? [] as $index => $story)
                    <div class="love-story-item border rounded p-3 mb-3 bg-light">
                        <input type="text" name="story_title[]" value="{{ $story['title'] ?? '' }}"
                            class="form-control mb-2" placeholder="Judul kisah">
                        <textarea name="love_story[]" rows="2"
                            class="form-control mb-2">{{ $story['story'] ?? '' }}</textarea>
                        <button type="button" class="btn btn-sm btn-link text-danger p-0"
                            onclick="this.closest('.love-story-item').remove()">Hapus</button>
                    </div>
                @empty
                    <p class="text-muted">Belum ada kisah cinta.</p>
                @endforelse
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addLoveStory()">+ Tambah
                Kisah</button>
        </div>
    </div>
</div>

{{-- 9. HADIAH --}}
<div id="tab-9" class="tab-content d-none">
    <div class="mb-3">
        <div class="card-header bg-transparent border-0 p-3 mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enableGift" name="enable_gift" value="1" {{ ($inv && $inv->enable_gift) ? 'checked' : '' }} onchange="toggleSettings('giftTab', this.checked)">
                <label class="form-check-label fw-bold" for="enableGift">Aktifkan Hadiah Digital</label>
            </div>
        </div>
        <div class="card-body p-0 {{ ($inv && $inv->enable_gift) ? '' : 'd-none' }}" id="giftTab">
            <div id="giftContainer">
                @if(isset($inv) && $inv->gifts)
                    @foreach($inv->gifts as $g)
                        <div class="gift-item border rounded p-3 mb-3 bg-light position-relative shadow-sm">
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
    </div>
</div>
<script>
    function switchMusicSource(source) {
        // Sembunyikan semua div
        document.querySelectorAll('.music-source-div').forEach(div => {
            div.classList.add('d-none');
        });

        // Tampilkan div yang dipilih
        const activeDiv = document.getElementById('source-' + source);
        if (activeDiv) {
            activeDiv.classList.remove('d-none');
        }

        // Hentikan audio jika sedang bermain saat ganti tab
        const audioPlayer = document.getElementById('audioPlayer');
        if (audioPlayer) {
            audioPlayer.pause();
            audioPlayer.currentTime = 0;
        }

        // Update live preview
        updateLivePreview();
    }
</script>
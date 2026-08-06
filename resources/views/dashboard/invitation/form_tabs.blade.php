@php
    $inv = $invitation ?? null;
@endphp

{{-- 1. MEMPELAI PRIA --}}
<div id="tab-1" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3 d-flex align-items-center gap-3">
            <div class="islami-icon"><i class="bi bi-person-fill fs-5"></i></div>
            <h6 class="mb-0 fw-bold">Data Mempelai Pria</h6>
        </div>
        <div class="card-body p-0">
            <div class="row g-3">
                <div class="col-12">
                    <label for="groom_name" class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" id="groom_name" name="groom_name" value="{{ old('groom_name', $inv->groom_name ?? '') }}" placeholder="Nama lengkap mempelai pria" class="form-control form-control-sm">
                </div>
                <div class="col-12">
                    <label for="groom_nickname" class="form-label small fw-bold">Nama Panggilan</label>
                    <input type="text" id="groom_nickname" name="groom_nickname" value="{{ old('groom_nickname', $inv->groom_nickname ?? '') }}" placeholder="Nama panggilan" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label for="groom_father_name" class="form-label small fw-bold">Nama Ayah</label>
                    <input type="text" id="groom_father_name" name="groom_father_name" value="{{ old('groom_father_name', $inv->groom_father_name ?? '') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label for="groom_mother_name" class="form-label small fw-bold">Nama Ibu</label>
                    <input type="text" id="groom_mother_name" name="groom_mother_name" value="{{ old('groom_mother_name', $inv->groom_mother_name ?? '') }}" class="form-control form-control-sm">
                </div>
                <div class="col-12">
                    <label for="groom_username_instagram" class="form-label small fw-bold">Instagram Username</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">@</span>
                        <input type="text" id="groom_username_instagram" name="groom_username_instagram" value="{{ old('groom_username_instagram', $inv->groom_username_instagram ?? '') }}" class="form-control insta-username">
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Foto Mempelai Pria</label>
                    <div class="upload-zone border rounded p-3 text-center {{ ($inv && $inv->foto_pria) ? 'd-none' : '' }}" id="uploadBoxGroomContainer">
                        <label for="foto_pria" class="cursor-pointer mb-0">
                            <i class="bi bi-cloud-upload fs-4 text-primary"></i>
                            <p class="x-small text-muted mb-0">Klik untuk upload foto</p>
                            <input id="foto_pria" type="file" name="foto_pria" class="d-none" onchange="openCropModal(event, 'groom')">
                        </label>
                    </div>
                    <div id="previewContainerGroom" class="mt-2 {{ ($inv && $inv->foto_pria) ? '' : 'd-none' }} text-center position-relative">
                        <img id="previewGroom" src="{{ ($inv && $inv->foto_pria) ? asset('storage/' . $inv->foto_pria) : '' }}" class="img-fluid rounded border shadow-sm" style="max-height: 150px; object-fit: cover;">
                        <button type="button" onclick="removePreview('groom')" class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. TEMA & WARNA --}}
<div id="tab-2" class="tab-content active">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3 d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-bold">Pilih Template</h6>
            <input type="text" id="searchTemplate" class="form-control form-control-sm w-50" placeholder="Cari...">
        </div>
        <div class="card-body p-0">
            <div class="mb-3">
                <label class="form-label small fw-bold">Kategori</label>
                <select id="categorySelect" class="form-select form-select-sm">
                    <option value="all">Semua Kategori</option>
                    @php $categories = $templates->pluck('category')->unique()->filter(); @endphp
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-2" id="templateGallery">
                @foreach ($templates as $template)
                    @php
                        $isSubscribed = auth()->user()->isSubscribed();
                        $isLocked = $template->is_premium && !$isSubscribed;
                    @endphp
                    <div class="col-6 template-selector-item" data-category="{{ $template->category ?? 'modern' }}"
                        data-name="{{ strtolower($template->name) }}" data-color="{{ $template->primary_color ?? '#0d9488' }}">
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
                            <div class="card-body p-1 text-center">
                                <span class="x-small fw-bold text-truncate d-block"
                                    style="font-size: 10px;">{{ $template->name }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-between align-items-center mt-3">
                <button type="button" class="btn btn-xs btn-outline-secondary" id="prevPage"><i class="bi bi-chevron-left"></i></button>
                <span class="x-small text-muted" id="pageInfo">Halaman 1</span>
                <button type="button" class="btn btn-xs btn-outline-secondary" id="nextPage"><i class="bi bi-chevron-right"></i></button>
            </div>

            <hr class="my-4">
            <div class="mb-4">
                <label class="form-label small fw-bold">Background Header (Sampul)</label>
                <div class="upload-zone border rounded p-3 text-center {{ ($inv && $inv->gallery_cover) ? 'd-none' : '' }}" id="uploadBoxCoverContainer">
                    <label for="gallery_cover" class="cursor-pointer mb-0">
                        <i class="bi bi-image fs-4 text-primary"></i>
                        <p class="x-small text-muted mb-0">Klik untuk upload Background Header</p>
                        <input id="gallery_cover" type="file" name="gallery_cover" class="d-none" onchange="openCropModal(event, 'cover')">
                    </label>
                </div>
                <div id="previewContainerCover" class="mt-2 {{ ($inv && $inv->gallery_cover) ? '' : 'd-none' }} text-center position-relative">
                    <img id="previewCover" src="{{ ($inv && $inv->gallery_cover) ? asset('storage/' . $inv->gallery_cover) : '' }}" class="img-fluid rounded border shadow-sm w-100" style="max-height: 200px; object-fit: cover;">
                    <button type="button" onclick="removePreview('cover')" class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1"><i class="bi bi-x"></i></button>
                </div>
            </div>

            <div class="mb-3">
                <label for="primary_color" class="form-label small fw-bold">Warna Utama</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" name="primary_color" id="primary_color" class="form-control form-control-color" value="{{ $inv->primary_color ?? '#0d9488' }}">
                    <span class="x-small text-muted">Warna teks & tombol</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. GALERI FOTO --}}
<div id="tab-3" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0">Galeri Foto</h6>
            @if(!auth()->user()->isSubscribed())
                <span class="premium-badge">
                    <i class="bi bi-gem me-1"></i>PREMIUM
                </span>
            @endif
        </div>
        <div class="card-body p-0">
            <div id="gallery-dropzone" class="border border-dashed p-4 text-center rounded cursor-pointer">
                <i class="bi bi-images fs-3 text-muted"></i>
                <p class="x-small mb-0">Klik/Drop foto di sini</p>
                <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="d-none">
            </div>
            <div id="gallery-preview" class="d-flex gap-2 flex-wrap mt-3">
                @if($inv && $inv->galleries)
                    @foreach($inv->galleries as $image)
                        <div class="position-relative border rounded overflow-hidden" style="width: 70px; height: 70px;">
                            <img src="{{ asset('storage/' . $image->image) }}" class="w-100 h-100 object-fit-cover">
                            <button type="button" class="btn btn-danger btn-xs position-absolute top-0 end-0 p-0" style="width:18px;height:18px;" onclick="deleteGallery({{ $image->id }})">×</button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

{{-- 4. MUSIK --}}
<div id="tab-4" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3">
            <h6 class="fw-bold mb-0">Lagu Latar</h6>
        </div>
        <div class="card-body p-0">
            <div class="mb-3">
                <label class="form-label small fw-bold">Pilih Lagu</label>
                <input type="hidden" id="music_id" name="music_id" value="{{ $inv->music ?? '' }}">
                <div id="musicListContainer" class="d-flex flex-column">
                    @foreach ($music as $m)
                        <div class="music-list-item {{ ($inv && $inv->music == $m->id) ? 'selected' : '' }}" 
                             data-id="{{ $m->id }}"
                             data-url="{{ asset('storage/' . $m->audio_url) }}"
                             onclick="handleMusicClick(this)">
                            <div class="music-icon-box">
                                <i class="bi bi-music-note-beamed"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-0 fw-bold x-small music-title-clamp">{{ $m->title }}</p>
                                <p class="mb-0 text-muted" style="font-size: 10px;">{{ $m->category ?? 'Romantis' }}</p>
                            </div>
                            <div class="music-play-btn" onclick="event.stopPropagation(); previewAudio('{{ asset('storage/' . $m->audio_url) }}')">
                                <i class="bi bi-play-circle-fill fs-5"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <audio id="audioPlayer" controls class="w-100 mt-2" style="height: 30px;"></audio>
            <div class="mt-4">
                <label class="form-label small fw-bold">Link YouTube (Musik)</label>
                <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text bg-danger text-white border-0"><i class="bi bi-youtube"></i></span>
                    <input type="text" name="youtube_url" class="form-control" placeholder="https://www.youtube.com/watch?v=..." value="{{ $inv->youtube_url ?? '' }}" oninput="updateLivePreview()">
                </div>
                
                <label class="form-label small fw-bold">Atau Upload Sendiri</label>
                <input type="file" name="custom_music" accept="audio/*" class="form-control form-control-sm">
            </div>
        </div>
    </div>
</div>

{{-- 5. RSVP --}}
<div id="tab-5" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enable_rsvp" name="enable_rsvp" value="1" {{ ($inv && $inv->enable_rsvp) ? 'checked' : '' }} onchange="toggleSettings('rsvp_settings', this.checked)">
                <label class="form-check-label fw-bold" for="enable_rsvp">Aktifkan RSVP</label>
            </div>
        </div>
        <div class="card-body p-0" id="rsvp_settings" style="{{ ($inv && $inv->enable_rsvp) ? '' : 'display:none' }}">
            <div class="mb-3">
                <label class="form-label small fw-bold">Batas Tanggal</label>
                <input type="date" name="rsvp_deadline" value="{{ $inv->rsvp_deadline ?? '' }}" class="form-control form-control-sm">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Nomor WhatsApp Notifikasi</label>
                <input type="text" name="rsvp_whatsapp" value="{{ $inv->rsvp_whatsapp ?? '' }}" placeholder="628..." class="form-control form-control-sm">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold">Pesan Konfirmasi</label>
                <textarea name="rsvp_message" rows="3" class="form-control form-control-sm">{{ $inv->rsvp_message ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- 6. TEMPAT & TANGGAL --}}
<div id="tab-6" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3">
            <h6 class="fw-bold mb-0">Jadwal Acara</h6>
        </div>
        <div class="card-body p-0">
            <div class="mb-3">
                <label class="form-label small fw-bold">Tanggal Pernikahan</label>
                <input type="date" id="wedding_date" name="wedding_date" value="{{ $inv->wedding_date ?? '' }}" class="form-control form-control-sm">
            </div>
            
            <hr>
            <div class="mb-3">
                <label class="form-label small fw-bold text-primary">Akad Nikah</label>
                <input type="text" name="akad_location" value="{{ $inv->akad_location ?? '' }}" placeholder="Lokasi (Gedung/Mesjid)" class="form-control form-control-sm mb-2">
                <input type="text" name="akad_address" value="{{ $inv->akad_address ?? '' }}" placeholder="Alamat lengkap" class="form-control form-control-sm mb-2">
                <div class="row g-2">
                    <div class="col-6"><input type="time" name="akad_time" value="{{ $inv->akad_time ?? '' }}" class="form-control form-control-sm"></div>
                    <div class="col-6"><input type="time" name="akad_time_end" value="{{ $inv->akad_time_end ?? '' }}" class="form-control form-control-sm"></div>
                </div>
                <input type="text" name="akad_maps" value="{{ $inv->akad_maps ?? '' }}" placeholder="Link Google Maps" class="form-control form-control-sm mt-2">
            </div>

            <hr>
            <div class="mb-3">
                <label class="form-label small fw-bold text-primary">Resepsi</label>
                <input type="text" name="resepsi_location" value="{{ $inv->resepsi_location ?? '' }}" placeholder="Lokasi Resepsi" class="form-control form-control-sm mb-2">
                <input type="text" name="resepsi_address" value="{{ $inv->resepsi_address ?? '' }}" placeholder="Alamat Resepsi" class="form-control form-control-sm mb-2">
                <div class="row g-2">
                    <div class="col-6"><input type="time" name="resepsi_time" value="{{ $inv->resepsi_time ?? '' }}" class="form-control form-control-sm"></div>
                    <div class="col-6"><input type="time" name="resepsi_time_end" value="{{ $inv->resepsi_time_end ?? '' }}" class="form-control form-control-sm"></div>
                </div>
                <input type="text" name="resepsi_maps" value="{{ $inv->resepsi_maps ?? '' }}" placeholder="Link Google Maps" class="form-control form-control-sm mt-2">
            </div>
        </div>
    </div>
</div>

{{-- 7. MEMPELAI WANITA --}}
<div id="tab-7" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3 d-flex align-items-center gap-3">
            <div class="islami-icon"><i class="bi bi-person-heart fs-5"></i></div>
            <h6 class="mb-0 fw-bold">Data Mempelai Wanita</h6>
        </div>
        <div class="card-body p-0">
            <div class="row g-3">
                <div class="col-12">
                    <label for="bride_name" class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" id="bride_name" name="bride_name" value="{{ old('bride_name', $inv->bride_name ?? '') }}" placeholder="Nama lengkap mempelai wanita" class="form-control form-control-sm">
                </div>
                <div class="col-12">
                    <label for="bride_nickname" class="form-label small fw-bold">Nama Panggilan</label>
                    <input type="text" id="bride_nickname" name="bride_nickname" value="{{ old('bride_nickname', $inv->bride_nickname ?? '') }}" placeholder="Nama panggilan" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label for="bride_father_name" class="form-label small fw-bold">Nama Ayah</label>
                    <input type="text" id="bride_father_name" name="bride_father_name" value="{{ old('bride_father_name', $inv->bride_father_name ?? '') }}" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <label for="bride_mother_name" class="form-label small fw-bold">Nama Ibu</label>
                    <input type="text" id="bride_mother_name" name="bride_mother_name" value="{{ old('bride_mother_name', $inv->bride_mother_name ?? '') }}" class="form-control form-control-sm">
                </div>
                <div class="col-12">
                    <label for="bride_username_instagram" class="form-label small fw-bold">Instagram Username</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">@</span>
                        <input type="text" id="bride_username_instagram" name="bride_username_instagram" value="{{ old('bride_username_instagram', $inv->bride_username_instagram ?? '') }}" class="form-control insta-username">
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label small fw-bold">Foto Mempelai Wanita</label>
                    <div class="upload-zone border rounded p-3 text-center {{ ($inv && $inv->foto_wanita) ? 'd-none' : '' }}" id="uploadBoxBrideContainer">
                        <label for="foto_wanita" class="cursor-pointer mb-0">
                            <i class="bi bi-cloud-upload fs-4 text-primary"></i>
                            <p class="x-small text-muted mb-0">Klik untuk upload foto</p>
                            <input id="foto_wanita" type="file" name="foto_wanita" class="d-none" onchange="openCropModal(event, 'bride')">
                        </label>
                    </div>
                    <div id="previewContainerBride" class="mt-2 {{ ($inv && $inv->foto_wanita) ? '' : 'd-none' }} text-center position-relative">
                        <img id="previewBride" src="{{ ($inv && $inv->foto_wanita) ? asset('storage/' . $inv->foto_wanita) : '' }}" class="img-fluid rounded border shadow-sm" style="max-height: 150px; object-fit: cover;">
                        <button type="button" onclick="removePreview('bride')" class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1"><i class="bi bi-x"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 8. VIDEO & KISAH --}}
<div id="tab-8" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3">
            <h6 class="fw-bold mb-0">Video & Cerita</h6>
        </div>
        <div class="card-body p-0">
            <div class="mb-3">
                <label class="form-label small fw-bold">Link YouTube Video</label>
                <input type="text" name="video_link" value="{{ $inv->video_link ?? '' }}" placeholder="https://youtube.com/..." class="form-control form-control-sm">
            </div>
            <hr>
            <div class="mb-3">
                <label class="form-label small fw-bold">Kutipan Pernikahan</label>
                <select name="quote_id" class="form-select form-select-sm mb-2" onchange="showQuote()">
                    <option value="">-- Pilih Kutipan --</option>
                    <option value="rum21" {{ ($inv && $inv->quote_id == 'rum21') ? 'selected' : '' }}>QS. Ar-Rum : 21</option>
                    <option value="nisa1" {{ ($inv && $inv->quote_id == 'nisa1') ? 'selected' : '' }}>QS. An-Nisa : 1</option>
                    <option value="furqan74" {{ ($inv && $inv->quote_id == 'furqan74') ? 'selected' : '' }}>QS. Al-Furqan : 74</option>
                </select>
                <textarea name="wedding_quote" id="wedding_quote" rows="2" class="form-control form-control-sm x-small">{{ $inv->wedding_quote ?? '' }}</textarea>
            </div>
            <hr>
            <div id="loveStoryWrapper">
                <label class="form-label small fw-bold">Kisah Cinta</label>
                @forelse($inv->love_story ?? [] as $index => $story)
                    <div class="love-story-item border rounded p-2 mb-2 bg-light">
                        <input type="text" name="story_title[]" value="{{ $story['title'] ?? '' }}" class="form-control form-control-sm mb-1" placeholder="Judul">
                        <textarea name="love_story[]" rows="2" class="form-control form-control-sm x-small mb-1">{{ $story['story'] ?? '' }}</textarea>
                        <button type="button" class="btn btn-link text-danger btn-xs p-0" onclick="this.closest('.love-story-item').remove()">Hapus</button>
                    </div>
                @empty
                    <p class="x-small text-muted">Belum ada kisah cinta.</p>
                @endforelse
            </div>
            <button type="button" class="btn btn-xs btn-outline-primary" onclick="addLoveStory()">+ Tambah Kisah</button>
        </div>
    </div>
</div>

{{-- 9. HADIAH --}}
<div id="tab-9" class="tab-content d-none">
    <div class="card border-0 bg-transparent mb-3">
        <div class="card-header bg-transparent border-0 p-0 pb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enableGift" name="enable_gift" value="1" {{ ($inv && $inv->enable_gift) ? 'checked' : '' }} onchange="toggleSettings('giftTab', this.checked)">
                <label class="form-check-label fw-bold" for="enableGift">Aktifkan Hadiah Digital</label>
            </div>
        </div>
        <div class="card-body p-0 {{ ($inv && $inv->enable_gift) ? '' : 'd-none' }}" id="giftTab">
            <div id="giftContainer">
                @if(isset($inv) && $inv->gifts)
                    @foreach($inv->gifts as $g)
                        <div class="gift-item border rounded p-3 mb-2 bg-light position-relative shadow-sm">
                            <button type="button" class="btn-close x-small position-absolute top-0 end-0 m-2" onclick="this.closest('.gift-item').remove(); updateLivePreview();"></button>
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="x-small fw-bold text-muted mb-1">Bank / E-Wallet</label>
                                    <select name="bank[]" class="form-select form-select-sm">
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
                                    <label class="x-small fw-bold text-muted mb-1">No. Rekening / HP</label>
                                    <input type="text" name="number[]" value="{{ $g->number ?? '' }}" placeholder="Contoh: 12345678" class="form-control form-control-sm">
                                </div>
                                <div class="col-12">
                                    <label class="x-small fw-bold text-muted mb-1">Atas Nama</label>
                                    <input type="text" name="name[]" value="{{ $g->name ?? '' }}" placeholder="Nama pemilik rekening" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" id="addGift" class="btn btn-xs btn-outline-secondary mt-2">+ Tambah Rekening</button>
        </div>
    </div>
</div>

<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="container-fluid mt-4">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="fw-semibold mb-0">
                        {{ __('Edit Undangan') }}
                    </h5>
                </div>

                <div class="col-auto d-flex gap-2 align-items-center">
                    <a href="{{ url($invitation->slug) }}" target="_blank"
                       class="text-primary text-decoration-none">
                        Preview Undangan
                    </a>

                    <a href="{{ route('invitation.create') }}" 
                       class="btn btn-outline-secondary btn-sm">
                        Batal
                    </a>

                    <button type="button" 
                            onclick="document.getElementById('myForm').submit()" 
                            class="btn btn-primary btn-sm">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </x-slot>

    {{-- CONTENT --}}
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Errors -->
                @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="myForm" method="POST" action="{{ route('invitation.update', $invitation) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- MAIN TABS --}}
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <button type="button" class="nav-link active tab-btn" data-tab="1">Data Dasar</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="2">Tema & Warna</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="3">Galeri Foto</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="4">Musik</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="5">RSVP</button>
                        </li>
                    </ul>

                    <div class="row">

                        {{-- SIDEBAR --}}
                        <div class="col-3 border-end p-3 bg-light">
                            <button class="btn btn-light w-100 text-start mb-2 sub-tab-btn active" data-tab="general">
                                Mempelai Pria
                            </button>
                            <button class="btn btn-light w-100 text-start mb-2 sub-tab-btn" data-tab="bride">
                                Mempelai Wanita
                            </button>
                            <button class="btn btn-light w-100 text-start mb-2 sub-tab-btn" data-tab="acara">
                                Tempat & Tanggal
                            </button>
                            <button class="btn btn-light w-100 text-start sub-tab-btn" data-tab="other">
                                Lainnya
                            </button>
                        </div>

                        {{-- CONTENT --}}
                        <div class="col-9">

                            {{-- DATA DASAR --}}
                            <div id="1" class="tab-content active">

                                {{-- DATA MEMPELAI PRIA --}}
                                <div id="general" class="sub-tab-content active">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="groom_name" class="form-label">Nama Mempelai Pria</label>
                                            <input type="text" id="groom_name" name="groom_name"
                                                value="{{ old('groom_name', $invitation->groom_name) }}"
                                                placeholder="Masukkan nama mempelai pria"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="groom_nickname" class="form-label">Nama Panggilan</label>
                                            <input type="text" id="groom_nickname" name="groom_nickname"
                                                value="{{ old('groom_nickname', $invitation->groom_nickname) }}"
                                                placeholder="Masukkan nama panggilan"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="groom_father_name" class="form-label">Nama Ayah Kandung</label>
                                            <input type="text" id="groom_father_name" name="groom_father_name"
                                                value="{{ old('groom_father_name', $invitation->groom_father_name) }}"
                                                placeholder="Masukkan nama lengkap ayah"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="groom_mother_name" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" id="groom_mother_name" name="groom_mother_name"
                                                value="{{ old('groom_mother_name', $invitation->groom_mother_name) }}"
                                                placeholder="Masukkan nama lengkap ibu"
                                                class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Foto Mempelai Pria</label>
                                            @if($invitation->foto_pria)
                                            <!-- Preview & Delete Button -->
                                            <div id="previewContainerGroom" class="mb-3">
                                                <img id="previewGroom" src="{{ asset('storage/' . $invitation->foto_pria) }}" class="img-fluid rounded" alt="Preview Foto">
                                                <div class="text-center mt-2">
                                                    <button type="button" onclick="removeGroomPreview()" class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                            @else
                                            <div class="border border-dashed bg-light p-4 text-center rounded">
                                                <label id="uploadBoxGroom" for="foto_pria" class="cursor-pointer">
                                                    <div class="mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                        </svg>
                                                    </div>
                                                    <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                    <input id="foto_pria" type="file" name="foto_pria" class="d-none" onchange="previewGroomImage(event)">
                                                </label>
                                            </div>
                                            @endif
                                            <input id="foto_pria" type="file" name="foto_pria" class="d-none" onchange="previewGroomImage(event)">
                                        </div>
                                    </div>
                                </div>

                                {{-- DATA MEMPELAI WANITA --}}
                                <div id="bride" class="sub-tab-content d-none">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="bride_name" class="form-label">Nama Mempelai Wanita</label>
                                            <input type="text" id="bride_name" name="bride_name" 
                                                value="{{ old('bride_name', $invitation->bride_name) }}" 
                                                placeholder="Masukkan nama mempelai wanita" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="bride_nickname" class="form-label">Nama Panggilan</label>
                                            <input type="text" id="bride_nickname" name="bride_nickname" 
                                                value="{{ old('bride_nickname', $invitation->bride_nickname) }}" 
                                                placeholder="Masukkan nama panggilan mempelai wanita" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="bride_father_name" class="form-label">Nama Ayah Kandung</label>
                                            <input type="text" id="bride_father_name" name="bride_father_name" 
                                                value="{{ old('bride_father_name', $invitation->bride_father_name) }}" 
                                                placeholder="Masukkan nama lengkap ayah kandung mempelai wanita" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="bride_mother_name" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" id="bride_mother_name" name="bride_mother_name" 
                                                value="{{ old('bride_mother_name', $invitation->bride_mother_name) }}" 
                                                placeholder="Masukkan nama lengkap ibu kandung mempelai wanita" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Foto Mempelai Wanita</label>
                                            @if($invitation->foto_wanita)
                                            <!-- Preview & Delete Button -->
                                            <div id="previewContainerBride" class="mb-3">
                                                <img id="previewBride" src="{{ asset('storage/' . $invitation->foto_wanita) }}" class="img-fluid rounded" alt="Preview Foto">
                                                <div class="text-center mt-2">
                                                    <button type="button" onclick="removeBridePreview()" class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                            @else
                                            <div class="border border-dashed bg-light p-4 text-center rounded">
                                                <label id="uploadBoxBride" for="foto_wanita" class="cursor-pointer">
                                                    <div class="mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                        </svg>
                                                    </div>
                                                    <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                    <input id="foto_wanita" type="file" name="foto_wanita" class="d-none" onchange="previewBrideImage(event)">
                                                </label>
                                            </div>
                                            @endif
                                            <input id="foto_wanita" type="file" name="foto_wanita" class="d-none" onchange="previewBrideImage(event)">
                                        </div>
                                    </div>
                                </div>

                                {{-- TEMPAT & TANGGAL --}}
                                <div id="acara" class="sub-tab-content d-none">
                                    <div class="mb-4">
                                        <h5 class="fw-semibold">Tanggal Pernikahan</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="wedding_date" class="form-label">Tanggal</label>
                                                <input type="date" id="wedding_date" name="wedding_date" 
                                                    value="{{ old('wedding_date', $invitation->wedding_date) }}" 
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h5 class="fw-semibold">Tempat Akad</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="akad_location" class="form-label">Lokasi Acara</label>
                                                <input type="text" id="akad_location" name="akad_location" 
                                                    value="{{ old('akad_location', $invitation->akad_location) }}" 
                                                    placeholder="Masukkan lokasi akad" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="akad_time" class="form-label">Waktu Akad</label>
                                                <input type="time" id="akad_time" name="akad_time" 
                                                    value="{{ old('akad_time', $invitation->akad_time) }}" 
                                                    class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label for="akad_maps" class="form-label">Link Maps</label>
                                                <input type="text" id="akad_maps" name="akad_maps" 
                                                    value="{{ old('akad_maps', $invitation->akad_maps) }}" 
                                                    placeholder="Masukkan link Google Maps" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h5 class="fw-semibold">Tempat Resepsi</h5>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="resepsi_location" class="form-label">Lokasi Acara</label>
                                                <input type="text" id="resepsi_location" name="resepsi_location" 
                                                    value="{{ old('resepsi_location', $invitation->resepsi_location) }}" 
                                                    placeholder="Masukkan lokasi resepsi" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="resepsi_time" class="form-label">Waktu Resepsi</label>
                                                <input type="time" id="resepsi_time" name="resepsi_time" 
                                                    value="{{ old('resepsi_time', $invitation->resepsi_time) }}" 
                                                    class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label for="resepsi_maps" class="form-label">Link Maps</label>
                                                <input type="text" id="resepsi_maps" name="resepsi_maps" 
                                                    value="{{ old('resepsi_maps', $invitation->resepsi_maps) }}" 
                                                    placeholder="Masukkan link Google Maps" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- LAINNYA --}}
                                <div id="other" class="sub-tab-content d-none">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="wedding_quote" class="form-label">Kutipan Pernikahan</label>
                                            <textarea id="wedding_quote" name="wedding_quote" rows="4" 
                                                placeholder="Masukkan kutipan untuk undangan" 
                                                class="form-control">{{ old('wedding_quote', $invitation->wedding_quote) }}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="video_link" class="form-label">Link Video Pernikahan</label>
                                            <input type="text" id="video_link" name="video_link" 
                                                value="{{ old('video_link', $invitation->video_link) }}" 
                                                placeholder="Masukkan link video YouTube" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label for="love_story" class="form-label">Cerita Cinta</label>
                                            <textarea id="love_story" name="love_story" rows="4" 
                                                placeholder="Ceritakan perjalanan cinta kalian" 
                                                class="form-control">{{ old('love_story', $invitation->love_story) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TEMA & WARNA --}}
                            <div id="2" class="tab-content d-none">
                                <div class="mb-4">
                                    <label for="gallery_cover" class="form-label">Cover Galeri</label>
                                    <input type="file" id="gallery_cover" name="gallery_cover" accept="image/*" class="form-control">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Pilih Template</label>
                                        <select name="template_id" id="template_id" class="form-select">
                                            @foreach ($templates as $template)
                                            <option value="{{ $template->id }}" 
                                                {{ $invitation->template_id == $template->id ? 'selected' : '' }} 
                                                data-image="{{ $template->image }}">{{ $template->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Preview</label>
                                        <div class="border rounded overflow-hidden" style="max-width: 200px;">
                                            <img src="{{ asset('tempelate/sample_preview.png') }}" alt="Template Preview" class="img-fluid">
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="form-label">Pilih Warna Tema</label>
                                    <div class="d-flex gap-2">
                                        <!-- Contoh 1 -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="theme_color" id="color1" value="#1a365d" 
                                                {{ $invitation->theme_color == '#1a365d' ? 'checked' : '' }}>
                                            <label class="form-check-label p-2 border rounded" for="color1" style="background-color: #1a365d; width: 40px; height: 40px; display: block;"></label>
                                        </div>

                                        <!-- Contoh 2 -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="theme_color" id="color2" value="#b91c1c" 
                                                {{ $invitation->theme_color == '#b91c1c' ? 'checked' : '' }}>
                                            <label class="form-check-label p-2 border rounded" for="color2" style="background-color: #b91c1c; width: 40px; height: 40px; display: block;"></label>
                                        </div>

                                        <!-- Contoh 3 -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="theme_color" id="color3" value="#166534" 
                                                {{ $invitation->theme_color == '#166534' ? 'checked' : '' }}>
                                            <label class="form-check-label p-2 border rounded" for="color3" style="background-color: #166534; width: 40px; height: 40px; display: block;"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- GALERI FOTO --}}
                            <div id="3" class="tab-content d-none">
                                <label for="gallery_cover" class="form-label">Galeri Kisah</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="gallery-dropzone" class="border border-dashed bg-light p-4 text-center rounded cursor-pointer">
                                            <p class="mb-0">Drag & drop gambar di sini atau klik untuk memilih</p>
                                            <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="d-none">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="gallery-preview" class="d-flex gap-2 flex-wrap">
                                            @if($invitation->galleries)
                                                @foreach(json_decode($invitation->galleries) as $image)
                                                    <div class="position-relative" id="gallery-item-{{ $image->id }}" style="width: 100px; height: 100px;">
                                                        <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded" style="width: 100px; height: 100px; object-fit: cover;">
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0"
                                                                style="width: 24px; height: 24px; padding: 0; border-radius: 50%;"
                                                                onclick="deleteGallery({{ $image->id }})">
                                                            ×
                                                        </button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- MUSIK --}}
                            <div id="4" class="tab-content d-none">
                                <div class="mb-3">
                                    <label for="music_id" class="form-label">Pilih Lagu Background</label>
                                    <select name="music_id" id="music_id" class="form-select">
                                        <option value="">-- Pilih Lagu --</option>
                                        @if(isset($music))
                                        @foreach ($music as $music)
                                        <option value="{{ $music->id }}" {{ $invitation->music == $music->id ? 'selected' : '' }}>{{ $music->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="music_volume" class="form-label">Atur Volume</label>
                                    <input type="range" name="music_volume" min="0" max="100" 
                                        value="{{ old('music_volume', $invitation->music_volume ?? 50) }}" class="form-range">
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">0</small>
                                        <small class="text-muted">50</small>
                                        <small class="text-muted">100</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="custom_music" class="form-label">Upload Lagu Kustom</label>
                                    <input type="file" name="custom_music" accept="audio/*" class="form-control">
                                </div>
                            </div>

                            {{-- RSVP --}}
                            <div id="5" class="tab-content d-none">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="enable_rsvp" name="enable_rsvp" 
                                            {{ $invitation->enable_rsvp ? 'checked' : '' }}>
                                        <label class="form-check-label" for="enable_rsvp">
                                            Aktifkan RSVP
                                        </label>
                                    </div>
                                </div>

                                <div id="rsvp_settings" style="{{ $invitation->enable_rsvp ? '' : 'display:none' }}">
                                    <div class="mb-3">
                                        <label for="rsvp_deadline" class="form-label">Batas Tanggal RSVP</label>
                                        <input type="date" name="rsvp_deadline" 
                                            value="{{ old('rsvp_deadline', $invitation->rsvp_deadline) }}" 
                                            class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="rsvp_message" class="form-label">Pesan Konfirmasi</label>
                                        <textarea name="rsvp_message" rows="4" 
                                            placeholder="Terima kasih atas konfirmasi kehadiran Anda. Kami sangat menantikan kehadiran Anda di hari bahagia kami." 
                                            class="form-control">{{ old('rsvp_message', $invitation->rsvp_message) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="rsvp_whatsapp" class="form-label">Nomor WhatsApp untuk Notifikasi</label>
                                        <input type="text" name="rsvp_whatsapp" 
                                            value="{{ old('rsvp_whatsapp', $invitation->rsvp_whatsapp) }}" 
                                            placeholder="6281234567890" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>


<!-- Main Tabs Script -->
<script>
    // Main tabs functionality
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content[id]');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.add('d-none'));

            tab.classList.add('active');
            const tabId = tab.dataset.tab;
            document.getElementById(tabId).classList.remove('d-none');
        });
    });

    // Sidebar Tabs Script
    const tabButtons = document.querySelectorAll('.sub-tab-btn');
    const tabContents = document.querySelectorAll('.sub-tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            tabButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const target = btn.dataset.tab;
            tabContents.forEach(c => c.classList.add('d-none'));
            document.getElementById(target).classList.remove('d-none');
        });
    });

    // Template preview
    const templateSelect = document.getElementById('template_id');
    const templatePreview = document.getElementById('template_preview');

    if (templateSelect && templatePreview) {
        templateSelect.addEventListener('change', () => {
            const selectedOption = templateSelect.options[templateSelect.selectedIndex];
            templatePreview.src = selectedOption.dataset.image;
        });

        templateSelect.dispatchEvent(new Event('change'));
    }

    // Gallery functionality
    const dropzone = document.getElementById('gallery-dropzone');
    const fileInput = document.getElementById('gallery-input');
    const preview = document.getElementById('gallery-preview');

    if (dropzone && fileInput && preview) {
        dropzone.addEventListener('click', () => fileInput.click());
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('bg-light');
        });
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('bg-light');
        });
        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('bg-light');
            fileInput.files = e.dataTransfer.files;
            displayPreview(fileInput.files);
        });

        fileInput.addEventListener('change', () => displayPreview(fileInput.files));

        function displayPreview(files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const imgContainer = document.createElement('div');
                    imgContainer.className = 'position-relative';
                    imgContainer.style.width = '100px';
                    imgContainer.style.height = '100px';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid rounded';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    imgContainer.appendChild(img);

                    // Add delete button
                    const deleteBtn = document.createElement('button');
                    deleteBtn.type = 'button';
                    deleteBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                    deleteBtn.style.width = '24px';
                    deleteBtn.style.height = '24px';
                    deleteBtn.style.padding = '0';
                    deleteBtn.style.borderRadius = '50%';
                    deleteBtn.innerHTML = '×';
                    deleteBtn.onclick = function() {
                        imgContainer.remove();
                    };
                    imgContainer.appendChild(deleteBtn);

                    preview.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // RSVP settings toggle
    const enableRsvp = document.getElementById('enable_rsvp');
    const rsvpSettings = document.getElementById('rsvp_settings');

    if (enableRsvp && rsvpSettings) {
        // Initially hide settings if checkbox is not checked
        if (!enableRsvp.checked) {
            rsvpSettings.style.display = 'none';
        }

        enableRsvp.addEventListener('change', () => {
            rsvpSettings.style.display = enableRsvp.checked ? 'block' : 'none';
        });
    }

    // Image preview functions for groom
    function previewGroomImage(event) {
        const preview = document.getElementById('previewGroom');
        const previewContainer = document.getElementById('previewContainerGroom');
        const uploadBox = document.getElementById('uploadBoxGroom');

        if (event.target.files && event.target.files[0]) {
            // Create preview container if it doesn't exist
            if (!previewContainer) {
                const newContainer = document.createElement('div');
                newContainer.id = 'previewContainerGroom';
                newContainer.className = 'mb-3';
                
                const newImg = document.createElement('img');
                newImg.id = 'previewGroom';
                newImg.className = 'img-fluid rounded';
                newImg.alt = 'Preview Foto';
                
                const btnContainer = document.createElement('div');
                btnContainer.className = 'text-center mt-2';
                
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'btn btn-danger btn-sm';
                deleteBtn.textContent = 'Hapus';
                deleteBtn.onclick = removeGroomPreview;
                
                btnContainer.appendChild(deleteBtn);
                newContainer.appendChild(newImg);
                newContainer.appendChild(btnContainer);
                
                uploadBox.parentElement.parentElement.appendChild(newContainer);
            }
            
            // Set src preview
            document.getElementById('previewGroom').src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('previewContainerGroom').classList.remove('d-none');

            // Hide upload box
            uploadBox.parentElement.classList.add('d-none');
        }
    }

    function removeGroomPreview() {
        const preview = document.getElementById('previewGroom');
        const previewContainer = document.getElementById('previewContainerGroom');
        const uploadBox = document.getElementById('uploadBoxGroom');
        const inputFile = document.getElementById('foto_pria');

        // Remove preview
        if (previewContainer) {
            previewContainer.remove();
        }

        // Reset input file
        inputFile.value = '';

        // Show upload box again
        uploadBox.parentElement.classList.remove('d-none');
    }

    // Image preview functions for bride
    function previewBrideImage(event) {
        const preview = document.getElementById('previewBride');
        const previewContainer = document.getElementById('previewContainerBride');
        const uploadBox = document.getElementById('uploadBoxBride');

        if (event.target.files && event.target.files[0]) {
            // Create preview container if it doesn't exist
            if (!previewContainer) {
                const newContainer = document.createElement('div');
                newContainer.id = 'previewContainerBride';
                newContainer.className = 'mb-3';
                
                const newImg = document.createElement('img');
                newImg.id = 'previewBride';
                newImg.className = 'img-fluid rounded';
                newImg.alt = 'Preview Foto';
                
                const btnContainer = document.createElement('div');
                btnContainer.className = 'text-center mt-2';
                
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'btn btn-danger btn-sm';
                deleteBtn.textContent = 'Hapus';
                deleteBtn.onclick = removeBridePreview;
                
                btnContainer.appendChild(deleteBtn);
                newContainer.appendChild(newImg);
                newContainer.appendChild(btnContainer);
                
                uploadBox.parentElement.parentElement.appendChild(newContainer);
            }
            
            // Set src preview
            document.getElementById('previewBride').src = URL.createObjectURL(event.target.files[0]);
            document.getElementById('previewContainerBride').classList.remove('d-none');

            // Hide upload box
            uploadBox.parentElement.classList.add('d-none');
        }
    }

    function removeBridePreview() {
        const preview = document.getElementById('previewBride');
        const previewContainer = document.getElementById('previewContainerBride');
        const uploadBox = document.getElementById('uploadBoxBride');
        const inputFile = document.getElementById('foto_wanita');

        // Remove preview
        if (previewContainer) {
            previewContainer.remove();
        }

        // Reset input file
        inputFile.value = '';

        // Show upload box again
        uploadBox.parentElement.classList.remove('d-none');
    }

    function deleteGallery(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus foto ini?',
            text: 'Data akan terhapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/gallery/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Hapus dari tampilan
                        document.getElementById(`gallery-item-${id}`).remove();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Foto berhasil dihapus',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(err => console.error(err));
            }
        });
    }
</script>
</x-app-layout>
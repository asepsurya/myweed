<x-app-layout>
    {{-- HEADER --}}
    <x-slot name="header">
        <div class="container-fluid mt-4">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="fw-semibold mb-0">
                        {{ __('Buat Undangan') }}
                    </h5>
                </div>

                <div class="col-auto d-flex gap-2">
                    <a href="{{ route('invitation.create') }}" class="btn btn-outline-secondary btn-sm">
                        Batal
                    </a>

                    <button type="button" onclick="document.getElementById('myForm').submit()"
                        class="btn btn-primary btn-sm">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </x-slot>
    <style>
        .android-frame {
            width: 200px;
            height: 400px;
            border: 10px solid #111;
            border-radius: 30px;
            background: #000;
            overflow-y: auto;
        }

        /* notch / speaker */
        .android-frame::before {
            content: '';
            position: absolute;
            top: 6px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 6px;
            background: #333;
            border-radius: 10px;
            z-index: 2;
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
        }
    </style>

    {{-- CONTENT --}}
    <div class="container-fluid mt-4 ">
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

                <form id="myForm" method="POST" action="{{ route('invitation.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- MAIN TABS --}}
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <button type="button" class="nav-link active tab-btn" data-tab="1">
                                <i class="bi bi-info-circle me-1"></i> Data Dasar
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="2">
                                <i class="bi bi-palette me-1"></i> Tema & Warna
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="3">
                                <i class="bi bi-images me-1"></i> Galeri Foto
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="4">
                                <i class="bi bi-music-note-beamed me-1"></i> Musik
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link tab-btn" data-tab="5">
                                <i class="bi bi-chat-dots me-1"></i> RSVP
                            </button>
                        </li>
                    </ul>


                    <div class="row">

                        {{-- SIDEBAR --}}
                        <div class="col-3 p-3">
                            <button type="button" class="btn w-100 text-start mb-2 sub-tab-btn active"
                                data-tab="general">
                                <i class="bi bi-person-fill me-2"></i> Mempelai Pria
                            </button>

                            <button type="button" class="btn w-100 text-start mb-2 sub-tab-btn" data-tab="bride">
                                <i class="bi bi-person-heart me-2"></i> Mempelai Wanita
                            </button>

                            <button type="button" class="btn w-100 text-start mb-2 sub-tab-btn" data-tab="acara">
                                <i class="bi bi-geo-alt-fill me-2"></i> Tempat & Tanggal
                            </button>

                            <button type="button" class="btn w-100 text-start sub-tab-btn" data-tab="other">
                                <i class="bi bi-three-dots me-2"></i> Lainnya
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
                                                value="{{ old('groom_name') }}"
                                                placeholder="Masukkan nama mempelai pria" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="groom_nickname" class="form-label">Nama Panggilan</label>
                                            <input type="text" id="groom_nickname" name="groom_nickname"
                                                value="{{ old('groom_nickname') }}"
                                                placeholder="Masukkan nama panggilan" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="groom_father_name" class="form-label">Nama Ayah Kandung</label>
                                            <input type="text" id="groom_father_name" name="groom_father_name"
                                                value="{{ old('groom_father_name') }}"
                                                placeholder="Masukkan nama lengkap ayah" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="groom_mother_name" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" id="groom_mother_name" name="groom_mother_name"
                                                value="{{ old('groom_mother_name') }}"
                                                placeholder="Masukkan nama lengkap ibu" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Foto Mempelai Pria</label>
                                            <div class="border border-dashed p-4 text-center rounded">
                                                <label id="uploadBoxGroom" for="foto_pria" class="cursor-pointer">
                                                    <div class="mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="d-block mx-auto" width="40" height="40"
                                                            fill="currentColor" viewBox="0 0 16 16">
                                                            <path
                                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                            <path
                                                                d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                    <input id="foto_pria" type="file" name="foto_pria"
                                                        class="d-none" onchange="previewGroomImage(event)">
                                                </label>
                                            </div>

                                            <!-- Preview & Delete Button -->
                                            <div id="previewContainerGroom" class="mt-3 d-none">
                                                <img id="previewGroom" class="img-fluid rounded" alt="Preview Foto">
                                                <div class="text-center mt-2">
                                                    <button type="button" onclick="removeGroomPreview()"
                                                        class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- DATA MEMPELAI WANITA --}}
                                <div id="bride" class="sub-tab-content d-none">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="bride_name" class="form-label">Nama Mempelai Wanita</label>
                                            <input type="text" id="bride_name" name="bride_name"
                                                placeholder="Masukkan nama mempelai wanita" class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="bride_nickname" class="form-label">Nama Panggilan</label>
                                            <input type="text" id="bride_nickname" name="bride_nickname"
                                                placeholder="Masukkan nama panggilan mempelai wanita"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="bride_father_name" class="form-label">Nama Ayah
                                                Kandung</label>
                                            <input type="text" id="bride_father_name" name="bride_father_name"
                                                placeholder="Masukkan nama lengkap ayah kandung mempelai wanita"
                                                class="form-control">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="bride_mother_name" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" id="bride_mother_name" name="bride_mother_name"
                                                placeholder="Masukkan nama lengkap ibu kandung mempelai wanita"
                                                class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Foto Mempelai Wanita</label>
                                            <div class="border border-dashed  p-4 text-center rounded">
                                                <label id="uploadBoxBride" for="foto_wanita" class="cursor-pointer">
                                                    <div class="mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="d-block mx-auto" width="40" height="40"
                                                            fill="currentColor" viewBox="0 0 16 16">
                                                            <path
                                                                d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                            <path
                                                                d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                    <input id="foto_wanita" type="file" name="foto_wanita"
                                                        class="d-none" onchange="previewBrideImage(event)">
                                                </label>
                                            </div>

                                            <!-- Preview & Delete Button -->
                                            <div id="previewContainerBride" class="mt-3 d-none">
                                                <img id="previewBride" class="img-fluid rounded" alt="Preview Foto">
                                                <div class="text-center mt-2">
                                                    <button type="button" onclick="removeBridePreview()"
                                                        class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
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
                                                    placeholder="Masukkan lokasi akad" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="akad_time" class="form-label">Waktu Akad</label>
                                                <input type="time" id="akad_time" name="akad_time"
                                                    class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label for="akad_maps" class="form-label">Link Maps</label>
                                                <input type="text" id="akad_maps" name="akad_maps"
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
                                                    placeholder="Masukkan lokasi resepsi" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="resepsi_time" class="form-label">Waktu Resepsi</label>
                                                <input type="time" id="resepsi_time" name="resepsi_time"
                                                    class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label for="resepsi_maps" class="form-label">Link Maps</label>
                                                <input type="text" id="resepsi_maps" name="resepsi_maps"
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
                                            <textarea id="wedding_quote" name="wedding_quote" rows="4" placeholder="Masukkan kutipan untuk undangan"
                                                class="form-control"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="video_link" class="form-label">Link Video Pernikahan</label>
                                            <input type="text" id="video_link" name="video_link"
                                                placeholder="Masukkan link video YouTube" class="form-control">
                                        </div>

                                        <div class="col-12">
                                            <label for="love_story" class="form-label">Cerita Cinta</label>
                                            <textarea id="love_story" name="love_story" rows="4" placeholder="Ceritakan perjalanan cinta kalian"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TEMA & WARNA --}}
                            <div id="2" class="tab-content d-none">
                                <div class="mb-4">
                                    <label for="gallery_cover" class="form-label">Cover Galeri</label>
                                    <input type="file" id="gallery_cover" name="gallery_cover" accept="image/*"
                                        class="form-control">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Pilih Template</label>
                                        <select name="template_id" id="template_id" class="form-select">
                                            @foreach ($templates as $template)
                                                <option value="{{ $template->id }}"
                                                    data-image="{{ $template->image }}">{{ $template->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Preview</label>

                                        <div class="android-frame">
                                            <div class="screen">
                                                <img src="{{ asset('tempelate/sample_preview.png') }}" alt="Preview"
                                                    class="preview-img">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- GALERI FOTO --}}
                            <div id="3" class="tab-content d-none">
                                <label for="gallery_cover" class="form-label">Galeri Kisah</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="gallery-dropzone"
                                            class="border border-dashed  p-4 text-center rounded cursor-pointer">
                                            <p class="mb-0">Drag & drop gambar di sini atau klik untuk memilih</p>
                                            <input type="file" id="gallery-input" name="gallery[]" multiple
                                                accept="image/*" class="d-none">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="gallery-preview" class="d-flex gap-2 flex-wrap"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- MUSIK --}}
                            <div id="4" class="tab-content d-none">
                                <div class="mb-3">
                                    <label for="music_id" class="form-label">Pilih Lagu Background</label>
                                    <select name="music_id" id="music_id" class="form-select">
                                        <option value="">-- Pilih Lagu --</option>
                                        @foreach ($music as $item)
                                            <option value="{{ $item->id }}"
                                                data-audio="{{ asset('/storage/' . $item->audio_url) }}"
                                                {{ isset($invitation) && $invitation->music == $item->id ? 'selected' : '' }}>
                                                {{ $item->title }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <audio id="audioPlayer" controls style="margin-top:10px; width:100%;">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <script>
                                        document.getElementById('music_id').addEventListener('change', function() {
                                            const selectedOption = this.options[this.selectedIndex];
                                            const audioSrc = selectedOption.getAttribute('data-audio');
                                            const audioPlayer = document.getElementById('audioPlayer');

                                            if (audioSrc) {
                                                audioPlayer.src = audioSrc;
                                                audioPlayer.load();
                                                audioPlayer.play();
                                            } else {
                                                audioPlayer.pause();
                                                audioPlayer.src = '';
                                            }
                                        });
                                        window.addEventListener('DOMContentLoaded', function() {
                                            const select = document.getElementById('music_id');
                                            const selectedOption = select.options[select.selectedIndex];
                                            const audioSrc = selectedOption.getAttribute('data-audio');

                                            if (audioSrc) {
                                                const audioPlayer = document.getElementById('audioPlayer');
                                                audioPlayer.src = audioSrc;
                                                audioPlayer.play();
                                            }
                                        });
                                    </script>

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
                                        <input class="form-check-input" type="checkbox" id="enable_rsvp"
                                            name="enable_rsvp">
                                        <label class="form-check-label" for="enable_rsvp">
                                            Aktifkan RSVP
                                        </label>
                                    </div>
                                </div>

                                <div id="rsvp_settings">
                                    <div class="mb-3">
                                        <label for="rsvp_deadline" class="form-label">Batas Tanggal RSVP</label>
                                        <input type="date" name="rsvp_deadline" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="rsvp_message" class="form-label">Pesan Konfirmasi</label>
                                        <textarea name="rsvp_message" rows="4"
                                            placeholder="Terima kasih atas konfirmasi kehadiran Anda. Kami sangat menantikan kehadiran Anda di hari bahagia kami."
                                            class="form-control"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="rsvp_whatsapp" class="form-label">Nomor WhatsApp untuk
                                            Notifikasi</label>
                                        <input type="text" name="rsvp_whatsapp" placeholder="6281234567890"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>

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
            preview.innerHTML = '';
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
            // Set src preview
            preview.src = URL.createObjectURL(event.target.files[0]);
            previewContainer.classList.remove('d-none');

            // Sembunyikan upload box
            uploadBox.parentElement.classList.add('d-none');
        }
    }

    function removeGroomPreview() {
        const preview = document.getElementById('previewGroom');
        const previewContainer = document.getElementById('previewContainerGroom');
        const uploadBox = document.getElementById('uploadBoxGroom');
        const inputFile = document.getElementById('foto_pria');

        // Hapus preview
        preview.src = '';
        previewContainer.classList.add('d-none');

        // Reset input file
        inputFile.value = '';

        // Tampilkan kembali upload box
        uploadBox.parentElement.classList.remove('d-none');
    }

    // Image preview functions for bride
    function previewBrideImage(event) {
        const preview = document.getElementById('previewBride');
        const previewContainer = document.getElementById('previewContainerBride');
        const uploadBox = document.getElementById('uploadBoxBride');

        if (event.target.files && event.target.files[0]) {
            // Set src preview
            preview.src = URL.createObjectURL(event.target.files[0]);
            previewContainer.classList.remove('d-none');

            // Sembunyikan upload box
            uploadBox.parentElement.classList.add('d-none');
        }
    }

    function removeBridePreview() {
        const preview = document.getElementById('previewBride');
        const previewContainer = document.getElementById('previewContainerBride');
        const uploadBox = document.getElementById('uploadBoxBride');
        const inputFile = document.getElementById('foto_wanita');

        // Hapus preview
        preview.src = '';
        previewContainer.classList.add('d-none');

        // Reset input file
        inputFile.value = '';

        // Tampilkan kembali upload box
        uploadBox.parentElement.classList.remove('d-none');
    }
</script>

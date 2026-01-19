<x-app-layout>

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

        .inner-sidebar-wrap .inner-sidebar-content {
            overflow-y: auto;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE & Edge lama */
        }

        .inner-sidebar-wrap .inner-sidebar-content::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }

        .inner-sidebar-wrap .inner-sidebar {
            background-color: transparent;
        }

        .inner-sidebar,
        .inner-sidebar-wrap,
        .inner-sidebar .nav {
            width: 100%;
            max-width: 100%;
        }

        /* --- CSS UNTUK MEMPERBAIKI UKURAN FOTO --- */

        /* Container agar foto dan tombol delete berada di tengah */
        #previewContainerGroom,
        #previewContainerBride {
            text-align: center;
        }

        /* Style khusus untuk gambar preview agar ukurannya proporsional & profesional */
        #previewGroom,
        #previewBride {
            /* Override class img-fluid agar tidak terlalu lebar */
            width: 100%;
            max-width: 300px;
            /* Batas lebar maksimal */
            height: 400px;
            /* Tinggi tetap agar rapi (Portrait) */
            object-fit: cover;
            /* Agar gambar terpotong rapi tanpa gepeng */
            border-radius: 12px;
            /* Sudut melengkung yang modern */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Bayangan halus */
            margin: 0 auto;
            /* Posisi tengah */
            background-color: #f8f9fa;
            /* Warna background jika gambar transparan/kosong */
            display: block;
        }

        /* Tambahan style lain */
        [data-bs-theme="dark"] .ts-control,
        [data-bs-theme="dark"] .ts-dropdown {
            background-color: #1e1e2d;
            color: #e5e7eb;
            border-color: #374151;
        }

        [data-bs-theme="dark"] .ts-control input {
            color: #e5e7eb;
        }

        [data-bs-theme="dark"] .ts-dropdown {
            box-shadow: 0 10px 25px rgba(0, 0, 0, .6);
        }

        [data-bs-theme="dark"] .ts-dropdown .option {
            color: #e5e7eb;
        }

        [data-bs-theme="dark"] .ts-dropdown .option:hover,
        [data-bs-theme="dark"] .ts-dropdown .option.active {
            background-color: #374151;
            color: #fff;
        }

        [data-bs-theme="dark"] .ts-dropdown .option.selected {
            background-color: #2563eb;
            color: #fff;
        }

        [data-bs-theme="dark"] .ts-control::after {
            border-top-color: #e5e7eb;
        }

        /* Ikon style */
        .islami-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #eff2f5;
            border-radius: 10px;
            color: #3b82f6;
        }
          .nav-link {
                cursor: pointer;
            }
    </style>

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <div class="inner-sidebar-wrap">
        {{-- SIDEBAR MENU --}}
        <div class="inner-sidebar bg-none mb-5 h-100 ">

            <div class="card adminuiux-card h-100">
                <div class="card-body d-flex flex-column">

                    <div class="row mb-3">
                        <div class="col align-self-center">
                            <h6 class="fw-medium">Main Menu</h6>
                        </div>
                        <div class="col-auto">
                            <a class="btn btn-link btn-square" data-bs-toggle="collapse" data-bs-target="#usersidebarprofile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="inner-sidebar-wrap flex-fill">
                        <div class="inner-sidebar h-100">
                            <ul class="nav flex-column h-100 overflow-auto no-scrollbar">

                                <li class="nav-item">
                                    <a class="nav-link tab-btn active" data-tab="1">
                                        <i class="bi bi-person-fill me-3"></i> Mempelai Pria
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="7">
                                        <i class="bi bi-person-heart me-3"></i> Mempelai Wanita
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="6">
                                        <i class="bi bi-geo-alt-fill me-3"></i> Tempat & Tanggal
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="2">
                                        <i class="bi bi-palette me-3"></i> Tema & Warna
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="3">
                                        <i class="bi bi-images me-3"></i> Galeri Foto
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="4">
                                        <i class="bi bi-music-note-beamed me-3"></i> Musik
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="8">
                                        <i class="bi bi-play me-3"></i> Video dan Kisah Cinta
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="5">
                                        <i class="bi bi-chat-dots me-3"></i> RSVP
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link tab-btn" data-tab="9">
                                        <i class="menu-icon bi bi-gift me-3"></i> Hadiah dan Donasi
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- MAIN CONTENT --}}
        <div class="inner-sidebar-content ">
            <div class="p-3">
                {{-- HEADER --}}
                <div class="row gx-3 align-items-center mb-4">
                    <div class="col col-sm">
                        <h5>Edit Undangan</h5>
                    </div>
                    <div class="col-auto py-1 ms-auto d-flex gap-2">
                        <a href="{{ url($invitation->slug) }}" target="_blank"
                           class="btn btn-outline-primary btn-sm">
                           Preview Undangan
                        </a>

                        <a href="{{ route('invitation.index') }}"
                           class="btn btn-outline-secondary btn-sm">
                           Batal
                        </a>

                        <button class="btn btn-primary btn-sm" onclick="document.getElementById('myForm').submit()">
                            <i class="bi bi-save me-2 align-middle"></i>
                            Simpan Perubahan
                        </button>
                    </div>

                </div>

                <form id="myForm" method="POST" action="{{ route('invitation.update', $invitation) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- 1. MEMPELAI PRIA --}}
                    <div id="1" class="tab-content active">
                        <div class="card">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                                <h6 class="mb-0">Data Mempelai Pria</h6>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="groom_name" class="form-label">Nama Mempelai Pria</label>
                                        <input type="text" id="groom_name" name="groom_name"
                                            value="{{ old('groom_name', $invitation->groom_name) }}"
                                            placeholder="Masukkan nama mempelai pria" class="form-control">
                                    </div>
                                    <input name="invitation_id" value="{{ $invitation->id }}" hidden >

                                    <div class="col-md-6">
                                        <label for="groom_nickname" class="form-label">Nama Panggilan</label>
                                        <input type="text" id="groom_nickname" name="groom_nickname"
                                            value="{{ old('groom_nickname', $invitation->groom_nickname) }}"
                                            placeholder="Masukkan nama panggilan" class="form-control">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="groom_father_name" class="form-label">Nama Ayah Kandung</label>
                                        <input type="text" id="groom_father_name" name="groom_father_name"
                                            value="{{ old('groom_father_name', $invitation->groom_father_name) }}"
                                            placeholder="Masukkan nama lengkap ayah" class="form-control">
                                    </div>
                                        <div class="col-md-6">
                                            <label for="groom_mother_name" class="form-label">Nama Ibu Kandung</label>
                                            <input type="text" id="groom_mother_name" name="groom_mother_name" value="{{ old('groom_mother_name', $invitation->groom_mother_name) }}" placeholder="Masukkan nama lengkap ibu" class="form-control">
                                        </div>
                                        <div class="col-12 mb-6">
                                            <label for="groom_username_instagram" class="form-label">Username</label>
                                            <span>@</span>
                                            <input type="text" id="groom_username_instagram" name="groom_username_instagram" value="{{ old('groom_username_instagram') }}" placeholder="Contoh: gemini.ai" class="form-control insta-username">
                                        </div>


                                        <div class="col-12 mb-6">
                                            <label for="groom_instagram" class="form-label">Link Instagram (Otomatis)</label>
                                            <input type="text" id="groom_instagram" name="groom_instagram" value="{{ old('groom_instagram') }}" placeholder="Akan terisi otomatis..." class="form-control" readonly>
                                        </div>

                                    <div class="col-12">
                                        <label class="form-label">Foto Mempelai Pria</label>
                                        {{-- LOGIKA EDIT: Jika ada foto lama, tampilkan preview --}}
                                        @if($invitation->foto_pria)
                                            <div id="previewContainerGroom" class="mt-3 mb-3 text-center">
                                                <img id="previewGroom" src="{{ asset('storage/' . $invitation->foto_pria) }}" class="professional-preview rounded" alt="Preview Foto">
                                                <div class="text-center mt-2">
                                                    <button type="button" onclick="removeGroomPreview()" class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="border border-dashed p-4 text-center rounded d-none" id="uploadBoxGroomContainer">
                                                <label id="uploadBoxGroom" for="foto_pria" class="cursor-pointer">
                                                    <div class="mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                    <input id="foto_pria" type="file" name="foto_pria" class="d-none" onchange="previewGroomImage(event)">
                                                </label>
                                            </div>
                                        @else
                                            <div class="border border-dashed p-4 text-center rounded" id="uploadBoxGroomContainer">
                                                <label id="uploadBoxGroom" for="foto_pria" class="cursor-pointer">
                                                    <div class="mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                        </svg>
                                                    </div>
                                                    <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                    <input id="foto_pria" type="file" name="foto_pria" class="d-none" onchange="previewGroomImage(event)">
                                                </label>
                                            </div>
                                            <div id="previewContainerGroom" class="mt-3 d-none text-center">
                                                <img id="previewGroom" class="img-fluid rounded professional-preview" alt="Preview Foto">
                                                <div class="text-center mt-2">
                                                    <button type="button" onclick="removeGroomPreview()" class="btn btn-danger btn-sm">
                                                        Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. TEMA & WARNA --}}
                    <div id="2" class="tab-content d-none">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Pilih Template</label>
                                    <select id="template_id" name="template_id" class="form-select">
                                        @foreach ($templates as $template)
                                        <option value="{{ $template->id }}"
                                            {{ $invitation->template_id == $template->id ? 'selected' : '' }}
                                           data-image="{{ Storage::url($template->preview) }}">
                                            {{ $template->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <script>
                                        new TomSelect('#template_id', {
                                            placeholder: 'Cari template...',
                                            valueField: 'value',
                                            labelField: 'text',
                                            searchField: ['text'],
                                            render: {
                                                option: function(data, escape) {
                                                    return `<div class="d-flex align-items-center gap-2"><i class="bi bi-palette fs-5"></i><span>${escape(data.text)}</span></div>`;
                                                },
                                                item: function(data, escape) {
                                                    return `<span><i class="bi bi-palette me-1"></i>${escape(data.text)}</span>`;
                                                }
                                            }
                                        });
                                    </script>
                                </div>

                                <div class="mb-4">
                                    <label for="gallery_cover" class="form-label">Cover Galeri</label>
                                    <input type="file" id="gallery_cover" name="gallery_cover" accept="image/*" class="form-control">
                                </div>


                            </div>
                            <div class="item-center col-md-4">
                                <label class="form-label">Preview</label>
                                <div class="android-frame">
                                    <div class="screen">
                                        {{-- Logic sederhana update gambar preview berdasarkan select --}}
                                        <img id="androidPreview" class="preview-img" loading="lazy">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const select = document.getElementById('template_id');
                            const preview = document.getElementById('androidPreview');

                            function updatePreview() {
                                const selected = select.options[select.selectedIndex];
                                const image = selected.getAttribute('data-image');

                                if (image) {
                                    preview.src = image;
                                }
                            }

                            // init saat load (edit mode)
                            updatePreview();

                            // ganti saat dipilih
                            select.addEventListener('change', updatePreview);
                        });
                        </script>

                    {{-- 3. GALERI FOTO --}}
                    <div id="3" class="tab-content d-none">
                        <label for="gallery_cover" class="form-label">Galeri Kisah</label>
                        <div class="">
                            <div class="card">
                                <div id="gallery-dropzone" class="border border-dashed  p-5 text-center rounded cursor-pointer">
                                    <p class="mb-0">Drag & drop gambar di sini atau klik untuk memilih</p>
                                    <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="d-none">
                                </div>
                            </div>
                            <div class="mt-5 ">
                                <label for="" class="mb-3">Preview :</label>
                                <div id="gallery-preview" class="d-flex gap-2 flex-wrap ">
                                    {{-- EXISTING GALLERY --}}
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

                    {{-- 4. MUSIK --}}
                    <div id="4" class="tab-content d-none">
                        <div class="mb-3">
                            <label for="music_id" class="form-label">Pilih Lagu Background</label>
                            <select id="music_id" name="music_id" class="form-select">
                                <option value="">-- Pilih Lagu --</option>
                                @if(isset($music))
                                @foreach ($music as $musicItem)
                                <option value="{{ $musicItem->id }}"
                                    {{ $invitation->music == $musicItem->id ? 'selected' : '' }}
                                    data-audio="{{ asset('storage/' . $musicItem->audio_url) }}">
                                    {{ $musicItem->title }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <script>
                                new TomSelect('#music_id', {
                                    placeholder: 'Cari lagu...',
                                    valueField: 'value',
                                    labelField: 'text',
                                    searchField: ['text'],
                                    render: {
                                        option: function(data, escape) {
                                            return `<div class="d-flex align-items-center gap-2"><i class="bi bi-music-note-beamed fs-5"></i><span>${escape(data.text)}</span></div>`;
                                        },
                                        item: function(data, escape) {
                                            return `<span><i class="bi bi-music-note-beamed me-1"></i>${escape(data.text)}</span>`;
                                        }
                                    }
                                });
                            </script>

                            <audio id="audioPlayer" controls style="margin-top:10px; width:100%;">
                                Your browser does not support the audio element.
                            </audio>
                        </div>

                        <div class="mb-3">
                            <label for="custom_music" class="form-label">Upload Lagu Pilihan Kamu</label>
                            <input type="file" name="custom_music" accept="audio/*" class="form-control">
                        </div>
                    </div>

                    {{-- 5. RSVP --}}
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

                    {{-- 6. TEMPAT --}}
                    <div id="6" class="tab-content d-none">
                        {{-- DATE CARD --}}
                        <div class="card mb-3">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-calendar-event fs-5"></i>
                                </div>
                                <h6 class="mb-0">Tanggal Pernikahan</h6>
                            </div>
                            <div class="card-body ">
                                <div class="">
                                    <label for="wedding_date" class="form-label">Tanggal</label>
                                    <input type="date" id="wedding_date" name="wedding_date"
                                        value="{{ old('wedding_date', $invitation->wedding_date) }}"
                                        class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- AKAD CARD --}}
                        <div class="card mb-4">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-moon-stars fs-5"></i>
                                </div>
                                <h6 class="mb-0">Tempat Akad</h6>
                            </div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <label for="akad_location" class="form-label">Nama Tempat</label>
                                    <input type="text" id="akad_location" name="akad_location"
                                        value="{{ old('akad_location', $invitation->akad_location) }}"
                                        placeholder="Masukkan lokasi akad" class="form-control">

                                </div>
                                <div class="col-md-6">

                                   <label for="akad_time" class="form-label">Waktu Akad</label>
                                    <input type="text"
                                        id="akad_time"
                                        name="akad_time"
                                        value="{{ old('akad_time', $invitation->akad_time) }}"
                                        class="form-control"
                                        placeholder="Contoh: 08:00 - Selesai">
                                </div>
                                 <div class="col-12">
                                    <label for="akad_address" class="form-label">Alamat Akad</label>
                                    <input type="text" id="akad_address" name="akad_address"
                                        value="{{ old('akad_address') }}"
                                        placeholder="Contoh : Jalan Pancasila No.41 " class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="akad_maps" class="form-label">Link Maps</label>
                                    <input type="text" id="akad_maps" name="akad_maps"
                                        value="{{ old('akad_maps', $invitation->akad_maps) }}"
                                        placeholder="Masukkan link Google Maps" class="form-control">
                                </div>
                            </div>
                        </div>

                        {{-- RESEPSI CARD --}}
                        <div class="card mb-4">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-geo-alt fs-5"></i>
                                </div>
                                <h6 class="mb-0">Tempat Resepsi</h6>
                            </div>
                            <div class="card-body row g-3">
                                <div class="col-md-6">
                                    <label for="resepsi_location" class="form-label">Lokasi Acara</label>
                                    <input type="text" id="resepsi_location" name="resepsi_location"
                                        value="{{ old('resepsi_location', $invitation->resepsi_location) }}"
                                        placeholder="Masukkan lokasi resepsi" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="resepsi_time" class="form-label">Waktu Resepsi</label>
                                    <input type="text" id="resepsi_time" name="resepsi_time" placeholder="Contoh: 08:00 - Selesai"
                                        value="{{ old('resepsi_time', $invitation->resepsi_time) }}"
                                        class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="resepsi_address" class="form-label">Alamat Resepsi</label>
                                    <input type="text" id="resepsi_address" name="resepsi_address"
                                        value="{{ old('resepsi_address') }}"
                                        placeholder="Contoh : Jalan Pancasila No.41 " class="form-control">
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

                    {{-- 7. DATA WANITA --}}
                    <div id="7" class="tab-content d-none">
                        <div class="card">
                            <div class="card-header p-3 d-flex align-items-center gap-3">
                                <div class="islami-icon">
                                    <i class="bi bi-person-heart fs-5"></i>
                                </div>
                                <h6 class="mb-0">Data Mempelai Wanita</h6>
                            </div>
                            <div class="card-body row g-3">
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
                                <div class="col-12 mb-6">
                                    <label for="bride_username_instagram" class="form-label">Username</label>
                                    <span>@</span>
                                    <input type="text" id="bride_username_instagram" name="bride_username_instagram"
                                        value="{{ old('bride_username_instagram') }}"
                                        placeholder="Contoh: gemini.ai" class="form-control insta-username">
                                </div>

                                <div class="col-12 mb-6">
                                    <label for="bride_instagram" class="form-label">Link Instagram (Otomatis)</label>
                                    <input type="text" id="bride_instagram" name="bride_instagram"
                                        value="{{ old('bride_instagram') }}"
                                        placeholder="Akan terisi otomatis..." class="form-control" readonly>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Foto Mempelai Wanita</label>
                                    @if($invitation->foto_wanita)
                                        <div id="previewContainerBride" class="mt-3 mb-3 text-center">
                                            <img id="previewBride" src="{{ asset('storage/' . $invitation->foto_wanita) }}" class="professional-preview rounded" alt="Preview Foto">
                                            <div class="text-center mt-2">
                                                <button type="button" onclick="removeBridePreview()" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                        <div class="border border-dashed p-4 text-center rounded d-none" id="uploadBoxBrideContainer">
                                            <label id="uploadBoxBride" for="foto_wanita" class="cursor-pointer">
                                                <div class="mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                    </svg>
                                                </div>
                                                <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                <input id="foto_wanita" type="file" name="foto_wanita" class="d-none" onchange="previewBrideImage(event)">
                                            </label>
                                        </div>
                                    @else
                                        <div class="border border-dashed p-4 text-center rounded" id="uploadBoxBrideContainer">
                                            <label id="uploadBoxBride" for="foto_wanita" class="cursor-pointer">
                                                <div class="mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="d-block mx-auto" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                    </svg>
                                                </div>
                                                <p class="mb-0">Klik atau tarik foto ke sini</p>
                                                <input id="foto_wanita" type="file" name="foto_wanita" class="d-none" onchange="previewBrideImage(event)">
                                            </label>
                                        </div>
                                        <div id="previewContainerBride" class="mt-3 d-none text-center">
                                            <img id="previewBride" class="img-fluid rounded professional-preview" alt="Preview Foto">
                                            <div class="text-center mt-2">
                                                <button type="button" onclick="removeBridePreview()" class="btn btn-danger btn-sm">
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 8. LAINNYA (VIDEO & KISAH) --}}
                    <div id="8" class="tab-content d-none">
                        <div id="other">
                            <div class="row g-3">
                                {{-- QUOTE --}}
                                <div class="col-md-6">
                                    <label for="wedding_quote_select" class="form-label">Kutipan Pernikahan</label>
                                    <select id="wedding_quote_select" class="form-select" onchange="showQuote()" name="quote_id">
                                        <option value="">-- Pilih Kutipan --</option>
                                        <option value="rum21" {{ $invitation->quote_id == 'rum21' ? 'selected' : '' }}>QS. Ar-Rum : 21</option>
                                        <option value="nisa1" {{ $invitation->quote_id == 'nisa1' ? 'selected' : '' }}>QS. An-Nisa : 1</option>
                                        <option value="furqan74" {{ $invitation->quote_id == 'furqan74' ? 'selected' : '' }}>QS. Al-Furqan : 74</option>
                                    </select>

                                    <!-- Tampilan hasil kutipan -->
                                    <div id="quote_result" class="mt-3 p-3 border rounded" >
                                        <p id="quote_text" class="mb-1 fst-italic">{{ $invitation->wedding_quote }}</p>
                                        <strong id="quote_source"></strong>
                                    </div>

                                    <!-- Hidden input untuk submit custom text jika perlu -->
                                    <input type="hidden" name="wedding_quote" id="wedding_quote" value="{{ old('wedding_quote', $invitation->wedding_quote) }}">
                                </div>

                                {{-- VIDEO --}}
                                <div class="col-md-6">
                                    <label for="video_link" class="form-label">Link Video Pernikahan</label>
                                    <input type="text" id="video_link" name="video_link"
                                        value="{{ old('video_link', $invitation->video_link) }}"
                                        placeholder="Masukkan link video YouTube" class="form-control">
                                </div>

                                <div class="col-12" id="loveStoryWrapper">
                                    <label  class="form-label">Kisah Cinta</label>
                                    @forelse($invitation->love_story ?? [] as $index => $story)
                                    <div class="love-story-item border rounded p-3 mb-3">

                                        <input type="hidden" name="story_id[]" value="{{ $index }}">

                                        <input type="text" name="story_title[]" class="form-control mb-2" placeholder="Judul Cerita" value="{{ old('story_title.'.$index, $story['title'] ?? '') }}">

                                        <textarea name="love_story[]" rows="4" class="form-control mb-2" placeholder="Ceritakan perjalanan cinta kalian">{{ old('love_story.'.$index, $story['story'] ?? '') }}</textarea>

                                        @if(!empty($story['photo']))
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/'.$story['photo']) }}" class="img-fluid rounded mb-2" style="max-height:150px;object-fit:cover;">
                                        </div>
                                        @endif

                                        <input type="file" name="story_photo[]" class="form-control mb-2" accept="image/*">

                                        <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.love-story-item').remove()">
                                            Hapus Cerita
                                        </button>

                                    </div>
                                    @empty
                                    <div class="love-story-item border rounded p-3 mb-3">
                                        <input type="hidden" name="story_id[]" value="">
                                        <input type="text" name="story_title[]" class="form-control mb-2" placeholder="Judul Cerita">
                                        <textarea name="love_story[]" rows="4" class="form-control mb-2"></textarea>
                                        <input type="file" name="story_photo[]" class="form-control">
                                    </div>
                                    @endforelse
                                    <button type="button" class="btn btn-outline-primary mt-2" onclick="addLoveStory()">
                                        + Tambah Cerita
                                    </button>

                                    </div>
                            </div>
                        </div>
                    </div>

                    {{-- 9. GIFT / DONASI --}}
                    <div id="9" class="tab-content d-none">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" name="enable_gift" id="enableGift" {{ isset($invitation->enable_gift) && $invitation->enable_gift ? 'checked' : '' }}>
                            <label class="form-check-label" for="enableGift">
                                Aktifkan Fitur Hadiah & Donasi
                            </label>
                        </div>

                        <div id="giftTab" class="{{ isset($invitation->enable_gift) && $invitation->enable_gift == 1 ? '' : 'd-none' }}">
                            <div class="card">
                                <div class="card-header p-3 d-flex align-items-center gap-3">
                                    <div class="islami-icon">
                                        <i class="bi bi-gift-fill fs-5"></i>
                                    </div>
                                    <h6 class="mb-0">Data Hadiah & Donasi</h6>
                                </div>
                                <div class="card-body">
                                    <div id="giftContainer">

                                        {{-- Load existing gifts if stored as JSON in a single field or similar. Assuming 'gifts' relation or JSON field --}}
                                        {{-- Since Code B implies dynamic input, we will render the inputs based on available data or empty if new --}}
                                        @if(json_decode($invitation->gifts ?? '[]'))
                                            @foreach(json_decode($invitation->gifts) as $g)
                                            <div class="gift-item card p-3 mb-3 position-relative">
                                                <button type="button" class="btn-close position-absolute top-0 end-0 remove-gift" aria-label="Hapus"></button>
                                                <div class="mb-2">
                                                    <label class="form-label">Bank / E-Wallet</label>
                                                    <select name="bank[]" class="form-select bank-select">
                                                        <option value="">-- Pilih Bank / E-Wallet --</option>
                                                        <option value="BCA" {{ $g->bank == 'BCA' ? 'selected' : '' }}>BCA</option>
                                                        <option value="BNI" {{ $g->bank == 'BNI' ? 'selected' : '' }}>BNI</option>
                                                        <option value="BRI" {{ $g->bank == 'BRI' ? 'selected' : '' }}>BRI</option>
                                                        <option value="Mandiri" {{ $g->bank == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                                        <option value="CIMB" {{ $g->bank == 'CIMB' ? 'selected' : '' }}>CIMB</option>
                                                        <option value="OVO" {{ $g->bank == 'OVO' ? 'selected' : '' }}>OVO</option>
                                                        <option value="GoPay" {{ $g->bank == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                                        <option value="Dana" {{ $g->bank == 'Dana' ? 'selected' : '' }}>Dana</option>
                                                        <option value="LinkAja" {{ $g->bank == 'LinkAja' ? 'selected' : '' }}>LinkAja</option>
                                                        <option value="ShopeePay" {{ $g->bank == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Nomor Rekening / HP</label>
                                                    <input type="text" name="number[]" class="form-control" value="{{ $g->number ?? '' }}">
                                                </div>
                                                <div class="mb-2">
                                                    <label class="form-label">Atas Nama</label>
                                                    <input type="text" name="name[]" class="form-control" value="{{ $g->name ?? '' }}">
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <button type="button" id="addGift" class="btn btn-secondary mb-3">Tambah Gift Lain</button>

                                    <!-- Template Gift (hidden) -->
                                    <div id="giftTemplate" class="gift-item card p-3 mb-3 d-none position-relative">
                                        <button type="button" class="btn-close position-absolute top-0 end-0 remove-gift" aria-label="Hapus"></button>

                                        <div class="mb-2">
                                            <label class="form-label">Bank / E-Wallet</label>
                                            <select name="bank[]" class="form-select bank-select">
                                                <option value="">-- Pilih Bank / E-Wallet --</option>
                                                <option value="BCA">BCA</option>
                                                <option value="BNI">BNI</option>
                                                <option value="BRI">BRI</option>
                                                <option value="Mandiri">Mandiri</option>
                                                <option value="CIMB">CIMB</option>
                                                <option value="OVO">OVO</option>
                                                <option value="GoPay">GoPay</option>
                                                <option value="Dana">Dana</option>
                                                <option value="LinkAja">LinkAja</option>
                                                <option value="ShopeePay">ShopeePay</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Nomor Rekening / HP</label>
                                            <input type="text" name="number[]" class="form-control">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Atas Nama</label>
                                            <input type="text" name="name[]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->

<script>
    // Ambil semua element yang memiliki class insta-username
    const usernameInputs = document.querySelectorAll('.insta-username');

    usernameInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Cek apakah ini milik groom atau bride berdasarkan ID
            const role = this.id.includes('groom') ? 'groom' : 'bride';
            const targetLinkInput = document.getElementById(`${role}_instagram`);

            let username = this.value.trim();

            // Hapus karakter @ jika ada
            if (username.startsWith('@')) {
                username = username.substring(1);
            }

            // Update value link instagram
            if (username) {
                targetLinkInput.value = `https://www.instagram.com/${username}`;
            } else {
                targetLinkInput.value = '';
            }
        });
    });
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
                const enableGift = document.getElementById('enableGift');
    const giftTab = document.getElementById('giftTab');

    // 🔥 INIT STATE DARI DATABASE
    if (enableGift && enableGift.checked) {
        giftTab.classList.remove('d-none');
    }

    if(enableGift){
        enableGift.addEventListener('change', function() {
            if (this.checked) {
                giftTab.classList.remove('d-none');
            } else {
                giftTab.classList.add('d-none');
            }
        });
    }

            // --- GIFT LOGIC ---
            const giftContainer = document.getElementById('giftContainer');
            const addGiftBtn = document.getElementById('addGift');
            const template = document.getElementById('giftTemplate');

            function addGift() {
                // clone template hidden
                const clone = template.cloneNode(true);
                clone.classList.remove('d-none');
                clone.removeAttribute('id');

                // reset input/select
                clone.querySelectorAll('input').forEach(input => input.value = '');
                clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

                giftContainer.appendChild(clone);

                // init Tom Select hanya pada select baru
                clone.querySelectorAll('.bank-select').forEach(select => {
                    new TomSelect(select, {
                        placeholder: 'Cari Bank / E-Wallet...',
                        allowEmptyOption: true,
                        render: {
                            option: function(data, escape) {
                                return `<div class="d-flex align-items-center gap-2"><i class="bi bi-wallet2"></i><span>${escape(data.text)}</span></div>`;
                            },
                            item: function(data, escape) {
                                return `<span><i class="bi bi-wallet2 me-1"></i>${escape(data.text)}</span>`;
                            }
                        }
                    });
                });

                attachRemoveEvents();
            }

            function attachRemoveEvents() {
                document.querySelectorAll('.remove-gift').forEach(btn => {
                    btn.onclick = function() {
                        if (document.querySelectorAll('.gift-item').length > 1) {
                            this.closest('.gift-item').remove();
                        } else {
                            // Biarkan user hapus jika kosong, atau alert jika perlu minimal 1
                            // Sesuai request user, tidak ada validasi minimal
                            this.closest('.gift-item').remove();
                        }
                    };
                });
            }

            // Init TomSelect untuk existing gifts
            document.querySelectorAll('#giftContainer .bank-select').forEach(select => {
                new TomSelect(select, {
                    placeholder: 'Cari Bank / E-Wallet...',
                    allowEmptyOption: true,
                    render: {
                        option: function(data, escape) {
                            return `<div class="d-flex align-items-center gap-2"><i class="bi bi-wallet2"></i><span>${escape(data.text)}</span></div>`;
                        },
                        item: function(data, escape) {
                            return `<span><i class="bi bi-wallet2 me-1"></i>${escape(data.text)}</span>`;
                        }
                    }
                });
            });

            if(addGiftBtn) addGiftBtn.addEventListener('click', addGift);

            // --- ANDROID PREVIEW UPDATE ---
            const templateSelect = document.getElementById('template_id');
            const androidPreview = document.getElementById('androidPreview');

            if (templateSelect && androidPreview) {
                templateSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    androidPreview.src = selectedOption.dataset.image;
                });
            }
        });

        function addLoveStory() {
            const wrapper = document.getElementById("loveStoryWrapper");

            const div = document.createElement("div");
            div.className = "love-story-item border rounded p-3 mb-3";

            div.innerHTML = `
                <input type="text" name="story_title[]" class="form-control mb-2"
                    placeholder="Judul Cerita (contoh: Lamaran)">
                <textarea name="love_story[]" rows="4" class="form-control mb-2"
                    placeholder="Ceritakan perjalanan cinta kalian"></textarea>
                <input type="file" name="story_photo[]" class="form-control mb-2"
                    accept="image/*">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="this.parentElement.remove()">
                    Hapus Cerita
                </button>
            `;

            wrapper.appendChild(div);
        }

        function showQuote() {
            const quotes = {
                rum21: {
                    text: "Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan untukmu agar kamu merasa tentram.",
                    source: "(QS. Ar-Rum : 21)"
                },
                nisa1: {
                    text: "Bertakwalah kepada Tuhanmu yang telah menciptakan kamu dari diri yang satu dan darinya Dia menciptakan pasangannya.",
                    source: "(QS. An-Nisa : 1)"
                },
                furqan74: {
                    text: "Ya Tuhan kami, anugerahkanlah kepada kami pasangan dan keturunan sebagai penyejuk mata.",
                    source: "(QS. Al-Furqan : 74)"
                }
            };

            const select = document.getElementById("wedding_quote_select").value;
            const resultBox = document.getElementById("quote_result");
            const hiddenInput = document.getElementById("wedding_quote");

            if (select && quotes[select]) {
                document.getElementById("quote_text").innerText = `"${quotes[select].text}"`;
                document.getElementById("quote_source").innerText = quotes[select].source;

                // Simpan ke hidden input
                if(hiddenInput) {
                    hiddenInput.value = `"${quotes[select].text}" ${quotes[select].source}`;
                }

                resultBox.style.display = "block";
            } else {
                resultBox.style.display = "none";
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            const savedQuote = document.getElementById("wedding_quote")?.value || '';
            const select = document.getElementById("wedding_quote_select");

            if (!savedQuote) return;

            Object.entries(quotes).forEach(([key, quote]) => {
                if (savedQuote.includes(quote.text) || savedQuote.includes(quote.source)) {
                    select.value = key;
                    showQuote();
                }
            });
        });
        // --- TABS LOGIC ---
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content[id]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.add('d-none'));

                tab.classList.add('active');
                const tabId = tab.dataset.tab;
                const content = document.getElementById(tabId);
                if(content) content.classList.remove('d-none');
            });
        });

        // --- IMAGE PREVIEW LOGIC (GROOM) ---
        function previewGroomImage(event) {
            const preview = document.getElementById('previewGroom');
            const previewContainer = document.getElementById('previewContainerGroom');
            const uploadBoxContainer = document.getElementById('uploadBoxGroomContainer');

            if (event.target.files && event.target.files[0]) {
                // Jika container preview belum ada di DOM (kondisi else di HTML), buat dulu
                if (!previewContainer || previewContainer.classList.contains('d-none')) {
                     // Logic ini menangani saat awalnya upload box tampil, lalu user upload
                     // Kita pastikan struktur HTML sudah ada dan hanya toggle class
                }

                preview.src = URL.createObjectURL(event.target.files[0]);
                previewContainer.classList.remove('d-none');
                uploadBoxContainer.classList.add('d-none');
            }
        }

        function removeGroomPreview() {
            const preview = document.getElementById('previewGroom');
            const previewContainer = document.getElementById('previewContainerGroom');
            const uploadBoxContainer = document.getElementById('uploadBoxGroomContainer');
            const inputFile = document.getElementById('foto_pria');

            // Hapus sumber gambar
            preview.src = '';

            // Tampilkan Upload Box, Sembunyikan Preview
            previewContainer.classList.add('d-none');
            uploadBoxContainer.classList.remove('d-none');

            // Reset input agar bisa upload file yang sama
            inputFile.value = '';
        }

        // --- IMAGE PREVIEW LOGIC (BRIDE) ---
        function previewBrideImage(event) {
            const preview = document.getElementById('previewBride');
            const previewContainer = document.getElementById('previewContainerBride');
            const uploadBoxContainer = document.getElementById('uploadBoxBrideContainer');

            if (event.target.files && event.target.files[0]) {
                preview.src = URL.createObjectURL(event.target.files[0]);
                previewContainer.classList.remove('d-none');
                uploadBoxContainer.classList.add('d-none');
            }
        }

        function removeBridePreview() {
            const preview = document.getElementById('previewBride');
            const previewContainer = document.getElementById('previewContainerBride');
            const uploadBoxContainer = document.getElementById('uploadBoxBrideContainer');
            const inputFile = document.getElementById('foto_wanita');

            preview.src = '';
            previewContainer.classList.add('d-none');
            uploadBoxContainer.classList.remove('d-none');
            inputFile.value = '';
        }

        // --- GALLERY LOGIC ---
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
                // Tidak kita reset innerHTML karena ada existing images
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const imgContainer = document.createElement("div");
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

        // --- RSVP LOGIC ---
        const enableRsvp = document.getElementById('enable_rsvp');
        const rsvpSettings = document.getElementById('rsvp_settings');

        if (enableRsvp && rsvpSettings) {
            enableRsvp.addEventListener('change', () => {
                rsvpSettings.style.display = enableRsvp.checked ? 'block' : 'none';
            });
        }

        // --- AUDIO PLAYER LOGIC ---
        const musicSelect = document.getElementById('music_id');
        const audioPlayer = document.getElementById('audioPlayer');

        if (musicSelect && audioPlayer) {
             // Init on load
             const initialOption = musicSelect.options[musicSelect.selectedIndex];
             if(initialOption && initialOption.getAttribute('data-audio')) {
                 audioPlayer.src = initialOption.getAttribute('data-audio');
             }

            musicSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const audioSrc = selectedOption.getAttribute('data-audio');

                if (audioSrc) {
                    audioPlayer.src = audioSrc;
                    audioPlayer.load();
                    audioPlayer.play();
                } else {
                    audioPlayer.pause();
                    audioPlayer.src = '';
                }
            });
        }

        // --- DELETE GALLERY FUNCTION ---
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
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

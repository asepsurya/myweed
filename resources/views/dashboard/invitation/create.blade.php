<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Undangan') }}
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('invitation.create') }}" class="btn-sm inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                    Batal
                </a>

                <button type="button" onclick="document.getElementById('myForm').submit()" class="btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Errors -->
            @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="space-y-2">
                    @foreach ($errors->all() as $error)
                    <li class="text-red-700 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mx-auto p-6 bg-white rounded-xl">
                <!-- Main Tabs -->
                <div class="flex flex-wrap border-b border-gray-200 mb-6">
                    <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-blue-600 text-blue-600" data-tab="1">Data Dasar</button>
                    <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="2">Tema & Warna</button>
                    <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="3">Galeri Foto</button>
                    <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="4">Musik</button>
                    <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="5">RSVP</button>
                </div>

                <form method="POST" action="{{ route('invitation.store') }}" enctype="multipart/form-data" class="" id="myForm">
                    @csrf

                    <!-- Tabs Content -->
                    <div class="p-0 m-0">
                        <!-- Data Dasar -->
                        <div class="tab-content" data-content="1">
                            <div class="flex h-full bg-gray-100">

                                <!-- Sidebar Tabs -->
                                <div class="w-48 bg-white border-r p-4 text-left">
                                    <ul class="space-y-2 flex flex-col items-start">
                                        <li class="w-full">
                                            <button type="button" class="w-full text-left px-3 py-2 rounded hover:bg-gray-200 focus:bg-gray-200 tab-button active" data-tab="general">
                                                Mempelai Pria
                                            </button>
                                        </li>
                                        <li class="w-full">
                                            <button type="button" class="w-full text-left px-3 py-2 rounded hover:bg-gray-200 focus:bg-gray-200 tab-button" data-tab="bride">
                                                Mempelai Wanita
                                            </button>
                                        </li>
                                        <li class="w-full">
                                            <button type="button" class="w-full text-left px-3 py-2 rounded hover:bg-gray-200 focus:bg-gray-200 tab-button" data-tab="acara">
                                                Tempat & Tanggal
                                            </button>
                                        </li>
                                        <li class="w-full">
                                            <button type="button" class="w-full text-left px-3 py-2 rounded hover:bg-gray-200 focus:bg-gray-200 tab-button" data-tab="other">
                                                Lainnya
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Sidebar Content -->
                                <div class="flex-1 p-6 bg-gray-50">
                                    <!-- Data Mempelai Pria -->
                                    <div class="tab-content" id="general">
                                        <div class="flex gap-6">
                                            <!-- Kiri -->
                                            <div class="flex-1 flex flex-col gap-4">
                                                <div class="flex flex-col">
                                                    <label for="groom_name" class="mb-1 font-medium text-gray-700">Nama Mempelai Pria</label>
                                                    <input type="text" id="groom_name" name="groom_name"
                                                        value="{{ old('groom_name') }}"
                                                        placeholder="Masukkan nama mempelai pria"
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>

                                                <div class="flex flex-col">
                                                    <label for="groom_nickname" class="mb-1 font-medium text-gray-700">Nama Panggilan</label>
                                                    <input type="text" id="groom_nickname" name="groom_nickname"
                                                        value="{{ old('groom_nickname') }}"
                                                        placeholder="Masukkan nama panggilan"
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>

                                                <div class="flex flex-col">
                                                    <label for="groom_father_name" class="mb-1 font-medium text-gray-700">Nama Ayah Kandung</label>
                                                    <input type="text" id="groom_father_name" name="groom_father_name"
                                                        value="{{ old('groom_father_name') }}"
                                                        placeholder="Masukkan nama lengkap ayah"
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>

                                                <div class="flex flex-col">
                                                    <label for="groom_mother_name" class="mb-1 font-medium text-gray-700">Nama Ibu Kandung</label>
                                                    <input type="text" id="groom_mother_name" name="groom_mother_name"
                                                        value="{{ old('groom_mother_name') }}"
                                                        placeholder="Masukkan nama lengkap ibu"
                                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                            </div>


                                            <!-- Kanan -->
                                            <div class="flex-1 bg-green-100 p-6 rounded-lg">
                                                <!-- Upload Box -->
                                                <center>
                                                    <label class="font-medium text-gray-700">Foto Mempelai Pria</label>
                                                </center>
                                                <label id="uploadBoxGroom" for="foto_pria" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-green-400 hover:bg-green-50 transition duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M12 6v6" />
                                                    </svg>
                                                    <span class="text-gray-600">Klik atau tarik foto ke sini</span>
                                                    <input id="foto_pria" type="file" name="foto_pria" class="hidden" onchange="previewGroomImage(event)">
                                                </label>

                                                <!-- Preview & Delete Button -->
                                                <div id="previewContainerGroom" class="mt-4 hidden relative">
                                                    <img id="previewGroom" class="w-full max-h-60 object-cover rounded-lg" alt="Preview Foto">
                                                    <center>
                                                        <button type="button" onclick="removeGroomPreview()" class="mt-2 btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                            Hapus
                                                        </button>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Data Mempelai Wanita -->
                                    <div class="tab-content hidden" id="bride">
                                        <div class="flex gap-6">
                                            <div class="flex-1 flex flex-col gap-4">
                                                <div class="flex flex-col">
                                                    <label for="bride_name" class="mb-1 font-medium text-gray-700">Nama Mempelai Wanita</label>
                                                    <input type="text" id="bride_name" name="bride_name" placeholder="Masukkan nama mempelai wanita" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                                <div class="flex flex-col">
                                                    <label for="bride_nickname" class="mb-1 font-medium text-gray-700">Nama Panggilan</label>
                                                    <input type="text" id="bride_nickname" name="bride_nickname" placeholder="Masukkan nama panggilan mempelai wanita" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                                <div class="flex flex-col">
                                                    <label for="bride_father_name" class="mb-1 font-medium text-gray-700">Nama Ayah Kandung</label>
                                                    <input type="text" id="bride_father_name" name="bride_father_name" placeholder="Masukkan nama lengkap ayah kandung mempelai wanita" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                                <div class="flex flex-col">
                                                    <label for="bride_mother_name" class="mb-1 font-medium text-gray-700">Nama Ibu Kandung</label>
                                                    <input type="text" id="bride_mother_name" name="bride_mother_name" placeholder="Masukkan nama lengkap ibu kandung mempelai wanita" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                </div>
                                            </div>

                                            <!-- Kanan -->
                                            <div class="flex-1 bg-green-100 p-6 rounded-lg">
                                                <!-- Upload Box -->
                                                <center>
                                                    <label class="font-medium text-gray-700">Foto Mempelai Wanita</label>
                                                </center>
                                                <label id="uploadBoxBride" for="foto_wanita" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-green-400 hover:bg-green-50 transition duration-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M12 6v6" />
                                                    </svg>
                                                    <span class="text-gray-600">Klik atau tarik foto ke sini</span>
                                                    <input id="foto_wanita" type="file" name="foto_wanita" class="hidden" onchange="previewBrideImage(event)">
                                                </label>

                                                <!-- Preview & Delete Button -->
                                                <div id="previewContainerBride" class="mt-4 hidden relative">
                                                    <img id="previewBride" class="w-full max-h-60 object-cover rounded-lg" alt="Preview Foto">
                                                    <center>
                                                        <button type="button" onclick="removeBridePreview()" class="mt-2 btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                                            Hapus
                                                        </button>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tempat & Tanggal -->
                                    <div class="tab-content hidden" id="acara">
                                        <!-- Tanggal Acara -->
                                        <div class="flex flex-col mb-4">
                                            <label for="wedding_date" class="mb-2 font-semibold text-gray-700">Tanggal Pernikahan</label>
                                            <input type="date" id="wedding_date" name="wedding_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>

                                        <!-- Tempat Akad -->
                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2 border-b border-gray-200 pb-1">Tempat Akad</h3>

                                            <div class="flex flex-col mb-3">
                                                <label for="akad_location" class="mb-1 font-medium text-gray-700">Lokasi Acara</label>
                                                <input type="text" id="akad_location" name="akad_location" placeholder="Masukkan lokasi akad" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>

                                            <div class="flex flex-col">
                                                <label for="akad_time" class="mb-1 font-medium text-gray-700">Waktu Akad</label>
                                                <input type="time" id="akad_time" name="akad_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>

                                            <div class="flex flex-col mt-3">
                                                <label for="akad_maps" class="mb-1 font-medium text-gray-700">Link Maps</label>
                                                <input type="text" id="akad_maps" name="akad_maps" placeholder="Masukkan link Google Maps" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                        </div>

                                        <!-- Tempat Resepsi -->
                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2 border-b border-gray-200 pb-1">Tempat Resepsi</h3>

                                            <div class="flex flex-col mb-3">
                                                <label for="resepsi_location" class="mb-1 font-medium text-gray-700">Lokasi Acara</label>
                                                <input type="text" id="resepsi_location" name="resepsi_location" placeholder="Masukkan lokasi resepsi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>

                                            <div class="flex flex-col">
                                                <label for="resepsi_time" class="mb-1 font-medium text-gray-700">Waktu Resepsi</label>
                                                <input type="time" id="resepsi_time" name="resepsi_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>

                                            <div class="flex flex-col mt-3">
                                                <label for="resepsi_maps" class="mb-1 font-medium text-gray-700">Link Maps</label>
                                                <input type="text" id="resepsi_maps" name="resepsi_maps" placeholder="Masukkan link Google Maps" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lainnya -->
                                    <div class="tab-content hidden" id="other">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="flex flex-col">
                                                <label for="wedding_quote" class="mb-1 font-medium text-gray-700">Kutipan Pernikahan</label>
                                                <textarea id="wedding_quote" name="wedding_quote" rows="4" placeholder="Masukkan kutipan untuk undangan" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                            </div>

                                            <div class="flex flex-col">
                                                <label for="video_link" class="mb-1 font-medium text-gray-700">Link Video Pernikahan</label>
                                                <input type="text" id="video_link" name="video_link" placeholder="Masukkan link video YouTube" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>

                                            <div class="flex flex-col">
                                                <label for="love_story" class="mb-1 font-medium text-gray-700">Cerita Cinta</label>
                                                <textarea id="love_story" name="love_story" rows="4" placeholder="Ceritakan perjalanan cinta kalian" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tema & Warna -->
                        <div class="tab-content hidden" data-content="2">
                             <div class="flex flex-col mb-2">
                                                <label for="gallery_cover" class=" block text-sm font-semibold text-gray-900 mb-2">Cover Galeri</label>
                                                <input type="file" id="gallery_cover" name="gallery_cover" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            </div>
                            <div class="grid grid-cols-2 gap-4">

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Template</label>
                                    <select name="template_id" id="template_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                                        @foreach ($templates as $template)
                                        <option value="{{ $template->id }}" data-image="{{ $template->image }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>


                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Preview</label>
                                    {{-- <img id="template_preview" src="" alt="Template Preview" class="w-full h-48 object-cover border border-gray-300 rounded-lg"> --}}
                                   <div class="w-64 border border-gray-300 rounded-3xl overflow-y-auto mx-auto shadow-lg bg-black" style="aspect-ratio: 9/15;">
                                        <img src="{{ asset('tempelate/sample_preview.png') }}"
                                            alt="Template Preview"
                                            class="w-full h-auto object-none">
                                    </div>

                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Warna Tema</label>
                                <div class="flex flex-wrap gap-3">
                                    <!-- Contoh 1 -->
                                    <label class="relative flex items-center justify-center cursor-pointer">
                                        <input type="radio" name="theme_color" value="#1a365d" class="sr-only peer">
                                        <span class="w-8 h-8 rounded-full border-2 border-gray-300
                         peer-checked:border-blue-900
                         peer-checked:ring-2
                         peer-checked:ring-offset-1
                         transition-all hover:scale-110 relative" style="background-color: #1a365d;">
                                            <!-- Ceklis -->
                                            <svg class="w-5 h-5 text-white absolute opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </label>

                                    <!-- Contoh 2 -->
                                    <label class="relative flex items-center justify-center cursor-pointer">
                                        <input type="radio" name="theme_color" value="#b91c1c" class="sr-only peer">
                                        <span class="w-8 h-8 rounded-full border-2 border-gray-300
                         peer-checked:border-red-700
                         peer-checked:ring-2
                         peer-checked:ring-offset-1
                         transition-all hover:scale-110 relative" style="background-color: #b91c1c;">
                                            <svg class="w-5 h-5 text-white absolute opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </label>

                                    <!-- Contoh 3 -->
                                    <label class="relative flex items-center justify-center cursor-pointer">
                                        <input type="radio" name="theme_color" value="#166534" class="sr-only peer">
                                        <span class="w-8 h-8 rounded-full border-2 border-gray-300
                         peer-checked:border-green-700
                         peer-checked:ring-2
                         peer-checked:ring-offset-1
                         transition-all hover:scale-110 relative" style="background-color: #166534;">
                                            <svg class="w-5 h-5 text-white absolute opacity-0 peer-checked:opacity-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </label>

                                    <!-- Tambahkan warna lain dengan pola sama -->
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Galeri Foto -->
                    <div class="tab-content hidden" data-content="3">
                            <label for="gallery_cover" class=" block text-sm font-semibold text-gray-900 mb-2">Galeri Kisah</label>
                        <div class="flex flex-col md:flex-row gap-6">
                            <div id="gallery-dropzone" class="flex-1 px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition flex items-center justify-center text-center relative">
                                <p class="text-gray-600">Drag & drop gambar di sini atau klik untuk memilih</p>
                                <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="hidden">
                            </div>

                            <div id="gallery-preview" class="flex-1 flex overflow-x-auto gap-4 p-2 border rounded-lg bg-gray-50"></div>
                        </div>
                    </div>

                    <!-- Musik -->
                    <div class="tab-content hidden" data-content="4">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Lagu Background</label>
                                <select name="music_id" id="music_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                                    <option value="">-- Pilih Lagu --</option>
                                    @if(isset($music))
                                    @foreach ($music as $music)
                                    <option value="{{ $music->id }}">{{ $music->title }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Atur Volume</label>
                                <input type="range" name="music_volume" min="0" max="100" value="50" class="w-full">
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>0</span>
                                    <span>50</span>
                                    <span>100</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2">Upload Lagu Kustom</label>
                                <input type="file" name="custom_music" accept="audio/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- RSVP -->
                    <div class="tab-content hidden" data-content="5">
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" id="enable_rsvp" name="enable_rsvp" class="mr-2">
                                <label for="enable_rsvp" class="text-sm font-medium text-gray-700">Aktifkan RSVP</label>
                            </div>

                            <div id="rsvp_settings" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Batas Tanggal RSVP</label>
                                    <input type="date" name="rsvp_deadline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pesan Konfirmasi</label>
                                    <textarea name="rsvp_message" rows="4" placeholder="Terima kasih atas konfirmasi kehadiran Anda. Kami sangat menantikan kehadiran Anda di hari bahagia kami." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent"></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nomor WhatsApp untuk Notifikasi</label>
                                    <input type="text" name="rsvp_whatsapp" placeholder="6281234567890" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

        </div>
    </div>
    </div>

    <!-- Main Tabs Script -->
    <script>
        // Main tabs functionality
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content[data-content]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('border-blue-600', 'text-blue-600');
                    t.classList.add('border-transparent', 'text-gray-500');
                });
                contents.forEach(c => c.classList.add('hidden'));

                tab.classList.add('border-blue-600', 'text-blue-600');
                tab.classList.remove('border-transparent', 'text-gray-500');

                const tabId = tab.dataset.tab;
                document.querySelector(`.tab-content[data-content="${tabId}"]`).classList.remove('hidden');
            });
        });

        // Sidebar Tabs Script
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content[id]');

        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                tabButtons.forEach(b => b.classList.remove('active', 'bg-gray-200'));
                btn.classList.add('active', 'bg-gray-200');

                const target = btn.dataset.tab;
                tabContents.forEach(c => c.classList.add('hidden'));
                document.getElementById(target).classList.remove('hidden');
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
                dropzone.classList.add('bg-blue-50', 'border-blue-400');
            });
            dropzone.addEventListener('dragleave', () => {
                dropzone.classList.remove('bg-blue-50', 'border-blue-400');
            });
            dropzone.addEventListener('drop', e => {
                e.preventDefault();
                dropzone.classList.remove('bg-blue-50', 'border-blue-400');
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
                        imgContainer.className = 'flex-shrink-0 w-32 h-32 border border-gray-200 rounded-lg overflow-hidden relative';
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';
                        imgContainer.appendChild(img);

                        // Add delete button
                        const deleteBtn = document.createElement('button');
                        deleteBtn.type = 'button';
                        deleteBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center';
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
                previewContainer.classList.remove('hidden');

                // Sembunyikan upload box
                uploadBox.classList.add('hidden');
            }
        }

        function removeGroomPreview() {
            const preview = document.getElementById('previewGroom');
            const previewContainer = document.getElementById('previewContainerGroom');
            const uploadBox = document.getElementById('uploadBoxGroom');
            const inputFile = document.getElementById('foto_pria');

            // Hapus preview
            preview.src = '';
            previewContainer.classList.add('hidden');

            // Reset input file
            inputFile.value = '';

            // Tampilkan kembali upload box
            uploadBox.classList.remove('hidden');
        }

        // Image preview functions for bride
        function previewBrideImage(event) {
            const preview = document.getElementById('previewBride');
            const previewContainer = document.getElementById('previewContainerBride');
            const uploadBox = document.getElementById('uploadBoxBride');

            if (event.target.files && event.target.files[0]) {
                // Set src preview
                preview.src = URL.createObjectURL(event.target.files[0]);
                previewContainer.classList.remove('hidden');

                // Sembunyikan upload box
                uploadBox.classList.add('hidden');
            }
        }

        function removeBridePreview() {
            const preview = document.getElementById('previewBride');
            const previewContainer = document.getElementById('previewContainerBride');
            const uploadBox = document.getElementById('uploadBoxBride');
            const inputFile = document.getElementById('foto_wanita');

            // Hapus preview
            preview.src = '';
            previewContainer.classList.add('hidden');

            // Reset input file
            inputFile.value = '';

            // Tampilkan kembali upload box
            uploadBox.classList.remove('hidden');
        }

    </script>
</x-app-layout>

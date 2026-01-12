<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Undangan') }}
            </h2>
            <a href="{{ route('invitation.create') }}"
                class="btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Batal
            </a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-lg">
    <!-- Tabs -->
    <div class="flex flex-wrap border-b border-gray-200 mb-6">
        <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-blue-600 text-blue-600" data-tab="1">Data Dasar</button>
        <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="2">Tema & Warna</button>
        <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="3">Galeri Foto</button>
        <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="4">Musik</button>
        <button class="tab-btn px-4 py-2 -mb-px font-semibold border-b-2 border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600" data-tab="5">RSVP</button>
    </div>
   <form method="POST" action="{{ route('invitation.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
    <!-- Tabs Content -->
    <div>
        <!-- Data Dasar -->
        <div class="tab-content" data-content="1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <label for="bride_name" class="mb-1 font-medium text-gray-700">Nama Mempelai Wanita</label>
                    <input type="text" id="bride_name"  name="bride_name" placeholder="Masukkan nama mempelai wanita"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="flex flex-col">
                    <label for="groom_name" class="mb-1 font-medium text-gray-700">Nama Mempelai Pria</label>
                    <input type="text" id="groom_name"  name="groom_name" placeholder="Masukkan nama mempelai pria"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="flex flex-col">
                    <label for="wedding_date" class="mb-1 font-medium text-gray-700">Tanggal Pernikahan</label>
                    <input type="date" id="wedding_date"  name="wedding_date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="flex flex-col">
                    <label for="location" class="mb-1 font-medium text-gray-700">Lokasi Acara</label>
                    <input type="text" id="location" name="location" placeholder="Masukkan lokasi acara"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Tema & Warna -->
        <div class="tab-content hidden" data-content="2">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Template</label>
                <select name="template_id" id="template_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                    @foreach ($templates as $template)
                    <option value="{{ $template->id }}" data-image="{{ $template->image }}">{{ $template->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Preview</label>
                <img id="template_preview" src="" alt="Template Preview" class="w-full h-48 object-cover border border-gray-300 rounded-lg">
            </div>
        </div>

        <script>
        const templateSelect = document.getElementById('template_id');
        const templatePreview = document.getElementById('template_preview');

        templateSelect.addEventListener('change', () => {
            const selectedOption = templateSelect.options[templateSelect.selectedIndex];
            templatePreview.src = selectedOption.dataset.image;
        });

        // Load preview on page load
        templateSelect.dispatchEvent(new Event('change'));
        </script>
        </div>

        <!-- Galeri Foto -->
       <div class="tab-content hidden" data-content="3">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Dropzone -->
        <div id="gallery-dropzone"
             class="flex-1 px-4 py-6 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100 transition flex items-center justify-center text-center relative">
            <p class="text-gray-600">Drag & drop gambar di sini atau klik untuk memilih</p>
            <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="hidden">
        </div>

        <!-- Preview Horizontal Scroll -->
        <div id="gallery-preview" class="flex-1 flex overflow-x-auto gap-4 p-2 border rounded-lg bg-gray-50"></div>
    </div>

    <script>
    const dropzone = document.getElementById('gallery-dropzone');
    const fileInput = document.getElementById('gallery-input');
    const preview = document.getElementById('gallery-preview');

    dropzone.addEventListener('click', () => fileInput.click());

    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.classList.add('bg-blue-50', 'border-blue-400');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('bg-blue-50', 'border-blue-400');
    });

    dropzone.addEventListener('drop', (e) => {
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
            reader.onload = (e) => {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'flex-shrink-0 w-32 h-32 border border-gray-200 rounded-lg overflow-hidden';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';

                imgContainer.appendChild(img);
                preview.appendChild(imgContainer);
            };
            reader.readAsDataURL(file);
        });
    }
    </script>
</div>


        <!-- Musik -->
        <div class="tab-content hidden" data-content="4">
            <p class="text-gray-700">Pilih lagu background untuk undangan online.</p>
        </div>

        <!-- RSVP -->
        <div class="tab-content hidden" data-content="5">
            <p class="text-gray-700">Atur form RSVP dan pesan otomatis untuk tamu.</p>
        </div>
    </div>
</div>

<script>
const tabs = document.querySelectorAll('.tab-btn');
const contents = document.querySelectorAll('.tab-content');

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
</script>
<button class="mt-3 w-full btn-sm inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">simpan</button>
</form>
        </div>
        <form method="POST" action="{{ route('invitation.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Data Dasar -->
            <div class="space-y-4">


            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                <label for="bride_name" class="mb-1 text-gray-700 font-medium">Nama Mempelai Wanita</label>
                <input type="text" id="bride_name" name="bride_name" placeholder="Masukkan nama mempelai wanita"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <div class="flex flex-col">
                <label for="groom_name" class="mb-1 text-gray-700 font-medium">Nama Mempelai Pria</label>
                <input type="text" id="groom_name" name="groom_name" placeholder="Masukkan nama mempelai pria"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <div class="flex flex-col">
                <label for="wedding_date" class="mb-1 text-gray-700 font-medium">Tanggal Pernikahan</label>
                <input type="date" id="wedding_date" name="wedding_date"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>

                <div class="flex flex-col">
                <label for="location" class="mb-1 text-gray-700 font-medium">Lokasi Acara</label>
                <input type="text" id="location" name="location" placeholder="Masukkan lokasi acara"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                </div>
            </div>
            </div>

            <!-- Pilih Template -->
            <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">Template</label>
            <select name="template_id"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
                @foreach ($templates as $template)
                <option value="{{ $template->id }}">{{ $template->name }}</option>
                @endforeach
            </select>
            </div>

            <!-- Upload Music & Gallery -->
            <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Background Music</label>
                <input type="file" name="music" accept="audio/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">Galeri Foto</label>
                <input type="file" name="gallery[]" multiple accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent">
            </div>
            </div>

            <button type="submit"
            class="w-full bg-black text-white font-semibold py-3 rounded-lg hover:bg-gray-900 transition">
            Buat Undangan
            </button>
        </form>
        </div>
    </div>
</x-app-layout>

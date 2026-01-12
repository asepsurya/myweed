<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Template') }}
            </h2>

            <!-- Tabs -->
           <div class="flex space-x-4">
    <button id="tab-template" class="tab-btn flex items-center bg-blue-600 text-white px-4 py-2 rounded">
        <!-- Ikon Layout dari Tabler Icons -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout w-5 h-5 me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <rect x="4" y="4" width="6" height="5" rx="1"></rect>
            <rect x="14" y="4" width="6" height="5" rx="1"></rect>
            <rect x="4" y="14" width="6" height="5" rx="1"></rect>
            <rect x="14" y="14" width="6" height="5" rx="1"></rect>
        </svg>
        Template
    </button>

    <button id="tab-music" class="tab-btn flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded">
        <!-- Ikon Music dari Tabler Icons -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-music w-5 h-5 me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <circle cx="6" cy="17" r="3"></circle>
            <circle cx="18" cy="17" r="3"></circle>
            <path d="M9 17l0 -13l10 0l0 13"></path>
        </svg>
        Music
    </button>
</div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 bg-gray-100 min-h-screen">

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="space-y-2">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-700 text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Template Content -->
            <div id="content-template" class="tab-content">
                <div class="min-h-screen bg-gray-100 p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($tempelate as $template)
                            <div class="bg-white rounded-xl shadow hover:shadow-lg transition">
                                <img src="/storage/{{ $template->thumnail }}" class="w-full h-48 object-cover rounded-t-xl">
                                <div class="p-4">
                                    <h2 class="text-lg font-semibold">{{ $template->name }}</h2>
                                    <p class="text-sm text-gray-500">Slug: {{ $template->slug }}</p>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            Active
                                        </span>
                                        <a href="/templates/{{ $template->slug }}" class="text-sm text-blue-600 hover:underline">
                                            Preview
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Music Content -->
            <div id="content-music" class="tab-content hidden">
                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold">Wedding Music</h2>
                        <button onclick="openModal()" class="flex items-center gap-2 bg-black text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition">
                            <i class="ti ti-plus"></i> Tambah
                        </button>
                    </div>

                    @php
                        function fileUrl($path, $folder = '') {
                            if (!$path) return null;
                            return Str::startsWith($path, ['http://', 'https://'])
                                ? $path
                                : asset("storage/$folder/$path");
                        }
                    @endphp

                    @foreach ($musics as $music)
                        <div class="bg-white border-b p-4 flex items-center gap-4">

                            <!-- Cover -->
                            <img src="{{ $music->cover_url ? '/storage/'.$music->cover_url : asset('tempelate/no_sound.webp') }}"
                                 class="w-14 h-14 rounded-lg object-cover">

                            <!-- Info -->
                            <div class="flex-1">
                                <h3 class="font-semibold text-sm">{{ $music->title }}</h3>
                                <p class="text-xs text-gray-500">{{ $music->artist }}</p>

                                <!-- Tanggal / Frekuensi -->
                                <div class="text-xs text-gray-400 mt-1 flex gap-2">
                                    @if($music->release_date)
                                        <span>{{ \Carbon\Carbon::parse($music->release_date)->format('d M Y') }}</span>
                                    @endif
                                    @if($music->frequency)
                                        <span>{{ $music->frequency }} Hz</span>
                                    @endif
                                </div>

                                <div class="mt-2 flex items-center gap-2">
                                    <!-- Play Button -->
                                    <button onclick="toggleMusic('song{{ $music->id }}', this)" class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center">
                                        <svg class="play-icon w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                        <svg class="pause-icon w-4 h-4 hidden" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6 5h4v14H6zm8 0h4v14h-4z" />
                                        </svg>
                                    </button>

                                    <!-- Duration -->
                                    <span class="text-xs text-gray-500">{{ $music->duration }}</span>
                                </div>
                            </div>

                            <!-- Category + Actions -->
                            <div class="text-right flex flex-col items-end gap-1">
                                <p class="text-sm font-medium">{{ $music->category }}</p>
                                <p class="text-xs text-gray-500">{{ $music->mood }}</p>

                                <div class="flex items-center gap-2 mt-1">
                                    <!-- Download -->
                                    <a href="{{ fileUrl($music->audio_url) }}" download class="text-gray-700 hover:text-black">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 3v10.586l3.293-3.293 1.414 1.414L12 17.414l-4.707-4.707 1.414-1.414L11 13.586V3z" />
                                            <path d="M5 19h14v2H5z" />
                                        </svg>
                                    </a>

                                    <!-- Hapus -->
                                    <a href="javascript:void(0);" class="text-red-600 hover:text-red-800" onclick="confirmDelete({{ $music->id }})">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3 6h18v2H3V6zm2 3h14v12H5V9zm3 2v8h2v-8H8zm4 0v8h2v-8h-2z" />
                                        </svg>
                                    </a>

                                    <!-- Hidden Form -->
                                    <form id="delete-form-{{ $music->id }}" action="{{ route('music.destroy', $music->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>

                            <!-- Audio -->
                            <audio id="song{{ $music->id }}" src="{{ fileUrl($music->audio_url) }}"></audio>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Music -->
    <div id="musicModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Overlay -->
        <div onclick="closeModal()" class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300" id="modalOverlay"></div>

        <!-- Modal Box -->
        <div class="relative bg-white w-full max-w-md p-6 rounded-xl shadow-xl transform scale-95 opacity-0 transition-all duration-300" id="modalBox">
            <h3 class="text-lg font-semibold mb-4">Tambah Music</h3>

            <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="text-sm">Upload MP3</label>
                    <input type="file" name="file" required class="w-full border rounded p-2">
                </div>

                <div class="mb-3">
                    <label class="text-sm">Cover (Optional)</label>
                    <input type="file" name="cover" class="w-full border rounded p-2">
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded hover:bg-gray-100">
                        Batal
                    </button>
                    <button class="bg-black text-white px-4 py-2 rounded hover:bg-gray-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tabs
        const tabTemplate = document.getElementById('tab-template');
        const tabMusic = document.getElementById('tab-music');
        const contentTemplate = document.getElementById('content-template');
        const contentMusic = document.getElementById('content-music');

        tabTemplate.onclick = () => {
            tabTemplate.classList.add('bg-blue-600','text-white');
            tabTemplate.classList.remove('bg-gray-200','text-gray-700');
            tabMusic.classList.remove('bg-blue-600','text-white');
            tabMusic.classList.add('bg-gray-200','text-gray-700');
            contentTemplate.classList.remove('hidden');
            contentMusic.classList.add('hidden');
        };

        tabMusic.onclick = () => {
            tabMusic.classList.add('bg-blue-600','text-white');
            tabMusic.classList.remove('bg-gray-200','text-gray-700');
            tabTemplate.classList.remove('bg-blue-600','text-white');
            tabTemplate.classList.add('bg-gray-200','text-gray-700');
            contentMusic.classList.remove('hidden');
            contentTemplate.classList.add('hidden');
        };

        // Play/Pause Music
        function toggleMusic(id, btn){
            const audio = document.getElementById(id);
            const playIcon = btn.querySelector('.play-icon');
            const pauseIcon = btn.querySelector('.pause-icon');

            document.querySelectorAll('audio').forEach(a=>{
                if(a!==audio){
                    a.pause();
                    a.currentTime=0;
                }
            });

            if(audio.paused){
                audio.play();
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
            } else {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            }
        }

        // Modal
        function openModal(){
            const modal = document.getElementById('musicModal');
            const overlay = document.getElementById('modalOverlay');
            const box = document.getElementById('modalBox');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(()=>{
                overlay.classList.remove('opacity-0');
                box.classList.remove('opacity-0','scale-95');
                box.classList.add('opacity-100','scale-100');
            },10);
        }

        function closeModal(){
            const modal = document.getElementById('musicModal');
            const overlay = document.getElementById('modalOverlay');
            const box = document.getElementById('modalBox');

            overlay.classList.add('opacity-0');
            box.classList.add('opacity-0','scale-95');

            setTimeout(()=>{
                modal.classList.add('hidden');
            },300);
        }

        // SweetAlert Delete
        function confirmDelete(id){
            Swal.fire({
                title: 'Yakin ingin menghapus lagu ini?',
                text: "Data akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result)=>{
                if(result.isConfirmed){
                    document.getElementById('delete-form-'+id).submit();
                }
            });
        }
    </script>
</x-app-layout>

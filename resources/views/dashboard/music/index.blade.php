<x-app-layout>
    <div class="card shadow-sm ">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center p-4">
            <h5 class="fw-bold m-0">Wedding Music</h5>
            <!-- Menggunakan data-bs-toggle standar Bootstrap -->
            <button type="button" data-bs-toggle="modal" data-bs-target="#musicModal" class="btn btn-dark btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Tambah
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

        <div class="list-group list-group-flush">
        @forelse ($musics as $music)
            <div class="list-group-item  d-flex align-items-center gap-3">
                <!-- Cover Image -->
                <img src="{{ $music->cover_url ? '/storage/'.$music->cover_url : asset('tempelate/no_sound.webp') }}"
                     class="rounded border object-fit-cover"
                     style="width: 56px; height: 56px;"
                     alt="cover">

                <!-- Info Lagu -->
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-1">{{ $music->title }}</h6>
                    <p class="small text-muted mb-1">{{ $music->artist }}</p>

                    <!-- Tanggal / Frekuensi -->
                    <div class="small text-secondary mb-2">
                        @if($music->release_date)
                        <span>{{ \Carbon\Carbon::parse($music->release_date)->format('d M Y') }}</span>
                        @endif
                        @if($music->frequency)
                        <span class="ms-2">{{ $music->frequency }} Hz</span>
                        @endif
                    </div>

                    <!-- Play Button Area -->
                    <div class="d-flex align-items-center gap-2">
                        <button onclick="toggleMusic('song{{ $music->id }}', this)"
                                class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center p-0"
                                style="width: 32px; height: 32px;">
                            <svg class="play-icon" style="width: 14px; height: 14px; fill: white;" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                            <svg class="pause-icon d-none" style="width: 14px; height: 14px; fill: white;" viewBox="0 0 24 24">
                                <path d="M6 5h4v14H6zm8 0h4v14h-4z" />
                            </svg>
                        </button>
                        <span class="small text-muted">{{ $music->duration }}</span>
                    </div>
                </div>

                <!-- Category & Actions (Right Side) -->
                <div class="text-end d-flex flex-column align-items-end gap-1">
                    <span class="fw-medium small">{{ $music->category }}</span>
                    <span class="text-muted small">{{ $music->mood }}</span>

                    <div class="d-flex align-items-center gap-2 mt-1">
                        <!-- Download -->
                        <a href="{{ fileUrl($music->audio_url) }}" download class="text-secondary text-decoration-none">
                            <i class="bi bi-download fs-5"></i>
                        </a>

                        <!-- Hapus -->
                        <a href="javascript:void(0);" class="text-danger text-decoration-none" onclick="confirmDelete({{ $music->id }})">
                            <i class="bi bi-trash fs-5"></i>
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
            @empty
           <div class="flex items-center justify-center min-h-[60vh] p-5 list-none">
    <div class="text-center">

        <!-- Icon -->
        <div class="flex items-center justify-center w-14 h-14 mx-auto mb-3 rounded-full bg-gray-100">
            <i class="bi bi-music-note-list text-2xl text-gray-400"></i>
        </div>

        <!-- Text -->
        <h3 class="text-base font-semibold text-gray-700">
            Belum ada musik
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            Tambahkan musik agar undangan lebih berkesan
        </p>

        <!-- Button -->
       
    </div>
</div>

        @endforelse
        </div>
    </div>

    <!-- Modal Tambah Music (Bootstrap 5 Standard) -->
    <div class="modal fade" id="musicModal" tabindex="-1" aria-labelledby="musicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="musicModalLabel">Tambah Music</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="musicFile" class="form-label fw-medium">Upload MP3</label>
                            <input type="file" name="file" id="musicFile" class="form-control" required accept="audio/*">
                        </div>

                        <div class="mb-3">
                            <label for="musicCover" class="form-label fw-medium">Cover (Optional)</label>
                            <input type="file" name="cover" id="musicCover" class="form-control" accept="image/*">
                            <div class="form-text">Maksimal ukuran file 2MB.</div>
                        </div>

                        <!-- Modal Footer Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light text-secondary fw-medium" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-dark">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap JS Logic -->
    <script>
        // --- Logika Music Player (Anda sudah punya ini, dipertahankan) ---
        function toggleMusic(id, btn) {
            const audio = document.getElementById(id);
            const playIcon = btn.querySelector('.play-icon');
            const pauseIcon = btn.querySelector('.pause-icon');

            // Stop semua musik lain (opsional, agar tidak berdengung)
            document.querySelectorAll('audio').forEach(el => {
                if(el !== audio) {
                    el.pause();
                    // Reset icon tombol lain disini jika perlu
                }
            });

            if (audio.paused) {
                audio.play();
                playIcon.classList.add('d-none');
                pauseIcon.classList.remove('d-none');
            } else {
                audio.pause();
                playIcon.classList.remove('d-none');
                pauseIcon.classList.add('d-none');
            }
        }

        // --- Logika Delete (Anda sudah punya ini, dipertahankan) ---
        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus musik ini?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
</x-app-layout>

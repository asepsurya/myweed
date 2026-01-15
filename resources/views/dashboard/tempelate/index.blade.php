<x-app-layout>
    <style>
        .template-preview {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .preview-img {
            width: 100%;
            height: auto;
            /* gambar panjang */
            transform: translateY(0);
            transition: transform 6s linear;
        }

        /* saat hover */
        .template-preview:hover .preview-img {
            transform: translateY(calc(-100% + 200px));
        }

        .preview-img {
            transition: transform 7s ease-in-out;
        }
    </style>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">
                {{ __('Template') }}
            </h2>

            <!-- Tabs (Buttons) -->
            <div class="d-flex gap-2">
                <button id="tab-template" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                    <!-- Ikon Layout -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="4" width="6" height="5" rx="1"></rect>
                        <rect x="14" y="4" width="6" height="5" rx="1"></rect>
                        <rect x="4" y="14" width="6" height="5" rx="1"></rect>
                        <rect x="14" y="14" width="6" height="5" rx="1"></rect>
                    </svg>
                    Template
                </button>

                <button id="tab-music" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-2">
                    <!-- Ikon Music -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="6" cy="17" r="3"></circle>
                        <circle cx="18" cy="17" r="3"></circle>
                        <path d="M9 17l0 -13l10 0l0 13"></path>
                    </svg>
                    Music
                </button>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content Wrapper -->
        <div class="card adminuiux-card p-4 rounded shadow-sm border">

            <!-- Template Content Area -->
            <div id="content-template" class="tab-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold">My Templates</h4>
                    <!-- Trigger Modal Bootstrap -->
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modaltemplate"
                        class="btn btn-dark d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>
                </div>

                <!-- Grid Layout Bootstrap -->
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($tempelate as $template)
                        <div class="col">
                            <!-- Card Component -->
                            <div class="card h-100 shadow-sm border-0 position-relative">

                                <!-- Tombol Hapus Absolute -->
                                <button onclick="confirmDelete({{ $template->id }})"
                                    class="position-absolute top-50 end-0 translate-middle-y z-1
                                btn btn-danger btn-sm rounded-circle shadow d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                        <path fill-rule="evenodd"
                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                    </svg>
                                </button>

                                <!-- Hidden Form -->
                                <form id="delete-form-{{ $template->id }}"
                                    action="{{ route('templates.destroy', $template->id) }}" method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <!-- Image -->
                                <div class="template-preview">
                                    <img src="/storage/{{ $template->thumbnail }}" alt="Template" class="preview-img">
                                </div>


                                <!-- Body -->
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $template->name }}</h5>
                                    <p class="card-text small text-muted">Slug: {{ $template->slug }}</p>

                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="badge bg-success bg-opacity-10 text-success">Active</span>

                                        <a href="/templates/{{ $template->slug }}"
                                            class="btn btn-sm btn-link text-decoration-none p-0 fw-bold">
                                            Preview
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Music Content Area (Dummy placeholder as per original code structure) -->
            <div id="content-music" class="tab-content d-none">
                <!-- Paste Music Content here -->
                <div class="text-center text-muted py-5">
                    <p>Konten Music akan tampil di sini.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap Modal Structure -->
    <div class="modal fade" id="modaltemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Upload Template Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="/templates/upload" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <!-- Nama Template -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Template</label>
                            <input type="text" name="name" placeholder="Contoh: Love Theme"
                                class="form-control" id="name">
                        </div>

                        <!-- Thumbnail -->
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label fw-semibold">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" id="thumbnail">
                        </div>

                        <!-- ZIP File -->
                        <div class="mb-3">
                            <label for="zip" class="form-label fw-semibold">File ZIP Template</label>
                            <input type="file" name="zip" accept=".zip" class="form-control"
                                id="zip">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload Template</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Logika Tab
        const tabTemplate = document.getElementById('tab-template');
        const tabMusic = document.getElementById('tab-music');
        const contentTemplate = document.getElementById('content-template');
        const contentMusic = document.getElementById('content-music');

        tabTemplate.onclick = () => {
            // Style Active Button
            tabTemplate.classList.add('btn-primary');
            tabTemplate.classList.remove('btn-outline-secondary');
            tabMusic.classList.remove('btn-primary');
            tabMusic.classList.add('btn-outline-secondary');

            // Toggle Content (Menggunakan d-none Bootstrap)
            contentTemplate.classList.remove('d-none');
            contentMusic.classList.add('d-none');
        };

        tabMusic.onclick = () => {
            // Style Active Button
            tabMusic.classList.add('btn-primary');
            tabMusic.classList.remove('btn-outline-secondary');
            tabTemplate.classList.remove('btn-primary');
            tabTemplate.classList.add('btn-outline-secondary');

            // Toggle Content
            contentMusic.classList.remove('d-none');
            contentTemplate.classList.add('d-none');
        };

        // SweetAlert Delete
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus ini?',
                text: "Data akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
</x-app-layout>

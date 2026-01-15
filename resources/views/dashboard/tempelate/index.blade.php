<x-app-layout>

    <style>
        .template-preview {
            height: 220px;
            overflow: hidden;
            position: relative;
            border-radius: 12px;
        }

        .preview-img {
            width: 100%;
            height: auto;
            transform: translateY(0);
            transition: transform 6s linear;
        }

        .template-preview:hover .preview-img {
            transform: translateY(calc(-100% + 220px));
        }

    </style>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark m-0">Template Manager</h2>

            <div class="d-flex gap-2">
                <button id="tab-template" class="btn btn-primary btn-sm">
                    <i class="bi bi-grid-3x3-gap"></i> Template
                </button>

                <button id="tab-music" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-music-note-beamed"></i> Music
                </button>
            </div>
        </div>
    </x-slot>

    <div class="container mt-4" id="main-content">

        <!-- HERO / WELCOME -->
        <div class="row align-items-center py-4">
            <div class="col-12 col-lg-6 col-xxl-8">
                <h3 class="fw-normal mb-0 text-secondary">Let's explore best</h3>
                <h1 class="mb-4">Wedding Invitation Templates</h1>

                <div class="row align-items-center">
                    <div class="col-12 col-md-11 col-xxl-8 mb-4">
                        <div class="input-group">
                            <input id="templateSearch" class="form-control border-end-0" type="text" placeholder="Search template...">
                            <button class="btn btn-lg btn-theme btn-square">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="row">
                            <div class="col-auto theme-green mb-4">
                                <span class="avatar avatar-40 rounded border-theme-1 border text-theme-1">
                                    <i class="bi bi-person-check h5"></i>
                                </span>
                            </div>
                            <div class="col-auto theme-green mb-4">
                                <p class="text-theme-1 small">Professional<br>Designs</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="row">
                            <div class="col-auto theme-green mb-4">
                                <span class="avatar avatar-40 rounded border-theme-1 border text-theme-1">
                                    <i class="bi bi-person-check h5"></i>
                                </span>
                            </div>
                            <div class="col-auto theme-green mb-4">
                                <p class="text-theme-1 small">100+ Best professionals<br>for your support </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="row">
                            <div class="col-auto theme-purple mb-4">
                                <span class="avatar avatar-40 rounded border-theme-1 border text-theme-1">
                                    <i class="bi bi-shield-check h5"></i>
                                </span>
                            </div>
                            <div class="col-auto theme-purple mb-4">
                                <p class="text-theme-1 small">We have Quick, Easy<br> and Trusted partners</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- PROMO CARD -->
            <div class="col-12 col-lg-6 col-xl-4 mb-4">
                <div class="card adminuiux-card position-relative overflow-hidden bg-theme-1 text-white">
                    <div class="card-body">
                        <h2>New Templates!</h2>
                        <h4 class="fw-medium">Modern & Elegant Wedding Themes</h4>
                        <p class="mb-4">Update your invitation with premium design</p>
                        <button class="btn btn-light my-1">Explore Now</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TEMPLATE CONTENT -->
        <div id="content-template">
            <div class="col-12">
                <div class="row mb-2">

                    <!-- Jawa -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=jawa" class="card adminuiux-card style-none text-center h-100">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 h3 bi bi-flower1 mb-3"></i>
                                <p class="text-secondary small">Adat Jawa</p>
                            </div>
                        </a>
                    </div>

                    <!-- Sunda -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=sunda" class="card adminuiux-card style-none text-center h-100">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-music-note-beamed h3 mb-3"></i>
                                <p class="text-secondary small">Adat Sunda</p>
                            </div>
                        </a>
                    </div>

                    <!-- Minang -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=minang" class="card adminuiux-card style-none text-center h-100">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-house-door h3 mb-3"></i>
                                <p class="text-secondary small">Adat Minangkabau</p>
                            </div>
                        </a>
                    </div>

                    <!-- Batak -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=batak" class="card adminuiux-card style-none text-center h-100">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-dribbble h3 mb-3"></i>
                                <p class="text-secondary small">Adat Batak</p>
                            </div>
                        </a>
                    </div>

                    <!-- Bugis -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=bugis" class="card adminuiux-card style-none text-center h-100">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-compass h3 mb-3"></i>
                                <p class="text-secondary small">Adat Bugis</p>
                            </div>
                        </a>
                    </div>

                    <!-- Bali -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=bali" class="card adminuiux-card style-none text-center">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-sun h3 mb-3"></i>
                                <p class="text-secondary small">Adat Bali</p>
                            </div>
                        </a>
                    </div>

                    <!-- Betawi -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=betawi" class="card adminuiux-card style-none text-center h-100">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-people h3 mb-3"></i>
                                <p class="text-secondary small">Adat Betawi</p>
                            </div>
                        </a>
                    </div>

                    <!-- Modern -->
                    <div class="col-6 col-md-3 col-lg-3 col-xl-3 col-xxl mb-3">
                        <a href="/templates?kategori=modern" class="card adminuiux-card style-none text-center">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-stars h3 mb-3"></i>
                                <p class="text-secondary small">Modern / Universal</p>
                            </div>
                        </a>
                    </div>

                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-medium">My Templates</h5>

                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modaltemplate">
                    <i class="bi bi-plus-lg"></i> Add Template
                </button>
            </div>

            <div class="row">
                @foreach ($tempelate as $template)
                <div class="col-12 col-md-6 col-lg-4 template-card" data-name="{{ strtolower($template->name) }}">
                    <div class="card adminuiux-card mb-4 position-relative">

                        <!-- DELETE BUTTON -->
                        <button onclick="confirmDelete({{ $template->id }})" class="position-absolute top-0 end-0 m-2 btn btn-danger btn-sm rounded-circle">
                            <i class="bi bi-trash"></i>
                        </button>

                        <form id="delete-form-{{ $template->id }}" action="{{ route('templates.destroy', $template->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>

                        <!-- PREVIEW -->
                        <div class="template-preview">
                            <img src="/storage/{{ $template->thumbnail }}" class="preview-img">
                        </div>

                        <!-- INFO -->
                        <div class="card-body">
                            <h5 class="fw-medium mb-1">{{ $template->name }}</h5>
                            <p class="text-secondary small">Slug: {{ $template->slug }}</p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge text-bg-success">Active</span>

                                <a href="/templates/{{ $template->slug }}" class="btn btn-sm btn-outline-theme">
                                    Preview
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
                <div id="noResult" class="text-center text-muted mt-4 d-none">
                    <i class="bi bi-search fs-1 d-block mb-2"></i>
                    <p class="fw-semibold">Template tidak ditemukan</p>
                    <small>Coba kata kunci lain</small>
                </div>
            </div>

        </div>

        <!-- MUSIC TAB -->
        <div id="content-music" class="d-none">
            <div class="text-center py-5 text-muted">
                <h5>Music Manager</h5>
                <p>Coming Soon...</p>
            </div>
        </div>

    </div>

    <!-- MODAL UPLOAD -->
    <div class="modal fade" id="modaltemplate" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Upload New Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="/templates/upload" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Template Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">ZIP File</label>
                            <input type="file" name="zip" accept=".zip" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const tabTemplate = document.getElementById('tab-template');
        const tabMusic = document.getElementById('tab-music');
        const contentTemplate = document.getElementById('content-template');
        const contentMusic = document.getElementById('content-music');

        tabTemplate.onclick = () => {
            tabTemplate.classList.add('btn-primary');
            tabTemplate.classList.remove('btn-outline-secondary');
            tabMusic.classList.remove('btn-primary');
            tabMusic.classList.add('btn-outline-secondary');

            contentTemplate.classList.remove('d-none');
            contentMusic.classList.add('d-none');
        };

        tabMusic.onclick = () => {
            tabMusic.classList.add('btn-primary');
            tabMusic.classList.remove('btn-outline-secondary');
            tabTemplate.classList.remove('btn-primary');
            tabTemplate.classList.add('btn-outline-secondary');

            contentMusic.classList.remove('d-none');
            contentTemplate.classList.add('d-none');
        };

        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete this template?'
                , text: "This action cannot be undone!"
                , icon: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#d33'
                , confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

    </script>

</x-app-layout>
<script>
    const searchInput = document.getElementById('templateSearch');
    const noResult = document.getElementById('noResult');

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.template-card');

        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');

            if (name.includes(term)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Jika tidak ada hasil
        if (visibleCount === 0) {
            noResult.classList.remove('d-none');
        } else {
            noResult.classList.add('d-none');
        }
    });

</script>

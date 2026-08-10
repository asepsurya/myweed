<x-app-layout>

    <style>
        .adminuiux-card {
            position: relative;
            overflow: hidden;
            /* optional, biar rapi */
        }

        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .delete-btn {
            z-index: 20;
        }

        .template-preview {
            position: relative;
            z-index: 1;
        }

        .preview-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }


        .kategori-scroll {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .kategori-scroll::-webkit-scrollbar {
            display: none;
        }

        .border-dashed {
            border-style: dashed !important;
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
                <div class="row flex-nowrap flex-md-wrap overflow-auto mb-2 kategori-scroll">
                    @foreach ($categories as $cat)
                    <div class="col-8 col-sm-6 col-md-3 mb-3">
                        <a href="javascript:void(0)" onclick="filterCategory('{{ $cat->slug }}')" class="card adminuiux-card category-filter style-none text-center h-100" data-category="{{ $cat->slug }}">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi {{ $cat->icon ?? 'bi-folder' }} h3 mb-3"></i>
                                <p class="text-secondary small mb-0">{{ $cat->name }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach

                    <div class="col-8 col-sm-6 col-md-3 mb-3">
                        <a href="javascript:void(0)" onclick="openCategoryModal()" class="card adminuiux-card category-filter style-none text-center h-100 border-dashed">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-plus-circle h3 mb-3"></i>
                                <p class="text-secondary small mb-0">Manage Categories</p>
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
            @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="row">
                @foreach ($tempelate as $template)
                <div class="col-6 col-md-6 col-lg-4 template-card" data-name="{{ strtolower($template->name) }}" data-category="{{ $template->category->slug ?? '' }}">

                    <div class="card adminuiux-card mb-4 position-relative">

                        <form id="delete-form-{{ $template->id }}" action="{{ route('templates.destroy', $template->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>

                        <!-- PREVIEW -->
                        <div class="template-preview">
                            <img src="{{ $template->thumbnail ? asset('storage/' . $template->thumbnail) : 'https://placehold.co/600x450?text=No+Thumbnail' }}" class="preview-img img-fluid">
                        </div>

                        <!-- INFO -->
                        <div class="card-body p-3">
                            <h6 class="fw-medium mb-1 text-truncate">
                                {{ $template->name }}
                            </h6>

                            <p class="text-secondary small mb-2 text-truncate">
                                Slug: {{ $template->slug }}
                            </p>

                          <div class="d-flex justify-content-between align-items-center">
                                <span class="badge text-bg-success">Active</span>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('template.preview', ['romeo-juliet',$template->id]) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <button type="button"
                                            onclick="confirmDelete({{ $template->id }})"
                                            class="btn btn-sm btn-outline-theme">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
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

    <!-- MODAL MANAGE CATEGORIES -->
    <div class="modal fade" id="modalCategory" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Manage Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" class="mb-3">
                        <div class="input-group">
                            <input type="text" id="categoryName" class="form-control" placeholder="New category name..." required>
                            <select id="categoryIcon" class="form-select" style="max-width: 150px;">
                                <option value="bi-folder">Folder</option>
                                <option value="bi-heart">Heart</option>
                                <option value="bi-baby">Baby</option>
                                <option value="bi-cake">Cake</option>
                                <option value="bi-mortarboard">Graduation</option>
                                <option value="bi-tree">Tree</option>
                                <option value="bi-music-note-beamed">Music</option>
                                <option value="bi-stars">Stars</option>
                                <option value="bi-house-door">House</option>
                                <option value="bi-sun">Sun</option>
                                <option value="bi-people">People</option>
                                <option value="bi-shield-check">Shield</option>
                                <option value="bi-flower1">Flower</option>
                            </select>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-plus-lg"></i> Add
                            </button>
                        </div>
                    </form>

                    <div class="list-group" id="categoryList">
                        @foreach ($categories as $cat)
                        <div class="list-group-item d-flex justify-content-between align-items-center category-item" data-id="{{ $cat->id }}" data-slug="{{ $cat->slug }}">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $cat->icon ?? 'bi-folder' }} text-theme-1"></i>
                                <span>{{ $cat->name }}</span>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-category" data-id="{{ $cat->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <div id="noCategoryResult" class="text-center text-muted mt-3 d-none">
                        <p class="mb-0">No categories yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UPLOAD -->
    <div class="modal fade" id="modaltemplate" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Upload New Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <ul class="nav nav-tabs mb-3" id="uploadTemplateTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="zip-tab" data-bs-toggle="tab" data-bs-target="#zip-panel" type="button" role="tab">Upload ZIP</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="code-tab" data-bs-toggle="tab" data-bs-target="#code-panel" type="button" role="tab">Import Code</button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        {{-- ZIP Upload --}}
                        <div class="tab-pane fade show active" id="zip-panel" role="tabpanel">
                            <form action="/templates/upload" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Category</label>
                                    <select name="id_category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Template Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Thumbnail</label>
                                    <input type="file" name="thumbnail" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Image Preview</label>
                                    <input type="file" name="preview" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">ZIP File</label>
                                    <input type="file" name="zip" accept=".zip" class="form-control" required>
                                </div>

                                <div class="modal-footer px-0 pb-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </form>
                        </div>

                        {{-- Code Import --}}
                        <div class="tab-pane fade" id="code-panel" role="tabpanel">
                            <form action="/templates/import-code" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Category</label>
                                    <select name="id_category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Template Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Template Slug</label>
                                    <input type="text" name="slug" class="form-control" required>
                                    <div class="form-text">Contoh: love-theme, elegant-theme</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Blade Code</label>
                                    <textarea name="code" class="form-control font-monospace" rows="12" required placeholder="Paste kode Blade di sini..."></textarea>
                                </div>

                                <div class="modal-footer px-0 pb-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Import Template</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">    </script>

    <script>
        const categories = @json($categories);

        window.openCategoryModal = function() {
            const modal = new bootstrap.Modal(document.getElementById('modalCategory'));
            modal.show();
        }

        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const nameInput = document.getElementById('categoryName');
            const iconInput = document.getElementById('categoryIcon');
            const name = nameInput.value.trim();
            const icon = iconInput.value;

            if (!name) return;

            fetch('{{ route('categories.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, icon })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    nameInput.value = '';
                    const list = document.getElementById('categoryList');
                    const item = document.createElement('div');
                    item.className = 'list-group-item d-flex justify-content-between align-items-center category-item';
                    item.dataset.id = data.category.id;
                    item.dataset.slug = data.category.slug;
                    item.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi ${icon} text-theme-1"></i>
                            <span>${name}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-category" data-id="${data.category.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                    list.appendChild(item);

                    const filterContainer = document.querySelector('#content-template .kategori-scroll');
                    const col = document.createElement('div');
                    col.className = 'col-8 col-sm-6 col-md-3 mb-3';
                    col.innerHTML = `
                        <a href="javascript:void(0)" onclick="filterCategory('${data.category.slug}')" class="card adminuiux-card category-filter style-none text-center h-100" data-category="${data.category.slug}">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi ${icon} h3 mb-3"></i>
                                <p class="text-secondary small mb-0">${name}</p>
                            </div>
                        </a>
                    `;
                    filterContainer.insertBefore(col, filterContainer.lastElementChild);

                    const selectOptions = document.querySelectorAll('select[name="category"]');
                    selectOptions.forEach(select => {
                        const option = document.createElement('option');
                        option.value = name;
                        option.textContent = name;
                        select.appendChild(option);
                    });

                    bindDeleteCategory();
                }
            })
            .catch(err => {
                Swal.fire({ icon: 'error', title: 'Gagal', text: err.responseJSON?.message || 'Terjadi kesalahan' });
            });
        });

        function bindDeleteCategory() {
            document.querySelectorAll('.btn-delete-category').forEach(btn => {
                btn.onclick = function() {
                    const id = this.dataset.id;
                    const item = this.closest('.category-item');
                    const card = document.querySelector(`.category-filter[data-category="${item.dataset.slug}"]`)?.closest('.col-8, .col-sm-6, .col-md-3');

                    Swal.fire({
                        title: 'Delete this category?',
                        text: "Templates in this category will not be deleted.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/categories/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    item.remove();
                                    if (card) card.remove();
                                    const selectOptions = document.querySelectorAll('select[name="category"]');
                                    selectOptions.forEach(select => {
                                        const opts = select.querySelectorAll('option');
                                        opts.forEach(opt => {
                                            if (opt.value === item.querySelector('span').textContent) opt.remove();
                                        });
                                    });
                                } else {
                                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                                }
                            });
                        }
                    });
                };
            });
        }

        bindDeleteCategory();

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
    let activeCategory = 'all';

    function filterTemplates() {
        const term = searchInput.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.template-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const category = card.getAttribute('data-category');

            const matchesSearch = name.includes(term);
            const matchesCategory = (activeCategory === 'all' || category === activeCategory);

            if (matchesSearch && matchesCategory) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noResult.classList.remove('d-none');
        } else {
            noResult.classList.add('d-none');
        }
    }

    window.filterCategory = function(cat) {
        // Toggle category
        if (activeCategory === cat) {
            activeCategory = 'all';
            document.querySelectorAll('.category-filter').forEach(el => el.classList.remove('border-primary', 'bg-light'));
        } else {
            activeCategory = cat;
            document.querySelectorAll('.category-filter').forEach(el => el.classList.remove('border-primary', 'bg-light'));
            document.querySelector(`.category-filter[data-category="${cat}"]`).classList.add('border-primary', 'bg-light');
        }
        filterTemplates();
    }

    searchInput.addEventListener('input', filterTemplates);

</script>


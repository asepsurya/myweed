<x-app-layout>

    @php
        // Map tipe template -> kategori paling umum (berdasarkan template yang sudah ada)
        $typeCatCounts = [];
        foreach ($tempelate as $tpl) {
            if ($tpl->templateType && $tpl->category) {
                $typeCatCounts[$tpl->template_type_id][$tpl->id_category] =
                    ($typeCatCounts[$tpl->template_type_id][$tpl->id_category] ?? 0) + 1;
            }
        }
        $typeCategoryMap = [];
        foreach ($typeCatCounts as $typeId => $cats) {
            arsort($cats);
            $typeCategoryMap[$typeId] = array_key_first($cats);
        }
    @endphp

    <style>
        .adminuiux-card {
            position: relative;
            overflow: hidden;
        }

        .preview-img {
            width: 100%;
            height: 220px;
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

        .kategori-scroll {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            scroll-snap-type: x mandatory;
            
        }

        .kategori-scroll::-webkit-scrollbar {
            display: none;
        }

        .kategori-scroll .category-filter {
            scroll-snap-align: start;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        .type-badge-card {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 4px;
            color: #fff;
            pointer-events: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        }

        .type-filter-bar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .4rem;
        }

        .type-filter {
            cursor: pointer;
            user-select: none;
            opacity: .65;
            border: 1px solid transparent;
            transition: opacity .15s ease, box-shadow .15s ease;
        }

        .type-filter:hover {
            opacity: 1;
        }

        .type-filter.active {
            opacity: 1;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px rgba(27, 42, 74, .55);
        }

        /* CodeMirror */
        .CodeMirror {
            height: 100% !important;
            font-family: 'Courier New', monospace !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
            background-color: #1e1e1e !important;
            color: #d4d4d4 !important;
            border-radius: 0 !important;
        }

        .CodeMirror-scroll {
            max-height: 100% !important;
            overflow-y: auto !important;
        }

        /* Modal structure */
        #editCodeModal .modal-content {
            display: flex;
            flex-direction: column;
            height: 92vh;
            overflow: hidden;
        }

        #editCodeModal .modal-header {
            flex-shrink: 0;
        }

        #editCodeModal .modal-body {
            flex: 1 1 auto;
            min-height: 0;
            overflow: hidden;
            padding: 0;
        }

        #editCodeModal .modal-body>.row {
            height: 100%;
            min-height: 0;
            display: flex;
        }

        #editCodeModal .info-panel {
            height: 100%;
            overflow-y: auto;
            position: sticky;
            top: 0;
        }

        #editCodeModal .code-panel {
            height: 100%;
            overflow-y: auto;
            background-color: #1e1e1e;
        }

        #codeSearchInput {
            font-size: 13px;
            border-radius: 6px;
        }

        #editCodeModal+.modal-backdrop {
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            background-color: rgba(0, 0, 0, 0.6);
        }

        /* =============================================
           MOBILE IMPROVEMENTS
        ============================================= */
        @media (max-width: 767.98px) {
            .preview-img {
                height: 160px;
            }

            .template-card .card-body {
                padding: 0.75rem;
            }

            .template-card .card-body h6 {
                font-size: 0.85rem;
            }

            .template-card .card-body p {
                font-size: 0.75rem;
            }

            .template-card .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }

            .kategori-scroll {
                padding-bottom: 0.5rem;
                margin-bottom: -0.5rem;
            }

            .kategori-scroll .category-filter {
                min-width: 120px;
                flex: 0 0 auto;
            }

            .kategori-scroll .category-filter .card-body {
                padding: 0.75rem;
            }

            .kategori-scroll .category-filter .avatar {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .kategori-scroll .category-filter p {
                font-size: 0.75rem;
            }

            #modaltemplate .modal-dialog {
                margin: 0;
                height: 100vh;
                max-width: 100%;
            }

            #modaltemplate .modal-content {
                height: 100%;
                border-radius: 0;
            }

            #editCodeModal .modal-dialog {
                margin: 0;
                height: 100vh;
                max-width: 100%;
            }

            #editCodeModal .modal-content {
                height: 100%;
                border-radius: 0;
            }

            #editCodeModal .modal-body>.row {
                flex-direction: column;
            }

            #editCodeModal .info-panel {
                position: relative;
                max-height: 40%;
                border-bottom: 1px solid var(--bs-border-color);
            }

            #editCodeModal .code-panel {
                flex: 1;
                min-height: 0;
            }

            .header-actions {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .header-actions .btn {
                flex: 1 1 auto;
                min-width: 0;
                font-size: 0.8rem;
                padding: 0.4rem 0.75rem;
            }

            .hero-features {
                display: none;
            }

            .hero-card {
                margin-top: 1rem;
            }
        }

        @media (max-width: 575.98px) {
            .preview-img {
                height: 140px;
            }

            .template-card .card-body {
                padding: 0.6rem;
            }

            .template-card .card-body h6 {
                font-size: 0.8rem;
            }

            .template-card .btn-sm {
                padding: 0.2rem 0.4rem;
                font-size: 0.7rem;
            }

            .kategori-scroll .category-filter {
                min-width: 100px;
            }

            .kategori-scroll .category-filter .card-body {
                padding: 0.6rem;
            }

            .kategori-scroll .category-filter .avatar {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }

            .kategori-scroll .category-filter p {
                font-size: 0.7rem;
            }
        }
        .template-promo-card {
    min-height: 300px;
    border-radius: 18px !important;
    background:
        radial-gradient(
            circle at 85% 10%,
            rgba(255,255,255,.20),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            var(--theme-color, #16a085),
            #087f6f
        );
}

/* Glow */
.promo-glow {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    filter: blur(2px);
}

.promo-glow-1 {
    width: 180px;
    height: 180px;
    right: -70px;
    top: -80px;
    background: rgba(255,255,255,.10);
}

.promo-glow-2 {
    width: 120px;
    height: 120px;
    right: 70px;
    top: 70px;
    background: rgba(255,255,255,.06);
}

/* Badge */
.new-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    border-radius: 50px;
    background: rgba(255,255,255,.16);
    border: 1px solid rgba(255,255,255,.25);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .5px;
    backdrop-filter: blur(8px);
}

/* Particles */
.particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 1;
}

.particles span {
    position: absolute;
    display: block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: rgba(255,255,255,.45);
    animation: floatParticle 5s ease-in-out infinite;
}

.particles span:nth-child(1) {
    left: 12%;
    top: 20%;
}

.particles span:nth-child(2) {
    left: 30%;
    top: 12%;
    width: 3px;
    height: 3px;
    animation-delay: 1s;
}

.particles span:nth-child(3) {
    left: 55%;
    top: 28%;
    width: 4px;
    height: 4px;
    animation-delay: 2s;
}

.particles span:nth-child(4) {
    left: 75%;
    top: 18%;
    width: 3px;
    height: 3px;
    animation-delay: .5s;
}

.particles span:nth-child(5) {
    left: 88%;
    top: 40%;
    width: 6px;
    height: 6px;
    animation-delay: 1.5s;
}

.particles span:nth-child(6) {
    left: 42%;
    top: 48%;
    width: 3px;
    height: 3px;
    animation-delay: 2.5s;
}

.particles span:nth-child(7) {
    left: 18%;
    top: 55%;
    width: 4px;
    height: 4px;
    animation-delay: 3s;
}

.particles span:nth-child(8) {
    left: 65%;
    top: 52%;
    width: 3px;
    height: 3px;
    animation-delay: 1.8s;
}

@keyframes floatParticle {
    0%, 100% {
        transform: translateY(0) scale(1);
        opacity: .3;
    }

    50% {
        transform: translateY(-12px) scale(1.4);
        opacity: .8;
    }
}

/* Wave */
.wave-bottom {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 100px;
    z-index: 1;
    pointer-events: none;
}

.wave-bottom svg {
    width: 100%;
    height: 100%;
    display: block;
}

.wave-bottom path {
    fill: rgba(255,255,255,.10);
}

.wave-bottom .wave-back {
    fill: rgba(255,255,255,.06);
}
    </style>

    <!-- CodeMirror CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/theme/monokai.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/dialog/dialog.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/search/search.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/search/searchcursor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/dialog/dialog.min.js"></script>

   

    <div class="container mt-4" id="main-content">
        <!-- HERO / WELCOME -->
        <div class="row align-items-center py-4">
            <div class="col-12 col-lg-6 col-xxl-8">
                <h5 class="fw-normal mb-1 text-muted" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pilihan Tema Eksklusif</h5>
                <h1 class="mb-3 fw-bold" style="font-family: 'Plus Jakarta Sans', sans-serif; color: var(--ru-text-title, #1B2A4A);">Template Undangan Digital</h1>
                <div class="row align-items-center">
                    <div class="col-12 col-md-11 col-xxl-8 mb-4">
                        <div class="input-group shadow-sm rounded-3 overflow-hidden">
                            <input id="templateSearch" class="form-control border-end-0 py-2" type="text"
                                placeholder="Cari nama template desain...">
                            <button class="btn btn-primary px-4" style="background: linear-gradient(135deg, #C6A962, #A68B4B); border: none;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                <div class="d-flex flex-wrap align-items-start gap-4 mb-4">

                    <div class="hero-features">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="avatar avatar-40 rounded-3 border d-flex align-items-center justify-content-center" style="background: rgba(198, 169, 98, 0.12); color: #C6A962; border-color: rgba(198, 169, 98, 0.25) !important;">
                                    <i class="bi bi-palette-fill fs-5"></i>
                                </span>
                            </div>
                            <div>
                                <p class="small mb-0 fw-semibold">
                                    Desain Eksklusif<br><span class="text-muted fw-normal">Seni Digital Berkualitas</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="hero-features">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="avatar avatar-40 rounded-3 border d-flex align-items-center justify-content-center" style="background: rgba(59, 130, 246, 0.12); color: #3B82F6; border-color: rgba(59, 130, 246, 0.25) !important;">
                                    <i class="bi bi-phone-fill fs-5"></i>
                                </span>
                            </div>
                            <div>
                                <p class="small mb-0 fw-semibold">
                                    100% Responsif<br><span class="text-muted fw-normal">Sempurna di Semua Layar</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="hero-features">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="avatar avatar-40 rounded-3 border d-flex align-items-center justify-content-center" style="background: rgba(16, 185, 129, 0.12); color: #10B981; border-color: rgba(16, 185, 129, 0.25) !important;">
                                    <i class="bi bi-code-slash fs-5"></i>
                                </span>
                            </div>
                            <div>
                                <p class="small mb-0 fw-semibold">
                                    Live Customizer<br><span class="text-muted fw-normal">Pratinjau Instan</span>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

{{-- Promo Card --}}
<div class="col-12 col-lg-6 col-xl-4 mb-4 hero-card">
    <div class="card adminuiux-card position-relative overflow-hidden border-0 text-white template-promo-card">

        {{-- Background Decoration --}}
        <div class="promo-glow promo-glow-1"></div>
        <div class="promo-glow promo-glow-2"></div>

        {{-- Floating Particles --}}
        <div class="particles">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        {{-- Content --}}
        <div class="card-body position-relative z-2 p-4 p-xl-4">

            {{-- Badge --}}
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="new-badge">
                    <i class="bi bi-stars me-1"></i>
                    NEW
                </span>

                <span class="small opacity-75">
                    Premium Collection
                </span>
            </div>

            {{-- Title --}}
            <h2 class="fw-bold mb-2">
                New Templates!
            </h2>

            <h4 class="fw-medium mb-2">
                Modern &amp; Elegant<br>
                Wedding Themes
            </h4>

            {{-- Description --}}
            <p class="mb-4 opacity-75">
                Update your invitation with
                <strong class="text-white">
                    premium design
                </strong>
                that feels unforgettable.
            </p>

            {{-- Button --}}
            <button type="button"
                    class="btn btn-light rounded-pill px-4 py-2 fw-semibold shadow-sm">
                Explore Now
                <i class="bi bi-arrow-right ms-2"></i>
            </button>

        </div>

        {{-- Wave Background --}}
        <div class="wave-bottom">
            <svg
                viewBox="0 0 800 180"
                preserveAspectRatio="none"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
            >

                {{-- Front Wave --}}
                <path
                    d="
                        M0,120
                        C120,180 200,40 330,100
                        C450,160 520,190 650,90
                        C710,45 760,60 800,80
                        L800,180
                        L0,180
                        Z
                    "
                ></path>

                {{-- Back Wave --}}
                <path
                    class="wave-back"
                    d="
                        M0,145
                        C130,90 210,190 340,125
                        C470,60 560,170 680,110
                        C730,85 770,95 800,105
                        L800,180
                        L0,180
                        Z
                    "
                ></path>

            </svg>
        </div>

    </div>
</div>

</div>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Pustaka Template Desain</h4>
            <p class="text-muted small mb-0">Kelola tema dan tampilan undangan digital yang siap digunakan</p>
        </div>
        <div class="d-flex gap-2 flex-wrap header-actions">
            <a href="{{ route('template-creator.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-magic me-1"></i> AI Creator
            </a>
            <form action="{{ route('tempelate.sync') }}" method="POST" class="d-inline"
                onsubmit="return confirm('Sinkronisasi template dari R2? Template yang belum ada di database akan ditambahkan.');">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                    <i class="bi bi-arrow-repeat me-1"></i> Sync R2
                </button>
            </form>
            <button class="btn btn-sm text-white rounded-pill px-3 fw-semibold shadow-sm"
                style="background: linear-gradient(135deg, #C6A962 0%, #A68B4B 100%); border: none;"
                data-bs-toggle="modal" data-bs-target="#modaltemplate">
                <i class="bi bi-plus-lg me-1"></i> Tambah Template
            </button>
        </div>
    </div>
        <!-- TEMPLATE CONTENT -->
        <div id="content-template">
            <div class="col-12">
                <div class="row flex-nowrap flex-md-wrap overflow-auto mb-2 kategori-scroll">
                    @foreach ($categories as $cat)
                        <div class="col-8 col-sm-6 col-md-3 mb-3">
                            <a href="javascript:void(0)" onclick="filterCategory('{{ $cat->slug }}')"
                                class="card adminuiux-card category-filter style-none text-center h-100"
                                data-category="{{ $cat->slug }}">
                                <div class="card-body">
                                    {!! category_icon_html($cat, 'avatar avatar-40 text-theme-1 h3 mb-3') !!}
                                    <p class="text-secondary small mb-0">{{ $cat->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <div class="col-8 col-sm-6 col-md-3 mb-3">
                        <a href="javascript:void(0)" onclick="openCategoryModal()"
                            class="card adminuiux-card category-filter style-none text-center h-100 border-dashed">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-plus-circle h3 mb-3"></i>
                                <p class="text-secondary small mb-0">Manage Categories</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-8 col-sm-6 col-md-3 mb-3">
                        <a href="javascript:void(0)" onclick="openTemplateTypeModal()"
                            class="card adminuiux-card category-filter style-none text-center h-100 border-dashed">
                            <div class="card-body">
                                <i class="avatar avatar-40 text-theme-1 bi bi-palette h3 mb-3"></i>
                                <p class="text-secondary small mb-0">Manage Types</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Filter by Template Type --}}
                <div class="type-filter-bar mb-3">
                    <span class="small fw-semibold text-muted me-1">
                        <i class="bi bi-funnel me-1"></i>Tipe Undangan:
                    </span>
                    <a href="javascript:void(0)" onclick="filterType('all')"
                        class="badge rounded-pill text-bg-secondary type-filter active" data-type="all">Semua</a>
                    @foreach ($templateTypes as $type)
                        <a href="javascript:void(0)" onclick="filterType('{{ $type->slug }}')"
                            class="badge rounded-pill type-filter"
                            style="background-color: {{ $type->color }}; color: #fff;"
                            data-type="{{ $type->slug }}">{{ $type->name }}</a>
                    @endforeach
                </div>
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
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 template-card" data-name="{{ strtolower($template->name) }}"
                        data-category="{{ $template->category->slug ?? '' }}"
                        data-type="{{ $template->templateType->slug ?? '' }}">
                        <div class="card adminuiux-card mb-4 position-relative">
                            <form id="delete-form-{{ $template->id }}"
                                action="{{ route('templates.destroy', $template->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                            <div class="template-preview">
                                <img src="{{ template_thumbnail_url($template) }}" class="preview-img img-fluid">
                            </div>
                            @if($template->templateType)
                                <div class="type-badge-card" style="background-color: {{ $template->templateType->color }};">
                                    {{ $template->templateType->name }}
                                </div>
                            @endif
                            <div class="card-body p-3">
                                <h6 class="fw-medium mb-1 text-truncate">{{ $template->name }}</h6>
                                <p class="text-secondary small mb-2 text-truncate">Slug: {{ $template->slug }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge text-bg-success">Active</span>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('template.frame', ['slug' => $template->slug, 'id' => $template->id]) }}"
                                            target="_blank" class="btn btn-sm btn-outline-primary" title="Preview">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button"
                                            onclick="openEditCodeModal({{ $template->id }}, '{{ $template->name }}', '{{ $template->slug }}', {{ $template->category->id ?? 'null' }})"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" onclick="confirmDelete({{ $template->id }})"
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
                    <form id="addCategoryForm" class="mb-4">
                        <label class="form-label small fw-semibold mb-1">Nama Kategori</label>
                        <div class="input-group mb-3">
                            <input type="text" id="categoryName" class="form-control"
                                placeholder="Contoh: Undangan Pernikahan" required>
                            <button class="btn btn-primary px-3" type="submit">
                                <i class="bi bi-plus-lg me-1"></i> Tambah
                            </button>
                        </div>

                        <label class="form-label small fw-semibold mb-1">Ikon Kategori</label>
                        <input type="hidden" id="categoryIcon" value="bi-folder">
                        <button type="button"
                            class="btn w-100 d-flex align-items-center gap-3 text-start border rounded-3 p-2 bg-body-tertiary icon-picker-trigger"
                            id="categoryIconPickerBtn" aria-expanded="false" aria-controls="categoryIconPickerPanel">
                            <span class="rounded-3 d-flex align-items-center justify-content-center bg-white border flex-shrink-0"
                                style="width: 42px; height: 42px;">
                                <i class="bi bi-folder" id="categoryIconPickerIcon" style="font-size: 1.25rem;"></i>
                                <img src="" alt="" id="categoryIconPickerSvgImg" class="d-none"
                                    style="width: 1.25rem; height: 1.25rem; object-fit: contain;">
                            </span>
                            <span style="min-width: 0;">
                                <span class="d-block fw-semibold small text-truncate" id="categoryIconPickerName">bi-folder</span>
                                <span class="d-block text-muted" style="font-size: 0.7rem;">Klik untuk memilih ikon</span>
                            </span>
                            <i class="bi bi-chevron-down ms-auto text-muted"></i>
                        </button>

                        <div class="border rounded-3 p-3 mt-2 shadow-sm bg-body d-none icon-picker-panel"
                            id="categoryIconPickerPanel">
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text bg-transparent border-0"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control border-0" id="categoryIconPickerSearch"
                                    placeholder="Cari ikon...">
                                <span class="input-group-text bg-transparent border-0 text-muted small"
                                    id="categoryIconPickerCount">0 ikon</span>
                            </div>
                            <div id="categoryIconPickerGrid"
                                style="max-height: 220px; overflow-y: auto; display: grid; grid-template-columns: repeat(auto-fill, minmax(44px, 1fr)); gap: 6px; align-content: start;">
                            </div>

                            <div class="d-flex align-items-center gap-2 mt-3 pt-3 border-top flex-wrap">
                                <input type="hidden" id="categoryIconSvg" value="">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="categoryIconSvgBtn">
                                    <i class="bi bi-upload me-1"></i>Upload SVG
                                </button>
                                <input type="file" id="categoryIconSvgFile" accept=".svg,image/svg+xml" class="d-none">
                                <span class="small text-muted text-truncate" id="categoryIconSvgName"></span>
                                <button type="button" class="btn btn-sm btn-outline-danger ms-auto d-none"
                                    id="categoryIconSvgClear">
                                    <i class="bi bi-x-lg me-1"></i>Hapus
                                </button>
                            </div>
                            <div class="form-text">SVG opsional (maks 100 KB). Jika diisi, SVG dipakai menggantikan ikon Bootstrap.</div>
                            <div class="text-danger small mt-1" id="categoryIconSvgError"></div>
                        </div>
                    </form>
                    <div class="list-group" id="categoryList">
                        @foreach ($categories as $cat)
                            <div class="list-group-item d-flex justify-content-between align-items-center category-item"
                                data-id="{{ $cat->id }}" data-slug="{{ $cat->slug }}">
                                <div class="d-flex align-items-center gap-2">
                                    {!! category_icon_html($cat, 'text-theme-1') !!}
                                    <span>{{ $cat->name }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-reorder-category"
                                        data-id="{{ $cat->id }}" data-direction="up" title="Naikkan urutan">
                                        <i class="bi bi-arrow-up"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-reorder-category"
                                        data-id="{{ $cat->id }}" data-direction="down" title="Turunkan urutan">
                                        <i class="bi bi-arrow-down"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-category"
                                        data-id="{{ $cat->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
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

    <!-- MODAL MANAGE TEMPLATE TYPES -->
    <div class="modal fade" id="modalTemplateType" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Manage Template Types</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addTemplateTypeForm" class="mb-3">
                        <div class="input-group">
                            <input type="text" id="templateTypeName" class="form-control" placeholder="New type name..."
                                required>
                            <input type="color" id="templateTypeColor" class="form-control form-control-color"
                                value="#6c757d" title="Badge color" style="max-width: 60px;">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-plus-lg"></i> Add
                            </button>
                        </div>
                    </form>
                    <div class="list-group" id="templateTypeList">
                        @foreach ($templateTypes as $type)
                            <div class="list-group-item d-flex justify-content-between align-items-center type-item"
                                data-id="{{ $type->id }}" data-slug="{{ $type->slug }}" data-color="{{ $type->color }}">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge type-badge" style="background-color: {{ $type->color }}; color: #fff;">{{ $type->name }}</span>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-template-type"
                                    data-id="{{ $type->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    <div id="noTemplateTypeResult" class="text-center text-muted mt-3 d-none">
                        <p class="mb-0">No template types yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- MODAL UPLOAD TEMPLATE                                           -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <div class="modal fade" id="modaltemplate" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered"
            style="max-width: 1100px; margin: 3vh auto; height: 94vh;">
            <div class="modal-content border-0 shadow-lg"
                style="height: 100%; overflow: hidden; display: flex; flex-direction: column;">

                <!-- Modal Header -->
                <div class="modal-header border-0 pb-0 d-flex align-items-center justify-content-between flex-shrink-0">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">Upload New Template</h5>
                        <small class="text-muted">Upload template ZIP atau import kode Blade</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-0 flex-grow-1" style="min-height: 0; overflow: hidden;">
                    <div class="row g-0 h-100" style="min-height: 0;">

                        <!-- ══ LEFT PANEL ══ -->
                        <div class="col-md-4 border-end info-panel"
                            style="height: 100%; overflow-y: auto; overflow-x: hidden;">
                            <div class="p-4">
                                <h6 class="fw-bold mb-3">Template Information</h6>

                                <!-- Tabs -->
                                <ul class="nav nav-tabs mb-3" id="uploadTemplateTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="zip-tab" data-bs-toggle="tab"
                                            data-bs-target="#zip-panel" type="button" role="tab">
                                            Upload ZIP
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="code-tab" data-bs-toggle="tab"
                                            data-bs-target="#code-panel" type="button" role="tab">
                                            Import Code
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <!-- ══ ZIP UPLOAD FORM ══ -->
                                    <div class="tab-pane fade show active" id="zip-panel" role="tabpanel">
                                        <form action="/templates/upload" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Category</label>
                                                <select name="id_category" class="form-select form-select-sm" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Template Type</label>
                                                <select name="template_type_id" class="form-select form-select-sm">
                                                    <option value="">-- Select Type --</option>
                                                    @foreach ($templateTypes as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Template Name</label>
                                                <input type="text" name="name" class="form-control form-control-sm"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Thumbnail</label>
                                                <input type="file" name="thumbnail" class="form-control form-control-sm"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">ZIP File</label>
                                                <input type="file" name="zip" accept=".zip"
                                                    class="form-control form-control-sm" required>
                                            </div>
                                            <div class="modal-footer px-0 pb-0 mt-3">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- ══ CODE IMPORT FORM ══ -->
                                    <div class="tab-pane fade" id="code-panel" role="tabpanel">
                                        <form action="/templates/import-code" method="POST"
                                            enctype="multipart/form-data" id="importCodeForm">
                                            @csrf

                                            {{-- ⚠️ FIX: Hidden input untuk "code" di DALAM form --}}
                                            {{-- Sebelumnya textarea code berada di luar form, --}}
                                            {{-- sehingga nilainya tidak pernah terkirim. --}}
                                            <input type="hidden" name="code" id="importCodeHidden" value="">

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Category</label>
                                                <select name="id_category" class="form-select form-select-sm" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Template Type</label>
                                                <select name="template_type_id" class="form-select form-select-sm">
                                                    <option value="">-- Select Type --</option>
                                                    @foreach ($templateTypes as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Template Name</label>
                                                <input type="text" name="name" id="importTemplateName"
                                                    class="form-control form-control-sm" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Template Slug</label>
                                                <input type="text" name="slug" id="importTemplateSlug"
                                                    class="form-control form-control-sm" required>
                                                <div class="form-text" style="font-size: 11px;">
                                                    Contoh: love-theme, elegant-theme
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small">Thumbnail</label>
                                                <input type="file" name="thumbnail" class="form-control form-control-sm"
                                                    accept="image/*">
                                                <div class="form-text" style="font-size: 11px;">
                                                    Opsional. Jika tidak diisi, akan dibuat placeholder.
                                                </div>
                                            </div>
                                            <div class="modal-footer px-0 pb-0 mt-3">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    Import Template
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ══ RIGHT PANEL - CODE EDITOR ══ -->
                        <div class="col-md-8 code-panel d-flex flex-column"
                            style="height: 100%; min-height: 0; overflow: hidden;">
                            <div
                                class="p-3 border-bottom bg-light d-flex justify-content-between align-items-center flex-shrink-0">
                                <label class="form-label fw-semibold mb-0">Blade Code</label>
                                <small class="text-muted">Paste kode Blade di sini...</small>
                            </div>
                            {{-- ⚠️ FIX: hapus name="code" dari textarea karena --}}
                            {{-- textarea ini di LUAR form. Nilai code dikirim --}}
                            {{-- via hidden input #importCodeHidden di dalam form. --}}
                            <textarea id="importCodeTextarea" class="form-control border-0" spellcheck="false"
                                placeholder="Paste kode Blade di sini..." style="
                                flex: 1 1 auto;
                                min-height: 0;
                                width: 100%;
                                padding: 1rem;
                                resize: none;
                                overflow: auto;
                                background-color: #1e1e1e;
                                color: #d4d4d4;
                                font-family: 'Courier New', monospace;
                                font-size: 14px;
                                line-height: 1.6;
                                display: block;
                                white-space: pre;
                                tab-size: 4;
                                border-radius: 0;
                                outline: none;
                                box-shadow: none;
                            "></textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- EDIT CODE MODAL                                                 -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <div class="modal fade" id="editCodeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered" style="max-width: 1100px; margin: 3vh auto;">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">Edit Template HTML</h5>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-auto">
                        <div class="input-group input-group-sm" style="width: 220px;">
                            <input type="text" id="codeSearchInput" class="form-control" placeholder="Find in code..."
                                onkeydown="if(event.key==='Enter') findInCode()">
                            <button class="btn btn-outline-secondary" type="button" onclick="findInCode()">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        <button type="button" class="btn btn-success btn-sm" id="saveEditCodeBtn"
                            onclick="saveEditCode()">
                            <i class="bi bi-save me-1"></i> Simpan ke R2
                        </button>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-4 border-end info-panel">
                            <div class="p-4">
                                <h6 class="fw-bold mb-3">Informasi Template</h6>
                                <div class="mb-3">
                                    <label for="editTemplateName" class="form-label fw-semibold small">Nama
                                        Template</label>
                                    <input type="text" id="editTemplateName" class="form-control form-control-sm">
                                </div>
                                <div class="mb-3">
                                    <label for="editTemplateSlug" class="form-label fw-semibold small">Slug</label>
                                    <input type="text" id="editTemplateSlug" class="form-control form-control-sm"
                                        readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="editTemplateCategory"
                                        class="form-label fw-semibold small">Kategori</label>
                                    <select id="editTemplateCategory" class="form-select form-select-sm">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editTemplateType"
                                        class="form-label fw-semibold small">Tipe Template</label>
                                    <select id="editTemplateType" class="form-select form-select-sm">
                                        <option value="">-- Pilih Tipe --</option>
                                        @foreach($templateTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-grid gap-2 mb-3">
                                    <button type="button" class="btn btn-primary btn-sm" id="saveTemplateInfoBtn"
                                        onclick="saveTemplateInfo()">
                                        <i class="bi bi-save me-1"></i> Simpan Informasi
                                    </button>
                                </div>
                                <hr>
                                <div class="alert alert-info small mb-0">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Perubahan akan disimpan langsung ke R2 bucket pada path:
                                    <br>
                                    <code>templates/{slug}/index.blade.php</code>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 border-start code-panel">
                            <textarea id="editCodeTextarea" class="form-control border-0" style="
                                width: 100%;
                                padding: 1rem;
                                resize: none;
                                background-color: #1e1e1e;
                                color: #d4d4d4;
                                font-family: 'Courier New', monospace;
                                font-size: 14px;
                                line-height: 1.6;
                                display: block;
                                white-space: pre;
                                tab-size: 4;
                            " spellcheck="false"></textarea>
                            <div id="editCodeMirror" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- SCRIPT: Categories, Tabs, Import Code Editor                    -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <script src="{{ asset('assets/js/bootstrap-icons-list.js') }}?v={{ @filemtime(public_path('assets/js/bootstrap-icons-list.js')) }}"></script>
    <script>
        const categories = @json($categories);

        /* ── Category Icon Picker ── */
        (function () {
            const btn = document.getElementById('categoryIconPickerBtn');
            const hidden = document.getElementById('categoryIcon');
            const iconEl = document.getElementById('categoryIconPickerIcon');
            const svgImgEl = document.getElementById('categoryIconPickerSvgImg');
            const panel = document.getElementById('categoryIconPickerPanel');
            const search = document.getElementById('categoryIconPickerSearch');
            const grid = document.getElementById('categoryIconPickerGrid');
            const countEl = document.getElementById('categoryIconPickerCount');
            const nameEl = document.getElementById('categoryIconPickerName');

            const svgInput = document.getElementById('categoryIconSvg');
            const svgBtn = document.getElementById('categoryIconSvgBtn');
            const svgFile = document.getElementById('categoryIconSvgFile');
            const svgName = document.getElementById('categoryIconSvgName');
            const svgClear = document.getElementById('categoryIconSvgClear');
            const svgError = document.getElementById('categoryIconSvgError');

            if (!btn) return;
            if (!window.BOOTSTRAP_ICONS) {
                if (countEl) countEl.textContent = 'Daftar ikon gagal dimuat';
                return;
            }

            let rendered = false;

            function selectIcon(icon) {
                hidden.value = icon;
                iconEl.className = 'bi ' + icon;
                nameEl.textContent = icon;
                grid.querySelectorAll('.icon-picker-btn').forEach(function (b) {
                    b.classList.toggle('active', b.dataset.icon === icon);
                });
            }

            function setSvg(dataUri, label) {
                svgInput.value = dataUri || '';
                if (dataUri) {
                    svgImgEl.src = dataUri;
                    svgImgEl.classList.remove('d-none');
                    iconEl.classList.add('d-none');
                    svgName.textContent = label || 'SVG kustom';
                    svgClear.classList.remove('d-none');
                    nameEl.textContent = 'SVG kustom';
                } else {
                    svgImgEl.removeAttribute('src');
                    svgImgEl.classList.add('d-none');
                    iconEl.classList.remove('d-none');
                    svgName.textContent = '';
                    svgClear.classList.add('d-none');
                    nameEl.textContent = hidden.value || 'bi-folder';
                }
            }

            function renderIcons(filter) {
                const q = (filter || '').toLowerCase().replace(/^bi-/, '').trim();
                const icons = q
                    ? window.BOOTSTRAP_ICONS.filter(function (n) { return n.replace('bi-', '').includes(q); })
                    : window.BOOTSTRAP_ICONS;

                countEl.textContent = icons.length + ' ikon';
                grid.innerHTML = '';

                const frag = document.createDocumentFragment();
                icons.forEach(function (icon) {
                    const name = icon.indexOf('bi-') === 0 ? icon : 'bi-' + icon;
                    const b = document.createElement('button');
                    b.type = 'button';
                    b.className = 'icon-picker-btn';
                    if (name === hidden.value) b.classList.add('active');
                    b.dataset.icon = name;
                    b.title = name;
                    b.innerHTML = '<i class="bi ' + name + '"></i>';
                    b.addEventListener('click', function () {
                        selectIcon(name);
                        setSvg('', '');
                        panel.classList.add('d-none');
                    });
                    frag.appendChild(b);
                });
                grid.appendChild(frag);
                rendered = true;
            }

            btn.addEventListener('click', function () {
                const willOpen = panel.classList.contains('d-none');
                panel.classList.toggle('d-none');
                btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
                if (willOpen) {
                    if (!rendered) renderIcons(search.value);
                    search.focus();
                }
            });

            search.addEventListener('input', function () { renderIcons(search.value); });

            /* ── Upload SVG ── */
            if (svgBtn && svgFile) {
                svgBtn.addEventListener('click', function () { svgFile.click(); });
                svgFile.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    svgError.textContent = '';
                    if (!file) return;

                    if (!/\.svg$/i.test(file.name) && file.type !== 'image/svg+xml') {
                        svgError.textContent = 'File harus berformat .svg';
                        this.value = '';
                        return;
                    }
                    if (file.size > 100 * 1024) {
                        svgError.textContent = 'Ukuran SVG maksimal 100 KB';
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function (e) { setSvg(e.target.result, file.name); };
                    reader.readAsDataURL(file);
                });
            }

            if (svgClear) {
                svgClear.addEventListener('click', function () {
                    setSvg('', '');
                    svgError.textContent = '';
                    if (svgFile) svgFile.value = '';
                });
            }

            /* Reset picker (dipakai setelah kategori ditambah) */
            window.resetCategoryIconPicker = function () {
                selectIcon('bi-folder');
                setSvg('', '');
                svgError.textContent = '';
                if (svgFile) svgFile.value = '';
            };

            selectIcon(hidden.value || 'bi-folder');
            setSvg(svgInput.value || '', 'SVG kustom');
        })();

        /* ── Category Modal ── */
        window.openCategoryModal = function () {
            new bootstrap.Modal(document.getElementById('modalCategory')).show();
        };

        document.getElementById('addCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const nameInput = document.getElementById('categoryName');
            const iconInput = document.getElementById('categoryIcon');
            const svgInput = document.getElementById('categoryIconSvg');
            const name = nameInput.value.trim();
            const icon = iconInput.value;
            const iconSvg = (svgInput && svgInput.value) ? svgInput.value : null;
            if (!name) return;

            fetch('{{ route("categories.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, icon, icon_svg: iconSvg })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        nameInput.value = '';
                        if (window.resetCategoryIconPicker) window.resetCategoryIconPicker();

                        const list = document.getElementById('categoryList');
                        const item = document.createElement('div');
                        item.className = 'list-group-item d-flex justify-content-between align-items-center category-item';
                        item.dataset.id = data.category.id;
                        item.dataset.slug = data.category.slug;
                        item.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        ${data.category.icon_svg
                            ? `<i class="category-icon-img text-theme-1" style="--category-icon:url('${data.category.icon_svg}')"></i>`
                            : `<i class="bi ${icon} text-theme-1"></i>`}
                        <span>${name}</span>
                    </div>
                    <div class="d-flex align-items-center gap-1 flex-shrink-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-reorder-category" data-id="${data.category.id}" data-direction="up" title="Naikkan urutan"><i class="bi bi-arrow-up"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-reorder-category" data-id="${data.category.id}" data-direction="down" title="Turunkan urutan"><i class="bi bi-arrow-down"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-category" data-id="${data.category.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>`;
                        list.appendChild(item);

                        const filterContainer = document.querySelector('#content-template .kategori-scroll');
                        const col = document.createElement('div');
                        col.className = 'col-8 col-sm-6 col-md-3 mb-3';
                        col.innerHTML = `
                    <a href="javascript:void(0)" onclick="filterCategory('${data.category.slug}')"
                        class="card adminuiux-card category-filter style-none text-center h-100"
                        data-category="${data.category.slug}">
                        <div class="card-body">
                            ${data.category.icon_svg
                                ? `<i class="category-icon-img avatar avatar-40 text-theme-1 h3 mb-3" style="--category-icon:url('${data.category.icon_svg}')"></i>`
                                : `<i class="avatar avatar-40 text-theme-1 bi ${icon} h3 mb-3"></i>`}
                            <p class="text-secondary small mb-0">${name}</p>
                        </div>
                    </a>`;
                        filterContainer.insertBefore(col, filterContainer.lastElementChild);
                        bindDeleteCategory();
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err.responseJSON?.message || 'Terjadi kesalahan'
                    });
                });
        });

        /* ── Reorder Category ── */
        function reorderCategory(id, direction) {
            fetch('{{ route("admin.categories.reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: parseInt(id, 10), direction: direction })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        applyCategoryOrder(data.order);
                    } else if (data.message) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Info',
                            text: data.message,
                            timer: 1600,
                            showConfirmButton: false
                        });
                    }
                })
                .catch(() => Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan' }));
        }

        function applyCategoryOrder(order) {
            if (!Array.isArray(order)) return;

            const list = document.getElementById('categoryList');
            if (list) {
                order.forEach(function (id) {
                    const item = list.querySelector('.category-item[data-id="' + id + '"]');
                    if (item) list.appendChild(item);
                });
            }

            const scroll = document.querySelector('#content-template .kategori-scroll');
            if (!scroll) return;

            const slugById = {};
            categories.forEach(function (c) { slugById[c.id] = c.slug; });

            const manageLink = scroll.querySelector('.category-filter[onclick*="openCategoryModal"]');
            const anchor = manageLink ? manageLink.closest('.col-8, .col-sm-6, .col-md-3') : null;

            order.forEach(function (id) {
                const slug = slugById[id];
                if (!slug) return;
                const card = scroll.querySelector('.category-filter[data-category="' + slug + '"]');
                if (!card) return;
                const wrapper = card.closest('.col-8, .col-sm-6, .col-md-3');
                if (!wrapper) return;
                if (anchor && anchor.parentNode === scroll) {
                    scroll.insertBefore(wrapper, anchor);
                } else {
                    scroll.appendChild(wrapper);
                }
            });
        }

        document.getElementById('modalCategory').addEventListener('click', function (e) {
            const btn = e.target.closest('.btn-reorder-category');
            if (!btn) return;
            reorderCategory(btn.dataset.id, btn.dataset.direction);
        });

        function bindDeleteCategory() {
            document.querySelectorAll('.btn-delete-category').forEach(btn => {
                btn.onclick = function () {
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
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        item.remove();
                                        if (card) card.remove();
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

        /* ── Template Type Modal ── */
        window.openTemplateTypeModal = function () {
            new bootstrap.Modal(document.getElementById('modalTemplateType')).show();
        };

        document.getElementById('addTemplateTypeForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const nameInput = document.getElementById('templateTypeName');
            const colorInput = document.getElementById('templateTypeColor');
            const name = nameInput.value.trim();
            const color = colorInput.value;
            if (!name) return;

            fetch('{{ route("template-types.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, color })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        nameInput.value = '';
                        const list = document.getElementById('templateTypeList');
                        const item = document.createElement('div');
                        item.className = 'list-group-item d-flex justify-content-between align-items-center type-item';
                        item.dataset.id = data.type.id;
                        item.dataset.slug = data.type.slug;
                        item.dataset.color = color;
                        item.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge type-badge" style="background-color: ${color}; color: #fff;">${name}</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-delete-template-type" data-id="${data.type.id}">
                        <i class="bi bi-trash"></i>
                    </button>`;
                        list.appendChild(item);

                        const filterBar = document.querySelector('.type-filter-bar');
                        if (filterBar) {
                            const pill = document.createElement('a');
                            pill.href = 'javascript:void(0)';
                            pill.className = 'badge rounded-pill type-filter';
                            pill.dataset.type = data.type.slug;
                            pill.style.backgroundColor = color;
                            pill.style.color = '#fff';
                            pill.textContent = name;
                            pill.onclick = function () { filterType(data.type.slug); };
                            filterBar.appendChild(pill);
                        }

                        bindDeleteTemplateType();
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err.responseJSON?.message || 'Terjadi kesalahan'
                    });
                });
        });

        function bindDeleteTemplateType() {
            document.querySelectorAll('.btn-delete-template-type').forEach(btn => {
                btn.onclick = function () {
                    const id = this.dataset.id;
                    const item = this.closest('.type-item');
                    Swal.fire({
                        title: 'Delete this template type?',
                        text: "Templates assigned to this type will be unassigned.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/template-types/${id}`, {
                                method: 'DELETE',
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                            })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        item.remove();
                                    } else {
                                        Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                                    }
                                });
                        }
                    });
                };
            });
        }
        bindDeleteTemplateType();

        /* ── Tab Switching ── */
        const tabTemplate = document.getElementById('tab-template');
        const tabMusic = document.getElementById('tab-music');
        const contentTemplate = document.getElementById('content-template');
        const contentMusic = document.getElementById('content-music');

        if (tabTemplate && tabMusic && contentTemplate && contentMusic) {
            tabTemplate.onclick = () => {
                tabTemplate.classList.replace('btn-outline-secondary', 'btn-primary');
                tabMusic.classList.replace('btn-primary', 'btn-outline-secondary');
                contentTemplate.classList.remove('d-none');
                contentMusic.classList.add('d-none');
            };
            tabMusic.onclick = () => {
                tabMusic.classList.replace('btn-outline-secondary', 'btn-primary');
                tabTemplate.classList.replace('btn-primary', 'btn-outline-secondary');
                contentMusic.classList.remove('d-none');
                contentTemplate.classList.add('d-none');
            };
        }

        /* ── Delete Template ── */
        function confirmDelete(id) {
            Swal.fire({
                title: 'Delete this template?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        /* ── Slug Auto-Generate ── */
        function generateSlug(text) {
            return text.toString().toLowerCase().trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        const importNameInput = document.getElementById('importTemplateName');
        const importSlugInput = document.getElementById('importTemplateSlug');
        if (importNameInput && importSlugInput) {
            importNameInput.addEventListener('input', function () {
                if (!importSlugInput.dataset.manual) {
                    importSlugInput.value = generateSlug(this.value);
                }
            });
            importSlugInput.addEventListener('input', function () { this.dataset.manual = 'true'; });
            importSlugInput.addEventListener('focus', function () { this.dataset.manual = 'true'; });
        }

        /* ════════════════════════════════════════════════════════════ */
        /* ⚠️ FIX: Import CodeMirror — sync ke hidden input di form    */
        /* ════════════════════════════════════════════════════════════ */
        let importCodeMirrorInstance = null;
        const importCodeTextarea = document.getElementById('importCodeTextarea');
        const importCodeForm = document.getElementById('importCodeForm');
        const importCodeHidden = document.getElementById('importCodeHidden'); // ← hidden input di dalam form

        // Sync CodeMirror → hidden input (yang ada di dalam <form>)
        function syncImportCodeToHidden() {
            if (importCodeMirrorInstance && importCodeHidden) {
                importCodeHidden.value = importCodeMirrorInstance.getValue();
            }
        }

        if (importCodeTextarea) {
            importCodeMirrorInstance = CodeMirror.fromTextArea(importCodeTextarea, {
                mode: 'htmlmixed',
                theme: 'monokai',
                lineNumbers: true,
                autoCloseTags: true,
                autoCloseBrackets: true,
                matchBrackets: true,
                indentUnit: 4,
                tabSize: 4,
                indentWithTabs: false,
                lineWrapping: true,
            });

            // Sync pada setiap perubahan
            importCodeMirrorInstance.on('change', syncImportCodeToHidden);

            // ⚠️ FIX: Refresh CodeMirror saat modal dibuka dan saat tab "Import Code" diklik
            const modaltemplate = document.getElementById('modaltemplate');
            modaltemplate.addEventListener('shown.bs.modal', function () {
                setTimeout(() => importCodeMirrorInstance.refresh(), 200);
            });

            const codeTabBtn = document.getElementById('code-tab');
            if (codeTabBtn) {
                codeTabBtn.addEventListener('shown.bs.tab', function () {
                    setTimeout(() => importCodeMirrorInstance.refresh(), 200);
                });
            }
        }

        // ⚠️ FIX: Pastikan hidden input terisi sebelum form di-submit
        if (importCodeForm) {
            importCodeForm.addEventListener('submit', function (e) {
                syncImportCodeToHidden();

                // Validasi: cegah submit jika code kosong
                if (!importCodeHidden.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Code Kosong',
                        text: 'Silakan isi kode Blade template terlebih dahulu.',
                    });
                }
            });
        }
    </script>

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- SCRIPT: Edit Code Modal (Fetch-based, tidak ada issue form)     -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <script>
        let currentEditTemplateId = null;
        let codeMirrorInstance = null;

        window.openEditCodeModal = function (templateId, name, slug, categoryId) {
            currentEditTemplateId = templateId;
            document.getElementById('editTemplateName').value = name;
            document.getElementById('editTemplateSlug').value = slug;
            document.getElementById('editTemplateCategory').value = categoryId || '';

            new bootstrap.Modal(document.getElementById('editCodeModal')).show();

            fetch("{{ route('tempelate.edit-code', ['template' => '__ID__']) }}".replace('__ID__', templateId), {
                headers: { 'Accept': 'application/json' },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('editTemplateCategory').value = data.template.category_id || '';
                        document.getElementById('editTemplateType').value = data.template.template_type_id || '';
                        const textarea = document.getElementById('editCodeTextarea');
                        const codeMirrorDiv = document.getElementById('editCodeMirror');

                        if (codeMirrorInstance) {
                            codeMirrorInstance.toTextArea();
                            codeMirrorInstance = null;
                        }

                        textarea.value = data.code || '';
                        textarea.style.display = 'block';
                        codeMirrorDiv.style.display = 'none';

                        codeMirrorInstance = CodeMirror.fromTextArea(textarea, {
                            mode: 'htmlmixed',
                            theme: 'monokai',
                            lineNumbers: true,
                            autoCloseTags: true,
                            autoCloseBrackets: true,
                            matchBrackets: true,
                            indentUnit: 4,
                            tabSize: 4,
                            indentWithTabs: false,
                            lineWrapping: true,
                        });

                        codeMirrorInstance.on('change', function () { codeMirrorInstance.save(); });
                        setTimeout(() => codeMirrorInstance.refresh(), 300);
                    } else {
                        document.getElementById('editCodeTextarea').value = '// Gagal memuat kode template';
                    }
                })
                .catch(() => {
                    document.getElementById('editCodeTextarea').value = '// Gagal memuat kode template';
                });
        };

        window.findInCode = function () {
            if (!codeMirrorInstance) return;
            const query = document.getElementById('codeSearchInput').value;
            if (!query) return;
            codeMirrorInstance.execCommand('findPersistent', { query, caseFold: true });
        };

        window.saveEditCode = function () {
            const code = codeMirrorInstance
                ? codeMirrorInstance.getValue()
                : document.getElementById('editCodeTextarea').value;
            const saveBtn = document.getElementById('saveEditCodeBtn');
            const originalText = saveBtn.innerHTML;

            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('code', code);

            fetch("{{ route('tempelate.save-code', ['template' => '__ID__']) }}".replace('__ID__', currentEditTemplateId), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success', title: 'Berhasil!', text: data.message,
                            confirmButtonColor: '#C6A962', timer: 1500, showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error', title: 'Gagal!', text: data.message || 'Gagal menyimpan',
                            confirmButtonColor: '#C6A962'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error', title: 'Gagal!', text: 'Terjadi kesalahan koneksi',
                        confirmButtonColor: '#C6A962'
                    });
                })
                .finally(() => {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                });
        };

        window.saveTemplateInfo = function () {
            const name = document.getElementById('editTemplateName').value.trim();
            const templateTypeId = document.getElementById('editTemplateType').value;
            const categoryId = document.getElementById('editTemplateCategory').value;
            const saveBtn = document.getElementById('saveTemplateInfoBtn');
            const originalText = saveBtn.innerHTML;

            if (!name) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Nama template harus diisi',
                    confirmButtonColor: '#C6A962'
                });
                return;
            }

            saveBtn.disabled = true;
            saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('name', name);
            formData.append('id_category', categoryId);
            formData.append('template_type_id', templateTypeId);

            fetch("{{ route('tempelate.update-info', ['template' => '__ID__']) }}".replace('__ID__', currentEditTemplateId), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            confirmButtonColor: '#C6A962',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: data.message || 'Gagal menyimpan',
                            confirmButtonColor: '#C6A962'
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan koneksi',
                        confirmButtonColor: '#C6A962'
                    });
                })
                .finally(() => {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalText;
                });
        };
    </script>

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- SCRIPT: Search & Category Filter                                -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <script>
        const searchInput = document.getElementById('templateSearch');
        const noResult = document.getElementById('noResult');
        let activeCategory = 'all';
        let activeType = 'all';

        function filterTemplates() {
            const term = searchInput.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.template-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const category = card.getAttribute('data-category');
                const type = card.getAttribute('data-type');
                const matchesSearch = name.includes(term);
                const matchesCategory = (activeCategory === 'all' || category === activeCategory);
                const matchesType = (activeType === 'all' || type === activeType);

                if (matchesSearch && matchesCategory && matchesType) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            noResult.classList.toggle('d-none', visibleCount > 0);
        }

        window.filterCategory = function (cat) {
            if (activeCategory === cat) {
                activeCategory = 'all';
                document.querySelectorAll('.category-filter').forEach(el => {
                    el.classList.remove('border-primary', 'bg-light');
                });
            } else {
                activeCategory = cat;
                document.querySelectorAll('.category-filter').forEach(el => {
                    el.classList.remove('border-primary', 'bg-light');
                });
                document.querySelector(`.category-filter[data-category="${cat}"]`)
                    ?.classList.add('border-primary', 'bg-light');
            }
            filterTemplates();
        };

        window.filterType = function (type) {
            if (activeType === type && type !== 'all') {
                activeType = 'all';
            } else {
                activeType = type;
            }
            document.querySelectorAll('.type-filter').forEach(el => {
                el.classList.toggle('active', el.dataset.type === activeType);
            });
            filterTemplates();
        };

        searchInput.addEventListener('input', filterTemplates);
    </script>

    <!-- ═══════════════════════════════════════════════════════════════ -->
    <!-- SCRIPT: Auto-set Kategori berdasarkan Tipe Template            -->
    <!-- ═══════════════════════════════════════════════════════════════ -->
    <script>
        const typeCategoryMap = @json($typeCategoryMap ?? []);

        function bindTypeCategoryAutofill(typeSelect, categorySelect) {
            if (!typeSelect || !categorySelect) return;
            typeSelect.addEventListener('change', function () {
                const categoryId = typeCategoryMap[this.value];
                if (categoryId) {
                    categorySelect.value = categoryId;
                }
            });
        }

        // Modal Edit Template
        bindTypeCategoryAutofill(
            document.getElementById('editTemplateType'),
            document.getElementById('editTemplateCategory')
        );

        // Modal Upload — tab ZIP
        bindTypeCategoryAutofill(
            document.querySelector('#zip-panel select[name="template_type_id"]'),
            document.querySelector('#zip-panel select[name="id_category"]')
        );

        // Modal Upload — tab Import Code
        bindTypeCategoryAutofill(
            document.querySelector('#code-panel select[name="template_type_id"]'),
            document.querySelector('#code-panel select[name="id_category"]')
        );
    </script>

</x-app-layout>
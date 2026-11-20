@extends('layouts.page')

@php
    $canonicalUrl = route('pages.cari-tema');
    $noIndex = !empty($searchQuery);
    $baseParams = request()->except(['_token', 'page']);

    $activePrice = $isPremiumFilter ?? request('is_premium');
    $activeCategory = $categoryFilter ?? request('category');
    $activeType = $typeFilter ?? request('type');
@endphp

@section('content')
    <!-- Hero Section (Modern Editorial Style) -->
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Koleksi Tema</li>
                </ol>
            </nav>
            <h1>Koleksi Tema Undangan Digital</h1>
            <p>Temukan tema undangan eksklusif yang sesuai dengan tema pernikahan dan momen bahagia Anda.</p>
        </div>
    </section>

    <!-- Templates Gallery Section -->
    <section class="ev-section-light">
        <div class="container">
            <div class="ev-gallery-layout" id="templates">
                <!-- Filter Sidebar -->
                <aside class="ev-ct-sidebar" id="filterSidebar">
                    <div class="ev-ct-sidebar-header">
                        <span class="ev-ct-sidebar-title">Filter</span>
                        <a href="{{ route('pages.cari-tema') }}" class="ev-ct-sidebar-clear" data-ajax-link>Hapus</a>
                    </div>

                    <!-- Price Filter -->
                    <div class="ev-ct-filter-group">
                        <span class="ev-ct-filter-label">Harga</span>
                        <div class="ev-ct-price-pills">
                            <a href="{{ route('pages.cari-tema', array_merge($baseParams, ['is_premium' => $activePrice === '0' ? null : 0])) }}#templates"
                                class="ev-ct-price-pill {{ $activePrice === '0' ? 'active' : '' }}" data-ajax-link
                                data-filter-price="0">
                                <i class="bi bi-tag-fill"></i> Gratis
                            </a>
                            <a href="{{ route('pages.cari-tema', array_merge($baseParams, ['is_premium' => $activePrice === '1' ? null : 1])) }}#templates"
                                class="ev-ct-price-pill {{ $activePrice === '1' ? 'active' : '' }}" data-ajax-link
                                data-filter-price="1">
                                <i class="bi bi-award-fill"></i> Premium
                            </a>
                        </div>
                    </div>

                    <!-- Template Type Filter -->
                    <div class="ev-ct-filter-group">
                        <span class="ev-ct-filter-label">Tipe Tema</span>
                        <div class="ev-ct-type-list">
                            @foreach($templateTypes as $type)
                                <a href="{{ route('pages.cari-tema', array_merge($baseParams, ['type' => $activeType === $type['slug'] ? null : $type['slug']])) }}#templates"
                                    class="ev-ct-type-item {{ $activeType === $type['slug'] ? 'active' : '' }}" data-ajax-link
                                    data-filter-type="{{ $type['slug'] }}">
                                    <span class="ev-ct-type-dot"
                                        style="background-color: {{ $type['color'] ?? '#425620' }}"></span>
                                    <span class="ev-ct-type-name">{{ $type['name'] }}</span>
                                    <span class="ev-ct-type-count">{{ $type['count'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="ev-ct-filter-group">
                        <span class="ev-ct-filter-label">Kategori</span>
                        <div class="ev-ct-filter-chips">
                            <a href="{{ route('pages.cari-tema', array_merge($baseParams, ['category' => null])) }}#templates"
                                class="ev-ct-chip {{ !$activeCategory || $activeCategory === 'All' ? 'active' : '' }}"
                                data-ajax-link data-filter-category="">
                                Semua
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('pages.cari-tema', array_merge($baseParams, ['category' => $activeCategory === $cat['name'] ? null : $cat['name']])) }}#templates"
                                    class="ev-ct-chip {{ $activeCategory === $cat['name'] ? 'active' : '' }}" data-ajax-link
                                    data-filter-category="{{ $cat['name'] }}">
                                    {{ $cat['name'] }} <span class="ev-ct-chip-count">{{ $cat['count'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Search Box -->
                    <div class="ev-ct-search-wrap">
                        <form action="{{ route('pages.cari-tema') }}#templates" method="GET" class="ev-ct-search-box"
                            data-ajax-form>
                            @if($activePrice !== null && $activePrice !== '')
                                <input type="hidden" name="is_premium" value="{{ $activePrice }}">
                            @endif
                            @if($activeCategory && $activeCategory !== 'All')
                                <input type="hidden" name="category" value="{{ $activeCategory }}">
                            @endif
                            @if($activeType)
                                <input type="hidden" name="type" value="{{ $activeType }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif
                            <i class="bi bi-search"></i>
                            <input type="text" name="search" placeholder="Cari tema..." value="{{ request('search') }}">
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="ev-ct-main" id="evCtResults">
                    @include('pages.partials.cari-tema-results')
                </div>
            </div>
        </div>
    </section>

    <style>
        /* ===== Cari Tema Hero ===== */
        .ev-ct-hero {
            background: linear-gradient(135deg, var(--ev-bg) 0%, var(--ev-bg-ivory) 100%);
            padding: 5rem 0 3rem;
            border-bottom: 1px solid var(--ev-border-light);
            text-align: center;
        }

        .ev-ct-hero h1 {
            font-family: var(--ev-font-serif);
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 700;
            color: var(--ev-text-primary);
            margin-bottom: 0.85rem;
            letter-spacing: -0.015em;
        }

        .ev-ct-hero p {
            font-size: 1.08rem;
            color: var(--ev-text-secondary);
            max-width: 680px;
            margin: 0 auto;
        }

        /* ===== Gallery Layout ===== */
        .ev-gallery-layout {
            display: grid;
            grid-template-columns: 270px 1fr;
            gap: 2rem;
            scroll-margin-top: 92px;
        }

        /* ===== Filter Sidebar ===== */
        .ev-ct-sidebar {
            background: var(--ev-bg-white);
            border: 1px solid var(--ev-border-light);
            border-radius: var(--ev-radius-lg);
            box-shadow: var(--ev-shadow-sm);
            padding: 1.5rem;
            height: fit-content;
            max-height: calc(100vh - 110px);
            overflow-y: auto;
            overscroll-behavior: contain;
            position: sticky;
            top: 88px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .ev-ct-sidebar::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        .ev-ct-sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .ev-ct-sidebar-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--ev-text-muted);
        }

        .ev-ct-sidebar-clear {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--ev-green);
            cursor: pointer;
            transition: var(--ev-transition);
        }

        .ev-ct-sidebar-clear:hover {
            color: var(--ev-green-hover);
            text-decoration: underline;
        }

        /* Filter Group */
        .ev-ct-filter-group {
            margin-bottom: 1.75rem;
        }

        .ev-ct-filter-group:last-child {
            margin-bottom: 0;
        }

        .ev-ct-filter-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--ev-text-muted);
            display: block;
            margin-bottom: 0.75rem;
        }

        /* Price Pills */
        .ev-ct-price-pills {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .ev-ct-price-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 0.9rem;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: var(--ev-radius-sm);
            background: var(--ev-bg-search);
            color: var(--ev-text-secondary);
            border: 1.5px solid transparent;
            text-decoration: none;
            transition: var(--ev-transition);
            cursor: pointer;
        }

        .ev-ct-price-pill:hover {
            background: var(--ev-green-light);
            color: var(--ev-green);
        }

        .ev-ct-price-pill.active {
            background: var(--ev-green);
            color: var(--ev-bg-white);
            border-color: var(--ev-green);
        }

        /* Template Type List */
        .ev-ct-type-list {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .ev-ct-type-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: var(--ev-radius-sm);
            background: transparent;
            color: var(--ev-text-secondary);
            border: 1.5px solid transparent;
            text-decoration: none;
            transition: var(--ev-transition);
            cursor: pointer;
        }

        .ev-ct-type-item:hover {
            background: var(--ev-green-light);
            color: var(--ev-green);
        }

        .ev-ct-type-item.active {
            background: var(--ev-green);
            color: var(--ev-bg-white);
            border-color: var(--ev-green);
        }

        .ev-ct-type-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.7);
        }

        .ev-ct-type-name {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .ev-ct-type-count {
            font-size: 0.75rem;
            font-weight: 700;
            opacity: 0.7;
        }

        /* Category Chips */
        .ev-ct-filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .ev-ct-chip {
            padding: 0.4rem 0.9rem;
            font-size: 0.82rem;
            font-weight: 600;
            border-radius: var(--ev-radius-pill);
            background: var(--ev-bg);
            color: var(--ev-text-secondary);
            border: 1px solid var(--ev-border);
            text-decoration: none;
            white-space: nowrap;
            transition: var(--ev-transition);
            cursor: pointer;
        }

        .ev-ct-chip:hover {
            border-color: var(--ev-green);
            color: var(--ev-green);
        }

        .ev-ct-chip.active {
            background: var(--ev-green);
            color: var(--ev-bg-white);
            border-color: var(--ev-green);
        }

        .ev-ct-chip-count {
            opacity: 0.7;
        }

        /* Search Box in Sidebar */
        .ev-ct-search-box {
            display: flex;
            align-items: center;
            width: 100%;
            position: relative;
        }

        .ev-ct-search-box i {
            position: absolute;
            left: 0.85rem;
            color: var(--ev-text-muted);
            z-index: 2;
            font-size: 0.95rem;
        }

        .ev-ct-search-box input {
            width: 100%;
            padding: 0.6rem 0.75rem 0.6rem 2.25rem;
            font-size: 0.88rem;
            border-radius: var(--ev-radius-pill);
            border: 1.5px solid var(--ev-border);
            background: var(--ev-bg-search);
            outline: none;
            transition: var(--ev-transition);
            font-family: var(--ev-font-sans);
        }

        .ev-ct-search-box input:focus {
            border-color: var(--ev-green);
            background: var(--ev-bg-white);
            box-shadow: 0 0 0 3px rgba(66, 86, 32, 0.12);
        }

        /* ===== Main Content Toolbar ===== */
        .ev-ct-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .ev-ct-toolbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .ev-ct-filter-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.45rem 0.95rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: var(--ev-radius-pill);
            border: 1.5px solid var(--ev-border);
            background: var(--ev-bg-white);
            color: var(--ev-text-secondary);
            cursor: pointer;
            transition: var(--ev-transition);
        }

        .ev-ct-filter-toggle:hover {
            border-color: var(--ev-green);
            color: var(--ev-green);
            background: var(--ev-green-light);
        }

        .ev-ct-results-count {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--ev-text-secondary);
        }

        /* ===== Active Filter Chips ===== */
        .ev-ct-active-filters {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .ev-ct-active-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--ev-text-muted);
        }

        .ev-ct-active-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            font-size: 0.82rem;
            font-weight: 600;
            border-radius: var(--ev-radius-pill);
            background: var(--ev-green-light);
            color: var(--ev-green);
            border: 1px solid rgba(66, 86, 32, 0.18);
            text-decoration: none;
            transition: var(--ev-transition);
        }

        .ev-ct-active-chip:hover {
            background: var(--ev-green);
            color: var(--ev-bg-white);
            border-color: var(--ev-green);
        }

        .ev-ct-active-clear {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ev-text-muted);
            text-decoration: underline;
            transition: var(--ev-transition);
        }

        .ev-ct-active-clear:hover {
            color: var(--ev-green);
        }

        /* ===== Pagination ===== */
        .ev-ct-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.4rem;
            margin-top: 2.75rem;
        }

        .ev-ct-page {
            min-width: 40px;
            height: 40px;
            padding: 0 0.7rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: var(--ev-radius-sm);
            border: 1.5px solid var(--ev-border);
            background: var(--ev-bg-white);
            color: var(--ev-text-secondary);
            text-decoration: none;
            transition: var(--ev-transition);
        }

        .ev-ct-page:hover {
            border-color: var(--ev-green);
            color: var(--ev-green);
        }

        .ev-ct-page.is-active {
            background: var(--ev-green);
            border-color: var(--ev-green);
            color: var(--ev-bg-white);
        }

        .ev-ct-page.is-disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .ev-ct-page.is-ellipsis {
            border-color: transparent;
            background: transparent;
            cursor: default;
        }

        /* ===== Sidebar Collapsed State ===== */
        .ev-gallery-layout.filters-hidden {
            grid-template-columns: 1fr;
        }

        .ev-gallery-layout.filters-hidden .ev-ct-sidebar {
            display: none;
        }

        .ev-ct-sort-form {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ev-ct-sort-label {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--ev-text-muted);
        }

        .ev-ct-sort-select {
            padding: 0.4rem 0.9rem;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: var(--ev-radius-pill);
            border: 1.5px solid var(--ev-border);
            background: var(--ev-bg-white);
            color: var(--ev-text-primary);
            cursor: pointer;
            transition: var(--ev-transition);
        }

        .ev-ct-sort-select:focus {
            outline: none;
            border-color: var(--ev-green);
            box-shadow: 0 0 0 3px rgba(66, 86, 32, 0.12);
        }

        /* ===== Gallery Grid (override landing.css) ===== */
        .ev-gallery-layout .ev-templates-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .ev-gallery-layout.filters-hidden .ev-templates-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        /* ===== Gallery Card ===== */
        .ev-gallery-card {
            background: var(--ev-bg-white);
            border: 1px solid var(--ev-border-light);
            border-radius: var(--ev-radius-md);
            overflow: hidden;
            box-shadow: var(--ev-shadow-sm);
            display: flex;
            flex-direction: column;
            transition: var(--ev-transition);
        }

        .ev-gallery-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--ev-shadow-md);
            border-color: var(--ev-green);
        }

        /* Gallery Media - 4:3 Aspect Ratio */
        .ev-gallery-media {
            position: relative;
            aspect-ratio: 4 / 3;
            height: auto !important;
            background-color: var(--ev-bg-search);
            overflow: hidden;
            border-radius: var(--ev-radius-md) var(--ev-radius-md) 0 0;
        }

        .ev-gallery-link {
            display: block;
            width: 100%;
            height: 100%;
        }

        .ev-gallery-link img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .ev-gallery-card:hover .ev-gallery-link img {
            transform: scale(1.04);
        }

        /* Gallery Hover Actions Overlay */
        .ev-gallery-hover-actions {
            position: absolute;
            inset: 0;
            background: rgba(18, 26, 21, 0.55);
            backdrop-filter: blur(4px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            opacity: 0;
            visibility: hidden;
            transition: var(--ev-transition);
            z-index: 4;
            padding: 1.5rem;
        }

        .ev-gallery-card:hover .ev-gallery-hover-actions {
            opacity: 1;
            visibility: visible;
        }

        .ev-gallery-hover-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 0.65rem 1.4rem;
            border-radius: var(--ev-radius-pill);
            box-shadow: var(--ev-shadow-md);
            width: 100%;
            max-width: 180px;
            text-align: center;
            transition: var(--ev-transition);
        }

        .ev-hover-preview {
            background-color: var(--ev-bg-white);
            color: var(--ev-text-primary);
        }

        .ev-hover-preview:hover {
            background-color: var(--ev-bg-search);
            transform: scale(1.02);
        }

        .ev-hover-use {
            background-color: var(--ev-green);
            color: var(--ev-bg-white) !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
        }

        .ev-hover-use:hover {
            background-color: var(--ev-green-hover);
            transform: scale(1.02);
        }

        /* Gallery Badge - Free / Premium (top-left) */
        .ev-gallery-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 2;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.3rem 0.7rem;
            border-radius: var(--ev-radius-pill);
            box-shadow: var(--ev-shadow-sm);
        }

        .ev-badge--free {
            background: rgba(66, 86, 32, 0.9);
            color: var(--ev-bg-white);
        }

        .ev-badge--premium {
            background: linear-gradient(135deg, var(--ev-warm-gold) 0%, #B8860B 100%);
            color: var(--ev-bg-white);
        }

        /* Gallery Meta */
        .ev-gallery-meta {
            padding: 1rem 1rem 1.1rem;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 0.75rem;
            background: var(--ev-bg-white);
        }

        .ev-gallery-info {
            flex: 1;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .ev-gallery-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }

        .ev-gallery-name {
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            color: var(--ev-text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
        }

        .ev-gallery-cat {
            font-size: 0.78rem;
            color: var(--ev-text-muted);
        }

        /* Empty State */
        .ev-ct-empty-state i {
            font-size: 3rem;
            color: var(--ev-text-muted);
            opacity: 0.3;
        }

        /* ===== AJAX Loading State ===== */
        .ev-ct-main {
            position: relative;
            min-height: 220px;
        }

        .ev-ct-main.is-loading {
            opacity: 0.45;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .ev-ct-main.is-loading::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: var(--ev-radius-pill);
            background: linear-gradient(90deg, var(--ev-green) 0%, var(--ev-warm-gold) 50%, var(--ev-green) 100%);
            background-size: 200% 100%;
            animation: evCtLoading 1.1s linear infinite;
            z-index: 5;
        }

        @keyframes evCtLoading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Hide overlay style from base (not used in gallery) */
        .ev-gallery-card .ev-template-overlay {
            display: none;
        }

        /* ===== Responsive ===== */
        @media (max-width: 1080px) {
            .ev-gallery-layout {
                grid-template-columns: 1fr;
            }

            .ev-ct-sidebar {
                display: none;
            }

            .ev-gallery-layout.filters-hidden .ev-ct-sidebar {
                display: none;
            }

            .ev-ct-filter-toggle {
                display: none;
            }

            .ev-gallery-layout .ev-templates-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .ev-gallery-layout.filters-hidden .ev-templates-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {

            .ev-gallery-layout .ev-templates-grid,
            .ev-gallery-layout.filters-hidden .ev-templates-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .ev-ct-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .ev-ct-filter-toggle-text {
                display: none;
            }

            .ev-ct-filter-toggle {
                width: 40px;
                height: 40px;
                padding: 0;
                justify-content: center;
                border-radius: 50%;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {

            .ev-gallery-layout .ev-templates-grid,
            .ev-gallery-layout.filters-hidden .ev-templates-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@push('scripts')
<script>
    (function () {
        const doc = document;
        const results = doc.getElementById('evCtResults');
        const layout = doc.getElementById('templates');
        if (!results || !layout) return;

        let controller = null;

        function csrfToken() {
            return doc.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        }

        function syncToggleLabel() {
            const btn = results.querySelector('#filterToggle');
            if (!btn) return;
            const label = btn.querySelector('.ev-ct-filter-toggle-text');
            const hidden = layout.classList.contains('filters-hidden');
            btn.setAttribute('aria-expanded', hidden ? 'false' : 'true');
            if (label) label.textContent = hidden ? 'Tampilkan filter' : 'Sembunyikan filter';
        }

        function syncFilterStates(url) {
            const params = new URLSearchParams(url.search);

            doc.querySelectorAll('[data-filter-price]').forEach(el => {
                el.classList.toggle('active', params.get('is_premium') === el.dataset.filterPrice);
            });

            doc.querySelectorAll('[data-filter-type]').forEach(el => {
                el.classList.toggle('active', params.get('type') === el.dataset.filterType);
            });

            doc.querySelectorAll('[data-filter-category]').forEach(el => {
                const value = el.dataset.filterCategory;
                const current = params.get('category');
                const isAll = value === '';
                el.classList.toggle('active', isAll ? (!current || current === 'All') : current === value);
            });
        }

        function syncFilterLinks(url) {
            const params = new URLSearchParams(url.search);
            const base = window.location.pathname;

            params.delete('page');

            function build(mutate) {
                const next = new URLSearchParams(params);
                mutate(next);
                const query = next.toString();
                return base + (query ? '?' + query : '') + '#templates';
            }

            doc.querySelectorAll('[data-filter-price]').forEach(el => {
                const value = el.dataset.filterPrice;
                el.setAttribute('href', build(next => {
                    if (params.get('is_premium') === value) {
                        next.delete('is_premium');
                    } else {
                        next.set('is_premium', value);
                    }
                }));
            });

            doc.querySelectorAll('[data-filter-type]').forEach(el => {
                const value = el.dataset.filterType;
                el.setAttribute('href', build(next => {
                    if (params.get('type') === value) {
                        next.delete('type');
                    } else {
                        next.set('type', value);
                    }
                }));
            });

            doc.querySelectorAll('[data-filter-category]').forEach(el => {
                const value = el.dataset.filterCategory;
                el.setAttribute('href', build(next => {
                    if (!value || params.get('category') === value) {
                        next.delete('category');
                    } else {
                        next.set('category', value);
                    }
                }));
            });

            doc.querySelectorAll('.ev-ct-sidebar-clear').forEach(el => {
                el.setAttribute('href', base + '#templates');
            });

            const searchForm = doc.querySelector('.ev-ct-search-box');
            if (searchForm) {
                searchForm.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
                ['is_premium', 'category', 'type', 'sort'].forEach(key => {
                    const value = params.get(key);
                    if (!value) return;
                    const input = doc.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    searchForm.appendChild(input);
                });
                const searchInput = searchForm.querySelector('input[name="search"]');
                if (searchInput) searchInput.value = params.get('search') || '';
            }
        }

        function syncRobotsMeta(url) {
            const meta = doc.querySelector('meta[name="robots"]');
            if (!meta) return;
            const hasSearch = new URLSearchParams(url.search).has('search');
            meta.setAttribute('content', hasSearch
                ? 'noindex, nofollow'
                : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1');
        }

        function revealCards() {
            const cards = results.querySelectorAll('.reveal');
            if (!('IntersectionObserver' in window)) {
                cards.forEach(el => el.classList.add('active'));
                return;
            }
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08 });
            cards.forEach(el => observer.observe(el));
        }

        function load(url, pushState) {
            if (controller) controller.abort();
            controller = new AbortController();

            results.classList.add('is-loading');

            const target = new URL(url, window.location.origin);
            target.hash = '';

            fetch(target.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'text/html'
                },
                signal: controller.signal
            })
            .then(response => {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return response.text();
            })
            .then(html => {
                results.innerHTML = html;
                syncFilterStates(target);
                syncFilterLinks(target);
                syncToggleLabel();
                syncRobotsMeta(target);
                revealCards();

                const clean = target.pathname + target.search;
                if (pushState) {
                    history.pushState({ evGallery: true }, '', clean);
                } else {
                    history.replaceState({ evGallery: true }, '', clean);
                }
            })
            .catch(error => {
                if (error.name === 'AbortError') return;
                window.location.href = url;
            })
            .finally(() => {
                results.classList.remove('is-loading');
            });
        }

        doc.addEventListener('click', function (e) {
            const link = e.target.closest('a[data-ajax-link]');
            if (link) {
                e.preventDefault();
                load(link.getAttribute('href'), true);
                return;
            }

            const toggle = e.target.closest('#filterToggle');
            if (toggle) {
                layout.classList.toggle('filters-hidden');
                syncToggleLabel();
                return;
            }

            const likeBtn = e.target.closest('.ev-like-btn');
            if (likeBtn) {
                e.preventDefault();
                if (likeBtn.classList.contains('processing')) return;
                likeBtn.classList.add('processing');

                const id = likeBtn.getAttribute('data-id');
                const countSpan = likeBtn.querySelector('.ev-likes-count');
                const heartIcon = likeBtn.querySelector('i');

                fetch(`/templates/${id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && countSpan) {
                        countSpan.textContent = data.likes_count.toLocaleString();
                        heartIcon.classList.add('bi-heart');
                        heartIcon.classList.remove('bi-heart-fill');
                        setTimeout(() => {
                            heartIcon.classList.remove('bi-heart');
                            heartIcon.classList.add('bi-heart-fill');
                        }, 180);
                    }
                    likeBtn.classList.remove('processing');
                })
                .catch(err => {
                    console.error(err);
                    likeBtn.classList.remove('processing');
                });
            }
        });

        doc.addEventListener('submit', function (e) {
            const form = e.target.closest('form[data-ajax-form]');
            if (!form) return;
            e.preventDefault();

            const url = new URL(form.getAttribute('action') || window.location.href, window.location.origin);
            const data = new URLSearchParams(new FormData(form));
            data.delete('_token');
            url.search = data.toString();
            load(url.toString(), true);
        });

        doc.addEventListener('change', function (e) {
            const select = e.target.closest('select[data-ajax-sort]');
            if (!select) return;
            const form = select.closest('form');
            if (form) form.requestSubmit();
        });

        window.addEventListener('popstate', function () {
            load(window.location.href, false);
        });

        syncToggleLabel();
        syncFilterStates(window.location.href);
        syncFilterLinks(window.location.href);
    })();
</script>
@endpush

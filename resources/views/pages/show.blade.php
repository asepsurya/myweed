@extends('layouts.page')

@section('content')
    {{-- Breadcrumb --}}
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Halaman</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($page->title, 48) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="ev-section-light">
        <div class="container">
            @php
                $colClass = match ($page->template) {
                    'full' => 'col-12',
                    'minimal' => 'col-lg-6',
                    default => 'col-lg-8',
                };
            @endphp>

            <div class="row justify-content-center">
                <article class="{{ $colClass }}">
                    <div class="text-center mb-4">
                        <h1 class="ev-static-title">{{ $page->title }}</h1>
                        @if($page->excerpt)
                            <p class="ev-static-lead">{{ $page->excerpt }}</p>
                        @endif
                    </div>

                    @if($page->image)
                        <img src="{{ asset('storage/'.$page->image) }}"
                             alt="{{ $page->title }}"
                             class="ev-article-cover mb-4">
                    @endif

                    <div class="ev-article-content">
                        {!! $page->content !!}
                    </div>

                    <hr class="my-5">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <a href="{{ route('pages.index') }}" class="ev-btn-hero-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Semua Halaman
                        </a>
                        <a href="{{ route('landing') }}" class="ev-btn-hero-secondary">
                            Beranda <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    @push('styles')
    <style>
        .ev-static-title {
            font-size: clamp(1.6rem, 3.4vw, 2.5rem);
            line-height: 1.25;
            font-weight: 800;
            color: var(--ev-text-primary);
            margin: 0.75rem 0 1rem;
        }

        .ev-static-lead {
            font-size: 1.1rem;
            line-height: 1.8;
            font-weight: 500;
            color: var(--ev-text-primary);
            padding-left: 1rem;
            border-left: 3px solid var(--ev-green, #16a34a);
            margin-bottom: 2rem;
        }

        .ev-article-content {
            font-size: 1.02rem;
            line-height: 1.85;
            color: #374151;
        }

        .ev-article-content h2 {
            font-size: 1.45rem;
            font-weight: 700;
            color: var(--ev-text-primary);
            margin: 2.2rem 0 0.8rem;
            line-height: 1.35;
        }

        .ev-article-content h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--ev-text-primary);
            margin: 1.8rem 0 0.6rem;
        }

        .ev-article-content p {
            margin-bottom: 1.15rem;
        }

        .ev-article-content ul,
        .ev-article-content ol {
            padding-left: 1.35rem;
            margin-bottom: 1.35rem;
        }

        .ev-article-content li {
            margin-bottom: 0.45rem;
        }

        .ev-article-content blockquote {
            border-left: 3px solid var(--ev-green, #16a34a);
            background: #f9fafb;
            margin: 1.6rem 0;
            padding: 1rem 1.25rem;
            border-radius: 0 0.5rem 0.5rem 0;
            color: #4b5563;
            font-style: italic;
        }

        .ev-article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 1.25rem 0;
        }

        .ev-article-content a {
            color: var(--ev-green, #16a34a);
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .ev-article-cover {
            width: 100%;
            max-height: 460px;
            object-fit: cover;
            border-radius: var(--ev-radius-lg, 1rem);
            display: block;
        }

        @media (max-width: 575.98px) {
            .ev-static-lead {
                font-size: 1rem;
            }

            .ev-article-content {
                font-size: 0.98rem;
            }
        }
    </style>
    @endpush
@endsection
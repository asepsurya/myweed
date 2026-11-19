@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Inspirasi &amp; Panduan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 48) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="ev-section-light">
        <div class="container">
            <div class="row justify-content-center">
                <article class="col-lg-8">

                    <div class="text-center mb-4">
                        <span class="ev-blog-tag">
                            {{ $blog->type === 'panduan' ? 'Panduan' : 'Inspirasi' }}
                        </span>
                        <h1 class="ev-article-title">{{ $blog->title }}</h1>

                        <div class="ev-article-meta">
                            <span><i class="bi bi-calendar3 me-1"></i>{{ $blog->created_at?->translatedFormat('d M Y') }}</span>
                            <span class="mx-2">•</span>
                            <span><i class="bi bi-clock me-1"></i>{{ $readingMinutes }} menit baca</span>
                        </div>
                    </div>

                    @if($blog->image)
                        <img src="{{ Storage::url($blog->image) }}"
                             alt="{{ $blog->title }}"
                             class="ev-article-cover mb-4">
                    @endif

                    @if($blog->excerpt)
                        <p class="ev-article-lead">{{ $blog->excerpt }}</p>
                    @endif

                    <div class="ev-article-content">
                        {!! $blog->content !!}
                    </div>

                    <hr class="my-5">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <a href="{{ route('blog.index') }}" class="ev-btn-hero-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Semua Artikel
                        </a>
                        <a href="{{ route('landing') }}#inspirasi" class="ev-btn-hero-secondary">
                            Buat Undangan Anda <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </article>
            </div>

            @if($related->isNotEmpty())
                <div class="mt-5 pt-4">
                    <h2 class="ev-section-title h4 mb-4 text-center">Artikel Lainnya</h2>
                    <div class="ev-blog-grid">
                        @foreach($related as $item)
                            <a href="{{ route('blog.show', $item->slug) }}"
                               class="ev-blog-card text-decoration-none">
                                <div class="ev-blog-img-box">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" loading="lazy">
                                    @else
                                        <img src="https://picsum.photos/seed/{{ $item->slug }}/500/320"
                                             alt="{{ $item->title }}" loading="lazy">
                                    @endif
                                </div>
                                <div class="ev-blog-body">
                                    <span class="ev-blog-tag">
                                        {{ $item->type === 'panduan' ? 'Panduan' : 'Inspirasi' }}
                                    </span>
                                    <h4 class="ev-blog-title">{{ $item->title }}</h4>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @push('styles')
    <style>
        .ev-article-title {
            font-size: clamp(1.6rem, 3.4vw, 2.5rem);
            line-height: 1.25;
            font-weight: 800;
            color: var(--ev-text-primary);
            margin: 0.75rem 0 1rem;
        }

        .ev-article-meta {
            font-size: 0.9rem;
            color: var(--ev-text-muted);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .ev-article-cover {
            width: 100%;
            max-height: 460px;
            object-fit: cover;
            border-radius: var(--ev-radius-lg, 1rem);
            display: block;
        }

        .ev-article-lead {
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

        @media (max-width: 575.98px) {
            .ev-article-lead {
                font-size: 1rem;
            }

            .ev-article-content {
                font-size: 0.98rem;
            }
        }
    </style>
    @endpush
@endsection
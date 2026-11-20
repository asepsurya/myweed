@extends('layouts.page')

@section('content')
    <!-- Page Header -->
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Inspirasi &amp; Panduan</li>
                </ol>
            </nav>
            <h1>Inspirasi &amp; Panduan Pernikahan</h1>
            <p>Tips, tren, dan checklist untuk menyelenggarakan pernikahan impian Anda.</p>
        </div>
    </section>

    <section class="ev-section-light">
        <div class="container">
            <div class="ev-blog-grid">
                @forelse($blogs as $blog)
                    <a href="{{ route('blog.show', $blog->slug) }}"
                       class="ev-blog-card reveal reveal-d{{ min($loop->iteration, 4) }} text-decoration-none">
                        <div class="ev-blog-img-box">
                            @if($blog->image)
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" loading="lazy">
                            @else
                                <img src="https://picsum.photos/seed/{{ $blog->slug }}/500/320"
                                     alt="{{ $blog->title }}" loading="lazy">
                            @endif
                        </div>
                        <div class="ev-blog-body">
                            <span class="ev-blog-tag">
                                {{ $blog->type === 'panduan' ? 'Panduan' : 'Inspirasi' }}
                            </span>
                            <h4 class="ev-blog-title">{{ $blog->title }}</h4>
                            @if($blog->snippet)
                                <p class="ev-blog-excerpt">
                                    {{ Str::limit($blog->snippet, 120, '......') }}
                                </p>
                            @endif
                            <span class="ev-blog-meta ev-blog-meta-stats">
                                <span><i class="bi bi-calendar3 me-1"></i>{{ $blog->created_at?->translatedFormat('d M Y') }}</span>
                                <span><i class="bi bi-eye me-1"></i>{{ number_format($blog->views_count ?? 0, 0, ',', '.') }}</span>
                                <span><i class="bi bi-heart me-1"></i>{{ $blog->likes_count }}</span>
                                <span><i class="bi bi-chat me-1"></i>{{ $blog->comments_count }}</span>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-journal-text" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada artikel yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $blogs->links() }}
            </div>
        </div>
    </section>
@endsection
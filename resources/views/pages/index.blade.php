@extends('layouts.page')

@section('content')
    {{-- Page Header --}}
    <section class="ev-page-hero">
        <div class="container ev-page-hero-content">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}"><i class="bi bi-house-door me-1"></i> Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Halaman</li>
                </ol>
            </nav>
            <h1>Halaman</h1>
            <p>Temukan berbagai informasi dan halaman layanan RuangUndang.</p>
        </div>
    </section>

    <section class="ev-section-light">
        <div class="container">
            <div class="ev-blog-grid">
                @forelse($pages as $page)
                    <a href="{{ route('pages.show', $page->slug) }}"
                       class="ev-blog-card reveal reveal-d{{ min($loop->iteration, 4) }} text-decoration-none">
                        <div class="ev-blog-img-box">
                            @if($page->image)
                                <img src="{{ asset('storage/'.$page->image) }}" alt="{{ $page->title }}" loading="lazy">
                            @else
                                <img src="https://picsum.photos/seed/{{ $page->slug }}/500/320"
                                     alt="{{ $page->title }}" loading="lazy">
                            @endif
                        </div>
                        <div class="ev-blog-body">
                            <span class="ev-blog-tag">{{ $page->template_label }}</span>
                            <h4 class="ev-blog-title">{{ $page->title }}</h4>
                            @if($page->snippet)
                                <p class="ev-blog-excerpt">{{ Str::limit($page->snippet, 120, '......') }}</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="text-muted mt-3 mb-0">Belum ada halaman yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
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

                        <div class="ev-article-stats">
                            <span><i class="bi bi-eye me-1"></i>{{ number_format($blog->views_count ?? 0, 0, ',', '.') }} view</span>
                            <span class="ev-article-stats-sep"></span>
                            <span><i class="bi bi-chat me-1"></i>{{ $blog->comments_count }} komentar</span>
                            <span class="ev-article-stats-sep"></span>
                            <button type="button" id="likeBtn"
                                    class="ev-like-btn {{ $liked ? 'is-liked' : '' }}"
                                    data-url="{{ route('blog.like', $blog->slug) }}"
                                    aria-pressed="{{ $liked ? 'true' : 'false' }}">
                                <i class="bi bi-heart{{ $liked ? '-fill' : '' }} me-1"></i>
                                <span id="likeCount">{{ $blog->likes_count }}</span> suka
                            </button>
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

                    <!-- Komentar -->
                    <section class="ev-comments mt-5">
                        <h2 class="ev-comments-title">
                            <i class="bi bi-chat-text me-2"></i>Komentar
                            <span class="ev-comments-count">{{ $blog->comments_count }}</span>
                        </h2>

                        @if(session('success'))
                            <div class="alert alert-success rounded-3 py-2 small">{{ session('success') }}</div>
                        @endif

                        <div class="ev-comments-list">
                            @if($comments->isEmpty())
                                <p class="text-muted small mb-0">Belum ada komentar. Jadilah yang pertama!</p>
                            @else
                                @include('pages.blog.partials.comment', ['comments' => $comments])
                            @endif
                        </div>

                        @auth
                            <form action="{{ route('blog.comment', $blog->slug) }}" method="POST"
                                  class="ev-comment-form mt-4" id="commentForm">
                                @csrf
                                <input type="hidden" name="parent_id" id="parent_id" value="{{ old('parent_id') }}">

                                <div class="ev-replying-to d-none" id="replyingTo">
                                    <i class="bi bi-reply me-1"></i>Membalas <strong id="replyingToName"></strong>
                                    <button type="button" class="btn btn-sm btn-link p-0 ms-2 align-baseline" id="cancelReply">Batal</button>
                                </div>
                                @error('parent_id')
                                    <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror

                                <div class="mb-3">
                                    <label for="author_name" class="form-label small fw-semibold">Nama</label>
                                    <input type="text" id="author_name" name="author_name"
                                           class="form-control rounded-3"
                                           value="{{ old('author_name', auth()->user()?->name) }}"
                                           maxlength="100" required>
                                    @error('author_name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label small fw-semibold">Komentar</label>
                                    <textarea id="content" name="content" rows="3" class="form-control rounded-3"
                                              maxlength="2000" placeholder="Tulis komentar Anda..." required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="ev-btn-hero-secondary">
                                    <i class="bi bi-send me-1"></i> <span id="submitLabel">Kirim Komentar</span>
                                </button>
                            </form>
                        @else
                            <div class="ev-comment-login mt-4">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                <span>Silakan <a href="{{ route('login') }}">login</a> terlebih dahulu untuk menulis komentar.</span>
                                <a href="{{ route('login') }}" class="ev-btn-hero-secondary ms-lg-2 mt-2 mt-lg-0">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Berkomentar
                                </a>
                            </div>
                        @endauth
                    </section>
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

        .ev-article-stats {
            margin-top: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.85rem;
            font-size: 0.85rem;
            color: var(--ev-text-muted);
        }

        .ev-article-stats-sep {
            width: 1px;
            height: 14px;
            background: var(--ev-border-light, #e5e7eb);
        }

        .ev-like-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border: 1px solid var(--ev-border-light, #e5e7eb);
            background: var(--ev-bg-white, #fff);
            color: var(--ev-text-muted);
            border-radius: 999px;
            padding: 0.35rem 0.9rem;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .ev-like-btn:hover {
            border-color: var(--ev-green, #16a34a);
            color: var(--ev-green, #16a34a);
        }

        .ev-like-btn.is-liked {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.35);
            color: #ef4444;
        }

        .ev-comments {
            border-top: 1px solid var(--ev-border-light, #e5e7eb);
            padding-top: 2rem;
        }

        .ev-comments-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--ev-text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .ev-comments-count {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--ev-green, #16a34a);
            background: rgba(22, 163, 74, 0.12);
            border-radius: 999px;
            padding: 0.15rem 0.6rem;
        }

        .ev-comment {
            display: flex;
            gap: 0.9rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--ev-border-light, #e5e7eb);
        }

        .ev-comment:last-child {
            border-bottom: 0;
        }

        .ev-comment-avatar {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--ev-green, #16a34a), #0f766e);
        }

        .ev-comment-body {
            flex: 1;
            min-width: 0;
        }

        .ev-comment-head {
            display: flex;
            align-items: baseline;
            gap: 0.6rem;
            flex-wrap: wrap;
            margin-bottom: 0.25rem;
        }

        .ev-comment-head strong {
            font-size: 0.95rem;
            color: var(--ev-text-primary);
        }

        .ev-comment-head span {
            font-size: 0.78rem;
            color: var(--ev-text-muted);
        }

        .ev-comment-text {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #374151;
            margin: 0;
            white-space: pre-line;
            word-break: break-word;
        }

        .ev-reply-btn {
            margin-top: 0.4rem;
            background: none;
            border: 0;
            padding: 0;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--ev-green, #16a34a);
            cursor: pointer;
        }

        .ev-reply-btn:hover {
            text-decoration: underline;
        }

        .ev-comment-replies {
            margin-top: 0.9rem;
            padding-left: 1rem;
            border-left: 2px solid var(--ev-border-light, #e5e7eb);
        }

        .ev-comment-replies .ev-comment {
            padding: 0.6rem 0;
        }

        .ev-comment-replies .ev-comment-avatar {
            width: 34px;
            height: 34px;
            font-size: 0.85rem;
        }

        .ev-replying-to {
            display: flex;
            align-items: center;
            gap: 0.35rem;
            background: rgba(22, 163, 74, 0.08);
            border: 1px solid rgba(22, 163, 74, 0.2);
            color: var(--ev-text-primary);
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
            margin-bottom: 0.85rem;
        }

        .ev-comment-login {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            background: var(--ev-bg-subtle, #f9fafb);
            border: 1px solid var(--ev-border-light, #e5e7eb);
            border-radius: 0.75rem;
            padding: 1rem 1.25rem;
            color: var(--ev-text-muted);
            font-size: 0.9rem;
        }

        .ev-comment-login a {
            color: var(--ev-green, #16a34a);
            font-weight: 600;
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const likeBtn = document.getElementById('likeBtn');
            if (!likeBtn) return;

            const likeCount = document.getElementById('likeCount');
            const icon = likeBtn.querySelector('i');
            const token = document.querySelector('meta[name="csrf-token"]')?.content;

            likeBtn.addEventListener('click', async function () {
                if (likeBtn.disabled) return;
                likeBtn.disabled = true;

                try {
                    const res = await fetch(likeBtn.dataset.url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await res.json();

                    if (data.success) {
                        likeBtn.classList.toggle('is-liked', data.liked);
                        likeBtn.setAttribute('aria-pressed', data.liked ? 'true' : 'false');
                        likeCount.textContent = data.likes_count;
                        icon.classList.toggle('bi-heart', !data.liked);
                        icon.classList.toggle('bi-heart-fill', data.liked);
                    }
                } catch (e) {
                    console.error('Gagal memproses like:', e);
                } finally {
                    likeBtn.disabled = false;
                }
            });

            // --- Balasan komentar (hanya untuk pengguna login) ---
            const form = document.getElementById('commentForm');
            const parentIdInput = document.getElementById('parent_id');
            const replyingTo = document.getElementById('replyingTo');
            const replyingToName = document.getElementById('replyingToName');
            const cancelReply = document.getElementById('cancelReply');
            const contentInput = document.getElementById('content');
            const submitLabel = document.getElementById('submitLabel');

            if (form && parentIdInput && contentInput && submitLabel && replyingTo && replyingToName) {
                function setReplyTarget(id, name) {
                    parentIdInput.value = id || '';
                    replyingToName.textContent = name || '';
                    replyingTo.classList.toggle('d-none', !id);
                    submitLabel.textContent = id ? 'Kirim Balasan' : 'Kirim Komentar';

                    if (id) {
                        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        setTimeout(() => contentInput.focus(), 300);
                    }
                }

                document.querySelectorAll('.ev-reply-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        setReplyTarget(btn.dataset.parentId, btn.dataset.parentName);
                    });
                });

                if (cancelReply) {
                    cancelReply.addEventListener('click', () => setReplyTarget('', ''));
                }

                // Pulihkan konteks balasan jika validasi gagal.
                if (parentIdInput.value) {
                    const replyBtn = document.querySelector(`.ev-reply-btn[data-parent-id="${parentIdInput.value}"]`);
                    if (replyBtn) {
                        setReplyTarget(replyBtn.dataset.parentId, replyBtn.dataset.parentName);
                    }
                }
            }
        });
    </script>
    @endpush
@endsection
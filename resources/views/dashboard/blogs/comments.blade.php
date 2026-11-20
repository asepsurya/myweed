<x-app-layout>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h4 class="fw-bold mb-0" style="font-family: 'Plus Jakarta Sans', sans-serif;">Komentar Blog</h4>
                    <span class="badge rounded-pill px-2.5 py-1 small"
                        style="background: rgba(198, 169, 98, 0.15); color: #A68B4B; border: 1px solid rgba(198, 169, 98, 0.3);">
                        {{ $comments->total() }} Komentar
                    </span>
                </div>
                <p class="text-muted mb-0 small">Kelola dan moderasi komentar pengunjung pada artikel blog</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <!-- Filter -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body py-3">
                <form method="GET" action="{{ route('admin.blogs.comments') }}" class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label for="blog" class="form-label small fw-semibold mb-1">Filter Artikel</label>
                        <select name="blog" id="blog" class="form-select rounded-3"
                            onchange="this.form.submit()">
                            <option value="">Semua Artikel</option>
                            @foreach($blogs as $item)
                                <option value="{{ $item->id }}" @selected($selectedBlog === (int) $item->id)>
                                    {{ $item->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-funnel me-1"></i> Terapkan
                        </button>
                        @if($selectedBlog)
                            <a href="{{ route('admin.blogs.comments') }}" class="btn btn-light rounded-pill px-4">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Komentar -->
        <div class="d-flex flex-column gap-3">
            @forelse($comments as $comment)
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 text-white fw-bold"
                                style="width: 44px; height: 44px; background: linear-gradient(135deg, #16a34a, #0f766e);">
                                {{ strtoupper(mb_substr($comment->author_name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                    <strong>{{ $comment->author_name }}</strong>
                                    @if($comment->parent)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">
                                            <i class="bi bi-reply me-1"></i>Membalas {{ $comment->parent->author_name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Komentar</span>
                                    @endif
                                    <span class="text-muted small ms-auto">{{ $comment->created_at?->diffForHumans() }}</span>
                                </div>

                                <p class="mb-2" style="white-space: pre-line; word-break: break-word;">{{ $comment->content }}</p>

                                <div class="d-flex flex-wrap align-items-center gap-3 small">
                                    <span class="text-muted">
                                        <i class="bi bi-journal-text me-1"></i>
                                        <a href="{{ route('admin.blogs.edit', $comment->blog) }}" class="text-decoration-none">
                                            {{ $comment->blog?->title ?? 'Artikel dihapus' }}
                                        </a>
                                    </span>
                                    @if($comment->user)
                                        <span class="text-muted"><i class="bi bi-person me-1"></i>{{ $comment->user->email }}</span>
                                    @endif
                                    <div class="ms-auto d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-success rounded-pill"
                                            onclick="toggleReply({{ $comment->id }})">
                                            <i class="bi bi-reply me-1"></i> Balas
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill"
                                            onclick="confirmDeleteComment({{ $comment->id }})">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </div>
                                </div>

                                <form id="reply-form-{{ $comment->id }}"
                                    action="{{ route('admin.blogs.comments.reply', $comment) }}" method="POST"
                                    class="reply-box mt-3 d-none">
                                    @csrf
                                    <label class="form-label small fw-semibold mb-1" for="reply-content-{{ $comment->id }}">
                                        <i class="bi bi-reply me-1"></i>Balas komentar {{ $comment->author_name }}
                                    </label>
                                    <textarea name="content" id="reply-content-{{ $comment->id }}" rows="2"
                                        maxlength="2000" class="form-control rounded-3 mb-2"
                                        placeholder="Tulis balasan Anda..." required></textarea>
                                    <button type="submit" class="btn btn-sm btn-success rounded-pill">
                                        <i class="bi bi-send me-1"></i> Kirim Balasan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <form id="delete-comment-form-{{ $comment->id }}"
                    action="{{ route('admin.blogs.comments.destroy', $comment) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            @empty
                <div class="card border-0 shadow-sm text-center py-5 rounded-4">
                    <div class="card-body">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                            style="width: 72px; height: 72px; background: rgba(198, 169, 98, 0.12); color: #C6A962;">
                            <i class="bi bi-chat-dots fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-1">Belum Ada Komentar</h5>
                        <p class="text-muted small mb-0">Komentar pengunjung pada artikel blog akan tampil di sini.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($comments->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function confirmDeleteComment(id) {
            if (confirm('Hapus komentar ini beserta seluruh balasannya?')) {
                document.getElementById('delete-comment-form-' + id).submit();
            }
        }

        function toggleReply(id) {
            const form = document.getElementById('reply-form-' + id);
            if (!form) return;
            form.classList.toggle('d-none');
            if (!form.classList.contains('d-none')) {
                const textarea = form.querySelector('textarea');
                if (textarea) textarea.focus();
            }
        }
    </script>
    @endpush
</x-app-layout>
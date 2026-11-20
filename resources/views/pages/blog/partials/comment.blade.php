@foreach($comments as $comment)
    <div class="ev-comment" id="comment-{{ $comment->id }}">
        <div class="ev-comment-avatar">
            {{ strtoupper(mb_substr($comment->author_name, 0, 1)) }}
        </div>
        <div class="ev-comment-body">
            <div class="ev-comment-head">
                <strong>{{ $comment->author_name }}</strong>
                <span>{{ $comment->created_at?->diffForHumans() }}</span>
            </div>
            <p class="ev-comment-text">{{ $comment->content }}</p>
            @auth
                <button type="button" class="ev-reply-btn"
                        data-parent-id="{{ $comment->id }}"
                        data-parent-name="{{ $comment->author_name }}">
                    <i class="bi bi-reply me-1"></i>Balas
                </button>
            @endauth

            @if($comment->replies->isNotEmpty())
                <div class="ev-comment-replies">
                    @include('pages.blog.partials.comment', ['comments' => $comment->replies])
                </div>
            @endif
        </div>
    </div>
@endforeach
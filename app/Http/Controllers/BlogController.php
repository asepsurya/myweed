<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::withCount(['likes', 'comments'])->ordered();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $blogs = $query->get();

        return view('dashboard.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('dashboard.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'type' => 'required|in:inspirasi,panduan',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|file|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs/images', 'public');
        }

        $isPublished = $request->input('status', 'published') === 'published';

        Blog::create(array_merge(Arr::except($validated, ['status', 'is_active']), [
            'image' => $imagePath,
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $isPublished,
        ]));

        return redirect()->route('admin.blogs.index')
            ->with('success', $isPublished
                ? 'Blog berhasil dipublikasikan.'
                : 'Draft blog berhasil disimpan.');
    }

    public function edit(Blog $blog)
    {
        return view('dashboard.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255|unique:blogs,title,' . $blog->id,
            'slug' => 'sometimes|required|string|max:255|unique:blogs,slug,' . $blog->id,
            'type' => 'sometimes|required|in:inspirasi,panduan',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|file|image|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $validated['title'] ?? $blog->title,
            'slug' => $validated['slug'] ?? $blog->slug,
            'type' => $validated['type'] ?? $blog->type,
            'content' => $validated['content'] ?? $blog->content,
            'excerpt' => $validated['excerpt'] ?? $blog->excerpt,
            'sort_order' => $validated['sort_order'] ?? $blog->sort_order,
        ];

        // Status dari tombol Simpan Draft / Publikasikan
        if ($request->has('status')) {
            $data['is_active'] = $request->input('status') === 'published';
        } else {
            $data['is_active'] = $validated['is_active'] ?? $blog->is_active;
        }

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs/images', 'public');
        }

        $blog->update($data);

        $wasPublished = $data['is_active'];

        return redirect()->route('admin.blogs.index')
            ->with('success', $wasPublished
                ? 'Blog berhasil diperbarui dan dipublikasikan.'
                : 'Blog berhasil diperbarui dan disimpan sebagai draft.');
    }

    /**
     * Daftar artikel publik (Inspirasi & Panduan).
     */
    public function publicIndex()
    {
        $blogs = Blog::withCount(['likes', 'comments'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(12);

        $seoTitle = 'Inspirasi & Panduan Pernikahan - RuangUndang';
        $seoDescription = 'Kumpulan artikel inspirasi dan panduan pernikahan: tips persiapan, dekorasi, anggaran, dan checklist hari H.';
        $seoKeywords = 'inspirasi pernikahan, panduan pernikahan, tips wedding, dekorasi pernikahan, anggaran pernikahan';

        return view('pages.blog.index', compact(
            'blogs', 'seoTitle', 'seoDescription', 'seoKeywords'
        ));
    }

    /**
     * Detail satu artikel publik.
     */
    public function publicShow($slug)
    {
        $blog = Blog::withCount(['likes', 'comments'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Hitung view sekali per sesi pengunjung agar tidak dobel saat refresh.
        $viewKey = 'blog_viewed_'.$blog->id;
        if (! session()->has($viewKey)) {
            $blog->increment('views_count');
            session([$viewKey => true]);
        }

        $related = Blog::withCount(['likes', 'comments'])
            ->where('is_active', true)
            ->where('id', '!=', $blog->id)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        $comments = $blog->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id')
            ->oldest()
            ->get();

        $liked = $blog->likes()
            ->where('visitor_key', $this->visitorKey())
            ->exists();

        $seoTitle = $blog->title.' - RuangUndang';
        $seoDescription = $blog->excerpt ?: Str::limit(strip_tags($blog->content), 155);
        $seoKeywords = 'pernikahan, '.Str::slug($blog->type).', '.Str::slug($blog->title);
        $seoImage = $blog->image ? Storage::url($blog->image) : asset('assets/og-image.png');

        $readingMinutes = max(1, (int) ceil(str_word_count(strip_tags($blog->content)) / 200));

        return view('pages.blog.show', compact(
            'blog', 'related', 'comments', 'liked', 'seoTitle', 'seoDescription', 'seoKeywords', 'seoImage', 'readingMinutes'
        ));
    }

    /**
     * Toggle like artikel oleh pengunjung (pengguna login atau tamu via sesi).
     */
    public function toggleLike($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $key = $this->visitorKey();
        $like = $blog->likes()->where('visitor_key', $key)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            $blog->likes()->create([
                'visitor_key' => $key,
                'user_id' => auth()->id(),
            ]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $blog->likes()->count(),
        ]);
    }

    /**
     * Simpan komentar baru pada artikel.
     */
    public function storeComment(Request $request, $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $validated = $request->validate([
            'author_name' => 'nullable|string|max:100',
            'content' => 'required|string|max:2000',
            'parent_id' => 'nullable|integer|exists:blog_comments,id',
        ]);

        $parent = null;
        if (! empty($validated['parent_id'])) {
            $parent = BlogComment::where('id', $validated['parent_id'])
                ->where('blog_id', $blog->id)
                ->first();

            if (! $parent) {
                return back()->withErrors([
                    'parent_id' => 'Komentar yang dibalas tidak ditemukan.',
                ])->withInput();
            }
        }

        $blog->comments()->create([
            'user_id' => auth()->id(),
            'parent_id' => $parent?->id,
            'author_name' => ($validated['author_name'] ?? null) ?: auth()->user()->name,
            'content' => $validated['content'],
        ]);

        return redirect()
            ->route('blog.show', $blog->slug)
            ->with('success', $parent
                ? 'Balasan berhasil ditambahkan.'
                : 'Komentar berhasil ditambahkan.');
    }

    /**
     * Daftar komentar untuk admin (moderasi).
     */
    public function adminComments(Request $request)
    {
        $query = BlogComment::with(['user', 'blog', 'parent'])
            ->orderByDesc('created_at');

        if ($request->filled('blog')) {
            $query->where('blog_id', $request->integer('blog'));
        }

        $comments = $query->paginate(20)->withQueryString();

        $blogs = Blog::orderBy('title')->get(['id', 'title']);
        $selectedBlog = $request->integer('blog') ?: null;

        return view('dashboard.blogs.comments', compact('comments', 'blogs', 'selectedBlog'));
    }

    /**
     * Admin membalas komentar pengunjung.
     */
    public function replyComment(Request $request, BlogComment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment->replies()->create([
            'blog_id' => $comment->blog_id,
            'user_id' => auth()->id(),
            'parent_id' => $comment->id,
            'author_name' => auth()->user()->name,
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    /**
     * Hapus komentar beserta seluruh balasannya.
     */
    public function destroyComment(BlogComment $comment)
    {
        $this->deleteCommentTree($comment);

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Hapus komentar dan semua balasannya secara rekursif.
     */
    private function deleteCommentTree(BlogComment $comment): void
    {
        foreach ($comment->replies as $reply) {
            $this->deleteCommentTree($reply);
        }

        $comment->delete();
    }

    /**
     * Identitas unik pengunjung untuk keperluan like.
     */
    private function visitorKey(): string
    {
        if (auth()->check()) {
            return 'user:'.auth()->id();
        }

        $guestId = session('blog_guest_id');

        if (! $guestId) {
            $guestId = (string) Str::uuid();
            session(['blog_guest_id' => $guestId]);
        }

        return 'guest:'.$guestId;
    }

    public function toggleStatus(Blog $blog)
    {
        $blog->update(['is_active' => ! $blog->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status blog berhasil diubah.',
            'blog' => $blog->fresh(),
        ]);
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::ordered();

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
        $blogs = Blog::where('is_active', true)
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
        $blog = Blog::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Blog::where('is_active', true)
            ->where('id', '!=', $blog->id)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->take(3)
            ->get();

        $seoTitle = $blog->title.' - RuangUndang';
        $seoDescription = $blog->excerpt ?: Str::limit(strip_tags($blog->content), 155);
        $seoKeywords = 'pernikahan, '.Str::slug($blog->type).', '.Str::slug($blog->title);
        $seoImage = $blog->image ? Storage::url($blog->image) : asset('assets/og-image.png');

        $readingMinutes = max(1, (int) ceil(str_word_count(strip_tags($blog->content)) / 200));

        return view('pages.blog.show', compact(
            'blog', 'related', 'seoTitle', 'seoDescription', 'seoKeywords', 'seoImage', 'readingMinutes'
        ));
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
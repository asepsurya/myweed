<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Daftar halaman untuk admin.
     */
    public function index(Request $request)
    {
        $query = Page::ordered();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('slug', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $pages = $query->get();

        return view('dashboard.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('dashboard.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|file|image|max:2048',
            'template' => 'nullable|in:default,full,minimal',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pages/images', 'public');
        }

        $isPublished = $request->input('status', 'published') === 'published';

        Page::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'] ?? Str::slug($validated['title']),
            'content' => $validated['content'] ?? null,
            'excerpt' => $validated['excerpt'] ?? null,
            'image' => $imagePath,
            'template' => $validated['template'] ?? 'default',
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $isPublished,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', $isPublished
                ? 'Halaman berhasil dipublikasikan.'
                : 'Draft halaman berhasil disimpan.');
    }

    public function edit(Page $page)
    {
        return view('dashboard.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:pages,slug,'.$page->id,
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|file|image|max:2048',
            'template' => 'nullable|in:default,full,minimal',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'nullable|in:draft,published',
        ]);

        $data = [
            'title' => $validated['title'] ?? $page->title,
            'slug' => $validated['slug'] ?? $page->slug,
            'content' => $validated['content'] ?? $page->content,
            'excerpt' => $validated['excerpt'] ?? $page->excerpt,
            'template' => $validated['template'] ?? $page->template,
            'meta_title' => $validated['meta_title'] ?? $page->meta_title,
            'meta_description' => $validated['meta_description'] ?? $page->meta_description,
            'sort_order' => $validated['sort_order'] ?? $page->sort_order,
        ];

        if ($request->has('status')) {
            $data['is_active'] = $request->input('status') === 'published';
        } else {
            $data['is_active'] = $page->is_active;
        }

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $data['image'] = $request->file('image')->store('pages/images', 'public');
        }

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', $data['is_active']
                ? 'Halaman berhasil diperbarui dan dipublikasikan.'
                : 'Halaman berhasil diperbarui dan disimpan sebagai draft.');
    }

    public function toggleStatus(Page $page)
    {
        $page->update(['is_active' => ! $page->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status halaman berhasil diubah.',
            'page' => $page->fresh(),
        ]);
    }

    public function destroy(Page $page)
    {
        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Halaman berhasil dihapus.');
    }

    /**
     * Daftar halaman publik (yang sudah aktif).
     */
    public function publicIndex()
    {
        $pages = Page::active()->ordered()->get();

        $seoTitle = 'Halaman - RuangUndang';
        $seoDescription = 'Daftar halaman informasi RuangUndang: panduan, promo, dan informasi layanan undangan digital.';

        return view('pages.index', compact('pages', 'seoTitle', 'seoDescription'));
    }

    /**
     * Detail satu halaman publik.
     */
    public function publicShow($slug)
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        $seoTitle = ($page->meta_title ?: $page->title).' - RuangUndang';
        $seoDescription = $page->meta_description
            ?: ($page->excerpt ?: Str::limit(strip_tags((string) $page->content), 155));
        $seoImage = $page->image ? asset('storage/'.$page->image) : asset('assets/og-image.png');

        return view('pages.show', compact('page', 'seoTitle', 'seoDescription', 'seoImage'));
    }
}

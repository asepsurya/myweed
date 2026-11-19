<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'icon' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|image|max:2048',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'dynamic_fields' => 'nullable|array',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('categories/thumbnails', 'public');
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?: Str::slug($request->name),
            'icon' => $request->icon ?? 'bi-folder',
            'thumbnail' => $thumbnailPath,
            'description' => $request->description,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'dynamic_fields' => $request->dynamic_fields ?? [],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan.',
            'category' => $category,
        ], 201);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'sometimes|required|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|image|max:2048',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'dynamic_fields' => 'nullable|array',
        ]);

        $data = [];

        if ($request->has('name')) {
            $data['name'] = $request->name;
        }
        if ($request->has('slug')) {
            $data['slug'] = $request->slug;
        }
        if ($request->has('icon')) {
            $data['icon'] = $request->icon;
        }
        if ($request->has('description')) {
            $data['description'] = $request->description;
        }
        if ($request->has('sort_order')) {
            $data['sort_order'] = $request->sort_order;
        }
        if ($request->has('is_active')) {
            $data['is_active'] = $request->boolean('is_active');
        }
        if ($request->has('dynamic_fields')) {
            $data['dynamic_fields'] = $request->dynamic_fields;
        }

        if ($request->hasFile('thumbnail')) {
            if ($category->thumbnail) {
                Storage::disk('public')->delete($category->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('categories/thumbnails', 'public');
        }

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
            'category' => $category->fresh(),
        ]);
    }

    public function destroy(Category $category)
    {
        $templateCount = $category->templates()->count();

        if ($templateCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Kategori tidak bisa dihapus karena masih ada {$templateCount} template yang menggunakan kategori ini.",
            ], 422);
        }

        if ($category->thumbnail) {
            Storage::disk('public')->delete($category->thumbnail);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }

    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => ! $category->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status kategori berhasil diubah.',
            'category' => $category->fresh(),
        ]);
    }

    public function adminIndex()
    {
        $categories = Category::ordered()->withCount(['templates as active_template_count' => function ($q) {
            $q->where('is_active', true);
        }])->get();

        return view('dashboard.categories.index', compact('categories'));
    }

    public function adminCreate()
    {
        return view('dashboard.categories.create');
    }

    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'icon' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|image|max:2048',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'dynamic_fields' => 'nullable|array',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('categories/thumbnails', 'public');
        }

        Category::create(array_merge($validated, [
            'thumbnail' => $thumbnailPath,
            'icon' => $validated['icon'] ?? 'bi-folder',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'dynamic_fields' => $validated['dynamic_fields'] ?? [],
        ]));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function adminEdit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    public function adminUpdate(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|image|max:2048',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'dynamic_fields' => 'nullable|array',
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'icon' => $validated['icon'] ?? 'bi-folder',
            'description' => $validated['description'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'dynamic_fields' => $validated['dynamic_fields'] ?? [],
        ];

        if ($request->hasFile('thumbnail')) {
            if ($category->thumbnail) {
                Storage::disk('public')->delete($category->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('categories/thumbnails', 'public');
        } elseif ($request->boolean('remove_thumbnail')) {
            if ($category->thumbnail) {
                Storage::disk('public')->delete($category->thumbnail);
            }
            $data['thumbnail'] = null;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function adminDestroy(Category $category)
    {
        $templateCount = $category->templates()->count();

        if ($templateCount > 0) {
            return back()->with('error', "Kategori tidak bisa dihapus karena masih ada {$templateCount} template yang menggunakan kategori ini.");
        }

        if ($category->thumbnail) {
            Storage::disk('public')->delete($category->thumbnail);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}

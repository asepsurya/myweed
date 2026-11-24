<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('sort_order')->orderByDesc('id')->get();

        return view('dashboard.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('dashboard.promotions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,webm,ogv,ogg,m4v|max:51200',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'image.required' => 'Unggah gambar atau video promosi terlebih dahulu.',
        ]);

        // Ensure at least one media source is provided.
        if (! $request->hasFile('image') && ! $request->hasFile('video_file') && ! $request->filled('video_url')) {
            return back()->withErrors([
                'image' => 'Unggah gambar, video, atau isi link YouTube promosi terlebih dahulu.',
            ])->withInput();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        if ($request->hasFile('video_file')) {
            $validated['video_file'] = $request->file('video_file')->store('promotions', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Promotion::create($validated);

        return redirect()->route('promotions.index')->with('success', 'Promosi berhasil ditambahkan.');
    }

    public function edit(Promotion $promotion)
    {
        return view('dashboard.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'video_file' => 'nullable|file|mimes:mp4,mov,webm,ogv,ogg,m4v|max:51200',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
                Storage::disk('public')->delete($promotion->image);
            }
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        if ($request->hasFile('video_file')) {
            if ($promotion->video_file && Storage::disk('public')->exists($promotion->video_file)) {
                Storage::disk('public')->delete($promotion->video_file);
            }
            $validated['video_file'] = $request->file('video_file')->store('promotions', 'public');
        } elseif ($request->boolean('remove_video')) {
            if ($promotion->video_file && Storage::disk('public')->exists($promotion->video_file)) {
                Storage::disk('public')->delete($promotion->video_file);
            }
            $validated['video_file'] = null;
            $validated['video_url'] = null;
        }

        if ($request->boolean('remove_image') && ! $request->hasFile('image')) {
            if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
                Storage::disk('public')->delete($promotion->image);
            }
            $validated['image'] = null;
        }

        $validated['is_active'] = $request->has('is_active');

        $promotion->update($validated);

        return redirect()->route('promotions.index')->with('success', 'Promosi berhasil diperbarui.');
    }

    public function destroy(Promotion $promotion)
    {
        if ($promotion->image && Storage::disk('public')->exists($promotion->image)) {
            Storage::disk('public')->delete($promotion->image);
        }

        if ($promotion->video_file && Storage::disk('public')->exists($promotion->video_file)) {
            Storage::disk('public')->delete($promotion->video_file);
        }

        $promotion->delete();

        return redirect()->route('promotions.index')->with('success', 'Promosi berhasil dihapus.');
    }
}

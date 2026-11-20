<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('id')->get();

        return view('dashboard.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('dashboard.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'link_text' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Announcement::create($validated);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('dashboard.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'link_text' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $announcement->update($validated);

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{

    public function index(Request $request)
    {
        $musics = Music::all();
        return view('dashboard.music.index', compact('musics'));
    }
    // Form create
    public function create()
    {
        return view('music.create');
    }

    // Store music
    public function store(Request $request)
    {
       $request->validate([
        'file'  => 'required|file|max:40480',
        'cover' => 'nullable|image|max:2048'
    ]);

    // Upload audio
    $audioPath = $request->file('file')->store('music', 'public');

    // Upload cover
    $coverPath = $request->file('cover')
        ? $request->file('cover')->store('covers', 'public')
        : null;

    // Auto title from filename (FIX DI SINI)
    $title = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);

    Music::create([
        'title'      => $title,
        'artist'     => 'Wedding Music',
        'audio_url' =>$audioPath,
        'cover_url' => $coverPath,
        'duration'   => 'Auto',
        'category'   => 'Wedding',
        'mood'       => 'Romantic'
    ]);

    return back()->with('success', 'Music berhasil ditambahkan!');
    }

    // Edit form
    public function edit(Music $music)
    {
        return view('music.edit', compact('music'));
    }

    // Update
    public function update(Request $request, Music $music)
    {
        $music->update($request->all());

        return redirect()->route('music.index')
            ->with('success', 'Music updated!');
    }

    // Delete
    public function destroy(Music $music,$id)
    {
        $music = Music::findOrFail($id);

        // Hapus file audio
        if ($music->audio_url && \Storage::disk('public')->exists($music->audio_url)) {
            \Storage::disk('public')->delete($music->audio_url);
        }

        // Hapus cover jika ada
        if ($music->cover_url && \Storage::disk('public')->exists($music->cover_url)) {
            \Storage::disk('public')->delete($music->cover_url);
        }

        // Hapus waveform PNG jika ada
        if ($music->waveform_file && file_exists(public_path('waveforms/'.$music->waveform_file))) {
            unlink(public_path('waveforms/'.$music->waveform_file));
        }

        // Hapus record DB
        $music->delete();

        return back()->with('success', 'Music deleted!');
    }
}

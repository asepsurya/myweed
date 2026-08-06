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

    // Upload cover as webp
    $coverPath = null;
    if ($request->hasFile('cover')) {
        $tempSource = str_replace('\\', '/', sys_get_temp_dir() . '/' . uniqid() . '_' . $request->file('cover')->getClientOriginalName());
        $request->file('cover')->move(sys_get_temp_dir(), basename($tempSource));

        $destinationPath = storage_path('app/public/covers');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $destFile = $destinationPath . '/' . uniqid() . '.webp';

        $driver = new \Intervention\Image\Drivers\Gd\Driver();
        $manager = new \Intervention\Image\ImageManager($driver);
        $image = $manager->read($tempSource);
        $image->save($destFile, 75, 'webp');

        @unlink($tempSource);

        $coverPath = 'covers/' . basename($destFile);
    }

    // Auto title from filename
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

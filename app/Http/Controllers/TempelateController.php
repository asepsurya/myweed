<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Music;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;

class TempelateController extends Controller
{
    public function index(Request $request)
    {
      $tempelate = Template::all();
       $musics = Music::where('is_active', true)->get();
      return view('dashboard.tempelate.index', compact('tempelate','musics'));
    }
     public function store(Request $request)
    {
   $request->validate([
        'name' => 'required',
        'thumbnail' => 'required|image',
        'preview' => 'required|image',
        'zip' => 'required|mimes:zip'
    ]);

    $zip = new ZipArchive;
    $file = $request->file('zip');
    $zipPath = $file->getRealPath();

    if ($zip->open($zipPath) !== TRUE) {
        return back()->with('error', 'File ZIP tidak valid atau rusak.');
    }

    // Slug folder template
    $folderName = Str::slug($request->name);

    // Path ke resources/views/templates
    $extractPath = resource_path("views/templates/$folderName");

    // Buat folder jika belum ada
    if (!file_exists($extractPath)) {
        mkdir($extractPath, 0755, true);
    }

    // Extract ZIP
    $zip->extractTo($extractPath);
    $zip->close();

    // Simpan thumbnail
    $thumb = $request->file('thumbnail')->store('templates', 'public');
    $preview = $request->file('preview')->store('preview', 'public');
    // Simpan ke database
    Template::create([
        'name' => $request->name,
        'slug' => $folderName,
        'thumbnail' => $thumb,
        'preview' => $preview,
        'sections' => ["hero","couple","event","gallery","rsvp","music"],
        'is_active' => true
    ]);

    return back()->with('success', 'Template berhasil diupload & diekstrak ke views/templates!');
    }
    public function destroy(Template $template)
    {
        // Hapus folder template di views/templates
        $folderPath = resource_path("views/templates/{$template->slug}");

        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        // Hapus thumbnail
        if ($template->thumbnail && File::exists(public_path("storage/{$template->thumbnail}"))) {
            File::delete(public_path("storage/{$template->thumbnail}"));
        }

        // Hapus data DB
        $template->delete();

        return back()->with('success', 'Template berhasil dihapus.');
    }
}

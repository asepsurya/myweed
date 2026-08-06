<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Music;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

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

        $folderName = Str::slug($request->name);
        $extractPath = resource_path("views/templates/$folderName");

        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0755, true);
        }

        $file = $request->file('zip');
        $zipPath = $file->getRealPath();

        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive;
            if ($zip->open($zipPath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();
            } else {
                return back()->with('error', 'File ZIP tidak valid atau rusak.');
            }
        } elseif (function_exists('exec')) {
            $escapedZip = escapeshellarg($zipPath);
            $escapedDest = escapeshellarg($extractPath);
            exec("unzip $escapedZip -d $escapedDest 2>&1", $output, $returnVar);
            if ($returnVar !== 0) {
                $powerShellCmd = "Expand-Archive -LiteralPath $escapedZip -DestinationPath $escapedDest -Force";
                exec("powershell -Command " . escapeshellarg($powerShellCmd) . " 2>&1", $psOutput, $psReturn);
                if ($psReturn !== 0) {
                    return back()->with('error', 'Gagal mengekstrak ZIP. Pastikan server mendukung ZipArchive, perintah unzip, atau PowerShell Expand-Archive.');
                }
            }
        } else {
            return back()->with('error', 'Server tidak mendukung ekstraksi ZIP. Aktifkan ekstensi php-zip atau pastikan perintah unzip/Expand-Archive tersedia.');
        }

        $thumb = $this->convertImageToWebp($request->file('thumbnail'), 'templates');
        $preview = $this->convertImageToWebp($request->file('preview'), 'preview');

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

    public function importCode(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:templates,slug',
            'code' => 'required|string',
        ]);

        $slug = Str::slug($request->slug);
        $folderPath = resource_path("views/templates/$slug");

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }

        file_put_contents($folderPath . '/index.blade.php', $request->code);

        $thumb = $this->generatePlaceholderImage($slug, 'templates');
        $preview = $this->generatePlaceholderImage($slug, 'preview');

        Template::create([
            'name' => $request->name,
            'slug' => $slug,
            'thumbnail' => $thumb,
            'preview' => $preview,
            'sections' => ["hero","couple","event","gallery","rsvp","music"],
            'is_active' => true,
        ]);

        return back()->with('success', 'Template berhasil di-import dari code!');
    }

    private function generatePlaceholderImage($slug, $folder)
    {
        $dir = storage_path("app/public/$folder");
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = $slug . '-placeholder.png';
        $path = $dir . '/' . $filename;

        if (!file_exists($path)) {
            $img = imagecreatetruecolor(400, 300);
            $bg = imagecolorallocate($img, 120, 120, 120);
            imagefill($img, 0, 0, $bg);
            $textColor = imagecolorallocate($img, 255, 255, 255);
            imagestring($img, 5, 140, 140, $slug, $textColor);
            imagepng($img, $path);
            imagedestroy($img);
        }

        return $folder . '/' . $filename;
    }

     private function convertImageToWebp($file, $folder)
     {
         $tempSource = str_replace('\\', '/', sys_get_temp_dir() . '/' . uniqid() . '_' . $file->getClientOriginalName());
         $file->move(sys_get_temp_dir(), basename($tempSource));

         $destinationPath = str_replace('\\', '/', storage_path('app/public/' . $folder));
         if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0755, true);
         }

         $destFile = $destinationPath . '/' . uniqid() . '.webp';

         $driver = new \Intervention\Image\Drivers\Gd\Driver();
         $manager = new \Intervention\Image\ImageManager($driver);
         $image = $manager->read($tempSource);
         $image->save($destFile, 75, 'webp');

         @unlink($tempSource);

         return $folder . '/' . basename($destFile);
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
    public function preview($slug, $id, Request $request)
    {
        $invitation = Invitation::with([
                'template',
                'galleries',
                'rsvps',
        ])
            ->where('slug', $slug)
            ->first();

        if (!$invitation) {
            $invitation = Invitation::create([
                'user_id' => 1,
                'template_id' => $id,
                'slug' => $slug,
                'is_default' => true,
                'groom_name' => 'Romeo',
                'groom_nickname' => 'Romeo',
                'groom_father_name' => 'Tuan Montague',
                'groom_mother_name' => 'Nyonya Montague',
                'bride_name' => 'Juliet',
                'bride_nickname' => 'Juliet',
                'bride_father_name' => 'Tuan Capulet',
                'bride_mother_name' => 'Nyonya Capulet',
                'wedding_date' => date('Y-m-d'),
                'enable_rsvp' => true,
                'enable_gift' => false,
            ]);
        }

        $template = Template::findOrFail($id);

        if ($invitation->template_id != $template->id) {
            $invitation->update([
                'template_id' => $template->id
            ]);
            $invitation->load('template');
        }

        $themeColor = $request->query('theme_color', '#3b82f6');

        $templateView = 'templates.' . $invitation->template->slug . '.index';

        if (!view()->exists($templateView)) {
            abort(404, 'Template tidak ditemukan');
        }

        return view($templateView, compact('invitation', 'themeColor'));
    }

    public function previewUpdate($slug, $id, Request $request)
    {
        $invitation = Invitation::where('slug', $slug)->first();

        if ($invitation) {
            $updateableFields = [
                'groom_name', 'groom_nickname', 'groom_father_name', 'groom_mother_name',
                'groom_username_instagram',
                'bride_name', 'bride_nickname', 'bride_father_name', 'bride_mother_name',
                'bride_username_instagram',
                'wedding_date', 'akad_location', 'akad_time', 'akad_time_end',
                'akad_maps', 'akad_address', 'resepsi_location', 'resepsi_time',
                'resepsi_time_end', 'resepsi_maps', 'resepsi_address',
                'theme_color', 'wedding_quote', 'quote_id', 'video_link',
                'enable_rsvp', 'enable_gift', 'enable_music',
                'rsvp_deadline', 'rsvp_message', 'rsvp_whatsapp',
                'music_youtube_url',
            ];

            $data = $request->only($updateableFields);

            // Filter out empty strings to prevent overwriting existing demo data
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            foreach ($data as $key => $value) {
                if ($value === null) unset($data[$key]);
            }

            if ($request->has('enable_rsvp')) $data['enable_rsvp'] = $request->boolean('enable_rsvp');
            if ($request->has('enable_gift')) $data['enable_gift'] = $request->boolean('enable_gift');
            if ($request->has('enable_music')) $data['enable_music'] = $request->boolean('enable_music');

            if ($request->filled('music_youtube_url')) {
                $data['music_youtube_url'] = $request->music_youtube_url;
            }

            if (!empty($data['groom_username_instagram'])) {
                $data['groom_instagram'] = 'https://www.instagram.com/' . $data['groom_username_instagram'];
            }
            if (!empty($data['bride_username_instagram'])) {
                $data['bride_instagram'] = 'https://www.instagram.com/' . $data['bride_username_instagram'];
            }

            $invitation->update($data);
        }

        $themeColor = $request->input('theme_color', $invitation ? ($invitation->theme_color ?? '#FF6B81') : '#FF6B81');
        $baseUrl = '/templates/' . $slug . '/' . $id;

        return response()->json([
            'preview_url' => $baseUrl . '?theme_color=' . urlencode($themeColor) . '&t=' . time(),
        ]);
    }

}

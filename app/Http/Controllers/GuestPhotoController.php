<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GuestPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\ImageManager;

class GuestPhotoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:invitations,id',
            'guest_name' => 'required|string|max:255',
            'device_id' => 'required|string|max:100',
            'image' => 'required|string',
        ]);

        // Decode base64 image data from JSON payload (frontend always sends data URL)
        $imageData = $request->image;
        preg_match('/^data:image\/(\w+);base64,/', $imageData, $match);
        $base64 = substr($imageData, strpos($imageData, ',') + 1);
        $imageBinary = base64_decode($base64);
        $file = tempnam(sys_get_temp_dir(), 'guest_photo_');
        file_put_contents($file, $imageBinary);

        // Check device photo limit (max 5 photos per device per event)
        $photoCount = GuestPhoto::where('event_id', $request->event_id)
            ->where('device_id', $request->device_id)
            ->count();

        if ($photoCount >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Kuantum foto untuk device ini sudah mencapai batas maksimal 5 foto.',
            ], 422);
        }

        $image = new \Illuminate\Http\UploadedFile($file);

        // Compress and convert to JPEG with max width 1280px and quality 0.8
        $originalPath = $image->getRealPath();
        $originalMime = $image->getMimeType();

        $driver = new GdDriver;
        $manager = new ImageManager($driver);
        $img = $manager->read($originalPath);

        // Resize to max width 1280px while maintaining aspect ratio
        $maxWidth = 1280;
        if ($img->width() > $maxWidth) {
            $ratio = $maxWidth / $img->width();
            $newHeight = floor($img->height() * $ratio);
            $img->scale(width: $maxWidth, height: $newHeight);
        }

        // Convert to JPEG with quality 80 (0-100 scale, 80 ≈ 0.8 quality)
        $buffer = $img->encode('jpg', 80);

        // Generate unique filename
        $filename = 'guest-photos/'. $request->event_id. '/'. $request->device_id. '/' . Str::uuid() . '.jpg';

        // Save to storage
        $disk = Storage::disk('public');
        $disk->put($filename, $buffer);

        // Create gallery record
        $guestPhoto = GuestPhoto::create([
            'event_id' => $request->event_id,
            'guest_name' => $request->guest_name,
            'device_id' => $request->device_id,
            'image_url' => Storage::url($filename),
        ]);

        return response()->json([
            'success' => true,
            'data' => $guestPhoto,
            'remaining' => 5 - $photoCount - 1,
        ]);
    }

    public function show($event_id, Request $request)
    {
        // Validate secret token
        $secretToken = $request->header('X-Secret-Token');
        if ($secretToken !== env('GUEST_PHOTOS_SECRET_TOKEN')) {
            return response()->json([
                'success' => false,
                'message' => 'Token rahasia tidak valid.',
            ], 403);
        }

        $photos = GuestPhoto::where('event_id', $event_id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $photos,
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GuestPhoto;
use App\Models\Invitation;
use App\Services\ImageProcessingService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class GuestPhotoController extends Controller
{
    /**
     * Tampilkan halaman kamera tamu.
     * Bisa diakses via /guest/camera/{slug} atau /guest/camera?event={slug}.
     */
    public function camera(Request $request, $slug = null)
    {
        $slug = $slug ?: $request->query('event');

        $invitation = $slug
            ? Invitation::where('slug', $slug)
                ->orWhere('public_id', $slug)
                ->first()
            : null;

        // Galeri pengantin (upload user/admin)
        $galleries = $invitation
            ? $invitation->galleries()->latest()->get()->map(fn (Gallery $g) => [
                'image_url' => storage_url_with_fallback($g->image),
                'created_at' => $g->created_at?->format('d M Y'),
            ])->values()
            : collect();

        // Galeri tamu (hasil kamera tamu)
        $guestPhotos = $invitation
            ? GuestPhoto::where('event_id', $invitation->id)->latest()->get()->map(fn (GuestPhoto $p) => [
                'id' => $p->id,
                'image_url' => $p->image_url ?: storage_url_with_fallback($p->image_url),
                'guest_name' => $p->guest_name ?: 'Tamu',
                'created_at' => $p->created_at?->format('d M Y'),
            ])->values()
            : collect();

        return view('guest.camera', [
            'invitation' => $invitation,
            'galleries' => $galleries,
            'guestPhotos' => $guestPhotos,
        ]);
    }

    /**
     * Simpan foto dari kamera tamu ke galeri pengantin (berdasarkan undangan/slug).
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer|exists:invitations,id',
            'guest_name' => 'nullable|string|max:255',
            'device_id' => 'nullable|string|max:100',
            'image' => 'required|string',
        ]);

        $invitation = Invitation::findOrFail($request->event_id);

        // Batasi maksimal 5 foto per perangkat
        $limit = 5;
        $deviceId = $request->device_id ?: 'unknown';
        $used = GuestPhoto::where('event_id', $invitation->id)
            ->where('device_id', $deviceId)
            ->count();

        if ($used >= $limit) {
            return response()->json([
                'success' => false,
                'message' => 'Kuota foto penuh. Maksimal '.$limit.' foto per perangkat.',
            ], 422);
        }

        $imageData = $request->image;
        if (! preg_match('/^data:image\/(\w+);base64,/', $imageData, $match)) {
            return response()->json([
                'success' => false,
                'message' => 'Format gambar tidak valid.',
            ], 422);
        }

        $type = strtolower($match[1]);
        $ext = $type === 'jpg' ? 'jpeg' : $type;

        $binary = base64_decode(substr($imageData, strpos($imageData, ',') + 1));
        if ($binary === false) {
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak dapat dibaca.',
            ], 422);
        }

        $tmp = tempnam(sys_get_temp_dir(), 'guestcam_');
        file_put_contents($tmp, $binary);

        try {
            $file = new UploadedFile($tmp, 'guestcam.'.$ext, 'image/'.$ext, null, true);

            // Simpan di folder terpisah (bukan galeri pengantin)
            $folder = "invitations/{$invitation->public_id}/guest";

            $result = app(ImageProcessingService::class)->process(
                $file,
                $folder,
                'guest-'.Str::uuid()->toString(),
                1600
            );

            // Hanya simpan ke galeri tamu (TIDAK masuk ke galeri pengantin/template)
            $guestPhoto = GuestPhoto::create([
                'event_id' => $invitation->id,
                'guest_name' => $request->guest_name ?: 'Tamu',
                'device_id' => $deviceId,
                'image_url' => $result['url'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil disimpan ke galeri tamu.',
                'photo' => $guestPhoto,
                'url' => $result['url'],
                'remaining' => max(0, $limit - ($used + 1)),
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan foto: '.$e->getMessage(),
            ], 500);
        } finally {
            if (is_file($tmp)) {
                @unlink($tmp);
            }
        }
    }

    /**
     * Ambil daftar foto tamu untuk sebuah undangan (berdasarkan slug atau id).
     */
    public function show($event_id, Request $request)
    {
        $expected = env('GUEST_PHOTOS_SECRET_TOKEN');
        if ($expected && $request->header('X-Secret-Token') !== $expected) {
            return response()->json([
                'success' => false,
                'message' => 'Token rahasia tidak valid.',
            ], 403);
        }

        $invitation = Invitation::where('slug', $event_id)
            ->orWhere('public_id', $event_id)
            ->orWhere('id', $event_id)
            ->firstOrFail();

        $deviceId = $request->header('X-Device-Id');
        $limit = 5;
        $myCount = $deviceId
            ? GuestPhoto::where('event_id', $invitation->id)->where('device_id', $deviceId)->count()
            : 0;

        $data = GuestPhoto::where('event_id', $invitation->id)
            ->latest()
            ->get()
            ->map(fn (GuestPhoto $photo) => [
                'id' => $photo->id,
                'guest_name' => $photo->guest_name ?: 'Tamu',
                'image_url' => $photo->image_url ?: storage_url_with_fallback($photo->image_url),
                'created_at' => $photo->created_at?->format('d M Y, H:i'),
                // hanya perangkat yang sama yang boleh menghapus
                'can_delete' => $deviceId !== null && $photo->device_id === $deviceId,
            ]);

        return response()->json([
            'success' => true,
            'data' => $data,
            'my_count' => $myCount,
            'limit' => $limit,
        ]);
    }

    /**
     * Hapus foto tamu — hanya boleh oleh perangkat (device) yang mengunggahnya.
     */
    public function destroy(Request $request, $id)
    {
        $photo = GuestPhoto::findOrFail($id);
        $invitation = $photo->invitation;

        // Pemilik undangan / admin (via sesi web) boleh hapus foto apa pun
        $isOwner = auth()->check() && $invitation && (
            auth()->id() === $invitation->user_id
            || auth()->id() === $invitation->partner_user_id
            || (auth()->user() && auth()->user()->role === 'admin')
        );

        $deviceId = $request->header('X-Device-Id') ?: $request->input('device_id');

        if (! $isOwner && (! $deviceId || $photo->device_id !== $deviceId)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak diizinkan menghapus foto ini.',
            ], 403);
        }

        // Hapus file fisik (best effort) berdasarkan URL
        $publicUrl = rtrim((string) config('filesystems.disks.r2.public_url', ''), '/');
        if ($publicUrl && $photo->image_url && str_starts_with($photo->image_url, $publicUrl)) {
            $path = ltrim(substr($photo->image_url, strlen($publicUrl)), '/');
            if ($path !== '') {
                try {
                    \Illuminate\Support\Facades\Storage::disk(config('image.disk', 'public'))->delete($path);
                } catch (\Throwable $e) {
                    // abaikan
                }
            }
        }

        $photo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil dihapus.',
        ]);
    }
}
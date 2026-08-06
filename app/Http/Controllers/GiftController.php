<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    public function index()
    {
        $gifts = Gift::all();
        return view('dashboard.gift.index', compact('gifts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invitation_id' => 'required',
            'bank' => 'nullable',
            'number' => 'required',
            'name' => 'required',
            'qr' => 'nullable|image'
        ]);

        if ($request->hasFile('qr')) {
            $tempSource = str_replace('\\', '/', sys_get_temp_dir() . '/' . uniqid() . '_' . $request->file('qr')->getClientOriginalName());
            $request->file('qr')->move(sys_get_temp_dir(), basename($tempSource));

            $destinationPath = storage_path('app/public/gifts');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $destFile = $destinationPath . '/' . uniqid() . '.webp';

            $driver = new \Intervention\Image\Drivers\Gd\Driver();
            $manager = new \Intervention\Image\ImageManager($driver);
            $image = $manager->read($tempSource);
            $image->save($destFile, 75, 'webp');

            @unlink($tempSource);

            $data['qr'] = 'gifts/' . basename($destFile);
        }

        Gift::create($data);

        return back()->with('success', 'Gift berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $gift = Gift::findOrFail($id);

        if ($gift->qr) {
            Storage::disk('public')->delete($gift->qr);
        }

        $gift->delete();

        return response()->json(['success' => true]);
    }
}

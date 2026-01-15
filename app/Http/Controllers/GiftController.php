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
            $data['qr'] = $request->file('qr')->store('gifts', 'public');
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

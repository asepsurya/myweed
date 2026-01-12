<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserInvitationController extends Controller
{
     public function index()
    {
        $invitations = Invitation::where('user_id', auth()->id())->latest()->get();
        return view('dashboard.invitation.index', compact('invitations'));
    }

    public function create()
    {
        $templates = Template::where('is_active', true)->get();
        return view('dashboard.invitation.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bride_name' => 'required',
            'groom_name' => 'required',
            'wedding_date' => 'required|date',
            'location' => 'required',
            'template_id' => 'required|exists:templates,id',
        'music' => 'nullable',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

      DB::transaction(function () use ($request) {

    $invitation = Invitation::create([
        'user_id' => $request->user()->id,
        'template_id' => $request->template_id,
        'slug' => Str::slug($request->groom_name . '-' . $request->bride_name),
        'bride_name' => $request->bride_name,
        'groom_name' => $request->groom_name,
        'wedding_date' => $request->wedding_date,
        'location' => $request->location,
    ]);

    // ✅ UPLOAD MUSIC (INI YANG KURANG)
    if ($request->hasFile('music') && $request->file('music')->isValid()) {
        $musicPath = $request->file('music')->store(
            "invitations/{$invitation->id}/music",
            'public'
        );

        $invitation->update([
            'music' => $musicPath
        ]);
    }

    // UPLOAD GALERI
    if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $image) {
            $path = $image->store(
                "invitations/{$invitation->id}/gallery",
                'public'
            );

            Gallery::create([
                'invitation_id' => $invitation->id,
                'image' => $path,
            ]);
        }
    }
});


        return redirect()->route('dashboard')
            ->with('success', 'Undangan berhasil dibuat 🎉');
    }

    public function edit(Invitation $invitation)
    {
        abort_if($invitation->user_id !== auth()->id(), 403);
        return view('dashboard.invitation.edit', compact('invitation'));
    }

    public function update(Request $request, Invitation $invitation)
    {
        abort_if($invitation->user_id !== auth()->id(), 403);

        $request->validate([
            'bride_name'   => 'required',
            'groom_name'   => 'required',
            'wedding_date' => 'required|date',
            'location'     => 'required',
        ]);

        $invitation->update($request->only([
            'bride_name',
            'groom_name',
            'wedding_date',
            'location',
        ]));

        return back()->with('success', 'Undangan diperbarui 💖');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function store(Request $request, $invitationId)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'message' => 'nullable|string',
            'attending' => 'nullable',
        ]);

        Rsvp::create([
            'invitation_id' => $invitationId,
            'name' => $request->name,
            'message' => $request->message,
            'attending' => $request->attending ?? true,
        ]);

       return response()->json([
        'success' => true,
        'message' => 'RSVP berhasil dikirim!'
    ]);
    }
    public function getRsvps($invitationId)
{
    $rsvps = Rsvp::where('invitation_id', $invitationId)->latest()->get();
    return response()->json($rsvps);
}
}

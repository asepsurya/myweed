<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Invitation;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function index()
{
 $inviation = Invitation::orderBy('id')->get();

    // Ambil invitation_id aktif
    $activeInvitationId = request('list')
        ?? $inviation->first()?->id;

    // Query RSVP
    $rsvps = Rsvp::when($activeInvitationId, function ($q) use ($activeInvitationId) {
            $q->where('invitation_id', $activeInvitationId);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    // Statistik berdasarkan invitation aktif
    $stats = [
        'total' => Rsvp::where('invitation_id', $activeInvitationId)->count(),
        'hadir' => Rsvp::where('invitation_id', $activeInvitationId)
                        ->where('attending', 1)->count(),
        'tidak_hadir' => Rsvp::where('invitation_id', $activeInvitationId)
                              ->where('attending', 2)->count(),
        'ragu' => Rsvp::where('invitation_id', $activeInvitationId)
                       ->where('attending', 3)->count(),
    ];

    return view('dashboard.rsvps.index', compact(
        'rsvps',
        'stats',
        'inviation',
        'activeInvitationId'
    ));
}

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
public function destroy(Rsvp $rsvp)
{
    $rsvp->delete();

    return redirect()
        ->back()
        ->with('success', 'RSVP berhasil dihapus');
}

}

<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function index()
{
    $inviation = Rsvp::all();
    $rsvps = Rsvp::latest()->paginate(10);

    $stats = [
        'total' => Rsvp::count(),
        'hadir' => Rsvp::where('attending', '1')->count(),
        'tidak_hadir' => Rsvp::where('attending', '2')->count(),
        'ragu' => Rsvp::where('attending', '2')->count(),
    ];

    return view('dashboard.rsvps.index', compact('rsvps', 'stats','inviation'));
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

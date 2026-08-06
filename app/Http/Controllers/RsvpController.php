<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Invitation;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $inviation = Invitation::orderBy('id')->get();

        $activeInvitationId = request('list')
            ?? $inviation->first()?->id;

        $rsvps = Rsvp::when($activeInvitationId, function ($q) use ($activeInvitationId) {
                $q->where('invitation_id', $activeInvitationId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

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
=======
        $user = auth()->user();
        $activeInvitationId = request('list');

        if (!$activeInvitationId) {
            if ($user->isAdmin()) {
                $activeInvitationId = Invitation::first()?->id;
            } else {
                $activeInvitationId = Invitation::where('user_id', $user->id)->first()?->id;
            }
        }

        $rsvps = Rsvp::where('invitation_id', $activeInvitationId)
            ->latest()
            ->paginate(10);

        $stats = [
            'total'       => Rsvp::where('invitation_id', $activeInvitationId)->count(),
            'hadir'       => Rsvp::where('invitation_id', $activeInvitationId)->where('attending', '1')->count(),
            'tidak_hadir' => Rsvp::where('invitation_id', $activeInvitationId)->where('attending', '2')->count(),
            'ragu'        => Rsvp::where('invitation_id', $activeInvitationId)->where('attending', '0')->count(),
        ];

        if ($user->isAdmin()) {
            $invitations = Invitation::all();
        } else {
            $invitations = Invitation::where('user_id', $user->id)->get();
        }

        return view('dashboard.rsvps.index', compact(
            'rsvps',
            'stats',
            'invitations',
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b
            'activeInvitationId'
        ));
    }

    public function store(Request $request, $invitationId)
    {
        $invitation = Invitation::findOrFail($invitationId);

        $request->validate([
            'name' => 'required|string|max:100',
            'message' => 'nullable|string',
            'attending' => 'nullable|in:1,2,3',
        ]);

        Rsvp::create([
            'invitation_id' => $invitation->id,
            'name' => $request->name,
            'message' => $request->message,
            'attending' => $request->attending ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'RSVP berhasil dikirim!'
        ]);
    }

    public function getRsvps($invitationId)
    {
<<<<<<< HEAD
        $invitation = Invitation::findOrFail($invitationId);
        $rsvps = Rsvp::where('invitation_id', $invitation->id)->latest()->get();
        return response()->json($rsvps);
    }
public function destroy(Rsvp $rsvp)
{
    $rsvp->delete();
=======
        $rsvps = Rsvp::where('invitation_id', $invitationId)->latest()->get();
        return response()->json($rsvps);
    }
>>>>>>> cf03afae4c1d966c8748d360e1034ab498ceeb3b

    public function destroy(Rsvp $rsvp)
    {
        $rsvp->delete();

        return redirect()
            ->back()
            ->with('success', 'RSVP berhasil dihapus');
    }
}

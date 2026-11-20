<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Rsvp;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activeInvitationId = request('list');

        if (! $activeInvitationId) {
            if ($user->isAdmin()) {
                $activeInvitationId = Invitation::first()?->id;
            } else {
                $activeInvitationId = Invitation::where('user_id', $user->id)->first()?->id;
            }
        }

        $rsvps = Rsvp::when($activeInvitationId, function ($q) use ($activeInvitationId) {
            $q->where('invitation_id', $activeInvitationId);
        })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => Rsvp::where('invitation_id', $activeInvitationId)->count(),
            'hadir' => Rsvp::where('invitation_id', $activeInvitationId)->where('attending', 1)->count(),
            'tidak_hadir' => Rsvp::where('invitation_id', $activeInvitationId)->where('attending', 2)->count(),
            'ragu' => Rsvp::where('invitation_id', $activeInvitationId)->where('attending', 3)->count(),
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
            'activeInvitationId'
        ));
    }

    public function store(Request $request, $invitationId)
    {
        $invitation = Invitation::where('slug', $invitationId)
            ->orWhere('public_id', $invitationId)
            ->orWhere('id', $invitationId)
            ->firstOrFail();

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
            'message' => 'RSVP berhasil dikirim!',
        ]);
    }

    public function getRsvps(Request $request, $invitationId)
    {
        $invitation = Invitation::where('slug', $invitationId)
            ->orWhere('public_id', $invitationId)
            ->orWhere('id', $invitationId)
            ->firstOrFail();

        $baseQuery = Rsvp::where('invitation_id', $invitation->id);

        // Jika diminta via AJAX/API, tetap kembalikan JSON (kompatibilitas lama)
        if ($request->wantsJson()) {
            return response()->json($baseQuery->latest()->get());
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'hadir' => (clone $baseQuery)->where('attending', 1)->count(),
            'tidak_hadir' => (clone $baseQuery)->where('attending', 2)->count(),
            'ragu' => (clone $baseQuery)->where('attending', '!=', 1)->where('attending', '!=', 2)->count(),
        ];

        $rsvps = $baseQuery->latest()->paginate(10)->withQueryString();

        $user = auth()->user();
        if ($user && $user->isAdmin()) {
            $invitations = Invitation::orderByDesc('id')->get();
        } elseif ($user) {
            $invitations = Invitation::where('user_id', $user->id)
                ->orWhere('partner_user_id', $user->id)
                ->orderByDesc('id')
                ->get();
        } else {
            $invitations = collect([$invitation]);
        }

        return view('dashboard.rsvps.index', [
            'rsvps' => $rsvps,
            'stats' => $stats,
            'invitations' => $invitations,
            'activeInvitationId' => $invitation->id,
            'showInvitation' => $invitation,
        ]);
    }

    public function destroy(Rsvp $rsvp)
    {
        $rsvp->delete();

        return redirect()
            ->back()
            ->with('success', 'RSVP berhasil dihapus');
    }
}

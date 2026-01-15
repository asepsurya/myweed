<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Music;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function index()
    {
        return view('dashboard', [
            'totalInvitations' => Invitation::count(),
            'totalGuests'      => Rsvp::count(),
            'rsvpYes'          => Rsvp::where('attending', '1')->count(),
            'rsvpNo'           => Rsvp::where('attending', '2')->count(),
            'invitations'     => Invitation::latest()->take(5)->get(),
            'recentRsvps'     => Rsvp::latest()->take(5)->get(),
        ]);
    }
    public function indexUser(){
        $invitations = Invitation::where('user_id', auth()->id())->latest()->get();
        return view('guest.index', compact('invitations'));
    }
}

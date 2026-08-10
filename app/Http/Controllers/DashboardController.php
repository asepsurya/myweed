<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use App\Models\Music;
use App\Models\Template;
use App\Models\Invitation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

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
            'totalMusic'      => Music::count(),
            'activeMusic'     => Music::where('is_active', true)->count(),
            'inactiveMusic'   => Music::where('is_active', false)->count(),
            'totalMusicSize'  => Music::sum('file_size') ?? 0,
        ]);
    }
    public function indexUser(){
        $invitations = Invitation::where('user_id', auth()->id())->latest()->get();
        $templates = Template::where('is_active', true)->get();
        return view('guest.index', compact('invitations', 'templates'));
    }

    public function temaIndex(){
        $templates = Template::where('is_active', true)->paginate(12);
        return view('dashboard.tema.index', compact('templates'));
    }

    public function checkUpdate()
    {
        $githubRepo = 'asepsurya/myweed';
        $currentVersion = config('app.version', '1.0.0');

        try {
            $response = Http::timeout(10)
                ->accept('application/vnd.github.v3+json')
                ->get("https://api.github.com/repos/{$githubRepo}/releases/latest");

            if ($response->successful()) {
                $latest = $response->json();
                $latestVersion = ltrim($latest['tag_name'] ?? '1.0.0', 'v');
                $hasUpdate = version_compare($latestVersion, $currentVersion, '>');

                return response()->json([
                    'has_update' => $hasUpdate,
                    'current_version' => $currentVersion,
                    'latest_version' => $latestVersion,
                    'release_url' => $latest['html_url'] ?? "https://github.com/{$githubRepo}/releases",
                    'release_name' => $latest['name'] ?? $latestVersion,
                    'published_at' => $latest['published_at'] ?? null,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'has_update' => false,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'has_update' => false,
            'current_version' => $currentVersion,
            'latest_version' => $currentVersion,
        ]);
    }
}

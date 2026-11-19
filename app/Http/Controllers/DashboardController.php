<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Music;
use App\Models\Rsvp;
use App\Models\Template;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuests = Rsvp::count();
        $rsvpYes = Rsvp::where('attending', '1')->count();
        $rsvpNo = Rsvp::where('attending', '2')->count();
        $rsvpMaybe = Rsvp::where('attending', '3')->count();

        return view('dashboard', [
            'totalInvitations' => Invitation::count(),
            'publishedInvitations' => Invitation::where('status', 'published')->count(),
            'draftInvitations' => Invitation::where('status', 'draft')->count(),
            'totalGuests' => $totalGuests,
            'rsvpYes' => $rsvpYes,
            'rsvpNo' => $rsvpNo,
            'rsvpMaybe' => $rsvpMaybe,
            'invitations' => Invitation::with(['template', 'category'])
                ->withCount('rsvps')
                ->latest()
                ->take(6)
                ->get(),
            'recentRsvps' => Rsvp::with('invitation')
                ->latest()
                ->take(6)
                ->get(),
            'totalMusic' => Music::count(),
            'activeMusic' => Music::where('is_active', true)->count(),
            'inactiveMusic' => Music::where('is_active', false)->count(),
            'totalMusicSize' => Music::sum('file_size') ?? 0,
            'topTemplates' => Template::where('is_active', true)
                ->orderByDesc('views_count')
                ->take(5)
                ->get(['name', 'views_count']),
        ]);
    }

    public function indexUser()
    {
        $user = auth()->user();
        $invitations = Invitation::where('user_id', $user->id)
            ->orWhere('partner_user_id', $user->id)
            ->latest()
            ->get();
        $templates = Template::where('is_active', true)->get();

        return view('guest.index', compact('invitations', 'templates'));
    }

    public function publishedDashboard()
    {
        $user = auth()->user();
        $invitations = Invitation::where('user_id', $user->id)
            ->orWhere('partner_user_id', $user->id)
            ->latest()
            ->get();

        return view('dashboard.invitation.published', compact('invitations'));
    }

    public function temaIndex()
    {
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

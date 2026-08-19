<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\SavingsContributor;
use App\Models\User;
use App\Notifications\SavingsContributorInvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class SavingsContributorController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $contributors = SavingsContributor::where('invitation_id', $invitationId)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('savings.contributor.index', compact('contributors', 'invitationId'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        return view('savings.contributor.create', compact('invitationId'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'relationship' => ['nullable', 'string', 'max:255'],
            'is_external' => ['boolean'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $validated['invitation_id'] = $invitationId;
        $validated['is_external'] = $request->boolean('is_external');

        $sendInvite = false;

        if (! empty($validated['user_id'])) {
            $validated['user_id'] = (int) $validated['user_id'];
            $validated['accepted_at'] = now();
        } elseif (! empty($validated['email'])) {
            $existingUser = User::where('email', $validated['email'])->first();
            if ($existingUser) {
                $validated['user_id'] = $existingUser->id;
                $validated['accepted_at'] = now();
            } else {
                $validated['invite_token'] = Str::random(64);
                $validated['invite_email'] = trim($validated['email']);
                $validated['invited_at'] = now();
                $validated['user_id'] = null;
                $sendInvite = true;
            }
        }

        $contributor = SavingsContributor::create($validated);

        if ($sendInvite) {
            try {
                $contributor->notifyNow(new SavingsContributorInvitationNotification($contributor, $user));
            } catch (\Throwable $e) {
                \Log::error('Gagal mengirim email undangan kontributor: '.$e->getMessage());
            }
        }

        return redirect()->route('savings.contributor.index')->with('success', 'Kontributor berhasil ditambahkan 🎉');
    }

    public function invite(Request $request)
    {
        $user = $request->user();
        $invitationId = $this->resolveInvitationId($request, $user);

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'relationship' => ['nullable', 'string', 'max:255'],
            'can_edit' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            $contributor = SavingsContributor::create([
                'invitation_id' => $invitationId,
                'user_id' => $existingUser->id,
                'name' => $request->name,
                'email' => $request->email,
                'relationship' => $request->relationship,
                'is_external' => false,
                'accepted_at' => now(),
                'can_edit' => $request->boolean('can_edit'),
            ]);

            return redirect()->route('savings.contributor.index')->with('success', 'Kontributor berhasil ditambahkan dan ditautkan ke akun yang ada 🎉');
        }

        $contributor = SavingsContributor::create([
            'invitation_id' => $invitationId,
            'user_id' => null,
            'name' => $request->name,
            'email' => $request->email,
            'relationship' => $request->relationship,
            'is_external' => true,
            'invite_token' => Str::random(64),
            'invite_email' => trim($request->email),
            'invited_at' => now(),
            'can_edit' => $request->boolean('can_edit'),
        ]);

        try {
            $contributor->notifyNow(new SavingsContributorInvitationNotification($contributor, $user));
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim email undangan kontributor: '.$e->getMessage());
        }

        return redirect()->route('savings.contributor.index')->with('success', 'Undangan kontributor berhasil dikirim ke '.$request->email.'! 💌');
    }

    public function accept($token)
    {
        $contributor = SavingsContributor::where('invite_token', $token)
            ->whereNotNull('invite_email')
            ->firstOrFail();

        if ($contributor->accepted_at !== null) {
            return redirect()->route('savings.dashboard')->with('info', 'Anda sudah menerima undangan ini sebelumnya.');
        }

        $user = auth()->user();

        if (!$user) {
            session()->put('url.intended', request()->fullUrl());

            return redirect()->route('login')->with('info', 'Silakan login untuk menerima undangan kontributor.');
        }

        if (strcasecmp(trim((string) $user->email), trim((string) $contributor->invite_email)) !== 0) {
            return redirect()->route('savings.dashboard')->with('error', 'Email Anda tidak cocok dengan undangan kontributor. Silakan login dengan email '.$contributor->invite_email.'.');
        }

        $contributor->update([
            'user_id' => $user->id,
            'accepted_at' => now(),
            'invite_token' => null,
        ]);

        return redirect()->route('savings.dashboard')->with('success', 'Undangan kontributor berhasil diterima! Anda sekarang dapat menambah setoran. 🎉');
    }

    public function edit(SavingsContributor $contributor)
    {
        $this->authorizeContributor($contributor);

        return view('savings.contributor.edit', compact('contributor'));
    }

    public function update(Request $request, SavingsContributor $contributor)
    {
        $this->authorizeContributor($contributor);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'relationship' => ['nullable', 'string', 'max:255'],
            'is_external' => ['boolean'],
            'user_id' => ['nullable', 'exists:users,id'],
            'can_edit' => ['nullable', 'boolean'],
        ]);

        $validated['is_external'] = $request->boolean('is_external');
        $validated['can_edit'] = $request->boolean('can_edit');

        if (! empty($validated['user_id'])) {
            $validated['user_id'] = (int) $validated['user_id'];
            $validated['accepted_at'] = $validated['accepted_at'] ?? now();
            $validated['invite_token'] = null;
            $validated['invite_email'] = null;
            $validated['invited_at'] = null;
        }

        $contributor->update($validated);

        return redirect()->route('savings.contributor.index')->with('success', 'Kontributor berhasil diperbarui 🎉');
    }

    public function destroy(SavingsContributor $contributor)
    {
        $this->authorizeContributor($contributor);

        $contributor->delete();

        return back()->with('success', 'Kontributor berhasil dihapus 🗑️');
    }

    private function resolveInvitationId(Request $request, $user): int
    {
        $invitationId = $request->query('invitation_id') ?: $request->input('invitation_id');

        if ($invitationId) {
            return (int) $invitationId;
        }

        if ($user->isAdmin()) {
            return Invitation::first()->id;
        }

        return Invitation::where('user_id', $user->id)
            ->orWhere('partner_user_id', $user->id)
            ->first()?->id ?? 0;
    }

    private function authorizeContributor(SavingsContributor $contributor): void
    {
        if (! auth()->user()->canAccessInvitation($contributor->invitation)) {
            abort(403, 'Anda tidak memiliki akses ke kontributor ini.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $plans = SubscriptionPlan::all();
        $subscription = $user->subscription;
        $currentPlan = $subscription?->plan;

        return view('dashboard.users.edit', compact('user', 'plans', 'subscription', 'currentPlan'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function generateMagicLink(User $user)
    {
        $token = Str::random(64);

        $user->login_token = hash('sha256', $token);
        $user->login_token_expires_at = now()->addMinutes(20);
        $user->save();

        $url = url('/auth/magic-login/' . $token);

        return response()->json([
            'url' => $url,
            'token' => $token,
        ]);
    }

    public function magicLogin($token)
    {
        $hashed = hash('sha256', $token);

        $user = User::where('login_token', $hashed)->firstOrFail();

        if ($user->login_token_expires_at && $user->login_token_expires_at->isPast()) {
            $user->login_token = null;
            $user->login_token_expires_at = null;
            $user->save();

            return redirect()->route('login')->with('error', 'Link login sudah kadaluarsa. Silakan minta link baru.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->email_verified_at = now();
        }

        Auth::login($user);

        $user->login_token = null;
        $user->login_token_expires_at = null;
        $user->save();

        return redirect()->intended(route('dashboard'));
    }
}

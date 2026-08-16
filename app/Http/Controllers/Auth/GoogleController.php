<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $avatarPath = null;

        if ($googleUser->avatar) {
            $avatarContents = Http::get($googleUser->avatar)->body();
            $avatarPath = 'avatars/google_'.md5($googleUser->email).'.jpg';

            Storage::disk('public')->put($avatarPath, $avatarContents);
        }
        // 🔽 create / update user
        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name' => $googleUser->name,
                'password' => Hash::make(Str::random(32)),
                'google_id' => $googleUser->id,
                'avatar' => $avatarPath,
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user);

        // Ensure Google users have the 'user' role
        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }

        // 🔽 redirect logic
        return redirect()->route('dashboard.user');
    }
}

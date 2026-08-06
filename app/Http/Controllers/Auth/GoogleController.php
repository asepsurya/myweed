<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
            $avatarContents = Http::withOptions([
                'verify' => env('CURL_CA_BUNDLE', 'C:\\php\\extras\\ssl\\cacert.pem'),
            ])->get($googleUser->avatar)->body();
            $avatarPath = 'avatars/google_' . md5($googleUser->email) . '.jpg';

            Storage::disk('public')->put($avatarPath, $avatarContents);
        }
        // 🔽 create / update user
        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name'      => $googleUser->name,
                'password'  => Hash::make(Str::random(32)),
                'google_id' => $googleUser->id,
                'avatar'    => $avatarPath,
            ]
        );


        Auth::login($user);

        // 🔽 Otomatis buat undangan jika belum punya
        if (!Invitation::where('user_id', $user->id)->exists()) {
            Invitation::createDefault($user->id);
        }

        // 🔽 redirect logic
        return redirect()->route('dashboard.user');
    }
}

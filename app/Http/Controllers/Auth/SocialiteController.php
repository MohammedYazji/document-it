<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update only avatar on subsequent logins
                $user->update(['avatar' => $googleUser->getAvatar()]);
            } else {
                // Create new user with Google data
                $user = User::create([
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName(),
                    'username' => $googleUser->getNickname() ?? strtolower(str_replace(' ', '', $googleUser->getName())),
                    'avatar' => $googleUser->getAvatar(),
                    'type' => 'user',
                ]);
            }

            Auth::login($user, true);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }
}

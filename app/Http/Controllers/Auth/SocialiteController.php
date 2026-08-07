<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'username' => $googleUser->getNickname() ?? strtolower(str_replace(' ', '', $googleUser->getName())),
                    'type' => 'user',
                ]
            );

            Auth::login($user, true);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }
}

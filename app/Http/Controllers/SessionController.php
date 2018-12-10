<?php

namespace App\Http\Controllers;

use App\Domain\Users\User;
use Laravel\Socialite\Facades\Socialite;
use Auth;

class SessionController extends Controller
{
    const SOCIAL_PROVIDER = 'vkontakte';

    public function redirect()
    {
        return Socialite::with(self::SOCIAL_PROVIDER)->scopes(['ads', 'offline'])->redirect();
    }

    public function login()
    {
        $social = Socialite::driver(self::SOCIAL_PROVIDER)->user();

        $user = User::where('api_user_id', $social->getId())->first();
        if (!$user) {
            $user = User::create([
                'name' => $social->getName(),
                'api_user_id' => $social->getId(),
                'api_access_token' => $social->accessTokenResponseBody['access_token'],
                'avatar' => explode('?', $social->user['photo'])[0] ?? ''
            ]);
        }
        auth()->login($user, true);

        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()
            ->home();
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginWithSocialiteController extends Controller
{


    //github login
    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();

    }

    public function githubCallback()
    {
        $gitUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate(
            ['email' => $gitUser->email],
            [
                'name'          => $gitUser->name,
                'provider_name'      => 'github',
                'provider_id'   => $gitUser->id,
                'avatar'        => $gitUser->avatar,
                'password'      => Hash::make(12345678),
            ]
        );

        Auth::login($user);
        return redirect('/dashboard');
    }

    //Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function GoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name'          => $googleUser->name,
                'provider_name'      => 'google',
                'provider_id'   => $googleUser->id,
                'avatar'        => $googleUser->avatar,
                'password'      => Hash::make(12345678),
            ]
        );
        Auth::login($user);
        return redirect('/dashboard');
    }

    //linkedin login

    public function redirectTolinkedin()
    {
      
        return Socialite::driver('linkedin')->stateless()->scopes(['r_liteprofile', 'r_emailaddress'])->redirect();
    }

    public function linkedinCallback()
    {
        $linkedUser = Socialite::driver('linkedin')->user();
        dd($linkedUser);
    }
}

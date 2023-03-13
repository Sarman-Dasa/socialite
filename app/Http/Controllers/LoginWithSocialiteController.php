<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginWithSocialiteController extends Controller
{
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
}

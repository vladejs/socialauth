<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialAccountService;
use Socialite;

class SocialAuth extends Controller
{
    public function redirect() {
//        return Socialite::diver('facebook')->redirect();
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(SocialAccountService $service) {
        $providerUser = Socialite::driver('facebook')->user();
        $user = $service->signUpOrLoginUser($providerUser);

        auth()->login($user);

        return $this->redirect()->to('/home');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: vla2
 * Date: 05/12/2016
 * Time: 10:24 AM
 */

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function signUpOrLoginUser(ProviderUser $pv) {
        $account = SocialAccount
            ::whereProvider('facebook')
            ->whereProviderUserId($pv->getId())
            ->first();

        if ($account) {
            return $account->user();
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $pv->getId(),
                'provider' => 'facebook'
            ]);

            $user = User
                ::whereEmail($pv->getEmail())
                ->first();

            if (!$user) {
                $user = User::create([
                    'email' => $pv->getEmail(),
                    'name'  => $pv->getName()
                ]);
            }

            $account
                ->user()
                ->associate($user);

            $account->save();

            return $user;
        }
    }
}
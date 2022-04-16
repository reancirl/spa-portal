<?php

namespace App\Services;

class UserService
{
    protected const TOKEN_NAME = 'Dealer Portal';

    protected const TOKEN_TYPE = 'Bearer';

    /**
     * Register any application services.
     *
     * @param \App\Models\User $user
     * @return object
     */
    public function createAppToken($user)
    {
        return (object) [
            'access_token' => $user->createToken(self::TOKEN_NAME)->plainTextToken,
            'token_type' => self::TOKEN_TYPE,
        ];
    }
}

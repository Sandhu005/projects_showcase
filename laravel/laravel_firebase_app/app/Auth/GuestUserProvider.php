<?php

namespace App\Auth;

use App\Models\Guest;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class GuestUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return new Guest($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->retrieveById($identifier);
    }

    public function updateRememberToken(
        Authenticatable $user,
        $token
    ) {
        //
    }

    public function retrieveByCredentials(array $credentials)
    {
        return null;
    }

    public function validateCredentials(
        Authenticatable $user,
        array $credentials
    ) {
        return false;
    }

    public function rehashPasswordIfRequired(
        Authenticatable $user,
        array $credentials,
        bool $force = false
    ): void {
        //
    }
}

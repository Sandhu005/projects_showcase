<?php

namespace App\Auth;

use App\Models\Farmer;
use App\Services\FarmerService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class FirebaseFarmerUserProvider implements UserProvider
{
    public function __construct(
        protected FarmerService $farmers
    ) {}

    public function retrieveById($identifier)
    {
        $farmer = $this->farmers->show($identifier);

        if (!$farmer) {
            return null;
        }

        if (($farmer['status'] ?? 'active') === 'deleted') {
            return null;
        }

        return new Farmer($identifier);
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
        if (!isset($credentials['phone'])) {
            return null;
        }

        $farmer = $this->farmers->findByPhone(
            $credentials['phone']
        );

        if (!$farmer) {
            return null;
        }

        if (($farmer['status'] ?? 'active') === 'deleted') {
            return null;
        }

        return new Farmer($farmer['id']);
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
        // OTP authentication does not use passwords.
    }
}

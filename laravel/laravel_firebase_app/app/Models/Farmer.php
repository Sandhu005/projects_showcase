<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Farmer implements
Authenticatable, JWTSubject

{
     public function __construct(
        public string $id
    ) {
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'type' => 'farmer',
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function getAuthPassword()
    {
        return '';
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Not used.
    }

    public function getRememberTokenName()
    {
        return null;
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Guest implements Authenticatable, JWTSubject
{
    public function __construct(
        public string $id
    ) {
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): string
    {
        return $this->id;
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword(): ?string
    {
        return null;
    }

    public function getRememberToken(): string
    {
        return '';
    }

    public function setRememberToken($value): void
    {
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

    public function getJWTIdentifier()
    {
        return $this->id;
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'type' => 'guest',
        ];
    }
}

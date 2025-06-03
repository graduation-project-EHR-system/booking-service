<?php

namespace App\Data\Auth;

use App\Enums\UserRole;

class AuthUser{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public UserRole $role
    ) {
    }

    public static function fromRequest($request): self
    {
        return new self(
            id: $request->id,
            name: $request->name,
            email: $request->email,
            role: $request->role,
        );
    }
}

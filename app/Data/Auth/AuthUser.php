<?php

namespace App\Data\Auth;

use App\Enums\UserRole;
use Spatie\LaravelData\Data;

class AuthUser extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public UserRole $role
    ) {}
}

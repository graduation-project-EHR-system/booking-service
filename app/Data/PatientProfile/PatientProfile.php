<?php
namespace App\Data\PatientProfile;

use Spatie\LaravelData\Data;

class PatientProfile extends Data
{
    public function __construct(
        public string $id,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $address = null
    ) {}
}

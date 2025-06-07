<?php
namespace App\Data\PatientProfile;

use Spatie\LaravelData\Data;

class PatientProfile extends Data
{
    public function __construct(
        public string $id,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $national_id = null,
        public ?string $address = null
    ) {}
}

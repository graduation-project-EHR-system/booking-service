<?php

namespace App\Interfaces;

use App\Data\PatientProfile\PatientProfile;

interface PatientProfileServiceInterface
{
    public function getById(string $id): PatientProfile;
}

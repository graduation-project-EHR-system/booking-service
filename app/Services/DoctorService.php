<?php

namespace App\Services;

use App\Interfaces\DoctorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DoctorService
{
    public function __construct(private DoctorRepositoryInterface $doctorRepository)
    {
    }

    public function getLookup(): Collection
    {
        return $this->doctorRepository->getAll(['id', 'name', 'specialization']);
    }
}
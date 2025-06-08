<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface DoctorRepositoryInterface
{
    public function getAll(array $columns = ['*']): Collection;
}
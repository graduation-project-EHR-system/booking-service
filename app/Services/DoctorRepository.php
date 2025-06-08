<?php

namespace App\Services;

use App\Interfaces\DoctorRepositoryInterface;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Collection;

class DoctorRepository implements DoctorRepositoryInterface
{
    public function getAll(array $columns = ['*']): Collection
    {
        return Doctor::when($columns[0] !== '*', function ($query) use ($columns) {
            return $query->select($columns);
        })->get();
    }
}
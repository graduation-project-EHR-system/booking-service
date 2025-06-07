<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class BookingFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function status(string $status): self
    {
        return $this->where('status', $status);
    }

    public function type(string $type): self
    {
        return $this->where('type', $type);
    }

    public function doctorId(string $doctorId): self
    {
        return $this->where('doctor_id', $doctorId);
    }

    public function patientId(string $patientId): self
    {
        return $this->where('patient_id', $patientId);
    }
}

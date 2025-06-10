<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    protected $fillable = [
        'id',
        'clinic_name',
        'date',
        'from',
        'to',
    ];
}

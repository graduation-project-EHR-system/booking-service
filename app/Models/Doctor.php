<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $fillable = [
        'id',
        'name',
        'specialization',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}

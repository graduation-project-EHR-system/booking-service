<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasUuids;

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

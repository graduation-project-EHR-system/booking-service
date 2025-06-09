<?php

namespace App\Data;

use App\Enums\BookingStatus;
use App\Enums\BookingType;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class BookingData extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $doctor_id = null,
        public ?string $patient_id = null,
        public ?string $patient_name = null,
        public ?string $patient_national_id = null,
        public ?string $booked_at = null,
        public ?BookingType $type = null,
        public ?BookingStatus $status = null,
        public ?string $appointment_date = null,
        public ?string $appointment_time = null
    ) {}
}

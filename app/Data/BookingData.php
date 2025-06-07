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
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $booked_at = null,
        public ?BookingType $type = null,
        public ?BookingStatus $status = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $appointment_date = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $appointment_time = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $created_at = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $updated_at = null,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $deleted_at = null,
    ) {}
}

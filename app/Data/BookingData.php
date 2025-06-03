<?php
namespace App\Data;

use App\Enums\BookingStatus;
use App\Enums\BookingType;
use DateTime;
use Illuminate\Support\Carbon;

class BookingData
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $doctor_id = null,
        public readonly ?string $patient_id = null,
        public readonly ?string $patient_name = null,
        public readonly ?string $patient_national_id = null,
        public readonly ?DateTime $booked_at = null,
        public readonly ?BookingType $type = null,
        public readonly ?BookingStatus $status = null,
        public readonly ?DateTime $appointment_date = null,
        public readonly ?DateTime $appointment_time = null,
        public readonly ?DateTime $created_at = null,
        public readonly ?DateTime $updated_at = null,
        public readonly ?DateTime $deleted_at = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            doctor_id: $data['doctor_id'] ?? null,
            patient_id: $data['patient_id'] ?? null,
            patient_name: $data['patient_name'] ?? null,
            patient_national_id: $data['patient_national_id'] ?? null,
            booked_at: isset($data['booked_at']) ? Carbon::parse($data['booked_at']) : null,
            type: isset($data['type']) ?
            (is_string($data['type']) ? BookingType::from($data['type']) : $data['type']) :
            null,
            status: isset($data['status']) ?
            (is_string($data['status']) ? BookingStatus::from($data['status']) : $data['status']) :
            null,
            appointment_date: isset($data['appointment_date']) ? Carbon::parse($data['appointment_date']) : null,
            appointment_time: isset($data['appointment_time']) ? Carbon::parse($data['appointment_time']) : null,
            created_at: isset($data['created_at']) ? Carbon::parse($data['created_at']) : null,
            updated_at: isset($data['updated_at']) ? Carbon::parse($data['updated_at']) : null,
            deleted_at: isset($data['deleted_at']) ? Carbon::parse($data['deleted_at']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'id'                  => $this->id,
            'doctor_id'           => $this->doctor_id,
            'patient_id'          => $this->patient_id,
            'patient_name'        => $this->patient_name,
            'patient_national_id' => $this->patient_national_id,
            'booked_at'           => $this->booked_at?->format('Y-m-d H:i:s'),
            'type'                => $this->type?->value,
            'status'              => $this->status?->value,
            'appointment_date'    => $this->appointment_date?->format('Y-m-d'),
            'appointment_time'    => $this->appointment_time?->format('H:i:s'),
            'created_at'          => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at'          => $this->updated_at?->format('Y-m-d H:i:s'),
            'deleted_at'          => $this->deleted_at?->format('Y-m-d H:i:s'),
        ];
    }
}

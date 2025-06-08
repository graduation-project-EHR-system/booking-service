<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'doctor_id' => $this->doctor_id,
            'patient_name' => $this->patient_name,
            'booked_at' => $this->booked_at?->format('Y-m-d H:i:s'),
            'type' => $this->type,
            'status' => $this->status,
            'appointment_date' => $this->appointment_date?->format('Y-m-d'),
            'appointment_time' => $this->appointment_time?->format('H:i'),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
        ];
    }
}
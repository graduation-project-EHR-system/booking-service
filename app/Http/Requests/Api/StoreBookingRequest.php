<?php

namespace App\Http\Requests\Api;

use App\Enums\BookingType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'string', 'min:3', 'max:255', 'exists:doctors,id'],
            'type' => ['required', 'string', Rule::enum(BookingType::class)],
            'patient_id' => ['required', 'string', 'min:3', 'max:255'],
            'appointment_date' => ['required', 'date_format:Y-m-d'],
            'appointment_time' => ['required', 'date_format:H:i'],
        ];
    }
}

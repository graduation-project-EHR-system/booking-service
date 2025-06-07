<?php

namespace App\Http\Requests\Api;

use App\Enums\BookingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
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
            'status' => ['string', Rule::enum(BookingStatus::class)],
            'appointment_date' => ['date_format:Y-m-d'],
            'appointment_time' => ['date_format:H:i'],
        ];
    }
}

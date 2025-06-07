<?php
namespace App\Services\External;

use App\Data\PatientProfile\PatientProfile;
use App\Interfaces\PatientProfileServiceInterface;
use Illuminate\Support\Facades\Http;

class PatientProfileService implements PatientProfileServiceInterface
{
    public function __construct()
    {}

    public function getById(string $id): PatientProfile
    {
        $response = Http::withHeaders([
            'x-api-key' => config('services.patient_profile.api_key'),
        ])->get(config('services.patient_profile.base_url') . '/api/patient/' . $id);

        return PatientProfile::from($response->json());
    }
}

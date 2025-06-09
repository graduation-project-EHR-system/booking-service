<?php
namespace App\Services\External;

use App\Data\PatientProfile\PatientProfile;
use App\Interfaces\PatientProfileServiceInterface;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PatientProfileService implements PatientProfileServiceInterface
{
    public function __construct()
    {}

    public function getById(string $id): PatientProfile
    {
        $response = Http::withHeaders([
            'x-api-key' => config('services.patient_profile.api_key'),
        ])->get(config('services.patient_profile.base_url') . '/api/patient/' . $id);

        $this->ensureSuccessResponse($response);

        return PatientProfile::from($response->json('data'));
    }

    private function ensureSuccessResponse(Response $response)
    {
        throw_if($response->failed() , new Exception('Failed response'));

        throw_if($response->json('statusCode') !== \Symfony\Component\HttpFoundation\Response::HTTP_OK, new \Exception('Failed response'));
    }
}

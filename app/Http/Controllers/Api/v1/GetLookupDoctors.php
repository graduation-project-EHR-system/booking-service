<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\DoctorService;
use App\Util\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetLookupDoctors extends Controller
{
    public function __construct(private DoctorService $doctorService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $doctors = $this->doctorService->getLookup();

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Doctors retrieved successfully',
            data: $doctors
        );
    }
}

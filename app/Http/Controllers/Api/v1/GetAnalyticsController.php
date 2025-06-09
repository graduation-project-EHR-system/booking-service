<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use App\Util\ApiResponse;
use Illuminate\Http\Request;

class GetAnalyticsController extends Controller
{
    public function __construct(
        private AnalyticsService $analyticsService
    ) {
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return ApiResponse::success(
            data : $this->analyticsService->getBookingsAnalyticsForLast7Days(),
            message : 'Bookings analytics for last 7 days'
        );
    }
}

<?php

namespace App\Services;

use App\Interfaces\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AnalyticsService
{
    public function __construct(
        private BookingRepositoryInterface $bookingRepository
    ) {
    }

    public function getBookingsAnalyticsForLast7Days() : Collection
    {
        return $this->bookingRepository->getCountForLastDays(7);
    }
}
<?php

namespace App\Services;

use App\Data\BookingData;
use App\Enums\BookingStatus;
use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use Carbon\Carbon;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingService
{
    private BookingRepositoryInterface $bookingRepository;

    /**
     * BookingService constructor.
     */
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Get all bookings with pagination
     */
    public function getAllBookings(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->bookingRepository->getAllBookings($perPage, $filters);
    }

    /**
     * Get a booking by ID
     */
    public function getBookingById(string $id): ?Booking
    {
        return $this->bookingRepository->getBookingById($id);
    }

    /**
     * Create a new booking
     *
     * @throws Exception
     */
    public function createBooking(BookingData $bookingData): Booking
    {
        $bookingData->booked_at = Carbon::now();
        $bookingData->status = BookingStatus::PENDING;

        return $this->bookingRepository->createBooking($bookingData);
    }

    /**
     * Update an existing booking
     */
    public function updateBooking(string $id, BookingData $bookingData): ?Booking
    {
        // Get existing booking
        $existingBooking = $this->bookingRepository->getBookingById($id);

        if (! $existingBooking) {
            return null;
        }

        // Update repository
        return $this->bookingRepository->updateBooking(
            $id,
            $bookingData
        );
    }
}

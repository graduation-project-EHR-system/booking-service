<?php

namespace App\Services;

use App\Data\BookingData;
use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingRepositoryInterface
{
    /**
     * Get all bookings with pagination
     */
    public function getAllBookings(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $bookings = Booking::orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->with('doctor')
            ->filter($filters)
            ->paginate($perPage);

        return $bookings;
    }

    /**
     * Get a booking by ID
     */
    public function getBookingById(string $id): ?Booking
    {
        return Booking::with('doctor')->find($id);
    }

    /**
     * Create a new booking
     */
    public function createBooking(BookingData $bookingData): Booking
    {
        return Booking::create($bookingData->toArray());
    }

    /**
     * Update an existing booking
     */
    public function updateBooking(string $id, BookingData $bookingData): ?Booking
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return null;
        }

        $booking->update($bookingData->toArray());

        return $booking;
    }

    public function getCountForLastDays(int $numberOfDays): Collection
    {
        return Booking::where('created_at', '>=', now()->subDays($numberOfDays))
            ->groupBy('created_at')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->get();
    }
}

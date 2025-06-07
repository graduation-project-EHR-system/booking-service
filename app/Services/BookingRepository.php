<?php

namespace App\Services;

use App\Data\BookingData;
use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository implements BookingRepositoryInterface
{
    /**
     * Get all bookings with pagination
     */
    public function getAllBookings(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $query = Booking::query();

        // Apply filters if any
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('appointment_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('appointment_date', '<=', $filters['date_to']);
        }

        // Get paginated results
        $bookings = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Transform to DTOs
        $bookings->setCollection(
            $bookings->getCollection()->map(function ($booking) {
                return BookingData::from($booking);

            })
        );

        return $bookings;
    }

    /**
     * Get a booking by ID
     */
    public function getBookingById(string $id): ?BookingData
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return null;
        }

        return BookingData::from($booking);

    }

    /**
     * Create a new booking
     */
    public function createBooking(BookingData $bookingData): BookingData
    {
        $booking = new Booking;

        // Convert DTO to model attributes
        $attributes = $bookingData->toArray();
        unset($attributes['id']); // Remove ID for creation

        foreach ($attributes as $key => $value) {
            if ($value !== null) {
                $booking->{$key} = $value;
            }
        }

        $booking->save();

        // Return new booking as DTO
        return BookingData::from($booking);

    }

    /**
     * Update an existing booking
     */
    public function updateBooking(string $id, BookingData $bookingData): ?BookingData
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return null;
        }

        // Convert DTO to model attributes
        $attributes = $bookingData->toArray();
        unset($attributes['id']); // Remove ID for update

        foreach ($attributes as $key => $value) {
            if ($value !== null) {
                $booking->{$key} = $value;
            }
        }

        $booking->save();

        // Return updated booking as DTO
        return BookingData::from($booking);

    }

    /**
     * Delete a booking
     */
    public function deleteBooking(string $id): bool
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return false;
        }

        return $booking->delete();
    }

    /**
     * Get bookings by doctor ID
     */
    public function getBookingsByDoctorId(string $doctorId, int $perPage = 15): LengthAwarePaginator
    {
        $bookings = Booking::where('doctor_id', $doctorId)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate($perPage);

        // Transform to DTOs
        $bookings->setCollection(
            $bookings->getCollection()->map(function ($booking) {
                return BookingData::from($booking);

            })
        );

        return $bookings;
    }

    /**
     * Get bookings by patient ID
     */
    public function getBookingsByPatientId(string $patientId, int $perPage = 15): LengthAwarePaginator
    {
        $bookings = Booking::where('patient_id', $patientId)
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate($perPage);

        // Transform to DTOs
        $bookings->setCollection(
            $bookings->getCollection()->map(function ($booking) {
                return BookingData::from($booking);
            })
        );

        return $bookings;
    }
}

<?php
namespace App\Interfaces;

use App\Data\BookingData;
use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

interface BookingRepositoryInterface
{
    /**
     * Get all bookings with pagination
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllBookings(int $perPage = 15, array $filters = []): LengthAwarePaginator;

    /**
     * Get a booking by ID
     *
     * @param string $id
     * @return Booking|null
     */
    public function getBookingById(string $id): ?Booking;

    /**
     * Create a new booking
     *
     * @param BookingData $bookingData
     * @return Booking
     */
    public function createBooking(BookingData $bookingData): Booking;

    /**
     * Update an existing booking
     *
     * @param string $id
     * @param BookingData $bookingData
     * @return Booking|null
     */
    public function updateBooking(string $id, BookingData $bookingData): ?Booking;

    /**
     * Get bookings by doctor ID
     *
     * @param string $doctorId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getBookingsByDoctorId(string $doctorId, int $perPage = 15): LengthAwarePaginator;

    /**
     * Get bookings by patient ID
     *
     * @param string $patientId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getBookingsByPatientId(string $patientId, int $perPage = 15): LengthAwarePaginator;
}

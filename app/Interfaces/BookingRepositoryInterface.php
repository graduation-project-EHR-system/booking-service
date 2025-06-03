<?php
namespace App\Interfaces;

use App\Data\BookingData;
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
     * @return BookingData|null
     */
    public function getBookingById(string $id): ?BookingData;

    /**
     * Create a new booking
     *
     * @param BookingData $bookingData
     * @return BookingData
     */
    public function createBooking(BookingData $bookingData): BookingData;

    /**
     * Update an existing booking
     *
     * @param string $id
     * @param BookingData $bookingData
     * @return BookingData|null
     */
    public function updateBooking(string $id, BookingData $bookingData): ?BookingData;

    /**
     * Delete a booking
     *
     * @param string $id
     * @return bool
     */
    public function deleteBooking(string $id): bool;

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

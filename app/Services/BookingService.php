<?php

namespace App\Services;

use App\Data\BookingData;
use App\Enums\BookingStatus;
use App\Exceptions\InvalidBookingException;
use App\Interfaces\BookingRepositoryInterface;
use App\Models\Booking;
use App\Models\DoctorAvailability;
use App\Services\External\PatientProfileService;
use Carbon\Carbon;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingService
{
    /**
     * BookingService constructor.
     */
    public function __construct(
        protected BookingRepositoryInterface $bookingRepository,
        protected PatientProfileService $patientProfileService
    ) {}

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
        try {
            $bookingData->booked_at = Carbon::now();
            $bookingData->status = BookingStatus::PENDING;

            $patientProfile = $this->patientProfileService->getById($bookingData->patient_id);

            $bookingData->patient_name = $patientProfile->firstName.' '.$patientProfile->lastName;

            $this->validateAppointmentTime($bookingData);

            return $this->bookingRepository->createBooking($bookingData);
        } catch (Exception $e) {
            throw $e;
        }
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

        $this->validateAppointmentTime($bookingData);

        // Update repository
        return $this->bookingRepository->updateBooking(
            $id,
            $bookingData
        );
    }

    protected function validateAppointmentTime(BookingData $bookingData): void
    {
        $isValidAppointmentTime = DoctorAvailability::where('doctor_id', $bookingData->doctor_id)
            ->whereAll([
                'date' => $bookingData->appointment_date,
                'from' => '<=', $bookingData->appointment_time,
                'to' => '>=', $bookingData->appointment_time,
            ])
            ->exists();

        throw_if(! $isValidAppointmentTime, InvalidBookingException::dueToInvalidAppointmentTime());
    }
}

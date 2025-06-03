<?php
namespace App\Services;

use App\Data\BookingData;
use App\Enums\BookingStatus;
use App\Interfaces\BookingRepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class BookingService
{
    /**
     * @var BookingRepositoryInterface
     */
    private BookingRepositoryInterface $bookingRepository;

    /**
     * BookingService constructor.
     *
     * @param BookingRepositoryInterface $bookingRepository
     */
    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * Get all bookings with pagination
     *
     * @param int $perPage
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllBookings(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->bookingRepository->getAllBookings($perPage, $filters);
    }

    /**
     * Get a booking by ID
     *
     * @param string $id
     * @return BookingData|null
     */
    public function getBookingById(string $id): ?BookingData
    {
        return $this->bookingRepository->getBookingById($id);
    }

    /**
     * Create a new booking
     *
     * @param BookingData $bookingData
     * @return BookingData
     * @throws Exception
     */
    public function createBooking(BookingData $bookingData): BookingData
    {
        // Validate required fields
        $this->validateBookingData($bookingData);

        // Set default values if needed
        $data = $bookingData->toArray();

        if (empty($data['booked_at'])) {
            $data['booked_at'] = Carbon::now()->toDateTimeString();
        }

        if (empty($data['status'])) {
            $data['status'] = BookingStatus::PENDING->value;
        }

        // If anything was modified, create a new DTO
        if ($data['booked_at'] !== $bookingData->booked_at?->format('Y-m-d H:i:s') ||
            $data['status'] !== $bookingData->status?->value) {
            $bookingData = BookingData::fromArray($data);
        }

        // Save to repository
        return $this->bookingRepository->createBooking($bookingData);
    }

    /**
     * Update an existing booking
     *
     * @param string $id
     * @param BookingData $bookingData
     * @return BookingData|null
     */
    public function updateBooking(string $id, BookingData $bookingData): ?BookingData
    {
        // Get existing booking
        $existingBooking = $this->bookingRepository->getBookingById($id);

        if (! $existingBooking) {
            return null;
        }

        // Merge existing data with new data
        $mergedData = array_merge(
            $existingBooking->toArray(),
            $bookingData->toArray()
        );

        // Create new DTO with merged data
        $updatedBookingData = BookingData::fromArray($mergedData);

        // Update repository
        return $this->bookingRepository->updateBooking($id, $updatedBookingData);
    }

    /**
     * Delete a booking
     *
     * @param string $id
     * @return bool
     */
    public function deleteBooking(string $id): bool
    {
        return $this->bookingRepository->deleteBooking($id);
    }

    /**
     * Get bookings by doctor ID
     *
     * @param string $doctorId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getBookingsByDoctorId(string $doctorId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->bookingRepository->getBookingsByDoctorId($doctorId, $perPage);
    }

    /**
     * Get bookings by patient ID
     *
     * @param string $patientId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getBookingsByPatientId(string $patientId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->bookingRepository->getBookingsByPatientId($patientId, $perPage);
    }

    /**
     * Validate booking data
     *
     * @param BookingData $data
     * @return void
     * @throws Exception
     */
    private function validateBookingData(BookingData $data): void
    {
        // Check required fields
        if (empty($data->doctor_id)) {
            throw new Exception("The field 'doctor_id' is required for booking.");
        }

        if (empty($data->patient_id)) {
            throw new Exception("The field 'patient_id' is required for booking.");
        }

        if (empty($data->type)) {
            throw new Exception("The field 'type' is required for booking.");
        }

        if (empty($data->appointment_date)) {
            throw new Exception("The field 'appointment_date' is required for booking.");
        }

        if (empty($data->appointment_time)) {
            throw new Exception("The field 'appointment_time' is required for booking.");
        }

        // Validate appointment date is in the future
        if ($data->appointment_date && $data->appointment_date->isPast()) {
            throw new Exception("The appointment date must be in the future.");
        }
    }
}

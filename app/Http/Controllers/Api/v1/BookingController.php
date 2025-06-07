<?php

namespace App\Http\Controllers\Api\v1;

use App\Data\BookingData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBookingRequest;
use App\Http\Requests\Api\UpdateBookingRequest;
use App\Services\BookingService;
use App\Util\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    private BookingService $bookingService;

    /**
     * BookingController constructor.
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the bookings.
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 15);

        $bookings = $this->bookingService->getAllBookings($perPage, $request->all());

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Bookings retrieved successfully',
            data: $bookings
        );
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        try {
            $bookingData = BookingData::from($request->validated());

            $booking = $this->bookingService->createBooking($bookingData);

            return ApiResponse::send(
                code: Response::HTTP_CREATED,
                message: 'Booking created successfully',
                data: $booking
            );
        } catch (Exception $e) {
            return ApiResponse::send(
                code: Response::HTTP_BAD_REQUEST,
                message: $e->getMessage()
            );
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(string $id): JsonResponse
    {
        $booking = $this->bookingService->getBookingById($id);

        if (! $booking) {
            return ApiResponse::send(
                code: Response::HTTP_NOT_FOUND,
                message: 'Booking not found'
            );
        }

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Booking retrieved successfully',
            data: $booking
        );
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(UpdateBookingRequest $request, string $id): JsonResponse
    {
        $bookingData = BookingData::from($request->validated());

        $booking = $this->bookingService->updateBooking($id, $bookingData);

        if (! $booking) {
            return ApiResponse::send(
                code: Response::HTTP_NOT_FOUND,
                message: 'Booking not found'
            );
        }

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Booking status updated successfully',
            data: $booking
        );
    }

    /**
     * Get bookings by doctor ID.
     */
    public function getByDoctor(Request $request, string $doctorId): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 15);
        $bookings = $this->bookingService->getBookingsByDoctorId($doctorId, $perPage, $request->all());

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Doctor bookings retrieved successfully',
            data: $bookings
        );
    }

    /**
     * Get bookings by patient ID.
     */
    public function getByPatient(Request $request, string $patientId): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 15);
        $bookings = $this->bookingService->getBookingsByPatientId($patientId, $perPage, $request->all());

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Patient bookings retrieved successfully',
            data: $bookings
        );
    }
}

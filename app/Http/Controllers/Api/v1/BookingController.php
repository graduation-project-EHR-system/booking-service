<?php
namespace App\Http\Controllers\Api\v1;

use App\Data\BookingData;
use App\Http\Controllers\Controller;
use App\Services\BookingService;
use App\Util\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    /**
     * @var BookingService
     */
    private BookingService $bookingService;

    /**
     * BookingController constructor.
     *
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of the bookings.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->input('per_page', 15);
        $filters = $request->only(['status', 'type', 'date_from', 'date_to']);

        $bookings = $this->bookingService->getAllBookings($perPage, $filters);

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Bookings retrieved successfully',
            data: $bookings
        );
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Create DTO from request data
            $bookingData = BookingData::fromArray($request->all());
            $booking     = $this->bookingService->createBooking($bookingData);

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
     *
     * @param string $id
     * @return JsonResponse
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
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        // Create DTO from request data
        $bookingData = BookingData::fromArray($request->all());
        $booking     = $this->bookingService->updateBooking($id, $bookingData);

        if (! $booking) {
            return ApiResponse::send(
                code: Response::HTTP_NOT_FOUND,
                message: 'Booking not found'
            );
        }

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Booking updated successfully',
            data: $booking
        );
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $result = $this->bookingService->deleteBooking($id);

        if (! $result) {
            return ApiResponse::send(
                code: Response::HTTP_NOT_FOUND,
                message: 'Booking not found'
            );
        }

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Booking deleted successfully'
        );
    }

    /**
     * Get bookings by doctor ID.
     *
     * @param Request $request
     * @param string $doctorId
     * @return JsonResponse
     */
    public function getByDoctor(Request $request, string $doctorId): JsonResponse
    {
        $perPage  = (int) $request->input('per_page', 15);
        $bookings = $this->bookingService->getBookingsByDoctorId($doctorId, $perPage);

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Doctor bookings retrieved successfully',
            data: $bookings
        );
    }

    /**
     * Get bookings by patient ID.
     *
     * @param Request $request
     * @param string $patientId
     * @return JsonResponse
     */
    public function getByPatient(Request $request, string $patientId): JsonResponse
    {
        $perPage  = (int) $request->input('per_page', 15);
        $bookings = $this->bookingService->getBookingsByPatientId($patientId, $perPage);

        return ApiResponse::send(
            code: Response::HTTP_OK,
            message: 'Patient bookings retrieved successfully',
            data: $bookings
        );
    }
}

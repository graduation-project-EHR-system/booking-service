<?php

namespace App\Http\Controllers\Api\v1;

use App\Data\BookingData;
use App\Exceptions\InvalidBookingException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBookingRequest;
use App\Http\Requests\Api\UpdateBookingRequest;
use App\Http\Resources\Api\BookingResource;
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
            data: $bookings,
            resource: BookingResource::class
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
                data: new BookingResource($booking)
            );
        } catch (InvalidBookingException $e) {
            return ApiResponse::send(
                code: Response::HTTP_BAD_REQUEST,
                message: $e->getMessage()
            );
        } catch (Exception $e) {
            return ApiResponse::send(
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
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
            data: new BookingResource($booking)
        );
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(UpdateBookingRequest $request, string $id): JsonResponse
    {
        try {
            $oldBooking = $this->bookingService->getBookingById($id);

            $booking = $this->bookingService->updateBooking(
                $id,
                BookingData::from(
                    array_merge(
                        $oldBooking->attributesToArray(),
                        $request->validated(),
                    )
                )
            );

            if (! $booking) {
                return ApiResponse::send(
                    code: Response::HTTP_NOT_FOUND,
                    message: 'Booking not found'
                );
            }

            return ApiResponse::send(
                code: Response::HTTP_OK,
                message: 'Booking status updated successfully',
                data: new BookingResource($booking)
            );
        } catch (InvalidBookingException $e) {
            return ApiResponse::send(
                code: Response::HTTP_BAD_REQUEST,
                message: $e->getMessage()
            );
        } catch (Exception $e) {
            return ApiResponse::send(
                code: Response::HTTP_INTERNAL_SERVER_ERROR,
                message: $e->getMessage()
            );
        }
    }
}

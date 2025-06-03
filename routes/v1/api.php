<?php

use App\Http\Controllers\Api\v1\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (v1)
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// Booking routes
Route::apiResource('bookings', BookingController::class);

// Additional booking routes
Route::get('doctors/{doctorId}/bookings', [BookingController::class, 'getByDoctor']);
Route::get('patients/{patientId}/bookings', [BookingController::class, 'getByPatient']);

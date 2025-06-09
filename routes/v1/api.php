<?php

use App\Http\Controllers\Api\v1\BookingController;
use App\Http\Controllers\Api\v1\GetAnalyticsController;
use App\Http\Controllers\Api\v1\GetLookupDoctors;
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

Route::get('lookup/doctors', GetLookupDoctors::class);

Route::get('analytics' , GetAnalyticsController::class);
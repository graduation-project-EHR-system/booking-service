<?php

use App\Http\Controllers\Api\v1\BookingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->apiResource('bookings', BookingController::class);

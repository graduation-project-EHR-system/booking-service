<?php
namespace App\Enums;

enum BookingStatus: string {
    case PENDING   = 'pending';
    case CANCELLED = 'cancelled';
    case NO_SHOW   = 'no_show';
    case COMPLETED = 'completed';
}

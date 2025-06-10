<?php

namespace App\Exceptions;

use Exception;

class InvalidBookingException extends Exception
{
    public static function dueToInvalidAppointmentTime()
    {
        return new self('Invalid appointment time');
    }
}

<?php
namespace App\Enums;

enum BookingType : string {
    case CONSULTATION = 'consultation';
    case EXAMINATION = 'examination';
}
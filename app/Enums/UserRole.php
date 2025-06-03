<?php
namespace App\Enums;

enum UserRole : string {
    case ADMIN = 'Admin';
    case DOCTOR = 'Doctor';
    case NURSE = 'Nurse';
    case RECEPTIONIST = 'Receptionist';
}

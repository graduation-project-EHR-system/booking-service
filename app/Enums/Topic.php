<?php

namespace App\Enums;

enum Topic: string
{
    case USER_CREATED = 'user.created';
    case USER_UPDATED = 'user.updated';
    case USER_DELETED = 'user.deleted';
}

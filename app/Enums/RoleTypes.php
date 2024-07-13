<?php

namespace App\Enums;

enum RoleTypes: string
{
    case ADMIN_VIEW = 'ADMIN_VIEW';
    case ADMIN_ROLE = 'ADMIN_ROLE';
    case ADMIN_CREATE = 'ADMIN_CREATE';
    case ADMIN_UPDATE = 'ADMIN_UPDATE';
    case ADMIN_DELETE = 'ADMIN_DELETE';

    case USER_VIEW = 'USER_VIEW';
    case USER_CREATE = 'USER_CREATE';
    case USER_UPDATE = 'USER_UPDATE';
    case USER_DELETE = 'USER_DELETE';
}

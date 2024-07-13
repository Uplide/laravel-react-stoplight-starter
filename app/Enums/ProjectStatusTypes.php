<?php

namespace App\Enums;

enum ProjectStatusTypes: string
{
    case PENDING = 'pending';
    case IN_PROCESS = 'in_process';
    case COMPLETED = 'completed';
}

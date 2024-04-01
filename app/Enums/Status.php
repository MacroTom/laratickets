<?php

namespace App\Enums;

enum Status: string
{
    case ONGOING = 'ongoing';
    case RESOLVED = 'resolved';
    case DISABLED = 'disabled';
    case ACTIVE = 'active';
}

<?php

namespace App\Enums;

enum OrderStatus
{
    case WAIT = 'WAIT';
    case PENDING = 'PENDING';
    case DELIVERED = 'DELIVERED';
    case DELIVERING = 'DELIVERING';

    case CANCELLED = 'CANCELLED';
    case UNACCEPTED = 'UNACCEPTED';
}

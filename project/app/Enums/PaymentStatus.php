<?php

namespace App\Enums;

enum PaymentStatus
{
    case CASH = 'CASH';
    case TRANSFER = 'TRANSFER';
}

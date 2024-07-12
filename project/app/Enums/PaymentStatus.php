<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case CASH = 'CASH';
    case TRANSFER = 'TRANSFER';
}

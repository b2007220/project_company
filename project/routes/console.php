<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
Schedule::command('discounts:update-expired')->daily();
Schedule::command('orders:delete-wait-orders')->daily();
Schedule::command('send:discount-codes')->daily();
Schedule::command('emails:send-purchase-history')->yearly();

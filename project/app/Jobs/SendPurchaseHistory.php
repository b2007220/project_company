<?php

namespace App\Jobs;

use App\Mail\PurchaseHistoryMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use App\Models\User;

class SendPurchaseHistory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        $user = User::find($this->userId);
        $orders = Order::where('user_id', $this->userId)->get();
        $totalAmount = $orders->sum('grand_total');

        Mail::to($user->email)->send(new PurchaseHistoryMail($user, $orders, $totalAmount));
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PurchaseHistoryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $orders;
    public $totalAmount;
    /**
     * Create a new message instance.
     */
    public function __construct($user, $orders, $totalAmount)
    {
        $this->user = $user;
        $this->orders = $orders;
        $this->totalAmount = $totalAmount;
    }

    public function build()
    {
        return $this->view('emails.purchase_history')
            ->with([
                'user' => $this->user,
                'orders' => $this->orders,
                'totalAmount' => $this->totalAmount,
            ]);
    }
}

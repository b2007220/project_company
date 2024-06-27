<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiscountCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $discount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($discount)
    {
        $this->discount = $discount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.discount_code')
            ->with([
                'code' => $this->discount->code,
                'discount' => $this->discount->discount,
                'expires_at' => $this->discount->expires_at,
            ]);
    }
}

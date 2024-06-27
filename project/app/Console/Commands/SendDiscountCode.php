<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Discount;
use Illuminate\Support\Facades\Mail;
use App\Mail\DiscountCodeMail;

class SendDiscountCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:discount-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send discount codes to users';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $discount = Discount::where('type', 'ORDER')->where('is_active', true);

            Mail::to($user->email)->send(new DiscountCodeMail($discount));
        }

        $this->info('Discount codes have been sent successfully!');
    }
}

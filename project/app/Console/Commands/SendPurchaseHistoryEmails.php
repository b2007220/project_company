<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\SendPurchaseHistory;

class SendPurchaseHistoryEmails extends Command
{
    protected $signature = 'emails:send-purchase-history';
    protected $description = 'Send purchase history emails to all users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            dispatch(new SendPurchaseHistory($user->id));
        }

        $this->info('Purchase history emails have been dispatched.');
    }
}

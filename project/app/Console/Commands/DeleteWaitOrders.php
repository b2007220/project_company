<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Order;

class DeleteWaitOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-wait-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete wait orders after 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $waitOrders = Order::waitOrders();

        foreach ($waitOrders as $order) {
            $order->delete();
        }

        $this->info('Đơn hàng chờ đã được xóa.');
    }
}

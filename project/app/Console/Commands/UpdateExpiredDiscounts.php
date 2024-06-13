<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Discount;

class UpdateExpiredDiscounts extends Command
{
    protected $signature = 'discounts:update-expired';

    protected $description = 'Update is_active field of expired discounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $expiredDiscounts = Discount::expiredDiscounts();

        foreach ($expiredDiscounts as $discount) {
            $discount->update(['is_active' => false]);
            if ($discount->products) {
                foreach ($discount->products as $product) {
                    $product->discounts()->updateExistingPivot($discount->id, ['is_predefined' => false]);
                }
            }
        }

        $this->info('Mã giảm giá đã cập nhật trạng thái.');
    }
}

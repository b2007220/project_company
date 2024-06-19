<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\BankAccount;
use App\Models\Banner;
use App\Models\ProductDetail;
use App\Models\ProductPicture;
use App\Models\ProductDiscount;
use App\Models\UserSelectDiscount;
use App\Models\Order;
use App\Models\OrderDetail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
        ]);
        User::factory(10)->create();
        Category::factory(5)->create();
        Discount::factory(10)->create();
        Product::factory(20)->create();
        BankAccount::factory(10)->create();
        Banner::factory(10)->create();
        ProductDetail::factory(20)->create();
        ProductPicture::factory(30)->create();
        ProductDiscount::factory(10)->create();
        UserSelectDiscount::factory(10)->create();
        Order::factory(10)->create();
        OrderDetail::factory(30)->create();
    }
}

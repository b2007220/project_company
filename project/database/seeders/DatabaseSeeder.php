<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(5)->create();
        \App\Models\Discount::factory(10)->create();
        \App\Models\Product::factory(20)->create();
        \App\Models\BankAccount::factory(10)->create();
        \App\Models\Banner::factory(10)->create();
        \App\Models\ProductDetail::factory(20)->create();
        \App\Models\ProductPicture::factory(30)->create();
        \App\Models\ProductDiscount::factory(10)->create();
        \App\Models\UserSelectDiscount::factory(10)->create();
        \App\Models\Order::factory(10)->create();
        \App\Models\OrderDetail::factory(30)->create();
    }
}

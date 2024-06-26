<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSelectDiscount>
 */
class UserSelectDiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'discount_id' => Discount::factory(),
            'user_id' => User::factory(),
            'order_id' => Order::factory(),
        ];
    }
}

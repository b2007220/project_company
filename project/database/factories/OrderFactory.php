<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BankAccount;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total = $this->faker->randomFloat(2, 0, 1000000);
        $ship = $this->faker->randomFloat(2, 0, 1000000);
        $discount = Discount::factory()->create();
        $discountPercentage = $discount->discount;
        $grandTotal = $ship + $total - ($total * $discountPercentage / 100);

        return [
            'user_id' => User::factory(),
            'total' => $total,
            'status' => $this->faker->randomElement(['PENDING', 'DELIVERING', 'DELIVERED', 'CANCELLED', 'UNACCEPTED', 'WAIT']),
            'address' => $this->faker->address,
            'delivery_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'receiver_phone' => $this->faker->phoneNumber,
            'receiver_name' => $this->faker->name,
            'ship' => $ship,
            'bank_id' => BankAccount::factory(),
            'payment_type' => $this->faker->randomElement(['CASH', 'TRANSFER']),
            'grand_total' => $grandTotal,
        ];
    }
}

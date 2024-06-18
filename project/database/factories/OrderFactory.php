<?php

namespace Database\Factories;

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
        return [
            'user_id' => \App\Models\User::factory(),
            'total_price' => $this->faker->randomFloat(2, 0, 1000000),
            'status' => $this->faker->randomElement(['PENDING', 'DELIVERING', 'DELIVERED', 'CANCELLED', 'UNACCEPTED']),
            'address' => $this->faker->address(),
            'delivery_date' => $this->faker->dateTimeBetween('now', '+1 week'),
            'receiver_name' => $this->faker->name(),
            'ship' => $this->faker->randomFloat(2, 0, 1000000),
            'bank_id' => \App\Models\BankAccount::factory(),
            'payment_type' => $this->faker->randomElement(['CASH', 'TRANSFER']),
        ];
    }
}

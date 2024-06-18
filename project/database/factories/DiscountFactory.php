<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'discount' => $this->faker->numberBetween(1, 100),
            'is_active' => true,
            'amount' => $this->faker->numberBetween(1, 100),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 year'),
            'code' => $this->faker->unique()->word(),
            'type' => $this->faker->randomElement(['ORDER', 'PRODUCT']),
        ];
    }
}

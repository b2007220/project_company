<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Discount;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<ProductDiscount>
 */
class ProductDiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'discount_id' => Discount::factory(),
            'is_predefined' => true,
        ];
    }
}

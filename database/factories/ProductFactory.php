<?php

namespace Database\Factories;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productType = ProductType::all()->random();

        return [
            'code'            => $this->faker->unique()->numberBetween(1, 9999),
            'product_type_id' => $productType->id,
            'is_rented'       => false,
            'price'           => $this->faker->boolean() ? $productType->price : $this->faker->randomFloat(2, 1, 1000),
            'size'            => $productType->base_type->isMeasurable() ? $this->faker->randomFloat(2, 1, $productType->max_size) : null,
        ];
    }
}

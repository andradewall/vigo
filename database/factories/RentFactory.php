<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rent>
 */
class RentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'starting_date'       => now(),
            'value'               => $this->faker->randomFloat(2, 100, 1000),
            'shipping_fee'        => $this->faker->randomFloat(2, 100, 1000),
            'payment_method'      => 'Dinheiro',
            'discount_percentage' => $this->faker->numberBetween(0, 100),
            'usage_address'       => $this->faker->address,
        ];
    }
}

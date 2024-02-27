<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductType>
 */
class ProductTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        $name  = $faker->unique(true)->word();

        return [
            'code_prefix' => strtoupper(substr($name, 0, 3)) . $faker->unique(true)->randomNumber(3),
            'name'        => $name,
            'description' => $faker->sentence(),
            'price'       => $faker->randomFloat(2, 1, 1000),
        ];
    }
}

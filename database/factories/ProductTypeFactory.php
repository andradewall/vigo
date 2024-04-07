<?php

namespace Database\Factories;

use App\Enums\BaseTypeEnum;
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
        $faker    = Faker::create();
        $name     = $faker->unique(true)->word();
        $baseType = $faker->randomElement(array_map(fn ($case) => $case->value, BaseTypeEnum::cases()));

        return [
            'code_prefix' => strtoupper(substr($name, 0, 3)) . $faker->unique(true)->randomNumber(3),
            'base_type'   => $baseType,
            'max_size'    => ($baseType === BaseTypeEnum::MEASURABLE) ? $faker->randomFloat(2, 1, 1000) : null,
            'name'        => $name,
            'description' => $faker->sentence(),
            'price'       => $faker->randomFloat(2, 1, 1000),
        ];
    }
}

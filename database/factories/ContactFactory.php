<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'            => $this->faker->name,
            'address'         => $this->faker->address,
            'document_number' => ($this->faker->boolean) ? $this->faker->cpf(false) : $this->faker->cnpj(false),
            'main_phone'      => $this->faker->phoneNumber,
            'secondary_phone' => ($this->faker->boolean) ? $this->faker->phoneNumber : null,
            'email'           => ($this->faker->boolean) ? $this->faker->email : null,
        ];
    }
}

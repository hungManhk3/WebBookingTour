<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName . ' ' .$this->faker->lastName,
            'address' => $this->faker->streetAddress,
            'address2' => $this->faker->buildingNumber,
            'district' => $this->faker->streetName,
            'city' => $this->faker->city,
            'country' => 'Vietnam',
            'zipcode' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'logo' => $this->faker->imageUrl(),
        ];
    }
}

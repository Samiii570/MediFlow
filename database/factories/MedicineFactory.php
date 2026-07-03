<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    protected $model = \App\Models\Medicine::class;

    public function definition(): array
    {
        return [
            'medicine_name' => $this->faker->unique()->words(2, true),
            'stock' => $this->faker->numberBetween(5, 500),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'expiry_date' => $this->faker->dateTimeBetween('-6 months', '+2 years'),
        ];
    }
}

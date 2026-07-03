<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = \App\Models\Patient::class;

    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'patient']);

        return [
            'user_id' => $user->id,
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'dob' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'address' => $this->faker->address(),
        ];
    }
}

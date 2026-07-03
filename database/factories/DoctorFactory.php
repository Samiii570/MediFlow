<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = \App\Models\Doctor::class;

    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'doctor']);
        $specializations = ['Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Dermatology', 'Ophthalmology', 'General Surgery', 'ENT', 'Psychiatry', 'Urology'];
        $qualifications = ['MBBS', 'MBBS, MD', 'MBBS, MS', 'MBBS, DM', 'MBBS, MCh', 'MBBS, DNB'];

        return [
            'user_id' => $user->id,
            'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
            'specialization' => $this->faker->randomElement($specializations),
            'qualification' => $this->faker->randomElement($qualifications),
            'consultation_fee' => $this->faker->randomFloat(2, 200, 2000),
        ];
    }
}

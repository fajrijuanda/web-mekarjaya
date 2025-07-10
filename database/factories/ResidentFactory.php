<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resident>
 */
class ResidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nik' => fake()->unique()->numerify('################'), // 16 digit NIK
            'gender' => fake()->randomElement(['laki-laki', 'perempuan']),
            'birth_date' => fake()->dateTimeBetween('-80 years', '-5 years'),
        ];
    }
}
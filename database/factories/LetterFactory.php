<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Letter>
 */
class LetterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'letter_number' => '500/' . fake()->randomNumber(3) . '/PEM/' . now()->year,
            'title' => 'Surat ' . fake()->sentence(3),
            'type' => fake()->randomElement(['masuk', 'keluar']),
            'letter_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
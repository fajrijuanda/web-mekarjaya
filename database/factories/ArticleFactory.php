<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(6);
        $slug = Str::slug($title) . '-' . fake()->unique()->randomNumber(5);

        // Membuat struktur JSON yang mirip dengan output TipTap
        $content = [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'heading',
                    'attrs' => ['level' => 2],
                    'content' => [
                        ['type' => 'text', 'text' => fake()->sentence(4)],
                    ],
                ],
                [
                    'type' => 'paragraph',
                    'content' => [
                        ['type' => 'text', 'text' => fake()->paragraph(5)],
                    ],
                ],
                [
                    'type' => 'paragraph',
                    'content' => [
                        ['type' => 'text', 'text' => fake()->paragraph(8)],
                    ],
                ],
            ],
        ];

        return [
            'user_id' => User::factory(), // Otomatis membuat user baru atau gunakan user yang ada
            'title' => $title,
            'slug' => $slug,
            'content' => json_encode($content), // Simpan sebagai string JSON
            'status' => fake()->randomElement(['draft', 'published']),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
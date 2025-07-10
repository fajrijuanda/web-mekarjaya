<?php

namespace Database\Seeders;

use App\Models\Letter; // <-- Tambahkan ini
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    public function run(): void
    {
        Letter::factory(20)->create();
    }
}
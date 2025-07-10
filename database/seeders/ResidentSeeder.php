<?php

namespace Database\Seeders;

use App\Models\Resident; // <-- Tambahkan ini
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResidentSeeder extends Seeder
{
    public function run(): void
    {
        Resident::factory(50)->create();
    }
}
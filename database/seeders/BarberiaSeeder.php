<?php

namespace Database\Seeders;

use App\Models\Barberia;
use Illuminate\Database\Seeder;

class BarberiaSeeder extends Seeder
{
    public function run(): void
    {
        Barberia::factory()->count(5)->create();
    }
}

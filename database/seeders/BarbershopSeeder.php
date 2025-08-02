<?php

namespace Database\Seeders;

use App\Domain\Barbershop\Entities\Barbershop;
use Illuminate\Database\Seeder;

class BarbershopSeeder extends Seeder
{
    public function run(): void
    {
        Barbershop::factory()->count(5)->create();
    }
}

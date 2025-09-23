<?php

namespace Database\Seeders;

use App\Domain\Barbershop\Entities\Barbershop;
use Illuminate\Database\Seeder;

class BarbershopSeeder extends Seeder
{
    public function run(): void
    {
        if (Barbershop::query()->exists()) {
            return;
        }

        $faker = fake();

        foreach (range(1, 12) as $index) {
            Barbershop::query()->create([
                'name' => $faker->unique()->company(),
                'address' => $faker->address(),
            ]);
        }

        $faker->unique(true);
    }
}

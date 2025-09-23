<?php

namespace Database\Seeders;

use App\Domain\Service\Entities\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        if (Service::query()->exists()) {
            return;
        }

        $faker = fake();

        foreach (range(1, 20) as $index) {
            Service::query()->create([
                'name' => ucfirst($faker->unique()->words(2, true)),
                'cost' => $faker->randomFloat(2, 5, 150),
            ]);
        }

        $faker->unique(true);
    }
}

<?php

namespace Database\Seeders;

use App\Domain\Client\Entities\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        if (Client::query()->exists()) {
            return;
        }

        $faker = fake();

        foreach (range(1, 30) as $index) {
            Client::query()->create([
                'name' => $faker->name(),
                'phone' => $faker->unique()->e164PhoneNumber(),
                'email' => $faker->unique()->safeEmail(),
                'birthday' => $faker->dateTimeBetween('-65 years', '-18 years')->format('Y-m-d'),
                'occupation' => $faker->jobTitle(),
            ]);
        }

        $faker->unique(true);
    }
}

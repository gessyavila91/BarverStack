<?php

namespace Database\Seeders;

use App\Domain\Client\Entities\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::factory()->count(10)->create();
    }
}

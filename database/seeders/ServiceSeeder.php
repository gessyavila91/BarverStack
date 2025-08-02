<?php

namespace Database\Seeders;

use App\Domain\Service\Entities\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::factory()->count(8)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Domain\Client\Entities\Client;
use App\Domain\Service\Entities\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        if (Appointment::query()->exists()) {
            return;
        }

        $clients = Client::all();
        $barbers = User::query()
            ->whereHas('roles', fn (Builder $query) => $query->where('slug', 'barber'))
            ->get();
        $barbershops = Barbershop::all();
        $services = Service::all();

        if ($clients->isEmpty() || $barbers->isEmpty() || $barbershops->isEmpty() || $services->isEmpty()) {
            return;
        }

        $faker = fake();

        foreach ($clients as $client) {
            $appointmentsToCreate = $faker->numberBetween(1, 2);

            for ($i = 0; $i < $appointmentsToCreate; $i++) {
                $start = Carbon::instance($faker->dateTimeBetween('+1 day', '+1 month'));
                $end = (clone $start)->addMinutes($faker->numberBetween(30, 120));

                Appointment::factory()
                    ->for($client, 'client')
                    ->for($barbers->random(), 'barber')
                    ->for($barbershops->random(), 'barbershop')
                    ->for($services->random(), 'service')
                    ->create([
                        'starts_at' => $start,
                        'ends_at' => $end,
                        'notes' => $faker->optional()->sentence(),
                    ]);
            }
        }
    }
}

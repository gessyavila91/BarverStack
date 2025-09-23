<?php

namespace Database\Factories\Domain\Appointment\Entities;

use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Domain\Client\Entities\Client;
use App\Domain\Service\Entities\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $start = Carbon::instance($this->faker->dateTimeBetween('+1 day', '+1 month'));
        $end = (clone $start)->addMinutes($this->faker->numberBetween(30, 120));

        return [
            'client_id' => Client::factory(),
            'barber_id' => User::factory(),
            'barbershop_id' => Barbershop::factory(),
            'service_id' => Service::factory(),
            'starts_at' => $start,
            'ends_at' => $end,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}

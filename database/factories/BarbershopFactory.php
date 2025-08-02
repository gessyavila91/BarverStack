<?php

namespace Database\Factories;

use App\Models\Barbershop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Barbershop>
 */
class BarbershopFactory extends Factory
{
    protected $model = Barbershop::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
        ];
    }
}

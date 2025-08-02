<?php

namespace Database\Factories;

use App\Domain\Client\Entities\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'birthday' => $this->faker->date(),
            'occupation' => $this->faker->jobTitle(),
        ];
    }
}

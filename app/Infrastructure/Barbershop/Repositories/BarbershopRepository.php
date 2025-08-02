<?php

namespace App\Infrastructure\Barbershop\Repositories;

use App\Application\Barbershop\DTOs\BarbershopDTO;
use App\Domain\Barbershop\Entities\Barbershop;

class BarbershopRepository
{
    public function all(): iterable
    {
        return Barbershop::all();
    }

    public function create(BarbershopDTO $data): Barbershop
    {
        return Barbershop::create([
            'name' => $data->name,
            'address' => $data->address,
        ]);
    }

    public function update(Barbershop $barbershop, BarbershopDTO $data): Barbershop
    {
        $barbershop->update([
            'name' => $data->name,
            'address' => $data->address,
        ]);

        return $barbershop;
    }

    public function delete(Barbershop $barbershop): void
    {
        $barbershop->delete();
    }
}

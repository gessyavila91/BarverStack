<?php

namespace App\Domain\Barbershop\Contracts;

use App\Application\Barbershop\DTOs\BarbershopDTO;
use App\Domain\Barbershop\Entities\Barbershop;

interface BarbershopServiceInterface
{
    /** @return iterable<Barbershop> */
    public function all(): iterable;

    public function create(BarbershopDTO $data): Barbershop;

    public function update(Barbershop $barbershop, BarbershopDTO $data): Barbershop;

    public function delete(Barbershop $barbershop): void;
}

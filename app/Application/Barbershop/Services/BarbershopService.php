<?php

namespace App\Application\Barbershop\Services;

use App\Application\Barbershop\DTOs\BarbershopDTO;
use App\Domain\Barbershop\Contracts\BarbershopServiceInterface;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Infrastructure\Barbershop\Repositories\BarbershopRepository;

class BarbershopService implements BarbershopServiceInterface
{
    public function __construct(private BarbershopRepository $repository)
    {
    }

    public function all(): iterable
    {
        return $this->repository->all();
    }

    public function create(BarbershopDTO $data): Barbershop
    {
        return $this->repository->create($data);
    }

    public function update(Barbershop $barbershop, BarbershopDTO $data): Barbershop
    {
        return $this->repository->update($barbershop, $data);
    }

    public function delete(Barbershop $barbershop): void
    {
        $this->repository->delete($barbershop);
    }
}

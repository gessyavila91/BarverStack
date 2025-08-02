<?php

namespace App\Application\Service\Services;

use App\Application\Service\DTOs\ServiceDTO;
use App\Domain\Service\Contracts\ServiceServiceInterface;
use App\Domain\Service\Entities\Service;
use App\Infrastructure\Service\Repositories\ServiceRepository;

class ServiceService implements ServiceServiceInterface
{
    public function __construct(private ServiceRepository $repository)
    {
    }

    public function all(): iterable
    {
        return $this->repository->all();
    }

    public function create(ServiceDTO $data): Service
    {
        return $this->repository->create($data);
    }

    public function update(Service $service, ServiceDTO $data): Service
    {
        return $this->repository->update($service, $data);
    }

    public function delete(Service $service): void
    {
        $this->repository->delete($service);
    }
}

<?php

namespace App\Infrastructure\Service\Repositories;

use App\Application\Service\DTOs\ServiceDTO;
use App\Domain\Service\Entities\Service;

class ServiceRepository
{
    public function all(): iterable
    {
        return Service::all();
    }

    public function create(ServiceDTO $data): Service
    {
        return Service::create([
            'name' => $data->name,
            'cost' => $data->cost,
        ]);
    }

    public function update(Service $service, ServiceDTO $data): Service
    {
        $service->update([
            'name' => $data->name,
            'cost' => $data->cost,
        ]);

        return $service;
    }

    public function delete(Service $service): void
    {
        $service->delete();
    }
}

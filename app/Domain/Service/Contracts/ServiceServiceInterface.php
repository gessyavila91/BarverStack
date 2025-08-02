<?php

namespace App\Domain\Service\Contracts;

use App\Application\Service\DTOs\ServiceDTO;
use App\Domain\Service\Entities\Service;

interface ServiceServiceInterface
{
    /** @return iterable<Service> */
    public function all(): iterable;

    public function create(ServiceDTO $data): Service;

    public function update(Service $service, ServiceDTO $data): Service;

    public function delete(Service $service): void;
}

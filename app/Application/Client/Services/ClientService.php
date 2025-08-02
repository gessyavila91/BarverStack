<?php

namespace App\Application\Client\Services;

use App\Application\Client\DTOs\ClientDTO;
use App\Domain\Client\Contracts\ClientServiceInterface;
use App\Domain\Client\Entities\Client;
use App\Infrastructure\Client\Repositories\ClientRepository;

/**
 * Service implementation for Client domain operations.
 */
class ClientService implements ClientServiceInterface
{
    public function __construct(private ClientRepository $repository)
    {
    }

    public function all(): iterable
    {
        return $this->repository->all();
    }

    public function create(ClientDTO $data): Client
    {
        return $this->repository->create($data);
    }

    public function update(Client $client, ClientDTO $data): Client
    {
        return $this->repository->update($client, $data);
    }

    public function delete(Client $client): void
    {
        $this->repository->delete($client);
    }
}

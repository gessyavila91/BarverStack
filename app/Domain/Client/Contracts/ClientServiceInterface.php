<?php

namespace App\Domain\Client\Contracts;

use App\Application\Client\DTOs\ClientDTO;
use App\Domain\Client\Entities\Client;

interface ClientServiceInterface
{
    /**
     * Retrieve all clients.
     *
     * @return iterable<Client>
     */
    public function all(): iterable;

    /**
     * Create a new client.
     */
    public function create(ClientDTO $data): Client;

    /**
     * Update an existing client.
     */
    public function update(Client $client, ClientDTO $data): Client;

    /**
     * Remove the given client.
     */
    public function delete(Client $client): void;
}

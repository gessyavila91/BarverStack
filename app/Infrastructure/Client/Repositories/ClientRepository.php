<?php

namespace App\Infrastructure\Client\Repositories;

use App\Application\Client\DTOs\ClientDTO;
use App\Domain\Client\Entities\Client;

/**
 * Repository layer for Client persistence.
 */
class ClientRepository
{
    public function all(): iterable
    {
        return Client::all();
    }

    public function create(ClientDTO $data): Client
    {
        return Client::create([
            'name' => $data->name,
            'phone' => $data->phone,
            'email' => $data->email,
            'birthday' => $data->birthday,
            'occupation' => $data->occupation,
        ]);
    }

    public function update(Client $client, ClientDTO $data): Client
    {
        $client->update([
            'name' => $data->name,
            'phone' => $data->phone,
            'email' => $data->email,
            'birthday' => $data->birthday,
            'occupation' => $data->occupation,
        ]);

        return $client;
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}

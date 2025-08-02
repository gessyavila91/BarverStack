<?php

namespace App\Http\Controllers;

use App\Application\Client\DTOs\ClientDTO;
use App\Domain\Client\Contracts\ClientServiceInterface;
use App\Domain\Client\Entities\Client;
use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;

class ClientController extends Controller
{
    public function __construct(private ClientServiceInterface $service)
    {
    }

    public function index()
    {
        return response()->json($this->service->all());
    }

    public function store(CreateClientRequest $request)
    {
        $client = $this->service->create(ClientDTO::fromArray($request->validated()));

        return response()->json($client, 201);
    }

    public function show(Client $client)
    {
        return response()->json($client);
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client = $this->service->update($client, ClientDTO::fromArray($request->validated()));

        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $this->service->delete($client);

        return response()->json(null, 204);
    }
}

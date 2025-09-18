<?php

namespace Tests\Application\Client\Services;

use App\Application\Client\DTOs\ClientDTO;
use App\Application\Client\Services\ClientService;
use App\Domain\Client\Entities\Client;
use App\Infrastructure\Client\Repositories\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientServiceTest extends TestCase
{
    use RefreshDatabase;

    private ClientService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ClientService(new ClientRepository());
    }

    public function test_can_create_client(): void
    {
        $dto = new ClientDTO('John', '123456', 'john@example.com', '1990-01-01', 'Barber');
        $client = $this->service->create($dto);

        $this->assertDatabaseHas('clients', ['id' => $client->id, 'email' => 'john@example.com']);
    }

    public function test_can_update_client(): void
    {
        $client = Client::factory()->create(['name' => 'Old']);
        $dto = new ClientDTO('New', $client->phone, $client->email, $client->birthday, $client->occupation);
        $updated = $this->service->update($client, $dto);

        $this->assertEquals('New', $updated->name);
    }

    public function test_can_delete_client(): void
    {
        $client = Client::factory()->create();
        $this->service->delete($client);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}

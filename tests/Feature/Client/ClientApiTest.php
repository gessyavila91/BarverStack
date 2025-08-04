<?php

namespace Tests\Feature\Client;

use App\Domain\Client\Entities\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_client(): void
    {
        $payload = [
            'name' => 'John',
            'phone' => '123456789',
            'email' => 'john@example.com',
            'birthday' => '1990-01-01',
            'occupation' => 'Barber',
        ];

        $response = $this->postJson('/api/clients', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'John']);

        $this->assertDatabaseHas('clients', ['name' => 'John']);
    }

    public function test_can_list_clients(): void
    {
        Client::factory()->create(['name' => 'Mary']);

        $response = $this->getJson('/api/clients');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Mary']);
    }

    public function test_can_show_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->getJson('/api/clients/'.$client->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $client->id]);
    }

    public function test_can_update_client(): void
    {
        $client = Client::factory()->create();
        $payload = ['name' => 'Updated'];

        $response = $this->putJson('/api/clients/'.$client->id, $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated']);

        $this->assertDatabaseHas('clients', ['id' => $client->id, 'name' => 'Updated']);
    }

    public function test_can_delete_client(): void
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson('/api/clients/'.$client->id);

        $response->assertStatus(204);

        $this->assertSoftDeleted('clients', ['id' => $client->id]);
    }

    public function test_validation_error_on_create_client(): void
    {
        $response = $this->postJson('/api/clients', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }
}


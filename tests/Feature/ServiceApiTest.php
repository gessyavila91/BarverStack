<?php

namespace Tests\Feature;

use App\Domain\Service\Entities\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_service(): void
    {
        $payload = [
            'name' => 'Basic Cut',
            'cost' => 15.5,
        ];

        $response = $this->postJson('/api/services', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Basic Cut']);

        $this->assertDatabaseHas('services', ['name' => 'Basic Cut']);
    }

    public function test_can_list_services(): void
    {
        Service::factory()->create(['name' => 'Shave']);

        $response = $this->getJson('/api/services');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Shave']);
    }

    public function test_can_show_service(): void
    {
        $service = Service::factory()->create();

        $response = $this->getJson('/api/services/'.$service->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $service->id]);
    }

    public function test_can_update_service(): void
    {
        $service = Service::factory()->create();
        $payload = ['name' => 'Updated Service'];

        $response = $this->putJson('/api/services/'.$service->id, $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Service']);

        $this->assertDatabaseHas('services', ['id' => $service->id, 'name' => 'Updated Service']);
    }

    public function test_can_delete_service(): void
    {
        $service = Service::factory()->create();

        $response = $this->deleteJson('/api/services/'.$service->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}


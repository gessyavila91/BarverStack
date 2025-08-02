<?php

namespace Tests\Feature;

use App\Domain\Barbershop\Entities\Barbershop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarbershopApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_barbershop(): void
    {
        $payload = [
            'name' => 'Barber Shop',
            'address' => '123 Main St',
        ];

        $response = $this->postJson('/api/barbershops', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Barber Shop']);

        $this->assertDatabaseHas('barbershops', ['name' => 'Barber Shop']);
    }

    public function test_can_list_barbershops(): void
    {
        Barbershop::factory()->create(['name' => 'Local One']);

        $response = $this->getJson('/api/barbershops');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Local One']);
    }

    public function test_can_show_barbershop(): void
    {
        $barbershop = Barbershop::factory()->create();

        $response = $this->getJson('/api/barbershops/'.$barbershop->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $barbershop->id]);
    }

    public function test_can_update_barbershop(): void
    {
        $barbershop = Barbershop::factory()->create();
        $payload = ['name' => 'Updated Shop'];

        $response = $this->putJson('/api/barbershops/'.$barbershop->id, $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Shop']);

        $this->assertDatabaseHas('barbershops', ['id' => $barbershop->id, 'name' => 'Updated Shop']);
    }

    public function test_can_delete_barbershop(): void
    {
        $barbershop = Barbershop::factory()->create();

        $response = $this->deleteJson('/api/barbershops/'.$barbershop->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('barbershops', ['id' => $barbershop->id]);
    }
}


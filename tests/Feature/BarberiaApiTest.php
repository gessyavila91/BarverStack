<?php

namespace Tests\Feature;

use App\Models\Barberia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarberiaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_barberia(): void
    {
        $payload = [
            'nombre' => 'Barber Shop',
            'direccion' => '123 Main St',
        ];

        $response = $this->postJson('/api/barberias', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['nombre' => 'Barber Shop']);

        $this->assertDatabaseHas('barberias', ['nombre' => 'Barber Shop']);
    }

    public function test_can_list_barberias(): void
    {
        Barberia::factory()->create(['nombre' => 'Local Uno']);

        $response = $this->getJson('/api/barberias');

        $response->assertStatus(200)
            ->assertJsonFragment(['nombre' => 'Local Uno']);
    }
}

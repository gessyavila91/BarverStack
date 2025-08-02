<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_cliente(): void
    {
        $payload = [
            'nombre' => 'Juan',
            'telefono' => '123456789',
            'correo' => 'juan@example.com',
            'fecha_de_cumpleanios' => '1990-01-01',
            'ocupacion' => 'Barbero',
        ];

        $response = $this->postJson('/api/clientes', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['nombre' => 'Juan']);

        $this->assertDatabaseHas('clientes', ['nombre' => 'Juan']);
    }

    public function test_can_list_clientes(): void
    {
        Cliente::factory()->create(['nombre' => 'Maria']);

        $response = $this->getJson('/api/clientes');

        $response->assertStatus(200)
            ->assertJsonFragment(['nombre' => 'Maria']);
    }
}

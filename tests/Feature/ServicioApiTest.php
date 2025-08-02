<?php

namespace Tests\Feature;

use App\Models\Servicio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicioApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_servicio(): void
    {
        $payload = [
            'nombre' => 'Corte Basico',
            'costo' => 15.5,
        ];

        $response = $this->postJson('/api/servicios', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['nombre' => 'Corte Basico']);

        $this->assertDatabaseHas('servicios', ['nombre' => 'Corte Basico']);
    }

    public function test_can_list_servicios(): void
    {
        Servicio::factory()->create(['nombre' => 'Afeitado']);

        $response = $this->getJson('/api/servicios');

        $response->assertStatus(200)
            ->assertJsonFragment(['nombre' => 'Afeitado']);
    }
}

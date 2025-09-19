<?php

namespace Tests\Feature\Appointment;

use App\Domain\Appointment\Entities\Appointment;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Domain\Client\Entities\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchid\Platform\Models\Role;
use Tests\TestCase;

class AppointmentApiTest extends TestCase
{
    use RefreshDatabase;

    private Role $barberRole;

    protected function setUp(): void
    {
        parent::setUp();

        $this->barberRole = Role::query()->create([
            'name' => 'Barber',
            'slug' => 'barber',
            'permissions' => ['platform.appointments' => true],
        ]);
    }

    private function createBarber(): User
    {
        $barber = User::factory()->create();
        $barber->roles()->sync([$this->barberRole->getKey()]);

        return $barber;
    }

    public function test_can_schedule_appointment(): void
    {
        $client = Client::factory()->create();
        $barbershop = Barbershop::factory()->create();
        $barber = $this->createBarber();

        $payload = [
            'client_id' => $client->id,
            'barber_id' => $barber->id,
            'barbershop_id' => $barbershop->id,
            'starts_at' => now()->addDay()->toISOString(),
            'ends_at' => now()->addDay()->addHour()->toISOString(),
            'notes' => 'Initial consultation',
        ];

        $response = $this->postJson('/api/appointments', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['notes' => 'Initial consultation']);

        $this->assertDatabaseHas('appointments', [
            'client_id' => $client->id,
            'barber_id' => $barber->id,
        ]);
    }

    public function test_can_list_appointments(): void
    {
        $client = Client::factory()->create();
        $barbershop = Barbershop::factory()->create();
        $barber = $this->createBarber();

        Appointment::factory()
            ->for($client, 'client')
            ->for($barber, 'barber')
            ->for($barbershop, 'barbershop')
            ->create(['notes' => 'Follow-up']);

        $response = $this->getJson('/api/appointments');

        $response->assertStatus(200)
            ->assertJsonFragment(['notes' => 'Follow-up']);
    }

    public function test_can_show_appointment(): void
    {
        $client = Client::factory()->create();
        $barbershop = Barbershop::factory()->create();
        $barber = $this->createBarber();

        $appointment = Appointment::factory()
            ->for($client, 'client')
            ->for($barber, 'barber')
            ->for($barbershop, 'barbershop')
            ->create();

        $response = $this->getJson('/api/appointments/'.$appointment->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $appointment->id]);
    }

    public function test_can_update_appointment(): void
    {
        $client = Client::factory()->create();
        $barbershop = Barbershop::factory()->create();
        $barber = $this->createBarber();

        $appointment = Appointment::factory()
            ->for($client, 'client')
            ->for($barber, 'barber')
            ->for($barbershop, 'barbershop')
            ->create();

        $payload = [
            'notes' => 'Updated note',
        ];

        $response = $this->putJson('/api/appointments/'.$appointment->id, $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['notes' => 'Updated note']);

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'notes' => 'Updated note',
        ]);
    }

    public function test_can_delete_appointment(): void
    {
        $client = Client::factory()->create();
        $barbershop = Barbershop::factory()->create();
        $barber = $this->createBarber();

        $appointment = Appointment::factory()
            ->for($client, 'client')
            ->for($barber, 'barber')
            ->for($barbershop, 'barbershop')
            ->create();

        $response = $this->deleteJson('/api/appointments/'.$appointment->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }

    public function test_validation_errors_when_data_missing(): void
    {
        $response = $this->postJson('/api/appointments', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['client_id', 'barber_id', 'barbershop_id', 'starts_at', 'ends_at']);
    }
}

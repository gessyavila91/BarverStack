<?php

namespace Tests\Application\Barbershop\Services;

use App\Application\Barbershop\DTOs\BarbershopDTO;
use App\Application\Barbershop\Services\BarbershopService;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Infrastructure\Barbershop\Repositories\BarbershopRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarbershopServiceTest extends TestCase
{
    use RefreshDatabase;

    private BarbershopService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BarbershopService(new BarbershopRepository());
    }

    public function test_can_create_barbershop(): void
    {
        $dto = new BarbershopDTO('Shop', 'Street 1');
        $shop = $this->service->create($dto);

        $this->assertDatabaseHas('barbershops', ['id' => $shop->id, 'name' => 'Shop']);
    }

    public function test_can_update_barbershop(): void
    {
        $shop = Barbershop::factory()->create(['name' => 'Old']);
        $dto = new BarbershopDTO('New', $shop->address);
        $updated = $this->service->update($shop, $dto);

        $this->assertEquals('New', $updated->name);
    }

    public function test_can_delete_barbershop(): void
    {
        $shop = Barbershop::factory()->create();
        $this->service->delete($shop);

        $this->assertDatabaseMissing('barbershops', ['id' => $shop->id]);
    }
}

<?php

namespace Tests\Application\Service\Services;

use App\Application\Service\DTOs\ServiceDTO;
use App\Application\Service\Services\ServiceService;
use App\Domain\Service\Entities\Service;
use App\Infrastructure\Service\Repositories\ServiceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceServiceTest extends TestCase
{
    use RefreshDatabase;

    private ServiceService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ServiceService(new ServiceRepository());
    }

    public function test_can_create_service(): void
    {
        $dto = new ServiceDTO('Cut', 10);
        $service = $this->service->create($dto);

        $this->assertDatabaseHas('services', ['id' => $service->id, 'name' => 'Cut']);
    }

    public function test_can_update_service(): void
    {
        $service = Service::factory()->create(['name' => 'Old']);
        $dto = new ServiceDTO('New', $service->cost);
        $updated = $this->service->update($service, $dto);

        $this->assertEquals('New', $updated->name);
    }

    public function test_can_delete_service(): void
    {
        $service = Service::factory()->create();
        $this->service->delete($service);

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}

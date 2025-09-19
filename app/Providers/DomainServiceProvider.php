<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Appointment\Contracts\AppointmentServiceInterface;
use App\Application\Appointment\Services\AppointmentService;
use App\Domain\Client\Contracts\ClientServiceInterface;
use App\Application\Client\Services\ClientService;
use App\Domain\Barbershop\Contracts\BarbershopServiceInterface;
use App\Application\Barbershop\Services\BarbershopService;
use App\Domain\Service\Contracts\ServiceServiceInterface;
use App\Application\Service\Services\ServiceService;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AppointmentServiceInterface::class, AppointmentService::class);
        $this->app->bind(ClientServiceInterface::class, ClientService::class);
        $this->app->bind(BarbershopServiceInterface::class, BarbershopService::class);
        $this->app->bind(ServiceServiceInterface::class, ServiceService::class);
    }
}

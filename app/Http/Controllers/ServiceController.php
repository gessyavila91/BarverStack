<?php

namespace App\Http\Controllers;

use App\Application\Service\DTOs\ServiceDTO;
use App\Domain\Service\Contracts\ServiceServiceInterface;
use App\Domain\Service\Entities\Service;
use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;

class ServiceController extends Controller
{
    public function __construct(private ServiceServiceInterface $service)
    {
    }

    public function index()
    {
        return response()->json($this->service->all());
    }

    public function store(CreateServiceRequest $request)
    {
        $service = $this->service->create(ServiceDTO::fromArray($request->validated()));

        return response()->json($service, 201);
    }

    public function show(Service $service)
    {
        return response()->json($service);
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service = $this->service->update($service, ServiceDTO::fromArray($request->validated()));

        return response()->json($service);
    }

    public function destroy(Service $service)
    {
        $this->service->delete($service);

        return response()->json(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Application\Barbershop\DTOs\BarbershopDTO;
use App\Domain\Barbershop\Contracts\BarbershopServiceInterface;
use App\Domain\Barbershop\Entities\Barbershop;
use App\Http\Requests\Barbershop\CreateBarbershopRequest;
use App\Http\Requests\Barbershop\UpdateBarbershopRequest;

class BarbershopController extends Controller
{
    public function __construct(private BarbershopServiceInterface $service)
    {
    }

    public function index()
    {
        return response()->json($this->service->all());
    }

    public function store(CreateBarbershopRequest $request)
    {
        $barbershop = $this->service->create(BarbershopDTO::fromArray($request->validated()));

        return response()->json($barbershop, 201);
    }

    public function show(Barbershop $barbershop)
    {
        return response()->json($barbershop);
    }

    public function update(UpdateBarbershopRequest $request, Barbershop $barbershop)
    {
        $barbershop = $this->service->update($barbershop, BarbershopDTO::fromArray($request->validated()));

        return response()->json($barbershop);
    }

    public function destroy(Barbershop $barbershop)
    {
        $this->service->delete($barbershop);

        return response()->json(null, 204);
    }
}

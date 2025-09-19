<?php

namespace App\Http\Controllers;

use App\Application\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Contracts\AppointmentServiceInterface;
use App\Domain\Appointment\Entities\Appointment;
use App\Http\Requests\Appointment\CreateAppointmentRequest;
use App\Http\Requests\Appointment\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    public function __construct(private AppointmentServiceInterface $service)
    {
    }

    public function index()
    {
        return response()->json($this->service->all());
    }

    public function store(CreateAppointmentRequest $request)
    {
        $appointment = $this->service->create(AppointmentDTO::fromArray($request->validated()));

        return response()->json($appointment, 201);
    }

    public function show(Appointment $appointment)
    {
        return response()->json($appointment->load(['client', 'barber', 'barbershop', 'service']));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment = $this->service->update(
            $appointment,
            AppointmentDTO::fromArray(array_merge($appointment->only([
                'client_id',
                'barber_id',
                'barbershop_id',
                'service_id',
                'starts_at',
                'ends_at',
                'notes',
            ]), $request->validated()))
        );

        return response()->json($appointment);
    }

    public function destroy(Appointment $appointment)
    {
        $this->service->delete($appointment);

        return response()->json(null, 204);
    }
}

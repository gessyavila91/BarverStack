<?php

namespace App\Infrastructure\Appointment\Repositories;

use App\Application\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Entities\Appointment;

class AppointmentRepository
{
    /** @return iterable<Appointment> */
    public function all(): iterable
    {
        return Appointment::with(['client', 'barber', 'barbershop'])->get();
    }

    public function create(AppointmentDTO $data): Appointment
    {
        $appointment = Appointment::create([
            'client_id' => $data->clientId,
            'barber_id' => $data->barberId,
            'barbershop_id' => $data->barbershopId,
            'starts_at' => $data->startsAt,
            'ends_at' => $data->endsAt,
            'notes' => $data->notes,
        ]);

        return $appointment->load(['client', 'barber', 'barbershop']);
    }

    public function update(Appointment $appointment, AppointmentDTO $data): Appointment
    {
        $appointment->update([
            'client_id' => $data->clientId,
            'barber_id' => $data->barberId,
            'barbershop_id' => $data->barbershopId,
            'starts_at' => $data->startsAt,
            'ends_at' => $data->endsAt,
            'notes' => $data->notes,
        ]);

        return $appointment->load(['client', 'barber', 'barbershop']);
    }

    public function delete(Appointment $appointment): void
    {
        $appointment->delete();
    }
}

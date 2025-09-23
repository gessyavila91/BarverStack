<?php

namespace App\Application\Appointment\Services;

use App\Application\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Contracts\AppointmentServiceInterface;
use App\Domain\Appointment\Entities\Appointment;
use App\Infrastructure\Appointment\Repositories\AppointmentRepository;

class AppointmentService implements AppointmentServiceInterface
{
    public function __construct(private AppointmentRepository $repository)
    {
    }

    public function all(): iterable
    {
        return $this->repository->all();
    }

    public function create(AppointmentDTO $data): Appointment
    {
        return $this->repository->create($data);
    }

    public function update(Appointment $appointment, AppointmentDTO $data): Appointment
    {
        return $this->repository->update($appointment, $data);
    }

    public function delete(Appointment $appointment): void
    {
        $this->repository->delete($appointment);
    }
}

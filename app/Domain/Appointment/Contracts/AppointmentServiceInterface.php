<?php

namespace App\Domain\Appointment\Contracts;

use App\Application\Appointment\DTOs\AppointmentDTO;
use App\Domain\Appointment\Entities\Appointment;

interface AppointmentServiceInterface
{
    /** @return iterable<Appointment> */
    public function all(): iterable;

    public function create(AppointmentDTO $data): Appointment;

    public function update(Appointment $appointment, AppointmentDTO $data): Appointment;

    public function delete(Appointment $appointment): void;
}

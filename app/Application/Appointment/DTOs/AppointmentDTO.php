<?php

namespace App\Application\Appointment\DTOs;

use DateTimeInterface;

class AppointmentDTO
{
    public function __construct(
        public readonly int $clientId,
        public readonly int $barberId,
        public readonly int $barbershopId,
        public readonly DateTimeInterface|string $startsAt,
        public readonly DateTimeInterface|string $endsAt,
        public readonly ?string $notes,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['client_id'],
            $data['barber_id'],
            $data['barbershop_id'],
            $data['starts_at'],
            $data['ends_at'],
            $data['notes'] ?? null,
        );
    }
}

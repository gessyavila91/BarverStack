<?php

namespace App\Application\Barbershop\DTOs;

/**
 * DTO for barbershop data.
 */
class BarbershopDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $address,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['address'],
        );
    }
}

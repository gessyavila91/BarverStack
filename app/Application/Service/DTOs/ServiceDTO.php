<?php

namespace App\Application\Service\DTOs;

/**
 * DTO for service data.
 */
class ServiceDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $cost,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            (float) $data['cost'],
        );
    }
}

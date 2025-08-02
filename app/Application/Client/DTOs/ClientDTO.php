<?php

namespace App\Application\Client\DTOs;

/**
 * Data Transfer Object for Client data.
 */
class ClientDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $phone,
        public readonly ?string $email,
        public readonly ?string $birthday,
        public readonly ?string $occupation,
    ) {
    }

    /**
     * Create a DTO instance from an array of validated data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['phone'] ?? null,
            $data['email'] ?? null,
            $data['birthday'] ?? null,
            $data['occupation'] ?? null,
        );
    }
}

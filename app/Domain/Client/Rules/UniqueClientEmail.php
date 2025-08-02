<?php

namespace App\Domain\Client\Rules;

use App\Domain\Client\Entities\Client;
use Illuminate\Contracts\Validation\Rule;

/**
 * Ensure the provided email address is unique among clients.
 */
class UniqueClientEmail implements Rule
{
    public function __construct(private ?int $ignoreId = null)
    {
    }

    public function passes($attribute, $value): bool
    {
        return !Client::where('email', $value)
            ->when($this->ignoreId, fn($q) => $q->where('id', '!=', $this->ignoreId))
            ->exists();
    }

    public function message(): string
    {
        return 'The email has already been taken.';
    }
}

<?php

namespace App\Domain\Barbershop\Rules;

use App\Domain\Barbershop\Entities\Barbershop;
use Illuminate\Contracts\Validation\Rule;

/**
 * Validate that the barbershop name is unique.
 */
class UniqueBarbershopName implements Rule
{
    public function __construct(private ?int $ignoreId = null)
    {
    }

    public function passes($attribute, $value): bool
    {
        return !Barbershop::where('name', $value)
            ->when($this->ignoreId, fn($q) => $q->where('id', '!=', $this->ignoreId))
            ->exists();
    }

    public function message(): string
    {
        return 'The barbershop name has already been taken.';
    }
}

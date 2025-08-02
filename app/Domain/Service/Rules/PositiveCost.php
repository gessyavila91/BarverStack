<?php

namespace App\Domain\Service\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Ensure the service cost is a positive number.
 */
class PositiveCost implements Rule
{
    public function passes($attribute, $value): bool
    {
        return is_numeric($value) && (float) $value >= 0;
    }

    public function message(): string
    {
        return 'The :attribute must be a positive amount.';
    }
}

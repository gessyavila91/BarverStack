<?php

namespace App\Domain\Client\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Ensure a given date is not in the future.
 */
class PastDate implements Rule
{
    public function passes($attribute, $value): bool
    {
        return strtotime($value) <= time();
    }

    public function message(): string
    {
        return 'The :attribute must be a valid past date.';
    }
}

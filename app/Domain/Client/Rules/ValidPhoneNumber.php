<?php

namespace App\Domain\Client\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Validate a phone number using a simple regex pattern.
 */
class ValidPhoneNumber implements Rule
{
    public function passes($attribute, $value): bool
    {
        return (bool) preg_match('/^[0-9+\-\s]{7,15}$/', $value);
    }

    public function message(): string
    {
        return 'The :attribute format is invalid.';
    }
}

<?php

namespace App\Domain\Appointment\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

class BarberRole implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isBarber = User::query()
            ->whereKey($value)
            ->whereHas('roles', fn (Builder $query) => $query->where('slug', 'barber'))
            ->exists();

        if (! $isBarber) {
            $fail('The selected barber is invalid.');
        }
    }
}

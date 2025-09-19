<?php

namespace App\Http\Requests\Appointment;

use App\Domain\Appointment\Rules\BarberRole;
use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'barber_id' => ['required', 'exists:users,id', new BarberRole()],
            'barbershop_id' => ['required', 'exists:barbershops,id'],
            'starts_at' => ['required', 'date', 'after_or_equal:now'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

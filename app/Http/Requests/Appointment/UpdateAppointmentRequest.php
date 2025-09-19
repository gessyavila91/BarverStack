<?php

namespace App\Http\Requests\Appointment;

use App\Domain\Appointment\Rules\BarberRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => ['sometimes', 'required', 'exists:clients,id'],
            'barber_id' => ['sometimes', 'required', 'exists:users,id', new BarberRole()],
            'barbershop_id' => ['sometimes', 'required', 'exists:barbershops,id'],
            'starts_at' => ['sometimes', 'required_with:ends_at', 'date', 'after_or_equal:now'],
            'ends_at' => ['sometimes', 'required_with:starts_at', 'date', 'after:starts_at'],
            'notes' => ['sometimes', 'nullable', 'string'],
        ];
    }
}

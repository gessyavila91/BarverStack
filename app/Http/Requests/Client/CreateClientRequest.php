<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use App\Domain\Client\Rules\UniqueClientEmail;
use App\Domain\Client\Rules\ValidPhoneNumber;
use App\Domain\Client\Rules\PastDate;

class CreateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string', new ValidPhoneNumber()],
            'email' => ['nullable', 'email', new UniqueClientEmail()],
            'birthday' => ['nullable', 'date', new PastDate()],
            'occupation' => ['nullable', 'string'],
        ];
    }
}

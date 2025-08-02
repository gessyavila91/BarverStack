<?php

namespace App\Http\Requests\Barbershop;

use Illuminate\Foundation\Http\FormRequest;
use App\Domain\Barbershop\Rules\UniqueBarbershopName;

class CreateBarbershopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', new UniqueBarbershopName()],
            'address' => ['required', 'string'],
        ];
    }
}

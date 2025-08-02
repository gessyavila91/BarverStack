<?php

namespace App\Http\Requests\Barbershop;

use Illuminate\Foundation\Http\FormRequest;
use App\Domain\Barbershop\Rules\UniqueBarbershopName;

class UpdateBarbershopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $barbershopId = $this->route('barbershop')?->id;

        return [
            'name' => ['sometimes', 'required', 'string', new UniqueBarbershopName($barbershopId)],
            'address' => ['sometimes', 'required', 'string'],
        ];
    }
}

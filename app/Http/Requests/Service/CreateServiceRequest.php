<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use App\Domain\Service\Rules\PositiveCost;

class CreateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'cost' => ['required', 'numeric', new PositiveCost()],
        ];
    }
}

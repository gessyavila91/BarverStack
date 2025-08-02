<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use App\Domain\Service\Rules\PositiveCost;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string'],
            'cost' => ['sometimes', 'required', 'numeric', new PositiveCost()],
        ];
    }
}

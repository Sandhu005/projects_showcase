<?php

namespace App\Http\Requests\Api\Crops;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CropSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100',],
            'season' => ['nullable', 'string', 'max:50',],
            'type' => ['nullable', 'string', 'max:50',],
            'cursor' => ['nullable', 'string',]
        ];
    }
}

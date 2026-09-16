<?php

namespace App\Http\Requests\Seed;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeedStoreRequest extends FormRequest
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
            'crop_id' => ['required', 'exists:crops,id'],
            'seed_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('seeds', 'seed_name')
                    ->where(fn($query) => $query->where('crop_id', $this->crop_id)),
            ],
            'seed_type' => ['required', 'string', 'max:255'],
            'maturity_days' => ['required', 'integer', 'min:0'],
            'season' => ['required', 'string', 'max:255'],
            'seed_description' => ['nullable', 'string'],
        ];
    }
}

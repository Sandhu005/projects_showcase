<?php

namespace App\Http\Requests\Api\Settings;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
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
            'city' => ['required', 'string', 'max:255',],
            'state' => ['required', 'string', 'max:255',],
            'lat' => ['required', 'numeric', 'between:-90,90',],
            'lng' => ['required', 'numeric', 'between:-180,180',],
            'source' => ['required', 'string', 'in:gps,manual',],
        ];
    }
}

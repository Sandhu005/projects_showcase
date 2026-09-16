<?php

namespace App\Http\Requests\Crop;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CropUpdateRequest extends FormRequest
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
            'crop_name' => [
            'required',
            'string',
            'max:100',
            Rule::unique('crops', 'crop_name')->ignore($this->route('crop'))
            ],
            'crop_season' => ['required', 'string', 'max:150'],
            'crop_type' => ['required', 'string', 'max:100'],
            'variety' => ['required', 'string'],
            'sowing_method' => ['required', 'string'],
            'irrigation' => ['required', 'string'],
            'fertilizers' => ['required', 'string'],
            'plant_protection' => ['required', 'string'],
            'deficiency' => ['required', 'string'],
            'weeds' => ['required', 'string'],
            'advisory' => ['required', 'string'],
            'crop_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}

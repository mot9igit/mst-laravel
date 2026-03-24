<?php

namespace App\Http\Requests\API\Organization;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'active' => 'required|boolean',
            'verified' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'inn' => 'required|string|unique:requisites,inn',
            'kpp' => 'nullable|string',
            'ogrn' => 'required|string',
            'ur_address' => 'nullable',
            'fact_address' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Заполните наименование Организации'
        ];
    }
}

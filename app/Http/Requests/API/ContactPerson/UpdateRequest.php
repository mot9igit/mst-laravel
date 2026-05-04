<?php

namespace App\Http\Requests\API\ContactPerson;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'nullable|string|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'description' => 'nullable|string|max:1000',
            'properties' => 'nullable|json',
        ];
    }
}

<?php

namespace App\Http\Requests\API\ContactPerson;

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
            'name' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'description' => 'nullable|string|max:1000',
            'properties' => 'nullable|json',
        ];
    }
}

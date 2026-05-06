<?php

namespace App\Http\Requests\API\ApiKey;

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
            'key' => 'required|string|max:255',
            'active' => 'required|boolean',
            'description' => 'nullable|string|max:1000',
            'properties' => 'nullable|json',
            'org_id' => 'nullable|exists:organizations,id',
            'store_id' => 'nullable|exists:stores,id',
        ];
    }
}

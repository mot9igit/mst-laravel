<?php

namespace App\Http\Requests\API\ApiKey;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'perpage' => 'nullable|int',
            'page' => 'nullable|int',
            'sort' => 'nullable|array',
            'org_id' => 'nullable|int',
            'store_id' => 'nullable|int',
            'filter' => 'nullable|string|max:255',
        ];
    }
}

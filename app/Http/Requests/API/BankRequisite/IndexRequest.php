<?php

namespace App\Http\Requests\API\BankRequisite;

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
            'org_id' => 'required|integer|exists:organizations,id',
            'requisite_id' => 'required|integer|exists:requisites,id',
            'perpage' => 'nullable|int',
            'sort' => 'nullable|array',
            'filter' => 'nullable|string|max:255'
        ];
    }
}

<?php

namespace App\Http\Requests\API\StoreRemainHistory;

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
            'remain_id' => "required|integer|exists:stores_remains,id",
            'name' => 'nullable|string',
            'article' => 'nullable|string',
            "date" => "required|date",
            'price' => 'nullable|numeric',
            'available' => 'nullable|numeric',
            'reserved' => 'nullable|numeric',
            'remains' => 'nullable|numeric',
            'description' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Пожалуйста, заполните Дату',
            'remain_id.required' => 'Укажите номенклатуру',
            'remain_id.exists' => 'Указанной номенклатуры не существует',
        ];
    }
}

<?php

namespace App\Http\Requests\API\StoreDoc;

use App\Enums\StoreIntegrationType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

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
            'store_id' => 'required|integer|exists:stores,id',
            'number' => 'nullable|integer',
            'base_guid' => 'nullable|string',
            'guid' => 'nullable|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'properties' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'store_id.exists' => 'Точка продажи не существует',
            'store_id.integer' => 'Идентификатор должен быть числом',
            'store_id.required' => 'Точка продажи обязательна',

            'number.integer' => 'Номер должен быть числом',

            'base_guid.string' => 'Идентификатор базы должен быть числом',
            'guid.string' => 'Идентификатор документа должен быть числом',

            'date.date' => 'Неверный формат даты',

            'description.string' => 'Описание должно быть строкой',

            'properties.array' => 'Неверный формат свойств'
        ];
    }
}

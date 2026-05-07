<?php

namespace App\Http\Requests\API\StoreDocRemain;

use App\Enums\StoreDocRemainType;
use Illuminate\Foundation\Http\FormRequest;
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
            'doc_id' => 'nullable|integer|exists:stores_doc,id',
            'remain_id' => 'nullable|integer|exists:stores_remains,id',
            'guid' => 'nullable|string',
            'type' => [
                "nullable",
                new Enum(StoreDocRemainType::class)
            ],
            'article' => 'nullable|string',
            'count' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'properties' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'doc_id.required' => 'Идентификатор документа обязателен',
            'doc_id.string' => 'Идентификатор документа должен быть строкой',

            'remain_id.string' => 'Идентификатор остатка должен быть строкой',

            'guid.string' => 'GUID должен быть строкой',

            'type.enum' => 'Неверное значение типа',

            'article.string' => 'Артикул должен быть строкой',

            'count.integer' => 'Количество должно быть числом',

            'price.numeric' => 'Цена должна быть числом',

            'description.string' => 'Описание должно быть строкой',

            'properties.array' => 'Свойства должны быть массивом'
        ];
    }
}

<?php

namespace App\Http\Requests\API\StoreRemainCatalog;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'store_id' => "required|integer|exists:stores,id",
            'name' => 'required|string',
            "guid" => "required|string",
            'name_alt' => 'nullable|string',
            'base_guid' => 'nullable|string',
            'parent_guid' => 'nullable|string',
            'parent_id.id' => 'sometimes|integer|exists:stores_remains_catalogs,id',
            'description' => 'nullable|string',
            'active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, заполните наименование точки продаж',
            'guid.required' => 'Пожалуйста, заполните GUID',
            'article.required' => 'Пожалуйста, заполните артикул',
            'store_id.required' => 'Укажите точку продаж',
            'store_id.exists' => 'Указанной точки продаж не существует',
        ];
    }

    // Кастомный ответ при ошибке (для API)
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Ошибка валидации данных'
            ], 422)
        );
    }
}

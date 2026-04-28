<?php

namespace App\Http\Requests\API\Store;

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
            'name' => 'required|string',
            "name_short" => "nullable|string",
            'active' => 'sometimes|boolean',
            'check_remains' => 'sometimes|boolean',
            'check_docs' => 'sometimes|boolean',
            'marketplace' => 'sometimes|boolean',
            'opt_marketplace' => 'sometimes|boolean',
            'address' => 'nullable',
            'coordinates' => 'nullable',
            'city_id.id' => "required|integer|exists:cities,id",
            'files' => 'nullable|array',
            'description' => 'nullable|string',
            'integration_type.code' => [
                "required",
                new Enum(StoreIntegrationType::class)
            ],
            'yml_file' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, заполните наименование точки продаж',
            'city_id.id.required' => 'Укажите город',
            'city_id.id.exists' => 'Указанного города не существует',
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

<?php

namespace App\Http\Requests\API\Geo\City;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'name' => "required|string",
            'name_r' => "required|string",
            'fias_id' => "nullable|string",
            'population' => "nullable|integer",
            'postal_code' => "nullable|string",
            'active' => "nullable|boolean",
            'region_id.id' => "required|integer|exists:regions,id",
            'description' => 'nullable|string'
        ];
    }

    /**
     * Получить сообщения об ошибках для определенных правил валидации.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Поле обязательно для заполнения',
            'name_r.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Наименование должно быть строкой',
            'region_id.id.required' => 'Укажите регион',
            'region_id.id.exists' => 'Указанного региона не существует',
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

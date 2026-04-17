<?php

namespace App\Http\Requests\API\Geo\Region;

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
            'name' => "required|string",
            'name_r' => "required|string",
            'code' => "required|string",
            'fias_id' => "nullable|string",
            'population' => "nullable|integer",
            'postal_code' => "nullable|string",
            'active' => "nullable|boolean",
            'country_id.id' => "required|integer|exists:countries,id",
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
            'name.string' => 'Наименование должно быть строкой',
            'name_r.required' => 'Поле обязательно для заполнения',
            'code.required' => 'Поле обязательно для заполнения',
            'country_id.id.required' => 'Укажите страну',
            'country_id.id.exists' => 'Указанной страны не существует',
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

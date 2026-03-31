<?php

namespace App\Http\Requests\API\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
            'name' => 'required|string',
            'active' => 'sometimes|boolean',
            'verified' => 'sometimes|boolean',
            'files' => 'nullable|array',
            'description' => 'nullable|string',
            'inn' => 'required|string|unique:requisites,inn',
            'kpp' => 'nullable|string',
            'ogrn' => 'required|string',
            'ur_address' => 'nullable',
            'fact_address' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, заполните ИНН и выберите Организацию из выпадающего списка',
            'inn.required' => 'Заполните ИНН Организации',
            'ogrn.required' => 'Заполните ОГРН Организации'
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

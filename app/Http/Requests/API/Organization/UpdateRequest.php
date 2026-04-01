<?php

namespace App\Http\Requests\API\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
            'name' => 'required|string',
            'active' => 'sometimes|boolean',
            'verified' => 'sometimes|boolean',
            'description' => 'nullable|string',
            'files' => 'nullable|array'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, наименование организации'
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

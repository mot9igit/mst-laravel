<?php

namespace App\Http\Requests\API\Requisite;

use App\Models\Requisite;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // TODO: написать проверку принадлежности реквизитов к организации и доступ пользователя
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Requisite $requisite): array
    {
        return [
            'name' => 'required|string',
            'org_id' => 'required|integer|exists:organizations,id',
            'description' => 'nullable|string',
            'inn' => [
                'required',
                'string',
                Rule::unique('requisites', 'inn')
                    ->ignore($this->route('requisite')->id)
            ],
            'kpp' => 'nullable|string',
            'ogrn' => 'required|string',
            'ur_address' => 'nullable',
            'fact_address' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
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

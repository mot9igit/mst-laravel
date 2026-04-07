<?php

namespace App\Http\Requests\API\BankRequisite;

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
            'name' => 'required|string',
            'org_id' => 'required|integer|exists:organizations,id',
            'requisite_id' => 'required|integer|exists:requisites,id',
            'description' => 'nullable|string',
            'bik' => 'required|string',
            'number' => 'required|string',
            'knumber' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Заполните наименование банка',
            'org_id.required' => 'Не известная Организация',
            'requisite_id.required' => 'Не известные Реквизиты',
            'bik.required' => 'Заполните БИК банка',
            'number.required' => 'Заполните расчетный счет',
            'knumber.required' => 'Заполните корреспондентский счет',
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

<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
            ],
            'new_password_confirmation' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Введите текущий пароль',
            'new_password.required' => 'Введите новый пароль',
            'new_password.min' => 'Пароль должен содержать минимум 8 символов',
            'new_password.confirmed' => 'Пароли не совпадают',
            'new_password.different' => 'Новый пароль не должен совпадать с текущим',
            'new_password_confirmation.required' => 'Подтвердите новый пароль',
        ];
    }
}

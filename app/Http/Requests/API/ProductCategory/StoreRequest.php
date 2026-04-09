<?php

namespace App\Http\Requests\API\ProductCategory;

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
        // TODO: написать проверку принадлежности реквизитов к организации и доступ пользователя
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
            'title' => 'required|string',
            'longtitle' => 'nullable|string',
            'slug' => 'nullable|string',
            'parent_id' => 'nullable|integer|exists:product_categories,id',
            'description' => 'nullable|string',
            'files' => 'nullable|array',
            'seo_title' => 'nullable|string',
            'seo_description' => 'nullable|string',
            'published' => 'sometimes|boolean',
            'show_in_menu' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заполните заголовок',
            'parent_id.exists' => 'Указанного родителя не существует'
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

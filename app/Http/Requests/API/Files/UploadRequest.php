<?php

namespace App\Http\Requests\API\Files;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadRequest extends FormRequest
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
            'path' => 'required|string',
            'image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'path.required' => 'Не известен путь загрузки файлов.',
            'image.*.image' => 'Изображение должно быть файлом: PNG, JPEG, GIF, SVG',
            'image.*.mimes' => 'Изображение должно быть файлом: PNG, JPEG, GIF, SVG',
            'image.*.max' => 'Максимальный размер изображения 2МБ',
            'images.*.image' => 'Изображение должно быть файлом: PNG, JPEG, GIF, SVG',
            'images.*.mimes' => 'Изображение должно быть файлом: PNG, JPEG, GIF, SVG',
            'images.*.max' => 'Максимальный размер изображения 2МБ',
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

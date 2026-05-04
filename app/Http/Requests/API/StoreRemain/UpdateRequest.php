<?php

namespace App\Http\Requests\API\StoreRemain;

use App\Enums\StoreRemainStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

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
            'store_id' => "required|integer|exists:stores,id",
            'name' => 'required|string',
            "guid" => "required|string",
            'article' => 'required|string',
            'product_id.id' => 'sometimes|integer|exists:products,id',
            'parent_id.id' => 'sometimes|integer|exists:product_categories,id',
            'catalog_id.id' => 'sometimes|integer|exists:stores_remains_catalogs,id',
            'vendor_id.id' => 'sometimes|integer|exists:vendors,id',
            'status.code' => [
                "nullable",
                new Enum(StoreRemainStatus::class)
            ],
            'address' => 'nullable',
            'coordinates' => 'nullable',
            'catalog_guid' => 'nullable|string',
            'parent_guid' => 'nullable|string',
            'base_guid' => 'nullable|string',
            'barcode' => 'nullable|string',
            'remains' => 'nullable|integer',
            'reserved' => 'nullable|integer',
            'available' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'tags' => 'nullable|string',
            'published' => 'nullable|boolean',
            'brand_manual' => 'nullable|boolean',
            'article_manual' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, заполните наименование точки продаж',
            'guid.required' => 'Пожалуйста, заполните GUID',
            'article.required' => 'Пожалуйста, заполните артикул',
            'store_id.required' => 'Укажите точку продаж',
            'store_id.exists' => 'Указанной точки продаж не существует',
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

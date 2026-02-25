<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

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
            'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|string',
            'fullname' => 'nullable|string',
            'email' => 'required|string',
            'phone' => 'nullable|string',
        ];

    }
}

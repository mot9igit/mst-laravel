<?php

namespace App\Http\Requests\API\RequestLog;

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
            'method' => 'nullable|string|max:255',
            'url' => 'nullable|string',
            'status_code' => 'nullable|string|max:1000',
            'duration' => 'nullable|json',
            'ip_address' => 'nullable|exists:organizations,id',
            'user_agent' => 'nullable|exists:stores,id',
            'request_body' => 'nullable|array',
            'response_body' => 'nullable|array',
            'error_message' => 'nullable|array',
        ];
    }
}

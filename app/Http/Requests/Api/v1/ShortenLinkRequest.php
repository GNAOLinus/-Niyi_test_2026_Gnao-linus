<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShortenLinkRequest extends FormRequest
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
            'original_url' => 'required|url|http|https',
            'custom_code' => 'nullable|string|max:10|regex:/^[a-zA-Z0-9_\-]+$/|unique:shortened_links,code',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'original_url.required' => 'The original URL is required.',
            'original_url.url' => 'The original URL must be a valid URL.',
            'custom_code.max' => 'The custom code must not exceed 10 characters.',
            'custom_code.regex' => 'The custom code can only contain letters, numbers, underscores, and hyphens.',
            'custom_code.unique' => 'The custom code has already been taken.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
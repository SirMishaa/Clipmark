<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookmarkRequest extends FormRequest
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
            'url' => ['required', 'url', 'max:2048'],
            'title' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'is_starred' => ['sometimes', 'boolean'],
            'is_read' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Convert checkbox values to proper booleans
        $this->merge([
            'is_starred' => $this->boolean('is_starred'),
            'is_read' => $this->boolean('is_read'),
        ]);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'url.required' => 'The URL is required to create a bookmark.',
            'url.url' => 'Please provide a valid URL.',
            'url.max' => 'The URL cannot exceed 2048 characters.',
            'title.max' => 'The title cannot exceed 255 characters.',
            'excerpt.max' => 'The excerpt cannot exceed 1000 characters.',
        ];
    }
}

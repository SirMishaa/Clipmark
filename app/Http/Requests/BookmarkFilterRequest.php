<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\BookmarkFilter;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookmarkFilterRequest extends FormRequest
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'filter' => ['sometimes', Rule::enum(BookmarkFilter::class)],
            'sort' => ['sometimes', 'string', Rule::in(['date', 'title', 'relevance'])],
            'tag' => ['sometimes', 'string', 'max:50'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

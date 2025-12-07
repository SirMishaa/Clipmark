<?php

declare(strict_types=1);

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookmarkFilterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'filter' => ['sometimes', 'string', Rule::in(['starred', 'archived', 'unread'])],
            'sort' => ['sometimes', 'string', Rule::in(['date', 'title', 'relevance'])],
            'tag' => ['sometimes', 'string', 'max:50'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

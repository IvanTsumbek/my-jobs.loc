<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpsertUserPreferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keywords'   => 'nullable|array',
            'keywords.*' => 'string',
            'locations'  => 'nullable|array',
            'locations.*' => 'string',
            'categories' => 'nullable|array',
            'categories.*' => 'string',
            'salary_min' => 'nullable|integer|min:0',
            'salary_max' => 'nullable|integer|min:0|gte:salary_min',
            'remote_only' => 'nullable|boolean',
            'frequency'  => 'nullable|in:daily,weekly',
            'is_active'  => 'nullable|boolean',
        ];
    }
}

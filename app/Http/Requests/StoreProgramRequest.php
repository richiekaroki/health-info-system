<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:programs',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'is_active' => 'sometimes|boolean'
        ];
    }

    public function attributes(): array
    {
        return [
            'duration_weeks' => 'program duration'
        ];
    }
}
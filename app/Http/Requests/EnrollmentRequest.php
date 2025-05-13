<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'program_ids' => 'required|array|min:1',
            'program_ids.*' => 'exists:programs,id',
            'status' => 'sometimes|string|in:active,pending,completed',
            'enrollment_date' => 'sometimes|date|after_or_equal:today'
        ];
    }

    public function messages(): array
    {
        return [
            'program_ids.required' => 'At least one program must be selected',
            'program_ids.*.exists' => 'One or more selected programs are invalid',
            'status.in' => 'Status must be active, pending, or completed',
            'enrollment_date.after_or_equal' => 'Enrollment date cannot be in the past'
        ];
    }
}

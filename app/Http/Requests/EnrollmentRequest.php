<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust if you want stricter policy-based rules
    }

    public function rules(): array
    {
        return [
            'program_ids'        => 'required|array|min:1',
            'program_ids.*'      => 'exists:programs,id',

            'status'             => 'nullable|in:pending,active,completed',
            'enrollment_date'    => 'nullable|date',
            'completion_date'    => 'nullable|date|after_or_equal:enrollment_date',

            'actual_cost'        => 'nullable|numeric|min:0',
            'attendance_weeks'   => 'nullable|integer|min:0',
            'total_sessions'     => 'nullable|integer|min:0',
            'completed_sessions' => 'nullable|integer|min:0',

            'medical_clearance'  => 'nullable|boolean',
            'clearance_expiry'   => 'nullable|date|after:enrollment_date',

            'coach_id'           => 'nullable|exists:users,id',
            'progress_notes'     => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'program_ids.required'   => 'Please select at least one program.',
            'program_ids.*.exists'   => 'One or more selected programs do not exist.',
            'completion_date.after_or_equal' => 'Completion date must be the same or after the enrollment date.',
            'clearance_expiry.after' => 'Clearance expiry must be after the enrollment date.',
        ];
    }
}
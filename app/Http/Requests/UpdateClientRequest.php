<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Changed from false to true
    }

    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,'.$this->client->id,
            'phone_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today'
        ];
    }

    public function messages(): array
    {
        return [
            'birth_date.before' => 'Birth date must be in the past'
        ];
    }
}

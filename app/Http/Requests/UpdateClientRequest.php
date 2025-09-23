<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'sometimes|string|max:255',
            'preferred_name' => 'nullable|string|max:255',
            'email' => 'sometimes|email|unique:clients,email,' . $this->client->id,
            'phone' => 'nullable|string|max:20',
            'phone_alt' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,non-binary,other,prefer_not_to_say',
        ];
    }
}

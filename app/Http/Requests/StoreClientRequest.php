<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'phone_number' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date|before:today'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone_number' => preg_replace('/[^0-9]/', '', $this->phone_number)
        ]);
    }
}

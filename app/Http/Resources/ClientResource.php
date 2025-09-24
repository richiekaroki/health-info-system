<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name, // computed accessor
            'preferred_name' => $this->preferred_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date?->toDateString(),
            'gender' => $this->gender,

            'address' => [
                'line1' => $this->address_line1,
                'line2' => $this->address_line2,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
                'country_code' => $this->country_code,
            ],

            'status' => $this->status,

            // Fixed programs relationship handling
            'programs' => $this->whenLoaded('programs', function () {
                return $this->programs->map(function ($program) {
                    return [
                        'id' => $program->id,
                        'name' => $program->name, // Removed fallback logic
                        'code' => $program->code,
                        'status' => $program->pivot->status ?? null,
                        'enrolled_at' => $program->pivot->enrollment_date ?? null,
                        'completion_date' => $program->pivot->completion_date ?? null,
                        'medical_clearance' => $program->pivot->medical_clearance ?? null,
                    ];
                });
            }),

            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
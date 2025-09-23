<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'preferred_name' => $this->preferred_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'phone_alt' => $this->phone_alt,
            'birth_date' => $this->birth_date,
            'status' => $this->status,
            'programs' => $this->whenLoaded('programs', function () {
                return $this->programs->map(function ($program) {
                    return [
                        'id' => $program->id,
                        'title' => $program->title,
                        'status' => $program->pivot->status,
                        'enrollment_date' => $program->pivot->enrollment_date,
                    ];
                });
            }),
        ];
    }
}